<?php

class PembelianbarangTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'pengadaan.views.pembelianbarangT.';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render($this->path_view.'view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionIndex($id = null, $rencana_id = null, $linkHalaman = null)
	{
//                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=new ADPembelianbarangT;
		$renc = new RenkebbarangT;
		
		$model->tglpembelian = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
                $model->tglpermintaanuangmuka = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
                
                $model->is_uangmukapembelian = false;
                
		$modDetails = array();
		$modPesan = array();
		$modBeli = array();
		$model->tglpembelian = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));

		$instalasi_id = Yii::app()->user->getState('instalasi_id');
		$modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
		$model->peg_pemesanan_id = $modLogin->pegawai_id;
		if (!empty($modLogin->pegawai_id)) $model->peg_pemesan_nama = $modLogin->pegawai->nama_pegawai;
                
                 // alamat pengiriman
                $profil = ProfilrumahsakitM::model()->find();
                if (!empty($profil)){
                    $kelrh = (!empty($profil->kelurahan_id)?$profil->kelurahan->kelurahan_nama:null);
                    $kec = (!empty($profil->kecamatan_id)?$profil->kecamatan->kecamatan_nama:null);
                    $kab = (!empty($profil->kabupaten_id)?$profil->kabupaten->kabupaten_nama:null);
                    $prov = (!empty($profil->propinsi_id)?$profil->propinsi->propinsi_nama:null);
                    $alamatpengirim = $profil->alamatlokasi_rumahsakit.", ".$kelrh.", ".$kec.", ".$kab.", ".$prov." ".$profil->kodepos;
                    $model->alamatpengirim = $alamatpengirim;
                }
        
		if (!empty($rencana_id)) {
			$renc = RenkebbarangT::model()->findByPk($rencana_id);
			$model->renkebbarang_id = $rencana_id;
                        $model->sumberdana_id = $renc->sumberdana_id;
                        $model->sumberdana_nama = (!empty($renc->sumberdana_id)?$renc->sumberdana->sumberdana_nama:"");
			$renc->renkebbarang_tgl = MyFormatter::formatDateTimeForUser($renc->renkebbarang_tgl);
			//var_dump($renc->attributes, $model->attributes);
			
			$rencdet = RenkebbarangdetT::model()->findAllByAttributes(array(
				'renkebbarang_id'=>$rencana_id,
			));
			
			foreach ($rencdet as $item) {
				$det = new BelibrgdetailT();
				$det->barang_id = $item->barang_id;
				$det->hargasatuan = MyFormatter::formatNumberForPrint($item->harga_barangdet, 2);
				//$det->jmlbeli = $item->jmlpermintaanbarangdet * $renc->ro_barang_bulan;
                                $jml = $item->getSisaRencana($rencana_id);
                                // $jmlTot = is_array($jml)?(($item->jmlpermintaanbarangdet * $renc->ro_barang_bulan) - $jml[$item->barang_id]['stok']):$item->jmlpermintaanbarangdet * $renc->ro_barang_bulan;
                                $jmlTot = $item->jmlpermintaanbarangdet;

                                if ($jmlTot < 0){
                                    $jmlTot = 0;
                                }
                                
                                $det->jmlbeli = $jmlTot;
                                $det->persen_ppn = $item->persen_ppn;
								$hppbeli = $item->hpp;
                                $det->hpp = MyFormatter::formatNumberForPrint($hppbeli , 2);
								$det->hargabeli = MyFormatter::formatNumberForPrint(($det->jmlbeli * $hppbeli), 2);
								$det->satuanbeli = $item->satuanbarangdet;
								$det->jmlbeli = MyFormatter::formatNumberForPrint($det->jmlbeli, 2);
//				 var_dump($item->attributes, $det->attributes); die;
				
				array_push($modDetails, $det);
			}
			
		}
		
                $modApprovalotorisasiM = ApprovalotorisasiM::model()->find();
                if(isset($modApprovalotorisasiM)){
                    if($model->sumberdana_id == Params::SUMBERDANA_ID_PT){
                        $mengetahui_umum = $modApprovalotorisasiM->managerumumpt_id; //Jabatan id Manager Umum
                        $mengetahui = $modApprovalotorisasiM->managerkeuanganpt_id; //Jabatan id Manager Keuangan
                        $menyetujui = $modApprovalotorisasiM->direkturpt_id; //Jabatan id Direktur RS
                    }else{
                        $mengetahui_umum = $modApprovalotorisasiM->managerumum_id; //Jabatan id Manager Umum
                        $mengetahui = $modApprovalotorisasiM->managerkeuangan_id; //Jabatan id Manager Keuangan
                        $menyetujui = $modApprovalotorisasiM->direkturrs_id; //Jabatan id Direktur RS
                    }
                }
                $sumberGen = "RS";
                if($model->sumberdana_id == Params::SUMBERDANA_ID_PT){
                    $sumberGen = "SHB";
                }
                $model->nopembelian = MyGenerator::noPembelianBarang($sumberGen);
                
		if (isset($id)){
			$model = ADPembelianbarangT::model()->findByPk($id);
                        $sumberGen = "RS";
                        if($model->sumberdana_id == Params::SUMBERDANA_ID_PT){
                            $sumberGen = "SHB";
                        }
//			$model->nopembelian = MyGenerator::noPembelianBarang($sumberGen);
                        $model->sumberdana_nama = (!empty($renc->sumberdana_id)?$renc->sumberdana->sumberdana_nama:"");
                        
			$renc = RenkebbarangT::model()->findByPk($model->renkebbarang_id);
			if (!empty($renc)) $renc->renkebbarang_tgl = MyFormatter::formatDateTimeForUser($renc->renkebbarang_tgl);
			else $renc = new RenkebbarangT;
			if (!empty($model)){
				$model = $model;
				$model->peg_pemesan_nama = $model->pemesan->nama_pegawai;
				$model->peg_mengetahui_nama = isset($model->mengetahui->nama_pegawai)?$model->mengetahui->nama_pegawai:null;
				$model->peg_menyetujui_nama = isset($model->menyetujui->nama_pegawai)?$model->menyetujui->nama_pegawai:null;
				$modDetails = BelibrgdetailT::model()->findAll('pembelianbarang_id = '.$id);
                                
                                
                                foreach ($modDetails as $item) {
                                    $item->hargabeli = MyFormatter::formatNumberForPrint($item->hargabeli, 2);
                                    $item->hargasatuan = MyFormatter::formatNumberForPrint($item->hargasatuan, 2);
									$item->persenpph = MyFormatter::formatNumberForPrint($item->persenpph, 2);
                                    $item->ppn = MyFormatter::formatNumberForPrint($item->ppn, 2);
                                    $item->hpp = MyFormatter::formatNumberForPrint($item->hpp, 2);
									$item->jmlbeli = MyFormatter::formatNumberForPrint($item->jmlbeli, 2);
                                }
			}
                        // die;
                        
                        if(!empty($model->tglpermintaanuangmuka)){
                            $model->is_uangmukapembelian = true;
                        }else{
                            $model->is_uangmukapembelian = false;
                        }
		}
                
                if (!empty($mengetahui_umum)){ 
                    $data = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$mengetahui_umum));                    
                    if(isset($data)){
                        $model->peg_mengetahui_umum_id = $data->pegawai_id;
                        $model->peg_mengetahui_umum_nama = $data->namaLengkap;
                    }
                }
                
                if (!empty($mengetahui)){ 
                    $data = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$mengetahui));  
                    if(isset($data)){
                        $model->peg_mengetahui_id = $data->pegawai_id;
                        $model->peg_mengetahui_nama = $data->namaLengkap;
                    }
                }
                
                if (!empty($menyetujui)){ 
                    $data = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$menyetujui));      
                    if(isset($data)){
                        $model->peg_menyetujui_id= $data->pegawai_id;
                        $model->peg_menyetujui_nama = $data->namaLengkap;  
                    }
                }
                
                $model->tglpembelian = MyFormatter::formatDateTimeForUser($model->tglpembelian);
		// Uncomment the following line if AJAX validation is needed
		
                
		if(isset($_POST['ADPembelianbarangT']))
		{
            $transaction = Yii::app()->db->beginTransaction();
            if (isset($_POST['data_dihapus'])) {
                $data = explode(".", $_POST['data_dihapus']);
                foreach ($data as $item) {
                    if (empty($item) || trim($item) == "") {
                        continue;
                    }
                    BelibrgdetailT::model()->deleteByPk($item);
                }
            }
            
			$model->attributes=$_POST['ADPembelianbarangT'];
			$model->renkebbarang_id = $_POST['ADPembelianbarangT']['renkebbarang_id'];
                        $tglPembelian = date('Y-m-d H:i:s');
                        $tglKirim = null;
                        
                        if(!empty($model->tglpembelian)){
                            $tglPembelian = MyFormatter::formatDateTimeForDb($model->tglpembelian);
                        }
                        
                        if(!empty($model->tgldikirim)){
                            $tglKirim = MyFormatter::formatDateTimeForDb($model->tgldikirim);
                        }   
                        
                        if(!empty($_POST['ADPembelianbarangT']['is_uangmukapembelian']) && $_POST['ADPembelianbarangT']['is_uangmukapembelian'] == 1){
                             if(!empty($model->tglpermintaanuangmuka)){
                                $model->tglpermintaanuangmuka = MyFormatter::formatDateTimeForDb($model->tglpermintaanuangmuka);
                            }
                        }else{
                            $model->tglpermintaanuangmuka = null;
                        }
                        
			$model->tglpembelian = $tglPembelian;
			$model->tgldikirim = $tglKirim;
			
            if (count((array)$_POST['BelibrgdetailT']) > 0){
                if ($model->validate()){
                    try{
                        $success = true;
                        if($model->save()){
                            $modDetails = $this->validasiTabular($model, $_POST['BelibrgdetailT']);
                            foreach ($modDetails as $i=>$data){
                                if ($data->jmlbeli > 0){
                                    if ($data->save()){
                                        $success = true;
                                    }
                                    else{
                                        $success = false;
                                    }
                                }
                            }
                        }
                        else{
                            $success = false;
                        }
                        
                        $this->notifPermintaanPembelian($model);
                        if ($success == true){
                            $transaction->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('index','id'=>$model->pembelianbarang_id,'sukses'=>1));
                        }
                        else{
                            $transaction->rollback();
                            Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                        }
                    }
                    catch (Exception $ex){
                         $transaction->rollback();
                         Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
                    }
                }
            }else{
                $transaction->rollback();
                $model->validate();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
            }
		}

		$this->render($this->path_view.'index',array(
			'model'=>$model, 'modDetails'=>$modDetails, 'modPesan'=>$modPesan, 'modBeli'=>$modBeli, 'renc'=>$renc,'linkHalaman'=>$linkHalaman
		));
	}
    
    public function notifPermintaanPembelian($model) {
        
        $pemesan = "-";
        $mengetahui = "-";
        $mengetahui_umum = "-";
        $menyetujui = "-";
        
        if (!empty($model->peg_pemesanan_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_pemesanan_id);
            if (!empty($peg)) {
                $pemesan = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_mengetahui_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_mengetahui_id);
            if (!empty($peg)) {
                $mengetahui = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_mengetahui_umum_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_mengetahui_umum_id);
            if (!empty($peg)) {
                $mengetahui_umum = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_menyetujui_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_menyetujui_id);
            if (!empty($peg)) {
                $menyetujui = $peg->namaLengkap;
            }
        }
        
        
        $judul = "Permintaan Pembelian Barang";
        $isi = "Tgl. Pembelian : ". MyFormatter::formatDateTimeForUser($model->tglpembelian)."<br/>";
        $isi .= "No. Pembelian : ".$model->nopembelian."<br/>";
        $isi .= "Pemesan : ".$pemesan."<br/>";
        $isi .= "Manajer Umum : ".$mengetahui_umum."<br/>";
        $isi .= "Manajer Keuangan : ".$mengetahui."<br/>";
        $isi .= "Direktur : ".$menyetujui."<br/>";
        
        $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
        $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
        $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
        
        $link_keuangan = $this->createUrl('/gudangUmum/PembelianbarangTGU/Informasi',array(
            'ADPembelianbarangT[tgl_awal]'=>date('Y-m-d', strtotime($model->tglpembelian)),
            'ADPembelianbarangT[tgl_akhir]'=>date('Y-m-d', strtotime($model->tglpembelian)),
            'ADPembelianbarangT[nopembelian]'=>$model->nopembelian,
        ));
        
        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id'=>$ruangan_gudang->instalasi_id, 'ruangan_id'=>$ruangan_gudang->ruangan_id, 'modul_id'=>$ruangan_gudang->modul_id),
            array('instalasi_id'=>$ruangan_purchasing->instalasi_id, 'ruangan_id'=>$ruangan_purchasing->ruangan_id, 'modul_id'=>$ruangan_purchasing->modul_id),
            array('instalasi_id'=>$ruangan_keuangan->instalasi_id, 'ruangan_id'=>$ruangan_keuangan->ruangan_id, 'modul_id'=>$ruangan_keuangan->modul_id, 'link_proses'=>$link_keuangan),
        ));
        
        
    }
	
	public function actionAutoCompleteRencana($term) {
		if(Yii::app()->request->isAjaxRequest) {
			$cr = new CDbCriteria;
			$cr->compare('lower(renkebbarang_no)', strtolower($term), true);
			$cr->order = 'renkebbarang_no';
			$rencana = RenkebbarangT::model()->findAll($cr);

			$res = array();
			foreach ($rencana as $item) {
				array_push($res, array(
					'dat'=>$item->attributes,
					'label'=>$item->renkebbarang_no,
					'value'=>$item->renkebbarang_id
				));
			}
			
			echo CJSON::encode($res);
		}
		Yii::app()->end();
		
	}
	
	public function actionLoadRencana() {
		if(Yii::app()->request->isAjaxRequest) {
			$rencana_id = $_POST['id'];
			$renc = RenkebbarangT::model()->findByPk($rencana_id);
			$renc->renkebbarang_tgl = MyFormatter::formatDateTimeForUser($renc->renkebbarang_tgl);
			//var_dump($renc->attributes, $model->attributes);
			$modDetails = array();
			$res = array(
				'rencana'=>"",
				'html'=>"",
			);
			
			$rencdet = RenkebbarangdetT::model()->findAllByAttributes(array(
				'renkebbarang_id'=>$rencana_id,
			));
			
			foreach ($rencdet as $item) {
				$det = new BelibrgdetailT();
				$det->barang_id = $item->barang_id;
				$det->hargasatuan = MyFormatter::formatNumberForPrint($item->harga_barangdet);
				//$det->jmlbeli = $item->jmlpermintaanbarangdet;
                                $det->jmlbeli = $item->jmlpermintaanbarangdet * $renc->ro_barang_bulan;
				$det->hargabeli = MyFormatter::formatNumberForPrint($det->jmlbeli * $item->harga_barangdet);
				$det->satuanbeli = $item->satuanbarangdet;
				// var_dump($item->attributes, $det->attributes); die;
				
				array_push($modDetails, $det);
			}
			
			$res['rencana'] = $renc->attributes;
			foreach ($modDetails as $item) {
				$modBarang = BarangM::model()->findByPk($item->barang_id);
				$res['html'] .= $this->renderPartial($this->path_view.'_detailPembelianBarang', array('modBarang'=>$modBarang, 'modDetail'=>$item), true);
			}
			
			echo CJSON::encode($res);
		}
		Yii::app()->end();
	}
        
        protected function validasiTabular($model, $data){
            $valid = true;
            //var_dump($data); die;
            
            foreach ($data as $i=>$row){
                
                if (isset($row['belibrgdetail_id'])) {
                    $modDetails[$i] = BelibrgdetailT::model()->findByPk($row['belibrgdetail_id']);
                } else {
                    $modDetails[$i] = new BelibrgdetailT();
                }
                
                $modDetails[$i]->attributes = $row;
                $modDetails[$i]->pembelianbarang_id = $model->pembelianbarang_id;
                $valid = $modDetails[$i]->validate() && $valid;
                //var_dump($modDetails[$i]->attributes);
            }
            
            return $modDetails;
        }
		
	/**
	 * menampilkan barang yang akan di beli (detail)
	 */
    public function actionGetPembelianBarang(){
        if (Yii::app()->request->isAjaxRequest){
            $idBarang = $_POST['idBarang'];
            $jumlah = $_POST['jumlah'];
            $satuan = $_POST['satuan'];
            
            $modBarang = BarangM::model()->with('subsubkelompok')->findByPk($idBarang);
            // var_dump($modBarang->attributes); die;
            $modDetail = new BelibrgdetailT();
            $modDetail->barang_id = $idBarang;
            $modDetail->satuanbeli = $satuan;
            $modDetail->jmlbeli = $jumlah;
            $modDetail->hargasatuan = MyFormatter::formatNumberForPrint($modBarang->barang_harganetto);
//            $modDetail->persen_ppn = 10;
            $modDetail->hpp = MyFormatter::formatNumberForPrint($modBarang->barang_harganetto * ($modDetail->persen_ppn + 100) / 100);
            $modDetail->hargabeli = MyFormatter::formatNumberForPrint($modBarang->barang_harganetto * $jumlah);
            $modDetail->jmldlmkemasan = $modBarang->barang_jmldlmkemasan;
            
            $tr = $this->renderPartial($this->path_view.'_detailPembelianBarang', array('modBarang'=>$modBarang, 'modDetail'=>$modDetail), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['ADPembelianbarangT']))
		{
			$model->attributes=$_POST['ADPembelianbarangT'];
			if($model->save()){
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('view','id'=>$model->pembelianbarang_id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('ADPembelianbarangT');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                
		$model=new ADPembelianbarangT('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ADPembelianbarangT']))
			$model->attributes=$_GET['ADPembelianbarangT'];

		$this->render($this->path_view.'admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ADPembelianbarangT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='gupembelianbarang-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         *Mengubah status aktif
         * @param type $id 
         */
        public function actionRemoveTemporary($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
                //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
//        public function actionPrint()
//        {
//            $model= new ADPembelianbarangT;
//            $model->attributes=$_REQUEST['ADPembelianbarangT'];
//            $judulLaporan='Data ADPembelianbarangT';
//            $caraPrint=$_REQUEST['caraPrint'];
//            if($caraPrint=='PRINT') {
//                $this->layout='//layouts/printWindows';
//                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
//            }
//            else if($caraPrint=='EXCEL') {
//                $this->layout='//layouts/printExcel';
//                $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
//            }
//            else if($_REQUEST['caraPrint']=='PDF') {
//                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
//                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
//                $mpdf = new MyPDF60('',$ukuranKertasPDF); 
//                //$mpdf->useOddEven = 2;  
//                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
//                $mpdf->WriteHTML($stylesheet,1);  
//                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
//                $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
//                $mpdf->Output();
//            }                       
//        }
        
        public function actionInformasi($linkHalaman = null)
	{
//                
		$model=new ADPembelianbarangT('search');
                $format= new MyFormatter;
		$model->unsetAttributes();  // clear any default values
                $model->tgl_awal = date('Y-m-d');
                $model->tgl_akhir = date('Y-m-d');
		if(isset($_GET['ADPembelianbarangT'])){
                     $model->attributes=$_GET['ADPembelianbarangT'];
                     $model->tgl_awal = $format->formatDateTimeForDb($_GET['ADPembelianbarangT']['tgl_awal']);
                     $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADPembelianbarangT']['tgl_akhir']);
                     $model->is_uangmukapembelian = isset($_GET['ADPembelianbarangT']['is_uangmukapembelian']) ? $_GET['ADPembelianbarangT']['is_uangmukapembelian'] : null;
                }

		$this->render($this->path_view.'informasi',array(
			'model'=>$model,'format'=>$format,'linkHalaman'=>$linkHalaman
		));
	}
        
        public function actionDetailPembelianBarang($id){
            $this->layout ='//layouts/iframe';
            $modBeli = PembelianbarangT::model()->findByPk($id);
            $judulLaporan='SURAT PESANAN';
            $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$modBeli->pembelianbarang_id));
            $this->render($this->path_view.'detailInformasi', array(
                'modBeli'=>$modBeli,
                'modDetailBeli'=>$modDetailBeli,
                'judulLaporan'=>$judulLaporan,
            ));
        }
        
        public function actionPrint($id){
            $this->layout='//layouts/printWindows';
            $judulLaporan='SURAT PESANAN';
            $modBeli = PembelianbarangT::model()->findByPk($id);
            $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$modBeli->pembelianbarang_id));
            $this->render($this->path_view.'detailInformasi', array(
                'judulLaporan'=>$judulLaporan,
                'modBeli'=>$modBeli,
                'modDetailBeli'=>$modDetailBeli,
            ));
        }
        
        public function actionMenyetujui($pembelianbarang_id,$approve=false,$tolak=false)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
		$modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
                if($approve){
			$update = ADPembelianbarangT::model()->updateByPk($pembelianbarang_id,array('tglmenyetujui'=>date("Y-m-d H:i:s")));
			if($update){
                $this->notifMenyetujuiPermintaanPembelian($pembelianbarang_id);
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('menyetujui','pembelianbarang_id'=>$pembelianbarang_id,'sukses'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
//		if($tolak){
//			$update = ADPembelianbarangT::model()->updateByPk($rencanakebfarmasi_id,array('statusrencana'=>"DITOLAK"));
//			if($update){
//				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
//				$this->redirect(array('menyetujui','rencanakebfarmasi_id'=>$rencanakebfarmasi_id,'sukses'=>1,'ditolak'=>1));
//			}else{
//				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
//			}
//		}
        $judulLaporan = 'SURAT PESANAN';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglpembelian);
        $this->render($this->path_view.'_menyetujui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetailBeli'=>$modDetailBeli
		));
		
	}
        
        public function actionPrintMenyetujui($pembelianbarang_id)
    {
		$format = new MyFormatter();
                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
		$modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
                $judulLaporan = 'SURAT PESANAN';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglpembelian);
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'printMenyetujui',array('format'=>$format,'model'=>$model,'modDetailBeli'=>$modDetailBeli,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'printMenyetujui',array('format'=>$format,'model'=>$model,'modDetailBeli'=>$modDetailBeli,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			//$mpdf->useOddEven = 2;
                        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
                        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A5.css'); 
                        $mpdf->WriteHTML($formatkonten, 1);
                        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
                        $mpdf->WriteHTML($stylesheet, 1);
                        
			$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
    }
    
    public function actionMengetahui($pembelianbarang_id,$approve=false)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
                
                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
		if($approve){
			$update = ADPembelianbarangT::model()->updateByPk($pembelianbarang_id,array('tglmengetahui'=>date("Y-m-d H:i:s")));
			if($update){
                $this->notifMengetahuiPermintaanPembelian($pembelianbarang_id);
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('mengetahui','pembelianbarang_id'=>$pembelianbarang_id,'sukses'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
        $judulLaporan = 'SURAT PESANAN';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglpembelian);
        $this->render($this->path_view.'_mengetahui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetailBeli'=>$modDetailBeli
		));
		
	}
	
	public function actionPrintMengetahui($pembelianbarang_id)
    {
		$format = new MyFormatter();
                
                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
		
                $judulLaporan = 'SURAT PESANAN';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglpembelian);
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'printMengetahui',array('format'=>$format,'model'=>$model,'modDetailBeli'=>$modDetailBeli,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'printMengetahui',array('format'=>$format,'model'=>$model,'modDetailBeli'=>$modDetailBeli,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			//$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'printMengetahui',array('format'=>$format,'model'=>$model,'modDetailBeli'=>$modDetailBeli,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
    
    public function actionPrintInformasi($caraPrint) {
        $model=new ADPembelianbarangT('search');
        $format= new MyFormatter;
		$model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if(isset($_GET['ADPembelianbarangT'])){
            $model->attributes=$_GET['ADPembelianbarangT'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['ADPembelianbarangT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADPembelianbarangT']['tgl_akhir']);
            $model->is_uangmukapembelian = $_GET['ADPembelianbarangT']['is_uangmukapembelian'];
        }
        
        $this->printFunction($model, $caraPrint, "Informasi Permintaan Pembelian Barang", $this->path_view."printInformasi");
		
    }
    
    
    protected function printFunction($model, $caraPrint, $judulLaporan, $target)
    {
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
//            //$mpdf->useOddEven = 2;
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css'); 
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        } else if ($caraPrint == "CSV") {
            CSV::konversiTabel($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
        }
    }
    
    public function actionMengetahuiUmum($pembelianbarang_id,$approve=false)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
                
                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
		if($approve){
            $update = ADPembelianbarangT::model()->updateByPk($pembelianbarang_id,array('tglmengetahui_umum'=>date("Y-m-d H:i:s")));
            $this->notifMengetahuiUmumPermintaanPembelian($pembelianbarang_id);
			if($update){
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('mengetahuiUmum','pembelianbarang_id'=>$pembelianbarang_id,'sukses'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
        $judulLaporan = 'SURAT PESANAN';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglpembelian);
        $this->render($this->path_view.'_mengetahuiumum', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetailBeli'=>$modDetailBeli
		));
		
	}
    
    public function notifMengetahuiUmumPermintaanPembelian($pembelianbarang_id) {
        
        $model = ADPembelianbarangT::model()->findByPk($pembelianbarang_id);
        
        $pemesan = "-";
        $mengetahui = "-";
        $mengetahui_umum = "-";
        $menyetujui = "-";
        
        if (!empty($model->peg_pemesanan_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_pemesanan_id);
            if (!empty($peg)) {
                $pemesan = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_mengetahui_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_mengetahui_id);
            if (!empty($peg)) {
                $mengetahui = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_mengetahui_umum_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_mengetahui_umum_id);
            if (!empty($peg)) {
                $mengetahui_umum = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_menyetujui_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_menyetujui_id);
            if (!empty($peg)) {
                $menyetujui = $peg->namaLengkap;
            }
        }
        
        
        $judul = "Approval Permintaan Pembelian Barang";
        $isi = "Tgl. Approval : ". MyFormatter::formatDateTimeForUser($model->tglmengetahui_umum)."<br/>";
        $isi .= "No. Pembelian : ".$model->nopembelian."<br/>";
        //$isi .= "Pemesan : ".$pemesan."<br/>";
        $isi .= "Manajer Umum : ".$mengetahui_umum."<br/>";
        //$isi .= "Manajer Keuangan : ".$mengetahui."<br/>";
        //$isi .= "Direktur : ".$menyetujui."<br/>";
        
        $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
        $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
        $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
        
         $urlFull = "";
        $modul = null;
        
        if (!empty($ruangan_gudang->modul_id)) {
            $urlFull = "gudangUmum/PembelianbarangTGU/Informasi";
        }
        
        if (!empty($ruangan_keuangan->modul_id)) {
            $modul = ModulK::model()->findByPk($ruangan_keuangan->modul_id);
            
            $urlFull = $modul->url_modul."/PembelianbarangTGU".$modul->modul_key.'/Informasi';
        }
        
        if (!empty($ruangan_purchasing->modul_id)) {
            $urlFull = "gudangUmum/PembelianbarangTGU/Informasi";
        }
        
        if(isset($modul)){
                $link = Yii::app()->createUrl($urlFull, array(
                    'ADPembelianbarangT[tgl_awal]'=> MyFormatter::formatDateTimeForUser($model->tglpembelian),
                    'ADPembelianbarangT[tgl_akhir]'=>MyFormatter::formatDateTimeForUser($model->tglpembelian),
                    'ADPembelianbarangT[nopembelian]'=>$model->nopembelian,
                ));
            }
            
        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id'=>$ruangan_gudang->instalasi_id, 'ruangan_id'=>$ruangan_gudang->ruangan_id, 'modul_id'=>$ruangan_gudang->modul_id, 'link_proses'=>$link),
            array('instalasi_id'=>$ruangan_keuangan->instalasi_id, 'ruangan_id'=>$ruangan_keuangan->ruangan_id, 'modul_id'=>$ruangan_keuangan->modul_id, 'link_proses'=>$link),
            array('instalasi_id'=>$ruangan_purchasing->instalasi_id, 'ruangan_id'=>$ruangan_purchasing->ruangan_id, 'modul_id'=>$ruangan_purchasing->modul_id, 'link_proses'=>$link),
        ));
    }
    
    public function notifMengetahuiPermintaanPembelian($pembelianbarang_id) {
        
        $model = ADPembelianbarangT::model()->findByPk($pembelianbarang_id);
        
        $pemesan = "-";
        $mengetahui = "-";
        $mengetahui_umum = "-";
        $menyetujui = "-";
        
        if (!empty($model->peg_pemesanan_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_pemesanan_id);
            if (!empty($peg)) {
                $pemesan = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_mengetahui_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_mengetahui_id);
            if (!empty($peg)) {
                $mengetahui = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_mengetahui_umum_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_mengetahui_umum_id);
            if (!empty($peg)) {
                $mengetahui_umum = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_menyetujui_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_menyetujui_id);
            if (!empty($peg)) {
                $menyetujui = $peg->namaLengkap;
            }
        }
        
        
        $judul = "Approval Permintaan Pembelian Barang";
        $isi = "Tgl. Approval : ". MyFormatter::formatDateTimeForUser($model->tglmengetahui)."<br/>";
        $isi .= "No. Pembelian : ".$model->nopembelian."<br/>";
        //$isi .= "Pemesan : ".$pemesan."<br/>";
        //$isi .= "Manajer Umum : ".$mengetahui_umum."<br/>";
        $isi .= "Manajer Keuangan : ".$mengetahui."<br/>";
        //$isi .= "Direktur : ".$menyetujui."<br/>";
        
        $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
        $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
        $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
        
        $urlFull = "";
        $modul = null;
        
        if (!empty($ruangan_gudang->modul_id)) {
            $urlFull = "gudangUmum/PembelianbarangTGU/Informasi";
        }
        
        if (!empty($ruangan_keuangan->modul_id)) {
            $modul = ModulK::model()->findByPk($ruangan_keuangan->modul_id);
            
            $urlFull = $modul->url_modul."/PembelianbarangTGU".$modul->modul_key.'/Informasi';
        }
        
        if (!empty($ruangan_purchasing->modul_id)) {
            $urlFull = "gudangUmum/PembelianbarangTGU/Informasi";
        }
        
        if(isset($modul)){
                $link = Yii::app()->createUrl($urlFull, array(
                    'ADPembelianbarangT[tgl_awal]'=> MyFormatter::formatDateTimeForUser($model->tglpembelian),
                    'ADPembelianbarangT[tgl_akhir]'=>MyFormatter::formatDateTimeForUser($model->tglpembelian),
                    'ADPembelianbarangT[nopembelian]'=>$model->nopembelian,
                ));
            }
            
        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id'=>$ruangan_gudang->instalasi_id, 'ruangan_id'=>$ruangan_gudang->ruangan_id, 'modul_id'=>$ruangan_gudang->modul_id, 'link_proses'=>$link),
            array('instalasi_id'=>$ruangan_keuangan->instalasi_id, 'ruangan_id'=>$ruangan_keuangan->ruangan_id, 'modul_id'=>$ruangan_keuangan->modul_id, 'link_proses'=>$link),
            array('instalasi_id'=>$ruangan_purchasing->instalasi_id, 'ruangan_id'=>$ruangan_purchasing->ruangan_id, 'modul_id'=>$ruangan_purchasing->modul_id, 'link_proses'=>$link),
        ));
    }
    
    public function notifMenyetujuiPermintaanPembelian($pembelianbarang_id) {
        
        $model = ADPembelianbarangT::model()->findByPk($pembelianbarang_id);
        
        $pemesan = "-";
        $mengetahui = "-";
        $mengetahui_umum = "-";
        $menyetujui = "-";
        
        if (!empty($model->peg_pemesanan_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_pemesanan_id);
            if (!empty($peg)) {
                $pemesan = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_mengetahui_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_mengetahui_id);
            if (!empty($peg)) {
                $mengetahui = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_mengetahui_umum_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_mengetahui_umum_id);
            if (!empty($peg)) {
                $mengetahui_umum = $peg->namaLengkap;
            }
        }
        if (!empty($model->peg_menyetujui_id)) {
            $peg = PegawaiM::model()->findByPk($model->peg_menyetujui_id);
            if (!empty($peg)) {
                $menyetujui = $peg->namaLengkap;
            }
        }
        
        
        $judul = "Approval Permintaan Pembelian Barang";
        $isi = "Tgl. Approval : ". MyFormatter::formatDateTimeForUser($model->tglmengetahui)."<br/>";
        $isi .= "No. Pembelian : ".$model->nopembelian."<br/>";
        //$isi .= "Pemesan : ".$pemesan."<br/>";
        //$isi .= "Manajer Umum : ".$mengetahui_umum."<br/>";
        //$isi .= "Manajer Keuangan : ".$mengetahui."<br/>";
        $isi .= "Direktur : ".$menyetujui."<br/>";
        
        $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
        $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
        $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
        
        $urlFull = "";
        $modul = null;
        
        if (!empty($ruangan_gudang->modul_id)) {
            $urlFull = "gudangUmum/PembelianbarangTGU/Informasi";
        }
        
        if (!empty($ruangan_keuangan->modul_id)) {
            $modul = ModulK::model()->findByPk($ruangan_keuangan->modul_id);
            
            $urlFull = $modul->url_modul."/PembelianbarangTGU".$modul->modul_key.'/Informasi';
        }
        
        if (!empty($ruangan_purchasing->modul_id)) {
            $urlFull = "gudangUmum/PembelianbarangTGU/Informasi";
        }
        
        if(isset($modul)){
                $link = Yii::app()->createUrl($urlFull, array(
                    'ADPembelianbarangT[tgl_awal]'=> MyFormatter::formatDateTimeForUser($model->tglpembelian),
                    'ADPembelianbarangT[tgl_akhir]'=>MyFormatter::formatDateTimeForUser($model->tglpembelian),
                    'ADPembelianbarangT[nopembelian]'=>$model->nopembelian,
                ));
            }
        
        
        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id'=>$ruangan_gudang->instalasi_id, 'ruangan_id'=>$ruangan_gudang->ruangan_id, 'modul_id'=>$ruangan_gudang->modul_id, 'link_proses'=>$link),
            array('instalasi_id'=>$ruangan_keuangan->instalasi_id, 'ruangan_id'=>$ruangan_keuangan->ruangan_id, 'modul_id'=>$ruangan_keuangan->modul_id, 'link_proses'=>$link),
            array('instalasi_id'=>$ruangan_purchasing->instalasi_id, 'ruangan_id'=>$ruangan_purchasing->ruangan_id, 'modul_id'=>$ruangan_purchasing->modul_id, 'link_proses'=>$link),
        ));
        
        if(!empty($model->tglpermintaanuangmuka)){
            $judulUangMuka = "Permintaan Uang Muka Pembelian";
            $isiUangMuka = "Telah dilakukan approval untuk permintaan uang muka pembelian dengan rincian sebagai berikut <br/>";
            $isiUangMuka .= "Tgl. Permintaan Uang Muka Pembelian : ". MyFormatter::formatDateTimeForUser($model->tglpermintaanuangmuka)."<br/>";
            $isiUangMuka .= "No. Permintaan Pembelian : ". $model->nopembelian."<br/>";
            CustomFunction::broadcastNotif($judulUangMuka, $isiUangMuka, array(
                array('instalasi_id'=>$ruangan_keuangan->instalasi_id, 'ruangan_id'=>$ruangan_keuangan->ruangan_id, 'modul_id'=>$ruangan_keuangan->modul_id),
            ));
        }
    }
    
	
	public function actionPrintMengetahuiUmum($pembelianbarang_id)
    {
		$format = new MyFormatter();
                
                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));     
                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
		
                $judulLaporan = 'SURAT PESANAN';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglpembelian);
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'printMengetahuiumum',array('format'=>$format,'model'=>$model,'modDetailBeli'=>$modDetailBeli,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'printMengetahuiumum',array('format'=>$format,'model'=>$model,'modDetailBeli'=>$modDetailBeli,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			//$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'printMengetahuiumum',array('format'=>$format,'model'=>$model,'modDetailBeli'=>$modDetailBeli,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
    
     public function actionBatalPermintaanPembelian() {
        $keterangan = "";

        if (Yii::app()->request->isAjaxRequest) {
                $transaction = Yii::app()->db->beginTransaction();
                $pesan = 'success';
                $status = 'ok';
                $ok = true;
                try {
                    $terimapersediaan_id = $_POST['terimapersediaan_id'];
                    $tglbatal = $_POST['tglbatal'];
                    $keterangan_batal = $_POST['keterangan_batal'];
    //                            $pegawaipembatalan = $_POST['pegawaipembatalan'];

                    $permintaanpembelian = PembelianbarangT::model()->findByPk($terimapersediaan_id);

                    // simpan batal permintaan
                    $model = new BatalpermintaanpembelianT;
                    $model->ruangan_id = $permintaanpembelian->create_ruangan;
                    $model->permintaanpembelian_id = $permintaanpembelian->pembelianbarang_id;
                    $model->tglbatalpermintaan = MyFormatter::formatDateTimeForDb($tglbatal);
                    $model->tglpermintaanpembelian = MyFormatter::formatDateTimeForDb($permintaanpembelian->tglpembelian);
                    $model->nopermintaan = $permintaanpembelian->nopembelian;
                    $model->supplier_nama = $permintaanpembelian->supplier->supplier_nama;
                    $model->pegawaipemesan = $permintaanpembelian->pemesan->namaLengkap;
                    $model->alasanbatalpermintaan = $keterangan_batal;
                    $modOtoritasi = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                    $model->user_name_otoritasi = $modOtoritasi->nama_pegawai;
                    $model->user_id_otorisasi = $modOtoritasi->pegawai_id;
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai_id = Yii::app()->user->id;
                    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                    if ($model->validate()) {
                        if($model->save()){
                            $ok = true;
                            PembelianbarangT::model()->updateByPk($permintaanpembelian->pembelianbarang_id, array('batalpermintaanpembelian_id'=>$model->batalpermintaanpembelian_id));
                        }
                    } else $ok = false;

                    if ($ok) {
                        $pesan = 'success';
                        $this->notifPembatalanPermintaanpembelian($model->batalpermintaanpembelian_id);
                        $transaction->commit();
                    } else {
                        $transaction->rollback();
                        $keterangan = "Permintaan Tidak Bisa dibatalkan";
                        $pesan = 'exist';
                    }

                } catch (Exception $ex) {
                    print_r($ex);
                    $status = 'not';
                    $pesan = 'exist';
                    $transaction->rollback();
                }

                $data['pesan'] = $pesan;
                $data['status'] = $status;
                $data['keterangan'] = $keterangan;

                echo json_encode($data);

                Yii::app()->end();
        }
    }
    
    public function cekPegawaiJabatan() {
        $approval = ApprovalotorisasiM::model()->find();
        if (empty($approval)) {
            return false;
        }
        
        return in_array(Yii::app()->user->getState('pegawai_id'), array(
            $approval->managerumum_id,
            $approval->managerkeuangan_id,
            $approval->direkturrs_id,
        ));
        
        
        //return in_array($peg->jabatan_id, );
    }
    
    public function cekPegawaiApproval() {
        $approval = ApprovalotorisasiM::model()->find();
        if (empty($approval)) {
            return false;
        }
        
        return in_array(Yii::app()->user->getState('pegawai_id'), array(
            $approval->managerumum_id,
            // $approval->managerkeuangan_id  ,
            $approval->direkturrs_id,
        ));
        
        
        //return in_array($peg->jabatan_id, );
    }
    
    
    public function notifPembatalanPermintaanpembelian($batalpermintaanpembelian_id) {
        
        $model = BatalpermintaanpembelianT::model()->findByPk($batalpermintaanpembelian_id);
        
        $pegawaiBatal = "-";
        
        if (!empty($model->user_id_otorisasi)) {
            $peg = PegawaiM::model()->findByPk($model->user_id_otorisasi);
            if (!empty($peg)) {
                $pegawaiBatal = $peg->namaLengkap;
            }
        }
        
        $judul = "Pembatalan Permintaan Pembelian Barang";
        $isi = "Tgl. Pembatalan Permintaan Barang : ". MyFormatter::formatDateTimeForUser($model->tglbatalpermintaan)."<br/>";
        $isi .= "No. Permintaan Barang : ".$model->nopermintaan."<br/>";
        $isi .= "Pegawai Pembatalan Permintaan Barang : ".$pegawaiBatal."<br/>";
        
        $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
        $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
        $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
        
        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id'=>$ruangan_gudang->instalasi_id, 'ruangan_id'=>$ruangan_gudang->ruangan_id, 'modul_id'=>$ruangan_gudang->modul_id),
            array('instalasi_id'=>$ruangan_keuangan->instalasi_id, 'ruangan_id'=>$ruangan_keuangan->ruangan_id, 'modul_id'=>$ruangan_keuangan->modul_id),
            array('instalasi_id'=>$ruangan_purchasing->instalasi_id, 'ruangan_id'=>$ruangan_purchasing->ruangan_id, 'modul_id'=>$ruangan_purchasing->modul_id),
        ));
    }
}

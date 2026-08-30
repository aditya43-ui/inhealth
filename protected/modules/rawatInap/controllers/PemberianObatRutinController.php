
<?php

class PemberianObatRutinController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'admin';
    public $path_view = "rawatInap.views.pemberianObatRutin.";


	/**
	 * Membuat dan menyimpan data baru.
	 */
	public function actionCreate($pendaftaran_id, $pasienadmisi_id = null, $id = null)
	{
        $this->layout = '//layouts/iframe';

        if (!empty($pasienadmisi_id)) {
            $kunjungan = InfokunjunganriV::model()->findByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
            ));
        } else {
            $kunjungan = PendaftaranT::model()->findByAttributes(array(
                'pendaftaran_id'=>$pendaftaran_id,
            ));
        }

        $model = CatatanpemberianobatT::model()->findByPk($id);

        $modPemberianObatDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id'=>$id));



        if (empty($modPemberianObatDet)) {

            $modPemberianObatDet = new CatatanpemberianobatdetT;
        }

            // echo print_r($modPemberianObatDet).exit();

        if (empty($model)) {
            $model = new CatatanpemberianobatT;
            $model->pendaftaran_id = $kunjungan->pendaftaran_id;
            $model->pasien_id = $kunjungan->pasien_id;
        }


        if (!empty($model->obatalkes)) {
            $model->obatalkes_nama = $model->obatalkes->obatalkes_nama;
        }

        if (!empty($model->petugaspengisi)) {
            $model->petugaspengisi_nama = $model->petugaspengisi->namaLengkap;
        }

				$conditionRiwayat_infus = array();
				$riwayat_oral = array();
				if(Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_VK){
					$conditionRiwayat_infus = array('condition'=>"jenisinfus in ('INJEKSI','INFUS')");

					$riwayat_oral = CatatanpemberianobatT::model()->findAllByAttributes(array(
	            'pendaftaran_id'=>$pendaftaran_id,
	        ), array('condition'=>"jenisinfus in ('ORAL','OBAT LUAR')"));
				}

        $riwayat_infus = CatatanpemberianobatT::model()->findAllByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
        ), $conditionRiwayat_infus);


		if(isset($_POST['CatatanpemberianobatT']))
		{
			$model->attributes = $_POST['CatatanpemberianobatT'];


            if ($model->isNewRecord) {
                $model->create_time = date('Y-m-d H:i:s');
                $model->create_loginpemakai = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            }
            $model->isalergiobat = $_POST['CatatanpemberianobatT']['isalergiobat'];
            $model->carapemberian = $_POST['CatatanpemberianobatT']['carapemberian'];
            $model->cairanmasuk = $_POST['CatatanpemberianobatT']['cairanmasuk'];
            $model->jeniscairanmasuk = $_POST['CatatanpemberianobatT']['jeniscairanmasuk'];
            $model->pegawai_id = $_POST['CatatanpemberianobatT']['pegawai_id'];
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai = Yii::app()->user->id;

			if($model->save()){
                $sukses = true;
                if (!empty($modPemberianObatDet)){
                    // echo print_r($modPemberianObatDet).exit();
                    $hapusRiwayat = CatatanpemberianobatdetT::model()->deleteAll('catatanpemberianobat_id='.$model->catatanpemberianobat_id.'');
                }
                if(isset($_POST['CatatanpemberianobatdetT'])){

                    if (count($_POST['CatatanpemberianobatdetT']) > 0){
                        $modPemberianObatDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id'=>$model->catatanpemberianobat_id));


                        foreach($_POST['CatatanpemberianobatdetT'] as $det){
                            $modPemberianObatDet = new CatatanpemberianobatdetT;
                            $modPemberianObatDet->catatanpemberianobat_id = $model->catatanpemberianobat_id;
                            $modPemberianObatDet->tanggal_pemberian = MyFormatter::formatDateTimeForDB($det['tanggal_pemberian']);
                            $modPemberianObatDet->tanda = $det['tanda'];
                            $modPemberianObatDet->initial = $det['initial'];
                            $modPemberianObatDet->jam_pemberian = $det['jam_pemberian'];
                            $modPemberianObatDet->waktu_monitoring = $det['waktu_monitoring'];
                            if($modPemberianObatDet->save()){
                                $sukses = true;
                            }else{
                                $sukses = false;
                            }
                        }
                    }

                }


			}else{
                $sukses = false;
            }

            if($sukses){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('create','pendaftaran_id'=>$model->pendaftaran_id, 'pasienadmisi_id'=>$kunjungan->pasienadmisi_id,'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:"")));

            }
		}
        // echo print_r(($modPemberianObatDet)).exit();
		$this->render($this->path_view.'create',array(
			'model'=>$model,
            'kunjungan'=>$kunjungan,
            'riwayat_infus'=>$riwayat_infus,
						'riwayat_oral'=>$riwayat_oral,
            'modPemberianObatDet'=>$modPemberianObatDet
		));
	}

    public function actionUpdatePemberianObat($pendaftaran_id, $catatanpemberianobatdet_id, $status = null) {
        
        $this->layout = '//layouts/iframe';
        $model = CatatanpemberianobatdetT::model()->findByPk(array('catatanpemberianobatdet_id'=>$catatanpemberianobatdet_id));
        
        if (isset($_POST['CatatanpemberianobatdetT'])) {
            $trans = Yii::app()->db->beginTransaction();
            
            try {

                if($status === 'update'){
                    // echo '<pre>';var_dump('update ',$_POST);die;
                    $updateObatDet = CatatanpemberianobatdetT::model()->updateByPk($catatanpemberianobatdet_id, array(
                        'tanda' => $_POST['CatatanpemberianobatdetT']['tanda'],
                        'tanggal_pemberian' => MyFormatter::formatDateTimeForDB($_POST['CatatanpemberianobatdetT']['tanggal_pemberian']),
                        'jam_pemberian' => $_POST['CatatanpemberianobatdetT']['jam_pemberian'],
                        'pemberian_peg' => $_POST['CatatanpemberianobatdetT']['pemberian_peg'],
                        'initial' => $_POST['CatatanpemberianobatdetT']['initial'],
                    ));
                }

                if ($updateObatDet) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Update Pemberian Obat berhasil disimpan ! ");
                    // $this->redirect(array('updateRiwayatVaksinasi','pendaftaran_id'=>$model->pendaftaran_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Update Pemberian Obat gagal disimpan ! ");
                }
                
                
            } catch (Exception $ex) {
                echo '<pre>';var_dump('failed ',$ex);die;
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Update Pemberian Obat gagal disimpan ! ".$ex->getMessage());
            }
        }
        
        if(!empty($model->tanggal_pemberian)){
            $model->tanggal_pemberian = $model->tanggal_pemberian;
        }
        if(!empty($model->jam_pemberian)){
            $model->jam_pemberian = $model->jam_pemberian;
        }
        if(!empty($model->pemberian_peg)){
            $peg = PegawaiM::model()->findByPk($model->pemberian_peg);
            $model->pemberian_peg = $peg->pegawai_id;
        }
        if(!empty($model->initial)){
            $model->initial = $model->initial;
        }
        if(!empty($model->tanda)){
            $model->tanda = $model->tanda;
        }

        $this->render($this->path_view."vaksinasi.update", array(
            'model'=>$model,
        ));
    }

    public function actionCreatePemberianObat($pendaftaran_id, $catatanpemberianobatdet_id, $status = null) {
        
        $this->layout = '//layouts/iframe';
        $model = CatatanpemberianobatdetT::model()->findByPk(array('catatanpemberianobatdet_id'=>$catatanpemberianobatdet_id));
        
        if (isset($_POST['CatatanpemberianobatdetT'])) {
            $trans = Yii::app()->db->beginTransaction();
            
            try {

                // echo '<pre>';var_dump('create ',$_POST);die;
                $format = new MyFormatter();
                $model->attributes = $_POST['CatatanpemberianobatdetT'];
                $model->tanda = $_POST['CatatanpemberianobatdetT']['tanda'];
                $model->tanggal_pemberian = $_POST['CatatanpemberianobatdetT']['tanggal_pemberian'];
                $model->jam_pemberian = $_POST['CatatanpemberianobatdetT']['jam_pemberian'];
                $model->pemberian_peg = $_POST['CatatanpemberianobatdetT']['pemberian_peg'];
                $model->initial = $_POST['CatatanpemberianobatdetT']['initial'];
                
                $model->save();

                if ($model->save()) {
                    $trans->commit();
                    Yii::app()->user->setFlash('success', "Pemberian Obat berhasil disimpan ! ");
                    // $this->redirect(array('updateRiwayatVaksinasi','pendaftaran_id'=>$model->pendaftaran_id));
                } else {
                    $trans->rollback();
                    Yii::app()->user->setFlash('error', "Pemberian Obat gagal disimpan ! ");
                }
                
                
            } catch (Exception $ex) {
                echo '<pre>';var_dump('failed ',$ex);die;
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Pemberian Obat gagal disimpan ! ".$ex->getMessage());
            }
        }

        $model->tanggal_pemberian = date('Y-m-d');
        $model->jam_pemberian = date('H:i:s');
        $model->pemberian_peg = Yii::app()->user->id;
        $peg = PegawaiM::model()->findByPk(Yii::app()->user->id);
        $model->initial = $peg->nama_pegawai;
        $model->tanda = 'Diberikan';

        $this->render($this->path_view."vaksinasi.update", array(
            'model'=>$model,
        ));
    }
	/**
	 * Memanggil dan Menghapus data.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        // Yii::app()->db->beginTransaction();

        $ok = 1;
        $msg = "Data catatan berhasil dihapus.";

        try {
            $id = $_POST['id'];
            $this->loadModel($id)->delete();

        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Data catatan gagal dihapus. ".$ex->getMessage();
        }

        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg
        ));

	}

	/**
	 * Memanggil data dari model.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = CatatanpemberianobatT::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catatanobatpasien-t-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	/**
	 * Mencetak data
	 */
	public function actionPrint()
	{
		$model = new CatatanpemberianobatT;
		$model->attributes = $_REQUEST['CatatanpemberianobatT'];
		$judulLaporan='Data CatatanpemberianobatT';
		$caraPrint = $_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }


    public function actionPrintNew($pendaftaran_id)
	{
		$typeoa = $_GET['typeoa'];
		$criteria = new CDbCriteria();
        $judulLaporan = '';

        if(!empty($typeoa)){
            if($typeoa == 'obat'){
                $judulLaporan = "CATATAN PEMBERIAN (CPO) INJEKSI/INFUS";
            }else if($typeoa == 'luar'){
                $judulLaporan = "CATATAN PEMBERIAN (CPO) ORAL DAN OBAT LUAR";
            }
        }
		// $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
		// if(!empty($typeoa)){
		// 	if($typeoa == 'obat'){
		// 		$criteria->addInCondition('jenisinfus',array('INJEKSI','INFUS'));
		// 	}else if($typeoa == 'luar'){
		// 		$criteria->addInCondition('jenisinfus',array('ORAL','OBAT LUAR'));
		// 	}
		// }
        // $model = CatatanpemberianobatT::model()->findAll($criteria);

        $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        $modPasien = PasienM::model()->findByAttributes(array('pasien_id'=>$modPendaftaran->pasien_id));
        $modAdmisi = RIPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        $modDiagnosa = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
		
		$caraPrint = $_REQUEST['caraprint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view.'Print',array('modAdmisi'=>$modAdmisi, 'modDiagnosa'=>$modDiagnosa,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view.'Print',array('modelInjeksi'=>$modelInjeksi,'modelNon'=>$modelNon, 'modelSup'=>$modelSup, 'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}

    public function actionAutocompletePetugas($term = "") {
        $modPetugas = new PegawairuanganV('searchPegawaiMenyetujui');
        $modPetugas->unsetAttributes();
        $modPetugas->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPetugas->pegawai_aktif = true;
        $modPetugas->nama_pegawai = $term;

        $prov = $modPetugas->search();
        $prov->pagination = false;

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['namaLengkap'] = $item->namaLengkap;
            $sub['label'] = $item->namaLengkap;
            $sub['value'] = $item->pegawai_id;
            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    public function actionAutocompleteObat($term = "") {
        $modObatAlkes = new RIObatalkesM('search');
        $modObatAlkes->unsetAttributes();
        $modObatAlkes->pendaftaran_id = $_GET['pendaftaran_id'];
        $modObatAlkes->obatalkes_nama = $term;

        $prov = $modObatAlkes->searchObatAlkesPasienDijual();
        $prov->pagination = false;

        $res = array();

        foreach ($prov->data as $item) {
            $sub = $item->attributes;
            $sub['label'] = $item->obatalkes_nama;
            $sub['value'] = $item->obatalkes_id;
            $res[] = $sub;
        }

        echo CJSON::encode($res);
    }

    public function actionAjaxDetail(){
            if(Yii::app()->request->isAjaxRequest) {
            $id = $_POST['catatanpemberianobat_id'];
            $detail = CatatanpemberianobatdetT::model()->findallByAttributes(array('catatanpemberianobat_id'=>$id));
            $data['result'] = $this->renderPartial($this->path_view.'_Detail', array('modDetail'=>$detail), true);

            echo json_encode($data);
             Yii::app()->end();
            }
    }

    //tombol dikolom penerima
    public function actionUpdatePenerima(){
        if(Yii::app()->request->isAjaxRequest) {

        // echo '<pre>';var_dump($_POST);die;

        $id = isset($_POST['catatanpemberianobat_id']) ? $_POST['catatanpemberianobat_id'] : null;

        $updatePenerima = CatatanpemberianobatT::model()->updateByPk($id, array(
            'penerimaan_status' => 'Diterima',
            'penerimaan_waktu' => date('Y-m-d H:i:s'),
            'pegawai_id' => Yii::app()->user->id
        ));

        if($updatePenerima){
            $pesan = 'ok';
        } else {
            $pesan = 'nope';
        }

        $data['pesan'] = $pesan;

        echo json_encode($data);
            Yii::app()->end();
        }
    }

    //tombol dikolom cara pemberian
    public function actionUpdateCaraPemberian(){
        if(Yii::app()->request->isAjaxRequest) {

        // echo '<pre>';var_dump($_POST);die;

        $id = isset($_POST['catatanpemberianobat_id']) ? $_POST['catatanpemberianobat_id'] : null;
        $carapemberian = isset($_POST['carapemberian']) ? $_POST['carapemberian'] : null;

        $updateCarPemberian = CatatanpemberianobatT::model()->updateByPk($id, array(
            'carapemberian' => $carapemberian
        ));

        if($updateCarPemberian){
            $pesan = 'ok';
        } else {
            $pesan = 'nope';
        }
        
        $data['pesan'] = $pesan;

        echo json_encode($data);
            Yii::app()->end();
        }
    }

    //tombol dikolom penerima
    public function actionPemberian(){
        if(Yii::app()->request->isAjaxRequest) {

        // echo '<pre>';var_dump($_POST);die;

        $id = isset($_POST['catatanpemberianobat_id']) ? $_POST['catatanpemberianobat_id'] : null;
        $idDet = isset($_POST['catatanpemberianobatdet_id']) ? $_POST['catatanpemberianobatdet_id'] : null;

        // $catatanpemberianobatdetT = CatatanpemberianobatdetT::model()->findByAttributes(array(
        //     'catatanpemberianobatdet_id' => $idDet
        // ));
        $pegawaiM = PegawaiM::model()->findByAttributes(array(
            'pegawai_id' => Yii::app()->user->id
        ));
        // echo '<pre>';var_dump($_POST,$idDet);die;
        $pemberian = CatatanpemberianobatdetT::model()->updateByPk($idDet, array(
            'tanda' => 'Diberikan',
            'tanggal_pemberian' => date('Y-m-d'),
            'jam_pemberian' => date('H:i:s'),
            'pemberian_peg' => Yii::app()->user->id,
            'initial' => $pegawaiM->nama_pegawai
        ));
        // echo '<pre>';var_dump($pemberian);die;
        if($pemberian){
            $pesan = 'ok';
        } else {
            $pesan = 'nope';
        }

        $data['pesan'] = $pesan;

        echo json_encode($data);
            Yii::app()->end();
        }
    }

    public function actionPrintRiwayat()
    {
        $pendaftaran_id = $_GET['pendaftaran_id'];
        $kunjungan = PendaftaranT::model()->findByAttributes(array(
            'pendaftaran_id'=>$pendaftaran_id,
        ));
        $modPasien = PasienM::model()->findByAttributes(array('pasien_id'=>$kunjungan->pasien_id));
        $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

        $criteria = new CDbCriteria;
        $criteria->select = 'catatanpemberianobat_id, noresep, tglreseptur, tglpenyerahan, racikan_nama, obatalkes_nama, subjenis_nama, dosisobat, aturanpakaiobat, penerimaan_status, penerimaan_waktu, penerima_peg_nama';
        $criteria->group = $criteria->select;
        $criteria->addCondition("pendaftaran_id = '" .$pendaftaran_id . "'");
        $modPemberianObatRutin = DaftarpemberianobatrutinV::model()->findAll($criteria);
        $modPemberianObatRutin2 = DaftarpemberianobatrutinV::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id), array('order' => 'catatanpemberianobatdet_id asc'));
        // var_dump($modPemberianObatRutin2);die;

        $judulLaporan = 'Catatan Pemberian Obat Pasien Rawat Inap';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('printRiwayat', array('kunjungan' => $kunjungan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modPemberianObatRutin'=>$modPemberianObatRutin, 'modPemberianObatRutin2'=>$modPemberianObatRutin2,'modPasien'=>$modPasien, 'modAdmisi'=>$modAdmisi));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('printRiwayat', array('kunjungan' => $kunjungan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modPemberianObatRutin'=>$modPemberianObatRutin, 'modPemberianObatRutin2'=>$modPemberianObatRutin2,'modPasien'=>$modPasien, 'modAdmisi'=>$modAdmisi));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Params::DEFAULT_KERTAS_POSISI_LANDSCAPE;                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            //$mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->SetHTMLFooter('<span></span>');
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('printRiwayat', array('kunjungan' => $kunjungan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modPemberianObatRutin'=>$modPemberianObatRutin, 'modPemberianObatRutin2'=>$modPemberianObatRutin2,'modPasien'=>$modPasien, 'modAdmisi'=>$modAdmisi), true));
            $mpdf->Output();
        }
    }
}

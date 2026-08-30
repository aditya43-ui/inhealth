<?php

class InformasiAnggaranPenerimaanController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $tandaBayar = false;
	public $realisasiPenerimaan = false;
	
	public function actionIndex()
	{
		$model = new AGRenanggpenerimaanT;
		if(isset($_GET['AGRenanggpenerimaanT'])){
			$model->attributes = $_GET['AGRenanggpenerimaanT'];
			$model->noren_penerimaan  = isset($_REQUEST['AGRenanggpenerimaanT']['noren_penerimaan'])?$_REQUEST['AGRenanggpenerimaanT']['noren_penerimaan']:null;
			$model->konfiganggaran_id = isset($_REQUEST['konfiganggaran_id'])?$_REQUEST['konfiganggaran_id']:null;
			$model->sumberanggaran_id = isset($_REQUEST['AGRenanggpenerimaanT']['sumberanggaran_id'])?$_REQUEST['AGRenanggpenerimaanT']['sumberanggaran_id']:null;
		}
		$this->render('index',array(
									'model'=>$model
							));
	}
	
	/**
	 * Untuk rincian
	 */
	public function actionRincian($renanggpenerimaan_id)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id);  
		$modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
		
        $judulLaporan = 'Anggaran Penerimaan';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $this->render('_rincian', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetails'=>$modDetails
		));
	}
	
    public function actionPrintRincian($renanggpenerimaan_id)
    {
		
		$format = new MyFormatter();
		$model = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id); 
		$modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
		$judulLaporan = 'Anggaran Penerimaan';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printRincian',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printRincian',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			////$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printRincian',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
	/**
	 * Untuk transaksi realisasi
	 */
	public function actionRealisasi($renanggpenerimaan_id = null, $realisasianggpenerimaan_id = null)
	{
		$this->layout='//layouts/column1';
		$format = new MyFormatter();
		$jumlahTermin = 0;
		$model = new AGRealisasianggpenerimaanT;
		$modTandaBuktiBayar = new AGTandabuktibayarT;
		$modDetail = new AGRenanggaranpenerimaandetT;
                $modPenerimaan = new AGRenanggpenerimaanT;
		if (!empty($renanggpenerimaan_id)) {
                    $modPenerimaan = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id);  
                    $modPenerimaan->deskripsiperiode = AGKonfiganggaranK::model()->findByPk($modPenerimaan->konfiganggaran_id)->deskripsiperiode;
                    $modPenerimaan->sumberanggarannama = AGSumberanggaranM::model()->findByPk($modPenerimaan->sumberanggaran_id)->sumberanggarannama;
                    //$digit = AGKonfiganggaranK::model()->findByPk($modPenerimaan->konfiganggaran_id)->digitnilaianggaran;
                    $digit_str = 1; //"1".$digit;
                    //$modPenerimaan->digitnilai = "/ ".$digit;
                    $modPenerimaan->nilaipenerimaananggaran = $format->formatNumberForPrint($modPenerimaan->nilaipenerimaananggaran / (int)$digit_str);
                }
                $model->transfer = 0;
		$model->cek = 0;

		if (isset($_POST['AGTandabuktibayarT'])){
                        // var_dump($_POST); die;
			$transaction = Yii::app()->db->beginTransaction();
            try{
				$modTandaBuktiBayar->attributes = $_POST['AGTandabuktibayarT'];
				$modTandaBuktiBayar->create_time = date("Y-m-d H:i:s");
				$modTandaBuktiBayar->create_loginpemakai_id = Yii::app()->user->id;
				$modTandaBuktiBayar->create_ruangan = Yii::app()->user->ruangan_id;
				$modTandaBuktiBayar->uangkembalian = 0;
				$modTandaBuktiBayar->biayaadministrasi = 0;
				$modTandaBuktiBayar->uangditerima = $modTandaBuktiBayar->jmlpembayaran;
				$modTandaBuktiBayar->jmlpembulatan = 0;
				$modTandaBuktiBayar->ruangan_id = Yii::app()->user->ruangan_id;
				$modTandaBuktiBayar->sebagaipembayaran_bkm = "PENERIMAAN ANGGARAN";
				$modTandaBuktiBayar->carapembayaran = (($modTandaBuktiBayar->carapembayaran == 0) ? "TUNAI" : (($modTandaBuktiBayar->carapembayaran == 1) ? "TRANSFER" : (($modTandaBuktiBayar->carapembayaran == 2) ? "CEK" : "")));
				$modTandaBuktiBayar->tglbuktibayar = $format->formatDateTimeForDb($modTandaBuktiBayar->tglbuktibayar);
				$modTandaBuktiBayar->nobuktibayar = MyGenerator::noBuktiBayarAnggaran($modTandaBuktiBayar->tglbuktibayar);
				$modTandaBuktiBayar->nourutkasir = 1;
				$modTandaBuktiBayar->shift_id = 1;	
                                
                                //var_dump($modTandaBuktiBayar->attributes);
                                
				if ($modTandaBuktiBayar->save()){
					$this->tandaBayar = true;
                                                // var_dump($_POST);
						$model->attributes = $_POST['AGRealisasianggpenerimaanT'];
						$model->create_time = date("Y-m-d H:i:s");
						$model->create_loginpemakai_id = Yii::app()->user->id;
						$model->create_ruangan = Yii::app()->user->ruangan_id;
						$model->tandabuktibayar_id = $modTandaBuktiBayar->tandabuktibayar_id;
						$model->renanggpenerimaan_id = $_POST['AGRenanggpenerimaanT']['renanggpenerimaan_id']; //$_GET['renanggpenerimaan_id'];
						$model->tglrealisasianggpen = $modTandaBuktiBayar->tglbuktibayar;
						$model->norealisasianggpen = $_POST['AGRenanggpenerimaanT']['noren_penerimaan'];
						$jumlahTermin = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
						$berapaxpenerimaan = count((array)$jumlahTermin);
						$model->berapaxpenerimaan = $berapaxpenerimaan;
						$model->penerimaanke = $_POST['AGRealisasianggpenerimaanT']['renanggaranpenerimaandet_id'];
						$model->carapembayaran =$modTandaBuktiBayar->carapembayaran ;
						// var_dump($model->attributes); die;
                                                if ($model->save()){
							$this->realisasiPenerimaan = true;
						}
				}
                                        //die;
					if($this->tandaBayar && $this->realisasiPenerimaan){
						$transaction->commit();
						$jmlRealisasis = 0;
						$jmlDetail = 0;
						$modRealisasis = AGRealisasianggpenerimaanT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
						$jmlRealisasis = count((array)$modRealisasis);
								$criteria = new CDbCriteria;
								if(!empty($model->renanggpenerimaan_id)){
								$criteria->addCondition('renanggpenerimaan_id ='.$model->renanggpenerimaan_id);
								}
								$detail = AGRenanggaranpenerimaandetT::model()->findAll($criteria);
								$jmlDetail = count((array)$detail);
							//if ($jmlRealisasis == $jmlDetail){
							//	$this->redirect(array('index','renanggpenerimaan_id'=>$model->renanggpenerimaan_id,'frame'=>1,'sukses'=>1));
							//}else{
								$this->redirect(array('realisasi','renanggpenerimaan_id'=>$model->renanggpenerimaan_id,'realisasianggpenerimaan_id'=>$model->realisasianggpenerimaan_id,'frame'=>1,'sukses'=>1));
							//}
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data Realisasi Anggaran Penerimaan gagal disimpan !");
					}
			} catch (Exception $ex) {
				$transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Realisasi Anggaran Penerimaan gagal disimpan ! ".MyExceptionMessage::getMessage($ex,true));
			}
		}
		
		$this->render('_realisasi', array(
				'format'=>$format,
				'model'=>$model,
				'modPenerimaan'=>$modPenerimaan,
				'modTandaBuktiBayar'=>$modTandaBuktiBayar,
				'modDetail'=>$modDetail
		));
	}
	
    public function actionPrintRealisasi($realisasianggpenerimaan_id)
    {
		
		$format = new MyFormatter();
		$model = AGRealisasianggpenerimaanT::model()->findByPk($realisasianggpenerimaan_id); 
		$model->nilaipenerimaan = $format->formatNumberForPrint($model->nilaipenerimaan);
		$model->realisasipenerimaan = $format->formatNumberForPrint($model->realisasipenerimaan);
		$modPenerimaan = AGRenanggpenerimaanT::model()->findByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
		$modTandaBukti = AGTandabuktibayarT::model()->findByAttributes(array('tandabuktibayar_id'=>$model->tandabuktibayar_id));
		$modKonfig = AGKonfiganggaranK::model()->findByPk($modPenerimaan->konfiganggaran_id);
		$deskripsi = $modPenerimaan->konfiganggaran->deskripsiperiode;
        $jenisPrint = (isset($_REQUEST['jenisPrint']) ? $_REQUEST['jenisPrint'] : null);
		if($jenisPrint=='REALISASI') {
			$judulLaporan = 'Realisasi Anggaran Penerimaan';
			$this->layout='//layouts/printWindows';
			$this->render('printRealisasi',array('format'=>$format,'model'=>$model,'modPenerimaan'=>$modPenerimaan,'modTandaBukti'=>$modTandaBukti,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'jenisPrint'=>$jenisPrint));
		}
		else if($jenisPrint=='TANDABUKTIBAYAR') {
			$judulLaporan = 'KUITANSI';
			$this->layout='//layouts/printWindows';
			$this->render('printTandaBuktiBayar',array('format'=>$format,'model'=>$model,'modPenerimaan'=>$modPenerimaan,'modTandaBukti'=>$modTandaBukti,'modKonfig'=>$modKonfig,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'jenisPrint'=>$jenisPrint));
		}
    }
	
	public function actionCekNilaiPenerimaan()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$renanggaranpenerimaandet_id=$_POST['renanggaranpenerimaandet_id'];
			$renanggpenerimaan_id=$_POST['renanggpenerimaan_id'];
			$modPenerimaan = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id); 
			//$digit = AGKonfiganggaranK::model()->findByPk($modPenerimaan->konfiganggaran_id)->digitnilaianggaran;
			$digit_str = 1;//"1".$digit;
			$modDetail =  AGRenanggaranpenerimaandetT::model()->findByPk($renanggaranpenerimaandet_id);
			$data['nilaipenerimaan'] = empty($modDetail)?0:MyFormatter::formatNumberForPrint($modDetail->nilaipenerimaan / (int)$digit_str);
			$data['renanggaran_ke'] = empty($modDetail)?null:$modDetail->renanggaran_ke;
			echo json_encode($data);
			Yii::app()->end();
		}
	}
	
    public function actionAutocompletePegawaiMengetahui()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = AGPegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
    public function actionAutocompletePegawaiMenyetujui()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
			$criteria->group = 'nomorindukpegawai,nama_pegawai,gelardepan,gelarbelakang_nama,alamat_pegawai,pegawai_id';
			$criteria->select = $criteria->group;
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = AGPegawairuanganV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
    
    public function actionAutocompletePenerimaan()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $returnVal = array();
            $model = new AGRenanggpenerimaanT;
            $model->noren_penerimaan = $_GET['term'];
            $provider = $model->searchInformasiAnggPenBelumRelasasi();
            
            foreach ($provider->data as $item) {
                $sum = array();
                $sum['label'] = $item->noren_penerimaan;
                $sum['data'] = CJSON::decode($item->json);
                array_push($returnVal, $sum);
            }
            
            echo CJSON::encode($returnVal);
        }
    }
}
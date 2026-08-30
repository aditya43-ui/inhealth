<?php

class InformasiRencanaAnggaranPenerimaanController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $ubahRencana = false;
	public $hapusDetailLama = false;
	public $ubahRencanaDet = true;
	public $approveUpdateId = true;
	public $approveBaru = false;
	public $approveUpdateTglDet = true;
//	public $hapusDetailLamaApp = false;
	public $insertDetail = true;
	
	public function actionIndex()
	{
		$model = new AGRenanggpenerimaanT;
		$modDetail = new AGRenanggaranpenerimaandetT;
		
		if(isset($_GET['AGRenanggpenerimaanT'])){
			$model->attributes = $_GET['AGRenanggpenerimaanT'];
			$model->noren_penerimaan  = isset($_REQUEST['AGRenanggpenerimaanT']['noren_penerimaan'])?$_REQUEST['AGRenanggpenerimaanT']['noren_penerimaan']:null;
			$model->konfiganggaran_id = isset($_REQUEST['konfiganggaran_id'])?$_REQUEST['konfiganggaran_id']:null;
			$model->sumberanggaran_id = isset($_REQUEST['AGRenanggpenerimaanT']['sumberanggaran_id'])?$_REQUEST['AGRenanggpenerimaanT']['sumberanggaran_id']:null;
		}
		$this->render('index',array(
									'model'=>$model,
									'modDetail'=>$modDetail,
							));
	}
	
	/**
	 * Ajax untuk menyetujui
	 */
	public function actionMenyetujui($renanggpenerimaan_id,$renpen_menyetujui_id =null)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id); 
		$modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
		
		if(!empty($renpen_menyetujui_id)){
			$update = AGRenanggpenerimaanT::model()->updateByPk($renanggpenerimaan_id,array('renpen_tglmenyetujui'=>date("Y-m-d")));
				if($update){
					Yii::app()->user->setFlash('success',"Data berhasil disimpan");
					$this->redirect(array('menyetujui','renanggpenerimaan_id'=>$renanggpenerimaan_id,'sukses'=>1));
				}else{
					Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
				}
		}
		
        $judulLaporan = 'Rencana Anggaran Penerimaan';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $this->render('_menyetujui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetails'=>$modDetails
		));
		
	}
	
    public function actionPrintMenyetujui($renanggpenerimaan_id)
    {
		$format = new MyFormatter();
		$model = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id); 
		$modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
		$judulLaporan = 'Rencana Anggaran Penerimaan';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printMenyetujui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printMenyetujui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			////$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printMenyetujui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
	/**
	 * Ajax untuk mengetahui
	 */
	public function actionMengetahui($renanggpenerimaan_id,$renpen_mengetahui_id =null)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id); 
		$modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
		
		if(!empty($renpen_mengetahui_id)){
			$update = AGRenanggpenerimaanT::model()->updateByPk($renanggpenerimaan_id,array('renpen_tglmengetahui'=>date("Y-m-d")));
				if($update){
					Yii::app()->user->setFlash('success',"Data berhasil disimpan");
					$this->redirect(array('mengetahui','renanggpenerimaan_id'=>$renanggpenerimaan_id,'sukses'=>1));
				}else{
					Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
				}
		}
		
        $judulLaporan = 'Rencana Anggaran Penerimaan';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $this->render('_mengetahui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetails'=>$modDetails
		));
	}
	
    public function actionPrintMengetahui($renanggpenerimaan_id)
    {
		$format = new MyFormatter();
		$model = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id); 
		$modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
		$judulLaporan = 'Rencana Anggaran Penerimaan';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printMengetahui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printMengetahui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			////$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printMengetahui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
	/**
	 * Ajax untuk rincian
	 */
	public function actionRincian($renanggpenerimaan_id)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id);  
		$modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
		if($model->approverenanggpen_id){
        $judulLaporan = 'Anggaran Penerimaan';
		}else{
        $judulLaporan = 'Rencana Anggaran Penerimaan';
		}
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
		if($model->approverenanggpen_id){
        $judulLaporan = 'Anggaran Penerimaan';
		}else{
        $judulLaporan = 'Rencana Anggaran Penerimaan';
		}
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
	
	
	public function actionUbahAnggaran($renanggpenerimaan_id){
		$format = new MyFormatter();
		$detailAnggaran = array(); 
		$model = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id);
		$model->deskripsiperiode = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->deskripsiperiode;
		$model->tglrenanggaranpen = $format->formatDateTimeForUser($model->tglrenanggaranpen);
		$model->sumberanggarannama = AGSumberanggaranM::model()->findByPk($model->sumberanggaran_id)->sumberanggarannama;
		$digit = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->digitnilaianggaran;
		$digit_str = "1".$digit;
		$model->digitnilai = "/ ".$digit;
		$model->pegawaimengetahui_nama = isset($model->renpen_mengetahui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->renpen_mengetahui_id))->nama_pegawai : "";
		$model->pegawaimenyetujui_nama = isset($model->renpen_menyetujui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->renpen_menyetujui_id))->nama_pegawai : "";
		$model->total_renanggaranpen = $format->formatNumberForUser($model->total_renanggaranpen/ (int)$digit_str);
		$model->nilaipenerimaananggaran = $format->formatNumberForUser($model->nilaipenerimaananggaran/ (int)$digit_str);
		$model->statusDetail = "lama";
		$modDetail = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$renanggpenerimaan_id));
		$update = true;
		
		if(isset($_POST['AGRenanggaranpenerimaandetT'])){
			$transaction = Yii::app()->db->beginTransaction();
            try {
				$model->attributes = $_POST['AGRenanggpenerimaanT'];
				$model->renpen_menyetujui_id = isset($_POST['AGRenanggpenerimaanT']['renpen_menyetujui_id']) ? $_POST['AGRenanggpenerimaanT']['renpen_menyetujui_id'] : "";
				$model->renpen_mengetahui_id = isset($_POST['AGRenanggpenerimaanT']['renpen_mengetahui_id']) ? $_POST['AGRenanggpenerimaanT']['renpen_mengetahui_id'] : "";
				$model->tglrenanggaranpen = $format->formatDateTimeForDb($model->tglrenanggaranpen);
				$model->total_renanggaranpen = $format->formatNumberForDb($_POST['AGRenanggpenerimaanT']['nilaipenerimaananggaran']).$digit;
				$model->nilaipenerimaananggaran = $format->formatNumberForDb($_POST['AGRenanggpenerimaanT']['nilaipenerimaananggaran']).$digit;
				if ($model->update()){
				$this->ubahRencana = true;
				if ($_POST['AGRenanggpenerimaanT']['statusDetail'] == "baru"){
				$deleteDetail = AGRenanggaranpenerimaandetT::model()->deleteAllByAttributes(array('renanggpenerimaan_id'=>$renanggpenerimaan_id));
				$this->hapusDetailLama = true;
				}else{
					$this->hapusDetailLama = false;
				}
					$modDetails = $_POST['AGRenanggaranpenerimaandetT'];
					foreach ($modDetails as $i => $detail){
						if ($detail['renanggaranpenerimaandet_id']!=0){
							$updateTglDetail = AGRenanggaranpenerimaandetT::model()->updateByPk($detail['renanggaranpenerimaandet_id'],array('tglrenanggaranpen'=>$format->formatDateTimeForDb($detail['tglrenanggaranpen'])));
							if($updateTglDetail) {
								$this->ubahRencanaDet &= true;
							} else {
								$this->ubahRencanaDet &= false;
							}
						}else{
							$modKonfig = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id);
							if ($modKonfig->digitnilaianggaran === "0"){
								$digitNilai = null;
							}else {
								$digitNilai = isset($modKonfig->digitnilaianggaran) ? $modKonfig->digitnilaianggaran : null;
							}
							$modDet = new AGRenanggaranpenerimaandetT;
							$modDet->attributes = $detail;
							$modDet->renanggpenerimaan_id = $model->renanggpenerimaan_id;
							$modDet->renanggaran_ke = $detail['termin'];
							$modDet->nilaipenerimaan = $detail['nilaipenerimaan'].$digitNilai;
							$modDet->tglrenanggaranpen = $format->formatDateTimeForDb($detail['tglrenanggaranpen']);
							if($modDet->save()) {
								$this->ubahRencanaDet &= true;
							} else {
								$this->ubahRencanaDet &= false;
							}
						}
					}
				}
						if($this->ubahRencana && $this->ubahRencanaDet){
							$transaction->commit();
							$this->redirect(array('index','renanggpenerimaan_id'=>$model->renanggpenerimaan_id,'frame'=>1,'sukses'=>1));
						}else{
							$transaction->rollback();
							Yii::app()->user->setFlash('error',"Update Data Rencana Anggaran Pengeluaran gagal disimpan !");
						}
				
			} catch (Exception $ex) {
				$transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Rencana Anggaran Penerimaan gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
			}	
			
		}
		
		$this->render('_ubahAnggaran',array(
			'format'=>$format,
			'model'=>$model,
			'modDetail'=>$modDetail,
			'digit_str'=>$digit_str,
			'update'=>$update
		));
	}
	
	public function actionApproval($renanggpenerimaan_id){
		$format = new MyFormatter();
		$jumlahRow = 0;
		$model = AGRenanggpenerimaanT::model()->findByPk($renanggpenerimaan_id);
		$model->tglrenanggaranpen = $format->formatDateTimeForUser($model->tglrenanggaranpen);
		$model->deskripsiperiode = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->deskripsiperiode;
		$model->sumberanggarannama = AGSumberanggaranM::model()->findByPk($model->sumberanggaran_id)->sumberanggarannama;
		$model->pegawaimengetahui_nama = isset($model->renpen_mengetahui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->renpen_mengetahui_id))->nama_pegawai : "";
		$model->pegawaimenyetujui_nama = isset($model->renpen_menyetujui_id) ? AGPegawaiV::model()->findByAttributes(array('pegawai_id'=>$model->renpen_menyetujui_id))->nama_pegawai : "";
		$digit = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id)->digitnilaianggaran;
		$digit_str = 1; //"1".$digit;
		// $model->digitnilai = "/ ".$digit;
		$model->total_renanggaranpen = $format->formatNumberForPrint($model->total_renanggaranpen/ (int)$digit_str);
		$modDetail = new AGRenanggaranpenerimaandetT;
		$modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$renanggpenerimaan_id));
			
		if (isset($_POST['AGRenanggaranpenerimaandetT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modApprove =  new AGApproverenanggpenT;
				$modApprove->attributes = $_POST['AGRenanggaranpenerimaandetT'];
				$modApprove->tglapproverenanggaran = $format->formatDateTimeForDb($_POST['AGRenanggpenerimaanT']['tglrenanggaranpen']);
				$modApprove->menyetujui_id = $_POST['AGRenanggpenerimaanT']['renpen_mengetahui_id'];
				$modApprove->mengetahui_id = $_POST['AGRenanggpenerimaanT']['renpen_menyetujui_id'];
				$modApprove->tglmengetahuiappr = date("Y-m-d");
				$modApprove->tglmenyetujappr = date("Y-m-d");
				$modApprove->create_time = date("Y-m-d H:i:s");
				$modApprove->create_loginpemakai_id = Yii::app()->user->id;
				$modApprove->create_ruangan = Yii::app()->user->ruangan_id;
				if($modApprove->save())
				$this->approveBaru = true;
				if($this->approveBaru){
					if(count((array)$_POST['AGRenanggaranpenerimaandetT']) > 0){
						$jumlahRow = $_POST['AGRenanggpenerimaanT']['jmlRow'];
						$nilaiPenerimaan = $_POST['AGRenanggpenerimaanT']['totalnilaipenerimaan'];
						foreach($_POST['AGRenanggaranpenerimaandetT'] AS $i => $postRencanaDet){
							//$modKonfig = AGKonfiganggaranK::model()->findByPk($model->konfiganggaran_id);
							//if ($modKonfig->digitnilaianggaran === "0"){
							//	$digitNilai = null;
							//}else {
							//	$digitNilai = isset($modKonfig->digitnilaianggaran) ? $modKonfig->digitnilaianggaran : null;
							//}
									if ($_POST['AGRenanggaranpenerimaandetT'][$i]['renanggaranpenerimaandet_id'] != 0){
										$updatePenerimaan = AGRenanggpenerimaanT::model()->updateByPk($renanggpenerimaan_id, array('approverenanggpen_id'=>$modApprove->approverenanggpen_id,'berapaxpenerimaan'=>$jumlahRow, 'nilaipenerimaananggaran'=>$nilaiPenerimaan));								
										if ($updatePenerimaan)
                                                                                    $this->approveUpdateId &= true;
										$updateDetail = AGRenanggaranpenerimaandetT::model()->updateByPk($_POST['AGRenanggaranpenerimaandetT'][$i]['renanggaranpenerimaandet_id'],array('tglrenanggaranpen'=>$format->formatDateTimeForDb($_POST['AGRenanggaranpenerimaandetT'][$i]['tglrenanggaranpen']),'nilaipenerimaan'=>$_POST['AGRenanggaranpenerimaandetT'][$i]['nilaipenerimaan']));
										if ($updateDetail)
                                                                                    $this->approveUpdateTglDet &= true;
									}else if ($_POST['AGRenanggaranpenerimaandetT'][$i]['renanggaranpenerimaandet_id'] == 0){
										$updatePenerimaan = AGRenanggpenerimaanT::model()->updateByPk($renanggpenerimaan_id, array('approverenanggpen_id'=>$modApprove->approverenanggpen_id,'berapaxpenerimaan'=>$jumlahRow, 'nilaipenerimaananggaran'=>$nilaiPenerimaan, 'total_renanggaranpen'=>$nilaiPenerimaan));								
										if ($updatePenerimaan)
                                                                                    $this->approveUpdateId &= true;
										
                                                                                $modDet = new AGRenanggaranpenerimaandetT;
										$modDet->attributes = $postRencanaDet;
										$modDet->renanggpenerimaan_id = $model->renanggpenerimaan_id;
										$modDet->renanggaran_ke = $i+1;
										$modDet->nilaipenerimaan = $postRencanaDet['nilaipenerimaan'];
										$modDet->tglrenanggaranpen = $format->formatDateTimeForDb($postRencanaDet['tglrenanggaranpen']);
										
                                                                                // var_dump($modDet->attributes); die;
                                                                                
                                                                                if($modDet->save()) {
											$this->insertDetail &= true;
										} else {
											$this->insertDetail &= false;
										}
									}
						}
					}
				}
						if($this->approveBaru && $this->approveUpdateId || $this->insertDetail || $this->approveUpdateTglDet){
							$transaction->commit();
							$this->redirect(array('approval','renanggpenerimaan_id'=>$model->renanggpenerimaan_id,'approverenanggpen_id'=>$modApprove->approverenanggpen_id,'frame'=>1,'sukses'=>1));
						}else{
							$transaction->rollback();
							Yii::app()->user->setFlash('error',"Update Data Approve gagal disimpan !");
						}
			} catch (Exception $ex) {
				$transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Approve gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
			}
		}
		
		$this->render('_approval',array(
			'format'=>$format,
			'model'=>$model,
			'modDetail'=>$modDetail,
			'modDetails'=>$modDetails,
			'digit_str'=>$digit_str
		));
	}
	
    public function actionPrintApproval($approverenanggpen_id)
    {
		$format = new MyFormatter();
		$modPenerimaan = AGRenanggpenerimaanT::model()->findByAttributes(array('approverenanggpen_id'=>$approverenanggpen_id)); 
		$modDetails = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$modPenerimaan->renanggpenerimaan_id));
		$judulLaporan = 'Anggaran Penerimaan';
		$deskripsi = $modPenerimaan->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printApproval',array('format'=>$format,'modPenerimaan'=>$modPenerimaan,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
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
	
    public function actionAutocompleteProgramKerja()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(subkegiatanprogram_nama)', strtolower($_GET['term']), true);
            $criteria->order = 'subkegiatanprogram_nama';
            $criteria->limit = 5;
            $models = AGRekeninganggaranV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->subkegiatanprogram_nama;
                $returnVal[$i]['value'] = $model->subkegiatanprogram_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    	
    /**
    * menampilkan rencana anggaran pengeluaran detail
    * @return row table 
    */
    public function actionLoadFormTambahRencana()
    {
        if(Yii::app()->request->isAjaxRequest) { 
			$format = new MyFormatter;
			$modDetail = new AGRenanggaranpenerimaandetT;
			$hasil = 0;
            $nilaipenerimaananggaran = $_POST['nilaipenerimaananggaran'];
            $berapaxpenerimaan = $_POST['berapaxpenerimaan'];
			$termin = $berapaxpenerimaan;
			$hasil = $nilaipenerimaananggaran / $berapaxpenerimaan;
			$modDetail->nilaipenerimaan = $format->formatNumberForUser($hasil);
			$update = false;
			echo CJSON::encode(array(
                'form'=>$this->renderPartial('_rowTermin', array(
                        'format'=>$format,
                        'termin'=>$termin,
                        'hasil'=>$hasil,
                        'modDetail'=>$modDetail,
						'update'=>$update
                    ), 
                true))
            );
            exit;  
        }
    }  
	
    /**
    * menghapus rencana anggaran pengeluaran detail
    */
    public function actionHapusRencana()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $renanggaranpenerimaandet_id = $_POST['renanggaranpenerimaandet_id'];
			$modDetail = AGRenanggaranpenerimaandetT::model()->findByPk($renanggaranpenerimaandet_id);
			$model = AGRenanggpenerimaanT::model()->findByPk($modDetail->renanggpenerimaan_id);
			$model->nilaipenerimaananggaran = $model->nilaipenerimaananggaran - $modDetail->nilaipenerimaan;
			$model->berapaxpenerimaan = $model->berapaxpenerimaan - 1;
			$model->update();
			$deleteDetail = AGRenanggaranpenerimaandetT::model()->deleteByPk($renanggaranpenerimaandet_id);
			$details = AGRenanggaranpenerimaandetT::model()->findAllByAttributes(array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
				foreach($details as $i => $detail){
					$i++;
					$updateDetail = AGRenanggaranpenerimaandetT::model()->updateByPk($detail->renanggaranpenerimaandet_id,array('renanggaran_ke'=>$i));
				}
        }
    }  
	
    /**
    * menghapus rencana anggaran pengeluaran detail
    */
    public function actionBatalApprove()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $rencanggaranpengdet_id = $_POST['rencanggaranpengdet_id'];
            $apprrencanggaran_id = $_POST['apprrencanggaran_id'];
			$updateRencDetail = AGRencanggaranpengdetailT::model()->updateByPk($rencanggaranpengdet_id,array('apprrencanggaran_id'=>null));
			$deleteApprove = AGApprrencanggaranT::model()->deleteByPk($apprrencanggaran_id);
			$data['pesan'] = "sukses";
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
	
    /**
    * menghapus rencana anggaran pengeluaran detail
    */
    public function actionBatalRevisi()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $rencanggaranpengdet_id = $_POST['rencanggaranpengdet_id'];
            $apprrencanggaran_id = $_POST['apprrencanggaran_id'];
			
			$revisi_id = AGApprrencanggaranT::model()->findByPk($apprrencanggaran_id)->revisirencanggpeng_id;
			$updateRencDetail = AGRencanggaranpengdetailT::model()->updateByPk($rencanggaranpengdet_id,array('apprrencanggaran_id'=>null));
			$deleteApprove = AGApprrencanggaranT::model()->deleteByPk($apprrencanggaran_id);
			$deleteRevisi = AGRevisirencanggpengT::model()->deleteByPk($revisi_id);
			$data['pesan'] = "sukses";
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    } 
	
    /**
    * membatalkan approve
	* update rencanggaranpengdet_id di tabel rencanggaranpengdetail_t menjadi null
	* hapus apprrencanggaran_id di tabel apprrencanggaran_t
	* @param rencanggaranpengdet_id dan apprrencanggaran_id
    */
	public function actionHapusRencanaDetail(){
        if(Yii::app()->request->isAjaxRequest) {
            $data['pesan'] = "";
            $data['sukses'] = 0;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $updateRencanaDetail = RencanggaranpengdetailT::model()->findByPk($_POST['rencanggaranpengdet_id']);
                $updateRencanaDetail->apprrencanggaran_id = null;
                $updateRencanaDetail->update();
                $hapusApprrove = ApprrencanggaranT::model()->deleteByPk($_POST['apprrencanggaran_id']);
				if($hapusApprrove){
                    $transaction->commit();
                    $data['pesan'] = "Rencana Anggaran berhasil dihapus!";
                    $data['sukses'] = 1;
                }    
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['pesan'] = "Rencana Anggaran gagal dihapus! :".MyExceptionMessage::getMessage($exc,true);
            }
            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }   
}
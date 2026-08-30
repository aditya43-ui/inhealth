<?php

class InformasiRealisasiAnggaranPenerimaanController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	
	public function actionIndex()
	{
		$model = new AGRealisasianggpenerimaanT();
		if(isset($_GET['AGRealisasianggpenerimaanT'])){
			$model->attributes = $_GET['AGRealisasianggpenerimaanT'];
			$model->konfiganggaran_id = !empty($_GET['AGRealisasianggpenerimaanT']['konfiganggaran_id'])?$_GET['AGRealisasianggpenerimaanT']['konfiganggaran_id']:'';
			$model->sumberanggaran_id = !empty($_GET['AGRealisasianggpenerimaanT']['sumberanggaran_id'])?$_GET['AGRealisasianggpenerimaanT']['sumberanggaran_id']:'';
		}
		$this->render('index',array(
								'model'=>$model,
							));
	}
	
	public function actionRincian($norealisasianggpen)
	{
		$this->layout='//layouts/iframe';
		$criteria = new CDbCriteria;
		$criteria->addCondition("t.norealisasianggpen = '".$norealisasianggpen."'");
		$criteria->select = 'renanggpenerimaan_t.konfiganggaran_id,norealisasianggpen,sumberanggaran_id,nilaipenerimaan,realisasipenerimaan,tglrealisasianggpen,penerimaanke,
							renpen_tglmengetahui,renpen_tglmenyetujui,renpen_mengetahui_id,renpen_menyetujui_id';
		$criteria->join = 'JOIN renanggpenerimaan_t ON t.renanggpenerimaan_id = renanggpenerimaan_t.renanggpenerimaan_id';
		$model = AGRealisasianggpenerimaanT::model()->findAll($criteria);
        $judulLaporan = 'Realisasi Anggaran Penerimaan';
		$deskripsi = $model[0]->konfiganggaran->deskripsiperiode;
        $this->render('_rincian', array(
				'models'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi
		));
	}
	
	public function actionPrintRincian($norealisasianggpen)
    {
		
		$format = new MyFormatter();
		$criteria = new CDbCriteria;
		$criteria->addCondition("t.norealisasianggpen = '".$norealisasianggpen."'");
		$criteria->select = 'renanggpenerimaan_t.konfiganggaran_id,norealisasianggpen,sumberanggaran_id,nilaipenerimaan,realisasipenerimaan,tglrealisasianggpen,penerimaanke,
							renpen_tglmengetahui,renpen_tglmenyetujui,renpen_mengetahui_id,renpen_menyetujui_id';
		$criteria->join = 'JOIN renanggpenerimaan_t ON t.renanggpenerimaan_id = renanggpenerimaan_t.renanggpenerimaan_id';
		$model = AGRealisasianggpenerimaanT::model()->findAll($criteria);
		$judulLaporan = 'Rencana Anggaran Penerimaan';
		$deskripsi = $model[0]->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printRincian',array('format'=>$format,'models'=>$model,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printRincian',array('format'=>$format,'models'=>$model,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			////$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printRincian',array('format'=>$format,'models'=>$model,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
}
<?php

class InformasiRealisasiAnggaranPengeluaranController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	
	public function actionIndex()
	{
		$model = new AGRealisasianggpengT();
		if(isset($_GET['AGRealisasianggpengT'])){
			$model->attributes = $_GET['AGRealisasianggpengT'];
			$model->konfiganggaran_id = !empty($_GET['AGRealisasianggpengT']['konfiganggaran_id'])?$_GET['AGRealisasianggpengT']['konfiganggaran_id']:'';
			$model->sumberanggaran_id = !empty($_GET['AGRealisasianggpengT']['sumberanggaran_id'])?$_GET['AGRealisasianggpengT']['sumberanggaran_id']:'';
		}
		$this->render('index',array(
								'model'=>$model,
							));
	}
	
	public function actionRincian($unitkerja_id,$konfiganggaran_id)
	{
		$this->layout='//layouts/iframe';
		$criteria = new CDbCriteria;
		$criteria->addCondition("unitkerja_id = '".$unitkerja_id."'");
		$criteria->addCondition("konfiganggaran_id = '".$konfiganggaran_id."'");
		$model = AGRealisasianggpengT::model()->findAll($criteria);
        $judulLaporan = 'Realisasi Anggaran Pengeluaran';
		$deskripsi = $model[0]->konfiganggaran->deskripsiperiode;
        $this->render('_rincian', array(
				'models'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi
		));
	}
	
	public function actionPrintRincian($unitkerja_id,$konfiganggaran_id)
    {
		
		$criteria = new CDbCriteria;
		$criteria->addCondition("unitkerja_id = '".$unitkerja_id."'");
		$criteria->addCondition("konfiganggaran_id = '".$konfiganggaran_id."'");
		$model = AGRealisasianggpengT::model()->findAll($criteria);
		$judulLaporan = 'Realisasi Anggaran Pengeluaran';
		$deskripsi = $model[0]->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printRincian',array('models'=>$model,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printRincian',array('models'=>$model,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			////$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printRincian',array('models'=>$model,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
}
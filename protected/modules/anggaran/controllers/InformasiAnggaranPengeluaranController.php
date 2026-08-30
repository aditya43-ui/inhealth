<?php

class InformasiAnggaranPengeluaranController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	
	public function actionIndex()
	{
		$model = new AGRencanggaranpengT;
		$modDetail = new AGRencanggaranpengdetailT;
		
		if(isset($_GET['AGRencanggaranpengT'])){
			$model->attributes = $_GET['AGRencanggaranpengT'];
		}
		$this->render('index',array(
									'model'=>$model,
									'modDetail'=>$modDetail,
							));
	}
	
	public function actionRincian($rencanggaranpeng_id)
	{
		$this->layout='//layouts/iframe';
		$detail = array();
        $modPrograms = array();
		$format = new MyFormatter();
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);  
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id),'apprrencanggaran_id is not null');
		foreach ($modDetails as $i => $modDetail){
			$detail['tglrencanapengdet'][] = $modDetail->tglrencanapengdet;
			$detail['nilairencpengeluaran'][] = $modDetail->nilairencpengeluaran;
			$modSubKegiatans[$i] = AGRekeninganggaranV::model()->findAllByAttributes(array('subkegiatanprogram_id'=>$modDetail->subkegiatanprogram_id));
			foreach ($modSubKegiatans[$i] as $ii => $modSubKegiatan){
				$modPrograms['programkerja_kode'][] = $modSubKegiatan->programkerja_kode;
				$modPrograms['subprogramkerja_kode'][] = $modSubKegiatan->subprogramkerja_kode;
				$modPrograms['kegiatanprogram_kode'][] = $modSubKegiatan->kegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_kode'][] = $modSubKegiatan->subkegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_nama'][] = $modSubKegiatan->subkegiatanprogram_nama;
			}
		}
		
        $judulLaporan = 'Anggaran Pengeluaran';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $this->render('_rincian', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modPrograms'=>$modPrograms,
				'detail'=>$detail,
		));
		
	}
	
	public function actionPrintRincian($rencanggaranpeng_id)
    {
		$detail = array();
        $modPrograms = array();
		$format = new MyFormatter();
		$model = AGRencanggaranpengT::model()->findByPk($rencanggaranpeng_id);  
		$modDetails = AGRencanggaranpengdetailT::model()->findAllByAttributes(array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id),'apprrencanggaran_id is not null');
		foreach ($modDetails as $i => $modDetail){
			$detail['tglrencanapengdet'][] = $modDetail->tglrencanapengdet;
			$detail['nilairencpengeluaran'][] = $modDetail->nilairencpengeluaran;
			$modSubKegiatans[$i] = AGRekeninganggaranV::model()->findAllByAttributes(array('subkegiatanprogram_id'=>$modDetail->subkegiatanprogram_id));
			foreach ($modSubKegiatans[$i] as $ii => $modSubKegiatan){
				$modPrograms['programkerja_kode'][] = $modSubKegiatan->programkerja_kode;
				$modPrograms['subprogramkerja_kode'][] = $modSubKegiatan->subprogramkerja_kode;
				$modPrograms['kegiatanprogram_kode'][] = $modSubKegiatan->kegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_kode'][] = $modSubKegiatan->subkegiatanprogram_kode;
				$modPrograms['subkegiatanprogram_nama'][] = $modSubKegiatan->subkegiatanprogram_nama;
			}
		}
        $judulLaporan = 'Rencana Anggaran Pengeluaran';
		$deskripsi = $model->konfiganggaran->deskripsiperiode;
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render('printRincian',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render('printRincian',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			////$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('printRincian',array('format'=>$format,'model'=>$model,'modPrograms'=>$modPrograms,'detail'=>$detail,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
}
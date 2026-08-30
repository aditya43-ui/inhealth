<?php
Yii::import('gudangFarmasi.models.*');
class InformasiPermintaanPembelianController extends MyAuthController
{
	public $defaultAction ='index';
	public $path_view = 'pengadaan.views.informasiPermintaanPembelian.';
        public $path_permintaan = 'PermintaanPembelian';    
        public $path_penerimaan = 'PenerimaanBarang';
        
	public function actionIndex()
	{
		$model=new ADInformasipermintaanpembelianV;
		$format = new MyFormatter();
		$model->tgl_awal =date('Y-m-d');
		$model->tgl_akhir =date('Y-m-d');

		if(isset($_GET['ADInformasipermintaanpembelianV'])){
			$model->attributes=$_GET['ADInformasipermintaanpembelianV'];
			$model->tgl_awal  = $format->formatDateTimeForDb($_GET['ADInformasipermintaanpembelianV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADInformasipermintaanpembelianV']['tgl_akhir']);
		}
		$this->render($this->path_view.'index',array('format'=>$format,'model'=>$model));
	}
	
	public function actionMenyetujui($permintaanpembelian_id,$approve=false,$tolak=false)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = ADPermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));     
        $modDetails = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));
		if($approve){
			$update = ADPermintaanpembelianT::model()->updateByPk($permintaanpembelian_id,array('tglmenyetujui'=>date("Y-m-d")));
			if($update){
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('menyetujui','permintaanpembelian_id'=>$permintaanpembelian_id,'sukses'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
		if($tolak){
			$update = ADPermintaanpembelianT::model()->updateByPk($permintaanpembelian_id,array('statuspembelian'=>"DITOLAK"));
			if($update){
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('menyetujui','permintaanpembelian_id'=>$permintaanpembelian_id,'sukses'=>1,'ditolak'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
        $judulLaporan = 'Permintaan Pembelian';
		$deskripsi = '';
        $this->render($this->path_view.'_menyetujui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetails'=>$modDetails
		));
		
	}
	
	public function actionPrintMenyetujui($permintaanpembelian_id)
    {
		$format = new MyFormatter();
		$model = ADPermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));
		$modDetails = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));
		$judulLaporan = 'Permintaan Pembelian';
		$deskripsi = '';
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'printMenyetujui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'printMenyetujui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'printMenyetujui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
	public function actionMengetahui($permintaanpembelian_id,$approve=false)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = ADPermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));     
        $modDetails = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));
		if($approve){
			$update = ADPermintaanpembelianT::model()->updateByPk($permintaanpembelian_id,array('tglmengetahui'=>date("Y-m-d"),'statuspembelian'=>"DISETUJUI"));
			if($update){
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('mengetahui','permintaanpembelian_id'=>$permintaanpembelian_id,'sukses'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
        $judulLaporan = 'Permintaan Pembelian';
		$deskripsi = '';
        $this->render($this->path_view.'_mengetahui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetails'=>$modDetails
		));
	}
	
	public function actionPrintMengetahui($permintaanpembelian_id)
    {
		$format = new MyFormatter();
		$model = ADPermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));
		$modDetails = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));
		$judulLaporan = 'Permintaan Pembelian';
		$deskripsi = '';
        $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'printMengetahui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'printMengetahui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'printMengetahui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
	public function actionRincian($permintaanpembelian_id)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = ADPermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));     
        $modDetails = ADPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id'=>$permintaanpembelian_id));
        $judulLaporan = 'Permintaan Pembelian';
		$deskripsi = '';
        $this->render($this->path_view.'_rincian', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetails'=>$modDetails
		));
		
	}
        
}
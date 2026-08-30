<?php

class InformasiRencanaKebutuhanController extends MyAuthController
{
	public $defaultAction ='index';
        public $path_view = 'pengadaan.views.informasiRencanaKebutuhan.';
        public $path_permintaan = 'PermintaanPembelian';
        public $path_penawaran = 'PermintaanPenawaran';
        public $path_rencana = 'RencanaKebutuhan';

	public function actionIndex()
	{
		$model=new ADInformasirencanakebutuhanfarmasiV;
		$format = new MyFormatter();
		$model->tgl_awal =date('Y-m-d');
		$model->tgl_akhir =date('Y-m-d');

		if(isset($_GET['ADInformasirencanakebutuhanfarmasiV'])){
			$model->attributes=$_GET['ADInformasirencanakebutuhanfarmasiV'];
			$model->tgl_awal  = $format->formatDateTimeForDb($_GET['ADInformasirencanakebutuhanfarmasiV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADInformasirencanakebutuhanfarmasiV']['tgl_akhir']);
		}
		$this->render($this->path_view.'index',array('format'=>$format,'model'=>$model));
	}
        
	// Aksi untuk membatalkan rencana kebutuhan
	public function actionDelete()
	{
			//if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
			if(Yii::app()->request->isPostRequest)
			{
				$id = $_POST['id'];
				$transaction = Yii::app()->db->beginTransaction();
					 try {
							$detail=ADRencDetailkebT::model()->deleteAll('rencanakebfarmasi_id=:rencanakebfarmasi_id', array(':rencanakebfarmasi_id'=>$id));
							$model=ADRencanaKebFarmasiT::model()->deleteAll('rencanakebfarmasi_id=:rencanakebfarmasi_id', array(':rencanakebfarmasi_id'=>$id));
							$transaction->commit();
							if (Yii::app()->request->isAjaxRequest)
							{
								echo CJSON::encode(array(
									'status'=>'proses_form', 
									'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
									));
								exit;               
							}
							if(!isset($_GET['ajax']))
							$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
						} 
					catch (Exception $e)
						{
							$transaction->rollback();
							Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal dihapus.');
						}   

			}
			else
					throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
		
	public function actionMenyetujui($rencanakebfarmasi_id,$approve=false,$tolak=false)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = ADInformasirencanakebutuhanfarmasiV::model()->findByAttributes(array('rencanakebfarmasi_id'=>$rencanakebfarmasi_id));     
        $modDetails = ADRencDetailkebT::model()->findAllByAttributes(array('rencanakebfarmasi_id'=>$rencanakebfarmasi_id));
		if($approve){
			$update = ADRencanaKebFarmasiT::model()->updateByPk($rencanakebfarmasi_id,array('tglmenyetujui'=>date("Y-m-d"),'statusrencana'=>"DISETUJUI"));
			if($update){
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('menyetujui','rencanakebfarmasi_id'=>$rencanakebfarmasi_id,'sukses'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
		if($tolak){
			$update = ADRencanaKebFarmasiT::model()->updateByPk($rencanakebfarmasi_id,array('statusrencana'=>"DITOLAK"));
			if($update){
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('menyetujui','rencanakebfarmasi_id'=>$rencanakebfarmasi_id,'sukses'=>1,'ditolak'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
        $judulLaporan = 'Rencana Kebutuhan';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglperencanaan);
        $this->render($this->path_view.'_menyetujui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetails'=>$modDetails
		));
		
	}
	
	public function actionPrintMenyetujui($rencanakebfarmasi_id)
    {
		$format = new MyFormatter();
		$model = ADInformasirencanakebutuhanfarmasiV::model()->findByAttributes(array('rencanakebfarmasi_id'=>$rencanakebfarmasi_id));
		$modDetails = ADRencDetailkebT::model()->findAllByAttributes(array('rencanakebfarmasi_id'=>$rencanakebfarmasi_id));
		$judulLaporan = 'Rencana Kebutuhan';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglperencanaan);
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
			$mpdf = new MyPDF60('', $ukuranKertasPDF);
                       
                        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css'); 
                        $mpdf->WriteHTML($formatkonten, 1);
                        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
                        $mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'printMenyetujui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
	public function actionMengetahui($rencanakebfarmasi_id,$approve=false)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = ADInformasirencanakebutuhanfarmasiV::model()->findByAttributes(array('rencanakebfarmasi_id'=>$rencanakebfarmasi_id));     
        $modDetails = ADRencDetailkebT::model()->findAllByAttributes(array('rencanakebfarmasi_id'=>$rencanakebfarmasi_id));
		if($approve){
			$update = ADRencanaKebFarmasiT::model()->updateByPk($rencanakebfarmasi_id,array('tglmengetahui'=>date("Y-m-d")));
			if($update){
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('mengetahui','rencanakebfarmasi_id'=>$rencanakebfarmasi_id,'sukses'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
        $judulLaporan = 'Rencana Kebutuhan';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglperencanaan);
        $this->render($this->path_view.'_mengetahui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetails'=>$modDetails
		));
		
	}
	
	public function actionPrintMengetahui($rencanakebfarmasi_id)
    {
		$format = new MyFormatter();
		$model = ADInformasirencanakebutuhanfarmasiV::model()->findByAttributes(array('rencanakebfarmasi_id'=>$rencanakebfarmasi_id));
		$modDetails = ADRencDetailkebT::model()->findAllByAttributes(array('rencanakebfarmasi_id'=>$rencanakebfarmasi_id));
		$judulLaporan = 'Rencana Kebutuhan';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglperencanaan);
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
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
			//$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'printMengetahui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
	
	public function actionRincian($rencanakebfarmasi_id)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = ADInformasirencanakebutuhanfarmasiV::model()->findByAttributes(array('rencanakebfarmasi_id'=>$rencanakebfarmasi_id));     
        $modDetails = ADRencDetailkebT::model()->findAllByAttributes(array('rencanakebfarmasi_id'=>$rencanakebfarmasi_id));
        $judulLaporan = 'Rencana Kebutuhan';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglperencanaan);
        $this->render($this->path_view.'_rincian', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetails'=>$modDetails
		));
		
	}
        
}
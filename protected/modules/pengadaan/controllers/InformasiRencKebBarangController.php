<?php

class InformasiRencKebBarangController extends MyAuthController
{
        public $defaultAction ='index';
        public $path_view = 'pengadaan.views.informasiRencKebBarang.';
		public $controllerPembelian = 'pembelianbarangT';
        
        public function actionIndex($linkHalaman = null)
        {
            $model=new ADInformasirenkebbarangV;
            $format = new MyFormatter();
            $model->tgl_awal =date('Y-m-d');
            $model->tgl_akhir =date('Y-m-d');
            
            
            if(isset($_GET['ADInformasirenkebbarangV'])){
                $model->attributes=$_GET['ADInformasirenkebbarangV'];
                $model->tgl_awal  = $format->formatDateTimeForDb($_GET['ADInformasirenkebbarangV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADInformasirenkebbarangV']['tgl_akhir']);
            }
            $this->render($this->path_view.'index',array('format'=>$format,'model'=>$model));
        }
        
        // Aksi untuk membatalkan rencana kebutuhan Barang
        public function actionDelete()
        {
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                if(Yii::app()->request->isPostRequest)
                {
                    $id = $_POST['id'];
                    $transaction = Yii::app()->db->beginTransaction();
                         try {
                                $detail=ADRenkebbarangdetT::model()->deleteAll('renkebbarang_id=:renkebbarang_id', array(':renkebbarang_id'=>$id));
                                $model=  ADRenkebbarangT::model()->deleteAll('renkebbarang_id=:renkebbarang_id', array(':renkebbarang_id'=>$id));
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
		

	public function actionPrint($renkebbarang_id,$caraprint = null)
    {
       // $this->layout='//layouts/printWindows';
       // if (isset($_GET['frame'])){
         //   $this->layout='//layouts/iframe';
        //}elseif($caraprint=='EXCEL') {
          //  $this->layout='//layouts/printExcel';
        //}
        $this->layout='//layouts/iframe';
        $format = new MyFormatter;    
        $model = InformasirenkebbarangV::model()->findByAttributes(array('renkebbarang_id'=>$renkebbarang_id));
        $modRencanaKebBarang = ADRenkebbarangT::model()->findByPk($renkebbarang_id);     
        $criteria = new CDbCriteria();
        $criteria->addCondition('renkebbarang_id = '.$renkebbarang_id);		
        $modRencanaKebBarangDetail = ADRenkebbarangdetT::model()->findAll($criteria);

        $judul_print = 'Rencana Kebutuhan Barang';
            
        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judulLaporan'=>$judul_print,
			'modRencanaKebBarang'=>$modRencanaKebBarang,
			'modRencanaKebBarangDetail'=>$modRencanaKebBarangDetail,
			'caraPrint'=>$caraPrint,
                        'model'=>$model,
        ));
        }
        elseif($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
             $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judulLaporan'=>$judul_print,
			'modRencanaKebBarang'=>$modRencanaKebBarang,
			'modRencanaKebBarangDetail'=>$modRencanaKebBarangDetail,
			'caraPrint'=>$caraPrint,
                        'model'=>$model,
        ));
        }
        elseif($caraPrint=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('',$ukuranKertasPDF); 
//            //$mpdf->useOddEven = 2;  
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css'); 
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1); 
            $mpdf->AddPage($posisi,'','','','',15,15,15,30,15,15);
            $mpdf->WriteHTML( $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judulLaporan'=>$judul_print,
			'modRencanaKebBarang'=>$modRencanaKebBarang,
			'modRencanaKebBarangDetail'=>$modRencanaKebBarangDetail,
			'caraPrint'=>$caraPrint,
                        'model'=>$model,
        ),true));
            $mpdf->Output($judul_print.'_'.date('Y-m-d').'.pdf','I');
        }      
            
      
        
       
    }
	
	public function actionRincian($renkebbarang_id)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = ADInformasirenkebbarangV::model()->findByAttributes(array('renkebbarang_id'=>$renkebbarang_id));
                $modHead = ADRenkebbarangT::model()->findByPk($renkebbarang_id);		
                $modDetails = ADRenkebbarangdetT::model()->findAllByAttributes(array('renkebbarang_id'=>$renkebbarang_id));
                $judulLaporan = 'Rencana Kebutuhan Barang Umum';
                        $deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->renkebbarang_tgl);
                $this->render($this->path_view.'_rincian', array(
                                        'format'=>$format,
                                        'model'=>$model,
                                        'judulLaporan'=>$judulLaporan,
                                        'deskripsi'=>$deskripsi,
                                        'modHead'=>$modHead,
                                        'modDetails'=>$modDetails
                        ));
		
	}
    
    public function actionPrintInformasi($caraPrint) {
        $model=new ADInformasirenkebbarangV;
        $format = new MyFormatter();
        $model->tgl_awal =date('Y-m-d');
        $model->tgl_akhir =date('Y-m-d');


        if(isset($_GET['ADInformasirenkebbarangV'])){
            $model->attributes=$_GET['ADInformasirenkebbarangV'];
            $model->tgl_awal  = $format->formatDateTimeForDb($_GET['ADInformasirenkebbarangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADInformasirenkebbarangV']['tgl_akhir']);
        }
        
        $this->printFunction($model, $caraPrint, "Informasi Rencana Kebutuhan Barang", $this->path_view."printInformasi");
		
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
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css'); 
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
           
            
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        } else if ($caraPrint == "CSV") {
            CSV::konversiTabel($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
        }
    }
    
     public function actionApproveMenyetujui($renkebbarang_id,$approve=false,$tolak=false)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
                
                $model = ADRenkebbarangT::model()->findByAttributes(array('renkebbarang_id'=>$renkebbarang_id));     
        $modDetails = ADRenkebbarangdetT::model()->findAllByAttributes(array('renkebbarang_id'=>$renkebbarang_id));
                if($approve){
			$update = ADRenkebbarangT::model()->updateByPk($renkebbarang_id,array('tglmenyetujui'=>date("Y-m-d H:i:s")));
			if($update){
				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
				$this->redirect(array('ApproveMenyetujui','renkebbarang_id'=>$renkebbarang_id,'sukses'=>1));
			}else{
				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
			}
		}
        $judulLaporan = 'Rencana Kebutuhan Barang Umum';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($model->renkebbarang_tgl)));
        $this->render($this->path_view.'_menyetujui', array(
				'format'=>$format,
				'model'=>$model,
				'judulLaporan'=>$judulLaporan,
				'deskripsi'=>$deskripsi,
				'modDetails'=>$modDetails
		));
		
	}
        
        public function actionPrintApproveMenyetujui($renkebbarang_id)
    {
		$format = new MyFormatter();
                $model = ADRenkebbarangT::model()->findByAttributes(array('renkebbarang_id'=>$renkebbarang_id));     
        $modDetails = ADRenkebbarangdetT::model()->findAllByAttributes(array('renkebbarang_id'=>$renkebbarang_id));
                $judulLaporan = 'Rencana Kebutuhan Barang Umum';
		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->renkebbarang_tgl);
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
			$mpdf = new MyPDF60('',$ukuranKertasPDF); 
//			//$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'printMenyetujui',array('format'=>$format,'model'=>$model,'modDetails'=>$modDetails,'deskripsi'=>$deskripsi,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    }
}
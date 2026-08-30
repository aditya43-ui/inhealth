<?php

class InformasiPengisianSaldoAwalController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'billingKasir.views.informasiPengisianSaldoAwal.';
	public $path_view_T = 'billingKasir.views.pengisiansaldoawalT.';
        
	public function actionIndex()
	{
            $format = new MyFormatter();
            $model = new BKInformasipengisiansaldoawalV();
            $model->tgl_awal = date('Y-m-d');
            $model->tgl_akhir = date('Y-m-d');
            $model->unsetAttributes();  // clear any default values
                
            if(isset($_GET['BKInformasipengisiansaldoawalV'])){
                $model->attributes=$_GET['BKInformasipengisiansaldoawalV'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasipengisiansaldoawalV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasipengisiansaldoawalV']['tgl_akhir']);
            }   

            $this->render($this->path_view.'index',array(
                    'model'=>$model,'format'=>$format
            ));
	}
    
    public function actionUpdate($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
        $format = new MyFormatter();
        $model=$this->loadModel($id);
		$ruanganAsal = CHtml::listData(BKRuanganM::getRuanganItems(Yii::app()->user->getState('instalasi_id')),'ruangan_id','ruangan_nama');
        $model->update_time = date('Y-m-d H:i:s');
		$model->nilaisaldoawal = MyFormatter::formatNumberForUser($model->nilaisaldoawal,2);
        $profilrs = ProfilrumahsakitM::model()->findByPk($model->profilrs_id);
        $ruangan = RuanganM::model()->findByPk($model->ruangan_id);
        
		$model->nama_rumahsakit = $profilrs->nama_rumahsakit;
		$model->ruangan_nama = $ruangan->ruangan_nama;
		// $model->is_kirim = false;
		// Uncomment the following line if AJAX validation is needed
		

		if(isset($_POST['PengisiansaldoawalT']))
		{
            $model->attributes=$_POST['PengisiansaldoawalT'];
            $model->tglpengisiansaldo =  $format->formatDateTimeForDb($model->tglpengisiansaldo);
		    $model->nilaisaldoawal = MyFormatter::formatRupiahForDB($_POST['PengisiansaldoawalT']['nilaisaldoawal']);
            
			if($model->save()){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
				$this->redirect(array('index'));
                        }
		}

		$this->render($this->path_view.'_update',array(
			'model'=>$model,'ruanganAsal'=>$ruanganAsal,
		));
    }

    public function actionBatal($id){
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $model = PengisiansaldoawalT::model()->findByPk($id);
       
        if (empty($model)) {
            $model = new PengisiansaldoawalT;
        }

        if(isset($_POST['PengisiansaldoawalT'])) {
            $model->alasanpembatalan = $_POST['PengisiansaldoawalT']['alasanpembatalan'];
            $model->tglpembatalan = $format->formatDateTimeForDb($_POST['PengisiansaldoawalT']['tglpembatalan']);
            $model->pegawaibatal_id = $_POST['PengisiansaldoawalT']['pegawaibatal_id'];
            if($model->save()){
                Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                $this->redirect(array('Batal','id' => $id, 'sukses' => 1));
            }else{
                Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
            }
        }

        // if ($approve) {
        //     $update = PenggajianpegT::model()->updateByPk($penggajianpeg_id, array('tgl_mengetahui' => date("Y-m-d H:i:s")));
        //     if ($update) {
        //         Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        //         $this->redirect(array('ApproveMengetahui', 'penggajianpeg_id' => $penggajianpeg_id, 'sukses' => 1));
        //     } else {
        //         Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
        //     }
        // }
        $judulLaporan = 'Pembatalan Pengisian Saldo Awal';
        $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengisiansaldo);
        $this->render($this->path_view . '_batal', array(
            'format' => $format,
            // 'modelpegawai' => $modelpegawai,
            'model' => $model,
            // 'kom' => $kom,
            'judulLaporan' => $judulLaporan,
            // 'deskripsi' => $deskripsi,
//				'modDetailBeli'=>$modDetailBeli))
        ));
    }

    public function loadModel($id)
	{
		$model=PengisiansaldoawalT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
    }
    
    public function actionPrintRincian($pengisiansaldoawal_id=null){
        $this->layout = '//layouts/iframe';
        $data['judulLaporan'] = 'Rincian Pengisian Saldo Awal';
    //    var_dump($_POST['pengisiansaldoawal_id']);die;
       $pengisiansaldoawal_id = $_REQUEST['pengisiansaldoawal_id'];
        $model = PengisiansaldoawalT::model()->findByPk($pengisiansaldoawal_id);

        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('','A5'); 
        // $mpdf->useOddEven = 2;  
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet,1);  
        $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
        $mpdf->WriteHTML($this->render('_rincian',array('model'=>$model),true));
        $mpdf->Output();
       
    }
        
    public function actionPrint()
    {
       $format = new MyFormatter();
        $model = new BKInformasipembayarantagihannontunaiV();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['BKInformasipengisiansaldoawalV'])){
            $model->attributes=$_GET['BKInformasipengisiansaldoawalV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasipengisiansaldoawalV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasipengisiansaldoawalV']['tgl_akhir']);
        }   
        $data['judulLaporan']='Data Rincian Tagihan Pasien';
        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render('_print', array('model'=>$model,'caraPrint'=>$caraPrint));
            //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render('_print',array('model'=>$model,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('',$ukuranKertasPDF); 
            $mpdf->useOddEven = 2;  
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);  
            $style = '<style>.control-label{float:left; text-align: right; width:140px;font-size:12px; color:black;padding-right:10px;  }</style>';
            $mpdf->WriteHTML($style, 1);  
            $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
            $mpdf->WriteHTML($this->renderPartial('_print',array('model'=>$model,'caraPrint'=>$caraPrint),true));
            $mpdf->Output();
        }                       
    }
    
}

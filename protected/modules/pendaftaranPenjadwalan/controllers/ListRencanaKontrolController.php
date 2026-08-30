<?php

class ListRencanaKontrolController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'index';     
    
    public function actionIndex(){        
        $format = new MyFormatter;
        $model = new ARCustomModel;
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['ARCustomModel'])){
            $model->attributes = $_GET['ARCustomModel'];
            $model->tgl_awal = isset($_GET['ARCustomModel']['tgl_awal'])?$format->formatDateTimeForDb($_GET['ARCustomModel']['tgl_awal']):null;
            $model->tgl_akhir = isset($_GET['ARCustomModel']['tgl_akhir'])?$format->formatDateTimeForDb($_GET['ARCustomModel']['tgl_akhir']):null;            
            $model->berdasarkantgl = isset($_GET['ARCustomModel']['berdasarkantgl'])?$_GET['ARCustomModel']['berdasarkantgl']:null;            
            $model->jenissurat = isset($_GET['ARCustomModel']['jenissurat'])?$_GET['ARCustomModel']['jenissurat']:null;                        
        }                
        // echo CJSON::encode($model);die;
        if (isset($_GET['ajax'])){
            $ajax = $_GET['ajax'];
            
            if ($ajax == 'list-rencana-kontrol-grid')
                $path = '_table';
            
            $this->renderPartial($path,['model'=>$model]);
            exit;
        }else{        
            $this->render('index', array(
                'model' => $model,
            ));
        }
        
    }

    public function actionPrint() {
        $this->pageTitle = Yii::app()->name . " - Cetak Surat Eligibilitas Peserta";
//        $model = new ARSepT;
//        $model->attributes = $_REQUEST['ARSepT'];
        $format = new MyFormatter;
        // $model = new ARCustomModel;
        // $model->attributes = $_REQUEST['ARCustomModel'];
        // if(isset($_REQUEST['ARCustomModel'])){
        //     $model->attributes = $_REQUEST['ARCustomModel'];
        //     $model->tgl_awal = isset($_REQUEST['ARCustomModel']['tgl_awal']) ? $format->formatDateTimeForDb($_REQUEST['ARCustomModel']['tgl_awal']) : null;
        //     $model->tgl_akhir = isset($_REQUEST['ARCustomModel']['tgl_akhir']) ? $format->formatDateTimeForDb($_REQUEST['ARCustomModel']['tgl_akhir']) : null;
        // }
        $judulLaporan = 'Surat Rencana Kontrol';
        $judulLaporan2 = 'Surat Rencana Inap';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render('print', array('judulLaporan' => $judulLaporan, 'judulLaporan2' => $judulLaporan2, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }
    
}

<?php

class InformasiPemberianObatController extends MyAuthController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $path_view='farmasiApotek.views.informasiPemberianObat.';

    /**
     * Digunakan untuk load halaman informasi penilaian IKU
     */
    public function actionIndex(){       
        $model = new InformasipemberianobatV('searchInformasi');
        $model->unsetAttributes();
        $model->tgl_awal = date("d M Y");
        $model->tgl_akhir = date("d M Y");
        if (isset($_GET['InformasipemberianobatV'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['InformasipemberianobatV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['InformasipemberianobatV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasipemberianobatV']['tgl_akhir']);
        }

        $this->render($this->path_view.'index',array('model' => $model));
    }
    
    /**
     * Digunakan untuk cetak data
     */
    public function actionPrint(){
        $model = new InformasipemberianobatV('searchInformasi');
        $model->unsetAttributes();
        $model->tgl_awal = date("d M Y");
        $model->tgl_akhir = date("d M Y");
        if (isset($_GET['InformasipemberianobatV'])) {
            $format = new MyFormatter();
            $model->attributes = $_GET['InformasipemberianobatV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['InformasipemberianobatV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasipemberianobatV']['tgl_akhir']);
        }
        $judulLaporan='Data Remunerasi Kedisiplinan';
        $caraPrint = $_REQUEST['caraPrint'];

        if($caraPrint=='PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('',$ukuranKertasPDF); 
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);  
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> "", 'colspan'=>10),true));
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }
}

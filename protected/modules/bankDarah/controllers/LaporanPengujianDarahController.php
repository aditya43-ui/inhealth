<?php
/**
 * Digunakan sebagai Laporan Pengujian Darah
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @author  Yusuf Putra Anugrah <yusufputra@.com>
 * @author  Andyka Putra<andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 **/
class LaporanPengujianDarahController extends MyAuthController {
    
    public $path_view = 'bankDarah.views.laporanPengujianDarah.'; 
    
    /**
     * Fungsi load halaman laporan pengujian darah
     */
    public function actionIndex() {
        $model = new BDLaporanpengujiandarahV;
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        
        if (isset($_GET['BDLaporanpengujiandarahV'])) {
           
            $model->attributes = $_GET['BDLaporanpengujiandarahV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpengujiandarahV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpengujiandarahV']['tgl_akhir']);
        }
        
        $this->render('admin', array(
            'model' => $model
        ));
    }
    
    /**
     * Fungsi untuk mendapatkan laporan yang dicari
     */
    public function actionGetLaporan(){
        if (Yii::app()->request->isAjaxRequest){
            $modLaporan = BDLaporanpengujiandarahV::model()->findAll();
            $model=new PersonForm;
            
            $tr = $this->renderPartial('_detailLaporan', array('model'=>$modLaporan), true);
            echo json_encode($tr);
            Yii::app()->end();
        }
    }
    
    /**
     * Fungsi cetak data laporan pengujian darah
     */
    public function actionPrint()
    {

        $model= new BDLaporanpengujiandarahV();
        $model->attributes=$_REQUEST['BDLaporanpengujiandarahV'];

        $format=new MyFormatter();
        if(!empty($_REQUEST['BDLaporanpengujiandarahV']['tgl_awal']))
        {
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDLaporanpengujiandarahV']['tgl_awal']);
        }
        if(!empty($_REQUEST['BDLaporanpengujiandarahV']['tgl_awal']))
        {
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDLaporanpengujiandarahV']['tgl_akhir']);
        }
        $judulLaporan='Laporan Pengujian Konfirmasi Golongan Darah';
        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT')
        {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL')    
        {
            $this->layout='//layouts/printExcel';
            $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF')
        {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait                
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 20, 20, 20, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model' => $model,'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }                                                  
    }
    
    /**
     * Fungsi untuk menampilkan grafik
     */
    public function actionFrameGrafikPengujian() {
        $this->layout = '//layouts/iframe';

        $model = new BDLapseleksidonordarahV('searchGrafik');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pengujian Golongan Darah';
        $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

        if (isset($_GET['BDLapseleksidonordarahV'])) {
            $model->attributes = $_GET['BDLapseleksidonordarahV'];
            $model->jns_periode = $_GET['BDLapseleksidonordarahV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLapseleksidonordarahV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLapseleksidonordarahV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['BDLapseleksidonordarahV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['BDLapseleksidonordarahV']['bln_akhir']);
            $model->thn_awal = $_GET['BDLapseleksidonordarahV']['thn_awal'];
            $model->thn_akhir = $_GET['BDLapseleksidonordarahV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));

            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            //$model->is_gagalseleksi = isset($_GET['BDLapseleksidonordarahV']['is_gagalseleksi'])?$_GET['BDLapseleksidonordarahV']['is_gagalseleksi']:null;
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
}
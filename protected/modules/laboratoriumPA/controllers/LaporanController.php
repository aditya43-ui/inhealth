<?php

class LaporanController extends MyAuthController {
    
    public $path_view;
    
    public function actionLaporanSensusHarian() {
        $model = new LBLaporansensuslabV('search');
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        $jenis = CHtml::listData(JenispemeriksaanlabM::model()->findAll('jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_id');
        $model->jenispemeriksaanlab_id = $jenis;
        $kunjungan = LookupM::getItems('kunjungan');
        $model->kunjungan = $kunjungan;        
        if (isset($_GET['filter'])){
            $model->pilihan = $_GET['filter'];
        } else {
            $model->pilihan = null;
        }
        if (isset($_GET['LBLaporansensuslabV'])) {
            $model->attributes = $_GET['LBLaporansensuslabV'];
            $model->jns_periode = $_GET['LBLaporansensuslabV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporansensuslabV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporansensuslabV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporansensuslabV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporansensuslabV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporansensuslabV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporansensuslabV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }

        $this->render('sensus/index', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporanSensusHarian() {
        $model = new LBLaporansensuslabV('search');
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Sensus Harian Laboratorium';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = $_REQUEST['type'];
        $model->pilihan = $_GET['filter'];
        if (isset($_REQUEST['LBLaporansensuslabV'])) {
            $model->attributes = $_REQUEST['LBLaporansensuslabV'];
            $model->jns_periode = $_GET['LBLaporansensuslabV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporansensuslabV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporansensuslabV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporansensuslabV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporansensuslabV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporansensuslabV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporansensuslabV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'sensus/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikSensusHarian() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporansensuslabV('search');
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        $model->pilihan = isset($_GET['filter'])?$_GET['filter']:null;
        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['LBLaporansensuslabV'])) {
            $model->attributes = $_GET['LBLaporansensuslabV'];
            $model->jns_periode = $_GET['LBLaporansensuslabV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporansensuslabV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporansensuslabV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporansensuslabV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporansensuslabV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporansensuslabV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporansensuslabV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

    public function actionLaporanKunjungan() {
        $model = new LBLaporanpasienpenunjangV('search');
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
       // $model->kunjungan = LookupM::getItems('kunjungan');
        
        if (isset($_GET['LBLaporanpasienpenunjangV'])) {
            $model->attributes = $_GET['LBLaporanpasienpenunjangV'];
            $model->jns_periode = $_GET['LBLaporanpasienpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpasienpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpasienpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpasienpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpasienpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpasienpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpasienpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }

        $this->render('kunjungan/index', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporanKunjungan() {
        $model = new LBLaporanpasienpenunjangV('search');
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Kunjungan Laboratorium';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Kunjungan Laboratorium';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['LBLaporanpasienpenunjangV'])) {
            $model->attributes = $_REQUEST['LBLaporanpasienpenunjangV'];
            $model->jns_periode = $_GET['LBLaporanpasienpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpasienpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpasienpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpasienpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpasienpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpasienpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpasienpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'kunjungan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikKunjungan() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporanpasienpenunjangV('search');
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Kunjungan Pasien';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['LBLaporanpasienpenunjangV'])) {
            $model->attributes = $_GET['LBLaporanpasienpenunjangV'];
            $model->jns_periode = $_GET['LBLaporanpasienpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpasienpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpasienpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpasienpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpasienpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpasienpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpasienpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporan10BesarPenyakit() {
        $model = new LBLaporan10besarpenyakit('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');                
        $model->jumlahTampil = 10;
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');        

        if (isset($_GET['LBLaporan10besarpenyakit'])) {
            $model->attributes = $_GET['LBLaporan10besarpenyakit'];
            $model->jns_periode = $_GET['LBLaporan10besarpenyakit']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporan10besarpenyakit']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporan10besarpenyakit']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporan10besarpenyakit']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporan10besarpenyakit']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporan10besarpenyakit']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');  
        }

        $this->render('10Besar/index', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporan10BesarPenyakit() {
        $model = new LBLaporan10besarpenyakit('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');  
        $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Laboratorium';

        //Data Grafik
        $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien Laboratorium';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['LBLaporan10besarpenyakit'])) {
            $model->attributes = $_REQUEST['LBLaporan10besarpenyakit'];
            $model->jns_periode = $_GET['LBLaporan10besarpenyakit']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporan10besarpenyakit']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporan10besarpenyakit']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporan10besarpenyakit']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');  
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = '10Besar/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafik10BesarPenyakit() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporan10besarpenyakit('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');  

        //Data Grafik
        $data['title'] = 'Grafik Laporan 10 Besar Penyakit Laboratorium';
        $data['type'] = $_GET['type'];
        if (isset($_GET['LBLaporan10besarpenyakit'])) {
            $model->attributes = $_GET['LBLaporan10besarpenyakit'];
            $model->jns_periode = $_GET['LBLaporan10besarpenyakit']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporan10besarpenyakit']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporan10besarpenyakit']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporan10besarpenyakit']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporan10besarpenyakit']['bln_akhir']);
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');  
        }
               
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanPemakaiObatAlkes()
    {
        $model = new LBLaporanpemakaiobatalkesruanganV;
        $format = new MyFormatter();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   
        $jenisObat =CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_id');
        $model->jenisobatalkes_id = $jenisObat;
        
        if(isset($_GET['LBLaporanpemakaiobatalkesruanganV']))
        {
            $model->attributes = $_GET['LBLaporanpemakaiobatalkesruanganV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['LBLaporanpemakaiobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpemakaiobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpemakaiobatalkesruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
        $this->render('pemakaiObatAlkes/index',array('model'=>$model));
    }

    public function actionPrintLaporanPemakaiObatAlkes() {
        $model = new LBLaporanpemakaiobatalkesruanganV('search');
        $format = new MyFormatter();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   
        $judulLaporan = 'Laporan Info Pemakai Obat Alkes Laboratorium';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Laboratorium';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['LBLaporanpemakaiobatalkesruanganV'])) {
            $model->attributes = $_REQUEST['LBLaporanpemakaiobatalkesruanganV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['LBLaporanpemakaiobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpemakaiobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpemakaiobatalkesruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pemakaiObatAlkes/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    

    public function actionFrameGrafikLaporanPemakaiObatAlkes() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporanpemakaiobatalkesruanganV('search');
        $format = new MyFormatter();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Laboratorium';
        $data['type'] = $_GET['type'];
        if (isset($_GET['LBLaporanpemakaiobatalkesruanganV'])) {
            $model->attributes = $_GET['LBLaporanpemakaiobatalkesruanganV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['LBLaporanpemakaiobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemakaiobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpemakaiobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpemakaiobatalkesruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanJasaInstalasi() {
        $model = new LBLaporanjasainstalasiV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');        
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $tindakan = array('LUNAS', 'BELUM LUNAS');
        
        $model->tindakansudahbayar_id = $tindakan;
        
        if (isset($_GET['LBLaporanjasainstalasiV'])) {
            $model->attributes = $_GET['LBLaporanjasainstalasiV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_REQUEST['LBLaporanjasainstalasiV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanjasainstalasiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanjasainstalasiV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanjasainstalasiV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanjasainstalasiV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanjasainstalasiV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanjasainstalasiV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->nama_pegawai = isset($_GET['LBLaporanjasainstalasiV']['nama_pegawai'])?$_GET['LBLaporanjasainstalasiV']['nama_pegawai']:null;
        }
		
        $this->render('jasaInstalasi/index', array(
            'model' => $model
        ));
    }

    public function actionPrintLaporanJasaInstalasi() {
        $model = new LBLaporanjasainstalasiV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');       
        $judulLaporan = 'Laporan Jasa Instalasi Laboratorium';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Instalasi';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['LBLaporanjasainstalasiV'])) {
            $model->attributes = $_REQUEST['LBLaporanjasainstalasiV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_REQUEST['LBLaporanjasainstalasiV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanjasainstalasiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanjasainstalasiV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanjasainstalasiV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanjasainstalasiV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanjasainstalasiV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanjasainstalasiV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->nama_pegawai = isset($_GET['LBLaporanjasainstalasiV']['nama_pegawai'])?$_GET['LBLaporanjasainstalasiV']['nama_pegawai']:null;
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'jasaInstalasi/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanJasaInstalasi() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporanjasainstalasiV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');       

        //Data Grafik
        $data['title'] = 'Grafik Laporan Jasa Instalasi';
        $data['type'] = $_GET['type'];
        if (isset($_GET['LBLaporanjasainstalasiV'])) {
            $model->attributes = $_GET['LBLaporanjasainstalasiV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_REQUEST['LBLaporanjasainstalasiV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanjasainstalasiV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanjasainstalasiV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanjasainstalasiV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanjasainstalasiV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanjasainstalasiV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanjasainstalasiV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->nama_pegawai = isset($_GET['LBLaporanjasainstalasiV']['nama_pegawai'])?$_GET['LBLaporanjasainstalasiV']['nama_pegawai']:null;
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanBiayaPelayanan() {
        $model = new LBLaporanbiayapelayananV('search');
        $format = new MyFormatter();        
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'),'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        //$model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
        //$model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
        if (isset($_GET['LBLaporanbiayapelayananV'])) {
            $model->attributes = $_GET['LBLaporanbiayapelayananV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['LBLaporanbiayapelayananV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanbiayapelayananV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanbiayapelayananV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanbiayapelayananV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanbiayapelayananV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanbiayapelayananV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanbiayapelayananV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        
        $this->render('biayaPelayanan/index', array(
            'model' => $model
        ));
    }

    public function actionPrintLaporanBiayaPelayanan() {
        $model = new LBLaporanbiayapelayananV('search');
        $format = new MyFormatter();        
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Biaya Pelayanan Laboratorium';
        $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'),'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        //Data Grafik        
        $data['title'] = 'Grafik Laporan Biaya Pelayanan Laboratorium';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['LBLaporanbiayapelayananV'])) {
            $model->attributes = $_REQUEST['LBLaporanbiayapelayananV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['LBLaporanbiayapelayananV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanbiayapelayananV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanbiayapelayananV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanbiayapelayananV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanbiayapelayananV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanbiayapelayananV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanbiayapelayananV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        // echo "<pre>"; print_r($model->attributes); exit();
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'biayaPelayanan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanBiayaPelayanan() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporanbiayapelayananV('search');
        $format = new MyFormatter();        
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        //Data Grafik
        $data['title'] = 'Grafik Laporan Biaya Pelayanan Laboratorium';
        $data['type'] = $_GET['type'];
        
        if (isset($_GET['LBLaporanbiayapelayananV'])) {
            $model->attributes = $_GET['LBLaporanbiayapelayananV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['LBLaporanbiayapelayananV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanbiayapelayananV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanbiayapelayananV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanbiayapelayananV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanbiayapelayananV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanbiayapelayananV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanbiayapelayananV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    /**
	 * ini digantikan oleh : laboratorium/Laporan/LaporanPendapatan
	 */
    public function actionLaporanPendapatanRuangan() {
        $model = new LBLaporanpendapatanruanganV('search');
        $model->tgl_awal = date('Y-m-d 00:00:00');
        $model->tgl_akhir = date('Y-m-d H:i:s');
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        if (isset($_GET['LBLaporanpendapatanruanganV'])) {
            $model->attributes = $_GET['LBLaporanpendapatanruanganV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_akhir']);
        }

        $this->render('pendapatanRuangan/index', array(
            'model' => $model, 'filter'=>$filter
        ));
    }

    public function actionPrintLaporanPendapatanRuangan() {
        $model = new LBLaporanpendapatanruanganV('search');
        $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Laboratorium';

        //Data Grafik        
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['LBLaporanpendapatanruanganV'])) {
            $model->attributes = $_REQUEST['LBLaporanpendapatanruanganV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBLaporanpendapatanruanganV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pendapatanRuangan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanPendapatanRuangan() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporanpendapatanruanganV('search');
        $model->tgl_awal = date('Y-m-d 00:00:00');
        $model->tgl_akhir = date('Y-m-d H:i:s');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = $_GET['type'];
        if (isset($_GET['LBLaporanpendapatanruanganV'])) {
            $model->attributes = $_GET['LBLaporanpendapatanruanganV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_akhir']);
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanBukuRegister() {
        $model = new LBBukuregisterpenunjangV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');

        if (isset($_GET['LBBukuregisterpenunjangV'])) {
            $model->attributes = $_GET['LBBukuregisterpenunjangV'];
            $model->jns_periode = $_GET['LBBukuregisterpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBBukuregisterpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBBukuregisterpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBBukuregisterpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBBukuregisterpenunjangV']['bln_akhir']);
			$model->thn_awal = $_GET['LBBukuregisterpenunjangV']['thn_awal'];
			$model->thn_akhir = $_GET['LBBukuregisterpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }

        $this->render('bukuRegister/index', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporanBukuRegister() {
        $model = new LBBukuregisterpenunjangV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Buku Register Pasien Laboratorium';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Buku Register Pasien Laboratorium';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['LBBukuregisterpenunjangV'])) {
            $model->attributes = $_REQUEST['LBBukuregisterpenunjangV'];
            $model->jns_periode = $_GET['LBBukuregisterpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBBukuregisterpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBBukuregisterpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBBukuregisterpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBBukuregisterpenunjangV']['bln_akhir']);
			$model->thn_awal = $_GET['LBBukuregisterpenunjangV']['thn_awal'];
			$model->thn_akhir = $_GET['LBBukuregisterpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'bukuRegister/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikBukuRegister() {
        $this->layout = '//layouts/iframe';
        $model = new LBBukuregisterpenunjangV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Buku Register Pasien Laboratorium';
        $data['type'] = $_GET['type'];
        if (isset($_GET['LBBukuregisterpenunjangV'])) {
            $model->attributes = $_GET['LBBukuregisterpenunjangV'];
            $model->jns_periode = $_GET['LBBukuregisterpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBBukuregisterpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBBukuregisterpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBBukuregisterpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBBukuregisterpenunjangV']['bln_akhir']);
			$model->thn_awal = $_GET['LBBukuregisterpenunjangV']['thn_awal'];
			$model->thn_akhir = $_GET['LBBukuregisterpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanCaraMasukPasien() {
        $model = new LBLaporancaramasukpenunjangV('search');        
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        
        $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_id');
        $model->asalrujukan_id = $asalrujukan;
        $ruanganasal = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'),'ruangan_id','ruangan_id');
        $model->ruanganasal_id = $ruanganasal;
        $model->pilihan = 'instalasi';
        
        if (isset($_GET['LBLaporancaramasukpenunjangV'])) {
            $model->attributes = $_GET['LBLaporancaramasukpenunjangV'];
            $model->jns_periode = $_GET['LBLaporancaramasukpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporancaramasukpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporancaramasukpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporancaramasukpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporancaramasukpenunjangV']['bln_akhir']);
			$model->thn_awal = $_GET['LBLaporancaramasukpenunjangV']['thn_awal'];
			$model->thn_akhir = $_GET['LBLaporancaramasukpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->asalrujukan_id = isset($_GET['LBLaporancaramasukpenunjangV']['asalrujukan_id'])?$_GET['LBLaporancaramasukpenunjangV']['asalrujukan_id']:null;
        }

        $this->render('caraMasuk/index', array(
            'model' => $model
        ));
    }

    public function actionPrintLaporanCaraMasukPasien() {
        $model = new LBLaporancaramasukpenunjangV('search');
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Cara Masuk Pasien Laboratorium';
        
        //Data Grafik
        $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
        $data['type'] = $_REQUEST['type'];
        
        if (isset($_REQUEST['LBLaporancaramasukpenunjangV'])) {
            $model->attributes = $_REQUEST['LBLaporancaramasukpenunjangV'];            
            $model->jns_periode = $_GET['LBLaporancaramasukpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporancaramasukpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporancaramasukpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporancaramasukpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporancaramasukpenunjangV']['bln_akhir']);
			$model->thn_awal = $_GET['LBLaporancaramasukpenunjangV']['thn_awal'];
			$model->thn_akhir = $_GET['LBLaporancaramasukpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->asalrujukan_id = isset($_GET['LBLaporancaramasukpenunjangV']['asalrujukan_id'])?$_GET['LBLaporancaramasukpenunjangV']['asalrujukan_id']:null;
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'caraMasuk/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanCaraMasukPasien() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporancaramasukpenunjangV('search');
        $format = new MyFormatter();        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
        $data['type'] = $_GET['type'];
        if (isset($_GET['LBLaporancaramasukpenunjangV'])) {
            $model->attributes = $_GET['LBLaporancaramasukpenunjangV'];
            $model->jns_periode = $_GET['LBLaporancaramasukpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporancaramasukpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporancaramasukpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporancaramasukpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporancaramasukpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporancaramasukpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporancaramasukpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->asalrujukan_id = isset($_GET['LBLaporancaramasukpenunjangV']['asalrujukan_id'])?$_GET['LBLaporancaramasukpenunjangV']['asalrujukan_id']:null;
        }

        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanPemeriksaanPenunjang() {
		$judulLaporan = 'Laporan <b>Pemeriksaan Laboratorium</b>';
        $model = new LBLaporanpemeriksaanpenunjangV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['LBLaporanpemeriksaanpenunjangV'])) {
            $model->attributes = $_GET['LBLaporanpemeriksaanpenunjangV'];
            $model->jns_periode = $_GET['LBLaporanpemeriksaanpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
//            $model->tgl_awal = $model->tgl_awal." 00:00:00";
//            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        
//        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
//        $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
//        $model->bln_awal = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_awal))));
//        $model->bln_akhir = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_akhir))));
        $this->render('pemeriksaanPenunjang/adminPemeriksaanPenunjang', array(
            'model' => $model,
            'judulLaporan' => $judulLaporan,
        ));
    }

    public function actionPrintLaporanPemeriksaanPenunjang() {
        $model = new LBLaporanpemeriksaanpenunjangV('search');
        $judulLaporan = 'Laporan Pemeriksaan Laboratorium';
//        $model->tgl_awal = $_REQUEST['LBLaporanpemeriksaanpenunjangV']['tgl_awal'];
//        $model->tgl_akhir = $_REQUEST['LBLaporanpemeriksaanpenunjangV']['tgl_akhir'];
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemeriksaan Penunjang';
        if (isset($_REQUEST['type'])){
            $data['type'] = $_REQUEST['type'];
        } else {
            $data['type'] = null;
        }
        if (isset($_REQUEST['LBLaporanpemeriksaanpenunjangV'])) {
            $model->attributes = $_REQUEST['LBLaporanpemeriksaanpenunjangV'];
            $format = new MyFormatter();
            $model->jns_periode = $_GET['LBLaporanpemeriksaanpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pemeriksaanPenunjang/_printPemeriksaanPenunjang';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPemeriksaanPenunjang() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporanpemeriksaanpenunjangV('search');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemeriksaan Penunjang';
        if (isset($_REQUEST['type'])){
            $data['type'] = $_REQUEST['type'];
        } else {
            $data['type'] = null;
        }
        if (isset($_GET['LBLaporanpemeriksaanpenunjangV'])) {
            $model->attributes = $_GET['LBLaporanpemeriksaanpenunjangV'];
            $format = new MyFormatter();
            $model->jns_periode = $_GET['LBLaporanpemeriksaanpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpemeriksaanpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    public function actionLaporanPemeriksaanRujukan() {
//        $model = new LBLaporanpemeriksaanrujukanV('search');
//        $modelRS = new LBLaporanpemeriksaanrujukanrsV('search');
//        $format = new MyFormatter();
//        $model->jns_periode = "hari";
//        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
//        $model->tgl_akhir = date('Y-m-d');
//        $model->bln_awal = date('Y-m', strtotime('first day of january'));
//        $model->bln_akhir = date('Y-m');
//        $model->thn_awal = date('Y');
//        $model->thn_akhir = date('Y');
//        if (isset($_GET['LBLaporanpemeriksaanrujukanV'])) {
//            $model->attributes = $_GET['LBLaporanpemeriksaanrujukanV'];
//            $model->jns_periode = $_GET['LBLaporanpemeriksaanrujukanV']['jns_periode'];
//            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanV']['tgl_awal']);
//            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanV']['tgl_akhir']);
//            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
//            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
//            switch($model->jns_periode){
//                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
//                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
//                default : null;
//            }
//            $model->tgl_awal = $model->tgl_awal." 00:00:00";
//            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
////            $model->no_pendaftaran = $_GET['LBLaporanpemeriksaanrujukanV']['no_pendaftaran'];
//            
//            $modelRS->attributes = $_GET['LBLaporanpemeriksaanrujukanV'];
//            $modelRS->jns_periode = $_GET['LBLaporanpemeriksaanrujukanV']['jns_periode'];
//            $modelRS->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanV']['tgl_awal']);
//            $modelRS->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanV']['tgl_akhir']);
//            $bln_akhir = $modelRS->bln_akhir."-".date("t",strtotime($modelRS->bln_akhir));
//            $thn_akhir = $modelRS->thn_akhir."-".date("m-t",strtotime($modelRS->thn_akhir."-12"));
//            switch($modelRS->jns_periode){
//                case 'bulan' : $modelRS->tgl_awal = $modelRS->bln_awal."-01"; $modelRS->tgl_akhir = $bln_akhir; break;
//                case 'tahun' : $modelRS->tgl_awal = $modelRS->thn_awal."-01-01"; $modelRS->tgl_akhir = $thn_akhir; break;
//                default : null;
//            }
//            $modelRS->tgl_awal = $modelRS->tgl_awal." 00:00:00";
//            $modelRS->tgl_akhir = $modelRS->tgl_akhir." 23:59:59";            
////            $modelRS->no_pendaftaran = $_GET['LBLaporanpemeriksaanrujukanV']['no_pendaftaran'];            
//        }
//        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
//        $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
//        $model->bln_awal = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_awal))));
//        $model->bln_akhir = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_akhir))));
        $this->render('pemeriksaanRujukan/adminPemeriksaanRujukan', array(
//            'model' => $model,
//            'modelRS'=>$modelRS,
        ));
    }
    
    public function actionLaporanPemeriksaanRujukanLuar() {
        $model = new LBLaporanpemeriksaanrujukanV('search');
        $modelRS = new LBLaporanpemeriksaanrujukanrsV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        if (isset($_GET['LBLaporanpemeriksaanrujukanV'])) {
            $model->attributes = $_GET['LBLaporanpemeriksaanrujukanV'];
            $model->jns_periode = $_GET['LBLaporanpemeriksaanrujukanV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpemeriksaanrujukanV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpemeriksaanrujukanV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
//            $model->tgl_awal = $model->tgl_awal." 00:00:00";
//            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";    
        }
        
        $this->layout = "//layouts/iframe";
        $this->render('pemeriksaanRujukan/_tablePemeriksaanRujukanLuar', array(
            'model' => $model,
            'modelRS'=>$modelRS,
        ));
    }
    
    public function actionLaporanPemeriksaanRujukanRS() {
        $modelRS = new LBLaporanpemeriksaanrujukanrsV('search');
        $format = new MyFormatter();
        $modelRS->jns_periode = "hari";
        $modelRS->tgl_awal = date('Y-m-d');
        $modelRS->tgl_akhir = date('Y-m-d');
        $modelRS->bln_awal = date('Y-m');
        $modelRS->bln_akhir = date('Y-m');
        $modelRS->thn_awal = date('Y');
        $modelRS->thn_akhir = date('Y');
        if (isset($_GET['LBLaporanpemeriksaanrujukanrsV'])) {
            $modelRS->attributes = $_GET['LBLaporanpemeriksaanrujukanrsV'];
            $modelRS->jns_periode = $_GET['LBLaporanpemeriksaanrujukanrsV']['jns_periode'];
            $modelRS->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['tgl_awal']);
            $modelRS->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['tgl_akhir']);
            $modelRS->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['bln_awal']);
            $modelRS->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['bln_akhir']);
            $modelRS->thn_awal = $_GET['LBLaporanpemeriksaanrujukanrsV']['thn_awal'];
            $modelRS->thn_akhir = $_GET['LBLaporanpemeriksaanrujukanrsV']['thn_akhir'];
            $bln_akhir = $modelRS->bln_akhir."-".date("t",strtotime($modelRS->bln_akhir));
            $thn_akhir = $modelRS->thn_akhir."-".date("m-t",strtotime($modelRS->thn_akhir."-12"));
            switch($modelRS->jns_periode){
                case 'bulan' : $modelRS->tgl_awal = $modelRS->bln_awal."-01"; $modelRS->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $modelRS->tgl_awal = $modelRS->thn_awal."-01-01"; $modelRS->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $modelRS->tgl_awal = $modelRS->tgl_awal." 00:00:00";
            $modelRS->tgl_akhir = $modelRS->tgl_akhir." 23:59:59";           
        }
        $modelRS->tgl_awal = $format->formatDateTimeForUser($modelRS->tgl_awal);
        $modelRS->tgl_akhir = $format->formatDateTimeForUser($modelRS->tgl_akhir);
        $modelRS->bln_awal = $format->formatMonthForUser(date('Y-m',(strtotime($modelRS->bln_awal))));
        $modelRS->bln_akhir = $format->formatMonthForUser(date('Y-m',(strtotime($modelRS->bln_akhir))));
        $this->layout = "//layouts/iframe";
        $this->render('pemeriksaanRujukan/_tablePemeriksaanRujukanRS', array(
            'modelRS'=>$modelRS
        ));
    }
    
    public function actionPrintLaporanPemeriksaanRujukanLuar() {
//        $model = LBLaporanpemeriksaanrujukanV::model()->findAll();
        $model = new LBLaporanpemeriksaanrujukanV('search');
        $modelRS = new LBLaporanpemeriksaanrujukanrsV('search');
        $judulLaporan = 'Laporan Pemeriksaan Rujukan Pasien Luar';
        $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan Pasien Luar';
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
  
        if (isset($_GET['type'])){
            $data['type'] = $_GET['type'];
        } else {
            $data['type'] = null;
        }
        
        
            if (isset($_REQUEST['LBLaporanpemeriksaanrujukanV'])) {
                $model->attributes = $_REQUEST['LBLaporanpemeriksaanrujukanV'];
                $model->jns_periode = $_GET['LBLaporanpemeriksaanrujukanV']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanV']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanV']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanV']['bln_akhir']);
                $model->thn_awal = $_GET['LBLaporanpemeriksaanrujukanV']['thn_awal'];
                $model->thn_akhir = $_GET['LBLaporanpemeriksaanrujukanV']['thn_akhir'];
                $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
                $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
                switch($model->jns_periode){
                    case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                    case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                    default : null;
                }
                $model->tgl_awal = $model->tgl_awal." 00:00:00";
                $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            }
        
        $tab = 'luar';
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pemeriksaanRujukan/_printPemeriksaanRujukan';
        
        $this->printFunctionRujukan($model, $modelRS, $data, $caraPrint, $judulLaporan, $target, $tab);
    }

    public function actionPrintLaporanPemeriksaanRujukanRS() {
//        $model = LBLaporanpemeriksaanrujukanV::model()->findAll();
        $modelRS = new LBLaporanpemeriksaanrujukanrsV('search');
        $judulLaporan = 'Laporan Pemeriksaan Rujukan Pasien RS';
        $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan Pasien RS';
        $format = new MyFormatter();
        $modelRS->jns_periode = "hari";
        $modelRS->tgl_awal = date('Y-m-d');
        $modelRS->tgl_akhir = date('Y-m-d');
        $modelRS->bln_awal = date('Y-m');
        $modelRS->bln_akhir = date('Y-m');
        $modelRS->thn_awal = date('Y');
        $modelRS->thn_akhir = date('Y');
        if (isset($_GET['type'])){
            $data['type'] = $_GET['type'];
        } else {
            $data['type'] = null;
        }
            if (isset($_REQUEST['LBLaporanpemeriksaanrujukanrsV'])) {
                $modelRS->attributes = $_REQUEST['LBLaporanpemeriksaanrujukanrsV'];
                $modelRS->jns_periode = $_GET['LBLaporanpemeriksaanrujukanrsV']['jns_periode'];
                $modelRS->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['tgl_awal']);
                $modelRS->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['tgl_akhir']);
                $modelRS->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['bln_awal']);
                $modelRS->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['bln_akhir']);
                $modelRS->thn_awal = $_GET['LBLaporanpemeriksaanrujukanrsV']['thn_awal'];
                $modelRS->thn_akhir = $_GET['LBLaporanpemeriksaanrujukanrsV']['thn_akhir'];
                $bln_akhir = $modelRS->bln_akhir."-".date("t",strtotime($modelRS->bln_akhir));
                $thn_akhir = $modelRS->thn_akhir."-".date("m-t",strtotime($modelRS->thn_akhir."-12"));
                switch($modelRS->jns_periode){
                    case 'bulan' : $modelRS->tgl_awal = $modelRS->bln_awal."-01"; $modelRS->tgl_akhir = $bln_akhir; break;
                    case 'tahun' : $modelRS->tgl_awal = $modelRS->thn_awal."-01-01"; $modelRS->tgl_akhir = $thn_akhir; break;
                    default : null;
                }
                $modelRS->tgl_awal = $modelRS->tgl_awal." 00:00:00";
                $modelRS->tgl_akhir = $modelRS->tgl_akhir." 23:59:59";
            }
       
        $tab = 'rs';       
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pemeriksaanRujukan/_printPemeriksaanRujukan';
        
        $this->printFunctionRujukanRS($model=null, $modelRS, $data, $caraPrint, $judulLaporan, $target, $tab);
    }
    
    public function actionPrintLaporanPemeriksaanRujukan() {
//        $model = LBLaporanpemeriksaanrujukanV::model()->findAll();
        $model = new LBLaporanpemeriksaanrujukanV('search');
        $modelRS = new LBLaporanpemeriksaanrujukanrsV('search');
        if($_GET['filter_tab'] == "luar"){
            
            $judulLaporan = 'Laporan Pemeriksaan Rujukan Pasien Luar';
            $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan Pasien Luar';
        }else if($_GET['filter_tab'] == "rs"){
            
             $judulLaporan = 'Laporan Pemeriksaan Rujukan Pasien RSJK';
             $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan Pasien RSJK';
        }
        if (isset($_GET['type'])){
            $data['type'] = $_GET['type'];
        } else {
            $data['type'] = null;
        }
            if (isset($_REQUEST['LBLaporanpemeriksaanrujukanV'])) {
                $model->attributes = $_REQUEST['LBLaporanpemeriksaanrujukanV'];
                $format = new MyFormatter();
                $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBLaporanpemeriksaanrujukanV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBLaporanpemeriksaanrujukanV']['tgl_akhir']);
//                $model->no_pendaftaran = $_REQUEST['LBLaporanpemeriksaanrujukanV']['no_pendaftaran'];

                $modelRS->attributes = $_REQUEST['LBLaporanpemeriksaanrujukanV'];
                $format = new MyFormatter();
                $modelRS->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBLaporanpemeriksaanrujukanV']['tgl_awal']);
                $modelRS->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBLaporanpemeriksaanrujukanV']['tgl_akhir']);
//                $modelRS->no_pendaftaran =$_REQUEST['LBLaporanpemeriksaanrujukanV']['no_pendaftaran'];
            }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pemeriksaanRujukan/_printPemeriksaanRujukan';
        
        $this->printFunctionRujukan($model,$modelRS, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPemeriksaanRujukan() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporanpemeriksaanrujukanV('search');
        $modelRS = new LBLaporanpemeriksaanrujukanrsV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        $modelRS->jns_periode = "hari";
        $modelRS->tgl_awal = date('Y-m-d');
        $modelRS->tgl_akhir = date('Y-m-d');
        $modelRS->bln_awal = date('Y-m');
        $modelRS->bln_akhir = date('Y-m');
        $modelRS->thn_awal = date('Y');
        $modelRS->thn_akhir = date('Y');
        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan';
        if (isset($_GET['type'])){
            $data['type'] = $_GET['type'];
        } else {
            $data['type'] = null;
        }
        
        if (isset($_GET['LBLaporanpemeriksaanrujukanV'])) {
            $model->attributes = $_GET['LBLaporanpemeriksaanrujukanV'];
            $format = new MyFormatter();
            $model->jns_periode = $_GET['LBLaporanpemeriksaanrujukanV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpemeriksaanrujukanV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpemeriksaanrujukanV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
//            $model->no_pendaftaran = $_GET['LBLaporanpemeriksaanrujukanV']['no_pendaftaran'];
            
          //  $modelRS->attributes = $_GET['LBLaporanpemeriksaanrujukanrsV'];
          //  $format = new MyFormatter();
           // $modelRS->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['tgl_awal']);
            //$modelRS->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['tgl_akhir']);
//            $modelRS->no_pendaftaran = $_GET['LBLaporanpemeriksaanrujukanV']['no_pendaftaran'];
        }
        
        if (isset($_GET['LBLaporanpemeriksaanrujukanrsV'])) {
            
            $modelRS->attributes = $_GET['LBLaporanpemeriksaanrujukanrsV'];
            $format = new MyFormatter();
            $modelRS->jns_periode = $_GET['LBLaporanpemeriksaanrujukanrsV']['jns_periode'];
            $modelRS->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['tgl_awal']);
            $modelRS->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['tgl_akhir']);
            $modelRS->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['bln_awal']);
            $modelRS->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaanrujukanrsV']['bln_akhir']);
            $modelRS->thn_awal = $_GET['LBLaporanpemeriksaanrujukanrsV']['thn_awal'];
            $modelRS->thn_akhir = $_GET['LBLaporanpemeriksaanrujukanrsV']['thn_akhir'];
            $bln_akhir = $modelRS->bln_akhir."-".date("t",strtotime($modelRS->bln_akhir));
            $thn_akhir = $modelRS->thn_akhir."-".date("m-t",strtotime($modelRS->thn_akhir."-12"));
            switch($modelRS->jns_periode){
                case 'bulan' : $modelRS->tgl_awal = $modelRS->bln_awal."-01"; $modelRS->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $modelRS->tgl_awal = $modelRS->thn_awal."-01-01"; $modelRS->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $modelRS->tgl_awal = $modelRS->tgl_awal." 00:00:00";
            $modelRS->tgl_akhir = $modelRS->tgl_akhir." 23:59:59";

        }
        
        if($_GET['id'] == "1r=laboratorium/laporan/LaporanPemeriksaanRujukanLuar"){
                $model = $model;
        }else if($_GET['id'] == "1r=laboratorium/laporan/LaporanPemeriksaanRujukanRS"){
                $model = $modelRS;
        }
        $this->render('_grafik', array(
//        $this->render('pemeriksaanRujukan/_grafik', array(
            'model' => $model,
//            'modelRS'=>$modelRS,
            'data' => $data,
        ));
    }
    
    
    public function actionLaporanPemeriksaanCaraBayar() {
        $model = new LBLaporanpemeriksaangroupV('search');
        $modelPerusahaan = new LBLaporanpemeriksaanp3V('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['LBLaporanpemeriksaangroupV'])) {
            $model->attributes = $_GET['LBLaporanpemeriksaangroupV'];
            $model->jns_periode = $_GET['LBLaporanpemeriksaangroupV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaangroupV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaangroupV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaangroupV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaangroupV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpemeriksaangroupV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpemeriksaangroupV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }

        $this->render('pemeriksaanCaraBayar/adminPemeriksaanCaraBayar', array(
            'model' => $model,
            'modelPerusahaan'=>$modelPerusahaan,
        ));
    }

    public function actionPrintLaporanPemeriksaanCaraBayar() {
        $model = new LBLaporanpemeriksaangroupV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $modelPerusahaan = new LBLaporanpemeriksaanp3V('search');
        $judulLaporan = 'Laporan Pemeriksaan Jenis Penjamin';
//        echo "<pre>";
//        print_r($_GET);exit;
         if($_GET['filter_tab'] == "pemeriksaan"){
            //$judulLaporan = 'LAPORAN PEMERIKSAAN GROUP BK';
            $judulLaporan = 'LAPORAN PEMERIKSAAN CARA BAYAR - PEMERIKSAAN';
            //$data['title'] = 'Grafik Laporan Pemeriksaan Group BK';
            $data['title'] = 'Grafik Laporan Pemeriksaan Jenis Penjamin - Pemeriksaan';
         }else if($_GET['filter_tab'] == "rincian"){           
             //$judulLaporan = 'LAPORAN PEMERIKSAAN KONTRAK P3';
             $judulLaporan = 'LAPORAN PEMERIKSAAN CARA BAYAR - RINCIAN';
             //$data['title'] = 'Grafik Laporan Pemeriksaan Kontrak P3';
             $data['title'] = 'Grafik Laporan Pemeriksaan Jenis Penjamin - Rincian';
         }
     
        if (isset($_GET['type'])){
            $data['type'] = $_GET['type'];
        } else {
            $data['type'] = null;
        }
        if (isset($_REQUEST['LBLaporanpemeriksaangroupV'])) {
            $model->attributes = $_REQUEST['LBLaporanpemeriksaangroupV'];
            $format = new MyFormatter();
            $model->jns_periode = $_GET['LBLaporanpemeriksaangroupV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaangroupV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaangroupV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaangroupV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaangroupV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpemeriksaangroupV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpemeriksaangroupV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
//            $model->carabayar_id = $_REQUEST['LBLaporanpemeriksaangroupV']['carabayar_id'];
            
            $modelPerusahaan->attributes = $_REQUEST['LBLaporanpemeriksaangroupV'];
            $format = new MyFormatter();
            $modelPerusahaan->jns_periode = $_GET['LBLaporanpemeriksaangroupV']['jns_periode'];
            $modelPerusahaan->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaangroupV']['tgl_awal']);
            $modelPerusahaan->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaangroupV']['tgl_akhir']);
            $modelPerusahaan->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaangroupV']['bln_awal']);
            $modelPerusahaan->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaangroupV']['bln_akhir']);
            $modelPerusahaan->thn_awal = $_GET['LBLaporanpemeriksaangroupV']['thn_awal'];
            $modelPerusahaan->thn_akhir = $_GET['LBLaporanpemeriksaangroupV']['thn_akhir'];
            $bln_akhir = $modelPerusahaan->bln_akhir."-".date("t",strtotime($modelPerusahaan->bln_akhir));
            $thn_akhir = $modelPerusahaan->thn_akhir."-".date("m-t",strtotime($modelPerusahaan->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $modelPerusahaan->tgl_awal = $modelPerusahaan->bln_awal."-01"; $modelPerusahaan->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $modelPerusahaan->tgl_awal = $modelPerusahaan->thn_awal."-01-01"; $modelPerusahaan->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $modelPerusahaan->tgl_awal = $modelPerusahaan->tgl_awal." 00:00:00";
            $modelPerusahaan->tgl_akhir = $modelPerusahaan->tgl_akhir." 23:59:59";
//            $modelPerusahaan->carabayar_id = $_REQUEST['LBLaporanpemeriksaangroupV']['carabayar_id'];
        }
               
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pemeriksaanCaraBayar/_printPemeriksaanCaraBayar';
        $this->printFunctionCaraBayar($model, $modelPerusahaan, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPemeriksaanCaraBayar() {
        $this->layout = '//layouts/iframe';
		$format = new MyFormatter();
        $model = new LBLaporanpemeriksaangroupV('search');
        $modelPerusahaan = new LBLaporanpemeriksaangroupV('search');
        //$modelPerusahaan = new LBLaporanpemeriksaanp3V('search');
        
        
        //Data Grafik
		if($_GET['filter_tab'] == "pemeriksaan"){
            
			//$data['title'] = 'Grafik Laporan Pemeriksaan Group BK';
                    $data['title'] = 'Grafik Laporan Pemeriksaan Jenis Penjamin - Pemeriksaan';
			if (isset($_GET['LBLaporanpemeriksaangroupV'])) {
				$model->attributes = $_GET['LBLaporanpemeriksaangroupV'];
				$format = new MyFormatter();
                                $model->jns_periode = $_GET['LBLaporanpemeriksaangroupV']['jns_periode'];
                                $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaangroupV']['tgl_awal']);
                                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaangroupV']['tgl_akhir']);
                                $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaangroupV']['bln_awal']);
                                $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaangroupV']['bln_akhir']);
                                $model->thn_awal = $_GET['LBLaporanpemeriksaangroupV']['thn_awal'];
                                $model->thn_akhir = $_GET['LBLaporanpemeriksaangroupV']['thn_akhir'];
                                $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
                                $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
                                switch($model->jns_periode){
                                    case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                                    case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                                    default : null;
                                }
                                $model->tgl_awal = $model->tgl_awal." 00:00:00";
                                $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
			}
        }elseif($_GET['filter_tab'] == "rincian"){
            
			//$data['title'] = 'Grafik Laporan Pemeriksaan Kontrak P3';
                        $data['title'] = 'Grafik Laporan Pemeriksaan Jenis Penjamin - Rincian';
			if (isset($_GET['LBLaporanpemeriksaangroupV'])) {
				$modelPerusahaan->attributes = $_GET['LBLaporanpemeriksaangroupV'];				
				$format = new MyFormatter();
                                $modelPerusahaan->jns_periode = $_GET['LBLaporanpemeriksaangroupV']['jns_periode'];
                                $modelPerusahaan->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaangroupV']['tgl_awal']);
                                $modelPerusahaan->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpemeriksaangroupV']['tgl_akhir']);
                                $modelPerusahaan->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpemeriksaangroupV']['bln_awal']);
                                $modelPerusahaan->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpemeriksaangroupV']['bln_akhir']);
                                $modelPerusahaan->thn_awal = $_GET['LBLaporanpemeriksaangroupV']['thn_awal'];
                                $modelPerusahaan->thn_akhir = $_GET['LBLaporanpemeriksaangroupV']['thn_akhir'];
                                $bln_akhir = $modelPerusahaan->bln_akhir."-".date("t",strtotime($modelPerusahaan->bln_akhir));
                                $thn_akhir = $modelPerusahaan->thn_akhir."-".date("m-t",strtotime($modelPerusahaan->thn_akhir."-12"));
                                switch($modelPerusahaan->jns_periode){
                                    case 'bulan' : $modelPerusahaan->tgl_awal = $modelPerusahaan->bln_awal."-01"; $modelPerusahaan->tgl_akhir = $bln_akhir; break;
                                    case 'tahun' : $modelPerusahaan->tgl_awal = $modelPerusahaan->thn_awal."-01-01"; $modelPerusahaan->tgl_akhir = $thn_akhir; break;
                                    default : null;
                                }
                                $modelPerusahaan->tgl_awal = $modelPerusahaan->tgl_awal." 00:00:00";
                                $modelPerusahaan->tgl_akhir = $modelPerusahaan->tgl_akhir." 23:59:59";
			}
        }
        
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        
        $this->render('pemeriksaanCaraBayar/_grafik', array(
            'model' => $model,
            'modelPerusahaan'=>$modelPerusahaan,
            'data' => $data,
        ));
    }
    
    public function actionLaporanPembayaranPemeriksaan() {
        $model = new LBLaporanpembayaranpenunjangV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['LBLaporanpembayaranpenunjangV']))
        {
            $model->attributes = $_GET['LBLaporanpembayaranpenunjangV'];
            $model->jns_periode = $_GET['LBLaporanpembayaranpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpembayaranpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpembayaranpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpembayaranpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpembayaranpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpembayaranpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpembayaranpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
			if(isset($_GET['LBLaporanpembayaranpenunjangV']['no_pendaftaran'])){$model->no_pendaftaran = $_GET['LBLaporanpembayaranpenunjangV']['no_pendaftaran'];}
        }
        
        $this->render('pembayaranPemeriksaan/adminPembayaranPemeriksaan', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporanPembayaranPemeriksaan() {
        $model = new LBLaporanpembayaranpenunjangV('search');
        $format = new MyFormatter();
        $judulLaporan = 'Laporan Pembayaran Pemeriksaan';
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        //Data Grafik
        $data['title'] = 'Grafik Laporan Pembayaran Pemeriksaan';
        if (isset($_REQUEST['type'])) {
            $data['type'] = $_REQUEST['type'];
        } else {
            $data['type'] = null;
        }
        if (isset($_REQUEST['LBLaporanpembayaranpenunjangV'])) {
            $model->attributes = $_REQUEST['LBLaporanpembayaranpenunjangV'];            
            $model->jns_periode = $_GET['LBLaporanpembayaranpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpembayaranpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpembayaranpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpembayaranpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpembayaranpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpembayaranpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpembayaranpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            if(isset($_GET['LBLaporanpembayaranpenunjangV']['no_pendaftaran'])){$model->no_pendaftaran = $_GET['LBLaporanpembayaranpenunjangV']['no_pendaftaran'];}
        }
        
       
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pembayaranPemeriksaan/_printPembayaranPemeriksaan';
		
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    /**
         * update nilai grafik garis dan speedo dari request ajax
         */
        public function actionUpdateGrafik(){
            if(Yii::app()->request->isAjaxRequest) {
                $model = new LBLaporanpembayaranpenunjangV();
                $format = new MyFormatter();
                if (isset($_POST['LBLaporanpembayaranpenunjangV'])) {
                    $model->attributes = $_POST['LBLaporanpembayaranpenunjangV'];
                    $model->tgl_awal = $format->formatDateTimeForDb($_POST['LBLaporanpembayaranpenunjangV']['tgl_awal'])." 00:00:00";
                    $model->tgl_akhir = $format->formatDateTimeForDb($_POST['LBLaporanpembayaranpenunjangV']['tgl_akhir'])." 23:59:59";
                }
                $index_garis = array();
                $result_garis = array();
                $periodeGrafik = $format->formatDateTimeId(date('Y-m-d',(strtotime($model->tgl_awal))))." s.d ".$format->formatDateTimeId(date('Y-m-d',(strtotime($model->tgl_akhir))));
                $return['title'] = "Grafik Laporan Jenis Pemeriksaan Radiologi <br> Periode: ".$periodeGrafik;
               
                $dataProviderGaris = $model->searchGrafik();
                $dataProviderSpeedo = $model->searchGrafik();
                $hasilGaris = $dataProviderGaris->getData(); 
                foreach ($hasilGaris as $i=>$v){
                    if(strlen($v['data']) > 2){
                        $index_garis[] = $format->formatDateTimeForUser($v['data']);
                    }else{
                        $index_garis[] = $format->getMonthUser((int)$v['data'])." ".$v['data_2'];
                    }
                    $result_garis[] = array($i+1,(int)$v['jumlah']);
                }
                $return['garis']['result'] = $result_garis;
                $return['garis']['index'] = $index_garis;
                $return['speedo']['result'] = (int)$dataProviderSpeedo->getTotalItemCount();

                echo json_encode($return);
                Yii::app()->end();
            }
        }
    
    public function actionFrameGrafikPembayaranPemeriksaan() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporanpembayaranpenunjangV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        //Data Grafik
        $data['title'] = 'Grafik Laporan Pembayaran Pemeriksaan';
        if (isset($_GET['type'])){
            $data['type'] = $_GET['type'];
        } else {
            $data['type'] = null;
        }
        
        if (isset($_GET['LBLaporanpembayaranpenunjangV'])) {
            $model->attributes = $_GET['LBLaporanpembayaranpenunjangV'];            
            $model->jns_periode = $_GET['LBLaporanpembayaranpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpembayaranpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpembayaranpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpembayaranpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpembayaranpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpembayaranpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpembayaranpenunjangV']['thn_akhir'];            
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            if(isset($_GET['LBLaporanpembayaranpenunjangV']['no_pendaftaran'])){$model->no_pendaftaran = $_GET['LBLaporanpembayaranpenunjangV']['no_pendaftaran'];}
        }
        //$model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
        //$model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
        //$model->bln_awal = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_awal))));
        //$model->bln_akhir = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_akhir))));
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
     // -- GANTI PERIODE LAPORAN -- //
    
    public function actionGantiPeriode()
        {
            if(Yii::app()->request->isAjaxRequest){
                $namaPeriode = $_POST['namaPeriode'];
                $month = date('m');
                $year = date('Y');
                $jumHari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                
                $bulan =  date ("Y-m-d", mktime (0,0,0,$month,$jumHari,$year)); 
                
                
                $lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
                $nextyear  = mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1);
                
                if($namaPeriode == "hari"){
                   $awal = MyFormatter::formatDateTimeForUser(date('Y-m-d 00:00:00'));
                   $akhir = MyFormatter::formatDateTimeForUser(date('Y-m-d 23:59:59'));
                }else if($namaPeriode == "bulan"){
                    $awal = MyFormatter::formatDateTimeForUser(date('Y-m-01 00:00:00'));
                    $akhir = MyFormatter::formatDateTimeForUser(date(''.$bulan.' 23:59:59'));
                }else if($namaPeriode == "tahun"){
                    $awal = MyFormatter::formatDateTimeForUser(date('Y-01-01 00:00:00'));
                    $akhir = MyFormatter::formatDateTimeForUser(date('Y-12-01 23:59:59'));
                }else{
                    $awal = MyFormatter::formatDateTimeForUser(date('Y-m-d 00:00:00'));
                    $akhir = MyFormatter::formatDateTimeForUser(date('Y-m-d 23:59:59'));
                }
                
                 $data['periodeawal']  = $awal;
                 $data['periodeakhir'] = $akhir;
                 $data['namaPeriode'] = $namaPeriode;
                 
                echo CJSON::encode($data);
                    Yii::app()->end();
            }
        }
    // -- END GANTI PERIODE LAPORAN -- //
    
    /*
     * Laporan Pasien DBD
     */
    
    public function actionLaporanPasienDBD() {
        $model = new LBLaporanpasienpenunjangV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        if (isset($_GET['LBLaporanpasienpenunjangV']))
        {
            $model->attributes = $_GET['LBLaporanpasienpenunjangV'];
            $model->jns_periode = $_REQUEST['LBLaporanpasienpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBLaporanpasienpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBLaporanpasienpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['LBLaporanpasienpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['LBLaporanpasienpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpasienpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpasienpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }
        
        $this->render('pasienDBD/index', array(
            'model' => $model,
        ));
    }

    public function actionPrintLaporanPasienDBD() {
        $model = new LBLaporanpasienpenunjangV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        $judulLaporan = 'Laporan Pasien DBD';
		$format = new MyFormatter();
        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien DBD';
		$data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
        if (isset($_REQUEST['LBLaporanpasienpenunjangV'])) {
            $model->attributes = $_GET['LBLaporanpasienpenunjangV'];
            $model->jns_periode = $_REQUEST['LBLaporanpasienpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBLaporanpasienpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBLaporanpasienpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['LBLaporanpasienpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['LBLaporanpasienpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpasienpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpasienpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }
       
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pasienDBD/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPasienDBD() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporanpasienpenunjangV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        //Data Grafik
        $data['title'] = 'Grafik Laporan Pasien DBD';
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        
        if (isset($_GET['LBLaporanpasienpenunjangV'])) {
            $model->attributes = $_GET['LBLaporanpasienpenunjangV'];
            $model->jns_periode = $_REQUEST['LBLaporanpasienpenunjangV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBLaporanpasienpenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBLaporanpasienpenunjangV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['LBLaporanpasienpenunjangV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['LBLaporanpasienpenunjangV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpasienpenunjangV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpasienpenunjangV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
            $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
        }
		
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    /*
     * end Laporan Pasien DBD
     */
    
    public function actionLaporanPendapatan() {
        $model = new LBLaporanpendapatanruanganV('search');
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
        $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
        if (isset($_GET['LBLaporanpendapatanruanganV'])) {
            $model->attributes = $_GET['LBLaporanpendapatanruanganV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_akhir']);
        }
        
        $this->render('pendapatan/index', array(
            'model' => $model
        ));
    }
    
    public function actionLaporanPendapatanRS() {
        $model = new LBLaporanpendapatanruanganV('search');
        $format = new MyFormatter();
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        
        if (isset($_GET['LBLaporanpendapatanruanganV'])) { 
            $model->attributes = $_GET['LBLaporanpendapatanruanganV'];
            $model->jns_periode = $_GET['LBLaporanpendapatanruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpendapatanruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpendapatanruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpendapatanruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpendapatanruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $this->layout = "//layouts/iframe";
        $this->render('pendapatan/_tableRS', array(
            'model' => $model
        ));
    }
    
    public function actionLaporanPendapatanRSLuar() {
        $model = new LBLaporanpendapatanruanganV('search');
        $format = new MyFormatter();
        $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
        $model->penjamin_id = $penjamin;
        $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
        $model->kelaspelayanan_id = $kelas;
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        if (isset($_GET['LBLaporanpendapatanruanganV'])) {
            $model->attributes = $_GET['LBLaporanpendapatanruanganV'];
            $model->jns_periode = $_GET['LBLaporanpendapatanruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpendapatanruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpendapatanruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpendapatanruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpendapatanruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $this->layout = "//layouts/iframe";
        $this->render('pendapatan/_tableRSLuar', array(
            'model' => $model
        ));
    }
    
    public function actionPrintLaporanPendapatanRS() {
        $model = new LBLaporanpendapatanruanganV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Pendapatan Ruangan Laboratorium dari RS';
        
        //Data Grafik        
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        if (isset($_REQUEST['type'])){
            $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        }
        if (isset($_REQUEST['LBLaporanpendapatanruanganV'])) { 
            $model->attributes = $_REQUEST['LBLaporanpendapatanruanganV'];
            $model->jns_periode = $_GET['LBLaporanpendapatanruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpendapatanruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpendapatanruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpendapatanruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpendapatanruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $tab = 'rs';
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pendapatan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab);
    }
    
    public function actionPrintLaporanPendapatanRSLuar() {
        $model = new LBLaporanpendapatanruanganV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');
        $judulLaporan = 'Laporan Pendapatan Ruangan Laboratorium dari Luar RS';
        
        //Data Grafik        
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        if (isset($_REQUEST['type'])){
            $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        }
        if (isset($_REQUEST['LBLaporanpendapatanruanganV'])) {
            $model->attributes = $_REQUEST['LBLaporanpendapatanruanganV'];
            $model->jns_periode = $_GET['LBLaporanpendapatanruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpendapatanruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpendapatanruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpendapatanruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpendapatanruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
        }
        $tab = 'luar';
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pendapatan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab);
    }

    public function actionPrintLaporanPendapatan() {
        $model = new LBLaporanpendapatanruanganV('search');
        if($_GET['filter_tab'] == "rs"){
            $judulLaporan = 'Laporan Pendapatan Ruangan Laboratorium dari RS';
        }else if($_GET['filter_tab'] == "luar"){
            $judulLaporan = 'Laporan Pendapatan Ruangan Laboratorium dari Luar RS';
        }else{
            $judulLaporan = 'Laporan Pendapatan Ruangan Laboratorium';
        }
        
        //Data Grafik        
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        if (isset($_REQUEST['LBLaporanpendapatanruanganV'])) {
            $model->attributes = $_REQUEST['LBLaporanpendapatanruanganV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LBLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LBLaporanpendapatanruanganV']['tgl_akhir']);
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pendapatan/_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikLaporanPendapatan() {
        $this->layout = '//layouts/iframe';
        $model = new LBLaporanpendapatanruanganV('search');
        $format = new MyFormatter();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
        $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
        if (isset($_GET['LBLaporanpendapatanruanganV'])) {
            $model->attributes = $_GET['LBLaporanpendapatanruanganV'];
            $model->jns_periode = $_GET['LBLaporanpendapatanruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLaporanpendapatanruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLaporanpendapatanruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLaporanpendapatanruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLaporanpendapatanruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLaporanpendapatanruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
                
        $this->render('pendapatan/_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    
    /*
     * end laporan pendapatan II
     */
    protected function printFunction($model,$data, $caraPrint, $judulLaporan, $target, $tab='rs'){
        $format = new MyFormatter();
        $periode = $periode = $format->formatDateTimeId($model->tgl_awal).' s/d '.$format->formatDateTimeId($model->tgl_akhir);
        
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows2';
            $this->render($target, array('model' => $model,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' =>$tab));    
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' =>$tab));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $footer = '<table width="100%"><tr>'
                    . '<td style = "text-align:left;font-size:8px;"><i><b>Generated By Ehealthsys</b></i></td>'
                    . '<td style = "text-align:right;font-size:8px;"><i><b>Print Count :</b></i></td>'
                    . '</tr></table>';
            $mpdf->SetHtmlFooter($footer,'E');
            $mpdf->SetHtmlFooter($footer,'O');
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' =>$tab), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }
    
    protected function printFunctionRujukan($model, $modelRS, $data, $caraPrint, $judulLaporan, $target, $tab=null){
        $format = new MyFormatter();
       // $periode = $this->parserTanggalRujukan($model->tgl_awal).' s/d '.$this->parserTanggalRujukan($model->tgl_akhir);
         $periode = $format->formatDateTimeForUser(date('Y-m-d', strtotime($model->tgl_awal))).' s/d '.$format->formatDateTimeForUser(date('Y-m-d', strtotime($model->tgl_akhir)));
         
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows2';
            $this->render($target, array('model' => $model, 'modelRS'=>$modelRS, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'modelRS'=>$modelRS,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $footer = '<table width="100%"><tr>'
                    . '<td style = "text-align:left;font-size:8px;"><i><b>Generated By Ehealthsys</b></i></td>'
                    . '<td style = "text-align:right;font-size:8px;"><i><b>Print Count :</b></i></td>'
                    . '</tr></table>';
            $mpdf->SetHtmlFooter($footer,'E');
            $mpdf->SetHtmlFooter($footer,'O');
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'modelRS'=>$modelRS,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }
    
    protected function printFunctionRujukanRS($model, $modelRS, $data, $caraPrint, $judulLaporan, $target, $tab=null){
        $format = new MyFormatter();
        $periode = $periode = $format->formatDateTimeId($modelRS->tgl_awal).' s/d '.$format->formatDateTimeId($modelRS->tgl_akhir);
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $modelRS, 'modelRS'=>$modelRS, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $modelRS, 'modelRS'=>$modelRS,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'modelRS'=>$modelRS,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab), true));
            $mpdf->Output();
        }
    }
    
     protected function printFunctionCaraBayar($model, $modelPerusahaan, $data, $caraPrint, $judulLaporan, $target){
        $format = new MyFormatter();
        $periode = $periode = $format->formatDateTimeId($model->tgl_awal).' s/d '.$format->formatDateTimeId($model->tgl_akhir);
        
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model,'modelPerusahaan'=>$modelPerusahaan,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model,'modelPerusahaan'=>$modelPerusahaan,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->useOddEven = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'modelPerusahaan'=>$modelPerusahaan,'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'_'.date('Y-m-d').'.pdf','I');
        }
    }
    
    protected function parserTanggalRujukan($tgl){
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row){
        if (!empty($row)){
            $result[] = $row;
        }
    }
    return $result[0].' '.$result[1].' '.$result[2];
  
    }
    
    protected function parserTanggal($tgl){
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row){
        if (!empty($row)){
            $result[] = $row;
        }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'),'medium',null).' '.$result[1];
  
    }
	
	/**
	* set dropdown penjamin pasien dari carabayar_id
	* @param type $encode
	* @param type $namaModel
	*/
	public function actionSetDropdownPenjaminPasien($encode=false,$namaModel='')
	{
		if(Yii::app()->request->isAjaxRequest) {
		   $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
		  if($encode)
		  {
			   echo CJSON::encode($penjamin);
		  } else {
			   if(empty($carabayar_id)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   } else {
				   $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
				   if(count($penjamin) > 1)
				   {
					   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   }
				   $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
				   foreach($penjamin as $value=>$name) {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		  }
		}
		Yii::app()->end();
	}
	
	public function actionGetPenjaminPasienForCheckBox($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

           if($encode) {
                echo CJSON::encode($penjamin);
           } else {
                if(empty($carabayar_id)){
//                    $penjamin = PenjaminpasienM::model()->findAll();
                    echo '<label>Data Tidak Ditemukan</label>';
                } else {
                    $penjamindata = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
                    $penjamin = CHtml::listData($penjamindata,'penjamin_id','penjamin_nama');
                    echo CHtml::hiddenField(''.$namaModel.'[penjamin_id]');
                    echo "<div style='margin-left:0px;'>".CHtml::checkBox('checkAllCaraBayar',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                            'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'))." Pilih Semua";
                    echo "</div><br/>";
                    $i = 0;
                    if (count($penjamin) > 0){
                        foreach($penjamin as $value=>$name) {
                            $selects[] = $value;
							$i++;
                        }
						echo CHtml::checkBoxList(''.$namaModel."[penjamin_id]", $selects, $penjamin);
                    } else{
                        echo '<label>Data Tidak Ditemukan</label>';
                    }
                }
           }
        }
        Yii::app()->end();
    }

    public function actionRujukanKeluarLaboratorium() {
        $model = new LBInformasirujukanpenunjangkeluarV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   
        $this->path_view = 'laboratorium.views.laporan.rujukanKeluarLaboratorium.';

        if (isset($_GET['LBInformasirujukanpenunjangkeluarV'])) {
            $model->attributes = $_GET['LBInformasirujukanpenunjangkeluarV'];
            $model->jns_periode = $_GET['LBInformasirujukanpenunjangkeluarV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBInformasirujukanpenunjangkeluarV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBInformasirujukanpenunjangkeluarV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBInformasirujukanpenunjangkeluarV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBInformasirujukanpenunjangkeluarV']['bln_akhir']);
            $model->thn_awal = $_GET['LBInformasirujukanpenunjangkeluarV']['thn_awal'];
            $model->thn_akhir = $_GET['LBInformasirujukanpenunjangkeluarV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";            
        }

        $this->render($this->path_view.'index', array(
            'model' => $model,
        ));
    }

    public function actionPrintRujukanKeluarLaboratorium() {
        $model = new LBInformasirujukanpenunjangkeluarV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');        
        $judulLaporan = 'Laporan Rujukan Keluar Laboratorium';
        $this->path_view = 'laboratorium.views.laporan.rujukanKeluarLaboratorium.';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Rujukan Keluar Laboratorium';
        $data['type'] = $_REQUEST['type'];
         if (isset($_GET['LBInformasirujukanpenunjangkeluarV'])) {
            $model->attributes = $_GET['LBInformasirujukanpenunjangkeluarV'];
            $model->jns_periode = $_GET['LBInformasirujukanpenunjangkeluarV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBInformasirujukanpenunjangkeluarV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBInformasirujukanpenunjangkeluarV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBInformasirujukanpenunjangkeluarV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBInformasirujukanpenunjangkeluarV']['bln_akhir']);
            $model->thn_awal = $_GET['LBInformasirujukanpenunjangkeluarV']['thn_awal'];
            $model->thn_akhir = $_GET['LBInformasirujukanpenunjangkeluarV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";            
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikRujukanKeluarLaboratorium() {
        $this->layout = '//layouts/iframe';
        $model = new LBInformasirujukanpenunjangkeluarV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');        
        $this->path_view = 'laboratoriumPA.views.laporan.rujukanKeluarLaboratorium.';
        //Data Grafik
        $data['title'] = 'Grafik Laporan Rujukan Keluar Laboratorium';
        $data['type'] = $_GET['type'];
         if (isset($_GET['LBInformasirujukanpenunjangkeluarV'])) {
            $model->attributes = $_GET['LBInformasirujukanpenunjangkeluarV'];
            $model->jns_periode = $_GET['LBInformasirujukanpenunjangkeluarV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBInformasirujukanpenunjangkeluarV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBInformasirujukanpenunjangkeluarV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBInformasirujukanpenunjangkeluarV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBInformasirujukanpenunjangkeluarV']['bln_akhir']);
            $model->thn_awal = $_GET['LBInformasirujukanpenunjangkeluarV']['thn_awal'];
            $model->thn_akhir = $_GET['LBInformasirujukanpenunjangkeluarV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";            
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
	
	public function actionPemeriksaanRujukanRS() {
        $model = new LBLappemeriksaanrujukanrsV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   
        $this->path_view = 'laboratoriumPA.views.laporan.pemeriksaanRujukanRs.';

        if (isset($_GET['LBLappemeriksaanrujukanrsV'])) {
            $model->attributes = $_GET['LBLappemeriksaanrujukanrsV'];
            $model->jns_periode = $_GET['LBLappemeriksaanrujukanrsV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLappemeriksaanrujukanrsV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLappemeriksaanrujukanrsV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLappemeriksaanrujukanrsV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLappemeriksaanrujukanrsV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLappemeriksaanrujukanrsV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLappemeriksaanrujukanrsV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";            
        }

        $this->render($this->path_view.'index', array(
            'model' => $model,
        ));
    }

    public function actionPrintPemeriksaanRujukanRS() {
        $model = new LBLappemeriksaanrujukanrsV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');        
        $judulLaporan = 'Laporan Pemeriksaan Rujukan RS';
        $this->path_view = 'laboratoriumPA.views.laporan.pemeriksaanRujukanRs.';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan RS';
        $data['type'] = $_REQUEST['type'];
         if (isset($_GET['LBLappemeriksaanrujukanrsV'])) {
            $model->attributes = $_GET['LBLappemeriksaanrujukanrsV'];
            $model->jns_periode = $_GET['LBLappemeriksaanrujukanrsV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLappemeriksaanrujukanrsV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLappemeriksaanrujukanrsV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLappemeriksaanrujukanrsV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLappemeriksaanrujukanrsV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLappemeriksaanrujukanrsV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLappemeriksaanrujukanrsV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";            
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view.'_print';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionFrameGrafikPemeriksaanRujukanRS() {
        $this->layout = '//layouts/iframe';
        $model = new LBLappemeriksaanrujukanrsV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');        
        $this->path_view = 'laboratoriumPA.views.laporan.pemeriksaanRujukanRs.';
        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemeriksaan Rujukan RS';
        $data['type'] = $_GET['type'];
         if (isset($_GET['LBLappemeriksaanrujukanrsV'])) {
            $model->attributes = $_GET['LBLappemeriksaanrujukanrsV'];
            $model->jns_periode = $_GET['LBLappemeriksaanrujukanrsV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBLappemeriksaanrujukanrsV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBLappemeriksaanrujukanrsV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['LBLappemeriksaanrujukanrsV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['LBLappemeriksaanrujukanrsV']['bln_akhir']);
            $model->thn_awal = $_GET['LBLappemeriksaanrujukanrsV']['thn_awal'];
            $model->thn_akhir = $_GET['LBLappemeriksaanrujukanrsV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal." 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";            
        }
        
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }

}
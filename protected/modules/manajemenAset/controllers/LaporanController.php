<?php

class LaporanController extends MyAuthController {

    public $path_view = 'manajemenAset.views.laporan.';

    public function actionLaporanPenyusutanAset() {
        $model = new MALaporanpenyusutanasetV();
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        if (isset($_GET['MALaporanpenyusutanasetV'])) {
            $model->attributes = $_GET['MALaporanpenyusutanasetV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['MALaporanpenyusutanasetV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MALaporanpenyusutanasetV']['tgl_akhir']);
        }
        if (Yii::app()->request->isAjaxRequest) {
            $modPenyusutans = $model->getPenyusutan();
            echo $this->renderPartial($this->path_view . 'penyusutanAset._table', array('model' => $model, 'modPenyusutans' => $modPenyusutans), true);
        } else {
            $this->render($this->path_view . 'penyusutanAset/admin', array('model' => $model,));
        }
    }

    public function actionLaporanReevaluasiAset() {
        $this->pageTitle = Yii::app()->name . " - Laporan Re-evaluasi Aset";
        $model = new MALaporanreevaluasiasetV('Search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');


        if (isset($_GET['MALaporanreevaluasiasetV'])) {
            $model->attributes = $_GET['MALaporanreevaluasiasetV'];
            $model->tgl_awal = $format->formatDateTimeForUser($_GET['MALaporanreevaluasiasetV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForUser($_GET['MALaporanreevaluasiasetV']['tgl_akhir']);

            $model->tgl_awal = $model->tgl_awal . " 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
        }

        $this->render($this->path_view . 'reevaluasiAset/index', array(
            'model' => $model, 'format' => $format
        ));
    }

    public function actionPrintReevaluasi() {
        $model = new MALaporanreevaluasiasetV('search');
        $format = new MyFormatter();
        $model->unsetAttributes();
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $judulLaporan = 'Laporan Re-Evaluasi Aset';

        //Data Grafik
        $data['title'] = 'Grafik Laporan Indikator Dokter';
        $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
        if (isset($_REQUEST['MALaporanreevaluasiasetV'])) {
            $model->attributes = $_GET['MALaporanreevaluasiasetV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['MALaporanreevaluasiasetV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MALaporanreevaluasiasetV']['tgl_akhir']);
            $model->tgl_awal = $model->tgl_awal . " 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
        }

        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view . 'reevaluasiAset/_printReevaluasi';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }

    public function actionPrintLaporanPenyusutanAset() {

        $model = new MALaporanpenyusutanasetV();
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        $judulLaporan = 'Laporan Penyusutan Aset';
        //Data Grafik
        $data['title'] = 'Grafik Laporan Sensus Harian';
        $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
        if (isset($_GET['MALaporanpenyusutanasetV'])) {
            $model->attributes = $_GET['MALaporanpenyusutanasetV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['MALaporanpenyusutanasetV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MALaporanpenyusutanasetV']['tgl_akhir']);
        }

        $modPenyusutans = $model->getPenyusutan();

        $caraPrint = $_REQUEST['caraPrint'];
        $target = $this->path_view . 'penyusutanAset/_print';

        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);

        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modPenyusutans' => $modPenyusutans));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modPenyusutans' => $modPenyusutans));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modPenyusutans' => $modPenyusutans), true));
            $mpdf->Output();
        }
    }

    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $multi_mpdf = false) {
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);

        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'GRAFIK-NOT-AUTO') {            
            $this->layout = '//layouts/printWindowsNonAuto';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('', $ukuranKertasPDF);
            $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            if ($multi_mpdf == true)
                $this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'mpdf'=>$mpdf), true);
            else
                $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            
            $mpdf->Output();
        }
    }

    /**
     * beranda dinas sponsorship
     */
    public function actionDashboardAsetOpname() {

        $periode = PeriodeasetopnameK::model()->find("periodeasetopname_aktif = TRUE ORDER BY tanggal_akhir DESC");

        $model = new MACustomModel();
        $model->periodeasetopname_id = !empty($periode) ? $periode->periodeasetopname_id : null;

        $modInv = new MAInvperalatanT();
        if (isset($_GET['MAInvperalatanT'])) {
            $modInv->attributes = $_GET['MAInvperalatanT'];
            $modInv->tgl_awal = isset($_GET['MAInvperalatanT']['tgl_awal']) ? $_GET['MAInvperalatanT']['tgl_awal'] : null;
            $modInv->tgl_akhir = isset($_GET['MAInvperalatanT']['tgl_akhir']) ? $_GET['MAInvperalatanT']['tgl_akhir'] : null;
        }


        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_GET['ajax'])) {
                $ajax = $_GET['ajax'];
                if ($ajax == 'invperalatan-grid') {
                    $this->renderPartial($this->path_view . 'dashboardAsetOpname/_tabel', array(
                        'model' => $modInv,
                    ));
                }
            }
        } else {
            $this->render($this->path_view . 'dashboardAsetOpname/index', array(
                'model' => $model,
                'modInv' => $modInv
            ));
        }
    }

    /**
     * mencari data sesuai periode laporan
     */
    public function actionCariDashboardAsetOpname() {
        if (Yii::app()->request->isAjaxRequest) {
            $periodeasetopname_id = isset($_POST['periodeasetopname_id']) ? $_POST['periodeasetopname_id'] : null;

            $period = PeriodeasetopnameK::model()->findByPk($periodeasetopname_id);

            $model = new MACustomModel();
            $model->periodeasetopname_id = $periodeasetopname_id;

            $data = $model->generateDashboardAsetOpname();

            $return['sukses'] = 1;
            $return['tile'] = $data['tile'];
            $return['grafik'] = $data['grafik'];
            $return['tgl_awal'] = $period->tanggal_awal;
            $return['tgl_akhir'] = $period->tanggal_akhir;

            echo json_encode($return);
            Yii::app()->end();
        }
    }

    /**
     * 
     */
    public function actionRekapitulasiPemeliharaanAset() {

        $model = new MALaporanrekappemeliharaanasetV();
        $model->tgl_awal = date('01 F Y');
        $model->tgl_akhir = date('d F Y');
        $format = new MyFormatter();

        if (isset($_GET['MALaporanrekappemeliharaanasetV'])) {
            $model->attributes = $_GET['MALaporanrekappemeliharaanasetV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['MALaporanrekappemeliharaanasetV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MALaporanrekappemeliharaanasetV']['tgl_akhir']);
        }

        $this->render($this->path_view . 'rekapitulasiPemerliharaanAset.admin', array(
            'model' => $model, 'format' => $format
        ));
    }

    /**
     * 
     */
    public function actionPrintRekapitulasiPemeliharaanAset() {

        $model = new MALaporanrekappemeliharaanasetV();        
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN REKAPITULASI PEMELIHARAAN PERALATAN DAN MESIN';
        //Data Grafik
        $data['title'] = 'GRAFIK LAPORAN REKAPITULASI PEMELIHARAAN PERALATAN DAN MESIN';        

        if (isset($_GET['MALaporanrekappemeliharaanasetV'])) {
            $model->attributes = $_GET['MALaporanrekappemeliharaanasetV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['MALaporanrekappemeliharaanasetV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MALaporanrekappemeliharaanasetV']['tgl_akhir']);
            $model->tipe = isset($_GET['type'])?$_GET['type']:null;
            
        }

        $caraPrint = $_REQUEST['caraPrint'];

        $target = $this->path_view . 'rekapitulasiPemerliharaanAset/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
   
    public function actionCariGrafikRekapitulasiPemeliharaanAset(){
        if (Yii::app()->request->isAjaxRequest) {
            $tgl_awal = isset($_POST['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_awal']) : null;
            $tgl_akhir = isset($_POST['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_akhir']) : null;
            $gedung_id = isset($_POST['gedung_id']) ? $_POST['gedung_id'] : null;
            $lokasi_id = isset($_POST['lokasi_id']) ? $_POST['lokasi_id'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $tipe = isset($_POST['tipe'])?$_POST['tipe']:null;

            $model = new MALaporanrekappemeliharaanasetV;
            $model->tgl_awal = $tgl_awal;
            $model->tgl_akhir = $tgl_akhir;
            $model->gedung_id = $gedung_id;
            $model->lokasi_id = $lokasi_id;
            $model->ruangan_id = $ruangan_id;
            $model->tipe = $tipe;
            
            $grafik = $model->loadGrafik();
            
            $return['grafik'] = $grafik;
            $return['sukses'] = 1;
            

            echo json_encode($return);
            Yii::app()->end();
        }
    }
    
    public function actionPerbekalanMedik() {

        $model = new MALaporanperbekalanmedikV();        
        $format = new MyFormatter();

        if (isset($_GET['MALaporanperbekalanmedikV'])) {
            $model->attributes = $_GET['MALaporanperbekalanmedikV'];            
        }

        if (Yii::app()->request->isAjaxRequest){
            if ($_GET['ajax']){
                $path = $this->path_view . 'perbekalanMedik.grid';
                $aj = $_GET['ajax'];
                if ($aj == 'barang-m-grid')
                    $path .= '._barang';
                else if ($aj == 'gedung-m-grid')
                    $path .= '._gedung';
                else if ($aj == 'lokasiaset-m-grid')
                    $path .= '._lokasi';
                else if ($aj == 'ruangan-m-grid')
                    $path .= '._ruangan';
                else
                    $path .= '._table';
                
                $this->renderPartial($path, array(
                    'model' => $model, 'format' => $format
                ));
                
            }
        }else{
            $this->render($this->path_view . 'perbekalanMedik.admin', array(
                'model' => $model, 'format' => $format
            ));
        }
    }

    public function actionPrintPerbekalanMedik() {

        $model = new MALaporanperbekalanmedikV();
      
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN PERBEKALAN MEDIK';
        //Data Grafik
        $data['title'] = 'GRAFIK PERBEKALAN MEDIK';        

        if (isset($_GET['MALaporanperbekalanmedikV'])) {
            $model->attributes = $_GET['MALaporanperbekalanmedikV'];
            }

        $caraPrint = $_REQUEST['caraPrint'];

        $target = $this->path_view . 'perbekalanMedik/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    
    /**
     * 
     */
    public function actionPerizinanPeralatanDanMesin() {

        $model = new MALaporanperizinanperalatandanmesinV();        
        $format = new MyFormatter();

        if (isset($_GET['MALaporanperizinanperalatandanmesinV'])) {
            $model->attributes = $_GET['MALaporanperizinanperalatandanmesinV'];            
        }

        $this->render($this->path_view . 'perizinanPeralatanMesin.admin', array(
            'model' => $model, 'format' => $format
        ));
    }

    /**
     * 
     */
    public function actionPrintPerizinanPeralatanDanMesin() {

        $model = new MALaporanperizinanperalatandanmesinV();        
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN PERIZINAN PERALATAN DAN MESIN';
        //Data Grafik
        $data['title'] = 'GRAFIK LAPORAN PERIZINANPERALATAN DAN MESIN';        

        if (isset($_GET['MALaporanperizinanperalatandanmesinV'])) {
            $model->attributes = $_GET['MALaporanperizinanperalatandanmesinV'];   
            $model->tipe = isset($_GET['type'])?$_GET['type']:null;
        }

        $caraPrint = $_REQUEST['caraPrint'];

        $target = $this->path_view . 'perizinanPeralatanMesin/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
   
    public function actionCariGrafikPerizinanPeralatanDanMesin(){
        if (Yii::app()->request->isAjaxRequest) {            
            $gedung_id = isset($_POST['gedung_id']) ? $_POST['gedung_id'] : null;
            $lokasi_id = isset($_POST['lokasi_id']) ? $_POST['lokasi_id'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $tipe = isset($_POST['tipe'])?$_POST['tipe']:null;

            $model = new MALaporanperizinanperalatandanmesinV;            
            $model->gedung_id = $gedung_id;
            $model->lokasi_id = $lokasi_id;
            $model->ruangan_id = $ruangan_id;
            $model->tipe = $tipe;
            
            $grafik = $model->loadGrafik();
            
            $return['grafik'] = $grafik;
            $return['sukses'] = 1;
            

            echo json_encode($return);
            Yii::app()->end();
        }
    }
    
    
    /**
     * 
     */
    public function actionKalibrasiPeralatanDanMesin() {

        $model = new MALaporanjadwalkalibrasiV();           
        $format = new MyFormatter();

        if (isset($_GET['MALaporanjadwalkalibrasiV'])) {
            $model->attributes = $_GET['MALaporanjadwalkalibrasiV'];            
        }

        $this->render($this->path_view . 'kalibrasiPeralatanMesin.admin', array(
            'model' => $model, 'format' => $format
        ));
    }

    /**
     * 
     */
    public function actionPrintKalibrasiPeralatanDanMesin() {

        $model = new MALaporanjadwalkalibrasiV();        
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN KALIBRASI PERALATAN DAN MESIN';
        //Data Grafik
        $data['title'] = 'GRAFIK KALIBRASI PERIZINANPERALATAN DAN MESIN';        

        if (isset($_GET['MALaporanjadwalkalibrasiV'])) {
            $model->attributes = $_GET['MALaporanjadwalkalibrasiV'];   
            $model->tipe = isset($_GET['type'])?$_GET['type']:null;
        }

        $caraPrint = $_REQUEST['caraPrint'];

        $target = $this->path_view . 'kalibrasiPeralatanMesin/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
   
    public function actionCariGrafikKalibrasiPeralatanDanMesin(){
        if (Yii::app()->request->isAjaxRequest) {            
            $gedung_id = isset($_POST['gedung_id']) ? $_POST['gedung_id'] : null;
            $lokasi_id = isset($_POST['lokasi_id']) ? $_POST['lokasi_id'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $tipe = isset($_POST['tipe'])?$_POST['tipe']:null;

            $model = new MALaporanjadwalkalibrasiV;            
            $model->gedung_id = $gedung_id;
            $model->lokasi_id = $lokasi_id;
            $model->ruangan_id = $ruangan_id;
            $model->tipe = $tipe;
            
            $grafik = $model->loadGrafik();
            
            $return['grafik'] = $grafik;
            $return['sukses'] = 1;
            

            echo json_encode($return);
            Yii::app()->end();
        }
    }
    
    /**
     * 
     */
    public function actionRekapitulasiKondisiAset() {

        $model = new MALaporanrekapkondisiasetV();        
        $format = new MyFormatter();

        if (isset($_GET['MALaporanrekapkondisiasetV'])) {
            $model->attributes = $_GET['MALaporanrekapkondisiasetV'];            
        }

        $this->render($this->path_view . 'rekapitulasiKondisiAset.admin', array(
            'model' => $model, 'format' => $format
        ));
    }

    /**
     * 
     */
    public function actionPrintRekapitulasiKondisiAset() {

        $model = new MALaporanrekapkondisiasetV();        
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN REKAPITULASI KONDISI ASET';
        //Data Grafik
        $data['title'] = 'GRAFIK  REKAPITULASI KONDISI ASET';        

        if (isset($_GET['MALaporanrekapkondisiasetV'])) {
            $model->attributes = $_GET['MALaporanrekapkondisiasetV'];   
            $model->tipe = isset($_GET['type'])?$_GET['type']:null;
        }

        $caraPrint = $_REQUEST['caraPrint'];

        $target = $this->path_view . 'rekapitulasiKondisiAset/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
   
    public function actionCariGrafikRekapitulasiKondisiAset(){
        if (Yii::app()->request->isAjaxRequest) {            
            $gedung_id = isset($_POST['gedung_id']) ? $_POST['gedung_id'] : null;
            $lokasi_id = isset($_POST['lokasi_id']) ? $_POST['lokasi_id'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $tipe = isset($_POST['tipe'])?$_POST['tipe']:null;

            $model = new MALaporanrekapkondisiasetV;            
            $model->gedung_id = $gedung_id;
            $model->lokasi_id = $lokasi_id;
            $model->ruangan_id = $ruangan_id;
            $model->tipe = $tipe;
            
            $grafik = $model->loadGrafik();
            
            $return['grafik'] = $grafik;
            $return['sukses'] = 1;
            

            echo json_encode($return);
            Yii::app()->end();
        }
    }
    
    public function actionAsetJenisPeralatan() {

        $model = new MALaporanrekapkondisiasetperjenisV();        
        $format = new MyFormatter();

        if (isset($_GET['MALaporanrekapkondisiasetperjenisV'])) {
            $model->attributes = $_GET['MALaporanrekapkondisiasetperjenisV'];            
        }

        if (Yii::app()->request->isAjaxRequest){
            if ($_GET['ajax']){
                $path = $this->path_view . 'asetJenisPeralatan.grid';
                $aj = $_GET['ajax'];
                if ($aj == 'barang-m-grid')
                    $path .= '._barang';
                else if ($aj == 'gedung-m-grid')
                    $path .= '._gedung';
                else if ($aj == 'lokasiaset-m-grid')
                    $path .= '._lokasi';
                else if ($aj == 'ruangan-m-grid')
                    $path .= '._ruangan';
                else
                    $path .= '._table';
                
                $this->renderPartial($path, array(
                    'model' => $model, 'format' => $format
                ));
                
            }
        }else{
            $this->render($this->path_view . 'asetJenisPeralatan.admin', array(
                'model' => $model, 'format' => $format
            ));
        }
    }

    public function actionPrintAsetJenisPeralatan() {

        $model = new MALaporanrekapkondisiasetperjenisV();
      
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN ASET BERDASARKAN JENIS PERALATAN';
        //Data Grafik
        $data['title'] = 'GRAFIK ASET BERDASARKAN JENIS PERALATAN';        

        if (isset($_GET['MALaporanrekapkondisiasetperjenisV'])) {
            $model->attributes = $_GET['MALaporanrekapkondisiasetperjenisV'];
            }

        $caraPrint = $_REQUEST['caraPrint'];

        $target = $this->path_view . 'asetJenisPeralatan/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    
    /**
     * 
     */
    public function actionRekapitulasiPeralatanByUmur() {

        $model = new MALaporanrekapumurasetV();
        
        $format = new MyFormatter();

        if (isset($_GET['MALaporanrekapumurasetV'])) {
            $model->attributes = $_GET['MALaporanrekapumurasetV'];            
        }

        if (Yii::app()->request->isAjaxRequest){
            if (isset($_GET['ajax'])){
                $ajax = $_GET['ajax'];
                $path_view = $this->path_view;
                if ($ajax == 'gedung-m-grid'){
                    $path_view .= 'grid/_gedung';
                }elseif ($ajax == 'ruangan-m-grid'){
                    $path_view .= 'grid/_ruangan';
                }elseif ($ajax == 'lokasiaset-m-grid'){
                    $path_view .= 'grid/_lokasi';
                }else{
                    $path_view .= 'rekapitulasiPeralatanByUmur/_table';
                }
                
                $this->render($path_view, array(
                    'model' => $model, 'format' => $format
                ));
            }
        }else{
            $this->render($this->path_view . 'rekapitulasiPeralatanByUmur.admin', array(
                'model' => $model, 'format' => $format
            ));
        }
    }

    /**
     * 
     */
    public function actionPrintRekapitulasiPeralatanByUmur() {

        $model = new MALaporanrekapumurasetV();        
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN REKAPITULASI PERALATAN BERDASARKAN UMUR';
        //Data Grafik
        $data['title'] = 'GRAFIK LAPORAN REKAPITULASI PERALATAN BERDASARKAN UMUR';

        if (isset($_GET['MALaporanrekapumurasetV'])) {
            $model->attributes = $_GET['MALaporanrekapumurasetV'];            
            $model->tipe = isset($_GET['type'])?$_GET['type']:null;
            
        }

        $caraPrint = $_REQUEST['caraPrint'];

        $target = $this->path_view . 'rekapitulasiPeralatanByUmur/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
   
    public function actionCariGrafikRekapitulasiPeralatanByUmur(){
        if (Yii::app()->request->isAjaxRequest) {            
            $gedung_id = isset($_POST['gedung_id']) ? $_POST['gedung_id'] : null;
            $lokasi_id = isset($_POST['lokasi_id']) ? $_POST['lokasi_id'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $tipe = isset($_POST['tipe'])?$_POST['tipe']:null;

            $model = new MALaporanrekapumurasetV;            
            $model->gedung_id = $gedung_id;
            $model->lokasi_id = $lokasi_id;
            $model->ruangan_id = $ruangan_id;
            $model->tipe = $tipe;
            
            $grafik = $model->loadGrafik();
            
            $return['grafik'] = $grafik;
            $return['sukses'] = 1;
            

            echo json_encode($return);
            Yii::app()->end();
        }
    }
    
    /**
     * 
     */
    public function actionRekapitulasiPeralatanBySumberDana() {

        $model = new MALaporanrekapsumberdanaasetV();        
        $format = new MyFormatter();

        if (isset($_GET['MALaporanrekapsumberdanaasetV'])) {
            $model->attributes = $_GET['MALaporanrekapsumberdanaasetV'];            
        }

        $this->render($this->path_view . 'rekapitulasiPeralatanBySumberDana.admin', array(
            'model' => $model, 'format' => $format
        ));
    }

    /**
     * 
     */
    public function actionPrintRekapitulasiPeralatanBySumberDana() {

        $model = new MALaporanrekapsumberdanaasetV();        
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN REKAPITULASI PERALATAN BERDASARKAN SUMBER DANA';
        //Data Grafik
        $data['title'] = 'GRAFIK  REKAPITULASI PERALATAN BERDASARKAN SUMBER DANA';        

        if (isset($_GET['MALaporanrekapsumberdanaasetV'])) {
            $model->attributes = $_GET['MALaporanrekapsumberdanaasetV'];   
            $model->tipe = isset($_GET['type'])?$_GET['type']:null;
        }

        $caraPrint = $_REQUEST['caraPrint'];

        $target = $this->path_view . 'rekapitulasiPeralatanBySumberDana/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
   
    public function actionCariGrafikRekapitulasiPeralatanBySumberDana(){
        if (Yii::app()->request->isAjaxRequest) {            
            $gedung_id = isset($_POST['gedung_id']) ? $_POST['gedung_id'] : null;
            $lokasi_id = isset($_POST['lokasi_id']) ? $_POST['lokasi_id'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $tipe = isset($_POST['tipe'])?$_POST['tipe']:null;

            $model = new MALaporanrekapsumberdanaasetV;            
            $model->gedung_id = $gedung_id;
            $model->lokasi_id = $lokasi_id;
            $model->ruangan_id = $ruangan_id;
            $model->tipe = $tipe;
            
            $grafik = $model->loadGrafik();
            
            $return['grafik'] = $grafik;
            $return['sukses'] = 1;
            

            echo json_encode($return);
            Yii::app()->end();
        }
    }
    
    /**
     * beranda dinas sponsorship
     */
    public function actionDashboardPemeliharaanAset() {


        $model = new MACustomModel();
        $modPrev = new MAPrevmaintenT();
        $modCorr = new MAKorektifmaintenT();
        $modWo = new MAWorkorderT();
        
        $load = $model->generateDashboardPemeliharaanAset();
       
        $this->render($this->path_view . 'dashboardPemeliharaanAset/index', array(
            'model' => $model,
            'modPrev' => $modPrev,
            'modCorr' => $modCorr,
            'modWo' => $modWo,
            'load' => $load
        ));
        
    }

    /**
     * 
     */
    public function actionKebutuhanKalibrasiTahunan() {

        $model = new MALaporankebutuhankalibrasiV();     
        $model->tahun_perolehan = date('Y', strtotime('+1 years'));
        $format = new MyFormatter();

        if (isset($_GET['MALaporankebutuhankalibrasiV'])) {
            $model->attributes = $_GET['MALaporankebutuhankalibrasiV'];     
            $model->tahun_perolehan = !empty($model->tahun_perolehan)?$model->tahun_perolehan:null;
        }

        $this->render($this->path_view . 'kebutuhanKalibrasiTahunan.admin', array(
            'model' => $model, 'format' => $format
        ));
    }

    /**
     * 
     */
    public function actionPrintKebutuhanKalibrasiTahunan() {

        $model = new MALaporankebutuhankalibrasiV();        
        $format = new MyFormatter();
        $judulLaporan = 'LAPORAN KEBUTUHAN KALIBRASI TAHUNAN';
        //Data Grafik
        $data['title'] = 'GRAFIK KEBUTUHAN KALIBRASI TAHUNAN';        

        if (isset($_GET['MALaporankebutuhankalibrasiV'])) {
            $model->attributes = $_GET['MALaporankebutuhankalibrasiV'];   
            $model->tipe = isset($_GET['type'])?$_GET['type']:null;
            $model->tahun_perolehan = !empty($model->tahun_perolehan)?$model->tahun_perolehan:null;
        }

        $caraPrint = $_REQUEST['caraPrint'];

        $target = $this->path_view . 'kebutuhanKalibrasiTahunan/_print';

        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, true);
    }
   
    public function actionCariGrafikKebutuhanKalibrasiTahunan(){
        if (Yii::app()->request->isAjaxRequest) {            
            $gedung_id = isset($_POST['gedung_id']) ? $_POST['gedung_id'] : null;
            $lokasi_id = isset($_POST['lokasi_id']) ? $_POST['lokasi_id'] : null;
            $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
            $tipe = isset($_POST['tipe'])?$_POST['tipe']:null;
            $sumberdana = isset($_POST['sumberdana'])?$_POST['sumberdana']:null;
            $tahun_perolehan = isset($_POST['tahun_perolehan'])?$_POST['tahun_perolehan']-1:null;

            $model = new MALaporankebutuhankalibrasiV;            
            $model->gedung_id = $gedung_id;
            $model->lokasi_id = $lokasi_id;
            $model->ruangan_id = $ruangan_id;
            $model->sumberdana = $sumberdana;
            $model->tahun_perolehan = $tahun_perolehan;
            $model->tipe = $tipe;
            
            $grafik = $model->loadGrafik();
            
            $return['grafik'] = $grafik;
            $return['sukses'] = 1;
            

            echo json_encode($return);
            Yii::app()->end();
        }
    }

}

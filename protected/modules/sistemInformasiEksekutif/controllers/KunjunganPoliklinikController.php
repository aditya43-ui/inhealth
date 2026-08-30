<?php

/**
 * Controller Laporan Kunjungan Pasien
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemInformasiEksekutif
 * @subpackage controllers
 */
class KunjunganPoliklinikController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.kunjunganPoliklinik.';

    /**
     * Halaman utama laporan kunjungan poliklinik
     */
    public function actionIndex() {
        $this->render('index');
    }

    /**
     * menampilkan halaman dashboard (iframe)
     * beberapa menggunakan DAO (createCommand) agar lebih cepat
     */
    public function actionSetIFrameDashboard() {

        $this->layout = '//layouts/iframeNeon';
        $format = new MyFormatter();
        $model = new SEKunjunganpoliklinikR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SEKunjunganpoliklinikR'])) {
            $model->attributes = $_GET['SEKunjunganpoliklinikR'];
            $model->jns_periode = $_GET['SEKunjunganpoliklinikR']['jns_periode'];
            $model->instalasi_id = !empty($_GET['SEKunjunganpoliklinikR']['instalasi_id']) ? $_GET['SEKunjunganpoliklinikR']['instalasi_id'] : null;
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEKunjunganpoliklinikR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEKunjunganpoliklinikR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEKunjunganpoliklinikR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEKunjunganpoliklinikR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEKunjunganpoliklinikR']['thn_awal'];
            $model->thn_akhir = $_GET['SEKunjunganpoliklinikR']['thn_akhir'];
            $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
            switch ($model->jns_periode) {
                case 'bulan' : $model->tgl_awal = $model->bln_awal . "-01";
                    $model->tgl_akhir = $bln_akhir;
                    break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal . "-01-01";
                    $model->tgl_akhir = $thn_akhir;
                    break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
        
        //=== chart pie ===
        if(!empty($model->instalasi_id)){
            $sql = "
                    SELECT 
                    ruangan_nama as jenis, sum(jumlah) as jumlah
                    FROM kunjunganpoliklinik_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    AND instalasi_id = " . $model->instalasi_id . "
                    GROUP BY jenis
                    ORDER BY jenis ASC
                    ";
        }else{
            $sql = "
                    SELECT 
                    ruangan_nama as jenis, sum(jumlah) as jumlah
                    FROM kunjunganpoliklinik_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    GROUP BY jenis
                    ORDER BY jenis ASC
                    ";
        }


        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

        //=== chart line ===
        if(!empty($model->instalasi_id)){
            $sql2 = "
                    SELECT 
                    date_trunc('month', tanggal) as periode, sum(jumlah) as jumlah
                    FROM kunjunganpoliklinik_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    AND instalasi_id = " . $model->instalasi_id . "
                    GROUP BY periode
                    ORDER BY periode ASC
                    ";
        }else{
            $sql2 = "
                    SELECT 
                    date_trunc('month', tanggal) as periode, sum(jumlah) as jumlah
                    FROM kunjunganpoliklinik_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    GROUP BY periode
                    ORDER BY periode ASC
                    ";
        }


        $result2 = Yii::app()->db->createCommand($sql2)->queryAll();
        $dataLineChart = $result2;

        //=== tabel ===
        if(!empty($model->instalasi_id)){
            $sql3 = "
                    SELECT 
                    date_trunc('month', tanggal) as periode, ruangan_nama as jenis, sum(jumlah) as jumlah
                    FROM kunjunganpoliklinik_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    AND instalasi_id = " . $model->instalasi_id . "
                    GROUP BY periode, jenis
                    ORDER BY periode ASC
                    ";
        }else{
            $sql3 = "
                    SELECT 
                    date_trunc('month', tanggal) as periode, ruangan_nama as jenis, sum(jumlah) as jumlah
                    FROM kunjunganpoliklinik_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    GROUP BY periode, jenis
                    ORDER BY periode ASC
                    ";
        }

        $result3 = Yii::app()->db->createCommand($sql3)->queryAll();
        $dataChart = $result3;

        $dataTable = array();
        foreach ($dataChart as $data) {
            $id = $data['periode'];
            if (isset($dataTable[$id])) {
                $dataTable[$id][] = $data;
            } else {
                $dataTable[$id] = array($data);
            }
        }

        $this->render('dashboard', array(
            'model' => $model,
            'dataPieChart' => $dataPieChart,
            'dataTable' => $dataTable,
            'dataLineChart' => $dataLineChart,
        ));
    }


    /**
     * Fungsi cetak laporan Kunjungan Poliklinik
     */
    public function actionPrintLaporan() {
        $model = new SEKunjunganpoliklinikR('search');
        $format = new MyFormatter();
        $judulLaporan = 'Laporan Kunjungan Poli Klinik';

        //Data Grafik
        $data['title'] = 'Grafik Kunjungan Poli Klinik';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['SEKunjunganpoliklinikR'])) {
            $model->attributes = $_REQUEST['SEKunjunganpoliklinikR'];
            $model->instalasi_id = $_REQUEST['SEKunjunganpoliklinikR']['instalasi_id'];
            $model->jns_periode = $_REQUEST['SEKunjunganpoliklinikR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['SEKunjunganpoliklinikR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['SEKunjunganpoliklinikR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['SEKunjunganpoliklinikR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['SEKunjunganpoliklinikR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_REQUEST['SEKunjunganpoliklinikR']['thn_awal'];
            $model->thn_akhir = $_REQUEST['SEKunjunganpoliklinikR']['thn_akhir'];
            $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
            switch ($model->jns_periode) {
                case 'bulan' : $model->tgl_awal = $model->bln_awal . "-01";
                    $model->tgl_akhir = $bln_akhir;
                    break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal . "-01-01";
                    $model->tgl_akhir = $thn_akhir;
                    break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
        

        //=== tabel ===
        if(!empty($model->instalasi_id)){
            $sql3 = "
                    SELECT 
                    date_trunc('month', tanggal) as periode, ruangan_nama as jenis, sum(jumlah) as jumlah
                    FROM kunjunganpoliklinik_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    AND instalasi_id = " . $model->instalasi_id . "
                    GROUP BY periode, jenis
                    ORDER BY periode ASC
                    ";
        }else{
            $sql3 = "
                    SELECT 
                    date_trunc('month', tanggal) as periode, ruangan_nama as jenis, sum(jumlah) as jumlah
                    FROM kunjunganpoliklinik_r
                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                    GROUP BY periode, jenis
                    ORDER BY periode ASC
                    ";
        }

        $result3 = Yii::app()->db->createCommand($sql3)->queryAll();
        $dataChart = $result3;

        $dataTable = array();
        foreach ($dataChart as $data) {
            $id = $data['periode'];
            if (isset($dataTable[$id])) {
                $dataTable[$id][] = $data;
            } else {
                $dataTable[$id] = array($data);
            }
        }


        $caraPrint = $_REQUEST['caraPrint'];
        $target = '_print';

        $this->printFunction($dataTable, $data, $caraPrint, $judulLaporan, $target);
    }

    /**
     * Fungsi print 
     * @param type $model
     * @param type $data
     * @param type $caraPrint
     * @param type $judulLaporan
     * @param type $target
     * @param type $tab
     * @param type $variabel
     */
    protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab = 'rs', $variabel = array()) {
        $format = new MyFormatter();
        $periode = '';
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows3';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $kertas = Params::getUkuranKertas();
            $mpdf = new MyPDF('', $kertas['F4']);
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'colspan' => 10), true));
            $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 10), true));
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 20, 60, 30, 20, 20);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab, 'variabel' => $variabel), true));
            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
        }
    }

}

?>
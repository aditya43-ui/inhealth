<?php

/**
 * Controller Dashboard Rujukan Pasien
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemInformasiEksekutif
 * @subpackage controllers
 */
class RujukanPasienController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.rujukanPasien.';

    /**
     * Action utama dashboard rujukan pasien
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
        //=== start 4 kolom ===
        $dataPie = array();
        $dataPieChart = array();
        $dataBarLineChart = array();

        $format = new MyFormatter();
        $model = new SERujukanpasienR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SERujukanpasienR'])) {
            $model->attributes = $_GET['SERujukanpasienR'];
            $model->instalasi_id = $_GET['SERujukanpasienR']['instalasi_id'];
            $model->jns_periode = $_GET['SERujukanpasienR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SERujukanpasienR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SERujukanpasienR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SERujukanpasienR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SERujukanpasienR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SERujukanpasienR']['thn_awal'];
            $model->thn_akhir = $_GET['SERujukanpasienR']['thn_akhir'];
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
        //=== chart ===
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
                                    SELECT 
                                    date_trunc('month', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas
                                    FROM rujukanpasien_r
                                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                                    GROUP BY periode
                                    ORDER BY periode ASC
                                ";
                break;
            case 'tahun' : $sql = "
                                    SELECT 
                                    date_trunc('year', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas
                                    FROM rujukanpasien_r
                                    WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                                    GROUP BY periode
                                    ORDER BY periode ASC

                                ";
                break;
            default : $sql = "
                                SELECT 
                                date_trunc('day', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas
                                FROM rujukanpasien_r
                                WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                                GROUP BY periode
                                ORDER BY periode ASC

                            ";
        }

        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarLineChart = $result;

        $sql = "
                SELECT 
                sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas
                FROM rujukanpasien_r
                WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
                ";


        $result = Yii::app()->db->createCommand($sql)->queryRow();
        $dataPie = $result;

        foreach ($dataPie as $key => $value) {
            if ($key == "jumlah_rs") {
                $key = "Rumah Sakit";
            } elseif ($key == "jumlah_klinik") {
                $key = "Klinik";
            } elseif ($key == "jumlah_dokter") {
                $key = "Dokter";
            } else {
                $key = "Puskesmas";
            }
            $temp['jenis'] = $key;
            $temp['jumlah'] = $value;

            array_push($dataPieChart, $temp);
        }
        //=== end chart ===
        //=== start table ===
        $criteria = new CDbCriteria;

        /*
          switch ($model->jns_periode) {
          case 'bulan' : $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas');
          $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
          $criteria->group = 'periode';
          $criteria->order = 'periode ASC';
          break;
          case 'tahun' : $criteria->select = array('date_trunc(' . "'year'" . ', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas');
          $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
          $criteria->group = 'periode';
          $criteria->order = 'periode ASC';
          break;
          default : $criteria->select = array('date_trunc(' . "'day'" . ', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas');
          $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
          $criteria->group = 'periode';
          $criteria->order = 'periode ASC';
          }
         */
        $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas');
        $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
        if(!empty($model->instalasi_id)){
            $criteria->addCondition('instalasi_id = '.$model->instalasi_id);
        }
        $criteria->group = 'periode';
        $criteria->order = 'periode ASC';

        $dataTable = new CActiveDataProvider($model, array(
            'criteria' => $criteria
        ));

        $criteria1 = new CDbCriteria;
        $criteria1->select = array('sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas');
        $criteria1->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
        if(!empty($model->instalasi_id)){
            $criteria1->addCondition('instalasi_id = '.$model->instalasi_id);
        }
        $tile = SERujukanpasienR::model()->find($criteria1);

        $criteria2 = new CDbCriteria;
        $criteria2->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas');
        $criteria2->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
        if(!empty($model->instalasi_id)){
            $criteria2->addCondition('instalasi_id = '.$model->instalasi_id);
        }
        $criteria2->group = 'periode';
        $criteria2->order = 'periode ASC';
        $grafik = SERujukanpasienR::model()->findAll($criteria2);
        //=== end table ===
//		$model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
//		$model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
//		$model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
//		$model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

        $this->render('dashboard', array(
            'tile' => $tile,
            'grafik' => $grafik,
            'model' => $model,
            'dataBarLineChart' => $dataBarLineChart,
            'dataPieChart' => $dataPieChart,
            'dataTable' => $dataTable
        ));
    }

    /**
     * Fungsi cetak laporan TAT
     */
    public function actionPrintLaporan() {
        $model = new SERujukanpasienR('search');
        $format = new MyFormatter();
        $judulLaporan = 'Rujukan Pasien';

        //Data Grafik
        $data['title'] = 'Grafik Rujukan Pasien';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['SERujukanpasienR'])) {
            $model->attributes = $_REQUEST['SERujukanpasienR'];
            $model->instalasi_id = $_REQUEST['SERujukanpasienR']['instalasi_id'];
            $model->jns_periode = $_REQUEST['SERujukanpasienR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['SERujukanpasienR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['SERujukanpasienR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_REQUEST['SERujukanpasienR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['SERujukanpasienR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_REQUEST['SERujukanpasienR']['thn_awal'];
            $model->thn_akhir = $_REQUEST['SERujukanpasienR']['thn_akhir'];
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

        $criteriaPrint = new CDbCriteria;
        $criteriaPrint->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(rujukanrs) as jumlah_rs, sum(rujukanklinik) as jumlah_klinik, sum(rujukandokter) jumlah_dokter, sum(rujukanpuskesmas) jumlah_puskesmas');
        $criteriaPrint->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
        if(!empty($model->instalasi_id)){
            $criteriaPrint->addCondition('instalasi_id = '.$model->instalasi_id);
        }
        $criteriaPrint->group = 'periode';
        $criteriaPrint->order = 'periode ASC';
        $criteriaPrint->limit = -1;

        $dataTablePrint = new CActiveDataProvider($model, array(
            'criteria' => $criteriaPrint,
            'pagination' => false,
        ));


        $caraPrint = $_REQUEST['caraPrint'];
        $target = '_print';

        $this->printFunction($dataTablePrint, $data, $caraPrint, $judulLaporan, $target);
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
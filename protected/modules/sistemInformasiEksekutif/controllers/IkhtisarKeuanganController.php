<?php

class IkhtisarKeuanganController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.ikhtisarKeuangan.';

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
        $dataStackChart = array();

        $format = new MyFormatter();
        $model = new SEPendapatanrsR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SEPendapatanrsR'])) {
            $model->attributes = $_GET['SEPendapatanrsR'];
            $model->jns_periode = $_GET['SEPendapatanrsR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEPendapatanrsR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEPendapatanrsR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEPendapatanrsR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEPendapatanrsR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEPendapatanrsR']['thn_awal'];
            $model->thn_akhir = $_GET['SEPendapatanrsR']['thn_akhir'];
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
        // PENDAPATAN
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapatanrs_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, coalesce(sum(jumlah), 0) as jumlah
		FROM pendapatanrs_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, coalesce(sum(jumlah), 0) as jumlah
		FROM pendapatanrs_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChartPendapatan = $result;

        // LABARUGI
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tglperiodeposting_awal) as periode, coalesce(sum(jumlah), 0)  as jumlah
		FROM laporanlabarugi_v
		WHERE DATE(tglperiodeposting_awal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tglperiodeposting_awal) as periode, coalesce(sum(jumlah), 0)  as jumlah
		FROM laporanlabarugi_v
		WHERE DATE(tglperiodeposting_awal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tglperiodeposting_awal) as periode, coalesce(sum(jumlah), 0)  as jumlah
		FROM laporanlabarugi_v
		WHERE DATE(tglperiodeposting_awal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChartLabaRugi = $result;

        // ASET
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', create_time) as periode, coalesce(sum(aktiva), 0)  as jumlah
		FROM laporanneraca_r
		WHERE DATE(create_time) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', create_time) as periode, coalesce(sum(aktiva), 0)  as jumlah
		FROM laporanneraca_r
		WHERE DATE(create_time) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', create_time) as periode, coalesce(sum(aktiva), 0)  as jumlah
		FROM laporanneraca_r
		WHERE DATE(create_time) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChartAset = $result;

        // LIABILITAS
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', create_time) as periode, coalesce(sum(kewajiban), 0)  as jumlah
		FROM laporanneraca_r
		WHERE DATE(create_time) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', create_time) as periode, coalesce(sum(kewajiban), 0)  as jumlah
		FROM laporanneraca_r
		WHERE DATE(create_time) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', create_time) as periode, coalesce(sum(kewajiban), 0)  as jumlah
		FROM laporanneraca_r
		WHERE DATE(create_time) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChartLiabilitas = $result;

        // EKUITAS
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', create_time) as periode, coalesce(sum(modal), 0)  as jumlah
		FROM laporanneraca_r
		WHERE DATE(create_time) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', create_time) as periode, coalesce(sum(modal), 0)  as jumlah
		FROM laporanneraca_r
		WHERE DATE(create_time) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', create_time) as periode, coalesce(sum(modal), 0)  as jumlah
		FROM laporanneraca_r
		WHERE DATE(create_time) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode
		ORDER BY periode ASC

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChartEkuitas = $result;




//        $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
//        $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
//        $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
//        $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

        $this->render('dashboard', array(
            'model' => $model,
            'dataChartPendapatan' => $dataChartPendapatan,
            'dataChartLabaRugi' => $dataChartLabaRugi,
            'dataChartAset' => $dataChartAset,
            'dataChartLiabilitas' => $dataChartLiabilitas,
            'dataChartEkuitas' => $dataChartEkuitas,
        ));
    }

}

?>
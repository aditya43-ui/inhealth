<?php

class ObatAlkesFarmasiController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.obatAlkesFarmasi.';

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
        $model = new SEInformasifarmasiR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SEInformasifarmasiR'])) {
            $model->attributes = $_GET['SEInformasifarmasiR'];
            $model->jns_periode = $_GET['SEInformasifarmasiR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEInformasifarmasiR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEInformasifarmasiR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEInformasifarmasiR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEInformasifarmasiR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEInformasifarmasiR']['thn_awal'];
            $model->thn_akhir = $_GET['SEInformasifarmasiR']['thn_akhir'];
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
            $model->tgl_awal = $model->tgl_awal . " 00:00:00";
            $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
        }
        //=== chart ===
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode,obatalkes_id as id, obatalkes_nama as jenis, sum(jumlah) as jumlah
		FROM informasifarmasi_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,periode, jenis
		ORDER BY jumlah DESC
		LIMIT 10
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, obatalkes_id as id, obatalkes_nama as jenis, sum(jumlah) as jumlah
		FROM informasifarmasi_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,periode, jenis
		ORDER BY jumlah DESC
		LIMIT 10

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, obatalkes_id as id, obatalkes_nama as jenis, sum(jumlah) as jumlah
		FROM informasifarmasi_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,periode,jenis
		ORDER BY jumlah DESC
		LIMIT 10

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChart = $result;

        for ($i = 0; $i < count($dataChart); $i++) {
            $dataBarLineChart[$i]['id'] = $dataChart[$i]['id'];
            $dataBarLineChart[$i]['periode'] = $dataChart[$i]['periode'];
            $dataBarLineChart[$i]['jenis'] = $dataChart[$i]['jenis'];
            $dataBarLineChart[$i]['jumlah' . $dataChart[$i]['id']] = $dataChart[$i]['jumlah'];
        }
        
        // sort by id for graph making
        usort($dataBarLineChart, function($a, $b) {
            return $a['id'] - $b['id'];
        });

        $graphs = array();

        for ($i = 0; $i < count($dataBarLineChart); $i++) {
            if ($i == count($dataBarLineChart) - 1) {
                $graph['id'] = "graph" . $i;
                $graph['type'] = "column";
                $graph['title'] = $dataBarLineChart[$i]['jenis'];
                $graph['valueField'] = "jumlah" . $dataBarLineChart[$i]['id'];
                $graph['balloonText'] = "[[title]]: [[value]]";
                $graph['lineAlpha'] = 0;
                $graph['fillAlphas'] = 1;
                array_push($graphs, $graph);
            } else {
                if ($dataBarLineChart[$i]['id'] !== $dataBarLineChart[$i + 1]['id']) {
                    $graph['id'] = "graph" . $i;
                    $graph['type'] = "column";
                    $graph['title'] = $dataBarLineChart[$i]['jenis'];
                    $graph['valueField'] = "jumlah" . $dataBarLineChart[$i]['id'];
                    $graph['balloonText'] = "[[title]]:[[value]]";
                    $graph['lineAlpha'] = 0;
                    $graph['fillAlphas'] = 1;
                    array_push($graphs, $graph);
                }
            }
        }

        // sort by date for graph category

        function date_compare($a, $b) {
            $t1 = strtotime($a['periode']);
            $t2 = strtotime($b['periode']);
            return $t1 - $t2;
        }

        usort($dataBarLineChart, 'date_compare');

        $sql = "
		SELECT 
		obatalkes_nama as jenis, sum(jumlah) as jumlah
		FROM informasifarmasi_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY jenis
                ORDER BY jumlah DESC
                LIMIT 10
				";


        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

//		foreach ($dataPie as $key => $value) {
//			if ($key == "jumlah_ri") {
//				$key = "Rawat Inap";
//			} elseif ($key == "jumlah_rd") {
//				$key = "Rawat Darurat";
//			} else {
//				$key = "Rawat Jalan";
//			}
//			$temp['jenis'] = $key;
//			$temp['jumlah'] = $value;
//
//			array_push($dataPieChart, $temp);
//		}
        //=== end chart ===
        //=== start table ===
        $sql = "
		SELECT 
		obatalkes_id as id, obatalkes_nama as nama
		FROM obatalkes_m
		ORDER BY id ASC
		";


        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataObatAlkes = $result;

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, obatalkes_id as id,obatalkes_nama as jenis, COALESCE(sum(jumlah), 0) as jumlah
		FROM informasifarmasi_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode, jenis
		ORDER BY periode ASC, jumlah DESC
		LIMIT 10
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, obatalkes_id as id,obatalkes_nama as jenis, COALESCE(sum(jumlah), 0) as jumlah
		FROM informasifarmasi_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode,jenis
		ORDER BY periode ASC, jumlah DESC
		LIMIT 10

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, obatalkes_id as id,obatalkes_nama as jenis, COALESCE(sum(jumlah), 0) as jumlah
		FROM informasifarmasi_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, periode,jenis
		ORDER BY periode ASC, jumlah DESC
		LIMIT 10

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataTable = array();
        foreach ($result as $data) {
            $id = $data['periode'];
            if (isset($dataTable[$id])) {
                $dataTable[$id][] = $data;
            } else {
                $dataTable[$id] = array($data);
            }
        }
        //=== end table ===

//        $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
//        $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
//        $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
//        $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

        $this->render('dashboard', array(
            'model' => $model,
            'dataBarLineChart' => $dataBarLineChart,
            'dataPieChart' => $dataPieChart,
            'dataTable' => $dataTable,
            'graphs' => $graphs,
            'dataObatAlkes' => $dataObatAlkes
        ));
    }

}

?>
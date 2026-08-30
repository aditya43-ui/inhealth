<?php

class PendapatanPenunjangController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.pendapatanPenunjang.';

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
        $model = new SEPendapataninstalasiR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SEPendapataninstalasiR'])) {
            $model->attributes = $_GET['SEPendapataninstalasiR'];
            $model->jns_periode = $_GET['SEPendapataninstalasiR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEPendapataninstalasiR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEPendapataninstalasiR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEPendapataninstalasiR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEPendapataninstalasiR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEPendapataninstalasiR']['thn_awal'];
            $model->thn_akhir = $_GET['SEPendapataninstalasiR']['thn_akhir'];
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
		date_trunc('month', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapataninstalasi_r
		WHERE lower(rekening_nama) LIKE ANY(ARRAY['%laboratorium%','%radiologi%','%pemulasaran jenazah%','%persalinan%', '%bedah sentral%', '%gizi%', '%rehabilitasi medis%']) AND DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapataninstalasi_r
		WHERE lower(rekening_nama) LIKE ANY(ARRAY['%laboratorium%','%radiologi%','%pemulasaran jenazah%','%persalinan%', '%bedah sentral%', '%gizi%', '%rehabilitasi medis%']) AND DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapataninstalasi_r
		WHERE lower(rekening_nama) LIKE ANY(ARRAY['%laboratorium%','%radiologi%','%pemulasaran jenazah%','%persalinan%', '%bedah sentral%', '%gizi%', '%rehabilitasi medis%']) AND DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode ASC

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
                $graph['valueAxis'] = "valueAxis1";
                $graph['title'] = $dataBarLineChart[$i]['jenis'];
                $graph['valueField'] = "jumlah" . $dataBarLineChart[$i]['id'];
                $graph['bullet'] = "round";
                $graph['hideBulletsCount'] = 30;
                $graph['bulletBorderThickness'] = 1;
                array_push($graphs, $graph);
            } else {
                if ($dataBarLineChart[$i]['id'] !== $dataBarLineChart[$i + 1]['id']) {
                    $graph['id'] = "graph" . $i;
                    $graph['valueAxis'] = "valueAxis1";
                    $graph['title'] = $dataBarLineChart[$i]['jenis'];
                    $graph['valueField'] = "jumlah" . $dataBarLineChart[$i]['id'];
                    $graph['bullet'] = "round";
                    $graph['hideBulletsCount'] = 30;
                    $graph['bulletBorderThickness'] = 1;
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

        // stacked chart

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapataninstalasi_r
		WHERE lower(rekening_nama) LIKE ANY(ARRAY['%laboratorium%','%radiologi%','%pemulasaran jenazah%','%persalinan%', '%bedah sentral%', '%gizi%', '%rehabilitasi medis%']) AND DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapataninstalasi_r
		WHERE lower(rekening_nama) LIKE ANY(ARRAY['%laboratorium%','%radiologi%','%pemulasaran jenazah%','%persalinan%', '%bedah sentral%', '%gizi%', '%rehabilitasi medis%']) AND DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapataninstalasi_r
		WHERE lower(rekening_nama) LIKE ANY(ARRAY['%laboratorium%','%radiologi%','%pemulasaran jenazah%','%persalinan%', '%bedah sentral%', '%gizi%', '%rehabilitasi medis%']) AND DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode ASC

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChartStack = array();
        foreach ($result as $data) {
            $id = $data['periode'];
            if (isset($dataChartStack[$id])) {
                unset($data['periode']);
                $dataChartStack[$id][] = $data;
            } else {
                unset($data['periode']);
                $dataChartStack[$id] = array($data);
            }
        }

        foreach ($dataChartStack as $key => $value) {
            $tempStackChart['periode'] = $key;
            foreach ($value as $data) {
                $tempStackChart['jumlah' . $data['id']] = $data['jumlah'];
            }
            array_push($dataStackChart, $tempStackChart);
        }


        // generate_graph
        $graphStack = array();
        $graphsStack = array();
        foreach ($result as $data) {
            $id = $data['id'];
            if (isset($dataChart[$id])) {
                unset($data['periode']);
                unset($data['jumlah']);

                $graphStack[$id][] = $data;
            } else {
                unset($data['periode']);
                unset($data['jumlah']);

                $graphStack[$id] = array($data);
            }
        }

        // make graphs
        foreach ($graphStack as $key => $data) {
            $tempGraphStack['id'] = "graph" . $data[0]['id'];
            $tempGraphStack['title'] = $data[0]['jenis'];
            $tempGraphStack['valueField'] = "jumlah" . $data[0]['id'];
            $tempGraphStack['balloonText'] = "[[title]]:[[value]]";
            $tempGraphStack['lineAlpha'] = 0.5;
            $tempGraphStack['fillAlphas'] = 0.5;
            array_push($graphsStack, $tempGraphStack);
        }

        $sql = "
		SELECT 
		rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapataninstalasi_r
		WHERE lower(rekening_nama) LIKE ANY(ARRAY['%laboratorium%','%radiologi%','%pemulasaran jenazah%','%persalinan%', '%bedah sentral%', '%gizi%', '%rehabilitasi medis%']) AND DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis
				";


        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

        //=== end chart ===
        //=== start table ===
        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapataninstalasi_r
		WHERE lower(rekening_nama) LIKE ANY(ARRAY['%laboratorium%','%radiologi%','%pemulasaran jenazah%','%persalinan%', '%bedah sentral%', '%gizi%', '%rehabilitasi medis%']) AND DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapataninstalasi_r
		WHERE lower(rekening_nama) LIKE ANY(ARRAY['%laboratorium%','%radiologi%','%pemulasaran jenazah%','%persalinan%', '%bedah sentral%', '%gizi%', '%rehabilitasi medis%']) AND DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapataninstalasi_r
		WHERE lower(rekening_nama) LIKE ANY(ARRAY['%laboratorium%','%radiologi%','%pemulasaran jenazah%','%persalinan%', '%bedah sentral%', '%gizi%', '%rehabilitasi medis%']) AND DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id,jenis,periode
		ORDER BY periode ASC

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
            'dataStackChart' => $dataStackChart,
            'graphs' => $graphs,
            'graphsStack' => $graphsStack
        ));
    }

}

?>
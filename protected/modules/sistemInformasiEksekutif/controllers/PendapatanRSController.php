<?php

class PendapatanRSController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.pendapatanRS.';

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
        $dataBarLineChart = $result;

        // stacked chart

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0)  as jumlah
		FROM pendapatanrs_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, jenis, periode
		ORDER BY periode ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0) as jumlah
		FROM pendapatanrs_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, jenis, periode
		ORDER BY periode ASC

									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, rekening_id as id, rekening_nama as jenis, coalesce(sum(jumlah), 0) as jumlah
		FROM pendapatanrs_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY id, jenis, periode
		ORDER BY periode ASC

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChart = array();
        foreach ($result as $data) {
            $id = $data['periode'];
            if (isset($dataChart[$id])) {
                unset($data['periode']);
                $dataChart[$id][] = $data;
            } else {
                unset($data['periode']);
                $dataChart[$id] = array($data);
            }
        }

        foreach ($dataChart as $key => $value) {
            $temp['periode'] = $key;
            foreach ($value as $data) {
                $temp['jumlah' . $data['id']] = $data['jumlah'];
            }
            array_push($dataStackChart, $temp);
        }


        // generate_graph
        $graph = array();
        $graphs = array();
        foreach ($result as $data) {
            $id = $data['id'];
            if (isset($graph[$id])) {
                unset($data['periode']);
                unset($data['jumlah']);

                $graph[$id][] = $data;
            } else {
                unset($data['periode']);
                unset($data['jumlah']);

                $graph[$id] = array($data);
            }
        }

        // make graphs
        foreach ($graph as $key => $data) {
            $temp['id'] = "graph" . $data[0]['id'];
            $temp['title'] = $data[0]['jenis'];
            $temp['valueField'] = "jumlah" . $data[0]['id'];
            $temp['balloonText'] = "[[title]]:[[value]]";
            $temp['lineAlpha'] = 0.5;
            $temp['fillAlphas'] = 0.5;
            array_push($graphs, $temp);
        }


        $sql = "
		SELECT 
		obatalkes_nama as jenis, sum(jumlah) as jumlah
		FROM informasifarmasi_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY jenis
				";


        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPieChart = $result;

        //=== end chart ===
        //=== start table ===
        $criteria = new CDbCriteria;

        switch ($model->jns_periode) {
            case 'bulan' : $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, sum(jumlah) as jumlah');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
                break;
            case 'tahun' : $criteria->select = array('date_trunc(' . "'year'" . ', tanggal) as periode, sum(jumlah) as jumlah');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
                break;
            default : $criteria->select = array('date_trunc(' . "'day'" . ', tanggal) as periode, sum(jumlah) as jumlah');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode';
                $criteria->order = 'periode ASC';
        }

        $dataTable = new CActiveDataProvider($model, array(
            'criteria' => $criteria
        ));
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
            'graphs' => $graphs
        ));
    }

}

?>
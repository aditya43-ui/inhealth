<?php

class KegiatanLaboratoriumController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.kegiatanLaboratorium.';

    public function actionIndex() {
        $this->render($this->path_view.'index');
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

        $model = new SEKegiatanlaboratoriumR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SEKegiatanlaboratoriumR'])) {
            $model->attributes = $_GET['SEKegiatanlaboratoriumR'];
            $model->jns_periode = $_GET['SEKegiatanlaboratoriumR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEKegiatanlaboratoriumR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEKegiatanlaboratoriumR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEKegiatanlaboratoriumR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEKegiatanlaboratoriumR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEKegiatanlaboratoriumR']['thn_awal'];
            $model->thn_akhir = $_GET['SEKegiatanlaboratoriumR']['thn_akhir'];
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
        $sql = "
		SELECT 
		jenispemeriksaanlab_id as id, jenispemeriksaanlab_nama as nama
		FROM jenispemeriksaanlab_m
                
		ORDER BY jenispemeriksaanlab_nama ASC
		";


        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataPemeriksaanLab = $result;

        switch ($model->jns_periode) {
            case 'bulan' : $sql = "
		SELECT 
		date_trunc('month', tanggal) as periode, jenispemeriksaanlab_id as id, jenispemeriksaanlab_nama as jenis, sum(jumlah) as jumlah
		FROM kegiatanlaboratorium_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode, id, jenis
		ORDER BY periode, id ASC
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		date_trunc('year', tanggal) as periode, jenispemeriksaanlab_id as id, jenispemeriksaanlab_nama as jenis, sum(jumlah) as jumlah
		FROM kegiatanlaboratorium_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode, id, jenis
		ORDER BY periode, id ASC
									";
                break;
            default : $sql = "
		SELECT 
		date_trunc('day', tanggal) as periode, jenispemeriksaanlab_id as id, jenispemeriksaanlab_nama as jenis, sum(jumlah) as jumlah
		FROM kegiatanlaboratorium_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY periode, id, jenis
		ORDER BY periode, id ASC
									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataChart = $result;

        $dataBarLineChart = array();
        $i = 1;
        foreach ($dataChart as $data) {
            $id = $data['id'];
         //   $id = $i;
            if (isset($dataBarLineChart[$id])) {
                $dataBarLineChart[$id][] = $data;
            } else {
                $dataBarLineChart[$id] = array($data);
            }
           // $i++;
        }

        $sql = "
		SELECT 
		jenispemeriksaanlab_nama as jenis, sum(jumlah) as jumlah
		FROM kegiatanlaboratorium_r
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
        $criteria = new CDbCriteria;

        switch ($model->jns_periode) {
            case 'bulan' : $criteria->select = array('date_trunc(' . "'month'" . ', tanggal) as periode, jenispemeriksaanlab_id as id, jenispemeriksaanlab_nama as jenis, sum(jumlah) as jumlah');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode, id, jenis';
                $criteria->order = 'periode, id ASC';
                break;
            case 'tahun' : $criteria->select = array('date_trunc(' . "'year'" . ', tanggal) as periode, jenispemeriksaanlab_id as id, jenispemeriksaanlab_nama as jenis, sum(jumlah) as jumlah');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode, id, jenis';
                $criteria->order = 'periode, id ASC';
                break;
            default : $criteria->select = array('date_trunc(' . "'day'" . ', tanggal) as periode, jenispemeriksaanlab_id as id, jenispemeriksaanlab_nama as jenis, sum(jumlah) as jumlah');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'periode, id, jenis';
                $criteria->order = 'periode, id ASC';
        }

//        $dataTable = new CActiveDataProvider($model, array(
//            'criteria' => $criteria
//        ));
        $dataTable = $dataBarLineChart;

        //=== end table ===

//        $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
//        $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
//        $model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
//        $model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

        $this->render($this->path_view.'dashboard', array(
            'model' => $model,
            'dataBarLineChart' => $dataBarLineChart,
            'dataPieChart' => $dataPieChart,
            'dataTable' => $dataTable,
            'dataPemeriksaanLab' => $dataPemeriksaanLab
        ));
    }

}

?>
<?php

class JenisKasusPenyakitController extends MyAuthController {

    public $path_view = 'sistemInformasiEksekutif.views.jenisKasusPenyakit.';

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
        $model = new SEKasuspenyakitpasienR();
        $model->unsetAttributes();
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');

        if (isset($_GET['SEKasuspenyakitpasienR'])) {
            $model->attributes = $_GET['SEKasuspenyakitpasienR'];
            $model->jns_periode = $_GET['SEKasuspenyakitpasienR']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['SEKasuspenyakitpasienR']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEKasuspenyakitpasienR']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['SEKasuspenyakitpasienR']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['SEKasuspenyakitpasienR']['bln_akhir']);
            $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
            $model->thn_awal = $_GET['SEKasuspenyakitpasienR']['thn_awal'];
            $model->thn_akhir = $_GET['SEKasuspenyakitpasienR']['thn_akhir'];
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
		jeniskasuspenyakit_nama as jenis, sum(jumlah) as jumlah
		FROM kasuspenyakitpasien_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY jenis
		ORDER BY jumlah DESC
		LIMIT 10
									";
                break;
            case 'tahun' : $sql = "
		SELECT 
		jeniskasuspenyakit_nama as jenis, sum(jumlah) as jumlah
		FROM kasuspenyakitpasien_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY jenis
		ORDER BY jumlah DESC
		LIMIT 10

									";
                break;
            default : $sql = "
		SELECT 
		jeniskasuspenyakit_nama as jenis, sum(jumlah) as jumlah
		FROM kasuspenyakitpasien_r
		WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
		GROUP BY jenis
		ORDER BY jumlah DESC
		LIMIT 10

									";
        }
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataBarLineChart = $result;

        $sql = "
				SELECT 
				jeniskasuspenyakit_nama as jenis, sum(jumlah) as jumlah
				FROM kasuspenyakitpasien_r
				WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
				GROUP BY jenis
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
            case 'bulan' : $criteria->select = array('jeniskasuspenyakit_id as id, jeniskasuspenyakit_nama as jenis, sum(jumlah) as jumlah');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'jenis, id';
                $criteria->order = 'jumlah DESC';
                break;
            case 'tahun' : $criteria->select = array('jeniskasuspenyakit_id as id, jeniskasuspenyakit_nama as jenis, sum(jumlah) as jumlah');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'jenis, id';
                $criteria->order = 'jumlah DESC';
                break;
            default : $criteria->select = array('jeniskasuspenyakit_id as id, jeniskasuspenyakit_nama as jenis, sum(jumlah) as jumlah');
                $criteria->addBetweenCondition('DATE(tanggal)', $model->tgl_awal, $model->tgl_akhir);
                $criteria->group = 'jenis, id';
                $criteria->order = 'jumlah DESC';
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
            'dataTable' => $dataTable
        ));
    }

}

?>
<?php

class PegawaiBaruController extends MyAuthController {

	public $path_view = 'sistemInformasiEksekutif.views.pegawaiBaru.';

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

		$format = new MyFormatter();
		$model = new SEPegawaibaruR();
		$model->unsetAttributes();
		$model->jns_periode = "hari";
		$model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
		$model->tgl_akhir = date('Y-m-d');
		$model->bln_awal = date('Y-m', strtotime('first day of january'));
		$model->bln_akhir = date('Y-m');
		$model->thn_awal = date('Y');
		$model->thn_akhir = date('Y');

		if (isset($_GET['SEPegawaibaruR'])) {
			$model->attributes = $_GET['SEPegawaibaruR'];
			$model->jns_periode = $_GET['SEPegawaibaruR']['jns_periode'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['SEPegawaibaruR']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['SEPegawaibaruR']['tgl_akhir']);
			$model->bln_awal = $format->formatMonthForDb($_GET['SEPegawaibaruR']['bln_awal']);
			$model->bln_akhir = $format->formatMonthForDb($_GET['SEPegawaibaruR']['bln_akhir']);
			$bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
			$model->thn_awal = $_GET['SEPegawaibaruR']['thn_awal'];
			$model->thn_akhir = $_GET['SEPegawaibaruR']['thn_akhir'];
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
										date_trunc('month', tanggal) as periode, sum(jumlah) as jumlah
										FROM pegawaibaru_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
										GROUP BY periode
										ORDER BY periode ASC
									";
				break;
			case 'tahun' : $sql = "
										SELECT 
										date_trunc('year', tanggal) as periode, sum(jumlah) as jumlah
										FROM pegawaibaru_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
										GROUP BY periode
										ORDER BY periode ASC

									";
				break;
			default : $sql = "
										SELECT 
										date_trunc('day', tanggal) as periode, sum(jumlah) as jumlah
										FROM pegawaibaru_r
										WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
										GROUP BY periode
										ORDER BY periode ASC

									";
		}

		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataBarLineChart = $result;

		$sql = "
				SELECT 
				sum(jumlah) as jumlah
				FROM pegawaibaru_r
				WHERE DATE(tanggal) BETWEEN '" . $model->tgl_awal . "' AND '" . $model->tgl_akhir . "'
				";


		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataPie = $result;

		foreach ($dataPie as $key => $value) {
			if ($key == "jumlah_ri") {
				$key = "Rawat Inap";
			} elseif ($key == "jumlah_rd") {
				$key = "Rawat Darurat";
			} else {
				$key = "Rawat Jalan";
			}
			$temp['jenis'] = $key;
			$temp['jumlah'] = $value;

			array_push($dataPieChart, $temp);
		}
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

//		$model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_awal))));
//		$model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d', (strtotime($model->tgl_akhir))));
//		$model->bln_awal = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_awal))));
//		$model->bln_akhir = $format->formatMonthForUser(date('Y-m', (strtotime($model->bln_akhir))));

		$this->render($this->path_view.'dashboard', array(
			'model' => $model,
			'dataBarLineChart' => $dataBarLineChart,
			'dataPieChart' => $dataPieChart,
			'dataTable' => $dataTable,
			'format' => $format
		));
	}

}

?>
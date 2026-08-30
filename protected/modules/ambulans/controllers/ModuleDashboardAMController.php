<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardAMController extends ModuleDashboardNeonController
{
	public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
	public function actionIndex()
	{
		$this->pageTitle = Yii::app()->name . " - Dashboard Ambulan";
		$this->render('index');
	}

	/**
	 * menampilkan halaman dashboard (iframe)
	 * beberapa menggunakan DAO (createCommand) agar lebih cepat
	 */
	public function actionSetIFrameDashboard()
	{

		$this->layout = '//layouts/iframeNeon';
		$format = new MyFormatter();
		//=== start 4 kolom ===
		$dataKolom = array();
		$dataAreaChart = array();
		$dataLineChart = array();
		$dataDonutChart = array();
		$dataPieChart = array();
		$dataBarChart = array();

		$sql = "SELECT count (pesanambulans_t) AS jumlah
				FROM pesanambulans_t 
				WHERE pendaftaran_id IS NULL
                AND DATE(tglpemesananambulans) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[1] = $result['jumlah'];

		$sql = "SELECT count (pesanambulans_t) AS jumlah
				FROM pesanambulans_t 
				WHERE pendaftaran_id IS NOT NULL
				AND date(tglpemesananambulans) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[2] = $result['jumlah'];

		$sql = "SELECT count (pemakaianambulans_id) AS jumlah
				FROM pemakaianambulans_t 
				WHERE date(tglpemakaianambulans) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[3] = $result['jumlah'];

		$sql = "SELECT count (batalpakaiambulans_id) AS jumlah
				FROM batalpakaiambulans_t 
				WHERE date(tglpembatalan) = '" . date('Y-m-d') . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[4] = $result['jumlah'];

		//=== end 4 kolom ===

		//=== chart ===
		$sql = "SELECT count (pesanambulans_t) AS jumlah , date(tglpemesananambulans) as tglpemesananambulans
				FROM pesanambulans_t 
				WHERE date(tglpemesananambulans) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY date(tglpemesananambulans)
				ORDER BY date(tglpemesananambulans)";
		$result = Yii::app()->db->createCommand($sql)->queryAll();

		$dataAreaChart = $result;
		//=== chart ===
		$sql = "SELECT count (pesanambulans_t) AS jumlah_1 ,DATE(tglpemesananambulans) as tglpemesananambulans
				FROM pesanambulans_t 
				WHERE pendaftaran_id IS NULL
				AND date(tglpemesananambulans) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglpemesananambulans)
				ORDER BY tglpemesananambulans";
		$result_1 = Yii::app()->db->createCommand($sql)->queryAll();
		$sql = "SELECT count (pesanambulans_t) AS jumlah_2,DATE(tglpemesananambulans) as tglpemesananambulans
				FROM pesanambulans_t 
				WHERE pendaftaran_id IS NOT NULL
				AND date(tglpemesananambulans) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglpemesananambulans)
				ORDER BY tglpemesananambulans";
		$result_2 = Yii::app()->db->createCommand($sql)->queryAll();
		$dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'tglpemesananambulans');

		$sql = "SELECT count (pesanambulans_t)  AS jumlah,instalasi_m.instalasi_nama
				FROM pesanambulans_t 
				JOIN ruangan_m ON ruangan_m.ruangan_id = pesanambulans_t.ruangan_id
				JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id
				WHERE instalasi_m.instalasi_id = any(array[" . PARAMS::INSTALASI_ID_RJ . "," . PARAMS::INSTALASI_ID_RD . "," . PARAMS::INSTALASI_ID_RI . "])
				AND date(tglpemesananambulans) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY instalasi_m.instalasi_nama";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataDonutChart = $result;

		$sql = "SELECT count (pemakaianambulans_t.mobilambulans_id) AS jumlah,mobilambulans_m.nopolisi 
				FROM pemakaianambulans_t 
				JOIN mobilambulans_m ON mobilambulans_m.mobilambulans_id=pemakaianambulans_t.mobilambulans_id
                WHERE date(tglpemakaianambulans) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY mobilambulans_m.nopolisi 
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataPieChart = $result;

		$sql = "SELECT count (pemakaianambulans_id) AS jumlah
				FROM pemakaianambulans_t 
				WHERE date(tglpemakaianambulans) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[5] = $result['jumlah'];

		$sql = "SELECT count (batalpakaiambulans_id) AS jumlah
				FROM batalpakaiambulans_t 
				WHERE date(tglpembatalan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
		$result = Yii::app()->db->createCommand($sql)->queryRow();
		$dataKolom[6] = $result['jumlah'];



		$sql = "SELECT count (kelurahan_nama) AS jumlah,kelurahan_nama 
				FROM pemakaianambulans_t 
				GROUP BY kelurahan_nama
				LIMIT 10";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataBarChart = $result;
		//=== end chart ===

		//=== start table ===
		// $criteria_updatepasien = new CDbCriteria();
		// $criteria_updatepasien->limit=5;
		// $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
		// $dataTable = LKPendaftaranMp::model()->findAll($criteria_updatepasien);


		$dataTable = new AMPesanambulansT();

		//=== end table ===

		//=== start todo list ===
		$modTodolist = new PPTodolistR;
		$dataProviderTodolist = $modTodolist->searchTodolistWidget();
		//=== end todo list ===

		//=== start map ===
		$sql = "SELECT count(latitude) AS jumlah,longitude,latitude,kelurahan_nama 
				FROM pemakaianambulans_t
                WHERE date(tglpemakaianambulans) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY longitude,latitude,kelurahan_nama 
				";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$dataMap = $result;
		//=== end map ===

		$this->render('dashboard', array(
			'dataKolom' => $dataKolom,
			'dataAreaChart' => $dataAreaChart,
			'dataLineChart' => $dataLineChart,
			'dataDonutChart' => $dataDonutChart,
			'dataPieChart' => $dataPieChart,
			'dataBarChart' => $dataBarChart,
			'dataTable' => $dataTable,
			'modTodolist' => $modTodolist,
			'dataProviderTodolist' => $dataProviderTodolist,
			'dataMap' => $dataMap,
		));
	}

	public function actionSetKabupaten() {
		if (Yii::app()->request->isAjaxRequest) {
			$data = array();
			$kabupaten = (isset($_POST['kabupaten']) ? trim($_POST['kabupaten']) : null);
	
			$criteria = new CDbCriteria();
			$criteria->select = "kecamatan_m.kecamatan_nama,kabupaten_m.kabupaten_nama as kabupaten_nama,kabupaten_m.longitude as logitude_kab, kabupaten_m.latitude as latitude_kab,  kecamatan_m.longitude, kecamatan_m.latitude, COUNT(pasien_m.pasien_id) AS jumlah";
			$criteria->join = 'JOIN pasien_m ON bayaruangmuka_t.pasien_id = pasien_m.pasien_id
					JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
			JOIN kabupaten_m ON kabupaten_m.kabupaten_id = pegawai_m.kabupaten_id';
			$criteria->group = "kecamatan_m.kecamatan_nama,kabupaten_m.kabupaten_nama as kabupaten_nama,kabupaten_m.longitude as logitude_kab, kabupaten_m.latitude as latitude_kab,  kecamatan_m.longitude, kecamatan_m.latitude";
			$criteria->compare('LOWER(kabupaten_m.kabupaten_nama)', strtolower($kabupaten), true);
	
			$model = BayaruangmukaT::model()->findAll($criteria);
	
			$pas = array();
			if (count($model) > 0) {
				foreach ($model as $i => $map) {
					if ($map['latitude'] != '' && $map['latitude'] != '') {
						$pas[$i]['latitude'] = $map->latitude;
						$pas[$i]['longitude'] = $map->longitude;
						$pas[$i]['kecamatan_nama'] = $map->kecamatan_nama;
						$pas[$i]['jumlah'] = $map->jumlah;
					}
				}
	
				$data['pasien'] = count($pas);
				$data['loadpasien'] = $pas;
			} else {
				$data['pasien'] = 0;
				$data['loadpasien'] = array();
			}
	
			echo CJSON::encode($data);
			Yii::app()->end();
		} else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}
}

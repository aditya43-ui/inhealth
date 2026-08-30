<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");
class ModuleDashboardRDController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Rawat Darurat";
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

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM infokunjunganrd_v
				WHERE DATE(tgl_pendaftaran) = '" . date('Y-m-d') . "'
					AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM laporantindaklanjutrd_v
				WHERE DATE(tglpasienpulang) = '" . date('Y-m-d') . "'
					AND create_ruangan = '" . Yii::app()->user->getState('ruangan_id') . "'
					AND carakeluar_id = '" . Params::CARAKELUAR_ID_RAWATINAP . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM laporantindaklanjutrd_v
				WHERE DATE(tglpasienpulang) = '" . date('Y-m-d') . "'
					AND create_ruangan = '" . Yii::app()->user->getState('ruangan_id') . "'
					AND carakeluar_id = '" . Params::CARAKELUAR_ID_DIPULANGKAN . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM laporantindaklanjutrd_v
				WHERE DATE(tglpasienpulang) = '" . date('Y-m-d') . "'
					AND create_ruangan = '" . Yii::app()->user->getState('ruangan_id') . "'
					AND carakeluar_id = '" . Params::CARAKELUAR_ID_MENINGGAL . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah
				FROM infokunjunganrd_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_1
				FROM infokunjunganrd_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
					AND statuspasien LIKE '%" . PARAMS::STATUSPASIEN_BARU . "%'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_2
				FROM infokunjunganrd_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
					AND statuspasien LIKE '%" . PARAMS::STATUSPASIEN_LAMA . "%'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_3
				FROM infokunjunganrd_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
					AND kunjungan LIKE '%" . PARAMS::STATUSKUNJUNGAN_BARU . "%'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_3 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_4
				FROM infokunjunganrd_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
					AND kunjungan LIKE '%" . PARAMS::STATUSKUNJUNGAN_LAMA . "%'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_4 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_5
				FROM infokunjunganrd_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
					AND LOWER(statusmasuk) = '" . strtolower(Params::STATUSMASUK_RUJUKAN) . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_5 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_6
				FROM infokunjunganrd_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
					AND LOWER(statusmasuk) = '" . strtolower(Params::STATUSMASUK_NONRUJUKAN) . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_6 = Yii::app()->db->createCommand($sql)->queryAll();
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataAreaChart, $result_1, 'tgl_pendaftaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tgl_pendaftaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_3, 'tgl_pendaftaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_4, 'tgl_pendaftaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_5, 'tgl_pendaftaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_6, 'tgl_pendaftaran');

    $sql = "SELECT keadaanmasuk,count(pendaftaran_id) as jumlah
				FROM infokunjunganrd_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
				GROUP BY keadaanmasuk
				ORDER BY keadaanmasuk ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT carabayar_nama, count(pendaftaran_id) as jumlah
				FROM infokunjunganrd_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
				GROUP BY carabayar_nama
				ORDER BY carabayar_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(pendaftaran_t.pendaftaran_id) AS jumlah
				FROM pendaftaran_t
				LEFT JOIN pasienkecelakaan_t ON pasienkecelakaan_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
				WHERE DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND pendaftaran_t.no_pendaftaran ILIKE '" . Yii::app()->user->getState('instalasi_singkatan') . "%'
					AND pasienkecelakaan_t.pasienkecelakaan_id is not null
					AND pendaftaran_t.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(pendaftaran_t.pendaftaran_id) AS jumlah
				FROM pendaftaran_t
				LEFT JOIN pasienkecelakaan_t ON pasienkecelakaan_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
				WHERE DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND pendaftaran_t.no_pendaftaran ILIKE '" . Yii::app()->user->getState('instalasi_singkatan') . "%'
					AND pasienkecelakaan_t.pasienkecelakaan_id is null
					AND pendaftaran_t.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];


    $sql = "SELECT diagnosa_nama,count(diagnosa_id) as jumlah
				FROM laporan10besarpenyakit_v
				WHERE instalasi_id = " . Params::INSTALASI_ID_RD . "
					AND ruangan_id = " . Yii::app()->user->getState('ruangan_id') . "
					AND date_part('year',tglmorbiditas) = '" . date('Y') . "'
				GROUP BY diagnosa_nama
				ORDER BY jumlah DESC
				LIMIT 10";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    $criteria_updatepasien = new CDbCriteria();
    $criteria_updatepasien->limit = 10;
    $criteria_updatepasien->addCondition('ruanganasal_id = ' . Yii::app()->user->getState('ruangan_id'));
    $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
    $dataTable = RDLaporankepenunjangrd::model()->findAll($criteria_updatepasien);


    $dataTable = new RDLaporankepenunjangrd("searchTable");

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,kabupaten_m.longitude as longitude_kab,kabupaten_m.latitude as latitude_kab,kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
				FROM pasienmorbiditas_t
				JOIN pasien_m ON pasienmorbiditas_t.pasien_id = pasien_m.pasien_id
				JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
				JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
				JOIN kabupaten_m ON pasien_m.kabupaten_id = kabupaten_m.kabupaten_id
				WHERE date_part('year',tglmorbiditas) = '" . date('Y') . "'
				GROUP BY kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,longitude_kab,latitude_kab,kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
				ORDER BY jumlah DESC
				LIMIT 10
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataMap = $result;
    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
    $latitude = $modPropinsi->latitude;
    $longitude = $modPropinsi->longitude;
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
      'latitude' => $latitude,
      'longitude' => $longitude,
    ));
  }

  /**
   * menampilkan data kecamatan berdasarkan diagnosa_id dari ajax
   * @throws CHttpException
   */
  public function actionSetKecamatan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $dataMap = array();
      $diagnosa_id = (isset($_POST['diagnosa_id']) ? $_POST['diagnosa_id'] : null);
      if (!empty($diagnosa_id)) {
        //=== start map ===
        $sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
						FROM pasienmorbiditas_t
						JOIN pasien_m ON pasienmorbiditas_t.pasien_id = pasien_m.pasien_id
						JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
						JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
						WHERE date_part('year',tglmorbiditas) = '" . date('Y') . "' AND diagnosa_m.diagnosa_id = '" . $diagnosa_id . "'
						GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama
						ORDER BY jumlah DESC
						LIMIT 10
						";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $dataMap = $result;
        //=== end map ===
      } else {
      }
      if (count((array)$dataMap) > 0) {
        foreach ($dataMap as $i => $map) {
          $data[$i]['latitude'] = $map['latitude'];
          $data[$i]['longitude'] = $map['longitude'];
          $data[$i]['kecamatan_nama'] = $map['kecamatan_nama'];
        }
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}

<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardPSController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Persalinan";
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

    $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM persalinan_t
                WHERE DATE(tglmelahirkan) = '" . date('Y-m-d') . "' AND jmlkelahiranhidup > 0";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM persalinan_t
                WHERE DATE(tglmelahirkan) = '" . date('Y-m-d') . "' AND jmlkelahiranmati > 0";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM persalinan_t
                WHERE DATE(tglabortus) = '" . date('Y-m-d') . "' AND jmlabortus > 0";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM infokunjunganpersalinan_v
                WHERE DATE(tgl_meninggal) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT DATE(tglmelahirkan) as tglmelahirkan, count(pasien_id) as jumlah
				FROM persalinan_t
				WHERE DATE(tglmelahirkan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglmelahirkan)
				ORDER BY tglmelahirkan ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT DATE(tgllahirbayi) as tgllahirbayi, count(kelahiranbayi_id) as jumlah_1
				FROM kelahiranbayi_t
				WHERE DATE(tgllahirbayi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND islahirtunggal = true
				GROUP BY DATE(tgllahirbayi)
				ORDER BY tgllahirbayi ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tgllahirbayi) as tgllahirbayi, count(kelahiranbayi_id) as jumlah_1
				FROM kelahiranbayi_t
				WHERE DATE(tgllahirbayi) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND islahirtunggal = false
				GROUP BY DATE(tgllahirbayi)
				ORDER BY tgllahirbayi ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_1, 'tgllahirbayi');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tgllahirbayi');

    $sql = "SELECT asalrujukan_nama, count(pasien_id) as jumlah
				FROM infokunjunganpersalinan_v
				WHERE DATE(tanggal_lahir) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY asalrujukan_nama
				ORDER BY asalrujukan_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT carabayar_m.carabayar_nama, count(pendaftaran_t.pendaftaran_id) as jumlah
				FROM pendaftaran_t
				JOIN carabayar_m ON carabayar_m.carabayar_id = pendaftaran_t.carabayar_id
				WHERE DATE(pendaftaran_t.tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND pendaftaran_t.instalasi_id = 38
				GROUP BY carabayar_m.carabayar_nama
				ORDER BY carabayar_m.carabayar_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(pasien_id) AS jumlah
				FROM persalinan_t
				WHERE DATE(tglmelahirkan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND LOWER(carapersalinan) = 'normal'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
				FROM persalinan_t
				WHERE DATE(tglmelahirkan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND LOWER(carapersalinan) != 'normal'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];



    $sql = "SELECT diagnosa_nama,count(diagnosa_id) as jumlah
				FROM laporan10besarpenyakit_v
				WHERE ruangan_id = " . Yii::app()->user->getState('ruangan_id') . "
					AND date_part('year',tglmorbiditas) = '" . date('Y') . "'
				GROUP BY diagnosa_nama
				ORDER BY jumlah DESC
				LIMIT 10";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    // $criteria_updatepasien = new CDbCriteria();
    // $criteria_updatepasien->limit=5;
    // $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
    // $dataTable = LKPendaftaranMp::model()->findAll($criteria_updatepasien);


    $dataTable = new PSPersalinanT("search10Terakhir");

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,kabupaten_m.longitude as longitude_kab,kabupaten_m.latitude as latitude_kab,kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				JOIN kecamatan_m ON laporankunjunganrs_v.kecamatan_id = kecamatan_m.kecamatan_id
				JOIN kabupaten_m ON laporankunjunganrs_v.kabupaten_id = kabupaten_m.kabupaten_id
				WHERE date_part('year',tgl_pendaftaran) = '" . date('Y') . "'
					AND (
						instalasi_id = 38
					)
				GROUP BY kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,longitude_kab,latitude_kab,kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				LIMIT 10
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
}

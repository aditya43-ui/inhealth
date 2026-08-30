<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");
/**
 * controller utama dashboard rehab medis
 * 
 * @package application.modules.rehabMedis
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class ModuleDashboardRMController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Rehab Medis";
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

    $sql = "SELECT COUNT(pasienmasukpenunjang_t.pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_t
				JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
				JOIN ruangan_m ruanganasal_m ON ruanganasal_m.ruangan_id = pasienmasukpenunjang_t.ruanganasal_id
				WHERE DATE(tglmasukpenunjang) = '" . date('Y-m-d') . "'
				AND ruangan_m.instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND ruanganasal_m.instalasi_id <> " . Yii::app()->user->getState('instalasi_id');
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT COUNT(pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_t
				JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
				JOIN ruangan_m ruanganasal_m ON ruanganasal_m.ruangan_id = pasienmasukpenunjang_t.ruanganasal_id
				WHERE DATE(tglmasukpenunjang) = '" . date('Y-m-d') . "'
				AND ruangan_m.instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND ruanganasal_m.instalasi_id <> " . Yii::app()->user->getState('instalasi_id');
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT count (hasilpemeriksaanrm_id) as jumlah 
				FROM hasilpemeriksaanrm_t 
				WHERE DATE(tglpemeriksaanrm) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT count (pasienmasukpenunjang_id) as jumlah 
				FROM pasienmasukpenunjang_t 
				JOIN ruangan_m ON ruangan_m.ruangan_id=pasienmasukpenunjang_t.ruangan_id
				JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id
				WHERE instalasi_m.instalasi_id= " . PARAMS::INSTALASI_ID_REHAB . "
				AND statusperiksa='" . PARAMS::STATUSPERIKSA_ANTRIAN . "'
				AND date(tglmasukpenunjang) = '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT count (pasienmasukpenunjang_id) as jumlah, date(tglmasukpenunjang) as tglmasukpenunjang
				FROM pasienmasukpenunjang_t 
				JOIN ruangan_m ON ruangan_m.ruangan_id=pasienmasukpenunjang_t.ruangan_id
				JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id
				WHERE instalasi_m.instalasi_id= " . PARAMS::INSTALASI_ID_REHAB . "
				AND date(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY date(tglmasukpenunjang)
				ORDER BY date(tglmasukpenunjang)";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT count (pasienmasukpenunjang_id) as jumlah,jeniskasuspenyakit_m.jeniskasuspenyakit_nama , date(tglmasukpenunjang) AS tglmasukpenunjang
				FROM pasienmasukpenunjang_t 
				JOIN ruangan_m ON ruangan_m.ruangan_id=pasienmasukpenunjang_t.ruangan_id
				JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id
				JOIN jeniskasuspenyakit_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id=pasienmasukpenunjang_t.jeniskasuspenyakit_id
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_REHAB . "
				AND date(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY jeniskasuspenyakit_m.jeniskasuspenyakit_nama, date(tglmasukpenunjang)";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    foreach ($result as $key => $value) {
      if ($value['jeniskasuspenyakit_nama'] == 'Fisioterapi') {
        $temp['tglmasukpenunjang'] = $value['tglmasukpenunjang'];
        $temp['jumlah_1'] = $value['jumlah'];
      } else if ($value['jeniskasuspenyakit_nama'] == 'Okupasi Terapi') {
        $temp['tglmasukpenunjang'] = $value['tglmasukpenunjang'];
        $temp['jumlah_2'] = $value['jumlah'];
      } else if ($value['jeniskasuspenyakit_nama'] == 'Terapi Wicara') {
        $temp['tglmasukpenunjang'] = $value['tglmasukpenunjang'];
        $temp['jumlah_3'] = $value['jumlah'];
      } else if ($value['jeniskasuspenyakit_nama'] == 'Ortosis-Prostetis') {
        $temp['tglmasukpenunjang'] = $value['tglmasukpenunjang'];
        $temp['jumlah_4'] = $value['jumlah'];
      } else if ($value['jeniskasuspenyakit_nama'] == 'Psikologi') {
        $temp['tglmasukpenunjang'] = $value['tglmasukpenunjang'];
        $temp['jumlah_5'] = $value['jumlah'];
      } else {
        $temp['tglmasukpenunjang'] = $value['tglmasukpenunjang'];
        $temp['jumlah_6'] = $value['jumlah'];
      }

      array_push($dataLineChart, $temp);
    }

    $sql = "SELECT count (hasilpemeriksaanrm_id) as jumlah,tindakanrm_m.tindakanrm_nama 
				FROM hasilpemeriksaanrm_t 
				JOIN tindakanrm_m ON tindakanrm_m.tindakanrm_id=hasilpemeriksaanrm_t.tindakanrm_id
				AND date(tglpemeriksaanrm) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY tindakanrm_m.tindakanrm_nama";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama,carabayar_m.carabayar_nama, count (pasienmasukpenunjang_t.pasienmasukpenunjang_id) AS jumlah 
				FROM pasienmasukpenunjang_t 
				JOIN pendaftaran_t ON pasienmasukpenunjang_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				JOIN carabayar_m ON carabayar_m.carabayar_id = pendaftaran_t.carabayar_id
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_REHAB . "
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama,carabayar_m.carabayar_nama";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT count (pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_t 
				JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id=pasienmasukpenunjang_t.pendaftaran_id
				JOIN ruangan_m ON ruangan_m.ruangan_id=pasienmasukpenunjang_t.ruangan_id
				JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_REHAB . "
				AND statusmasuk = '" . PARAMS::STATUSMASUK_RUJUKAN . "'
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT count (pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_t 
				JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id=pasienmasukpenunjang_t.pendaftaran_id
				JOIN ruangan_m ON ruangan_m.ruangan_id=pasienmasukpenunjang_t.ruangan_id
				JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_REHAB . "
				AND statusmasuk = '" . PARAMS::STATUSMASUK_NONRUJUKAN . "'
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];


    $sql = "SELECT count (hasilpemeriksaanrm_id) as jumlah,tindakanrm_m.tindakanrm_nama 
				FROM hasilpemeriksaanrm_t 
				JOIN tindakanrm_m ON tindakanrm_m.tindakanrm_id=hasilpemeriksaanrm_t.tindakanrm_id
				GROUP BY tindakanrm_m.tindakanrm_nama
				ORDER BY jumlah desc";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    $dataTable = new RMPasienMasukPenunjangV();

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,kabupaten_m.longitude as longitude_kab,kabupaten_m.latitude as latitude_kab,pasien_m.kecamatan_id,kecamatan_m.kecamatan_nama,count (pasienmasukpenunjang_id) AS jumlah,kecamatan_m.longitude, kecamatan_m.latitude
				FROM pasienmasukpenunjang_t 
				JOIN pasien_m ON pasien_m.pasien_id = pasienmasukpenunjang_t.pasien_id
				JOIN kecamatan_m ON kecamatan_m.kecamatan_id = pasien_m.kecamatan_id
				JOIN kabupaten_m ON kabupaten_m.kabupaten_id = pasien_m.kabupaten_id
				JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_REHAB . "
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP by  kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,longitude_kab,latitude_kab,pasien_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC LIMIT 10
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
      $dataMap = array();
      $data = array();
      $diagnosa_id = (isset($_POST['diagnosa_id']) ? $_POST['diagnosa_id'] : null);
      if (!empty($diagnosa_id)) {
        //=== start map ===
        $sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
						FROM pasienmorbiditas_t
						JOIN pasien_m ON pasienmorbiditas_t.pasien_id = pasien_m.pasien_id
						JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
						JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
						WHERE DATE(tglmorbiditas) BETWEEN '" . date('Y-m') . "-01' AND '" . date('Y-m-d') . "'
						AND diagnosa_m.diagnosa_id = '" . $diagnosa_id . "'
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

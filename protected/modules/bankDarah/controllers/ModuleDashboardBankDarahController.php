<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardBankDarahController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
		$this->pageTitle = Yii::app()->name . " - Dashboard Bank Darah";
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
   
    $sql = "SELECT count (pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_t
				JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id=pasienmasukpenunjang_t.pendaftaran_id
				JOIN ruangan_m ON ruangan_m.ruangan_id=pasienmasukpenunjang_t.ruanganasal_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE ruangan_m.instalasi_id = " . PARAMS::INSTALASI_ID_RJ . " AND date(tglmasukpenunjang) = '" . date('Y-m-d') . "'
				AND pasienmasukpenunjang_t.ruangan_id=" . Yii::app()->user->getState('ruangan_id') . "
				GROUP BY tglmasukpenunjang";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
   
    $dataKolom[1] = $result['jumlah'] ?? 0;

    $sql = "SELECT count (pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_t
				JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id=pasienmasukpenunjang_t.pendaftaran_id
				JOIN ruangan_m ON ruangan_m.ruangan_id=pasienmasukpenunjang_t.ruanganasal_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE ruangan_m.instalasi_id = " . PARAMS::INSTALASI_ID_RI . " AND date(tglmasukpenunjang) = '" . date('Y-m-d') . "'
				AND pasienmasukpenunjang_t.ruangan_id=" . Yii::app()->user->getState('ruangan_id') . "
				GROUP BY tglmasukpenunjang  
				";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
   
    $dataKolom[2] = $result['jumlah'] ?? 0;

    $sql = "SELECT count (pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_t
				JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id=pasienmasukpenunjang_t.pendaftaran_id
				JOIN ruangan_m ON ruangan_m.ruangan_id=pasienmasukpenunjang_t.ruanganasal_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE ruangan_m.instalasi_id = " . PARAMS::INSTALASI_ID_RD . " AND date(tglmasukpenunjang) = '" . date('Y-m-d') . "'
				AND pasienmasukpenunjang_t.ruangan_id=" . Yii::app()->user->getState('ruangan_id') . "
				GROUP BY tglmasukpenunjang  
				";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah']??0;

    $sql = "SELECT COUNT(pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_t
				JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
				JOIN ruangan_m ruanganasal_m ON ruanganasal_m.ruangan_id = pasienmasukpenunjang_t.ruanganasal_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE DATE(tglmasukpenunjang)= '" . date('Y-m-d') . "'
				AND instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_LAB . "
				AND pasienmasukpenunjang_t.ruangan_id=" . Yii::app()->user->getState('ruangan_id') . "";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah']??0;
    
    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT count (pasienmasukpenunjang_id) AS jumlah, DATE(tglmasukpenunjang) AS tglmasukpenunjang
				FROM pasienmasukpenunjang_t 
				JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_LAB . "
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY DATE(tglmasukpenunjang)";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT count (pasienmasukpenunjang_id) AS jumlah_1, DATE(tglmasukpenunjang) AS tglmasukpenunjang
				FROM pasienmasukpenunjang_t 
				JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_LAB . " AND pasienmasukpenunjang_t.kunjungan= '" . PARAMS::STATUSKUNJUNGAN_BARU . "'
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY DATE(tglmasukpenunjang)";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT count (pasienmasukpenunjang_id) AS jumlah_2, DATE(tglmasukpenunjang) AS tglmasukpenunjang
				FROM pasienmasukpenunjang_t 
				JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_LAB . " AND pasienmasukpenunjang_t.kunjungan='" . PARAMS::STATUSKUNJUNGAN_LAMA . "'
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglmasukpenunjang)
				ORDER BY DATE(tglmasukpenunjang)";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'tglmasukpenunjang');

    $sql = "SELECT pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama,count (pasienmasukpenunjang_t.pasienmasukpenunjang_id) AS jumlah 
				FROM pasienmasukpenunjang_t 
				JOIN pendaftaran_t ON pasienmasukpenunjang_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_LAB . "
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama,count (pasienmasukpenunjang_t.pasienmasukpenunjang_id) AS jumlah 
				FROM pasienmasukpenunjang_t 
				JOIN pendaftaran_t ON pasienmasukpenunjang_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_LAB . "
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(pasienmasukpenunjang_t.pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_t
				JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
				JOIN ruangan_m ruanganasal_m ON ruanganasal_m.ruangan_id = pasienmasukpenunjang_t.ruanganasal_id
				WHERE DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND ruangan_m.instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND ruanganasal_m.instalasi_id <> " . Yii::app()->user->getState('instalasi_id');
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(pasienmasukpenunjang_id) AS jumlah
				FROM pasienmasukpenunjang_t
				JOIN ruangan_m ON ruangan_m.ruangan_id = pasienmasukpenunjang_t.ruangan_id
				JOIN ruangan_m ruanganasal_m ON ruanganasal_m.ruangan_id = pasienmasukpenunjang_t.ruanganasal_id
				WHERE DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND ruangan_m.instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND ruanganasal_m.instalasi_id <> " . Yii::app()->user->getState('instalasi_id');
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];



    $sql = "SELECT diagnosa_m.diagnosa_nama, count(pasienmorbiditas_id) as jumlah 
				FROM pasienmorbiditas_t
				JOIN diagnosa_m ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
				JOIN ruangan_m ON pasienmorbiditas_t.ruangan_id = ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
				WHERE ruangan_m.instalasi_id= " . PARAMS::INSTALASI_ID_LAB . "
				GROUP BY diagnosa_m.diagnosa_nama
				ORDER BY jumlah desc LIMIT 10;";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    // $criteria_updatepasien = new CDbCriteria();
    // $criteria_updatepasien->limit=5;
    // $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
    // $dataTable = BDPendaftaranMp::model()->findAll($criteria_updatepasien);


    $dataTable = new BDHasilPemeriksaanPAT();

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
				WHERE instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_LAB . "
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,longitude_kab,latitude_kab,pasien_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC LIMIT 10
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
		$sql = "SELECT kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,kabupaten_m.longitude as longitude_kab,kabupaten_m.latitude as latitude_kab,pasien_m.kecamatan_id,kecamatan_m.kecamatan_nama,count (pasienmasukpenunjang_id) AS jumlah,kecamatan_m.longitude, kecamatan_m.latitude
				FROM pasienmasukpenunjang_t 
				JOIN pasien_m ON pasien_m.pasien_id = pasienmasukpenunjang_t.pasien_id
				JOIN kecamatan_m ON kecamatan_m.kecamatan_id = pasien_m.kecamatan_id
				JOIN kabupaten_m ON kabupaten_m.kabupaten_id = pasien_m.kabupaten_id
				JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE kabupaten_m.kabupaten_nama = '".  $kabupaten ."'
				AND  instalasi_m.instalasi_id = " . PARAMS::INSTALASI_ID_LAB . "
				GROUP BY kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,longitude_kab,latitude_kab,pasien_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				
				";
    	$result = Yii::app()->db->createCommand($sql)->queryAll();
        $model = $result;
        $pas = array();
        if (count($model) > 0) {
            foreach ($model as $i => $map) {
				// var_dump($map['latitude']);die;
                if ($map['latitude'] != '' && $map['latitude'] != '') {
                    $pas[$i]['latitude'] = $map['latitude'];
                    $pas[$i]['longitude'] = $map['longitude'];
                    $pas[$i]['kecamatan_nama'] = $map['kecamatan_nama'];
                    $pas[$i]['jumlah'] = $map['jumlah'];
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

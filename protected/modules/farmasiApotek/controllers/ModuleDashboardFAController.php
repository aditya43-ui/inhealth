<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardFAController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Modul Farmasi / Apotek";
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
                FROM laporanpenjualanobat_v
                WHERE DATE(tglpenjualan) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM laporanpenjualanobat_v
                WHERE DATE(tglpenjualan) = '" . date('Y-m-d') . "' and racikan_id = " . Params::RACIKAN_ID_RACIKAN;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM laporanpenjualanobat_v
                WHERE DATE(tglpenjualan) = '" . date('Y-m-d') . "' and racikan_id = " . Params::RACIKAN_ID_NONRACIKAN;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM informasipenjualanresep_v
                WHERE DATE(tglresep) = '" . date('Y-m-d') . "' and jenispenjualan = '" . Params::JENISPENJUALAN_RESEP . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT DATE(tglpenjualan) as tglpenjualan, sum(hargajual_oa) as jumlah
				FROM laporanpendapatanfarmasi_v
				WHERE DATE(tglpenjualan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND ruangan_id = " . Yii::app()->user->getState('ruangan_id') . "
				GROUP BY DATE(tglpenjualan)
				ORDER BY tglpenjualan ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT DATE(tglpenjualan) as tglpenjualan, sum(hargajual_oa) as jumlah_1
				FROM laporanpendapatanfarmasi_v
				WHERE DATE(tglpenjualan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglpenjualan)
				ORDER BY tglpenjualan ASC";
    $dataLineChart = Yii::app()->db->createCommand($sql)->queryAll();

    $sql = "SELECT jenispenjualan, sum(totalhargajual) as jumlah
				FROM penjualanresep_t
				WHERE DATE(tglpenjualan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
                AND ruangan_id = " . Yii::app()->user->getState('ruangan_id') . "
				GROUP BY jenispenjualan
				ORDER BY jenispenjualan ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT jenisobatalkes_nama, count(penjualanresep_id) as jumlah
				FROM laporanpenjualanjenisoa_v 
				WHERE DATE(tglresep) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY jenisobatalkes_nama
				ORDER BY jenisobatalkes_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(pasien_id) AS jumlah
				FROM laporanpenjualanobat_v
				WHERE DATE(tglpenjualan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND racikan_id = " . Params::RACIKAN_ID_RACIKAN;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
				FROM laporanpenjualanobat_v
				WHERE DATE(tglpenjualan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND racikan_id = " . Params::RACIKAN_ID_NONRACIKAN;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];



    $sql = "SELECT jnskelompok, sum(infostokobatalkesruangan_v.hargajual) AS hargajual
				FROM infostokobatalkesruangan_v JOIN obatalkes_m ON infostokobatalkesruangan_v.obatalkes_id = obatalkes_m.obatalkes_id
				WHERE ruangan_id = 59 GROUP BY jnskelompok";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    // $criteria_updatepasien = new CDbCriteria();
    // $criteria_updatepasien->limit=5;
    // $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
    // $dataTable = LKPendaftaranMp::model()->findAll($criteria_updatepasien);


    $dataTable = new FALaporanpenjualanobatV('search10Besar');

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kabupaten_m.kabupaten_nama as kabupaten_nama,kabupaten_m.longitude as longitude_kab, kabupaten_m.latitude as latitude_kab,  kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				JOIN kecamatan_m ON pasienmasukpenunjang_v.kecamatan_id = kecamatan_m.kecamatan_id
				JOIN kabupaten_m ON pasienmasukpenunjang_v.kabupaten_id = kabupaten_m.kabupaten_id
				WHERE date_part('year',tgl_pendaftaran) = '" . date('Y') . "'
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama,kabupaten_m.kabupaten_nama,longitude_kab, latitude_kab,  kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
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

      
        $sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kabupaten_m.kabupaten_nama as kabupaten_nama,kabupaten_m.longitude as longitude_kab, kabupaten_m.latitude as latitude_kab,  kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				JOIN kecamatan_m ON pasienmasukpenunjang_v.kecamatan_id = kecamatan_m.kecamatan_id
				JOIN kabupaten_m ON pasienmasukpenunjang_v.kabupaten_id = kabupaten_m.kabupaten_id
				WHERE date_part('year',tgl_pendaftaran) = '" . date('Y') . "'
				-- WHERE date_part('year',tgl_pendaftaran) = '" . date('Y') . "'
        AND kabupaten_m.kabupaten_nama = '" .strtolower($kabupaten) . "'
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama,kabupaten_m.kabupaten_nama,longitude_kab, latitude_kab,  kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				";
      $result = Yii::app()->db->createCommand($sql)->queryAll();
      $model = $result;

        $pas = array();
        if (count($model) > 0) {
            foreach ($model as $i => $map) {
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

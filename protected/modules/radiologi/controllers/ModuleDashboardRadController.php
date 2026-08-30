<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardRadController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Radiologi";
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
                FROM pasienmasukpenunjang_v
                WHERE DATE(tgl_pendaftaran) = '" . date('Y-m-d') . "' and instalasiasal_id = " . Params::INSTALASI_ID_RJ;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM pasienmasukpenunjang_v
                WHERE DATE(tgl_pendaftaran) = '" . date('Y-m-d') . "' and instalasiasal_id = " . Params::INSTALASI_ID_RI;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM pasienmasukpenunjang_v
                WHERE DATE(tgl_pendaftaran) = '" . date('Y-m-d') . "' and instalasiasal_id = " . Params::INSTALASI_ID_RD;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT COUNT(pasien_id) AS jumlah
                FROM pasienmasukpenunjang_v
                WHERE DATE(tgl_pendaftaran) = '" . date('Y-m-d') . "' and instalasiasal_id = " . Params::INSTALASI_ID_RAD;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
                AND instalasi_id = " . Params::INSTALASI_ID_RAD . "
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_1
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND statuspasien = '" . Params::STATUSPASIEN_BARU . "'
                    AND instalasi_id = " . Params::INSTALASI_ID_RAD . "
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_2
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND statuspasien = '" . Params::STATUSPASIEN_LAMA . "'
                    AND instalasi_id = " . Params::INSTALASI_ID_RAD . "
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataAreaChart, $result_1, 'tgl_pendaftaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tgl_pendaftaran');

    $sql = "SELECT penjamin_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
                AND instalasi_id = " . Params::INSTALASI_ID_RAD . "
				GROUP BY penjamin_nama
				ORDER BY penjamin_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    //		$sql = "SELECT carabayar_nama, count(pendaftaran_id) as jumlah
    //				FROM pasienmasukpenunjang_v
    //				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
    //                AND instalasi_id = ".Params::INSTALASI_ID_RAD."
    //				GROUP BY carabayar_nama
    //				ORDER BY carabayar_nama ASC";
    $sql = "
				SELECT 
				penjamin_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND penjamin_id IN (" . Params::PENJAMIN_ID_PISA . "," . Params::PENJAMIN_ID_PROKESPEN . ") 
				AND instalasi_id = " . Params::INSTALASI_ID_RAD . "
				GROUP BY penjamin_id, penjamin_nama
				UNION
				SELECT 
				'Lainnya'::CHARACTER VARYING(50) AS penjamin_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND penjamin_id NOT IN (" . Params::PENJAMIN_ID_PISA . "," . Params::PENJAMIN_ID_PROKESPEN . ") 
				AND instalasi_id = " . Params::INSTALASI_ID_RAD . "
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasi_id = " . Params::INSTALASI_ID_RAD . " AND instalasiasal_id <> " . Params::INSTALASI_ID_RAD;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasi_id = " . Params::INSTALASI_ID_RAD . " AND instalasiasal_id = " . Params::INSTALASI_ID_RAD;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];



    $sql = "SELECT jeniskasuspenyakit_nama, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasi_id = " . Params::INSTALASI_ID_RAD . "
				GROUP BY jeniskasuspenyakit_nama
				ORDER BY jeniskasuspenyakit_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    // $criteria_updatepasien = new CDbCriteria();
    // $criteria_updatepasien->limit=5;
    // $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
    // $dataTable = LKPendaftaranMp::model()->findAll($criteria_updatepasien);


    $dataTable = new ROPasienMasukPenunjangV("searchPemeriksaan");

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,kabupaten_m.longitude as longitude_kab,kabupaten_m.latitude as latitude_kab,kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM pasienmasukpenunjang_v
				JOIN kecamatan_m ON pasienmasukpenunjang_v.kecamatan_id = kecamatan_m.kecamatan_id
				JOIN kabupaten_m ON pasienmasukpenunjang_v.kabupaten_id = kabupaten_m.kabupaten_id
				WHERE date_part('year',tgl_pendaftaran) = '" . date('Y') . "'
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

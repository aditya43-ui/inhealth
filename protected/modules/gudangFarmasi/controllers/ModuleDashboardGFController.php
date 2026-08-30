<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");
class ModuleDashboardGFController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Gudang Farmasi";
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

    $sql = "SELECT COUNT(permintaanpenawaran_id) AS jumlah
				FROM informasipermintaanpenawaran_v
				WHERE DATE(tglpenawaran) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT COUNT(permintaanpembelian_id) AS jumlah
				FROM informasipermintaanpembelian_v
				WHERE DATE(tglpermintaanpembelian) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT sum(pemusnahanoadetail_t.jmlbarang) AS jumlah
				FROM pemusnahanobatalkes_t
				JOIN pemusnahanoadetail_t ON pemusnahanoadetail_t.pemusnahanobatalkes_id = pemusnahanobatalkes_t.pemusnahanobatalkes_id
				WHERE DATE(tglpemusnahan) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT COUNT(returpembelian_id) AS jumlah
				FROM returpembelian_t
				WHERE DATE(tglretur) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT DATE(tglmutasioa) as tglmutasioa, count(mutasioaruangan_id) as jumlah
				FROM informasimutasioaruangan_v
				WHERE DATE(tglmutasioa) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglmutasioa)
				ORDER BY tglmutasioa ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT DATE(tglmutasioa) as tglmutasioa, count(mutasioaruangan_id) as jumlah_1, instalasitujuanmutasi_nama
				FROM informasimutasioaruangan_v
				WHERE DATE(tglmutasioa) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasitujuanmutasi_id = '" . PARAMS::INSTALASI_ID_RJ . "'
				GROUP BY DATE(tglmutasioa), instalasitujuanmutasi_nama
				ORDER BY tglmutasioa, instalasitujuanmutasi_nama ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tglmutasioa) as tglmutasioa, count(mutasioaruangan_id) as jumlah_2, instalasitujuanmutasi_nama
				FROM informasimutasioaruangan_v
				WHERE DATE(tglmutasioa) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasitujuanmutasi_id = '" . PARAMS::INSTALASI_ID_RD . "'
				GROUP BY DATE(tglmutasioa), instalasitujuanmutasi_nama
				ORDER BY tglmutasioa, instalasitujuanmutasi_nama ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tglmutasioa) as tglmutasioa, count(mutasioaruangan_id) as jumlah_3, instalasitujuanmutasi_nama
				FROM informasimutasioaruangan_v
				WHERE DATE(tglmutasioa) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasitujuanmutasi_id = '" . PARAMS::INSTALASI_ID_RI . "'
				GROUP BY DATE(tglmutasioa), instalasitujuanmutasi_nama
				ORDER BY tglmutasioa, instalasitujuanmutasi_nama ASC";
    $result_3 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tglmutasioa) as tglmutasioa, count(mutasioaruangan_id) as jumlah_4, instalasitujuanmutasi_nama
				FROM informasimutasioaruangan_v
				WHERE DATE(tglmutasioa) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasitujuanmutasi_id = '" . PARAMS::INSTALASI_ID_FARMASI . "'
				GROUP BY DATE(tglmutasioa), instalasitujuanmutasi_nama
				ORDER BY tglmutasioa, instalasitujuanmutasi_nama ASC";
    $result_4 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tglmutasioa) as tglmutasioa, count(mutasioaruangan_id) as jumlah_5, instalasitujuanmutasi_nama
				FROM informasimutasioaruangan_v
				WHERE DATE(tglmutasioa) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasitujuanmutasi_id = '" . PARAMS::INSTALASI_ID_RAD . "'
				GROUP BY DATE(tglmutasioa), instalasitujuanmutasi_nama
				ORDER BY tglmutasioa, instalasitujuanmutasi_nama ASC";
    $result_5 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tglmutasioa) as tglmutasioa, count(mutasioaruangan_id) as jumlah_6, instalasitujuanmutasi_nama
				FROM informasimutasioaruangan_v
				WHERE DATE(tglmutasioa) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasitujuanmutasi_id = '" . PARAMS::INSTALASI_ID_LAB . "'
				GROUP BY DATE(tglmutasioa), instalasitujuanmutasi_nama
				ORDER BY tglmutasioa, instalasitujuanmutasi_nama ASC";
    $result_6 = Yii::app()->db->createCommand($sql)->queryAll();

    $dataLineChart = CustomFunction::joinTwo2DArrays($dataAreaChart, $result_1, 'tglmutasioa');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tglmutasioa');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_3, 'tglmutasioa');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_4, 'tglmutasioa');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_5, 'tglmutasioa');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_6, 'tglmutasioa');

    $sql = "SELECT ruanganasalmutasi_nama, count(mutasioaruangan_id) as jumlah
				FROM informasimutasioaruangan_v
				WHERE DATE(tglmutasioa) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY ruanganasalmutasi_nama
				ORDER BY ruanganasalmutasi_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT obatalkes_m.obatalkes_nama, sum(pesanoadetail_t.jmlpesan) as jumlah
				FROM pesanobatalkes_t
				JOIN pesanoadetail_t ON pesanoadetail_t.pesanobatalkes_id = pesanobatalkes_t.pesanobatalkes_id
				JOIN obatalkes_m ON obatalkes_m.obatalkes_id = pesanoadetail_t.obatalkes_id
				GROUP BY obatalkes_m.obatalkes_nama
				ORDER BY jumlah DESC
				LIMIT 10";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(fakturpembelian_id) AS jumlah
				FROM fakturpembelian_t
				WHERE DATE(tglfaktur) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(returpembelian_id) AS jumlah
				FROM returpembelian_t
				WHERE DATE(tglretur) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];


    $sql = "SELECT obatalkes_nama,count(obatalkes_id) as jumlah
				FROM infostokobatalkesruangan_v
				WHERE ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'
					AND tglkadaluarsa > '" . date("Y-m-d") . "'
				GROUP BY obatalkes_nama
				ORDER BY obatalkes_nama DESC
				LIMIT 10";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    $criteria_updatemutasi = new CDbCriteria();
    $criteria_updatemutasi->limit = 10;
    $criteria_updatemutasi->order = 'tglmutasioa DESC';
    $dataTable = GFInformasimutasioaruanganV::model()->findAll($criteria_updatemutasi);

    $dataTable = new GFInformasimutasioaruanganV("searchDashboard");

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT supplier_m.supplier_id,supplier_m.supplier_kabupaten, supplier_m.supplier_nama, supplier_m.supplier_alamat, supplier_m.longitude, supplier_m.latitude, COUNT(pembelianbarang_t.supplier_id) AS jumlah
				FROM pembelianbarang_t
				JOIN supplier_m ON supplier_m.supplier_id = pembelianbarang_t.supplier_id
				WHERE date_part('year',pembelianbarang_t.tglpembelian) = '" . date('Y') . "'
				GROUP BY supplier_m.supplier_id,supplier_m.supplier_kabupaten, supplier_m.supplier_nama, supplier_m.supplier_alamat, supplier_m.longitude, supplier_m.latitude
				ORDER BY jumlah DESC
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataMap = $result;

    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
    // $latitude = $modPropinsi->latitude;
    // $longitude = $modPropinsi->longitude;
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
      // 'latitude' => $latitude,
      // 'longitude' => $longitude,
    ));
  }

  
}

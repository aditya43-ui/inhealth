<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");
class ModuleDashboardGUController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Gudang Umum";
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

    $sql = "SELECT COUNT(pembelianbarang_id) AS jumlah
				FROM pembelianbarang_t
				WHERE DATE(tglpembelian) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT COUNT(terimapersediaan_id) AS jumlah
				FROM terimapersediaan_t
				WHERE DATE(tglterima) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT COUNT(returpenerimaan_id) AS jumlah
				FROM returpenerimaan_t
				WHERE DATE(tglreturterima) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT COUNT(mutasibrg_t.mutasibrg_id) AS jumlah
				FROM mutasibrg_t
                                LEFT JOIN batalmutasibrg_t ON batalmutasibrg_t.mutasibrg_id = mutasibrg_t.mutasibrg_id
				WHERE DATE(mutasibrg_t.tglmutasibrg) = '" . date('Y-m-d') . "' AND batalmutasibrg_t.mutasibrg_id IS NULL";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT DATE(tglmutasibrg) as tglmutasibrg, count(mutasibrg_id) as jumlah
				FROM mutasibrg_t
				WHERE DATE(tglmutasibrg) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglmutasibrg)
				ORDER BY tglmutasibrg ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT DATE(tglmutasibrg) as tglmutasibrg, count(mutasibrg_id) as jumlah_1
				FROM mutasibrg_t
				WHERE DATE(tglmutasibrg) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglmutasibrg)
				ORDER BY tglmutasibrg ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tglbatalmutasibrg) as tglmutasibrg, count(batalmutasibrg_id) as jumlah_2
				FROM batalmutasibrg_t
				WHERE DATE(tglbatalmutasibrg) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglbatalmutasibrg)
				ORDER BY tglmutasibrg ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_1, 'tglmutasibrg');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tglmutasibrg');

    $sql = "SELECT ruangan_m.ruangan_nama, count(mutasibrg_t.mutasibrg_id) as jumlah
				FROM mutasibrg_t
				JOIN ruangan_m ON ruangan_m.ruangan_id = mutasibrg_t.ruangantujuan_id
				WHERE DATE(mutasibrg_t.tglmutasibrg) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY ruangan_m.ruangan_nama
				ORDER BY ruangan_m.ruangan_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT barang_m.barang_nama, count(pesanbarangdetail_t.barang_id) as jumlah
				FROM pesanbarangdetail_t
				JOIN barang_m ON barang_m.barang_id = pesanbarangdetail_t.barang_id
				JOIN pesanbarang_t ON pesanbarang_t.pesanbarang_id = pesanbarangdetail_t.pesanbarang_id
				WHERE DATE(pesanbarang_t.tglpesanbarang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY barang_m.barang_nama
				ORDER BY barang_m.barang_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(terimapersediaan_id) AS jumlah
				FROM terimapersediaan_t
				WHERE DATE(tglterima) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(returpenerimaan_id) AS jumlah
				FROM returpenerimaan_t
				WHERE DATE(tglreturterima) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];


    $sql = "SELECT barang_m.barang_nama,count(belibrgdetail_t.barang_id) as jumlah
				FROM belibrgdetail_t
				JOIN pembelianbarang_t ON belibrgdetail_t.pembelianbarang_id = pembelianbarang_t.pembelianbarang_id
				JOIN barang_m ON barang_m.barang_id = belibrgdetail_t.barang_id
				WHERE date_part('year',pembelianbarang_t.tglpembelian) = '" . date('Y') . "'
				GROUP BY barang_m.barang_nama
				ORDER BY jumlah DESC
				LIMIT 10";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    $dataTable = new GUPembelianbarangT("search10Terakhir");

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT supplier_m.supplier_nama,supplier_m.supplier_kabupaten, supplier_m.supplier_alamat, supplier_m.longitude, supplier_m.latitude ,COUNT(pembelianbarang_t.supplier_id) AS jumlah
				FROM pembelianbarang_t
				JOIN supplier_m ON supplier_m.supplier_id = pembelianbarang_t.supplier_id
				WHERE date_part('year',pembelianbarang_t.tglpembelian) = '" . date('Y') . "'
				GROUP BY supplier_m.supplier_nama,supplier_m.supplier_kabupaten,supplier_m.supplier_alamat, supplier_m.longitude, supplier_m.latitude
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

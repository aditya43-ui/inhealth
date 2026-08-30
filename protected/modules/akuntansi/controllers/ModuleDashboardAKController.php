<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");
class ModuleDashboardAKController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Akuntansi";
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

    $sql = "SELECT SUM(totalharga) AS jumlah
				FROM penerimaanumum_t
				WHERE DATE(tglpenerimaan) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT SUM(totalharga) AS jumlah
				FROM pengeluaranumum_t
				WHERE DATE(tglpengeluaran) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT COUNT(batalkeluarumum_id) AS jumlah
				FROM batalkeluarumum_t
				WHERE DATE(tglbatalkeluar) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT COUNT(batalbayarsupplier_id) AS jumlah
				FROM batalbayarsupplier_t
				WHERE DATE(tglbatalbayar) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT DATE(tglpengeluaran) as tglpengeluaran, SUM(totalharga) AS jumlah
				FROM pengeluaranumum_t
				WHERE DATE(tglpengeluaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tglpengeluaran)
				ORDER BY tglpengeluaran ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    $sql = "SELECT DATE(tglpengeluaran) as tglpengeluaran , sum(totalharga) as jumlah_1
				FROM pengeluaranumum_t
				WHERE DATE(tglpengeluaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						AND LOWER(kelompoktransaksi) ILIKE '%KAS%'
				GROUP BY  DATE(tglpengeluaran)
				ORDER BY  tglpengeluaran ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tglpengeluaran) as tglpengeluaran , sum(totalharga) as jumlah_2
				FROM pengeluaranumum_t
				WHERE DATE(tglpengeluaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						AND LOWER(kelompoktransaksi) ILIKE '%NON KAS%'
				GROUP BY  DATE(tglpengeluaran)
				ORDER BY  tglpengeluaran ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();

    $dataLineChart = CustomFunction::joinTwo2DArrays($dataAreaChart, $result_1, 'tglpengeluaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tglpengeluaran');

    $sql = "SELECT jenispengeluaran_m.jenispengeluaran_nama, count(pengeluaranumum_t.pengeluaranumum_id) as jumlah
				FROM pengeluaranumum_t
				JOIN jenispengeluaran_m ON jenispengeluaran_m.jenispengeluaran_id = pengeluaranumum_t.jenispengeluaran_id
				WHERE DATE(pengeluaranumum_t.tglpengeluaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY jenispengeluaran_m.jenispengeluaran_nama
				ORDER BY jenispengeluaran_m.jenispengeluaran_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT jenispenerimaan_m.jenispenerimaan_nama, count(penerimaanumum_id) as jumlah
				FROM penerimaanumum_t
				JOIN jenispenerimaan_m ON jenispenerimaan_m.jenispenerimaan_id = penerimaanumum_t.jenispenerimaan_id
				WHERE DATE(penerimaanumum_t.tglpenerimaan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY jenispenerimaan_m.jenispenerimaan_nama
				ORDER BY jenispenerimaan_m.jenispenerimaan_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(penerimaanumum_id) AS jumlah
				FROM penerimaanumum_t
				WHERE DATE(tglpenerimaan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND LOWER(kelompoktransaksi) ILIKE '%KAS%'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(penerimaanumum_id) AS jumlah
				FROM penerimaanumum_t
				WHERE DATE(tglpenerimaan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND LOWER(kelompoktransaksi) ILIKE '%NON KAS%'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];


    $sql = "SELECT DATE(tglpenerimaan) as tglpenerimaan,count(returpenerimaanumum_id) as jumlah
				FROM penerimaanumum_t
				GROUP BY DATE(tglpenerimaan)
				ORDER BY tglpenerimaan DESC
				LIMIT 10";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    $criteria_faktur = new CDbCriteria();
    $criteria_faktur->limit = 10;
    $criteria_faktur->order = 'tgljatuhtempo ASC';
    $dataTable = AKFakturpembelianT::model()->findAll($criteria_faktur);


    $dataTable = new AKFakturpembelianT("search");

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama,kabupaten_m.kabupaten_nama as kabupaten_nama,kabupaten_m.longitude as logitude_kab, kabupaten_m.latitude as latitude_kab, kecamatan_m.longitude, kecamatan_m.latitude, COUNT(pasien_m.pasien_id) AS jumlah
				FROM bayaruangmuka_t
				JOIN pasien_m ON bayaruangmuka_t.pasien_id = pasien_m.pasien_id
				JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
        JOIN kabupaten_m ON kabupaten_m.kabupaten_id = pasien_m.kabupaten_id
				WHERE date_part('year',tgluangmuka) = '" . date('Y') . "'
				GROUP BY kecamatan_m.kecamatan_id,kecamatan_m.kecamatan_nama,kabupaten_m.kabupaten_nama,logitude_kab,  latitude_kab,  kecamatan_m.longitude, kecamatan_m.latitude
				
        --GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
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

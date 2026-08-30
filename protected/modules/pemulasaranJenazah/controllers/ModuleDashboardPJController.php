<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");

class ModuleDashboardPJController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Pemulasaran Jenazah";
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

    $sql = "SELECT count (ambiljenazah_id) AS jumlah
				FROM ambiljenazah_t 
				WHERE date(tglpengambilan) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT count (tindakanpelayanan_id) AS jumlah
				FROM tindakanpelayanan_t 
				WHERE daftartindakan_id = " . Params::DAFTARTINDAKAN_ID_PEMULASARAN_JENAZAH . " 
				AND date(tgl_tindakan) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT count(pasienmasukpenunjang_t.pendaftaran_id) AS jumlah
				FROM pasienmasukpenunjang_t
				JOIN pendaftaran_t ON pasienmasukpenunjang_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
				JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
				JOIN pasienpulang_t ON pendaftaran_t.pendaftaran_id = pasienpulang_t.pendaftaran_id
				JOIN carakeluar_m ON pasienpulang_t.carakeluar_id = carakeluar_m.carakeluar_id
				WHERE pasienpulang_t.pasienbatalpulang_id IS NULL 
				AND pasienbatalperiksa_id IS NULL 
				AND carakeluar_m.carakeluar_id = " . Params::CARAKELUAR_ID_MENINGGAL . "
				AND date(tglpasienpulang) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT count (pemakaianambulans_id) AS jumlah
				FROM pemakaianambulans_t
				JOIN mobilambulans_m ON mobilambulans_m.mobilambulans_id=pemakaianambulans_t.mobilambulans_id
				WHERE LOWER(mobilambulans_m.jeniskendaraan) = '" . strtolower(Params::JENISKENDARAAN_MOBIL_JENAZAH) . "'
				AND date(tglpemakaianambulans) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT count(tindakanpelayanan_id) AS jumlah, date(tgl_tindakan) AS tgl_tindakan
				FROM tindakanpelayanan_t
				JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id=tindakanpelayanan_t.daftartindakan_id
				JOIN kelompoktindakan_m ON kelompoktindakan_m.kelompoktindakan_id=daftartindakan_m.kelompoktindakan_id
				WHERE kelompoktindakan_m.kelompoktindakan_id= " . Params::KELOMPOKTINDAKAN_ID_PEMULASARAN_JENAZAH . "
				AND date(tgl_tindakan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY date(tgl_tindakan)
				ORDER BY date(tgl_tindakan)";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT count(tindakanpelayanan_id) AS jumlah,daftartindakan_m.daftartindakan_nama,date(tgl_tindakan) AS tgl_tindakan
				FROM tindakanpelayanan_t
				JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id=tindakanpelayanan_t.daftartindakan_id
				JOIN kelompoktindakan_m ON kelompoktindakan_m.kelompoktindakan_id=daftartindakan_m.kelompoktindakan_id
				WHERE kelompoktindakan_m.kelompoktindakan_id= " . Params::KELOMPOKTINDAKAN_ID_PEMULASARAN_JENAZAH . "
				AND date(tgl_tindakan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY daftartindakan_m.daftartindakan_nama,date(tgl_tindakan)
				ORDER BY date(tgl_tindakan)";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataLineChart = $result;


    $sql = "SELECT instalasiasal_m.instalasi_nama,count(pasienmasukpenunjang_id) as jumlah
				FROM pasienmasukpenunjang_t
				JOIN pendaftaran_t ON pasienmasukpenunjang_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
				JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
				JOIN ruangan_m ruanganasal_m ON pasienmasukpenunjang_t.ruangan_id=ruanganasal_m.ruangan_id
				JOIN instalasi_m instalasiasal_m ON ruanganasal_m.instalasi_id=instalasiasal_m.instalasi_id
				JOIN pasienpulang_t ON pendaftaran_t.pendaftaran_id = pasienpulang_t.pendaftaran_id
				JOIN carakeluar_m ON pasienpulang_t.carakeluar_id = carakeluar_m.carakeluar_id
				WHERE pasienpulang_t.pasienbatalpulang_id IS NULL 
				AND carakeluar_m.carakeluar_id = " . Params::CARAKELUAR_ID_MENINGGAL . " 
				AND date(tglpasienpulang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY instalasiasal_m.instalasi_nama";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;
    $sql = "SELECT pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama,count (pasienmasukpenunjang_t.pasienmasukpenunjang_id) AS jumlah 
				FROM pasienmasukpenunjang_t 
				JOIN pendaftaran_t ON pasienmasukpenunjang_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . Params::INSTALASI_ID_RAD . "
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT count (ambiljenazah_id) AS jumlah
				FROM ambiljenazah_t 
				WHERE date(tglpengambilan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT count (tindakanpelayanan_id) AS jumlah
				FROM tindakanpelayanan_t 
				WHERE daftartindakan_id =" . Params::DAFTARTINDAKAN_ID_PEMULASARAN_JENAZAH . " AND date(tgl_tindakan) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];



    $sql = "SELECT diagnosa_nama, count(pasienmorbiditas_id) as jumlah  
				FROM pasienmorbiditas_t
				JOIN diagnosa_m ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
				GROUP BY diagnosa_nama";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    $dataTable = new PJTindakanPelayananT();

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
				JOIN kabupaten_m ON  pasien_m.kabupaten_id = kabupaten_m.kabupaten_id
				JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id=ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id=instalasi_m.instalasi_id
				WHERE instalasi_m.instalasi_id = " . Params::INSTALASI_ID_JZ . "
				AND DATE(tglmasukpenunjang) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP by  kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama, longitude_kab, latitude_kab,pasien_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
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
}

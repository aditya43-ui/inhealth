<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.PPTodolistR");
class ModuleDashboardSTController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Sterilisasi";
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

    // KOLOM BARIS PERTAMA
    $dataKolom = array();
    // Query pengajuan Pengajuansterlilisasi_t
    $sql = "SELECT COUNT(Pengajuansterlilisasi_id) AS jumlah
						FROM Pengajuansterlilisasi_t
						WHERE DATE(pengajuansterlilisasi_tgl) ='" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];
    // Query Pesan Pesanperlinensteril_t
    $sql = "SELECT COUNT(Pesanperlinensteril_id) AS jumlah
						FROM Pesanperlinensteril_t
						WHERE DATE(Pesanperlinensteril_tgl) ='" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];
    // Query penyimpanan Penyimpanansteril_t
    $sql = "SELECT COUNT(Penyimpanansteril_id) AS jumlah
						FROM Penyimpanansteril_t
						WHERE DATE(Penyimpanansteril_tgl) ='" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];
    // Query Penerimaan Penerimaansterilisasi_t
    $sql = "SELECT COUNT(Penerimaansterilisasi_id) AS jumlah
						FROM Penerimaansterilisasi_t
						WHERE DATE(Penerimaansterilisasi_tgl) ='" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    // AREA CHART
    $sql = "SELECT penerimaansterilisasi_tgl::date as tglrekammedis, count(Penerimaansterilisasi_id) as jumlah
						FROM penerimaansterilisasi_t
						WHERE penerimaansterilisasi_tgl::date BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						GROUP BY penerimaansterilisasi_tgl::date
						ORDER BY penerimaansterilisasi_tgl::Date ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataAreaChart = $result;

    // LINE CHART
    // LINE I
    $sql = "SELECT  Terimaperlinensteril_tgl::date as tglpeminjamanrm, count(Terimaperlinensteril_id) as jumlah_1
						FROM Terimaperlinensteril_t
						WHERE Terimaperlinensteril_tgl::date BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						GROUP BY Terimaperlinensteril_tgl::date
						ORDER BY Terimaperlinensteril_tgl::date ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    // LINE 2
    $sql = "SELECT  Penerimaansterilisasi_tgl::date as tglpeminjamanrm, count(Penerimaansterilisasi_id) as jumlah_2
						FROM Penerimaansterilisasi_t
						WHERE Penerimaansterilisasi_tgl::date BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						GROUP BY Penerimaansterilisasi_tgl::date
						ORDER BY Penerimaansterilisasi_tgl::date ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();

    $dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'tglpeminjamanrm');

    // DONUT CHART
    $sql = "SELECT  ruangan_nama, DATE(Penerimaansterilisasi_tgl) as tglpengirimanrm, count(Penerimaansterilisasi_id) as jumlah
						FROM Penerimaansterilisasi_t JOIN ruangan_m ON Penerimaansterilisasi_t.ruangan_id = ruangan_m.ruangan_id
						WHERE DATE(Penerimaansterilisasi_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						GROUP BY ruangan_nama,DATE(Penerimaansterilisasi_tgl)
						ORDER BY ruangan_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    // PIE CHART
    $sql = "
				SELECT 
				penjamin_nama, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND penjamin_id IN (" . Params::PENJAMIN_ID_PISA . "," . Params::PENJAMIN_ID_PROKESPEN . ") 
				GROUP BY penjamin_id, penjamin_nama
				UNION
				SELECT 
				'Lainnya'::CHARACTER VARYING(50) AS penjamin_nama, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND penjamin_id NOT IN (" . Params::PENJAMIN_ID_PISA . "," . Params::PENJAMIN_ID_PROKESPEN . ") 
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    // KOLOM BARIS KETIGA
    // Query Jumlah Pengajuansterlilisasi_t Bulan Ini
    $sql = "SELECT COUNT(Pengajuansterlilisasi_id) AS jumlah
						FROM Pengajuansterlilisasi_t 
						WHERE DATE(Pengajuansterlilisasi_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];
    // Query Jumlah Pesanperlinensteril_t bulan ini
    $sql = "SELECT COUNT(Pesanperlinensteril_id) AS jumlah
						FROM Pesanperlinensteril_t
						WHERE DATE(Pesanperlinensteril_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];

    // Query Jumlah Pengajuansterlilisasi_t Bulan Ini
    $sql = "SELECT COUNT(Penyimpanansteril_id) AS jumlah
						FROM Penyimpanansteril_t 
						WHERE DATE(Penyimpanansteril_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[7] = $result['jumlah'];
    // Query Jumlah Pesanperlinensteril_t bulan ini
    $sql = "SELECT COUNT(Penerimaansterilisasi_id) AS jumlah
						FROM Penerimaansterilisasi_t
						WHERE DATE(Penerimaansterilisasi_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[8] = $result['jumlah'];

    // BAR CHART
    $sql = "SELECT  ruangan_nama, count(Penerimaansterilisasi_id) as jumlah
						FROM Penerimaansterilisasi_t JOIN ruangan_m ON Penerimaansterilisasi_t.ruangan_id = ruangan_m.ruangan_id
						WHERE DATE(Penerimaansterilisasi_tgl) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
						GROUP BY ruangan_nama
						ORDER BY jumlah DESC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;

    // TABEL
    $criteria_updatepasien = new CDbCriteria();
    $criteria_updatepasien->limit = 10;
    $criteria_updatepasien->order = 'Pesanperlinensteril_tgl DESC';
    $dataTable = STPesanperlinensterilT::model()->findAll($criteria_updatepasien);
    $dataTable = new STPesanperlinensterilT();

    // MAP 
    $sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				JOIN kecamatan_m ON laporankunjunganrs_v.kecamatan_id = kecamatan_m.kecamatan_id
				WHERE date_part('year',tgl_pendaftaran) = '" . date('Y') . "'
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				LIMIT 10
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataMap = $result;

    // TO DO LIST
    $modTodolist = new PPTodolistR();
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();

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

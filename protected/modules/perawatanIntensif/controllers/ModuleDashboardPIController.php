<?php
Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");
class ModuleDashboardPIController extends ModuleDashboardNeonController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Perawatan Intensif";
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

    $tgl_sekarang = date('Y-m-d');
    $bln_sekarang = date('Y-m');

    $sql = "SELECT count (pasienadmisi_id) AS jumlah FROM pasienadmisi_t 
				WHERE date(tgladmisi) ='" . $tgl_sekarang . "'
				AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    /**
     * RND-13890
     */
    //		$sql = "SELECT count (pindahkamar_id) AS jumlah FROM pindahkamar_t
    //				WHERE DATE(tglpindahkamar) = '".date('Y-m-d')."'
    //				AND ruangan_id = '".Yii::app()->user->getState('ruangan_id')."'";
    //		$result = Yii::app()->db->createCommand($sql)->queryRow();
    //        $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT count (pindahkamar_id) AS jumlah FROM pindahkamar_t
				WHERE DATE(tglpindahkamar) = '" . $tgl_sekarang . "'
				AND ruangan_id != '" . Yii::app()->user->getState('ruangan_id') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT count (pindahkamar_t.pindahkamar_id) AS jumlah FROM pindahkamar_t
				JOIN masukkamar_t ON masukkamar_t.masukkamar_id = pindahkamar_t.masukkamar_id
				WHERE DATE(masukkamar_t.tglmasukkamar) = '" . $tgl_sekarang . "'
				AND masukkamar_t.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT count (pasienpulang_id) AS jumlah FROM pasienpulang_t
				WHERE DATE(tglpasienpulang) = '" . $tgl_sekarang . "'
				AND create_ruangan = '" . Yii::app()->user->getState('ruangan_id') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT count (pasienadmisi_id) AS jumlah, DATE(tgladmisi) as tgladmisi
				FROM pasienadmisi_t
				WHERE DATE(tgladmisi) BETWEEN '" . $bln_sekarang . "-01' AND '" . $tgl_sekarang . "'
				GROUP BY DATE(tgladmisi)
				ORDER BY tgladmisi ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT count (pendaftaran_id) AS jumlah_1, DATE(tgl_pendaftaran) AS tglpendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = " . Params::INSTALASI_ID_PI . "
				AND pasienbatalperiksa_id IS NULL and statuspasien = '" . PARAMS::STATUSPASIEN_BARU . "' 
				AND DATE(tgl_pendaftaran) BETWEEN '" . $bln_sekarang . "-01' AND '" . $tgl_sekarang . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY DATE(tgl_pendaftaran) ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();

    $sql = "SELECT count (pendaftaran_id) AS jumlah_2, DATE(tgl_pendaftaran) AS tglpendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = " . Params::INSTALASI_ID_PI . "
				AND pasienbatalperiksa_id IS NULL and statuspasien = '" . PARAMS::STATUSPASIEN_LAMA . "' 
				AND DATE(tgl_pendaftaran) BETWEEN '" . $bln_sekarang . "-01' AND '" . $tgl_sekarang . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY DATE(tgl_pendaftaran) ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();

    $sql = "SELECT count (pendaftaran_id) AS jumlah_3, DATE(tgl_pendaftaran) AS tglpendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = " . Params::INSTALASI_ID_PI . "
				AND pasienbatalperiksa_id IS NULL and kunjungan = '" . PARAMS::STATUSKUNJUNGAN_BARU . "' 
				AND DATE(tgl_pendaftaran) BETWEEN '" . $bln_sekarang . "-01' AND '" . $tgl_sekarang . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY DATE(tgl_pendaftaran) ASC";
    $result_3 = Yii::app()->db->createCommand($sql)->queryAll();

    $sql = "SELECT count (pendaftaran_id) AS jumlah_4, DATE(tgl_pendaftaran) AS tglpendaftaran
				FROM pendaftaran_t 
				WHERE instalasi_id = " . Params::INSTALASI_ID_PI . "
				AND pasienbatalperiksa_id IS NULL and kunjungan = '" . PARAMS::STATUSKUNJUNGAN_LAMA . "' 
				AND DATE(tgl_pendaftaran) BETWEEN '" . $bln_sekarang . "-01' AND '" . $tgl_sekarang . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY DATE(tgl_pendaftaran) ASC";
    $result_4 = Yii::app()->db->createCommand($sql)->queryAll();

    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_1, 'tglpendaftaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_2, 'tglpendaftaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_3, 'tglpendaftaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_4, 'tglpendaftaran');

    $sql = "SELECT kelaspelayanan_m.kelaspelayanan_id,kelaspelayanan_m.kelaspelayanan_nama,count (pasienadmisi_t.pasienadmisi_id) AS jumlah 
				FROM pasienadmisi_t
				JOIN kelaspelayanan_m ON kelaspelayanan_m.kelaspelayanan_id=pasienadmisi_t.kelaspelayanan_id 
				AND DATE(tgladmisi) BETWEEN '" . $bln_sekarang . "-01' AND '" . $tgl_sekarang . "'
				GROUP BY kelaspelayanan_m.kelaspelayanan_id,kelaspelayanan_m.kelaspelayanan_nama ";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama,count (pendaftaran_id) AS jumlah 
				FROM pendaftaran_t 
				JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
				WHERE instalasi_id = " . Params::INSTALASI_ID_PI . "
				AND pasienbatalperiksa_id IS NULL AND DATE(tgl_pendaftaran) BETWEEN '" . $bln_sekarang . "-01' AND '" . $tgl_sekarang . "'
				GROUP BY pendaftaran_t.penjamin_id, penjaminpasien_m.penjamin_nama";

    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT count (pasienadmisi_id) AS jumlah 
				FROM pasienadmisi_t 
				WHERE caramasuk_id = any(array[" . Params::CARAMASUK_ID_RD . "," . Params::CARAMASUK_ID_RJ . "])
				AND DATE(tgladmisi) BETWEEN '" . $bln_sekarang . "-01' AND '" . $tgl_sekarang . "'
				AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT count (pasienadmisi_id) AS jumlah 
				FROM pasienadmisi_t 
				WHERE caramasuk_id = " . Params::CARAMASUK_ID_LANGSUNG_RI . "
				AND DATE(tgladmisi) BETWEEN '" . $bln_sekarang . "-01' AND '" . $tgl_sekarang . "'
				AND ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];

    $sql = "SELECT diagnosa_m.diagnosa_nama, count(pasienmorbiditas_id) as jumlah 
				FROM pasienmorbiditas_t
				JOIN diagnosa_m ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
				JOIN ruangan_m ON pasienmorbiditas_t.ruangan_id = ruangan_m.ruangan_id
				JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
				WHERE ruangan_m.instalasi_id = " . Params::INSTALASI_ID_PI . "
				GROUP BY diagnosa_m.diagnosa_nama
				ORDER BY jumlah desc LIMIT 10";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    $dataTable = new PIPasienPulangT();

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT pasien_m.kecamatan_id,kecamatan_m.kecamatan_nama,count (pendaftaran_id) AS jumlah,kecamatan_m.longitude, kecamatan_m.latitude
				FROM pendaftaran_t 
				JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id
				JOIN kecamatan_m ON kecamatan_m.kecamatan_id = pasien_m.kecamatan_id
				WHERE instalasi_id = " . Params::INSTALASI_ID_PI . "
				AND pasienbatalperiksa_id IS NULL AND DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY  pasien_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC LIMIT 10
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataMap = $result;
    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
    $latitude = isset($modPropinsi->latitude) ? $modPropinsi->latitude : null;
    $longitude = isset($modPropinsi->longitude) ? $modPropinsi->longitude : null;
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
      $data = array();
      $kecamatan_nama = (isset($_POST['kecamatan_nama']) ? $_POST['kecamatan_nama'] : null);
      if (!empty($kecamatan_nama)) {
        //=== start map ===
        $sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, diagnosa_m.diagnosa_id, diagnosa_m.diagnosa_kode, diagnosa_m.diagnosa_nama,COUNT(pasienmorbiditas_id) AS jumlah
						FROM pasienmorbiditas_t
						JOIN pasien_m ON pasienmorbiditas_t.pasien_id = pasien_m.pasien_id
						JOIN diagnosa_m ON diagnosa_m.diagnosa_id = pasienmorbiditas_t.diagnosa_id
						JOIN kecamatan_m ON pasien_m.kecamatan_id = kecamatan_m.kecamatan_id
						WHERE DATE(tglmorbiditas) BETWEEN '" . date('Y-m') . "-01' AND '" . date('Y-m-d') . "'
							AND kecamatan_m.kecamatan_nama = '" . $kecamatan_nama . "'
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

<?php
Yii::import('sistemAdministrator.models.*');
class ModuleDashboardNeonController extends MyAuthController
{
  public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';
  public function actionIndex()
  {
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

    $sql = "SELECT COUNT(bookingkamar_id) AS jumlah
				FROM bookingkamar_t
				WHERE pasienadmisi_id = null
				AND LOWER(statuskonfirmasi) like '" . strtolower(Params::STATUSKONFIRMASI_BOOKING_BATAL) . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) = '" . date('Y-m-d') . "'
					AND (
						instalasi_id = " . Params::INSTALASI_ID_RJ . "
						OR instalasi_id = " . Params::INSTALASI_ID_RD . "
						OR instalasi_id = " . Params::INSTALASI_ID_RI . "
					)";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) = '" . date('Y-m-d') . "'
					AND (
						instalasi_id = " . Params::INSTALASI_ID_RJ . "
						OR instalasi_id = " . Params::INSTALASI_ID_RD . "
						OR instalasi_id = " . Params::INSTALASI_ID_RI . "
					)
					AND LOWER(statuspasien) = '" . strtolower(Params::STATUSPASIEN_BARU) . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) = '" . date('Y-m-d') . "'
					AND LOWER(statuspasien) = '" . strtolower(Params::STATUSPASIEN_LAMA) . "'
					AND (
							instalasi_id = " . Params::INSTALASI_ID_RJ . "
							OR instalasi_id = " . Params::INSTALASI_ID_RD . "
							OR instalasi_id = " . Params::INSTALASI_ID_RI . "
						)";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===

    //=== chart ===
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND (
						instalasi_id = " . Params::INSTALASI_ID_RJ . "
						OR instalasi_id = " . Params::INSTALASI_ID_RD . "
						OR instalasi_id = " . Params::INSTALASI_ID_RI . "
					)
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_1
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasi_id = " . Params::INSTALASI_ID_RJ . "
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_2
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasi_id = " . Params::INSTALASI_ID_RD . "
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT DATE(tgl_pendaftaran) as tgl_pendaftaran, count(pendaftaran_id) as jumlah_2
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasi_id = " . Params::INSTALASI_ID_RI . "
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_3 = Yii::app()->db->createCommand($sql)->queryAll();
    $dataLineChart = CustomFunction::joinTwo2DArrays($result_1, $result_2, 'tgl_pendaftaran');
    $dataLineChart = CustomFunction::joinTwo2DArrays($dataLineChart, $result_3, 'tgl_pendaftaran');

    $sql = "SELECT instalasi_nama, ruangan_nama, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND (
						instalasi_id = " . Params::INSTALASI_ID_RJ . "
						OR instalasi_id = " . Params::INSTALASI_ID_RD . "
						OR instalasi_id = " . Params::INSTALASI_ID_RI . "
					)
				GROUP BY instalasi_nama, ruangan_nama
				ORDER BY instalasi_nama, ruangan_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    //		$sql = "SELECT carabayar_nama, count(pendaftaran_id) as jumlah
    //				FROM laporankunjunganrs_v
    //				WHERE DATE(tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
    //					AND (
    //						instalasi_id = ".Params::INSTALASI_ID_RJ."
    //						OR instalasi_id = ".Params::INSTALASI_ID_RD."
    //						OR instalasi_id = ".Params::INSTALASI_ID_RI."
    //					)
    //				GROUP BY carabayar_nama
    //				ORDER BY carabayar_nama ASC";

    /*  created By  : Iqbal Laksana
                    tanggal     : 21 April 2016
                    keterangan  : comment query union dan mengubah penjamin_id menjadi penjamin_aktif
                 original query > penjamin_id IN (".Params::PENJAMIN_ID_PISA.",".Params::PENJAMIN_ID_PROKESPEN.")
                 
                 awal edit
                 */
    $sql = "
				SELECT 
				laporankunjunganrs_v.penjamin_nama, count(laporankunjunganrs_v.pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v  JOIN penjaminpasien_m ON laporankunjunganrs_v.penjamin_id = penjaminpasien_m.penjamin_id 
				WHERE DATE(laporankunjunganrs_v.tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				AND penjaminpasien_m.penjamin_aktif = true 
				AND laporankunjunganrs_v.instalasi_id IN (" . Params::INSTALASI_ID_RJ . "," . Params::INSTALASI_ID_RD . "," . Params::INSTALASI_ID_RI . ")
				GROUP BY laporankunjunganrs_v.penjamin_id, laporankunjunganrs_v.penjamin_nama
				";/*
                                 * UNION
				SELECT 
				'Lainnya'::CHARACTER VARYING(50) AS penjamin_nama, count(laporankunjunganrs_v.pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v JOIN penjaminpasien_m ON laporankunjunganrs_v.penjamin_id = penjaminpasien_m.penjamin_id 
				WHERE DATE(laporankunjunganrs_v.tgl_pendaftaran) BETWEEN '".date("Y-m")."-01' AND '".date("Y-m-d")."'
				AND penjaminpasien_m.penjamin_aktif = true 
				AND laporankunjunganrs_v.instalasi_id IN (".Params::INSTALASI_ID_RJ.",".Params::INSTALASI_ID_RD.",".Params::INSTALASI_ID_RI.")
				"
                                 * 
                                 * 
                                 */
    /*
                 * akhir edit
                 */
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND (
						instalasi_id = " . Params::INSTALASI_ID_RJ . "
						OR instalasi_id = " . Params::INSTALASI_ID_RD . "
						OR instalasi_id = " . Params::INSTALASI_ID_RI . "
					)
					AND LOWER(statusmasuk) = '" . strtolower(Params::STATUSMASUK_RUJUKAN) . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(pendaftaran_id) AS jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND (
						instalasi_id = " . Params::INSTALASI_ID_RJ . "
						OR instalasi_id = " . Params::INSTALASI_ID_RD . "
						OR instalasi_id = " . Params::INSTALASI_ID_RI . "
					)
					AND LOWER(statusmasuk) = '" . strtolower(Params::STATUSMASUK_NONRUJUKAN) . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];

    $sql = "SELECT instalasi_nama, ruangan_nama, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				WHERE DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
					AND instalasi_id = " . Params::INSTALASI_ID_RJ . "
				GROUP BY instalasi_nama, ruangan_nama
				ORDER BY instalasi_nama, ruangan_nama ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;
    //=== end chart ===

    //=== start table ===
    $criteria_updatepasien = new CDbCriteria();
    $criteria_updatepasien->limit = 5;
    $criteria_updatepasien->order = 'tgl_pendaftaran DESC';
    $dataTable = PPPendaftaranT::model()->findAll($criteria_updatepasien);


    $dataTable = new PPBuatJanjiPoliT("searchRiwayatPasien");

    //=== end table ===

    //=== start todo list ===
    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===

    //=== start map ===
    $sql = "SELECT kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude, count(pendaftaran_id) as jumlah
				FROM laporankunjunganrs_v
				JOIN kecamatan_m ON laporankunjunganrs_v.kecamatan_id = kecamatan_m.kecamatan_id
				WHERE date_part('year',tgl_pendaftaran) = '" . date('Y') . "'
					AND (
						instalasi_id = " . Params::INSTALASI_ID_RJ . "
						OR instalasi_id = " . Params::INSTALASI_ID_RD . "
						OR instalasi_id = " . Params::INSTALASI_ID_RI . "
					)
				GROUP BY kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				ORDER BY jumlah DESC
				LIMIT 10
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataMap = $result;
    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
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
      'modPropinsi' => $modPropinsi,
    ));
  }

  /**
   * menampilkan form antrian dari request ajax
   * @param type $record
   * @param type $noantrian
   * @throws CHttpException
   */
  public function actionSetFormTodolist()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $data['pesan'] = "";
      $todolist_id = (isset($_POST['todolist_id']) ? $_POST['todolist_id'] : null);
      if (!empty($todolist_id)) { //antrian baru
        $modTodolist =  PPTodolistR::model()->findByPk($todolist_id);
      } else {
        $data['pesan'] = 'tidak ditemukan';
      }
      $data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array('modTodolist' => $modTodolist), true);
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * menyimpan data todolist by ajax
   * @throws CHttpException
   */
  public function actionSimpanTodolist()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_POST['isi'], $isi);

      $data = array();
      $data['pesan'] = "";



      // echo "<pre>"; print_r($isi['PPTodolistR']['todolist_id']);exit();

      $IdTodolist = isset($isi['PPTodolistR']['todolist_id']) ? $isi['PPTodolistR']['todolist_id'] : '';

      if (empty($IdTodolist)) { //antrian baru
        $modTodolist = new PPTodolistR;
        $modTodolist->todolist_nama = isset($isi['PPTodolistR']['todolist_nama']) ? $isi['PPTodolistR']['todolist_nama'] : '';
        $modTodolist->todolist_aktif = isset($isi['PPTodolistR']['todolist_aktif']) ? $isi['PPTodolistR']['todolist_aktif'] : true;
        $modTodolist->tgltodolist = isset($isi['PPTodolistR']['tgltodolist_new']) ? MyFormatter::formatDateTimeForDb($isi['PPTodolistR']['tgltodolist_new']) : date('Y-m-d');
        $modTodolist->create_time = date('Y-m-d');
        $modTodolist->create_loginpemakai_id = Yii::app()->user->id;
        $modTodolist->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modTodolist->create_modul_id = Yii::app()->session['modul_id'];
        $simpan = $modTodolist->save();
        if ($simpan) {
          $data['pesan'] = 'Todolist Berhasil Disimpan!';
        } else {
          $data['pesan'] = 'Todolist Gagal Disimpan!';
        }
      } else {
        $modTodolist = PPTodolistR::model()->findByPk($IdTodolist);
        $modTodolist->todolist_nama = isset($isi['PPTodolistR']['todolist_nama']) ? $isi['PPTodolistR']['todolist_nama'] : '';
        $modTodolist->todolist_aktif = isset($isi['PPTodolistR']['todolist_aktif']) ? $isi['PPTodolistR']['todolist_aktif'] : true;
        $modTodolist->tgltodolist = isset($isi['PPTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['PPTodolistR']['tgltodolist']) : date('Y-m-d');
        $modTodolist->update_time = date('Y-m-d');
        $modTodolist->update_loginpemakai_id = Yii::app()->user->id;

        $update = $modTodolist->update();
        if ($update) {
          $data['pesan'] = 'Todolist Berhasil Diubah!';
        } else {
          $data['pesan'] = 'Todolist Gagal Diubah!';
        }
      }
      $data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array('modTodolist' => $modTodolist), true);
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * update by ajax
   * @throws CHttpException
   */
  public function actionUpdateTodolist()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_POST['isi'], $isi);

      $data = array();
      $data['pesan'] = "";

      $IdTodolist = isset($isi['PPTodolistR']['todolist_id']) ? $isi['PPTodolistR']['todolist_id'] : '';

      if (empty($IdTodolist)) { //antrian baru
        $modTodolist = new PPTodolistR;
        $modTodolist->todolist_nama = isset($isi['PPTodolistR']['todolist_nama']) ? $isi['PPTodolistR']['todolist_nama'] : '';
        $modTodolist->todolist_aktif = isset($isi['PPTodolistR']['todolist_aktif']) ? $isi['PPTodolistR']['todolist_aktif'] : true;
        $modTodolist->tgltodolist = isset($isi['PPTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['PPTodolistR']['tgltodolist']) : date('Y-m-d');
        $modTodolist->create_time = date('Y-m-d');
        $modTodolist->create_loginpemakai_id = Yii::app()->user->id;
        $modTodolist->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modTodolist->create_modul_id = Yii::app()->session['modul_id'];
        $simpan = $modTodolist->save();
        if ($simpan) {
          $data['pesan'] = 'Todolist Berhasil Disimpan!';
        } else {
          $data['pesan'] = 'Todolist Gagal Disimpan!';
        }
      } else {
        $modTodolist = PPTodolistR::model()->findByPk($IdTodolist);
        $modTodolist->todolist_nama = isset($isi['PPTodolistR']['todolist_nama']) ? $isi['PPTodolistR']['todolist_nama'] : '';
        $modTodolist->todolist_aktif = isset($isi['PPTodolistR']['todolist_aktif']) ? $isi['PPTodolistR']['todolist_aktif'] : true;
        $modTodolist->tgltodolist = isset($isi['PPTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['PPTodolistR']['tgltodolist']) : date('Y-m-d');
        $modTodolist->update_time = date('Y-m-d');
        $modTodolist->update_loginpemakai_id = Yii::app()->user->id;

        $update = $modTodolist->update();
        if ($update) {
          $data['pesan'] = 'Todolist Berhasil Diubah!';
        } else {
          $data['pesan'] = 'Todolist Gagal Diubah!';
        }
      }
      $data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array('modTodolist' => $modTodolist), true);
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * hapus todo list ajax dari tombol di widget
   * @throws CHttpException
   */
  public function actionHapusTodolist()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $data['pesan'] = "";
      $todolist_id = (isset($_POST['todolist_id']) ? $_POST['todolist_id'] : null);
      if (!empty($todolist_id)) { //antrian baru
        $modTodolist =  PPTodolistR::model()->deleteByPk($todolist_id);
        $data['pesan'] = 'Data Berhasil Dihapus';
      } else {
        $data['pesan'] = 'Data Gagal Dihapus';
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * ubah todolist ajax dari widget
   * @throws CHttpException
   */
  public function actionUbahStatusTodolist()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $data['pesan'] = "";
      $todolist_id = (isset($_POST['todolist_id']) ? $_POST['todolist_id'] : null);
      if (!empty($todolist_id)) { //antrian baru
        $modTodolist = PPTodolistR::model()->findByPk($todolist_id);
        $modTodolist->todolist_aktif = false;
        $update = $modTodolist->update();
        if ($update) {
          $data['pesan'] = 'Status Todolist Berhasil Diubah!';
        } else {
          $data['pesan'] = 'Status Todolist Gagal Diubah!';
        }
      } else {
        $data['pesan'] = 'Status Todolist Gagal Diubah!';
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}

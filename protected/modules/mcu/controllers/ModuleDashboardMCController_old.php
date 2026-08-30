<?php

Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");

class ModuleDashboardMCController_old extends ModuleDashboardNeonController
{
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
    $dataLine = array();

    $sql = "SELECT count (pendaftaran_id) AS jumlah FROM pendaftaran_t 
				WHERE ruangan_id = " . PARAMS::RUANGAN_ID_KLINIK_MCU . " AND pasienbatalperiksa_id IS NULL 
				AND date(tgl_pendaftaran) = '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[1] = $result['jumlah'];

    $sql = "SELECT count (pendaftaran_t.pendaftaran_id) AS jumlah,asalrujukan_m.asalrujukan_nama  FROM pendaftaran_t 
JOIN rujukan_t ON rujukan_t.rujukan_id=pendaftaran_t.rujukan_id
JOIN asalrujukan_m ON asalrujukan_m.asalrujukan_id=rujukan_t.asalrujukan_id
WHERE pendaftaran_t.ruangan_id = " . PARAMS::RUANGAN_ID_KLINIK_MCU . " AND pendaftaran_t.pasienbatalperiksa_id IS NULL 
AND pendaftaran_t.rujukan_id IS NOT NULL
AND asalrujukan_m.asalrujukan_id != " . PARAMS::ASAL_RUJUKAN_ID_SENDIRI . "
AND date(tgl_pendaftaran)= '" . date('Y-m-d') . "'
GROUP BY asalrujukan_m.asalrujukan_nama";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[2] = $result['jumlah'];

    $sql = "SELECT count(buatjanjipoli_id) as jumlah FROM buatjanjipoli_t
WHERE ruangan_id= " . PARAMS::RUANGAN_ID_KLINIK_MCU . " AND date(tglbuatjanji)= '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[3] = $result['jumlah'];

    $sql = "SELECT count(pengajuangantikm_id) as jumlah FROM pengajuangantikm_t
WHERE date(tglpengajuan_km)= '" . date('Y-m-d') . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[4] = $result['jumlah'];

    //=== end 4 kolom ===
    //=== chart ===
    $sql = "SELECT count (pendaftaran_id) AS jumlah, DATE(tgl_pendaftaran) AS tgl_pendaftaran FROM pendaftaran_t WHERE 
ruangan_id = " . PARAMS::RUANGAN_ID_KLINIK_MCU . " AND pasienbatalperiksa_id IS NULL 
AND date(tgl_pendaftaran)  BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
		GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result = Yii::app()->db->createCommand($sql)->queryAll();

    $dataAreaChart = $result;
    //=== chart ===
    $sql = "SELECT count (pendaftaran_id) AS jumlah_1 , DATE(tgl_pendaftaran) AS tgl_pendaftaran
			FROM pendaftaran_t 
WHERE ruangan_id = " . PARAMS::RUANGAN_ID_KLINIK_MCU . " AND pasienbatalperiksa_id IS NULL 
AND statuspasien= '" . PARAMS::STATUSPASIEN_BARU . "'
AND DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_1 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT count (pendaftaran_id) AS jumlah_2 , DATE(tgl_pendaftaran) AS tgl_pendaftaran
			FROM pendaftaran_t 
WHERE ruangan_id = " . PARAMS::RUANGAN_ID_KLINIK_MCU . " AND pasienbatalperiksa_id IS NULL 
AND statuspasien= '" . PARAMS::STATUSPASIEN_LAMA . "'
AND DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_2 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT count (pendaftaran_id) AS jumlah_3 , DATE(tgl_pendaftaran) AS tgl_pendaftaran 
			FROM pendaftaran_t 
WHERE ruangan_id = " . PARAMS::RUANGAN_ID_KLINIK_MCU . " AND pasienbatalperiksa_id IS NULL 
AND kunjungan= '" . PARAMS::STATUSKUNJUNGAN_BARU . "'
AND date(tgl_pendaftaran)  BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_3 = Yii::app()->db->createCommand($sql)->queryAll();
    $sql = "SELECT count (pendaftaran_id) AS jumlah_4 , DATE(tgl_pendaftaran) AS tgl_pendaftaran 
			FROM pendaftaran_t 
WHERE ruangan_id = " . PARAMS::RUANGAN_ID_KLINIK_MCU . " AND pasienbatalperiksa_id IS NULL 
AND kunjungan= '" . PARAMS::STATUSKUNJUNGAN_LAMA . "'
AND date(tgl_pendaftaran)  BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
				GROUP BY DATE(tgl_pendaftaran)
				ORDER BY tgl_pendaftaran ASC";
    $result_4 = Yii::app()->db->createCommand($sql)->queryAll();

    if (count((array)$result_1) > 0) {
      foreach ($result_1 as $pb) {
        $tempPB['tgl_pendaftaran'] = $pb['tgl_pendaftaran'];
        $tempPB['jumlah_1'] = $pb['jumlah_1'];
        array_push($dataLine, $tempPB);
      }
    }

    if (count((array)$result_2) > 0) {
      foreach ($result_2 as $pl) {
        $tempPL['tgl_pendaftaran'] = $pl['tgl_pendaftaran'];
        $tempPL['jumlah_2'] = $pl['jumlah_2'];
        array_push($dataLine, $tempPL);
      }
    }

    if (count((array)$result_3) > 0) {
      foreach ($result_3 as $kb) {
        $tempKB['tgl_pendaftaran'] = $kb['tgl_pendaftaran'];
        $tempKB['jumlah_3'] = $kb['jumlah_3'];
        array_push($dataLine, $tempKB);
      }
    }

    if (count((array)$result_4) > 0) {
      foreach ($result_4 as $kl) {
        $tempKL['tgl_pendaftaran'] = $kl['tgl_pendaftaran'];
        $tempKL['jumlah_4'] = $kl['jumlah_4'];
        array_push($dataLine, $tempKL);
      }
    }

    $temp = 0;
    for ($i = 0; $i < count((array)$dataLine); $i++) {
      if ($i == 0) {
        $dataLineChart[$i]['tgl_pendaftaran'] = $dataLine[$i]['tgl_pendaftaran'];
        $dataLineChart[$i]['jumlah_1'] = isset($dataLine[$i]['jumlah_1']) ? $dataLine[$i]['jumlah_1'] : 0;
        $dataLineChart[$i]['jumlah_2'] = isset($dataLine[$i]['jumlah_2']) ? $dataLine[$i]['jumlah_2'] : 0;
        $dataLineChart[$i]['jumlah_3'] = isset($dataLine[$i]['jumlah_3']) ? $dataLine[$i]['jumlah_3'] : 0;
        $dataLineChart[$i]['jumlah_4'] = isset($dataLine[$i]['jumlah_4']) ? $dataLine[$i]['jumlah_4'] : 0;
      } else {
        if ($dataLine[$i]['tgl_pendaftaran'] == $dataLine[$temp]['tgl_pendaftaran']) {
          if (isset($dataLine[$i]['jumlah_1'])) {
            $dataLineChart[$temp]['jumlah_1'] = $dataLine[$i]['jumlah_1'];
          }
          if (isset($dataLine[$i]['jumlah_2'])) {
            $dataLineChart[$temp]['jumlah_2'] = $dataLine[$i]['jumlah_2'];
          }
          if (isset($dataLine[$i]['jumlah_3'])) {
            $dataLineChart[$temp]['jumlah_3'] = $dataLine[$i]['jumlah_3'];
          }
          if (isset($dataLine[$i]['jumlah_4'])) {
            $dataLineChart[$temp]['jumlah_4'] = $dataLine[$i]['jumlah_4'];
          }
        } else {
          $dataLineChart[$i]['tgl_pendaftaran'] = $dataLine[$i]['tgl_pendaftaran'];
          $dataLineChart[$i]['jumlah_1'] = isset($dataLine[$i]['jumlah_1']) ? $dataLine[$i]['jumlah_1'] : 0;
          $dataLineChart[$i]['jumlah_2'] = isset($dataLine[$i]['jumlah_2']) ? $dataLine[$i]['jumlah_2'] : 0;
          $dataLineChart[$i]['jumlah_3'] = isset($dataLine[$i]['jumlah_3']) ? $dataLine[$i]['jumlah_3'] : 0;
          $dataLineChart[$i]['jumlah_4'] = isset($dataLine[$i]['jumlah_4']) ? $dataLine[$i]['jumlah_4'] : 0;

          $temp++;
        }
      }
    }
    $sql = "SELECT DATE(konsulpoli_t.tglkonsulpoli) as tglkonsulpoli, ruanganasal_m.ruangan_nama,count(konsulpoli_t.konsulpoli_id) as jumlah
    FROM konsulpoli_t
    JOIN ruangan_m ruanganasal_m ON ruanganasal_m.ruangan_id=konsulpoli_t.asalpoliklinikkonsul_id
    JOIN ruangan_m ON ruangan_m.ruangan_id=konsulpoli_t.ruangan_id
    WHERE konsulpoli_t.ruangan_id = " . PARAMS::RUANGAN_ID_KLINIK_MCU . "
     AND DATE(konsulpoli_t.tglkonsulpoli)  BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
    GROUP BY DATE(tglkonsulpoli),ruanganasal_m.ruangan_nama";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataDonutChart = $result;

    $sql = "SELECT pendaftaran_t.penjamin_id,penjaminpasien_m.penjamin_nama,count (pendaftaran_id) AS jumlah 
FROM pendaftaran_t 
JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
WHERE 
instalasi_id = " . PARAMS::INSTALASI_ID_RJ . "
AND pasienbatalperiksa_id IS NULL AND date(tgl_pendaftaran)   BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
group by pendaftaran_t.penjamin_id, penjaminpasien_m.penjamin_nama";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataPieChart = $result;

    $sql = "SELECT count(gantikacamata_id) as jumlah FROM gantikacamata_t
WHERE date(tglgantikacamata) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[5] = $result['jumlah'];

    $sql = "SELECT COUNT(pengajuangantikm_id) AS jumlah
				FROM pengajuangantikm_t
				WHERE DATE(tglpengajuan_km) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    $dataKolom[6] = $result['jumlah'];

    $sql = " SELECT diagnosa_m.diagnosa_nama, count(pasienmorbiditas_id) as jumlah 
   FROM pasienmorbiditas_t
   JOIN diagnosa_m ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
   JOIN ruangan_m ON pasienmorbiditas_t.ruangan_id = ruangan_m.ruangan_id
   JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
WHERE ruangan_m.instalasi_id= " . PARAMS::INSTALASI_ID_RJ . "
GROUP BY diagnosa_m.diagnosa_nama
ORDER BY jumlah desc LIMIT 10;";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataBarChart = $result;

    //=== end chart ===
    //=== start table ===
    $criteria_updatepasien = new CDbCriteria();
    $criteria_updatepasien->limit = 5;
    $criteria_updatepasien->order = 'tgldirujuk DESC';
    $dataTable = MCPasiendirujukkeluarT::model()->findAll($criteria_updatepasien);


    $dataTable = new MCPasiendirujukkeluarT();

    //=== end table ===
    //=== start todo list ===
    $modTodolist = new MCTodolistR();
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();
    //=== end todo list ===
    //=== start map ===
    $sql = "SELECT kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,kabupaten_m.latitude as latitude_kab, kabupaten_m.longitude as longitude_kab,pasien_m.kecamatan_id,kecamatan_m.kecamatan_nama,count (pendaftaran_id) AS jumlah,kecamatan_m.longitude, kecamatan_m.latitude
FROM pendaftaran_t 
JOIN pasien_m ON pasien_m.pasien_id = pendaftaran_t.pasien_id
JOIN kecamatan_m ON kecamatan_m.kecamatan_id = pasien_m.kecamatan_id
JOIN kabupaten_m ON kabupaten_m.kabupaten_id = pasien_m.kabupaten_id
WHERE 
ruangan_id= " . PARAMS::RUANGAN_ID_KLINIK_MCU . "
AND pasienbatalperiksa_id IS NULL AND DATE(tgl_pendaftaran) BETWEEN '" . date("Y-m") . "-01' AND '" . date("Y-m-d") . "'
group by  kabupaten_m.kabupaten_id,kabupaten_m.kabupaten_nama,longitude_kab,latitude_kab,pasien_m.kecamatan_id, kecamatan_m.kecamatan_nama, kecamatan_m.longitude, kecamatan_m.latitude
				";
    $result = Yii::app()->db->createCommand($sql)->queryAll();
    $dataMap = $result;
    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
    //=== end map ===

    $this->render('dashboard', array(
      'dataKolom'         => $dataKolom,
      'dataAreaChart'       => $dataAreaChart,
      'dataLineChart'       => $dataLineChart,
      'dataDonutChart'     => $dataDonutChart,
      'dataPieChart'       => $dataPieChart,
      'dataBarChart'       => $dataBarChart,
      'dataTable'         => $dataTable,
      'modTodolist'       => $modTodolist,
      'dataProviderTodolist'   => $dataProviderTodolist,
      'dataMap'         => $dataMap,
      'modPropinsi'       => $modPropinsi,
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
        $modTodolist = MCTodolistR::model()->findByPk($todolist_id);
      } else {
        $data['pesan'] = 'tidak ditemukan';
      }
      $data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array(
        'modTodolist' => $modTodolist
      ), true);
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

      $IdTodolist = isset($isi['PPTodolistR']['todolist_id']) ? $isi['MCTodolistR']['todolist_id'] : '';

      if (empty($IdTodolist)) { //antrian baru
        $modTodolist = new MCTodolistR;
        $modTodolist->todolist_nama = isset($isi['MCTodolistR']['todolist_nama']) ? $isi['MCTodolistR']['todolist_nama'] : '';
        $modTodolist->todolist_aktif = isset($isi['MCTodolistR']['todolist_aktif']) ? $isi['MCTodolistR']['todolist_aktif'] : true;
        $modTodolist->tgltodolist = isset($isi['MCTodolistR']['tgltodolist_new']) ? MyFormatter::formatDateTimeForDb($isi['MCTodolistR']['tgltodolist_new']) : date('Y-m-d');
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
        $modTodolist->todolist_nama = isset($isi['MCTodolistR']['todolist_nama']) ? $isi['MCTodolistR']['todolist_nama'] : '';
        $modTodolist->todolist_aktif = isset($isi['MCTodolistR']['todolist_aktif']) ? $isi['MCTodolistR']['todolist_aktif'] : true;
        $modTodolist->tgltodolist = isset($isi['MCTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['MCTodolistR']['tgltodolist']) : date('Y-m-d');
        $modTodolist->update_time = date('Y-m-d');
        $modTodolist->update_loginpemakai_id = Yii::app()->user->id;

        $update = $modTodolist->update();
        if ($update) {
          $data['pesan'] = 'Todolist Berhasil Diubah!';
        } else {
          $data['pesan'] = 'Todolist Gagal Diubah!';
        }
      }
      $data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array(
        'modTodolist' => $modTodolist
      ), true);
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

      $IdTodolist = isset($isi['MCTodolistR']['todolist_id']) ? $isi['MCTodolistR']['todolist_id'] : '';

      if (empty($IdTodolist)) { //antrian baru
        $modTodolist = new PPTodolistR;
        $modTodolist->todolist_nama = isset($isi['MCTodolistR']['todolist_nama']) ? $isi['MCTodolistR']['todolist_nama'] : '';
        $modTodolist->todolist_aktif = isset($isi['MCTodolistR']['todolist_aktif']) ? $isi['MCTodolistR']['todolist_aktif'] : true;
        $modTodolist->tgltodolist = isset($isi['MCTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['MCTodolistR']['tgltodolist']) : date('Y-m-d');
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
        $modTodolist = MCTodolistR::model()->findByPk($IdTodolist);
        $modTodolist->todolist_nama = isset($isi['MCTodolistR']['todolist_nama']) ? $isi['MCTodolistR']['todolist_nama'] : '';
        $modTodolist->todolist_aktif = isset($isi['MCTodolistR']['todolist_aktif']) ? $isi['MCTodolistR']['todolist_aktif'] : true;
        $modTodolist->tgltodolist = isset($isi['MCTodolistR']['tgltodolist']) ? MyFormatter::formatDateTimeForDb($isi['MCTodolistR']['tgltodolist']) : date('Y-m-d');
        $modTodolist->update_time = date('Y-m-d');
        $modTodolist->update_loginpemakai_id = Yii::app()->user->id;

        $update = $modTodolist->update();
        if ($update) {
          $data['pesan'] = 'Todolist Berhasil Diubah!';
        } else {
          $data['pesan'] = 'Todolist Gagal Diubah!';
        }
      }
      $data['form_todolist'] = $this->renderPartial($this->path_view . '_formTodolist', array(
        'modTodolist' => $modTodolist
      ), true);
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
        $modTodolist = MCTodolistR::model()->deleteByPk($todolist_id);
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
        $modTodolist = MCTodolistR::model()->findByPk($todolist_id);
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

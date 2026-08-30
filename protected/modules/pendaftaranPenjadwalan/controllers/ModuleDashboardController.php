<?php

class ModuleDashboardController extends MyAuthController
{
  public function actionIndex()
  {
    $format = new MyFormatter();
    $pemakai_id = Yii::app()->user->id;
    $ruangan_id = Yii::app()->user->getState('ruangan_id');

    $modPemakai = LoginpemakaiK::model()->findByPk($pemakai_id);
    $modPegawai = PegawaiM::model()->findByPk($modPemakai->pegawai_id);
    if (empty($modPegawai)) {
      $modPegawai = new PegawaiM;
    }
    $modRuanganPegawai = RuanganpegawaiM::model()->findAllByAttributes(array('pegawai_id' => $modPemakai->pegawai_id));
    $dataProviderPengumuman =  PPPengumuman::model()->searchPengumumanWidget();
    $modKunjungan = new PPLaporankunjunganrsV;
    $modKunjungan->tgl_awal = date('Y-m-d') . " 00:00:00";
    $modKunjungan->tgl_akhir = date('Y-m-d') . " 23:59:59";

    $modTodolist = new PPTodolistR;
    $dataProviderTodolist = $modTodolist->searchTodolistWidget();

    $criteria = new CDbCriteria;
    $criteria->addCondition('create_loginpemakai_id = ' . Yii::app()->user->id);
    $criteria->addCondition('create_ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
    $criteria->addCondition('create_modul_id = ' . Yii::app()->session['modul_id']);
    $criteria->order = 'tgltodolist desc';
    $modTodolistKalender = PPTodolistR::model()->findAll($criteria);


    $modMenu = MenumodulK::model()->findAllByAttributes(array('modul_id' => Yii::app()->session['modul_id'], 'menu_shortcut' => true));


    $this->render('index', array(
      'modPemakai' => $modPemakai,
      'modPegawai' => $modPegawai,
      'modRuanganPegawai' => $modRuanganPegawai,
      'modKunjungan' => $modKunjungan,
      'modTodolist' => $modTodolist,
      'modTodolistKalender' => $modTodolistKalender,
      'modMenu' => $modMenu,
      'dataProviderPengumuman' => $dataProviderPengumuman,
      'dataProviderTodolist' => $dataProviderTodolist
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
      $data['form_todolist'] = $this->renderPartial('_formTodolist', array('modTodolist' => $modTodolist), true);
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionSetKalender()
  {
    // if(Yii::app()->request->isAjaxRequest)
    // {
    $this->layout = '//layouts/iframe';
    $data = array();
    $criteria = new CDbCriteria;
    $criteria->addCondition('create_loginpemakai_id = ' . Yii::app()->user->id);
    $criteria->addCondition('create_ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
    $criteria->addCondition('create_modul_id = ' . Yii::app()->session['modul_id']);
    $criteria->order = 'tgltodolist desc';

    $criteria2 = new CDbCriteria;
    $criteria2->addCondition('status_publish = 1');

    $modTodolistKalender = PPTodolistR::model()->findAll($criteria);
    $modPengumumanKalender = PPPengumuman::model()->findAll($criteria2);

    $this->render('_kalender', array('modTodolist' => $modTodolistKalender, 'modPengumumanKalender' => $modPengumumanKalender));
    // echo CJSON::encode($data);
    // Yii::app()->end();
    // }
    // else
    //     throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
  }

  public function actionSetStatistik()
  {

    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();

    $modKunjungan = new PPLaporankunjunganrsV;
    $modKunjungan->tgl_awal = date('Y-m-d') . " 00:00:00";
    $modKunjungan->tgl_akhir = date('Y-m-d') . " 23:59:59";
    $modPasienLama = $modKunjungan;
    $modPasienLama->kunjungan = "KUNJUNGAN LAMA";
    $dataProviderPasienLama = $modPasienLama->searchSpeedo();

    $modPasienBaru = $modKunjungan;
    $modPasienBaru->kunjungan = "KUNJUNGAN BARU";
    $dataProviderPasienBaru = $modPasienBaru->searchSpeedo();

    $modPasien = $modKunjungan;
    $dataProviderPasien = $modPasien->searchMaxSpeedo();

    $modPasienRD = $modKunjungan;
    //        $modPasienRD->statuspasien = null;
    $modPasienRD->instalasi_id = Params::INSTALASI_ID_RD;
    $dataProviderPasienRD = $modPasienRD->searchKotakRJRD();

    $modPasienRJ = $modKunjungan;
    //        $modPasienRJ->statuspasien = null;
    $modPasienRJ->instalasi_id = Params::INSTALASI_ID_RJ;
    $dataProviderPasienRJ = $modPasienRJ->searchKotakRJRD();

    $modPasienRI = $modKunjungan;
    //        $modPasienRI->statuspasien = null;
    $modPasienRI->alihstatus = true;
    $modPasienRI->instalasi_id = Params::INSTALASI_ID_RI;
    $dataProviderPasienRI = $modPasienRI->searchKotakRI();

    $modBerkunjung = $modKunjungan;
    $modBerkunjung->statuspasien = null;
    $modBerkunjung->instalasi_id = null;
    $dataProviderPasienBerkunjung = $modBerkunjung->searchSpeedo();

    $modBooking = new PPBookingKamarT;
    $modBooking->tgl_awal = date('Y-m-d') . " 00:00:00";
    $modBooking->tgl_akhir = date('Y-m-d') . " 23:59:59";
    $dataProviderBooking = $modBooking->searchKotakBooking();

    $modJanjiPoli = new PPBuatJanjiPoliT();
    $modJanjiPoli->tgl_awal = date('Y-m-d') . " 00:00:00";
    $modJanjiPoli->tgl_akhir = date('Y-m-d') . " 23:59:59";
    $dataProviderJanjiPoli = $modJanjiPoli->searchKotakJanjiPoli();

    $sql = "
            SELECT * FROM notifikasi_r WHERE 
                (SELECT DATE(NOW()) - DATE(r.create_time) FROM notifikasi_r r WHERE notifikasi_r.nofitikasi_id = r.nofitikasi_id) <= notifikasi_r.lamahrnotif AND 
                notifikasi_r.isread = false AND 
                instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND
                create_ruangan = " . Yii::app()->user->getState('ruangan_id') . " AND 
                isread = false
        ";
    $records = Yii::app()->db->createCommand($sql)->queryAll();

    $isi_notif = "";
    if (count((array)$records) > 0) {
      foreach ($records as $value) {
        $isi_notif .= '<li class="read">';
        $isi_notif .= '<a href="#" value="' . $value['nofitikasi_id'] . '" onClick="$(\'#pop_pesan\').dialog(\'open\');getDetailNotifikasi(this);set_read_notifikasi(this);return false;">';
        $isi_notif .= '<span class="sender"><strong>' . $value['judulnotifikasi'] . '</strong></span><br>';
        $isi_notif .= '<span class="message">';
        $isi_notif .= '<div style="float:left;">' . $value['isinotifikasi'] . '</div><br>';
        $isi_notif .= '</span>';
        $isi_notif .= '<span class="time">' . $format->formatDateTimeForUser($value['tglnotifikasi']) . '</span>';
        $isi_notif .= '</a>';
        $isi_notif .= '</li>';
      }
    }
    $jumlah_notif = count((array)$records);

    $this->render('_statistik', array(
      'modKunjungan' => $modKunjungan,
      'dataProviderPasien' => $dataProviderPasien,
      'dataProviderPasienLama' => $dataProviderPasienLama,
      'dataProviderPasienBaru' => $dataProviderPasienBaru,
      'dataProviderPasienRD' => $dataProviderPasienRD,
      'dataProviderPasienRJ' => $dataProviderPasienRJ,
      'dataProviderPasienRI' => $dataProviderPasienRI,
      'dataProviderPasienBerkunjung' => $dataProviderPasienBerkunjung,
      'dataProviderBooking' => $dataProviderBooking,
      'dataProviderJanjiPoli' => $dataProviderJanjiPoli,
      'isi_notif' => $isi_notif,
    ));
  }

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
      $data['form_todolist'] = $this->renderPartial('_formTodolist', array('modTodolist' => $modTodolist), true);
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionUpdateTodolist()
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
      $data['form_todolist'] = $this->renderPartial('_formTodolist', array('modTodolist' => $modTodolist), true);
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }



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

  public function actionSimpanFoto()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $data['pesan'] = "";
      $pegawai_id = (isset($_POST['pegawaiId']) ? $_POST['pegawaiId'] : null);
      $photoPegawai = (isset($_POST['photoPegawai']) ? $_POST['photoPegawai'] : null);
      if (!empty($pegawai_id)) { //antrian baru
        $modPegawai =  PegawaiM::model()->findByPk($pegawai_id);
        $modPegawai->photopegawai = $photoPegawai;
        if ($modPegawai->save()) {
          $data['pesan'] = 'Foto Berhasil Disimpan!';
        } else {
          $data['pesan'] = 'Foto Gagal Disimpan!';
        }
      } else {
        $data['pesan'] = 'Tidak ditemukan!';
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}

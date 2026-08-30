<?php

class SuratPersetujuanUmumController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = "pendaftaranPenjadwalan.views.suratPersetujuanUmum.";

  /**
   * Menampilkan detail data.
   * @param integer $pendaftaran_id ID pendaftaran_t
   */
  public function actionView($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    if (empty($modPendaftaran)) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }

    $model = SuratpersetujuanumumT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));

    if (empty($model)) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }

    if (!empty($model->pasien_tanggal_lahir)) {
      $model->pasien_tanggal_lahir = MyFormatter::formatDateTimeForUser($model->pasien_tanggal_lahir);
    }
    if (!empty($model->tandatangan_tanggal_lahir)) {
      $model->tandatangan_tanggal_lahir = MyFormatter::formatDateTimeForUser($model->tandatangan_tanggal_lahir);
    }
    $model->pelepasan_informasi = CJSON::decode($model->pelepasan_informasi);
    $model->tgl_persetujuan = MyFormatter::formatDateTimeForUser($model->tgl_persetujuan);

    $this->render($this->path_view . 'view', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

    if (empty($modPendaftaran)) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }

    $model = SuratpersetujuanumumT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    if (empty($model)) {
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $pj = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);

      $model = new SuratpersetujuanumumT;
      $model->pendaftaran_id = $pendaftaran_id;
      $model->pasien_nama = $modPasien->nama_pasien;
      $model->pasien_jeniskelamin = $modPasien->jeniskelamin;
      $model->pasien_tanggal_lahir = $modPasien->tanggal_lahir;
      $model->pasien_no_rekam_medik = $modPasien->no_rekam_medik;
      $model->pasien_alamat = $modPasien->alamat_pasien;
      $model->tgl_persetujuan = date('Y-m-d H:i:s');
      $model->petugas_admisi = Yii::app()->user->getState('nama_pegawai');

      $model->ijin_mengunjungi = false;
      $model->ingin_privasi = false;

      if (!empty($pj)) {
        $model->tandatangan_nama = $model->penanggungjawab_pasien = $pj->nama_pj;
        $model->tandatangan_jeniskelamin = $pj->jeniskelamin;
        $model->tandatangan_tanggal_lahir = $pj->tgllahir_pj;
        $model->tandatangan_telepon = empty($pj->no_teleponpj) ? $pj->no_mobilepj : $pj->no_teleponpj;
        $model->tandatangan_hubungan = $pj->hubungankeluarga;
        $model->tandatangan_alamat = $pj->alamat_pj;
      }
    } else {
    }

    if (!empty($model->pasien_tanggal_lahir)) {
      $model->pasien_tanggal_lahir = MyFormatter::formatDateTimeForUser($model->pasien_tanggal_lahir);
    }
    if (!empty($model->tandatangan_tanggal_lahir)) {
      $model->tandatangan_tanggal_lahir = MyFormatter::formatDateTimeForUser($model->tandatangan_tanggal_lahir);
    }
    $model->pelepasan_informasi = CJSON::decode($model->pelepasan_informasi);
    $model->tgl_persetujuan = MyFormatter::formatDateTimeForUser($model->tgl_persetujuan);

    if (isset($_POST['SuratpersetujuanumumT'])) {
      $model->attributes = $_POST['SuratpersetujuanumumT'];

      $info = $model->pelepasan_informasi;
      $info_hasil = array();

      if (!empty($info)) {
        foreach ($info as $item) {
          if (!empty($item)) {
            $info_hasil[] = $item;
          }
        }
      }


      $model->tgl_persetujuan = MyFormatter::formatDateTimeForDB($model->tgl_persetujuan);
      $model->tandatangan_tanggal_lahir = MyFormatter::formatDateTimeForDB($model->tandatangan_tanggal_lahir);
      $model->pasien_tanggal_lahir = MyFormatter::formatDateTimeForDB($model->pasien_tanggal_lahir);

      $model->ijin_mengunjungi = $model->ijin_mengunjungi == 1 ? true : false;
      $model->ingin_privasi = $model->ingin_privasi == 1 ? true : false;

      $model->pelepasan_informasi = CJSON::encode($info_hasil);

      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState("ruangan_id");

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create', 'pendaftaran_id' => $model->pendaftaran_id));
      } else {
        Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan.');
        $this->redirect(array('create', 'pendaftaran_id' => $model->pendaftaran_id));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien
    ));
  }


  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * Memanggil dan menonaktifkan status 
   */
  public function actionNonActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example: 
      // $model->modelaktif = false;
      // if($model->save()){
      //	$data['sukses'] = 1;
      // }
      echo CJSON::encode($data);
    }
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SuratpersetujuanumumT');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SuratpersetujuanumumT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SuratpersetujuanumumT'])) {
      $model->attributes = $_GET['SuratpersetujuanumumT'];
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = SuratpersetujuanumumT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'suratpersetujuanumum-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    if (empty($modPendaftaran)) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }

    $model = SuratpersetujuanumumT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));

    if (empty($model)) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }

    if (!empty($model->pasien_tanggal_lahir)) {
      $model->pasien_tanggal_lahir = MyFormatter::formatDateTimeForUser($model->pasien_tanggal_lahir);
    }
    if (!empty($model->tandatangan_tanggal_lahir)) {
      $model->tandatangan_tanggal_lahir = MyFormatter::formatDateTimeForUser($model->tandatangan_tanggal_lahir);
    }
    $model->pelepasan_informasi = CJSON::decode($model->pelepasan_informasi);
    $model->tgl_persetujuan = MyFormatter::formatDateTimeForUser($model->tgl_persetujuan);

    $this->render($this->path_view . 'Print', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
    ));
  }

  public function actionIndexKeuangan($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    if (empty($modPendaftaran) && empty($modAdmisi)) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $model = SuratpersetujuanumumT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'is_keuangan' => true
    ));

    if (empty($model)) {
      $model = new SuratpersetujuanumumT;
      $model->pendaftaran_id = $pendaftaran_id;
      $model->pasien_nama = $modPasien->nama_pasien;
      $model->pasien_jeniskelamin = $modPasien->jeniskelamin;
      $model->pasien_tanggal_lahir = $modPasien->tanggal_lahir;
      $model->pasien_no_rekam_medik = $modPasien->no_rekam_medik;
      $model->pasien_alamat = $modPasien->alamat_pasien;
      $model->tgl_persetujuan = date('Y-m-d H:i:s');
      $model->petugas_admisi = Yii::app()->user->getState('nama_pegawai');
    }

    if (!empty($model->pasien_tanggal_lahir)) {
      $model->pasien_tanggal_lahir = MyFormatter::formatDateTimeForUser($model->pasien_tanggal_lahir);
    }
    if (!empty($model->tandatangan_tanggal_lahir)) {
      $model->tandatangan_tanggal_lahir = MyFormatter::formatDateTimeForUser($model->tandatangan_tanggal_lahir);
    }
    $model->pelepasan_informasi = CJSON::decode($model->pelepasan_informasi);
    $model->tgl_persetujuan = MyFormatter::formatDateTimeForUser($model->tgl_persetujuan);

    if (isset($_POST['SuratpersetujuanumumT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SuratpersetujuanumumT'];
        $model->is_keuangan = true;
        $model->pasien_jeniskelamin = $modPasien->jeniskelamin;

        if (!empty($_POST['Peraturankeuangan'])) {
          $peraturankeuangan = array();
          foreach ($_POST['Peraturankeuangan'] as $item) {
            if ((!empty($item['iscek'])) && $item['iscek'] == 1) {
              $peraturankeuangan[] = $item['nama'];
            }
          }
          if (count((array)$peraturankeuangan) > 0) {
            $model->peraturankeuangan = json_encode($peraturankeuangan);
          }
        }

        $model->tgl_persetujuan = MyFormatter::formatDateTimeForDB($model->tgl_persetujuan);
        $model->tandatangan_tanggal_lahir = MyFormatter::formatDateTimeForDB($model->tandatangan_tanggal_lahir);
        $model->pasien_tanggal_lahir = MyFormatter::formatDateTimeForDB($model->pasien_tanggal_lahir);

        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState("ruangan_id");

        if ($model->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('indexKeuangan', 'pendaftaran_id' => $model->pendaftaran_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Data gagal disimpan.');
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view . 'indexKeuangan', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
      'modAdmisi' => $modAdmisi,
      'modPasien' => $modPasien
    ));
  }

  public function actionPrintKeuangan($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    if (empty($modPendaftaran) && empty($modAdmisi)) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model = SuratpersetujuanumumT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'is_keuangan' => true
    ));

    if (empty($model)) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }

    if (!empty($model->pasien_tanggal_lahir)) {
      $model->pasien_tanggal_lahir = MyFormatter::formatDateTimeForUser($model->pasien_tanggal_lahir);
    }
    if (!empty($model->tandatangan_tanggal_lahir)) {
      $model->tandatangan_tanggal_lahir = MyFormatter::formatDateTimeForUser($model->tandatangan_tanggal_lahir);
    }

    $this->render($this->path_view . 'PrintKeuangan', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
      'modAdmisi' => $modAdmisi,
      'modPasien' => $modPasien
    ));
  }

  public function actionPrintGeneralConsent($pendaftaran_id = null)
  {

    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

    $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $pasien_id = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : null);
    $modPasien =  PasienM::model()->findByPk($pasien_id);
    $modSurat = SuratpersetujuanumumT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $judul_print = 'Kunjungan Rawat Inap';
    $this->render($this->path_view . '_generalConsentNew', array(
      'format' => $format,
      'modPasienAdmisi' => $modPasienAdmisi,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modSurat' => $modSurat,
    ));
  }
}

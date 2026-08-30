<?php

/**
 * Digunakan untuk menampilkan Informasi Permintaan Darah Pasien di modul Bank Darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class InformasiPermintaanDarahPasienRuanganController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'bankDarah.views.informasiPermintaanDarahRuangan';

  /**
   * Load data permintaan darah
   */
  public function actionIndex()
  {
    $model = new BDInfopermintaandarahpasien();
    $pemeriksaan = new BDUjidarahpasienT();
    $model->unsetAttributes();  // clear any default values
    $format = new MyFormatter();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    if (isset($_GET['BDInfopermintaandarahpasien'])) {
      $model->attributes = $_GET['BDInfopermintaandarahpasien'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDInfopermintaandarahpasien']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDInfopermintaandarahpasien']['tgl_akhir']);
      $model->no_permintaandarah = $_GET['BDInfopermintaandarahpasien']['no_permintaandarah'];
      /*
                $model->no_rekam_medik = $_GET['BDInfopermintaandarahpasien']['no_rekam_medik'];
                $model->nama_pasien = $_GET['BDInfopermintaandarahpasien']['nama_pasien'];
                $model->ruanganpemesan_id = $_GET['BDInfopermintaandarahpasien']['ruanganpemesan_id'];
                $model->carabayar_id = $_GET['BDInfopermintaandarahpasien']['carabayar_id'];
                $model->penjamin_id =$_GET['BDInfopermintaandarahpasien']['penjamin_id'];
                 * 
                 */
    }

    $this->render($this->path_view . '/index', array(
      'model' => $model,
      'format' => $format,
      'pemeriksaan' => $pemeriksaan
    ));
  }

  /**
   * Digunakan untuk menampilkan detail pengujian kompatibilitas
   * RSST-2270
   * @author  Andyka <andykaputra@.com>                    
   * @param type $id
   * @param type $ujidarahpasien_id
   * @param type $tglujikompatibilitas
   */
  public function actionDetailKompatibilitas($id, $ujidarahpasien_id, $ujikompatibilitas_ke)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $modPermintaanDarah = BDPermintaandarahT::model()->findByPk($id);
    $modUjiDarahPasien = UjidarahpasienT::model()->findByAttributes(array('permintaandarah_id' => $modPermintaanDarah->permintaandarah_id, 'metodedarah_id' => Params::METODE_DARAH_ID_SLIDE_TEST));
    $modUjiDarah = BDUjidarahpasienT::model()->findByPk($ujidarahpasien_id);
    $modUjiKompatibilitas = BDUjikompatibilitasT::model()->findByAttributes(array('ujidarahpasien_id' => $ujidarahpasien_id, 'ujikompatibilitas_ke' => $ujikompatibilitas_ke));
    $modPengujianDarah = BDPengujiandarahT::model()->findByPk($modUjiKompatibilitas->pengujiandarah_id);

    $modPendaftaran = BDPendaftaranT::model()->findByPk($modPermintaanDarah->pendaftaran_id);


    $this->render($this->path_view . '/detailkompatibilitas', array(
      'modUjiKompatibilitas' => $modUjiKompatibilitas,
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPermintaanDarah' => $modPermintaanDarah,
      'modUjiDarah' => $modUjiDarah,
      'modPengujianDarah' => $modPengujianDarah,
      'modUjiDarahPasien' => $modUjiDarahPasien
    ));
  }
  /**
   * Load tampilan batal minta darah dan melakukan transaksi batal permintaan 
   * @param type $permintaandarah_id
   */
  public function actionBatal($permintaandarah_id)
  {
    $this->layout = '//layouts/iframe';
    $model = PermintaandarahT::model()->findByPk($permintaandarah_id);
    $modelBatal = new BatalmintadarahR();
    $modelBatal->tglpembatalan = "d M Y H:i:s";
    $modelBatal->permintaandarah_id = $permintaandarah_id;

    $this->render($this->path_view . '/_batalPermintaan', array(
      'model' => $model,
      'modelBatal' => $modelBatal
    ));
  }

  /**
   * Pembatalan permintaan darah 
   * @throws CHttpException
   */
  public function actionAjaxUbahStatus()
  {
    if (Yii::app()->request->isPostRequest) {
      $tanggal = MyFormatter::formatDateTimeForDb($_POST['tanggal']);
      $alasan = $_POST['alasan'];
      $id = $_POST['id'];
      $pegawai = $_POST['pegawai'];
      $modelBatal = new BatalmintadarahR;
      $modelBatal->permintaandarah_id = $id;
      $modelBatal->alasanpembatalan = $alasan;
      $modelBatal->tglpembatalan = $tanggal;
      $modelBatal->pegawai_id = $pegawai;
      $modelBatal->create_time = date('Y-m-d H:i:s');
      $modelBatal->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
      $modelBatal->create_ruangan = Yii::app()->user->getState('ruangan_id');

      $updatePermintaan = PermintaandarahT::model()->updateByPk($id, array('isbatal' => 1));
      if ($modelBatal->save() && $updatePermintaan) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Pembatalan berhasil disimpan.</div>",
          ));
          exit;
        }
      } else {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'gagal_form',
            'div' => "<div class='flash-danger'>Pembatalan gagal disimpan.</div>",
          ));
          exit;
        }
      }
    } else {
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
  }

  /**
   * Memverifikasi permintaan darah
   * @param type $permintaandarah_id
   */
  public function actionVerifikasi($permintaandarah_id)
  {
    $this->layout = '//layouts/iframe';
    $penjamin = '-';
    $diagnosis = '-';
    $ruangan = '-';
    $model = PermintaandarahT::model()->findByPk($permintaandarah_id);
    $modPasien = PasienM::model()->findByPk($model->pasien_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
    if (!empty($modPendaftaran->penjamin_id)) {
      $modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
      if (!empty($modPenjamin)) {
        $penjamin = $modPenjamin->penjamin_nama;
      }
    }
    if (!empty($modPendaftaran->ruangan_id)) {
      $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
      if (!empty($modRuangan)) {
        $ruangan = $modRuangan->ruangan_nama;
      }
    }
    if (!empty($model->diagnosis)) {
      $diagnosis = $model->diagnosis;
    }
    $model->waktu_terima = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    return $this->render($this->path_view . '/verifikasi', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'penjamin' => $penjamin,
      'diagnosis' => $diagnosis,
      'ruangan' => $ruangan,
    ));
  }

  /**
   * digunakan untuk autocomplete pegawai
   */
  public function actionAutocompletePetugas()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nama = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama), true);;
      $criteria->addCondition('ruangan_id =' . Yii::app()->user->ruangan_id);
      $criteria->limit = 5;
      $models = PegawairuanganV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . " - " . $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * digunakan untuk menyimpan verifikasi permintaan darah
   */
  public function actionAjaxSimpanVerifikasi()
  {
    if (Yii::app()->request->isPostRequest) {
      $waktu_terima = MyFormatter::formatDateTimeForDb($_POST['waktu_terima']);
      $pegawai_penerima_id = $_POST['pegawai_penerima_id'];
      $permintaandarah_id = $_POST['permintaandarah_id'];
      $is_pasiensama = $_POST['is_pasiensama'];
      $model = PermintaandarahT::model()->findByPk($permintaandarah_id);
      $model->waktu_terima = $waktu_terima;
      $model->pegawai_penerima_id = $pegawai_penerima_id;
      $model->permintaandarah_id = $permintaandarah_id;
      $model->is_pasiensama = $is_pasiensama;
      if ($model->save()) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'berhasil_form',
            'div' => "<div class='flash-success'>Verifikasi berhasil disimpan.</div>",
          ));
          exit;
        }
      } else {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'gagal_form',
            'div' => "<div class='flash-danger'>Verifikasi gagal disimpan.</div>",
          ));
          exit;
        }
      }
    } else {
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
  }
}

<?php

/**
 * Digunakan untuk menampilkan Informasi Permintaan Darah Pasien di modul Bank Darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class InformasiPermintaanDarahPasienController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'bankDarah.views.informasiPermintaanDarah';

  /**
   * Load data permintaan darah
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Permintaan Darah Pasien";
    $model = new BDPasienKirimKeUnitLainT();
    $model->unsetAttributes();  // clear any default values
    $format = new MyFormatter();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $model->ruangan_id = Params::RUANGAN_ID_BANK_DARAH;
    if (isset($_GET['BDPasienKirimKeUnitLainT'])) {
      $model->attributes = $_GET['BDPasienKirimKeUnitLainT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDPasienKirimKeUnitLainT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDPasienKirimKeUnitLainT']['tgl_akhir']);
      $model->noperminatanpenujang = $_GET['BDPasienKirimKeUnitLainT']['noperminatanpenujang'];
      $model->ruangan_id = $_GET['BDPasienKirimKeUnitLainT']['ruangan_id'];
      $model->instalasi_id = $_GET['BDPasienKirimKeUnitLainT']['instalasi_id'];
      $model->carabayar_id = $_GET['BDPasienKirimKeUnitLainT']['carabayar_id'];
      $model->penjamin_id =$_GET['BDPasienKirimKeUnitLainT']['penjamin_id'];
      $model->no_rekam_medik = $_GET['BDPasienKirimKeUnitLainT']['no_rekam_medik'];
      $model->nama_pasien = $_GET['BDPasienKirimKeUnitLainT']['nama_pasien'];
    
    }

    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'permintaandarah-r-grid') {
        $this->renderPartial($this->path_view . '._table', ['model' => $model]);
        Yii::app()->end();
      }
    }

    $this->render($this->path_view . '/index', array(
      'model' => $model,
      'format' => $format,
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
   * Tambah / ubah Jadwal Tindakan
   */
  public function actionBuatJadwal($pasienkirimkeunitlain_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();

    $kirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
    $permintaan = PermintaankepenunjangT::model()->findAll("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id");
   
    
    if (isset($_POST['pasienkirimkeunitlain_id'])) {
      // echo '<pre>'; var_dump($_POST); die;
      
      $transaction = Yii::app()->db->beginTransaction();

      try {

        $ok = false;

        if(!empty($_POST['pasienkirimkeunitlain_id'])) {
            $kirim->tgl_jadwalpemeriksaan = MyFormatter::formatDateTimeForDb($_POST['tgl_jadwalpemeriksaan']);
            $kirim->petugas_jadwal_id = Yii::app()->user->getState('pegawai_id');

            if($kirim->save()) {
              $ok = true;
            }
        }


        // $ok &= PendaftaranT::model()->updateByPk($kirim->pendaftaran_id, array('ruangan_id' => Yii::app()->user->getState('ruangan_id'),
        //  'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->getState('pegawai_id')));

        //  var_dump($ok); die;
       
        if ($ok) {

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Jadwal Berhasil dibuat !");
          $this->redirect(array('buatJadwal', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'sukses' => 1));
        } else {
          $transaction->rollback();

          Yii::app()->user->setFlash('error', "Jadwal gagal dibuat[1] !<br>");
        }
      } catch (Exception $exc) {
        // var_dump($exc); die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Jadwal gagal dibuat[2] !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view.'.buatJadwal', array(
      'kirim' => $kirim,
      'permintaan' => $permintaan
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

  public function actionSetRuangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $list = '';
    
      $instalasi_id = $_POST['instalasi_id'];
      $criteria = new CdbCriteria();
      if (!empty($instalasi_id)) {
        $criteria->addCondition('instalasi_id = ' . $instalasi_id);
      }
      $criteria->addCondition('ruangan_aktif IS TRUE');
      $criteria->order = "ruangan_nama";
      $model = RuanganM::model()->findAll($criteria);
      $list .= '<option value="null">---Pilih---</option>';
      foreach ($model as $i => $ruangan) {
        $list .= '<option value="' . $ruangan->ruangan_id . '">' . $ruangan->ruangan_nama . '</option>';
      }
      echo CJSON::encode(array(
        'list' => $list,
      ));
      Yii::app()->end();
    }
  }

  public function actionPrintUlangTindakanPenunjangDialog($pasienmasukpenunjang_id)
  {
    Yii::import('rawatJalan.models.*');
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $penunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($penunjang->pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);


    $modTindakan = new RJTindakanPelayananT;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->dokterpemeriksa1_id = $penunjang->pegawai_id ?? $modPendaftaran->pegawai_id;
    $modTindakan->dokterpemeriksa1Nama = $penunjang->pegawai->NamaLengkap ?? $modPendaftaran->pegawai->namaLengkap ?? "-";
    
    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $modPendaftaran->penjamin_id);

    $this->render(
      $this->path_view . '/printUlangPenunjangDialog',
      array(
        'format' => $format,
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modTindakan' => $modTindakan,
        'modJenisTarif' => $modJenisTarif,
        'penunjang' => $penunjang,
      )
    );
  }
}

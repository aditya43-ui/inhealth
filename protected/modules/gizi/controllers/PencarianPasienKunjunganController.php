<?php

class PencarianPasienKunjunganController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $successSavepasienKirimKeUnitLain = false;
  public $successSaveHasilPemeriksaan = false;
  public $successSavePasienMasukPenunjang = false;
  public $errorMessages = 'error<br/>';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $modRJ = new GZInfoKunjunganRJV;
    $modRI = new GZInfoKunjunganRIV;
    $modRD = new GZInfoKunjunganRDV;
    $cekRJ = true;
    $cekRI = false;
    $cekRD = false;
    $modRJ->tgl_awal = date("d M Y");
    $modRJ->tgl_akhir = date('d M Y');
    $modRI->tgl_awal = date("d M Y");
    $modRI->tgl_akhir = date('d M Y');
    $modRD->tgl_awal = date("d M Y");
    $modRD->tgl_akhir = date('d M Y');


    if (isset($_POST['instalasi'])) {
      switch ($_POST['instalasi']) {
        case 'RJ':
          $cekRJ = true;
          $cekRI = false;
          $cekRD = false;
          if (isset($_POST['GZInfoKunjunganRJV'])) {
            $modRJ->attributes = $_POST['GZInfoKunjunganRJV'];
          }
          if (!empty($_POST['GZInfoKunjunganRJV']['tgl_awal'])) {
            $modRJ->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GZInfoKunjunganRJV']['tgl_awal']);
          }
          if (!empty($_POST['GZInfoKunjunganRJV']['tgl_awal'])) {
            $modRJ->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GZInfoKunjunganRJV']['tgl_akhir']);
          }

          break;

        case 'RI':
          $cekRI = true;
          $cekRJ = false;
          $cekRD = false;
          if (isset($_POST['GZInfoKunjunganRIV'])) {
            $modRI->attributes = $_POST['GZInfoKunjunganRIV'];
          }
          if (!empty($_POST['GZInfoKunjunganRIV']['tgl_awal'])) {
            $modRI->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GZInfoKunjunganRIV']['tgl_awal']);
          }
          if (!empty($_POST['GZInfoKunjunganRIV']['tgl_awal'])) {
            $modRI->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GZInfoKunjunganRIV']['tgl_akhir']);
          }
          break;

        case 'RD':
          $cekRD = true;
          $cekRI = false;
          $cekRJ = false;
          if (isset($_POST['GZInfoKunjunganRDV'])) {
            $modRD->attributes = $_POST['GZInfoKunjunganRDV'];
          }
          if (!empty($_POST['GZInfoKunjunganRDV']['tgl_awal'])) {
            $modRD->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GZInfoKunjunganRDV']['tgl_awal']);
          }
          if (!empty($_POST['GZInfoKunjunganRDV']['tgl_awal'])) {
            $modRD->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GZInfoKunjunganRDV']['tgl_akhir']);
          }

          break;
      }
    }

    $this->render('index', array(
      'modRJ' => $modRJ,
      'modRI' => $modRI,
      'modRD' => $modRD,
      'cekRJ' => $cekRJ,
      'cekRI' => $cekRI,
      'cekRD' => $cekRD,
    ));
  }

  public function actionDaftarDariPasienRujukan($pendaftaran_id, $pasien_id, $pasienadmisi_id)
  {
    if (empty($pasienadmisi_id)) { //Jika Pasien Bukan dari RI
      $modPendaftaran = GZPendaftaranT::model()->findByPk($pendaftaran_id);
    } else {
      $modPendaftaran = GZPasienAdmisiT::model()->with('pendaftaran')->findByPk($pasienadmisi_id);
    }
    $modPasien = GZPasienM::model()->findByPk($pasien_id);
    //            $modPeriksaLab = GZPemeriksaanLabM::model()->findAllByAttributes(array('pemeriksaanlab_aktif'=>true),array('order'=>'pemeriksaanlab_urutan'));
    //            $modJenisPeriksaLab = GZJenisPemeriksaanLabM::model()->findAllByAttributes(array('jenispemeriksaanlab_aktif'=>true),array('order'=>'jenispemeriksaanlab_urutan'));


    if (!empty($_POST['PemeriksaanLab'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $this->savePasienMasukPenunjang($modPasien, $modPendaftaran);

        if (
          $this->successSavepasienKirimKeUnitLain && $this->successSaveHasilPemeriksaan
          && $this->successSavePasienMasukPenunjang
        ) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
          $this->redirect(array('index'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
          Yii::app()->user->setFlash('info', $this->errorMessages);
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $this->render('daftarDariPasienRujukan', array(
      'modPeriksaLab' => $modPeriksaLab,
      'modJenisPeriksaLab' => $modJenisPeriksaLab,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'pasienadmisi_id' => $pasienadmisi_id,
    ));
  }

  protected function savePasienMasukPenunjang($modPasien, $modPendaftaran)
  {
    $modPasienMasukPenunjang = new GZPasienMasukPenunjangT;
    $modPasienMasukPenunjang->pasien_id = $modPasien->pasien_id;
    if (!empty($modPendaftaran->pasienadmisi_id)) { ////Jika Pasien Berasal dari Rawat Inap
      $modPasienMasukPenunjang->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
      $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran->pendaftaran_id;
      $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modPendaftaran->pendaftaran->jeniskasuspenyakit_id;
      $no_pendaftaran = $modPendaftaran->pendaftaran->no_pendaftaran;
      $modPasienMasukPenunjang->statusperiksa = $modPendaftaran->pendaftaran->statusperiksa;
    } else { ////Jika Pasien berasal dari RJ ataw RD
      $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
      $no_pendaftaran = $modPendaftaran->no_pendaftaran;
      $modPasienMasukPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
    }
    $modPasienMasukPenunjang->pegawai_id = $modPendaftaran->pegawai_id;
    $modPasienMasukPenunjang->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modPasienMasukPenunjang->ruangan_id = Params::RUANGAN_ID_LAB;
    $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang('GZ');
    $modPasienMasukPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');
    $modPasienMasukPenunjang->no_urutperiksa = MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
    $modPasienMasukPenunjang->kunjungan = $modPendaftaran->kunjungan;
    $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    if ($modPasienMasukPenunjang->validate()) { //Jika proses Palidasi Pasien Masuk Penunjang Berhasil
      if ($modPasienMasukPenunjang->save()) { //Jika $modPasienMasukPenunjang Berhasil Disimpan
        $this->successSavePasienMasukPenunjang = true;
        //Yii::app()->user->setFlash('success',"Data Pasien Masuk Penunjang berhasil Disimpan.");
        $this->savePasienKirimKeUnitLain($modPasien, $modPendaftaran, $modPasienMasukPenunjang);
        $this->saveHasilPemeriksaan($modPasienMasukPenunjang, $modPendaftaran, $modPasien, $_POST['PemeriksaanLab']); //Simpan Hasil Pemeriksaan
      } else { //Jika $modPasienMasukPenunjang Gagal Disimpan
        $this->successSavePasienMasukPenunjang = false;
        //Yii::app()->user->setFlash('error',"Data Pasien Masuk Pennunjang Gagal Disimpan.");
        $this->errorMessages .= "Data Pasien Masuk Penunjang Gagal Disimpan.<br/>";
      }
    } else { //Jika proses Palidasi Pasien Masuk Penunjang Berhasil Gagal
      $this->successSavePasienMasukPenunjang = false;
      //Yii::app()->user->setFlash('error',"Data Pasien Masuk Pennunjang Tidak Tervalidasi.");
      $this->errorMessages .= "Data Pasien Masuk Penunjang Tidak Tervalidasi.</br>";
    }
  }

  protected function savePasienKirimKeUnitLain($modPasien, $modPendaftaran, $modPasienMasukPenunjang)
  {
    $modPasienKirimKeUnitLain = new GZPasienKirimKeUnitLainT;
    $modPasienKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modPasienKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_LAB;
    $modPasienKirimKeUnitLain->pasien_id = $modPasien->pasien_id;
    $modPasienKirimKeUnitLain->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    $modPasienKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_LAB;
    $modPasienKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modPasienKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPasienKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modPasienKirimKeUnitLain->ruangan_id);
    $modPasienKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modPasienKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modPasienKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modPasienKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    $modPasienKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modPasienKirimKeUnitLain->validate()) {
      if ($modPasienKirimKeUnitLain->save()) {
        $this->successSavepasienKirimKeUnitLain = true;
        //Yii::app()->user->setFlash('success',"Data Pasien Masuk Penunjang berhasil Disimpan.");
      } else {
        $this->successSavepasienKirimKeUnitLain = false;
        //Yii::app()->user->setFlash('error',"Data Pasien Kirim Ke Unit Lain Gagal Disimpan.");
        $this->errorMessages .= "Data Pasien Kirim Ke Unit Lain Gagal Disimpan. <br/>";
      }
    } else {
      $this->successSavepasienKirimKeUnitLain = false;
      //Yii::app()->user->setFlash('error',"Data Pasien Kirim Ke Unit Lain Tidak Valid");
      $this->errorMessages .= "Data Pasien Kirim Ke Unit Lain Tidak Valid. <br/>";
    }
    return $modPasienKirimKeUnitLain;
  }

  public function actionLoadFormPemeriksaanLabPendLab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPemeriksaanLab = (isset($_POST['idPemeriksaanlab']) ? $_POST['idPemeriksaanlab'] : null);
      $idKelasPelayan = (isset($_POST['kelasPelayan_id']) ? $_POST['kelasPelayan_id'] : null);
      $modPeriksaLab = PemeriksaanlabM::model()->with('jenispemeriksaan')->findByPk($idPemeriksaanLab);
      $modTindakanRuangan = TariftindakanperdaV::model()->findByAttributes(array('daftartindakan_id' => $modPeriksaLab->daftartindakan_id, 'kelaspelayanan_id' => $idKelasPelayan, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL));
      //$modTindakanRuangan = TindakanruanganV::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaLab->daftartindakan_id));

      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial('_formLoadPemeriksaanLabPendLab', array(
          'modPeriksaLab' => $modPeriksaLab,
          'modTindakanRuangan' => $modTindakanRuangan,
          'idKelasPelayan' => $idKelasPelayan
        ), true)
      ));
      exit;
    }
  }
}

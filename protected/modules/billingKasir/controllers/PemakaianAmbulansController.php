<?php
class PemakaianAmbulansController extends MyAuthController
{
  public $layout = "//layouts/iframe";
  protected $obatalkespasientersimpan = true;
  protected $tindakanpelayanantersimpan = true;
  public $path_view = 'billingKasir.views.pemakaianAmbulans.';

  public function actionIndex($instalasi_id = null, $pendaftaran_id, $pemakaian_id = '')
  {
    $format = new MyFormatter();
    $modPasien = new PasienM;
    $modKunjungan = new BKInfokunjunganrjV;
    $modObatAlkesPasien = new BKObatalkesPasienT;
    $modPemakaian = new BKPemakaianambulansT;

    $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
    $modInstalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true), array('order' => 'instalasi_nama'));

    $instalasi = '';
    $tarif = array();
    $tarif['tarifAmbulans'][] = null;

    //        if(!empty($pemesanan_id)){
    //            $modPemakaian = $this->setDataPemakaianFromPemesanan($pemesanan_id);
    //            $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
    //        }

    if (!empty($pendaftaran_id)) {
      $modPemakaian = $this->setDataPemakaianFromPendaftaran($pendaftaran_id);
      $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
    }

    if (!empty($pemakaian_id)) {
      $modPemakaian = $this->setDataPemakaianFromPemakaian($pemakaian_id);
      $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
    }

    $dataTindakans = array();
    $modTindakan = new BKTindakanPelayananT;
    //        $modTindakan->instalasi_id = (!empty($modPasienAdmisi->ruangan_id) ? $modPasienAdmisi->ruangan->instalasi_id : $modPemakaian->ruangan->instalasi_id);
    //        $modTindakan->instalasi_id = (!empty($instalasi_id) ? $instalasi_id : $modTindakan->instalasi_id); //ditimpa
    $modRiwayatTindakans = $this->loadTindakanPelayanans($_GET['instalasi_id'], $pendaftaran_id);


    if (isset($_POST['BKPemakaianambulansT'])) {
      if (isset($_POST['tarif'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          foreach ($_POST['tarif']['tarifAmbulans'] as $i => $tarifAmbulans) {
            $tarif['tarifAmbulans'][$i] = $tarifAmbulans;
            $tarif['tarifKM'][$i] = $_POST['tarif']['tarifKM'][$i];
            $tarif['jmlKM'][$i] = $_POST['tarif']['jmlKM'][$i];
            $tarif['kelurahan'][$i] = $_POST['tarif']['kelurahan'][$i];
            $tarif['kecamatan'][$i] = $_POST['tarif']['kecamatan'][$i];
            $tarif['kabupaten'][$i] = $_POST['tarif']['kabupaten'][$i];
            $tarif['propinsi'][$i] = $_POST['tarif']['propinsi'][$i];
            $tarif['daftartindakanId'][$i] = $_POST['tarif']['daftartindakanId'][$i];
            //=== set attribute pemakaian ambulans ===//
            $save = true;
            $modPemakaian = new BKPemakaianambulansT;
            $modPemakaian->attributes = $_POST['BKPemakaianambulansT'];
            $modPemakaian->rt_rw = $_POST['BKPemakaianambulansT']['rt'] . '/' . $_POST['BKPemakaianambulansT']['rw'];
            $modPemakaian->tarifperkm = $tarif['tarifKM'][$i];
            $modPemakaian->jumlahkm = $tarif['jmlKM'][$i];
            $modPemakaian->totaltarifambulans = $tarif['tarifAmbulans'][$i];
            $modPemakaian->daftartindakanId = $tarif['daftartindakanId'][$i];
            $modPemakaian->create_time = date('Y-m-d H:i:s');
            $modPemakaian->create_loginpemakai_id = Yii::app()->user->id;
            $modPemakaian->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPemakaian->noidentitas = Yii::app()->user->getState('ruangan_id');
            $instalasi = $_POST['instalasi'];
            $format = new MyFormatter();
            $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($_POST['BKPemakaianambulansT']['tglpemakaianambulans']);
            $modPemakaian->tglkembaliambulans = $format->formatDateTimeForDb($_POST['BKPemakaianambulansT']['tglkembaliambulans']);

            //=== save pemakaian ambulans ===//
            if ($modPemakaian->validate()) {
              $save = $save && $modPemakaian->save();
              if (!empty($modPemakaian->pendaftaran_id) && $save) {
                $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $this->simpanTindakanPelayanan($modPasien, $modPendaftaran, $modPemakaian);
              }
              if (!empty($pemesanan_id)) {
                BKPesanambulansT::model()->updateByPk($pemesanan_id, array('pemakaianambulans_id' => $modPemakaian->pemakaianambulans_id));
              }
            } else {
              $save = false;
            }
          }
          //=== commit or rollback ===//
          if ($save && $this->obatalkespasientersimpan && $this->tindakanpelayanantersimpan) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
            $sukses = 1;
            $modPemakaian->isNewRecord = FALSE;
            $this->redirect(array('index', 'instalasi_id' => Params::INSTALASI_ID_AMBULAN, 'pendaftaran_id' => $modPemakaian->pendaftaran_id, 'pemakaian_id' => $modPemakaian->pemakaianambulans_id, 'sukses' => $sukses));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Gagal disimpan");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render($this->path_view . 'index', array(
      'modPemakaian' => $modPemakaian,
      'modPasien' => $modPasien,
      'modInstalasi' => $modInstalasi,
      'instalasi' => $instalasi,
      'tarif' => $tarif,
      'modKunjungan' => $modKunjungan,
      'format' => $format,
      'modRiwayatTindakans' => $modRiwayatTindakans
    ));
  }

  /**
   * load tindakanpelayananT yg tersimpan
   * @param type $pendaftaran_id
   * @param type $pasienadmisi_id\
   */
  protected function loadTindakanPelayanans($instalasi_id, $pendaftaran_id)
  {
    $criteria = new CDbCriteria();
    $criteria->addCondition('instalasi_id = ' . $instalasi_id);
    $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    $criteria->order = 'tgl_tindakan';
    $modTindakans = BKTindakanPelayananT::model()->findAll($criteria);
    return $modTindakans;
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - instalasi_id
   * - pendaftaran_id
   * - pasienadmisi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      if (!empty($pasienadmisi_id)) {
        $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
      }
      if (!empty($instalasi_id)) {
        $criteria->addCondition("instalasi_id = " . $instalasi_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $model = BKInfokunjunganrjV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $model = BKInfoKunjunganRDV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $model = BKPasienrawatinapV::model()->find($criteria);
      } else {
        $model = null;
      }

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $models = BKInfokunjunganrjV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $models = BKInfoKunjunganRDV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $models = BKPasienrawatinapV::model()->find($criteria);
      }
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * menghapus tindakanpelayanan (ajax)
   */
  public function actionHapusTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $loadTindakanPelayanan = TindakanpelayananT::model()->findByPk($_POST['tindakanpelayanan_id']);
        $deleteTindakanKomponen = TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $_POST['tindakanpelayanan_id']));
        $deleteObatAlkes = ObatalkespasienT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $_POST['tindakanpelayanan_id']));
        if ($loadTindakanPelayanan->delete()) {
          $transaction->commit();
          $data['pesan'] = "Tindakan dan pemakaian bahan & alat medis berhasil dihapus!";
          $data['sukses'] = 1;
        } else {
          $transaction->rollback();
          $data['pesan'] = "Tindakan dan pemakaian bahan & alat medis gagal dihapus!";
          $data['sukses'] = 0;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Tindakan dan pemakaian bahan & alat medis gagal dihapus! :" . MyExceptionMessage::getMessage($exc, true);
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionAutocompleteSupir()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nama_supir = isset($_GET['supir_nama']) ? $_GET['supir_nama'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_supir), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = SupirambulansV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompleteParamedis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nama_paramedis = isset($_GET['paramedis_nama']) ? $_GET['paramedis_nama'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_paramedis), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = ParamedisV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompleteKendaraan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $mobilambulans_kode = isset($_GET['mobilambulans_kode']) ? $_GET['mobilambulans_kode'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(mobilambulans_kode)', strtolower($mobilambulans_kode), true);
      $criteria->order = 'mobilambulans_kode';
      $criteria->limit = 5;
      $models = MobilambulansM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->mobilambulans_kode . " - " . $model->nopolisi . " - " . $model->jeniskendaraan;
        $returnVal[$i]['value'] = $model->mobilambulans_kode;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  protected function setDataPemakaianFromPendaftaran($pendaftaran_id)
  {
    $format = new MyFormatter();
    $modPemakaian = new BKPemakaianambulansT;
    $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
    $modPendaftaran = PendaftaranT::model()->with('pasien')->findByPk($pendaftaran_id);
    $modPemakaian->pasien_id = $modPendaftaran->pasien_id;
    $modPemakaian->namapasien = $modPendaftaran->pasien->nama_pasien;
    $modPemakaian->nomobile = $modPendaftaran->pasien->no_mobile_pasien;
    $modPemakaian->notelepon = $modPendaftaran->pasien->no_telepon_pasien;
    $modPemakaian->norekammedis = $modPendaftaran->pasien->no_rekam_medik;
    $modPemakaian->noidentitas = $modPendaftaran->pasien->no_identitas_pasien;
    $modPemakaian->tempattujuan = '';
    $modPemakaian->alamattujuan = $modPendaftaran->pasien->alamat_pasien;
    $modPemakaian->kelurahan_nama = (isset($modPendaftaran->pasien->kelurahan->kelurahan_nama) ? $modPendaftaran->pasien->kelurahan->kelurahan_nama : "");
    $modPemakaian->rt_rw = $modPendaftaran->pasien->rt . '/' . $modPendaftaran->pasien->rw;
    $modPemakaian->rt = $modPendaftaran->pasien->rt;
    $modPemakaian->rw = $modPendaftaran->pasien->rw;
    $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($modPemakaian->tglpemakaianambulans);
    $modPemakaian->pesanambulans_t = null;
    $modPemakaian->pendaftaran_id = $pendaftaran_id;
    $modPemakaian->ruangan_id = $modPendaftaran->ruangan_id;

    return $modPemakaian;
  }

  protected function setDataPemakaianFromPemesanan($pemesanan_id)
  {
    $format = new MyFormatter();
    $modPemakaian = new BKPemakaianambulansT;
    $modPemesanan = BKPesanambulansT::model()->findByPk($pemesanan_id);
    $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
    $modPasien = PasienM::model()->findByPk($modPemesanan->pasien_id);
    if (isset($modPasien)) {
      $noidentitas = $modPasien->no_identitas_pasien;
    } else {
      $noidentitas = null;
    }
    $modPemakaian->pasien_id = $modPemesanan->pasien_id;
    $modPemakaian->namapasien = $modPemesanan->namapasien;
    $modPemakaian->nomobile = $modPemesanan->nomobile;
    $modPemakaian->notelepon = $modPemesanan->notelepon;
    $modPemakaian->norekammedis = $modPemesanan->norekammedis;
    $modPemakaian->noidentitas = $noidentitas;
    $modPemakaian->tempattujuan = $modPemesanan->tempattujuan;
    $modPemakaian->alamattujuan = $modPemesanan->alamattujuan;
    $modPemakaian->kelurahan_nama = $modPemesanan->kelurahan_nama;
    $modPemakaian->rt_rw = $modPemesanan->rt_rw;
    $modPemakaian->rt = substr($modPemesanan->rt_rw, 0, 2);
    $modPemakaian->rw = substr($modPemesanan->rt_rw, 2, 2);
    $modPemakaian->tglpemakaianambulans = (isset($modPemesanan->tglpemakaianambulans) ? $modPemesanan->tglpemakaianambulans : $format->formatDateTimeForUser($modPemakaian->tglpemakaianambulans));
    $modPemakaian->pesanambulans_t = $pemesanan_id;
    $modPemakaian->pendaftaran_id = $modPemesanan->pendaftaran_id;
    $modPemakaian->ruangan_id = $modPemesanan->ruangan_id;

    return $modPemakaian;
  }

  protected function setDataPemakaianFromPemakaian($pemakaian_id)
  {
    $format = new MyFormatter();
    $modPemakaian = BKPemakaianambulansT::model()->findByPk($pemakaian_id);
    $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
    $modPasien = PasienM::model()->findByPk($modPemakaian->pasien_id);
    if (isset($modPasien)) {
      $noidentitas = $modPasien->no_identitas_pasien;
    } else {
      $noidentitas = $modPemakaian->noidentitas;
    }
    $modPemakaian->pasien_id = $modPemakaian->pasien_id;
    $modPemakaian->namapasien = $modPemakaian->namapasien;
    $modPemakaian->nomobile = $modPemakaian->nomobile;
    $modPemakaian->notelepon = $modPemakaian->notelepon;
    $modPemakaian->norekammedis = $modPemakaian->norekammedis;
    $modPemakaian->noidentitas = $noidentitas;
    $modPemakaian->tempattujuan = $modPemakaian->tempattujuan;
    $modPemakaian->alamattujuan = $modPemakaian->alamattujuan;
    $modPemakaian->kelurahan_nama = $modPemakaian->kelurahan_nama;
    $modPemakaian->rt_rw = $modPemakaian->rt_rw;
    $modPemakaian->rt = substr($modPemakaian->rt_rw, 0, 2);
    $modPemakaian->rw = substr($modPemakaian->rt_rw, 2, 2);
    $modPemakaian->tglpemakaianambulans = (isset($modPemakaian->tglpemakaianambulans) ? $modPemakaian->tglpemakaianambulans : $format->formatDateTimeForUser($modPemakaian->tglpemakaianambulans));
    $modPemakaian->pendaftaran_id = $modPemakaian->pendaftaran_id;
    $modPemakaian->ruangan_id = $modPemakaian->ruangan_id;
    $modPemakaian->supir_nama = isset($modPemakaian->supir) ? $modPemakaian->supir->nama_pegawai : "";
    $modPemakaian->paramedis1_nama = isset($modPemakaian->paramedis1) ? $modPemakaian->paramedis1->nama_pegawai : "";
    $modPemakaian->paramedis2_nama = isset($modPemakaian->paramedis2) ? $modPemakaian->paramedis2->nama_pegawai : "";
    $modPemakaian->pelaksana_nama = isset($modPemakaian->pelaksana) ? $modPemakaian->pelaksana->nama_pegawai : "";
    $modPemakaian->mobilambulans_nama = isset($modPemakaian->mobil) ? $modPemakaian->mobil->jeniskendaraan : "";

    return $modPemakaian;
  }

  /**
   * simpan ObatalkespasienT
   * @param type $modPasienMasukPenunjang
   * @param type $post
   * @return \ObatalkespasienT
   * copy dari : PemakaianBmhpController
   */
  public function simpanObatAlkesPasien($modPendaftaran, $post)
  {
    $modObatAlkesPasien = new BKObatalkesPasienT;
    $modObatAlkesPasien->attributes = $post;
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modObatAlkesPasien->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
    $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
    $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
    $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
    $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
    $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');

    if ($modObatAlkesPasien->validate()) {
      $modObatAlkesPasien->save();
      StokobatalkesT::kurangiStok($modObatAlkesPasien->qty_oa, $modObatAlkesPasien->obatalkes_id);
    } else {
      $this->obatalkespasientersimpan &= false;
    }
    return $modObatAlkesPasien;
  }

  protected function simpanTindakanPelayanan($modPasien, $modPendaftaran, $modPemakaian)
  {
    $modTindakan = new BKTindakanPelayananT;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modTindakan->pasien_id = $modPasien->pasien_id;
    $modTindakan->daftartindakan_id = $modPemakaian->daftartindakanId;
    $modTindakan->carabayar_id = $modPendaftaran->carabayar_id;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modTindakan->ruangan_id =  Params::RUANGAN_ID_AMBULANCE;
    $modTindakan->instalasi_id =  $modTindakan->ruangan->instalasi_id;
    $modTindakan->penjamin_id = $modPendaftaran->penjamin_id;
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');

    $modTindakan->tarif_tindakan = $modPemakaian->totaltarifambulans;
    $modTindakan->satuantindakan = 'Km';
    $modTindakan->qty_tindakan = $modPemakaian->jumlahkm;
    $modTindakan->tarif_satuan = $modPemakaian->tarifperkm;

    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;

    if ($modTindakan->save()) {
      $this->tindakanpelayanantersimpan &= $modTindakan->saveTindakanKomponen();
    } else {
      $this->tindakanpelayanantersimpan = false;
      Yii::app()->user->setFlash('info', '<pre>' . print_r($modTindakan->getErrors(), 1) . '</pre>');
    }
  }

  public function actionDynamicRuangan()
  {
    $instalasi_id = (isset($_POST['instalasi']) ? $_POST['instalasi'] : null);
    $data = RuanganM::model()->findAll(
      'instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama',
      array(':instalasi_id' => $instalasi_id)
    );

    $data = CHtml::listData($data, 'ruangan_id', 'ruangan_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
  }
  /**
   * set LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetRiwayatObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $loadOaPasiens = BKObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id'], 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
      if (count((array)$loadOaPasiens) > 0) {
        foreach ($loadOaPasiens as $i => $modObatAlkesPasien) {
          $modObatAlkesPasien->tglpelayanan = $format->formatDateTimeForUser($modObatAlkesPasien->tglpelayanan);
          $modObatAlkesPasien->hargajual_oa = $format->formatNumberForUser($modObatAlkesPasien->hargajual_oa);
          $modObatAlkesPasien->qty_oa = $format->formatNumberForUser($modObatAlkesPasien->qty_oa);
          $modObatAlkesPasien->iurbiaya = $format->formatNumberForUser($modObatAlkesPasien->iurbiaya);
          $rows .= $this->renderPartial($this->path_view . "_rowRiwayatObatAlkesPasien", array('modObatAlkesPasien' => $modObatAlkesPasien), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * set BKTindakanpelayananT yang sudah ada di database
   * @params pendaftaran_id
   */
  public function actionSetTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modTindakans = BKTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id'], 'ruangan_id' => Yii::app()->user->getState('ruangan_id')), 'karcis_id IS NULL', 'tindakansudahbayar_id IS NULL');
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {
          $modTindakan->kepropinsi_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->kepropinsi_nama;
          $modTindakan->kekabupaten_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->kekabupaten_nama;
          $modTindakan->kekecamatan_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->kekecamatan_nama;
          $modTindakan->kekelurahan_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->kekelurahan_nama;
          $modTindakan->jmlkilometer = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->jmlkilometer;
          $modTindakan->tarifperkm = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->tarifperkm;
          $modTindakan->tarif_pelayanan = $modTindakan->jmlkilometer * $modTindakan->tarifperkm;
          $rows .= $this->renderPartial($this->path_view . "_rowTindakanPelayanan", array('i' => 0, 'modTindakan' => $modTindakan), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }
  /**
   * @param type $pemakaianambulans_id
   */
  public function actionPrintStatusAmbulans($pemakaianambulans_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPemakaian = BKPemakaianambulansT::model()->findByPk($pemakaianambulans_id);
    $modPendaftaran = BKPendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
    $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
    $criteria1 = new CdbCriteria();
    $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria1->order = "pendaftaran_id DESC, pemakaianambulans_id DESC";
    $loadPemakaianAmbulans = BKPemakaianambulansT::model()->find($criteria1);
    if (isset($loadPemakaianAmbulans)) {
      $modPemakaian = $loadPemakaianAmbulans;
      $modTindakans = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
      $criteria_tot = new CdbCriteria();
      $criteria_tot->addCondition("karcis_id IS NULL");
      $criteria_tot->addCondition("tindakansudahbayar_id IS NULL");
      $criteria_tot->addCondition("pendaftaran_id = " . $modPendaftaran->pendaftaran_id);
      $criteria_tot->addCondition("create_ruangan = " . Yii::app()->user->getState('ruangan_id'));
      $daftartindakan = TindakanpelayananT::model()->findAll($criteria_tot);
    }

    $judul_print = 'Pemakaian Ambulance Pasien';
    $this->render($this->path_view . 'printStatusAmbulan', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPemakaian' => $modPemakaian,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'daftartindakan' => $daftartindakan,
    ));
  }

  /*
         * untuk print pemakaian bahp
         */
  public function actionPrintPemakaianBmhp($pemakaian_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPemakaian = BKPemakaianambulansT::model()->findByPk($pemakaian_id);
    $modPendaftaran = BKPendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
    $modObatAlkesPasien = BKObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
    $ruangan_id  = BKObatalkesPasienT::model()->find('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id . ' AND ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . '');
    if (!isset($ruangan_id)) {
      $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
    } else {
      $ruangan = RuanganM::model()->findByPk($ruangan_id);
    }
    $judul_print = 'Pemakaian BAHP ' . $ruangan->ruangan_nama;
    $this->render($this->path_view . 'printPemakaianBmhp', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPemakaian' => $modPemakaian,
      'modPendaftaran' => $modPendaftaran,
      'modObatAlkesPasien' => $modObatAlkesPasien,
    ));
  }
}

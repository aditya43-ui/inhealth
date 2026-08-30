<?php
class TindakanRawatJalanController extends MyAuthController
{
  public $layout = "//layouts/iframe";
  public $path_view = "billingKasir.views.tindakanRawatJalan.";

  public $tindakanpelayanantersimpan = true; //dilooping
  public $komponentindakantersimpan = true; //dilooping
  public $veriftagihantersimpan = true; //dilooping

  public function actionIndex($instalasi_id = null, $pendaftaran_id = null)
  {
    $format = new MyFormatter();
    $modPasienAdmisi = new BKPasienadmisiT;
    $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
    if ($instalasi_id == Params::INSTALASI_ID_RI) {
      $loadPasienAdmisi = BKPasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      if ($loadPasienAdmisi) {
        $modPasienAdmisi = $loadPasienAdmisi;
      } else {
        echo "Pasien belum pernah dirawat inap!";
        exit;
      }
    }
    $dataTindakans = array();
    $verifTindakans = array();
    $modTindakan = new BKTindakanPelayananT;
    $modTindakan->instalasi_id = (!empty($modPasienAdmisi->ruangan_id) ? $modPasienAdmisi->ruangan->instalasi_id : $modPendaftaran->ruangan->instalasi_id);
    $modTindakan->instalasi_id = (!empty($instalasi_id) ? $instalasi_id : $modTindakan->instalasi_id); //ditimpa
    if (isset($_GET['instalasi_id']) && !empty($_GET['instalasi_id'])) {
      $modRiwayatTindakans = $this->loadTindakanPelayanans($_GET['instalasi_id'], $pendaftaran_id, $modPasienAdmisi->pasienadmisi_id);
    } else {
      $modRiwayatTindakans = $this->loadTindakanPelayananLain($pendaftaran_id);
      $modTindakan->instalasi_id = null;
    }
    
        $modVerifikasi = new VerifikasitagihanT;

    if (isset($_POST['BKTindakanPelayananT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        if (count((array)$_POST['BKTindakanPelayananT']) > 0) {
          foreach ($_POST['BKTindakanPelayananT'] as $i => $tindakan) {
            if (!empty($tindakan['daftartindakan_id'])) {
              $dataTindakans[$i] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienAdmisi, $tindakan);
            }
          }
        }

        if (count((array)$_POST['riwayatTindakan']) > 0) {

          $is_verif = $_POST['is_verif'];
          foreach ($_POST['riwayatTindakan'] as $i => $riwayat) {

            $tindakan = TindakanpelayananT::model()->findByPk($riwayat['tindakanpelayanan_id']);

            $tindakanpel = $tindakan;

            // if($is_verif[$i] == 'yes') {
              
            //   if(empty($tindakan->verifikasitagihan_id)) {
            //     $verifTindakans[$i] = $this->simpanVerifikasi($modPendaftaran, $modPasienAdmisi, $riwayat, $tindakan);
            //   }
            // } else {
            //     VerifikasitagihanT::model()->deleteByPk($tindakan->verifikasitagihan_id);
            //   }
            }
          }        

        if ($this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->veriftagihantersimpan) {
          if ($instalasi_id == Params::INSTALASI_ID_RI) {
            $updatePasienAdmisi = BKPasienadmisiT::model()->updateByPk($modPendaftaran->pasienadmisi_id, array('pembayaranpelayanan_id' => null));
          } else {
            $updatePendaftaran = BKPendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('pembayaranpelayanan_id' => null));
          }
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data " . $modPendaftaran->pasien->nama_pasien . " berhasil disimpan!");
          $this->redirect($this->createUrl('index', array('instalasi_id' => (isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : ""), 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1)));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tindakan gagal disimpan!");
          echo "-" . $this->tindakanpelayanantersimpan . "<br>";
          echo "-" . $this->komponentindakantersimpan . "<br>";
          exit();
        }
      } catch (Exception $exc) {
        // echo '<pre>'; var_dump($exc); die;

        Yii::app()->user->setFlash('error', "Data tindakan gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }


    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modTindakan' => $modTindakan,
      'modPendaftaran' => $modPendaftaran,
      'modPasienAdmisi' => $modPasienAdmisi,
      'dataTindakans' => $dataTindakans,
      'modRiwayatTindakans' => $modRiwayatTindakans,
    ));
  }


    /**
   * proses simpan ROTindakanpelayananT dan ROTindakankomponenT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienAdmisi, $post)
  {
    $modTindakan = new BKTindakanPelayananT;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->pasien_id = $modPendaftaran->pasien_id;
    $modTindakan->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
    $modTindakan->jeniskasuspenyakit_id = (!empty($modPasienAdmisi->jeniskasuspenyakit_id) ? $modPasienAdmisi->jeniskasuspenyakit_id : $modPendaftaran->jeniskasuspenyakit_id);
    $modTindakan->kelaspelayanan_id = (!empty($modPasienAdmisi->kelaspelayanan_id) ? $modPasienAdmisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id);
    $modTindakan->carabayar_id = (!empty($modPasienAdmisi->carabayar_id) ? $modPasienAdmisi->carabayar_id : $modPendaftaran->carabayar_id);
    $modTindakan->penjamin_id = (!empty($modPasienAdmisi->penjamin_id) ? $modPasienAdmisi->penjamin_id : $modPendaftaran->penjamin_id);
    $modTindakan->ruangan_id = (!empty($modPasienAdmisi->ruangan_id) ? $modPasienAdmisi->ruangan_id : $modPendaftaran->ruangan_id);
    $modTindakan->attributes = $post;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($modTindakan->tgl_tindakan);
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;

    $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

    if(!empty($md_noawal)) {
      $noawal = intval($md_noawal->nopelayanan) + 1;
    } else {
      $noawal = 1;
    }

    $modTindakan->nopelayanan = str_pad($noawal,3,"0",STR_PAD_LEFT);
    
    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }
    
    return $modTindakan;
  }

    /**
   * proses simpan VerifikasitagihanT
   */
  public function simpanVerifikasi($modPendaftaran, $modPasienAdmisi, $tindakan)
  {
      $modVerifikasi = new VerifikasitagihanT();
      $modVerifikasi->tglverifikasi = date('Y-m-d H:i:s');
      $modVerifikasi->noverifikasi = MyGenerator::noVerifikasi();
      $modVerifikasi->verifikasioleh_id = Yii::app()->user->getState('pegawai_id');
      $modVerifikasi->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modVerifikasi->keteranganverifikasi = '-';

      $modVerifikasi->create_time = date('Y-m-d H:i:s');
      $modVerifikasi->create_loginpemakai_id = Yii::app()->user->id;
      
      if ($modVerifikasi->validate()) {
        if ($modVerifikasi->save()) {
          $this->veriftagihantersimpan &= true;
          TindakanpelayananT::model()->updateByPk($tindakan->tindakanpelayanan_id, array('verifikasitagihan_id' => $modVerifikasi->verifikasitagihan_id));
        }
      } else {
        echo '<pre>'; var_dump($modVerifikasi->getErrors()); die;
        $this->veriftagihantersimpan &= false;
      }
    
    return $modVerifikasi;
  }


    /**
   * proses simpan VerifikasitagihanT
   */
  public function simpanVerifikasiRencana($modPendaftaran, $modPasienAdmisi, $tindakan)
  {
      $modVerifikasi = new VerifrenctindakanT();

      $modVerifikasi->tglverifikasirenc = date('Y-m-d H:i:s');
      $modVerifikasi->noverifikasi_renc = MyGenerator::noVerifikasiTindakan();
      $modVerifikasi->petugas_verif_id = Yii::app()->user->getState('pegawai_id');
      $modVerifikasi->mengetahui_id = Yii::app()->user->getState('pegawai_id');

      $modVerifikasi->create_time = date('Y-m-d H:i:s');
      $modVerifikasi->create_loginpemakai_id = Yii::app()->user->id;
      $modVerifikasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
      
      if ($modVerifikasi->validate()) {
        if ($modVerifikasi->save()) {
          $this->veriftagihantersimpan &= true;
          TindakanpelayananT::model()->updateByPk($tindakan->tindakanpelayanan_id, array('verifrenctindakan_id' => $modVerifikasi->verifrenctindakan_id));
        }
      } else {
        echo '<pre>'; var_dump($modVerifikasi->getErrors()); die;
        $this->veriftagihantersimpan &= false;
      }
    
    return $modVerifikasi;
  }

  /**
   * load tindakanpelayananT yg tersimpan
   * @param type $pendaftaran_id
   * @param type $pasienadmisi_id\
   */
  protected function loadTindakanPelayanans($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
  {
    $criteria = new CDbCriteria();
    if (!empty($instalasi_id)) {
      $criteria->addCondition('instalasi_id = ' . $instalasi_id);
    }
    $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    if (!empty($pasienadmisi_id)) {
      $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
    }
    $criteria->addCondition('tindakansudahbayar_id IS NULL');
    $criteria->addCondition('pasienmasukpenunjang_id IS NULL');
    $criteria->addCondition('verifrenctindakan_id IS NULL');

    $criteria->order = 'tgl_tindakan';
    $modTindakans = BKTindakanPelayananT::model()->findAll($criteria);
    // var_dump(count($modTindakans)); die;
    return $modTindakans;
  }
  /**
   * load tindakanpelayananT yg tersimpan
   * @param type $pendaftaran_id
   * @param type $pasienadmisi_id\
   */
  protected function loadTindakanPelayananLain($pendaftaran_id)
  {
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    $criteria->addCondition('tindakansudahbayar_id IS NULL');
    $criteria->addCondition('verifrenctindakan_id IS NULL');
    //            $criteria->addCondition('pasienmasukpenunjang_id IS NULL');
    $criteria->order = 'tgl_tindakan';
    $modTindakans = BKTindakanPelayananT::model()->findAll($criteria);
    return $modTindakans;
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

    /**
   * menghapus tindakanpelayanan (ajax)
   */
  public function actionVerifikasiTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $admisi = new PasienadmisiT;
        $tindakan = TindakanpelayananT::model()->findByPk($_POST['tindakanpelayanan_id']);
        $pendaftaran = PendaftaranT::model()->model()->findByPk($tindakan->pendaftaran_id);
        if(!empty($pendaftaran->pasienadmisi_id)) {
          $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
        }

        $verifTindakan = $this->simpanVerifikasiRencana($pendaftaran, $admisi, $tindakan);
        
        if ($verifTindakan->save()) {
          $tindakan->verifrenctindakan_id = $verifTindakan->verifrenctindakan_id;
          $tindakan->save();

          $transaction->commit();
          $data['pesan'] = "Data Telah Terverifikasi!";
          $data['sukses'] = 1;
        } else {
          $transaction->rollback();
          $data['pesan'] = "Data Gagal Diverifikasi!";
          $data['sukses'] = 0;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Data Gagal Diverifikasi! :" . MyExceptionMessage::getMessage($exc, true);
        echo '<pre>'; var_dump($exc); die;
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteDaftarTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $tipepaket_id = isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null;
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
      $kelaspelayanan_id = isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : null;
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $daftartindakan_nama = isset($_GET['daftartindakan_nama']) ? $_GET['daftartindakan_nama'] : null;

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(daftartindakan_nama)', strtolower($daftartindakan_nama), true);
      $criteria->order = 'daftartindakan_nama';
      $criteria->limit = 5;
      if ($tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
        $criteria->addCondition('penjamin_id = ' . $penjamin_id);
        //if (Yii::app()->user->getState('tindakankelas')) {
          $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
        //}
        //if (Yii::app()->user->getState('tindakanruangan')) {
          if (!empty($ruangan_id)) {
            $criteria->addCondition("ruangan_id = " . $ruangan_id);
          }
          $models = TariftindakanperdaruanganV::model()->findAll($criteria);
        //} else {
        //  $models = TariftindakanperdaV::model()->findAll($criteria);
        //}
      } else {
        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        }
        if (Yii::app()->user->getState('tindakankelas')) {
          $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
        }
        if (!empty($tipepaket_id)) {
          $criteria->addCondition("tipepaket_id = " . $tipepaket_id);
        }
        $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
        $models = PaketpelayananV::model()->findAll($criteria);
      }
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->daftartindakan_nama . " - " . $format->formatUang($model->harga_tariftindakan);
        $returnVal[$i]['value'] = $model->daftartindakan_nama;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * untuk menampilkan data dokter
   */
  public function actionAutocompleteDokterPemeriksa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      if (!empty($ruangan_id)) {
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
      }
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = BKDokterV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->NamaLengkap;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * untuk menampilkan data perawat
   */
  public function actionAutocompletePerawat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      if (!empty($ruangan_id)) {
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
      }
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $criteria->compare('kelompokpegawai_id', Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN);
      $models = PegawairuanganV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->NamaLengkap;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * untuk menampilkan data bidan
   */
  public function actionAutocompleteBidan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);

      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $criteria->compare('kelompokpegawai_id', Params::KELOMPOKPEGAWAI_ID_BIDAN);
      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->NamaLengkap;
      }
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
        $models = BKInformasikasirrawatjalanV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $models = BKInformasikasirrdpulangV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $models = BKInformasikasirinappulangV::model()->findAll($criteria);
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
}

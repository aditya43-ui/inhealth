<?php

class TindakanBedahSentralController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "rawatJalan.views.tindakanBedahSentral.";

  public $tindakanpelayanantersimpan = true;
  public $succesSave = false;
  protected $successSaveBmhp = true; // loop
  protected $successSavePemakaianBahan = true; // loop
  protected $stokobatalkestersimpan = true; // loop

  /**
   * Tambah / Ubah Pemeriksaan Bedah.
   */
  public function actionIndex($pasienmasukpenunjang_id = null, $pendaftaran_id = null, $instalasi_id = null)
  {
    $format = new MyFormatter();
    $modKunjungan = new RJInfokunjunganrjV;
    $modPemeriksaanBedah = new RJTarifoperasiruanganV;
    $modPendaftaran = new RJPendaftaranT();
    $modPendaftaran->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modTindakan = new RJTindakanPelayananT();
    $modTindakanDetail = new TindakanpelayananT();
    $dataTindakans = array();
    $modTindakans = array();
    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

    if (!empty($_POST['RJTindakanPelayananT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        foreach ($_POST['TindakanpelayananT'] as $key => $value) {
          $modTindakanPelayanan = $this->simpanTindakanPelayanan($_POST['RJTindakanPelayananT'], $value);
        }
        if ($this->tindakanpelayanantersimpan) {
          $modPendaftaran = RJPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
          $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
          $modTindakans = $this->saveTindakan($modPasien, $modPendaftaran, $modTindakanPelayanan);
        }
        if ($this->tindakanpelayanantersimpan && $this->successSaveBmhp && $this->successSavePemakaianBahan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $_POST['pendaftaran_id'], 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $modViewBmhp = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);
    $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);

    $this->render($this->path_view . 'index', array(
      'modKunjungan' => $modKunjungan,
      'modPemeriksaanBedah' => $modPemeriksaanBedah,
      'modPendaftaran' => $modPendaftaran,
      'modTindakan' => $modTindakan,
      'modViewBmhp' => $modViewBmhp,
      'modTindakanDetail' => $modTindakanDetail,
      'dataTindakans' => $dataTindakans,
    ));
  }

  /**
   * proses simpan TindakanPelayananT dan TindakanKomponenT
   * khusus untuk permintaan penunjang
   */
  public function simpanTindakanPelayanan($postTindakan, $postTindakanDetail)
  {
    $modTindakan = new RJTindakanPelayananT;

    $modTindakan->attributes = $_POST;
    $modTindakan->ruangan_id = $_POST['ruangan_id'];
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->pendaftaran_id = $_POST['pendaftaran_id'];
    $modTindakan->daftartindakan_id = $postTindakanDetail['daftartindakan_id'];
    $modTindakan->tarif_satuan = $postTindakanDetail['tarif_satuan'];
    $modTindakan->qty_tindakan = $postTindakanDetail['qty_tindakan'];
    $modTindakan->satuantindakan = $postTindakanDetail['satuantindakan'];
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $postTindakan['dokterpemeriksa1_id'];
    $modTindakan->dokterpemeriksa2_id = $postTindakan['dokterpemeriksa2_id'];
    $modTindakan->dokteranastesi_id = $postTindakan['dokteranastesi_id'];
    $modTindakan->dokterpendamping_id = $postTindakan['dokterpendamping_id'];
    $modTindakan->suster_id = $postTindakan['suster_id'];
    $modTindakan->bidan_id = $postTindakan['bidan_id'];
    $modTindakan->keterangantindakan = $postTindakan['keterangantindakan'];
    $modTindakan->tgl_tindakan = $postTindakan['tgl_tindakan'];
    $modTindakan->instalasi_id = $_POST['instalasi_id'];
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    $modTindakan->kelaspelayanan_id = $_POST['RJPendaftaranT']['kelaspelayanan_id'];
    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;
    $modTindakan->alatmedis_id = $this->cekAlatmedis($modTindakan->daftartindakan_id);
    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->tindakanpelayanantersimpan &= true;
        //			   $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen(); LNG-188
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }

  public function saveTindakan($modPasien, $modPendaftaran, $modTindakans)
  {
    $post  = (isset($_POST['TindakanpelayananT'])) ? $_POST['TindakanpelayananT'] : $_POST['RJTindakanPelayananT'];
    $valid = true;
    if ($valid && (count((array)$modTindakans) > 0)) {
      foreach ($modTindakans as $i => $tindakan) {
        if (isset($_POST['paketBmhp'])) {
          if (count((array)$_POST['paketBmhp']) > 0) {
            //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jumlah pesan
            $detailGroups = array();
            foreach ($_POST['paketBmhp'] as $i => $postDetail) {
              $modDetails[$i] = new RJObatalkesPasienT();
              $modDetails[$i]->attributes = $postDetail;
              $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
              $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
              $obatalkes_id = $postDetail['obatalkes_id'];
              if (isset($detailGroups[$obatalkes_id])) {
                $detailGroups[$obatalkes_id]['qtypemakaian'] += $postDetail['qtypemakaian'];
              } else {
                $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                $detailGroups[$obatalkes_id]['qtypemakaian'] = $postDetail['qtypemakaian'];
              }
            }
            //END GROUP
          }

          $obathabis = "";
          //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
          foreach ($detailGroups as $i => $detail) {
            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qtypemakaian'], Yii::app()->user->getState('ruangan_id'));
            if (count((array)$modStokOAs) > 0) {
              foreach ($modStokOAs as $i => $stok) {
                $modDetails[$i] = $this->savePaketBmhp($modPendaftaran, $stok, $_POST['paketBmhp'], $tindakan, $modTindakans);
                $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
              }
            } else {
              $this->stokobatalkestersimpan &= false;
              $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
            }
          }
        }
        if (isset($_POST['pemakaianBahan'])) {
          if (count((array)$_POST['pemakaianBahan']) > 0) {
            //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jumlah pesan
            $detailGroups = array();
            foreach ($_POST['pemakaianBahan'] as $i => $postDetail) {
              $modDetails[$i] = new RJObatalkesPasienT();
              $modDetails[$i]->attributes = $postDetail;
              $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
              $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
              $obatalkes_id = $postDetail['obatalkes_id'];
              if (isset($detailGroups[$obatalkes_id])) {
                $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
              } else {
                $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
              }
            }
            //END GROUP
          }

          $obathabis = "";
          //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
          foreach ($detailGroups as $i => $detail) {
            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
            if (count((array)$modStokOAs) > 0) {
              foreach ($modStokOAs as $i => $stok) {
                $modDetails[$i] = $this->savePemakaianBahan($modPendaftaran, $stok, $_POST['pemakaianBahan'], $tindakan);
                $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
              }
            } else {
              $this->stokobatalkestersimpan &= false;
              $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
            }
          }
        }
      }
      $this->succesSave = true;
    }
    return $modTindakans;
  }

  protected function savePaketBmhp($modPendaftaran, $stokOa, $paketBmhp, $tindakan, $modTindakans)
  {
    $modObatAlkesPasien = new RJObatalkesPasienT();
    $modObatAlkesPasien->attributes = $stokOa->attributes;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET; //$tindakan->tipepaket_id;
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
    $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
    $modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $totalBmhp = 0;

    foreach ($paketBmhp as $i => $bmhp) {
      if ($stokOa->obatalkes_id == $bmhp['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $bmhp['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $bmhp['satuankecil_id'];
        $modObatAlkesPasien->qty_stok = $bmhp['qty_stok'];
        $modObatAlkesPasien->iurbiaya = $bmhp['subtotal'];
        $modObatAlkesPasien->qty_oa = $bmhp['qtypemakaian'];
        $modObatAlkesPasien->hargajual_oa = $bmhp['hargapemakaian'];
        $modObatAlkesPasien->harganetto_oa = $bmhp['harganetto'];
        $modObatAlkesPasien->hargasatuan_oa = $bmhp['hargasatuan']; //$bmhp['hargasatuan'];
        $modObatAlkesPasien->daftartindakan_id = $bmhp['daftartindakan_id'];
        $modObatAlkesPasien->tindakanpelayanan_id = $modTindakans->tindakanpelayanan_id;
        $totalBmhp = $totalBmhp + $bmhp['hargapemakaian'];
      }
    }

    if ($modObatAlkesPasien->save()) {
      $this->successSaveBmhp &= true;
      $totalBmhp = $totalBmhp + $modTindakans->tarif_bhp;
      $modTindakans->tarif_bhp = $totalBmhp;
      $modTindakans->update();
    } else {
      $this->successSaveBmhp &= false;
    }
    return $modObatAlkesPasien;
  }

  protected function savePemakaianBahan($modPendaftaran, $stokOa, $pemakaianBahan, $tindakan)
  {
    $modObatAlkesPasien = new RJObatalkesPasienT();
    $modObatAlkesPasien->attributes = $stokOa->attributes;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
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
    $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
    $modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;
    foreach ($pemakaianBahan as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatAlkesPasien->daftartindakan_id = $postDetail['daftartindakan_id'];
        $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
        $modObatAlkesPasien->iurbiaya = $postDetail['subtotal'];
      }
    }

    if ($modObatAlkesPasien->save()) {
      $this->successSavePemakaianBahan &= true;
    } else {
      $this->successSavePemakaianBahan &= false;
    }
    return $modObatAlkesPasien;
  }


  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modObatAlkesPasien
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesOut($stokobatalkesasal_id, $modObatAlkesPasien)
  {
    $format = new MyFormatter;
    $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
    $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    if ($modStokOaNew->validateStok()) {
      $modStokOaNew->save();
      $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  protected function cekAlatmedis($idDaftartindakan)
  {
    $idAlatmedis = null;
    if (!empty($_POST['pemakaianAlat'])) {
      foreach ($_POST['pemakaianAlat'] as $k => $item) {
        if ($item['daftartindakan_id'] == $idDaftartindakan) {
          $idAlatmedis = $item['alatmedis_id'];
        }
      }
    }

    return $idAlatmedis;
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $modPendaftaran =  BSPendaftaranMp::model()->findByPk($id);
    if ($modPendaftaran === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $modPendaftaran;
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
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $models = RJInfokunjunganrjrdriV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . '-' . $model->no_rekam_medik . '-' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $model = RJInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["namalengkapdokter"] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }




  /**
   * set checklist pemeriksaan bedah
   */
  public function actionSetChecklistPemeriksaanBedah()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $disabled = $_POST['sukses'];
      $postPemeriksaan = $post['RJTarifoperasiruanganV'];
      if (!empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
        $criteria = new CdbCriteria();
        $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
        $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        $criteria->compare('LOWER(kegiatanoperasi_nama)', strtolower($postPemeriksaan['kegiatanoperasi_nama']), true);
        $criteria->compare('LOWER(operasi_nama)', strtolower($postPemeriksaan['operasi_nama']), true);
        $criteria->order = "kegiatanoperasi_nama, operasi_nama";
        $modPemeriksaanBedahs = RJTarifoperasiruanganV::model()->findAll($criteria);
        $content = $this->renderPartial($this->path_view . '_checklistPemeriksaanBedah', array('modPemeriksaanBedahs' => $modPemeriksaanBedahs, 'disabled' => $disabled), true);
      } else {
        $criteria = new CdbCriteria();
        $criteria->addCondition('kelaspelayanan_id = ' . params::KELASPELAYANAN_ID_TANPA_KELAS); // jika pasien blm dipilih didefault kelas III
        $criteria->addCondition('penjamin_id = ' . params::PENJAMIN_ID_UMUM); // jika pasien blm dipilih didefault umum
        $criteria->compare('LOWER(kegiatanoperasi_nama)', strtolower($postPemeriksaan['kegiatanoperasi_nama']), true);
        $criteria->compare('LOWER(operasi_nama)', strtolower($postPemeriksaan['operasi_nama']), true);
        $criteria->order = "kegiatanoperasi_nama, operasi_nama";
        $modPemeriksaanBedahs = RJTarifoperasiruanganV::model()->findAll($criteria);
        $content = $this->renderPartial($this->path_view . '_checklistPemeriksaanBedah', array('modPemeriksaanBedahs' => $modPemeriksaanBedahs, 'disabled' => $disabled), true);
      }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }

  public function actionSetRencanaTindakanOperasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      //            $modTindakans = BSRencanaOperasiT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$_POST['pasienmasukpenunjang_id']));
      if (!empty($modTindakans) && count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {
          $criteria = null;
          $criteria = new CdbCriteria();
          $criteria->addCondition('kelaspelayanan_id = ' . $modTindakan->pasienmasukpenunjang->kelaspelayanan_id);
          $criteria->addCondition('penjamin_id = ' . $modTindakan->pendaftaran->penjamin_id);
          $criteria->addCondition('operasi_id = ' . $modTindakan->operasi_id);
          $modPemeriksaanBedahs = RJTarifoperasiruanganV::model()->find($criteria);
          $modTindakan->operasi_id = $modTindakan->operasi_id;
          $modTindakan->daftartindakan_id = $modTindakan->operasi->daftartindakan_id;
          $modTindakan->operasi_nama = $modTindakan->operasi->operasi_nama;
          $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
          $modTindakan->tarif_satuan = $format->formatNumberForUser(isset($modPemeriksaanBedahs) ? $modPemeriksaanBedahs->hargaoperasi : 0);
          $modTindakan->tarif_tindakan = $format->formatNumberForUser(isset($modPemeriksaanBedahs) ? $modPemeriksaanBedahs->hargaoperasi : 0);
          $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;;
          $modTindakan->qty_tindakan = 1;

          $rows .= $this->renderPartial($this->path_view . "_rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * menampilkan obat
   * @return row table 
   */
  public function actionSetFormObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new RJObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      if (count((array)$modStokOAs) > 0) {

        foreach ($modStokOAs as $i => $stok) {
          $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
          $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
          $modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
          $modObatAlkesPasien->harganetto_oa = $stok->HPP;
          $modObatAlkesPasien->hargasatuan_oa = $stok->HargaJualSatuan;
          $modObatAlkesPasien->qty_stok = $stok->qtystok;
          $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
          $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
          $modObatAlkesPasien->biayaservice = 0;
          $modObatAlkesPasien->biayakonseling = 0;
          $modObatAlkesPasien->jasadokterresep = 0;
          $modObatAlkesPasien->biayakemasan = 0;
          $modObatAlkesPasien->biayaadministrasi = 0;
          $modObatAlkesPasien->tarifcyto = 0;
          $modObatAlkesPasien->discount = 0;
          $modObatAlkesPasien->subsidiasuransi = 0;
          $modObatAlkesPasien->subsidipemerintah = 0;
          $modObatAlkesPasien->subsidirs = 0;
          $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
          $modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
          $modObatAlkesPasien->satuankecil_nama = $stok->satuankecil->satuankecil_nama;

          $form .= $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien), true);
        }
      } else {
        $pesan = "Stok tidak mencukupi!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * untuk mencari paket bmhp di autocomplete
   */
  public function actionPaketBMHP()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('obatalkes', 'daftartindakan', 'kelompokumur');
      $criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'obatalkes.obatalkes_nama';
      $criteria->limit = 5;
      $models = PaketbmhpM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->obatalkes->obatalkes_nama . ' - ' . $model->daftartindakan->daftartindakan_nama . ' (' . $model->kelompokumur->kelompokumur_nama . ')';
        $returnVal[$i]['value'] = $model->obatalkes->obatalkes_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionSetFormPemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $obatalkes_id = (isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : "");
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
      $ruangan_id = Yii::app()->user->getState('ruangna_id');
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new RJObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $persenjual = $this->persenJualRuangan();
      if (count((array)$modStokOAs) > 0) {

        foreach ($modStokOAs as $i => $stok) {
          $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
          $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
          $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
          $modObatAlkesPasien->obatalkes_nama = $stok->obatalkes->obatalkes_nama;
          $modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
          $modObatAlkesPasien->harganetto_oa = $stok->HPP;
          $modObatAlkesPasien->hargasatuan_oa = $stok->HargaJualSatuan;
          $modObatAlkesPasien->qty_stok = $stok->qtystok;
          $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
          $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
          $modObatAlkesPasien->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkesPasien->hargajual);
          $modObatAlkesPasien->biayaservice = 0;
          $modObatAlkesPasien->biayakonseling = 0;
          $modObatAlkesPasien->jasadokterresep = 0;
          $modObatAlkesPasien->biayakemasan = 0;
          $modObatAlkesPasien->biayaadministrasi = 0;
          $modObatAlkesPasien->tarifcyto = 0;
          $modObatAlkesPasien->discount = 0;
          $modObatAlkesPasien->subsidiasuransi = 0;
          $modObatAlkesPasien->subsidipemerintah = 0;
          $modObatAlkesPasien->subsidirs = 0;
          $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
          $modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
          $modObatAlkesPasien->satuankecil_nama = $stok->satuankecil->satuankecil_nama;

          $form .= $this->renderPartial($this->path_view . '_formAddPemakaianBahan', array(
            'modObatAlkesPasien' => $modObatAlkesPasien, 'modDaftartindakan' => $modDaftartindakan,
            'modPendaftaran' => $modPendaftaran,
          ), true);
        }
      } else {
        $pesan = "Stok tidak mencukupi!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  protected function persenJualRuangan()
  {
    switch (Yii::app()->user->getState('instalasi_id')) {
      case Params::INSTALASI_ID_RI:
        $persen = Yii::app()->user->getState('ri_persjual');
        break;
      case Params::INSTALASI_ID_RJ:
        $persen = Yii::app()->user->getState('rj_persjual');
        break;
      case Params::INSTALASI_ID_RD:
        $persen = Yii::app()->user->getState('rd_persjual');
        break;
      default:
        $persen = 0;
        break;
    }

    return $persen;
  }

  public function actionAddFormPaketBmhp()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $kelumur_id = (isset($_POST['kelumur_id']) ? $_POST['kelumur_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);
      $modPaketBmhp = PaketbmhpM::model()->with('daftartindakan', 'obatalkes')->findAllByAttributes(array(
        'daftartindakan_id' => $daftartindakan_id,
        'kelompokumur_id' => $kelumur_id,
      ));
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new RJObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $persenjual = $this->persenJualRuangan();
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

      foreach ($modPaketBmhp as $j => $paket) {
        $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($paket->obatalkes_id, $paket->qtypemakaian, $ruangan_id);
        if (count((array)$modStokOAs) > 0) {
          foreach ($modStokOAs as $i => $stok) {
            $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
            $modObatAlkesPasien->daftartindakan_id = $paket->daftartindakan_id;
            $modObatAlkesPasien->daftartindakan_nama = $paket->daftartindakan->daftartindakan_nama;
            $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
            $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
            $modObatAlkesPasien->obatalkes_nama = $stok->obatalkes->obatalkes_nama;
            $modObatAlkesPasien->qtypemakaian = $stok->qtystok_terpakai;
            $modObatAlkesPasien->hargapemakaian = $paket->hargapemakaian;
            $modObatAlkesPasien->harganetto_oa = $stok->HPP;
            $modObatAlkesPasien->hargasatuan_oa = $stok->HargaJualSatuan;
            $modObatAlkesPasien->qty_stok = $stok->qtystok;
            $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
            $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
            $modObatAlkesPasien->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkesPasien->hargajual);
            $modObatAlkesPasien->biayaservice = 0;
            $modObatAlkesPasien->biayakonseling = 0;
            $modObatAlkesPasien->jasadokterresep = 0;
            $modObatAlkesPasien->biayakemasan = 0;
            $modObatAlkesPasien->biayaadministrasi = 0;
            $modObatAlkesPasien->tarifcyto = 0;
            $modObatAlkesPasien->discount = 0;
            $modObatAlkesPasien->subsidiasuransi = 0;
            $modObatAlkesPasien->subsidipemerintah = 0;
            $modObatAlkesPasien->subsidirs = 0;
            $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
            $modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
            $modObatAlkesPasien->satuankecil_nama = $stok->satuankecil->satuankecil_nama;

            $form .= $this->renderPartial($this->path_view . '_formAddPaketBmhp', array(
              'paketBmhp' => $modObatAlkesPasien, 'modDaftartindakan' => $modDaftartindakan,
              'modPendaftaran' => $modPendaftaran
            ), true);
          }
        } else {
          $pesan = "Obat : " . $paket->obatalkes->obatalkes_nama . " Stok tidak mencukupi!";
        }
      }
      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }
}

<?php
Yii::import('bankDarah.controllers.PendaftaranBankDarahController');
class PendaftaranBankDarahRujukanRSController extends PendaftaranBankDarahController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "bankDarah.views.pendaftaranBankDarahRujukanRS.";
  public $path_view_pendaftaran = "bankDarah.views.pendaftaranBankDarah.";
  public $obatalkespasientersimpan = true; //di looping
  public $stokobatalkestersimpan = true; //looping
  /**
   * Tambah / Ubah Pemeriksaan Laboratorium.
   */
  public function actionIndex($pasienmasukpenunjang_id = null, $pendaftaran_id = null, $instalasi_id = null)
  {
    $format = new MyFormatter();
    $modKunjungan = new BDPasienKirimKeUnitLainV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPemeriksaanLab = new BDTarifpemeriksaanlabruanganV;
    $modPasienMasukPenunjang = new BDPasienmasukpenunjangT;
    $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modTindakan = new BDTindakanPelayananT;
    $modObatAlkesPasien = new BDObatalkespasienT;
    $dataTindakans = array();

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

    if (isset($_GET['pasienkirimkeunitlain_id'])) {
      $modKunjungan = BDPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_GET['pasienkirimkeunitlain_id']));
      $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $modKunjungan->pasienkirimkeunitlain_id;
      $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modKunjungan->jeniskasuspenyakit_id;
      $modPasienMasukPenunjang->kelaspelayanan_id = $modKunjungan->kelaspelayanan_id;
    }
    if (isset($_GET['pendaftaran_id'])) {
      $modKunjungan = BDInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'instalasi_id' => $_GET['instalasi_id']));
      $modKunjungan->instalasiasal_id = $modKunjungan->instalasi_id;
      $modKunjungan->instalasiasal_nama = $modKunjungan->instalasi_nama;
      $modKunjungan->ruanganasal_id = $modKunjungan->ruangan_id;
      $modKunjungan->ruanganasal_nama = $modKunjungan->ruangan_nama;
      $modKunjungan->nama_bin = $modKunjungan->alias;
      $modPasienMasukPenunjang->pasienkirimkeunitlain_id = isset($modKunjungan->pasienkirimkeunitlain_id) ? $modKunjungan->pasienkirimkeunitlain_id : null;
      $modPasienMasukPenunjang->jeniskasuspenyakit_id = isset($modKunjungan->jeniskasuspenyakit_id) ? $modKunjungan->jeniskasuspenyakit_id : null;
      $modPasienMasukPenunjang->kelaspelayanan_id = isset($modKunjungan->kelaspelayanan_id) ? $modKunjungan->kelaspelayanan_id : null;
    }
    if (!empty($pasienmasukpenunjang_id)) {
      $modPasienMasukPenunjang = BDPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $loadModKunjungan = BDPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;
      }
    }

    if (isset($_POST['BDPasienmasukpenunjangT'])) {
      if (!empty($_POST['BDPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])) {
        $modKunjungan = BDPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['BDPasienmasukpenunjangT']['pasienkirimkeunitlain_id']));
      } else {
        $modKunjungan = BDInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'instalasi_id' => $_GET['instalasi_id']));
      }
      $modPendaftaran = BDPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $_POST['BDPasienmasukpenunjangT']);
        if (!empty($_POST['BDPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])) {
          $pasienkirimterupdate = PasienkirimkeunitlainT::model()->updateByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id, array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id));
        } else {
          $pasienkirimterupdate = true;
        }
        if ($_POST['BDPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK) {
          $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPendaftaran->pasien, $modPasienMasukPenunjang);
        }
        if (isset($_POST['BDTindakanPelayananT'][0])) {
          if (count((array)$_POST['BDTindakanPelayananT'][0]) > 0) {
            foreach ($_POST['BDTindakanPelayananT'][0] as $ii => $tindakan) {
              if (!empty($tindakan['tindakanpelayanan_id'])) {
                $dataTindakans[$ii] = BDTindakanPelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
                $dataTindakans[$ii]->attributes = $modPasienMasukPenunjang->attributes;
                $dataTindakans[$ii]->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
                $dataTindakans[$ii]->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
                $dataTindakans[$ii]->qty_tindakan = $tindakan['qty_tindakan'];
                $dataTindakans[$ii]->tarif_tindakan = ($tindakan['tarif_tindakan']);
                $dataTindakans[$ii]->cyto_tindakan = $tindakan['cyto_tindakan'];
                $dataTindakans[$ii]->tarifcyto_tindakan = $tindakan['tarif_cyto'];
                $dataTindakans[$ii]->update();

                //agar tindakan yg belum tersimpan ke detai hasil pemeriksaan lab tersimpan RND-14370
                $criteria = new CDbCriteria();
                $criteria->addCondition('tindakanpelayanan_id = ' . $tindakan['tindakanpelayanan_id']);
                $modCekDetHasilLab = DetailhasilpemeriksaanlabT::model()->findAll($criteria);
                if (count((array)$modCekDetHasilLab) <= 0) {
                  $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$ii], $tindakan);
                }
              } else {
                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan);
                if ($_POST['BDPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK) {
                  if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                    if (empty($tindakan['tindakanpelayanan_id'])) { //jika tindakan baru
                      $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$ii], $tindakan);
                    }
                  }
                } else if ($_POST['BDPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI) {
                  $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
                }
              }
              //untuk ditampilkan di form
              $dataTindakans[$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
            }
          }
        }

        if (isset($_POST['ROObatalkespasienT']) or isset($_POST['BDObatalkespasienT'])) {
          if (count((array)$_POST['BDObatalkespasienT']) > 0) {
            //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
            $detailGroups = array();
            foreach ($_POST['BDObatalkespasienT'] as $i => $postDetail) {
              $modDetails[$i] = new BDObatalkespasienT;
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
            $obathabis = "";
            //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
            foreach ($detailGroups as $i => $detail) {
              $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
              if (count((array)$modStokOAs) > 0) {
                foreach ($modStokOAs as $i => $stok) {
                  $modDetails[$i] = $this->simpanObatAlkesPasien($modPasienMasukPenunjang, $stok, $_POST['BDObatalkespasienT']);
                  $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                }
              } else {
                $this->stokobatalkestersimpan &= false;
                $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
              }
            }
          }
        }

        if ($this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan && $pasienkirimterupdate && $this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {

          // SMS GATEWAY
          $smspasien = 1;
          if (Yii::app()->user->getState('issmsgateway')) {
            $modPasien = $modPasienMasukPenunjang->pasien;
            $modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
            $modRuangan = $modPasienMasukPenunjang->ruangan;
            $sms = new Sms();
            foreach ($modSmsgateway as $i => $smsgateway) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasienMasukPenunjang->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPendaftaran->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modRuangan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }

              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPasienMasukPenunjang->tglmasukpenunjang), $isiPesan);

              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
          }
          // END SMS GATEWAY

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pemeriksaan laboratorium berhasil disimpan !");
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id, 'sukses' => 1, 'smspasien' => $smspasien));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan !");
          //                        echo "-".$this->pasienpenunjangtersimpan."<br>";
          //                        echo "-".$this->tindakanpelayanantersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
          //                        echo "-".$this->obatalkespasientersimpan."<br>";
          //                        exit;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render('index', array(
      'modKunjungan' => $modKunjungan,
      'modPemeriksaanLab' => $modPemeriksaanLab,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modTindakan' => $modTindakan,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'dataTindakans' => $dataTindakans,
      'modSmsgateway' => $modSmsgateway,
    ));
  }


  /**
   * simpan BDObatalkespasienT
   * @param type $modPasienMasukPenunjang
   * @param type $stokOa
   * @param type $postObatAlkesPasien
   * @return \BDObatalkespasienT
   * copy dari : PemakaianBmhpController
   */
  public function simpanObatAlkesPasien($modPasienMasukPenunjang, $stokOa, $postObatAlkesPasien)
  {
    $modObatAlkesPasien = new BDObatalkespasienT;
    $modObatAlkesPasien->attributes = $stokOa->attributes;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
    $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
    $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
    $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
    $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
    $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
    $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
    $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
    $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');
    $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
    $modObatAlkesPasien->hargasatuan_oa = $stokOa->getHargaJualSatuan($modObatAlkesPasien->penjamin_id);
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
    foreach ($postObatAlkesPasien as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
      }
    }

    if ($modObatAlkesPasien->save()) {
      $this->obatalkespasientersimpan &= true;
    } else {
      $this->obatalkespasientersimpan &= false;
    }

    //        old
    //        $modObatAlkesPasien = new BDObatalkespasienT;
    //        $modObatAlkesPasien->attributes = $post;
    //        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    //        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //        $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
    //        $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    //        $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
    //        $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
    //        $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
    //        $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
    //        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    //        $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
    //        $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
    //        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
    //        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    //        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
    //        
    //        if($modObatAlkesPasien->validate()) {
    //            $modObatAlkesPasien->save();
    //            StokobatalkesT::kurangiStok($modObatAlkesPasien->qty_oa, $modObatAlkesPasien->obatalkes_id);
    //        } else {
    //            $this->obatalkespasientersimpan &= false;
    //        }
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
    $modStokOaNew->tglstok_in = null;
    $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
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
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $criteria->addCondition("DATE(tgl_kirimpasien) = '" . date("Y-m-d") . "'");
      $criteria->limit = 5;
      $models = BDPasienKirimKeUnitLainV::model()->findAll($criteria);
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
   * - pasienkirimkeunitlain_id
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $model = BDPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));
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
   * set BDPermintaanKePenunjangT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetPermintaanKePenunjang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modPermintaans = BDPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));
      if (count((array)$modPermintaans) > 0) {
        foreach ($modPermintaans as $i => $modPermintaan) {
          $modPemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('pemeriksaanlab_id' => $modPermintaan->pemeriksaanlab_id));
          if (isset($modPemeriksaan->daftartindakan_id)) {
            $modPermintaan->daftartindakan_id = $modPemeriksaan->daftartindakan_id;
            $rows .= $this->renderPartial($this->path_view . "_rowPermintaanKePenunjang", array('i' => 0, 'modPermintaan' => $modPermintaan), true);
          }
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * set LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modTindakans = BDTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {
          $modTindakan->pemeriksaanlab_id = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->pemeriksaanlab_id;
          $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
          $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
          $modTindakan->tarif_satuan = $format->formatNumberForUser($modTindakan->tarif_satuan);
          $rows .= $this->renderPartial($this->path_view_pendaftaran . "_rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan), true);
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
      $satuankecil_id = isset($_POST['satuankecil_id']) ? $_POST['satuankecil_id'] : null;
      $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new BDObatalkespasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      if (count((array)$modStokOAs) > 0) {

        foreach ($modStokOAs as $i => $stok) {
          $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
          $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
          $modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
          $modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
          $modObatAlkesPasien->harganetto_oa = $stok->HPP;
          $modObatAlkesPasien->hargasatuan_oa = $stok->getHargaJualSatuan($penjamin_id);
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

  public function actionAddFormPaketBmhp()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);
      $modPaketBmhp = PaketbmhpM::model()->with('daftartindakan', 'obatalkes')->findAllByAttributes(array('daftartindakan_id' => $daftartindakan_id));
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new BDObatalkespasienT;
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
            $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
            $modObatAlkesPasien->hargasatuan_oa = $stok->getHargaJualSatuan($modObatAlkesPasien->penjamin_id);
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

            //						$form .= $this->renderPartial($this->path_view.'_formAddPaketBmhp', array('paketBmhp'=>$modObatAlkesPasien,'modDaftartindakan'=>$modDaftartindakan,
            //						'modPendaftaran'=>$modPendaftaran), true);
            $form .= $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien), true);
          }
        } else {
          $pesan = "Obat : " . $paket->obatalkes->obatalkes_nama . " Stok tidak mencukupi!";
        }
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

  public function actionAmbilTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tindakanpelayanan_id = (isset($_POST['tindakanpelayanan_id']) ? $_POST['tindakanpelayanan_id'] : null);
      if ($tindakanpelayanan_id != NULL) {
        $TindakanPelayanan = BDTindakanPelayananT::model()->findByPk($tindakanpelayanan_id);
        $data['qty_tindakan'] = $TindakanPelayanan->qty_tindakan;
      } else {
        $data['qty_tindakan'] = 1;
      }

      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }
}

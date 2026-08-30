<?php
//Yii::import('rawatJalan.controllers.KonsulGiziController');
//Yii::import('rawatJalan.models.*');
//class KonsulGiziTPIController extends KonsulGiziController
//{
//        
//}
class KonsulGiziTPIController extends MyAuthController
{
  protected $statusSaveKirimkeUnitLain = false;
  protected $statusSavePermintaanPenunjang = false;
  public $successSave = false;
  public $successSaveTindakan = true;

  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = array();
    $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
    $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKirimKeUnitLain = new PIPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    //            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modKirimKeUnitLain->pegawai_id = isset($modAdmisi->pegawai_id) ? $modAdmisi->pegawai_id : $modPendaftaran->pegawai_id;

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modAdmisi->penjamin_id);

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

    if (isset($_GET['idPasienKirimKeUnitLain'])) {
      $modKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    //RSPMC-1260
    if (!empty(Yii::app()->user->getState('kelasrujukanpenunjang_id'))) {
      $modAdmisi->kelaspelayanan_id = Yii::app()->user->getState('kelasrujukanpenunjang_id');
    }

    if (isset($_POST['PIPasienKirimKeUnitLainT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modAdmisi);
        if (isset($_POST['permintaanPenunjang'])) {
          $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);
          $this->savePasienPenunjang($modPendaftaran, $modKirimKeUnitLain);
        } else {
          $this->statusSavePermintaanPenunjang = true;
        }

        // notif
        $ruangan_tujuan = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);
        $judul = "Konsultasi Gizi Pasien Perawatan Intensif";

        $isi = "Tgl. Konsultasi : " . MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tgl_kirimpasien) . "<br/>";
        $isi .= "No. Pendaftaran : " . $modPendaftaran->no_pendaftaran . "<br/>";
        $isi .= "Pasien : " . $modPasien->no_rekam_medik . " - " . $modPasien->nama_pasien . "<br/>";
        $isi .= "Ruangan Pengirim : " . Yii::app()->user->getState('ruangan_nama');


        CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $ruangan_tujuan->instalasi_id, 'ruangan_id' => $ruangan_tujuan->ruangan_id, 'modul_id' => $ruangan_tujuan->modul_id),
        ));

        if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang) {

          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $sms = new Sms();
          $smspasien = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modPendaftaran->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modPegawai->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modKirimKeUnitLain->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }
          // END SMS GATEWAY

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'idPasienKirimKeUnitLain' => $modKirimKeUnitLain->pasienkirimkeunitlain_id, 'smspasien' => $smspasien));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'instalasi_id' => Params::INSTALASI_ID_GIZI
    ));
    //            $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
    //                                                                                                      'instalasi_id'=>Params::INSTALASI_ID_GIZI),
    //                                                                                                'pasienmasukpenunjang_id IS NULL');

    $modBayarUangMuka = PIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $total = 0;
    foreach ($modBayarUangMuka as $key => $value) {
      $total += $modBayarUangMuka[$key]->jumlahuangmuka;
    }
    $modDeposit = (($modBayarUangMuka) ? $total : null);

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modAdmisi' => $modAdmisi,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modJenisTarif' => $modJenisTarif,
      'modDeposit' => $modDeposit,
    ));
  }

  protected function savePasienKirimKeUnitLain($modAdmisi)
  {
    $modKirimKeUnitLain = new PIPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->attributes = $_POST['PIPasienKirimKeUnitLainT'];
    $modKirimKeUnitLain->pasien_id = $modAdmisi->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modAdmisi->pendaftaran_id;
    $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_GIZI;
    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
    $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    //            $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->create_ruangan = $modAdmisi->ruangan_id;
    $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
    if ($modKirimKeUnitLain->validate()) {
      $modKirimKeUnitLain->save();
      $this->statusSaveKirimkeUnitLain = true;
    }

    return $modKirimKeUnitLain;
  }

  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    foreach ($permintaan as $i => $item) {
      if (isset($item['cbTindakan'])) {
        if ($item['cbTindakan'] == 1) {
          $modPermintaan = new PIPermintaanPenunjangT;
          $modPermintaan->daftartindakan_id = $item['idDaftarTindakan'];     //$permintaan['idDaftarTindakan'][$i];
          $modPermintaan->pemeriksaanlab_id = '';
          $modPermintaan->pemeriksaanrad_id = '';
          $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
          $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PG');
          $modPermintaan->qtypermintaan = 1;
          $modPermintaan->tarif_pelayananan = $item['tarifPelayanan'];
          $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
          if ($modPermintaan->validate()) {
            $modPermintaan->save();
            $this->statusSavePermintaanPenunjang = true;
          }
        }
      }
    }
  }

  protected function savePasienPenunjang($modPendaftaran, $modKirimKeUnitLain)
  {

    $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $kelaspelayanan_id = !empty($admisi) ? $admisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id;

    $modPasienPenunjang = new PIPasienMasukPenunjangT;
    $modPasienPenunjang->pasien_id = $modPendaftaran->pasien_id;
    $modPasienPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modPasienPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPasienPenunjang->pegawai_id = $modPendaftaran->pegawai_id;
    $modPasienPenunjang->kelaspelayanan_id = $kelaspelayanan_id;
    $modPasienPenunjang->ruangan_id = Params::RUANGAN_ID_GIZI;   //$modPendaftaran->ruangan_id;
    $modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang('RJ');
    $modPasienPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');    //$modPendaftaran->tgl_pendaftaran;
    $modPasienPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienPenunjang->ruangan_id);
    $modPasienPenunjang->kunjungan = $modPendaftaran->kunjungan;
    $modPasienPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
    $modPasienPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    $modPasienPenunjang->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;

    //                        echo "<pre>";
    //                        echo print_r($modPasienPenunjang->getAttributes());
    //                        echo "</pre>";

    if ($modPasienPenunjang->validate()) {
      $modPasienPenunjang->Save();
      $this->successSave = true;

      $this->saveTindakanPelayanan($modPendaftaran, $modPasienPenunjang);
      $this->updatePasienKirimKeUnitLain($modPasienPenunjang);
    } else {
      $this->successSave = false;
    }

    return $modPasienPenunjang;
  }

  /**
   * Fungsi untuk menyimpan data ke model TindakanpelayananT
   * @param type $modPendaftaran
   * @param type $modPasienPenunjang
   * @return TindakanpelayananT 
   */
  protected function saveTindakanPelayanan($modPendaftaran, $modPasienPenunjang)
  {
    $valid = true;
    $format = new MyFormatter;
    foreach ($_POST['permintaanPenunjang'] as $i => $item) {
      if (!empty($item)) {
        if (isset($item['cbTindakan'])) {
          if ($item['cbTindakan']) {
            $modTindakans[$i] = new TindakanpelayananT;
            $modTindakans[$i]->attributes = $item;
            $modTindakans[$i]->penjamin_id = $modPendaftaran->penjamin_id;
            $modTindakans[$i]->pasien_id = $modPendaftaran->pasien_id;
            $modTindakans[$i]->kelaspelayanan_id = $modPasienPenunjang->kelaspelayanan_id;
            $modTindakans[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
            $modTindakans[$i]->instalasi_id = Params::INSTALASI_ID_GIZI; //$modPendaftaran->instalasi_id;
            $modTindakans[$i]->ruangan_id = Params::RUANGAN_ID_GIZI;
            $modTindakans[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
            $modTindakans[$i]->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
            $modTindakans[$i]->daftartindakan_id = $item['idDaftarTindakan'];
            $modTindakans[$i]->carabayar_id = $modPendaftaran->carabayar_id;
            $modTindakans[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
            if (isset($_POST['PIPasienKirimKeUnitLainT']['tgl_kirimpasien'])) {
              $tgl_tindakan = $format->formatDateTimeForDb($_POST['PIPasienKirimKeUnitLainT']['tgl_kirimpasien']);
            } else {
              $tgl_tindakan = date('Y-m-d H:i:s');
            }
            $modTindakans[$i]->tgl_tindakan = $tgl_tindakan;
            $modTindakans[$i]->tarif_satuan = $item['tarifPelayanan'];
            $modTindakans[$i]->tarif_satuan = $modTindakans[$i]->getTarifSatuan(); //RND-7250
            $modTindakans[$i]->tarif_tindakan = $item['tarifPelayanan'] * 1;
            $modTindakans[$i]->satuantindakan = "HARI";
            $modTindakans[$i]->qty_tindakan = 1;
            $modTindakans[$i]->cyto_tindakan = $item['cyto'];
            $modTindakans[$i]->tarifcyto_tindakan = ($item['cyto']) ? (($item['cyto'] / 100) * $modTindakans[$i]->tarif_tindakan) : 0;
            $modTindakans[$i]->kelastanggungan_id = $modPendaftaran->kelaspelayanan_id;
            $modTindakans[$i]->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;

            $modTindakans[$i]->discount_tindakan = 0;
            $modTindakans[$i]->subsidiasuransi_tindakan = 0;
            $modTindakans[$i]->subsidipemerintah_tindakan = 0;
            $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
            $modTindakans[$i]->iurbiaya_tindakan = 0;
            $modTindakans[$i]->pasienadmisi_id = $_GET['pasienadmisi_id'];
            $valid = $modTindakans[$i]->validate() && $valid;
          }
        }
      }
    }

    if ($valid) {
      foreach ($modTindakans as $i => $tindakan) {
        if ($tindakan->save()) {
          $this->successSaveTindakan &= true;
          $updateAdmisi = PasienadmisiT::model()->updateByPk($modPendaftaran->pasienadmisi_id, array('pembayaranpelayanan_id' => null));
        } else {
          $this->successSaveTindakan = false;
        }
      }
    } else {
      $this->successSaveTindakan = false;
    }

    return $modTindakans;
  }

  /**
   *
   * @param type $modPasienPenunjang 
   */
  protected function updatePasienKirimKeUnitLain($modPasienPenunjang)
  {
    PasienkirimkeunitlainT::model()->updateByPk(
      $modPasienPenunjang->pasienkirimkeunitlain_id,
      array('pasienmasukpenunjang_id' => $modPasienPenunjang->pasienmasukpenunjang_id)
    );
  }

  public function actionBatalRujukan($task = 'BatalPenunjang')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $status = '';

      $pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');

      $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
        'instalasi_id' => Params::INSTALASI_ID_GIZI
      ));

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $criteria = new CDbCriteria();
        $criteria->addCondition('t.pasienkirimkeunitlain_id = ' . $pasienkirimkeunitlain_id);
        $criteria->addCondition('tindakanpelayanan_t.tindakansudahbayar_id is not null');
        $criteria->join = 'JOIN tindakanpelayanan_t ON tindakanpelayanan_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
        $modPermintaanPenunjang = PermintaankepenunjangT::model()->findAll($criteria);

        if (count((array)$modPermintaanPenunjang) > 0) {
          $pesan = "Pemeriksaan Rujukan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
        } else {
          $modPermintaanKePenunjang = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
          if (count((array)$modPermintaanKePenunjang) > 0) {
            foreach ($modPermintaanKePenunjang as $i => $detail) {
              $update_tindakanpelayanan = TindakanpelayananT::model()->updateByPk($detail->tindakanpelayanan_id, array(
                'detailhasilpemeriksaanlab_id' => null,
                'hasilpemeriksaanrm_id' => null,
                'hasilpemeriksaanrad_id' => null,
                'hasilpemeriksaanpa_id' => null
              ));

              if ($update_tindakanpelayanan) {
                $update_tindakan = true;
                $status = true;
              } else {
                $update_tindakan = false;
                $status = false;
              }

              $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteByPk($detail->tindakanpelayanan_id);
              if ($delete_tindakanpelayanan) {
                $delete_tindakan = true;
                $status = true;
              } else {
                $delete_tindakan = false;
                $status = false;
              }
            }
            if ($status = true) {
              $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));
              if (!empty($pasienMasukPenunjang->pasienkirimkeunitlain_id)) {
                PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, array('pasienkirimkeunitlain_id' => null));
                $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id));
              }

              $delete_permintaankepenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
              if ($delete_permintaankepenunjang) {
                $delete_penunjang = true;
                PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
                PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
                $status = true;
              } else {
                $delete_penunjang = false;
                $status = false;
              }
            }
          } else {
            $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));
            if (!empty($pasienMasukPenunjang->pasienkirimkeunitlain_id)) {
              PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, array('pasienkirimkeunitlain_id' => null));
              $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id));
            }

            $delete_permintaankepenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
            if ($delete_permintaankepenunjang) {
              $delete_penunjang = true;
              PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
              PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
              $status = true;
            } else {
              $delete_penunjang = false;
              $status = false;
            }
          }

          if ($status = true) {
            $pesan = 'Pasien Penunjang berhasil di batalkan';
            $transaction->commit();
          } else {
            $transaction->rollback();
          }
        }
      } catch (Exception $ex) {
        $status = false;
        $pesan = "exist";
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
        'result' => $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain), true)
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  //        public function actionAjaxBatalKirim()
  //        {
  //            if(Yii::app()->request->isAjaxRequest) {
  //            $idPasienKirimKeUnitLain = (isset($_POST['idPasienKirimKeUnitLain']) ? $_POST['idPasienKirimKeUnitLain'] : null);
  //            $pendaftaran_id = $_POST['pendaftaran_id'];
  //            $transaction = Yii::app()->db->beginTransaction();
  //            try{
  //                $pasienpenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain));
  //                $pasienpenunjang->pasienkirimkeunitlain_id = null;
  //                $pasienpenunjang->update();
  //                
  //                $modTindakanPelayanan = TindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id'=>$pasienpenunjang->pasienmasukpenunjang_id));
  //
  //                PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain));
  //                PasienkirimkeunitlainT::model()->deleteByPk($idPasienKirimKeUnitLain);
  //
  //                
  //                PasienmasukpenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idPasienKirimKeUnitLain));
  //                if(count((array)$modTindakanPelayanan) > 0){
  //                    foreach($modTindakanPelayanan as $i=>$items){
  //                        TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$items['tindakanpelayanan_id']));
  //                    }
  //                }
  //                TindakanpelayananT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id'=>$pasienpenunjang->pasienmasukpenunjang_id));
  //                $transaction->commit();
  //            } catch (Exception $ex) {
  //                 $transaction->rollback();
  //                 throw new CHttpException(500,Yii::t('mds','Error :'.$ex));
  //            }
  //            
  //            $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
  //                                                                                                      'instalasi_id'=>Params::INSTALASI_ID_GIZI));
  //            
  //            
  ////            $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
  ////                                                                                                      'instalasi_id'=>Params::INSTALASI_ID_GIZI),
  ////                                                                                                'pasienmasukpenunjang_id IS NULL');
  //            
  //            $data['result'] = $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain), true);
  //
  //            echo json_encode($data);
  //             Yii::app()->end();
  //            }
  //        }
  public function actionLoadFormTindakanGizi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = (isset($_POST['idRuangan']) ? $_POST['idRuangan']  : null);
      $kelaspelayanan_id = (isset($_POST['idKelasPelayanan']) ? $_POST['idKelasPelayanan'] : null);
      $criteria = new CDbCriteria();
      $criteria->addCondition('t.ruangan_id =' . $ruangan_id);
      $criteria->addCondition('daftartindakan_m.daftartindakan_konsul is true');
      $criteria->join = 'JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = t.daftartindakan_id';
      $modTindakan = TindakanruanganM::model()->findAll($criteria);
      //                $modTindakan = TindakanruanganM::model()->with('daftartindakan')->findAllByAttributes(
      //                    array('ruangan_id'=>$ruangan_id)
      //                );

      //          $modTarif = TariftindakanM::model()->findByAttributes(
      //              array(
      //                  'daftartindakan_id'=>$modPeriksaRad->daftartindakan_id,
      //                  'kelaspelayanan_id'=>$idKelasPelayanan,
      //                  'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL
      //              )
      //          );

      $form = null;
      //            if($modTindakan){
      $form = $this->renderPartial(
        '_formLoadTindakanGizi',
        array(
          'modTindakan' => $modTindakan,
          'idKelasPelayanan' => $kelaspelayanan_id,
        ),
        true
      );
      //            }
      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'form' => $form
        )
      );
      exit;
    }
  }

  /**
   * mengecek tarif tindakan gizi
   */
  public function actionCekTindakanGiziKelas()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $kelaspelayanan_id = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null;
      $daftartindakan_id = isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $modPasienAdmisi->penjamin_id)->jenistarif_id;
      $modTarif = TariftindakanM::model()->findByAttributes(
        array(
          'daftartindakan_id' => $daftartindakan_id,
          'kelaspelayanan_id' => $kelaspelayanan_id,
          'jenistarif_id' => $jenistarif,
          'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL
        )
      );
      $data['result'] = $this->renderPartial('_listTarifKonsulGizi', array('modTarif' => $modTarif), true);
      if (!empty($modTarif)) {
        $data['status'] = 'ada';
      } else {
        $data['status'] = 'kosong';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  // public function actionPrint()
  // {
  //     $pendaftaran_id = $_GET['id'];
  //     $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
  //     $modKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);
  //     $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
  //                                                                                               'instalasi_id'=>Params::INSTALASI_ID_GIZI)
  //              //RND-3375
  //                                                                                        // 'pasienmasukpenunjang_id IS NULL');
  //                                                                                                 );
  //     $judulLaporan='Konsultasi Gizi';
  //     $caraPrint=$_REQUEST['caraPrint'];
  //     if($caraPrint=='PRINT') {
  //         $this->layout='//layouts/printWindows';
  //         $this->render('Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
  //     }
  //     else if($caraPrint=='EXCEL') {
  //         $this->layout='//layouts/printExcel';
  //         $this->render('Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
  //     }
  //     else if($_REQUEST['caraPrint']=='PDF') {
  //         $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
  //         $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
  //         $mpdf = new MyPDF60('',$ukuranKertasPDF); 
  //         $mpdf->mirrorMargins = 2;  
  //         $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
  //         $mpdf->WriteHTML($stylesheet,1);  
  //         $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
  //         $mpdf->WriteHTML($this->renderPartial('Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
  //         $mpdf->Output();
  //     }                       
  // }

  public function actionPrint()
  {
    $pendaftaran_id = $_GET['id'];
    $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'instalasi_id' => Params::INSTALASI_ID_GIZI,
      'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
    ));

    $judulLaporan = 'Permintaan Konsultasi Gizi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);
    $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'instalasi_id' => Params::INSTALASI_ID_GIZI
    ));
    $judulLaporan = 'Permintaan Konsultasi Gizi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}

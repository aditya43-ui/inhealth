<?php
//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); //RND-6398
class KonsulGiziController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $successSave = false;
  public $successSaveTindakan = true;
  protected $statusSaveKirimkeUnitLain = false;
  protected $statusSavePermintaanPenunjang = false;
  protected $path_view = 'rawatJalan.views.konsulGizi.';

  public function actionIndex($pendaftaran_id, $idPasienKirimKeUnitLain = null)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_GIZI;

    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul)) {
      $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
    }

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);

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

    if (isset($idPasienKirimKeUnitLain)) {
      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    //RSPMC-1260
    if (!empty(Yii::app()->user->getState('kelasrujukanpenunjang_id'))) {
      $modPendaftaran->kelaspelayanan_id = Yii::app()->user->getState('kelasrujukanpenunjang_id');
    }

    if(isset($_GET['pasienmasukpenunjang_id'])) {
      $modPenunjang = PasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
      $modKirimKeUnitLain->pegawai_id = $modPenunjang->pegawai_id;
    }

    if (isset($_POST['RJPasienKirimKeUnitLainT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran);
        if (isset($_POST['permintaanPenunjang'])) {
          $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);

          PendaftaranT::model()->updateByPk(
            $modPendaftaran->pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );

          //                        RND-6398
          //                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
          //                        $params['create_time'] = date( 'Y-m-d H:i:s');
          //                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
          //                        $params['instalasi_id'] = Params::INSTALASI_ID_GIZI;
          //                        $params['modul_id'] = 15;
          //                        $ruangan = RuanganM::model()->findByPk($ruangan_id);
          //                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
          //                        $params['create_ruangan'] = Params::RUANGAN_ID_GIZI;
          //                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';                        
          //                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);

        } else {
          $this->statusSavePermintaanPenunjang = true;
        }
        $this->savePasienPenunjang($modPendaftaran, $modKirimKeUnitLain);


        // notif
        $ruangan_tujuan = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);
        $judul = "Konsultasi Gizi Pasien " . Yii::app()->user->getState('instalasi_nama');

        $isi = "Tgl. Konsultasi : " . MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tgl_kirimpasien) . "<br/>";
        $isi .= "No. Pendaftaran : " . $modPendaftaran->no_pendaftaran . "<br/>";
        $isi .= "Pasien : " . $modPasien->no_rekam_medik . " - " . $modPasien->nama_pasien . "<br/>";
        $isi .= "Ruangan Pengirim : " . Yii::app()->user->getState('ruangan_nama');

        CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $ruangan_tujuan->instalasi_id, 'ruangan_id' => $ruangan_tujuan->ruangan_id, 'modul_id' => $ruangan_tujuan->modul_id),
        ));


        if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang && $this->successSave && $this->successSaveTindakan) {

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
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'smspasien' => $smspasien));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'instalasi_id' => Params::INSTALASI_ID_GIZI
    ));

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modJenisTarif' => $modJenisTarif
    ));
  }

  protected function savePasienKirimKeUnitLain($modPendaftaran)
  {
    $format = new MyFormatter();
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];
    $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_GIZI;
    $modKirimKeUnitLain->tgl_kirimpasien = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien']);
    $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
    if ($modKirimKeUnitLain->validate()) {
      $modKirimKeUnitLain->save();
      $this->statusSaveKirimkeUnitLain = true;

      $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
      $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
    }

    return $modKirimKeUnitLain;
  }

  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    foreach ($permintaan as $i => $item) {
      if (isset($item['cbTindakan'])) {
        $modPermintaan = new RJPermintaanPenunjangT;
        $modPermintaan->daftartindakan_id = $item['idDaftarTindakan'];     //$permintaan['idDaftarTindakan'][$i];
        $modPermintaan->pemeriksaanlab_id = '';
        $modPermintaan->pemeriksaanrad_id = '';
        $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
        $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PG');
        $modPermintaan->qtypermintaan = 1;
        $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
        if ($modPermintaan->validate()) {
          $modPermintaan->save();
          $this->statusSavePermintaanPenunjang = true;
        }
      }
    }
  }

  protected function savePasienPenunjang($modPendaftaran, $modKirimKeUnitLain)
  {

    $modPasienPenunjang = new RJPasienMasukPenunjangT;
    $modPasienPenunjang->pasien_id = $modPendaftaran->pasien_id;
    $modPasienPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modPasienPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPasienPenunjang->pegawai_id = $modPendaftaran->pegawai_id;
    $modPasienPenunjang->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modPasienPenunjang->ruangan_id = Params::RUANGAN_ID_GIZI;   //$modPendaftaran->ruangan_id;
    $modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang('RJ');
    $modPasienPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');    //$modPendaftaran->tgl_pendaftaran;
    $modPasienPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienPenunjang->ruangan_id);
    $modPasienPenunjang->kunjungan = $modPendaftaran->kunjungan;
    $modPasienPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
    $modPasienPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    $modPasienPenunjang->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
    $modPasienPenunjang->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    if (empty($modPendaftaran->pasienadmisi_id)) {
      $modPasienPenunjang->pasienadmisi_id = null;
    } else {
      $modPasienPenunjang->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    }


    //                        echo "<pre>";
    //                        echo print_r($modPasienPenunjang->getAttributes());
    //                        echo "</pre>";

    if ($modPasienPenunjang->validate()) {
      //                echo "<pre>";
      //                print_r($modPasienPenunjang->getAttributes());
      //                exit;
      $modPasienPenunjang->Save();
      $this->successSave = true;
      if (isset($_POST['permintaanPenunjang']) && count((array)$_POST['permintaanPenunjang']) > 0) {
        $this->saveTindakanPelayanan($modPendaftaran, $modPasienPenunjang);
      }
      $this->updatePasienKirimKeUnitLain($modPasienPenunjang);
    } else {
      $this->successSave = false;
    }

    return $modPasienPenunjang;
  }

  protected function saveTindakanPelayanan($modPendaftaran, $modPasienPenunjang)
  {
    $valid = true;
    $format = new MyFormatter;
    $modTindakans = array();
    foreach ($_POST['permintaanPenunjang'] as $i => $item) {
      if (!empty($item)) {
        if (isset($item['cbTindakan']) == 1) {
          $modTindakans[$i] = new TindakanpelayananT;
          $modTindakans[$i]->attributes = $item;
          $modTindakans[$i]->penjamin_id = $modPendaftaran->penjamin_id;
          $modTindakans[$i]->pasien_id = $modPendaftaran->pasien_id;
          $modTindakans[$i]->kelaspelayanan_id = $modPasienPenunjang->kelaspelayanan_id;
          $modTindakans[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
          $modTindakans[$i]->instalasi_id = Params::INSTALASI_ID_GIZI;
          $modTindakans[$i]->ruangan_id = Params::RUANGAN_ID_GIZI;
          $modTindakans[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
          $modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
          $modTindakans[$i]->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
          $modTindakans[$i]->daftartindakan_id = $item['idDaftarTindakan'];
          $modTindakans[$i]->carabayar_id = $modPendaftaran->carabayar_id;
          $modTindakans[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
          if (isset($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien'])) {
            $tgl_tindakan = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien']);
          } else {
            $tgl_tindakan = date('Y-m-d H:i:s');
          }
          $modTindakans[$i]->tgl_tindakan = $tgl_tindakan;
          $modTindakans[$i]->tarif_satuan = $modTindakans[$i]->getTarifSatuan();
          $modTindakans[$i]->qty_tindakan = 1;
          $modTindakans[$i]->tarif_tindakan = $modTindakans[$i]->tarif_satuan * $modTindakans[$i]->qty_tindakan;
          $modTindakans[$i]->satuantindakan = "HARI";
          $modTindakans[$i]->cyto_tindakan = $item['cyto'];
          $modTindakans[$i]->tarifcyto_tindakan = ($item['cyto']) ? (($item['cyto'] / 100) * $modTindakans[$i]->tarif_tindakan) : 0;
          $modTindakans[$i]->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
          $modTindakans[$i]->discount_tindakan = 0;
          $modTindakans[$i]->subsidiasuransi_tindakan = 0;
          $modTindakans[$i]->subsidipemerintah_tindakan = 0;
          $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
          $modTindakans[$i]->iurbiaya_tindakan = 0;
          $valid = $modTindakans[$i]->validate() && $valid;
          if (isset($item['inputpemeriksaanrad'])) {
            $idPemeriksaanRad[$i] = $item['inputpemeriksaanrad'];
          }
        }
      }
    }

    if ($valid) {
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $tindakan) {
          if ($tindakan->save()) {
            $this->successSaveTindakan &= $tindakan->saveTindakanKomponen();
          }
        }
      }
    } else {
      $this->successSaveTindakan = false;
    }

    return $modTindakans;
  }


  //        RND-6260
  //        protected function saveTindakanKomponen($tindakan)
  //        {   
  //            $valid = true;
  //            $criteria = new CDbCriteria();
  //            $criteria->addCondition('komponentarif_id !='.Params::KOMPONENTARIF_ID_TOTAL);
  //			if(!empty($tindakan->daftartindakan_id)){
  //				$criteria->addCondition("daftartindakan_id = ".$tindakan->daftartindakan_id);						
  //			}
  //			if(!empty($tindakan->kelaspelayanan_id)){
  //				$criteria->addCondition("kelaspelayanan_id = ".$tindakan->kelaspelayanan_id);						
  //			}
  //            $modTarifs = TariftindakanM::model()->findAll($criteria);
  //            foreach ($modTarifs as $i => $tarif) {
  //                $modTindakanKomponen = new TindakankomponenT;
  //                $modTindakanKomponen->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
  //                $modTindakanKomponen->komponentarif_id = $tarif->komponentarif_id;
  //                $modTindakanKomponen->tarif_kompsatuan = $tarif->harga_tariftindakan;
  //                $modTindakanKomponen->tarif_tindakankomp = $modTindakanKomponen->tarif_kompsatuan * $tindakan->qty_tindakan;
  //                if($tindakan->cyto_tindakan){
  //                    $modTindakanKomponen->tarifcyto_tindakankomp = $tarif->harga_tariftindakan * ($tarif->persencyto_tind/100);
  //                } else {
  //                    $modTindakanKomponen->tarifcyto_tindakankomp = 0;
  //                }
  //                $modTindakanKomponen->subsidiasuransikomp = $tindakan->subsidiasuransi_tindakan;
  //                $modTindakanKomponen->subsidipemerintahkomp = $tindakan->subsidipemerintah_tindakan;
  //                $modTindakanKomponen->subsidirumahsakitkomp = $tindakan->subsisidirumahsakit_tindakan;
  //                $modTindakanKomponen->iurbiayakomp = $tindakan->iurbiaya_tindakan;
  //                $valid = $modTindakanKomponen->validate() && $valid;
  //                if($valid)
  //                    $modTindakanKomponen->save();
  //            }
  //            
  //            return $valid;
  //        }

  protected function updatePasienKirimKeUnitLain($modPasienPenunjang)
  {
    RJPasienKirimKeUnitLainT::model()->updateByPk(
      $modPasienPenunjang->pasienkirimkeunitlain_id,
      array('pasienmasukpenunjang_id' => $modPasienPenunjang->pasienmasukpenunjang_id)
    );
  }

  public function actionAjaxBatalKirim()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $idPasienKirimKeUnitLain = (isset($_POST['idPasienKirimKeUnitLain']) ? $_POST['idPasienKirimKeUnitLain'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $pasienpenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain));
        $pasienkirimkeunitlain = PasienkirimkeunitlainT::model()->findByPk($idPasienKirimKeUnitLain);
        $pasienkirimkeunitlain->pasienmasukpenunjang_id = null;
        $pasienkirimkeunitlain->update_time = date('Y-m-d H:i:s');
        $pasienkirimkeunitlain->tgl_kirimpasien = $format->formatDateTimeForDb($pasienkirimkeunitlain->tgl_kirimpasien);
        $pasienkirimkeunitlain->create_time = $format->formatDateTimeForDb($pasienkirimkeunitlain->create_time);

        //                echo print_r($pasienkirimkeunitlain->getAttributes());exit;
        $pasienkirimkeunitlain->update();
        //                $pasienpenunjang->pasienkirimkeunitlain_id = null;
        //                $pasienpenunjang->update();

        $modTindakanPelayanan = TindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienpenunjang->pasienmasukpenunjang_id));

        if (count((array)$modTindakanPelayanan) > 0) {
          foreach ($modTindakanPelayanan as $i => $items) {
            TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $items['tindakanpelayanan_id']));
          }
        }
        TindakanpelayananT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienpenunjang->pasienmasukpenunjang_id));
        PasienmasukpenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain));
        PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain));
        PasienkirimkeunitlainT::model()->deleteByPk($idPasienKirimKeUnitLain);
        $transaction->commit();
      } catch (Exception $ex) {
        $transaction->rollback();
        throw new CHttpException(500, Yii::t('mds', 'Error :' . $ex));
      }
      $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
        array(
          'pendaftaran_id' => $pendaftaran_id,
          'instalasi_id' => Params::INSTALASI_ID_GIZI
        ),
        'pasienmasukpenunjang_id IS NULL'
      );

      $data['result'] = $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  // public function actionPrint()
  // {
  //      $pendaftaran_id = $_GET['id'];
  //      $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
  //      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);
  //      $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
  //                                                                                               'instalasi_id'=>Params::INSTALASI_ID_GIZI)
  //              //RND-3375
  //                                                                                        // 'pasienmasukpenunjang_id IS NULL');
  //                                                                                                 );

  //     $judulLaporan='Konsultasi Gizi';
  //     $caraPrint=$_REQUEST['caraPrint'];
  //     if($caraPrint=='PRINT') {
  //         $this->layout='//layouts/printWindows';
  //         $this->render($this->path_view.'Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
  //     }
  //     else if($caraPrint=='EXCEL') {
  //         $this->layout='//layouts/printExcel';
  //         $this->render($this->path_view.'Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
  //     }
  //     else if($_REQUEST['caraPrint']=='PDF') {
  //         $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
  //         $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
  //         $mpdf = new MyPDF60('',$ukuranKertasPDF); 
  //         //$mpdf->useOddEven = 2;  
  //         $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
  //         $mpdf->WriteHTML($stylesheet,1);  
  //         $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
  //         $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
  //         $mpdf->Output();
  //     }                       
  // }

  public function actionPrint()
  {
    $pendaftaran_id = $_GET['id'];
    $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'instalasi_id' => Params::INSTALASI_ID_GIZI,
      'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
    ));

    $judulLaporan = 'Permintaan Konsultasi Gizi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'instalasi_id' => Params::INSTALASI_ID_GIZI
    ));
    $judulLaporan = 'Permintaan Konsultasi Gizi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
  public function actionLoadFormTindakanGizi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = (isset($_POST['idRuangan']) ? $_POST['idRuangan']  : null);
      $kelaspelayanan_id = (isset($_POST['idKelasPelayanan']) ? $_POST['idKelasPelayanan'] : null);

      $criteria = new CDbCriteria();
      $criteria->addCondition('t.ruangan_id =' . $ruangan_id);
      $criteria->addCondition('daftartindakan_m.daftartindakan_konsul is true');
      $criteria->addCondition('daftartindakan_m.daftartindakan_id = 11894 and t.ruangan_id =' . $ruangan_id, 'OR');
      $criteria->join = 'JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = t.daftartindakan_id';
      $modTindakan = TindakanruanganM::model()->findAll($criteria);

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
        $this->path_view . '_formLoadTindakanGizi',
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
      $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $modPendaftaran->penjamin_id)->jenistarif_id;
      // echo $kelaspelayanan_id.' '.$daftartindakan_id.' '.$pendaftaran_id.' '.$modPendaftaran.' '.$kelaspelayanan_id.' '.;
      $modTarif = TariftindakanM::model()->findByAttributes(
        array(
          'daftartindakan_id' => $daftartindakan_id,
          'kelaspelayanan_id' => $kelaspelayanan_id,
          'jenistarif_id' => $jenistarif,
          'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL
        )
      );
      $data['result'] = $this->renderPartial($this->path_view . '_listTarifKonsulGizi', array('modTarif' => $modTarif), true);
      if (!empty($modTarif)) {
        $data['status'] = 'ada';
      } else {
        $data['status'] = 'kosong';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}

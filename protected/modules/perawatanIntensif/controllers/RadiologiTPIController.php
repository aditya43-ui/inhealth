<?php
class RadiologiTPIController extends MyAuthController
{
  protected $statusSaveKirimkeUnitLain = false;
  protected $statusSavePermintaanPenunjang = false;
  protected $tindakanpelayanantersimpan = true;
  protected $komponentindakantersimpan = true;

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
    //RSPMC-1260
    if (!empty(Yii::app()->user->getState('kelasrujukanpenunjang_id'))) {
      $modKirimKeUnitLain->kelaspelayanan_id = Yii::app()->user->getState('kelasrujukanpenunjang_id');
    } else {
      $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id; //RND-8117
    }

    $modKirimKeUnitLain->isbayarkekasirpenunjang = Yii::app()->user->getState('isbayarkekasirpenunjang');
    //            $modPeriksaRad = PIPemeriksaanRadM::model()->findAllByAttributes(array('pemeriksaanrad_aktif'=>true),array('order'=>'jenispemeriksaanrad_id, pemeriksaanrad_urutan ASC'));
    $modPeriksaRad = PIPemeriksaanRadM::model()->findAllByAttributes(array('pemeriksaanrad_aktif' => true), array('order' => 'jenispemeriksaanrad_id, pemeriksaanrad_nama ASC'));

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

    if (isset($_POST['PIPasienKirimKeUnitLainT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if($_POST['PIPasienKirimKeUnitLainT']['is_cyto'] == 1){
          $_POST['PIPasienKirimKeUnitLainT']['is_cyto'] = true;
        } else{
          $_POST['PIPasienKirimKeUnitLainT']['is_cyto'] = false;
        }
        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modAdmisi);
        if (isset($_POST['permintaanPenunjang'])) {
          $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);
        } else {
          $this->statusSavePermintaanPenunjang = true;
        }

        if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang) {

          $judul = 'Pasien Rawat Intensif Rujuk ke Radiologi';

          $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;
          $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

          // var_dump($mr->attributes); die;
          $link = Yii::app()->createUrl('/radiologi/rujukanPenunjang/Index', array(
            'PasienkirimkeunitlainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
            'PasienkirimkeunitlainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
            'PasienkirimkeunitlainV[no_pendaftaran]' => $modKirimKeUnitLain->pendaftaran->no_pendaftaran,
            'PasienkirimkeunitlainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
            'PasienkirimkeunitlainV[nama_pasien]' => $modPasien->nama_pasien
          ));


          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
            // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
            // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
          ));

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
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'smspasien' => $smspasien));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'instalasi_id' => Params::INSTALASI_ID_RAD
      ),
      'pasienmasukpenunjang_id IS NULL'
    );

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
      'modPeriksaRad' => $modPeriksaRad,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modAdmisi' => $modAdmisi,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modJenisTarif' => $modJenisTarif,
      'modDeposit' => $modDeposit,
    ));
  }

  protected function savePasienKirimKeUnitLain($modAdmisi)
  {
    if (!empty($_POST['pasienkirimkeunitlain_id'])) {
      $modKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findByPk($_POST['pasienkirimkeunitlain_id']);
    } else {
      $modKirimKeUnitLain = new PIPasienKirimKeUnitLainT;
    }
    $modKirimKeUnitLain->attributes = $_POST['PIPasienKirimKeUnitLainT'];
    $modKirimKeUnitLain->pasien_id = $modAdmisi->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modAdmisi->pendaftaran_id;
    $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_RAD;
    $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_RAD;
    $modKirimKeUnitLain->ppds_id = isset($_POST['PIPasienKirimKeUnitLainT']['ppds_id']) ? $_POST['PIPasienKirimKeUnitLainT']['ppds_id'] : false;
    $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    //            $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->create_ruangan = $modAdmisi->ruangan_id;
    $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
    $modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['PIPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['PIPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;
    $modKirimKeUnitLain->is_cyto = isset($_POST['PIPasienKirimKeUnitLainT']['is_cyto']) ? $_POST['PIPasienKirimKeUnitLainT']['is_cyto'] : false;
    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
    if ($modKirimKeUnitLain->validate()) {
      $modKirimKeUnitLain->save();
      $this->statusSaveKirimkeUnitLain = true;
    }

    return $modKirimKeUnitLain;
  }

  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    foreach ($permintaan['inputpemeriksaanrad'] as $i => $value) {
      if (!empty($permintaan['pasienkirimkeunitlain_id'][$i])) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('pasienkirimkeunitlain_id =' . $permintaan['pasienkirimkeunitlain_id'][$i]);
        $criteria->addCondition('daftartindakan_id =' . $permintaan['idDaftarTindakan'][$i]);
        $modPermintaan = PIPermintaanPenunjangT::model()->find($criteria);
      } else {
        $modPermintaan = new PIPermintaanPenunjangT;
      }

      $modPermintaan->daftartindakan_id = $permintaan['idDaftarTindakan'][$i];
      $modPermintaan->pemeriksaanlab_id = '';
      $modPermintaan->pemeriksaanrad_id = $permintaan['inputpemeriksaanrad'][$i];
      $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
      $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PR');
      $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
      $modPermintaan->tarif_pelayananan = $permintaan['inputtarifpemeriksaanrad'][$i];
      $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
      if($modKirimKeUnitLain->is_cyto == true){
        $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modKirimKeUnitLain->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$modPermintaan->pemeriksaanrad->daftartindakan_id,
                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
        $modPermintaan->tarif_pelayananan = $modTarif->totaltarifakhir_cyto;
      }else{
        $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modKirimKeUnitLain->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$modPermintaan->pemeriksaanrad->daftartindakan_id,
                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
        $modPermintaan->tarif_pelayananan = $modTarif->harga_tariftindakan;
      }
      if ($modPermintaan->validate()) {
        if ($modPermintaan->save()) {
          $this->statusSavePermintaanPenunjang = true;
          /*
						if($modKirimKeUnitLain->isbayarkekasirpenunjang){ 
							$modPendaftaran = $modKirimKeUnitLain->pendaftaran;
							$modTindakan = $this->simpanTindakanPelayanan($modPendaftaran,$modKirimKeUnitLain,$modPermintaan); //AGAR BISA DI BAYAR DI KASIR
							$modPermintaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
							$modPermintaan->update();
						}
                         * 
                         */
        }
      }
    }
  }

  /**
   * proses simpan TindakanPelayananT dan TindakanKomponenT
   * khusus untuk permintaan penunjang
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modKirimKeUnitLain, $modPermintaan)
  {
    //            $modTindakan = new PITindakanPelayananT;

    if (!empty($modPermintaan->tindakanpelayanan_id)) { //supaya tidak duplikat ketika update RSSP-992
      $modTindakan = PITindakanPelayananT::model()->findByPk($modPermintaan->tindakanpelayanan_id);
    } else {
      $modTindakan = new PITindakanPelayananT;
    }

    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->ruangan_id = $modKirimKeUnitLain->ruangan_id;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->daftartindakan_id = $modPermintaan->daftartindakan_id;
    $modTindakan->tarif_satuan = $modPermintaan->tarif_pelayananan;
    $modTindakan->qty_tindakan = $modPermintaan->qtypermintaan;
    $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    //			$modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->create_ruangan = $this->getRuanganId();
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modKirimKeUnitLain->pegawai_id;
    $modTindakan->perawat_id = (!empty($modKirimKeUnitLain->perawat_id) ? $modKirimKeUnitLain->perawat_id : null);
    $modTindakan->tgl_tindakan = $modPermintaan->tglpermintaankepenunjang;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
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

    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= true;
        $updateAdmisi = PasienadmisiT::model()->updateByPk($modPendaftaran->pasienadmisi_id, array('pembayaranpelayanan_id' => null));
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }


  //copy dari RJ - LaboratoriumController penyesuaian di $modRiwayatKirimKeUnitLain
  public function actionBatalRujukan($task = 'BatalPenunjang')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $status = '';
      $kirimUnit = array();

      $pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');

      $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(
        array(
          'pendaftaran_id' => $pendaftaran_id,
          'instalasi_id' => Params::INSTALASI_ID_RAD
        ),
        'pasienmasukpenunjang_id IS NULL'
      );

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

          $kirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
          if (!empty($kirim)) {
            $kirimUnit = array(
              'instalasi_id' => $kirim->instalasi_id,
              'ruangan_id' => $kirim->ruangan_id,
              'pasien_id' => $kirim->pasien_id,
              'no_pendaftaran' => $kirim->pendaftaran->no_pendaftaran
            );
          }

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
              $delete_permintaankepenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
              if ($delete_permintaankepenunjang) {
                $delete_penunjang = true;
                PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
                $status = true;
              } else {
                if (count((array)$modPermintaanKePenunjang) <= 0) {
                  PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
                }
                $delete_penunjang = false;
                $status = false;
              }
            }
          } else {
            $delete_permintaankepenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
            if ($delete_permintaankepenunjang) {
              $delete_penunjang = true;
              PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
              $status = true;
            } else {
              if (count((array)$modPermintaanKePenunjang) <= 0) {
                PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
              }
              $delete_penunjang = false;
              $status = false;
            }
          }

          if ($status = true) {

            $this->notifBatalRujuk($kirimUnit);

            $pesan = 'Pasien Penunjang berhasil dibatalkan!';
            $transaction->commit();
          } else {
            $pesan = 'Pasien Penunjang tidak bisa dibatalkan!<br/>' . $ex->getMessage();
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

  /**
   * - digunakan untuk mengenerate notif batal rujukan
   * @param type $modKirimKeunitlain
   */
  protected function notifBatalRujuk($modKirimKeunitlain)
  {

    $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain['ruangan_id']);
    $pasien_id = $modKirimKeunitlain['pasien_id'];
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul = 'Pasien Batal Rujuk Laboratorium';

    $isi = $modKirimKeunitlain['no_pendaftaran'] . ' ' . $modPasien->no_rekam_medik . ' ' . $modPasien->nama_pasien;


    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modKirimKeunitlain['instalasi_id'], 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
    ));
  }

  //        public function actionAjaxBatalKirim()
  //        {
  //            if(Yii::app()->request->isAjaxRequest) {
  //				$pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
  //				$pendaftaran_id = $_POST['pendaftaran_id'];
  //				$data['pesan'] = "Pasien kirim ke radiologi gagal dibatalkan!";
  //				$data['sukses'] = 0;
  //				
  //				$transaction = Yii::app()->db->beginTransaction();
  //				try {
  //					$loadPermintaans = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id));
  //					if(count((array)$loadPermintaans) > 0){
  //						foreach($loadPermintaans AS $i => $permintaan){
  //							$hapuspermintaan = true;
  //							if(!empty($permintaan->tindakanpelayanan_id)){
  //								if(!empty($permintaan->tindakanpelayanan->tindakansudahbayar_id)){
  //									$hapuspermintaan = false;
  //								}else{
  //									$permintaan->tindakanpelayanan->delete();
  //								}
  //							}
  //							if($hapuspermintaan){
  //								if($permintaan->delete()){
  //									$data['pesan'] = "Pasien kirim ke radiologi berhasil dibatalkan!";
  //									$data['sukses'] = 1;
  //								}
  //							}else{
  //								$data['pesan'] = "Pasien kirim ke radiologi tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
  //								$data['sukses'] = 0;
  //							}
  //						}
  //					}
  //					PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
  //					$transaction->commit();
  //				}catch (Exception $exc) {
  //					$transaction->rollback();
  //					$data['pesan'] = "Pasien kirim ke radiologi gagal dibatalkan karena tindakan sudah dibayarkan!";
  //					$data['sukses'] = 0;
  //				}
  //				$modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
  //                                                                                                      'instalasi_id'=>Params::INSTALASI_ID_RAD),
  //                                                                                                'pasienmasukpenunjang_id IS NULL');
  //            
  //				$data['result'] = $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain), true);
  //			
  //				echo json_encode($data);
  //				 Yii::app()->end();
  //            }
  //        }
  //          
  /*public function actionDeletePemeriksaanRad() {
            if(Yii::app()->request->isAjaxRequest)
            {   
                $pesan = '';
                $pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
		$daftartindakan_id = isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null;	
                if(!empty($pasienkirimkeunitlain_id) && !empty($daftartindakan_id)){
                    $delete_permintaankepenunjang = PIPermintaanPenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$pasienkirimkeunitlain_id, 'daftartindakan_id'=>$daftartindakan_id));
                    if($delete_permintaankepenunjang){
                        $pesan = '';
                    }
                    else{
                        $pesan = 'Data Gagal Dihapus';
                    }
                }                
                
                $data = array('pesan'=>$pesan);
		echo json_encode($data);
		Yii::app()->end();
            } 
        }*/
  public function actionDeletePemeriksaanRad()
  { //RSSP-992
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $status = true;
      $pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
      $daftartindakan_id = isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null;

      try {
        $transaction = Yii::app()->db->beginTransaction();

        $criteria = new CDbCriteria();
        $criteria->addCondition('t.pasienkirimkeunitlain_id = ' . $pasienkirimkeunitlain_id);
        $criteria->addCondition('t.daftartindakan_id = ' . $daftartindakan_id);
        $criteria->addCondition('tindakanpelayanan_t.tindakansudahbayar_id is not null');
        $criteria->join = 'JOIN tindakanpelayanan_t ON tindakanpelayanan_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
        $modPermintaanPenunjang = PIPermintaanPenunjangT::model()->findAll($criteria);

        if (count((array)$modPermintaanPenunjang) > 0) {
          $pesan = "Pemeriksaan Rujukan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
        } else {

          $criteria = new CDbCriteria();
          $criteria->addCondition('t.pasienkirimkeunitlain_id = ' . $pasienkirimkeunitlain_id);
          $criteria->addCondition('t.daftartindakan_id = ' . $daftartindakan_id);
          $criteria->join = 'JOIN tindakanpelayanan_t ON tindakanpelayanan_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
          $modPermintaanPenunjang = PIPermintaanPenunjangT::model()->findAll($criteria);

          foreach ($modPermintaanPenunjang as $i => $detail) {
            $update_tindakanpelayanan = PITindakanPelayananT::model()->updateByPk($detail->tindakanpelayanan_id, array(
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

            $delete_tindakanpelayanan = PITindakanPelayananT::model()->deleteByPk($detail->tindakanpelayanan_id);
            if ($delete_tindakanpelayanan) {
              $delete_tindakan = true;
              $status = true;
            } else {
              $delete_tindakan = false;
              $status = false;
            }
          }

          if ($status && !empty($pasienkirimkeunitlain_id) && !empty($daftartindakan_id)) {
            $delete_permintaankepenunjang = PIPermintaanPenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'daftartindakan_id' => $daftartindakan_id));
            if ($delete_permintaankepenunjang) {
              $pesan = '';
              $transaction->commit();
            } else {
              $pesan = 'Data Gagal Dihapus';
              $transaction->rollback();
            }
          }
        }
      } catch (Exception $ex) {
        $pesan = 'Data Gagal Dihapus. Error';
        $transaction->rollback();
      }


      $data = array('pesan' => $pesan);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * UNTUK LOAD DAFTAR PEMERIKSAAN RADIOLOGI
   */
  public function actionLoadFormPemeriksaanRad()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pemeriksaanrad_id = (isset($_POST['pemeriksaanrad_id']) ? $_POST['pemeriksaanrad_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

      //$modTindakanRuangan = TindakanruanganV::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaRad->daftartindakan_id));
      $criteria = new CDbCriteria();
      $criteria->addCondition('pemeriksaanrad_id = ' . $pemeriksaanrad_id);
      $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
      $criteria->addCondition('penjamin_id = ' . $modPasienAdmisi->penjamin_id);
      $modTarif = TarifpemeriksaanradruanganV::model()->find($criteria);

      /**
       * dicomment RND-3288
       */
      //                $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id = '.$modPasienAdmisi->penjamin_id)->jenistarif_id;
      //                $modPeriksaRad = PemeriksaanradM::model()->findByPk($pemeriksaanrad_id);
      //                $modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaRad->daftartindakan_id,
      //                                                                            'kelaspelayanan_id'=>$kelaspelayanan_id,
      //                                                                            'jenistarif_id'=>$jenistarif,
      //                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial('_formLoadPemeriksaanRad', array(
          //                                                                                'modPeriksaRad'=>$modPeriksaRad,
          //'modTindakanRuangan'=>$modTindakanRuangan,
          'modTarif' => $modTarif
        ), true)
      ));
      exit;
    }
  }
  public function actionPrint()
  {
    $pendaftaran_id = $_GET['id'];
    $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
      ),
      'pasienmasukpenunjang_id IS NULL'
    );
    $modKirim = PIPasienKirimKeUnitLainT::model()->findByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
      ),
    );

    $judulLaporan = 'Permintaan Pemeriksaan Radiologi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('modAdmisi' => $modAdmisi, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('modAdmisi' => $modAdmisi, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('modAdmisi' => $modAdmisi, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);

    $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'instalasi_id' => Params::INSTALASI_ID_RAD
      ),
      'pasienmasukpenunjang_id IS NULL'
    );

    $judulLaporan = 'Permintaan Pemeriksaan Radiologi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printRiwayat', array('modAdmisi' => $modAdmisi, 'modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printRiwayat', array('modAdmisi' => $modAdmisi, 'modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printRiwayat', array('modAdmisi' => $modAdmisi, 'modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
  public function actionUbahPemeriksaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $status = '';
      $content = '';

      $pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');

      $modRiwayatKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findByPk($pasienkirimkeunitlain_id);

      $criteria = new CDbCriteria();
      $criteria->addCondition('pasienkirimkeunitlain_id = ' . $pasienkirimkeunitlain_id);
      $modPermintaanPenunjang = PermintaankepenunjangT::model()->findAll($criteria);

      if (count((array)$modPermintaanPenunjang) > 0) {
        foreach ($modPermintaanPenunjang as $i => $penunjang) {
          $modTarif = new TarifpemeriksaanradruanganV();
          $modTarif->pemeriksaanrad_id = $penunjang->pemeriksaanrad_id;
          $modTarif->harga_tariftindakan = $penunjang->tarif_pelayananan;
          $modTarif->daftartindakan_id = $penunjang->daftartindakan_id;
          $modTarif->jenispemeriksaanrad_id = isset($penunjang->pemeriksaanrad->jenispemeriksaanrad_id) ? $penunjang->pemeriksaanrad->jenispemeriksaanrad_id : null;
          $modTarif->jenispemeriksaanrad_nama = isset($penunjang->pemeriksaanrad->jenispemeriksaanrad_id) ? $penunjang->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama : null;
          $modTarif->pemeriksaanrad_nama = isset($penunjang->pemeriksaanrad_id) ? $penunjang->pemeriksaanrad->pemeriksaanrad_nama : "";
          $pasienkirimkeunitlain_id = isset($penunjang->pasienkirimkeunitlain_id) ? $penunjang->pasienkirimkeunitlain_id : null;

          $content .= $this->renderPartial('_formLoadPemeriksaanRad', array('modTarif' => $modTarif, 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id), true);
        }
      } else {
        $pesan = 'Permintaan Ke Penunjang tidak ditemukan';
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
        'ruangan_id' => isset($modRiwayatKirimKeUnitLain->ruangan_id) ? $modRiwayatKirimKeUnitLain->ruangan_id : null,
        'content' => $content,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function getRuanganId()
  {
    $ruangan_id = null;
    if (isset($_GET['pasienadmisi_id'])) {
      $modAdmisi = PasienadmisiT::model()->findByPk($_GET['pasienadmisi_id']);
      $ruangan_id = $modAdmisi->ruangan_id;
    } else {
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
    }
    return $ruangan_id;
  }
}

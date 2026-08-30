<?php

class PendaftaranBedahSentralRujukanRSController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "bedahSentral.views.pendaftaranBedahSentralRujukanRS.";

  public $rencanaoperasitersimpan = false;
  public $pasienpenunjangtersimpan = false;
  public $pasienkirimunitlain = false;
  public $pelaksanaoperasisimpan = true;
  public $areaoperasisimpan = true;
  public $areaoperasidetsimpan = true;

  /**
   * Tambah / Ubah Pemeriksaan Bedah.
   */
  public function actionIndex($pasienmasukpenunjang_id = null, $pendaftaran_id = null, $instalasi_id = null)
  {
    $format = new MyFormatter();
    $modKunjungan = new BSPasienKirimKeUnitLainV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPemeriksaanBedah = new BSTarifoperasiruanganV;
    $modPasienMasukPenunjang = new BSPasienmasukpenunjangT;
    $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modTindakan = new BSTindakanPelayananT;
    $modGambarTubuh = new BSGambartubuhM();
    $modBagianTubuh = new BSBagiantubuhM();
    $modAreaOperasi = new BSAreaoperasiT;
    $modAreaDetOp = array();

    $dataTindakans = array();
    $modRencanaOperasi = new BSRencanaOperasiT;
    $modRencanaOperasi->norencanaoperasi = MyGenerator::noRencanaOperasi();
    $modRencanaOperasi->statusoperasi = Params::DEFAULT_STATUS_OPERASI;
    $modRencanaOperasi->tglrencanaoperasi = date('Y-m-d h:i:s');
    $modRencanaOperasi->qty_tindakan = 1;

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
      $modKunjungan = BSPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_GET['pasienkirimkeunitlain_id']));

      $modPasienMasukPenunjang->pasienkirimkeunitlain_id = isset($modKunjungan->pasienkirimkeunitlain_id) ? $modKunjungan->pasienkirimkeunitlain_id : "";
      $modPasienMasukPenunjang->jeniskasuspenyakit_id = isset($modKunjungan->jeniskasuspenyakit_id) ? $modKunjungan->jeniskasuspenyakit_id : "";
      $modPasienMasukPenunjang->kelaspelayanan_id = isset($modKunjungan->kelaspelayanan_id) ? $modKunjungan->kelaspelayanan_id : "";
      $p = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
      $modKunjungan->pasienadmisi_id = $p->pasienadmisi_id;

      $listMorbiditas = BSPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));
      $isi = '';
      if (count((array)$listMorbiditas) > 0) {
        foreach ($listMorbiditas as $key => $val) {
          $isi .= $val->diagnosa->diagnosa_nama . ', ';
        }
      }

      $kirimunit = PasienkirimkeunitlainT::model()->findByPk($_GET['pasienkirimkeunitlain_id']);

      $modKunjungan->namadiagnosa = $isi;
      $modRencanaOperasi->tglkirimpasien = $modKunjungan->tgl_kirimpasien;
      $modRencanaOperasi->estimasioperasi = $kirimunit->estimasioperasi;

      $rencana = BSRencanaOperasiT::model()->find("pendaftaran_id = $modKunjungan->pendaftaran_id");

      if(!empty($rencana)) {
        $modRencanaOperasi = $rencana;
      }
      $modRencanaOperasi->tglkirimpasien = $kirimunit->tgl_kirimpasien;
      $modRencanaOperasi->estimasioperasi = $kirimunit->estimasioperasi;
      $modRencanaOperasi->tglrencanaoperasi = $kirimunit->tglrencanapemeriksaan;
      $modRencanaOperasi->kamarruangan_id = Yii::app()->user->getState('ruangan_id');

    }

    if (isset($_GET['pendaftaran_id'])) {
      $modKunjungan = BSInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'instalasi_id' => $_GET['instalasi_id']));
      $modKunjungan->instalasiasal_id = $modKunjungan->instalasi_id;
      $modKunjungan->instalasiasal_nama = $modKunjungan->instalasi_nama;
      $modKunjungan->ruanganasal_id = $modKunjungan->ruangan_id;
      $modKunjungan->ruanganasal_nama = $modKunjungan->ruangan_nama;
      $modKunjungan->nama_bin = $modKunjungan->alias;
      $modPasienMasukPenunjang->pasienkirimkeunitlain_id = isset($modKunjungan->pasienkirimkeunitlain_id) ? $modKunjungan->pasienkirimkeunitlain_id : null;
      $modPasienMasukPenunjang->jeniskasuspenyakit_id = isset($modKunjungan->jeniskasuspenyakit_id) ? $modKunjungan->jeniskasuspenyakit_id : null;
      $modPasienMasukPenunjang->kelaspelayanan_id = isset($modKunjungan->kelaspelayanan_id) ? $modKunjungan->kelaspelayanan_id : null;

      $rencana = BSRencanaOperasiT::model()->find("pendaftaran_id = $pendaftaran_id");

      if(!empty($rencana)) {
        $modRencanaOperasi = $rencana;
      }
    }

    if (!empty($pasienmasukpenunjang_id)) {
      $modPasienMasukPenunjang = BSPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $loadModKunjungan = BSPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;

        $listMorbiditas = BSPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));
        $isi = '';
        if (count((array)$listMorbiditas) > 0) {
          foreach ($listMorbiditas as $key => $val) {
            $isi .= $val->diagnosa->diagnosa_nama . ', ';
          }
        }
      }
      // echo '<pre>';var_dump($modKunjungan);die;
      $modKunjungan->namadiagnosa = $isi;
      $loadRencanaOperasi = BSRencanaOperasiT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      if (!isset($_GET['sukses'])) {
        if (isset($_GET['statusoperasi'])) {
          if ($_GET['statusoperasi'] == Params::STATUSOPERASI_RENCANA) {
            $loadRencanaOperasi = null;
          }
        }
      }

      
      if (!empty($loadRencanaOperasi)) {
        $modRencanaOperasi = $loadRencanaOperasi;
        $modRencanaOperasi->tglkirimpasien = $modKunjungan->tgl_tindakan;
        $modRencanaOperasi->estimasioperasi = $modKunjungan->estimasioperasi;
        $modRencanaOperasi->kamarruangan1_id = $modKunjungan->ruangan_id;
        // echo '<pre>';var_dump($modRencanaOperasi);die;
        if (!empty($loadRencanaOperasi->pegmengetahui_id)) {
          $modPgMengetahui = PegawaiM::model()->findByPk($loadRencanaOperasi->pegmengetahui_id);
          $modRencanaOperasi->pegmengetahui_nama = $modPgMengetahui->namaLengkap;
        }
      }
      $modTindakan = new BSRencanaOperasiT();

      $modAreaOperasi = BSAreaoperasiT::model()->find("pasienmasukpenunjang_id = '" . $pasienmasukpenunjang_id . "' ");
      //			echo '<pre>';
      //                        print_r($modAreaOperasi);
      //                        exit();
      if (!empty($modAreaOperasi)) {
        $modAreaOperasi->pegawai_nama = $modAreaOperasi->pegawai->namaLengkap ?? '';

        $modAreaDetOp = BSAreaoperasidetT::model()->findAll(" areaoperasi_id = '" . $modAreaOperasi->areaoperasi_id . "' ");

        if (count((array)$modAreaDetOp) < 1) {
          $modAreaDetOp = array();
        }
      } else {
        $modAreaOperasi = new BSAreaoperasiT();
      }
    }

    if (isset($_POST['BSRencanaOperasiT'])) {

      $modRencanaOperasi->attributes = $_POST['BSRencanaOperasiT'];
      

      $modRencanaOperasi->jam_mulai = !empty($_POST['BSRencanaOperasiT']['jam_mulai']) ? $_POST['BSRencanaOperasiT']['jam_mulai'] : null;
      $modRencanaOperasi->jam_selesai = !empty($_POST['BSRencanaOperasiT']['jam_selesai']) ? $_POST['BSRencanaOperasiT']['jam_selesai'] : null;
      $modRencanaOperasi->paramedis_id = isset($_POST['BSRencanaOperasiT']['paramedis_id']) ? $_POST['BSRencanaOperasiT']['paramedis_id'] : null;


      $modPendaftaran = $this->loadModel($_POST['pendaftaran_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {

        if (isset($_POST['BSPasienmasukpenunjangT'])) {
          $modPasienMasukPenunjang = $this->savePasienPenunjang($modPendaftaran, $_POST['BSPasienmasukpenunjangT'], $modRencanaOperasi);
          if (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)) {
            $dataPasienKirimUnitLain = BSPasienKirimKeUnitLainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
            $dataPasienKirimUnitLain->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
            $dataPasienKirimUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($_POST['BSRencanaOperasiT']['tglkirimpasien']);
            $dataPasienKirimUnitLain->estimasioperasi = MyFormatter::formatNumberForDb($_POST['BSRencanaOperasiT']['estimasioperasi']);
            // if (isset($_POST['BSTindakanPelayananT'])) {
            //   if (count((array)$_POST['BSindakanPelayananT']) > 0) {
            //     foreach ($_POST['BSTindakanPelayananT'] as $ii => $tindakan) {
            //       $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan);
            //       $dataTindakans[$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
            //       $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
            //       $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
            //     }
            //   }
            // }
            if ($dataPasienKirimUnitLain->validate()) {
              $dataPasienKirimUnitLain->update();
              $this->pasienkirimunitlain = true;
            } else {
              $this->pasienkirimunitlain = false;
            }
          }
        }
        $postRencanaTindakan = array();

        foreach ($_POST['BSRencanaOperasiT'] as $k => $v) {
          if (is_array($v)) {
            $postRencanaTindakan[] = $v;
          }
        }

        // echo '<pre>'; var_dump($modRencanaOperasi->attributes, $_POST['BSRencanaOperasiT'], count((array)$postRencanaTindakan));
        // die;

        $operasi_ceklis = array();
        
        // if(isset($_POST['BSPermintaanKePenunjangT'])) {
        //   foreach($_POST['BSPermintaanKePenunjangT'] as $iii => $data) {
        //       $rencanaOperasiSimpan = $this->saveRencanaOperasi($modPendaftaran, $modPasienMasukPenunjang, $modRencanaOperasi, $data);
        //   }
        // }

        if (count((array)$postRencanaTindakan) > 0) {


          foreach ($postRencanaTindakan as $ii => $rencana) {



            $operasi_ceklis[] = $rencana['operasi_id'];

            if (!empty($rencana['rencanaoperasi_id'])) {
              $dataTindakansa[$ii] = BSRencanaOperasiT::model()->findByPk($rencana['rencanaoperasi_id']);
              $dataTindakansa[$ii]->tglrencanaoperasi = $format->formatDateTimeForDb($_POST['BSRencanaOperasiT']['tglrencanaoperasi']);
              $dataTindakansa[$ii]->kamarruangan_id = !empty($_POST['BSRencanaOperasiT']['kamarruangan_id']) ? $_POST['BSRencanaOperasiT']['kamarruangan_id'] : null;
              $dataTindakansa[$ii]->dokterpelaksana1_id = !empty($_POST['BSRencanaOperasiT']['dokterpelaksana1_id']) ? $_POST['BSRencanaOperasiT']['dokterpelaksana1_id'] : null;
              $dataTindakansa[$ii]->dokterpelaksana2_id = !empty($_POST['BSRencanaOperasiT']['dokterpelaksana2_id']) ? $_POST['BSRencanaOperasiT']['dokterpelaksana2_id'] : null;
              $dataTindakansa[$ii]->dokteranastesi_id = !empty($_POST['BSRencanaOperasiT']['dokteranastesi_id']) ? $_POST['BSRencanaOperasiT']['dokteranastesi_id'] : null;
              $dataTindakansa[$ii]->paramedis_id = !empty($_POST['BSRencanaOperasiT']['paramedis_id']) ? $_POST['BSRencanaOperasiT']['paramedis_id'] : null;
              $dataTindakansa[$ii]->suster_id = !empty($_POST['BSRencanaOperasiT']['suster_id']) ? $_POST['BSRencanaOperasiT']['suster_id'] : null;
              $dataTindakansa[$ii]->bidan_id = !empty($_POST['BSRencanaOperasiT']['bidan_id']) ? $_POST['BSRencanaOperasiT']['bidan_id'] : null;
              $dataTindakansa[$ii]->perawatsirkuler_id = !empty($_POST['BSRencanaOperasiT']['perawatsirkuler_id']) ? $_POST['BSRencanaOperasiT']['perawatsirkuler_id'] : null;
              $dataTindakansa[$ii]->keterangan_rencana = $_POST['BSRencanaOperasiT']['keterangan_rencana'];
              $dataTindakansa[$ii]->operasi_id = $rencana['operasi_id'];
              $dataTindakansa[$ii]->is_cyto = (($rencana['cyto_tindakan'] == 1) ? TRUE : FALSE);
              $dataTindakansa[$ii]->mulaioperasi = $format->formatDateTimeForDb($dataTindakansa[$ii]->mulaioperasi);
              $dataTindakansa[$ii]->selesaioperasi = $format->formatDateTimeForDb($dataTindakansa[$ii]->selesaioperasi);
              $dataTindakansa[$ii]->create_time = $format->formatDateTimeForDb($dataTindakansa[$ii]->create_time);
              $dataTindakansa[$ii]->update_time = $format->formatDateTimeForDb($dataTindakansa[$ii]->update_time);
              

              $dataTindakansa[$ii]->jam_mulai = !empty($_POST['BSRencanaOperasiT']['jam_mulai']) ? $_POST['BSRencanaOperasiT']['jam_mulai'] : null;
              $dataTindakansa[$ii]->jam_selesai = !empty($_POST['BSRencanaOperasiT']['jam_selesai']) ? $_POST['BSRencanaOperasiT']['jam_selesai'] : null;


              if (isset($_GET['statusoperasi'])) {
                if ($_GET['statusoperasi'] == Params::STATUSOPERASI_RENCANA) {
                  $dataTindakansa[$ii]->tgl_mengetahui = null;
                  $dataTindakansa[$ii]->statusoperasi = Params::STATUSOPERASI_RENCANA;
                }
              }

              if (isset($_POST['BSRencanaOperasiT']['pegmengetahui_id'])) {
                $dataTindakansa[$ii]->pegmengetahui_id = $_POST['BSRencanaOperasiT']['pegmengetahui_id'];
              }

              // var_dump($dataTindakansa[$ii]->attributes); die;

              $dataTindakansa[$ii]->save();
              // var_dump($dataTindakansa[$ii]->getErrors());
              $this->rencanaoperasitersimpan = true;
            } else {
              $dataTindakansa[$ii] = $this->saveRencanaOperasi($modPendaftaran, $modPasienMasukPenunjang, $modRencanaOperasi, $rencana);
            }

      

            if ($this->rencanaoperasitersimpan) {
              if (isset($_POST['BSPelaksanaoperasiT'])) {
                foreach ($_POST['BSPelaksanaoperasiT'] as $iii => $val) {
                  if (empty($val['pelaksanaoperasi_id'])) {
                    $modPelaksanaOp = new BSPelaksanaoperasiT();
                    $modPelaksanaOp->attributes = $_POST['BSPelaksanaoperasiT'][$iii];
                    $modPelaksanaOp->rencanaoperasi_id = $dataTindakansa[$ii]->rencanaoperasi_id;
                    $modPelaksanaOp->create_time = date('Y-m-d H:i:s');
                    $modPelaksanaOp->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modPelaksanaOp->create_ruangan = Yii::app()->user->getState('create_ruangan');

                    $this->pelaksanaoperasisimpan = $this->pelaksanaoperasisimpan && $modPelaksanaOp->save();
                  } else {
                    $modPelaksanaOp = BSPelaksanaoperasiT::model()->findByPk($val['pelaksanaoperasi_id']);
                    $modPelaksanaOp->attributes = $_POST['BSPelaksanaoperasiT'][$iii];
                    $modPelaksanaOp->update_time = date('Y-m-d H:i:s');
                    $modPelaksanaOp->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

                    $this->pelaksanaoperasisimpan = $this->pelaksanaoperasisimpan && $modPelaksanaOp->save();
                  }
                }
              }
              //var_dump($_POST['BSAreaoperasidetT']);die;
              if (isset($_POST['BSAreaoperasiT'])) {
                $modAreaOperasi = BSAreaoperasiT::model()->find(" rencanaoperasi_id = " . $dataTindakansa[$ii]->rencanaoperasi_id . "  AND pasienmasukpenunjang_id = " . $modPasienMasukPenunjang->pasienmasukpenunjang_id . " ");
                if (empty($modAreaOperasi)) {
                  $modAreaOperasi = new BSAreaoperasiT;
                  $modAreaOperasi->attributes = $_POST['BSAreaoperasiT'];
                  $modAreaOperasi->pendaftaran_id = $modPasienMasukPenunjang->pasienadmisi->pendaftaran_id;
                  $modAreaOperasi->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
                  $modAreaOperasi->pasien_id = $modPasienMasukPenunjang->pasien_id;
                  $modAreaOperasi->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
                  $modAreaOperasi->rencanaoperasi_id = $dataTindakansa[$ii]->rencanaoperasi_id;
                  $modAreaOperasi->kamarruangan_id = $modPasienMasukPenunjang->pasienadmisi->kamarruangan_id;
                  $modAreaOperasi->tgl_penandaanarea = date("Y-m-d H:i:s");
                  $modAreaOperasi->create_time = date("Y-m-d H:i:s");
                  $modAreaOperasi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                  $modAreaOperasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
                } else {
                  $modAreaOperasi->attributes = $_POST['BSAreaoperasiT'];
                  $modAreaOperasi->update_time = date("Y-m-d H:i:s");
                  $modAreaOperasi->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                }

                if ($modAreaOperasi->save()) {
                  $this->areaoperasisimpan = true;

                  if ($this->areaoperasisimpan) {
                    if (isset($_POST['BSAreaoperasidetT'])) {
                      //var_dump($_POST['BSAreaoperasidetT']);die;
                      foreach ($_POST['BSAreaoperasidetT'] as $iiii => $val) {
                        $modAreaOpDet = BSAreaoperasidetT::model()->findByAttributes(
                          array(
                            'areaoperasi_id' => $modAreaOperasi->areaoperasi_id,
                            'gambartubuh_id' => $val['gambartubuh_id'],
                            'bagiantubuh_id' => $val['bagiantubuh_id'],
                            'kordinat_tubuh_x' => $val['kordinat_tubuh_x'],
                            'kordinat_tubuh_y' => $val['kordinat_tubuh_y'],
                            'areaoperasidet_ket' => $val['areaoperasidet_ket'],
                          )
                        );

                        if (empty($modAreaOpDet)) {
                          $modAreaOpDet = new BSAreaoperasidetT();
                          $modAreaOpDet->attributes = $_POST['BSAreaoperasidetT'][$iiii];
                          $modAreaOpDet->areaoperasi_id = $modAreaOperasi->areaoperasi_id;

                          $this->areaoperasidetsimpan = $this->areaoperasidetsimpan && $modAreaOpDet->save();
                        } else {
                          //$modAreaOpDet = BSAreaoperasidetT::model()->findByPk($val['areaoperasidet_id']);
                          $modAreaOpDet->attributes = $_POST['BSAreaoperasidetT'][$iiii];

                          $this->areaoperasidetsimpan = $this->areaoperasidetsimpan && $modAreaOpDet->save();
                        }
                      }
                    }
                  }
                } else {
                  $this->areaoperasisimpan = false;
                }
              }
            }
          }
        } else {
          $this->rencanaoperasitersimpan = true;
        }

        // hapus tindakan operasi yang di-uncheck
   
        if (!empty($modPasienMasukPenunjang->pasienmasukpenunjang_id) && is_numeric($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
          
          $crDel = new CDbCriteria;
          $crDel->compare('pasienmasukpenunjang_id', $modPasienMasukPenunjang->pasienmasukpenunjang_id);
          $crDel->addNotInCondition('operasi_id', $operasi_ceklis);

          RencanaoperasiT::model()->deleteAll($crDel);
        }
        // var_dump($operasi_ceklis, $modPasienMasukPenunjang->pasienmasukpenunjang_id); die;


        $ruangan = RuanganM::model()->findByPk($modKunjungan->ruanganasal_id);


        $judul = 'Rencana Operasi'; //.$modKunjungan->no_rekam_medik.' - '.$modKunjungan->nama_pasien;

        $isi = $modKunjungan->no_pendaftaran . ' - ' . $modKunjungan->no_rekam_medik . ' - ' . $modKunjungan->nama_pasien;

        CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $modKunjungan->instalasiasal_id, 'ruangan_id' => $modKunjungan->ruanganasal_id, 'modul_id' => !empty($ruangan->modul_id) ? $ruangan->modul_id : null),
          array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState("ruangan_id"), 'modul_id' => Params::MODUL_ID_BEDAHSENTRAL),
        ));
        // var_dump($this->pasienpenunjangtersimpan , $this->rencanaoperasitersimpan , $this->pelaksanaoperasisimpan , $this->areaoperasisimpan  , $this->areaoperasidetsimpan);
        // die;
        if ($this->pasienpenunjangtersimpan && $this->rencanaoperasitersimpan && $this->pelaksanaoperasisimpan && $this->areaoperasisimpan  && $this->areaoperasidetsimpan) {


          // SMS GATEWAY

          $sms = new Sms();
          $smspasien = 1;
          $modPasien = PasienM::model()->findByPk($modKunjungan->pasien_id);
          $modKamarruangan = KamarruanganM::model()->findByPk($modRencanaOperasi->kamarruangan_id);
          $modRuangan = isset($modKamarruangan->ruangan) ? $modKamarruangan->ruangan : $modPasienMasukPenunjang->ruangan;
          $modKelaspelayanan = isset($modKamarruangan->kelaspelayanan) ? $modKamarruangan->kelaspelayanan : $modPasienMasukPenunjang->kelaspelayanan;


          foreach ($modSmsgateway as $i => $smsgateway) {

            $isiPesan = $smsgateway->templatesms;

            $attributes = $modRencanaOperasi->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            if ($modKamarruangan) {
              $attributes = $modKamarruangan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
            }
            $attributes = $modRuangan->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modKelaspelayanan->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }

            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modRencanaOperasi->tglrencanaoperasi), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }

          // echo '<pre>'; var_dump($_POST['BSRencanaOperasiT'], $modRencanaOperasi->attributes); die;
          // END SMS GATEWAY
          $transaction->commit();
          //					Yii::app()->user->setFlash('success',"Data berhasil disimpan");
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id, 'sukses' => 1, 'smspasien' => $smspasien));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        echo '<pre>'; var_dump($exc); die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);
    $modPasienMasukPenunjang->tglmasukpenunjang = $format->formatDateTimeForUser($modPasienMasukPenunjang->tglmasukpenunjang);

    $this->render('index', array(
      'modKunjungan' => $modKunjungan,
      'modPemeriksaanBedah' => $modPemeriksaanBedah,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modTindakan' => $modTindakan,
      'modGambarTubuh' => $modGambarTubuh,
      'dataTindakans' => $dataTindakans,
      'modRencanaOperasi' => $modRencanaOperasi,
      'modBagianTubuh' => $modBagianTubuh,
      'modAreaOperasi' => $modAreaOperasi,
      'modAreaDetOp' => $modAreaDetOp
    ));
  }

    /*
         * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
         * and open the template in the editor.
         */
        public function actionSetDropdownKamarRuangan($encode = false, $namaModel = '')
        {
          if (Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST["$namaModel"]['kamarruangan1_id'];
            // echo '<pre>'; var_dump($_POST); die;
            $kamarruangan = null;
            if ($ruangan_id) {
              $kamarruangan = KamarruanganM::model()->findAll('ruangan_id = ' . $ruangan_id . ' and kamarruangan_status = true and kamarruangan_aktif is true order by kamarruangan_id ASC');
              $kamarruangan = CHtml::listData($kamarruangan, 'kamarruangan_id', 'KamarDanTempatTidur');
            }
            if (empty($kamarruangan)) {
              echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
            } else {
              echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
              foreach ($kamarruangan as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
              }
            }
          }
          Yii::app()->end();
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

  public function savePasienPenunjang($attrPendaftaran, $penunjang, $modRencana)
  {
    $modPasienPenunjang = new BSPasienmasukpenunjangT;
    if (isset($_GET['pasienmasukpenunjang_id'])) {
      $modPasienPenunjang = BSPasienmasukpenunjangT::model()->findByPk($_GET['pasienmasukpenunjang_id']);
      $kelas_lama = $modPasienPenunjang->kelaspelayanan_id;
    }
    $modPasienPenunjang->attributes = $penunjang;
    $modPasienPenunjang->attributes = $attrPendaftaran->attributes;
    // $modPasienPenunjang->kelaspelayanan_id = $kelas_lama;

    $modPasienPenunjang->pasienkirimkeunitlain_id = $penunjang['pasienkirimkeunitlain_id'];
    $modPasienPenunjang->pasien_id = $attrPendaftaran->pasien_id;
    $modPasienPenunjang->jeniskasuspenyakit_id = $penunjang['jeniskasuspenyakit_id'];
    $modPasienPenunjang->pendaftaran_id = $attrPendaftaran->pendaftaran_id;
    $modPasienPenunjang->pegawai_id = $modRencana->dokterpelaksana1_id;
    $modPasienPenunjang->kelaspelayanan_id = $attrPendaftaran->kelaspelayanan_id;

    $modPasienPenunjang->ruangan_id = $penunjang['ruangan_id'];
    // $modPasienPenunjang->ppds_id = $attrPendaftaran->ppds_id;
    //$modPasienPenunjang->ppds_id = $penunjang['ppds_id']; 
    $modPasienPenunjang->ppds_id = $_POST['ppds_id'];
    $instalasi_id = $modPasienPenunjang->ruangan->instalasi_id;
    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    $modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
    $modPasienPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
    $modPasienPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienPenunjang->ruangan_id);
    $modPasienPenunjang->kunjungan = $attrPendaftaran->kunjungan;
    $modPasienPenunjang->statusperiksa = $attrPendaftaran->statusperiksa;
    $modPasienPenunjang->ruanganasal_id = $attrPendaftaran->ruangan_id;
    $modPasienPenunjang->create_time = date('Y-m-d H:i:s');
    $modPasienPenunjang->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modPasienPenunjang->validate()) {
      if ($modPasienPenunjang->save()) {

        $this->pasienpenunjangtersimpan = true;
      }
    } else {
      $this->pasienpenunjangtersimpan = false;
    }
    return $modPasienPenunjang;
  }

  // public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post)
  // {
  //   $modTindakan = new BSTindakanPelayananT;

  //   $modTindakan->attributes = $modPendaftaran->attributes;
  //   $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
  //   $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
  //   $modTindakan->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
  //   $modTindakan->attributes = $post;
  //   $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
  //   $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
  //   $modTindakan->qty_tindakan = (float)$modTindakan->qty_tindakan;
  //   $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
  //   if (!empty($modTindakan->karcis_id)) {
  //     $this->karcistersimpan = true;
  //     if (isset($post['harga_tariftindakan'])) { //jika dari form karcis
  //       if (!empty($post['harga_tariftindakan'])) {
  //         $modTindakan->tarif_satuan = $post['harga_tariftindakan'];
  //       }
  //     }
  //     $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
  //   }
  //   $modTindakan->tarif_satuan = is_numeric($modTindakan->tarif_satuan) ? $modTindakan->tarif_satuan : MyFormatter::formatRupiahForDB($modTindakan->tarif_satuan);
  //   $modTindakan->create_time = date("Y-m-d H:i:s");
  //   $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
  //   $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
  //   $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
  //   $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
  //   $modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
  //   $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
  //   $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
  //   // $modTindakan->cyto_tindakan = 0;
  //   // $modTindakan->tarifcyto_tindakan = 0;
  //   $modTindakan->discount_tindakan = 0;
  //   $modTindakan->subsidiasuransi_tindakan = 0;
  //   $modTindakan->subsidipemerintah_tindakan = 0;
  //   $modTindakan->subsisidirumahsakit_tindakan = 0;
  //   $modTindakan->iurbiaya_tindakan = 0;
  //   $modTindakan->tarif_rsakomodasi = 0;
  //   $modTindakan->tarif_medis = 0;
  //   $modTindakan->tarif_paramedis = 0;
  //   $modTindakan->tarif_bhp = 0;
  //   $kirim = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
  //   $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modPasienMasukPenunjang->pasienkirimkeunitlain->kelaspelayanan_id,
  //                                                                       'daftartindakan_id'=>$modTindakan->daftartindakan_id,
  //                                                                       'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
  //   $modTindakan->tarifcyto_tindakan = $modTarif->totaltarifakhir_cyto;
  //   $modTindakan->cyto_tindakan = $kirim->is_cyto;

  //   if ($modTindakan->validate()) {
  //     if ($modTindakan->save()) {
  //       $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
  //     }
  //   } else {
  //     $this->tindakanpelayanantersimpan &= false;
  //   }

  //   return $modTindakan;
  // }
  public function saveRencanaOperasi($pendaftaran, $penunjang, $rencanaOperasi, $rencana)
  {

    //array('pasienmasukpenunjang_id,pendaftaran_id,pasien_id,tglrencanaoperasi,norencanaoperasi,dokterpelaksana1_id','required'),
			
    $modRencana = new BSRencanaOperasiT;
    $modRencana->attributes = $rencanaOperasi->attributes;
    $modRencana->paramedis_id = $rencanaOperasi->paramedis_id;
    $modRencana->norencanaoperasi = $rencanaOperasi['norencanaoperasi'];
    $modRencana->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
    $modRencana->pendaftaran_id = $pendaftaran->pendaftaran_id;
    $modRencana->tglrencanaoperasi = date('Y-m-d H:i:s');
    
    $modRencana->pasien_id = $pendaftaran->pasien_id;
    $modRencana->pasienadmisi_id = (!empty($pendaftaran->pasienadmisi_id)) ? $pendaftaran->pasienadmisi_id : null;
    $modRencana->ppds_id = (!empty($modRencana->ppds_id)) ? $modRencana->ppds_id : null;
    $modRencana->kamarruangan_id = (!empty($modRencana->kamarruangan_id)) ? $modRencana->kamarruangan_id : null;
    $modRencana->dokterpelaksana2_id = (!empty($modRencana->dokterpelaksana2_id)) ? $modRencana->dokterpelaksana2_id : null;
    $modRencana->dokterpelaksana1_id = (!empty($modRencana->dokterpelaksana1_id)) ? $modRencana->dokterpelaksana1_id : null;

    $modRencana->paramedis_id = !empty($modRencana->paramedis_id) ? $modRencana->paramedis_id : null;
    $modRencana->tindakanpelayanan_id = !empty($modRencana->tindakanpelayanan_id) ? $modRencana->tindakanpelayanan_id : null;
    $modRencana->suster_id = !empty($modRencana->suster_id) ? $modRencana->suster_id : null;
    $modRencana->bidan_id = !empty($modRencana->bidan_id) ? $modRencana->bidan_id : null;
    $modRencana->perawatsirkuler_id = !empty($modRencana->perawatsirkuler_id) ? $modRencana->perawatsirkuler_id : null;
    $modRencana->keterangan_rencana = $modRencana->keterangan_rencana;
    $modRencana->statusoperasi = Params::STATUSOPERASI_RENCANA;
    // $modRencana->krubedah = $modRencana->krubedah;
    

    $modRencana->dokteranastesi_id = (!empty($modRencana->dokteranastesi_id)) ? $modRencana->dokteranastesi_id : null;
    $modRencana->selesaioperasi = $modRencana->tglrencanaoperasi; //sementara di set sama dl, nanti pas proses fix operasi baru di update lg
    $modRencana->mulaioperasi = $modRencana->tglrencanaoperasi; //sementara di set sama dl, nanti pas proses fix operasi baru di update lg
    $modRencana->operasi_id = $rencana['operasi_id'];
    $kirim = PasienkirimkeunitlainT::model()->findByPk($penunjang->pasienkirimkeunitlain_id);
    // $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$penunjang->pasienkirimkeunitlain->kelaspelayanan_id,
    //                                                                     'daftartindakan_id'=>$modRencana->daftartindakan_id,
    //                                                                     'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));

    $modRencana->jam_mulai = !empty($_POST['BSRencanaOperasiT']['jam_mulai']) ? $_POST['BSRencanaOperasiT']['jam_mulai'] : null;
    $modRencana->jam_selesai = !empty($_POST['BSRencanaOperasiT']['jam_selesai']) ? $_POST['BSRencanaOperasiT']['jam_selesai'] : null;
    // $modRencana->tarifcyto_tindakan = $modTarif->totaltarifakhir_cyto;
    $modRencana->is_cyto = $kirim->is_cyto;
    // $modRencana->is_cyto = (($rencana['cyto_tindakan'] == 1) ? TRUE : FALSE);
    $modRencana->create_time = date('Y-m-d H:i:s');
    $modRencana->create_loginpemakai_id = Yii::app()->user->id;
    $modRencana->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if (isset($rencana['pegmengetahui_id'])) {
      $modRencana->pegmengetahui_id = $rencana['pegmengetahui_id'];
    }

    if ($modRencana->validate()) {
      if ($modRencana->save()) {
        $updateKamarRuangan = KamarruanganM::model()->updateByPk($modRencana->kamarruangan_id, ['kamarruangan_status' => false, 'keterangan_kamar' => 'IN USE']);
        if($updateKamarRuangan) {
          $this->rencanaoperasitersimpan = true;
        } else {
          $this->rencanaoperasitersimpan = false;
        }
      }
    } else {
      $this->rencanaoperasitersimpan = false;
    }
    
    // var_dump($rencana, $modRencana->attributes, $rencanaOperasi->attributes); 
    return $modRencana;
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
      $models = BSInfokunjunganrjrdriV::model()->findAll($criteria);
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
      $model = BSInfokunjunganrjrdriV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));
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
      $postPemeriksaan = $post['BSTarifoperasiruanganV'];

      if (!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
        $criteria = new CdbCriteria();
        $criteria->addCondition('ruangan_id = ' . $postPemeriksaan['ruangan_id']);
        $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
        $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        $criteria->compare('LOWER(kegiatanoperasi_nama)', strtolower($postPemeriksaan['kegiatanoperasi_nama']), true);
        $criteria->compare('LOWER(operasi_nama)', strtolower($postPemeriksaan['operasi_nama']), true);
        $criteria->order = "kegiatanoperasi_nama, operasi_nama";
        $modPemeriksaanBedahs = BSTarifoperasiruanganV::model()->findAll($criteria);

        $kegiatanoperasi = KegiatanOperasiM::model()->findAll("kegiatanoperasi_aktif = true");
        $content = $this->renderPartial('_checklistPemeriksaanBedah', array('modPemeriksaanBedahs' => $modPemeriksaanBedahs, 'disabled' => $disabled, 'kegiatanoperasi' => $kegiatanoperasi), true);
      }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }

  public function actionSetPermintaanKePenunjang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modPermintaans = BSPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));
     
      if (count((array)$modPermintaans) > 0) {
        foreach ($modPermintaans as $i => $modPermintaan) {
          $modPemeriksaan = OperasiM::model()->findByAttributes(array('operasi_id' => $modPermintaan->operasi_id));
          if (isset($modPemeriksaan->daftartindakan_id)) {
            $modPermintaan->daftartindakan_id = $modPemeriksaan->daftartindakan_id;
            $rows .= $this->renderPartial($this->path_view . "_rowPermintaanKePenunjang", array('i' => $i, 'modPermintaan' => $modPermintaan), true);
          }
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  public function actionSetRencanaTindakanOperasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modRencanaOperasis = BSRencanaOperasiT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']));
      if (count((array)$modRencanaOperasis) > 0) {
        foreach ($modRencanaOperasis as $i => $modRencanaOperasi) {
          $criteria = null;
          $criteria = new CdbCriteria();
          $criteria->addCondition('kelaspelayanan_id = ' . $modRencanaOperasi->pasienmasukpenunjang->kelaspelayanan_id);
          $criteria->addCondition('penjamin_id = ' . $modRencanaOperasi->pendaftaran->penjamin_id);
          $criteria->addCondition('operasi_id = ' . $modRencanaOperasi->operasi_id);
          $modPemeriksaanBedahs = BSTarifoperasiruanganV::model()->find($criteria);
          $modTarifTindakan = BSTariftindakanM::model()->findByAttributes(array('daftartindakan_id' => $modRencanaOperasi->operasi->daftartindakan_id));
          $modRencanaOperasi->operasi_id = $modRencanaOperasi->operasi_id;
          $modRencanaOperasi->daftartindakan_id = $modRencanaOperasi->operasi->daftartindakan_id;
          $modRencanaOperasi->operasi_nama = $modRencanaOperasi->operasi->operasi_nama;
          $modRencanaOperasi->ppds_id = $modRencanaOperasi->ppds->ppds_id ?? '';
          $modRencanaOperasi->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modRencanaOperasi->pendaftaran->penjamin_id))->jenistarif_id;
          $modRencanaOperasi->tarif_satuan = $format->formatNumberForUser(isset($modPemeriksaanBedahs) ? $modPemeriksaanBedahs->hargaoperasi : 0);
          $modRencanaOperasi->tarif_tindakan = $format->formatNumberForUser(isset($modPemeriksaanBedahs) ? $modPemeriksaanBedahs->hargaoperasi : 0);
          $modRencanaOperasi->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;;
          $modRencanaOperasi->qty_tindakan = 1;
          $modRencanaOperasi->cyto_tindakan = (($modRencanaOperasi->is_cyto == TRUE) ? 1 : 0);
          $modRencanaOperasi->persencyto_tind = $modTarifTindakan->persencyto_tind;
          $modRencanaOperasi->tarif_cyto = (($modRencanaOperasi->is_cyto == TRUE) ? (isset($modPemeriksaanBedahs) ? $modPemeriksaanBedahs->hargaoperasi + ($modPemeriksaanBedahs->hargaoperasi  * ($modTarifTindakan->persencyto_tind / 100)) : 0) : 0);
          $modRencanaOperasi->tarif_cyto = $format->formatNumberForUser($modRencanaOperasi->tarif_cyto);
          $rows .= $this->renderPartial("_rowTindakanPemeriksaan", array('i' => 0, 'modRencanaOperasi' => $modRencanaOperasi), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * menambah asal rujukan dari tombol "+" / Dialogbox
   */
  public function actionAddKruBedah()
  {

    if (Yii::app()->request->isAjaxRequest) {
      $id = isset($_POST['id']) ? $_POST['id'] : null;
      $lookup = isset($_POST['lookup']) ? $_POST['lookup'] : null;
      $length = isset($_POST['length']) ? $_POST['length'] : null;
      $sukses = 0;

      $peg = PegawaiM::model()->findByPk($id);

      if (!empty($peg)) {
        $sukses = 1;
      }
      $model = new BSPelaksanaoperasiT();
      $model->pegawai_id = $peg->pegawai_id;
      $model->pegawai_nama = $peg->namaLengkap;
      $model->krubedah = $lookup;

      echo CJSON::encode(array(
        'sukses' => $sukses,
        'look' => ucwords(strtolower($lookup)),
        'lookup' => str_replace(' ', '-', strtolower($lookup)),
        'id' => $id,
        'div' => $this->renderPartial($this->path_view . '_rowKruBedah', array('length' => $length, 'model' => $model, 'i' => 0), true)
      ));
      Yii::app()->end();
    }
  }

  /**
   * membatalkan pegawai kru bedah
   */
  public function actionBatalKruBedah()
  {

    if (Yii::app()->request->isAjaxRequest) {
      $id = isset($_POST['id']) ? $_POST['id'] : null;
      $lookup = isset($_POST['lookup']) ? $_POST['lookup'] : null;
      $sukses = 0;
      $pesan = '';

      $peg = BSPelaksanaoperasiT::model()->findByPk($id);

      if (!empty($peg)) {

        $batalKruBedah = new BatalpelaksanaoperasiT();
        $batalKruBedah->pelaksanaoperasi_id = $peg->pelaksanaoperasi_id;
        $batalKruBedah->rencanaoperasi_id = $peg->rencanaoperasi_id;
        $batalKruBedah->create_time = date('Y-m-d H:i:s');
        $batalKruBedah->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $batalKruBedah->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $batalKruBedah->pegpembatal_id = Yii::app()->user->getState('pegawai_id');

        if ($batalKruBedah->save()) {
          $peg->batalpelaksanaoperasi_id = $batalKruBedah->batalpelaksanaoperasi_id;

          if ($peg->save()) {
            $sukses = 1;
            $pesan = "Data Sukses Dibatalkan !";
          } else {
            $pesan = "Data Gagal Dibatalkan !";
          }
        } else {
          $pesan = "Data Gagal Dibatalkan !";
        }
      } else {
        $pesan = "Data Tidak Ditemukan !";
      }


      echo CJSON::encode(array(
        'sukses' => $sukses,
        'pesan' => $pesan,
      ));
      Yii::app()->end();
    }
  }

  /**
   * menambahkan lookup kru bedah
   */
  public function actionAddLookupKruBedah()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $krubedah = isset($_POST['krubedah']) ? $_POST['krubedah'] : null;
      $sukses = 0;
      $pesan = '';

      $cri = new CDbCriteria();
      $cri->addCondition(" lookup_type = '" . Params::LOOKUPTYPE_KRU_BEDAH . "' ");
      $cri->addCondition(" lookup_value ilike '" . strtolower($krubedah) . "' ");
      $look = LookupM::model()->findAll($cri);

      if (!empty($look)) {
        $pesan = "Data Kru Bedah sudah ada !";
      } else {
        $look = new LookupM;
        $look->lookup_type = Params::LOOKUPTYPE_KRU_BEDAH;
        $look->lookup_name = $krubedah;
        $look->lookup_value = strtoupper($krubedah);
        $look->lookup_aktif = true;
        $look->lookup_urutan = $look->getNoUrutan(Params::LOOKUPTYPE_KRU_BEDAH);
        $look->create_time = date('Y-m-d H:i:s');
        $look->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $look->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($look->save()) {
          $sukses = 1;
          $pesan = "Data Kru Bedah baru berhasil disimpan !";
        } else {
          $pesan = "Data gagal disimpan !";
        }
      }

      $drop = LookupM::model()->getDropUrutan(Params::LOOKUPTYPE_KRU_BEDAH);

      echo CJSON::encode(array(
        'sukses' => $sukses,
        'pesan' => $pesan,
        'drop' => $drop,
        'look' => $krubedah
      ));
      Yii::app()->end();
    }
  }

  public function actionTambahBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $form = '';
      if (!empty($_POST['bagiantubuh_id'])) {
        $modPemeriksaanGbr = new BSAreaoperasidetT();
        $modPemeriksaanGbr->bagiantubuh_id      = $_POST['bagiantubuh_id'];
        $modPemeriksaanGbr->namabagtubuh      =  $_POST['namabagtubuh'];
        $modPemeriksaanGbr->areaoperasidet_ket    = $_POST['keterangan'];
        $modPemeriksaanGbr->kordinat_tubuh_x    = $_POST['pic_x'];
        $modPemeriksaanGbr->kordinat_tubuh_y    = $_POST['pic_y'];
        $modPemeriksaanGbr->gambartubuh_id          = $_POST['gambartubuh_id'];
        $form = $this->renderPartial($this->path_view . '_rowDetail', array('modPemeriksaanGbr' => $modPemeriksaanGbr), true);
        $axis['x'] = $modPemeriksaanGbr->kordinat_tubuh_x;
        $axis['y'] = $modPemeriksaanGbr->kordinat_tubuh_y;
        echo CJSON::encode(array('pesan' => $pesan, 'form' => $form, 'axis' => $axis, 'bagiantubuh_id' => $modPemeriksaanGbr->bagiantubuh_id));
      } else {
        $pesan = 'Bagian tubuh tidak boleh kosong!';
        echo CJSON::encode(array('pesan' => $pesan));
      }
    }
    Yii::app()->end();
  }


  public function actionHapusBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $ok = 0;
      $del = true;
      $areaOp = BSAreaoperasiT::model()->findAll(" pasienmasukpenunjang_id = " . $_POST['pasienmasukpenunjang_id'] . " ");
      //var_dump(count((array)$areaOp));die;
      foreach ($areaOp as $ar) {
        $det = BSAreaoperasidetT::model()->findAll(" areaoperasi_id = " . $ar->areaoperasi_id . " ");

        foreach ($det as $cek) {
          $ok = BSAreaoperasidetT::model()->findByAttributes(
            array(
              'areaoperasi_id' => $cek->areaoperasi_id,
              'gambartubuh_id' => $_POST['gambartubuh_id'],
              'bagiantubuh_id' => $_POST['bagiantubuh_id'],
              'kordinat_tubuh_x' => $_POST['kordinat_tubuh_x'],
              'kordinat_tubuh_y' => $_POST['kordinat_tubuh_y'],
              'areaoperasidet_ket' => $_POST['areaoperasidet_ket'],
            )
          );

          if (!empty($ok)) {
            $del = $del && $ok->delete();
          }
        }
      }

      if ($del) {
        $pesan = 'Data Berhasil Dihapus dari database';
        $ok = 1;
        echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
      } else {
        $ok = 0;
        $pesan = "Bagian Tubuh gagal dihapus!";
        echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
      }
    }
    Yii::app()->end();
  }

  function actionSetPPDS() {
    $type = $_POST['type'];
    
    $option = '<option> -- Pilih -- </option>';
    if($type == 'PPDS') {
      $modPPDS = PpdsM::model()->findAll(['condition' => 'ppds_aktif is true', 'order' => 'ppds_nama ASC']);
      
      if(!empty($modPPDS)) {
        foreach ($modPPDS as $i => $value) {
          $option .= "<option value='" . $value->ppds_id ."'> " . $value->ppds_nama . " </option>";
        }
      }
    } else {
      $modPegawai = PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Params::RUANGAN_ID_BEDAH, 'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK), array(
        'order'=>'nama_pegawai',
      ));
      if(!empty($modPegawai)) {
        foreach ($modPegawai as $i => $value) {
          $option .= "<option value='" . $value->pegawai_id ."'> " . $value->namaLengkap . " </option>";
        }
      }
    }

    echo json_encode(['option' => $option]);
  }
  function actionSet() {
    
  }
}
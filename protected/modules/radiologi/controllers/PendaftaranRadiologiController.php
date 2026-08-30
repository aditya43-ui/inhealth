<?php
Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('pendaftaranPenjadwalan.views.pendaftaranRawatJalan');
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalanController');
class PendaftaranRadiologiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'radiologi.views.pendaftaranRadiologi.';
  public $path_viewPPRJ = 'pendaftaranPenjadwalan.views.pendaftaranRawatJalan.';

  public $pasientersimpan = false;
  public $pendaftarantersimpan = false;
  public $penanggungjawabtersimpan = false;
  public $tindakanpelayanantersimpan = true; //dilooping / boleh tanpa ini
  public $karcistersimpan = true; //dilooping / boleh tanpa ini
  public $komponentindakantersimpan = true; //di looping
  public $rujukantersimpan = false;
  public $pengambilansampletersimpan = true; //dilooping / boleh tanpa ini
  public $pasienpenunjangtersimpan = true; //dilooping
  public $hasilpemeriksaantersimpan = true; //dilooping
  public $asuransipasientersimpan = false;
  public $hasilrad = true;

  public $is_pasien_baru = false;


  /**
   * Index transaksi pendaftaran
   */


  public function postDataPasien($modPasienMasukPenunjang){

    if (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)) {
      $modRes = RadorderlistV::model()->findByAttributes(array(
        'orderlabsimrs_id'=>$modPasienMasukPenunjang->pasienkirimkeunitlain_id,
        'is_kirim'=>true,
      ));
    } else {
      $modRes = RadorderlistV::model()->findByAttributes(array(
        'orderlabsimrs_id'=>$modPasienMasukPenunjang->pasienmasukpenunjang_id,
        'is_kirim'=>false,
      ));
    }

    // var_dump($modRes->attributes);
    
    $modDaftar = PendaftaranT::model()->findByPk($modPasienMasukPenunjang->pendaftaran_id);
    $modHasilpemeriksaan_all = HasilpemeriksaanradT::model()->findAllByAttributes(array(
      'pasienmasukpenunjang_id'=> $modPasienMasukPenunjang->pasienmasukpenunjang_id
    ));
    
    
    foreach ($modHasilpemeriksaan_all as $modHasilPemeriksaan) {

      $modPeriksa = PemeriksaanradM::model()->findByPk($modHasilPemeriksaan->pemeriksaanrad_id);
      $modRO= ROReferensihasildetM::model()->findByPk($modHasilPemeriksaan->pemeriksaanrad_id);
      $modListOrder = new ListAllOrder();
  
  
      // $persons = [];
      
      // // Load the post data into an array of Person models
      // if(isset($_POST['requestid'])) {
      //     $persons = Person::saveMultiple($_POST['Person']);
      // }
  
      // var_dump($modListOrder->getData()); die;
      $dataListOrder = CJSON::decode($modListOrder->getData());
      // var_dump($dataListOrder); die;
      $totalArray = $modListOrder->getData() ? count($dataListOrder) - 1 : 0;
  
      if($modHasilPemeriksaan->pemeriksaanrad_id) {
        $dikom = count((array)$modHasilPemeriksaan->pemeriksaanrad->kode_dicom_modality);
      } else {
        $dikom = 0;
      }
      // var_dump($totalArray,$dataListOrder[$totalArray]);die;
      // var_dump ($modRad); die;
      $dataRad = array();
  
      $dataRad['nama'] = $modDaftar->pasien->nama_pasien;
      $dataRad['noregister'] = $modDaftar->pasien->no_rekam_medik;
      $dataRad['jk'] = $modRes->jk ;
      $dataRad['tgllahir'] = date('d-m-Y', strtotime($modRes->tgllahir));
      $dataRad['telpon'] = $modDaftar->pasien->no_telepon_pasien;
      $dataRad['alamat'] = $modDaftar->pasien->alamat_pasien ;
      $dataRad['kota'] = $modDaftar->pasien->kabupaten->kabupaten_nama ;
      $dataRad['beratbadan'] = "10";
      $dataRad['asalpasien'] = $modDaftar->ruangan->ruangan_nama;
      $dataRad['namarspengirim'] = "RSSA MALANG";
      $dataRad['dokterpengirim'] = $modDaftar->pegawai->namaLengkap;
      $dataRad['asuransi'] = $modDaftar->carabayar->carabayar_nama;
      $dataRad['urgensi'] = "CITO";
      
      // var_dump($modHasilpemeriksaan->pemeriksaanrad_id); die;
      $dataRad['requestid'] = "[".count((array)$dikom)."]" ?? "[9]";
      $dataRad['diagnosis'] = !empty($modHasilPemeriksaan->pemeriksaanrad_id) ? $modHasilPemeriksaan->pemeriksaanrad->pemeriksaanrad_nama : '';
  
  
      // var_dump($dataRad); 
      // die;
  
      $dataPasien = CJSON::decode($modListOrder->postData($dataRad));
      // var_dump($dataPasien); die;
      $pesan = $dataPasien['message'] ?? null;
      $status = $dataPasien['status'] ?? null;
  
      if ($status == "Sukses") {
        $pesan = trim($pesan);
        $pesan = str_replace("<br />", "", $pesan);
        $pesan = str_replace("Nomor Foto ", "", $pesan);
  
        $arr_pesan = explode(" dan No. Urut ", $pesan);

        $modHasilPemeriksaan->statuskirimhasil_ris = $status;
        $modHasilPemeriksaan->no_urut_ris = $arr_pesan[1];
        $modHasilPemeriksaan->no_urutfoto_ris = $arr_pesan[0];
        $ok = $modHasilPemeriksaan->save(false, array('statuskirimhasil_ris', 'no_urut_ris', 'no_urutfoto_ris'));


      } else {

        $modHasilPemeriksaan->statuskirimhasil_ris = $status;
        $modHasilPemeriksaan->save(false, array('statuskirimhasil_ris'));
      }

      // var_dump($modHasilPemeriksaan->attributes);

    }


 
   
  }



  public function actionIndex($id = null)
  {
    $format = new MyFormatter();
    $model = new ROPendaftaranT;
    $model->pendaftaran_id = null; //new record
    $modPasien = new ROPasienM;
    $modPegawai = new PPPegawaiM;
    $modPegawaiPJ = new PPPegawaiM;
    $modAntrian = new PPAntrianT;
    $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
    $modAsuransiPasienDepartemen = new PPAsuransipasiendepartemenM();
    $modAsuransiPasienPekerja = new PPAsuransipasienpegawaiM();
    $modPenanggungJawab = new ROPenanggungJawabM;
    $modPasienMasukPenunjang = new ROPasienmasukpenunjangT;
    $modPasienMasukPenunjang->ruangan_id = Params::RUANGAN_ID_RAD;
    $modPasienMasukPenunjang->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $modPemeriksaanRad = new ROTarifpemeriksaanradruanganV;
    $modRujukan = new RORujukanT;
    $modTindakan = new ROTindakanpelayananT;
    $modHasilPemeriksaan = new ROHasilpemeriksaanradT;
    $modAsuransiPasien = new ROAsuransipasienM;
    $dataTindakans = array();
    $modKarcis = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->agama = Params::DEFAULT_AGAMA;

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


    //==load data
    if (!empty($idAntrian)) {
      $modAntrian = PPAntrianT::model()->findByPk($idAntrian, array(
        'condition' => 'pendaftaran_id is null',
      ));
      if (empty($modAntrian)) {
        $modAntrian = new PPAntrianT;
      } else {
        $model->antrian_id = $modAntrian->antrian_id;
      }
    }
    if (isset($id)) {
      $model = $this->loadModel($id);
      $modPasien = ROPasienM::model()->findByPk($model->pasien_id);
      $criteria = new CdbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $model->pendaftaran_id);
      $criteria->order = "pendaftaran_id DESC, pasienmasukpenunjang_id ASC";
      $criteria->limit = 2;
      $criteria1 = $criteria;
      $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_RAD);
      $loadPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->find($criteria1);
      if (isset($loadPasienMasukPenunjang)) {
        $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
        $modPasienMasukPenunjang->is_adakarcis = 1;
      }

      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = ROPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
        $modPenanggungJawab->tgllahir_pj = MyFormatter::formatDateTimeForUser($modPenanggungJawab->tgllahir_pj);
        if (!empty($modPenanggungJawab->pegawai_id)) {
          $modPasien->pegawai_penanggungjawab_id = $modPenanggungJawab->pegawai_id;
          $modPegawaiPJ = ROPegawaiM::model()->findByPk($modPenanggungJawab->pegawai_id);
        }
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = RORujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataKarcis = ROTindakanpelayananT::model()->findByAttributes(array('ruangan_id' => Params::RUANGAN_ID_RAD, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      if (isset($dataKarcis->karcis_id)) {
        $modKarcis[0] =  ROKarcisV::model()->findByAttributes(array('karcis_id' => $dataKarcis->karcis_id));
        $modKarcis[0]->harga_tariftindakan = $dataKarcis->tarif_tindakan;
      }

      $dataTindakans = ROTindakanpelayananT::model()->findAllByAttributes(array('ruangan_id' => Params::RUANGAN_ID_RAD, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is null");
    }

    /*
    if(isset($_GET['sukses'])){
      
      $this->postDataPasien($_GET['id']);
    }
    */

    if (isset($_POST['ROPendaftaranT'])) {

  
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasien = $this->simpanPasien($modPasien, $_POST['ROPasienM']);

        if ($_POST['ROPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['ROPenanggungJawabM'])) {
            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['ROPenanggungJawabM']);
          }
        } else {
          $this->penanggungjawabtersimpan = true;
        }

        if (isset($_POST['ROPasienM']['pegawai_penanggungjawab_id'])) {
          $modPenanggungJawab = $this->simpanPenanggungjawabDokter($modPenanggungJawab, $_POST['ROPasienM']['pegawai_penanggungjawab_id']);
        }



        if ($_POST['ROPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['RORujukanT'])) {
            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['RORujukanT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        if (isset($_POST['ROAsuransipasienM'])) {
          if (isset($_POST['ROAsuransipasienM']['asuransipasien_id'])) {
            if (!empty($_POST['ROAsuransipasienM']['asuransipasien_id'])) {
              $modAsuransiPasien = ROAsuransipasienM::model()->findByPk($_POST['ROAsuransipasienM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['ROPendaftaranT'], $modPasien, $_POST['ROAsuransipasienM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['ROPendaftaranT'], $_POST['ROPasienM'], $_POST['ROPasienmasukpenunjangT'], $modAsuransiPasien);

        $postPenunjang = $_POST['ROPasienmasukpenunjangT'];
        $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, $postPenunjang);

        if (isset($_POST['ROTindakanpelayananT'])) {
          if (count((array)$_POST['ROTindakanpelayananT']) > 0) {

            $ruangan_id = Yii::app()->user->getState('ruangan_id');

            $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $model->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

            if(!empty($md_noawal)) {
              $noawal = intval($md_noawal->nopelayanan);
            } else {
              $noawal = 1;
            }
          
            foreach ($_POST['ROTindakanpelayananT'] as $ii => $tindakan) {
              $dataTindakans[$ii] = $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjang, $tindakan, $noawal);
              $dataTindakans[$ii]->pemeriksaanrad_id = $tindakan['pemeriksaanrad_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $modHasilPemeriksaan = $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
              $dataTindakans[$ii]->tarif_tindakan = is_numeric($tindakan['tarif_tindakan']) ? $format->formatNumberForUser($tindakan['tarif_tindakan']) : $tindakan['tarif_tindakan'];
            }
          }
        }


        if ($postPenunjang['is_adakarcis']) {
          if (isset($_POST['ROKarcisV'])) {
            if (count((array)$_POST['ROKarcisV']) > 0) {
              foreach ($_POST['ROKarcisV'] as $ii => $karcis) {
                if ($karcis['is_pilihkarcis']) {
                  $modKarcis[$ii] = new ROKarcisV;
                  $modKarcis[$ii]->attributes = $karcis;
                  $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjang, $karcis);
                }
              }
            }
          }
        }



        if (isset($_POST['scan'])) {
          $this->simpanScanPasien($model, $_POST['scan']);
        }


        if (isset($_POST['PPAsuransipasienbadakM'])) {
          if (isset($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])) {
              $modAsuransiPasienBadak = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbadakM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBadak = $this->simpanAsuransiPasien($modAsuransiPasienBadak, $_POST['ROPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbadakM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasiendepartemenM'])) {
          if (isset($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])) {
              $modAsuransiPasienDepartemen = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienDepartemen = $this->simpanAsuransiPasien($modAsuransiPasienDepartemen, $_POST['ROPendaftaranT'], $modPasien, $_POST['PPAsuransipasiendepartemenM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienpegawaiM'])) {
          if (isset($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])) {
              $modAsuransiPasienPekerja = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienPekerja = $this->simpanAsuransiPasien($modAsuransiPasienPekerja, $_POST['ROPendaftaranT'], $modPasien, $_POST['PPAsuransipasienpegawaiM']);
        } else {
          $this->asuransipasientersimpan = true;
        }
        
        $ok_vaksinasi = true;
                    
        if ($_POST['ROPendaftaranT']['is_vaksinasi'] && isset($_POST['RiwayatvaksinasipasienT']['detail'])) {
            $ok_vaksinasi = RiwayatvaksinasipasienT::simpanRiwayat($model->pendaftaran_id, $model->pasien_id, $_POST['RiwayatvaksinasipasienT']['detail']);
        }
        
                    
        

        //                    var_dump($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->tindakanpelayanantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->pasienpenunjangtersimpan && $this->hasilpemeriksaantersimpan && $this->pengambilansampletersimpan && $this->asuransipasientersimpan);

        if (!empty($modPasienMasukPenunjang) && !empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
          // $this->pasienpenunjangtersimpan = $this->pasienpenunjangtersimpan && $this->tambahPasienHL7($modPasienMasukPenunjang);
          // $this->tambahPasienHL7($modPasienMasukPenunjang);
        }

        // var_dump($modPasien->save(), $modPasien->getErrors(), $modPasien->no_telepon_pasien); die;


        // var_dump($ok_vaksinasi, $this->pasientersimpan , $this->pendaftarantersimpan , $this->penanggungjawabtersimpan , $this->rujukantersimpan , $this->tindakanpelayanantersimpan , $this->karcistersimpan , $this->komponentindakantersimpan , $this->pasienpenunjangtersimpan , $this->hasilpemeriksaantersimpan , $this->pengambilansampletersimpan , $this->asuransipasientersimpan); die;
        if ($ok_vaksinasi && $this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->tindakanpelayanantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->pasienpenunjangtersimpan && $this->hasilpemeriksaantersimpan && $this->pengambilansampletersimpan && $this->asuransipasientersimpan) {

          $this->broadcastNotifDaftarRad($model, $modPasien);

          if ($this->is_pasien_baru) {
            $this->cleanUpSessionPasienSudahBaca($model->pendaftaran_id);
          }

          //Di set di form >> Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
          //                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
          $smspasien = 1;
          $smsdokter = 1;
          $smspenanggungjawab = 1;

          if (Yii::app()->user->getState('issmsgateway')) {
            // SMS GATEWAY
            $modPegawai = $model->pegawai;
            $modRuangan = $model->ruangan;
            $sms = new Sms();
            $smspasien = 1;
            $smsdokter = 1;
            $smspenanggungjawab = 1;

            $model->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran);
            $model->no_urutantri = $model->ruangan->ruangan_singkatan . "-" . $model->no_urutantri;

            $modPegawai->nama_pegawai = $modPegawai->namaLengkap;



            foreach ($modSmsgateway as $i => $smsgateway) {

              if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
                $isiPesan = $smsgateway->templatesms;
                $isiPesan = "${isiPesan}";

                $attributes = $modPasien->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modPenanggungJawab->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modPegawai->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modRuangan->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modPasienMasukPenunjang->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }

                $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tgl_pendaftaran), $isiPesan);
                $isiPesan = str_replace("{{no_urut}}", $model->no_urutantri, $isiPesan);
                $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);
                $isiPesan = str_replace("\\n", hex2bin("0a"), $isiPesan);


                if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                  if (!empty($modPasien->no_mobile_pasien)) {
                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                  } else {
                    $smspasien = 0;
                  }
                } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
                  if (!empty($modPegawai->nomobile_pegawai)) {
                    $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
                  } else {
                    $smsdokter = 0;
                  }
                } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_PENANGGUNGJAWAB && $smsgateway->statussms) {
                  if (!empty($modPenanggungJawab->no_mobilepj)) {
                    $sms->kirim($modPenanggungJawab->no_mobilepj, $isiPesan);
                  } else {
                    $smspenanggungjawab = 0;
                  }
                }
              }
            }
          }



            if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] == 1) {
                $this->kirimWhatsApp($model, $modPasien);
            }
            $this->postDataPasien($modPasienMasukPenunjang);
   //         var_dump($model->attributes); die;
            // die;

          $transaction->commit();

          // Yii::app()->user->setFlash('success', "Data pendaftaran berhasil disimpan !");
          $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1));
        } else {

          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !");
          //                        echo "-".$this->pasientersimpan."<br>";
          //                        echo "-".$this->pendaftarantersimpan."<br>";
          //                        echo "-".$this->penanggungjawabtersimpan."<br>";
          //                        echo "-".$this->rujukantersimpan."<br>";
          //                        echo "-".$this->karcistersimpan."<br>";
          //                        echo "-".$this->tindakanpelayanantersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
          //                        echo "-".$this->pengambilansampletersimpan."<br>";
          //                        exit;
        }
      } catch (Exception $exc) {

        echo '<pre>'; var_dump($exc); die;

        $transaction->rollback();
        // var_dump($exc->getMessage(), $exc->getTrace()); die;
        Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }



    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modPegawaiPJ' => $modPegawaiPJ,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPemeriksaanRad' => $modPemeriksaanRad,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modRujukan' => $modRujukan,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
      'modKarcis' => $modKarcis,
      'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
      'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
      'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
      'modSmsgateway' => $modSmsgateway,
      'modAntrian' => $modAntrian,
    ));
  }
  
        public function kirimWhatsApp($model, $modPasien) {
            
            $str = "Selamat Datang di ((nama_rs))\n\n";
            $str .= $modPasien->namadepan.$modPasien->nama_pasien." dengan No RM ".$modPasien->no_rekam_medik." ";
            $str .= "terdaftar sebagai pasien pada tanggal ".MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran);
            $str .= " dan akan melakukan pemeriksaan di ";
            $str .= $model->ruangan->ruangan_nama.".\n\n";
            
            //$str .= "Kamar ".(empty($modPasienAdmisi->kamarruangan) ? "-" : $modPasienAdmisi->kamarruangan->kamarruangan_nokamar)." - ";
            //$str .= (empty($modPasienAdmisi->kamarruangan) ? "-" : $modPasienAdmisi->kamarruangan->kamarruangan_nobed)."\n\n";
            
            $str .= "Harap dicermati dan dipatuhi apa yg sudah disetujui dan ditandatangani di persetujuan umum.\n";
            $str .= "Jika memerlukan bantuan bisa kontak ke bagian informasi Rumah Sakit.\n\n";
            
            $str .= "Terimakasih\n((nama_rs)) - ((lokasi))";
            
            $str = str_replace("((nama_rs))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))), $str);
            $str = str_replace("((lokasi))", Yii::app()->user->getState('kabupaten_nama'), $str);
            
            
//            var_dump($str); die;
            
            $wa = new WhatsApp();
            $res = $wa->kirimIndividu($modPasien->no_mobile_pasien, $str);
//            $res = $wa->kirimIndividu("085606615990", $str);
            
//            var_dump($res, $str, $model->attributes, $modPasienAdmisi->attributes, $modPasien->attributes);
//            die;
        }

  protected function tambahPasienHL7($penunjang, $komentar = "Pasien Daftar Langsung Radiologi")
  {
    $hl7 = new HL7;
    $ok = $hl7->tambahPasien($penunjang->pasienmasukpenunjang_id, $komentar);

    return $ok;
  }

  public function simpanPenanggungjawabDokter($modPenanggungjawab, $pegawai_id)
  {
    $format = new MyFormatter;
    $peg = PegawaiM::model()->findByPk($pegawai_id);

    // $modPenanggungjawab = new PPPenanggungJawabM;
    $modPenanggungjawab->pengantar = Params::PENGANTAR_PEGAWAI_RS;
    $modPenanggungjawab->jenisidentitas = $peg->jenisidentitas;
    $modPenanggungjawab->no_identitas = $peg->noidentitas;
    $modPenanggungjawab->no_identitas_pj = $peg->noidentitas;
    $modPenanggungjawab->nama_pj = $peg->namaLengkap;
    $modPenanggungjawab->tempatlahir_pj = $peg->tempatlahir_pegawai;
    $modPenanggungjawab->tgllahir_pj = $peg->tgl_lahirpegawai;
    $modPenanggungjawab->jeniskelamin = $peg->jeniskelamin;
    $modPenanggungjawab->alamat_pj = $peg->alamat_pegawai;
    $modPenanggungjawab->no_teleponpj = $peg->notelp_pegawai;
    $modPenanggungjawab->no_mobilepj = str_replace(" ", "", $peg->nomobile_pegawai);
    $modPenanggungjawab->pegawai_id = $pegawai_id;
    $modPenanggungjawab->hubungankeluarga = "";

    if ($modPenanggungjawab->save()) {
      $this->penanggungjawabtersimpan = true;
    } else {
      $this->penanggungjawabtersimpan = false;
    }

    return $modPenanggungjawab;
  }


  protected function broadcastNotifDaftarRad($model, $modPasien)
  {
    $judul = "Pendaftaran langsung Pasien Radiologi";
    $isi = $model->no_pendaftaran . " - " . $modPasien->no_rekam_medik . " - " . $modPasien->nama_pasien;

    $linkDaftarPasien = Yii::app()->createUrl('/radiologi/daftarPasien/index', array(
      'ROPasienMasukPenunjangV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
      'ROPasienMasukPenunjangV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
      'ROPasienMasukPenunjangV[no_pendaftaran]' => $model->no_pendaftaran,
      'ROPasienMasukPenunjangV[statusperiksahasil]' => '',
      'ROPasienMasukPenunjangV[tgl_awall]' => date('Y-m-d'),
      'ROPasienMasukPenunjangV[tgl_akhirl]' => date('Y-m-d'),
      'ROPasienMasukPenunjangV[prefix_pendaftaran]' => '',
      'ROPasienMasukPenunjangV[ceklis]' => 0,
    ));


    // var_dump($judul, $isi, $linkDaftarPasien); die;

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => Params::INSTALASI_ID_RAD, 'ruangan_id' => Params::RUANGAN_ID_RAD, 'modul_id' => Params::MODUL_ID_RAD,  'link_proses' => $linkDaftarPasien), //, 'link_proses'=>$link_rj
    ));
  }

  /**
   * form verifikasi sebelum submit
   * @param type $id
   */
  public function actionVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $this->layout = '//layouts/iframe';
      if (isset($_POST['ROPendaftaranT'])) {
        $format = new MyFormatter();
        $model = new ROPendaftaranT;
        $modPasien = new ROPasienM;
        $modPenanggungJawab = null;
        $modRujukan = null;
        $modTindakans = array();
        $modKarcis = array();

        $model->attributes = $_POST['ROPendaftaranT'];
        $modPasien->attributes = $_POST['ROPasienM'];
        if ($_POST['ROPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['ROPenanggungJawabM'])) {
            $modPenanggungJawab = new ROPenanggungJawabM;
            $modPenanggungJawab->attributes = $_POST['ROPenanggungJawabM'];
          }
        }

        if ($_POST['ROPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['RORujukanT'])) {
            $modRujukan = new RORujukanT;
            $modRujukan->attributes = $_POST['RORujukanT'];
            $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
          }
        }

        $modPasienMasukPenunjang = new ROPasienmasukpenunjangT;
        $postPenunjang = $_POST['ROPasienmasukpenunjangT'];
        $modPasienMasukPenunjang->attributes = $postPenunjang;
        $modPasienMasukPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');
        if (isset($_POST['ROTindakanpelayananT'])) {
          if (count((array)$_POST['ROTindakanpelayananT']) > 0) {
            foreach ($_POST['ROTindakanpelayananT'] as $ii => $tindakan) {
              $modTindakans[$ii] = new ROTindakanpelayananT;
              $modTindakans[$ii]->attributes = $tindakan;
            }
          }
        }
        if ($postPenunjang['is_adakarcis']) {
          if (isset($_POST['ROKarcisV'])) {
            if (count((array)$_POST['ROKarcisV']) > 0) {
              foreach ($_POST['ROKarcisV'] as $ii => $karcis) {
                if ($karcis['is_pilihkarcis']) {
                  $modKarcis[$ii] = new ROKarcisV;
                  $modKarcis[$ii]->attributes = $karcis;
                }
              }
            }
          }
        }
      }
      //var_dump($model->carabayar_id);die;
      echo CJSON::encode(array(
        'content' => $this->renderPartial($this->path_view . 'verifikasi', array(
          'model' => $model,
          'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
          'modPasien' => $modPasien,
          'modPenanggungJawab' => $modPenanggungJawab,
          'modRujukan' => $modRujukan,
          'modTindakans' => $modTindakans,
          'modKarcis' => $modKarcis,
          'format' => $format,
        ), true)
      ));
      Yii::app()->end();
    }
  }

  /**
   * proses simpan / ubah data pasien
   * @param type $modPasien
   * @param type $post
   * @return type
   */
  public function simpanPasien($modPasien, $post)
  {
    $format = new MyFormatter();
    if (isset($post['pasien_id']) && (!empty($post['pasien_id']))) {
      $load = new $modPasien;
      $modPasien = $load->findByPk($post['pasien_id']);
    }
    $modPasien->attributes = $post;
    $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);

    if (empty($modPasien->pasien_id)) {
      $this->is_pasien_baru = true;
      $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
      $modPasien->profilrs_id = Params::getDefaultProfilRS();
      $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
      $modPasien->ispasienluar = TRUE;
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPasien->create_loginpemakai_id = Yii::app()->user->id;
      $modPasien->create_time = date('Y-m-d H:i:s');
      $modPasien->no_rekam_medik = MyGenerator::noRekamMedikPenunjang(Yii::app()->user->getState('mr_rad'));
    } else {
      $modPasien->update_loginpemakai_id = Yii::app()->user->id;
      $modPasien->update_time = date('Y-m-d H:i:s');
    }
    $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
    $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;


    // simpan gambar
    if (isset($post['is_ambilfoto']) && $post['is_ambilfoto'] == 1) {
      $nama_file = "pasien_" . date('YmdHis') . "_" . (str_replace(".", "_", microtime(true))) . ".png";
      $fullImgSource = Params::pathPasienDirectory() . $nama_file;
      $fullThumbSource = Params::pathPasienTumbsDirectory() . 'kecil_' . $nama_file;

      $file = fopen($fullImgSource, "wb");
      $data_foto = explode(",", $modPasien->photopasien);

      fwrite($file, base64_decode($data_foto[1]));
      fclose($file);

      // thumbnail
      Yii::import("ext.EPhpThumb.EPhpThumb");
      $thumb = new EPhpThumb();
      $thumb->init();
      $thumb->create($fullImgSource)
        ->resize(200, 200)
        ->save($fullThumbSource);

      $modPasien->photopasien = $nama_file;
    }

    if (empty($modPasien->create_ruangan)) {
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    }

    if (!is_numeric($modPasien->no_mobile_pasien)) {
      $modPasien->no_mobile_pasien = str_replace("-", "", $modPasien->no_mobile_pasien);
      $modPasien->no_mobile_pasien = trim($modPasien->no_mobile_pasien);
    }
    if (!is_numeric($modPasien->no_telepon_pasien)) {
      $modPasien->no_telepon_pasien = str_replace("-", "", $modPasien->no_telepon_pasien);
      $modPasien->no_telepon_pasien = trim($modPasien->no_telepon_pasien);
    }



    if ($modPasien->save()) {
      $this->pasientersimpan = true;
    }


    return $modPasien;
  }

  /**
   * proses simpan data penanggungjawab pasien
   * @param type $modPenanggungjawab
   * @param type $post
   * @return type
   */
  public function simpanPenanggungjawab($modPenanggungjawab, $post)
  {
    $format = new MyFormatter;
    $modPenanggungjawab->attributes = $post;
    $modPenanggungjawab->tgllahir_pj = $format->formatDateTimeForDb($modPenanggungjawab->tgllahir_pj);

    if ($modPenanggungjawab->save()) {
      $this->penanggungjawabtersimpan = true;
    }
    return $modPenanggungjawab;
  }

  /**
   * proses simpan data rujukan
   * @param type $modRujukan
   * @param type $post
   * @return type
   */
  public function simpanRujukan($modRujukan, $post)
  {
    $format = new MyFormatter();
    $modRujukan->attributes = $post;
    $modRujukan->tanggal_rujukan = $format->formatDateTimeForDb($modRujukan->tanggal_rujukan);

    if ($modRujukan->save()) {
      $this->rujukantersimpan = true;
    }
    return $modRujukan;
  }

  /**
   * simpan asuransi pasien
   * @param type $modAsuransiPasien
   * @param type $postPendaftaran
   * @param type $postPasien
   * @param type $postAsuransiPasien
   * @return type
   */
  public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien)
  {
    $format = new MyFormatter();
    $modAsuransiPasien->attributes = $postAsuransiPasien;
    $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
    $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
    $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
    $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
    $modAsuransiPasien->hubkeluarga = isset($postAsuransiPasien['hubkeluarga']) ? $postAsuransiPasien['hubkeluarga'] : '';
    if (empty($postAsuransiPasien['nokartuasuransi'])) {
      $modAsuransiPasien->nokartuasuransi = $modAsuransiPasien->nopeserta;
    }

    if ($modAsuransiPasien->save()) {
      $this->asuransipasientersimpan = true;
    }
    return $modAsuransiPasien;
  }

  /**
   * proses simpan / ubah data pendaftaran
   * @return type
   */
  public function simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $post, $postPasien, $postPenunjang, $modAsuransiPasien)
  {
    $format = new MyFormatter();
    $model->attributes = $post;
    $model->pendaftaran_id = null;
    $model->pasien_id = $modPasien->pasien_id;
    $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
    $model->rujukan_id = $modRujukan->rujukan_id;
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (!empty($postPenunjang['pegawai_id'])) {
      $model->pegawai_id = $postPenunjang['pegawai_id'];
    }
    if (!empty($postPenunjang['jeniskasuspenyakit_id'])) {
      $model->jeniskasuspenyakit_id = $postPenunjang['jeniskasuspenyakit_id'];
    }
    if (!empty($postPenunjang['kelaspelayanan_id'])) {
      $model->kelaspelayanan_id = $postPenunjang['kelaspelayanan_id'];
    }
    if (!empty($postPenunjang['ruangan_id'])) {
      $model->ruangan_id = $postPenunjang['ruangan_id'];
    }
    $model->instalasi_id = (isset($model->ruangan_id) ? RuanganM::model()->findByPk($model->ruangan_id)->instalasi_id : null);
    $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id);
    $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
    $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
    $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
    $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
    $model->shift_id = Yii::app()->user->getState('shift_id');
    $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
    $model->statuspasien = (empty($postPasien['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
    $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_time = date("Y-m-d H:i:s");
    if (Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)) {
      $model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
    } else {
      $model->tgl_pendaftaran = date("Y-m-d H:i:s");
    }
    $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
    $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
    $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
    $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
    $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;

    if ($model->save()) {
      $this->pendaftarantersimpan = true;
      if (!empty($model->antrian_id)) {
        AntrianT::model()->updateByPk($model->antrian_id, array(
          'pendaftaran_id' => $model->pendaftaran_id,
        ));
      }
    }
    return $model;
  }

  /**
   * Fungsi untuk menyimpan data ke model ROPasienmasukpenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return ROPasienmasukpenunjangT
   */
  public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $post)
  {
    $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
    $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
    $modPasienMasukPenunjang->attributes = $post;
    $modPasienMasukPenunjang->perawat_id = (isset($post['perawat_id']) ? $post['perawat_id'] : null);
    $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
    $modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
    $modPasienMasukPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
    $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');

    if (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)) {
      $kirim = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
      $modPasienMasukPenunjang->ruanganasal_id = $kirim->create_ruangan;
    }

    if ($modPasienMasukPenunjang->validate()) {
      $modPasienMasukPenunjang->save();
      $this->pasienpenunjangtersimpan &= true;
    } else {
      $this->pasienpenunjangtersimpan &= false;
    }

    return $modPasienMasukPenunjang;
  }

  /**
   * proses simpan ROTindakanpelayananT dan ROTindakankomponenT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post, $nopelayanan = null)
  {

    // echo '<pre>'; var_dump($post); die;
    $modTindakan = new ROTindakanpelayananT;

    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->attributes = $post;
    $modTindakan->pasienadmisi_id = $modPendaftaran->pasienadmisi_id ?? null;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
    if (!empty($modTindakan->karcis_id)) {
      $this->karcistersimpan = true;
      if (isset($post['harga_tariftindakan'])) { //jika dari form karcis
        if (!empty($post['harga_tariftindakan'])) {
          $modTindakan->tarif_satuan = $post['harga_tariftindakan'];
        }
      }
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
    $modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
    $modTindakan->tarif_tindakan = floatval($modTindakan->tarif_satuan) * $modTindakan->qty_tindakan;
    if (!empty($_POST['tgl_tindakan_semua'])) {
      $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($_POST['tgl_tindakan_semua']);
    } else {
      $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    }
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
    
    $modTindakan->tarif_satuan = is_numeric($modTindakan->tarif_satuan) ? $modTindakan->tarif_satuan : MyFormatter::formatRupiahForDb($modTindakan->tarif_satuan);
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;

    if(isset($_POST['ROPendaftaranT']['tgl_tindakan'])) {
      $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($_POST['ROPendaftaranT']['tgl_tindakan']);
    }
    if(isset($post['tgl_tindakan'])) {
      $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($post['tgl_tindakan']);
    }

    $modTindakan->nopelayanan = $nopelayanan;
    
//    var_dump($modTindakan->attributes);

    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan = $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }

  /**
   * simpan ROHasilpemeriksaanradT
   */
  public function simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $modTindakan, $post)
  {
    $modHasilPemeriksaan = new ROHasilpemeriksaanradT;
    $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
    $modHasilPemeriksaan->pemeriksaanrad_id = $post['pemeriksaanrad_id'];
    $modHasilPemeriksaan->tglpemeriksaanrad = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;


    if ($modHasilPemeriksaan->validate()) {
      $modHasilPemeriksaan->save();

      //RND-8272
      $dataBroker = $modHasilPemeriksaan->getDataBroker();


      if (!empty($dataBroker)) {
        CustomFunction::postHL7Broker("ADD", $dataBroker);
      }
      $modTindakan->hasilpemeriksaanrad_id = $modHasilPemeriksaan->hasilpemeriksaanrad_id;
      $modTindakan->update();
    } else {
      $this->hasilpemeriksaantersimpan = false;
    }

  }

  /**
   * menentukan tipepaket_id
   * @param type $modPendaftaran
   * @param type $karcis_id
   * @param type $idTindakan
   * @return type
   */
  public function tipePaketKarcis($modPendaftaran, $karcis_id, $tindakan_id)
  {
    $criteria = new CDbCriteria;
    $criteria->with = array('tipepaket');
    if (!empty($tindakan_id)) {
      $criteria->addCondition("daftartindakan_id = " . $tindakan_id);
    }
    if (!empty($modPendaftaran->carabayar_id)) {
      $criteria->addCondition("tipepaket.carabayar_id = " . $modPendaftaran->carabayar_id);
    }
    if (!empty($modPendaftaran->penjamin_id)) {
      $criteria->addCondition("tipepaket.penjamin_id = " . $modPendaftaran->penjamin_id);
    }
    if (!empty($modPendaftaran->kelaspelayanan_id)) {
      $criteria->addCondition("tipepaket.kelaspelayanan_id = " . $modPendaftaran->kelaspelayanan_id);
    }
    $paket = PaketpelayananM::model()->find($criteria);
    $result = Params::TIPEPAKET_ID_NONPAKET;
    if (isset($paket)) $result = $paket->tipepaket_id;

    return $result;
  }
  
    /**
     * Set Tanggal, Wilayah, dan Jenis Kelamin berdasarkan No KTP
     */
    public function actionInputDariNoKTP() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }

        $no_ktp = $_POST['no_ktp'];
        $str_lens = strlen($no_ktp);

        $res = array(
            'propinsi_id'=>null,
            'kabupaten_id'=>null,
            'kecamatan_id'=>null,
            'tanggal_lahir'=>null,
            'tanggal_lahir_format'=>null,
            'jeniskelamin'=>'',
        );

        if ($str_lens >= 2) {
            $prop = PropinsiM::model()->findByAttributes(array(
                'kode_propinsi'=>substr($no_ktp, 0, 2),
            ));

            if (!empty($prop)) {
                $res['propinsi_id'] = $prop->propinsi_id;

                if ($str_lens >= 4) {
                    $kab = KabupatenM::model()->findByAttributes(array(
                        'propinsi_id'=>$prop->propinsi_id,
                        'kode_kabupaten'=>substr($no_ktp, 2, 2),
                    ));

                    if (!empty($kab)) {
                        $res['kabupaten_id'] = $kab->kabupaten_id;

                        if ($str_lens >= 6) {
                            $kec = KecamatanM::model()->findByAttributes(array(
                                'kabupaten_id'=>$kab->kabupaten_id,
                                'kode_kecamatan'=>substr($no_ktp, 4, 2),
                            ));

                            if (!empty($kec)) {
                                $res['kecamatan_id'] = $kec->kecamatan_id;
                            }
                        }
                    }
                }
            }
        }

        if ($str_lens >= 12) {
            $str_tgl = substr($no_ktp, 6, 6);

            $tgl = substr($str_tgl, 0, 2);
            $bln = substr($str_tgl, 2, 2);
            $thn = substr($str_tgl, 4, 2);

            $thn_min = "19".$thn;
            $thn_max = "20".$thn;
            $thn_real = $thn_max;

            if (($thn_real) > (date('Y') - 16)) {
                $thn_real = $thn_min;
            }
            
            $bln = ((int)$bln > 12) ? "01" : $bln;
                
            $hari_limit = date('t', strtotime($thn_real."-".$bln."-01"));
            $tgl = ($tgl > $hari_limit) ? "01" : $tgl;


            $res['tanggal_lahir'] = $thn_real."-".$bln."-".$tgl;
            $res['tanggal_lahir_format'] = $tgl."/".$bln."/".$thn_real;

            // jenis kelamin
            $res_jk = (int)$tgl - 40;

            if ($res_jk < 0) {
                $res['jeniskelamin'] = 'LAKI-LAKI';
            } else {
                $res['jeniskelamin'] = 'PEREMPUAN';
            }


        }

        echo CJSON::encode($res);
    }



  /**
   * set umur dari tanggal lahir (date)
   */
  public function actionSetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['umur'] = null;
      if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
        $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * set umur pjp dari tanggal lahir (date)
   */
  public function actionSetUmurPjp()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['umur_pj'] = null;
      if (isset($_POST['tgllahir_pj']) && !empty($_POST['tgllahir_pj'])) {
        $data['umur_pj'] = CustomFunction::hitungUmur($_POST['tgllahir_pj']);
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * set dropdown dokter
   */
  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new ROPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getDokterItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listDokter'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown jenis kasus penyakit
   */
  public function actionSetDropdownJeniskasuspenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new ROPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listKasuspenyakit'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * set antrian ruangan
   */
  public function actionSetAntrianRuangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $data = array();
      $data['maxantrianruangan'] = null;
      $data['no_urutantri'] = '001';
      if (!empty($ruangan_id)) {
        $data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
        $criteria = new CDbCriteria;
        if (!empty($ruangan_id)) {
          $criteria->addCondition("ruangan_id = " . $ruangan_id);
        }
        $modJadwalBukaPoli = JadwalbukapoliM::model()->findAll($criteria);
        if (count((array)$modJadwalBukaPoli) > 0) {
          foreach ($modJadwalBukaPoli as $key => $antrian) {
            $data['maxantrianruangan'] = $antrian->maxantiranpoli;
          }
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * set antrian dokter
   */
  public function actionSetAntrianDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $pegawai_id = $_POST['pegawai_id'];
      $data = array();
      $data['maxantriandokter'] = 0;
      if (!empty($ruangan_id) && !empty($pegawai_id)) {
        $criteria = new CDbCriteria;
        if (!empty($ruangan_id)) {
          $criteria->addCondition("ruangan_id = " . $ruangan_id);
        }
        if (!empty($pegawai_id)) {
          $criteria->addCondition("pegawai_id = " . $pegawai_id);
        }
        $modJadwalDokter = JadwaldokterM::model()->findAll($criteria);
        if (count((array)$modJadwalDokter) > 0) {
          foreach ($modJadwalDokter as $key => $antrian) {
            $data['maxantriandokter'] = $antrian->maximumantrian;
          }
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * menampilkan karcis
   */
  public function actionSetKarcis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $pasien_id = $_POST['pasien_id'];
      $penjamin_id = $_POST['penjamin_id'];
      $form = '';
      $is_pasienbaru = 'true';
      if (!empty($pasien_id)) {
        $modPasien = PasienM::model()->findByPk($pasien_id);
        if (isset($modPasien)) {
          $is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF) ? 'false' : 'true';
        }
      }
      $criteria = new CdbCriteria();
      $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
      $criteria->addCondition("ruangan_id = " . $ruangan_id);
      $criteria->addCondition("penjamin_id = " . $penjamin_id);

      $modKarcisAll = ROKarcisV::model()->findAll($criteria);

      if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
        $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
      }
      $modKarcis = ROKarcisV::model()->findAll($criteria);

      // susun karcis global
      $modKarcisFinal = array();
      $modKarcisAda = array();
      foreach ($modKarcisAll as $item) {
        if (empty($modKarcisAda[$item->daftartindakan_id])) {
          $modKarcisAda[$item->daftartindakan_id] = 1;
          $modKarcisFinal[] = $item;
        }
      }

      $form = $this->renderPartial($this->path_view . '_formKarcis', array('modKarcisAll' => $modKarcisFinal, 'modKarcis' => $modKarcis), true);
      $data['listKarcis'] = $form;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * set tabel riwayat kunjungan pasien
   */
  public function actionSetRiwayatKunjunganPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['table'] = "";
      $modPasien = new ROPasienM;
      $modPasien->pasien_id = $_POST['pasien_id'];
      $data['table'] = $this->renderPartial($this->path_view . '_tableRiwayatPasien', array(
        'modPasien' => $modPasien,
      ), true);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk menampilkan pasien lama dari autocomplete
   * 1. no_rekam_medik
   * 2. no_identitas_pasien
   * 3. nama_pasien
   * 4. nama_bin (alias)
   */
  public function actionAutocompletePasienLama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $tanggal_lahir = isset($_GET['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['tanggal_lahir']) : null;
      $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;

      if (empty($no_badge)) {

        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
        $criteria->compare('tanggal_lahir', $tanggal_lahir);
        $criteria->compare('ispasienluar', true);
        $criteria->order = 'no_rekam_medik, nama_pasien';
        $criteria->limit = 5;
        $models = PasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - '.$model->no_identitas_pasien.' - '. $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      } else {

        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
        $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
        $criteria->order = 'pegawai_m.nomorindukpegawai, t.nama_pasien';
        $criteria->limit = 50;
        $models = PPPasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai .
            ' - ' . $model->no_rekam_medik .
            ' - ' . $model->nama_pasien .
            ' - (' . $model->pegawai->nama_pegawai .
            ') - ' . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      }



      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Autocomplete Asuransi
   * @throws CHttpException
   */
  public function actionAutocompleteAsuransi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
      $criteria->addCondition('penjamin_id=' . $penjamin_id);
      $criteria->addCondition('asuransipasien_aktif is true');
      if ($_GET['pasien_id'] == "") {
        $criteria->addCondition('pasien_id is null');
      } else {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      $criteria->order = 'namapemilikasuransi';
      $criteria->limit = 5;
      $models = ROAsuransipasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nopeserta;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionAutocompleteAsuransiKartu()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nokartuasuransi = isset($_GET['nokartuasuransi']) ? $_GET['nokartuasuransi'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nokartuasuransi)', strtolower($nokartuasuransi), true);
      $criteria->addCondition('penjamin_id=' . $penjamin_id);
      if ($_GET['pasien_id'] == "") {
        $criteria->addCondition('pasien_id is null');
      } else {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      $criteria->order = 'namapemilikasuransi';
      $criteria->limit = 5;
      $models = ROAsuransipasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nokartuasuransi . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nokartuasuransi;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        $returnVal[$i]['nopeserta'] = $model->nopeserta;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * menampilkan data asuransi terakhir pasien
   * @throws CHttpException
   */
  public function actionSetAsuransiPasienLama()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $criteria = new CDbCriteria();
      $criteria->addCondition("pasien_id = " . $_POST['pasien_id']);
      $criteria->order = 'asuransipasien_id DESC';
      $model = AsuransipasienM::model()->find($criteria);
      $data["penjamin_nama"] = '';
      if ($model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $data["$attribute"] = $model->$attribute;
        }
        $data["penjamin_nama"] = $model->penjamin->penjamin_nama;
        $data['listPenjamin'] = "";
        $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
        if (count((array)$penjamin) > 1) {
          $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
        foreach ($penjamin as $value => $name) {
          $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      echo CJSON::encode($data);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }
  /**
   * Mengurai data pasien berdasarkan pasien_id
   * @throws CHttpException
   */
  public function actionGetDataPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pasien_id)) {
        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
          'pasien_id' => $pasien_id,
        ), array(
          'condition' => 'pasienbatalperiksa_id is null'
        ));
        if (empty($pendafaran)) {
          $pendaftaran = PendaftaranT::model()->findByAttributes(array(
            'pasien_id' => $pasien_id,
          ), array(
            'condition' => 'pasienbatalperiksa_id is null',
            'order' => 'tgl_pendaftaran desc',
          ));
        }
      } else if (!empty($no_rekam_medik)) {
        //var_dump($no_rekam_medik); die;
        $p = PasienM::model()->findByAttributes(array('no_rekam_medik' => trim($no_rekam_medik)));
        //var_dump($p->pasien_id); die;
        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
          'pasien_id' => $p->pasien_id,
        ), array(
          'condition' => 'pasienbatalperiksa_id is null',
          'order' => 'pendaftaran_id desc',
        ));
        if (empty($pendafaran)) {
          $pendaftaran = PendaftaranT::model()->findByAttributes(array(
            'pasien_id' => $p->pasien_id,
          ), array(
            'condition' => 'pasienbatalperiksa_id is null',
            'order' => 'tgl_pendaftaran desc',
          ));
        }
      } else {
        $pendaftaran = null;
      }



      $returnVal['lebih'] = false;
      $returnVal['adaDaftar'] = false;

      $pp = null;
      if (!empty($pendaftaran)) {
        $returnVal['listDaftar'] = $pendaftaran->attributes;
        $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien;
        $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan;
        $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi;

        $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
        $pp = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
        $con = new PendaftaranRawatJalanController('index');
        // if (!empty($admisi)) {
        //   $con->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
        // } else {
        //   //var_dump($pendaftaran->attributes);die;
        //   switch ($pendaftaran->instalasi_id) {
        //     case Params::INSTALASI_ID_RJ:
        //       $con->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     case Params::INSTALASI_ID_MCU:
        //       $con->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     case Params::INSTALASI_ID_HD:
        //       $con->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     case Params::INSTALASI_ID_RD:
        //       $con->periksaValidasiPasienRD($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     case Params::INSTALASI_ID_RI:
        //       $con->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     case Params::INSTALASI_ID_ICU:
        //       $con->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     default:
        //       $con->periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //   }
        // }
        //die;
      }


      $criteria = new CDbCriteria();
      if (!empty($pasien_id)) {
        $criteria->addCondition('pasien_id = ' . $pasien_id);
      }
      if (!empty($no_rekam_medik)) {
        $criteria->compare('no_rekam_medik', $no_rekam_medik);
      }
      $model = PasienM::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["fingerprint_data"] = null;
      $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
      if (!empty($model->pegawai_id)) {
        $returnVal['nomorindukpegawai'] = $model->pegawai->nomorindukpegawai;
        $returnVal['nama_pegawai'] = $model->pegawai->nama_pegawai;
        $returnVal['gelardepan'] = $model->pegawai->gelardepan;
        $returnVal['unit_perusahaan'] = $model->pegawai->unit_perusahaan;
        $returnVal['gelarbelakang_nama'] = isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "";
        $returnVal['jabatan_nama'] = isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "";
        $returnVal["nomorindukpegawai"] = $model->pegawai->nomorindukpegawai;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new ROPasienM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
        $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
      }
      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($kabupaten)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new ROPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
        $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kecamatan);
      } else {
        if (empty($kecamatan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kecamatan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kelurahan
   * @param type $encode jika = true maka return array jika false maka set Dropdown
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new ROPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
        //                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
        $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelurahan);
      } else {
        if (empty($kelurahan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kelurahan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * set dropdown daerah pasien berdasarkan
   * propinsi_id
   * kabupaten_id
   * kecamatan_id
   * kelurahan_id
   * pasien_id
   */
        public function actionSetDropdownDaerahPasien()
        {
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                $modPasien = new PPPasienM;
                $propinsi_id = $_POST['propinsi_id'];
                $kabupaten_id = $_POST['kabupaten_id'];
                $kecamatan_id = $_POST['kecamatan_id'];
                $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

                $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
                $propinsis = CHtml::listData($propinsis,'propinsi_id','propinsi_nama');
                $propinsiOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($propinsis as $value=>$name)
                {
                    if($value==$propinsi_id)
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $propinsiOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                
                if (empty($propinsi_id)) {
                    $kabupatens = array();
                } else {
                    $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
    //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
                    $kabupatens = CHtml::listData($kabupatens,'kabupaten_id','kabupaten_nama');
                    
                }
                
                $kabupatenOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kabupatens as $value=>$name)
                {
                    if($value==$kabupaten_id)
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kabupatenOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                
                
                if (empty($kabupaten_id)) {
                    $kecamatans = array();
                } else {
                    $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
    //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
                    $kecamatans = CHtml::listData($kecamatans,'kecamatan_id','kecamatan_nama');
                    
                }
                $kecamatanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kecamatans as $value=>$name)
                {
                    if($value==$kecamatan_id)
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kecamatanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
                
                if (empty($kecamatan_id)) {
                    $kelurahans = array();
                } else {
                    $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
                    $kelurahans = CHtml::listData($kelurahans,'kelurahan_id','kelurahan_nama');
                }
                
                $kelurahanOption = CHtml::tag('option',array('value'=>''),"-- Pilih --",true);
                foreach($kelurahans as $value=>$name)
                {
                    if($value==$kelurahan_id)
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value,'selected'=>true),CHtml::encode($name),true);
                    else
                        $kelurahanOption .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }

                $dataList['listPropinsi'] = $propinsiOption;
                $dataList['listKabupaten'] = $kabupatenOption;
                $dataList['listKecamatan'] = $kecamatanOption;
                $dataList['listKelurahan'] = $kelurahanOption;

                echo json_encode($dataList);
                Yii::app()->end();
            }
        }

  /**
   * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
   */
  public function actionSetTanggalLahir()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['tanggal_lahir'] = date("d/m/Y", strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));

      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * set tanggal lahir pjp dari umur (__ Thn __ Bln __ Hr)
   */
  public function actionSetTanggalLahirPjp()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['tgllahir_pj'] = date("d/m/Y", strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk drop down rujukan
   */
  public function actionGetRujukanDari($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];

      if ($encode) {
        echo CJSON::encode($rujukandari);
      } else {
        if (empty($asalrujukan_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id' => $asalrujukan_id), array('order' => 'namaperujuk'));
          $rujukandari = CHtml::listData($rujukandari, 'rujukandari_id', 'namaperujuk');
          foreach ($rujukandari as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
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
    $model =  ROPendaftaranT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }



  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'lkpendaftaran-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * set checklist pemeriksaan rad
   */
  public function actionSetChecklistPemeriksaanRad()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPemeriksaan = isset($post['ROTarifpemeriksaanradruanganV']) ? $post['ROTarifpemeriksaanradruanganV'] : null;

      // tarif radiologi antar kelas sama
      $postPemeriksaan['kelaspelayanan_id'] = Params::KELASPELAYANAN_ID_TANPA_KELAS;

      if (!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
        $criteria = new CdbCriteria();
        $criteria->addCondition('ruangan_id = ' . $postPemeriksaan['ruangan_id']);
        $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
        $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        $criteria->compare('LOWER(jenispemeriksaanrad_nama)', strtolower($postPemeriksaan['jenispemeriksaanrad_nama']));
        //$criteria->compare('jenispemeriksaanrad_id',$postPemeriksaan['jenispemeriksaanrad_id']);
        $criteria->compare('LOWER(pemeriksaanrad_nama)', strtolower($postPemeriksaan['pemeriksaanrad_nama']), true);
        $criteria->order = "jenispemeriksaanrad_urutan, pemeriksaanrad_urutan";
        $modPemeriksaanRads = ROTarifpemeriksaanradruanganV::model()->findAll($criteria);
        $content = $this->renderPartial($this->path_view . '_checklistPemeriksaanRad', array('modPemeriksaanRads' => $modPemeriksaanRads), true);
      }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintStatusRad($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasien = ROPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasienMasukPenunjang = array();
    $daftartindakan = array();
    $modTindakans = array();
    $criteria1 = new CdbCriteria();
    $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id ASC";
    $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_RAD);
    $loadPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->find($criteria1);
    $criteria = new CDbCriteria();
    $criteria->select = 'd.diagnosa_nama';
    $criteria->join = 'JOIN diagnosa_m d ON t.diagnosa_id = d.diagnosa_id';
    $criteria->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $query = ROPasienmorbiditasT::model()->findAll($criteria);
    if (isset($loadPasienMasukPenunjang)) {
      $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
      $modTindakans = ROTindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_tot = new CdbCriteria();
      $criteria_tot->addCondition("karcis_id IS NULL");
      $criteria_tot->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjang->pasienmasukpenunjang_id);
      $daftartindakan = ROTindakanpelayananT::model()->findAll($criteria_tot);
    }

    $judul_print = 'Kunjungan Radiologi';
    $this->render($this->path_view . 'printStatusRad', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'daftartindakan' => $daftartindakan,
      'query' => $query
    ));
  }


  /**
   * Cek keaktifan pegawai jika penjamin pt badak
   * @param type $encode
   * @param type $namaModel
   */
  public function actionCekCaraBayarBadak()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = $_POST['pasien_id'];
      $pegawai_id = $_POST['pegawai_id'];
      $pesan = '';
      $status = false;
      $modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
      if (!empty($modPegawai)) {
        if ($modPegawai->pegawai_aktif) {
          $status = true;
        } else {
          $status = false;
          $pesan = 'Data Pegawai tidak aktif';
        }
      } else {
        $status = false;
        $pesan = 'Data tidak ditemukan';
      }
      echo CJSON::encode(array('status' => $status, 'pesan' => $pesan));
    }
    Yii::app()->end();
  }

  /**
   * Ngeset data asuransi badak jika pasien telah memiliki data di asuransipasien_m
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetAsuransiBadak()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      if ((!empty($_POST['pasien_id'])) && (!empty($_POST['penjamin_id']))) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("pasien_id = " . $_POST['pasien_id']);
        $criteria->addCondition("penjamin_id = " . $_POST['penjamin_id']);
        $criteria->order = 'asuransipasien_id DESC';
        $model = AsuransipasienM::model()->find($criteria);
        if (!empty($model)) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $data["$attribute"] = $model->$attribute;
          }
          $data['listPenjamin'] = "";
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        } else {
          $data = null;
          $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
          if (!empty($pegawai_id)) {
            $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
            $data['nopeserta'] = $modPegawai->nomorindukpegawai;
            $data['namaperusahaan'] = $modPegawai->unit_perusahaan;
            $data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
            $data['namaperusahaan'] = 'PT. Badak LNG';
          }
        }
      } else {
        $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
        if (!empty($pegawai_id)) {
          $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
          $data['nopeserta'] = $modPegawai->nomorindukpegawai;
          $data['namaperusahaan'] = $modPegawai->unit_perusahaan;
          $data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
          $data['namaperusahaan'] = 'PT. Badak LNG';
        }
      }
      echo CJSON::encode($data);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Cek kategori pegawai untuk menentukan asuransi pasien
   * @param type $encode
   * @param type $namaModel
   */
  public function actionCekValiditasPenjamin()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : '';
      $penjamin_id =  isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : '';
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
      $penj = '';
      $pesan = '';
      $status = '';
      $html = '';
      $data = null;
      switch ($_POST['type']) {
        case "badak":

          $modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => Params::CARABAYAR_ID_BADAK, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          $html .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($penjamin as $value => $name) {
            $html .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }

          if (!empty($modPegawai)) {
            if ($modPegawai->kategoripegawai == "") {
              $status = "Empty";
              $pesan = 'Data Kategori pegawai penanggung jawab pasien tidak ditemukan!<br>Lakukan pengaturan kategori pegawai di modul kepegawaian';
            } else {
              if ($penjamin_id == Params::PENJAMIN_ID_PISA) {
                $penj = Params::PENJAMIN_ID_PISA;
                if ($modPegawai->kategoripegawai == "Tidak Tetap") {
                  $status = "Tidak Tetap";
                  $pesan = 'Tidak dapat memilih penjamin PISA. <br> Karena pegawai penanggung jawab pasien adalah pegawai tidak tetap / telah pensiun';
                }
              } else if ($penjamin_id == Params::PENJAMIN_ID_PROKESPEN) {
                $penj = Params::PENJAMIN_ID_PROKESPEN;
              }
            }
          } else {
            $status = "Fail";
            $pesan = 'Data tidak ditemukan';
          }
          break;

        case "departemen":

          $modPenjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
          $data['penjamin_nama'] = $modPenjamin->penjamin_nama;
          break;
      }

      echo CJSON::encode(array('status' => $status, 'pesan' => $pesan, 'html' => $html, 'penj' => $penj, 'data' => $data));
    }
    Yii::app()->end();
  }

  /**
   * set dropdown jenis kasus penyakit
   */
  public function actionSetDropdownStatushubungankeluarga()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $penjamin_id = $_POST['penjamin_id'];
      $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($penjamin_id)) {
        $data = $modAsuransiPasienBadak->getDropdownStatushubungankeluarga($penjamin_id);
        $data = CHtml::listData($data, 'lookup_value', 'lookup_name');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['statushubungankeluarga'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionAutocompleteAsuransiBadak()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nopeserta = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
      if (!empty($pasien_id)) {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      if (!empty($penjamin_id)) {
        $criteria->addCondition('penjamin_id=' . $penjamin_id);
      }
      $criteria->order = 'namapemilikasuransi';
      $criteria->limit = 5;
      $models = PPAsuransipasienM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nopeserta;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        //				$returnVal[$i]['nopeserta'] = $model->nopeserta;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;

        $modPegawai = '';
        $modPegawai = PPPegawaiM::model()->findByPk($model->pasien->pegawai_id);
        $returnVal[$i]['alamat_pegawai'] = !empty($modPegawai) ? $modPegawai->alamat_pegawai : '';
        $returnVal[$i]['notelp_pegawai'] = !empty($modPegawai) ? $modPegawai->notelp_pegawai : '';
      }
      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * untuk menampilkan data pegawai
   */
  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nomorindukpegawai, nama_pegawai';
      $criteria->limit = 5;
      $models = PPPegawaiM::model()->findAll($criteria);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $returnVal[$i] = $model->attributes;
          if (!empty($nomorindukpegawai)) {
            $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai;
          } else {
            $returnVal[$i]['label'] = $model->nama_pegawai;
          }
          $returnVal[$i]['value'] = $model->pegawai_id;
          $returnVal[$i]['jabatan_nama'] = !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : "";
          $returnVal[$i]['gelarbelakang_nama'] = !empty($model->gelarbelakang_id) ? $model->gelarbelakang->gelarbelakang_nama : "";
        }
      }
      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * menampilkan form antrian dari request ajax
   * @param type $record
   * @param type $noantrian
   * @throws CHttpException
   */
  public function actionSetFormAntrian(){
    // var_dump('dfghjkl');die;
    if(Yii::app()->request->isAjaxRequest)
    {
        $format = new MyFormatter();
        $data = array();
        $data['pesan'] = "";
        $record = (isset($_POST['record']) ? $_POST['record'] : "");
        $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
        if(empty($noantrian)){ //antrian baru
            $criteria = new CDbCriteria();
            $criteria->join = "join loket_m l on l.loket_id = t.loket_id";
            $criteria->addCondition("l.loket_singkatan ilike 'R'");
            $criteria->compare('DATE(t.tglantrian)', date("Y-m-d"));
            $criteria->addCondition("t.pendaftaran_id IS NULL");
            // if($record == "reset"){
                // $criteria->addCondition("panggil_flaq = false");
            // }
            $criteria->order = "noantrian ASC";
            $criteria->limit = 1;
            $modAntrian =  PPAntrianT::model()->find($criteria);
        }else{
            $criteria = new CDbCriteria();
            $criteria->join = "join loket_m l on l.loket_id = t.loket_id";
            $criteria->addCondition("l.loket_singkatan ilike 'R'");
            $criteria->compare('DATE(t.tglantrian)', date("Y-m-d"));
            $criteria->compare("t.noantrian",trim($noantrian));
            $cari =  PPAntrianT::model()->find($criteria);
            if($record == 'next'){
                $modAntrian = $cari->AntrianBerikut;
            }else if($record == 'prev'){
                $modAntrian = $cari->AntrianSebelum;
            }else{
                $modAntrian = $cari;
            }
        }

        if(!isset($modAntrian)){
            $modAntrian = new PPAntrianT;
            $data['pesan'] = "Antrian Habis !";
        }
        $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
        $data['form_antrian'] = $this->renderPartial($this->path_view.'_formPanggilAntrian',array('modAntrian'=>$modAntrian),true);
        echo CJSON::encode($data);
        Yii::app()->end();
    }
    else
        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
}


/**
 * action ketika tombol panggil di klik
 */
public function actionPanggil($antrian_id,$ket=null){
    if(Yii::app()->request->isAjaxRequest)
    {
        $format = new MyFormatter();
        $data = array();
        $data['pesan']="";
        $modAntrian =  PPAntrianT::model()->findByPk($antrian_id);
        if(isset($modAntrian)){
            if($modAntrian->panggil_flaq == true){
                if($ket == "batal"){
                    $modAntrian->panggil_flaq = false;
                    if($modAntrian->update()){
//                            $data['pesan'] = "Pemanggilan no. antrian ".$modAntrian->noantrian." dibatalkan !";
                    }
                } //else{
                   // $data['pesan'] = "No. antrian ".$modAntrian->noantrian." sudah dipanggil sebelumnya !";
                // }
            } else{
                $modAntrian->panggil_flaq = true;
                if($modAntrian->update()){
//                        $data['pesan'] = "No. antrian ".$modAntrian->noantrian." dipanggil !";
                }
            }
        }
        $attributes = $modAntrian->attributeNames();
        foreach($attributes as $i=>$attribute) {
            $data["$attribute"] = $modAntrian->$attribute;
        }
        echo CJSON::encode($data);
        Yii::app()->end();
    }
    else
        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
}

  public function actionAutocompletePegawaiUntukPasienBaru($nip = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $cr = new CDbCriteria;
    $cr->compare('lower(nomorindukpegawai)', strtolower("" . $nip . ""), true);
    $cr->addCondition('pegawai_aktif = true');
    $cr->order = 'nama_pegawai asc';

    $model = PegawaiM::model()->findAll($cr);
    $res = array();

    foreach ($model as $item) {
      $p = PasienM::model()->findByAttributes(array(
        'pegawai_id' => $item->pegawai_id
      ));

      $sub = array(
        'label' => $item->nomorindukpegawai . " - " . $item->namaLengkap,
        'pegawai_id' => $item->pegawai_id,
        'nip' => $item->nomorindukpegawai,
        'nama_pegawai' => $item->namaLengkap,
        'sudah_ada' => !empty($p),
      );

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  public function actionGetDataPegawaiUntukPasienBaru()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $pegawai_id = $_POST['pegawai_id'] == "null" ? null : $_POST['pegawai_id'];
    $nip = $_POST['nip'];

    $cr = new CDbCriteria();

    if (!empty($pegawai_id)) {
      $cr->compare('pegawai_id', $pegawai_id);
    } else if (!empty($nip)) {
      $cr->compare('lower(nomorindukpegawai)', strtolower($nip));
    }
    $cr->addCondition('pegawai_aktif = true');

    $model = PegawaiM::model()->find($cr);

    $ok = 1;
    $msg = "";
    $res = array();
    if (empty($model)) {
      $ok = 0;
      $msg = "Pegawai dengan nip " . $nip . " tidak ditemukan";
    } else {
      $pasien = PasienM::model()->findByAttributes(array(
        'pegawai_id' => $model->pegawai_id,
      ));

      if (!empty($pasien)) {
        $ok = 0;
        $msg = "Pegawai dengan nip " . $nip . " sudah didaftarkan sebagai pasien. Mohon cari pegawai di pasien lama.";
      }

      $model->nomobile_pegawai = str_replace(" ", "", $model->nomobile_pegawai);
      $model->tgl_lahirpegawai = date('d/m/Y', strtotime($model->tgl_lahirpegawai));
      $res = $model->attributes;
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg, 'res' => $res));
  }

  public function actionCatatCeklisHakPasien()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    if (isset($_POST['ceklis'])) {
      Yii::app()->user->setState('ceklis_hak_pasien_' . $this->id, $_POST['ceklis']);
    }

    echo CJSON::encode(array('ok' => 1, 'data' => $_POST['ceklis']));
  }

  public function actionSetSudahDibaca()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $pendaftaran = isset($_POST['pendaftaran_id']) && $_POST['pendaftaran_id'] != 0 ? $_POST['pendaftaran_id'] : null;

    if (!empty($pendaftaran)) {
      PendaftaranT::model()->updateByPk($pendaftaran, array(
        'isbacahakpasien' => true,
      ));
      Yii::app()->user->setState('hak_pasien_sudah_baca_' . $this->id, null);
      Yii::app()->user->setState('ceklis_hak_pasien_' . $this->id, null);
    } else {
      Yii::app()->user->setState('hak_pasien_sudah_baca_' . $this->id, 1);
    }

    echo CJSON::encode(['ok' => 1]);
  }

  public function cleanUpSessionPasienSudahBaca($id = null)
  {

    if (!empty(Yii::app()->user->getState('hak_pasien_sudah_baca_' . $this->id)) && Yii::app()->user->getState('hak_pasien_sudah_baca_' . $this->id) == 1) {
      Yii::app()->user->setState('hak_pasien_sudah_baca_' . $this->id, null);
      Yii::app()->user->setState('ceklis_hak_pasien_' . $this->id, null);
      if (!empty($id)) {
        PendaftaranT::model()->updateByPk($id, array(
          'isbacahakpasien' => true,
        ));
      }
    }
  }

  public function actionAjaxLoadPhotoScan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $mips = new MIPS;
    $response = $mips->newFindRecords(date('Y-m-d H:i', strtotime('now - 1 month')), date('Y-m-d H:i', strtotime('now + 1 day')));

    if ($response['success'] != true) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Error. Data tidak dapat di ambil',
      ));

      Yii::app()->end();
    }

    if (count((array)$response['data']) == 0) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Data belum ada',
      ));
      Yii::app()->end();
    }

    $res_dat = $response['data'];
    $sort_time = array();

    foreach ($res_dat as $key => $item) {
      $sort_time[$key] = $item['currentTime'];
    }

    array_multisort($sort_time, SORT_DESC, $res_dat);

    $res = $res_dat[0];

    $res_img = $mips->getRecordImg($res['imageName']);

    $pasien_id = "";
    $no_rm = "";

    if ($res['type'] == MIPS::REG_PASIEN) {
      $no_rm = substr($res['idCardNum'], 1);
      $pasien = PasienM::model()->findByAttributes(array(
        'no_rekam_medik' => $no_rm,
      ));

      if (!empty($pasien)) {
        $pasien_id = $pasien->pasien_id;
      } else {
        $no_rm = "";
      }
    }

    if ($res_img['success'] != true) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Gambar tidak ditemukan',
      ));
      Yii::app()->end();
    }

    echo CJSON::encode(array(
      'ok' => 1,
      'msg' => '',
      'no_rm' => $no_rm,
      'pasien_id' => $pasien_id,
      'html' => $this->renderPartial($this->path_view . "_fotoScan", array(
        'res' => $res,
        'res_img' => $res_img,

      ), true),
    ));
  }

  protected function simpanScanPasien($modPendaftaran, $post)
  {

    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $model = new ScanpasiendarialatT();
    $model->attributes = $post;
    $model->pake_masker = $model->pake_masker == 1;
    $model->pasien_id = $modPendaftaran->pasien_id;
    $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;

    if ($model->save()) {
      $modPendaftaran->suhu_tubuh = $model->suhu_tubuh;
      $modPendaftaran->save();

      if (!empty($model->data_gambar)) {
        $modPasien->setFotoPasienDariPerangkatMIPS($model->data_gambar);
      }
    }

    $response = $this->registerScanMIPS($model, $modPasien);

    //        if ($response['success'] != true) {
    //            Yii::app()->user->setFlash('warning', 'Scan Foto gagal didaftarkan');
    //        }

    // die;
  }

  public function actionSetDropdownLoket()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_nama_loket = $_POST["idModelantrian"];
      $data = array();
      $data['diLoket_antrian'] = '';
      if (empty($id_nama_loket)) {
        $data['diLoket_antrian'] = CHtml::dropDownList('namaLoket', 'namaLoket', array(), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:100px;'));
      } else {
        $data['diLoket_antrian'] = CHtml::dropDownList('namaLoket', 'namaLoket', CHtml::listData(LoketM::model()->findAllByAttributes(array('modelantrian_id' => $id_nama_loket, 'ispendaftaran' => TRUE, 'loket_aktif' => TRUE), array('order' => 'loket_nama ASC')), 'loket_id', 'loket_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:100px;', 'onchange' => 'setFormAntrian("reset");'));
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }
  protected function registerScanMIPS($model, $modPasien)
  {

    $person = array(
      'age' => $modPasien->umurTahun,
      'name' => $modPasien->nama_pasien,
      'prescription' => date('Y-m-d H:i') . ", " . date('Y-m-d H:i', strtotime('now + 1 year')),
      'sex' => $modPasien->jeniskelamin == 'LAKI-LAKI' ? 0 : 1,
      'type' => MIPS::REG_PASIEN,
      'vipID' => "1" . $modPasien->no_rekam_medik,
      'welCome' => '',
      'idCard' => "1" . $modPasien->no_rekam_medik,
      'card' => "1" . $modPasien->no_rekam_medik,
      'wn' => '',
      'imgBase64' => $model->data_gambar,
    );

    $mips = new MIPS();
    $response = $mips->register($person);

    // var_dump($response, $person); die;



    //var_dump($response, $person); die;
    //var_dump($model->attributes, $modPasien->attributes); die;
  }

  public function actionHapusTindakanPemeriksaan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $trans = Yii::app()->db->beginTransaction();
    $ok = 1;
    $msg = "Pemeriksaan berhasil dibatalkan.";



    try {

      $id = $_POST['id'];

      TindakanpelayananT::model()->updateByPk($id, array(
        'detailhasilpemeriksaanlab_id' => null,
      ));

      DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(array(
        'tindakanpelayanan_id' => $id,
      ));

      HasilpemeriksaanradT::model()->deleteAllByAttributes(array(
        'tindakanpelayanan_id' => $id,
      ));

      TindakanpelayananT::model()->deleteByPk($id);

      $trans->commit();
    } catch (Exception $ex) {
      $trans->rollback();
      $ok = 0;
      $msg = "Pemeriksaan gagal dibatalkan.<br/>" . $ex->getMessage();
    }

    echo CJSON::encode(array(
      'ok' => $ok,
      'msg' => $msg,
    ));
  }

  /**
     * - digunakan untuk mencetak sticker
     * @param type $pendaftaran_id
     */
    public function actionPrintLabel($pendaftaran_id)
    {
        // $this->layout='//layouts/printWindows';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        //        $this->render($this->path_view.'printLabel',
        //            array(
        //                'modPendaftaran'=>$modPendaftaran,
        //            )
        //        );
        $posisi = 'L'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', array(40, 60));
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printLabel', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }
}

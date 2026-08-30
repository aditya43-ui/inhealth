<?php

Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalan2Controller');

/**
 * Proses Pendaftaran Pasien Hemodialisa. 
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.pendaftaranPenjadwalan
 * @subpackage controllers
 */
class PendaftaranRawatDaruratHDController extends PendaftaranRawatJalan2Controller
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";
  public $path_viewRD = "pendaftaranPenjadwalan.views.pendaftaranRawatDarurat.";
  public $path_viewRD2 = "pendaftaranPenjadwalan.views.pendaftaranRawatDaruratHD.";
  public $kecelakaantersimpan = false;
  public $jadwalhemodialisatersimpan = false;

  /**
   * Index transaksi pendaftaran hemodialisa
   * @param integer $id
   * @param integer $idSep
   * @param integer $idAntrian
   * @param integer $sk_id
   */
  public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pendaftaran Hemodialisa";
    $modAntrian = new PPAntrianT;
    $format = new MyFormatter();
    $model = new PPPendaftaranT;
    $modPasien = new PPPasienM;
    $modPegawai = new PPPegawaiM;
    $modPenanggungJawab = new PPPenanggungJawabM;
    $modRujukan = new PPRujukanT;
    $modRujukanBpjs = new PPRujukanbpjsT;
    $modRujukanInhealth = new PPRujukanInhealthT;
    $modKecelakaan = new PPPasienkecelakaanT;
    $modTindakan = new PPTindakanPelayananT;
    $modPembayaran = new PPPembayaranpelayananT();
    $modAsuransiPasien = new PPAsuransipasienM;
    $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
    $modAsuransiPasienInhealth = new PPAsuransipasieninhealthM;
    $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
    $modAsuransiPasienDepartemen = new PPAsuransipasiendepartemenM();
    $modAsuransiPasienPekerja = new PPAsuransipasienpegawaiM();
    $modJadwalHD = new PPJadwalhemodialisaT();

    $modSep = new PPSepT;
    $modSepInhealthT = new PPSepInhealthT;
    $modSep->tglsep = date('Y-m-d H:i:s');
    $modSepInhealthT->tglsep = date('Y-m-d H:i:s');
    $modSep->jnspelayanan = 2;
    $modSepInhealthT->jnspelayanan = 3; //defaul RJTL
    $modSep->poli_eksekutif = 0;
    $modSep->cob = 0;
    $modSep->lakalantas = 0;
    $modSep->jenisfaskes = 2; //default RS
    $modSep->katarak = 0;
    $modSep->suplesi_jasaraharja = 0;
    $modSep->status_nosep = "TIDAK";
    $modSep->catatansep = '-';
    $modProfilRS = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
    $modSep->ppkpelayanan = $modProfilRS->ppkpelayanan;
    $modSep->pelayanan = 'RJ';
    $modRujukanBpjs->tanggal_rujukan = date('Y-m-d H:i:s');
    $modRujukanInhealth->tanggal_rujukan = date('Y-m-d H:i:s');
    $modSep->jenis_kunjungan = "0";
    $modSep->asesmen_pelayanan = "";

    $dataTindakans = array();
    $modKarcisV = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->agama = Params::DEFAULT_AGAMA;
    $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $model->is_pasienrujukan = 0;

    $model->jenis_rujukan = 2; //default RS
    $model->jeniskasuspenyakit_id = 55;
    $model->pegawai_id = Params::PEGAWAI_DPJP_ID_STRIP; //kasus penyakit default "UMUM"
    if ($model->pegawai_id) {
      $model->nama_pegawai = PegawaiM::model()->findByPk($model->pegawai_id)->NamaLengkap; //dpjp default "-"
    }
    $modPasien->warga_negara = Params::WARGA_NEGARA_WNI;
    $modPasien->jenisidentitas = Params::JENIS_IDENTITAS_KTP;
    $modPasien->suku_id = Params::SUKU_ID_JAWA;
    $modPasien->pendidikan_id = Params::PENDIDIKAN_ID_TIDAK_DIKETAHUI;
    $modPasien->pekerjaan_id = Params::PEKERJAAN_ID_TIDAK_TAHU;
    
    $cekShiftHd = ShiftHdM::model()->find(" shift_hd_aktif = TRUE AND ( '".date('H:i:s')."' >= shift_hd_jamawal AND '".date('H:i:s')."' <= shift_hd_jamakhir) ");

    if (!empty($cekShiftHd)){
        $model->shift_id = $cekShiftHd->shift_hd_id;
    }

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


    /* Start RSSP-2964 *//*
        if (count((array)$modSmsgateway) > 0) {
            foreach ($modSmsgateway as $value) {
                if ($value->tujuansms == Params::TUJUANSMS_PASIEN) {
                    $model->kirim_sms_pasien = $value->statussms;
                }
                if ($value->tujuansms == Params::TUJUANSMS_DOKTER) {
                    $model->kirim_sms_dokter = $value->statussms;
                }
                if ($value->tujuansms == Params::TUJUANSMS_PENANGGUNGJAWAB) {
                    $model->kirim_pasien_penangungjwb = $value->statussms;
                }
            }
        }
        /* End */

    // LNG-1578 untuk notif pemberitahuan sbelum simpan, jika pasien yang sudah terdaftar	201410001 
    $criteria = new CDbCriteria;
    $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
    $criteria->order = 'tgl_pendaftaran DESC';
    $criteria->limit = 10;
    $modPasienTerakhir = PPInfokunjunganhdV::model()->findAll($criteria);

    //load data dari jadwal HD
    if (isset($_GET['jadwalhemodialisa_id']) && !empty($_GET['jadwalhemodialisa_id'])) {
      $jadwalHD = PPJadwalhemodialisaT::model()->findByPk($_GET['jadwalhemodialisa_id']);
      $modPasien = PPPasienM::model()->findByPk($jadwalHD->pasien_id);
      $model->ruangan_id = $jadwalHD->ruangan_id;
      $model->kamarruangan_id = $jadwalHD->kamarruangan_id;
      $model->jadwalhemodialisa_id = $jadwalHD->jadwalhemodialisa_id; //untuk update jadwalhemodialisa_t
    }

    //==load data
    if (isset($id)) {
      $model = $this->loadModel($id);
      if (isset($idSep)) {
        $Sep = SepT::model()->findByPk($idSep);
        $model->is_bpjs = ($Sep->is_inhealth) ? 0 : 1;
        if ($Sep->is_inhealth) {
          $modRujukanInhealth = PPRujukanInhealthT::model()->findByPk($model->rujukan_id);
          $modAsuransiPasienInhealth = PPAsuransipasieninhealthM::model()->findByPk($model->asuransipasien_id);
          $modSepInhealthT = PPSepInhealthT::model()->findByPk($idSep);
        } else {
          $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
          $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
          $modSep = PPSepT::model()->findByPk($idSep);
        }
      }

      $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = PPRujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataTindakans = PPTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
    }

    $pasien_id = (isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null);
    if (isset($pasien_id)) {
      $modPasien = PPPasienM::model()->findByPk($pasien_id);
      $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
    }

    if (isset($_POST['bookingkamar_id'])) { //dari informasi booking kamar
      if (!empty($_POST['bookingkamar_id'])) {
        $modBookingKamar = PPBookingKamarT::model()->findByPk($_POST['bookingkamar_id']);
        $modPasien = PPPasienM::model()->findByPk($modBookingKamar->pasien_id);
        if ($modPasien->ispasienluar == TRUE) {
          $modPasien->no_rekam_medik = null;
          $modPasien->pasien_id = null;
        }
        if (!empty($modBookingKamar->ruangan_id))
          $model->ruangan_id = $modBookingKamar->ruangan_id;
        if (!empty($modBookingKamar->kamarruangan_id))
          $model->kamarruangan_id = $modBookingKamar->kamarruangan_id;
        if (!empty($modBookingKamar->kamarruangan_id))
          $model->kelaspelayanan_id = $modBookingKamar->kelaspelayanan_id;
        if (!empty($modBookingKamar->pegawai_id))
          $model->pegawai_id = $modBookingKamar->pegawai_id;
      }
    }

    if (!empty($modPasien->pegawai_id)) {
      $modPegawai->attributes = $modPasien->pegawai->attributes;
    }

    if (isset($_POST['PPPendaftaranT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {          
        $modPasien = $this->simpanPasien($modPasien, $_POST['PPPasienM']);

        if (isset($_POST['PPPendaftaranT']['is_adapjpasien']) && $_POST['PPPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['PPPenanggungJawabM'])) {
            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['PPPenanggungJawabM']);
          }
        } else {
          $this->penanggungjawabtersimpan = true;
        }

        if (isset($_POST['PPPendaftaranT']['is_pasienrujukan']) && $_POST['PPPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['PPRujukanT'])) {
            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['PPRujukanT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }
       
        if (isset($_POST['PPPendaftaranT']['is_bpjs']) && $_POST['PPPendaftaranT']['is_bpjs']) {
          if (isset($_POST['PPRujukanbpjsT'])) {
            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }
        /* Untuk penjamin inhealth */
        if (isset($_POST['PPRujukanInhealthT'])) {
          $modRujukanInhealth = $this->simpanRujukanBpjs($modRujukanInhealth, $_POST['PPRujukanInhealthT']);
        }

        if (isset($_POST['PPAsuransipasienM'])) {
          if (isset($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
              $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienM']);
        } else {
          $asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienbpjsM'])) {
          if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
              $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
        } else {
          $asuransipasientersimpan = true;
        }
        
        /* Untuk penjamin inhealth */
        if (isset($_POST['PPAsuransipasieninhealthM'])) {
          if (isset($_POST['PPAsuransipasieninhealthM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasieninhealthM']['asuransipasien_id'])) {
              $modAsuransiPasienInhealth = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasieninhealthM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienInhealth = $this->simpanAsuransiPasien($modAsuransiPasienInhealth, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasieninhealthM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPPendaftaranT']['is_bpjs']) && $_POST['PPPendaftaranT']['is_bpjs']) {
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanBpjs, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasienBpjs);
          if (isset($_POST['PPSepT'])) {
            $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
            if (isset($modSep->sep_id) && !empty($modSep->sep_id)) { //update sep_id ke pendaftaranT
              $model->sep_id = $modSep->sep_id;
              $model->save();
            }
          }
        } else {
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasien);
        }

        /* Untuk penjamin inhealth */
        if (isset($_POST['PPSepInhealthT'])) {
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanInhealth, $modAsuransiPasienInhealth, $_POST['PPSepInhealthT']);
          $model->sep_id = $modSep->sep_id;
          PPSepInhealthT::model()->updateByPk($modSep->sep_id, array('is_inhealth' => true));
          $model->update();
        }

        //untuk update jadwal HD - Berarti daftar dari info jadwal HD - RSKG-679
        if (!empty($model->jadwalhemodialisa_id)) {
          $this->updateJadwalHD($model);
        }

        $this->karcistersimpan = true;
        $this->komponentindakantersimpan = true;
        if (isset($_POST['PPPendaftaranT']['is_adakarcis']) && $_POST['PPPendaftaranT']['is_adakarcis']) {
          if (isset($_POST['PPTindakanPelayananT'])) {
            if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
              foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
                if ($karcis['is_pilihtindakan']) {
                  $dataTindakans[$i] = $this->simpanKarcis($modTindakan, $model, $karcis);
                }
              }
            }
            if (isset($_POST['PPPendaftaranT']['is_bayarkarcis'])) { //fitur belum ada >> RND-666
              if ($_POST['PPPendaftaranT']['is_bayarkarcis']) { //jika di ceklis
              }
            }
          }
        }
        
        $ok_vaksinasi = true;
                    
                    
        if ($_POST['PPPendaftaranT']['is_vaksinasi'] && isset($_POST['RiwayatvaksinasipasienT']['detail'])) {
            $ok_vaksinasi = RiwayatvaksinasipasienT::simpanRiwayat($model->pendaftaran_id, $model->pasien_id, $_POST['RiwayatvaksinasipasienT']['detail']);
        }

        if (isset($_POST['scan'])) {
          $this->simpanScanPasien($model, $_POST['scan']);
        }
        
        if (!empty($_POST['PPJadwalhemodialisaT'])) {
            $modJadwalHD = new PPJadwalhemodialisaT();
            $modJadwalHD->attributes = $_POST['PPJadwalhemodialisaT'];
            
            $hari = $modJadwalHD->jadwalhemodialisa_hari;
            $harijad = 'jadwalhari_hari_'.strtolower($hari);
            
            $jadwalhari = JadwalhariM::model()->findByAttributes([
                $harijad => true
            ]);
            $modJadwalHD->jadwalhari_id = !empty($jadwalhari->jadwalhari_id)?$jadwalhari->jadwalhari_id:1;
            $modJadwalHD->ruangan_id = $model->ruangan_id;
            $modJadwalHD->pendaftaran_id = $model->pendaftaran_id;

            $jml = JadwalhemodialisaT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id));
            if(!empty($jml)){
                $jadwal_ke = count($jml)+1;
            }else{
                $jadwal_ke = 1;
            }

            $modJadwalHD->jadwalhemodialisa_tgl_ke = MyFormatter::formatDateTimeForDb($_POST['PPJadwalhemodialisaT']['jadwalhemodialisa_tgl_ke']);
            $modJadwalHD->jadwalhemodialisa_ke = $jadwal_ke;
            $modJadwalHD->jadwalhemodialisa_status = false;
            $modJadwalHD->pegawai_id = Yii::app()->user->getState('pegawai_id');
            $modJadwalHD->membuat_id = Yii::app()->user->getState('pegawai_id');
            $modJadwalHD->mengetahui_id = Yii::app()->user->getState('pegawai_id');
            $modJadwalHD->pasien_id = $modPasien->pasien_id;
            $modJadwalHD->kamarruangan_id = $model->kamarruangan_id;
            $modJadwalHD->jh_create_time = date("Y-m-d H:i:s");
            $modJadwalHD->jh_create_loginid = Yii::app()->user->id;
            $modJadwalHD->jh_create_ruanganid = Yii::app()->user->getState('ruangan_id');
            $modJadwalHD->jh_create_ruanganiphost = getHostByName(getHostName());                    
            $modJadwalHD->validate();
            if($modJadwalHD->save()){
                $this->jadwalhemodialisatersimpan = true;
            }                                
        }else{
            $this->jadwalhemodialisatersimpan = true;
        }       
        
        $judul = 'Pendaftaran Pasien';

        if ($model->statuspasien == 'PENGUNJUNG LAMA') {
          $judul .= " Lama";
        } else $judul .= " Baru";

        $judul .= " Hemodialisa";

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;

        $link_hd = $this->createUrl('/hemodialisa/DaftarPasien/index', array(
          'HDInfoKunjunganRDV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
          'HDInfoKunjunganRDV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
          'HDInfoKunjunganRDV[tgl_awall]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
          'HDInfoKunjunganRDV[tgl_akhirl]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
          'HDInfoKunjunganRDV[ceklis]' => 0,
          'HDInfoKunjunganRDV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
          'HDInfoKunjunganRDV[no_pendaftaran]' => substr($model->no_pendaftaran, 2),
          'HDInfoKunjunganRDV[nama_pasien]' => $model->pasien->nama_pasien,
        ));

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => Params::INSTALASI_ID_HD, 'ruangan_id' => $model->ruangan_id, 'modul_id' => Params::MODUL_ID_HEMO,  'link_proses' => $link_hd),
        ));

       
        if ($this->jadwalhemodialisatersimpan && $this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan) {
            $model->status_hd = 'ANTRIAN';
            $model->lantai_hd = !empty($_POST['PPPendaftaranT']['lantai_hd']) ? $_POST['PPPendaftaranT']['lantai_hd'] : null;
            $model->save();                    
            
          // SMS GATEWAY
          $modPegawai = $model->pegawai;
          $modRuangan = $model->ruangan;
          $sms = new Sms();
          $smspasien = 1;
          $smsdokter = 1;
          $smspenanggungjawab = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

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
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tgl_pendaftaran), $isiPesan);
            $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

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
              if (!empty($modPenanggungJawab->no_mobilepj) && $kirim_pasien_penangungjwb) {
                $sms->kirim($modPenanggungJawab->no_mobilepj, $isiPesan);
              } else {
                $smspenanggungjawab = 0;
              }
            }
          }
            
            if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] == 1) {
                $this->kirimWhatsApp($model, $modPasien);
            }
//            die;
          
          // END SMS GATEWAY
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");

          //RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
          if ($this->septersimpan) {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
          } else {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();

        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modRujukan' => $modRujukan,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modRujukanInhealth' => $modRujukanInhealth,
      'modKecelakaan' => $modKecelakaan,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
      'modAntrian' => $modAntrian,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
      'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
      'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
      'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
      'modSep' => $modSep,
      'modSepInhealthT' => $modSepInhealthT,
      'modSmsgateway' => $modSmsgateway,
      'modKarcisV' => $modKarcisV,
      'modPasienTerakhir' => $modPasienTerakhir,
      'modJadwalHD' => $modJadwalHD
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

  /**
   * verifikasi pendaftaran
   */
  public function actionVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $this->layout = '//layouts/iframe';
      if (isset($_POST['PPPendaftaranT'])) {
        $format = new MyFormatter();
        $model = new PPPendaftaranT;
        $modPasien = new PPPasienM;
        $modPegawai = new PPPegawaiM;
        $modPenanggungJawab = null;
        $modRujukan = null;
        $modTindakan = null;
        $modKecelakaan = null;

        $model->attributes = $_POST['PPPendaftaranT'];
        $model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
        $modPasien->attributes = $_POST['PPPasienM'];
        $modPasien->nama_bin = $_POST['PPPasienM']['nama_bin'];
        if (!empty($modPasien->pegawai_id)) {
          $modPegawai->attributes = $modPasien->pegawai->attributes;
        }
        if (isset($_POST['PPPendaftaranT']['is_adapjpasien'])) {
          if (isset($_POST['PPPenanggungJawabM'])) {
            $modPenanggungJawab = new PPPenanggungJawabM;
            $modPenanggungJawab->attributes = $_POST['PPPenanggungJawabM'];
          }
        }
        if (isset($_POST['PPPendaftaranT']['is_adakarcis'])) {
          if (isset($_POST['PPTindakanPelayananT'])) {
            if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
              foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
                if ($karcis['is_pilihtindakan']) {
                  $modTindakan = new PPTindakanPelayananT;
                  $modTindakan->attributes = $karcis;
                  $modTindakan->karcis_id = $karcis['karcis_id'];
                }
              }
            }
          }
        }

        if (isset($_POST['PPPendaftaranT']['is_pasienrujukan'])) {
          if (isset($_POST['PPRujukanT'])) {
            $modRujukan = new PPRujukanT;
            $modRujukan->attributes = $_POST['PPRujukanT'];
            $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
          }
        }
      }
      echo CJSON::encode(array(
        'content' => $this->renderPartial('verifikasi', array(
          'model' => $model,
          'modPasien' => $modPasien,
          'modPegawai' => $modPegawai,
          'modPenanggungJawab' => $modPenanggungJawab,
          'modRujukan' => $modRujukan,
          'modTindakan' => $modTindakan,
          'modKecelakaan' => $modKecelakaan,
          'format' => $format,
        ), true)
      ));
      exit;
    }
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
   * Get data pasien hemodialisa
   */
  public function actionGetDaftarHDPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $returnVal = array();
      if (!empty($pasien_id)) {
        $criteria = new CDbCriteria();
        if (!empty($pasien_id)) {
          $criteria->addCondition("pasien_id = " . $pasien_id);
        }
        if (!empty($ruangan_id)) {
          $criteria->addCondition("ruangan_id = '" . $ruangan_id . "'");
        }
        $tgl_awal = date('Y-m-d');
        $tgl_akhir = date('Y-m-d');
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_awal, $tgl_akhir);
        $model = InfokunjunganhdV::model()->findAll($criteria);
        //                echo count((array)$model);exit;
        if (count((array)$model) > 0) {
          $returnVal['status'] = 'Ya';
          $returnVal['pesan'] = "Pasien sudah didaftarkan hari ini  : <br/>";
          $returnVal['pesan'] .= "<ol type=1>";
          foreach ($model as $i => $ruangan) {
            $returnVal['pesan'] .= "<li>" . $ruangan->ruangan_nama . " - " . ($format->formatDateTimeForUser($ruangan->tgl_pendaftaran)) . "</li>";
          }
          $returnVal['pesan'] .= "</ol>";
        } else {
          $returnVal['status'] = 'Tidak';
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Print status rawat RD
   * @param integer $pendaftaran_id
   */
  public function actionPrintStatusRD($pendaftaran_id)
  {
    // $this->layout = '//layouts/printWindows';
    // $format = new MyFormatter;
    // $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    // $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    // $karcis_id = null;
    // $modTindakan = TindakanpelayananT::model()->findByAttributes(array('pasien_id' => $modPasien->pasien_id, 'pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    // $judul_print = 'Kunjungan Rawat Darurat';
    // $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat.printStatusRD', array(
    //   'format' => $format,
    //   'modPendaftaran' => $modPendaftaran,
    //   'judul_print' => $judul_print,
    //   'modPasien' => $modPasien,
    //   'modTindakan' => $modTindakan,
    // ));
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPenanggungjawab = array();
    if (!empty($modPendaftaran->penanggungjawab_id)) {
        $modPenanggungjawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    }
    $karcis_id = null;
    $modTindakan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
    $judul_print = 'Kunjungan Rawat Jalan';

    $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat.printStatusRD2', array(
        'format' => $format,
        'modPendaftaran' => $modPendaftaran,
        'modPenanggungjawab' => $modPenanggungjawab,
        'judul_print' => $judul_print,
        'modPasien' => $modPasien,
        'modTindakan' => $modTindakan,
    ));
  }

  /**
   * Print status pendaftaran hemodialisa
   * @param integer $pendaftaran_id
   */
  public function actionPrintStatus($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPenanggungjawab = array();
    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungjawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    }
    $karcis_id = null;
    $modTindakan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
    $judul_print = 'Kunjungan Rawat Darurat';
    $this->render($this->path_view . 'printStatus', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPenanggungjawab' => $modPenanggungjawab,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakan' => $modTindakan,
    ));
  }

  /**
   * Print etiket pasien hemodialisa
   * @param integer $pasien_id
   * @param integer $pendaftaran_id
   */
  public function actionPrintEtiketPasienRD($pasien_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPasien = PasienM::model()->findByPk($pasien_id);

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPendaftaran->printetiket_jml += 1;
    $modPendaftaran->printetiket = true;
    $modPendaftaran->update(array('printetiket', 'printetiket_jml'));

    $this->render(
      $this->path_viewRD . 'printEtiketPasienRD',
      array(
        'modPasien' => $modPasien,
        'modPendaftaran' => $modPendaftaran,
      )
    );
  }

  /**
   * Print identitas pasien Hemodialisa
   * @param integer $pasien_id
   * @param integer $pendaftaran_id
   */
  public function actionPrintIdentitasPasienRD($pasien_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPasien = PasienM::model()->findByPk($pasien_id);

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPendaftaran->printetiket_jml += 1;
    $modPendaftaran->printetiket = true;
    $modPendaftaran->update(array('printetiket', 'printetiket_jml'));

    $this->render(
      $this->path_viewRD2 . 'printEtiketPasienRDHD',
      array(
        'modPasien' => $modPasien,
        'modPendaftaran' => $modPendaftaran,
      )
    );
  }

  /**
   * Print lembar resep pasien
   * @param integer $pasien_id
   * @param integer $pendaftaran_id
   */
  public function actionPrintLembarResep($pasien_id, $pendaftaran_id)
  {
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $ukuranKertasPDF = 'A4'; //Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
    $posisi = 'P'; //Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
    ob_end_clean();
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    $mpdf->debug = true;
    $mpdf->mirrorMargins = 2;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
    $mpdf->WriteHTML($this->renderPartial($this->path_viewRD2 . 'printLembarResepNew', array('modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran), true));
    $mpdf->SetJS('this.print();');
    $mpdf->Output();
  }

  /**
   * Autocomplete data pegawai dokter
   */
  public function actionAutocompleteDokter()
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;

    $prov = PegawaiV::model()->searchDokterDPJP();
    $prov->criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['nama_pegawai']), true);
    $prov->sort->defaultOrder = 'nama_pegawai';
    if (!empty($ruangan_id)) {
      $prov->criteria->join = "JOIN ruanganpegawai_m on ruanganpegawai_m.pegawai_id=t.pegawai_id";
      $prov->criteria->addCondition('ruangan_id=' . $ruangan_id);
    }
    $prov->pagination = false;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;
      $sub['nama_pegawai'] = $item->nama_pegawai;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  /**
   * Set dropdown kelas pelayanan berdasarkan ruangan
   */
  public function actionSetDropdownKelasPelayananRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $kelasPelayanan = null;
      $option = null;
      if ($ruangan_id) {
        $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan_id . ' and kelaspelayanan_aktif = true');
        $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
      }
      if (empty($kelasPelayanan)) {
        $option .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        foreach ($kelasPelayanan as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listKelas'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * Set dropdown kamar yang kosong
   * @param integer $encode
   * @param integer $namaModel
   * @param integer $attr
   */
  public function actionSetDropdownKamarKosong($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      if (empty($ruangan_id) && isset($_POST[$namaModel]['ruangan_id']))
        $ruangan_id = $_POST[$namaModel]['ruangan_id'];

      $bookingkamar_id = (isset($_POST['bookingkamar_id']) ? $_POST['bookingkamar_id'] : null);
      if (empty($bookingkamar_id) && isset($_POST[$namaModel]['bookingkamar_id']))
        $bookingkamar_id = $_POST[$namaModel]['bookingkamar_id'];

      $kamarKosong = array();
      if (!empty($ruangan_id)) {
        if (!empty($bookingkamar_id)) {
          $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true));

          $modBookingKamar = BookingkamarT::model()->findByPk($bookingkamar_id);
        } else {
          $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true));
        }
        $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
      }

      if ($encode) {
        echo CJSON::encode($kamarKosong);
      } else {
        if (empty($kamarKosong)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          foreach ($kamarKosong as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Load data kamar kosong
   * @param boolean $encode
   */
  public function actionGetKamarKosong($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_POST['kelaspelayanan_id'])) {
        $ruangan_id = $_POST['ruangan_id'];
        $kelaspelayanan_id = ($_POST['kelaspelayanan_id'] == '' ? 0 : $_POST['kelaspelayanan_id']);

        $kamarKosong = array();
        if (!empty($ruangan_id)) {
          $kamarKosong = KamarruanganM::model()->findAllByAttributes(
            array(
              'ruangan_id' => $ruangan_id,
              'kelaspelayanan_id' => $kelaspelayanan_id,
              'kamarruangan_status' => (isset($_POST['is_status']) ? $_POST['is_status'] : true)
            )
          );
          $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
        }
      } else {
        $ruangan_id = $_POST['ruangan_id'];
        $kamarKosong = array();
        if (!empty($ruangan_id)) {
          $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true));
          $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
        }
      }

      if ($encode) {
        echo CJSON::encode($kamarKosong);
      } else {
        if (empty($kamarKosong)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          if (count((array)$kamarKosong) > 1) {
            //						echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
          }
          foreach ($kamarKosong as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Update jadwal hemodialisa
   * @param array $model
   */
  public function updateJadwalHD($model)
  {
    $updateJadwal = PPJadwalhemodialisaT::model()->updateByPk($model->jadwalhemodialisa_id, array('pendaftaran_id' => $model->pendaftaran_id));
  }

  //untuk sementara action di deklarasikan juga di disini
  //Fungsi ini dikomen karena extend dari RJ//
  /* public function actionGetDataPasien() {
      if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();

      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pasien_id)) {
      $criteria->addCondition("pasien_id = " . $pasien_id);
      }
      if (!empty($no_rekam_medik)) {
      $criteria->addCondition("no_rekam_medik = '" . $no_rekam_medik . "'");
      }
      $criteria->addCondition('ispasienluar = FALSE');
      $model = PasienM::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
      $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["fingerprint_data"] = null;
      $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
      $pendaftaran = PPPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $pasien_id));
      if (count((array)$pendaftaran)) {
      $bl = 0;
      foreach ($pendaftaran as $i => $daftar) {
      $blacklist = PPPasienblacklistT::model()->findAllByAttributes(array('pendaftaran_id' => $daftar->pendaftaran_id));
      if (count((array)$blacklist)) {
      $bl++;
      }
      }
      if (isset($bl)) {
      $returnVal["blacklist"] = $bl;
      } else {
      $returnVal["blacklist"] = 0;
      }
      }
      if (!empty($model->pegawai_id)) {
      $returnVal['nomorindukpegawai'] = $model->pegawai->nomorindukpegawai;
      $returnVal['nama_pegawai'] = $model->pegawai->nama_pegawai;
      $returnVal['gelardepan'] = $model->pegawai->gelardepan;
      $returnVal['unit_perusahaan'] = $model->pegawai->unit_perusahaan;
      $returnVal['gelarbelakang_nama'] = isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "";
      $returnVal['jabatan_nama'] = isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "";
      $returnVal["nomorindukpegawai"] = $model->pegawai->nomorindukpegawai;
      }

      if (strpos($model->namadepan, " ") == false) {
      $returnVal["namadepan"] = $model->namadepan . " ";
      } else {
      $returnVal["namadepan"] = $model->namadepan;
      }

      echo CJSON::encode($returnVal);
      }
      Yii::app()->end();
      } */

  /**
   * Set umur pasien
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
         * Set dropdown daerah pasien, dari propinsi kabupaten kecamatan dan kelurahan
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
   * Set riwayat kunjungan pasien
   */
  public function actionSetRiwayatKunjunganPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['table'] = "";
      $modPasien = new PPPasienM;
      $modPasien->pasien_id = $_POST['pasien_id'];
      $data['table'] = $this->renderPartial($this->path_view . '_tableRiwayatPasien', array(
        'modPasien' => $modPasien,
      ), true);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Set data asuransi pasien lama
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
      if (!empty($model)) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $data["$attribute"] = $model->$attribute;
        }
        $data["penjamin_nama"] = $model->penjamin->penjamin_nama;
        $data['listPenjamin'] = "";
        $penjamin = PenjaminpasienM::model()->findAllByAttributes(array(
          'carabayar_id' => $model->carabayar_id,
          'penjamin_aktif' => true
        ), array('order' => 'penjamin_nama ASC'));
        if (count((array)$penjamin) > 1) {
          $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
        foreach ($penjamin as $value => $name) {
          $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      } else {
        $data = null;
      }
      echo CJSON::encode($data);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Set Dropdown jenis kasus penyakit
   */
  public function actionSetDropdownJeniskasuspenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new PPPendaftaranT;
      $option = '';
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
        $jml = count((array)$data);
        $count = 0;
        foreach ($data as $value => $name) {
          if ($count == 0 && $jml > 1) {
            $option .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          $count++;
        }
      }
      $dataList['listKasuspenyakit'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * Set Dropdown dokter ruangan
   */
  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new PPPendaftaranT;
      $option = '';
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getDokterItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        $jml = count((array)$data);
        $count = 0;
        foreach ($data as $value => $name) {
          if ($count == 0 && $jml > 1) {
            $option .= CHtml::tag('option', array('value' => ''), CHtml::encode('--Pilih--'), true);
          }
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          $count++;
        }
      }
      $dataList['listDokter'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * Set antrian ruangan
   */
  public function actionSetAntrianRuangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $data = array();
      $data['maxantrianruangan'] = null;
      $data['no_urutantri'] = '001';
      if (!empty($ruangan_id)) {
        if (!empty($pegawai_id)) {
          $data['no_urutantri'] = MyGenerator::noAntrianBerdasarkanDokter($ruangan_id, $pegawai_id);
        } else {
          //                    $data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
          $data['no_urutantri'] = MyGenerator::noAntrianPPKonsul($ruangan_id); //fungsi diganti karena no antrian duplikat ketika ada konsul poli ke ruangan.
        }
        $criteria = new CDbCriteria;
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
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
   * Load data antrian dokter
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
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
        $criteria->addCondition("pegawai_id = " . $pegawai_id);
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
   * Set load data karcis
   */
  public function actionSetKarcis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $modTindakan = new PPTindakanPelayananT;
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $pasien_id = $_POST['pasien_id'];
      $penjamin_id = $_POST['penjamin_id'];
      $form = '';

      $is_pasienbaru = 'true';
      if (!empty($ruangan_id)) {
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
        $modKarcisAll = KarcisV::model()->findAll($criteria);

        if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
          $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
        }
        $modKarcisV = KarcisV::model()->findAll($criteria);

        // susun karcis global
        $modKarcisFinal = array();
        $modKarcisAda = array();
        foreach ($modKarcisAll as $item) {
          if (empty($modKarcisAda[$item->daftartindakan_id])) {
            $modKarcisAda[$item->daftartindakan_id] = 1;
            $modKarcisFinal[] = $item;
          }
        }

        $form = $this->renderPartial($this->path_view . '_formKarcis', array(
          'modKarcisAll' => $modKarcisFinal, 'modKarcisV' => $modKarcisV,
          'modTindakan' => $modTindakan, 'format' => $format
        ), true);
        $data['listKarcis'] = $form;
        echo json_encode($data);
        Yii::app()->end();
      }
      $data['listKarcis'] = $form;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Autcomplte data pasien lama
   * @throws CHttpException
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
        $criteria->addCondition('ispasienluar = FALSE');
        $criteria->order = 'no_rekam_medik DESC';
        $criteria->limit = 5;
        $models = PasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . (!empty($model->nama_ayah) ? $model->nama_ayah : "(nama ayah tidak ada)") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
        $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
        $criteria->order = 'pegawai_m.pegawai_id DESC';
        $criteria->limit = 5;
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
   * Set Dropdown kabupaten
   * @param boolean $encode
   * @param string $model_nama
   * @param string $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
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
   * Set dropdown kecamatan
   * @param booleans $encode
   * @param string $model_nama
   * @param string $attr
   */
  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
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
   * @author Tantowy <tantowijaya@.com>
   * Fungsi untuk autocomplete PPJP
   * @throws CHttpException
   */
  public function actionAutocompletePPJP($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;

    $prov = PegawaiV::model()->searchPPJP();
    $prov->criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['nama_pegawai']), true);
    $prov->sort->defaultOrder = 'nama_pegawai';
    if (!empty($ruangan_id)) {
      $prov->criteria->join = "JOIN ruanganpegawai_m on ruanganpegawai_m.pegawai_id=t.pegawai_id";
      $prov->criteria->addCondition('ruangan_id=' . $ruangan_id);
    }
    $prov->pagination = false;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;
      $sub['nama_pegawai'] = $item->nama_pegawai;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
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
  
  /** 
     * Load data kamar kosong
     * @param boolean $encode
     */
    public function actionGetKamarKosongByKelasLantai($encode = false) {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['kelaspelayanan_id'])) {
                $ruangan_id = $_POST['ruangan_id'];
                $kelaspelayanan_id = ($_POST['kelaspelayanan_id'] == '' ? 0 : $_POST['kelaspelayanan_id']);
                $lantai_hd = ($_POST['lantai_hd'] == '' ? 0 : $_POST['lantai_hd']);

                $kamarKosong = array();
                if (!empty($ruangan_id)) {
                    $kamarKosong = KamarruanganM::model()->findAllByAttributes(
                            array(
                                'ruangan_id' => $ruangan_id,
                                'kelaspelayanan_id' => $kelaspelayanan_id,
                                'kamarruangan_status' => (isset($_POST['is_status']) ? $_POST['is_status'] : true),
                                'kamarruangan_nokamar' => $lantai_hd
                            )
                    );
                    
                    $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'TempatTidur');
                }
            } else {
                $ruangan_id = $_POST['ruangan_id'];
                $kamarKosong = array();
                if (!empty($ruangan_id)) {
                    $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true));
                    $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'TempatTidur');
                }
            }

            if ($encode) {
                echo CJSON::encode($kamarKosong);
            } else {
                if (empty($kamarKosong)) {
                    echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
                } else {
                    if (count($kamarKosong) > 1) {
//						echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
                    }
                    foreach ($kamarKosong as $value => $name) {
                        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    /**
     * untuk ajax action set hari berdasarkan tanggal yang dipilih
     */
    public function actionKonfersitanggal() {
        if (Yii::app()->request->isAjaxRequest) {
            $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : null;
            $konversi_ke_db = MyFormatter::formatDateTimeForDb($tanggal);
            $konversi_ke_inggris = date('w', strtotime($konversi_ke_db));
            $konversi_ke_indonesia = MyFormatter::getDayUser($konversi_ke_inggris);
            
            echo CJSON::encode(array('value' => $konversi_ke_indonesia));
            exit;
        }
    }

    public function actionSuratPersetujuanUmum($pendaftaran_id){
 
        $this->layout = '//layouts/iframe';

    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasienAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $modSurat = new SuratpernyataanumumT();
    $modSurat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modSurat->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
    if (!empty($id)) {
        $modSurat = SuratpernyataanumumT::model()->findByPk($id);
    }
    $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    $judulLaporan = 'FORMULIR SURAT PERSETUJUAN <br> 
                        UMUM PASIEN HEMODIALISA ';

    $loadData = array();
    $modForm = FormpernyataankhususM::model()->findAllByAttributes(['formpernyataankhusus_aktif' => true]);
    $modSuratKhusus = new SuratpernyataankhususT();
    if (!empty($modForm)) {
        foreach ($modForm as $key => $det) {
            $id = $det['formpernyataankhusus_id'];

            $loadData[$id]['formpernyataankhusus_id'] = $id;
            $loadData[$id]['formpernyataankhusus_nama'] = $det['formpernyataankhusus_nama'];
            $loadData[$id]['haschecklist'] = ($det['haschecklist'] == true) ? 1 : 0;
        }
    }

    if (isset($_POST['SuratpernyataankhususT'])) {
        $ok = true;
        $pesan = '';
        $trans = Yii::app()->db->beginTransaction();
        
        try {
            $proses = SuratpernyataanumumT::simpan_data($modSurat, $_POST['SuratpernyataanumumT']);
            $modSuratSimpan = $proses['model'];
            $ok &= $proses['sukses'];
            $pesan .= $proses['pesan'];

            $proses2 = SuratpernyataankhususT::simpan_data($modSurat, $_POST['SuratpernyataankhususT']);
            $model2 = $proses2['model'];
            $ok &= $proses2['sukses'];
            $pesan .= $proses2['pesan'];

            if ($ok) {
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $trans->commit();
                $this->redirect(array('suratPernyataanKhusus', 'pendaftaran_id' => $pendaftaran_id, 'id' => $modSuratSimpan->suratpernyataanumum_id, 'sukses' => 1));
            } else {
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan <br/>" . $pesan);
            }
        } catch (Exception $ex) {
            $trans->rollback();
            Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($ex, true));
        }
    }

    $this->render($this->path_viewRD2 . '/suratPersetujuan/_1_suratPertama', [
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modPasienAdmisi' => $modPasienAdmisi,
        'modSurat' => $modSurat,
        'modPenanggungJawab' => $modPenanggungJawab,
        'judulLaporan' => $judulLaporan,
        'loadData' => $loadData,
        'modSuratKhusus' => $modSuratKhusus
    ]);

  }

  public function actionAutocompleteItemSEP() {
    if (Yii::app()->request->isAjaxRequest) {
        $returnVal = array();
        $term = $_GET['term'];
        $item = $_GET['item'];
        $bpjs = new BpjsVklaim();
        
        /* Load data diagnosa*/
        if($item=="diagnosa"){
            $response = json_decode($bpjs->search_diagnosa($term,'', ''), true);
            if (!empty($response['response'])) {
                foreach ($response['response']['diagnosa'] as $i => $value) {
                    $returnVal[$i]['label'] = $value['nama'];
                    $returnVal[$i]['kode'] = $value['kode'];
                    $returnVal[$i]['nama'] = $value['nama'];
                }
            }
        }
        /* Load data poli / sub spesialis */
        if($item=="poli"){
            $response = json_decode($bpjs->search_poli($term), true);
            if (!empty($response['response'])) {
                foreach ($response['response']['poli'] as $i => $value) {
                    $returnVal[$i]['label'] = $value['kode']." - ".$value['nama'];
                    $returnVal[$i]['kode'] = $value['kode'];
                    $returnVal[$i]['nama'] = $value['nama'];
                }
            }
        }
        /* Load data ppk / faskes bpjs */
        if($item=="ppk"){
            $response = json_decode($bpjs->fasilitas_kesehatan($term.'/1','',''), true);
            /* Pertama load dengan jenis non reumah sakit */
            if (!empty($response['response'])) {
                foreach ($response['response']['faskes'] as $i => $value) {
                    $returnVal[$i]['label'] = $value['nama'];
                    $returnVal[$i]['kode'] = $value['kode'];
                    $returnVal[$i]['nama'] = $value['nama'];
                }
            }else{
                /* Pertama load dengan jenis reumah sakit */
                $response = json_decode($bpjs->fasilitas_kesehatan($term.'/2','',''), true);
                if (!empty($response['response'])) {
                    foreach ($response['response']['faskes'] as $i => $value) {
                        $returnVal[$i]['label'] = $value['nama'];
                        $returnVal[$i]['kode'] = $value['kode'];
                        $returnVal[$i]['nama'] = $value['nama'];
                    }
                }
            }
        }
        
        echo CJSON::encode($returnVal);
        
    } else {
        throw new CHttpException(403, 'Tidak dapat mengurai data');
        Yii::app()->end();
    }
  }
}

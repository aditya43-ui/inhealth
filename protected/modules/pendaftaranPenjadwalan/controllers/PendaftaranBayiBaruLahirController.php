<?php

Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalanController');
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatInapController');

class PendaftaranBayiBaruLahirController extends PendaftaranRawatInapController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";
  public $path_view_ri = "pendaftaranPenjadwalan.views.pendaftaranRawatInap.";
  public $path_view_bayi = "pendaftaranPenjadwalan.views.pendaftaranBayiBaruLahir.";
  public $pasientersimpan = false;
  public $pendaftarantersimpan = false;
  public $penanggungjawabtersimpan = false;
  public $karcistersimpan = false;
  public $komponentindakantersimpan = false;
  public $rujukantersimpan = false;
  public $masukkamartersimpan = false;
  public $admisitersimpan = false;
  public $asuransipasientersimpan = false;
  public $langsung = false;

  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pendaftaran Bayi Baru Lahir";
    $format = new MyFormatter();
    $model = new PPPendaftaranT('daftar_bayi');
    $modPasien = new PPPasienM('search');
    $modPegawai = new PPPegawaiM;
    $modPasienAdmisi = new PPPasienAdmisiT;
    $modPenanggungJawab = new PPPenanggungJawabM;
    $modRujukan = new PPRujukanT;
    $modRujukanBpjs = new PPRujukanbpjsT;
    $modTindakan = new PPTindakanPelayananT;
    $modPembayaran = new PPPembayaranpelayananT();
    $modAntrian = new PPAntrianT;
    $modAsuransiPasien = new PPAsuransipasienM;
    $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
    $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
    $modAsuransiPasienDepartemen = new PPAsuransipasiendepartemenM();
    $modAsuransiPasienPekerja = new PPAsuransipasienpegawaiM();
    $modSep = new PPSepT;
    $modSep->statuskecelakaan_kode = "0";
    $modSep->catatansep = "-";
    
    $dataTindakans = array();
    $modKarcisV = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->cekinap = 'ada';

    //$modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    //$modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    //$modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    //$modPasien->agama = Params::DEFAULT_AGAMA;
    $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $model->is_pasienrujukan = 1;
    $model->is_asubadak = 0;
    $model->is_asudepartemen = 0;
    $model->is_asupekerja = 0;
    $model->is_adapjpasien = 0;

    
    $modSep->jenis_kunjungan = "0";
    $modSep->asesmen_pelayanan = "";

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller) . "controller", true);
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
      if (isset($idSep)) {
        $model->is_bpjs = 1;
        $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
        $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
      }


      $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
      $modPasienAdmisi = PPPasienAdmisiT::model()->findByAttributes(array(
        'pendaftaran_id' => $model->pendaftaran_id,
      ));
      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = PPRujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataTindakans = PPTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
    }

    if (isset($idSep)) {
      $modSep = PPSepT::model()->findByPk($idSep);
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
          $modPasienAdmisi->ruangan_id = $modBookingKamar->ruangan_id;
        if (!empty($modBookingKamar->kamarruangan_id))
          $modPasienAdmisi->kamarruangan_id = $modBookingKamar->kamarruangan_id;
        if (!empty($modBookingKamar->kamarruangan_id))
          $modPasienAdmisi->kelaspelayanan_id = $modBookingKamar->kelaspelayanan_id;
        if (!empty($modBookingKamar->pegawai_id))
          $modPasienAdmisi->pegawai_id = $modBookingKamar->pegawai_id;
      }
    }
    if (!empty($modPasien->pegawai_id)) {
      $modPegawai->attributes = $modPasien->pegawai->attributes;
    }

    if (isset($_POST['PPPendaftaranT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {


        $modPasien = $this->simpanPasien($modPasien, $_POST['PPPasienM']);

        if ($_POST['PPPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['PPPenanggungJawabM'])) {
            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['PPPenanggungJawabM']);
          }
        } else {
          $this->penanggungjawabtersimpan = true;
        }

        if ($_POST['PPPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['PPRujukanT'])) {
            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['PPRujukanT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        if ($_POST['PPPendaftaranT']['is_bpjs']) {
          if (isset($_POST['PPRujukanbpjsT'])) {
            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienM'])) {
          if (isset($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
              $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['PPPasienAdmisiT'], $modPasien, $_POST['PPAsuransipasienM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienbpjsM'])) {
          if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
              $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPasienAdmisiT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        $model->ruangan_id = $modPasienAdmisi->ruangan_id;
        $model->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
        $model->pegawai_id = $modPasienAdmisi->pegawai_id;
        $model->carabayar_id = $modPasienAdmisi->carabayar_id;
        $model->penjamin_id = $modPasienAdmisi->penjamin_id;

        $timeset = date_default_timezone_get();

        if ($_POST['PPPendaftaranT']['is_bpjs']) {
          $model = $this->simpanPendaftaranRI($model, $modPasien, $modRujukanBpjs, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $_POST['PPPasienAdmisiT'], $modAsuransiPasienBpjs);
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT'], true);
        
          if (!empty($modSep->sep_id)) {
            $model->sep_id = $modSep->sep_id;
            $model->save();
          }
        
        } else {
          $model = $this->simpanPendaftaranRI($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $_POST['PPPasienAdmisiT'], $modAsuransiPasien);
        }

        date_default_timezone_set($timeset);

        $modPasienAdmisi = $this->simpanPasienAdmisi($model, $modPasien, $modPasienAdmisi, $_POST['PPPasienAdmisiT']);

        //update sep_id ke pasienadmisi_t
        if ($_POST['PPPendaftaranT']['is_bpjs']) {
          if (!empty($modSep->sep_id)){
            PasienadmisiT::model()->updateByPk($modPasienAdmisi->pasienadmisi_id, array('sep_id'=>$modSep->sep_id));
          }
        }

        $this->simpanMasukKamar($model, $modPasien, $modPasienAdmisi);

        if (isset($_POST['PPAsuransipasienbadakM'])) {
          if (isset($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])) {
              $modAsuransiPasienBadak = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbadakM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBadak = $this->simpanAsuransiPasien($modAsuransiPasienBadak, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbadakM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasiendepartemenM'])) {
          if (isset($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])) {
              $modAsuransiPasienDepartemen = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienDepartemen = $this->simpanAsuransiPasien($modAsuransiPasienDepartemen, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasiendepartemenM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienpegawaiM'])) {
          if (isset($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])) {
              $modAsuransiPasienPekerja = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienPekerja = $this->simpanAsuransiPasien($modAsuransiPasienPekerja, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienpegawaiM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        $this->karcistersimpan = true;
        $this->komponentindakantersimpan = true;
        if ($_POST['PPPendaftaranT']['is_adakarcis']) {
          if (isset($_POST['PPTindakanPelayananT'])) {
            if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
              foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
                if ($karcis['is_pilihtindakan']) {
                  $dataTindakans[$i] = $this->simpanKarcisRI($modTindakan, $model, $modPasienAdmisi, $karcis);
                }
              }
            }
            if (isset($_POST['PPPendaftaranT']['is_bayarkarcis'])) { //fitur belum ada >> RND-666
              if ($_POST['PPPendaftaranT']['is_bayarkarcis']) { //jika di ceklis
              }
            }
          }
        }

        $judul = 'Pendaftaran Pasien Bayi Baru Lahir';

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;

        $ruanganNotif = RuanganM::model()->findByPk($modPasienAdmisi->ruangan_id);

        if ($ruanganNotif->instalasi_id == Params::INSTALASI_ID_RI) {
          $link_ri = $this->createUrl('/rawatInap/PasienRawatInap/Index', array(
            'RIInfopasienmasukkamarV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RIInfopasienmasukkamarV[tgl_awall]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RIInfopasienmasukkamarV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RIInfopasienmasukkamarV[tgl_akhirl]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RIInfopasienmasukkamarV[no_pendaftaran]' => substr($model->no_pendaftaran, 2),
            'RIInfopasienmasukkamarV[nama_pasien]' => $model->pasien->nama_pasien,
            'RIInfopasienmasukkamarV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
            'RIInfopasienmasukkamarV[prefix_pendaftaran]' => substr($model->no_pendaftaran, 0, 2),
            'RIInfopasienmasukkamarV[ruangan_id]' => $model->ruangan_id,
            'RIInfopasienmasukkamarV[ceklis]' => '',
            'RIInfopasienmasukkamarV[ceklisAdmisi]' => '',
            'RIInfopasienmasukkamarV[is_nursestation]' => '',
          ));
        } else if ($ruanganNotif->instalasi_id == Params::INSTALASI_ID_ICU) {
          $link_ri = $this->createUrl('/perawatanIntensif/PasienRawatIntensif/Index', array(
            'PIInfopasienmasukkamarV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'PIInfopasienmasukkamarV[tgl_awall]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'PIInfopasienmasukkamarV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'PIInfopasienmasukkamarV[tgl_akhirl]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'PIInfopasienmasukkamarV[no_pendaftaran]' => substr($model->no_pendaftaran, 2),
            'PIInfopasienmasukkamarV[nama_pasien]' => $model->pasien->nama_pasien,
            'PIInfopasienmasukkamarV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
            'PIInfopasienmasukkamarV[prefix_pendaftaran]' => substr($model->no_pendaftaran, 0, 2),
            'PIInfopasienmasukkamarV[ruangan_id]' => $model->ruangan_id,
            'PIInfopasienmasukkamarV[ceklis]' => '',
            'PIInfopasienmasukkamarV[ceklisAdmisi]' => '',
            'PIInfopasienmasukkamarV[is_nursestation]' => '',
          ));
        } else {
          $link_ri = null;
        }

        $notifInap = array('instalasi_id' => $ruanganNotif->instalasi_id, 'ruangan_id' => $ruanganNotif->ruangan_id, 'modul_id' => $ruanganNotif->modul_id, 'link_proses' => $link_ri);

        $cek = DokrekammedisM::model()->findByAttributes(array('pasien_id' => $model->pasien_id));

        if ($cek) {
          $link = $this->createUrl('/rekamMedis/PengirimanBerkasRekamMedis/Index', array(
            'RKDokumenpasienrmlamaV[no_pendaftaran]' => $model->no_pendaftaran,
            'RKDokumenpasienrmlamaV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
            'RKDokumenpasienrmlamaV[tgl_rekam_medik]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RKDokumenpasienrmlamaV[tgl_rekam_medik_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RKDokumenpasienrmlamaV[nama_pasien]' => $model->pasien->nama_pasien
          ));
        } else {
          $link = $this->createUrl('/rekamMedis/PembuatanDokumenRK/Create', array(
            'pasien_id' => $model->pasien_id
          ));
        }



        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          $notifInap,
          //array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => 10),
          // array('instalasi_id' => Params::INSTALASI_ID_KASIR, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => 19),
          array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' => Params::MODUL_ID_REKAMMEDIS, 'link_proses' => $link), //, 'link_proses' => $link
        ));
        
        $this->setAkomodasiLangsung($model, $modPasienAdmisi);

        //if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI){						
        $ins = RuanganM::model()->findAllByAttributes(array('instalasi_id' => Params::INSTALASI_ID_RI));
        // var_dump($this->pasientersimpan , $this->pendaftarantersimpan , $this->penanggungjawabtersimpan && $this->rujukantersimpan , $this->karcistersimpan , $this->komponentindakantersimpan , $this->admisitersimpan , $this->masukkamartersimpan, $this->asuransipasientersimpan); die;
        if ($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->admisitersimpan && $this->masukkamartersimpan && $this->asuransipasientersimpan) {

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
            foreach ($modSmsgateway as $i => $smsgateway) {
              if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
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
                  if (!empty($modPenanggungJawab->no_mobilepj)) {
                    $sms->kirim($modPenanggungJawab->no_mobilepj, $isiPesan);
                  } else {
                    $smspenanggungjawab = 0;
                  }
                }
              }
            }
            // END SMS GATEWAY
          }


          $cekAdmisiId = PendaftaranT::model()->findByPk($modPasienAdmisi->pendaftaran_id);
          if ($cekAdmisiId->pasienadmisi_id == null) {
            PendaftaranT::model()->updateByPk($modPasienAdmisi->pendaftaran_id, array('pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id));
          } else {
            //echo "wowkeh";die;
          }

          if ($this->is_pasien_baru) {
            $this->cleanUpSessionPasienSudahBaca($model->pendaftaran_id);
          }

          $transaction->commit();
          if ($modPasien->is_random) {
            $modPasien->generateNoRMDanSimpan();
          }
          $model->generateNoPendaftaranDanSimpan();
          //Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
          // RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
          if ($this->septersimpan) {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
          } else {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
          }
        } else {
          $transaction->rollback();
          $model->isNewRecord = true;
          Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $model->isNewRecord = true;
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
      'modPasienAdmisi' => $modPasienAdmisi,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modRujukan' => $modRujukan,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modTindakan' => $modTindakan,
      'modAntrian' => $modAntrian,
      'dataTindakans' => $dataTindakans,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
      'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
      'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
      'modSep' => $modSep,
      'modSmsgateway' => $modSmsgateway,
      'modKarcisV' => $modKarcisV
    ));
  }

  /**
   * Mengurai data pasien berdasarkan pasien_id
   * @throws CHttpException
   */


   
   
   public function actionGetDataPasienIbu()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $kelahiranbayi_id = isset($_POST['kelahiranbayi_id']) ? $_POST['kelahiranbayi_id'] : null;
   
      $returnVal = array();
      if (!empty($pasien_id)) {
        $p = PasienM::model()->findByPk($pasien_id);
        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
          'pasien_id' => $pasien_id,
          'pendaftaran_id' => $pendaftaran_id,
        ), array(
          'condition' => 'pasienbatalperiksa_id is null'
        ));
      } else if (!empty($no_rekam_medik)) {
        $p = PasienM::model()->findByAttributes(array('no_rekam_medik' => trim($no_rekam_medik)));
        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
          'pasien_id' => $p->pasien_id,
          'pendaftaran_id' => $pendaftaran_id,
        ), array(
          'condition' => 'pasienbatalperiksa_id is null',
          'order' => 'pendaftaran_id desc',
        ));
      } else {
        $p = new PasienM;
        $pendaftaran = null;
      }

      $returnVal['lebih'] = false;
      $returnVal['adaDaftar'] = false;
      $returnVal['persalinan'] = array(
        'nama_bayi' => '',
        'tgl_lahir' => '',
        'jeniskelamin' => '',
      );

      $pp = null;
      if (!empty($pendaftaran)) {
        $returnVal['listDaftar'] = $pendaftaran->attributes;
        $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien;
        $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan;
        $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi;

        $returnVal['adaDaftar'] = false;

        $persalinan = PersalinanT::model()->findByAttributes(array(
          'pendaftaran_id' => $pendaftaran->pendaftaran_id,
        ));

        if (!empty($persalinan)) {

          $kelahiran = KelahiranbayiT::model()->findByAttributes(array(
            'persalinan_id' => $persalinan->persalinan_id,
            'kelahiranbayi_id' => $kelahiranbayi_id,
          ));

          if (!empty($kelahiran)) {
            $returnVal['persalinan']['nama_bayi'] = $kelahiran->namabayi;
            $returnVal['persalinan']['tgl_lahir'] = date('d/m/Y', strtotime($kelahiran->tgllahirbayi));
            $returnVal['persalinan']['jeniskelamin'] = $kelahiran->jeniskelamin;
            $returnVal['persalinan']["kelaspelayanan_id"] = $pendaftaran->kelaspelayanan_id;
            
          } else {
            $returnVal['persalinan']['nama_bayi'] = $p->nama_pasien;
          }
        }
      }

      $returnVal['listDaftar']['pasien']['fingerprint_data'] = null;





      if (isset($_POST['is_manual']) && $_POST['is_manual'] == true) {
        $rm_last = PasienM::model()->find(array(
          'condition' => 'ispasienluar = false',
          'order' => 'no_rekam_medik desc'
        ));

        if ((int) $no_rekam_medik > (int) $rm_last->no_rekam_medik) {
          $returnVal['lebih'] = true;
          echo CJSON::encode($returnVal);
          Yii::app()->end();
        }
      }


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
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * Sebelum dialog verifikasi dimunculkan maka dilakukan validasi Pasien, 
   * khususnya yang memiliki No KTP, dan Nama Ibu+Tgl. Lahir. Jika Nomor KTP
   * tidak ditemukan pada Pasien Lain, maka akan dilanjutkan dengan validasi
   * Nama Ibu+Tgl lahir
   */
  public function actionValidasiPasien()
  {
    $ok = 1;
    $msg = "";



    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    if (!isset($_POST['PPPasienM'])) {
      $msg = "Form Pasien belum Lengkap";
      Yii::app()->end();
    }



    if (isset($_POST['PPPasienM']['pasien_id']) && !empty($_POST['PPPasienM']['pasien_id']))
      goto prints;

    if (
      isset($_POST['PPPasienM']['no_identitas_pasien']) && !empty($_POST['PPPasienM']['no_identitas_pasien']) && $_POST['PPPasienM']['no_identitas_pasien'] != ''
    ) {
      // ktp
      $pasien = PasienM::model()->findByAttributes(array(
        'jenisidentitas' => 'KTP',
        'no_identitas_pasien' => $_POST['PPPasienM']['no_identitas_pasien'],
      ));


      /*
              if (!empty($pasien)) {
              $ok = 0;
              $msg = "KTP dengan Nomor " . $pasien->no_identitas_pasien . " sudah terdaftar atas Nama " . $pasien->nama_pasien . " - " . $pasien->no_rekam_medik;

              goto prints;
              }
             * 
             */
    }
    /*
        $pasien = PasienM::model()->findByAttributes(array(
            'tanggal_lahir' => MyFormatter::formatDateTimeForDb($_POST['PPPasienM']['tanggal_lahir']),
            'nama_ibu' => $_POST['PPPasienM']['nama_ibu'],
        ));

        if (!empty($pasien)) {
            $ok = 0;
            $msg = "Pasien ber tanggal lahir " . date('d/m/Y', strtotime($pasien->tanggal_lahir)) .
                    " beserta Ibu bernama " . $pasien->nama_ibu .
                    " sudah terdaftar atas Nama " . $pasien->nama_pasien . " - " . $pasien->no_rekam_medik;

            goto prints;
        }
         * 
         */


    prints:
    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }

  /**
   * proses simpan / ubah data pasien bayi
   * diinsert juga referensi dari pasien ibu
   * @param type $modPasien
   * @param type $post
   * @return type
   */
  public function simpanPasien($modPasien, $post)
  {
    $format = new MyFormatter();
    $snrm = "";

    $modPasien->attributes = $post;

    $modIbu = PasienM::model()->findByAttributes(array(
      'no_rekam_medik' => $modPasien->no_rekam_medik,
    ));
    $modPasien->pasien_ibu_id = $modIbu->pasien_id;
    $modPasien->no_rekam_medik_ibu = $modPasien->no_rekam_medik;
    $modPasien->no_rekam_medik = null;

    unset($modPasien->fingerprint_data);
    $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $modPasien->statusperkawinan = isset($post['statusperkawinan']) ? $post['statusperkawinan'] : 'Belum Menikah';

    if (empty($modPasien->pasien_id)) {
      $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
      $modPasien->profilrs_id = Params::getDefaultProfilRS();
      $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
      $modPasien->ispasienluar = FALSE;
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPasien->create_loginpemakai_id = Yii::app()->user->id;
      $modPasien->create_time = date('Y-m-d H:i:s');
      if (empty($modPasien->no_rekam_medik) || trim($modPasien->no_rekam_medik) == "") {
        if (isset($_POST['generateNoRM'])) {
          if (!empty($_POST['generateNoRM'])) {
            $modPasien->no_rekam_medik = MyGenerator::noRekamMedik('', 'FALSE', $_POST['generateNoRM']);
          }
        } else {
          $modPasien->no_rekam_medik = $modPasien->generateNoRandom(); // MyGenerator::noRekamMedik();
        }
      } else {
        $this->is_rm_manual = true;
      }
    } else {
      $modPasien->update_loginpemakai_id = Yii::app()->user->id;
      $modPasien->update_time = date('Y-m-d H:i:s');
      $modPasien->no_rekam_medik = $snrm;
    }
    $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
    $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
    $modPasien->pekerjaan_id = Params::PEKERJAAN_ID_TIDAK_BEKERJA;

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


    if ($modPasien->save()) {
      $this->pasientersimpan = true;
      KelahiranbayiT::model()->updateByPk($post['kelahiranbayi_id'], array(
        'pasien_id' => $modPasien->pasien_id
      ));
    }

    return $modPasien;
  }

  public function actionAutocompletePasienIbu($no_rekam_medik = "", $no_identitas_pasien = "")
  {

    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $modDataPasien = new PPPasienM('searchDialog');
    $modDataPasien->unsetAttributes();
    $format = new MyFormatter();
    $modDataPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
    $modDataPasien->no_rekam_medik = $no_rekam_medik;
    $modDataPasien->no_identitas_pasien = $no_identitas_pasien;

    $prov = $modDataPasien->searchDialogIbu();

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['kelahiranbayi_id'] = $item->kelahiranbayi_id;
      $sub['pendaftaran_id'] = $item->pendaftaran_id;
      $sub['label'] = $item->no_rekam_medik . " - Ibu : " . $item->nama_pasien . " - Bayi : " . $item->namabayi;
      //$sub['valie'] = $item->no_rekam_medik." - ".$item->
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  public function actionPrintLabelGelang($pendaftaran_id, $tipe = null)
    {
        $format = new MyFormatter();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

        $judul_print = '';
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if ($caraPrint == 'PRINT') {
                        $this->layout='//layouts/printWindows';
        }
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
        $posisi = 'L'; //Posisi L->Landscape,P->Portait

        $gelang_tipe = 0;

        if (empty($tipe)) {
          if ($modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_ANAK || $modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI || $modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR) {
                // panjang : 29 -> 2,9cm , lebar: 155->15.5 cm
                // $mpdf = new MyPDF60('', array(29, 155));
                $mpdf = new MyPDF60('', array(165, 20));
                $gelang_tipe = 1;
            } else {
                // panjang : 29 -> 2,9cm , lebar: 265 ->26,5 cm
                //$mpdf = new MyPDF60('', array(25, 285));
                $gelang_tipe = 0;
                $this->layout = '//layouts/printWindows';
                $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printLabelGelangDewasa', array(
                    'format' => $format,
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'gelang_tipe' => $gelang_tipe,
                ));
            }
        } else {
            if ($tipe == 1) {
                //$mpdf = new MyPDF60('', array(25, 285));
                $gelang_tipe = 0;
                $this->layout = '//layouts/printWindows';
                $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printLabelGelangDewasa', array(
                    'format' => $format,
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'gelang_tipe' => $gelang_tipe,
                ));
                // $mpdf = new MyPDF60('', array(25, 285));
                //     $gelang_tipe = 1;
            } else {
                // if($modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI || $modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR){
                // panjang : 25 -> 2,5cm , lebar: 40->4 cm
                //    $mpdf = new MyPDF60('', array(25, 40));
                //    $gelang_tipe = 2;
                //} else {
                // panjang : 29 -> 2,9cm , lebar: 155->15.5 cm
                // $mpdf = new MyPDF60('', array(29, 155));
                $mpdf = new MyPDF60('', array(25, 285));
                $gelang_tipe = 1;
                //}
            }
        }
        
        // echo  $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printLabelGelang', array(
        //         'format' => $format,
        //         'modPendaftaran' => $modPendaftaran,
        //         'modPasien' => $modPasien,
        //         'gelang_tipe' => $gelang_tipe,
        //             ), true); die;
         

        if ($gelang_tipe == 1) {
           // ob_clean();
            // $mpdf->mirrorMargins = 2;
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
            $mpdf->SetHTMLFooter('<span></span>');
            $mpdf->WriteHTML(
                $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printLabelGelang', array(
                    'format' => $format,
                    'modPendaftaran' => $modPendaftaran,
                    'modPasien' => $modPasien,
                    'gelang_tipe' => $gelang_tipe,
                ), true)
            );
            $mpdf->SetJS('this.print();');
            $mpdf->Output();
        }
    }
}

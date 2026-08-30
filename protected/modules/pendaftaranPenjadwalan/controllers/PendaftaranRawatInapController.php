<?php
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalanController');
class PendaftaranRawatInapController extends PendaftaranRawatJalanController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";

  public $pasientersimpan = false;
  public $pendaftarantersimpan = false;
  public $penanggungjawabtersimpan = false;
  public $karcistersimpan = false;
  public $komponentindakantersimpan = false;
  public $rujukantersimpan = false;
  public $masukkamartersimpan = false;
  public $admisitersimpan = false;
  public $asuransipasientersimpan = false;
  public $langsung = true;

  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
  {
    $format = new MyFormatter();
    $model = new PPPendaftaranT;
    $modPasien = new PPPasienM;
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

    $modRujukanInhealth = new PPRujukanInhealthT;
    $modRujukanInhealth->tanggal_rujukan = date('Y-m-d H:i:s');

    $modAsuransiPasienInhealth = new PPAsuransipasieninhealthM;
    $modSkpInhealthT = new PPSkpInhealthT;
    $modSkpInhealthT->tglskp = date('Y-m-d H:i:s');
    $modSkpInhealthT->jnspelayanan = 3; //defaul RJTL

    $modSepInhealthT = new PPSepInhealthT;
    $modSepInhealthT->tglsep = date('Y-m-d H:i:s');
    $modSepInhealthT->jnspelayanan = 4; //defaul RITL

    $modSep = new PPSepT;
    $dataTindakans = array();
    $modKarcisV = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->cekinap = 'ada';

    $modSkp = new PPSkpT;
      $modSkp->tglskp = date('Y-m-d H:i:s');
      $modSkp->jnspelayanan = 2; //defaul rajal
      $modSkp->poli_eksekutif = 0;
      $modSkp->cob = 0;
      $modSkp->lakalantas = 0;
      $modSkp->jenisfaskes = 2; //default RS
      $modSkp->katarak = 0;
      $modSkp->suplesi_jasaraharja = 0;
      $modSkp->status_noskp = "TIDAK";
      $modProfilRS = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
      $modSkp->ppkpelayanan = $modProfilRS->ppkpelayanan;
      $modSkp->pelayanan = 'RJ';

    
      $modSep->jenis_kunjungan = "0";
      $modSep->asesmen_pelayanan = "";

    //$modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    //$modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    //$modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    //$modPasien->agama = Params::DEFAULT_AGAMA;
    $model->is_adakarcis = 1;//Yii::app()->user->getState('iskarcis'); //RND-7737
    $model->is_pasienrujukan = 1;
    $model->is_asubadak = 0;
    $model->is_asudepartemen = 0;
    $model->is_asupekerja = 0;
    $model->is_adapjpasien = 1;

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
    
    //Check if is bridging false or true
    $konfig = KonfigsystemK::model()->find();
    if ($konfig->isbridging == false) {
        $model->is_bpjs_manual = 1;
    }else{
        $model->is_bpjs_manual = 0;
    }

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

      // var_dump($model->attributes); die;

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


      // var_dump($modPasienAdmisi->attributes); die;
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
        // echo "<pre>";
        // var_dump($_POST);die;
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

       //  var_dump($_POST); die;
        if ($_POST['PPPasienAdmisiT']['carabayar_id'] == Params::CARABAYAR_ID_JAMKESPA || $_POST['PPPasienAdmisiT']['carabayar_id'] == Params::CARABAYAR_ID_JAMKESDA) {
            $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPasienAdmisiT'], $_POST['PPPasienM'], $modAsuransiPasien);
            $modSkp = $this->simpanSkp($model, $modPasien, $modRujukan, $modAsuransiPasien);
            $model->skp_id = $modSkp->skp_id;
            $model->no_rujukan = $modSkp->norujukan;            
            $model->update();
        }

        if ($_POST['PPPendaftaranT']['is_bpjs']) {
          $model = $this->simpanPendaftaranRI($model, $modPasien, $modRujukanBpjs, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $_POST['PPPasienAdmisiT'], $modAsuransiPasienBpjs);
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
          $model->sep_id = $modSep->sep_id;
          $model->update();
        } else {
          $model = $this->simpanPendaftaranRI($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $_POST['PPPasienAdmisiT'], $modAsuransiPasien);
        }

         /* Untuk penjamin inhealth */
         if (isset($_POST['PPRujukanInhealthT'])) {
          $modRujukanInhealth = $this->simpanRujukanBpjs($modRujukanInhealth, $_POST['PPRujukanInhealthT']);
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

        if ($_POST['PPPendaftaranT']['is_bpjs']) {
          $model = $this->simpanPendaftaranRI($model, $modPasien, $modRujukanBpjs, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $_POST['PPPasienAdmisiT'], $modAsuransiPasienBpjs);
          if (isset($_POST['PPSepT'])) {
              $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
              $model->sep_id = $modSep->sep_id;
              $model->no_kontrol_bpjs = $modSep->no_surat;
              $model->no_rujukan = $modSep->norujukan;
              $model->ket_bridging = 'Sukses';                        
              $model->update();
          }else{
              $model->ket_bridging = 'Gagal Bridging';
              $model->update();
          }
        } else {
            if (isset($_POST['PPSepInhealthT'])) { //simpan pendaftaran ketika brigin dengan inhealth
                $model = $this->simpanPendaftaranRI($model, $modPasien, $modRujukanInhealth, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $_POST['PPPasienAdmisiT'], $modAsuransiPasienInhealth);
            } else {
                $model = $this->simpanPendaftaranRI($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $_POST['PPPasienAdmisiT'], $modAsuransiPasien);
            }
        }

        /* Untuk penjamin inhealth */
        if (isset($_POST['PPSepInhealthT'])) {
            $modSep = $this->simpanSep($model, $modPasien, $modRujukanInhealth, $modAsuransiPasienInhealth, $_POST['PPSepInhealthT']);
            $model->sep_id = $modSep->sep_id;
            PPSepInhealthT::model()->updateByPk($modSep->sep_id, array('is_inhealth' => true));
            $model->update();
        }

        $modPasienAdmisi = $this->simpanPasienAdmisi($model, $modPasien, $modPasienAdmisi, $_POST['PPPasienAdmisiT']);

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

        if (isset($_POST['scan'])) {
          $this->simpanScanPasien($model, $_POST['scan']);
        }
        
        // paket
        if (isset($_POST['paket_medis'])) {
            $this->simpanTindakanObatPaket($model, $_POST['paket_medis']);
        }

        $judul = 'Pendaftaran Pasien';

        if ($model->statuspasien == 'PENGUNJUNG LAMA') {
          $judul .= " Lama";
        } else $judul .= " Baru";

        $judul .= " Rawat Inap Langsung";

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;

        //$notifInap = array('instalasi_id'=>Params::INSTALASI_ID_RI, 'ruangan_id'=>$modPasienAdmisi->ruangan_id, 'modul_id'=>7);

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
          //$notifInap,
          //array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_1, 'modul_id'=>10),
          // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
          array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' =>  Params::MODUL_ID_REKAMMEDIS, 'link_proses' => $link), //, 'link_proses' => $link
        ));

        //if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI){						
        $ins = RuanganM::model()->findAllByAttributes(array('instalasi_id' =>  Params::INSTALASI_ID_RI));

        foreach ($ins as $r) {
          //if ($r->ruangan_id == $model->ruangan_id){

          $link_ri = $this->createUrl('/rawatInap/PasienRawatInap/Index', array(
            'RIInfopasienmasukkamarV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RIInfopasienmasukkamarV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RIInfopasienmasukkamarV[no_pendaftaran]' => substr($model->no_pendaftaran, 2),
            'RIInfopasienmasukkamarV[nama_pasien]' => $model->pasien->nama_pasien,
            'RIInfopasienmasukkamarV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
            'RIInfopasienmasukkamarV[prefix_pendaftaran]' => substr($model->no_pendaftaran, 0, 2),
            'RIInfopasienmasukkamarV[ruangan_id]' => $model->ruangan_id
          ));

          //var_dump($link_ri);die;

          $notifInap[] = array(
            'instalasi_id' => $r->instalasi_id,
            'ruangan_id' => $r->ruangan_id,
            'modul_id' => Params::MODUL_ID_RI,
            'link_proses' => $link_ri
          );
          //}else{
          //$notifInap[] = array(
          //	'instalasi_id'=>$r->instalasi_id, 
          //	'ruangan_id'=>$r->ruangan_id, 
          //	'modul_id'=>Params::MODUL_ID_RI,
          //);
          //}

        }

        $ok = CustomFunction::broadcastNotif($judul, $isi, $notifInap);
        //}
        // $this->setAkomodasiLangsung($model, $modPasienAdmisi);




        if ($this->is_simpanpaket && $this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->admisitersimpan && $this->masukkamartersimpan && $this->asuransipasientersimpan) {

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

          $transaction->commit();
          if ($modPasien->is_random) {
              $modPasien->generateNoRMDanSimpan();
          }
          $model->generateNoPendaftaranDanSimpan();
          Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
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
      'modKarcisV' => $modKarcisV,
      'modRujukanInhealth' => $modRujukanInhealth,
      'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
      'modSepInhealthT' => $modSepInhealthT,
    ));
  }
  
  

   public function actionPrintStiker($pendaftaran_id)
    {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $posisi = 'P'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', array(100, 135));
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printStiker', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }

  public function setAkomodasiLangsung($model, $modPasienAdmisi) {

        Yii::import('rawatInap.controllers.PasienRawatInapController');

        $masukkamar = MasukkamarT::model()->findByAttributes(array(
            'pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id
        ));

        if (Yii::app()->user->getState('akomodasiotomatis') && !empty($masukkamar) && !empty($masukkamar->kamarruangan_id)) {
            PasienRawatInapController::saveAkomodasi($model, $modPasienAdmisi);
        }
    }

  /**
   * proses simpan pendaftaran
   * @return type
   */
  public function simpanPendaftaranRI($model, $modPasien, $modRujukan, $modPenanggungJawab, $post, $postPasien, $postAdmisi, $modAsuransiPasien)
  {
    $format = new MyFormatter();
    $model->attributes = $post;
    $model->attributes = $postAdmisi;
    $model->pasien_id = $modPasien->pasien_id;
    $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
    $model->rujukan_id = $modRujukan->rujukan_id;
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $model->instalasi_id = (isset($model->ruangan_id) ? RuanganM::model()->findByPk($model->ruangan_id)->instalasi_id : null);
    //            $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
    $model->no_urutantri = MyGenerator::noAntrianPPKonsul($model->ruangan_id); //fungsi diganti karena no antrian duplikat ketika ada konsul poli ke ruangan.
    $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
    $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
    $model->statusperiksa = Params::STATUSPERIKSA_SEDANG_DIRAWATINAP;
    $model->statuspasien = (empty($postPasien['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
    $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
    $model->shift_id = Yii::app()->user->getState('shift_id');
    $model->kelompokumur_id = $modPasien->kelompokumur_id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_time = date("Y-m-d H:i:s");
    if (Yii::app()->user->getState('tgltransaksimundur') && !empty($postAdmisi['tgladmisi'])) {
      $model->tgl_pendaftaran = $format->formatDateTimeForDb($postAdmisi['tgladmisi']);
    } else {
      $model->tgl_pendaftaran = date("Y-m-d H:i:s");
    }
    $model->no_pendaftaran = $model->generateNoRandom(); // MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
    $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
    $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
    $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
    $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
    $model->alihstatus = TRUE; //RND-6114
    $model->keterangan_pendaftaran = $post['keterangan_pendaftaran'];

    //var_dump($model->isumumkebpjs);die;

    if ($model->save()) {
      if (!empty($model->antrian_id)) {
        PPAntrianT::model()->updateByPk($model->antrian_id, array('pendaftaran_id' => $model->pendaftaran_id));
      }
      $this->pendaftarantersimpan = true;
    }
    return $model;
  }
  /**
   * simpan PPPasienAdmisiT
   * @param modPasienAdmisi $modPasienAdmisi
   * @param type $model
   * @param type $modPasien
   * @param type $post
   * @return \modPasienAdmisi
   */
  public function simpanPasienAdmisi($model, $modPasien, $modPasienAdmisi, $post)
  {
    $format = new MyFormatter();
    $modPasienAdmisi = new PPPasienAdmisiT;
    $modPasienAdmisi->attributes = $post;
    if ($model->instalasi_id == Params::INSTALASI_ID_RJ) {
      $caramasuk_id = Params::CARAMASUK_ID_RJ;
    } else if ($model->instalasi_id == Params::INSTALASI_ID_RD) {
      $caramasuk_id = Params::CARAMASUK_ID_RD;
    } else {
      $caramasuk_id = Params::CARAMASUK_ID_LANGSUNG_RI;
    }
    $modPasienAdmisi->caramasuk_id = $caramasuk_id;
    $modPasienAdmisi->pendaftaran_id = $model->pendaftaran_id;
    $modPasienAdmisi->tglpendaftaran = $model->tgl_pendaftaran;
    if (Yii::app()->user->getState('tgltransaksimundur') && !empty($modPasienAdmisi->tgladmisi)) {
      $modPasienAdmisi->tgladmisi = $format->formatDateTimeForDb($modPasienAdmisi->tgladmisi);
    } else {
      $modPasienAdmisi->tgladmisi = date("Y-m-d H:i:s");
    }
    $modPasienAdmisi->pasien_id = $model->pasien_id;
    $modPasienAdmisi->shift_id = Yii::app()->user->getState('shift_id');
    $modPasienAdmisi->kunjungan = CustomFunction::getKunjungan($modPasien, $modPasienAdmisi->ruangan_id);
    $modPasienAdmisi->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasienAdmisi->tglpulang = null;
    $modPasienAdmisi->rencanapulang = null;
    $modPasienAdmisi->create_time = date("Y-m-d H:i:s");
    $modPasienAdmisi->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienAdmisi->kamarruangan_id = empty($modPasienAdmisi->kamarruangan_id) ? null : $modPasienAdmisi->kamarruangan_id;
    
    // if (isset($_POST['PPPendaftaranT']['carabayar_id'])) {
    //   $modPasienAdmisi->carabayar_id = $_POST['PPPendaftaranT']['carabayar_id'];
    // }
    // if (!empty($_POST['PPPendaftaranT']['penjamin_id'])) {
    //   $modPasienAdmisi->penjamin_id = $_POST['PPPendaftaranT']['penjamin_id'];
    // }else{
    //   $modPasienAdmisi->penjamin_id = $modPasienAdmisi->penjamin_id;
    // }
    $modPasienAdmisi->carabayar_id = !empty($modPasienAdmisi->carabayar_id) ? $modPasienAdmisi->carabayar_id : $_POST['PPPendaftaranT']['carabayar_id'];
    $modPasienAdmisi->penjamin_id = !empty($modPasienAdmisi->penjamin_id) ? $modPasienAdmisi->penjamin_id : $_POST['PPPendaftaranT']['penjamin_id'];
    $modPasienAdmisi->spesialis_id = $model->jeniskasuspenyakit_id;

    // echo '<pre>';var_dump($post);die;
    if(isset($post['is_titipan'])) {
      $modPasienAdmisi->is_titipan = $post['is_titipan'];
    }
    // echo '<pre>'; var_dump($modPasienAdmisi->attributes); die;
 

    //tes 123
    //var_dump($modPasienAdmisi->attributes); die;

    if ($modPasienAdmisi->save()) {
      //jika ada booking kamar (BELUM INTEGRASI)
      //                BookingkamarT::model()->updateByPk($modPasienAdmisi->bookingkamar_id,array('pasienadmisi_id'=>$modPasienAdmisi->pasienadmisi_id,'pendaftaran_id'=>$modPasienAdmisi->pendaftaran_id));
      if (PendaftaranT::model()->updateByPk($modPasienAdmisi->pendaftaran_id, array('pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id))) {
        $this->admisitersimpan = true;
      } else {
        $this->admisitersimpan = false;
      }
    } else {
      $this->admisitersimpan = false;
    }
    // var_dump($modPasienAdmisi->errors, $modPasienAdmisi->attributes); die;
    return $modPasienAdmisi;
  }

  /**
   * simpan MasukkamarT
   * ubah : KamarruanganM.kamarruangan_status, KamarruanganM.keterangan_kamar
   * @param type $model
   * @param type $modPasien
   * @param type $modPasienAdmisi
   */
  public function simpanMasukKamar($model, $modPasien, $modPasienAdmisi)
  {
    $modMasukKamar = new MasukkamarT;
    $modMasukKamar->carabayar_id = $model->carabayar_id;
    $modMasukKamar->kamarruangan_id = (!empty($modPasienAdmisi->kamarruangan_id)) ? $modPasienAdmisi->kamarruangan_id : null;
    $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
    $modMasukKamar->ruangan_id = $modPasienAdmisi->ruangan_id;
    $modMasukKamar->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
    $modMasukKamar->pegawai_id = $model->pegawai_id;
    $modMasukKamar->penjamin_id = $model->penjamin_id;
    $modMasukKamar->shift_id = Yii::app()->user->getState('shift_id');
    $modMasukKamar->tglmasukkamar = date('Y-m-d H:i:s');
    $modMasukKamar->nomasukkamar = MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
    $modMasukKamar->jammasukkamar = date('H:i:s');
    $modMasukKamar->tglkeluarkamar = null;
    $modMasukKamar->jamkeluarkamar = null;
    $modMasukKamar->lamadirawat_kamar = null;
    $modMasukKamar->create_time = date("Y-m-d H:i:s");
    $modMasukKamar->create_loginpemakai_id = Yii::app()->user->id;
    $modMasukKamar->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modMasukKamar->save()) {
      if (!empty($modMasukKamar->kamarruangan_id)) {
        KamarruanganM::model()->updateByPk($modMasukKamar->kamarruangan_id, array('kamarruangan_status' => false, 'keterangan_kamar' => 'IN USE'));
      }
      $this->masukkamartersimpan = true;
    } else {
      $this->masukkamartersimpan = false;
    }
  }

  /**
   * proses simpan karcis
   * @param type $modTindakan
   * @param type $post
   * @return type
   */
  public function simpanKarcisRI($modTindakan, $model, $modPasienAdmisi, $post)
  {
    $modTindakan->attributes = $post;
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->instalasi_id = Yii::app()->user->getState("instalasi_id");
    //$modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTindakan->ruangan_id = $modPasienAdmisi->ruangan_id;
    $modTindakan->pendaftaran_id = $model->pendaftaran_id;
    $modTindakan->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
    $modTindakan->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->carabayar_id = $model->carabayar_id;
    $modTindakan->penjamin_id = $model->penjamin_id;
    $modTindakan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
    $modTindakan->pasien_id = $model->pasien_id;
    $modTindakan->dokterpemeriksa1_id = $model->pegawai_id;
    $modTindakan->karcis_id = $post['karcis_id'];
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakan->qty_tindakan = 1;
    $modTindakan->tarif_satuan=$modTindakan->getTarifSatuan();
    
    $modTindakan->tarif_tindakan = MyFormatter::formatNumberForDb($modTindakan->tarif_satuan) * $modTindakan->qty_tindakan;

    $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
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

    if (!empty($modTindakan->karcis_id)) {
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($model, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }
    // var_dump($modTindakan);die;
    if ($modTindakan->save()) {
      $cekTindakanKomponen = 0;
      $this->komponentindakantersimpan = true; //SIMPAN KOMPONEN DILAKUKAN DI TRIGGER DB
      $this->karcistersimpan = true;

      // $this->setKarcisLamaNol($model);

      $model->karcis_id = $modTindakan->karcis_id;
      $model->save();

      // var_dump($model->attributes); die;
    } else {
      $this->karcistersimpan = false;
    }

    return $modTindakan;
  }

  public function setKarcisLamaNol($model)
  {

    if (!empty($model->karcis_id)) {
      $tindakan = TindakanpelayananT::model()->findByAttributes(array(
        'pendaftaran_id' => $model->pendaftaran_id,
        'karcis_id' => $model->karcis_id,
      ), array(
        'condition' => 'tindakansudahbayar_id is null',
      ));

      if (!empty($tindakan)) {
        // echo "Kicker"; die;
        TindakankomponenT::model()->deleteAllByAttributes(array(
          'tindakanpelayanan_id' => $tindakan->tindakanpelayanan_id,
        ));
        TindakanpelayananT::model()->deleteByPk($tindakan->tindakanpelayanan_id);

        /*
					$kom = TindakankomponenT::model()->findAllByAttributes(array(
						'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id,
					));

					// var_dump($tindakan->attributes); die;

					foreach ($kom as $item) {

						TindakankomponenT::model()->updateByPk($item->tindakankomponen_id, array(
							'tarif_kompsatuan'=>0,
							'tarif_tindakankomp'=>0,
							'subsidiasuransikomp'=>0,
							'subsidipemerintahkomp'=>0,
							'subsidirumahsakitkomp'=>0,
						));

					}
					TindakanpelayananT::model()->updateByPk($tindakan->tindakanpelayanan_id, array(
						'tarif_satuan'=>0,
						'tarif_tindakan'=>0,
						'iurbiaya_tindakan'>0,
						'subsidiasuransi_tindakan'=>0,
						'subsidipemerintah_tindakan'=>0,
						'subsisidirumahsakit_tindakan'=>0,
					));
					 * 
					 */
      }
    }




    // var_dump($model->attributes, $tindakan->attributes); die;
  }

  /**
   *penggunaannya
   * 1. digunakan di pendaftaran rawat inap
   * @param type $encode
   * @param type $namaModel
   * @param type $attr 
   */
  public function actionSetDropdownKamarKosong($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $check = isset($_POST['check']) ? $_POST['check'] : null;
      $gabung = isset($_POST['rawatgabung']) ? $_POST['rawatgabung'] : '';
      $rawatgabung = ($gabung == 'true') ? '1' : '0';
      $kelaspelayanan_id = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : '';

      if (empty($ruangan_id) && isset($_POST[$namaModel]['ruangan_id']))
        $ruangan_id = $_POST[$namaModel]['ruangan_id'];

      if (isset($_POST[$namaModel]['rawatgabung']))
        $rawatgabung = $_POST[$namaModel]['rawatgabung'];

      $bookingkamar_id = (isset($_POST['bookingkamar_id']) ? $_POST['bookingkamar_id'] : null);
      if (empty($bookingkamar_id) && isset($_POST[$namaModel]['bookingkamar_id']))
        $bookingkamar_id = $_POST[$namaModel]['bookingkamar_id'];

      $kamarKosong = array();
      if (!empty($ruangan_id)) {
        if (!empty($bookingkamar_id)) {

          if (!empty($kelaspelayanan_id)) {
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'ruangan_id' => $ruangan_id, 'kamarruangan_status' => true, 'kamarruangan_aktif' => true), array('order' => 'kamarruangan_id'));
          } else {
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true, 'kamarruangan_aktif' => true), array('order' => 'kamarruangan_id'));
          }

          $modBookingKamar = BookingkamarT::model()->findByPk($bookingkamar_id);
        } else {

          if (($rawatgabung == '1')) { //($ruangan_id ==  Params::RUANGAN_ID_BERSALIN) && 
            if (!empty($kelaspelayanan_id)) {
              $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'ruangan_id' => $ruangan_id, 'kamarruangan_status' => false, 'kamarruangan_aktif' => true), array('order' => 'kamarruangan_id'));
            } else {
              $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => false, 'kamarruangan_aktif' => true), array('order' => 'kamarruangan_id'));
            }
          } else {
            if (!empty($kelaspelayanan_id)) {
              $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'ruangan_id' => $ruangan_id, 'kamarruangan_aktif' => true), array('order' => 'kamarruangan_id'));
            } else {
              $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_aktif' => true), array('order' => 'kamarruangan_id'));
            }
          }
        }

        //var_dump(count((array)$kamarKosong));die;
        if ($check == 'check') {
          if (($rawatgabung == '1')) { //($ruangan_id ==  Params::RUANGAN_ID_BERSALIN) && 
            $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidurInUseV2');
          } else {
            //$kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
            $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidurInUseV2');
          }
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          if (!empty($_POST['ruangan_id'])) {
            foreach ($kamarKosong as $value => $name) {
              $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
          }
          $dataList['listKamar'] = $option;
          echo json_encode($dataList);
          Yii::app()->end();
        } else {
          if (($rawatgabung == '1')) { //($ruangan_id ==  Params::RUANGAN_ID_BERSALIN) && 
            $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidurInUseV2');
          } else {
            //$kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
            $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidurInUseV2');
          }
        }
      }

      if ($encode) {
        echo CJSON::encode($kamarKosong);
      } else {
        if (empty($kelaspelayanan_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          if (empty($kamarKosong)) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
          } else {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
            foreach ($kamarKosong as $value => $name) {
              echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
          }
        }
      }
    }
    Yii::app()->end();
  }


  /**
   * form verifikasi sebelum submit
   * @param type $id
   */
  public function actionVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ok = 1;
      $msg = '';

      $this->layout = '//layouts/iframe';
      if (isset($_POST['PPPendaftaranT'])) {
        $format = new MyFormatter();
        $model = new PPPendaftaranT;
        $modPasien = new PPPasienM('search');
        $modPegawai = new PPPegawaiM;
        $modPasienAdmisi = new PPPasienAdmisiT;
        $modPenanggungJawab = null;
        $modRujukan = null;
        $modTindakan = null;

        $model->attributes = $_POST['PPPendaftaranT'];
        $model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
        $modPasien->attributes = $_POST['PPPasienM'];
        if (!empty($modPasien->pegawai_id)) {
          $modPegawai->attributes = $modPasien->pegawai->attributes;
        }
        $modPasienAdmisi->attributes = $_POST['PPPasienAdmisiT'];

        if (isset($_POST['PPPasienAdmisiT']['carabayar_id'])) {
          $modPasienAdmisi->carabayar_id = $_POST['PPPasienAdmisiT']['carabayar_id'];
        }
        if ($_POST['PPPasienAdmisiT']['penjamin_id']) {
          $modPasienAdmisi->penjamin_id = $_POST['PPPasienAdmisiT']['penjamin_id'];
        }
        if ($_POST['PPPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['PPPenanggungJawabM'])) {
            $modPenanggungJawab = new PPPenanggungJawabM;
            $modPenanggungJawab->attributes = $_POST['PPPenanggungJawabM'];
          }
        }

        if ($_POST['PPPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['PPRujukanT'])) {
            $modRujukan = new PPRujukanT;
            $modRujukan->attributes = $_POST['PPRujukanT'];
            $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
          }
        }
        if ($_POST['PPPendaftaranT']['is_adakarcis']) {
          if (isset($_POST['PPTindakanPelayananT'])) {
            if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
              foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
                if ($karcis['is_pilihtindakan']) {
                  $modTindakan[$i] = new PPTindakanPelayananT;
                  $modTindakan[$i]->attributes = $karcis;
                  $modTindakan[$i]->tarif_satuan = str_replace(',','',$karcis['tarif_satuan']);
                  $modTindakan[$i]->karcis_id = $karcis['karcis_id'];
                }
              }
            }
          }
        }
      }

      //if ($_POST['PPPendaftaranT']['ruangan_id'] != Params::RUANGAN_ID_VERLOS_KAMER){
      if (isset($_POST['PPTindakanPelayananT'])) {
        $cekNoKarcis = true;
        if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
          foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
            if ($karcis['is_pilihtindakan']) {
              if (!empty($karcis['karcis_id'])) {
                $cekNoKarcis = $cekNoKarcis && false;
              } else {
                $cekNoKarcis = $cekNoKarcis && true;
              }
            }
          }
        }

        if ($cekNoKarcis == true) {
          $ok = 0;
          $msg = "Maaf, Karcis tidak ditemukan";
        }
      } else {
        $ok = 0;
        $msg = "Maaf, Karcis tidak ditemukan";
      }
      //}

      echo CJSON::encode(array(
        'ok' => $ok,
        'msg' => $msg,
        'content' => $this->renderPartial('verifikasi', array(
          'model' => $model,
          'modPasien' => $modPasien,
          'modPasienAdmisi' => $modPasienAdmisi,
          'modPenanggungJawab' => $modPenanggungJawab,
          'modRujukan' => $modRujukan,
          'modTindakan' => $modTindakan,
          'format' => $format,
        ), true)
      ));
      exit;
    }
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintStatusRI($pendaftaran_id = null, $pasienadmisi_id = null, $pasien_id = null)
  {

    $this->layout = '//layouts/printWindows';
    if($pendaftaran_id == null) {
      $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pasien_id' => $pasien_id));
      if(empty($modPendaftaran)) {
        echo 'pendaftaran_id tidak terset di url';
        die;
      }
    }
    $format = new MyFormatter;
    if (!empty($pasienadmisi_id)) {
      $modPendaftaran = PendaftaranT::model()->findByAttributes(array("pasienadmisi_id" => $pasienadmisi_id));
      if ($modPendaftaran) {
        $pendaftaran_id = !empty($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : null;
      }
    } else {
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    }
    $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $pasien_id = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : null);
    $modPasien =  PasienM::model()->findByPk($pasien_id);
    $karcis_id = null;
    if (empty($modPasienAdmisi)) {
      $modTindakan = new TindakanpelayananT;
    } else {
      $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id, 'pendaftaran_id' => $pendaftaran_id), "karcis_id IS NOT NULL");
    }
    $judul_print = 'Kunjungan Rawat Inap';
    $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatInap.printStatusRI', array(
      'format' => $format,
      'modPasienAdmisi' => $modPasienAdmisi,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakan' => $modTindakan,
    ));
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintKarcisRI($pasienadmisi_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($modPasienAdmisi->pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPegawai = PPPegawaiM::model()->findByPk(Yii::app()->user->id);

    if (empty($modPegawai)) {
      $modPegawai = new PPPegawaiM;
    }

    $karcis_id = null;
    $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id, 'pendaftaran_id' => $modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
    $judul_print = 'Karcis ' . $modPasienAdmisi->ruangan->instalasi->instalasi_nama;
    $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatInap.printKarcisRI', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakan' => $modTindakan,
      'modPegawai' => $modPegawai,
    ));
  }

  /*
         * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
         * and open the template in the editor.
         */
  // public function actionSetDropdownKelasPelayananRI()
  // {
  //   if (Yii::app()->request->isAjaxRequest) {
  //     $ruangan_id = $_POST['ruangan_id'];
  //     $kelasPelayanan = null;
  //     $option = null;
  //     if ($ruangan_id) {
  //       $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan_id . ' and kelaspelayanan_aktif = true order by kelaspelayanan_nama asc');
  //       $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
  //     }
  //     if (empty($kelasPelayanan)) {
  //       $option .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
  //     } else {
  //       $option .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
  //       foreach ($kelasPelayanan as $value => $name) {
  //         $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
  //       }
  //     }
  //     $dataList['listKelas'] = $option;
  //     echo json_encode($dataList);
  //     Yii::app()->end();
  //   }
  // }


  public function actionSetDropdownKelasPelayananRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $kelasPelayanan = null;
      $option = null;
      
      if ($ruangan_id) {
        $criteria_1 = new CDbCriteria();
        $criteria_1->addCondition('ruangan_id='. $ruangan_id);
        $criteria_1->addCondition('kelaspelayanan_aktif = true');
        $criteria_1->order = 'kelaspelayanan_nama asc';
        $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll($criteria_1);
        
        $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
      }
      if (empty($kelasPelayanan)) {
        $option .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        $option .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
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
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * @param type $term data dari Text Input
   */
  public function actionGetDokterPenerima($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $prov = PegawaiV::model()->searchDokter();
    $prov->criteria->compare('lower(nama_pegawai)', strtolower($term), true);
    $prov->sort->defaultOrder = 'nama_pegawai';
    $prov->pagination = false;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }


  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * Ambil data dokter Umum dari autocomplete.
   * 
   * @param type $term data dari Text Input
   */
  public function actionGetDokterDPJP($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();

    $prov = PegawaiV::model()->searchDokter();
    $prov->criteria->compare('lower(nama_pegawai)', strtolower($term), true);
    $prov->sort->defaultOrder = 'nama_pegawai';
    $prov->pagination = false;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }
}

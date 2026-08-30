<?php
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatInapController');
class PendaftaranRawatInapDariRJRDController extends PendaftaranRawatInapController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view_rj = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";
  public $path_view_ri = "pendaftaranPenjadwalan.views.pendaftaranRawatInap.";
  public $path_view_lab = "laboratorium.views.pendaftaranLaboratorium.";

  public $pasientersimpan = false;
  public $pendaftarantersimpan = true; //bypass karena tidak ada proses simpan pendaftaran
  public $penanggungjawabtersimpan = false;
  // public $karcistersimpan = false;
  public $komponentindakantersimpan = false;
  public $rujukantersimpan = false;
  public $successSaveMasukKamar = false;
  public $admisitersimpan = false;
  public $langsung = false;

  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pendaftaran Rawat Inap dari RJ / RD";
    $format = new MyFormatter();
    $model = new PPPendaftaranT;
    $modPasien = new PPPasienM;
    $modPegawai = new PPPegawaiM;
    $modPasienAdmisi = new PPPasienAdmisiT;
    $modPenanggungJawab = new PPPenanggungJawabM;
    $modRujukan = new PPRujukanT;
    $modAntrian = new PPAntrianT;
    $modRujukanBpjs = new PPRujukanbpjsT;
    $modTindakan = new PPTindakanPelayananT;
    $modPembayaran = new PPPembayaranpelayananT();
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
    $modSep->statuskecelakaan_kode = "0";
    $modSep->catatansep = "-";

    // $modKarcisV = array();
    $dataTindakans = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->cekinap = 'rjrd';
    //$modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    //$modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    //$modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
    // $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    //$modPasien->agama = Params::DEFAULT_AGAMA;
    // $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $model->is_asubadak = 0;
    $model->is_asudepartemen = 0;
    $model->is_asupekerja = 0;

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

    //Check if is bridging false or true
    $konfig = KonfigsystemK::model()->find();
    if ($konfig->isbridging == false) {
        $model->is_bpjs_manual = 1;
    }else{
        $model->is_bpjs_manual = 0;
    }

    if (!empty($_GET['antrian_id'])) {
        $modAntrian = PPAntrianT::model()->findByPk($_GET['antrian_id']);
    }

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
    
    //==load data
    if (isset($id)) {
      $model = $this->loadModel($id);
      if ($idSep) {
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

          if (empty($modAsuransiPasienBpjs)) {
            $modAsuransiPasienBpjs  = new PPAsuransipasienbpjsM;
          }
          $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
          $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
          $modSep = PPSepT::model()->findByPk($idSep);

          if (empty($modAsuransiPasienBpjs)) {
            $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
          }

          if (empty($modRujukanBpjs)) {
            $modRujukanBpjs = new PPRujukanbpjsT();
          }
        }
      }
      $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
      $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
      $modPasienAdmisi = PPPasienAdmisiT::model()->findByPk($model->pasienadmisi_id);
      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = PPRujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataTindakans = PPTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id, 'pasienadmisi_id' => $model->pasienadmisi_id), "karcis_id is not null");
    }

    if (isset($idSep)) {
      $modSep = PPSepT::model()->findByPk($idSep);
    }

    if (isset($_POST['PPPendaftaranT'])) { 
      // echo '<pre>';var_dump($_POST);die;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasien = $this->simpanPasien($modPasien, $_POST['PPPasienM']);
        if ($_POST['PPPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['PPPenanggungJawabM'])) {
            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['PPPenanggungJawabM']);
            //RSPMC-1005 -untuk update penanggung jawab ketika penanggung jawab diisi di pendaftaran RI
            if (empty($model->penanggungjawab_id)) {
              PPPendaftaranT::model()->updateByPk($_POST['PPPendaftaranT']['pendaftaran_id'], array('penanggungjawab_id' => $modPenanggungJawab->penanggungjawab_id));
            }
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

        if (isset($_POST['PPPendaftaranT']['is_bpjs'])) {
          //var_dump($_POST);die;
          if (isset($_POST['PPRujukanbpjsT'])) {
            if (!empty($model->sep_id)) {
              $oriSepRdRj = SepT::model()->findByAttributes(array('sep_id' => $model->sep_id));

              if (!empty($oriSepRdRj)) {
                $modRujukanBpjs->no_rujukan = $oriSepRdRj->norujukan;
              }
            }

            if (!empty($model->rujukan_id)) {
              $oriRujukanRdRj = SepT::model()->findByAttributes(array('rujukan_id' => $model->rujukan_id));

              if (!empty($oriRujukanRdRj)) {
                $modRujukanBpjs->asalrujukan_id = $oriRujukanRdRj->asalrujukan_id;
              }
            }

            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
          }
        } else {
          $this->rujukantersimpan = true;
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
          $modAsuransiPasienInhealth = $this->simpanAsuransiPasien($modAsuransiPasienInhealth, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasieninhealthM'], $_POST['PPPasienAdmisiT']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        /* Untuk penjamin inhealth */
        if (isset($_POST['PPSepInhealthT'])) {
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanInhealth, $modAsuransiPasienInhealth, $_POST['PPSepInhealthT']);
          $model->sep_id = $modSep->sep_id;
          PPSepInhealthT::model()->updateByPk($modSep->sep_id, array('is_inhealth' => true));
          $model->update();
        }

        //var_dump($_POST['PPAsuransipasienM']['asuransipasien_id'])
        //die;

        if (isset($_POST['PPAsuransipasienM'])) {
          if (isset($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
              $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
            }
          }
          //var_dump($modAsuransiPasien->attributes); die;
          $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienM']);
        } else {
          $this->asuransipasientersimpan = true;
        }
        // var_dump($_POST); die;
        if (isset($_POST['PPAsuransipasienbpjsM'])) {
          if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
              $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM'], $_POST['PPPasienAdmisiT']);
        } else {
          $this->asuransipasientersimpan = true;
        }
        //var_dump($modAsuransiPasienBpjs->attributes);die;
        //die;
        $modLoadPendaftaran = PPPendaftaranT::model()->findByPk($_POST['PPPendaftaranT']['pendaftaran_id']);
        $modLoadPendaftaran->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
        if (isset($modLoadPendaftaran)) {
          $model = $modLoadPendaftaran;
        }

        $timeset = date_default_timezone_get();

        if ($_POST['PPPasienAdmisiT']['carabayar_id'] == Params::CARABAYAR_ID_JAMKESPA || $_POST['PPPasienAdmisiT']['carabayar_id'] == Params::CARABAYAR_ID_JAMKESDA) {
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPasienAdmisiT'], $_POST['PPPasienM'], $modAsuransiPasien);
          $modSkp = $this->simpanSkp($model, $modPasien, $modRujukan, $modAsuransiPasien);
          $model->skp_id = $modSkp->skp_id;
          $model->no_rujukan = $modSkp->norujukan;
          $model->update();
        }

        if (isset($_POST['PPPendaftaranT']['is_bpjs']) && $_POST['PPPendaftaranT']['is_bpjs'] == 1 ) {   
          $this->cekSepHariIniDanHapus($modAsuransiPasienBpjs);
          // if (isset($_POST['PPSepT']) && isset($_POST['PPSepT']['catatansep'])) {
          //   $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT'], true);
          // }

          // echo '<pre>'; var_dump($modSep->attributes, $model->attributes); die;
          // if (!empty($modSep->sep_id)) $model->sep_id = $modSep->sep_id;
          if (!empty($modRujukanBpjs->rujukan_id)) $model->rujukan_id = $modRujukanBpjs->rujukan_id;
          $model->update();
        }
        
        if (isset($_POST['PPPendaftaranT']['is_bpjs']) && $_POST['PPPendaftaranT']['is_bpjs'] == 1) {
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
          // $model->sep_id = $modSep->sep_id;
          // $model->update();
        }
        
        

        date_default_timezone_set($timeset);

        $modPasienAdmisi = $this->simpanPasienAdmisi($model, $modPasien, $modPasienAdmisi, $_POST['PPPasienAdmisiT']);
        $model->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;

        //update sep_id ke pasienadmisi_t
        if (isset($_POST['PPPendaftaranT']['is_bpjs'])) {
          if (!empty($modSep->sep_id)) {

            $modPasienAdmisi->sep_id = $modSep->sep_id;
            $modPasienAdmisi->update();

            // $model->sep_id = $modSep->sep_id;
            // $model->update();
          }
        }

        // echo '<pre>'; var_dump($model->attributes, $modPasienAdmisi->attributes, $modSep->attributes); die;


        $this->simpanMasukKamar($model, $modPasien, $modPasienAdmisi);

        if (!empty($modPasienAdmisi->kamarruangan_id)) {
        }

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

        // $this->karcistersimpan = true;
        $this->komponentindakantersimpan = true;
        // if ($_POST['PPPendaftaranT']['is_adakarcis']) {
        //   if (isset($_POST['PPTindakanPelayananT'])) {
        //     if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
        //       foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
        //         if ($karcis['is_pilihtindakan']) {
        //           $dataTindakans[$i] = $this->simpanKarcisRI($modTindakan, $model, $modPasienAdmisi, $karcis);
        //         }
        //       }
        //     }
        //     if (isset($_POST['PPPendaftaranT']['is_bayarkarcis'])) { //fitur belum ada >> RND-666
        //       if ($_POST['PPPendaftaranT']['is_bayarkarcis']) { //jika di ceklis
        //       }
        //     }
        //   }
        // }

        $ok_vaksinasi = true;
        if ($_POST['PPPendaftaranT']['is_vaksinasi'] && isset($_POST['RiwayatvaksinasipasienT']['detail'])) {
          $ok_vaksinasi = RiwayatvaksinasipasienT::simpanRiwayat($model->pendaftaran_id, $model->pasien_id, $_POST['RiwayatvaksinasipasienT']['detail']);
        }

        $this->is_simpanpaket = true;
        if (isset($_POST['paket_medis'])) {
          $this->is_simpanpaket = $this->simpanTindakanObatPaket($model, $_POST['paket_medis'], $modPasienAdmisi);
        }


        $this->setAkomodasiLangsung($model, $modPasienAdmisi);

        // die;

        $judul = 'Pendaftaran Pasien Rujuk Rawat Inap';

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;

        $cek = DokrekammedisM::model()->findByAttributes(array('pasien_id' => $model->pasien_id));

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
          //array('instalasi_id'=>Params::INSTALASI_ID_RI, 'ruangan_id'=>$modPasienAdmisi->ruangan_id, 'modul_id'=>7),
          //array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_1, 'modul_id'=>10),
          //array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
          array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' =>  Params::MODUL_ID_REKAMMEDIS, 'link_proses' => $link), //, 'link_proses' => $link
        ));

        if ($ok_vaksinasi && $this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->komponentindakantersimpan && $this->admisitersimpan && $this->masukkamartersimpan && $this->asuransipasientersimpan) { //&& $this->karcistersimpan 
          $model->statusperiksa = Params::STATUSPERIKSA_SEDANG_DIRAWATINAP;
          $model->alihstatus = true;
          $model->save();

          $smspasien = 1;
          $smsdokter = 1;
          $smspenanggungjawab = 1;

          if (Yii::app()->user->getState('issmsgateway')) {
            // SMS GATEWAY
            $modPegawai = $model->pegawai;
            $modRuangan = $model->ruangan;
            // $modKamarRuangan = $modPasienAdmisi->kamarruangan;
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
                $attributes = $modPasienAdmisi->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                } /*
									$attributes = $modKamarRuangan->getAttributes();
									foreach($attributes as $attributes => $value){
										$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
									}
									 * 
									 */
                $attributes = $modRuangan->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPasienAdmisi->tgladmisi), $isiPesan);
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
          }
          // END SMS GATEWAY

          if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] == 1) {
            $this->kirimWhatsAppRI($model, $modPasien, $modPasienAdmisi);
          }

          //kirim informasi pasien sudah didaftarkan ke rawat inap ke modul gizi
          $this->sendNotifToGizi([
            'nama_pasien' => $modPasien->nama_pasien,
            'no_pendaftaran' => $model->no_pendaftaran,
            'no_rekam_medik' => $modPasien->no_rekam_medik
          ]);
          //            die;

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
          //                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
          if ($this->septersimpan) {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
          } else {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
          }
        } else {
          $transaction->rollback();
          $model->isNewRecord = true;
          //                        echo "-".$this->pasientersimpan."<br>";
          //                        echo "-".$this->pendaftarantersimpan."<br>";
          //                        echo "-".$this->penanggungjawabtersimpan."<br>";
          //                        echo "-".$this->rujukantersimpan."<br>";
          //                        echo "-".$this->karcistersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        echo "-".$this->admisitersimpan."<br>";
          //                        echo "-".$this->masukkamartersimpan."<br>";
          //                        exit;
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
      'dataTindakans' => $dataTindakans,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
      'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
      'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
      'modSep' => $modSep,
      'modSmsgateway' => $modSmsgateway,
      // 'modKarcisV' => $modKarcisV,
      'modRujukanInhealth' => $modRujukanInhealth,
      'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
      'modSepInhealthT' => $modSepInhealthT,
      'modAntrian' => $modAntrian
    ));
  }

  public function kirimWhatsAppRI($model, $modPasien, $modPasienAdmisi)
  {

    $str = $modPasien->namadepan . $modPasien->nama_pasien . " dengan No RM " . $modPasien->no_rekam_medik . " ";
    $str .= "dirujuk pada tanggal " . MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran);
    $str .= " dan akan melakukan perawatan di RS pada Ruangan ";
    $str .= $modPasienAdmisi->ruangan->ruangan_nama . " ";
    $str .= "Kamar " . (empty($modPasienAdmisi->kamarruangan) ? "-" : $modPasienAdmisi->kamarruangan->kamarruangan_nokamar) . " - ";
    $str .= (empty($modPasienAdmisi->kamarruangan) ? "-" : $modPasienAdmisi->kamarruangan->kamarruangan_nobed) . "\n\n";

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
        $modPasien = new PPPasienM;
        $modPasienAdmisi = new PPPasienAdmisiT;
        $modPenanggungJawab = null;
        $modRujukan = null;
        $modTindakan = null;

        $model = PendaftaranT::model()->findByAttributes(array(
          'pendaftaran_id' => $_POST['PPPendaftaranT']['pendaftaran_id']
        ));
        $model->attributes = $_POST['PPPendaftaranT'];
        $model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
        $model->no_pendaftaran = $_POST['cari_no_pendaftaran'];
        if (isset($_POST['instalasi_id'])) $model->instalasi_id = $_POST['instalasi_id'];
        $modPasien->attributes = $_POST['PPPasienM'];
        $modPasien->no_rekam_medik = $_POST['cari_no_rekam_medik'];
        $modPasienAdmisi->attributes = $_POST['PPPasienAdmisiT'];
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
        // if ($_POST['PPPendaftaranT']['is_adakarcis']) {
        //   if (isset($_POST['PPTindakanPelayananT'])) {
        //     if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
        //       foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
        //         if ($karcis['is_pilihtindakan']) {
        //           $modTindakan = new PPTindakanPelayananT;
        //           $modTindakan->attributes = $karcis;
        //           $modTindakan->karcis_id = $karcis['karcis_id'];
        //         }
        //       }
        //     }
        //   }
        // }
      }

      // if (isset($_POST['PPTindakanPelayananT'])) {
      //   // $cekNoKarcis = true;
      //   if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
      //     // foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
      //     //   if ($karcis['is_pilihtindakan']) {
      //     //     if (!empty($karcis['karcis_id'])) {
      //     //       $cekNoKarcis = $cekNoKarcis && false;
      //     //     } else {
      //     //       $cekNoKarcis = $cekNoKarcis && true;
      //     //     }
      //     //   }
      //     // }
      //   }

      //   // if ($cekNoKarcis == true) {
      //   //   $ok = 0;
      //   //   $msg = "Maaf, Karcis tidak ditemukan";
      //   // }
      // } else {
      //   $ok = 0;
      //   // $msg = "Maaf, Karcis tidak ditemukan";
      // }


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
   * Mengurai data pasien (kunjungan) berdasarkan:
   * - instalasi_id (RJ / RD)
   * - pendaftaran_id
   * - no_pendaftaran
   * - pasien_id
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataPasienRJRD()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();

      $kec_id = null;
      $modDialogKunjungan = new PPPasientindaklanjutkeriV('searchDialogUntukPendaftaranRI');
      $modDialogKunjungan->unsetAttributes();
      $modDialogKunjungan->statusperiksa = Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO;
      $modDialogKunjungan->no_pendaftaran = $no_pendaftaran;
      $modDialogKunjungan->no_rekam_medik = $no_rekam_medik;
      $modDialogKunjungan->instalasi_id = $instalasi_id;
      $modDialogKunjungan->pendaftaran_id = $pendaftaran_id;
      $modDialogKunjungan->pasien_id = $pasien_id;

      $prov = $modDialogKunjungan->searchDialogUntukPendaftaranRI();
      $prov->pagination = false;



      $model = PPPasientindaklanjutkeriV::model()->find($prov->criteria);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
      if (!empty($model->pasien_id)) {

        $returnVal['nomorspri_bpjs'] = '';
        if($model->carabayar_id == Params::CARABAYAR_ID_BPJS) {
          $modSPRI = SuratperintahranapT::model()->findByAttributes(['pendaftaran_id' => $model->pendaftaran_id]);
          if(!empty($modSPRI)) {
            $returnVal['nomorspri_bpjs'] = $modSPRI->nomorspri_bpjs;
          }
        }
        $modPasien = PasienM::model()->findByPk($model->pasien_id);
        $returnVal['pegawai_id'] = $modPasien->pegawai_id;
        $returnVal['nomorindukpegawai'] = isset($modPasien->pegawai_id) ? $modPasien->pegawai->nomorindukpegawai : '';
        $returnVal['nama_pegawai'] = isset($modPasien->pegawai_id) ? $modPasien->pegawai->nama_pegawai : '';
        $returnVal['gelardepan'] = isset($modPasien->pegawai_id) ? $modPasien->pegawai->gelardepan : '';
        $returnVal['unit_perusahaan'] = isset($modPasien->pegawai_id) ? $modPasien->pegawai->unit_perusahaan : '';
        $returnVal['gelarbelakang_nama'] = isset($modPasien->pegawai->gelarbelakang->gelarbelakang_nama) ? $modPasien->pegawai->gelarbelakang->gelarbelakang_nama : "";
        $returnVal['jabatan_nama'] = isset($modPasien->pegawai->jabatan->jabatan_nama) ? $modPasien->pegawai->jabatan->jabatan_nama : "";
        $returnVal['dokterpenerima_id'] = $model->dokterpenerima_id;
        $returnVal['dpjp1_id'] = $model->dpjp1_id;
        $returnVal['dpjp2_id'] = $model->dpjp2_id;
        $returnVal['dpjp3_id'] = $model->dpjp3_id;
        $returnVal['dpjp4_id'] = $model->dpjp4_id;
        $returnVal['dpjp5_id'] = $model->dpjp5_id;

        $returnVal['dokterpenerima'] = '';
        $returnVal['dpjp1'] = '';
        $returnVal['dpjp2'] = '';
        $returnVal['dpjp3'] = '';
        $returnVal['dpjp4'] = '';
        $returnVal['dpjp5'] = '';

        $returnVal['is_approve_rd'] = 1;

        $modPulang = PasienpulangT::model()->find("pasien_id = $model->pasien_id order by pasienpulang_id desc");
        $returnVal['penerimapasien'] = !empty($modPulang) ? $modPulang->penerimapasien : "";
        

        if (!empty($model->dokterpenerima_id)) {
          $peg = PegawaiM::model()->findByPk($model->dokterpenerima_id);
          $returnVal['dokterpenerima'] = $peg->namaLengkap;
        }
        if (!empty($model->dpjp1_id)) {
          $peg = PegawaiM::model()->findByPk($model->dpjp1_id);
          $returnVal['dpjp1'] = $peg->namaLengkap;
        }
        if (!empty($model->dpjp2_id)) {
          $peg = PegawaiM::model()->findByPk($model->dpjp2_id);
          $returnVal['dpjp2'] = $peg->namaLengkap;
        }
        if (!empty($model->dpjp3_id)) {
          $peg = PegawaiM::model()->findByPk($model->dpjp3_id);
          $returnVal['dpjp3'] = $peg->namaLengkap;
        }

        if (!empty($model->dpjp4_id)) {
          $peg = PegawaiM::model()->findByPk($model->dpjp4_id);
          $returnVal['dpjp4'] = $peg->namaLengkap;
        }
        if (!empty($model->dpjp5_id)) {
          $peg = PegawaiM::model()->findByPk($model->dpjp5_id);
          $returnVal['dpjp5'] = $peg->namaLengkap;
        }

        if ($model->instalasi_id == Params::INSTALASI_ID_RD) {
          $tindakan = TindakanpelayananT::model()->findByAttributes(array(
            'pendaftaran_id'=>$model->pendaftaran_id,
            'isapprovaltindaklanjut'=>true,
          ));
    
          $oa = ObatalkespasienT::model()->findByAttributes(array(
            'pendaftaran_id'=>$model->pendaftaran_id,
            'isapprovaltindaklanjut'=>true,
          ));
  
          if (empty($tindakan) && empty($oa)) {
            $returnVal['is_approve_rd'] = 0;
          }
        }



      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk menampilkan pasien lama dari autocomplete
   * - instalasi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * - no_identitas_pasien
   * - nama_pasien
   * - nama_bin (alias)
   */
  public function actionAutocompletePasienRJRD()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;

      if (empty($no_badge)) {

        $kec_id = null;
        $modDialogKunjungan = new PPPasientindaklanjutkeriV('searchDialogUntukPendaftaranRI');
        $modDialogKunjungan->unsetAttributes();
        $modDialogKunjungan->statusperiksa = Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO;
        $modDialogKunjungan->no_pendaftaran = $no_pendaftaran;
        $modDialogKunjungan->no_rekam_medik = $no_rekam_medik;
        $modDialogKunjungan->no_identitas_pasien = $no_identitas_pasien;
        $modDialogKunjungan->nama_pasien = $nama_pasien;

        $prov = $modDialogKunjungan->searchDialogUntukPendaftaranRI();
        $prov->pagination = false;

        /*
					$criteria = new CDbCriteria();
					if(!empty($instalasi_id)){
						$criteria->addCondition("instalasi_id = ".$instalasi_id); 				
					}
					$criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
					$criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
					$criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
					$criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
                                        $criteria->addCondition('pasienpulang_id is not null');
					$criteria->order = 'no_rekam_medik, nama_pasien';
					$criteria->limit = 50;
					$models = PPPasientindaklanjutkeriV::model()->findAll($criteria);
                     * 
                     */

        foreach ($prov->data as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          // $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->namadepan . $model->nama_pasien;
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - '. $model->no_identitas_pasien . " - "  . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_pendaftaran;
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
   * load cek cara bayar BPJS
   */
  public function actionCekCaraBayarBPJS()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $cr = new CDbCriteria();
      $cr->compare("pasien_id", $_POST['pasien_id']);
      $cr->order = "asuransipasien_id desc";
      $cr->limit = 1;
      $asuransi = AsuransipasienM::model()->find($cr);
      $pendaftaran = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
      $pp = PasienpulangT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran->pendaftaran_id,
      ));

      $profil = ProfilrumahsakitM::model()->find();

      $sep = SepT::model()->findByPk($pendaftaran->sep_id);

      $ruangan = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
        'instalasi_id' => array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD),
      )), 'ruangan_id', 'ruangan_id');

      $morbid = PasienmorbiditasT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran->pendaftaran_id,
        'ruangan_id' => $ruangan,
      ), array(
        'order' => 'kelompokdiagnosa_id asc',
      ));

      $rujukan = RujukandariM::model()->findByAttributes(array(
        'ppkrujukan' => $profil->ppkpelayanan,
      ));

      $spri = SuratperintahranapT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran->pendaftaran_id,
      ));





      $res = array(
        "dat" => null,
        "diag" => array(
          "kode" => null,
          "nama" => null,
        ),
        "sep" => null,
        "rujukandari_id" => null,
        "asalrujukan_id" => null,
        "spri" => null,
      );

      if (!empty($spri) && !empty($spri->nomorspri_bpjs)) {
        $res['spri'] = $spri->nomorspri_bpjs;
      }

      if (!empty($rujukan)) {
        $res["rujukandari_id"] = $rujukan->rujukandari_id;
        $res["asalrujukan_id"] = $rujukan->asalrujukan_id;
      }

      if (!empty($asuransi)) {
        $res["dat"] = $asuransi->attributes;
      }

      $res["ppk"] = $profil->ppkpelayanan;
      $res["ruj"] = MyGenerator::noRujukanLokalBpjs(); //date('dmY');
      $res["tglruj"] = $pp->tglpasienpulang;

      if (!empty($sep)) {
        $res['sep'] = $sep->attributes;
      }

      if (!empty($morbid)) {
        $diag = DiagnosaM::model()->findByPk($morbid->diagnosa_id);
        $res["diag"]["kode"] = $diag->diagnosa_kode;
        $res["diag"]["nama"] = $diag->diagnosa_nama;
      } else if (!empty($sep)) {
        $diag = DiagnosaM::model()->findByAttributes(array(
          'diagnosa_kode' => $sep->diagnosaawal,
        ));
        if (!empty($diag)) {
          $res["diag"]["kode"] = $diag->diagnosa_kode;
          $res["diag"]["nama"] = $diag->diagnosa_nama;
        }
      }
      echo CJSON::encode($res);
    }
    Yii::app()->end();
  }

  protected function cekSepHariIniDanHapus($modAsuransiPasienBpjs)
  {
    $bpjs = new Bpjs();
    // $dat = json_decode($bpjs->riwayat_terakhir($modAsuransiPasienBpjs->nokartuasuransi));

    // var_dump($dat); die;

    if (empty($dat)) return false;

    if ($dat->metadata->code != 200) return false;

    $last = $dat->response->list[0];
    if ($last->tglSEP != date('Y-m-d')) return false;
    $sep = $last->noSEP;
    $ppk = substr($sep, 0, 8);

    $str = "<request><data><t_sep>";
    $str .= "<noSep>" . $sep . "</noSep>";
    $str .= "<ppkPelayanan>" . $ppk . "</ppkPelayanan>";
    $str .= "</t_sep></data></request>";

    $dat = json_decode($bpjs->delete_sep($str));

    // var_dump($dat);

    //die;
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
      $kelaspelayanan_id = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null;

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
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'ruangan_id' => $ruangan_id, 'kamarruangan_aktif' => true), array('order' => 'kamarruangan_id'));
          } else {
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_aktif' => true), array('order' => 'kamarruangan_id'));
          }

          $modBookingKamar = BookingkamarT::model()->findByPk($bookingkamar_id);
        } else {

          //  if ( ($rawatgabung == '1') ){//($ruangan_id ==  Params::RUANGAN_ID_BERSALIN) && 
          if (!empty($kelaspelayanan_id)) {
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'ruangan_id' => $ruangan_id, 'kamarruangan_aktif' => true), array('order' => 'kamarruangan_id'));
          } else {
            $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_aktif' => true), array('order' => 'kamarruangan_id'));
          }
          // }else{                                                           
          //   $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true, 'kamarruangan_aktif'=>true),array('order'=>'kamarruangan_nokamar'));                            
          // }

        }


        if ($check == 'check') {
          // if ( ($rawatgabung == '1') ){//($ruangan_id ==  Params::RUANGAN_ID_BERSALIN) && 
          $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidurInUseV2');
          // }else{
          //   $kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
          // }
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
          $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidurInUseV2');
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
   * 
   */

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

   
  public function sendNotifToGizi($data)
  {
    $judul = 'Pendaftaran Pasien Rujuk Rawat Inap';
    $isi = $data['no_pendaftaran'] . ' - ' . $data['no_rekam_medik'] . ' - ' . $data['nama_pasien'];

    $rgizi = RuanganM::model()->findAll(" ruangan_aktif = TRUE AND instalasi_id = " . Params::INSTALASI_ID_GIZI);

    if (!empty($rgizi)) {
      $arr = [];
      foreach ($rgizi as $key => $val) {
        $arr[] = [
          'instalasi_id' => $val->instalasi_id,
          'ruangan_id' => $val->ruangan_id,
          'modul_id' => $val->modul_id
        ];
      }

      $notif = CustomFunction::broadcastNotif($judul, $isi, $arr);
    }
  }

  public function actionCetakFormulirPendaftaranRI($pendaftaran_id)
  {

    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    $judulLaporan = 'FORMULIR PENDAFTARAN RAWAT INAP';
    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    //$mpdf->useOddEven = 2;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
    $mpdf->WriteHTML($this->renderPartial($this->path_view_ri_dari_rjrd . '/suratPernyataanRI/_cetakFormulirPendaftaranRI', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modAdmisi' => $modAdmisi, 'judulLaporan' => $judulLaporan), true));
    $mpdf->Output();
  }

  /**
   * Surat Pernyataan Umum 
   * @param type $pendaftaran_id
   * @param type $id
   */
  public function actionSuratPernyataanUmum($pendaftaran_id, $id = null)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasienAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $modAdaSurat = SuratpernyataanumumT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
    if (!empty($modAdaSurat)) {
      $modSurat = $modAdaSurat;
    } else {
      $modSurat = new SuratpernyataanumumT();
      $modSurat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modSurat->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
      $modSurat->tgl_pernyataan = date('d/m/Y H:i:s');
    }

    $judulLaporan = 'FORMULIR SURAT PERNYATAAN <br> UMUM PASIEN RAWAT INAP';

    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    } else {
      $modPenanggungJawab = new PPPenanggungJawabM();
    }
    if (isset($_POST['SuratpernyataanumumT'])) {
      $ok = true;
      $pesan = '';
      $trans = Yii::app()->db->beginTransaction();
      try {
        $proses = SuratpernyataanumumT::simpan_data($modSurat, $_POST['SuratpernyataanumumT']);
        $model = $proses['model'];
        $ok &= $proses['sukses'];
        $pesan .= $proses['pesan'];

        if ($ok) {
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $trans->commit();
          $this->redirect(array('suratPernyataanUmum', 'pendaftaran_id' => $pendaftaran_id, 'id' => $model->suratpernyataanumum_id, 'sukses' => 1));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan <br/>" . $pesan);
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view_rj_dari_rj_rd . '/suratPernyataanRI/_1_suratPertama', [
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPasienAdmisi' => $modPasienAdmisi,
      'modSurat' => $modSurat,
      'modPenanggungJawab' => $modPenanggungJawab,
      'judulLaporan' => $judulLaporan
    ]);
  }

  /**
   * Cetak Surat Pernyataam Umum 
   * @param type $id
   */
  public function actionPrintSuratPernyataanUmum($id)
  {
    $modSurat = SuratpernyataanumumT::model()->findByPk($id);
    $modPendaftaran = PPPendaftaranT::model()->findByPk($modSurat->pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    } else {
      $modPenanggungJawab = new PPPenanggungJawabM();
    }

    $judulLaporan = 'FORMULIR SURAT PERNYATAAN <br> 
                                  UMUM PASIEN RAWAT INAP ';
    $ukuranKertasPDF = Params::DEFAULT_KERTAS_UKURAN;                  //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
    $mpdf->SetHTMLFooter('<span></span>');
    $mpdf->WriteHTML($this->renderPartial($this->path_view_rj_dari_rj_rd . '/suratPernyataanRI/_1_print_suratPertama', array(
      'modSurat' => $modSurat,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'modPasienAdmisi' => $modAdmisi,
      'modPenanggungJawab' => $modPenanggungJawab,
      'judulLaporan' => $judulLaporan
    ), true));
    $mpdf->Output();
  }

  /**
   * Cetak Surat Pernyataam Umum 
   * @param type $id
   */
  public function actionPrintSuratPernyataanBpjs($pendaftaran_id)
  {
    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $modSurat = SuratpernyataanumumT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    } else {
      $modPenanggungJawab = new PPPenanggungJawabM();
    }

    $judulLaporan = 'FORMULIR PERNYATAAN UMUM PASIEN BPJS';
    $ukuranKertasPDF = Params::DEFAULT_KERTAS_UKURAN;                  //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
    $mpdf->SetHTMLFooter('<span></span>');
    $mpdf->WriteHTML($this->renderPartial($this->path_view_rj_dari_rj_rd . '/suratPernyataanRI/_2_print_suratBPJS', array(
      'modSurat' => $modSurat,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'modAdmisi' => $modAdmisi,
      'modPenanggungJawab' => $modPenanggungJawab,
      'judulLaporan' => $judulLaporan
    ), true));
    $mpdf->Output();
  }

  public function actionPrintPersetujuanUmum($id, $jenis)
  {
    $modSurat = FormpersetujuanumumriT::model()->findByPk($id);
    $modPendaftaran = PPPendaftaranT::model()->findByPk($modSurat->pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    } else {
      $modPenanggungJawab = new PPPenanggungJawabM();
    }

    $modInstalasi = InstalasiM::model()->findByAttributes(['instalasi_singkatan' => $jenis, 'instalasi_aktif' => true]);

    $judulLaporan = 'PERSETUJUAN UMUM ';

    $ukuran = Params::getUkuranKertas();
    $ukuranKertasPDF = $ukuran['F4'];                  //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
    $mpdf->SetHTMLFooter('<span></span>');
    // var_dump($this->path_view_rj_dari_rj_rd . '/suratPersetujianRI/_1_print_suratPertama');die;
    $mpdf->WriteHTML($this->renderPartial($this->path_view_rj_dari_rj_rd . '/suratPersetujuanRI/_1_print_suratPertama', array(
      'modSurat' => $modSurat,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'modPasienAdmisi' => $modAdmisi,
      'modPenanggungJawab' => $modPenanggungJawab,
      'judulLaporan' => $judulLaporan
    ), true));
    $mpdf->Output();
  }
  /**
   * Surat Persetujuan Umum 
   * @param type $pendaftaran_id
   * @param type $id
   */
  public function actionPersetujuanUmum($pendaftaran_id, $id = null, $jenis = null)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasienAdmisi = new PPPasienAdmisiT();
    if (!empty($modPendaftaran->pasienadmisi_id)) {
      $modPasienAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $penjamin = PenjaminpasienM::model()->findByPk($modPasienAdmisi->penjamin_id);
    } else {
      $penjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
    }
    if (!empty($id)) {
      $modSurat = FormpersetujuanumumriT::model()->findByPk($id);
    } else {
      $modSurat = new FormpersetujuanumumriT();
    }

    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    } else {
      $modPenanggungJawab = new PPPenanggungJawabM();
    }
    $modSurat->nama_penjamin = $penjamin->penjamin_nama;

    $modInstalasi = InstalasiM::model()->findByAttributes(['instalasi_singkatan' => $jenis, 'instalasi_aktif' => true]);

    $judulLaporan = 'FORMULIR SURAT PERSETUJUAN <br> UMUM PASIEN ' . strtoupper($modInstalasi->instalasi_nama);

    if (isset($_POST['FormpersetujuanumumriT'])) {
      $ok = true;
      $pesan = '';
      $trans = Yii::app()->db->beginTransaction();

      try {
        $modSurat = new  FormpersetujuanumumriT();
        $modSurat->pendaftaran_id = $pendaftaran_id;
        $modSurat->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
        $modSurat->penjamin_id = $penjamin->penjamin_id;
        $modSurat->dokterkeluarga_pasien = $_POST['FormpersetujuanumumriT']['dokterkeluarga_pasien'];
        $modSurat->penanggungjawab_pasien = $_POST['FormpersetujuanumumriT']['penanggungjawab_pasien'];
        $modSurat->nama_pj  = $_POST['FormpersetujuanumumriT']['nama_pj'];
        // var_dump($modSurat);die;
        if (empty($modSurat->formpersetujuanumumri_id)) {
          $modSurat->create_time = date('Y-m-d H:i:s');
          $modSurat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $modSurat->create_ruangan = Yii::app()->user->getState('ruangan_id');
        } else {
          $modSurat->update_time = date('Y-m-d H:i:s');
          $modSurat->update_loginpemakai = Yii::app()->user->getState('loginpemakai_id');
        }
        // $proses = $modSurat->save();
        if ($modSurat->save()) {
          // $modSuratSimpan = $proses['model'];
          $ok &= 1;
          $pesan .= 'berhasil';
        }


        if ($ok) {
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $trans->commit();
          $this->redirect(array('persetujuanUmum', 'pendaftaran_id' => $pendaftaran_id, 'id' => $modSurat->formpersetujuanumumri_id, 'sukses' => 1, 'jenis' => $jenis));
        } else {

          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan <br/>" . $pesan);
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($ex, true));
      }
    }


    $this->render($this->path_view_rj_dari_rj_rd . '/suratPersetujuanRI/_1_suratPertama', [
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPasienAdmisi' => $modPasienAdmisi,
      'modSurat' => $modSurat,
      'modPenanggungJawab' => $modPenanggungJawab,
      'judulLaporan' => $judulLaporan
    ]);
  }

  /**
   * Surat Pernyataan Umum 
   * @param type $pendaftaran_id
   * @param type $id
   */
  public function actionSuratPersetujuanUmum($pendaftaran_id, $id = null)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasienAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $modSurat = new FormpersetujuanumumriT();
    $modSurat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modSurat->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
    if (!empty($id)) {
      $modSurat = FormpersetujuanumumriT::model()->findByPk($id);
    }
    $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    $judulLaporan = 'FORMULIR SURAT PERSETUJUAN <br> 
                            UMUM PASIEN RAWAT INAP ';

    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    } else {
      $modPenanggungJawab = new PPPenanggungJawabM();
    }
    $judulLaporan = 'FORMULIR SURAT PERSETUJUAN <br> 
                                  UMUM PASIEN RAWAT INAP ';

    $this->render($this->path_view_rj_dari_rj_rd . '/suratPersetujuanRI/_3_surat_pernyataan_khusus', [
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPasienAdmisi' => $modPasienAdmisi,
      'modSurat' => $modSurat,
      'modPenanggungJawab' => $modPenanggungJawab,
      'judulLaporan' => $judulLaporan
    ]);
  }

  /**
   * Surat Pernyataan Umum 
   * @param type $pendaftaran_id
   * @param type $id
   */
  public function actionSuratPernyataanKhusus($pendaftaran_id, $id = null)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasienAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $modSurat = new SuratpernyataanumumT();
    $modSurat->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modSurat->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;

    $modSuratPernyataan = SuratpernyataanumumT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
    if (!empty($modSuratPernyataan)) {
      $modSurat = $modSuratPernyataan;
    }
    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    } else {
      $modPenanggungJawab = new PPPenanggungJawabM();
    }

    $judulLaporan = 'FORMULIR PERNYATAAN <br> KHUSUS PASIEN RAWAT INAP ';

    $loadData = array();
    $modForm = FormpernyataankhususM::model()->findAllByAttributes(['formpernyataankhusus_aktif' => true]);
    $modSuratKhusus = new SuratpernyataankhususT();

    if (!empty($modSuratPernyataan)) {
      $modLoadSurat = SuratpernyataankhususT::model()->findAllByAttributes(['suratpernyataanumum_id' => $modSuratPernyataan->suratpernyataanumum_id]);
      if (!empty($modLoadSurat)) {
        foreach ($modLoadSurat as $key => $det) {
          $id = $det['suratpernyataankhusus_id'];

          $loadData[$id]['suratpernyataankhusus_id'] = $id;
          if (empty($det['formpernyataankhusus_id'])) {
            $loadData[$id]['formpernyataankhusus_nama'] = $det['lainlain'];
            $loadData[$id]['lainlain'] = $det['lainlain'];
          } else {
            $modForm = FormpernyataankhususM::model()->findByPk($det['formpernyataankhusus_id']);
            $loadData[$id]['formpernyataankhusus_nama'] = $modForm['formpernyataankhusus_nama'];
          }

          $loadData[$id]['suratpernyataankhusus_checklist'] = ($det['suratpernyataankhusus_checklist'] == true) ? 1 : 0;
          $loadData[$id]['formpernyataankhusus_id'] = !empty($det['formpernyataankhusus_id']) ? $det['formpernyataankhusus_id'] : "";
        }
      }
    } else {
      if (!empty($modForm)) {
        foreach ($modForm as $key => $det) {
          $id = $det['formpernyataankhusus_id'];

          $loadData[$id]['formpernyataankhusus_id'] = $id;
          $loadData[$id]['formpernyataankhusus_nama'] = $det['formpernyataankhusus_nama'];
          $loadData[$id]['haschecklist'] = ($det['haschecklist'] == true) ? 1 : 0;
        }
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

    $this->render($this->path_view_rj_dari_rj_rd . '/suratPernyataanRI/_3_surat_pernyataan_khusus', [
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



  /**
   * Cetak Surat Pernyataan Khusus
   * @param type $id
   */
  public function actionPrintSuratPernyataanKhusus($id)
  {
    $modSurat = SuratpernyataanumumT::model()->findByPk($id);
    $modPendaftaran = PPPendaftaranT::model()->findByPk($modSurat->pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = PPPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    if (!empty($modPendaftaran->penanggungjawab_id)) {
      $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    } else {
      $modPenanggungJawab = new PPPenanggungJawabM();
    }

    $loadData = array();
    $modSuratKhusus = SuratpernyataankhususT::model()->findAllByAttributes(['suratpernyataanumum_id' => $modSurat->suratpernyataanumum_id]);
    if (!empty($modSuratKhusus)) {
      foreach ($modSuratKhusus as $key => $det) {
        $id = $det['suratpernyataankhusus_id'];
        $loadData[$id]['suratpernyataankhusus_id'] = $id;
        if (!empty($det['formpernyataankhusus_id'])) {
          $modForm = FormpernyataankhususM::model()->findByPk($det['formpernyataankhusus_id']);
          $loadData[$id]['formpernyataankhusus_nama'] = $modForm['formpernyataankhusus_nama'];
        } else {
          $loadData[$id]['formpernyataankhusus_nama'] = $det['lainlain'];
        }
        $loadData[$id]['suratpernyataankhusus_checklist'] = ($det['suratpernyataankhusus_checklist'] == true) ? 1 : 0;
        $loadData[$id]['formpernyataankhusus_id'] = !empty($det['formpernyataankhusus_id']) ? $det['formpernyataankhusus_id'] : "";
      }
    }

    $judulLaporan = 'FORMULIR PERNYATAAN KHUSUS PASIEN RAWAT INAP ';
    $ukuranKertasPDF = Params::DEFAULT_KERTAS_UKURAN;                  //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', $ukuranKertasPDF);
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 10, 10, 10, 10);
    $mpdf->SetHTMLFooter('<span></span>');
    $mpdf->WriteHTML($this->renderPartial($this->path_view_rj_dari_rj_rd . '/suratPernyataanRI/_3_print_surat_pernyataan_khusus', array(
      'modSurat' => $modSurat,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'modAdmisi' => $modAdmisi,
      'loadData' => $loadData,
      'modPenanggungJawab' => $modPenanggungJawab,
      'judulLaporan' => $judulLaporan
    ), true));
    $mpdf->Output();
  }
  function actionGetPJPasien()
  {
      if (Yii::app()->request->isAjaxRequest) {
          $format = new MyFormatter();
          $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
          $returnValPP = array();
          if (!empty($pasien_id)) {
              $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                  'pasien_id' => $pasien_id,
              ), array(
                  'condition' => 'penanggungjawab_id is not null'
              ));
              
              if (!empty($pendaftaran)) {
                  $penanggungJP = PenanggungjawabM::model()->findByAttributes(array(
                      'penanggungjawab_id' => $pendaftaran->penanggungjawab_id,
                  ));

                  $returnValPP['pengantar'] = $penanggungJP->pengantar;
                  $returnValPP['nama_pj'] = $penanggungJP->nama_pj;
                  $returnValPP['jeniskelamin'] = $penanggungJP->jeniskelamin;
                  $returnValPP['jenisidentitas'] = $penanggungJP->jenisidentitas;
                  $returnValPP['no_identitas'] = $penanggungJP->no_identitas;
                  $returnValPP['no_teleponpj'] = $penanggungJP->no_teleponpj;
                  $returnValPP['no_mobilepj'] = $penanggungJP->no_mobilepj;
                  $returnValPP['hubungankeluarga'] = $penanggungJP->hubungankeluarga;
                  $returnValPP['tempatlahir_pj'] = $penanggungJP->tempatlahir_pj;
                  $returnValPP['tgllahir_pj'] = date('d/m/Y', strtotime($penanggungJP->tgllahir_pj));
                  $returnValPP['alamat_pj'] = $penanggungJP->alamat_pj;
              } else {
                  $returnValPP = null;
              }
          }
          echo CJSON::encode($returnValPP);
          Yii::app()->end();
      }
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
            $this->renderPartial('printLabel', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }
}

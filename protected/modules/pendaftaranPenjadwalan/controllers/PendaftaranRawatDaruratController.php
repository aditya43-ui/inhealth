<?php
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalanController');
class PendaftaranRawatDaruratController extends PendaftaranRawatJalanController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan.";
  public $path_viewRD = "pendaftaranPenjadwalan.views.pendaftaranRawatDarurat.";

  public $kecelakaantersimpan = false;
  /**
   * Index transaksi pendaftaran
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


   
  public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pendaftaran Rawat Darurat";
    $modAntrian = new PPAntrianT;
    $format = new MyFormatter();
    $model = new PPPendaftaranT;
    $modPasien = new PPPasienM;
    $modPegawai = new PPPegawaiM;
    $modPegawaiPJ = new PPPegawaiM;
    $modPenanggungJawab = new PPPenanggungJawabM;
    $modRujukan = new PPRujukanT;
    $modRujukanBpjs = new PPRujukanbpjsT;
    $modKecelakaan = new PPPasienkecelakaanT;
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
    $modSepInhealthT->jnspelayanan = 3; //defaul RJTL


    $modSep = new PPSepT;
    $modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
    $modSep->ppkpelayanan_nama = Yii::app()->user->getState('nama_ppkpelayanan');
    $peg_user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

    $modSep->catatansep = "-";
    if (isset($peg_user)) {
      $modSep->pembuat_sep = $peg_user->nama_pegawai;
    }
    $modSep->suplesi_jasaraharja = 0;
    $dataTindakans = array();
    $modKarcisV = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    //$modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    //$modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    //$modPasien->kelurahan_id = Yii::app()->user->getState('kelurahan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    //$modPasien->agama = Params::DEFAULT_AGAMA;
    $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $model->is_pasienrujukan = 0;
    $model->is_asubadak = 0;
    $model->is_asudepartemen = 0;
    $model->is_asupekerja = 0;
    $model->is_adapjpasien = 1;

    if(isset($_GET['notriage_pasien_id'])) {
      $modNotriagePasien = NotriagePasienT::model()->findByPk($_GET['notriage_pasien_id']);
      if(!empty($modNotriagePasien)) {
        $modPasien->nama_pasien = $modNotriagePasien->keterangan;
      }
    }


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
    $modRujukanBpjs->tanggal_rujukan = date('Y-m-d H:i:s');

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

    // LNG-1578 untuk notif pemberitahuan sbelum simpan, jika pasien yang sudah terdaftar	201410001 
    $criteria = new CDbCriteria;
    $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
    $criteria->order = 'tgl_pendaftaran DESC';
    $criteria->addCondition("asal_data = 'PENDAFTARAN'");
    $criteria->limit = 10;
    $modPasienTerakhir = PPInfoKunjunganRDV::model()->findAll($criteria);

    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;

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
          $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($model->rujukan_id) ?? new PPRujukanbpjsT;
          $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
          $modSep = PPSepT::model()->findByPk($idSep);
        }
      }
      $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
        if (!empty($modPenanggungJawab->pegawai_id)) {
          $modPasien->pegawai_penanggungjawab_id = $modPenanggungJawab->pegawai_id;
          $modPegawaiPJ = PPPegawaiM::model()->findByPk($modPenanggungJawab->pegawai_id);
        }
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = PPRujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataTindakans = PPTindakanPelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
    }

    if (isset($idSep)) {
      $modSep = PPSepT::model()->findByPk($idSep);
    }


    $pasien_id = (isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null);
    if (isset($pasien_id)) {
      $modPasien = PPPasienM::model()->findByPk($pasien_id);
      $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
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

            //var_dump($modPenanggungJawab->getErrors());
          }
        } else {
          $this->penanggungjawabtersimpan = true;
        }

        if (isset($_POST['PPPasienM']['pegawai_penanggungjawab_id'])) {
          $modPenanggungJawab = $this->simpanPenanggungjawabDokter($modPenanggungJawab, $_POST['PPPasienM']['pegawai_penanggungjawab_id']);
        }

        if ($_POST['PPPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['PPRujukanT'])) {
            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['PPRujukanT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        if ($_POST['PPPendaftaranT']['carabayar_id'] == Params::CARABAYAR_ID_JAMKESPA || $_POST['PPPendaftaranT']['carabayar_id'] == Params::CARABAYAR_ID_JAMKESDA) {
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasien);
          $modSkp = $this->simpanSkp($model, $modPasien, $modRujukan, $modAsuransiPasien);
          $model->skp_id = $modSkp->skp_id;
          $model->no_rujukan = $modSkp->norujukan;
          $model->update();
        }

        if (isset($_POST['PPPendaftaranT']['is_bpjs'])) {
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
        
        if (isset($_POST['PPPendaftaranT']['is_bpjs']) &&  $_POST['PPPendaftaranT']['is_bpjs'] == 1) {
          
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanBpjs, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasienBpjs);
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasien, $_POST['PPSepT']);
          $model->sep_id = $modSep->sep_id;
          $model->update();
        } else {
          if (isset($_POST['PPSepInhealthT'])) { //simpan pendaftaran ketika brigin dengan inhealth
            $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanInhealth, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasienInhealth);
          } else {
            $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasien);
            
          }
        }
        // if (isset($_POST['PPSepT']['tglsep']) || isset($_POST['PPSepT']['tglsep'])) {
        //   $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
        //   $model->sep_id = $modSep->sep_id;
        //   $model->update();
        // }

        /* Untuk penjamin inhealth */
        if (isset($_POST['PPSepInhealthT'])) {
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanInhealth, $modAsuransiPasienInhealth, $_POST['PPSepInhealthT']);
          $model->sep_id = $modSep->sep_id;
          PPSepInhealthT::model()->updateByPk($modSep->sep_id, array('is_inhealth' => true));
          $model->update();
        }

        if ($_POST['PPPendaftaranT']['is_pasienkecelakaan']) {
          if (isset($_POST['PPPasienkecelakaanT'])) {
            $modKecelakaan = $this->simpanKecelakaan($modKecelakaan, $model, $_POST['PPPasienkecelakaanT']);
          }
        } else {
          $this->kecelakaantersimpan = true;
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


        $this->karcistersimpan = true;
        $this->komponentindakantersimpan = true;
        if ($_POST['PPPendaftaranT']['is_adakarcis']) {
          if (isset($_POST['PPTindakanPelayananT'])) {
            if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
              foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
                if ($karcis['is_pilihtindakan']) {
                  $modTindakan = new TindakanpelayananT();
                  $dataTindakans[$i] = $this->simpanKarcis($modTindakan, $model, $karcis);
                  $model->karcis_id = $dataTindakans[$i]->karcis_id;
                  $model->save();
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

        $ok_vaksinasi = true;
        if ($_POST['PPPendaftaranT']['is_vaksinasi'] && isset($_POST['RiwayatvaksinasipasienT']['detail'])) {
          $ok_vaksinasi = RiwayatvaksinasipasienT::simpanRiwayat($model->pendaftaran_id, $model->pasien_id, $_POST['RiwayatvaksinasipasienT']['detail']);
        }


        $judul = 'Pendaftaran Pasien';

        if ($model->statuspasien == 'PENGUNJUNG LAMA') {
          $judul .= " Lama";
        } else $judul .= " Baru";


        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;

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

        $ruangan = RuanganM::model()->findByPk($model->ruangan_id);

        if ($ruangan->ruangan_id == Params::RUANGAN_ID_VK) {
          $judul .= " Persalinan";
          $link_rd = $this->createUrl('/persalinan/DaftarPasien/Index', array(
            'PSInfokunjunganpersalinanV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'PSInfokunjunganpersalinanV[tgl_awall]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'PSInfokunjunganpersalinanV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'PSInfokunjunganpersalinanV[tgl_akhirl]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'PSInfokunjunganpersalinanV[no_pendaftaran]' => substr($model->no_pendaftaran, 2),
            'PSInfokunjunganpersalinanV[nama_pasien]' => $model->pasien->nama_pasien,
            'PSInfokunjunganpersalinanV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
            'PSInfokunjunganpersalinanV[ceklis]' => 0
          ));
        } else {
          $judul .= " Rawat Darurat";
          $link_rd = $this->createUrl('/rawatDarurat/DaftarPasien/Index', array(
            'RDInfoKunjunganRDV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RDInfoKunjunganRDV[tgl_awall]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RDInfoKunjunganRDV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RDInfoKunjunganRDV[tgl_akhirl]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
            'RDInfoKunjunganRDV[no_pendaftaran]' => substr($model->no_pendaftaran, 2),
            'RDInfoKunjunganRDV[nama_pasien]' => $model->pasien->nama_pasien,
            'RDInfoKunjunganRDV[no_rekam_medik]' => $model->pasien->no_rekam_medik,
            'RDInfoKunjunganRDV[ceklis]' => 0
          ));
        }

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id, 'link_proses' => $link_rd),
          // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
          // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
          array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' =>  Params::MODUL_ID_REKAMMEDIS, 'link_proses' => $link), //, 'link_proses' => $link
        ));

        $smspasien = 1;
        $smsdokter = 1;
        $smspenanggungjawab = 1;
        //var_dump($this->pasientersimpan);
        //var_dump($this->pendaftarantersimpan);
        //var_dump($this->penanggungjawabtersimpan);
        //var_dump($this->rujukantersimpan);
        //var_dump($this->karcistersimpan);
        //var_dump($this->komponentindakantersimpan);die;



        if ($ok_vaksinasi && $this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan) {
          if ($this->is_pasien_baru) {
            $this->cleanUpSessionPasienSudahBaca($model->pendaftaran_id);
          }
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
          }

          if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] == 1) {
            $this->kirimWhatsApp($model, $modPasien);
          }

          // END SMS GATEWAY
          $transaction->commit();
          if ($modPasien->is_random) {
            $modPasien->generateNoRMDanSimpan();
          }
          $model->generateNoPendaftaranDanSimpan();
          
          if(isset($_GET['notriage_pasien_id'])) {
            // update triage
            NotriagePasienT::model()->updateByPk($_GET['notriage_pasien_id'], ['pendaftaran_id' => $model->pendaftaran_id]);
            // prosees update untuk merelate kan saat pemeriksaan daftar pasien

            $wpss = AsesmentriagewpssT::model()->findByAttributes([
                'notriage_pasien_id' => $_GET['notriage_pasien_id']
            ]);

            $anamnesa = AnamnesaT::model()->findByAttributes([
                'notriage_pasien_id' => $_GET['notriage_pasien_id']
            ]);

            $pemeriksaanfisik = PemeriksaanfisikT::model()->findByAttributes([
                'notriage_pasien_id' => $_GET['notriage_pasien_id']
            ]);

            if (!empty($wpss)) {
                $wpss->pendaftaran_id = $model->pendaftaran_id;
                $wpss->pasien_id = $model->pasien_id;
                $ok &= $wpss->update();
            }

            if (!empty($anamnesa)) {
                $anamnesa->pendaftaran_id = $model->pendaftaran_id;
                $anamnesa->pasien_id = $model->pasien_id;
                $anamnesa->update_time = date('Y-m-d H:i:s');
                $anamnesa->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                $ok &= $anamnesa->update();
            }

            if (!empty($pemeriksaanfisik)) {
                $pemeriksaanfisik->pendaftaran_id = $model->pendaftaran_id;
                $pemeriksaanfisik->pasien_id = $model->pasien_id;
                $pemeriksaanfisik->update_time = date('Y-m-d H:i:s');
                $pemeriksaanfisik->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                $ok &= $pemeriksaanfisik->update();
            }

          }

          if(isset($_GET['is_triage'])) {
            $is_triage = 1;
          } else {
            $is_triage = 0;
          }

          Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
          
          //RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
          if ($this->septersimpan) {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab, 'is_triage' => $is_triage));
          } else {
            $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab, 'is_triage' => $is_triage));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
          //						echo "-".$this->pasientersimpan."<br>";
          //                        echo "-".$this->pendaftarantersimpan."<br>";
          //                        echo "-".$this->penanggungjawabtersimpan."<br>";
          //                        echo "-".$this->rujukantersimpan."<br>";
          //                        echo "-".$this->karcistersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        exit;
        }
      } catch (Exception $exc) {
        echo "<pre>";
        var_dump($exc->getMessage());
        die;
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $exc->getMessage());
      }
    }

    $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat.index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modRujukan' => $modRujukan,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modKecelakaan' => $modKecelakaan,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
      'modAntrian' => $modAntrian,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
      'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
      'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
      'modSep' => $modSep,
      'modSmsgateway' => $modSmsgateway,
      'modKarcisV' => $modKarcisV,
      'modPasienTerakhir' => $modPasienTerakhir,
      'modPegawaiPJ' => $modPegawaiPJ,
      'modRujukanInhealth' => $modRujukanInhealth,
      'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
      'modSepInhealthT' => $modSepInhealthT,
    ));
  }

  public function actionAutocompleteItemSEP()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $term = $_GET['term'];
      $item = $_GET['item'];
      $bpjs = new BpjsVklaim();

      /* Load data diagnosa*/
      if ($item == "diagnosa") {
        $response = json_decode($bpjs->search_diagnosa($term, '', ''), true);
        if (!empty($response['response'])) {
          foreach ($response['response']['diagnosa'] as $i => $value) {
            $returnVal[$i]['label'] = $value['nama'];
            $returnVal[$i]['kode'] = $value['kode'];
            $returnVal[$i]['nama'] = $value['nama'];
          }
        }
      }
      /* Load data poli / sub spesialis */
      if ($item == "poli") {
        $response = json_decode($bpjs->search_poli($term), true);
        if (!empty($response['response'])) {
          foreach ($response['response']['poli'] as $i => $value) {
            $returnVal[$i]['label'] = $value['kode'] . " - " . $value['nama'];
            $returnVal[$i]['kode'] = $value['kode'];
            $returnVal[$i]['nama'] = $value['nama'];
          }
        }
      }
      /* Load data ppk / faskes bpjs */
      if ($item == "ppk") {
        $response = json_decode($bpjs->fasilitas_kesehatan($term . '/1', '', ''), true);
        /* Pertama load dengan jenis non reumah sakit */
        if (!empty($response['response'])) {
          foreach ($response['response']['faskes'] as $i => $value) {
            $returnVal[$i]['label'] = $value['nama'];
            $returnVal[$i]['kode'] = $value['kode'];
            $returnVal[$i]['nama'] = $value['nama'];
          }
        } else {
          /* Pertama load dengan jenis reumah sakit */
          $response = json_decode($bpjs->fasilitas_kesehatan($term . '/2', '', ''), true);
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

  public function kirimWhatsApp($model, $modPasien)
  {

    $str = "Selamat Datang di ((nama_rs))\n\n";
    $str .= $modPasien->namadepan . $modPasien->nama_pasien . " dengan No RM " . $modPasien->no_rekam_medik . " ";
    $str .= "terdaftar sebagai pasien pada tanggal " . MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran);
    $str .= " dan akan melakukan pemeriksaan di ";
    $str .= $model->ruangan->ruangan_nama . ".\n\n";

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
        $modPegawai = new PPPegawaiM;
        $modPenanggungJawab = null;
        $modRujukan = null;
        $modTindakan = null;
        $modKecelakaan = null;

        $model->attributes = $_POST['PPPendaftaranT'];
        $model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
        $modPasien->attributes = $_POST['PPPasienM'];
        $modPasien->kepercayaan = $_POST['PPPendaftaranT']['kepercayaan'];

        if (!empty($modPasien->pegawai_id)) {
          $modPegawai->attributes = $modPasien->pegawai->attributes;
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
                  $modTindakan[$i]->karcis_id = $karcis['karcis_id'];
                }
              }
            }
          }
        }
        if ($_POST['PPPendaftaranT']['is_pasienkecelakaan']) {
          if (isset($_POST['PPPasienkecelakaanT'])) {
            $modKecelakaan = new PPPasienkecelakaanT;
            $modKecelakaan->attributes = $_POST['PPPasienkecelakaanT'];
          }
        }
      }


      if ($_POST['PPPendaftaranT']['ruangan_id'] != Params::RUANGAN_ID_VERLOS_KAMER) {
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
            // $ok = 0;
            // $msg = "Maaf, Karcis tidak ditemukan";
          }
        } else {
          // $ok = 0;
          // $msg = "Maaf, Karcis tidak ditemukan";
        }
      }

      echo CJSON::encode(array(
        'ok' => $ok,
        'msg' => $msg,
        'content' => $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat.verifikasi', array(
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
   * proses simpan data kecelakaan
   * @param type $modKecelakaan
   * @param type $post
   * @return type
   */
  public function simpanKecelakaan($modKecelakaan, $model, $post)
  {
    $format = new MyFormatter();
    $modKecelakaan->attributes = $post;
    $modKecelakaan->pendaftaran_id = $model->pendaftaran_id;
    $modKecelakaan->tglkecelakaan = $format->formatDateTimeForDb($modKecelakaan->tglkecelakaan);

    if ($modKecelakaan->save()) {
      $this->kecelakaantersimpan = true;
    }
    return $modKecelakaan;
  }


  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintStatusRD($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $instalasi = InstalasiM::model()->findByPk($modPendaftaran->instalasi_id);
    $modPasien =  PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $karcis_id = null;
    $modTindakan =  TindakanpelayananT::model()->findByAttributes(array('pasien_id' => $modPasien->pasien_id, 'pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $judul_print = 'Kunjungan ' . $instalasi->instalasi_nama;
    $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatDarurat.printStatusRD', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakan' => $modTindakan,
    ));
  }

  public function actionAutocompleteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : '';
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->addCondition('ruangan_id=' . $ruangan_id);

      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PPDokterV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->NamaLengkap;
        $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionSetFormSuplesi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $suplesiList = $_POST['suplesiList'];
      $form = '';
      $pesan = '';
      if (count((array)$suplesiList) > 0) {
        foreach ($suplesiList as $i => $suplesi) {
          $no_register = $suplesi['noRegister'];
          $noSep = $suplesi['noSep'];
          $noSepAwal = $suplesi['noSepAwal'];
          $noSuratJaminan = $suplesi['noSuratJaminan'];
          $tglKejadian = $suplesi['tglKejadian'];
          $tglSep = $suplesi['tglSep'];
          $form .=
            "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#ARSepT_no_suplesi').val('" . $noSep . "');$('#dialogSuplesi').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli'>" . $no_register . "</span>
                        </td>
                        <td>
                            <span id='nmPoli'>" . $noSep . "</span>
                        </td>
                        <td>
                            <span id='nmPoli'>" . $noSepAwal . "</span>
                        </td>
                        <td>
                            <span id='nmPoli'>" . $noSuratJaminan . "</span>
                        </td>
                        <td>
                            <span id='nmPoli'>" . $tglKejadian . "</span>
                        </td>
                        <td>
                            <span id='nmPoli'>" . $tglSep . "</span>
                        </td>
                    </tr>";
        }
      } else {
        $pesan = "Data tidak ada!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionSetDropdownPropinsi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $propinsiList = $_POST['propinsiList'];
      $form = '<option value="">-- Pilih Propinsi --</option>';
      $pesan = '';
      if (count((array)$propinsiList) > 0) {
        foreach ($propinsiList as $i => $propinsi) {
          $kode = $propinsi['kode'];
          $nama = $propinsi['nama'];
          $form .=
            "
                        <option value='" . $kode . "'>" . $nama . "</option>
                    ";
        }
      } else {
        $pesan = "Data tidak ada!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * Load data kabupaten
   */
  public function actionSetDropdownKabupatenNew()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $propinsiList = $_POST['propinsiList'];
      $form = '<option value="">-- Pilih Kabupaten --</option>';
      $pesan = '';
      if (count((array)$propinsiList) > 0) {
        foreach ($propinsiList as $i => $propinsi) {
          $kode = $propinsi['kode'];
          $nama = $propinsi['nama'];
          $form .=
            "
                        <option value='" . $kode . "'>" . $nama . "</option>
                    ";
        }
      } else {
        $pesan = "Data tidak ada!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * Set dropdown kecamatan 
   */
  public function actionSetDropdownKecamatanNew()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $kabupatenList = $_POST['kabupatenList'];
      $form = '<option value="">-- Pilih Kecamatan --</option>';
      $pesan = '';
      if (count((array)$kabupatenList) > 0) {
        foreach ($kabupatenList as $i => $kabupaten) {
          $kode = $kabupaten['kode'];
          $nama = $kabupaten['nama'];
          $form .=
            "
                        <option value='" . $kode . "'>" . $nama . "</option>
                    ";
        }
      } else {
        $pesan = "Data tidak ada!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  
}

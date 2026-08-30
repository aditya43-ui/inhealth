<?php

/**
 * Proses Pendaftaran Pasien Rawat Jalan. 
 * Class ini juga digunakan/extend oleh Pendaftaran Lain
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.pendaftaranPenjadwalan
 * @subpackage controllers
 */
class PendaftaranRawatJalan2Controller extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "pendaftaranPenjadwalan.views.pendaftaranRawatJalan2.";
  public $pasientersimpan = false;
  public $pendaftarantersimpan = false;
  public $penanggungjawabtersimpan = false;
  public $karcistersimpan = false;
  public $komponentindakantersimpan = false;
  public $rujukantersimpan = false;
  public $asuransipasientersimpan = false;
  public $septersimpan = false;
  public $is_rm_manual = false;

  /**
   * menampilkan detail pendaftaran
   * @param type $id
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $modPasien = PPPasienM::model()->findByPk($model->pasien_id);
    $modPegawai = new PPPegawaiM;
    if (!empty($modPasien->pegawai_id)) {
      $modPegawai = PPPegawaiM::model()->findByPk($modPasien->pegawai_id);
    }
    $modPenanggungJawab = null;
    $modRujukan = null;

    if (!empty($model->penanggungjawab_id)) {
      $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
    }
    if (!empty($model->rujukan_id)) {
      $modRujukan = PPRujukanT::model()->findByPk($model->rujukan_id);
    }
    $modTindakan = PPTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
    $this->render('view', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modRujukan' => $modRujukan,
      'modTindakan' => $modTindakan,
    ));
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

        $model->attributes = $_POST['PPPendaftaranT'];
        $model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
        $modPasien->attributes = $_POST['PPPasienM'];
        $modPasien->nama_bin = $_POST['PPPasienM']['nama_bin'];
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
      }

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

      echo CJSON::encode(array(
        'ok' => $ok,
        'msg' => $msg,
        'content' => $this->renderPartial('verifikasi', array(
          'model' => $model,
          'modPasien' => $modPasien,
          'modPegawai' => $modPegawai,
          'modPenanggungJawab' => $modPenanggungJawab,
          'modRujukan' => $modRujukan,
          'modTindakan' => $modTindakan,
          'format' => $format,
        ), true)
      ));
      Yii::app()->end();
    }
  }

  /**
   * Load data rujukandari_m
   * @param boolean $encode
   * @param string $namaModel
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
   * Load data ppk dari master rujukandari_m
   */
  public function actionGetPPKRujukan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_POST['rujukan_id'])) {
        $rujukan = RujukandariM::model()->findByPk($_POST['rujukan_id']);
        echo $rujukan->kodeppk;
      } else {
        echo "";
      }
    }
  }

  /**
   * Index transaksi pendaftaran
   * @param integer $id
   * @param integer $idSep
   * @param integer $idAntrian
   * @param integer $sk_id
   */
  public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
  {
    $format = new MyFormatter();
    $model = new PPPendaftaranT;
    $modPasien = new PPPasienM;
    $modPegawai = new PPPegawaiM;
    $modPenanggungJawab = new PPPenanggungJawabM;
    $modRujukan = new PPRujukanT;
    $modRujukanBpjs = new PPRujukanbpjsT;
    $modRujukanInhealth = new PPRujukanInhealthT;
    $modTindakan = new PPTindakanPelayananT;
    $modPembayaran = new PPPembayaranpelayananT();
    $modAntrian = new PPAntrianT;
    $modAsuransiPasien = new PPAsuransipasienM;
    $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
    $modAsuransiPasienInhealth = new PPAsuransipasieninhealthM;
    $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
    $modAsuransiPasienDepartemen = new PPAsuransipasiendepartemenM();
    $modAsuransiPasienPekerja = new PPAsuransipasienpegawaiM();

    $modSep = new PPSepT;
    $modSepInhealthT = new PPSepInhealthT;
    $modSep->tglsep = date('Y-m-d H:i:s');
    $modSepInhealthT->tglsep = date('Y-m-d H:i:s');
    $modSep->jnspelayanan = 2; //defaul rajal
    $modSepInhealthT->jnspelayanan = 3; //defaul RJTL
    $modSep->poli_eksekutif = 0;
    $modSep->cob = 0;
    $modSep->lakalantas = 0;
    $modSep->jenisfaskes = 2; //default RS
    $modSep->katarak = 0;
    $modSep->suplesi_jasaraharja = 0;
    $modSep->status_nosep = "TIDAK";
    $modProfilRS = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    $modSep->ppkpelayanan = $modProfilRS->ppkpelayanan;
    $modSep->pelayanan = 'RJ';
    $modRujukanBpjs->tanggal_rujukan = date('Y-m-d H:i:s');
    $modRujukanInhealth->tanggal_rujukan = date('Y-m-d H:i:s');

    $dataTindakans = array();
    $modKarcisV = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->agama = Params::DEFAULT_AGAMA;
    $model->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $model->is_bpjs = 0;
    $model->is_asubadak = 0;
    $model->is_asudepartemen = 0;
    $model->is_asupekerja = 0;
    $model->jenis_rujukan = 2; //default RS
    $model->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_UMUM; //kasus penyakit default "UMUM"
    $model->pegawai_id = Params::PEGAWAI_DPJP_ID_STRIP; //dpjp default "-"

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

    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_KELAS_III;

    if (isset($_POST['buatjanjipoli_id'])) { //dari informasi janji poli
      if (!empty($_POST['buatjanjipoli_id'])) {
        $modJanjipoli = PPBuatJanjiPoliT::model()->findByPk($_POST['buatjanjipoli_id']);
        if (!empty($modJanjipoli->pasien_id)) {
          $modPasien = PPPasienM::model()->findByPk($modJanjipoli->pasien_id);
          $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
          if ($modPasien->ispasienluar == TRUE) {
            $modPasien->no_rekam_medik = null;
            $modPasien->pasien_id = null;
          }
        }
        $model->no_urutantri = $modJanjipoli->no_antrianjanji;
        $model->buatjanjipoli_id = $_POST['buatjanjipoli_id'];
        if (!empty($modJanjipoli->ruangan_id))
          $model->ruangan_id = $modJanjipoli->ruangan_id;
        if (!empty($modJanjipoli->pegawai_id))
          $model->pegawai_id = $modJanjipoli->pegawai_id;
      }
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
      $modPasien = PPPasienM::model()->findByPk($model->pasien_id);

      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = PPPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = PPRujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataTindakans = PPTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
    }

    $pasien_id = (isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null);
    if (!empty($pasien_id)) {
      $modPasien = PPPasienM::model()->findByPk($pasien_id);
      $modPasien->tanggal_lahir = date('d/m/Y', strtotime($modPasien->tanggal_lahir));
    }
    if (!empty($modPasien->pegawai_id)) {
      $modPegawai->attributes = $modPasien->pegawai->attributes;
    }

    $ruangan = null;
    if (!empty($sk_id)) {
      $sk = SuratketeranganR::model()->findByPk($sk_id);
      $p = PendaftaranT::model()->findByPk($sk->pendaftaran_id);
      $ruangan = $p->ruangankontrol_id;

      if ($p->carabayar_id == Params::CARABAYAR_ID_BPJS) {
        $asuransi = PPAsuransipasienbpjsM::model()->findByPk($p->asuransipasien_id);
        if (empty($asuransi))
          $asuransi = PPAsuransipasienbpjsM::model()->findByAttributes(array(
            'pasien_id' => $p->pasien_id,
            'carabayar_id' => $p->carabayar_id,
          ));
        if (!empty($asuransi)) {
          $rujuk = RujukandariM::model()->findByPk(Params::RUJUKANDARI_ID_ABE);
          $modAsuransiPasienBpjs->nopeserta = $asuransi->nopeserta;
          $modRujukanBpjs->asalrujukan_id = Params::ASALRUJUKAN_ID_RS;

          if (!empty($rujuk)) {
            $modRujukanBpjs->rujukandari_id = $rujuk->rujukandari_id;
            $modRujukanBpjs->nama_perujuk = $rujuk->namaperujuk;
            $modRujukanBpjs->tanggal_rujukan = date('Y-m-d H:i:s');
            $modRujukanBpjs->no_rujukan = date('dmYHi', strtotime($p->tglrenkontrol) + (3600 * 24 * 3));
            $modSep->ppkrujukan = $rujuk->ppkrujukan;
          }
        }
      }
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
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienbpjsM'])) {
          if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
              $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
        } else {
          $this->asuransipasientersimpan = true;
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
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanBpjs, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasienBpjs);
          if (isset($_POST['PPSepT'])) {
            $modSep = $this->simpanSep($model, $modPasien, $modRujukanInhealth, $modAsuransiPasienBpjs, $_POST['PPSepT']);
            $model->sep_id = $modSep->sep_id;
            $model->update();
          }
        } else {
          if (isset($_POST['PPSepInhealthT'])) { //simpan pendaftaran ketika brigin dengan inhealth
            $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanInhealth, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasienInhealth);
          } else {
            $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasien);
          }
        }

        /* Untuk penjamin inhealth */
        if (isset($_POST['PPSepInhealthT'])) {
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanInhealth, $modAsuransiPasienInhealth, $_POST['PPSepInhealthT']);
          $model->sep_id = $modSep->sep_id;
          PPSepInhealthT::model()->updateByPk($modSep->sep_id, array('is_inhealth' => true));
          $model->update();
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

        if (!empty($_POST['PPPendaftaranT']['buatjanjipoli_id'])) {
          $modJanjipoli = PPBuatJanjiPoliT::model()->findByPk($_POST['PPPendaftaranT']['buatjanjipoli_id']);
          $modJanjipoli->pendaftaran_id = $model->pendaftaran_id;
          $modJanjipoli->save();
        }

        if (!empty($sk_id)) { // untuk rencana kontrol pendaftaran
          $renKontrol = new PPBuatJanjiPoliT;
          $renKontrol->pegawai_id = $model->pegawai_id;
          $renKontrol->ruangan_id = $model->ruangan_id;
          $renKontrol->pasien_id = $model->pasien_id;
          $renKontrol->tglbuatjanji = $sk->create_time;
          $renKontrol->harijadwal = MyFormatter::getDayUser(date('w'));
          $renKontrol->tgljadwal = $p->tglrenkontrol;
          $renKontrol->keteranganbuatjanji = Params::KETERANGAN_BUAT_JANJI_RENKONTROL;
          $renKontrol->create_time = date('Y-m-d H:i:s');
          $renKontrol->create_loginpemakai_id = Yii::app()->user->id;
          $renKontrol->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $renKontrol->no_antrianjanji = MyGenerator::noAntrianJanjiPoli($model->ruangan_id);
          $renKontrol->no_buatjanji = MyGenerator::noJanjiPoli("JP");
          $renKontrol->pendaftaran_id = $model->pendaftaran_id;
          $renKontrol->suratketerangan_id = $sk_id;

          $renKontrol->save();
        }

        $judul = 'Pendaftaran Pasien';

        if ($model->statuspasien == 'PENGUNJUNG LAMA') {
          $judul .= " Lama";
        } else
          $judul .= " Baru";

        $judul .= " Rawat Jalan";

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

        $link_rj = $this->createUrl('/rawatJalan/DaftarPasien/Index', array(
          'RJInfokunjunganrjV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
          'RJInfokunjunganrjV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
          'RJInfokunjunganrjV[no_pendaftaran]' => substr($model->no_pendaftaran, 2),
          'RJInfokunjunganrjV[nama_pasien]' => $model->pasien->nama_pasien,
          'RJInfokunjunganrjV[no_rekam_medik]' => $model->pasien->no_rekam_medik
        ));


        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => Params::INSTALASI_ID_RJ, 'ruangan_id' => $model->ruangan_id, 'modul_id' => 5, 'link_proses' => $link_rj), //, 'link_proses'=>$link_rj
          //array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => 10),
          //array('instalasi_id' => Params::INSTALASI_ID_KASIR, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => 19),
          array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' => Params::MODUL_ID_REKAMMEDIS, 'link_proses' => $link), //, 'link_proses' => $link
        ));


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
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tgl_pendaftaran), $isiPesan);
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

        // END SMS GATEWAY

        if ($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->asuransipasientersimpan) {
          $transaction->commit();
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
      'modTindakan' => $modTindakan,
      'modAntrian' => $modAntrian,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
      'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
      'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
      'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
      'dataTindakans' => $dataTindakans,
      'modSep' => $modSep,
      'modSepInhealthT' => $modSepInhealthT,
      'modSmsgateway' => $modSmsgateway,
      'modKarcisV' => $modKarcisV,
      'ruangan' => $ruangan,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = PPPendaftaranT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'pppendaftaran-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * proses simpan / ubah data pasien
   * @param array $modPasien
   * @param array $post
   * @return \PPPasienM
   */
  public function simpanPasien($modPasien, $post)
  {
    $format = new MyFormatter();
    $snrm = "";
    if (isset($post['pasien_id']) && (!empty($post['pasien_id']))) {
      $load = new $modPasien;
      $modPasien = $load->findByPk($post['pasien_id']);
      $snrm = $modPasien->no_rekam_medik;
    } else {
      $modPasien = new PPPasienM;
    }

    $modPasien->attributes = $post;

    unset($modPasien->fingerprint_data);
    $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);

    if (empty($modPasien->pasien_id)) {
      $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
      $modPasien->profilrs_id = Params::getDefaultProfilRS();
      $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
      $modPasien->ispasienluar = FALSE;
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPasien->create_loginpemakai_id = Yii::app()->user->id;
      $modPasien->create_time = date('Y-m-d H:i:s');
      if (empty($modPasien->no_rekam_medik) || trim($modPasien->no_rekam_medik) == "") {
        $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
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
    }

    return $modPasien;
  }

  /**
   * proses simpan / ubah data pendaftaran
   * @param array $model
   * @param array $modPasien
   * @param array $modRujukan
   * @param array $modPenanggungJawab
   * @param array $post
   * @param array $postPasien
   * @param v $modAsuransiPasien
   * @return \PPPendaftaranT
   */
  public function simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $post, $postPasien, $modAsuransiPasien)
  {
    $format = new MyFormatter();
    $modP = PendaftaranT::model()->findByAttributes(array(
      'pasien_id' => $modPasien->pasien_id,
    ), array(
      'condition' => 'pasienbatalperiksa_id is null',
    ));
    $model->attributes = $post;
    $model->pasien_id = $modPasien->pasien_id;
    $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
    $model->rujukan_id = $modRujukan->rujukan_id;
    $model->instalasi_id = (isset($model->ruangan_id) ? $model->ruangan->instalasi_id : null);
    $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
    $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
    $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
    $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;

    // $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);

    if (empty($postPasien['pasien_id']) || empty($modP)) {
      $model->statuspasien = Params::STATUSPASIEN_BARU;
      $model->kunjungan = Params::STATUSKUNJUNGAN_BARU;
    } else if ($this->is_rm_manual) {
      $model->statuspasien = Params::STATUSPASIEN_LAMA;
      $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
    } else {
      $model->statuspasien = Params::STATUSPASIEN_LAMA;
      $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
    }
    /*
          $model->statuspasien = (empty($postPasien['pasien_id'] || empty($modP)) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
          $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);

          if ($this->is_rm_manual) {
          $model->statuspasien = Params::STATUSPASIEN_LAMA;
          $model->kunjungan = Params::STATUSKUNJUNGAN_LAMA;
          } */

    if (($model->ruangan->instalasi_id == PARAMS::INSTALASI_ID_HD) || ($model->ruangan->instalasi_id == PARAMS::INSTALASI_ID_HD_GA)) { //untuk pasien HD
      $model->kamarruangan_id = $post['kamarruangan_id'];
    } else {
      $model->kamarruangan_id = null;
    }

    $model->shift_id = Yii::app()->user->getState('shift_id');
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_time = date("Y-m-d H:i:s");
    if (Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)) {
      $model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
    } else {
      $model->tgl_pendaftaran = date("Y-m-d H:i:s");
    }
    $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
    $model->kelompokumur_id = (!empty($modPasien->kelompokumur_id) ? $modPasien->kelompokumur_id : CustomFunction::getKelompokUmur($modPasien->tanggal_lahir));
    $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
    $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
    $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
    $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
    $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
    $model->keterangan_pendaftaran = $post['keterangan_pendaftaran'];
    $model->no_rujukan = isset($post['no_rujukan']) ? $post['no_rujukan'] : '';
    $model->jenis_rujukan = isset($post['jenis_rujukan']) ? $post['jenis_rujukan'] : '';

    $modRuangan = PPRuanganM::model()->findByPk($model->ruangan_id);
    $estimasipelayanan = isset($modRuangan->estimasipelayanan) ? $modRuangan->estimasipelayanan : 15;

    $tgl_awal = date('Y-m-d');
    $tgl_akhir = date('Y-m-d');
    $criteria = new CDbCriteria();
    $criteria->addCondition('ruangan_id = ' . $model->ruangan_id);
    $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_awal, $tgl_akhir);
    $criteria->order = 'tgl_pendaftaran DESC';
    $dataPendaftaran = PPPendaftaranT::model()->find($criteria);

    if (!empty($dataPendaftaran) && $dataPendaftaran->tglakandilayani != null) {
      $tanggal = strtotime($dataPendaftaran->tglakandilayani . ' + ' . $estimasipelayanan . ' minute');
      $tglakandilayani = date('Y-m-d H:i:s', $tanggal);

      if ($tglakandilayani < $model->tgl_pendaftaran) {
        $tglakandilayani = strtotime($tglakandilayani . ' + ' . $estimasipelayanan . ' minute');
        $tglakandilayani = date('Y-m-d H:i:s', $tglakandilayani);
        $model->tglakandilayani = $tglakandilayani;
      } else {
        $tglakandilayani = strtotime($model->tgl_pendaftaran . ' + ' . $estimasipelayanan . ' minute');
        $tglakandilayani = date('Y-m-d H:i:s', $tglakandilayani);
        $model->tglakandilayani = $tglakandilayani;
      }
    } else {
      $tanggal = strtotime($model->tgl_pendaftaran . ' + ' . $estimasipelayanan . ' minute');
      $tglakandilayani = date('Y-m-d H:i:s', $tanggal);
      $model->tglakandilayani = $tglakandilayani;
    }

    if ($model->save()) {
      if (!empty($model->antrian_id)) {

        /* Start-RSST-960 */
        $modelAntrian = AntrianT::model()->findByPk($model->antrian_id);
        $jamselesai = date('Y-m-d H:i:s');
        $to_time = strtotime($jamselesai);
        $from_time = strtotime($modelAntrian->jampanggil);
        $difHour = round(abs($to_time - $from_time) / 60); //ambil konversi ke menit
        /* End */

        PPAntrianT::model()->updateByPk($model->antrian_id, array(
          'pendaftaran_id' => $model->pendaftaran_id,
          'jamselesai' => $jamselesai,
          'lamadilayani_mnt' => round($difHour),
          'isdatang' => true,
        ));
      }
      $this->pendaftarantersimpan = true;
    } else {
      $this->pendaftarantersimpan = false;
    }
    return $model;
  }

  /**
   * proses simpan data penanggungjawab pasien
   * @param array $modPenanggungjawab
   * @param array $post
   * @return array
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
   * @param array $modRujukan
   * @param array $post
   * @return array
   */
  public function simpanRujukan($modRujukan, $post)
  {
    $format = new MyFormatter();
    $modRujukan->attributes = $post;
    /* Validasi untuk input diagnosa multiple dan single */
    if (isset($post['kddiagnosa_rujukan'])) {
      if (is_array($post['kddiagnosa_rujukan']) && count((array)$post['kddiagnosa_rujukan']) > 0) {
        $modRujukan->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan']) > 0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
      } else {
        $modRujukan->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? $post['kddiagnosa_rujukan'] : '';
      }
    }
    if (isset($post['diagnosa_rujukan'])) {
      if (is_array($post['diagnosa_rujukan']) && count((array)$post['diagnosa_rujukan']) > 0) {
        $modRujukan->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan']) > 0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
      } else {
        $modRujukan->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? $post['diagnosa_rujukan'] : '';
      }
    }
    /* $modRujukan->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan'])>0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
          $modRujukan->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan'])>0) ? implode(', ', $post['diagnosa_rujukan']) : '') : ''; */
    $modRujukan->tanggal_rujukan = !empty($modRujukan->tanggal_rujukan) ? $format->formatDateTimeForDb($modRujukan->tanggal_rujukan) : date('Y-m-d');

    if ($modRujukan->save()) {
      $this->rujukantersimpan = true;
    }
    return $modRujukan;
  }

  /**
   * proses simpan data rujukan
   * @param array $modRujukan
   * @param array $post
   * @return array
   */
  public function simpanRujukanBpjs($modRujukanBpjs, $post)
  {
    $format = new MyFormatter();
    $modRujukanBpjs->attributes = $post;
    /* Validasi untuk input diagnosa multiple dan single */
    if (isset($post['kddiagnosa_rujukan'])) {
      if (is_array($post['kddiagnosa_rujukan']) && count((array)$post['kddiagnosa_rujukan']) > 0) {
        $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan']) > 0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
      } else {
        $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? $post['kddiagnosa_rujukan'] : '';
      }
    }
    if (isset($post['diagnosa_rujukan'])) {
      if (is_array($post['diagnosa_rujukan']) && count((array)$post['diagnosa_rujukan']) > 0) {
        $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan']) > 0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
      } else {
        $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? $post['diagnosa_rujukan'] : '';
      }
    }
    /* $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan'])>0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
          $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan'])>0) ? implode(', ', $post['diagnosa_rujukan']) : '') : ''; */
    $modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);
    if (empty($modRujukanBpjs->no_rujukan)) {
      $modRujukanBpjs->no_rujukan = "-";
    }

    if ($modRujukanBpjs->save()) {
      $this->rujukantersimpan = true;
    }
    return $modRujukanBpjs;
  }

  /**
   * proses simpan karcis
   * @param array $modTindakan
   * @param array $post
   * @return array
   */
  public function simpanKarcis($modTindakan, $model, $post)
  {
    $modTindakan->attributes = $post;
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    //$modTindakan->instalasi_id=Yii::app()->user->getState("instalasi_id");
    $modTindakan->instalasi_id = $model->instalasi_id;
    //$modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTindakan->ruangan_id = $model->ruangan_id;
    $modTindakan->pendaftaran_id = $model->pendaftaran_id;
    $modTindakan->kelaspelayanan_id = $model->kelaspelayanan_id;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->carabayar_id = $model->carabayar_id;
    $modTindakan->penjamin_id = $model->penjamin_id;
    $modTindakan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
    $modTindakan->pasien_id = $model->pasien_id;
    $modTindakan->dokterpemeriksa1_id = $model->pegawai_id;
    $modTindakan->karcis_id = $post['karcis_id'];
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakan->qty_tindakan = 1;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan();
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
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

    if ($modTindakan->save()) {
      $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      $this->karcistersimpan = true;
    } else {
      $this->karcistersimpan = false;
    }

    return $modTindakan;
  }

  /**
   * simpan asuransi pasien
   * @param array $modAsuransiPasien
   * @param array $postPendaftaran
   * @param array $postPasien
   * @param array $postAsuransiPasien
   * @return array
   */
  public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien, $postAdmisi = null)
  {

    $format = new MyFormatter();

    $carabayar = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
    if (empty($carabayar))
      $carabayar = isset($postAdmisi['carabayar_id']) ? $postAdmisi['carabayar_id'] : null;

    $penjamin = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
    if (empty($penjamin))
      $penjamin = isset($postAdmisi['penjamin_id']) ? $postAdmisi['penjamin_id'] : null;

    $modAsuransiPasien->attributes = $postAsuransiPasien;
    $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
    $modAsuransiPasien->penjamin_id = $penjamin;
    $modAsuransiPasien->carabayar_id = $carabayar;
    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
    $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
    $modAsuransiPasien->hubkeluarga = isset($postAsuransiPasien['hubkeluarga']) ? $postAsuransiPasien['hubkeluarga'] : '';
    $modAsuransiPasien->nominal_tanggungan = isset($postAsuransiPasien['nominal_tanggungan']) ? $postAsuransiPasien['nominal_tanggungan'] : 0;
    if ($carabayar == Params::CARABAYAR_ID_JAMKESPA) {
      $modAsuransiPasien->nopeserta = $postPasien->no_rekam_medik;
      // $modAsuransiPasien->status_konfirmasi = 1;
    } else if ($carabayar == Params::CARABAYAR_ID_BPJS) {
      $kelas = KelaspelayananM::model()->findByAttributes(array('kelasbpjs_id' => $modAsuransiPasien->kelastanggunganasuransi_id));
      if (!empty($kelas)) {
        $modAsuransiPasien->kelastanggunganasuransi_id = $kelas->kelaspelayanan_id;
      }
      $modAsuransiPasien->status_konfirmasi = 1;
      $modAsuransiPasien->tgl_konfirmasi = date('Y-m-d H:i:s');
      $modAsuransiPasien->namaperusahaan = 'BPJS';
      //var_dump($modAsuransiPasien->kelastanggunganasuransi_id);die;
    }
    if (empty($postAsuransiPasien['nokartuasuransi'])) {
      $modAsuransiPasien->nokartuasuransi = $modAsuransiPasien->nopeserta;
    }

    if ($modAsuransiPasien->status_konfirmasi == 1) {
      $modAsuransiPasien->status_konfirmasi = "SUDAH DIKONFIRMASI";
    } else if ($modAsuransiPasien->status_konfirmasi == 0) {
      $modAsuransiPasien->status_konfirmasi = "BELUM DIKONFIRMASI";
    }
    $modAsuransiPasien->validate();
    echo CHtml::errorSummary($modAsuransiPasien);
    if ($modAsuransiPasien->validate() && $modAsuransiPasien->save()) {
      $this->asuransipasientersimpan = true;
    }
    return $modAsuransiPasien;
  }

  /**
   * Simpan data SEP Pasien
   * @param array $model
   * @param array $modPasien
   * @param array $modRujukanBpjs
   * @param array $modAsuransiPasienBpjs
   * @param array $postSep
   * @return \PPSepT
   */
  public function simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $postSep, $isRI = false)
  {
    $reqSep = null;
    $modSep = new PPSepT;
    $modSep->attributes = $postSep;

    $bpjs = new BpjsVklaim();
    $kelas = KelaspelayananM::model()->findByPk($modAsuransiPasienBpjs->kelastanggunganasuransi_id);

    $modSep->tglsep = empty($modSep->tglsep) ? date("Y-m-d") : MyFormatter::formatDateTimeForDb($modSep->tglsep);
    $modSep->nokartuasuransi = $modAsuransiPasienBpjs->nopeserta;
    $modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
    if (empty($modSep->tglrujukan)) $modSep->tglrujukan = $modSep->tglsep;
    $modSep->norujukan = $modRujukanBpjs->no_rujukan;
    if (isset($postSep['ppkrujukan'])) $modSep->ppkrujukan = $postSep['ppkrujukan'];
    else $modSep->ppkrujukan = Yii::app()->user->getState('ppkpelayanan');
    $modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
    $modSep->jnspelayanan = ($model->instalasi_id == Params::INSTALASI_ID_RI || $isRI) ? Params::JENISPELAYANAN_RI : Params::JENISPELAYANAN_RJ;
    $modSep->catatansep = $postSep['catatansep'];
    $data_diagnosa = explode(', ', $modRujukanBpjs->kddiagnosa_rujukan);
    $data_diagnosa_nama = explode(', ', $modRujukanBpjs->diagnosa_rujukan);

    $modSep->diagnosaawal = isset($data_diagnosa[0]) ? $data_diagnosa[0] : '';
    $modSep->nama_diagnosaawal = isset($data_diagnosa_nama[0]) ? $data_diagnosa_nama[0] : '';
    $modSep->politujuan = $isRI ? "" : (empty($model->ruangan->kode_bpjs) ? $model->ruangan->ruangan_singkatan : $model->ruangan->kode_bpjs);
    $modSep->klsrawat = $kelas->kelasbpjs_id;
    $modSep->tglpulang = date('Y-m-d H:i:s');
    $modSep->create_time = date('Y-m-d H:i:s');
    $modSep->create_loginpemakai_id = Yii::app()->user->id;
    $modSep->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modSep->jenisrujukan_kode = (isset($postSep['jenisfaskes']) ? $postSep['jenisfaskes'] : 2);
    $modSep->jenisrujukan_nama = ($modSep->jenisrujukan_kode == 1) ? "PCare" : "Rumah Sakit";
    $modSep->no_telpon_peserta = (isset($postSep['no_telpon_peserta']) ? $postSep['no_telpon_peserta'] : null);
    $modSep->no_surat = (isset($postSep['no_surat']) ? $postSep['no_surat'] : null);
    $modSep->kode_dpjp = (isset($postSep['kode_dpjp']) ? $postSep['kode_dpjp'] : null);
    $modSep->nama_dpjp = (isset($postSep['nama_dpjp']) ? $postSep['nama_dpjp'] : null);

    if ($isRI) {
      $modSep->dpjpygmelayani_nama = null;
      $modSep->dpjpygmelayani_kode = null;
    }

    if (isset($postSep['klsRawatNaik'])) {
      $modSep->klsRawatNaik = $postSep['klsRawatNaik'];
    }

    $lakalantas = 0;
    $asalRujukan = $modSep->jenisrujukan_kode;
    $eksekutif = 0;
    $cob = null;
    $penjamin = $model->penjamin_id;
    $lokasiLaka = null;
    $noTelp = $modSep->no_telpon_peserta;
    $user = null;
    $peg_user = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
    if (isset($peg_user)) {
      $user = $peg_user->nama_pegawai;
    }
    $tglKejadian = null;
    $keterangan = $modSep->catatansep;
    $suplesi = 0;
    $noSepSuplesi = null;
    $kdPropinsi = null;
    $kdKabupaten = null;
    $kdKecamatan = null;
    $noSurat = $modSep->no_surat;
    $kodeDPJP = $modSep->kode_dpjp;
    $katarak = 0;

    //            $model->no_telpon_peserta = $postSep['no_telpon_peserta'];

    if (isset($_POST['PPPasienkecelakaanT'])) {
      $lakalantas = 1;
    }

    // var_dump($modSep->attributes, $postSep);

    // var_dump($modSep->attributes); die;
    if (isset($_POST['isSepManual'])) {
      if ($_POST['isSepManual'] == false) {
        $reqSep = json_decode($bpjs->create_sep_new($modSep->nokartuasuransi, $modSep->tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $asalRujukan, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak, $modSep), true);
        //                    $reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id, $lakalantas),true);
        //var_dump($reqSep); die;
        if ($reqSep['metaData']['code'] == 200) {
          $modSep->nosep = $reqSep['response']['sep']['noSep'];
          if (empty($modSep->norujukan)) $modSep->norujukan = "-";
          if (empty($modSep->diagnosaawal)) $modSep->diagnosaawal = "-";
          if ($modSep->save()) {
            $this->septersimpan = true;
            RujukandariM::model()->updateByPk($modRujukanBpjs->rujukandari_id, array(
              'ppkrujukan' => $modSep->ppkrujukan,
            ));
            $this->logBpjs($model, $reqSep);
          }
        } else {
          $this->logBpjs($model, $reqSep);
          // Yii::app()->user->setFlash('error', 'BPJS Error '.$reqSep['metaData']['code'].': '.$reqSep['metaData']['message']);
        }
      } else {
        $modSep->nosep = $_POST['PPSepT']['nosep'];
        if ($modSep->save()) {
          $this->septersimpan = true;
        }
      }
    } else {
      $reqSep = json_decode($bpjs->create_sep_new($modSep->nokartuasuransi, $modSep->tglsep, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->klsrawat, $modPasien->no_rekam_medik, $asalRujukan, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak, $modSep), true);
      // var_dump($reqSep); die;
      if (isset($reqSep['metaData']['code']) && !empty($reqSep['metaData']['code'])) {
        if ($reqSep['metaData']['code'] == 200) {
          // var_dump($reqSep); die;
          $modSep->nosep = $reqSep['response']['sep']['noSep'];
          $modSep->polirujukan = $reqSep['response']['sep']['poli'];
          if (empty($modSep->norujukan)) $modSep->norujukan = "-";
          if (empty($modSep->diagnosaawal)) $modSep->diagnosaawal = "-";

          $modAsuransiPasienBpjs->bpjs_pesertadinsos = $reqSep['response']['sep']['informasi']['dinsos'];
          $modAsuransiPasienBpjs->bpjs_prolanisprb = $reqSep['response']['sep']['informasi']['prolanisPRB'];
          $modAsuransiPasienBpjs->bpjs_nosktm = $reqSep['response']['sep']['informasi']['noSKTM'];
          $modAsuransiPasienBpjs->save();

          if ($modSep->save()) {
            $this->septersimpan = true;
            RujukandariM::model()->updateByPk($modRujukanBpjs->rujukandari_id, array(
              'ppkrujukan' => $modSep->ppkrujukan,
            ));
            $this->logBpjs($model, $reqSep);
          }
        } else {
          $this->logBpjs($model, $reqSep);
          // Yii::app()->user->setFlash('error', 'BPJS Error '.$reqSep['metaData']['code'].': '.$reqSep['metaData']['message']);
        }
      } else {
      }
    }

    $modSep->save();

    return $modSep;
  }

  
  function logBpjs($model, $reqSep) {
    $log = new BpjslogR;
    $log->tgl_log = date('Y-m-d H:i:s');
    $log->code = $reqSep['metaData']['code'];
    $log->loginpemakai_id = Yii::app()->user->id;
    if (isset($reqSep['metaData']['message'])) {
      $log->pesan = $reqSep['metaData']['message'];
    }
    if (!empty($reqSep['request_vars'])) {
      $log->json_request_respose = $reqSep['request_vars'];
    }
    $log->pendaftaran_id = $model->pendaftaran_id;
    $log->save();
  }

  function flashBpjs($id) {
    $log = BpjslogR::model()->findByAttributes(array(
      'pendaftaran_id'=>$id,
    ));
          $template = '<div class="alert alert-block alert-{key}{class}"><a class="close" data-dismiss="alert">&times;</a>{message}</div>';
    if (!empty($log) && $log->code != 200) {
              echo strtr($template, array(
        '{class}'=>'',
        '{key}'=>'error',
        '{message}'=>'BPJS Error '.$log->code.': '.$log->pesan,
      ));
      // Yii::app()->user->setFlash('error', 'BPJS Error '.$log->code.': '.$log->pesan);
    }
  }

  /**
   * menentukan tipepaket_id
   * @param array $modPendaftaran
   * @param array $karcis_id
   * @param array $idTindakan
   * @return array
   */
  public function tipePaketKarcis($modPendaftaran, $karcis_id, $tindakan_id)
  {
    $criteria = new CDbCriteria;
    $criteria->with = array('tipepaket');
    $criteria->addCondition("daftartindakan_id = " . $tindakan_id);
    $criteria->addCondition("tipepaket.carabayar_id = " . $modPendaftaran->carabayar_id);
    $criteria->addCondition("tipepaket.penjamin_id = " . $modPendaftaran->penjamin_id);
    $criteria->addCondition("tipepaket.kelaspelayanan_id = " . $modPendaftaran->kelaspelayanan_id);
    $paket = PaketpelayananM::model()->find($criteria);
    $result = Params::TIPEPAKET_ID_NONPAKET;
    if (isset($paket))
      $result = $paket->tipepaket_id;

    return $result;
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
        $criteria->addCondition('ispasienluar = FALSE');
        $criteria->order = 'no_rekam_medik, nama_pasien';
        $criteria->limit = 50;
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
   * Autocomplete asuransi pasien
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
      $models = PPAsuransipasienM::model()->findAll($criteria);
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
        $returnVal[$i]['nominal_tanggungan'] = $model->nominal_tanggungan;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Autocomplete asuransi pasien
   * @throws CHttpException
   */
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
      $models = PPAsuransipasienM::model()->findAll($criteria);
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
        $returnVal[$i]['nominal_tanggungan'] = $model->nominal_tanggungan;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Autocomplete asuransi pasien
   * @throws CHttpException
   */
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
   * Get data pasien berdasrkan NIK
   */
  public function actionGetDataPasienNIK()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $nik = $_POST['nik'];

      $id = 0;
      $pasien = PasienM::model()->findByAttributes(array(
        'no_identitas_pasien' => $nik,
      ));

      if (!empty($pasien))
        $id = $pasien->pasien_id;

      echo CJSON::encode(array('id' => $id));
    }
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
      if (!empty($pasien_id)) {
        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
          'pasien_id' => $pasien_id,
        ), array(
          'condition' => 'tgl_pendaftaran::date = now()::date and pasienbatalperiksa_id is null'
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
          'condition' => 'tgl_pendaftaran::date = now()::date and pasienbatalperiksa_id is null',
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
        $pasien_id = $p->pasien_id;
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

        if (!empty($admisi)) {
          $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
        } else {
          //var_dump($pendaftaran->attributes);die;
          switch ($pendaftaran->instalasi_id) {
            case Params::INSTALASI_ID_RJ:
              $this->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
              break;
            case Params::INSTALASI_ID_RD:
              $this->periksaValidasiPasienRD($pendaftaran, $admisi, $pp, $returnVal);
              break;
            case Params::INSTALASI_ID_RI:
              // default:
              $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
              break;
            
              // $this->periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, $returnVal);
              // break;
          }
        }
        //die;
      }

      $returnVal['listDaftar']['pasien']['fingerprint_data'] = null;





      /*
              if (!empty($pendaftaran)) {
              $returnVal['adaDaftar'] = true;
              $returnVal['listDaftar'] = $pendaftaran->attributes;
              $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien;
              $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan;
              $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi;

              if (!empty($pendaftaran->pasienpulang_id)) {
              $pp = PasienpulangT::model()->findByPk($pendaftaran->pasienpulang_id);
              if ($pp->carakeluar_id == 5) $returnVal['tindakLanjut'] = true;
              if (!empty($pendaftaran->pasienadmisi_id)) {
              $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
              $returnVal['adaInap'] = true;
              $returnVal['listDaftar']['ruangan'] = $admisi->ruangan;
              }
              }
              }
             * 
             */

      if (isset($_POST['is_manual']) && $_POST['is_manual'] == true) {
        $rm_last = PasienM::model()->find(array(
          'condition' => 'ispasienluar = false',
          'order' => 'no_rekam_medik desc'
        ));
        //echo $no_rekam_medik." ".$rm_last->no_rekam_medik; die;
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
      if ($returnVal['no_mobile_pasien'] == "-" || empty($returnVal['no_mobile_pasien'])) { //RSST-1857
        $returnVal['no_mobile_pasien'] = Params::DEFAULT_NO_MOBILE_PASIEN; //default no mobile pasien 
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

      $modPendaftaaranPasien = PPPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $pasien_id, 'pasienbatalperiksa_id' => null));
      $returnVal['kunjungan_ke'] = (count((array)$modPendaftaaranPasien) + 1);

      $returnVal['pernah_dirujuk'] = 0;
      if (!empty($pasien_id)) {
        $criteria = new CDbCriteria();
        if (!empty($pasien_id)) {
          $criteria->addCondition("pasien_id = " . $pasien_id);
        }
        $criteria->addCondition('pasienbatalperiksa_id is null');
        $criteria->addCondition('rujukan_id is not null');
        $criteria->addCondition('carabayar_id = ' . Params::CARABAYAR_ID_BPJS);
        $criteria->addCondition("instalasi_id IN (select instalasi_id from ruanganrawatjalan_v)");
        $modDaftar = PendaftaranT::model()->findAll($criteria);
        if (count((array)$modDaftar) > 0) {
          $returnVal['pernah_dirujuk'] = count((array)$modDaftar);
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Validasi periksa pasien RJ
   * @param array $pendaftaran
   * @param array $admisi
   * @param array $pp
   * @param array $returnVal
   */
  function periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, &$returnVal)
  {
    if (!empty($pendaftaran->pasienpulang_id)) {
      // echo "Kick"; die;
      $pp = PasienpulangT::model()->findByPk($pendaftaran->pasienpulang_id);
      if ($pp->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
        $returnVal['adaDaftar'] = true;
        $returnVal['listDaftar'] = $pendaftaran->attributes;
        $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
        $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
        $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
        if (!empty($pendaftaran->pasienadmisi_id)) {
          $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
          $returnVal['adaInap'] = true;
          $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
        } else {
          $returnVal['tindakLanjut'] = true;
        }
      }
    } else {
      $tindakan = TindakanpelayananT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran->pendaftaran_id,
      ), array(
        'condition' => 'tindakansudahbayar_id is null  and qty_tindakan <> 0',
      ));
      $oa = ObatalkespasienT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran->pendaftaran_id,
      ), array(
        'condition' => 'oasudahbayar_id is null and qty_oa <> 0',
      ));

      $isAda = false;
      if (!empty($oa) || !empty($tindakan)) {
        if (empty($pendaftaran->pembayaranpelayanan_id))
          $isAda = true;
      }

      // var_dump($isAda); die;
      if ($isAda && !in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_DIPERIKSA, Params::STATUSPERIKSA_SUDAH_PULANG))) {
        $returnVal['adaDaftar'] = true;
        $returnVal['listDaftar'] = $pendaftaran->attributes;
        $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
        $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
        $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
      }
    }
  }

  /**
   * Validasi periksa pasien RD
   * @param array $pendaftaran
   * @param array $admisi
   * @param array $pp
   * @param array $returnVal
   */
  function periksaValidasiPasienRD($pendaftaran, $admisi, $pp, &$returnVal)
  {
    if (!empty($pendaftaran->pasienpulang_id)) {
      $pp = PasienpulangT::model()->findByPk($pendaftaran->pasienpulang_id);
      if ($pp->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
        $returnVal['adaDaftar'] = true;
        $returnVal['listDaftar'] = $pendaftaran->attributes;
        $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
        $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
        $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
        if (!empty($pendaftaran->pasienadmisi_id)) {
          $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
          $returnVal['adaInap'] = true;
          $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
        } else {
          $returnVal['tindakLanjut'] = true;
        }
      }
    } else {
      $tindakan = TindakanpelayananT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran->pendaftaran_id,
      ), array(
        'condition' => 'tindakansudahbayar_id is null and qty_tindakan <> 0',
      ));
      $oa = ObatalkespasienT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran->pendaftaran_id,
      ), array(
        'condition' => 'oasudahbayar_id is null and qty_oa <> 0',
      ));

      $isAda = false;
      if (!empty($oa) || !empty($tindakan)) {
        if (empty($pendaftaran->pembayaranpelayanan_id))
          $isAda = true;
      }

      if ($isAda || !in_array($pendaftaran->statusperiksa, array(Params::STATUSPERIKSA_SUDAH_PULANG))) {
        $returnVal['adaDaftar'] = true;
        $returnVal['listDaftar'] = $pendaftaran->attributes;
        $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
        $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
        $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
      }
    }
  }

  /**
   * Validasi periksa pasien RI
   * @param array $pendaftaran
   * @param array $admisi
   * @param array $pp
   * @param array $returnVal
   */
  function periksaValidasiPasienRI($pendaftaran, $admisi, $pp, &$returnVal)
  {
    if (empty($pendaftaran->pasienpulang_id)) {
      $returnVal['adaDaftar'] = true;
      $returnVal['listDaftar'] = $pendaftaran->attributes;
      $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
      $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
      $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
      $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
      if (!empty($admisi)) {

        if ($pendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $pendaftaran->statusperiksa == Params::STATUSPERIKSA_BATAL_PERIKSA) {
          $returnVal['adaDaftar'] = false;
        } else {
          $returnVal['adaInap'] = true;
          $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
        }
      } else {
        if ($pendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $pendaftaran->statusperiksa == Params::STATUSPERIKSA_BATAL_PERIKSA) {
          $returnVal['adaDaftar'] = false;
        }
        //var_dump($admisi);
      }
    } else {
      //var_dump($pendaftaran->statusperiksa);
      if ($pendaftaran->statusperiksa != Params::STATUSPERIKSA_SUDAH_PULANG && $pendaftaran->statusperiksa != Params::STATUSPERIKSA_BATAL_PERIKSA) {
        //var_dump($pendaftaran->statusperiksa);
        $returnVal['adaDaftar'] = true;
        $returnVal['listDaftar'] = $pendaftaran->attributes;
        $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
        $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
        $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
        $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
        if (!empty($admisi)) {
          $returnVal['adaInap'] = true;
          $returnVal['listDaftar']['ruangan'] = $admisi->ruangan->attributes;
        } else {
          $returnVal['adaDaftar'] = false;
        }
      } else {
        $returnVal['adaDaftar'] = false;
      }
    }
    //var_dump($pendaftaran->pasienpulang_id);die;
  }

  /**
   * Validasi periksa pasien Penunjang
   * @param array $pendaftaran
   * @param array $admisi
   * @param array $pp
   * @param array $returnVal
   */
  function periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, &$returnVal)
  {
    if (date('Y-m-d', time()) == date('Y-m-d', strtotime($pendaftaran->tgl_pendaftaran))) {
      $returnVal['adaDaftar'] = true;
      $returnVal['listDaftar'] = $pendaftaran->attributes;
      $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien->attributes;
      $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan->attributes;
      $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi->attributes;
    }
  }

  /**
   * Mengurai data pasien berdasarkan pasien_id
   * @throws CHttpException
   */
  public function actionGetRuanganPoliklinikPasien()
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
        $model = InfokunjunganrjV::model()->findAll($criteria);
        //                echo count((array)$model);exit;
        if (count((array)$model) > 0) {
          $returnVal['status'] = 'Ya';
          $returnVal['pesan'] = "Pasien sudah mendaftarkan sebelumnya ke Poliklinik : <br/>";
          $returnVal['pesan'] .= "<ol type=1>";
          foreach ($model as $i => $ruangan) {
            $returnVal['pesan'] .= "<li>" . $ruangan->ruangan_nama . " - " . ($format->formatDateTimeForUser($ruangan->tgl_pendaftaran)) . "</li>";
          }
          $returnVal['pesan'] .= "</ol>";
        } else {
          $returnVal['status'] = 'Tidak';
        }
      }
      //                

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
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
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
   * Mengatur dropdown kelurahan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
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
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modPasien = new PPPasienM;
      $propinsi_id = $_POST['propinsi_id'];
      $kabupaten_id = $_POST['kabupaten_id'];
      $kecamatan_id = $_POST['kecamatan_id'];
      $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

      $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE ORDER BY propinsi_nama ASC');
      $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
      $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($propinsis as $value => $name) {
        if ($value == $propinsi_id)
          $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
      //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
      $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
      $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kabupatens as $value => $name) {
        if ($value == $kabupaten_id)
          $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
      //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
      $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
      $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kecamatans as $value => $name) {
        if ($value == $kecamatan_id)
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
      $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
      $kelurahanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kelurahans as $value => $name) {
        if ($value == $kelurahan_id)
          $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
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
   * set dropdown dokter
   */
  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new PPPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      $option1 = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getDokterItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        foreach ($data as $value => $name) {
          if ($value == Params::PEGAWAI_DPJP_ID_STRIP) {
            $select = true;
          } else {
            $select = false;
          }
          $option .= CHtml::tag('option', array('value' => $value, 'selected' => $select), CHtml::encode($name), true);
        }
        $data = $model->getPPJPItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        foreach ($data as $value => $name) {
          $option1 .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }

      $modRuangan = RuanganM::model()->findByPk($_POST['ruangan_id']);

      $dataList['listDokter'] = $option;
      $dataList['listPPJP'] = $option1;
      $dataList['kode_bpjs'] = $modRuangan->kode_bpjs;

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
      $model = new PPPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
        foreach ($data as $value => $name) {
          if ($value == Params::JENIS_KASUSPENYAKIT_ID_UMUM) {
            $select = true;
          } else {
            $select = false;
          }
          $option .= CHtml::tag('option', array('value' => $value, 'selected' => $select), CHtml::encode($name), true);
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
   * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
   * @param boolean $encode
   * @param string $namaModel
   */
  public function actionSetDropdownKelasPelayanan($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST["$namaModel"]['ruangan_id'];
      $kelasPelayanan = null;
      if ($ruangan_id) {
        $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan_id . ' and kelaspelayanan_aktif = true');
        $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
      }
      if (empty($kelasPelayanan)) {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        foreach ($kelasPelayanan as $value => $name) {
          echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
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
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
        $modJadwalBukaPoli = JadwalbukapoliM::model()->findAll($criteria);
        $ruangan = RuanganM::model()->findByPk($ruangan_id);
        if (count((array)$modJadwalBukaPoli) > 0) {
          foreach ($modJadwalBukaPoli as $key => $antrian) {
            $data['maxantrianruangan'] = $antrian->maxantiranpoli;
            $data['jammulai'] = date('Y-m-d') . " " . $antrian->jammulai;
            $data['jamtutup'] = date('Y-m-d') . " " . $antrian->jamtutup;
            $data['jammulai_a'] = $antrian->jammulai;
            $data['jamtutup_a'] = $antrian->jamtutup;
            $data['nama_ruangan'] = $ruangan->ruangan_nama;
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
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
        $criteria->addCondition("pegawai_id = " . $pegawai_id);
        $modJadwalDokter = JadwaldokterM::model()->findAll($criteria);
        if (count((array)$modJadwalDokter) > 0) {
          foreach ($modJadwalDokter as $key => $antrian) {
            $data['maxantriandokter'] = !empty($antrian->maximumantrian) ? $antrian->maximumantrian : 0;
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
      $modTindakan = new PPTindakanPelayananT;
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $pasien_id = $_POST['pasien_id'];
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : "";
      $penjamin_id = $_POST['penjamin_id'];
      $carabayar_id = $_POST['carabayar_id'];
      $form = '';

      if ($carabayar_id == Params::CARABAYAR_ID_BPJS || $carabayar_id == Params::CARABAYAR_ID_ASURANSI) {
        $kelaspelayanan_id = Params::KELASPELAYANAN_ID_KELAS_III;
      }

      $is_pasienbaru = 'true';
      if (!empty($ruangan_id)) {
        if (!empty($pasien_id)) {
          $modP = PendaftaranT::model()->findByAttributes(array(
            'pasien_id' => $pasien_id,
          ), array(
            'condition' => 'pasienbatalperiksa_id is null',
          ));
          $modPasien = PasienM::model()->findByPk($pasien_id);
          if (isset($modPasien)) {
            $is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF && !empty($modP)) ? 'false' : 'true';
          }
        } else if (trim($no_rekam_medik) != "") {
          $is_pasienbaru = 'false';
        }
        $criteria = new CdbCriteria();
        $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
        $criteria->addCondition("penjamin_id = " . $penjamin_id);

        if (!empty($pasien_id)) {
          $criteria->addCondition("pasienbaru_karcis IS FALSE");
        } else {
          $criteria->addCondition("pasienbaru_karcis IS TRUE");
        }

        $modKarcisV = KarcisV::model()->findAll($criteria);

        $form = $this->renderPartial($this->path_view . '_formKarcis', array('modKarcisV' => $modKarcisV, 'modTindakan' => $modTindakan, 'format' => $format), true);
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
   * set tabel riwayat kunjungan pasien
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
   * Print status pendaftarans
   * @param integer $pendaftaran_id
   */
  public function actionPrintStatus($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows3';
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
   * Print SJP Pasien
   * @param integer $pendaftaran_id
   */
  public function actionPrintSjp($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $this->render($this->path_view . 'printSjp', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }

  /**
   * Print karcis pendaftaran
   * @param integer $pendaftaran_id
   */
  public function actionPrintKarcis($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $lp = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);

    if (!empty($lp))
      $modPegawai = PegawaiM::model()->findByPk($lp->pegawai_id);
    else
      $modPegawai = new PegawaiM;

    $karcis_id = null;
    $modTindakan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id), "karcis_id IS NOT NULL");
    $judul_print = 'Karcis Pelayanan Rawat Jalan';
    $this->render($this->path_view . 'printKarcis', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakan' => $modTindakan,
      'modPegawai' => $modPegawai,
    ));
  }

  /**
   * print kartu pasien
   * @param integer $pasien_id
   */
  public function actionPrintKartuPasien($pasien_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul_print = 'Kartu Pasien';
    $this->render(
      $this->path_view . 'printKartuPasienKen',
      array(
        'modPasien' => $modPasien,
        'judul_print' => $judul_print
      )
    );
  }

  /**
   * Catat print kartu
   * @param array $model PasienM data Pasien
   */
  public function catatPrintKartu($model)
  {
    $pk = new KartupasienR();
    $pk->pasien_id = $model->pasien_id;
    $pk->tglprintkartu = date('Y-m-d H:i:s');
    $pk->statusprintkartu = true;
    $pk->create_time = date('Y-m-d');
    $pk->create_loginpemakai_id = Yii::app()->user->id;

    if ($pk->validate()) {
      $pk->save();
    }
  }

  /**
   * Print SEP Pasien
   * @param integer $sep_id
   */
  public function actionPrintSep($sep_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modRujukanBpjs = new PPRujukanbpjsT;
    $modSep = PPSepT::model()->findByPk($sep_id);
    $modSep->print_ke++;
    $modSep->update(array('print_ke'));
    $bpjs = new Bpjs();
    $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi));
    $modJenisPeserta = PPJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
    if (isset($modSep->norujukan)) {
      $modRujukanBpjs = PPRujukanbpjsT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
    }
    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);


    $judul_print = 'SURAT ELIGIBILITAS PESERTA';
    $this->render($this->path_view . 'printSep_baru', array(
      'format' => $format,
      'modSep' => $modSep,
      'judul_print' => $judul_print,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modJenisPeserta' => $modJenisPeserta,
      'modRujukan' => $modRujukan,
    ));
  }


  /**
   * action ketika tombol panggil di klik
   * @param integer $antrian_id
   * @param string $ket
   * @param integer $loket_id
   * @throws CHttpException
   */
  public function actionPanggil($antrian_id, $ket = null, $loket_id = null)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";

      $modAntrian = PPAntrianT::model()->findByPk($antrian_id);
      if (isset($modAntrian)) {
        if ($modAntrian->panggil_flaq == true) {
          if ($ket == "batal") {
            $modAntrian->panggil_flaq = false;
            if ($modAntrian->update()) {
            }
          }

          /* Start-RSST-960 */
          if (!empty($loket_id)) {
            $modAntrian->loket_id = $loket_id;
          }
          $modAntrian->jampanggil = date('Y-m-d H:i:s');
          $tglantrians = $modAntrian->tglantrian;
          $now = date('Y-m-d H:i:s');
          $to_time = strtotime($now);
          $from_time = strtotime($tglantrians);
          $difHour = round(abs($to_time - $from_time) / 60); //ambil konversi ke menit
          $modAntrian->lamamenunggu_mnt = $difHour;
          $jmlpanggil = $modAntrian->jml_panggil;
          $modAntrian->jml_panggil = $jmlpanggil + 1;
          $modAntrian->update_loginpemakai_id = Yii::app()->user->id;
          /* END */
          $modAntrian->update();
        } else {

          /* Start-RSST-960 */
          if (!empty($loket_id)) {
            $modAntrian->loket_id = $loket_id;
          }
          $modAntrian->jampanggil = date('Y-m-d H:i:s');
          $tglantrians = $modAntrian->tglantrian;
          $now = date('Y-m-d H:i:s');
          $to_time = strtotime($now);
          $from_time = strtotime($tglantrians);
          $difHour = round(abs($to_time - $from_time) / 60); //ambil konversi ke menit
          $modAntrian->lamamenunggu_mnt = $difHour;
          $modAntrian->jml_panggil = 1;
          $modAntrian->update_loginpemakai_id = Yii::app()->user->id;
          /* END */

          $modAntrian->panggil_flaq = true;
          if ($modAntrian->update()) {
          }
        }
      }
      $attributes = $modAntrian->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $modAntrian->$attribute;
      }
      $data['noantrian'] = (isset($modAntrian->noantrian) && !empty($modAntrian->noantrian)) ? (empty($modAntrian->modelantrian_id) ? "X" : $modAntrian->modelAntrian->modelantrian_singkatan) . "-" . $modAntrian->noantrian : null;
      $data['jml_panggil'] = $modAntrian->jml_panggil;

      $criteria1 = new CDbCriteria();
      $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
      $criteria1->addCondition("pendaftaran_id IS NULL");
      $criteria1->addCondition("modelantrian_id = " . $data['modelantrian_id']);
      $criteria1->addCondition('update_loginpemakai_id IS NULL');
      $criteria1->addCondition('jml_panggil IS NULL');
      $modAntrian = AntrianT::model()->findAll($criteria1);
      $dataList['sisaAntrian'] = count((array)$modAntrian);

      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * menampilkan form antrian dari request ajax
   * @throws CHttpException
   */
  public function actionSetFormAntrian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $record = (isset($_POST['record']) ? $_POST['record'] : "");
      $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
      $loket_id = (isset($_POST['loket_id']) ? $_POST['loket_id'] : null);
      $modelantrian_id = (isset($_POST['modelantrian_id']) ? $_POST['modelantrian_id'] : null);

      if (!empty($modelantrian_id)) {
        $criteria1 = new CDbCriteria();
        $criteria1->compare('DATE(tglantrian)', date("Y-m-d"));
        $criteria1->addCondition("pendaftaran_id IS NULL");
        $criteria1->addCondition("modelantrian_id = " . $modelantrian_id);
        $criteria1->addCondition('update_loginpemakai_id IS NULL');
        $criteria1->addCondition('jml_panggil IS NULL');
        $antrianModel = AntrianT::model()->findAll($criteria1);
      }

      if ($record == 'ulangi') { //ketika ubah lokasi antrian maka lakukan reset semua
        $modAntrian = new PPAntrianT;
      } else {

        if (empty($noantrian)) { //antrian baru
          $criteria = new CDbCriteria();
          $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
          $criteria->addCondition("pendaftaran_id IS NULL");

          if (!empty($modelantrian_id)) {
            $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
          }
          $criteria->addCondition('loket_id IS NULL OR loket_id = ' . $loket_id);
          $criteria->addCondition('update_loginpemakai_id IS NULL OR update_loginpemakai_id = ' . Yii::app()->user->id);

          $criteria->order = "antrian_id ASC";
          if ($record == 'reset' && isset($antrianModel) && count((array)$antrianModel) <= 0) {
            $criteria->order = "antrian_id DESC";
          } else if ($record == 'reset' && isset($antrianModel) && count((array)$antrianModel) > 0) {
            $criteria->addCondition('jml_panggil IS NULL');
          } else if ($record == 'reset' && isset($antrianModel)) {
            $criteria->addCondition('jml_panggil < 3 OR jml_panggil IS NULL');
          } else {
            $criteria->order = "antrian_id ASC";
          }
          $criteria->limit = 1;
          $modAntrian = PPAntrianT::model()->find($criteria);
        } else {
          $criteria = new CDbCriteria();
          $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
          $criteria->compare("noantrian", trim($noantrian));
          /*if ($record != 'next') {
                        $criteria->addCondition('(jml_panggil < 3 OR jml_panggil IS NULL)');
                    }*/
          if ($record == 'reset') {
            $criteria->addCondition('(jml_panggil IS NULL)');
          }
          if (!empty($modelantrian_id)) {
            $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
          }
          $criteria->addCondition('(loket_id IS NULL OR loket_id = ' . $loket_id . ')');
          $criteria->addCondition('(update_loginpemakai_id IS NULL OR update_loginpemakai_id = ' . Yii::app()->user->id . ')');
          $criteria->limit = 1;
          $criteria->order = "antrian_id ASC";
          $cari = PPAntrianT::model()->find($criteria);
          if (!empty($cari)) {

            if ($record == 'next') {
              $cari->loket_id = $loket_id;
              $modAntrian = $cari->AntrianBerikut;
            } else if ($record == 'prev') {
              $cari->loket_id = $loket_id;
              $modAntrian = $cari->AntrianSebelum;
            } else {
              $modAntrian = $cari;
            }
          }
        }
      }

      if (!isset($modAntrian)) {
        $modAntrian = new PPAntrianT;
        $data['pesan'] = "Antrian Habis !";
      }

      $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
      $data['form_antrian'] = $this->renderPartial($this->path_view . '_formPanggilAntrian', array('modAntrian' => $modAntrian), true);
      $data['noantrian'] = (isset($modAntrian->noantrian) && !empty($modAntrian->noantrian)) ? (empty($modAntrian->modelantrian_id) ? "X" : $modAntrian->modelAntrian->modelantrian_singkatan) . "-" . $modAntrian->noantrian : '';
      $data['jml_panggil'] = (isset($modAntrian->jml_panggil) && !empty($modAntrian->jml_panggil)) ? $modAntrian->jml_panggil : null;
      $data['sisaAntrian'] = isset($antrianModel) ? count((array)$antrianModel) : 0;

      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * untuk menampilkan data diagnosa dari autocomplete
   * 1. diagnosa_kode
   * 2. diagnosa_nama
   */
  public function actionAutocompleteDiagnosaRujukan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $diagnosa_nama = isset($_GET['diagnosa_rujukan']) ? $_GET['diagnosa_rujukan'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(diagnosa_nama)', strtolower($diagnosa_nama), true);
      $criteria->order = 'diagnosa_nama';
      $criteria->limit = 5;
      $models = DiagnosaM::model()->findAll($criteria);
      $data = array();
      foreach ($models as $i => $model) {
        $data[$i] = array(
          'key' => $model->diagnosa_kode,
          'value' => $model->diagnosa_nama
        );
      }

      echo CJSON::encode($data);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * set bpjs Interface
   */
  public function actionBpjsInterface()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (empty($_GET['param']) or $_GET['param'] === '') {
        die('param can\'not empty value');
      } else {
        $param = $_GET['param'];
      }
      $bpjs = new BpjsVklaim();

      switch ($param) {
        case '1':
          $query = $_GET['query'];
          //                        echo '<pre>';
          print_r($bpjs->search_kartu($query));
          //                        exit();
          break;
        case '2':
          $query = $_GET['query'];
          print_r($bpjs->search_nik($query));
          break;
        case '3':
          $query = $_GET['query'];
          print_r($bpjs->search_rujukan_no_rujukan($query));
          break;
        case '4':
          //                        $query = $_GET['query'];
          //                        print_r( $bpjs->search_rujukan_no_bpjs($query) );
          $query = $_GET['query'];
          $tgl = isset($_GET['tgl']) ? MyFormatter::formatDateTimeForDb($_GET['tgl']) : null;
          $suksesrujukan = false;
          $dataRujukan = json_decode($bpjs->search_rujukan_no_bpjs($query));

          if (isset($dataRujukan->metaData)) {
            if ($dataRujukan->metaData->message == 'OK') {
              $suksesrujukan = true;
            }
          }

          if ($suksesrujukan) {
            print_r(json_encode($dataRujukan));
          } else {
            print_r($bpjs->search_kartu($query, $tgl));
          }
          break;
        case '5':
          $query = $_GET['query'];
          $start = $_GET['start'];
          $limit = $_GET['limit'];
          print_r($bpjs->list_rujukan_tanggal($query, $start, $limit));
          break;
        case '6':
          $modPoli = RuanganM::model()->findByPk($_GET['poli_tujuan']);
          $nokartu = $_GET['no_kartu'];
          $tglsep = MyFormatter::formatDateTimeForDb($_GET['tgl_sep']);
          $tglrujukan = MyFormatter::formatDateTimeForDb($_GET['tgl_rujukan']);
          if ($_GET['jns_pelayanan'] == 1) {
            $norujukan = $_GET['no_mr'];
          } else {
            $norujukan = $_GET['no_rujukan'];
          }
          $ppkrujukan = $_GET['ppk_rujukan'];
          $ppkpelayanan = $_GET['ppk_pelayanan'];
          $jnspelayanan = $_GET['jns_pelayanan'];
          $lakalantas = isset($_GET['lakalantas']) ? $_GET['lakalantas'] : null;
          $catatan = $_GET['catatan'];
          $diagawal = $_GET['diag_awal'];
          $politujuan = (!empty($modPoli->kode_ruanganpoli) ? $modPoli->kode_ruanganpoli : "");
          $klsrawat = $_GET['kls_rawat'];
          $user = $_GET['user'];
          $nomr = (!empty($_GET['no_mr']) ? $_GET['no_mr'] : 0);
          $notrans = $_GET['no_trans'];

          $noTelp = isset($_GET['noTelp']) ? $_GET['noTelp'] : null;
          $asalRujukan = $_GET['asalRujukan'];
          $eksekutif = isset($_GET['eksekutif']) ? $_GET['eksekutif'] : null;
          $cob = $_GET['cob'];
          $penjamin = $_GET['penjamin'];
          $lokasiLaka = isset($_GET['lokasiLaka']) ? $_GET['lokasiLaka'] : null;

          $kelaspelayanan_id = $_GET['kelaspelayanan_id'];
          if (!empty($kelaspelayanan_id)) {
            $modKelas = KelaspelayananM::model()->findByPk($kelaspelayanan_id);
            if (!empty($modKelas->kodekelaspelayanan_bpjs)) {
              if ($modKelas->kodekelaspelayanan_bpjs <= $klsrawat) {
                $klsrawat = $klsrawat;
              } else {
                $klsrawat = $modKelas->kodekelaspelayanan_bpjs;
              }
            }
          }
          if ($jnspelayanan == Params::JENISPELAYANAN_RJ) {
            $klsrawat = 3;
          }

          $tglKejadian = isset($_GET['tglKejadian']) ? MyFormatter::formatDateTimeForDb($_GET['tglKejadian']) : null;
          $keterangan = isset($_GET['keterangan']) ? $_GET['keterangan'] : null;
          $suplesi = isset($_GET['suplesi']) ? $_GET['suplesi'] : null;
          $noSepSuplesi = isset($_GET['noSepSuplesi']) ? $_GET['noSepSuplesi'] : null;
          $kdPropinsi = isset($_GET['kdPropinsi']) ? $_GET['kdPropinsi'] : null;
          $kdKabupaten = isset($_GET['kdKabupaten']) ? $_GET['kdKabupaten'] : null;
          $kdKecamatan = isset($_GET['kdKecamatan']) ? $_GET['kdKecamatan'] : null;
          $noSurat = isset($_GET['noSurat']) ? $_GET['noSurat'] : null;
          $kodeDPJP = isset($_GET['kodeDPJP']) ? $_GET['kodeDPJP'] : null;
          $katarak = isset($_GET['katarak']) ? $_GET['katarak'] : null;

          print_r($bpjs->create_sep_new($nokartu, $tglsep, $ppkpelayanan, $jnspelayanan, $klsrawat, $nomr, $asalRujukan, $tglrujukan, $norujukan, $ppkrujukan, $catatan, $diagawal, $politujuan, $eksekutif, $cob, $lakalantas, $penjamin, $lokasiLaka, $noTelp, $user, $tglKejadian, $keterangan, $suplesi, $noSepSuplesi, $kdPropinsi, $kdKabupaten, $kdKecamatan, $noSurat, $kodeDPJP, $katarak));
          break;
        case '7':
          $nosep = $_GET['nosep'];
          $tglpulang = $_GET['tglpulang'];
          $ppkpelayanan = $_GET['ppkpelayanan'];
          print_r($bpjs->update_tanggal_pulang_sep($nosep, $tglpulang, $ppkpelayanan));
          break;
        case '8':
          $nosep = $_GET['nosep'];
          $notrans = $_GET['notrans'];
          $ppkpelayanan = $_GET['ppkpelayanan'];
          print_r($bpjs->mapping_trans($nosep, $notrans, $ppkpelayanan));
          break;
        case '9':
          $nosep = $_GET['nosep'];
          $ppkpelayanan = $_GET['ppkpelayanan'];
          print_r($bpjs->delete_transaksi($nosep, $ppkpelayanan));
          break;
        case '10':
          $nokartu = $_GET['nokartu'];
          print_r($bpjs->riwayat_terakhir($nokartu));
          break;
        case '11':
          $nosep = $_GET['nosep'];
          print_r($bpjs->detail_sep($nosep));
          break;
        case '12':
          $query = $_GET['ppkrujukan'];
          $query = explode(" ", $query);
          $query = $query[0];
          $query1 = '2';
          $query1 = explode(" ", $query1);
          $query1 = $query1[0];
          $start = 1;
          $limit = 10;
          if ($query != '' && $query1 == '') {
            $query = $query;
          } else if ($query != '' && $query1 != '') {
            $query = $query . '/' . $query1;
          } else if ($query == '' && $query1 != '') {
            $query = $query . '/' . $query1;
          }
          // $ppkpelayanan = $_GET['ppkrujukan'];
          // $start = $_GET['start'];
          // $limit = $_GET['limit'];
          // print_r( $bpjs->detail_ppk_rujukan($ppkpelayanan, $start, $limit) );
          print_r($bpjs->fasilitas_kesehatan($query, $start, $limit));
          break;
        case '13':
          $query = $_GET['query'];
          print_r($bpjs->search_rujukan_pcare_multi($query));
          break;
        case '16':
          $query = $_GET['kodeppkpelayanan'];
          $query = explode(" ", $query);
          $query = $query[0];
          $query1 = $_GET['jenis_rujukan'];
          $query1 = explode(" ", $query1);
          $query1 = $query1[0];
          $start = 1;
          $limit = 10;
          if ($query != '' && $query1 == '') {
            $query = $query;
          } else if ($query != '' && $query1 != '') {
            $query = $query . '/' . $query1;
          } else if ($query == '' && $query1 != '') {
            $query = $query . '/' . $query1;
          }
          print_r($bpjs->fasilitas_kesehatan($query, $start, $limit));
          break;
        case '17':
          $query1 = $_GET['katakunci1'];
          $query2 = MyFormatter::formatDateTimeForDb($_GET['katakunci2']);
          $query3 = (!empty($_GET['katakunci3']) ? $_GET['katakunci3'] : "");
          $query = $query1 . "/tglPelayanan/" . $query2 . "/Spesialis/" . $query3;
          $start = 1;
          $limit = 10;
          print_r($bpjs->search_dpjp($query, $start, $limit));
          break;
        case '18':
          $query = $_GET['query'];

          $str = $bpjs->search_no_surat_kontrol($query);
          if (!empty($str)) {
            $json = CJSON::decode($str);
            if (!empty($json['response']) && $json['response'] != "") {
              $json['response']['poli_tujuan'] = "-";
              $json['response']['sep']['peserta']['tglLahir'] = date('d/m/Y', strtotime($json['response']['sep']['peserta']['tglLahir']));
              $json['response']['sep']['tglSep'] = date('d/m/Y', strtotime($json['response']['sep']['tglSep']));
              $json['response']['tglTerbit'] = date('d/m/Y', strtotime($json['response']['tglTerbit']));
              // var_dump($json); die;

              $tgl_rencana =  $json['response']['tglRencanaKontrol'];

              $date_rencana = new DateTime($tgl_rencana);
              $date_sekarang = new DateTime(date('Y-m-d'));

              $status = 0;
              if ($date_sekarang > $date_rencana) {
                $status = 1;
              } else if ($date_sekarang < $date_rencana) {
                $status = -1;
              }

              $json['response']['status_kontrol'] = $status;
              $json['response']['tglRencanaKontrol'] = date('d/m/Y', strtotime($json['response']['tglRencanaKontrol']));

              $ruangan = RuanganM::model()->findByAttributes(array(
                'kode_bpjs' => $json['response']['poliTujuan'],
                'ruangan_aktif' => true,
              ));

              if (!empty($ruangan)) {
                $json['response']['poli_tujuan'] = $ruangan->ruangan_nama;
              }
            }

            print_r(CJSON::encode($json));
          }

          break;
        case '99':
          $bpjs->identity_magic();
          break;
        case '100':
          print_r($bpjs->help());
          break;
        default:
          die('error number, please check your parameter option');
          break;
      }
      Yii::app()->end();
    }
  }

  /**
   * set Inhealth Interface
   */
  public function actionInhealthInterface()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (empty($_GET['param']) or $_GET['param'] === '') {
        die('param can\'not empty value');
      } else {
        $param = $_GET['param'];
      }

      $inhealth = new Inhealth(); //service briging inhealth

      switch ($param) {
        case '1':
          $nokainhealth = $_GET['nokainhealth'];
          $tglpelayanan = $_GET['tglpelayanan'];
          $jenispelayanan = $_GET['jenispelayanan'];
          $poli = $_GET['poli'];
          $modPoli = RuanganM::model()->findByPk($poli);
          $poli = (!empty($modPoli->kode_poliinhealth) ? $modPoli->kode_poliinhealth : "");
          print_r($inhealth->EligibilitasPeserta($nokainhealth, date('Y-m-d', strtotime($tglpelayanan)), $jenispelayanan, $poli));
          break;
        case '2':
          $tanggalpelayanan = date('Y-m-d', strtotime($_GET['tanggalpelayanan']));
          $jenispelayanan = $_GET['jenispelayanan'];
          $nokainhealth = $_GET['nokainhealth'];
          $nomormedicalreport = $_GET['nomormedicalreport'];
          $nomorasalrujukan = $_GET['nomorasalrujukan'];
          $kodeproviderasalrujukan = $_GET['kodeproviderasalrujukan'];
          $tanggalasalrujukan = date('Y-m-d', strtotime($_GET['tanggalasalrujukan']));
          $kodediagnosautama = $_GET['kodediagnosautama'];
          $poli = $_GET['poli'];
          $informasitambahan = $_GET['informasitambahan'];
          $kodediagnosatambahan = $_GET['kodediagnosatambahan'];
          $kecelakaankerja = $_GET['kecelakaankerja'];
          $kelasrawat = $_GET['klsrawat'];
          $kelaspelayanan_id = $_GET['kelaspelayanan_id'];

          if (!empty($kelaspelayanan_id)) {
            $klsInhealth = KelaspelayananM::model()->findByPk($kelaspelayanan_id);
            if (!empty($klsInhealth->kode_kelas_inhealth)) {
              $kelaspelayanan_id = $klsInhealth->kode_kelas_inhealth;
              $kelasrawat = $kelaspelayanan_id;
            }
          }

          $modPoli = RuanganM::model()->findByPk($poli);
          $poli = (!empty($modPoli->kode_poliinhealth) ? $modPoli->kode_poliinhealth : "");
          $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->id);
          $username = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : '-';
          $kodejenpelruangrawat = null;

          print_r($inhealth->SimpanSJP($tanggalpelayanan, $jenispelayanan, $nokainhealth, $nomormedicalreport, $nomorasalrujukan, $kodeproviderasalrujukan, $tanggalasalrujukan, $kodediagnosautama, $poli, $username, $informasitambahan, $kodediagnosatambahan, $kecelakaankerja, $kelasrawat, $kodejenpelruangrawat));
          break;
        case 3:
          $SEP = PPSepInhealthT::model()->findByPk($_GET['sep_id']);
          $tkp = $_GET['tkp'];

          print_r($inhealth->CetakSJP($SEP->nosep, $tkp));
          break;
        default:
          die('error number, please check your parameter option');
          break;
      }
    }
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
      if (!empty($model)) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $data["$attribute"] = $model->$attribute;
        }

        if ($data['carabayar_id'] == Params::CARABAYAR_ID_BPJS) {
          $kelasbpjs_id = KelaspelayananM::model()->findByPk($data['kelastanggunganasuransi_id']);
          if (!empty($kelasbpjs_id)) {
            $data['kelastanggunganasuransi_id'] = $kelasbpjs_id->kelasbpjs_id;
          }
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
      }
      echo CJSON::encode($data);
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
   * Cek keaktifan pegawai jika penjamin pt badak
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
   * Cek kategori pegawai untuk menentukan asuransi pasien
   */
  public function actionCekValiditasPenjamin()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : '';
      $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : '';
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
   * Ngeset data asuransi badak jika pasien telah memiliki data di asuransipasien_m
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
            $modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
            $data['nopeserta'] = $modPegawai->nomorindukpegawai;
            $data['namaperusahaan'] = $modPegawai->unit_perusahaan;
            $data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
            $data['namaperusahaan'] = 'PT. Badak LNG';
          }
        }
      } else {
        $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
        if (!empty($pegawai_id)) {
          $modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
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

  /**
   * Proses cek SEP
   */
  public function actionCekSEP()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $nosep = $_POST['nosep'];
      $bpjs = new Bpjs();
      $res = CJSON::decode($bpjs->detail_sep($nosep));


      $res["rujukan"] = array(
        "rujukandari_id" => "",
      );

      if ($res["metadata"]["code"] == "200" && !empty($res["response"]["provRujukan"])) {

        $rujukan = RujukandariM::model()->findByAttributes(array(
          "ppkrujukan" => $res["response"]["provRujukan"]["kdProvider"]
        ));
        if (!empty($rujukan)) {
          $rujukans = CHtml::listData(RujukandariM::model()->findAllByAttributes(array(
            "asalrujukan_id" => $rujukan->asalrujukan_id,
          ), array(
            "order" => "namaperujuk"
          )), "rujukandari_id", "namaperujuk");

          $op = "";
          foreach ($rujukans as $idx => $item) {
            $op .= '<option value="' . $idx . '">' . $item . '</option>';
          }

          $res["rujukan"]["rujukandari_id"] = $rujukan->rujukandari_id;
          $res["rujukan"]["asalrujukan_id"] = $rujukan->asalrujukan_id;
          $res["rujukan"]["listrujukandari_id"] = $op;
        }
      }

      print_r(CJSON::encode($res));
    }
  }

  /**
   * - digunakan untuk mencetak sticker
   * @param integer $pendaftaran_id
   */
  public function actionPrintLabel($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

    $this->render(
      $this->path_view . 'printLabel',
      array(
        'modPendaftaran' => $modPendaftaran,
      )
    );
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

      if (!empty($pasien)) {
        $ok = 0;
        $msg = "KTP dengan Nomor " . $pasien->no_identitas_pasien . " sudah terdaftar atas Nama " . $pasien->nama_pasien . " - " . $pasien->no_rekam_medik;

        goto prints;
      }
    }

    /* Prosess validasi ini dilepaskan terkait issue RSST-722
          $pasien = PasienM::model()->findByAttributes(array(
          'tanggal_lahir'=>MyFormatter::formatDateTimeForDb($_POST['PPPasienM']['tanggal_lahir']),
          'nama_ibu'=>$_POST['PPPasienM']['nama_ibu'],
          ));

          if (!empty($pasien)) {
          $ok = 0;
          $msg = "Pasien ber tanggal lahir ".date('d/m/Y', strtotime($pasien->tanggal_lahir)).
          " beserta Ibu bernama ".$pasien->nama_ibu.
          " sudah terdaftar atas Nama ".$pasien->nama_pasien." - ".$pasien->no_rekam_medik;

          goto prints;
          }
         */


    prints:
    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }

  /**
   * Set diagnosa
   */
  public function actionSetFormDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $diagnosaList = $_POST['diagnosaList'];
      $form = '';
      $pesan = '';
      if (count((array)$diagnosaList) > 0) {
        foreach ($diagnosaList as $i => $diagnosa) {
          $kddiagnosa = $diagnosa['kode'];
          $nmdiagnosa = str_replace("'", "`", $diagnosa['nama']);
          $kddiagnosa1 = "'" . $kddiagnosa . "'";
          $nmdiagnosa1 = "'" . $nmdiagnosa . "'";
          $form .= '<tr>
                        <td>
                            <a class="btn-small" href="#" onclick="
                                if($(\'#content-bpjs\').hasClass(\'in\')){
                                    setDiagnosaBpjs(' . $kddiagnosa1 . ',' . $nmdiagnosa1 . ');
                                }else{
                                    setDiagnosa(' . $kddiagnosa1 . ',' . $nmdiagnosa1 . ');
                                }
                                $(\'#dialogDiagnosaBpjs\').dialog(\'close\'); 
                                return false;
                            ">
                            <i class="icon-form-check"></i></a>
                        </td>
                        <td>
                            <span id="kdPoli" name="[ii][kdPoli]">' . $kddiagnosa . '</span>
                        </td>
                        <td>
                            <span id="nmPoli" name="[ii][nmPoli]">' . $nmdiagnosa . '</span>
                        </td>
                    </tr>';
        }
      } else {
        $pesan = "Data tidak ada!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * Load dropdown rujukan dari
   */
  public function actionSetDropdownRujukanDari()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new RujukandariM;
      $option = '';
      $option2 = '';
      if (!empty($_POST['kodeppk'])) {
        $data = $model->getRujukanDariData($_POST['kodeppk']);

        $jml = $data;
        if (!empty($jml) > 0) {
          $data2 = AsalrujukanM::model()->findAllByAttributes(array('asalrujukan_id' => $data->asalrujukan_id));
          $data2 = CHtml::listData($data2, 'asalrujukan_id', 'asalrujukan_nama');

          foreach ($data2 as $value2 => $name2) {
            $option2 .= CHtml::tag('option', array('value' => $value2), CHtml::encode($name2), true);
          }
        } else {
          $data2 = AsalrujukanM::model()->findAllByAttributes(array('asalrujukan_aktif' => TRUE));
          $data2 = CHtml::listData($data2, 'asalrujukan_id', 'asalrujukan_nama');

          foreach ($data2 as $value2 => $name2) {
            $option2 .= CHtml::tag('option', array('value' => $value2), CHtml::encode($name2), true);
          }
        }

        $option .= CHtml::tag('option', array('value' => $data->rujukandari_id), CHtml::encode($data->namaperujuk), true);
      }
      $dataList['listAsalRujukan'] = $option2;
      $dataList['listRujukanDari'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * form proses SEP sesudah pasien disimpan
   * @param integer $pendaftaran_id
   * @param integer $pasien_id
   * @param integer $idSep
   */
  public function actionProsesSEP($pendaftaran_id = null, $pasien_id = null, $idSep = null)
  {
    $this->layout = '//layouts/iframe';
    $pendaftaran_id = isset($pendaftaran_id) ? $pendaftaran_id : null;
    $pasien_id = isset($pasien_id) ? $pasien_id : null;

    $format = new MyFormatter();

    $model = new PPPendaftaranT;
    $modPasien = new PPPasienM;
    $modAdmisi = new PPPasienAdmisiT;
    $modPenanggungJawab = new PPPenanggungJawabM;
    $modPegawai = new PPPegawaiM;
    $modRujukan = new PPRujukanT;
    $modRujukanBpjs = new PPRujukanbpjsT;
    $modAsuransiPasien = new PPAsuransipasienM;
    $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
    $modProfilRS = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    $modSep = new PPSepT;
    $modSep->tglsep = date('Y-m-d H:i:s');
    $modSep->ppkpelayanan = $modProfilRS->ppkpelayanan;
    $model->is_bpjs = 1;
    $modSep->jnspelayanan = 2; //defaul rajal
    $modSep->katarak = 0;
    $modSep->suplesi_jasaraharja = 0;
    $modSep->status_nosep = "TIDAK";
    if (isset($_GET['jnspelayanan']) && !empty($_GET['jnspelayanan'])) { //untuk kondisi dari RI/RD/RJ
      if ($_GET['jnspelayanan'] == "RJ" || $_GET['jnspelayanan'] == "RD") {
        $modSep->jnspelayanan = 2;
      } else {
        $modSep->jnspelayanan = 1;
      }
    }
    $modSep->poli_eksekutif = 0;
    $modSep->cob = 0;
    $modSep->lakalantas = 0;
    $modSep->jenisfaskes = 2;

    if (!empty($pendaftaran_id)) {
      $model = PPPendaftaranT::model()->findByPk($pendaftaran_id);
      $idSep = isset($model->sep_id) ? $model->sep_id : null;
      $pasien_id = $model->pasien_id;
      if (!empty($model->pasienadmisi_id)) {
        $modAdmisi = PPPasienAdmisiT::model()->findByPk($model->pasienadmisi_id);
        $model->ruangan_nama = isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan->ruangan_nama : "";
      } else {
        $model->ruangan_nama = isset($model->ruangan_id) ? $model->ruangan->ruangan_nama : "";
      }
      if (!empty($model->pasienadmisi_id)) {
        $modAdmisi = PPPasienAdmisiT::model()->findByPk($model->pasienadmisi_id);
      }
    }

    if (!empty($pasien_id)) {
      $modPasien = PPPasienM::model()->findByPk($pasien_id);
    }

    if (isset($idSep)) {
      $modSep = PPSepT::model()->findByPk($idSep);
      $model->is_bpjs = ($modSep->is_inhealth) ? 0 : 1;
      if (isset($model->rujukan_id)) {
        $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
      }
      if (isset($model->asuransipasien_id)) {
        $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
        $modJenisPeserta = JenispesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
        if (!empty($modJenisPeserta)) {
          $modAsuransiPasienBpjs->jenispeserta_nama = isset($modJenisPeserta->jenispeserta_nama) ? $modJenisPeserta->jenispeserta_nama : '-';
        }
        $modAsuransiPasienBpjs->kelastanggunganasuransi_nama = $modAsuransiPasienBpjs->kelastanggunganasuransi_id;
      }
    }

    if (isset($_POST['PPPendaftaranT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (isset($_POST['PPRujukanbpjsT'])) {
          $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
        } else {
          $this->rujukantersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienbpjsM'])) {
          if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
              $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbpjsM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPSepT'])) {

          $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
          if ($modSep) {
            $model = PPPendaftaranT::model()->findByPk($pendaftaran_id);
            $model->sep_id = $modSep->sep_id;
            $model->rujukan_id = isset($modRujukanBpjs->rujukan_id) ? $modRujukanBpjs->rujukan_id : null;
            $model->asuransipasien_id = isset($modAsuransiPasienBpjs->asuransipasien_id) ? $modAsuransiPasienBpjs->asuransipasien_id : null;
            $model->save();
          }
        }

        if ($this->rujukantersimpan && $this->asuransipasientersimpan) {
          $transaction->commit();
          if ($this->septersimpan) {
            $this->redirect(array('ProsesSEP', 'pendaftaran_id' => $model->pendaftaran_id, 'pasien_id' => $model->pasien_id, 'idSep' => $modSep->sep_id, 'pelayanan' => $_GET['pelayanan'], 'sukses' => 1));
          } else {
            $this->redirect(array('ProsesSEP', 'pendaftaran_id' => $model->pendaftaran_id, 'pasien_id' => $model->pasien_id, 'pelayanan' => $_GET['pelayanan'], 'sukses' => 1));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data SEP gagal disimpan !");
        }
      } catch (Exception $ex) {
        echo $ex;
        exit;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data SEP gagal disimpan !" . $ex);
      }
    }

    $this->render('_formAsuransiBpjsSEP', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modRujukan' => $modRujukan,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modSep' => $modSep,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modAdmisi' => $modAdmisi,
      'pelayanan' => $_GET['pelayanan'],
    ));
  }

  /**
   * form proses SEP sesudah pasien disimpan
   * @param integer $pendaftaran_id
   * @param integer $pasien_id
   * @param integer $idSep
   */
  public function actionProsesSJP($pendaftaran_id = null, $pasien_id = null, $idSep = null)
  {
    $this->layout = '//layouts/iframe';
    $pendaftaran_id = isset($pendaftaran_id) ? $pendaftaran_id : null;
    $pasien_id = isset($pasien_id) ? $pasien_id : null;

    $format = new MyFormatter();

    $model = new PPPendaftaranT;
    $modPasien = new PPPasienM;
    $modAdmisi = new PPPasienAdmisiT;
    $modPenanggungJawab = new PPPenanggungJawabM;
    $modPegawai = new PPPegawaiM;
    $modRujukan = new PPRujukanT;
    $modRujukanInhealth = new PPRujukanInhealthT;
    $modAsuransiPasien = new PPAsuransipasienM;
    $modAsuransiPasienInhealth = new PPAsuransipasieninhealthM;
    $modProfilRS = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    $modSepInhealthT = new PPSepInhealthT;
    $modSepInhealthT->tglsep = date('Y-m-d H:i:s');
    $modSepInhealthT->ppkpelayanan = $modProfilRS->ppkpelayanan;
    $model->is_bpjs = 0;
    $modSepInhealthT->jnspelayanan = 3; //defaul rajal
    $modSepInhealthT->suplesi_jasaraharja = 0;
    $modSepInhealthT->status_nosep = "TIDAK";
    $modRujukanInhealth->tanggal_rujukan = date('Y-m-d H:i:s');
    $modRujukanInhealth->no_rujukan = "-";
    if (isset($_GET['jnspelayanan']) && !empty($_GET['jnspelayanan'])) { //untuk kondisi dari RI/RD/RJ
      if ($_GET['jnspelayanan'] == "RJ" || $_GET['jnspelayanan'] == "RD") {
        $modSepInhealthT->jnspelayanan = 3;
      } else {
        $modSepInhealthT->jnspelayanan = 4;
      }
    }

    if (!empty($pendaftaran_id)) {
      $model = PPPendaftaranT::model()->findByPk($pendaftaran_id);
      $idSep = isset($model->sep_id) ? $model->sep_id : null;
      $pasien_id = $model->pasien_id;
      if (!empty($model->pasienadmisi_id)) {
        $modAdmisi = PPPasienAdmisiT::model()->findByPk($model->pasienadmisi_id);
        $model->ruangan_nama = isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan->ruangan_nama : "";
      } else {
        $model->ruangan_nama = isset($model->ruangan_id) ? $model->ruangan->ruangan_nama : "";
      }
      if (!empty($model->pasienadmisi_id)) {
        $modAdmisi = PPPasienAdmisiT::model()->findByPk($model->pasienadmisi_id);
      }
    }

    if (!empty($pasien_id)) {
      $modPasien = PPPasienM::model()->findByPk($pasien_id);
    }

    if (isset($idSep)) {
      $modSepInhealthT = PPSepInhealthT::model()->findByPk($idSep);
      $model->is_bpjs = ($modSepInhealthT->is_inhealth) ? 0 : 1;
      if (isset($model->rujukan_id)) {
        $modRujukanInhealth = PPRujukanInhealthT::model()->findByPk($model->rujukan_id);
      }
      if (isset($model->asuransipasien_id)) {
        $modAsuransiPasienInhealth = PPAsuransipasieninhealthM::model()->findByPk($model->asuransipasien_id);
        $modJenisPeserta = JenispesertaM::model()->findByPk($modAsuransiPasienInhealth->jenispeserta_id);
        if (!empty($modJenisPeserta)) {
          $modAsuransiPasienInhealth->jenispeserta_nama = isset($modJenisPeserta->jenispeserta_nama) ? $modJenisPeserta->jenispeserta_nama : '-';
        }
        $modAsuransiPasienInhealth->kelastanggunganasuransi_nama = $modAsuransiPasienInhealth->kelastanggunganasuransi_id;
      }
    }

    if (isset($_POST['PPPendaftaranT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (isset($_POST['PPRujukanInhealthT'])) {
          $modRujukanInhealth = $this->simpanRujukanBpjs($modRujukanInhealth, $_POST['PPRujukanInhealthT']);
        } else {
          $this->rujukantersimpan = true;
        }

        if (isset($_POST['PPAsuransipasieninhealthM'])) {
          if (isset($_POST['PPAsuransipasieninhealthM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasieninhealthM']['asuransipasien_id'])) {
              $modAsuransiPasienInhealth = PPAsuransipasieninhealthM::model()->findByPk($_POST['PPAsuransipasieninhealthM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienInhealth = $this->simpanAsuransiPasien($modAsuransiPasienInhealth, $_POST['PPPendaftaranT'], $modPasien, $_POST['PPAsuransipasieninhealthM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPSepInhealthT'])) {

          $modSepInhealthT = $this->simpanSep($model, $modPasien, $modRujukanInhealth, $modAsuransiPasienInhealth, $_POST['PPSepInhealthT']);
          if ($modSepInhealthT) {
            $model = PPPendaftaranT::model()->findByPk($pendaftaran_id);
            $model->sep_id = $modSepInhealthT->sep_id;
            $model->rujukan_id = isset($modRujukanInhealth->rujukan_id) ? $modRujukanInhealth->rujukan_id : null;
            $model->asuransipasien_id = isset($modAsuransiPasienInhealth->asuransipasien_id) ? $modAsuransiPasienInhealth->asuransipasien_id : null;
            $model->save();
            PPSepInhealthT::model()->updateByPk($modSepInhealthT->sep_id, array('is_inhealth' => true));
          }
        }

        if ($this->rujukantersimpan && $this->asuransipasientersimpan) {
          $transaction->commit();
          if ($this->septersimpan) {
            $this->redirect(array('ProsesSJP', 'pendaftaran_id' => $model->pendaftaran_id, 'pasien_id' => $model->pasien_id, 'idSep' => $modSepInhealthT->sep_id, 'pelayanan' => $_GET['pelayanan'], 'sukses' => 1));
          } else {
            $this->redirect(array('ProsesSJP', 'pendaftaran_id' => $model->pendaftaran_id, 'pasien_id' => $model->pasien_id, 'pelayanan' => $_GET['pelayanan'], 'sukses' => 1));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data SJP gagal disimpan !");
        }
      } catch (Exception $ex) {
        echo $ex;
        exit;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data SEP gagal disimpan !" . $ex);
      }
    }

    $this->render('_formAsuransiInhealthSJP', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modRujukan' => $modRujukan,
      'modRujukanInhealth' => $modRujukanInhealth,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienInhealth' => $modAsuransiPasienInhealth,
      'modSepInhealthT' => $modSepInhealthT,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modAdmisi' => $modAdmisi,
      'pelayanan' => $_GET['pelayanan'],
    ));
  }

  /**
   * untuk menampilkan kabupaten dan kota untuk tempat lahir pasien
   */
  public function actionAutocompleteTempatLahir()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $tempat_lahir = isset($_GET['tempat_lahir']) ? $_GET['tempat_lahir'] : null;

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(kabupaten_nama)', strtolower($tempat_lahir), true);
      $criteria->addCondition('kabupaten_aktif IS TRUE');
      $criteria->order = 'kabupaten_nama';
      $criteria->limit = 10;
      $models = KabupatenM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = strtoupper($model->kabupaten_nama);
        $returnVal[$i]['value'] = strtoupper($model->kabupaten_nama);
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Set form dokter DPJP
   */
  public function actionSetFormDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $dokterList = $_POST['diagnosaList'];
      $form = '';
      $pesan = '';
      if (count((array)$dokterList) > 0) {
        foreach ($dokterList as $i => $dokter) {
          $kode = $dokter['kode'];
          $nama = $dokter['nama'];
          $form .= "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#PPSepT_nama_dpjp').val('" . $nama . "');$('#PPSepT_kode_dpjp').val('" . $kode . "');$('#dialogDpjp').dialog('close'); \">
                            <i class='icon-form-check'></i></a>
                        </td>
                        <td>
                            <span id='kdPoli' name=[ii][kdPoli]'>" . $kode . "</span>
                        </td>
                        <td>
                            <span id='nmPoli' name=[ii][nmPoli]'>" . $nama . "</span>
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

  /**
   * Set form suplesi
   */
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
          $form .= "<tr>
                        <td>
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#PPSepT_no_suplesi').val('" . $noSep . "');$('#dialogSuplesi').dialog('close'); \">
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

  /**
   * Set model antrian berdasarkan model antrian
   */
  public function actionSetModelAntrian()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $lokasi = $_POST['lokasi'];

      $dataList = array();

      $modelantrian_id = array();
      $modelAntrian = ModelantrianM::model()->findAll('lokasi_karcisantrian_id = ' . $lokasi . ' AND modelantrian_aktif = TRUE ORDER BY modelantrian_nama ASC');
      $modelAntrian = CHtml::listData($modelAntrian, 'modelantrian_id', 'modelantrian_nama');
      $dropdown = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($modelAntrian as $value => $name) {
        $dropdown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        $modelantrian_id[] = $value;
      }

      $dataList['listModelAntrian'] = $dropdown;

      $criteria = new CDbCriteria;
      $criteria->addInCondition('modelantrian_id', $modelantrian_id);
      $criteria->addCondition('loket_aktif IS TRUE');
      $criteria->order = "loket_nama ASC";
      $modelLoket = LoketM::model()->findAll($criteria);
      $modelLoket = CHtml::listData($modelLoket, 'loket_id', 'loket_nama');
      $dropdown1 = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($modelLoket as $value => $name) {
        $dropdown1 .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listLoketAntrian'] = $dropdown1;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * Set lokasi antrian berdasarkan model antrian
   */
  public function actionSetLoketAntrian()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modelantrian_id = $_POST['modelantrian_id'];

      $dataList = array();

      $criteria = new CDbCriteria();
      $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
      $criteria->addCondition("pendaftaran_id IS NULL");
      $criteria->addCondition("modelantrian_id = " . $modelantrian_id);
      $criteria->addCondition('update_loginpemakai_id IS NULL');
      $criteria->addCondition('jml_panggil IS NULL');
      $modAntrian = AntrianT::model()->findAll($criteria);

      $modelLoket = LoketM::model()->findAll('modelantrian_id = ' . $modelantrian_id . ' AND loket_aktif = TRUE ORDER BY loket_nama ASC');
      $modelLoket = CHtml::listData($modelLoket, 'loket_id', 'loket_nama');
      $dropdown = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($modelLoket as $value => $name) {
        $dropdown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listLoketAntrian'] = $dropdown;
      $dataList['sisaAntrian'] = count((array)$modAntrian);

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * Simpan data antrian pendaftaran
   */
  public function actionSetAntrianPendaftaran()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $dataList = array();
      $antrian_id = $_POST['antrian_id'];

      $modAntrian = AntrianT::model()->findByPk($antrian_id);

      if (isset($modAntrian->antrian_id) && !empty($modAntrian->antrian_id)) {

        $modModelAntrian = ModelantrianM::model()->findByPk($modAntrian->modelantrian_id);
        $dataList['pesan'] = 'OK';
        $dataList['lokasi_karcisantrian_id'] = $modModelAntrian->lokasi_karcisantrian_id;

        $modelAntrian = ModelantrianM::model()->findAll('lokasi_karcisantrian_id = ' . $modModelAntrian->lokasi_karcisantrian_id . ' AND modelantrian_aktif = TRUE ORDER BY modelantrian_nama ASC');
        $modelAntrian = CHtml::listData($modelAntrian, 'modelantrian_id', 'modelantrian_nama');
        $dropdown = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
        foreach ($modelAntrian as $value => $name) {
          if ($value == $modModelAntrian->modelantrian_id)
            $dropdown .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
          else
            $dropdown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }

        $dataList['listModelAntrian'] = $dropdown;

        $modelLoket = LoketM::model()->findAll('modelantrian_id = ' . $modModelAntrian->modelantrian_id . ' AND loket_aktif = TRUE ORDER BY loket_nama ASC');
        $modelLoket = CHtml::listData($modelLoket, 'loket_id', 'loket_nama');
        $dropdown = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
        foreach ($modelLoket as $value => $name) {
          if ($value == $modAntrian->loket_id)
            $dropdown .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
          else
            $dropdown .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }

        $dataList['listLoketAntrian'] = $dropdown;
      } else {
        $dataList['pesan'] = 'NOT';
      }

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * Set dropdown ruangan rawat inap
   * @param boolen $encode
   * @param string $model_nama
   * @param string $attr
   */
  public function actionSetDropdownRuanganRI($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = new PPPendaftaranT;
      $instalasi_id = isset($_POST['PPPasienAdmisiT']['instalasi_id']) ? $_POST['PPPasienAdmisiT']['instalasi_id'] : null;

      $ruangan = null;
      if (!empty($instalasi_id)) {
        $ruangan = $model->getRuanganRI($instalasi_id);
        $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
      }

      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($ruangan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($ruangan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Set dropdown ruangan rawat jalan
   * @param boolen $encode
   * @param string $model_nama
   * @param string $attr
   */
  public function actionSetDropdownRuanganRJ($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = new PPPendaftaranT;
      $instalasi_id = isset($_POST['PPPendaftaranT']['instalasi_id']) ? $_POST['PPPendaftaranT']['instalasi_id'] : null;

      $ruangan = null;
      if (!empty($instalasi_id)) {
        $ruangan = $model->getRuanganRJ($instalasi_id);
        $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
      }

      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($ruangan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($ruangan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * digunakan jika pasien tidak datang pada saat antrian
   * POST['antrian_id']
   */
  public function actionBatalPanggil()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $antrian_id = isset($_POST['antrian_id']) ? $_POST['antrian_id'] : null;

      $modAntrian = AntrianT::model()->findByPk($antrian_id);
      if (!empty($modAntrian)) {

        $modAntrian->isdatang = false;
        $modAntrian->update();
        if ($modAntrian) {
          $data['status'] = true;
          $data['pesan'] = 'Antrian Pasien Telah Dibatalkan!';
        }
      } else {
        $data['status'] = false;
        $data['pesan'] = 'Gagal!';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Pencarian / autocomplete diagnosa untuk inhealth
   * @param string $term
   * @param string $param
   */
  public function actionGetDiagnosaInhealth($term = "", $param = "")
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $returnVal = array();

      if ($param == "kode") {
        $criteria->compare('LOWER(diagnosa_kode)', strtolower($term), true);
      } elseif ($param == "nama") {
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($term), true);
      } elseif ($param == "lainnya") {
        $criteria->compare('LOWER(diagnosa_namalainnya)', strtolower($term), true);
      } elseif ($param == "mixed") {
        $criteria->addCondition(
          ""
            . "(lower(diagnosa_kode) ilike '%" . $term . "%' or "
            . "lower(diagnosa_nama) ilike '%" . $term . "%' or "
            . " lower(diagnosa_namalainnya) ilike '%" . $term . "%'"
            . ")"
        );
      }

      $criteria->order = 'diagnosa_kode, diagnosa_nama';
      $criteria->addCondition("diagnosa_aktif = true");
      $models = DiagnosaM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = ($model->diagnosa_kode . ' - ' . $model->diagnosa_nama);
        $returnVal[$i]['value'] = $model->diagnosa_nama;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
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

  public function actionGetRujukanDariBpjs(){
    if(Yii::app()->request->isAjaxRequest) {
        $kodeppk = $_POST['kodeppk'];
        $asarujukan = (isset($_POST['asarujukan'])?$_POST['asarujukan']:null);
        $data['rujukandari'] = "";
        $data['asalrujukan'] = "";

        $criteria = new CDbCriteria();

        if(!empty($asarujukan)){
            $criteria->addCondition('asalrujukan_id = '.$asarujukan);
        }
        $criteria->compare('kodeppk',$kodeppk,true);


        $model = RujukandariM::model()->find($criteria);

        if(isset($model)){
             $data['rujukandari'] = $model->rujukandari_id;
             $data['asalrujukan'] = $model->asalrujukan_id;

             $modRujukanDari = RujukandariM::model()->findAll('asalrujukan_id = '.$model->asalrujukan_id .' ORDER BY namaperujuk ASC');

             if(count((array)$modRujukanDari) > 0){
                 $option = "";
                 $dataRujukan = CHtml::listData($modRujukanDari,'rujukandari_id', 'namaperujuk');
                    foreach($dataRujukan as $value=>$name){
                            $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                    $data['datarujukandari'] = $option;
             }


        }
        echo json_encode($data);
        Yii::app()->end();
    }
  }
}

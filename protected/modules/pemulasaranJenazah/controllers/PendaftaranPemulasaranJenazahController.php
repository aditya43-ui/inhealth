<?php
//Yii::import('gizi.controllers.PendaftaranKonsultasiGiziController');
//Yii::import('gizi.models.GZPendaftaranT');
//Yii::import('gizi.models.GZPasienM');
//Yii::import('gizi.models.GZPenanggungJawabM');
//Yii::import('gizi.models.GZPasienMasukPenunjangT');
//Yii::import('gizi.models.GZRujukanT');
//Yii::import('gizi.models.GZTindakanpelayananT');
//Yii::import('gizi.models.GZTindakanKomponenT');
//Yii::import('gizi.models.GZTarifTindakanPerdaRuanganV');
//Yii::import('gizi.models.GZPasienMasukPenunjangV');
//Yii::import('gizi.models.GZKarcisV');
//class PendaftaranPemulasaranJenazahController extends PendaftaranKonsultasiGiziController
//{
//        /**
//         * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
//         * using two-column layout. See 'protected/views/layouts/column2.php'.
//         */
//        public $path_view = 'gizi.views.pendaftaranKonsultasiGizi.';
//        public $judul_form = 'Pendaftaran Pemulasaran Jenazah Dari Luar';
//}
Yii::import('radiologi.controllers.PendaftaranRadiologiController');
Yii::import('radiologi.models.ROPendaftaranT');
Yii::import('radiologi.models.ROPasienM');
Yii::import('radiologi.models.ROPenanggungJawabM');
Yii::import('radiologi.models.ROPasienmasukpenunjangT');
Yii::import('radiologi.models.RORujukanT');
Yii::import('radiologi.models.ROTindakanpelayananT');
Yii::import('radiologi.models.ROTindakanKomponenT');
Yii::import('radiologi.models.ROTarifpemeriksaanradruanganV');
Yii::import('radiologi.models.ROPasienMasukPenunjangV');
Yii::import('radiologi.models.ROKarcisV');
Yii::import('radiologi.models.ROHasilpemeriksaanradT');
Yii::import('radiologi.models.ROAsuransipasienM');
Yii::import('radiologi.models.ROPasienblacklistT');
Yii::import('radiologi.models.ROPemeriksaanRadM');
Yii::import('pendaftaranPenjadwalan.models.PPAsuransipasienbadakM');
class PendaftaranPemulasaranJenazahController extends PendaftaranRadiologiController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $path_view = 'radiologi.views.pendaftaranRadiologi.';
  public $path_view_jenazah = 'pemulasaranJenazah.views.pendaftaranPemulasaranJenazah.';
  public $judul_form = 'Pendaftaran Pemulasaran Jenazah Dari Luar';


  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pendaftaran Pemulasaran Jenazah";
    $format = new MyFormatter();
    $model = new ROPendaftaranT;
    $model->pendaftaran_id = null; //new record
    $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR; //new record
    $model->penjamin_id = Params::PENJAMIN_ID_UMUM; //new record
    $modPasien = new ROPasienM;
    $modPegawai = new PPPegawaiM;
    $modPenanggungJawab = new ROPenanggungJawabM;
    $modPasienMasukPenunjang = new ROPasienmasukpenunjangT;
    $modAsuransiPasien = new ROAsuransipasienM;
    $modAsuransiPasienDepartemen = new PPAsuransipasiendepartemenM();
    $modAsuransiPasienPekerja = new PPAsuransipasienpegawaiM();
    $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
    //            $modPasienMasukPenunjang->ruangan_id = Params::RUANGAN_ID_RAD;
    //            RSSP-1164            
    $modPasienMasukPenunjang->ruangan_id = Params::RUANGAN_ID_FORENSIK;
    $modPasienMasukPenunjang->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $modPemeriksaanRad = new ROTarifpemeriksaanradruanganV;
    $modRujukan = new RORujukanT;
    $modTindakan = new ROTindakanpelayananT;
    $modHasilPemeriksaan = new ROHasilpemeriksaanradT;
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
        $modPasienMasukPenunjang->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
      }

      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = ROPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
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

    if (isset($_POST['ROPendaftaranT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasien = $this->simpanPasien($modPasien, $_POST['ROPasienM']);
        if (isset($_POST['ROPenanggungJawabM']) && $_POST['ROPenanggungJawabM']['alamat_pj'] != "") {
          $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['ROPenanggungJawabM']);
        } else {
          $this->penanggungjawabtersimpan = true;
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
            foreach ($_POST['ROTindakanpelayananT'] as $ii => $tindakan) {
              $dataTindakans[$ii] = $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjang, $tindakan);
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
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

        /*
                    var_dump(
                            $this->pasientersimpan,
                            $this->pendaftarantersimpan,
                            $this->penanggungjawabtersimpan,
                            $this->rujukantersimpan,
                            $this->tindakanpelayanantersimpan,
                            $this->karcistersimpan,
                            $this->komponentindakantersimpan,
                            $this->pasienpenunjangtersimpan,
                            $this->hasilpemeriksaantersimpan,
                            $this->pengambilansampletersimpan
                            
                            ); die;
                     * 
                     */

        if ($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->tindakanpelayanantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->pasienpenunjangtersimpan && $this->hasilpemeriksaantersimpan && $this->pengambilansampletersimpan) {

//          if (!empty($model->pendaftaran_id)) {
//            $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id);
//            $model->update();
//          }
//          if (empty($_POST['ROPasienM']['pasien_id']) && $modPasien->pasien_id) {
//            $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
//            $modPasien->update();
//          }
          if (!empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
            $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
            $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
            $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
            $modPasienMasukPenunjang->update();
          }

          // SMS GATEWAY
          $sms = new Sms();
          $smspenanggungjawab = 1;
          $smsdokter = 1;

          $modPegawai = PegawaiM::model()->findByPk($model->pegawai_id);

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
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }

            $isiPesan = str_replace("{{ruangan_nama}}", Yii::app()->user->getState('ruangan_nama'), $isiPesan);
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tgl_pendaftaran), $isiPesan);
            $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

            // var_dump($smsgateway->tujuansms, $smsgateway->statussms, $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
              if (!empty($modPegawai->nomobile_pegawai)) {
                $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
              } else {
                $smsdokter = 0;
              }
            } else if ($smsgateway->tujuansms == Params::TUJUANSMS_PENANGGUNGJAWAB && $smsgateway->statussms) {
              if (!empty($modPenanggungJawab->no_mobilepj)) {
                $sms->kirim($modPenanggungJawab->no_mobilepj, $isiPesan);
              } else {
                $smspenanggungjawab = 0;
              }
            }
          }
          // END SMS GATEWAY
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Pasien " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . "  berhasil disimpan !");
          $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1, 'smspenanggungjawab' => $smspenanggungjawab, 'smsdokter' => $smsdokter));
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
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $this->render($this->path_view_jenazah.'index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modPemeriksaanRad' => $modPemeriksaanRad,
      'modRujukan' => $modRujukan,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
      'modKarcis' => $modKarcis,
      'modSmsgateway' => $modSmsgateway,
      'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
      'modAsuransiPasienDepartemen'  => $modAsuransiPasienDepartemen,
      'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja
    ));
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
    $modPasien->kelompokumur_id = isset($modPasien->tanggal_lahir) ? CustomFunction::getKelompokUmur($modPasien->tanggal_lahir) : null;
    if (isset($post['tempPhoto'])) {
      $modPasien->photopasien = $post['tempPhoto'];
    }
    if (empty($modPasien->pasien_id)) {
      $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
      $modPasien->profilrs_id = Params::getDefaultProfilRS();
      $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
      $modPasien->ispasienluar = false; //harus false karena jika true maka no rekam medik akan bentrok dengan RM RS
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPasien->create_loginpemakai_id = Yii::app()->user->id;
      $modPasien->create_time = date('Y-m-d H:i:s');
      //                RSSP-1117
      //                $modPasien->no_rekam_medik = MyGenerator::noRekamMedikPenunjang(Yii::app()->user->getState('mr_jenazah'));
      $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
    } else {
      $modPasien->update_loginpemakai_id = Yii::app()->user->id;
      $modPasien->update_time = date('Y-m-d H:i:s');
    }
    $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
    $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
    if ($modPasien->save()) {
      $this->pasientersimpan = true;
    }
    
    return $modPasien;
  }

  /**
   * proses simpan ROTindakanpelayananT dan ROTindakankomponenT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post)
  {
    $modTindakan = new ROTindakanpelayananT;

    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->attributes = $post;
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
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    if (isset($_POST['tgl_tindakan_semua'])) {
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

    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= true;
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintStatusJz($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    $modPasien = ROPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
    $criteria1 = new CdbCriteria();
    $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id ASC";
    $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_FORENSIC);
    $loadPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->find($criteria1);
    if (isset($loadPasienMasukPenunjang)) {
      $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
      $modTindakans = ROTindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_tot = new CdbCriteria();
      $criteria_tot->addCondition("karcis_id IS NULL");
      $criteria_tot->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjang->pasienmasukpenunjang_id);
      $daftartindakan = ROTindakanpelayananT::model()->findAll($criteria_tot);
    }

    $judul_print = 'Kunjungan Pemulasaran Jenazah';
    $this->render($this->path_view_jenazah.'printStatusJz', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'daftartindakan' => $daftartindakan,
    ));
  }

  /**
   * proses simpan / ubah data pendaftaran
   * @return type
   */
  public function simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $post, $postPasien, $postPenunjang, $modAsuransiPasien)
  {
    $format = new MyFormatter();
    $model->attributes = $post;
    $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $model->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $model->pendaftaran_id = null;
    $model->pasien_id = $modPasien->pasien_id;
    $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
    $model->rujukan_id = $modRujukan->rujukan_id;
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $model->ruangan_id = Params::RUANGAN_ID_FORENSIC; //Yii::app()->user->getState('ruangan_id');
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
    }
    return $model;
  }

  /**
   * set umur dari tanggal lahir (date)
   */
  public function actionSetUmur()
  {
    return PendaftaranRadiologiController::actionSetUmur();
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    return PendaftaranRadiologiController::actionSetDropdownPenjaminPasien($encode, $namaModel);
  }

  public function actionAutocompletePasienLama()
  {
    return PendaftaranRadiologiController::actionAutocompletePasienLama();
  }

  /**
   * Autocomplete Asuransi
   * @throws CHttpException
   */
  public function actionAutocompleteAsuransi()
  {
    return PendaftaranRadiologiController::actionAutocompleteAsuransi();
  }

  public function actionAutocompleteAsuransiKartu()
  {
    return PendaftaranRadiologiController::actionAutocompleteAsuransiKartu();
  }

  public function actionSetAsuransiPasienLama()
  {
    return PendaftaranRadiologiController::actionSetAsuransiPasienLama();
  }

  public function actionGetDataPasien()
  {
    return PendaftaranRadiologiController::actionGetDataPasien();
  }

  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    return PendaftaranRadiologiController::actionSetDropdownKabupaten($encode, $model_nama, $attr);
  }

  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    return PendaftaranRadiologiController::actionSetDropdownKecamatan($encode, $model_nama, $attr);
  }

  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    return PendaftaranRadiologiController::actionSetDropdownKelurahan($encode, $model_nama, $attr);
  }

  public function actionSetDropdownDaerahPasien()
  {
    return PendaftaranRadiologiController::actionSetDropdownDaerahPasien();
  }

  public function actionSetTanggalLahir()
  {
    return PendaftaranRadiologiController::actionSetTanggalLahir();
  }

  public function actionGetRujukanDari($encode = false, $namaModel = '')
  {
    return PendaftaranRadiologiController::actionGetRujukanDari($encode, $namaModel);
  }

  public function actionAutocompletePegawai()
  {
    return PendaftaranRadiologiController::actionAutocompletePegawai();
  }

  public function actionVerifikasi()
  {
    return PendaftaranRadiologiController::actionVerifikasi();
  }

  public function actionSetDropdownDokter()
  {
    return PendaftaranRadiologiController::actionSetDropdownDokter();
  }

  public function actionSetDropdownJeniskasuspenyakit()
  {
    return PendaftaranRadiologiController::actionSetDropdownJeniskasuspenyakit();
  }
}

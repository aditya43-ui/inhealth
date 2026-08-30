<?php
class PendaftaranRehabilitasiMedisController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'rehabMedis.views.pendaftaranRehabilitasiMedis.';

  public $pasientersimpan = false;
  public $pendaftarantersimpan = false;
  public $penanggungjawabtersimpan = false;
  public $tindakanpelayanantersimpan = true; //dilooping / boleh tanpa ini
  public $karcistersimpan = true; //dilooping / boleh tanpa ini
  public $komponentindakantersimpan = true; //di looping
  public $rujukantersimpan = false;
  public $pasienpenunjangtersimpan = true; //dilooping
  public $hasilpemeriksaantersimpan = true; //dilooping
  public $asuransipasientersimpan = false;

  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null, $pasienmasukpenunjang_id = null, $jadwalrehabmedis_id = null)
  {
    $format = new MyFormatter();
    $model = new RMPendaftaranT;
    $model->pendaftaran_id = null; //new record
    $modPasien = new RMPasienM;
    $modPegawai = new RMPegawaiM();
    $modAsuransiPasien = new RMAsuransipasienM;
    $modAsuransiPasienBpjs = new RMAsuransipasienbpjsM;
    $modPenanggungJawab = new RMPenanggungJawabM;
    $modPasienMasukPenunjang = new RMPasienmasukpenunjangT;
    $modPasienMasukPenunjang->ruangan_id = Params::RUANGAN_ID_REHABMEDIS;
    $modPasienMasukPenunjang->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    $modPemeriksaanRm = new RMTarifpemeriksaanrmruanganV;
    $modRujukan = new RMRujukanT;
    $modRujukanBpjs = new RMRujukanbpjsT;
    $modTindakan = new RMTindakanpelayananT;
    $modJenisTindakan = RMJenisTindakanrmM::model()->findAllByAttributes(array('jenistindakanrm_aktif' => true), array('order' => 'jenistindakanrm_nama'));
    $modTindakanRM = RMTindakanrmM::model()->findAllByAttributes(array('tindakanrm_aktif' => true), array('order' => 'tindakanrm_nama'));
    $modHasilPemeriksaan = new HasilpemeriksaanrmT;
    $modSep = new RMSepT;
    $dataTindakans = array();
    $modKarcis = array();

    $model->is_bpjs = 0;
    $modSep->politujuan = "IRM";


    $modSep->jenis_kunjungan = "0";
    $modSep->asesmen_pelayanan = "";

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

    if (!empty($jadwalrehabmedis_id)) {
      $jadwal = JadwalrehabmedisT::model()->findByPk($jadwalrehabmedis_id);

      $modPasien = RMPasienM::model()->findByPk($jadwal->pasien_id);
    }

    //Check if is bridging false or true
    $konfig = KonfigsystemK::model()->find();
    if ($konfig->isbridging == false) {
        $model->is_bpjs_manual = 1;
    }else{
        $model->is_bpjs_manual = 0;
    }

    //==load data
    if (isset($id)) {
      $model = $this->loadModel($id);
      $modPasien = RMPasienM::model()->findByPk($model->pasien_id);
      if (!empty($modPasien->pegawai_id)) {
        $modPegawai = RMPegawaiM::model()->findByPk($modPasien->pegawai_id);
      }
      $criteria = new CdbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $model->pendaftaran_id);
      $criteria->order = "pendaftaran_id DESC, pasienmasukpenunjang_id ASC";
      $criteria->limit = 2;
      $criteria1 = $criteria;
      $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_REHABMEDIS);
      $loadPasienMasukPenunjang = RMPasienmasukpenunjangT::model()->find($criteria1);
      if (isset($loadPasienMasukPenunjang)) {
        $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
        $modPasienMasukPenunjang->is_adakarcis = 1;
      }

      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = RMPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = RMRujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataKarcis = RMTindakanpelayananT::model()->findByAttributes(array('ruangan_id' => Params::RUANGAN_ID_REHABMEDIS, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      if (isset($dataKarcis->karcis_id)) {
        $modKarcis[0] =  RMKarcisV::model()->findByAttributes(array('karcis_id' => $dataKarcis->karcis_id));
        $modKarcis[0]->harga_tariftindakan = $dataKarcis->tarif_tindakan;
      }

      $dataTindakans = RMTindakanpelayananT::model()->findAllByAttributes(array('ruangan_id' => Params::RUANGAN_ID_REHABMEDIS, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is null");
    }

    if (isset($_POST['RMPendaftaranT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasien = $this->simpanPasien($modPasien, $_POST['RMPasienM']);

        if ($_POST['RMPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['RMPenanggungJawabM'])) {
            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['RMPenanggungJawabM']);
          }
        } else {
          $this->penanggungjawabtersimpan = true;
        }

        if ($_POST['RMPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['RMRujukanT'])) {
            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['RMRujukanT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        if ($_POST['RMPendaftaranT']['is_bpjs']) {
          if (isset($_POST['RMRujukanbpjsT'])) {
            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['RMRujukanbpjsT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        if (isset($_POST['RMAsuransipasienM'])) {
          if (isset($_POST['RMAsuransipasienM']['asuransipasien_id'])) {
            if (!empty($_POST['RMAsuransipasienM']['asuransipasien_id'])) {
              $modAsuransiPasien = RMAsuransipasienM::model()->findByPk($_POST['RMAsuransipasienM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['RMPendaftaranT'], $modPasien, $_POST['RMAsuransipasienM']);
        } else {
          $this->asuransipasientersimpan = true;
        }


        if (isset($_POST['RMAsuransipasienbpjsM'])) {
          if (isset($_POST['RMAsuransipasienbpjsM']['asuransipasien_id'])) {
            if (!empty($_POST['RMAsuransipasienbpjsM']['asuransipasien_id'])) {
              $modAsuransiPasienBpjs = RMAsuransipasienM::model()->findByPk($_POST['RMAsuransipasienbpjsM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $_POST['RMPendaftaranT'], $modPasien, $_POST['RMAsuransipasienbpjsM']);
        } else {
          $this->asuransipasientersimpan = true;
        }


        if ($_POST['RMPendaftaranT']['is_bpjs'] && isset($_POST['RMSepT'])) {
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanBpjs, $modPenanggungJawab, $_POST['RMPendaftaranT'], $_POST['RMPasienM'], $_POST['RMPasienmasukpenunjangT'], $modAsuransiPasienBpjs);
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['RMSepT']);
          //var_dump($modSep->attributes);
          $model->sep_id = $modSep->sep_id;
          $model->update();
        } else {
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['RMPendaftaranT'], $_POST['RMPasienM'], $_POST['RMPasienmasukpenunjangT'], $modAsuransiPasien);
        }


        if (!empty($jadwalrehabmedis_id)) {
          JadwalrehabmedisT::model()->updateByPk($jadwalrehabmedis_id, array(
            'pendaftaran_id' => $model->pendaftaran_id,
          ));
        }

        $postPenunjang = $_POST['RMPasienmasukpenunjangT'];
        $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $model, $postPenunjang);

        if (isset($_POST['RMTindakanpelayananT'])) {
          if (count((array)$_POST['RMTindakanpelayananT']) > 0) {
            foreach ($_POST['RMTindakanpelayananT'] as $ii => $tindakan) {
              $dataTindakans[$ii] = $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjang, $tindakan);
              $dataTindakans[$ii]->daftartindakan_id = $tindakan['daftartindakan_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $modHasilPemeriksaan = $this->simpanHasilPemeriksaan($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
            }
          }
        }
        // echo "<pre>";
        // print_r($_POST);exit;
        if ($postPenunjang['is_adakarcis']) {
          if (isset($_POST['RMKarcisV'])) {
            if (count((array)$_POST['RMKarcisV']) > 0) {
              foreach ($_POST['RMKarcisV'] as $ii => $karcis) {
                if ($karcis['is_pilihkarcis']) {
                  $modKarcis[$ii] = new RMKarcisV;
                  $modKarcis[$ii]->attributes = $karcis;
                  $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjang, $karcis);
                }
              }
            }
          }
        }
        
        $ok_vaksinasi = true;
        // var_dump($modKarcis[$ii]->attributes);die;

        if ($_POST['RMPendaftaranT']['is_vaksinasi'] && isset($_POST['RiwayatvaksinasipasienT']['detail'])) {
          $ok_vaksinasi = RiwayatvaksinasipasienT::simpanRiwayat($model->pendaftaran_id, $model->pasien_id, $_POST['RiwayatvaksinasipasienT']['detail']);
        }

        if (isset($_POST['scan'])) {
          $this->simpanScanPasien($model, $_POST['scan']);
        }

        if ($ok_vaksinasi && $this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->tindakanpelayanantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->pasienpenunjangtersimpan) {

          $this->broadcastNotifDaftarRehab($model, $modPasien);

          // SMS GATEWAY
          $modPegawai = $modPasienMasukPenunjang->pegawai;
          $modRuangan = $modPasienMasukPenunjang->ruangan;
          if (isset($model->penanggungjawab)) {
            $modPenanggungJawab = $model->penanggungjawab;
          }
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
            if (isset($model->penanggungjawab)) {
              $attributes = $modPenanggungJawab->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
            }
            $attributes = $modPegawai->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modPasienMasukPenunjang->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modRuangan->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPasienMasukPenunjang->tglmasukpenunjang), $isiPesan);
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

          if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] == 1) {
            $this->kirimWhatsApp($model, $modPasien);
          }
          //            die;

          // END SMS GATEWAY
          // echo "<pre>";
          // var_dump($transaction);die;
          $transaction->commit();
          // Yii::app()->user->setFlash('success', "Data pendaftaran berhasil disimpan !");
          $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab));
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



    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawai' => $modPegawai,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPemeriksaanRm' => $modPemeriksaanRm,
      'modRujukan' => $modRujukan,
      'modRujukanBpjs' => $modRujukanBpjs,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
      'modKarcis' => $modKarcis,
      'modJenisTindakan' => $modJenisTindakan,
      'modTindakanRM' => $modTindakanRM,
      'modHasilPemeriksaan' => $modHasilPemeriksaan,
      'modSmsgateway' => $modSmsgateway,
      'modSep' => $modSep,
    ));
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


  protected function broadcastNotifDaftarRehab($model, $modPasien)
  {
    $judul = "Pendaftaran langsung Pasien Rehabilitasi";
    $isi = $model->no_pendaftaran . " - " . $modPasien->no_rekam_medik . " - " . $modPasien->nama_pasien;

    $linkDaftarPasien = Yii::app()->createUrl('/rehabMedis/daftarPasien/index', array(
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
      array('instalasi_id' => Params::INSTALASI_ID_REHAB, 'ruangan_id' => Params::RUANGAN_ID_REHABMEDIS, 'modul_id' => Params::MODUL_ID_REHABMEDIS,  'link_proses' => $linkDaftarPasien), //, 'link_proses'=>$link_rj
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
      if (isset($_POST['RMPendaftaranT'])) {
        $format = new MyFormatter();
        $model = new RMPendaftaranT;
        $modPasien = new RMPasienM;
        $modPenanggungJawab = null;
        $modRujukan = null;
        $modTindakans = array();
        $modKarcis = array();

        $model->attributes = $_POST['RMPendaftaranT'];
        $modPasien->attributes = $_POST['RMPasienM'];
        if ($_POST['RMPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['RMPenanggungJawabM'])) {
            $modPenanggungJawab = new RMPenanggungJawabM;
            $modPenanggungJawab->attributes = $_POST['RMPenanggungJawabM'];
          }
        }

        if ($_POST['RMPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['RMRujukanT'])) {
            $modRujukan = new RMRujukanT;
            $modRujukan->attributes = $_POST['RMRujukanT'];
            $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
          }
        }

        $modPasienMasukPenunjang = new RMPasienmasukpenunjangT;
        $postPenunjang = $_POST['RMPasienmasukpenunjangT'];
        $modPasienMasukPenunjang->attributes = $postPenunjang;
        $modPasienMasukPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');
        if (isset($_POST['RMTindakanpelayananT'])) {
          if (count((array)$_POST['RMTindakanpelayananT']) > 0) {
            foreach ($_POST['RMTindakanpelayananT'] as $ii => $tindakan) {
              $modTindakans[$ii] = new RMTindakanpelayananT;
              $modTindakans[$ii]->attributes = $tindakan;
            }
          }
        }
        if ($postPenunjang['is_adakarcis']) {
          if (isset($_POST['RMKarcisV'])) {
            if (count((array)$_POST['RMKarcisV']) > 0) {
              foreach ($_POST['RMKarcisV'] as $ii => $karcis) {
                if ($karcis['is_pilihkarcis']) {
                  $modKarcis[$ii] = new RMKarcisV;
                  $modKarcis[$ii]->attributes = $karcis;
                }
              }
            }
          }
        }
      }

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
    $snrm = "";
    if (isset($post['pasien_id']) && (!empty($post['pasien_id']))) {
      $load = new $modPasien;
      $modPasien = $load->findByPk($post['pasien_id']);
      $snrm = $modPasien->no_rekam_medik;
    }

    $modPasien->attributes = $post;

    unset($modPasien->fingerprint_data);
    //var_dump($modPasien->fingerprint_data);die;
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
        if (isset($_POST['generateNoRM'])) {
          if (!empty($_POST['generateNoRM'])) {
            $modPasien->no_rekam_medik = MyGenerator::noRekamMedik('', 'FALSE', $_POST['generateNoRM']);
          }
        } else {
          $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
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

    $carabayar = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
    $penjamin = isset($postPendaftaran['penjamin_id'])?$postPendaftaran['penjamin_id']:null;

    $modAsuransiPasien->attributes = $postAsuransiPasien;
    $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id'])?$postPasien['pasien_id']:null;
    $modAsuransiPasien->penjamin_id = $penjamin;
    $modAsuransiPasien->carabayar_id = $carabayar;
    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
    $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
    $modAsuransiPasien->hubkeluarga = isset($postAsuransiPasien['hubkeluarga'])?$postAsuransiPasien['hubkeluarga']:'';
    $modAsuransiPasien->nominal_tanggungan = isset($postAsuransiPasien['nominal_tanggungan'])?$postAsuransiPasien['nominal_tanggungan']:0;
    

    if ($carabayar == Params::CARABAYAR_ID_BPJS) {
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
    
    $modAsuransiPasien->nominal_tanggungan = !is_numeric($modAsuransiPasien->nominal_tanggungan) ? str_replace(",", "", $modAsuransiPasien->nominal_tanggungan) : $modAsuransiPasien->nominal_tanggungan;
    

    // var_dump($modAsuransiPasien->attributes);
    // die;

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
    if (empty($model->ruangan_id)) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }
    $model->instalasi_id = (isset($model->ruangan_id) ? RuanganM::model()->findByPk($model->ruangan_id)->instalasi_id : null);
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
   * Fungsi untuk menyimpan data ke model RMPasienmasukpenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return RMPasienmasukpenunjangT 
   */
  public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $post)
  {
    $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
    $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
    $modPasienMasukPenunjang->attributes = $post;
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
    $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');
    $modPasienMasukPenunjang->dpjp_id  = $modPasienMasukPenunjang->perawatPJP->dpjp_id ?? "";
    $modPasienMasukPenunjang->statusperiksa  = Params::STATUSPERIKSA_ANTRIAN;

    if (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)) {
      $kirim = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
      $modPasienMasukPenunjang->ruanganasal_id = $kirim->create_ruangan;
    }

    if(isset($post['tindakanterapi_rehab'])) {
      $tindakanRehab = implode(',', $post['tindakanterapi_rehab']);
      $modPasienMasukPenunjang->tindakanterapi_rehab = $tindakanRehab;
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
   * proses simpan RMTindakanpelayananT dan RMTindakanKomponenT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post)
  {
    
    $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

    if(!empty($md_noawal)) {
      $noawal = intval($md_noawal->nopelayanan);
    } else {
      $noawal = 1;
    }

    $modTindakan = new RMTindakanpelayananT;
    $format = new MyFormatter();
    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->attributes = $post;
    $modTindakan->pasienadmisi_id = $modPendaftaran->pasienadmisi_id ?? null;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = (!empty($post['tarif_satuan'])?$post['tarif_satuan'] : $modTindakan->getTarifSatuan()); //RND-7248
    
    $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
    if (!empty($modTindakan->karcis_id)) {
      $this->karcistersimpan = true;
      if (isset($post['harga_tariftindakan'])) { //jika dari form karcis
        if (!empty($post['harga_tariftindakan'])) {
          $modTindakan->tarif_satuan = MyFormatter::formatNumberForDb($post['harga_tariftindakan']);
        }
      }
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
    $modTindakan->ppds_id = isset($modPasienMasukPenunjang->ppds_id) ? $modPasienMasukPenunjang->ppds_id : "" ;
    if (isset($_POST['tgl_tindakan_semua'])) {
      $modTindakan->tgl_tindakan = $format->formatDateTimeForDb($_POST['tgl_tindakan_semua']);
    }
    $modTindakan->tgl_tindakan = (empty($modTindakan->tgl_tindakan) ? date("Y-m-d H:i:s") : $modTindakan->tgl_tindakan);
    
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    // var_dump($modTindakan->tarif_tindakan);die;
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

    $modTindakan->nopelayanan = str_pad($noawal+1,3,"0",STR_PAD_LEFT);

    if ($modTindakan->validate()) {
      $modTindakan->save();
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }
    
    return $modTindakan;
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
      $criteria->addCondition('daftartindakan_id =' . $tindakan_id);
    }
    if (!empty($modPendaftaran->carabayar_id)) {
      $criteria->addCondition('tipepaket.carabayar_id =' . $modPendaftaran->carabayar_id);
    }
    if (!empty($modPendaftaran->penjamin_id)) {
      $criteria->addCondition('tipepaket.penjamin_id =' . $modPendaftaran->penjamin_id);
    }
    if (!empty($modPendaftaran->kelaspelayanan_id)) {
      $criteria->addCondition('tipepaket.kelaspelayanan_id =' . $modPendaftaran->kelaspelayanan_id);
    }
    $paket = PaketpelayananM::model()->find($criteria);
    $result = Params::TIPEPAKET_ID_NONPAKET;
    if (isset($paket)) $result = $paket->tipepaket_id;

    return $result;
  }


  /**
   * Set Tanggal, Wilayah, dan Jenis Kelamin berdasarkan No KTP
   */
  public function actionInputDariNoKTP()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $no_ktp = $_POST['no_ktp'];
    $str_lens = strlen($no_ktp);

    $res = array(
      'propinsi_id' => null,
      'kabupaten_id' => null,
      'kecamatan_id' => null,
      'tanggal_lahir' => null,
      'tanggal_lahir_format' => null,
      'jeniskelamin' => '',
    );

    if ($str_lens >= 2) {
      $prop = PropinsiM::model()->findByAttributes(array(
        'kode_propinsi' => substr($no_ktp, 0, 2),
      ));

      if (!empty($prop)) {
        $res['propinsi_id'] = $prop->propinsi_id;

        if ($str_lens >= 4) {
          $kab = KabupatenM::model()->findByAttributes(array(
            'propinsi_id' => $prop->propinsi_id,
            'kode_kabupaten' => substr($no_ktp, 2, 2),
          ));

          if (!empty($kab)) {
            $res['kabupaten_id'] = $kab->kabupaten_id;

            if ($str_lens >= 6) {
              $kec = KecamatanM::model()->findByAttributes(array(
                'kabupaten_id' => $kab->kabupaten_id,
                'kode_kecamatan' => substr($no_ktp, 4, 2),
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

      $thn_min = "19" . $thn;
      $thn_max = "20" . $thn;
      $thn_real = $thn_max;

      if (($thn_real) > (date('Y') - 16)) {
        $thn_real = $thn_min;
      }

      $bln = ((int)$bln > 12) ? "01" : $bln;

      $hari_limit = date('t', strtotime($thn_real . "-" . $bln . "-01"));
      $tgl = ($tgl > $hari_limit) ? "01" : $tgl;


      $res['tanggal_lahir'] = $thn_real . "-" . $bln . "-" . $tgl;
      $res['tanggal_lahir_format'] = $tgl . "/" . $bln . "/" . $thn_real;

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
   * set dropdown dokter
   */
  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new RMPendaftaranT;
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
      $model = new RMPendaftaranT;
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
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif' => true, 'carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
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
        $criteria->addCondition('ruangan_id =' . $ruangan_id);
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
        $criteria->addCondition('ruangan_id =' . $ruangan_id);
        $criteria->addCondition('pegawai_id =' . $pegawai_id);
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
      $modKarcisAll = RMKarcisV::model()->findAll($criteria);

      if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
        $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
      }
      $modKarcis = RMKarcisV::model()->findAll($criteria);

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
      $modPasien = new RMPasienM;
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
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->compare('tanggal_lahir', $tanggal_lahir);
      $criteria->compare('ispasienluar', false);
      $criteria->limit = 5;
      $models = PasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
        $returnVal[$i]['value'] = $model->no_rekam_medik;
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
      $criteria->limit = 5;
      $models = RMAsuransipasienM::model()->findAll($criteria);
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
      $criteria->limit = 5;
      $models = RMAsuransipasienM::model()->findAll($criteria);
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
      if (!empty($model)) {
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
      } else {
        $data = null;
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
        $criteria->addCondition('pasien_id =' . $pasien_id);
      }
      $criteria->compare('no_rekam_medik', $no_rekam_medik);
      $model = PasienM::model()->find($criteria);
      $peg = new PegawaiM;
      if (!empty($model->pegawai_id)) {
        $peg = PegawaiM::model()->findByPk($model->pegawai_id);
      }
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }

      $returnVal['nomorindukpegawai'] = $peg->nomorindukpegawai;
      $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
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
      $modPasien = new RMPasienM;
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
      $modPasien = new RMPasienM;
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
      $modPasien = new RMPasienM;
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

      $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
      $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
      $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($propinsis as $value => $name) {
        if ($value == $propinsi_id)
          $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      if (empty($propinsi_id)) {
        $kabupatens = array();
      } else {
        $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
        //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
        $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
      }

      $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kabupatens as $value => $name) {
        if ($value == $kabupaten_id)
          $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }


      if (empty($kabupaten_id)) {
        $kecamatans = array();
      } else {
        $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
        //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
        $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
      }
      $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kecamatans as $value => $name) {
        if ($value == $kecamatan_id)
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      if (empty($kecamatan_id)) {
        $kelurahans = array();
      } else {
        $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
        $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
      }

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
    $model =  RMPendaftaranT::model()->findByPk($id);
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
   * set checklist pemeriksaan rehab medis
   */
  public function actionSetChecklistPemeriksaanRehab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPemeriksaan = $post['RMTarifpemeriksaanrmruanganV'];

      if (isset($post['RMPasienmasukpenunjangT'])) {
        $postMasukPenunjang = $post['RMPasienmasukpenunjangT'];
        $ruangan_id = $postMasukPenunjang['ruangan_id'];
      } else {
        $ruangan_id = $postPemeriksaan['ruangan_id'];
      }

      if (!empty($ruangan_id) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
        $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        if (!empty($modJenisTarif)) {
          $jenistarif_id = $modJenisTarif->jenistarif_id;
        }
        $criteria = new CdbCriteria();
        $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
        $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        if (!empty($jenistarif_id)) {
          $criteria->addCondition('jenistarif_id = ' . $jenistarif_id);
        }
        $criteria->compare('LOWER(tindakanrm_nama)', strtolower($postPemeriksaan['tindakanrm_nama']), true);
        $criteria->compare('LOWER(jenistindakanrm_nama)', strtolower($postPemeriksaan['jenistindakanrm_nama']), true);
        $criteria->order = "jenistindakanrm_nama, tindakanrm_nama";

        $modPemeriksaanRehabMediss = RMTarifpemeriksaanrmruanganV::model()->findAll($criteria);
        $content = $this->renderPartial('rehabMedis.views.pendaftaranRehabilitasiMedis._checklistPemeriksaanRehabMedis', array('modPemeriksaanRehabMediss' => $modPemeriksaanRehabMediss), true);
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
  public function actionPrintKlaim($pendaftaran_id) {
    $this->layout = '//layouts/printWindows';

    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    // var_dump($modPendaftaran->carabayar_id)
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
    $modPenanggungjawab=PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    $modPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
    // echo "<pre>";
    // var_dump($modPegawai);die;

    $judulLaporan = '';
    // var_dump($_REQUEST);die;

    // $caraPrint = $_REQUEST['caraPrint'];
    // if ($caraPrint == 'PRINT') {
    //     $this->layout = '//layouts/printWindows';
    // }
    $this->render($this->path_view . 'printKlaim', array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modAsuransi'   => $modAsuransi,
        'modPenanggungjawab' => $modPenanggungjawab,
        'format'=>$format,
        'modPegawai' => $modPegawai,

        //'model' => $model,
        'judulLaporan' => $judulLaporan,
        //'caraPrint' => $caraPrint
    ));
}
  public function actionPrintStatusRehabMedis($pendaftaran_id, $pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    $modPasien = RMPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
  
    $loadPasienMasukPenunjang = RMPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
    // echo '<pre>';
    // var_dump($loadPasienMasukPenunjang);die;
    if (isset($loadPasienMasukPenunjang)) {
      $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
      $modTindakans = RMTindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

    }

    $judul_print = 'Kunjungan Rehab Medis';
    $this->render($this->path_view . 'print', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
    //  'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
   //   'daftartindakan' => $daftartindakan,
    ));
  }

  public function actionPrintStatusTindakan($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    $modPasien = RMPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
    $criteria1 = new CdbCriteria();
    $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    // $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_REHABMEDIS);
    $loadPasienMasukPenunjang = RMPasienmasukpenunjangT::model()->find($criteria1);
    // echo '<pre>';
    // var_dump($loadPasienMasukPenunjang);die;
    if (isset($loadPasienMasukPenunjang)) {
      $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
      $modTindakans = RMTindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_tot = new CdbCriteria();
      $criteria_tot->addCondition("karcis_id IS NULL");
      $criteria_tot->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjang->pasienmasukpenunjang_id);
      $daftartindakan = RMTindakanpelayananT::model()->findAll($criteria_tot);
    }

    $judul_print = 'Kunjungan Ruang Tindakan';
    $this->render($this->path_view . 'printStatusTindakan', array(
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
   * simpan RMHasilpemeriksaanrmT
   */
  public function simpanHasilPemeriksaan($modPasienMasukPenunjang, $modTindakan, $post)
  {
    $modHasilPemeriksaan = new HasilpemeriksaanrmT;
    $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
    $modHasilPemeriksaan->jenistindakanrm_id = isset($post['jenistindakanrm_id']) ? $post['jenistindakanrm_id'] : "";
    $modHasilPemeriksaan->tindakanrm_id = isset($post['tindakanrm_id']) ? $post['tindakanrm_id'] : "";
    $modHasilPemeriksaan->tglpemeriksaanrm = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaan->kunjunganke = 1; //di default untuk kunjungan pertama
    $modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
    $modHasilPemeriksaan->nohasilrm = MyGenerator::noHasilPemeriksaanRM();

    if ($modHasilPemeriksaan->validate()) {
      $modHasilPemeriksaan->save();
      $modTindakan->hasilpemeriksaanrm_id = $modHasilPemeriksaan->hasilpemeriksaanrm_id;
      $modTindakan->save();
    } else {
      $this->hasilpemeriksaantersimpan = false;
    }
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
   * proses simpan data rujukan
   * @param type $modRujukan
   * @param type $post
   * @return type
   */
  public function simpanRujukanBpjs($modRujukanBpjs, $post)
  {
    $format = new MyFormatter();
    $modRujukanBpjs->attributes = $post;
    $modRujukanBpjs->asalrujukan_id = (isset($post['asalrujukan_id']) ? $post['asalrujukan_id'] : 4);
    $modRujukandari = RujukandariM::model()->findByAttributes(array('asalrujukan_id' => $modRujukanBpjs->asalrujukan_id));
    $modRujukanBpjs->rujukandari_id = (isset($modRujukandari) ? $modRujukandari->rujukandari_id : null);
    $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan']) > 0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
    $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan']) > 0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
    $modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);

    if ($modRujukanBpjs->save()) {
      $this->rujukantersimpan = true;
    }

    return $modRujukanBpjs;
  }

  public function simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $postSep, $isRI = false)
  {
    $reqSep = null;
    $modSep = new RMSepT;
    $modSep->attributes = $postSep;

    $bpjs = new BpjsVklaim();
    $kelas = KelaspelayananM::model()->findByPk($modAsuransiPasienBpjs->kelastanggunganasuransi_id);

    // var_dump($kelas->attributes);
    // die;

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

    $modSep->penanggungjwb_naikkls_id = null;

    // var_dump($modSep->attributes);
    // die;
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
    return $modSep;
  }

  function logBpjs($model, $reqSep)
  {
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

    // var_dump($log->attributes, $reqSep); die;

    $log->save();
  }

  function flashBpjs($id)
  {
    $log = BpjslogR::model()->findByAttributes(array(
      'pendaftaran_id' => $id,
    ));
    $template = '<div class="alert alert-block alert-{key}{class}"><a class="close" data-dismiss="alert">&times;</a>{message}</div>';
    if (!empty($log) && $log->code != 200) {
      echo strtr($template, array(
        '{class}' => '',
        '{key}' => 'error',
        '{message}' => 'BPJS Error ' . $log->code . ': ' . $log->pesan,
      ));
      // Yii::app()->user->setFlash('error', 'BPJS Error '.$log->code.': '.$log->pesan);
    }
  }

  /**
   * @param type $sep_id
   */
  public function actionPrintSep($sep_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modRujukanBpjs = new RMRujukanbpjsT;
    $modSep = RMSepT::model()->findByPk($sep_id);
    $modSep->print_ke++;
    $modSep->update(array('print_ke'));
    $bpjs = new Bpjs();
    $modAsuransiPasienBpjs = RMAsuransipasienbpjsM::model()->findByAttributes(array('nopeserta' => $modSep->nokartuasuransi));
    $modJenisPeserta = RMJenisPesertaM::model()->findByPk($modAsuransiPasienBpjs->jenispeserta_id);
    if (isset($modSep->norujukan)) {
      $modRujukanBpjs = RMRujukanbpjsT::model()->findByAttributes(array('no_rujukan' => $modSep->norujukan));
    }
    $modPendaftaran = RMPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RMPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRujukan = RujukanT::model()->findByPk($modPendaftaran->rujukan_id);


    $judul_print = 'SURAT ELIGIBILITAS PESERTA';
    $this->render('pendaftaranPenjadwalan.views.pendaftaranRawatJalan.printSep_baru', array(
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
                            <a class='btn-small' href='javascript:void(0);' onclick=\" $('#RMSepT_nama_dpjp').val('" . $nama . "');$('#RMSepT_kode_dpjp').val('" . $kode . "');$('#dialogDpjp').dialog('close'); \">
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
   * load ppk rujukan
   */
  public function actionGetPPKRujukan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_POST['rujukan_id'])) {
        $rujukan = RujukandariM::model()->findByPk($_POST['rujukan_id']);
        echo $rujukan->ppkrujukan;
      } else {
        echo "";
      }
    }
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
          print_r($bpjs->search_kartu($query));
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

  public function actionSetFormDokterMelayani()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $dokterList = $_POST['diagnosaList'];
      $form = '';
      $pesan = '';
      if (count($dokterList) > 0) {
        foreach ($dokterList as $i => $dokter) {
          $kode = $dokter['kode'];
          $nama = $dokter['nama'];
          $form .= "<tr>
                    <td>
                        <a class='btn-small' href='javascript:void(0);' onclick=\" $('#RMSepT_dpjpygmelayani_nama').val('" . $nama . "');$('#RMSepT_dpjpygmelayani_kode').val('" . $kode . "');$('#dialogDpjpMelayani').dialog('close'); \">
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

  public function actionGetRuanganSpesialisBPJS()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $r = RuanganM::model()->findByPk($_POST['ruangan_id']);
    $ok = 1;
    $kode = "";

    if (empty($r) || empty($r->kode_bpjs)) {
      $ok = 0;
    } else {
      $kode = $r->kode_bpjs;
    }

    echo CJSON::encode(array(
      'ok' => $ok,
      'kode' => $kode,
    ));
  }

  public function actionCekPasienBerdasarkanNoAsuransi() {
    if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
    }
    
    $nomor = $_POST['nomor'];
    
    $asuransi = AsuransipasienM::model()->findByAttributes(array(
        'nopeserta'=>$nomor,
    ));
    
    $ok = 0;
    $pasien_id = null;
    $no_rekam_medik = null;
    
    if (!empty($asuransi)) {
        $pasien_id = $asuransi->pasien_id;
        $no_rekam_medik = $asuransi->pasien->no_rekam_medik;
        $ok = 1;
    }
    
    echo CJSON::encode(array(
        'ok'=>$ok,
        'pasien_id'=>$pasien_id,
        'no_rekam_medik'=>$no_rekam_medik,
    ));
  }

  public function actionCekRuanganBerdasarkanPoliBPJS() {
    if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
    }
    
    $kode_ruangan = $_POST['kode_ruangan'];
    
    $ruangan = RuanganM::model()->findByAttributes(array(
        'kode_bpjs'=>$kode_ruangan,
    ));
    
    $ok = 0;
    $ruangan_id = null;
    
    if (!empty($ruangan)) {
        $ok = 1;
        $ruangan_id = $ruangan->ruangan_id;
    }
    
    echo CJSON::encode(array(
        'ok'=>$ok,
        'ruangan_id'=>$ruangan_id,
    ));
  }

  public function actionCekPasienDariJenisNomor() {
    if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
    }
    
    $jenis = $_POST['jenis'];
    $nomor = $_POST['nomor'];
    
    $cr = new CDbCriteria();
    $cr->join = 'left join pegawai_m p on p.pegawai_id = t.pegawai_id';
    $cr->addCondition('pegawai_aktif = true');
    
    if ($jenis == "nip") {
        $cr->compare('lower(p.nomorindukpegawai)', strtolower($nomor));
    }
    
    $pasien = PasienM::model()->find($cr);
    
    $cr2 = new CDbCriteria();
    $cr2->addCondition('t.pegawai_aktif = true');
    if ($jenis == "nip") {
        $cr2->compare('lower(t.nomorindukpegawai)', strtolower($nomor));
    }
    
    $peg = PegawaiM::model()->find($cr2);
    
    $ok = 0;
    $ok_pasien = 0;
    $pasien_id = null;
    $pegawai_id = null;
    $pegawai_data = array();
    $no_rekam_medik = null;
    
    
    if (!empty($peg)) {
        $ok = 1;
        $pegawai_id = $peg->pegawai_id;
        $pegawai_data = $peg->attributes;
        
        if (!empty($pasien)) {
            $ok_pasien = 1;
            $pasien_id = $pasien->pasien_id;
            $no_rekam_medik = $pasien->no_rekam_medik;
        }
    }
    
    
    echo CJSON::encode(array(
        'ok'=>$ok,
        'pegawai_id'=>$pegawai_id,
        'pegawai_data'=>$pegawai_data,
        'ok_pasien'=>$ok_pasien,
        'pasien_id'=>$pasien_id,
        'no_rekam_medik'=>$no_rekam_medik,
    ));
    
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
                    'condition' => 'pasienbatalperiksa_id is not null And penanggungjawab_id is not null'
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
                    $returnValPP['tgllahir_pj'] = $penanggungJP->tgllahir_pj;
                    $returnValPP['alamat_pj'] = $penanggungJP->alamat_pj;
                } else {
                    $returnValPP = null;
                }
            }
            echo CJSON::encode($returnValPP);
            Yii::app()->end();
        }
    }

    public function actionPrintKlaim2($pendaftaran_id) {
      $this->layout = '//layouts/printWindows';

      $format = new MyFormatter;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      // var_dump($modPendaftaran->carabayar_id)
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
      $modPenanggungjawab=PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
      $modPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
      $modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
      // echo "<pre>";
      // var_dump($modPegawai);die;

      $judulLaporan = '';
      // var_dump($_REQUEST);die;

      // $caraPrint = $_REQUEST['caraPrint'];
      // if ($caraPrint == 'PRINT') {
      //     $this->layout = '//layouts/printWindows';
      // }
      $this->render($this->path_view . 'printKlaim2', array(
          'modPendaftaran' => $modPendaftaran,
          'modPasien' => $modPasien,
          'modAsuransi'   => $modAsuransi,
          'modPenanggungjawab' => $modPenanggungjawab,
          'format'=>$format,
          'modPegawai' => $modPegawai,
          'modPenjamin'=> $modPenjamin,

          //'model' => $model,
          'judulLaporan' => $judulLaporan,
          //'caraPrint' => $caraPrint
      ));
  }

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

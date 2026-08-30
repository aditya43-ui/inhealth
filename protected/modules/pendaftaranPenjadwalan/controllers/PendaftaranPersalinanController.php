<?php
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatDaruratController');
class PendaftaranPersalinanController extends PendaftaranRawatDaruratController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public $kecelakaantersimpan = false;
  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pendaftaran Vk";
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
    $modSep = new PPSepT;
    $dataTindakans = array();
    $modKarcisV = array();
    $modPasien->jeniskelamin = Params::JENIS_KELAMIN_PEREMPUAN;
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
    $model->ruangan_id = Params::RUANGAN_ID_VK;

    //Check if is bridging false or true
    $konfig = KonfigsystemK::model()->find();
    if ($konfig->isbridging == false) {
        $model->is_bpjs_manual = 1;
    }else{
        $model->is_bpjs_manual = 0;
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

    // LNG-1578 untuk notif pemberitahuan sbelum simpan, jika pasien yang sudah terdaftar	201410001
    $criteria = new CDbCriteria;
    $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
    $criteria->order = 'tgl_pendaftaran DESC';
    $criteria->addCondition('konsulpoli_id is null');
    $criteria->limit = 10;
    $modPasienTerakhir = InfokunjunganpersalinanV::model()->findAll($criteria);

    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;

    //==load data
    if (isset($id)) {
      $model = $this->loadModel($id);
      if (isset($idSep)) {
        $model->is_bpjs = 1;
        $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($model->rujukan_id);
        $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($model->asuransipasien_id);
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
        if ($_POST['PPPendaftaranT']['is_bpjs']) {
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukanBpjs, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasienBpjs);
          $modSep = $this->simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
          $model->sep_id = $modSep->sep_id;
          $model->update();
        } else {
          $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['PPPendaftaranT'], $_POST['PPPasienM'], $modAsuransiPasien);
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

        $ok_vaksinasi = true;
        if ($_POST['PPPendaftaranT']['is_vaksinasi'] && isset($_POST['RiwayatvaksinasipasienT']['detail'])) {
            $ok_vaksinasi = RiwayatvaksinasipasienT::simpanRiwayat($model->pendaftaran_id, $model->pasien_id, $_POST['RiwayatvaksinasipasienT']['detail']);
        }
        
        // paket
        if (isset($_POST['paket_medis'])) {
            $this->simpanTindakanObatPaket($model, $_POST['paket_medis']);
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
          //array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
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
        
        if ($this->is_simpanpaket && $ok_vaksinasi && $this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan) {
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
          // END SMS GATEWAY
          $transaction->commit();
          if ($modPasien->is_random) {
            $modPasien->generateNoRMDanSimpan();
          }
          $model->generateNoPendaftaranDanSimpan();
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
          //						echo "-".$this->pasientersimpan."<br>";
          //                        echo "-".$this->pendaftarantersimpan."<br>";
          //                        echo "-".$this->penanggungjawabtersimpan."<br>";
          //                        echo "-".$this->rujukantersimpan."<br>";
          //                        echo "-".$this->karcistersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        exit;
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
        $modKecelakaan = null;

        $model->attributes = $_POST['PPPendaftaranT'];
        $model->keterangan_pendaftaran = $_POST['PPPendaftaranT']['keterangan_pendaftaran'];
        $modPasien->attributes = $_POST['PPPasienM'];
        $modPasien->nama_bin=$_POST['PPPasienM']['nama_bin'];
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
                  $modTindakan[$i]->tarif_satuan = str_replace(',','',$karcis['tarif_satuan']);
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
            $ok = 0;
            $msg = "Maaf, Karcis tidak ditemukan";
          }
        } else {
          $ok = 0;
          $msg = "Maaf, Karcis tidak ditemukan";
        }
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
          'modKecelakaan' => $modKecelakaan,
          'format' => $format,
        ), true)
      ));
      exit;
    }
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
}

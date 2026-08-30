<?php 
class TransaksiPermintaanDarahDariPelayananController extends MyAuthController
{
    public $path_view_pendaftaran = 'rehabMedis.views.pendaftaranRehabilitasiMedis.';
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

    public function actionIndex($pasienkirimkeunitlain_id = null, $id = null, $pasienmasukpenunjang_id = null, $jadwalrehabmedis_id = null, $pendaftaran_id = null)
    {
        if(Yii::app()->request->isAjaxRequest) {
          if(isset($_GET['ajax']) && $_GET['ajax'] == 'giladiagnosa-m-grid2') {
              $this->renderPartial('_daftarTindakanPaket');
              Yii::app()->end();
          }
          if(isset($_GET['ajax']) && $_GET['ajax'] == 'datakunjungan-grid') {
              $this->renderPartial('_dialogKunjungan');
              Yii::app()->end();
          }
        }
        
        $format = new MyFormatter();
        $modKunjungan = new BDPasienKirimKeUnitLainV;
        $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modPemeriksaanRm = new TarifpemeriksaanrmruanganV;
        $modPasienMasukPenunjang = new BDPasienmasukpenunjangT;
        $modPasienMasukPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');
        // $modPasienMasukPenunjang->pegawai_id = Yii::app()->user->getState('pegawai_id');
        // $modPasienMasukPenunjang->pegawai_nama = Yii::app()->user->getState('nama_pegawai');
        $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
        $modTindakan = new TindakanpelayananT;
        $modTindakan->tgl_tindakan = $format->formatDateTimeForUser(date('Y-m-d H:i:s'));
        $dataTindakans = array();

        $modPendaftaran = new PendaftaranT();
        
        $modKirim = new PasienkirimkeunitlainT;
        
        if(!empty($pasienkirimkeunitlain_id)) {
            $modKirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
        }

        
        $rowPermintaan = [];

        if(!empty($modKirim)) {
          $rowPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);
        }
        // echo '<pre>';var_dump($rowPermintaan);die;
        if(!empty($pendaftaran_id)) {
          $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
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
        
        if (isset($_GET['pasienkirimkeunitlain_id'])) {
            $modKunjungan = BDPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_GET['pasienkirimkeunitlain_id']));

            $permintaanKepenunjang = PermintaankepenunjangT::model()->findByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);

          
            if(!empty($modKunjungan)) {
              $modKunjungan->kadarhb = $permintaanKepenunjang->kadarhb ?? '';
              $modKunjungan->plt = $permintaanKepenunjang->plt ?? '';
              $modKunjungan->jenis_permintaan = $modKirim->jenis_permintaan ?? '';
              $modKunjungan->nama_pegawai = $modKunjungan->gelardepan . ' ' . $modKunjungan->nama_pegawai . ' ' . $modKunjungan->gelarbelakang_nama;

              $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $modKunjungan->pasienkirimkeunitlain_id;
              $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modKunjungan->jeniskasuspenyakit_id;
              $modPasienMasukPenunjang->kelaspelayanan_id = $modKunjungan->kelaspelayanan_id;
            }
            
            // echo '<pre>';
            // var_dump($modKunjungan);die;
        }

        if (!empty($pasienmasukpenunjang_id)) {
            $modPasienMasukPenunjang = BDPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
            $loadModKunjungan = BDPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
            if (isset($loadModKunjungan)) {
            $modKunjungan = $loadModKunjungan;
            }
        }

        if(!empty($pasienkirimkeunitlain_id) && !empty($pendaftaran_id)) {
            $load = PasienmasukpenunjangV::model()->findByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id], ['order' => 'tglmasukpenunjang desc']);
            // echo '<pre>';var_dump($load);die;
            if(empty($modKunjungan)) {
              $modKunjungan = $load;
            }
            $modPasienMasukPenunjang->pegawai_nama = $load->gelardepan . ' ' . $load->nama_pegawai . ' ' . $load->gelarbelakang_nama;
            if(!empty($modPendaftaran)) {
              if(!empty($modKunjungan)) {
                $modKunjungan->nama_pegawai = $modPendaftaran->pegawai->namaLengkap;
              }
            }

        }

        // echo '<pre>';var_dump($modKunjungan);die;
       
        if (isset($_POST['BDPasienmasukpenunjangT'])) {
          
            // echo '<pre>';var_dump($_POST);die;
            $modPendaftaran = BDPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
            // echo '<pre>';var_dump($modPendaftaran);die;
            $transaction = Yii::app()->db->beginTransaction();

            $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

            $noawal = 0;
        
            if(!empty($md_noawal)) {
              $noawal = intval($md_noawal->nopelayanan);
            } else {
              $noawal = 1;
            }
            
            try {
              $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $_POST['BDPasienmasukpenunjangT']);
              
                // if(isset($_POST['Permintaankepenunjang'])) {
                //   if(count($_POST['Permintaankepenunjang']) > 0) {
                //     foreach($_POST['Permintaankepenunjang'] as $ii => $tindakan) {
                //       $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan, $noawal);
                //     }
                //   }
                // }

                // die;
            
                $noPelayanan = '';
                if (isset($_POST['TindakanpelayananT'])) {
                    if (count((array)$_POST['TindakanpelayananT']) > 0) {
                    foreach ($_POST['TindakanpelayananT'] as $ii => $tindakan) {
                        if (!empty($tindakan['tindakanpelayanan_id'])) {
                        $dataTindakans[$ii] = TindakanpelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
                        } else {
                        $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan, $noawal);
                        $noPelayanan = $dataTindakans[$ii]->nopelayanan;
                        }
                        if (!empty($dataTindakans[$ii])) {
                        $dataTindakans[$ii]->daftartindakan_id = $tindakan['daftartindakan_id'];
                        $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
                        $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
                        }
                    }
                    }
                }


                
            
                $pd_simpan = true;
            
                // $updateStatusPeriksa = $modPendaftaran->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);
                $this->notifPermintaanDarah($modPasienMasukPenunjang);
            
                // $modPendaftaran->statusperiksa = Params::STATUSPERIKSA_SUDAH_DIPERIKSA;
                // $modPendaftaran->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $modPendaftaran->update_time = date('Y-m-d H:i:s');
                $modPendaftaran->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
                
                $pd_simpan &= $modPendaftaran->save();
            
                //cek sudah pengujian darah atau belum
                $pemeriksanGolDar = PemeriksaangoldarT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);
                if(!empty($pemeriksanGolDar)) {
                  $modKirim->is_progressgoldarah = true;
                  $modKirim->save(false, array('is_progressgoldarah'));
                }

                

                // echo '<pre>';
                // var_dump($this->pasienpenunjangtersimpan, $this->komponentindakantersimpan, $this->tindakanpelayanantersimpan, $pd_simpan);die;
                if ($this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan &&$pd_simpan) {
                    // SMS GATEWAY
                    $modPegawai = $modPasienMasukPenunjang->pegawai;
                    $modPasien = $modPasienMasukPenunjang->pasien;
                    $modRuangan = $modPasienMasukPenunjang->ruangan;
                    $modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
                    if (isset($modPendaftaran->penanggungjawab)) {
                    $modPenanggungJawab = $modPendaftaran->penanggungjawab;
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
                    if (isset($modPendaftaran->penanggungjawab)) {
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
                    // END SMS GATEWAY
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Pemeriksaan Permintaan darah Berhasil Disimpan !");
                    $this->redirect(array('index', 'pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id'], 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'sukses' => 1, 'smspasien' => $smspasien, 'smsdokter' => $smsdokter, 'smspenanggungjawab' => $smspenanggungjawab, 'nopelayanan' => $noPelayanan));
                } else {
            
                    $transaction->rollback();
                    
                    Yii::app()->user->setFlash('error', "Data pemeriksaan Permintaan Darah gagal disimpan [2]!<br>");
                }
            } catch (Exception $exc) {
            //   echo '<pre>'; var_dump($exc); die;
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data pemeriksaan Permintaan Darah gagal disimpan [1]!" . " " . MyExceptionMessage::getMessage($exc, true));
            }
        }
        if(!empty($modKirim->diagnosa_id)) {
          $modDiagnosa = DiagnosaM::model()->findByPk($modKirim->diagnosa_id);
          $modKunjungan->diagnosa_nama = $modDiagnosa->diagnosa_nama ?? '';
        }
        $this->render('index', array(
            'modKunjungan' => $modKunjungan,
            'modPemeriksaanRm' => $modPemeriksaanRm,
            'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
            'modTindakan' => $modTindakan,
            'dataTindakans' => $dataTindakans,
            'modSmsgateway' => $modSmsgateway,
            'modKirim' => $modKirim,
            'rowPermintaan' => $rowPermintaan
        ));
    }


  public function notifPermintaanDarah($modPasienMasukPenunjang)
  {


    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id
    ));
    $judul = "Permintaan Darah Pasien - " . $modPasienMasukPenunjang->no_masukpenunjang;

    $asal = RuanganM::model()->findByPk($modPasienMasukPenunjang->ruanganasal_id);
    $tujuan = RuanganM::model()->findByPk($modPasienMasukPenunjang->ruangan_id);

    $isi = "Tgl. Periksa : " . MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tglmasukpenunjang) . "<br/>";
    $isi .= "No. Periksa : " . $modPasienMasukPenunjang->no_masukpenunjang . "<br/>";
    $isi .= "No. Pendaftaran : " . $penunjang->no_pendaftaran . "<br/>";
    $isi .= "Pasien : " . $penunjang->no_rekam_medik . " - " . $penunjang->nama_pasien;

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id),
      array('instalasi_id' => $tujuan->instalasi_id, 'ruangan_id' => $tujuan->ruangan_id, 'modul_id' => $tujuan->modul_id),
    ));
  }

    /**
   * Fungsi untuk menyimpan data ke model RMPasienmasukpenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return BDPasienmasukpenunjangT 
   */
  public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $post)
  {
    $modPasienMasukPenunjang = new BDPasienmasukpenunjangT;
    $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
    $modPasienMasukPenunjang->attributes = $post;
    $modPasienMasukPenunjang->pegawai_id = $post['pegawai_id'];
    $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
    $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang2('BD');
    $modPasienMasukPenunjang->tglmasukpenunjang = MyFormatter::formatDateTimeForDb($post['tglmasukpenunjang']);
    $modPasienMasukPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
    $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');
    $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');
    $modPasienMasukPenunjang->dpjp_id  = $modPasienMasukPenunjang->perawatPJP->dpjp_id ?? "";
    $modPasienMasukPenunjang->is_bankdarah = true;
    $modPasienMasukPenunjang->ruangan_id = Params::RUANGAN_ID_BANK_DARAH;
    if (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)) {
      $kirim = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
      $modPasienMasukPenunjang->ruanganasal_id = $kirim->create_ruangan;
    }

    // echo '<pre>';var_dump($modPasienMasukPenunjang->save());die;

    if ($modPasienMasukPenunjang->validate()) {
      if($modPasienMasukPenunjang->save()) {
        $this->pasienpenunjangtersimpan &= true;
      } else {
        $this->pasienpenunjangtersimpan &= false;
      }
    } else {
      $this->pasienpenunjangtersimpan &= false;
    }

    return $modPasienMasukPenunjang;
  }


  /**
   * proses simpan RMTindakanpelayananT dan RMTindakanKomponenT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post, $noawal)
  {
    $modTindakan = new TindakanpelayananT;
    $format = new MyFormatter();
    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->attributes = $post;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
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

    $modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');

    // echo '<pre>'; var_dump($modTindakan->attributes); die;

    // echo '<pre>';
    // var_dump($modTindakan->getErrors());
    if ($modTindakan->validate()) {
      if($modTindakan->save()) {
        $this->tindakanpelayanantersimpan &= true;  
      } else {
        $this->tindakanpelayanantersimpan &= false;
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }
    
    return $modTindakan;
  }

  public function actionPrintStatus($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
    $criteria1 = new CdbCriteria();
    $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    // $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_REHABMEDIS);
    $loadPasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria1);
    // echo '<pre>';
    // var_dump($loadPasienMasukPenunjang);die;
    if (isset($loadPasienMasukPenunjang)) {
      $modPasienMasukPenunjang = $loadPasienMasukPenunjang;
      $modTindakans = TindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_tot = new CdbCriteria();
      $criteria_tot->addCondition("karcis_id IS NULL");
      $criteria_tot->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjang->pasienmasukpenunjang_id);
      $daftartindakan = TindakanpelayananT::model()->findAll($criteria_tot);
    }

    $judul_print = 'Kunjungan Bank Darah';
    $this->render('printStatus', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
    //  'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
     'daftartindakan' => $daftartindakan,
    ));
  }

  function actionUbahPencatatanStok() {
    $permintaankepenunjang_id = $_POST['permintaankepenunjang_id'];
    $jumlahkantong = $_POST['jumlahkantong'];
    $diambil = $_POST['diambil'];
    $dititip = $_POST['dititip'];

    $modPermintaanKePenunjang = PermintaankepenunjangT::model()->findByPk($permintaankepenunjang_id);
    $pasienkirimkeunitlain_id = $modPermintaanKePenunjang->pasienkirimkeunitlain_id;

    $attributes = [
      'jumlah_kantong' => $jumlahkantong,
      'diambil' => $diambil,
      'dititip' => $dititip
    ];
    $updatePermintaan = PermintaankepenunjangT::model()->updateByPk($permintaankepenunjang_id, $attributes);
    if($updatePermintaan) {
      $data['sukses'] = 1;
    } else {
      $data['sukses'] = 0;
    }

    $rowPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);
    
    // cek dititip sudah 0 semua apa belum
    $update = true;
    foreach($rowPermintaan as $val) {
      $cekDititip = preg_replace('/[^0-9]/', '', $val->dititip);
      if($cekDititip > 0) {
        // jika dititip masih ada yang bernilai lebih dari 0 maka jangan mengaupdate is_titipdarah
        $update = false;
      }
    }

    if($update) {
      PasienkirimkeunitlainT::model()->updateByPk($pasienkirimkeunitlain_id, ['is_titipdarah' => false]);
    }

    $modKirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
    $data['html'] = '';
    $data['htmlPencatatanStok'] = '';
    if(count($rowPermintaan) > 0) {
        foreach($rowPermintaan as $ii => $row) {
          $data['html'] .= $this->renderPartial('_rowPermintaanKePenunjang', [
                'ii' => $ii,
                'row' => $row,
                'modKirim' => $modKirim
          ], true);
          $data['htmlPencatatanStok'] .= $this->renderPartial('_rowPencatatanStok', [
                'ii' => $ii,
                'row' => $row,
                'modKirim' => $modKirim
          ], true);
        }
    }

    echo json_encode($data);
  }

  function actionSalinPemeriksaanDariPermintaan() {
    $pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
    $jumlahtr = $_POST['jumlahtr'];
    $rowPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);
    $data['sukses'] = 1;
    $data['html'] = '';
    $modKirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
    if(count($rowPermintaan) > 0) {
        $data['sukses'] = 1;
        foreach($rowPermintaan as $iii => $row) {
          $modPaketPelayanan = PaketpelayananM::model()->findAllByAttributes(['tipepaket_id' => $row->jeniskomponendarah_id]);
          if(count($modPaketPelayanan) > 0) {
            foreach($modPaketPelayanan as $ii => $val) {
              $tarif = TariftindakanM::model()->find('daftartindakan_id = ' . $val->daftartindakan_id . ' and ' . ' komponentarif_id = 6');
              $data['html'] .= $this->renderPartial('_rowSalinPermintaanKePenunjang', [
                    'ii' => $ii,
                    'row' => $row,
                    'modKirim' => $modKirim,
                    'modPaketPelayanan' => $val,
                    'jumlahtr' => $jumlahtr,
                    'tarif' => $tarif
              ], true);
              $jumlahtr++;
            }
          }
        }
    }

    echo json_encode($data);
  }
  function actionSalinPemeriksaanDariStok() {
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $modPasienKirimKeunitlain = PasienkirimkeunitlainT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);
    $jumlahtr = $_POST['jumlahtr'];
    $rowPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $modPasienKirimKeunitlain->pasienkirimkeunitlain_id]);
    $data['sukses'] = 1;
    $data['html'] = '';
    
    if(count($rowPermintaan) > 0) {
        $data['sukses'] = 1;
        foreach($rowPermintaan as $iii => $row) {
          $modPaketPelayanan = PaketpelayananM::model()->findAllByAttributes(['tipepaket_id' => $row->jeniskomponendarah_id]);
          if(count($modPaketPelayanan) > 0) {
            foreach($modPaketPelayanan as $ii => $val) {
              $tarif = TariftindakanM::model()->find('daftartindakan_id = ' . $val->daftartindakan_id . ' and ' . ' komponentarif_id = 6');
              $data['html'] .= $this->renderPartial('_rowSalinPermintaanKePenunjang', [
                    'ii' => $ii,
                    'row' => $row,
                    'modKirim' => $modPasienKirimKeunitlain,
                    'modPaketPelayanan' => $val,
                    'jumlahtr' => $jumlahtr,
                    'tarif' => $tarif
              ], true);
              $jumlahtr++;
            }
          }
        }
    }

    echo json_encode($data);
  }

  public function actionPrintTindakan($id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modTindakans = TindakanpelayananT::model()
      ->with(
        'daftartindakan',
        'dokter1',
        'dokter2',
        'dokterPendamping',
        'dokterAnastesi',
        'dokterDelegasi',
        'bidan',
        'suster',
        'perawat',
        'tipePaket'
      )
      ->findAll("t.pendaftaran_id = $id and t.ruangan_id = $ruangan_id and t.verifbataltindakan_id is null"); // RND-6244

      // membuat rincian data sejumlah qty tindakan
      $dataTindakanSejumlahQtyTindakan = [];
      $noPelayanan = '';
      $totalBiaya = 0;
      if(count($modTindakans) > 0) {
        foreach($modTindakans as $i => $val) {
          $noPelayanan = $val->nopelayanan;
          $totalBiaya += $val->tarif_tindakan;
          if($val->qty_tindakan > 0) {
            for ($i=0; $i < $val->qty_tindakan; $i++) { 
              $dataTindakanSejumlahQtyTindakan[$val->qty_tindakan . '_' . $val->tindakanpelayanan_id][$i]['daftartindakan_kode'] = $val->daftartindakan->daftartindakan_kode;
              $dataTindakanSejumlahQtyTindakan[$val->qty_tindakan. '_' . $val->tindakanpelayanan_id][$i]['daftartindakan_nama'] = $val->daftartindakan->daftartindakan_nama;
              $dataTindakanSejumlahQtyTindakan[$val->qty_tindakan. '_' . $val->tindakanpelayanan_id][$i]['tarif_satuan'] = $val->tarif_satuan;
            }
          }
        }
      }


      // mengumpulkan data jadi satu
      $dataNotaTindakanTemp = [];
      if(count($dataTindakanSejumlahQtyTindakan) > 0) {
        foreach($dataTindakanSejumlahQtyTindakan as $i => $data) {
          foreach($data as $ii => $val) {
            $dataNotaTindakanTemp[] = $val;
          }
        }
      }

      // memisahkan data perhalaman dengan ketentuan per page berapa data
      $no = 1;
      $banyakDataPerPage = 6;
      $page = 1;
      $dataNotaTindakan = [];
      if(count($dataNotaTindakanTemp) > 0) {
        foreach($dataNotaTindakanTemp as $i => $data) {
        
            
          $dataNotaTindakan[$page][$i]['daftartindakan_kode'] = $data['daftartindakan_kode'];
          $dataNotaTindakan[$page][$i]['daftartindakan_nama'] = $data['daftartindakan_nama'];
          $dataNotaTindakan[$page][$i]['tarif_satuan'] = $data['tarif_satuan'];
          
          if($no >= $banyakDataPerPage) {
            $no = 1;
            $page++;
          } else {
            $no++;
          }
          
        }
      }
      
      if(count($dataNotaTindakan) > 0) {
        foreach($dataNotaTindakan as $i => $data) {
          $this->render('printNotaTindakan', [
            'page' => $i, 
            'dataNotaTindakan' => $data,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'noPelayanan' => $noPelayanan,
            'totalBiaya' => $totalBiaya,
            'halamanAkhir' => ($i == ($page -1))
          ]);
        }
      }
  }

  function actionGetDataKunjungan() {
    $pendaftaran_id = $_POST['pendaftaran_id'];

    $modPasienKirimKeunitlain = PasienkirimkeunitlainV::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')]);
    $modKunjungan = BukuregisterpasienV::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);
    $morbid = PasienmorbiditasT::model()->findByAttributes(array(
        'pendaftaran_id'=>$pendaftaran_id,
        'kelompokdiagnosa_id'=>Params::KELOMPOKDIAGNOSA_UTAMA,
    ));
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $data['nama_dokter'] = $modPendaftaran->pegawai->namaLengkap ?? '';

    $data['diagnosa_utama'] = '';
    $data['html'] = '';
    if(!empty($modPasienKirimKeunitlain)) {
        $modPermintaanKePenunjang = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $modPasienKirimKeunitlain->pasienkirimkeunitlain_id]);
        if(!empty($modPermintaanKePenunjang)) {
          foreach($modPermintaanKePenunjang as $ii => $row) {
            $data['html'] .= $this->renderPartial('_rowPencatatanStok', [
              'jeniskomponenedarah_nama' => $row->jeniskomponendarah->jeniskomponenedarah_nama ?? '',
              'jeniskomponendarah_id' => $row->jeniskomponendarah_id,
              'row' => $row,
              'ii' => $ii
            ], true);
          }
        }
        if(!empty($modKunjungan)) {
          foreach($modPasienKirimKeunitlain->attributes as $i => $val) {
            $data[$i] = $val;
          }
          foreach($modKunjungan->attributes as $i => $val) {
            $data[$i] = $val;
          }
          if(!empty($morbid)) {
            $data['diagnosa_utama'] = $morbid->diagnosa->diagnosa_nama;
          }
          $data['sukses'] = 1;
        } else {
          $data['sukses'] = 0;
        }
    } else if(!empty($modKunjungan)){
      foreach($modKunjungan->attributes as $i => $val) {
        $data[$i] = $val;
      }
      if(!empty($morbid)) {
        $data['diagnosa_utama'] = $morbid->diagnosa->diagnosa_nama;
      }
      $data['sukses'] = 1;
    } else {
        $data['sukses'] = 0;
    }
    echo json_encode($data);
  }

  function actionSetPencatatanStok() {
    $jeniskomponendarah_id = $_POST['jeniskomponendarah_id'];
    $jeniskomponenedarah_nama = $_POST['jeniskomponenedarah_nama'];
   
    $jumlahtr = $_POST['jumlahtr'];

    
    $data['html'] = $this->renderPartial('_rowPencatatanStok', [
      'jeniskomponendarah_id' => $jeniskomponendarah_id,
      'jeniskomponenedarah_nama' => $jeniskomponenedarah_nama,
      'ii' => $jumlahtr
    ], true);

    echo json_encode($data);
  }

  function actionSimpanPencatatanStok() {
    $permintaankepenunjang_id = isset($_POST['permintaankepenunjang_id']) ? $_POST['permintaankepenunjang_id'] : null;
    $pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
    $jeniskomponendarah_id = $_POST['jeniskomponendarah_id'];
    $jumlahkantong = $_POST['jumlahkantong'];
    $diambil = $_POST['diambil'];
    $dititip = $_POST['dititip'];
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $jenisvolumjumlahkantong = $_POST['jenisvolumjumlahkantong'];
    $jenisvolumediambil = $_POST['jenisvolumediambil'];
    $jenisvolumedititip = $_POST['jenisvolumedititip'];

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

    if(empty($modPendaftaran)) {
      $data['sukses'] = 0;
      $data['pesan'] = 'Data Pendaftaran Tidak Ditemukan';

      echo json_encode($data);
      Yii::app()->end();
    }

    $isNew = false;
    $saveKirimKeUnitLain = false;
    $data['datapermintaanpenunjang'] = [];
    $data['datakirimkeunitlain'] = [];
    $data['sukses'] = 0;
    try {
      $transaction = Yii::app()->db->beginTransaction();
      $modPasienKirimKeunitlain = PasienkirimkeunitlainT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')]);
      if(empty($modPasienKirimKeunitlain)) {
        $modPasienKirimKeunitlain = new PasienkirimkeunitlainT();
        $isNew = true;
      } else {
        $saveKirimKeUnitLain = true;
      }

      if($isNew) {
        $modPasienKirimKeunitlain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modPasienKirimKeunitlain->pasien_id = $modPendaftaran->pasien_id;
        $modPasienKirimKeunitlain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPasienKirimKeunitlain->instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modPasienKirimKeunitlain->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPasienKirimKeunitlain->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPasienKirimKeunitlain->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $modPasienKirimKeunitlain->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $modPasienKirimKeunitlain->tgl_kirimpasien = date('Y-m-d H:i:s');
        $modPasienKirimKeunitlain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain(Params::RUANGAN_ID_BANK_DARAH);
        if($modPasienKirimKeunitlain->validate()) {
          if($modPasienKirimKeunitlain->save()) {
            $saveKirimKeUnitLain = true;
          }
        }
      }

      // echo '<pre>';var_dump($modPasienKirimKeunitlain);die;

      if($saveKirimKeUnitLain) {
        if(!empty($permintaankepenunjang_id)) {
          // update
          $modPermintaanKePenunjang = PermintaankepenunjangT::model()->findByPk($permintaankepenunjang_id);
        } else {
          // insert
          $modPermintaanKePenunjang = new PermintaankepenunjangT();
          $modPermintaanKePenunjang->pasienkirimkeunitlain_id = $modPasienKirimKeunitlain->pasienkirimkeunitlain_id;
          $modPermintaanKePenunjang->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('BD');
          $modPermintaanKePenunjang->tglpermintaankepenunjang =  $modPasienKirimKeunitlain->tgl_kirimpasien;
          $modPermintaanKePenunjang->jeniskomponendarah_id = $jeniskomponendarah_id;
        }
        $modPermintaanKePenunjang->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($modPermintaanKePenunjang->tglpermintaankepenunjang);
        $modPermintaanKePenunjang->diambil =  $diambil . ' ' . $jenisvolumediambil;
        $modPermintaanKePenunjang->dititip =  $dititip . ' ' . $jenisvolumedititip;
        $modPermintaanKePenunjang->qtypermintaan =  preg_replace('/[^0-9.]/', '', $jumlahkantong);
        $modPermintaanKePenunjang->jumlah_kantong =  $jumlahkantong;
        $modPermintaanKePenunjang->jenis_volume =  $jenisvolumjumlahkantong;
        $modPermintaanKePenunjang->jenispermintaan =  'Biasa';
        
        // echo '<pre>';var_dump($modPermintaanKePenunjang->save(), $modPermintaanKePenunjang->getErrors());die;
        if($modPermintaanKePenunjang->validate()) {
          if($modPermintaanKePenunjang->save()) {
            $rowPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $modPasienKirimKeunitlain->pasienkirimkeunitlain_id]);
    
            // cek dititip sudah 0 semua apa belum
            $update = true;
            foreach($rowPermintaan as $val) {
              $cekDititip = preg_replace('/[^0-9]/', '', $val->dititip);
              if($cekDititip > 0) {
                // jika dititip masih ada yang bernilai lebih dari 0 maka jangan mengaupdate is_titipdarah
                $update = false;
              }
            }

            if($update) {
              PasienkirimkeunitlainT::model()->updateByPk($modPasienKirimKeunitlain->pasienkirimkeunitlain_id, ['is_titipdarah' => false]);
            }
            
            $transaction->commit();
            $data['sukses'] = 1;

            foreach ($modPermintaanKePenunjang->attributes as $key => $value) {
              $data['datapermintaanpenunjang'][$key] = $value;
            }
            foreach ($modPasienKirimKeunitlain->attributes as $key => $value) {
              $data['datakirimkeunitlain'][$key] = $value;
            }
          } else {
            $data['pesan'] = 'Gagal Simpan permintaan ke penunjang [validasi]';
          }
        } else {
          $transaction->rollback();
          $data['pesan'] = 'Gagal Simpan permintaan ke penunjang [save]';
        }

      }

    } catch (Exception $exc) {
      $transaction->rollback();
      $data['pesan'] = 'Gagal Simpan permintaan ke database [exception] ' . $exc->getMessage();
    }

    echo json_encode($data);
  }

  function actionCekDataPencatatanStok() {
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $jeniskomponendarah_id = $_POST['jeniskomponendarah_id'];

    $modPasienKirimKeunitlain = PasienkirimkeunitlainT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_BANK_DARAH]);

    if(empty($modPasienKirimKeunitlain)) {
      echo json_encode(['sukses' => 0, 'pesan' => 'Data Pencatatan Stok Belum Disimpan']);
      Yii::app()->end();
    } 

    $belumSimpan = 0;
    $dataNamaPemeriksaan = '<ul>';
    if(count($jeniskomponendarah_id) > 0) {
      foreach($jeniskomponendarah_id as $i => $id) {
        $permintaanKepenunjang = PermintaankepenunjangT::model()->findByAttributes(['pasienkirimkeunitlain_id' => $modPasienKirimKeunitlain->pasienkirimkeunitlain_id, 'jeniskomponendarah_id' => $id]);
        if(empty($permintaanKepenunjang)) {
          $belumSimpan +=1;
          $dataNamaPemeriksaan .=  '<li>' . TipepaketM::model()->findByPk($id)->tipepaket_nama . '</li>';
        }
      }
    }
    $dataNamaPemeriksaan .= '</ul>';

    if($belumSimpan > 0) {
      echo json_encode(['sukses' => 0, 'belumSimpan' => 1, 'pesan' => '<b>Pencatatan Stok Belum Disimpan</b>. <br> Pemeriksaan : <br>' . $dataNamaPemeriksaan]);
      Yii::app()->end();
    } else {
      echo json_encode(['sukses' => 1]);
      Yii::app()->end();
    }
  }
}
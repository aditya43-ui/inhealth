<?php
Yii::import('laboratorium.controllers.PendaftaranLaboratoriumController');
class PendaftaranLaboratoriumRujukanRSController extends PendaftaranLaboratoriumController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "laboratorium.views.pendaftaranLaboratoriumRujukanRS.";
  public $path_view_pendaftaran = "laboratorium.views.pendaftaranLaboratorium.";
  public $obatalkespasientersimpan = true; //di looping
  public $stokobatalkestersimpan = true; //looping
  public $karcistersimpan = true; //looping
  public $komponentindakantersimpan = true;
  public $permintaankepenunjangtersimpan = true;

  /**
   * Tambah / Ubah Pemeriksaan Laboratorium.
   */
  public function actionIndex($pasienmasukpenunjang_id = null, $pendaftaran_id = null, $instalasi_id = null)
  {

    // untuk load dialog pemeriksaan
    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'dialog-tariftindakan-m-grid-pk') {
        $this->renderPartial('_daftarPemeriksaanDialogPK', []);
        Yii::app()->end();
      }

      if(isset($_GET['ajax']) && $_GET['ajax'] == 'pegawaiYangMengajukanPK-m-grid') {
        $modPasienMasukPenunjang = new LBPasienmasukpenunjangT;
        $this->renderPartial('_dialogDaftarPencarianDokter', ['modPasienMasukPenunjang' => $modPasienMasukPenunjang]);
        Yii::app()->end();
      }
    }
    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $index = ($instalasi_id == Params::INSTALASI_ID_LAB) ? 'index' : 'indexPA';

    $format = new MyFormatter();
    $modKunjungan = new LBPasienKirimKeUnitLainV;
    $modKirimKeUnitLain = new LBPasienKirimKeUnitLainT;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPemeriksaanLab = new LBTarifpemeriksaanlabruanganV;

    
    $modPasienMasukPenunjang = new LBPasienmasukpenunjangT;
    $modPasienMasukPenunjang->tglmasukpenunjang = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modTindakan = new LBTindakanPelayananT;
    $modObatAlkesPasien = new LBObatalkespasienT;
    $dataTindakans = array();
    $modKarcisV = array();
    $modPasienMasukPenunjang->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    if(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LAB_KLINIK) {
      $modJadwalDokterMod = JadwaldoktermodM::model()->findByAttributes(['tanggaljaga' => date('Y-m-d'), 'is_mod' => true]);
      if(!empty($modJadwalDokterMod)) {
        $pegawai = PegawaiM::model()->findByPk($modJadwalDokterMod->pegawai_id);
        if(!empty($pegawai)) {
          $modPasienMasukPenunjang->pegawai_id = $pegawai->pegawai_id;
          $modPasienMasukPenunjang->pegawai_nama = $pegawai->namaLengkap;
        }
      }
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
      if (!isset($_GET['pasienmasukpenunjang_id']) && !Yii::app()->request->isPostRequest) {
        $this->setReferrer();
      }
      $modKunjungan = LBPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_GET['pasienkirimkeunitlain_id']));

      $pendaftaran = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
      $modPemeriksaanLab->kelaspelayanan_id = $pendaftaran->kelaspelayanan_id;
      if($modKunjungan){
          $modKunjungan->dokterperujuk = $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama;
          $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $modKunjungan->pasienkirimkeunitlain_id;
          $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modKunjungan->jeniskasuspenyakit_id;
          $modPasienMasukPenunjang->kelaspelayanan_id = $modKunjungan->kelaspelayanan_id;
          if(!empty($modKunjungan->tglrencanapemeriksaan)) {
            $modPasienMasukPenunjang->tglrencanapemeriksaan = $modKunjungan->tglrencanapemeriksaan;
            $modPasienMasukPenunjang->tglmasukpenunjang = MyFormatter::formatDateTimeForUser($modKunjungan->tglrencanapemeriksaan);
          }
      }
    } else {
      $this->cleanReferrer();
    }

    if (isset($_GET['pendaftaran_id'])) {


      $modKunjungan = LBInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'instalasi_id' => $_GET['instalasi_id']));
      $modKunjungan->instalasiasal_id = $modKunjungan->instalasi_id;
      $modKunjungan->instalasiasal_nama = $modKunjungan->instalasi_nama;
      $modKunjungan->ruanganasal_id = $modKunjungan->ruangan_id;
      $modKunjungan->ruanganasal_nama = $modKunjungan->ruangan_nama;
      $modKunjungan->nama_bin = $modKunjungan->alias;
      $modPasienMasukPenunjang->pasienkirimkeunitlain_id = isset($modKunjungan->pasienkirimkeunitlain_id) ? $modKunjungan->pasienkirimkeunitlain_id : null;
      $modPasienMasukPenunjang->jeniskasuspenyakit_id = isset($modKunjungan->jeniskasuspenyakit_id) ? $modKunjungan->jeniskasuspenyakit_id : null;
      $modPasienMasukPenunjang->kelaspelayanan_id = isset($modKunjungan->kelaspelayanan_id) ? $modKunjungan->kelaspelayanan_id : null;
    }
    if (!empty($pasienmasukpenunjang_id)) {
      $modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $modPasienMasukPenunjang->tglmasukpenunjang = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tglmasukpenunjang);
      $loadModKunjungan = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;
        $modPasienMasukPenunjang->pegawai_nama = $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama;
        $modKunjungan->dokterperujuk = $modKunjungan->gelardokterasal . " " . $modKunjungan->nama_dokterasal;
      }
    }

    if (isset($_POST['LBPasienmasukpenunjangT'])) {
      // echo '<pre>';var_dump($_POST);die;
      if (!empty($_POST['LBPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])) {
        $modKunjungan = LBPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['LBPasienmasukpenunjangT']['pasienkirimkeunitlain_id']));
        $modKirimKeUnitLain = LBPasienKirimKeUnitLainT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['LBPasienmasukpenunjangT']['pasienkirimkeunitlain_id']));
      } else {
        $modKunjungan = LBInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'instalasi_id' => $_GET['instalasi_id']));
      }
      $modPendaftaran = LBPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modkirimUnit = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
        
        /*
        if (isset($modkirimUnit)) {
          $modRuanganKirim = RuanganM::model()->findByPk($modkirimUnit->create_ruangan);

          if (isset($modRuanganKirim)) {
            if ($modRuanganKirim->instalasi_id != Params::INSTALASI_ID_RI) {
              $modPendaftaran->pasienadmisi_id = null;
            }
          }
        }
        */

        $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $_POST['LBPasienmasukpenunjangT']);
        if (!empty($_POST['LBPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])) {
          $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $_POST['LBPasienmasukpenunjangT']['pasienkirimkeunitlain_id'];
          $pasienkirimterupdate = $modPasienMasukPenunjang->save(false);
          $modkirimUnit->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
          $modkirimUnit->save(false, array('pasienmasukpenunjang_id'));
        } else {
          $pasienkirimterupdate = true;
        }
        // echo '<pre>';var_dump($_POST['LBPasienmasukpenunjangT']['ruangan_id']);die;
        if ($_POST['LBPasienmasukpenunjangT']['ruangan_id'] != Params::RUANGAN_ID_LAB_ANATOMI) {
          $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPendaftaran->pasien, $modPasienMasukPenunjang);
        }

        $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

        if(!empty($md_noawal)) {
          $noawal = intval($md_noawal->nopelayanan) + 1;
        } else {
          $noawal = 1;
        }

        $permintaan = [];

        // echo '<pre>';
        // var_dump($_POST['LBTindakanPelayananT']); die;
       
        if (isset($_POST['LBTindakanPelayananT'])) {
          if (count((array)$_POST['LBTindakanPelayananT']) > 0) {

            foreach ($_POST['LBTindakanPelayananT'] as $ii => $tindakan) {
              if (!empty($tindakan['tindakanpelayanan_id'])) {
                // echo "Kicker";
           
                $dataTindakans[$ii] = LBTindakanPelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
                $dataTindakans[$ii]->attributes = $modPasienMasukPenunjang->attributes;
                $dataTindakans[$ii]->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
                $dataTindakans[$ii]->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
                $dataTindakans[$ii]->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $dataTindakans[$ii]->tarif_tindakan = ($tindakan['tarif_tindakan']);
                $dataTindakans[$ii]->nopelayanan = str_pad($noawal,3,"0",STR_PAD_LEFT);
                if (empty($dataTindakans[$ii]->pasienmasukpenunjang_id))
                  $dataTindakans[$ii]->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;

                $daftartindakan = DaftartindakanM::model()->find(" daftartindakan_id = " . $dataTindakans[$ii]->daftartindakan_id);
                $nama_tindakan = str_replace("'", "''", $daftartindakan->daftartindakan_nama);


                $perda = TariftindakanperdaruanganV::model()->find(" daftartindakan_kode = '$daftartindakan->daftartindakan_kode'");

                if(!empty($perda)) {
                  $dataTindakans[$ii]->tarif_satuan = !empty($perda) ? $perda->harga_tariftindakan : 0;
                  $dataTindakans[$ii]->qty_tindakan = $tindakan['qty_tindakan'];
                  $dataTindakans[$ii]->tarif_tindakan = intval($dataTindakans[$ii]->tarif_satuan) * intval($dataTindakans[$ii]->qty_tindakan);
                  // $modPemeriksaanTemp = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $perda->daftartindakan_id));
                  // if(!empty($perda)) {
                    //   $modPemeriksaan = $modPemeriksaanTemp;
                    // }
                }

                $dataTindakans[$ii]->update();
                
                if ($_POST['LBPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI) {
                  $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
                  $modPasienMasukPenunjang->ispatologianatomi = true;
                  $modPasienMasukPenunjang->save(false, 'ispatologianatomi');
                } else {
                  $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$ii], $tindakan);
                }
              } else {
                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan, $noawal); //PendaftaranLaboratoriumController
 
                if ($_POST['LBPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI) {
                  $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
                  $modPasienMasukPenunjang->ispatologianatomi = true;
                  $modPasienMasukPenunjang->save(false, 'ispatologianatomi');
                } else {
                  if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                    if (empty($tindakan['tindakanpelayanan_id'])) { //jika tindakan baru
                      $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$ii], $tindakan);
                    }
                  }
                }
              }
              //untuk ditampilkan di form
              $dataTindakans[$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);

              $permintaan[$ii] = $this->simpanPermintaanKepenunjang($dataTindakans[$ii]);
              // var_dump($dataTindakans[$ii]->attributes);
            }
          }
        }

        $this->karcistersimpan = true;
        $this->komponentindakantersimpan = true;

        if ($_POST['LBPasienmasukpenunjangT']['is_adakarcis']) {
          if (isset($_POST['PPTindakanPelayananT'])) {
            if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
              foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
                //if($karcis['is_pilihtindakan']){
                $modTindakan = new TindakanpelayananT();
                $this->simpanKarcis($modTindakan, $modPasienMasukPenunjang, $karcis);
                //                                    $model->karcis_id = $dataTindakans[$i]->karcis_id;
                //                                    $model->save();
                //}
              }
            }
            if (isset($_POST['PPPendaftaranT']['is_bayarkarcis'])) { //fitur belum ada >> RND-666
              if ($_POST['PPPendaftaranT']['is_bayarkarcis']) { //jika di ceklis
              }
            }
          }
        }
        // die;


        if (isset($_POST['ROObatalkespasienT']) or isset($_POST['LBObatalkespasienT'])) {
          if (count((array)$_POST['LBObatalkespasienT']) > 0) {
            //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
            $detailGroups = array();
            foreach ($_POST['LBObatalkespasienT'] as $i => $postDetail) {
              $modDetails[$i] = new LBObatalkespasienT;
              $modDetails[$i]->attributes = $postDetail;

              $modDetails[$i] = $this->simpanObatAlkesPasien2($modPasienMasukPenunjang, $postDetail);
              $this->simpanStokObatAlkesOut2($modDetails[$i]);

              /*
							$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
							$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
							$obatalkes_id = $postDetail['obatalkes_id'];
							if(isset($detailGroups[$obatalkes_id])){
								$detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
							}else{
								$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
								$detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
							} */
            }
            //END GROUP
            /*
						$obathabis = "";
						//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
						foreach($detailGroups AS $i => $detail){
							$modStokOAs = StokobatalkesT::ge
              
              tStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
							if(count((array)$modStokOAs) > 0){
								foreach($modStokOAs AS $i => $stok){
									$modDetails[$i] = $this->simpanObatAlkesPasien($modPasienMasukPenunjang,$stok, $_POST['LBObatalkespasienT']);
									$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
								}
							}else{
								$this->stokobatalkestersimpan &= false;
								$obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

							}
						}
                                                 * 
                                                 */
          }
        }
        // var_dump($modHasilPemeriksaan);die;
        // var_dump("OK"); die;
        if (!empty($modHasilPemeriksaan)) {
          $sysmex = new Sysmex;
          $sysmex->kirim_tambah($modHasilPemeriksaan->hasilpemeriksaanlab_id);
        }

        if ($this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $pasienkirimterupdate && $this->obatalkespasientersimpan && $this->stokobatalkestersimpan && $this->karcistersimpan && $this->permintaankepenunjangtersimpan) {
          // var_dump("OK"); die;
          // SMS GATEWAY
          $smspasien = 1;
          if (Yii::app()->user->getState('issmsgateway')) {
            $modPasien = $modPasienMasukPenunjang->pasien;
            $modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
            $modRuangan = $modPasienMasukPenunjang->ruangan;
            $sms = new Sms();
            foreach ($modSmsgateway as $i => $smsgateway) {
              if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
                $isiPesan = $smsgateway->templatesms;

                $attributes = $modPasienMasukPenunjang->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modPasien->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modPendaftaran->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modRuangan->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }

                $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPasienMasukPenunjang->tglmasukpenunjang), $isiPesan);

                if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                  if (!empty($modPasien->no_mobile_pasien)) {
                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                  } else {
                    $smspasien = 0;
                  }
                }
              }
            }
          }
          // END SMS GATEWAY

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pemeriksaan laboratorium berhasil disimpan !");
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id, 'sukses' => 1, 'smspasien' => $smspasien));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan [" . $this->pasienpenunjangtersimpan . " ," . $this->tindakanpelayanantersimpan . " ," . $this->komponentindakantersimpan . " ," . $this->hasilpemeriksaantersimpan . " ," . $this->obatalkespasientersimpan ."]!");
                                //  echo "-".$this->pasienpenunjangtersimpan."<br>";
                                //  echo "-".$this->tindakanpelayanantersimpan."<br>";
                                //  echo "-".$this->komponentindakantersimpan."<br>";
                                //  echo "-".$this->hasilpemeriksaantersimpan."<br>";
                                //  echo "-".$this->obatalkespasientersimpan."<br>";
                                //  exit;
        }
      } catch (Exception $exc) {
        echo '<pre>'; var_dump($exc); die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    // $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    // $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render($index, array(
      'modKunjungan' => $modKunjungan,
      'modPemeriksaanLab' => $modPemeriksaanLab,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modTindakan' => $modTindakan,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'dataTindakans' => $dataTindakans,
      'modSmsgateway' => $modSmsgateway,
      'modKarcisV' => $modKarcisV,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
    ));
  }

  public function simpanPermintaanKePenunjang($tindakan)
  {
    $permintaan = new PermintaankepenunjangT;
    $permintaan->daftartindakan_id = $tindakan->daftartindakan_id;
    $permintaan->pasienkirimkeunitlain_id = $_GET['pasienkirimkeunitlain_id'];
    $permintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PL');
    $permintaan->tglpermintaankepenunjang = date('Y-m-d H:i:s');
    $permintaan->tarif_pelayananan = doubleval($tindakan->tarif_tindakan);
    $permintaan->qtypermintaan = $tindakan->qty_tindakan;
    $permintaan->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;

    if ($permintaan->save()) {
      $this->permintaankepenunjangtersimpan &= true;
    } else {
      echo '<pre>'; var_dump($permintaan->getErrors()); die;
      $this->permintaankepenunjangtersimpan &= false;
    }

    return $permintaan;
  }



  public function simpanObatAlkesPasien2($modPasienMasukPenunjang, $postDetail)
  {
    $modObatAlkesPasien = new LBObatalkespasienT;
    // var_dump($postDetail);
    $oa = ObatalkesM::model()->findByPk($postDetail['obatalkes_id']);
    $modObatAlkesPasien->attributes = $postDetail;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
    $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
    $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
    $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
    $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
    $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
    $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
    $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
    $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');
    $modObatAlkesPasien->qty_oa = $postDetail['qty_oa']; //$stokOa->qtystok_terpakai;
    //$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stokOa->HPP;
    $modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stokOa->HargaJualSatuan;
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
    //foreach ($postObatAlkesPasien AS $i => $postDetail) {
    //if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
    $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
    $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
    // $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];                
    //}
    //}
    //var_dump($modObatAlkesPasien->validate());         
    //var_dump($modObatAlkesPasien->errors);
    //var_dump($modObatAlkesPasien->attributes); die;

    if ($modObatAlkesPasien->save()) {
      $this->obatalkespasientersimpan &= true;
    } else {
      $this->obatalkespasientersimpan &= false;
    }

    //        old
    //        $modObatAlkesPasien = new ROObatalkespasienT;
    //        $modObatAlkesPasien->attributes = $post;
    //        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    //        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //        $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
    //        $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    //        $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
    //        $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
    //        $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
    //        $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
    //        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    //        $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
    //        $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
    //        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
    //        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    //        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
    //        
    //        if($modObatAlkesPasien->validate()) {
    //            $modObatAlkesPasien->save();
    //            StokobatalkesT::kurangiStok($modObatAlkesPasien->qty_oa, $modObatAlkesPasien->obatalkes_id);
    //        } else {
    //            $this->obatalkespasientersimpan &= false;
    //        }
    return $modObatAlkesPasien;
  }


  /**
   * simpan LBObatalkespasienT
   * @param type $modPasienMasukPenunjang
   * @param type $stokOa
   * @param type $postObatAlkesPasien
   * @return \LBObatalkespasienT
   * copy dari : PemakaianBmhpController
   */
  public function simpanObatAlkesPasien($modPasienMasukPenunjang, $stokOa, $postObatAlkesPasien)
  {
    $modObatAlkesPasien = new LBObatalkespasienT;
    $modObatAlkesPasien->attributes = $stokOa->attributes;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
    $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
    $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
    $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
    $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
    $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
    $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
    $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
    $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');
    $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
    $modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
    foreach ($postObatAlkesPasien as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
      }
    }

    if ($modObatAlkesPasien->save()) {
      $this->obatalkespasientersimpan &= true;
    } else {
      echo "c";
      exit;
      $this->obatalkespasientersimpan &= false;
    }

    //        old
    //        $modObatAlkesPasien = new LBObatalkespasienT;
    //        $modObatAlkesPasien->attributes = $post;
    //        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    //        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //        $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
    //        $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    //        $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
    //        $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
    //        $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
    //        $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
    //        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    //        $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
    //        $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
    //        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
    //        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    //        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
    //        
    //        if($modObatAlkesPasien->validate()) {
    //            $modObatAlkesPasien->save();
    //            StokobatalkesT::kurangiStok($modObatAlkesPasien->qty_oa, $modObatAlkesPasien->obatalkes_id);
    //        } else {
    //            $this->obatalkespasientersimpan &= false;
    //        }
    return $modObatAlkesPasien;
  }

  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modObatAlkesPasien
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesOut2($modObatAlkesPasien)
  {
    $format = new MyFormatter;
    $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
    //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $oa->attributes;
    $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
    // $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
    $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    //var_dump($modStokOaNew->validate());
    //var_dump($modStokOaNew->errors);
    //var_dump($modStokOaNew->attributes); die;

    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();
      //$modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }


  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modObatAlkesPasien
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesOut($stokobatalkesasal_id, $modObatAlkesPasien)
  {
    $format = new MyFormatter;
    $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
    $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    if ($modStokOaNew->validateStok()) {
      $modStokOaNew->save();
      $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $models = LBPasienKirimKeUnitLainV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . '-' . $model->no_rekam_medik . '-' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - pasienkirimkeunitlain_id
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $model = LBPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["namalengkapdokter"] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * set LBPermintaanKePenunjangT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetPermintaanKePenunjang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $rowTablePemeriksaan = "";
      $rows_pemeriksaan = [];
      $modPermintaans = LBPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));
      $modTindakan = new LBTindakanPelayananT;
      if (count((array)$modPermintaans) > 0) {
        foreach ($modPermintaans as $i => $modPermintaan) {
          $modPemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('pemeriksaanlab_id' => $modPermintaan->pemeriksaanlab_id));
          $daftartindakan = DaftartindakanM::model()->find(" daftartindakan_id = " . $modPemeriksaan->daftartindakan_id);

          $perda = TariftindakanperdaruanganV::model()->find(" daftartindakan_id = '$daftartindakan->daftartindakan_id' and kelaspelayanan_id in (5, 6) order by kelaspelayanan_id asc");

          $perda_rj = TariftindakanperdaruanganV::model()->find(" daftartindakan_id = '$daftartindakan->daftartindakan_id' and kelaspelayanan_id = 6");
          $perda_k3 = TariftindakanperdaruanganV::model()->find(" daftartindakan_id = '$daftartindakan->daftartindakan_id' and kelaspelayanan_id = 5");

          if(!empty($perda)) {
            $modPemeriksaanTemp = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $perda->daftartindakan_id));
            if(!empty($perda)) {
              $modPemeriksaan = $modPemeriksaanTemp;
            }
          }

          if (isset($modPemeriksaan->daftartindakan_id)) {
            $modPermintaan->daftartindakan_id = $perda->daftartindakan_id ?? null;
            $tindakanpelayanan = !empty($modPermintaan->tindakanpelayanan_id);
            $modPermintaan->tipepaket_id = ($tindakanpelayanan) ? $modPermintaan->tindakanpelayanan->tipepaket_id : null;
            $jenistarif_id = null;
            if ($tindakanpelayanan) {
                $penjamin = JenistarifpenjaminM::model()->findByAttributes(['penjamin_id' => $modPermintaan->tindakanpelayanan_id]);
                if (!empty($penjamin)) {
                    $jenistarif_id = $penjamin->jenistarif_id;
                }
            }
            $modPermintaan->jenistarif_id = $jenistarif_id;
            
            $modPermintaan->tarif_tindakan = 0;
            $modPermintaan->tarif_pelayananan = 0;

            if(!empty($perda_rj)) {
              $modPermintaan->tarif_tindakan = $perda_rj->harga_tariftindakan;
              $modPermintaan->tarif_pelayananan = $perda_rj->harga_tariftindakan;
            }

            if(!empty($perda_k3)) {
              $modPermintaan->tarif_tindakan = $perda_k3->harga_tariftindakan;
              $modPermintaan->tarif_pelayananan = $perda_k3->harga_tariftindakan;
            }

            $modPermintaan->tarif_satuan = ($tindakanpelayanan) ? $modPermintaan->tindakanpelayanan->tarif_satuan : null;
            $modPermintaan->satuantindakan = ($tindakanpelayanan) ? $modPermintaan->tindakanpelayanan->satuantindakan : null;
            $modPermintaan->tindakansudahbayar_id = ($tindakanpelayanan) ? $modPermintaan->tindakanpelayanan->tindakansudahbayar_id : null;
            $modPermintaan->qty_tindakan = ($tindakanpelayanan) ? $modPermintaan->tindakanpelayanan->qty_tindakan : null;

            //pilihPemeriksaanIniPenunjang(pemeriksaanlab_nama, pemeriksaanlab_id, daftartindakan_id, jenistarif_id, harga_tariftindakan, daftartindakan_kode, kelaspelayanan_id) {

            $rows_pemeriksaan[$i] = [
              'pemeriksaanlab_nama' => $modPemeriksaan->pemeriksaanlab_nama, 
              'pemeriksaanlab_id' => $modPemeriksaan->pemeriksaanlab_id,
              'daftartindakan_id' => $daftartindakan->daftartindakan_id, 
              'jenistarif_id' => $jenistarif_id, 
              'harga_tariftindakan' => $modPermintaan->tarif_tindakan,
              'daftartindakan_kode' => $daftartindakan->daftartindakan_kode, 
              'kelaspelayanan_id' => 5,
              'jenispemeriksaanlab_nama' => $modPemeriksaan->jenispemeriksaan->jenispemeriksaanlab_nama ?? ''
            ];


            $view = (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_LAB) ? '_rowPermintaanKePenunjang' : '_rowPermintaanKePenunjangPA';
            $rows .= $this->renderPartial($this->path_view . $view, array('i' => 0, 'modPermintaan' => $modPermintaan), true);

            if(Yii::app()->user->getState('instalasi_id') !== Params::INSTALASI_ID_LAB) {
              $modTarif = LBTariftindakanM::model()->findByAttributes(['daftartindakan_id' => $daftartindakan->daftartindakan_id, 'komponentarif_id' => 6]);
              $modTindakan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
              $modTindakan->kelaspelayanan_id = $modPermintaan->pasienkirimkeunitlain->pendaftaran->kelaspelayanan_id ?? '';
              $modTindakan->nopelayanan = '- terisi otomatis -';
              $modTindakan->daftartindakan_nama = $modPermintaan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama ?? '';
              $modTindakan->daftartindakan_kode = $daftartindakan->daftartindakan_kode ?? '';
              $modTindakan->samplelab_id = $modPermintaan->samplelab_id ?? '';
              $modTindakan->pemeriksaanlab_id = $modPermintaan->pemeriksaanlab_id ?? '';
              $modTindakan->daftartindakan_id = $modPermintaan->daftartindakan_id ?? '';
              $modTindakan->jenistarif_id = $modTarif->jenistarif_id ?? '';
              $modTindakan->tarif_satuan = $modTarif->harga_tariftindakan ?? '';
              $modTindakan->tarif_tindakan = $modTarif->harga_tariftindakan ?? '';
              $modTindakan->satuantindakan = 'KALI';
              $rowTablePemeriksaan .= $this->renderPartial($this->path_view . '_rowTindakanPemeriksaanPA', array('i' => $i, 'modTindakan' => $modTindakan), true);
            }
          }
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows,
        'rowTablePemeriksaan' => $rowTablePemeriksaan,
        'rows_pemeriksaan' => $rows_pemeriksaan
      ));
    }
    Yii::app()->end();
  }

  /**
   * set LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modTindakans = LBTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {
          $modTindakan->pemeriksaanlab_id = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->pemeriksaanlab_id;
          $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
          $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
          $modTindakan->tarif_satuan = $format->formatNumberForUser($modTindakan->tarif_satuan);
          $rows .= $this->renderPartial($this->path_view_pendaftaran . "_rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

    /**
   * set LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetTindakanPelayananAfterSave()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modTindakans = LBTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {
          $modTindakan->pemeriksaanlab_id = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->pemeriksaanlab_id;
          $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
          $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
          $modTindakan->tarif_satuan = $format->formatNumberForUser($modTindakan->tarif_satuan);
          $modTindakan->nopelayanan = $modTindakan->pendaftaran->no_pendaftaran . $modTindakan->nopelayanan;
          $rows .= $this->renderPartial($this->path_view . "_rowTindakanPemeriksaan2", array('i' => 0, 'modTindakan' => $modTindakan), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * menampilkan obat
   * @return row table 
   */
  public function actionSetFormObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new LBObatalkespasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      $oa = ObatalkesM::model()->findByPk($obatalkes_id);
      //if(count((array)$modStokOAs) > 0){

      //    foreach($modStokOAs AS $i => $stok){
      $modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
      $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
      $modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
      $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
      $modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stok->HargaJualSatuan;
      $modObatAlkesPasien->qty_stok = 0; //$stok->qtystok;
      $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
      $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
      $modObatAlkesPasien->biayaservice = 0;
      $modObatAlkesPasien->biayakonseling = 0;
      $modObatAlkesPasien->jasadokterresep = 0;
      $modObatAlkesPasien->biayakemasan = 0;
      $modObatAlkesPasien->biayaadministrasi = 0;
      $modObatAlkesPasien->tarifcyto = 0;
      $modObatAlkesPasien->discount = 0;
      $modObatAlkesPasien->subsidiasuransi = 0;
      $modObatAlkesPasien->subsidipemerintah = 0;
      $modObatAlkesPasien->subsidirs = 0;
      $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
      $modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
      $modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;

      $form .= $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien), true);
      //    }
      //}else{
      //    $pesan = "Stok tidak mencukupi!";
      //}

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionSetKarcis()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $konfig = KonfigsystemK::model()->find();

      $format = new MyFormatter();
      $modTindakan = new PPTindakanPelayananT();
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
      $ruangan_id = Params::RUANGAN_ID_LAB_KLINIK;
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $penjamin_id = $_POST['penjamin_id'];
      $form = '';
      $is_pasienbaru = 'true';

      if (!empty($ruangan_id)) {
        if (!empty($pasien_id)) {
          $modP = PendaftaranT::model()->findByPk($pendaftaran_id);
          if (isset($modP)) {
            if ($modP->kunjungan == "KUNJUNGAN BARU") {
              $is_pasienbaru = 'true';
              $karcis_id = 537; // karcis id biaya administrasi laboratorium pasien baru
            } else {
              $is_pasienbaru = 'false';
              $karcis_id = 538; // karcis id biaya administrasi laboratorium pasien lamas
            }
          }
        } else {
          $is_pasienbaru = 'false';
        }
        $criteria = new CdbCriteria();
        $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        $criteria->addCondition("ruangan_id = " . $ruangan_id);
        $criteria->addCondition("penjamin_id = " . $penjamin_id);
        if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
          $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
        }
        $criteria->addCondition("karcis_id = " . $karcis_id);

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

  public function simpanKarcis($modTindakan, $model, $post)
  {
    $modTindakan->attributes = $post;
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    //$modTindakan->instalasi_id=Yii::app()->user->getState("instalasi_id");
    $modTindakan->instalasi_id = Params::INSTALASI_ID_LAB;
    //$modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTindakan->ruangan_id = Params::RUANGAN_ID_LAB_KLINIK;
    $modTindakan->pendaftaran_id = $model->pendaftaran_id;
    $modTindakan->kelaspelayanan_id = $model->kelaspelayanan_id;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;

    $modCaraBayar = null;
    $modPenjamin = null;

    if (!empty($model->pasienadmisi_id)) {
      $modAdmisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
      $modPenjamin = $modAdmisi->penjamin_id;
      $modCaraBayar = $modAdmisi->carabayar_id;
    } else {
      $modPend = PendaftaranT::model()->findByPk($model->pendaftaran_id);
      $modPenjamin = $modPend->penjamin_id;
      $modCaraBayar = $modPend->carabayar_id;
    }


    $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

    if(!empty($md_noawal)) {
      $noawal = intval($md_noawal->nopelayanan);
    } else {
      $noawal = 0;
    }

    $modTindakan->nopelayanan = str_pad($noawal+1,3,"0",STR_PAD_LEFT);


    $modTindakan->carabayar_id = $modCaraBayar;
    $modTindakan->penjamin_id = $modPenjamin;
    $modTindakan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
    $modTindakan->pasien_id = $model->pasien_id;
    $modTindakan->dokterpemeriksa1_id = $model->pegawai_id;
    $modTindakan->karcis_id = $post['karcis_id'];
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakan->qty_tindakan = 1;
    //        $modTindakan->tarif_satuan=$modTindakan->getTarifSatuan();
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
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($modTindakan, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }

    // echo '<pre>'; var_dump($modTindakan->attributes); die;

    if ($modTindakan->save()) {
      $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      $this->karcistersimpan = true;
    } else {
      $this->karcistersimpan = false;
    }

    return $modTindakan;
  }

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
    if (isset($paket)) $result = $paket->tipepaket_id;

    return $result;
  }
}

<?php
Yii::import('laboratorium.controllers.PendaftaranLaboratoriumController');
Yii::import("laboratorium.models.*");
class PendaftaranLaboratoriumRujukanRSMKController extends PendaftaranLaboratoriumController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "mikrobiologiKlinik.views.pendaftaranLaboratoriumRujukanRSMK.";
  public $path_view_pendaftaran = "mikrobiologiKlinik.views.pendaftaranLaboratorium.";
  public $obatalkespasientersimpan = true; //di looping
  public $stokobatalkestersimpan = true; //looping
  public $karcistersimpan = true; //looping
  public $komponentindakantersimpan = true;
  public $permintaankepenunjangtersimpan = true;

  /**
   * Tambah / Ubah Pemeriksaan Laboratorium.
   */
  public function actionIndex($pasienmasukpenunjang_id = null, $pendaftaran_id = null, $instalasi_id = null, $program = null)
  {

    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $index = ($instalasi_id != Params::RUANGAN_ID_LAB_ANATOMI) ? 'index' : 'indexPA';

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
      if(!empty($modKunjungan->pasienadmisi_id)) {

        $nopd = $modKunjungan->no_pendaftaran;

        $str = $nopd;
        $chars = str_split($str);

        $pd = '';

        // echo '<pre>';
        foreach ($chars as $char) {
            // echo "<br>";
            if(is_numeric($char)) {
              $pd .= $char;
            }
        }

        $modKunjungan->no_pendaftaran = "RI".$pd;

        $admisi = PasienadmisiT::model()->findByPk($modKunjungan->pasienadmisi_id);
        $modKunjungan->kelaspelayanan_id = $admisi->kelaspelayanan_id;
        $modKunjungan->kelaspelayanan_nama = $admisi->kelaspelayanan->kelaspelayanan_nama;

      }
      //var_dump($modKunjungan->attributes); die;
      
      $pendaftaran = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
      $modPemeriksaanLab->kelaspelayanan_id = $pendaftaran->kelaspelayanan_id;
      if($modKunjungan){
          $modPasienMasukPenunjang->ppds_id = $modKunjungan->ppds_id;
          $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $modKunjungan->pasienkirimkeunitlain_id;
          $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modKunjungan->jeniskasuspenyakit_id;
          $modPasienMasukPenunjang->kelaspelayanan_id = $modKunjungan->kelaspelayanan_id;
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

        $tindakan = isset($_POST['LBTindakanPelayananT']) ? $_POST['LBTindakanPelayananT'] : null;

        $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $_POST['LBPasienmasukpenunjangT'], true, $tindakan);
        // var_dump($modPasienMasukPenunjang->ruangan_id); die;
        if (!empty($_POST['LBPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])) {
          $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $_POST['LBPasienmasukpenunjangT']['pasienkirimkeunitlain_id'];
          $pasienkirimterupdate = $modPasienMasukPenunjang->save(false);
          $modkirimUnit->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
          $modkirimUnit->save(false, array('pasienmasukpenunjang_id'));
        } else {
          $pasienkirimterupdate = true;
        }
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

            // echo '<pre>';
            // var_dump($_POST['LBTindakanPelayananT']); die;
            $jenispemeriksaanlab_id_temp = '';
            $samplelab_id_temp = '';
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
                $dataTindakans[$ii]->pasienadmisi_id = $modPendaftaran->pasienadmisi_id ?? null;
                if (empty($dataTindakans[$ii]->pasienmasukpenunjang_id))
                  $dataTindakans[$ii]->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;

                $daftartindakan = DaftartindakanM::model()->find(" daftartindakan_id = " . $dataTindakans[$ii]->daftartindakan_id);
                $nama_tindakan = str_replace("'", "''", $daftartindakan->daftartindakan_nama);


                $perda = TariftindakanperdaruanganV::model()->find(" daftartindakan_nama = '$nama_tindakan' and kelaspelayanan_id = 5");

                if(!empty($perda)) {
                  $dataTindakans[$ii]->tarif_satuan = !empty($perda) ? $perda->harga_tariftindakan : 0;
                  $dataTindakans[$ii]->qty_tindakan = $tindakan['qty_tindakan'];
                  $dataTindakans[$ii]->tarif_tindakan = intval($dataTindakans[$ii]->tarif_satuan) * intval($dataTindakans[$ii]->qty_tindakan);
                  // $modPemeriksaanTemp = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $perda->daftartindakan_id));
                  // if(!empty($perda)) {
                    //   $modPemeriksaan = $modPemeriksaanTemp;
                    // }
                }

                $dataTindakans[$ii]->jenispemeriksaanlab_id = isset($tindakan['jenispemeriksaanlab_id']) ? $tindakan['jenispemeriksaanlab_id'] : null;


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
              // var_dump($dataTindakans[$ii]->attributes);
              //untuk ditampilkan di form
              $dataTindakans[$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);

              $permintaan[$ii] = $this->simpanPermintaanKepenunjang($dataTindakans[$ii]);

              if($program == 'non') {
                if(intval($dataTindakans[$ii]->qty_tindakan) > 0) {

                  $sample = SamplelabM::model()->findByPk($dataTindakans[$ii]->samplelab_id);
                  $jenis = JenispemeriksaanlabM::model()->findByPk($dataTindakans[$ii]->jenispemeriksaanlab_id);

                  $jenispemeriksaanlab_id_temp = $dataTindakans[$ii]->jenispemeriksaanlab_id;
                  if(!empty($sample)) {
                    $samplelab_id_temp = $sample->samplelab_id;
                  }
                 
                  if($jenispemeriksaanlab_id_temp == $dataTindakans[$ii]->jenispemeriksaanlab_id) {
                    if(empty($sample) && !empty($samplelab_id_temp)) {
                      $sample = SamplelabM::model()->findByPk($samplelab_id_temp);
                    }
                  }
                  
                  $jumlah = !empty($sample->jumlah) ? $sample->jumlah : 1;

                  for($i = 1; $i <= $jumlah; $i++) {
                    $modAmbilSample = new PengambilansampleT;
                    $modAmbilSample->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
                    $modAmbilSample->tglpengambilansample = $dataTindakans[$ii]->tgl_tindakan;
                    $modAmbilSample->samplelab_id = $dataTindakans[$ii]->samplelab_id;
                    $modAmbilSample->jenispemeriksaanlab_id = $dataTindakans[$ii]->jenispemeriksaanlab_id;

                    $modAmbilSample->jmlpengambilansample = 1;

                    $jml_pertahun = PengambilansampleT::model()->count(" date_part('year', create_time)::varchar(200) = '" . date('Y') . "'");

                    // var_dump($jml_pertahun); die;

                    $nomor_lab = $sample->kode_sample . "" . date('ymd') . "" . ($jml_pertahun + 1) . "" . $jenis->jenispemeriksaanlab_kode; 

                    $modAmbilSample->no_pengambilansample = $nomor_lab;

                    $modAmbilSample->create_time = date('Y-m-d H:i:s');
                    $modAmbilSample->create_loginpemakai_id = Yii::app()->user->id;
                    $modAmbilSample->create_ruangan = Yii::app()->user->getState('ruangan_id');

                    $simpansample = $modAmbilSample->save();

                    // echo '<pre>'; var_dump($simpansample, $modAmbilSample->attributes);
                    
                  }
                  // die;
                }
              } else {
                $sample = SamplelabM::model()->findByPk($dataTindakans[$ii]->samplelab_id);
                $jenis = JenispemeriksaanlabM::model()->findByPk($dataTindakans[$ii]->jenispemeriksaanlab_id);

                $modAmbilSample = new PengambilansampleT;
                $modAmbilSample->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
                $modAmbilSample->tglpengambilansample = $dataTindakans[$ii]->tgl_tindakan;
                $modAmbilSample->samplelab_id = $dataTindakans[$ii]->samplelab_id;
                $modAmbilSample->jenispemeriksaanlab_id = $dataTindakans[$ii]->jenispemeriksaanlab_id;

                $modAmbilSample->jmlpengambilansample = $dataTindakans[$ii]->qty_tindakan;

                $jml_pertahun = PengambilansampleT::model()->count(" date_part('year', create_time)::varchar(200) = '" . date('Y') . "'");

                $nomor_lab = $sample->kode_sample . "" . date('ymd') . "" . ($jml_pertahun + 1) . "" . $jenis->jenispemeriksaanlab_kode; 

                $modAmbilSample->no_pengambilansample =$tindakan['nopelayanan'];

                $modAmbilSample->create_time = date('Y-m-d H:i:s');
                $modAmbilSample->create_loginpemakai_id = Yii::app()->user->id;
                $modAmbilSample->create_ruangan = Yii::app()->user->getState('ruangan_id');

                $simpansample = $modAmbilSample->save();

                                    // echo '<pre>'; var_dump($modAmbilSample->attributes);


              }
            } 
            // die;
          }
        }

        // die;

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
          // var_dump("OK"); die;

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pemeriksaan laboratorium berhasil disimpan !");
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id, 'sukses' => 1, 'smspasien' => $smspasien, 'program'=>$program));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan !");
          //                        echo "-".$this->pasienpenunjangtersimpan."<br>";
          //                        echo "-".$this->tindakanpelayanantersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
          //                        echo "-".$this->obatalkespasientersimpan."<br>";
          //                        exit;
        }
      } catch (Exception $exc) {
        echo '<pre>'; var_dump($exc); die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'dialog-tariftindakan-m-grid') {
        $this->renderPartial($this->path_view . '_dialogDaftarPemeriksaan');
        Yii::app()->end();
      }
    }
    // $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    // $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render($this->path_view.$index, array(
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
      // echo '<pre>'; var_dump($permintaan->getErrors()); die;
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

      // var_dump("tes set permintaan"); die;
      $format = new MyFormatter();
      $rows = "";
      $rows_pemeriksaan = "";

      $kirim = PasienkirimkeunitlainT::model()->findByPk($_POST['pasienkirimkeunitlain_id']);

      $cr = new CDbCriteria;
      $cr->join = "join pemeriksaanlab_m p on p.pemeriksaanlab_id = t.pemeriksaanlab_id join jenispemeriksaanlab_m j on j.jenispemeriksaanlab_id = p.jenispemeriksaanlab_id";
      $cr->addCondition('pasienkirimkeunitlain_id = ' . $_POST['pasienkirimkeunitlain_id']);
      $cr->order = "j.jenispemeriksaanlab_id, t.samplelab_id";
      $modPermintaans = LBPermintaanKePenunjangT::model()->findAll($cr);
      
      $modKirim = null;
      $modPendaftaran = null;
      $modAdmisi = null;

      $jenis = "";
      $jenis_sblm = "";
      
      if (count((array)$modPermintaans) > 0) {
        foreach ($modPermintaans as $i => $modPermintaan) {


          if (empty($modKirim)) {
            $modKirim = PasienkirimkeunitlainT::model()->findByPk($modPermintaan->pasienkirimkeunitlain_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($modKirim->pendaftaran_id);
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
          }

          $penjamin_id = $modAdmisi->penjamin_id ?? $modPendaftaran->penjamin_id ?? null;
          $modPermintaan->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id ?? $modPendaftaran->kelaspelayanan_id ?? null;
          // $modPermintaan->kelaspelayanan_id = Params::KELASPELAYANAN_ID_KELAS_II; //$modAdmisi->kelaspelayanan_id ?? $modPendaftaran->kelaspelayanan_id ?? null;

          $modPemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('pemeriksaanlab_id' => $modPermintaan->pemeriksaanlab_id));
          $modOrder = OrderpemeriksaanlabV::model()->findByAttributes(array(
            'pemeriksaanlab_id'=>$modPemeriksaan->pemeriksaanlab_id
          ));
          
          $daftartindakan = DaftartindakanM::model()->find(" daftartindakan_id = " . $modPemeriksaan->daftartindakan_id);

          if(isset($modPermintaan->pemeriksaanlab_id)) {
            $modPemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('pemeriksaanlab_id' => $modPermintaan->pemeriksaanlab_id));
          } else {

          }
          if (isset($modPemeriksaan->daftartindakan_id)) {
            $modPermintaan->daftartindakan_id = $modPemeriksaan->daftartindakan_id;
            $tindakanpelayanan = !empty($modPermintaan->tindakanpelayanan_id);
            $modPermintaan->tipepaket_id = ($tindakanpelayanan) ? $modPermintaan->tindakanpelayanan->tipepaket_id : null;
            $jenistarif_id = null;
            if ($tindakanpelayanan) {
                $penjamin = JenistarifpenjaminM::model()->findByAttributes(['penjamin_id' => $modPermintaan->tindakanpelayanan->tindakanpelayanan_id]);
                if (!empty($penjamin)) {
                    $jenistarif_id = $penjamin->jenistarif_id;
                }
            }


            if (!($tindakanpelayanan)) {
              // var_dump("Load tarif");
              $tarif = TarifpemeriksaanlabruanganV::model()->findByAttributes(array(
                'daftartindakan_id'=>$modPemeriksaan->daftartindakan_id,
                'penjamin_id'=>$penjamin_id,
                'kelaspelayanan_id'=>$modPermintaan->kelaspelayanan_id,
              ));
              $penjamin = JenistarifpenjaminM::model()->findByAttributes(['penjamin_id' => $penjamin_id]);
            }

            // var_dump($modPermintaan->kelaspelayanan_id);

            $modPermintaan->jenistarif_id = $penjamin->jenistarif_id ?? null;
            $modPermintaan->qty_tindakan = $modPermintaan->qtypermintaan;
            $modPermintaan->tarif_satuan = ($tarif->harga_tariftindakan ?? 0);
            $modPermintaan->tarif_tindakan = $modPermintaan->tarif_satuan * $modPermintaan->qty_tindakan;
            $modPermintaan->satuantindakan = ($tindakanpelayanan) ? $modPermintaan->tindakanpelayanan->satuantindakan : null;
            $modPermintaan->tindakansudahbayar_id = ($tindakanpelayanan) ? $modPermintaan->tindakanpelayanan->tindakansudahbayar_id : null;
            $modPermintaan->jenispemeriksaanlab_nama = $modOrder->jenispemeriksaanlab_nama ?? $modPemeriksaan->jenispemeriksaan->jenispemeriksaanlab_nama;
            $modPermintaan->subjenis_pemeriksaanlab_id = $modOrder->subjenis_pemeriksaanlab_id ?? null;
            $modPermintaan->subjenis_pemeriksaanlab_nama = $modOrder->subjenis_pemeriksaanlab_nama ?? null;


            $rows .= $this->renderPartial($this->path_view . "_rowPermintaanKePenunjang", array('i' => 10, 'modPermintaan' => $modPermintaan), true);
          
            if ($modPermintaan->tarif_satuan != 0) {

              $jenis = $modPermintaan->pemeriksaanlab->jenispemeriksaanlab_id;
              $program = $_POST['program'];
              $tindakan = new LBTindakanPelayananT;
              if($program == 'non') {
                $tindakan->nopelayanan = "- Terisi Otomatis -";
              }
              $tindakan->daftartindakan_nama = $modPemeriksaan->pemeriksaanlab_nama;
              $tindakan->tindakanpelayanan_id = $modPermintaan->tindakanpelayanan_id;
              $tindakan->tindakansudahbayar_id = $modPermintaan->tindakansudahbayar_id;
              $tindakan->jenispemeriksaanlab_id = $modPermintaan->pemeriksaanlab->jenispemeriksaanlab_id;
              $tindakan->jenispemeriksaanlab_nama = $modPermintaan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
              $tindakan->pemeriksaanlab_id = $modPermintaan->pemeriksaanlab_id;
              $tindakan->daftartindakan_id = $modPermintaan->daftartindakan_id;
              $tindakan->jenistarif_id = $modPermintaan->jenistarif_id;
              $tindakan->qty_tindakan = $modPermintaan->qty_tindakan;
              $tindakan->tarif_tindakan = $modPermintaan->tarif_tindakan;
              $tindakan->tarif_satuan = $modPermintaan->tarif_satuan;
              $tindakan->kelaspelayanan_id = $modPermintaan->kelaspelayanan_id;
              $tindakan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
              $tindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
              $tindakan->samplelab_id = $modPermintaan->samplelab_id;
              $tindakan->caraambilsampel_id = $modPermintaan->caraambilsampel_id ?? $modKirim->caraambilsampel_id;
              $tindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($modKirim->tglrencanapemeriksaan);
              // $tindakan->is_elektif = $modKirim->is_elektif;

              $sama = ($jenis == $jenis_sblm) ? "sama" : "beda";

              $rows_pemeriksaan .= $this->renderPartial("mikrobiologiKlinik.views.pendaftaranLaboratoriumRujukanRSMK._rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $tindakan, 'sama' => $sama, 'program'=>$program), true);
              
              $jenis_sblm = $jenis;
            }
          }
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows,
        'rows_pemeriksaan' => $rows_pemeriksaan
      ));
    }
    Yii::app()->end();
  }

  public function actionLoadTarifTindakanUntukKelas() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }


    $permintaankepenunjang_id = $_POST['permintaankepenunjang_id'] ?? null;
    $kelaspelayanan_id = $_POST['kelaspelayanan_id'] ?? null;
    $daftartindakan_id = $_POST['daftartindakan_id'] ?? null;
    $jenistarif_id = $_POST['jenistarif_id'] ?? null;
    $qty = $_POST['qty'] ?? null;

    $modPermintaan = LBPermintaanKePenunjangT::model()->findByPk($permintaankepenunjang_id);
    $modPemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('pemeriksaanlab_id' => $modPermintaan->pemeriksaanlab_id));


    $tarif = TarifpemeriksaanradruanganV::model()->findByAttributes(array(
      'daftartindakan_id'=>$modPemeriksaan->daftartindakan_id ?? $daftartindakan_id,
      'jenistarif_id'=>$jenistarif_id,
      'kelaspelayanan_id'=>$kelaspelayanan_id,
    ));

    $tarif_satuan = 0;
    $tarif_tindakan = 0;
    $tarif_tindakan_format = 0;

    if (!empty($tarif)) {
      $tarif_satuan = $tarif->harga_tariftindakan;
      $tarif_tindakan = $tarif_satuan * $qty;
      $tarif_tindakan_format = number_format($tarif_tindakan, 0);
    }

    echo CJSON::encode(array(
      'nilai'=>$tarif_tindakan,
      'nilai_format'=>$tarif_tindakan_format,
      'nilai_satuan'=>$tarif_satuan,
    ));

  }

  public function actionSetFormTindakanDariPermintaan0() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $rows = "";

    $permintaankepenunjang_id = $_POST['permintaankepenunjang_id'] ?? null;
    $kelaspelayanan_id = $_POST['kelaspelayanan_id'] ?? null;
    $daftartindakan_id = $_POST['daftartindakan_id'] ?? null;
    $pemeriksaanlab_id = $_POST['pemeriksaanlab_id'] ?? null;
    $jenistarif_id = $_POST['jenistarif_id'] ?? null;
    $qty = $_POST['qty'] ?? null;

    $modPermintaan = LBPermintaanKePenunjangT::model()->findByPk($permintaankepenunjang_id);
    $modPemeriksaan = PemeriksaanlabM::model()->findByAttributes(array('pemeriksaanlab_id' => $modPermintaan->pemeriksaanlab_id));

    $daftartindakan_id = $modPemeriksaan->daftartindakan_id ?? $daftartindakan_id;

    $tarif = TariftindakanM::model()->findByAttributes(array(
      'daftartindakan_id'=>$daftartindakan_id,
      'jenistarif_id'=>$jenistarif_id,
      'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL,
    ));

    // var_dump($modPermintaan->daftartindakan_id, $modPemeriksaan->daftartindakan_id); die;

    $tindakan = new LBTindakanPelayananT;
    $tindakan->nopelayanan = "- Terisi Otomatis -";
    $tindakan->daftartindakan_nama = $modPemeriksaan->pemeriksaanlab_nama;
    $tindakan->tindakanpelayanan_id = $modPermintaan->tindakanpelayanan_id;
    $tindakan->tindakansudahbayar_id = $modPermintaan->tindakansudahbayar_id;
    $tindakan->pemeriksaanlab_id = $modPemeriksaan->pemeriksaanlab_id;
    $tindakan->daftartindakan_id = $modPemeriksaan->daftartindakan_id;
    $tindakan->jenistarif_id = $jenistarif_id;
    $tindakan->qty_tindakan = $qty;
    $tindakan->tarif_satuan = $tarif->harga_tariftindakan ?? 0;
    $tindakan->tarif_tindakan = $tindakan->tarif_satuan * $qty;
    $tindakan->kelaspelayanan_id = $kelaspelayanan_id;
    $tindakan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $tindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
    $tindakan->samplelab_id = $modPermintaan->samplelab_id;
    $tindakan->caraambilsampel_id = $modPermintaan->caraambilsampel_id;

    $rows .= $this->renderPartial("mikrobiologiKlinik.views.pendaftaranLaboratoriumRujukanRSMK._rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $tindakan), true);

    echo CJSON::encode(array(
      'rows' => $rows,
    ));

  }

  public function actionTambahTarifTindakanPaket() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $rows = "";
    $tipepaket_id = $_POST['tipepaket_id'];
    $pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];

    $modKirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($modKirim->pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

    $penjamin_id = $modAdmisi->penjamin_id ?? $modPendaftaran->penjamin_id ?? null;
    $kelaspelayanan_id = $modAdmisi->kelaspelayanan_id ?? $modPendaftaran->kelaspelayanan_id ?? null;

    $jenispenjamin = JenistarifpenjaminM::model()->findByAttributes(array(
      'penjamin_id'=>$penjamin_id
    ));

    $pelayanan = PaketpelayananM::model()->findAllByAttributes(array(
      'tipepaket_id'=>$tipepaket_id
    ));

    foreach ($pelayanan as $item) {

      $periksa = PemeriksaanlabM::model()->findByAttributes(array(
        'daftartindakan_id'=>$item->daftartindakan_id
      ));

      if (empty($periksa)) {
        continue;
      }

      // var_dump($item->attributes);

      $tindakan = new LBTindakanPelayananT;
      $tindakan->daftartindakan_nama = $periksa->pemeriksaanlab_nama;
      $tindakan->tindakanpelayanan_id = null;
      $tindakan->tindakansudahbayar_id = null;
      $tindakan->pemeriksaanlab_id = $periksa->pemeriksaanlab_id;
      $tindakan->daftartindakan_id = $periksa->daftartindakan_id;
      $tindakan->jenistarif_id = $jenispenjamin->jenistarif_id;
      $tindakan->qty_tindakan = $item->qty_tindakan;
      $tindakan->tarif_satuan = ($item->iurbiaya ?? 0) / ($item->qty_tindakan ?? 1);
      $tindakan->tarif_tindakan = $tindakan->tarif_satuan * $tindakan->qty_tindakan;
      $tindakan->kelaspelayanan_id = $kelaspelayanan_id;
      $tindakan->tipepaket_id = $item->tipepaket_id;
      $tindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
  
  
      $rows .= $this->renderPartial("mikrobiologiKlinik.views.pendaftaranLaboratoriumRujukanRSMK._rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $tindakan), true);

    }


    echo CJSON::encode(array(
      'rows' => $rows,
    ));

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

        $jenis = "";
        $jenis_sblm = "";

        foreach ($modTindakans as $i => $modTindakan) {

          $jenis = $modTindakan->jenispemeriksaanlab_id;

          $modTindakan->daftartindakan_nama = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->pemeriksaanlab_nama;
          $modTindakan->pemeriksaanlab_id = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->pemeriksaanlab_id;
          $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
          $modTindakan->tarif_tindakan = $modTindakan->tarif_tindakan;
          $modTindakan->tarif_satuan = $modTindakan->tarif_satuan;
          $modTindakan->nopelayanan = $modTindakan->no_lab;
          $modTindakan->no_lab = null;

          $sama = ($jenis == $jenis_sblm) ? "sama" : "beda";

          $rows .= $this->renderPartial("mikrobiologiKlinik.views.pendaftaranLaboratoriumRujukanRSMK._rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan, 'sama'=>$sama), true);

          $jenis_sblm = $jenis;

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

  /**
   * proses simpan LBTindakanPelayananT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post, $no_nota = null)
  {
    $modTindakan = new LBTindakanPelayananT;
    
    $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

    if(!empty($md_noawal)) {
      $noawal = intval($md_noawal->nopelayanan);
    } else {
      $noawal = 1;
    }


    $modTindakan->attributes = $modPendaftaran->attributes;
    // $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->kelaspelayanan_id = !empty($modPasienMasukPenunjang->kelaspelayanan_id) ? $modPasienMasukPenunjang->kelaspelayanan_id : Params::KELASPELAYANAN_ID_TANPA_KELAS;
    
    $modTindakan->attributes = $post;
    $modTindakan->pasienadmisi_id = $modPendaftaran->pasienadmisi_id ?? null;
    $modTindakan->samplelab_id = $post['samplelab_id'];
    $modTindakan->caraambilsampel_id = isset($post['caraambilsampel_id']) ? $post['caraambilsampel_id'] : null;
    $modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->qty_tindakan = (float)$modTindakan->qty_tindakan;
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
    $modTindakan->tarif_satuan = is_numeric($modTindakan->tarif_satuan) ? $modTindakan->tarif_satuan : MyFormatter::formatRupiahForDB($modTindakan->tarif_satuan);

    $daftartindakan = DaftartindakanM::model()->find(" daftartindakan_id = " . $modTindakan->daftartindakan_id);
    $nama_tindakan = str_replace("'", "''", $daftartindakan->daftartindakan_nama);

        
    // echo '<pre>'; var_dump($modTindakan->attributes); die;

    $perda = TariftindakanperdaruanganV::model()->find(" daftartindakan_nama = '$nama_tindakan' and kelaspelayanan_id = 5");

    if(!empty($perda)) {
      $modTindakan->tarif_satuan = !empty($perda) ? $perda->harga_tariftindakan : 0;
      $modTindakan->tarif_tindakan = floatval($modTindakan->tarif_satuan) * floatval($modTindakan->qty_tindakan);
      // $modPemeriksaanTemp = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $perda->daftartindakan_id));
      // if(!empty($perda)) {
        //   $modPemeriksaan = $modPemeriksaanTemp;
        // }
    }

    $modTindakan->nopelayanan = str_pad($noawal+1,3,"0",STR_PAD_LEFT);


    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
    $modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    if (!empty($_POST['tgl_tindakan_semua'])) {
      $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($_POST['tgl_tindakan_semua']);
    } else {
      $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    }

    // $modTindakan->cyto_tindakan = 0;
    // $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;
    $modTindakan->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    $kirim = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
    $kelas = empty($kirim) ? $modPasienMasukPenunjang->kelaspelayanan_id : $kirim->kelaspelayanan_id;
    $modTarif = TariftindakanM::model()->findByAttributes(array(
      'kelaspelayanan_id' => $kelas,
      'daftartindakan_id' => $modTindakan->daftartindakan_id,
      'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL
    ));
    if (!empty($kirim)) {
      $modTindakan->cyto_tindakan = $kirim->is_cyto;
    } else {
      $modTindakan->cyto_tindakan = false;
    }

    $modTindakan->tarifcyto_tindakan = !$modTindakan->cyto_tindakan ? 0 : $modTarif->totaltarifakhir_cyto;


    $modTindakan->nopelayanan = str_pad($no_nota,3,"0",STR_PAD_LEFT);


    // generate no lab
    if (!empty($kirim)) {
      // var_dump($post);
      $sample = SamplelabM::model()->findByPk($post['samplelab_id']);
      $permintaan = PermintaankepenunjangT::model()->findByAttributes(array(
        'pasienkirimkeunitlain_id'=>$kirim->pasienkirimkeunitlain_id,
        'pemeriksaanlab_id'=>$post['pemeriksaanlab_id']
      ));
      // var_dump($permintaan->attributes);
      if (!empty($sample)) { // && !empty($permintaan)) {

        //$kode = $sample->kode_sample

        //$kode = filter_var($permintaan->noperminatanpenujang, FILTER_SANITIZE_NUMBER_INT);
        $head = $sample->kode_sample.date('ymd').$modTindakan->nopelayanan;

        $modTindakan->no_lab = $head;

        // var_dump($kode, $head);
        // vaR_dump($sample->attributes); die;
      }
    }

    $modTindakan->jenispemeriksaanlab_id = $post['jenispemeriksaanlab_id'];



    // echo '<pre>';
    // var_dump($modTindakan->attributes); 
    // die;
    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    // var_dump($post, $modTindakan->errors, $modTarif->attributes, $modTindakan->attributes); die;

    return $modTindakan;
  }

  public function actionPrintBarcode($pasienmasukpenunjang_id) {
    $format = new MyFormatter;
        
    $crit = new CDbCriteria;
    $crit->select = 'no_lab';
    $crit->distinct = true;
    $crit->addCondition('pasienmasukpenunjang_id = '.$pasienmasukpenunjang_id . " and no_lab is not null");
                                              
    $modTindakan = TindakanpelayananT::model()->findAll($crit);

    $judul_print = 'Barcode';
    //lebar, panjang
    $mpdf = new MyPDF60('', array(80, 28));
    $posisi = 'P';
    // $mpdf->mirrorMargins = 2;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->setHtmlFooter('<span></span>');
    $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
    $mpdf->WriteHTML(utf8_encode(
                    $this->renderPartial('_printBarcodepdf', array(
                        'format' => $format,
                        'judul_print' => $judul_print,
                        'modTindakan' => $modTindakan,
                            ), true)));
    $mpdf->Output("Barcode.pdf", 'I');

  }

  public function actionPrintBarcode2($pasienmasukpenunjang_id) {
    $format = new MyFormatter;
        
    $crit = new CDbCriteria;
    $crit->select = 'no_pengambilansample';
    $crit->distinct = true;
    $crit->addCondition('pasienmasukpenunjang_id = '.$pasienmasukpenunjang_id);
                                              
    $modTindakan = PengambilansampleT::model()->findAll($crit);

    $judul_print = 'Barcode';
    //lebar, panjang
    $mpdf = new MyPDF60('', array(80, 28));
    $posisi = 'P';
    // $mpdf->mirrorMargins = 2;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->setHtmlFooter('<span></span>');
    $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
    $mpdf->WriteHTML(utf8_encode(
                    $this->renderPartial('_printBarcodepdf2', array(
                        'format' => $format,
                        'judul_print' => $judul_print,
                        'modTindakan' => $modTindakan,
                            ), true)));
    $mpdf->Output("Barcode.pdf", 'I');

  }
}

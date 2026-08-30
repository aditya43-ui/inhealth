<?php
Yii::import('radiologi.controllers.PendaftaranRadiologiController');
class PendaftaranRadiologiRujukanRSController extends PendaftaranRadiologiController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */ 
   public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "radiologi.views.pendaftaranRadiologiRujukanRS.";
  public $path_view_pendaftaran = "radiologi.views.pendaftaranRadiologi.";
  public $obatalkespasientersimpan = true; //di looping
  public $stokobatalkestersimpan = true; //looping
  public $karcistersimpan = true;
  public $komponentindakantersimpan = true;
  /**
   * Tambah / Ubah Pemeriksaan Radiologi.
   */



   public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $post)
   {
     $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
     $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
     $modPasienMasukPenunjang->attributes = $post;
     $modPasienMasukPenunjang->perawat_id = (isset($post['perawat_id']) ? $post['perawat_id'] : null);
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
 
     if (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)) {
       $kirim = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
       $modPasienMasukPenunjang->ruanganasal_id = $kirim->create_ruangan;
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
    * proses simpan ROTindakanpelayananT dan ROTindakankomponenT
    */
 

  public function actionIndex($pasienmasukpenunjang_id = null, $pendaftaran_id = null, $instalasi_id = null)
  {
 
    $format = new MyFormatter();
    $modKunjungan = new ROPasienKirimKeUnitLainV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modKunjungan->jeniskasuspenyakit_id = 14;
    $modPemeriksaanRad = new ROTarifpemeriksaanradruanganV;
    $modPasienMasukPenunjang = new ROPasienmasukpenunjangT;
    $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modTindakan = new ROTindakanpelayananT;
    $modObatAlkesPasien = new ROObatalkespasienT;
    $modPasienPPDS = ROPasienPPDST::model()->findByPk($pasienmasukpenunjang_id);
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

    $modPemeriksaanRad->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;

    if (isset($_GET['pasienkirimkeunitlain_id'])) {
      $modKunjungan = ROPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_GET['pasienkirimkeunitlain_id']));
      $modPasienMasukPenunjang->pasienkirimkeunitlain_id = isset($modKunjungan->pasienkirimkeunitlain_id) ? $modKunjungan->pasienkirimkeunitlain_id : "";
      $modPasienMasukPenunjang->jeniskasuspenyakit_id = isset($modKunjungan->jeniskasuspenyakit_id) ? $modKunjungan->jeniskasuspenyakit_id : "";
      $modPasienMasukPenunjang->kelaspelayanan_id = isset($modKunjungan->kelaspelayanan_id) ? $modKunjungan->kelaspelayanan_id : "";
    }
    if (isset($_GET['pendaftaran_id'])) {
      $modKunjungan = ROInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'instalasi_id' => $_GET['instalasi_id']));
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
      $modPasienMasukPenunjang = ROPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
       $loadModKunjungan = ROPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;
      }
    }

    if (isset($_POST['ROPasienmasukpenunjangT'])) {
      // ECHO '<PRE>'; var_dump($_POST); die;
     
      if (!empty($_POST['ROPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])) {
        $modKunjungan = ROPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['ROPasienmasukpenunjangT']['pasienkirimkeunitlain_id']));
      } else {
        $modKunjungan = ROInfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'instalasi_id' => $_GET['instalasi_id']));
      }

      
      $modPendaftaran = ROPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
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

        $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $_POST['ROPasienmasukpenunjangT']);
        // $modKunjungan->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
        // $modKunjungan->save(false, array('pasienmasukpenunjang_id'));
        
        // echo '<pre>'; var_dump($modKunjungan->attributes); die;
        
      

        if (!empty($_POST['ROPasienmasukpenunjangT']['pasienkirimkeunitlain_id'])) {
          $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $_POST['ROPasienmasukpenunjangT']['pasienkirimkeunitlain_id'];
          // $modPasienMasukPenunjang->ppds_id = $_POST['ROPasienmasukpenunjangT']['ppds_id'];

      $kirim = PasienkirimkeunitlainT::model()->findByPk($_POST['ROPasienmasukpenunjangT']['pasienkirimkeunitlain_id']);
      
      $modPermintaanAll = ROPermintaanKePenunjangT::model()->findAll("pasienkirimkeunitlain_id = '" . $kirim->pasienkirimkeunitlain_id . "' and pemeriksaanrad_id is not null");

      // echo '<pre>'; var_dump($_POST['ROTindakanpelayananT']); die;
      if(!empty($modPermintaanAll)) {
        foreach($modPermintaanAll as $all) {
          $pasienkirimterupdate = PasienkirimkeunitlainT::model()->updateByPk($all->pasienkirimkeunitlain_id,
          array('pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id,
                //  'is_elektif' => ['is_elektif_kirim'],
                 'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->getState('ruangan_id'), 'is_elektif' => $_POST['ROTindakanpelayananT'][0]['is_elektif'],
                 'tglrencanapemeriksaan' => MyFormatter::formatDateTimeForDb($_POST['ROTindakanpelayananT'][0]['tgl_tindakan'])
                ));
        }
      }

          
          // var_dump($modPasienMasukPenunjang->attributes); die;

          $pasienkirimterupdate = $modPasienMasukPenunjang->save(false);
        } else {
          $pasienkirimterupdate = true;
        }

        // var_dump($_POST); die;
        $modPasienPPDS = $this->simpanPasienPPDS($modPasienPPDS, $modPendaftaran, $modPasienMasukPenunjang, $_POST);
        if (!empty($_POST['ROPasienPPDST']['ppds_id'])) {
          $modPasienPPDS->ppds_id = $_POST['ROPasienPPDST']['ppds_id'];
          $modPasienPPDS->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienkirimkeunitlain_id;
          
          $pasienkirimterupdate = $modPasienPPDS->save(false);
        } else {
          $pasienkirimterupdate = true;
        }


        //var_dump($modPasienMasukPenunjang->attributes); die;
        // var_dump($_POST);
        if (isset($_POST['ROTindakanpelayananT'])) {

          $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

           if(!empty($md_noawal)) {
             $noawal = intval($md_noawal->nopelayanan);
           } else {
             $noawal = 1;
           }


          if (count((array)$_POST['ROTindakanpelayananT']) > 0) {
            // var_dump($_POST['ROTindakanpelayananT']);

            foreach ($_POST['ROTindakanpelayananT'] as $ii => $tindakan) {
              if (!empty($tindakan['tindakanpelayanan_id'])) {
                // echo "Kicker";
                $dataTindakans[$ii] = ROTindakanpelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
                $dataTindakans[$ii]->attributes = $modPasienMasukPenunjang->attributes;
                $dataTindakans[$ii]->qty_tindakan = $tindakan['qty_tindakan'];
                $dataTindakans[$ii]->tarif_tindakan = ($tindakan['tarif_tindakan']);
                $dataTindakans[$ii]->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $dataTindakans[$ii]->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
                $dataTindakans[$ii]->pemeriksaanrad_id = isset($tindakan['pemeriksaanrad_id']) ? $tindakan['pemeriksaanrad_id'] : '';
                $dataTindakans[$ii]->pasienadmisi_id = $modPendaftaran->pasienadmisi_id ?? null;

                $cyto_tindakan = false;

                if(!empty($_GET['pasienkirimkeunitlain_id'])) {
                  
                  $kirim = PasienkirimkeunitlainT::model()->findByPk($_GET['pasienkirimkeunitlain_id']);
                  $cyto_tindakan = ($kirim->is_cyto == true);


                }

                $dataTindakans[$ii]->cyto_tindakan = $cyto_tindakan;
                $dataTindakans[$ii]->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
                if (empty($dataTindakans[$ii]->pasienmasukpenunjang_id))
                  $dataTindakans[$ii]->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
                $dataTindakans[$ii]->update();
                // var_dump($dataTindakans[$ii]->attributes); die;
                $modHasilPemeriksaan = $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
              } else {
                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan, $noawal);
                $modHasilPemeriksaan = $this->simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
              }
              //untuk ditampilkan di form
              $dataTindakans[$ii]->pemeriksaanrad_id = $tindakan['pemeriksaanrad_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);


              // var_dump($dataTindakans[$ii]->attributes);
            }

            // echo '<pre>'; var_dump($dataTindakans[$ii]->attributes); die;
          }
        }

        // die;
        
        
        if (isset($_POST['ROObatalkespasienT'])) {
          if (count((array)$_POST['ROObatalkespasienT']) > 0) {
            //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
            $detailGroups = array();
            foreach ($_POST['ROObatalkespasienT'] as $i => $postDetail) {
              $modDetails[$i] = new ROObatalkespasienT;
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
            /*
					$obathabis = "";
					//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
					foreach($detailGroups AS $i => $detail){
						$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
						if(count((array)$modStokOAs) > 0){
							foreach($modStokOAs AS $i => $stok){
								$modDetails[$i] = $this->simpanObatAlkesPasien($modPasienMasukPenunjang,$stok, $_POST['ROObatalkespasienT']);
								$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
							}
						}else{
							$this->stokobatalkestersimpan &= false;
							$obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

						}
					}*/
            //END GROUP
          }
        }
        


        $this->karcistersimpan = true;
        $this->komponentindakantersimpan = true;
        

        if (isset($_POST['ROPasienmasukpenunjangT']['is_adakarcis'])) {
          if ($_POST['ROPasienmasukpenunjangT']['is_adakarcis']) {
          if (isset($_POST['PPTindakanPelayananT'])) {
            if (count((array)$_POST['PPTindakanPelayananT']) > 0) {
              foreach ($_POST['PPTindakanPelayananT'] as $i => $karcis) {
                //if($karcis['is_pilihtindakan']){
                $modTindakan = new TindakanpelayananT();
                $this->simpanKarcis($modTindakan, $modPasienMasukPenunjang, $karcis);
                //}
              }
            }
          }
        }
      }

      // die;

        if (!empty($modPasienMasukPenunjang) && !empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
          //$this->pasienpenunjangtersimpan = $this->pasienpenunjangtersimpan && $this->tambahPasienHL7($modPasienMasukPenunjang, "Pasien Rujuk Internal");
          // $this->tambahPasienHL7($modPasienMasukPenunjang, "Pasien Rujuk Internal");
        }


        // var_dump($this->pasienpenunjangtersimpan, $this->tindakanpelayanantersimpan, $this->komponentindakantersimpan, $this->hasilpemeriksaantersimpan, $pasienkirimterupdate, $this->obatalkespasientersimpan, $this->stokobatalkestersimpan); die;
        if ($this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan && $pasienkirimterupdate && $this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {

          // SMS GATEWAY
          $modPasien = $modPasienMasukPenunjang->pasien;
          $modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
          $modRuangan = $modPasienMasukPenunjang->ruangan;
          $sms = new Sms();
          $smspasien = 1;
          

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

          if(!empty($modPasienMasukPenunjang)) {
            $this->postDataPasien($modPasienMasukPenunjang);
          }

          // END SMS GATEWAY
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pemeriksaan radiologi berhasil disimpan !");
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id, 'smspasien' => $smspasien, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemeriksaan radiologi gagal disimpan !");
                                echo "- ".$this->pasienpenunjangtersimpan."<br>";
                                echo "- ".$this->tindakanpelayanantersimpan."<br>";
                                echo "- ".$this->komponentindakantersimpan."<br>";
                                echo "- ".$this->hasilpemeriksaantersimpan."<br>";
                                exit;
        }
      } catch (Exception $exc) {
        echo "<pre> ReportBugsController"; //show error 500
        var_dump($exc); exit;
         //show error 500
                                //  echo "-".$this->pasienpenunjangtersimpan."<br>";
                                //  echo "-".$this->tindakanpelayanantersimpan."<br>";
                                //  echo "-".$this->komponentindakantersimpan."<br>";
                                //  echo "-".$this->hasilpemeriksaantersimpan."<br>";
                                //  exit;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan radiologi gagal disimpan !" . " " . $exc->getMessage());
      }
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render('index', array(
      'modKunjungan' => $modKunjungan,
      'modPemeriksaanRad' => $modPemeriksaanRad,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modTindakan' => $modTindakan,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'dataTindakans' => $dataTindakans,
      'modSmsgateway' => $modSmsgateway,
      'modKarcisV' => $modKarcisV
    ));
  }


  public function simpanObatAlkesPasien2($modPasienMasukPenunjang, $postDetail)
  {
    $modObatAlkesPasien = new ROObatalkespasienT;
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
    $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
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
   * simpan ROObatalkespasienT
   * @param type $modPasienMasukPenunjang
   * @param type $stokOa
   * @param type $postObatAlkesPasien
   * @return \ROObatalkespasienT
   * copy dari : PemakaianBmhpController
   */
  public function simpanObatAlkesPasien($modPasienMasukPenunjang, $stokOa, $postObatAlkesPasien)
  {
    $modObatAlkesPasien = new ROObatalkespasienT;
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
    $modObatAlkesPasien->qty_stok = (int)$stokOa->qtystok;
    $modObatAlkesPasien->harganetto_oa = (int) $stokOa->HPP;
    $modObatAlkesPasien->hargasatuan_oa = (int) $stokOa->HargaJualSatuan;
    $modObatAlkesPasien->hargajual_oa = floatval($modObatAlkesPasien->hargasatuan_oa) * (int)$modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
    foreach ($postObatAlkesPasien as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatAlkesPasien->qty_stok = (int)$postDetail['qty_stok'];
      }
    }

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
    $modStokOaNew->qtystok_out = (int)$modObatAlkesPasien->qty_oa;
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
    $modStokOaNew->qtystok_out = (int) $modObatAlkesPasien->qty_oa;
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
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $models = ROPasienKirimKeUnitLainV::model()->findAll($criteria);
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
      $model = ROPasienKirimKeUnitLainV::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $_POST['pasienkirimkeunitlain_id']));
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
   * set ROPermintaanKePenunjangT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetPermintaanKePenunjang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $rows_periksa = "";

      $kirim = PasienkirimkeunitlainT::model()->findByPk($_POST['pasienkirimkeunitlain_id']);
      
      $modPermintaans = ROPermintaanKePenunjangT::model()->findAll("pasienkirimkeunitlain_id = '" . $_POST['pasienkirimkeunitlain_id'] . "' and pemeriksaanrad_id is not null");
      $modKirin = null;
      $modPendaftaran = null;
      $modAdmisi = null;
      
      if (count((array)$modPermintaans) > 0) {
        foreach ($modPermintaans as $i => $modPermintaan) {

          if (empty($modKirim)) {
            $modKirim = PasienkirimkeunitlainT::model()->findByPk($modPermintaan->pasienkirimkeunitlain_id);
            $modPendaftaran = PendaftaranT::model()->findByPk($modKirim->pendaftaran_id);
            $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
          }

          $penjamin_id = $modAdmisi->penjamin_id ?? $modPendaftaran->penjamin_id ?? null;
          $modPermintaan->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id ?? $modPendaftaran->kelaspelayanan_id ?? null;


          if(isset($modPermintaan->pemeriksaanrad_id)) {
            $modPemeriksaan = PemeriksaanradM::model()->findByAttributes(array('pemeriksaanrad_id' => $modPermintaan->pemeriksaanrad_id));
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
              $tarif = TarifpemeriksaanradruanganV::model()->findByAttributes(array(
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
            


            $rows .= $this->renderPartial($this->path_view . "_rowPermintaanKePenunjang", array('i' => 0, 'modPermintaan' => $modPermintaan), true);
          
            if ($modPermintaan->tarif_satuan != 0) {

              $tindakan = new ROTindakanpelayananT;
              $tindakan->daftartindakan_nama = $modPemeriksaan->pemeriksaanrad_nama;
              $tindakan->tindakanpelayanan_id = $modPermintaan->tindakanpelayanan_id;
              $tindakan->tindakansudahbayar_id = $modPermintaan->tindakansudahbayar_id;
              $tindakan->pemeriksaanrad_id = $modPermintaan->pemeriksaanrad_id;

              $pemeriksaan = PemeriksaanradM::model()->find("daftartindakan_id = " . $modPermintaan->daftartindakan_id);

              $tindakan->jenispemeriksaanrad_nama = !empty($pemeriksaan) ? $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama : $tindakan->daftartindakan_id;
              $tindakan->daftartindakan_id = $modPermintaan->daftartindakan_id;
              $tindakan->jenistarif_id = $modPermintaan->jenistarif_id;
              $tindakan->qty_tindakan = $modPermintaan->qty_tindakan;
              $tindakan->tarif_tindakan = $modPermintaan->tarif_tindakan;
              $tindakan->tarif_satuan = $modPermintaan->tarif_satuan;
              $tindakan->kelaspelayanan_id = $modPermintaan->kelaspelayanan_id;
              $tindakan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
              $tindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
              $tindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($modKirim->tglrencanapemeriksaan);
              $tindakan->is_elektif = $modKirim->is_elektif;

              $rows_periksa .= $this->renderPartial("radiologi.views.pendaftaranRadiologiRujukanRS._rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $tindakan), true);
            }
          }
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows,
        'rows_periksa' => $rows_periksa,
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

    $modPermintaan = ROPermintaanKePenunjangT::model()->findByPk($permintaankepenunjang_id);
    $modPemeriksaan = PemeriksaanradM::model()->findByAttributes(array('pemeriksaanrad_id' => $modPermintaan->pemeriksaanrad_id));


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
    $pemeriksaanrad_id = $_POST['pemeriksaanrad_id'] ?? null;
    $jenistarif_id = $_POST['jenistarif_id'] ?? null;
    $qty = $_POST['qty'] ?? null;

    $modPermintaan = ROPermintaanKePenunjangT::model()->findByPk($permintaankepenunjang_id);
    $modPemeriksaan = PemeriksaanradM::model()->findByAttributes(array('pemeriksaanrad_id' => $modPermintaan->pemeriksaanrad_id));

    $daftartindakan_id = $modPemeriksaan->daftartindakan_id ?? $daftartindakan_id;

    $tarif = TarifpemeriksaanradruanganV::model()->findByAttributes(array(
      'daftartindakan_id'=>$daftartindakan_id,
      'jenistarif_id'=>$jenistarif_id,
      'kelaspelayanan_id'=>$kelaspelayanan_id,
    ));

    // var_dump($modPermintaan->daftartindakan_id, $modPemeriksaan->daftartindakan_id); die;

    $tindakan = new ROTindakanpelayananT;
    $tindakan->daftartindakan_nama = $modPemeriksaan->pemeriksaanrad_nama;
    $tindakan->tindakanpelayanan_id = $modPermintaan->tindakanpelayanan_id;
    $tindakan->tindakansudahbayar_id = $modPermintaan->tindakansudahbayar_id;
    $tindakan->pemeriksaanrad_id = $modPemeriksaan->pemeriksaanrad_id;
    $tindakan->daftartindakan_id = $modPemeriksaan->daftartindakan_id;
    $tindakan->jenistarif_id = $jenistarif_id;
    $tindakan->qty_tindakan = $qty;
    $tindakan->tarif_satuan = $tarif->harga_tariftindakan ?? 0;
    $tindakan->tarif_tindakan = $tindakan->tarif_satuan * $qty;
    $tindakan->kelaspelayanan_id = $kelaspelayanan_id;
    $tindakan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $tindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;

    $rows .= $this->renderPartial("radiologi.views.pendaftaranRadiologiRujukanRS._rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $tindakan), true);

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

      $periksa = PemeriksaanradM::model()->findByAttributes(array(
        'daftartindakan_id'=>$item->daftartindakan_id
      ));

      if (empty($periksa)) {
        continue;
      }

      // var_dump($item->attributes);

      $tindakan = new ROTindakanpelayananT;
      $tindakan->daftartindakan_nama = $periksa->pemeriksaanrad_nama;
      $tindakan->tindakanpelayanan_id = null;
      $tindakan->tindakansudahbayar_id = null;
      $tindakan->pemeriksaanrad_id = $periksa->pemeriksaanrad_id;
      $tindakan->daftartindakan_id = $periksa->daftartindakan_id;
      $tindakan->jenistarif_id = $jenispenjamin->jenistarif_id;
      $tindakan->qty_tindakan = $item->qty_tindakan;
      $tindakan->tarif_satuan = ($item->iurbiaya ?? 0) / ($item->qty_tindakan ?? 1);
      $tindakan->tarif_tindakan = $tindakan->tarif_satuan * $tindakan->qty_tindakan;
      $tindakan->kelaspelayanan_id = $kelaspelayanan_id;
      $tindakan->tipepaket_id = $item->tipepaket_id;
      $tindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
  
  
      $rows .= $this->renderPartial("radiologi.views.pendaftaranRadiologiRujukanRS._rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $tindakan), true);

    }


    echo CJSON::encode(array(
      'rows' => $rows,
    ));

  }

  /**
   * set ROTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modTindakans = ROTindakanpelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {

          $pemeriksaan = PemeriksaanradM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id));

          if(isset($pemeriksaan->pemeriksaanrad_id)) {
            $modTindakan->pemeriksaanrad_id =  $pemeriksaan->pemeriksaanrad_id;
          }

          $modTindakan->jenispemeriksaanrad_nama = !empty($pemeriksaan) ? $pemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama : $tindakan->daftartindakan_id;

          $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
          $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
          $rows .= $this->renderPartial("radiologi.views.pendaftaranRadiologiRujukanRS._rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan), true);
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
      $modObatAlkesPasien = new ROObatalkespasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      $oa = ObatalkesM::model()->findByPk($obatalkes_id);
      //if(count((array)$modStokOAs) > 0){

      //	foreach($modStokOAs AS $i => $stok){
      $modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
      $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
      $modObatAlkesPasien->qty_oa = (int)$jumlah; //$stok->qtystok_terpakai;
      $modObatAlkesPasien->harganetto_oa = floatval($oa->harganetto); //$stok->HPP;
      $modObatAlkesPasien->hargasatuan_oa = floatval($oa->hargajual); //$stok->HargaJualSatuan;
      $modObatAlkesPasien->qty_stok = 0; //$stok->qtystok;
      $modObatAlkesPasien->hargajual_oa = (int) $modObatAlkesPasien->qty_oa * floatval($modObatAlkesPasien->hargasatuan_oa);
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
      $modObatAlkesPasien->iurbiaya = (int) $modObatAlkesPasien->qty_oa * floatval($modObatAlkesPasien->hargasatuan_oa);
      $modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
      $modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;
      $modObatAlkesPasien->obatalkes_nama = $oa->obatalkes_nama; //$stok->obatalkes->obatalkes_nama;

      $form .= $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien), true);
      //	}
      //}else{
      //	$pesan = "Stok tidak mencukupi!";
      //}

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * simpan ROHasilpemeriksaanradT
   */
  public function simpanHasilPemeriksaanRad($modPasienMasukPenunjang, $modTindakan, $post)
  {
    $modHasilPemeriksaan = new ROHasilpemeriksaanradT;
    $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
    $modHasilPemeriksaan->pemeriksaanrad_id = $post['pemeriksaanrad_id'];
    $modHasilPemeriksaan->tglpemeriksaanrad = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaan->create_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
    $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;

    if (empty($modTindakan->tgl_tindakan)) {
      $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    }

    // echo '<pre>'; var_dump($modHasilPemeriksaan->save(), $modHasilPemeriksaan->getErrors(), $modTindakan->daftartindakan_id); die;
    
    if ($modHasilPemeriksaan->validate()) {
     
      $modHasilPemeriksaan->save();
      
      //RND-8272
      if(!empty($modHasilPemeriksaan->pemeriksaanrad_id)) {
        $dataBroker = $modHasilPemeriksaan->getDataBroker();
        if (!empty($dataBroker)) {
          CustomFunction::postHL7Broker("ADD", $dataBroker);
        }
      }


      $modTindakan->hasilpemeriksaanrad_id = $modHasilPemeriksaan->hasilpemeriksaanrad_id;
      $modTindakan->save();
    } else {
      $this->hasilpemeriksaantersimpan = false;
    }
  }


  /**
   * proses simpan ROTindakanpelayananT dan ROTindakankomponenT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post, $noawal = null)
  {

    $modTindakan = new ROTindakanpelayananT;

    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
    $modTindakan->pemeriksaanrad_id = $post['pemeriksaanrad_id'];
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    // $modTindakan->kelaspelayanan_id = !empty($modPasienMasukPenunjang->kelaspelayanan_id) ? $modPasienMasukPenunjang->kelaspelayanan_id : Params::KELASPELAYANAN_ID_TANPA_KELAS;
    $modTindakan->attributes = $post;
    $modTindakan->pasienadmisi_id = $modPendaftaran->pasienadmisi_id ?? null;
    $modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    if(!empty($post['tarif_satuan'])) {
      $modTindakan->tarif_satuan = $post['tarif_satuan'];
    }
    $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
    if (!empty($modTindakan->karcis_id)) {
      $this->karcistersimpan = true;
      if (isset($post['harga_tariftindakan'])) { //jika dari form karcis
        if (!empty($post['harga_tariftindakan'])) {
          $modTindakan->tarif_satuan = floatval($post['harga_tariftindakan']);
        }
      }
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
    $modTindakan->tarif_tindakan = floatval($modTindakan->tarif_satuan) * $modTindakan->qty_tindakan;
    if (!empty($_POST['tgl_tindakan_semua'])) {
      $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($_POST['tgl_tindakan_semua']);
    } else {
      $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    }

    $kirim = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);

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

    $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modPasienMasukPenunjang->pasienkirimkeunitlain->kelaspelayanan_id,
                                                                        'daftartindakan_id'=>$modTindakan->daftartindakan_id,
                                                                        'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
                                                                        
    $modTindakan->tarifcyto_tindakan = empty($modTarif->totaltarifakhir_cyto) ? 0 : $modTarif->totaltarifakhir_cyto;
    $modTindakan->cyto_tindakan = ($kirim->is_cyto == true);   
    
    if(!empty($noawal)) {
      $modTindakan->nopelayanan = str_pad($noawal+1,3,"0",STR_PAD_LEFT);
    }

    $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($post['tgl_tindakan']);

    if(empty($modTindakan->tgl_tindakan)) {
      $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    }

    // echo '<pre>'; var_dump($modTindakan->save(), $modTindakan->attributes); die;

    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }

  public function actionSetChecklistPemeriksaanRad()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPemeriksaan = $post['ROTarifpemeriksaanradruanganV'];

      // tarif radiologi antar kelas sama
      $postPemeriksaan['kelaspelayanan_id'] = Params::KELASPELAYANAN_ID_TANPA_KELAS;


      if (!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
        $criteria = new CdbCriteria();
        $criteria->addCondition('ruangan_id = ' . $postPemeriksaan['ruangan_id']);
        $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
        $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        //$criteria->compare('jenispemeriksaanrad_id',$postPemeriksaan['jenispemeriksaanrad_id']);
        $criteria->compare('LOWER(jenispemeriksaanrad_nama)', strtolower($postPemeriksaan['jenispemeriksaanrad_nama']));
        $criteria->compare('LOWER(pemeriksaanrad_nama)', strtolower($postPemeriksaan['pemeriksaanrad_nama']), true);
        $criteria->order = "jenispemeriksaanrad_id, pemeriksaanrad_urutan";
        $modPemeriksaanRads = ROTarifpemeriksaanradruanganV::model()->findAll($criteria);

        // print_r(count((array)$modPemeriksaanRads)); die;

        $content = $this->renderPartial($this->path_view_pendaftaran . '_checklistPemeriksaanRad', array('modPemeriksaanRads' => $modPemeriksaanRads), true);
      }
      echo CJSON::encode(array(
        'content' => $content
      ));
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
      $ruangan_id = Params::RUANGAN_ID_RAD;
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
              $karcis_id = 539; // karcis id biaya administrasi laboratorium pasien baru
            } else {
              $is_pasienbaru = 'false';
              $karcis_id = 540; // karcis id biaya administrasi laboratorium pasien lamas
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
    $modTindakan->instalasi_id = Params::INSTALASI_ID_RAD;
    //$modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTindakan->ruangan_id = Params::RUANGAN_ID_RAD;
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

    $modTindakan->carabayar_id = $modCaraBayar;
    $modTindakan->penjamin_id = $modPenjamin;
    $modTindakan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
    $modTindakan->pasien_id = $model->pasien_id;
    $modTindakan->dokterpemeriksa1_id = $model->pegawai_id;
    $modTindakan->karcis_id = $post['karcis_id'];
    // $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
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

  public function simpanPasienPPDS($modPasienPPDS, $modPendaftaran, $modPasienMasukPenunjang, $post) {
    if (empty($modPasienPPDS)) {
      $modPasienPPDS = new ROPasienPPDST;
      
    }
    $modPasienPPDS->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPasienPPDS->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    $modPasienPPDS->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    $modPasienPPDS->ppds_id = $post['ROPasienmasukpenunjangT']['ppds_id'] ?? null;
    $modPasienPPDS->urutan_ppds = 1;
    $modPasienPPDS->save();
    // var_dump($modPasienPPDS->attributes, $modPasienPPDS->errors, $post);

    return $modPasienPPDS;
  }
}

<?php

class PasienRawatIntensifController extends MyAuthController
{

  /**
   * @return array action filters
   */
  public $successSave;
  public $successUpdateMasukKamar = false;
  public $successPasienPulang = false;
  public $successUpdatePendaftaran = false;
  public $successUpdatePasienAdmisi = false;
  public $successRujukanKeluar = true;
  public $successPaseinM = true;
  public $successSaveTindakanKomponen = true;
  public $successSaveTindakan;

  public $path_view = "perawatanIntensif.views.pasienRawatIntensif.";

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Rawat Intensif";
    $format = new MyFormatter();
    $model = new PIInfopasienmasukkamarV;
    		// $model->tgl_awal = date('Y-m-d');
    $model->tgl_awal  = date('Y-m-d', time() - (3600 * 24 * 60));
    $model->tgl_akhir = date('Y-m-d');
    $model->tgl_awall = date('Y-m-d');
    $model->tgl_akhirl = date('Y-m-d');
    $model->ceklis = false;
    $model->ceklisAdmisi = true;
    $model->is_nursestation = true;

    if (isset($_REQUEST['PIInfopasienmasukkamarV'])) {
      $model->attributes = $_REQUEST['PIInfopasienmasukkamarV'];
      $model->ceklis = $_REQUEST['PIInfopasienmasukkamarV']['ceklis'];
      $model->ceklisAdmisi = $_REQUEST['PIInfopasienmasukkamarV']['ceklisAdmisi'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PIInfopasienmasukkamarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PIInfopasienmasukkamarV']['tgl_akhir']);
      $model->tgl_awall  = $format->formatDateTimeForDb($_REQUEST['PIInfopasienmasukkamarV']['tgl_awall']);
      $model->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['PIInfopasienmasukkamarV']['tgl_akhirl']);
      $model->ceklis = $_REQUEST['PIInfopasienmasukkamarV']['ceklis'];
      $model->is_nursestation = $_REQUEST['PIInfopasienmasukkamarV']['is_nursestation'];

      if(Yii::app()->request->isAjaxRequest) {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'daftarPasien-grid') {
          $this->renderPartial('_tablePasien', ['model' => $model]);
          Yii::app()->end();
        }
      }
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }


  public function simpanPPDS($pendaftaran_id,$urutan_ppds,$pasienadmisi_id, $post)
  {
    foreach ($post as $i => $ppds) {
      if (empty($ppds['pasien_ppds_id'])) {
        $model = new PasienPpdsT();
        $model->attributes = $ppds;
        $model->pendaftaran_id = $pendaftaran_id;
        $model->urutan_ppds = $urutan_ppds;
        $model->ppds_id = $urutan_ppds;        
        $model->pasienadmisi_id = $pasienadmisi_id;        
    
        if (!$model->save()) {
          $this->ppdsTersimpan &= false;
        }
      }
    }
  }

  public function actionCreate($pendaftaran_id = null, $pasienadmisi_id = null, $ppds_id = null, $urutan_ppds = null)
  {

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;    
    $model = new PasienPpdsT;
    
    if (isset($_POST['PasienPpdsT'])) {  
     $transaction = Yii::app()->db->beginTransaction();
     $ok = true;

      $i = 1;
        foreach ($_POST['PasienPpdsT'] as $idx=>$item) {
          $modDetail = new PasienPpdsT;
          $modDetail->ppds_id = $item['ppds_id'];
          $modDetail->urutan_ppds = $i;
          $modDetail->pendaftaran_id = $pendaftaran_id;
          $modDetail->pasienadmisi_id = $pasienadmisi_id;

          $ok = $ok && $modDetail->save();
          $i++;
        }

        if ($ok && !empty(Yii::app()->user->getState('pegawai_id'))) {
          $transaction->commit();
         Yii::app()->user->setFlash('success', '<strong>Sukses!</strong> Data berhasil disimpan!');
        } else {
          $transaction->rollback();
         Yii::app()->user->setFlash('error', '<strong>Perhatian!</strong> Nama PPDS Tidak Sesuai login Anda!');
          
        }
      }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'model2' => $model2,
      'modPpds'=>$modPpds,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan'=> $modRuangan,
      'modDetail' => $modDetail
    ));
  }

  public function actionAutoPPDS()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(ppds_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'ppds_nama';
                $criteria->limit = 10;
                $models = PpdsM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->ppds_nama;
                    $returnVal[$i]['value'] = $model->ppds_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}

  public function actionPPDSRJ($pendaftaran_id = null)
  {
    $format = new MyFormatter();
    //$pendaftaran_id = $_GET['pendaftaran_id'];

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRuangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    $model2 = new PpdsM();
    $modPpds = new PpdsM();
    $modDetail = new PasienPpdsT;
    
    $model2->ppds_nama;
    
    $this->render('_formPPDSRJ', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRuangan'=> $modRuangan,
      'model2' => $model2,
      'modPpds'=>$modPpds,
      'modDetail' => $modDetail
   //   'datatable' => $datatable
    ));
  }
  public function actionTindakLanjutDariPasienPI($pendaftaran_id, $melarikandiri = 0, $meninggal = 0, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/iframe';

    $modelPulang = new PIPasienPulangT;
    $modKematian = new PISuratKeteranganR();
    $modRujukanKeluar = new PIPasienDirujukKeluarT;
    $modPendaftaran = PIPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasienPIV = PIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    // var_dump();die();
    $modTariftindakan = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id' => $modPasienPIV->kelaspelayanan_id));
    $modMasukKamar = PIMasukKamarT::model()->findByPk($modPasienPIV->masukkamar_id);
    $modPasienKirimUnit = PasienkirimkeunitlainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => null));
    $modelPulang->pendaftaran_id = $modPasienPIV->pendaftaran_id;
    $modelPulang->pasien_id = $modPasienPIV->pasien_id;
    $modelPulang->pasienadmisi_id = $modPasienPIV->pasienadmisi_id;
    $modMasukKamar->tglkeluarkamar = date('Y-m-d');
    $modMasukKamar->jamkeluarkamar = date('H:i:s');
    $modelPulang->tglpasienpulang = date('Y-m-d H:i:s');
    //		$modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $modRujukanKeluar->ruanganasal_id = $modPasienPIV->ruangan_id;
    $modRujukanKeluar->tgldirujuk = date('Y-m-d H:i:s');
    $modRujukanKeluar->tglberlakusurat = date('Y-m-d H:i:s');
    $modRujukanKeluar->sampaidengan = date('Y-m-d H:i:s');
    $tersimpan = 'Tidak';
    $modelPulang->keterangankeluar = null;
    $modelPulang->tgl_meninggal = date('Y-m-d H:i:s');

    if ($melarikandiri == 1) {
      $modelPulang->carakeluar_id = Params::CARAKELUAR_ID_MELARIKANDIRI;
    }

    if ($meninggal == 1) {
      $modelPulang->carakeluar_id = Params::CARAKELUAR_ID_MENINGGAL;
    }

    if(!empty($modPasienPIV->rencanacarakeluar_id)) {
      $modelPulang->carakeluar_id = $modPasienPIV->rencanacarakeluar_id;
      $modelPulang->kondisikeluar_id = $modPasienPIV->rencanakondisikeluar_id;
  }

    if(!empty($pasienadmisi_id)) {
      $modAdmisi = PasienadmisiT::model()->findByPk(['pasienadmisi_id' => $pasienadmisi_id]);
      if(!empty($modAdmisi)) {
        $modelPulang->kondisikeluar_id = $modAdmisi->rencanakondisikeluar_id;
      }
    }

    if(!empty($modPendaftaran)) {
      $modKematian = PISuratKeteranganR::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'jenissurat_id' => Params::SURAT_KETERANGAN_KEMATIAN]);

      if(empty($modKematian)) {
        $modKematian = new PISuratKeteranganR();
        $modKematian->pendaftaran_id = $pendaftaran_id;
        $modKematian->pasien_id = $modPendaftaran->pasien_id;
        $modKematian->nourutsurat = $modKematian->getNoUrut();
        $modKematian->nomorsurat = $modKematian->getNoSuratKematian(Yii::app()->user->getState('ruangan_id'));
        $modKematian->tglsurat = date('d M Y H:i:s');
        $modKematian->judulsurat = 'SURAT KETERANGAN KEMATIAN';
        $modKematian->jmlprint_surat = 1;
        $modKematian->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modKematian->profilrs_id = Params::getDefaultProfilRS();
        $modKematian->jenissurat_id = Params::SURAT_KETERANGAN_KEMATIAN;
      }
      
    }

    

    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($pendaftaran_id) == false) ? 'ada' : 'tidak';

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
    $smspasien = 1;

    $format = new MyFormatter();
    //Hitung lama rawat                
    $modMasukKamar->tglmasukkamar = $format->formatDateTimeForDb($modMasukKamar->tglmasukkamar);
    //$selisihHari = CustomFunction::hitungHari($modMasukKamar->tglmasukkamar);
    $modPasienPIV->tgladmisi = $format->formatDateTimeForDb($modPasienPIV->tgladmisi);
    $selisihHari = CustomFunction::hitungHari($modPasienPIV->tgladmisi);

    //Hitung hari rawat
    //$selisihHariRawat = CustomFunction::hitungHariRawat($modMasukKamar->tglmasukkamar);
    $selisihHariRawat = CustomFunction::hitungHariRawat($modPasienPIV->tgladmisi);

    $pen = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modUbahStatus = new PengirimanrmT;
    $modUbahStatus->tglpengirimanrm = date('d/m/Y H:i:s');
    $modUbahStatus->petugaspengirim = Yii::app()->user->name;
    $modUbahStatus->petugaspengirim_id = Yii::app()->user->getState('pegawai_id');
    $modUbahStatus->ruangan_id = Params::RUANGAN_ID_REKAM_MEDIS;
    $modUbahStatus->instalasi_id = Params::INSTALASI_ID_RM;
    //if ($_POST["RDPasienPulangT"]['carakeluar_id'] != Params::CARAKELUAR_ID_RAWATINAP){
    if (!empty($pen->pengirimanrm_id)) {
      if (Yii::app()->user->getState('ruangan_id') == $pen->pengirimanrm->ruanganpenerima_id) {
        if (empty($pen->pengirimanrm->tglterimadokrm)) {
          $modUbahStatus->statusdokrm = 'belum-diterima';
        } else {
          $modUbahStatus->statusdokrm = 'belum-dikembalikan';
        }
      }
    }

    //		$modMasukKamar->lamadirawat_kamar = $selisihHari;
    $modMasukKamar->lamadirawat_kamar = $selisihHari + 1; //RSSP-934
    $modelPulang->hariperawatan = $selisihHariRawat;


    //                if(empty($modPasienPIV->kamarruangan_nokamar)){ 
    ////                    echo "kamarruangan tidak  ada";
    ////                              myAlert('Silakan Isi No. Kamar Terlebih Dahulu');
    //                    echo "<script>
    //                                window.top.location.href='".Yii::app()->createUrl('perawatanIntensif/PasienRawatIntensif/index')."';
    //                            </script>";
    //                }else{
    ////                    echo "kamarruangan ada";
    //                }
    if (isset($_POST['PIPasienPulangT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modMasukKamar = PIMasukKamarT::model()->findByPk($_POST['PIMasukKamarT']['masukkamar_id']);
        $this->updateMasukKamar($modMasukKamar, $_POST['PIMasukKamarT']);
        if (!isset($modTariftindakan->harga_tariftindakan)) {
          echo 'Maaf, Harga Tarif Kamar Rawat Intensif Belum Ada. Silakan Hubungi Bagian Administrasi';
          exit();
          //					echo "<script>
          //                                        myAlert('Maaf, Harga Tarif Kamar Rawat Intensif Belum Ada. Silakan Hubungi Bagian Administrasi');
          //                                        window.location.href('" . Yii::app()->createUrl('/PasienRawatIntensif/index') . "');
          //                                    </script>";
        } else {
          //                                echo "<script>
          //                                            myAlert('Harga Tarif Kamar Rawat Intensif Ada');
          //                                        </script>";
          $modelPulang = $this->savePasienPulang($modMasukKamar, $modelPulang, $_POST['PIPasienPulangT'], $_POST['PIPasienPulangT']['pasienadmisi_id']);
        }


        $modPendaftaran = PIPendaftaranT::model()->findByPk($modelPulang->pendaftaran_id);
        $this->updatePendaftaran($modPendaftaran, $modelPulang);

        $modPasienAdmisi = PIPasienAdmisiT::model()->findByPk($modelPulang->pasienadmisi_id);
        $this->updatePasienAdmisi($modPasienAdmisi, $modelPulang);

        if (Yii::app()->user->getState('akomodasiotomatis') == true) {
          $akomodasitersimpan = self::simpanAkomodasiOtomatis($modPasienAdmisi->tgladmisi, $modelPulang->tglpasienpulang, $modPasienAdmisi->pasienadmisi_id);
          if ($akomodasitersimpan) {
            Yii::app()->user->setFlash('success', "Akomodasi otomatis tersimpan!");
          } else {
            Yii::app()->user->setFlash('error', "Akomodasi otomatis gagal disimpan! Silakan atur master dan tarif akomodasi!");
          }
        }
        if (isset($_POST['pakeRujukan']) && $_POST['pakeRujukan'] == '1') { //Jika Pake Rujukan
          $this->successRujukanKeluar = false;
          $modelPulang->pakeRujukan = true;
          $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar, $modelPulang, $_POST['PIPasienDirujukKeluarT']);
        }

        if (isset($_POST['isDead']) && $_POST['isDead'] == '1') { //Jika Pasien Meninggal
          $modelPulang->isDead;
          $this->successPaseinM = false;
          $modPasien = PIPasienM::model()->findByPk($modelPulang->pasien_id);
          $modPasien->tgl_meninggal = $format->formatDateTimeForDb($_POST['PIPasienPulangT']['tgl_meninggal']);

          if ($modPasien->save()) {
            $this->successPaseinM = true;
          } else {
            $this->successPaseinM = false;
          }
        }

        if ($this->successUpdateMasukKamar && $this->successPasienPulang && $this->successUpdatePendaftaran && $this->successUpdatePasienAdmisi && $this->successRujukanKeluar && $this->successPaseinM) {
          // SMS GATEWAY
          $modPasien = $modPendaftaran->pasien;
          $modCaraKeluar = $modelPulang->carakeluar;
          $modKondisiKeluar = $modelPulang->kondisikeluar;
          $sms = new Sms();
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modCaraKeluar->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modKondisiKeluar->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modelPulang->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modelPulang->tglpasienpulang), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }
          // END SMS GATEWAY

          if(isset($_POST['Diagnosa'])) {

              foreach ($_POST['Diagnosa'] as $ii => $data) {
                  $insert = new MortalitasR();
                  $insert->tanggal = date('Y-m-d H:i:s');
                  $insert->diagnosa_id = $data['diagnosa_id'];
                  $insert->diagnosa_nama = $data['diagnosa_nama'];
                  $insert->jumlah = 1;
                  $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                  $insert->created_by = Yii::app()->user->getState('loginpemakai_id');
                  $insert->created_time = date('Y-m-d H:i:s');
                  $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
                  $insert->pegawai_id = Yii::app()->user->getState('pegawai_id');
                  if ($insert->save()) {
                      
                  }
              }
              // echo '<pre>';var_dump($insert->save(), $insert->getErrors());
          }

          //save surat kematian
          if(isset($_POST['PISuratKeteranganR'])) {
              $modKematian->attributes = $_POST['PISuratKeteranganR'];
              $modKematian->penyebabkematian = $_POST['PISuratKeteranganR']['penyebabkematian'];
              $modKematian->jenissurat_id = Params::SURAT_KETERANGAN_KEMATIAN;
              if ($modKematian->validate()) {
                  $modKematian->save();
              }
          }

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $tersimpan = 'Ya';
        } else {
          if ($this->successUpdateMasukKamar == false) {
            Yii::app()->user->setFlash('error', "Data Masuk Kamar gagal disimpan");
          } else if ($this->successPasienPulang == false) {
            Yii::app()->user->setFlash('error', "Data Pasien Pulang gagal disimpan");
          } else if ($this->successUpdatePendaftaran == false) {
            Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan");
          } else if ($this->successUpdatePasienAdmisi == false) {
            Yii::app()->user->setFlash('error', "Data Pasien Admisi gagal disimpan");
          } else if ($this->successRujukanKeluar == false) {
            Yii::app()->user->setFlash('error', "Data Rujukan Keluar gagal disimpan");
          } else if ($this->successPaseinM == false) {
            Yii::app()->user->setFlash('error', "Data Pasien disimpan");
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatDiagnosaMortalitas = MortalitasR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id]);

    $modMasukKamar->tglmasukkamar = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modMasukKamar->tglmasukkamar, 'yyyy-MM-dd hh:mm:ss')
    );
    $modMasukKamar->tglkeluarkamar = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modMasukKamar->tglkeluarkamar, 'yyyy-MM-dd'),
      'medium',
      false
    );
    $modelPulang->tglpasienpulang = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modelPulang->tglpasienpulang, 'yyyy-MM-dd hh:mm:ss')
    );
    $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss')
    );
    $modRujukanKeluar->tglberlakusurat = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modRujukanKeluar->tglberlakusurat, 'yyyy-MM-dd hh:mm:ss')
    );
    $modRujukanKeluar->sampaidengan = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modRujukanKeluar->sampaidengan, 'yyyy-MM-dd hh:mm:ss')
    );

    $this->render('formTindakLanjutDariPasienPI', array(
      'modelPulang' => $modelPulang,
      'modRujukanKeluar' => $modRujukanKeluar,
      'modPasienPIV' => $modPasienPIV,
      'modMasukKamar' => $modMasukKamar,
      'modTariftindakan' => $modTariftindakan,
      'tersimpan' => $tersimpan,
      'modUbahStatus' => $modUbahStatus,
      'smspasien' => $smspasien,
      'modPendaftaran' => $modPendaftaran,
      'cekPembayaran' => $cekPembayaran,
      'modKematian' => $modKematian,
      'modRiwayatDiagnosaMortalitas' => $modRiwayatDiagnosaMortalitas
    ));
  }

  function actionAddRowDiagnosa() {
      $jumlahtr = $_POST['jumlahtr'];
      $diagnosa_id = $_POST['diagnosa_id'];
      $diagnosa_kode = $_POST['diagnosa_kode'];
      $diagnosa_nama = $_POST['diagnosa_nama'];
      $diagnosa_namalainnya = $_POST['diagnosa_namalainnya'];

      $data['html'] = $this->renderPartial($this->path_view . 'diagnosaMeninggal/_rowDiagnosa', [
          'jumlahtr' => $jumlahtr,
          'diagnosa_id' => $diagnosa_id,
          'diagnosa_nama' => $diagnosa_nama,
          'diagnosa_kode' => $diagnosa_kode,
          'diagnosa_namalainnya' => $diagnosa_namalainnya
      ], true);

      echo json_encode($data);

  }

  public function notifPasienMeninggal($modPasien, $modelPulang)
  {

    $modCaraKeluar = CarakeluarM::model()->findByPk($modelPulang->carakeluar_id);
    $modKondisiKeluar = KondisiKeluarM::model()->findByPk($modelPulang->kondisikeluar_id);

    $judul = "Pasien Meninggal";

    $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->namadepan . $modPasien->nama_pasien . ' '
      .  'Pasien ' . strtoupper($modCaraKeluar->carakeluar_nama) . ' dengan kondisi ' . $modKondisiKeluar->kondisikeluar_nama . ' pada tanggal '
      . MyFormatter::formatDateTimeForUser($modPasien->tgl_meninggal);

    return CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => Params::INSTALASI_ID_JZ, 'ruangan_id' => Params::RUANGAN_ID_FORENSIC, 'modul_id' => Params::MODUL_ID_JENAZAH),
    ));
  }

  public function actionTindakLanjutDrTransaksi($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Pulang";
    $modelPulang = new PIPasienPulangT;
    $modRujukanKeluar = new PIPasienDirujukKeluarT;
    // $modPasienPIV = new PIPasienRawatInapV;
    //$modInfoPasien = new PIInfopasienmasukkamarV;
    $modPasienPIV = new PIInfopasienmasukkamarV;
    $modMasukKamar = new PIMasukKamarT;
    $modelPulang->keterangankeluar = null;
    $modMasukKamar->tglkeluarkamar = date('Y-m-d');
    $modMasukKamar->jamkeluarkamar = date('H:i:s');
    $modelPulang->tglpasienpulang = date('Y-m-d H:i:s');
    //		$modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $modRujukanKeluar->ruanganasal_id = $modPasienPIV->ruangan_id;
    $tersimpan = 'Tidak';
    $modPendaftaran = new PIPendaftaranT;

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

    $modPasienPIV->unsetAttributes();
    if (isset($_GET['PIInfopasienmasukkamarV'])) {
      $modPasienPIV->attributes = $_GET['PIInfopasienmasukkamarV'];
    }

    if (!empty($id)) {
      $modelPulang = PIPasienPulangT::model()->findByPk($id);
      $modMasukKamar = PIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $modelPulang->pasienadmisi_id));
    }



    if (isset($_POST['PIPasienPulangT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modMasukKamar = PIMasukKamarT::model()->findByPk($_POST['PIMasukKamarT']['masukkamar_id']);
        $this->updateMasukKamar($modMasukKamar, $_POST['PIMasukKamarT']);

        $modelPulang = $this->savePasienPulang(
          $modMasukKamar,
          $modelPulang,
          $_POST['PIPasienPulangT'],
          $_POST['PIPasienPulangT']['pasienadmisi_id']
        );

        $modPendaftaran = PIPendaftaranT::model()->findByPk($modelPulang->pendaftaran_id);
        $this->updatePendaftaran($modPendaftaran, $modelPulang);

        $modPasienAdmisi = PIPasienAdmisiT::model()->findByPk($modelPulang->pasienadmisi_id);
        $this->updatePasienAdmisi($modPasienAdmisi, $modelPulang);

        $tglpulang = date("Y-m-d H:i:s");
        if (isset($_POST['pakeRujukan']) && $_POST['pakeRujukan'] == '1') { //Jika Pake Rujukan
          $this->successRujukanKeluar = false;
          $modelPulang->pakeRujukan = true;
          $modRujukanKeluar = $this->saveRujukanKeluar($modRujukanKeluar, $modelPulang, $_POST['PIPasienDirujukKeluarT']);
          $tglpulang = $modelPulang->tglpasienpulang;
        }

        if (isset($_POST['isDead']) && $_POST['isDead'] == '1') { //Jika Pasien Meninggal
          $modelPulang->isDead;
          $this->successPaseinM = false;
          $modPasien = PIPasienM::model()->findByPk($modelPulang->pasien_id);
          $modPasien->tgl_meninggal = $modelPulang->tgl_meninggal;
          if ($modPasien->save()) {
            $this->successPaseinM = true;
          } else {
            $this->successPaseinM = false;
          }
          $tglpulang = $modelPulang->tgl_meninggal;
        }
        if (Yii::app()->user->getState('akomodasiotomatis') == true) {
          $akomodasitersimpan = self::simpanAkomodasiOtomatis($modPasienAdmisi->tgladmisi, $tglpulang, $modPasienAdmisi->pasienadmisi_id);
          if ($akomodasitersimpan) {
            Yii::app()->user->setFlash('success', "Akomodasi otomatis tersimpan!");
          } else {
            Yii::app()->user->setFlash('error', "Akomodasi otomatis gagal disimpan! Silakan atur master dan tarif akomodasi!");
          }
        }

        if ($this->successUpdateMasukKamar && $this->successPasienPulang && $this->successUpdatePendaftaran && $this->successUpdatePasienAdmisi && $this->successRujukanKeluar) {

          // SMS GATEWAY
          $modPasien = $modPendaftaran->pasien;
          $modCaraKeluar = $modelPulang->carakeluar;
          $modKondisiKeluar = $modelPulang->kondisikeluar;
          $sms = new Sms();
          $smspasien = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modCaraKeluar->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modKondisiKeluar->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modelPulang->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modelPulang->tglpasienpulang), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }
          // END SMS GATEWAY

          $transaction->commit();
          $tersimpan = 'Ya';
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('TindakLanjutDrTransaksi', 'id' => $modelPulang->pasienpulang_id, 'sukses' => $tersimpan, 'smspasien' => $smspasien));
        } else {
          if ($this->successUpdateMasukKamar == false) {
            Yii::app()->user->setFlash('error', "Data Masuk Kamar gagal disimpan");
          } else if ($this->successPasienPulang == false) {
            Yii::app()->user->setFlash('error', "Data Pasien Pulang gagal disimpan");
          } else if ($this->successUpdatePendaftaran == false) {
            Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan");
          } else if ($this->successUpdatePasienAdmisi == false) {
            Yii::app()->user->setFlash('error', "Data Pasien Admisi gagal disimpan");
          } else if ($this->successRujukanKeluar == false) {
            Yii::app()->user->setFlash('error', "Data Rujukan Keluar gagal disimpan");
          } else if ($this->successPaseinM == false) {
            Yii::app()->user->setFlash('error', "Data Pasien disimpan");
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $modMasukKamar->tglmasukkamar = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modMasukKamar->tglmasukkamar, 'yyyy-MM-dd hh:mm:ss')
    );
    $modMasukKamar->tglkeluarkamar = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modMasukKamar->tglkeluarkamar, 'yyyy-MM-dd'),
      'medium',
      false
    );
    $modelPulang->tglpasienpulang = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modelPulang->tglpasienpulang, 'yyyy-MM-dd hh:mm:ss')
    );
    $modRujukanKeluar->tgldirujuk = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modRujukanKeluar->tgldirujuk, 'yyyy-MM-dd hh:mm:ss')
    );
    $modRujukanKeluar->tglberlakusurat = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modRujukanKeluar->tglberlakusurat, 'yyyy-MM-dd hh:mm:ss')
    );
    $modRujukanKeluar->sampaidengan = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modRujukanKeluar->sampaidengan, 'yyyy-MM-dd hh:mm:ss')
    );

    $linkHalaman = CustomFunction::getUrlByMenuID(2621);

    $this->render('formTindakLanjutDariPasienPI', array(
      'modelPulang' => $modelPulang,
      'modRujukanKeluar' => $modRujukanKeluar,
      'modPasienPIV' => $modPasienPIV,
      'modMasukKamar' => $modMasukKamar,
      'tersimpan' => $tersimpan,
      'modPendaftaran' => $modPendaftaran,
      'linkHalaman' => $linkHalaman
    ));
  }

  protected function saveRujukanKeluar($modRujukanKeluar, $modelPulang, $attrRujukanKeluar)
  {
    $format = new MyFormatter();
    $modRujukanKeluarNew = new PIPasienDirujukKeluarT;
    $modRujukanKeluarNew->attributes = $attrRujukanKeluar;
    $modRujukanKeluarNew->tgldirujuk = isset($attrRujukanKeluar['tgldirujuk']) ? $format->formatDateTimeForDb($attrRujukanKeluar['tgldirujuk']) : null;
    $modRujukanKeluarNew->tglberlakusurat = isset($attrRujukanKeluar['tglberlakusurat']) ? $format->formatDateTimeForDb($attrRujukanKeluar['tglberlakusurat']) : null;
    $modRujukanKeluarNew->sampaidengan = isset($attrRujukanKeluar['sampaidengan']) ? $format->formatDateTimeForDb($attrRujukanKeluar['sampaidengan']) : null;
    $modRujukanKeluarNew->pendaftaran_id = $modelPulang->pendaftaran_id;
    $modRujukanKeluarNew->pasien_id = $modelPulang->pasien_id;
    $modRujukanKeluarNew->create_time = date('Y-m-d H:i:s');
    //		$modRujukanKeluarNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modRujukanKeluarNew->create_ruangan = $this->getRuanganId($modelPulang->pasienadmisi_id);
    $modRujukanKeluarNew->create_loginpemakai_id = Yii::app()->user->id;
    if ($modRujukanKeluarNew->save()) {
      $this->successRujukanKeluar = true;
    } else {
      $this->successRujukanKeluar = false;
    }
    return $modRujukanKeluarNew;
  }

  protected function updateMasukKamar($modMasukKamar, $attrMasukKamar)
  {
    $format = new MyFormatter();
    $modMasukKamar->attributes = $attrMasukKamar;
    $modMasukKamar->tglmasukkamar = $format->formatDateTimeForDb(trim($attrMasukKamar['tglmasukkamar']));
    $modMasukKamar->tglkeluarkamar = $format->formatDateTimeForDb(trim($attrMasukKamar['tglkeluarkamar']) . ' ' . $attrMasukKamar['jamkeluarkamar']);
    if ($modMasukKamar->save()) {
      $this->successUpdateMasukKamar = true;
    } else {
      $this->successUpdateMasukKamar = false;
    }
  }

  protected function updatePendaftaran($modPendaftaran, $modelPulang)
  {
    if (isset($_POST['PIPendaftaranT']['tglrenkontrol']) && $_POST['PIPendaftaranT']['tglrenkontrol'] != null) {
      $format = new MyFormatter();
      $tglrenkontrol = $format->formatDateTimeForDb($_POST['PIPendaftaranT']['tglrenkontrol']);
    } else {
      $tglrenkontrol = null;
    }
    $daftar = PendaftaranT::model()->updateByPk(
      $modelPulang->pendaftaran_id,
      array(
        'tglselesaiperiksa' => date('Y-m-d H:i:s'),
        'pasienpulang_id' => $modelPulang->pasienpulang_id,
        'tglrenkontrol' => $tglrenkontrol,
        'statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG,
      )
    );
    //            $modPendaftaran->tglselesaiperiksa = date( 'Y-m-d H:i:s');
    //            $modPendaftaran->pasienpulang_id = $modelPulang->pasienpulang_id;
    if ($daftar) {
      $this->successUpdatePendaftaran = true;
      return $modPendaftaran;
    } else {
      $this->successUpdatePendaftaran = false;
    }
  }

  protected function updatePasienAdmisi($modPasienAdmisi, $modelPulang)
  {
    $modPasienAdmisi->pasienpulang_id = $modelPulang->pasienpulang_id;
    $modPasienAdmisi->tglpulang = $modelPulang->tglpasienpulang;
    $admisi = PasienadmisiT::model()->updateByPk($modPasienAdmisi->pasienadmisi_id, array("tglpulang" => $modPasienAdmisi->tglpulang, "pasienpulang_id" => $modPasienAdmisi->pasienpulang_id));
    if ($admisi) {
      $this->successUpdatePasienAdmisi = true;
    } else {
      $this->successUpdatePasienAdmisi = false;
    }

    return $modPasienAdmisi;
  }

  protected function savePasienPulang($modMasukKamar, $modPasienPulang, $attrPasienPulang, $pasienadmisi_id = '')
  {
    $format = new MyFormatter();
    $modelPulangNew = new PIPasienPulangT;
    $modelPulangNew->attributes = $attrPasienPulang;
    $modelPulangNew->carakeluar_id = $attrPasienPulang['carakeluar_id'];
    $modelPulangNew->kondisikeluar_id = $attrPasienPulang['kondisikeluar_id'];
    $modelPulangNew->tglpasienpulang = $format->formatDateTimeForDb(trim($attrPasienPulang['tglpasienpulang']));
    $modelPulangNew->tgl_meninggal = (isset($attrPasienPulang['tgl_meninggal']) ? $format->formatDateTimeForDb(trim($attrPasienPulang['tgl_meninggal'])) : null);
    $modelPulangNew->lamarawat = $modMasukKamar->lamadirawat_kamar;
    $modelPulangNew->satuanlamarawat = Params::SATUAN_LAMARAWAT_PI;
    //		$modelPulangNew->ruanganakhir_id = Yii::app()->user->getState('ruangan_id');
    $modelPulangNew->ruanganakhir_id = $this->getRuanganId($modPasienPulang->pasienadmisi_id);
    $modelPulangNew->create_time = date('Y-m-d H:i:s');
    $modelPulangNew->update_time = date('Y-m-d H:i:s');
    //		$modelPulangNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modelPulangNew->create_ruangan = $this->getRuanganId($modPasienPulang->pasienadmisi_id);
    $modelPulangNew->create_loginpemakai_id = Yii::app()->user->id;
    $modelPulangNew->update_loginpemakai_id = Yii::app()->user->id;
    $modelPulangNew->pasienadmisi_id = $pasienadmisi_id;

    if (isset($attrPasienPulang['tgl_meninggal'])) {
      $modelPulangNew->ismeninggal = true;
    } else {
      $modelPulangNew->ismeninggal = false;
    }

    $masukKamar = MasukkamarT::model()->findByAttributes(
      array(
        'pasienadmisi_id' => $pasienadmisi_id,
        'pindahkamar_id' => null
      )
    );
    if ($modelPulangNew->validate()) {
      if ($modelPulangNew->save()) {
        //                   ini digunakan untuk mengupdate masukkamar ruangan_id=>menjadi null dan kamarruangan_m  status menjadi true
        $kamarruangan_status = true;
        $keterangan_kamar = Params::KETERANGANKAMAR_TERSEDIA;
        $modBookingkamar = BookingkamarT::model()->findByAttributes(array('kamarruangan_id' => $masukKamar->kamarruangan_id, 'statuskonfirmasi' => 'SUDAH KONFIRMASI', 'pasienadmisi_id' => null));
        if (!empty($modBookingkamar)) {
          $kamarruangan_status = false;
          $keterangan_kamar = Params::KETERANGANKAMAR_DIPESAN;
        }
        $ukamarruangan = true;
        if (!empty($masukKamar->kamarruangan_id)) {
          $ukamarruangan = KamarruanganM::model()->updateByPk(
            $masukKamar->kamarruangan_id,
            array(
              'kamarruangan_status' => $kamarruangan_status,
              'keterangan_kamar' => $keterangan_kamar
            )
          );
        }
        // RND-12583
        //				$umasukkamar = MasukkamarT::model()->updateByPk($masukKamar->masukkamar_id, array('kamarruangan_id' => null));
        if ($ukamarruangan || $umasukkamar) {
          $this->successPasienPulang = true;
        }
      } else {
        $this->successPasienPulang = false;
      }
    }

    return $modelPulangNew;
  }

  public function actionPindahKamarDariTransaksi()
  {
    $this->pageTitle = Yii::app()->name . " - Pindah Kamar";
    $format = new MyFormatter;
    $modPindahKamar = new PIPindahkamarT;
    $modPasienPIV = new PIPasienRawatInapV;
    $modMasukKamar = new PIMasukKamarT;
    $akomodasitersimpan=false;
    $modPindahKamar->tglpindahkamar = date('Y-m-d');
    $modPindahKamar->jampindahkamar = date('H:i:s');
    $tersimpan = 'Tidak';

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
    $smspasien = 1;

    $modPasienPIV->unsetAttributes();
    if (isset($_GET['PIPasienRawatInapV'])) {
      $modPasienPIV->attributes = $_GET['PIPasienRawatInapV'];
    }

    if (isset($_POST['PIPindahkamarT'])) {
      if ($_POST['PIPindahkamarT']['pendaftaran_id'] == '') {
        Yii::app()->user->setFlash('error', "Pendaftaran masih kosong coba cek lagi");
        $this->refresh();
      } else {
        $modPindahKamar->attributes = $_POST['PIPindahkamarT'];
        $pendaftaran_id = ((isset($_POST['PIPindahkamarT']['pendaftaran_id'])) ? $_POST['PIPindahkamarT']['pendaftaran_id'] : null);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $modPasienPIV = PIPasienRawatInapV::model()->findByAttributes(
          array(
            'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id
          )
        );

        /* PASIEN MASUK KAMAR LAMA */
        $modMasukKamar = PIMasukKamarT::model()->findByPk(
          $modPindahKamar->masukkamar_id
        );

        /* PASIEN ADMISI */
        $modPasienAdmisi = PIPasienAdmisiT::model()->findByPK(
          $modPindahKamar->pasienadmisi_id
        );

        /* END PASIEN ADMISI */

        $modPindahKamar->pasien_id = $modPasienPIV->pasien_id;
        $modPindahKamar->pendaftaran_id = $modPasienPIV->pendaftaran_id;
        $modPindahKamar->pasienadmisi_id = $modPasienPIV->pasienadmisi_id;
        $modPindahKamar->masukkamar_id = null;
        $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id');
        $modPindahKamar->nopindahkamar = MyGenerator::noMasukKamar($modPindahKamar->ruangan_id);
        $modPindahKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
        $modPindahKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
        $modPindahKamar->pegawai_id = $modPasienAdmisi->pegawai_id;


        /* PROSES SIMPAN DAN UPDATE */
        $transaction = Yii::app()->db->beginTransaction();
        $is_simpan = false;
        $errors = array();
        $pesan = array(
          'status' => 'success',
          'text' => 'Data Berhasil Disimpan'
        );
        try {
          if (Yii::app()->user->getState('akomodasiotomatis') == true) {
            if(isset($modAdmisi)){
              $akomodasitersimpan = self::simpanAkomodasiOtomatis($modAdmisi->tgladmisi, date("Y-m-d H:i:s"), $modAdmisi->pasienadmisi_id);
            }
            if ($akomodasitersimpan) {
              Yii::app()->user->setFlash('success', "Akomodasi otomatis tersimpan!");
            } else {
              Yii::app()->user->setFlash('error', "Akomodasi otomatis gagal disimpan! Silakan atur master dan tarif akomodasi!");
            }
          }
          /* simpan_pindah_kamar */

          $isSimpanPindahKamar = false;
          if ($modPindahKamar->save()) {
            $isSimpanPindahKamar = true;
          };
          if (!empty($modPasienAdmisi->kamarruangan_id)) {
            KamarruanganM::model()->updateByPk(
              $modPasienAdmisi->kamarruangan_id,
              array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA)
            );
          }

          /* update_masuk_kamar lama */
          $modMasukKamar->pindahkamar_id = $modPindahKamar->pindahkamar_id;
          if ($modMasukKamar->save()) {
            /* update_pasien_admisi */
            $is_simpan = true;
            $modPasienAdmisi->ruangan_id = $modPindahKamar->ruangan_id;
            $modPasienAdmisi->kelaspelayanan_id = $modPindahKamar->kelaspelayanan_id;
            $modPasienAdmisi->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;
            if ($modPasienAdmisi->save()) {
              /* simpan_masuk_kamar_new */
              $is_simpan = true;
              $mod_masuk_kamar = new PIMasukKamarT();
              $mod_masuk_kamar->attributes = $modPindahKamar->attributes; //mengambil nilai ruangan_id, 
              $mod_masuk_kamar->pindahkamar_id = null; //karena record baru asumsi belum pernah pindah
              $mod_masuk_kamar->masukkamar_id = null; //record baru
              //							$mod_masuk_kamar->nomasukkamar = MyGenerator::noMasukKamar(Yii::app()->user->getState('ruangan_id'));
              $mod_masuk_kamar->nomasukkamar = MyGenerator::noMasukKamar($modPasienAdmisi->ruangan_id);
              $mod_masuk_kamar->tglmasukkamar = $modPindahKamar->tglpindahkamar;
              $mod_masuk_kamar->jammasukkamar = $modPindahKamar->jampindahkamar;
              $mod_masuk_kamar->kelaspelayanan_id = empty($modPindahKamar->kelaspelayanan_id) ? $modMasukKamar->kelaspelayanan_id : $modPindahKamar->kelaspelayanan_id;
              $mod_masuk_kamar->create_time = date('Y-m-d H:i:s');
              $mod_masuk_kamar->create_loginpemakai_id = Yii::app()->user->id;
              //							$mod_masuk_kamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $mod_masuk_kamar->create_ruangan = $modPasienAdmisi->ruangan_id;
              $mod_masuk_kamar->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;
              if ($mod_masuk_kamar->save()) {
                $is_simpan = true;

                /* update_kamar_ruangan */
                if (!empty($modPindahKamar->kamarruangan_id)) {
                  KamarruanganM::model()->updateByPk(
                    $modPindahKamar->kamarruangan_id,
                    array('kamarruangan_status' => false, 'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN)
                  );
                }
              } else {
                $is_simpan = false;
                $pesan = array(
                  'status' => 'error',
                  'text' => 'Data Masuk Kamar Gagal Disimpan'
                );
                $errors[] = $pesan;
              }
            } else {
              $is_simpan = false;
              $pesan = array(
                'status' => 'error',
                'text' => 'Data Admisi Gagal Disimpan'
              );
              $errors[] = $pesan;
            }
          } else {
            $is_simpan = false;
            $pesan = array(
              'status' => 'error',
              'text' => 'Data Masuk Kamar Gagal Disimpan'
            );
            $errors[] = $pesan;
          }

          if ($is_simpan && $isSimpanPindahKamar) {

            // SMS GATEWAY
            $modPasien = $modPasienAdmisi->pasien;
            $modRuangan = $modPasienAdmisi->ruangan;
            $modKamarRuangan = $modPasienAdmisi->kamarruangan;
            $modKelaspelayanan = $modPasienAdmisi->kelaspelayanan;
            $sms = new Sms();
            foreach ($modSmsgateway as $i => $smsgateway) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modRuangan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modKelaspelayanan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modKamarRuangan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPindahKamar->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPindahKamar->tglpindahkamar), $isiPesan);


              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
            // END SMS GATEWAY

            $tersimpan = 'Ya';
            $transaction->commit();
            Yii::app()->user->setFlash($pesan['status'], $pesan['text']);
          } else {
            foreach ($errors as $val) {
              Yii::app()->user->setFlash($val['status'], $val['text']);
            }
            $transaction->rollback();
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render(
      'formPindahKamar',
      array(
        'modPindahKamar' => $modPindahKamar,
        'modPasienPIV' => $modPasienPIV,
        'tersimpan' => $tersimpan,
        'modMasukKamar' => $modMasukKamar,
        'smspasien' => $smspasien
      )
    );
  }

  public function actionPindahKamarPasienPI($pendaftaran_id)
  {

    Yii::import("rawatInap.controllers.PasienRawatInapController");

    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPindahKamar = new PIPindahkamarT;
    $modPasienAdmisi = new PIPasienAdmisiT;
    $modPasienPulang = new PIPasienPulangT;
    $modMasukKamar = new PIMasukKamarT;
    $modTindakan = null;

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
    $smspasien = 1;

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasienPIV = PIPasienRawatInapV::model()->findByAttributes(
      array('pasienadmisi_id' => $modPendaftaran->pasienadmisi_id)
    );
    $modMasukKamar = PIMasukKamarT::model()->findByPk(
      $modPasienPIV->masukkamar_id
    );

    $modPindahKamar->pasien_id = $modPasienPIV->pasien_id;
    $modPindahKamar->pendaftaran_id = $modPasienPIV->pendaftaran_id;
    $modPindahKamar->pasienadmisi_id = $modPasienPIV->pasienadmisi_id;
    $modPindahKamar->masukkamar_id = $modPasienPIV->masukkamar_id;
    $modPindahKamar->kamarruangan_id = !empty($modPasienPIV->kamarruangan_id) ? $modPasienPIV->kamarruangan_id : null;
    $modPindahKamar->pegawai_id = $modPendaftaran->pegawai_id;
    $modPindahKamar->carabayar_id = $modPendaftaran->carabayar_id;
    // $modPindahKamar->ruangan_id = $modPendaftaran->ruangan_id;
    $modPindahKamar->penjamin_id = $modPendaftaran->penjamin_id;
    // $modPindahKamar->kelaspelayanan_id = $modPasienPIV->kelaspelayanan_id;
    $modPindahKamar->jampindahkamar = date('H:i:s');
    $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id');
    $modPindahKamar->nopindahkamar = MyGenerator::noPindahKamar($modPindahKamar->ruangan_id);
    $modPindahKamar->tglpindahkamar = date('d M Y');

    if (!empty($modPindahKamar->ruangan_id)) {
      $modRuang = RuanganM::model()->findByPk($modPindahKamar->ruangan_id);
      $modPindahKamar->instalasi_id = $modRuang->instalasi_id;
    }

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

    // $modPindahKamar->ruangan_id = null;

    $tersimpan = 'Tidak';
    if (isset($_POST['PIPindahkamarT'])) {
      if ($_POST['PIPindahkamarT']['pendaftaran_id'] == '') {
        Yii::app()->user->setFlash('error', "Pendaftaran masih kosong coba cek lagi");
        $this->refresh();
      } else {
        $modPindahKamar->attributes = $_POST['PIPindahkamarT'];
        $modPindahKamar->tglpindahkamar = $format->formatDateTimeForDb($_POST['PIPindahkamarT']['tglpindahkamar']) . " " . $modPindahKamar->jampindahkamar;
        $pendaftaran_id = ((isset($_POST['PIPindahkamarT']['pendaftaran_id'])) ? $_POST['PIPindahkamarT']['pendaftaran_id'] : null);
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $modPasienPIV = PIPasienRawatInapV::model()->findByAttributes(
          array(
            'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id
          )
        );

        /* PASIEN MASUK KAMAR LAMA */
        $modMasukKamar = PIMasukKamarT::model()->findByPk(
          $modPindahKamar->masukkamar_id
        );

        /* PASIEN ADMISI */
        $modPasienAdmisi = PIPasienAdmisiT::model()->findByPK(
          $modPindahKamar->pasienadmisi_id
        );

        /* END PASIEN ADMISI */

        $modPindahKamar->pasien_id = $modPasienPIV->pasien_id;
        $modPindahKamar->pendaftaran_id = $modPasienPIV->pendaftaran_id;
        $modPindahKamar->pasienadmisi_id = $modPasienPIV->pasienadmisi_id;
        $modPindahKamar->shift_id = Yii::app()->user->getState('shift_id');
        $modPindahKamar->nopindahkamar = MyGenerator::noPindahKamar($modPindahKamar->ruangan_id);
        $modPindahKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
        $modPindahKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
        $modPindahKamar->pegawai_id = $modPasienAdmisi->pegawai_id;


        /* PROSES SIMPAN DAN UPDATE */
        $transaction = Yii::app()->db->beginTransaction();
        $is_simpan = false;
        $errors = array();
        $pesan = array(
          'status' => 'success',
          'text' => 'Data Berhasil Disimpan'
        );
        try {
          /* simpan_pindah_kamar */
          $modPindahKamar->masukkamar_id = null; //ini di isi masukkamar baru nanti
          if ($modPindahKamar->save()) {
            $modMasukKamar->pindahkamar_id = $modPindahKamar->pindahkamar_id;
          } else {
            $modMasukKamar->pindahkamar_id = null;
          }

          if (!empty($modPasienAdmisi->kamarruangan_id)) {
            KamarruanganM::model()->updateByPk(
              $modPasienAdmisi->kamarruangan_id,
              array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA)
            );
          }
          /*
					if (Yii::app()->user->getState('akomodasiotomatis') == true) {
						$akomodasitersimpan = self::simpanAkomodasiOtomatis($modPasienAdmisi->tgladmisi, $modPindahKamar->tglpindahkamar, $modPasienAdmisi->pasienadmisi_id);
						if ($akomodasitersimpan) {
							Yii::app()->user->setFlash('success', "Akomodasi otomatis tersimpan!");
						} else {
							Yii::app()->user->setFlash('error', "Akomodasi otomatis gagal disimpan! Silakan atur master dan tarif akomodasi!");
						}
					}
                     * 
                     */

          $modMasukKamar->pindahkamar_id = $modPindahKamar->pindahkamar_id;
          $modMasukKamar->tglkeluarkamar = $modPindahKamar->tglpindahkamar;
          $modMasukKamar->jamkeluarkamar = $modPindahKamar->jampindahkamar;

          $selisihHari = CustomFunction::hitungHari($modMasukKamar->tglmasukkamar, $modMasukKamar->tglkeluarkamar);

          $modMasukKamar->lamadirawat_kamar = $selisihHari;

          /* update_masuk_kamar lama */
          if ($modMasukKamar->save()) {
            /* update_pasien_admisi */
            $is_simpan = true;
            $modPasienAdmisi->ruangan_id = $modPindahKamar->ruangan_id;
            $modPasienAdmisi->kelaspelayanan_id = $modPindahKamar->kelaspelayanan_id;
            $modPasienAdmisi->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;
            if ($modPasienAdmisi->save()) {
              /* simpan_masuk_kamar_new */
              $is_simpan = true;
              $mod_masuk_kamar = new PIMasukKamarT();
              $mod_masuk_kamar->attributes = $modPindahKamar->attributes; //mengambil nilai ruangan_id, 
              $mod_masuk_kamar->pindahkamar_id = null; //karena record baru asumsi belum pernah pindah
              $mod_masuk_kamar->masukkamar_id = null; //record baru
              //							$mod_masuk_kamar->nomasukkamar = MyGenerator::noMasukKamar(Yii::app()->user->getState('ruangan_id'));
              $mod_masuk_kamar->nomasukkamar = MyGenerator::noMasukKamar($modPasienAdmisi->ruangan_id);
              $mod_masuk_kamar->tglmasukkamar = $modPindahKamar->tglpindahkamar;
              $mod_masuk_kamar->jammasukkamar = $modPindahKamar->jampindahkamar;
              $mod_masuk_kamar->kelaspelayanan_id = empty($modPindahKamar->kelaspelayanan_id) ? $modMasukKamar->kelaspelayanan_id : $modPindahKamar->kelaspelayanan_id;
              $mod_masuk_kamar->create_time = date('Y-m-d H:i:s');
              $mod_masuk_kamar->create_loginpemakai_id = Yii::app()->user->id;
              //							$mod_masuk_kamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $mod_masuk_kamar->create_ruangan = $modPasienAdmisi->ruangan_id;
              $mod_masuk_kamar->kamarruangan_id = !empty($modPindahKamar->kamarruangan_id) ? $modPindahKamar->kamarruangan_id : null;

              if ($mod_masuk_kamar->save()) {
                $is_simpan = true;
                //update masukkamar_id (baru) pada pindahkamar_t
                $modPindahKamar->updateByPk($modPindahKamar->pindahkamar_id, array('masukkamar_id' => $mod_masuk_kamar->masukkamar_id));
                if (!empty($modPindahKamar->kamarruangan_id)) {
                  /* update_kamar_ruangan */
                  KamarruanganM::model()->updateByPk(
                    $modPindahKamar->kamarruangan_id,
                    array('kamarruangan_status' => false, 'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN)
                  );
                }
              } else {
                $is_simpan = false;
                $pesan = array(
                  'status' => 'error',
                  'text' => 'Data Masuk Kamar Gagal Disimpan'
                );
                $errors[] = $pesan;
              }
            } else {
              $is_simpan = false;
              $pesan = array(
                'status' => 'error',
                'text' => 'Data Admisi Gagal Disimpan'
              );
              $errors[] = $pesan;
            }
          } else {
            $is_simpan = false;
            $pesan = array(
              'status' => 'error',
              'text' => 'Data Masuk Kamar Gagal Disimpan'
            );
            $errors[] = $pesan;
          }

          $kamar_asal = (!empty($modMasukKamar)) ? $modMasukKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modMasukKamar->kamarruangan->kamarruangan_nobed : '-';

          if (Yii::app()->user->getState('akomodasiotomatis') == true) {
            PasienRawatInapController::saveAkomodasi($modPendaftaran, $modPasienAdmisi);
          }

          if ($is_simpan) {
            $tersimpan = 'Ya';

            $nama_pemakai = LoginpemakaiK::model()->findByPk($mod_masuk_kamar->create_loginpemakai_id);
            $tujuan = RuanganM::model()->findByPk($modPindahKamar->ruangan_id);
            $modul = ModulK::model()->findByPk($tujuan->modul_id);

            if ($modPindahKamar->ruangan_id != Yii::app()->user->getState('ruangan_id')) {
              $judul = 'PASIEN PINDAH KAMAR';
              $isi = $modPasienPIV->no_rekam_medik . ' ' . $modPasienPIV->namadepan . ' ' . $modPasienPIV->nama_pasien . ', ' . strtoupper($kamar_asal . ' - ' . $modPindahKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modPindahKamar->kamarruangan->kamarruangan_nobed) . '<br/>'
                . MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($mod_masuk_kamar->create_time))) . ', ' . $nama_pemakai->nama_pemakai;

              if (!empty($tujuan->modul_id)) {
                $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                  array(
                    'instalasi_id' => $tujuan->instalasi_id,
                    'ruangan_id' => $tujuan->ruangan_id,
                    'modul_id' => $modul->modul_id
                  ),
                ));
              }


              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
                //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' => Params::MODUL_ID_REKAMMEDIS),
                array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
              ));
            } else {
              $judul = 'PASIEN PINDAH KAMAR';
              $isi = $modPasienPIV->no_rekam_medik . ' ' . $modPasienPIV->namadepan . ' ' . $modPasienPIV->nama_pasien . ', ' . strtoupper($kamar_asal . ' - ' . $modPindahKamar->kamarruangan->kamarruangan_nokamar . ' ' . $modPindahKamar->kamarruangan->kamarruangan_nobed) . '<br/>'
                . MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($mod_masuk_kamar->create_time))) . ', ' . $nama_pemakai->nama_pemakai;
              $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'modul_id' => Yii::app()->session['modul_id']),
                //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_LOKET, 'modul_id' => Params::MODUL_ID_PENDAFTARAN),
                array('instalasi_id' => Params::INSTALASI_ID_RM, 'ruangan_id' => Params::RUANGAN_ID_REKAM_MEDIS, 'modul_id' => Params::MODUL_ID_REKAMMEDIS),
                array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK),
              ));
            }

            // SMS GATEWAY
            $modPasien = $modPasienAdmisi->pasien;
            $modRuangan = $modPasienAdmisi->ruangan;
            $modKamarRuangan = $modPasienAdmisi->kamarruangan;
            $modKelaspelayanan = $modPasienAdmisi->kelaspelayanan;
            $sms = new Sms();
            foreach ($modSmsgateway as $i => $smsgateway) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modRuangan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modKelaspelayanan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              if ($modKamarRuangan) {
                $attributes = $modKamarRuangan->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
              }
              $attributes = $modPindahKamar->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPindahKamar->tglpindahkamar), $isiPesan);


              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
            // END SMS GATEWAY

            $transaction->commit();
            Yii::app()->user->setFlash($pesan['status'], $pesan['text']);
          } else {
            foreach ($errors as $val) {
              Yii::app()->user->setFlash($val['status'], $val['text']);
            }
            $transaction->rollback();
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan" . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }
    $this->render(
      'formPindahKamar',
      array(
        'modPindahKamar' => $modPindahKamar,
        'modPasienPIV' => $modPasienPIV,
        'modMasukKamar' => $modMasukKamar,
        'modTindakan' => $modTindakan,
        'modPendaftaran' => $modPendaftaran,
        'tersimpan' => $tersimpan,
        'is_grid' => true,
        'smspasien' => $smspasien
      )
    );
  }

  /**
   * simpan tindakan akomodasi ke tindakanpelayanan_t
   * @param type $tglmasuk = d M Y H:i:s / Y-m-d H:i:s
   * @param type $tgltransaksi = d M Y H:i:s / Y-m-d H:i:s
   * @return boolean
   * RND-9999
   */
  public static function simpanAkomodasiOtomatis($tglmasuk, $tgltransaksi, $pasienadmisi_id)
  {
    //== jumlah hari akomodasi
    
    $format = new MyFormatter();
    $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
    if ($modAdmisi->pasienpulang_id) { //jika pasien sudah pulang maka tgltransaksi berdasarkan tanggal pulang
      $tgltransaksi = PasienpulangT::model()->findByPk($modAdmisi->pasienpulang_id)->tglpasienpulang;
    }
    $tglmasuk = $format->formatDateTimeForDb($tglmasuk);
    $tgltransaksi = $format->formatDateTimeForDb($tgltransaksi);
    $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
    $lamarawat = CustomFunction::hitungHariRawat($tglmasuk, $tgltransaksi);
    $tindakantersimpan = true;
    $tglakomodasi = $tglmasuk;
    for ($i = 0; $i < $lamarawat; $i++) {
      $tglakomodasi = new DateTime($tglakomodasi);
      if ($i > 0) {
        $tglakomodasi->modify('+1 day');
      }
      $tglakomodasi = $tglakomodasi->format('Y-m-d');
      $criteria = new CDbCriteria;
      $criteria->with = array('daftartindakan');
      $criteria->addCondition("t.pasienadmisi_id = " . $pasienadmisi_id);
      $criteria->addCondition("DATE(t.tgl_tindakan) = '" . $tglakomodasi . "'");
      $criteria->addCondition("daftartindakan.daftartindakan_akomodasi IS TRUE");
      $cekAkomodasi = TindakanpelayananT::model()->find($criteria);
      if ($cekAkomodasi == false) { //jika belum ada
        $criteria2 = new CDbCriteria;
        $criteria2->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
        $criteria2->addCondition("DATE(tglmasukkamar) <= '" . $tglakomodasi . "'");
        $criteria2->order = "tglmasukkamar DESC";
        $criteria2->limit = 1;
        $modMasukKamar = MasukkamarT::model()->find($criteria2);
        if ($modMasukKamar) {
          //load daftar tindakan akomodasi
          $daftarTindakan = TariftindakanperdatotalV::model()->findByAttributes(array(
            'penjamin_id' => $modMasukKamar->penjamin_id,
            'kelaspelayanan_id' => $modMasukKamar->kelaspelayanan_id,
            'daftartindakan_akomodasi' => TRUE,
          ));
          if ($daftarTindakan) {
            $modTindakanPelayan = new TindakanpelayananT;
            $modTindakanPelayan->pasienadmisi_id = $modMasukKamar->pasienadmisi_id;
            $modTindakanPelayan->penjamin_id = $modMasukKamar->penjamin_id;
            $modTindakanPelayan->kelaspelayanan_id = $modMasukKamar->kelaspelayanan_id;
            $modTindakanPelayan->ruangan_id = $modMasukKamar->ruangan_id;
            $modTindakanPelayan->carabayar_id = $modMasukKamar->carabayar_id;
            $modTindakanPelayan->instalasi_id = $modMasukKamar->ruangan->instalasi_id;
            $modTindakanPelayan->pasien_id = $modMasukKamar->admisi->pasien_id;
            $modTindakanPelayan->pendaftaran_id = $modMasukKamar->admisi->pendaftaran_id;
            $modTindakanPelayan->jeniskasuspenyakit_id = $modMasukKamar->admisi->pendaftaran->jeniskasuspenyakit_id;
            $modTindakanPelayan->shift_id = Yii::app()->user->getState('shift_id');
            $modTindakanPelayan->daftartindakan_id = $daftarTindakan->daftartindakan_id;
            $modTindakanPelayan->tarif_satuan = $daftarTindakan->harga_tariftindakan;
            $modTindakanPelayan->qty_tindakan = 1;
            $modTindakanPelayan->tarif_tindakan = $modTindakanPelayan->tarif_satuan * $modTindakanPelayan->qty_tindakan;
            $modTindakanPelayan->satuantindakan = Params::SATUAN_LAMARAWAT_RI;
            $modTindakanPelayan->dokterpemeriksa1_id = $modMasukKamar->pegawai_id;
            $modTindakanPelayan->cyto_tindakan = 0;
            $modTindakanPelayan->tarifcyto_tindakan = 0;
            $modTindakanPelayan->discount_tindakan = 0;
            $modTindakanPelayan->subsidiasuransi_tindakan = 0;
            $modTindakanPelayan->subsidipemerintah_tindakan = 0;
            $modTindakanPelayan->subsisidirumahsakit_tindakan = 0;
            $modTindakanPelayan->pembebasan_tindakan = 0;
            $modTindakanPelayan->iurbiaya_tindakan = 0;
            $modTindakanPelayan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
            $modTindakanPelayan->tgl_tindakan = $tglakomodasi;
            $modTindakanPelayan->create_time = date('Y-m-d H:i:s');
            $modTindakanPelayan->create_loginpemakai_id = Yii::app()->user->id;
            //						$modTindakanPelayan->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modTindakanPelayan->create_ruangan = $modTindakanPelayan->ruangan_id;
            $modTindakanPelayan->tarif_rsakomodasi = 0;
            $modTindakanPelayan->tarif_medis = 0;
            $modTindakanPelayan->tarif_paramedis = 0;
            $modTindakanPelayan->tarif_bhp = 0;
            $modTindakanPelayan->keterangantindakan = "Akomodasi Otomatis";

            if ($modTindakanPelayan->save()) {
              $tindakantersimpan &= true;
            } else {
              $tindakantersimpan &= false;
            }
          }
        }
      }
    }
    return $tindakantersimpan;
  }

  /**
   * digunakan untuk membatalkan pasien rawat  Intensif
   * tabel yang digunakan 
   * pendaftaran_t; pasien_m; pasienadmisi_t; jeniskasuspenyakit_m, pasienbatalrawat_r
   * @param type $pendaftaran_id type = integer  
   */
  public function actionBatalRawatInap($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $modPasienBatalRawat = new PasienbatalrawatR;

    $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    $jenisPenyakit = JeniskasuspenyakitM::model()->findByPk($modPendaftaran->jeniskasuspenyakit_id);
    //             digunakan untuk merefresh jika data berhasil di simpan
    $tersimpan = 'Tidak';

    $modPendaftaran->jeniskasuspenyakit_nama = $jenisPenyakit->jeniskasuspenyakit_nama;
    $modPasienBatalRawat->pasienadmisi_id = $modAdmisi->pasienadmisi_id;
    $modPasienBatalRawat->create_time = date('Y-m-d H:i:s');
    $modPasienBatalRawat->update_time = date('Y-m-d H:i:s');
    //		$modPasienBatalRawat->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasienBatalRawat->create_ruangan = $modAdmisi->ruangan_id;
    $modPasienBatalRawat->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienBatalRawat->update_loginpemakai_id = Yii::app()->user->id;

    if (!empty($_REQUEST['PasienbatalrawatR'])) {

      $format = new MyFormatter();
      $modPasienBatalRawat->attributes = $_REQUEST['PasienbatalrawatR'];
      $modPasienBatalRawat->tglbatalrawat = $format->formatDateTimeForDb($modPasienBatalRawat->tglbatalrawat);
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $cek = PasienbatalrawatR::model()->findByAttributes(array('pasienadmisi_id' => $modPasienBatalRawat->pasienadmisi_id));
      $kamarRuangan = PasienadmisiT::model()->findByPk($modPasienBatalRawat->pasienadmisi_id);

      if (!empty($cek->update_time) || !empty($cek->update_loginpemakaian_id)) {
        $modPasienBatalRawat->update_time = date('Y-m-d H:i:s');
        $modPasienBatalRawat->update_loginpemakai_id = date('Y-m-d H:i:s');
      }

      if ($modPasienBatalRawat->validate()) {
        $pasienadmisi_id = $modPasienBatalRawat->pasienadmisi_id;;
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modPasienBatalRawat->save()) {
            //                          update null terlebih dahulu kamarruangan_id di pasienadmisi                

            $modA = PasienadmisiT::model()->updateByPk($pasienadmisi_id, array('kamarruangan_id' => null));

            // TindakanpelayananT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id));

            $bookingKamar = BookingkamarT::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));

            $keterangan_kamar = Params::KETERANGANKAMAR_TERSEDIA;
            $kamarruangan_status = true;
            if ($bookingKamar) {
              BookingkamarT::model()->updateByPk($bookingKamar->bookingkamar_id, array('pasienadmisi_id' => null));
              $keterangan_kamar = Params::KETERANGANKAMAR_DIPESAN;
              $kamarruangan_status = false;
            }

            $masukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
            if ($masukKamar) {
              MasukkamarT::model()->deleteByPk($masukKamar->masukkamar_id);
            }
            if (!empty($kamarRuangan->kamarruangan_id)) {
              KamarruanganM::model()->updateByPk($kamarRuangan->kamarruangan_id, array('kamarruangan_status' => $kamarruangan_status, 'keterangan_kamar' => $keterangan_kamar));
            }
            $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienadmisi_id' => null, 'alihstatus' => false));
            // $deleteAdmisi = PasienadmisiT::model()->deleteByPk($pasienadmisi_id); //RND-1592

            if ($pendaftaran) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data berhasil disimpan");
              $tersimpan = 'Ya';
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
        }
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render('formBatalRawatInap', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPasienBatalRawat' => $modPasienBatalRawat, 'tersimpan' => $tersimpan));
  }

  public function actionRencanaPulangPasienPI($idPasienadmisi)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $model = new PIPasienAdmisiT;
    $model->rencanapulang = date('Y-m-d H:i:s');
    $tersimpan = 'Tidak';

    $modelAdmisi = PIPasienAdmisiT::model()->findByPk($idPasienadmisi);
    $modPasien = PIPasienM::model()->findByPk($modelAdmisi->pasien_id);
    $modPendaftaran = PIPendaftaranT::model()->findByPk($modelAdmisi->pendaftaran_id);

    if (!empty($modelAdmisi->rencanapulang)) {
      $model->rencanapulang = $modelAdmisi->rencanapulang;
    }
    if (isset($_POST['PIPasienAdmisiT'])) {
      $rencanapulang = $format->formatDateTimeForDb($_POST['PIPasienAdmisiT']['rencanapulang']);
      $pasien_id = $_POST['PIPasienAdmisiT']['pasienadmisi_id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $update = PIPasienAdmisiT::model()->updateByPk($pasien_id, array('rencanapulang' => $rencanapulang));

        if ($update) {
          $kamarUpdate = true;
          if (!empty($modelAdmisi->kamarruangan_id)) {
            $kamarUpdate = KamarruanganM::model()->updateByPk($modelAdmisi->kamarruangan_id, array('keterangan_kamar' => Params::KETERANGANKAMAR_RENCANA_PULANG));
          }
          if ($kamarUpdate) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            $tersimpan = 'Ya';
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
            $tersimpan = 'Tidak';
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }

        //                        RND-6398
        //                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
        //                        $params['create_time'] = date( 'Y-m-d H:i:s');
        //                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
        //                        $params['instalasi_id'] = Yii::app()->user->getState('instalasi_id');
        //                        $params['modul_id'] = Yii::app()->session['modul_id'];
        //                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien;
        //                        $params['create_ruangan'] = $modelAdmisi->ruangan_id;
        //                        $params['judulnotifikasi'] = ($modelAdmisi->rencanapulang != null ? 'Rencana Pulang Pasien' : 'Rencana Pulang Pasien' );
        //                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
      }
    }

    $model->rencanapulang = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($model->rencanapulang, 'yyyy-MM-dd hh:mm:ss')
    );

    $this->render('formRencanaPulang', array(
      'modelAdmisi' => $modelAdmisi,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'model' => $model,
      'tersimpan' => $tersimpan,
    ));
  }

  /**
   * untuk load form masuk kamar pasien
   * Issue  : RND-2717
   * Date   : 24 September 2014
   */
  public function actionAddMasukKamarPI()
  {
    $pendaftaran_id = (isset(Yii::app()->session['pendaftaran_id']) ? Yii::app()->session['pendaftaran_id'] : null);
    $kamarruangan_id = (isset($_POST['kamarruangan_id']) ? $_POST['kamarruangan_id'] : null);
    $masukkamar_id = (isset(Yii::app()->session['masukkamar_id']) ? Yii::app()->session['masukkamar_id'] : null);
    $kelaspelayanan_id = (isset(Yii::app()->session['kelaspelayanan_id']) ? Yii::app()->session['kelaspelayanan_id'] : null);
    //		$ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($masukkamar_id)) {
      $modMasukKamar = MasukkamarT::model()->findByPk($masukkamar_id);
    } else {
      $modMasukKamar = new MasukkamarT();
    }
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $ruangan_id = $modPasienAdmisi->ruangan_id;

    $modMasukKamar->ruangan_id = (isset($kamarruangan_id) ? $modMasukKamar->ruangan_id : $ruangan_id);
    $modMasukKamar->tglmasukkamar = date('Y-m-d H:i:s');
    $modMasukKamar->jammasukkamar = date('H:i:s');

    $modDataPasien = PasienrawatinapV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    if (isset($_POST['MasukkamarT'])) {
      $modMasukKamar->attributes = $_POST['MasukkamarT'];
      $modMasukKamar->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
      $modMasukKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
      $modMasukKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
      $modMasukKamar->pegawai_id = $modPasienAdmisi->pegawai_id;
      $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
      $modMasukKamar->nomasukkamar = MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
      $modMasukKamar->shift_id = Yii::app()->user->getState('shift_id');
      $modMasukKamar->create_time = date('Y-m-d H:i:s');
      $modMasukKamar->create_loginpemakai_id = Yii::app()->user->id;
      //			$modMasukKamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modMasukKamar->create_ruangan = $modMasukKamar->ruangan_id;

      $kamarruanganidupdate = isset($_POST['MasukkamarT']['kamarruangan_id']) ? $_POST['MasukkamarT']['kamarruangan_id'] : null;
      //            $cekidkamar = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
      $cekidkamar = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      if (empty($kamarruanganidupdate)) {
        PasienadmisiT::model()->updateByPk($cekidkamar->pasienadmisi_id, array('kamarruangan_id' => $kamarruanganidupdate));
        if (!empty($modDataPasien->kamarruangan_id)) {
          KamarruanganM::model()->updateByPk($modDataPasien->kamarruangan_id, array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA));
        }
      }
      if ($modMasukKamar->save()) {
        if (!empty($modPasienAdmisi->kamarruangan_id)) {
          KamarruanganM::model()->updateByPk($modDataPasien->kamarruangan_id, array('kamarruangan_status' => true, 'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA));
        }
        if (!empty($kamarruanganidupdate)) {
          KamarruanganM::model()->updateByPk($kamarruanganidupdate, array('kamarruangan_status' => false));
        }

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
          ));
          exit;
        }
      } else {

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
          ));
          exit;
        }
      }
    }
    if (Yii::app()->request->isAjaxRequest) {

      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formMasukKamar', array('modMasukKamar' => $modMasukKamar, 'modDataPasien' => $modDataPasien), true)
      ));
      exit;
    }
  }

  /**
   * untuk load session masuk kamar
   */
  public function actionBuatSessionMasukKamar()
  {

    $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
    $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
    if (!empty($_POST['masukkamar_id'])) {
      $masukkamar_id = (isset($_POST['masukkamar_id']) ? $_POST['masukkamar_id'] : null);
      Yii::app()->session['masukkamar_id'] = $masukkamar_id;
    }
    Yii::app()->session['kelaspelayanan_id'] = $kelaspelayanan_id;
    Yii::app()->session['pendaftaran_id'] = $pendaftaran_id;
    Yii::app()->session['masukkamar_id'] = $masukkamar_id;

    echo CJSON::encode(array(
      'kelaspelayanan_id' => Yii::app()->session['kelaspelayanan_id'],
      'pendaftaran_id' => Yii::app()->session['pendaftaran_id'],
      'masukkamar_id' => Yii::app()->session['masukkamar_id']
    ));
  }

  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropDownKondisiKeluar($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = new PIPasienPulangT;
      if ($model_nama !== '' && $attr == '') {
        $carakeluar_id = $_POST["$model_nama"]['carakeluar_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $carakeluar_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $carakeluar_id = $_POST["$model_nama"]["$attr"];
      }
      $kondisikeluar = null;
      if ($carakeluar_id) {
        $kondisikeluar = $model->getKondisikeluarItems($carakeluar_id);
        $kondisikeluar = CHtml::listData($kondisikeluar, 'kondisikeluar_id', 'kondisikeluar_nama');
      }
      if ($encode) {
        echo CJSON::encode($kondisikeluar);
      } else {
        if (empty($kondisikeluar)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kondisikeluar as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionGetKelasPelayanan($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $kelaspelayanan = array();
      if (!empty($ruangan_id)) {
        $kelasRuangan = KelasruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id));

        foreach ($kelasRuangan as $key => $value) {
          $kelaspelayanan[$key] = KelaspelayananM::model()->findByPk($value->kelaspelayanan_id);
        }
        $kelaspelayanan = CHtml::listData($kelaspelayanan, 'kelaspelayanan_id', 'kelaspelayanan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelaspelayanan);
      } else {
        if (empty($kelaspelayanan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
          foreach ($kelaspelayanan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown kasus penyakit
   */
  public function actionSetDropdownKasusPenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;

      $jeniskasuspenyakit = JeniskasuspenyakitM::model()->findAll('jeniskasuspenyakit_aktif = TRUE');
      $jeniskasuspenyakit = CHtml::listData($jeniskasuspenyakit, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');

      $jeniskasuspenyakitOptions = CHtml::dropDownList('jeniskasuspenyakit_id', '', $jeniskasuspenyakit, array("onchange" => "saveKasusPenyakit(this,$pendaftaran_id,$pasienadmisi_id)", "style" => "width:140px;", "options" => array($jeniskasuspenyakit_id => array("selected" => true))));

      $dataList['kasusPenyakit'] = $jeniskasuspenyakitOptions;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * Mengatur dropdown kasus penyakit
   */
  public function actionSaveKasusPenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $jeniskasuspenyakit_id = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null;
      $pesan = 'gagal';

      $update = PIPendaftaranT::model()->updateByPk($pendaftaran_id, array('jeniskasuspenyakit_id' => $jeniskasuspenyakit_id));
      if ($update) {
        $pesan = 'berhasil';
      } else {
        $pesan = 'gagal';
      }
      $data['pesan'] = $pesan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk Ubah Dokter
   */
  public function actionUbahDokterPeriksa()
  {
    $model = new PIPendaftaranT();
    $modAdmisi = new PIPasienAdmisiT();
    $modUbahDokter = new PIUbahdokterR;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['PIPendaftaranT'])) {
      if ($_POST['PIPendaftaranT']['pegawai_id'] != "") {
        $model->attributes = $_POST['PIPendaftaranT'];
        $modUbahDokter->attributes = $_POST['PIUbahdokterR'];
        $modUbahDokter->pendaftaran_id = $_POST['PIPendaftaranT']['pendaftaran_id'];
        $modUbahDokter->dokterbaru_id = $_POST['PIPendaftaranT']['pegawai_id'];
        $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
        $modUbahDokter->create_time = date('Y-m-d H:i:s');
        $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
        //				$modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahDokter->create_ruangan = $this->getRuanganId($_POST['PIPendaftaranT']['pasienadmisi_id']);
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('pegawai_id' => $_POST['PIPendaftaranT']['pegawai_id']);
          $masukkamar = PIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $_POST['PIPendaftaranT']['pasienadmisi_id']));
          if (!empty($masukkamar)) {
            $save = PIMasukKamarT::model()->updateByPk($masukkamar->masukkamar_id, $attributes);
            $save = $modAdmisi::model()->updateByPk($_POST['PIPendaftaranT']['pasienadmisi_id'], $attributes);
          } else {
            $save = $modAdmisi::model()->updateByPk($_POST['PIPendaftaranT']['pasienadmisi_id'], $attributes);
          }
          if ($save) {
            $modUbahDokter->save();
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formUbahDokterPeriksa', array('model' => $model, 'modAdmisi' => $modAdmisi, 'modUbahDokter' => $modUbahDokter, 'menu' => $menu), true)
      ));
      exit;
    }
  }

  public function actionUbahDokterPeriksa2()
  {
    $model = new PIPendaftaranT();
    $modAdmisi = new PIPasienAdmisiT();
    $modUbahDokter = new PIUbahdokterR;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['PIPendaftaranT'])) {
      if ($_POST['PIPendaftaranT']['pegawai_id'] != "") {

        $admisi = PIPasienAdmisiT::model()->findByPk($_POST['PIPendaftaranT']['pasienadmisi_id']);

        $model->attributes = $_POST['PIPendaftaranT'];
        $modUbahDokter->attributes = $_POST['PIUbahdokterR'];
        $modUbahDokter->pendaftaran_id = $_POST['PIPendaftaranT']['pendaftaran_id'];
        // $modUbahDokter->dokterbaru_id = $_POST['RIPendaftaranT']['pegawai_id'];
        $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
        $modUbahDokter->create_time = date('Y-m-d H:i:s');
        $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahDokter->pasienadmisi_id = $admisi->pasienadmisi_id;

        // print_r($modUbahDokter->attributes); 
        // print_r($_POST['RIPendaftaranT']['pegawai_id']);

        $pegawais = $_POST['PIPendaftaranT']['pegawai_id'];

        $transaction = Yii::app()->db->beginTransaction();
        try {

          $ok = true;

          foreach ($pegawais as $param => $item) {
            if (!empty($item)) {
              $ok = $ok && $this->simpanUbahDokters($modUbahDokter, $admisi, $param, $item);
            }
          }

          // var_dump($ok);

          // die;

          /*
					 $attributes = array('pegawai_id'=>$_POST['RIPendaftaranT']['pegawai_id']);
					 $masukkamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id'=>$_POST['RIPendaftaranT']['pasienadmisi_id']));
					 if(count((array)$masukkamar) > 0){
						 $save = RIMasukKamarT::model()->updateByPk($masukkamar->masukkamar_id, $attributes);
						 $save = RIPasienAdmisiT::model()->updateByPk($_POST['RIPendaftaranT']['pasienadmisi_id'], $attributes);
					 }else{
						 $save = $modAdmisi::model()->updateByPk($_POST['RIPendaftaranT']['pasienadmisi_id'], $attributes);
					 }
					  * 
					  */
          if ($ok) {
            $modUbahDokter->save();
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form2',
        'div' => $this->renderPartial('_formUbahDokterPeriksa2', array('model' => $model, 'modAdmisi' => $modAdmisi, 'modUbahDokter' => $modUbahDokter, 'menu' => $menu), true)
      ));
      exit;
    }
  }

  public function actionGetDataPendaftaranPI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $model = InfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran, 'pasienadmisi_id' => $pasienadmisi_id));
      $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
        $returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
        $returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
        $returnVal["pegawai_id"] = isset($modPasienAdmisi->pegawai_id) ? $modPasienAdmisi->pegawai_id : null;
      }
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionGetDataPendaftaranPI2()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $model = InfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran, 'pasienadmisi_id' => $pasienadmisi_id));
      $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
        $returnVal["gelarbelakang_nama"] = isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "";
        $returnVal["gelardepan"] = isset($model->gelardepan) ? $model->gelardepan : "";
        $returnVal["pegawai_id"] = isset($modPasienAdmisi->pegawai_id) ? $modPasienAdmisi->pegawai_id : null;

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
      }
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'nama_pegawai');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        $dataList['listDokter'] = $option;
      } else {
        $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * untuk print data penjualan dokter
   */
  public function actionPrintPasienPulang($pasienpulang_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPulang = PIPasienPulangT::model()->findByPk($pasienpulang_id);
    $modMasukKamar = PIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $modPulang->pasienadmisi_id));
    $modPasien = PIPendaftaranT::model()->findByAttributes(array('pasienadmisi_id' => $modPulang->pasienadmisi_id));

    $judul_print = 'Pasien Pulang';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render('Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPulang' => $modPulang,
      'modMasukKamar' => $modMasukKamar,
      'modPasien' => $modPasien
    ));
  }

  /**
   * Tampil dialog label gelang pasien
   */
  public function actionLabelGelang()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $datatable = '';
    $pendaftaran_id = $_GET['pendaftaran_id'];
    $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
    $this->render('_labelGelang', array(
      'modPendaftaran' => $modPendaftaran,
    ));
  }

  public function actionPrintLabelGelang($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);

    $judul_print = 'Label Gelang';
    $this->render('printLabelGelang', array(
      'modPendaftaran' => $modPendaftaran
    ));
  }

  public function actionGetKamarKosong($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_POST['kelaspelayanan_id'])) {
        $ruangan_id = $_POST['ruangan_id'];
        $kelaspelayanan_id = ($_POST['kelaspelayanan_id'] == '' ? 0 : $_POST['kelaspelayanan_id']);

        $kamarKosong = array();
        if (!empty($ruangan_id)) {
          $kamarKosong = KamarruanganM::model()->findAllByAttributes(
            array(
              'ruangan_id' => $ruangan_id,
              'kelaspelayanan_id' => $kelaspelayanan_id,
              'kamarruangan_status' => (isset($_POST['is_status']) ? $_POST['is_status'] : true)
            )
          );
          $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
        }
      } else {
        $ruangan_id = $_POST['ruangan_id'];
        $kamarKosong = array();
        if (!empty($ruangan_id)) {
          $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'kamarruangan_status' => true));
          $kamarKosong = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
        }
      }

      if ($encode) {
        echo CJSON::encode($kamarKosong);
      } else {
        if (empty($kamarKosong)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
        } else {
          if (count((array)$kamarKosong) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode("-- Pilih --"), true);
          }
          foreach ($kamarKosong as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionVerifikasiRencanaPulang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $data['pesan'] = '';
      $data['verifikasinull'] = '';
      $modRencanaTindakan = RencanatindakanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'rencanatindakan_id DESC'));
      if (!empty($modRencanaTindakan)) {
        $data['status'] = true;
        $data['pesan'] = "";
        if (empty($modRencanaTindakan->verifrenctindakan_id)) {
          $data['verifikasinull'] = 'ya';
          $data['pesan'] = "Tindakan Pasien Belum Di-Verifikasi";
        }
      } else {
        if (empty($status)) {
          //	var_dump($status);
          $data['status'] = false;
          $data['pesan'] = "Anda tidak akan dapat melakukan transaksi setelah membuat Rencana Pulang untuk Pasien. <br>Apakah Anda akan melanjutkan membuat Rencana Pulang ?";
          //var_dump($pendaftaran_id);die;
          $data['statusbayar'] = (PasienpulangT::model()->cekSisaPembayaran($pendaftaran_id) == false) ? 'ada' : 'tidak';
        } else {
          $data['status'] = true;
          $data['pesan'] = '';
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Untuk cek tagihan pasien pada saat batal periksa
   */
  public function actionCekTagihan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $status_tindakan = false;
      $status_obat = false;
      $status_batal = true;
      $pesan = '';
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;

      $criteriaTindakan = new CDbCriteria();
      $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');

      $modTindakanPelayanan = PITindakanPelayananT::model()->find($criteriaTindakan);

      $criteriaObat = new CDbCriteria();
      $criteriaObat->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $criteriaObat->addCondition('oasudahbayar_id is not null');
      $modObatalkesPasien = PIObatalkespasienT::model()->find($criteriaObat);

      if ($modTindakanPelayanan) {
        $status_tindakan = true;
      }

      if ($modObatalkesPasien) {
        $status_obat = true;
      }

      if ($status_tindakan == true || $status_obat == true) {
        $status_batal = false;
        $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan/obat yang sudah dibayarkan. Silakan hubungi Kasir!";
      } else {
        $status_batal = true;
      }

      $data['status_tindakan'] = $status_tindakan;
      $data['status_obat'] = $status_obat;
      $data['status_batal'] = $status_batal;
      $data['pesan'] = $pesan;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionCekLoginBatalPemeriksaan($task = 'BatalPemeriksaanPasien')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $username = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
      $password = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');

      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $username,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $data['status'] = 'Gagal Login';
      } else {
        // cek password
        if ($user->katakunci_pemakai !== $user->encrypt($password)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
        } else {
          // cek ruangan
          $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array(
            'loginpemakai_id' => $user->loginpemakai_id,
            'ruangan_id' => $ruangan_id
          ));
          if ($ruangan_user === null) {
            $data['error'] = 'ruangan salah!';
            $data['status'] = 'Gagal Login';
          } else {
            $data['error'] = '';
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
            if ($cek) {
              $data['status'] = 'success';
              $data['userid'] = $user->loginpemakai_id;
              $data['username'] = $user->nama_pemakai;
            } else {
              $data['status'] = 'Tidak memiliki akses untuk melakukan pembatalan!';
            }
          }
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionBatalRawat($task = 'BatalRawat')
  {

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;

    $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
    $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
    $statusperiksa = isset($_POST['statusperiksa']) ? $_POST['statusperiksa'] : null;
    $tglbatal = isset($_POST['tglbatal']) ? $_POST['tglbatal'] : null;
    $keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;
    $nama_pemakai = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
    $kata_kunci = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;


    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $status_batal = true;
    $ruangan_nama = '';
    $noresep = '';
    $nopembayaran = '';

    $pesan = '';
    $status = false;

    $delete_tindakan = true;
    $update_pendaftaran = false;
    $delete_admisi = false;
    $insert_batalrawat = false;
    $delete_pindahkamar = true;
    $delete_masukkamar = true;
    $update_kamarruangan = true;
    $update_masukkamar = true;
    $pembatalan = true;
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = Yii::app()->user->getState('ruangan_id');

      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $nama_pemakai,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $status = false;
        $pesan = 'Gagal Login';
      } else {
        // cek password
        if (!$user->cekPassword3($kata_kunci)) {
          //				if ($user->katakunci_pemakai !== $user->encrypt($kata_kunci)) { RSPMC-1532
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
          $pesan = 'Gagal Login';
        } else {
          //                                    echo 'masukkk';
          //                                    exit();
          // cek ruangan
          $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array(
            'loginpemakai_id' => $user->loginpemakai_id,
            'ruangan_id' => $ruangan_id
          ));
          if ($ruangan_user === null) {
            $data['error'] = 'ruangan salah!';
            $data['status'] = 'Gagal Login';
            $pesan = 'Gagal Login';
          } else {
            $data['error'] = '';
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
            if ($cek) {
              //							$status = 'success';
              $data['userid'] = $user->loginpemakai_id;
              $data['username'] = $user->nama_pemakai;

              $transaction = Yii::app()->db->beginTransaction();
              try {

                $criteria = new CDbCriteria();
                $criteria->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
                $criteria->addCondition('tindakansudahbayar_id is not null');
                $modTindakanPelayanan = TindakanpelayananT::model()->find($criteria);

                $criteria2 = new CDbCriteria();
                $criteria2->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
                $modPasienPenunjang = PasienmasukpenunjangT::model()->findAll($criteria2);

                $criteria3 = new CDbCriteria();
                $criteria3->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
                $modAnamnesa = AnamnesaT::model()->findAll($criteria3);

                $criteria4 = new CDbCriteria();
                $criteria4->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
                $modPeriksaFisik = PemeriksaanfisikT::model()->findAll($criteria4);

                $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
                $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
                if (!empty($modTindakanPelayanan)) {
                  $status = false;
                  $pesan = "Rawat Intensif tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
                } else if (count((array)$modPasienPenunjang) > 0) {
                  foreach ($modPasienPenunjang as $i => $data) {
                    $ruangan_nama .= isset($data->ruangan_id) ? $data->ruangan->ruangan_nama : "" . ", ";
                  }
                  $pesan = "Rawat Intensif tidak bisa dibatalkan karena ada konsul ke " . $ruangan_nama;
                } else if (count((array)$modAnamnesa) > 0) {
                  $status = false;
                  $pesan = "Rawat Intensif tidak bisa dibatalkan karena ada anamnesis!";
                } else if (count((array)$modPeriksaFisik) > 0) {
                  $status = false;
                  $pesan = "Rawat Intensif tidak bisa dibatalkan karena ada pemeriksaan fisik!";
                } else {
                  $criteria = new CDbCriteria();
                  $criteria->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
                  $criteria->addCondition('pindahkamar_id is not null');
                  $modPindahKamar = MasukkamarT::model()->find($criteria);
                  if (!empty($modPindahKamar)) {
                    if (!empty($modPindahKamar->kamarruangan_id)) {
                      $keterangan_kamar = Params::KETERANGANKAMAR_DIGUNAKAN;
                      $kamarruangan_status = false;
                      KamarruanganM::model()->updateByPk($modPindahKamar->kamarruangan_id, array('kamarruangan_status' => $kamarruangan_status, 'keterangan_kamar' => $keterangan_kamar));
                      $update_kamarruangan = true;
                    }

                    $select_pindahkamar = PindahkamarT::model()->findByPk($modPindahKamar->pindahkamar_id);
                    if (isset($select_pindahkamar)) {
                      $masukkamar_id = $select_pindahkamar->masukkamar_id;
                      $update_masukkamar = MasukkamarT::model()->updateByPk($modPindahKamar->masukkamar_id, array('pindahkamar_id' => null));
                      if ($update_masukkamar) {
                        $update_masukkamar = true;
                        $delete_pindahkamar = true;
                      } else {
                        $update_masukkamar = false;
                        $delete_pindahkamar = false;
                      }

                      if ($delete_pindahkamar) {
                        $delete_pindahkamar = PindahkamarT::model()->deleteByPk($modPindahKamar->pindahkamar_id);
                        if ($delete_pindahkamar) {
                          $delete_pindahkamar = true;
                        } else {
                          $delete_pindahkamar = false;
                        }
                      }

                      $modPindahKamar = MasukkamarT::model()->findByPk($masukkamar_id);
                      $delete_masukkamar = $modPindahKamar->delete();
                      if ($delete_masukkamar) {
                        $delete_masukkamar = true;
                      } else {
                        $delete_masukkamar = false;
                      }
                    }

                    if ($update_kamarruangan && $update_masukkamar && $delete_pindahkamar && $delete_masukkamar) {
                      $status = true;
                    } else {
                      $status = false;
                    }
                  } else {
                    // cek bayaruangmuka_t
                    $bayaruangmuka = BayaruangmukaT::model()->findAllByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
                    if (count((array)$bayaruangmuka) > 0) {
                      $status = false;
                      $pembatalan = false;
                      foreach ($bayaruangmuka as $i => $bayar) {
                        $nopembayaran .= 'No. Bukti Pembayaran: ' . (isset($bayar->tandabuktibayar_id) ? $bayar->tandabuktibayar->nobuktibayar : "-") . ' - Tanggal: ' . (isset($bayar->tglbuktibayar) ? MyFormatter::formatDateTimeForUser($resep->tglbuktibayar) : "-") . '<br>';
                      }
                      $pesan = 'Pasien Rawat Intensif tidak dapat dibatalkan karena sudah melakukan pembayaran uang muka';
                    }

                    // cek penjualanresep_t
                    $penjualanresep = PenjualanresepT::model()->findAllByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
                    if (count((array)$penjualanresep) > 0) {
                      $status = false;
                      $pembatalan = false;
                      foreach ($penjualanresep as $i => $resep) {
                        $noresep .= 'No. Resep: ' . (isset($resep->noresep) ? $resep->noresep : "-") . ' - Tanggal: ' . (isset($resep->tglresep) ? MyFormatter::formatDateTimeForUser($resep->tglresep) : "-") . '<br>';
                      }
                      $pesan = 'Pasien Rawat Intensif tidak dapat dibatalkan karena sudah melakukan pembelian resep apotek ' . $noresep;
                    }

                    if ($pembatalan == true) {
                      // menghapus tindakan pelayanan
                      $select_tindakan = TindakanpelayananT::model()->findAllByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
                      $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteAllByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
                      if (count((array)$select_tindakan)) {
                        if ($delete_tindakanpelayanan) {
                          $delete_tindakan = true;
                          $status = true;
                        } else {
                          $delete_tindakan = false;
                          $status = false;
                        }
                      }
                      // menyimpan riwayat batal rawat  Intensif pasien
                      $model = new PasienbatalrawatR();
                      $model->no_rm_batal = $modPendaftaran->pasien->no_rekam_medik;
                      $model->no_pendaftaran_batal = $modPendaftaran->no_pendaftaran;
                      $model->nama_pasien_batal = $modPendaftaran->pasien->nama_pasien;
                      $model->tgladmisi_batal = $modAdmisi->tgladmisi;
                      $model->tglpendaftaran_batal = $modPendaftaran->tgl_pendaftaran;
                      //											$model->ruanganterahkir_batal = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                      $model->ruanganterahkir_batal = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : $modAdmisi->ruangan_id;
                      $model->peg_batal = Yii::app()->user->getState('nama_pegawai');
                      $model->tglbatalrawat = date('Y-m-d H:i:s');
                      $model->alasanpembatalan = isset($keterangan_batal) ? $keterangan_batal : "Batal Rawat Intensif";
                      $model->keteranganpembatalan = isset($keterangan_batal) ? $keterangan_batal : "Batal Rawat Intensif";
                      //											$model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                      $model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : $modAdmisi->ruangan_id;
                      $model->create_time = date('Y-m-d H:i:s');
                      $model->create_loginpemakai_id = Yii::app()->user->id;

                      if ($model->save()) {
                        $insert_batalrawat = true;
                        $status = true;
                      } else {
                        $insert_batalrawat = false;
                        $status = false;
                      }

                      // ubah pendaftaran_t
                      $update_pendaftaran = PendaftaranT::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
                      if (isset($update_pendaftaran)) {
                        $update_pendaftaran->statusperiksa = Params::STATUSPERIKSA_SUDAH_PULANG;
                        $update_pendaftaran->pasienadmisi_id = null;
                        $update_pendaftaran->alihstatus = false;

                        if ($update_pendaftaran->save()) {
                          $update_pendaftaran = true;
                          $status = true;
                        } else {
                          $update_pendaftaran = false;
                          $status = false;
                        }
                      } else {
                        $update_pendaftaran = false;
                        $status = false;
                      }

                      // hapus pindahkamar_t
                      $pindahkamar = PindahkamarT::model()->findAllByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
                      if (count((array)$pindahkamar) > 0) {
                        $pindahkamar->deleteAll();
                        $delete_pindahkamar = true;
                      }


                      $kamarRuangan = PasienadmisiT::model()->findByPk($pasienadmisi_id);
                      $bookingKamar = BookingkamarT::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));

                      // ubah bookingkamar_t
                      $keterangan_kamar = Params::KETERANGANKAMAR_TERSEDIA;
                      $kamarruangan_status = true;
                      if (isset($bookingKamar)) {
                        BookingkamarT::model()->updateByPk($bookingKamar->bookingkamar_id, array('pasienadmisi_id' => null));
                        $keterangan_kamar = Params::KETERANGANKAMAR_DIPESAN;
                        $kamarruangan_status = false;
                      }

                      // hapus masukkamar_t
                      $masukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
                      if ($masukKamar) {
                        MasukkamarT::model()->deleteByPk($masukKamar->masukkamar_id);
                        $delete_masukkamar = true;
                      }

                      if (isset($kamarRuangan)) {
                        if (!empty($kamarRuangan->kamarruangan_id)) {
                          KamarruanganM::model()->updateByPk($kamarRuangan->kamarruangan_id, array('kamarruangan_status' => $kamarruangan_status, 'keterangan_kamar' => $keterangan_kamar));
                          $update_kamarruangan = true;
                        }
                      }

                      // hapus pasienadmisi_t
                      $delete_admisi = PasienadmisiT::model()->deleteByPk($pasienadmisi_id);
                      if ($delete_admisi) {
                        $delete_admisi = true;
                        $status = true;
                      } else {
                        $delete_admisi = false;
                        $status = false;
                      }

                      // status variabel/function proses berhasil/gagal
                      if ($delete_tindakan && $update_pendaftaran && $insert_batalrawat && $delete_pindahkamar && $delete_masukkamar && $update_kamarruangan && $delete_admisi) {
                        $status = true;
                      } else {
                        $status = false;
                        $pesan = 'Pasien Rawat Intensif gagal dibatalkan';
                      }
                    } else {
                      $status = false;
                      $pesan = 'Pasien Rawat Intensif gagal dibatalkan';
                    }
                  }
                  // kondisi status variabel/function proses
                  if ($status == true) {
                    $transaction->commit();
                    $pesan = 'Pasien Rawat Intensif berhasil di batalkan';
                  } else {
                    $status = false;
                    if (!isset($pesan)) {
                      $pesan = 'Pasien Rawat Intensif gagal dibatalkan';
                    }
                    $transaction->rollback();
                  }
                }
              } catch (Exception $ex) {
                $status = false;
                $pesan = "exist" . $ex;
                $transaction->rollback();
              }
            } else {
              $status = 'Tidak memiliki akses untuk melakukan pembatalan!';
            }
          }
        }
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * ubah status dokumen
   */
  public function actionStatusDokumenTerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];
      $statusdok = $_POST['status'];
      $update = false;
      $status = '';
      $div = '';
      $model = PendaftaranT::model()->findByPk($pendaftaran_id);
      if (!empty($pengirimanrm_id)) {
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
        $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
        //				$modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
        $modPenerimaanRm->ruanganpenerima_id = $this->getRuanganId($model->pasienadmisi_id);
        if ($modPenerimaanRm->save()) {
          $model->statusdokrm = 'SUDAH DITERIMA';
          $model->save();
          $update = true;
        } else {
          $update = false;
        }
      }

      if ($update == true) {
        $status = 'proses_form';
        $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil diterima </div>";
      } else {
        $status = 'proses_form';
        $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal diterima </div>";
      }

      echo CJSON::encode(array(
        'status' => $status,
        'div' => $div,
      ));
      exit;
    }
  }

  /**
   * Pengiriman Dokumen RM
   */
  public function actionStatusDokumenKirim($pengirimanrm_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $status = false;
    if (!empty($pengirimanrm_id)) {
      $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
    } else {
      $modPengirimanRm = new PengirimanrmT();
    }

    $modUbahStatus = new PengirimanrmT;

    if (isset($_POST['PengirimanrmT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modUbahStatus->attributes = $_POST['PengirimanrmT'];
        $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
        $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
        $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
        $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
        $modUbahStatus->kelengkapandokumen = TRUE;
        $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
        $modUbahStatus->create_time = date('Y-m-d H:i:s');
        $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
        //				$modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->create_ruangan = $this->getRuanganId($modPendaftaran->pasienadmisi_id);
        //				$modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpengirim_id = $this->getRuanganId($modPendaftaran->pasienadmisi_id);

        if ($modUbahStatus->save()) {
          $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
          $modPendaftaran->save();

          $transaction->commit();
          $status = true;
          Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
        } else {
          $status = false;
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $status = false;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render('_formStatusDokumen', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPengirimanRm' => $modPengirimanRm,
      'modUbahStatus' => $modUbahStatus,
      'status' => $status
    ));
  }

  /**
   * penghapusan dokumen RM
   */

  /**
   * ubah status dokumen
   */
  public function actionHapusDokumenPengiriman()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];
      $statusdok = $_POST['status'];
      $delete = false;
      $status = '';
      $div = '';
      $model = PendaftaranT::model()->findByPk($pendaftaran_id);
      if (!empty($pengirimanrm_id)) {
        $model->pengirimanrm_id = null;
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        if ($model->save()) {
          $modPenerimaanRm->delete();
          $delete = true;
        } else {
          $delete = false;
        }
      }

      if ($delete == true) {
        $status = 'proses_form';
        $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil dihapus </div>";
      } else {
        $status = 'proses_form';
        $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal dihapus </div>";
      }

      echo CJSON::encode(array(
        'status' => $status,
        'div' => $div,
      ));
      exit;
    }
  }

  /**
   * ambil status penerimaan dokumen
   */
  public function actionGetStatusPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];
      $ruanganpenerimaan_id = $_POST['ruanganpenerimaan_id'];
      $statusdok = $_POST['status'];
      $penerimaan = false;
      $div = '';
      $ruangan = '';
      $model = PendaftaranT::model()->findByPk($pendaftaran_id);
      if (!empty($pengirimanrm_id)) {
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        if ($modPenerimaanRm->ruanganpenerimaan_id == $ruanganpenerimaan_id) {
          $penerimaan = true;
        }
      }

      if ($penerimaan == true) {
        $div = "<div class='flash-success'>Dokumen Sudah Diterima Oleh Ruangan  <b>" . $ruangan . "</b></div>";
      } else {
        $div = "<div class='flash-error'>Dokumen Belum Diterima Oleh Ruangan  <b>" . $ruangan . "</b></div>";
      }

      echo CJSON::encode(array(
        'div' => $div,
      ));
      exit;
    }
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if (isset($_POST[$model_nama]['pasienadmisi_id'])) {
        $admisi = PasienadmisiT::model()->findByPk($_POST[$model_nama]['pasienadmisi_id']);
        
        
        $res_model = array();
        foreach ($models as $id => $nama) {
          if (!empty($admisi) && $id != $admisi->ruangan_id) {
            $res_model[$id] = $nama;
          }
        }
        
        $models = $res_model;
      }

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionBatalRencanaPulang()
  {

    $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
    $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;

    $pesan = '';
    $status = false;

    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $criteria = new CDbCriteria();
        $criteria->compare('pasienadmisi_id', $pasienadmisi_id);
        $criteria->compare('pendaftaran_id', $pendaftaran_id);

        $modPasienAdmisi = PasienadmisiT::model()->find($criteria);

        if (!empty($modPasienAdmisi)) {
          $modPasienAdmisi->rencanapulang = null;
          if ($modPasienAdmisi->save()) {
            $status = true;
          }
          $criteria = new CDbCriteria();
          $criteria->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
          $modMasukKamar = MasukkamarT::model()->find($criteria);
          $kamarruangan_status = false;
          $keterangan_kamar = Params::KETERANGANKAMAR_DIGUNAKAN;
          $updateKamar = KamarruanganM::model()->updateByPk($modMasukKamar->kamarruangan_id, array('kamarruangan_status' => $kamarruangan_status, 'keterangan_kamar' => $keterangan_kamar));

          if ($updateKamar) {
            $status = true;
          }
        } else {
          $status = false;
          $pesan = "Rencana Pulang tidak bisa dibatalkan karena pasien sudah dipulangkan!";
        }
        // kondisi status variabel/function proses
        if ($status == true) {
          $transaction->commit();
          $pesan = 'Rencana Pulang Pasien berhasil dibatalkan';
        } else {
          $status = false;
          if (!isset($pesan)) {
            $pesan = 'Rencana Pulang Pasien gagal dibatalkan';
          }
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $status = false;
        $pesan = "exist" . $ex;
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }


  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_rekam_medik
   */
  public function actionAutocompletePasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->limit = 5;

      $models = PIInfopasienmasukkamarV::model()->findAll($criteria); //default
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function getRuanganId($pasienadmisi_id = null)
  {
    $ruangan_id = null;
    if (!empty($pasienadmisi_id)) {
      $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
      $ruangan_id = $modAdmisi->ruangan_id;
    } else {
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
    }
    return $ruangan_id;
  }

  public function actionHitungHariRawatPulang()
  { //RSSP-934
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $tgl_pulang = isset($_POST['tgl_pulang']) ? $_POST['tgl_pulang'] :  date('Y-m-d H:i:s');
      $tgladmisi = $_POST['tgladmisi'];
      $tgl_pulang = $format->formatDateTimeForDb($tgl_pulang);

      //Hitung lama rawat                
      $tgladmisi = $format->formatDateTimeForDb($tgladmisi);
      $selisihHari = CustomFunction::hitungHari($tgladmisi, $tgl_pulang);

      //Hitung hari rawat
      $selisihHariRawat = CustomFunction::hitungHariRawat($tgladmisi, $tgl_pulang);

      $returnVal['lamadirawat_kamar'] = $selisihHari + 1;
      $returnVal['hariperawatan'] = $selisihHariRawat;

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionSetDropdownRuanganNurse()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {

      $nursestation_id = (isset($_POST['nursestation_id']) ? $_POST['nursestation_id'] : null);

      $ruangan = "";
      $ruangNurse = array();
      $ruangan .= '<option value="">-- Pilih --</option>';
      if (!empty($nursestation_id)) {
        $nurseRuangan = NursestationruanganM::model()->findAll('nursestation_id = ' . $nursestation_id);
        foreach ($nurseRuangan as $value) {
          $ruangNurse[] = $value->ruangan_id;
        }

        $criteria = new CDbCriteria;
        $criteria->addInCondition('ruangan_id', $ruangNurse);
        $ruanganByNurse = RuanganM::model()->findAll($criteria);
        foreach ($ruanganByNurse as $value) {
          $ruangan .= '<option value="' . $value->ruangan_id . '">' . $value->ruangan_nama . '</option>';
        }
      } else {
        $ruanganByNurse = RuanganM::model()->findAll('ruangan_aktif IS TRUE AND instalasi_id=4 ORDER BY ruangan_nama ASC');
        foreach ($ruanganByNurse as $value) {
          $ruangan .= '<option value="' . $value->ruangan_id . '">' . $value->ruangan_nama . '</option>';
        }
      }

      $data['ruangan'] = $ruangan;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionRincianTagihanPasien($pendaftaran_id, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    // untuk load data pasien
    $criteria = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
    }
    $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI));
    $modInfo = InfopasienpengunjungV::model()->find($criteria);
    if (!empty($modInfo->pasienadmisi_id)) { //replace dgn admisi
      $modInfo->instalasi_id = $modInfo->instalasiadmisi_id;
      $modInfo->ruangan_id = $modInfo->ruanganadmisi_id;
      $modInfo->kelaspelayanan_id = $modInfo->kelaspelayananadmisi_id;
      $modInfo->carabayar_id = $modInfo->carabayaradmisi_id;
      $modInfo->penjamin_id = $modInfo->penjaminadmisi_id;
      $modInfo->ruangan_nama = $modInfo->ruanganadmisi_nama;
      $modInfo->kelaspelayanan_nama = $modInfo->kelaspelayananadmisi_nama;
      $modInfo->carabayar_nama = $modInfo->carabayaradmisi_nama;
      $modInfo->penjamin_nama = $modInfo->penjaminadmisi_nama;
    }

    // untuk load data tindakan
    $criteriaTindakan = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    /* komen RSSP-726
		if(!empty($pasienadmisi_id)){
			$criteriaTindakan->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
		}*/
    $criteriaTindakan->group = 'pendaftaran_id, pasien_id, instalasi_id, ruangan_id, kelaspelayanan_id, tgl_tindakan, instalasi_nama, ruangan_nama, kelaspelayanan_nama';
    $criteriaTindakan->select = $criteriaTindakan->group . ', sum(tarif_tindakan) as tarif_tindakan, sum(tarif_medis) as tarif_medis, sum(tarif_bhp) as tarif_bhp, sum(tarif_paramedis) as tarif_paramedis, sum(tarifcyto_tindakan) as tarifcyto_tindakan';
    $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincianTindakan = RinciantagihantindakanV::model()->findAll($criteriaTindakan);

    // untuk load data obat
    $criteriaObatAlkes = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaObatAlkes->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    /* komen RSSP-726
		if(!empty($pasienadmisi_id)){
			$criteriaObatAlkes->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
		}*/
    $criteriaObatAlkes->group = 'pendaftaran_id, ruangan_id, kelaspelayanan_id, penjualanresep_id, instalasi_nama, ruangan_nama, kelaspelayanan_nama, noresep, tglpelayanan, qty_oa';
    $criteriaObatAlkes->select = $criteriaObatAlkes->group . ', sum(hargajual_oa) as hargajual_oa, sum(harganetto_oa) as harganetto_oa, sum(hargasatuan_oa) as hargasatuan_oa';
    $criteriaObatAlkes->order  = 'ruangan_id, penjualanresep_id, tglpelayanan';
    $modRincianObatAlkes = RinciantagihanobatalkesV::model()->findAll($criteriaObatAlkes);

    $this->render('billingKasir.views.pembayaranTagihanPasien.printRincianTagihanPasien', array(
      'format' => $format,
      'modInfo' => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
      'modRincianObatAlkes' => $modRincianObatAlkes
    ));
  }

  public function actionRincianTagihanPasienDetail($pendaftaran_id, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }

    // untuk load data pasien
    $criteria = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
    }
    $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI));
    $modInfo = InfopasienpengunjungV::model()->find($criteria);
    if (!empty($modInfo->pasienadmisi_id)) { //replace dgn admisi
      $modInfo->instalasi_id = $modInfo->instalasiadmisi_id;
      $modInfo->ruangan_id = $modInfo->ruanganadmisi_id;
      $modInfo->kelaspelayanan_id = $modInfo->kelaspelayananadmisi_id;
      $modInfo->carabayar_id = $modInfo->carabayaradmisi_id;
      $modInfo->penjamin_id = $modInfo->penjaminadmisi_id;
      $modInfo->ruangan_nama = $modInfo->ruanganadmisi_nama;
      $modInfo->kelaspelayanan_nama = $modInfo->kelaspelayananadmisi_nama;
      $modInfo->carabayar_nama = $modInfo->carabayaradmisi_nama;
      $modInfo->penjamin_nama = $modInfo->penjaminadmisi_nama;
    }

    // untuk load data tindakan
    $criteriaTindakan = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteriaTindakan->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
    }
    //		$criteriaTindakan->order = 'instalasi_id, ruangan_id, komponenunit_id, tgl_tindakan';
    $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincianTindakan = RinciantagihantindakanV::model()->findAll($criteriaTindakan);

    // untuk load data obat
    $criteriaObatAlkes = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaObatAlkes->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteriaObatAlkes->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
    }
    $criteriaObatAlkes->order = 'ruangan_id, penjualanresep_id, tglpelayanan';
    $modRincianObatAlkes = RinciantagihanobatalkesV::model()->findAll($criteriaObatAlkes);

    $this->render('billingKasir.views.pembayaranTagihanPasien.printRincianTagihanPasienDetail', array(
      'format' => $format,
      'modInfo' => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
      'modRincianObatAlkes' => $modRincianObatAlkes,
      'is_total_instalasi' => TRUE,
    ));
  }

  public function actionRincianPembayaranPasien($pendaftaran_id, $pembayaranpelayanan_id = null)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }

    // untuk load data pasien
    $criteria = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    //		$criteria->addInCondition('instalasi_id',array(Params::INSTALASI_ID_RJ,Params::INSTALASI_ID_RD,Params::INSTALASI_ID_RI));
    $modInfo = InfopasienpengunjungV::model()->find($criteria);
    if (!empty($modInfo->pasienadmisi_id)) { //replace dgn admisi
      $modInfo->instalasi_id = $modInfo->instalasiadmisi_id;
      $modInfo->ruangan_id = $modInfo->ruanganadmisi_id;
      $modInfo->kelaspelayanan_id = $modInfo->kelaspelayananadmisi_id;
      $modInfo->carabayar_id = $modInfo->carabayaradmisi_id;
      $modInfo->penjamin_id = $modInfo->penjaminadmisi_id;
      $modInfo->ruangan_nama = $modInfo->ruanganadmisi_nama;
      $modInfo->kelaspelayanan_nama = $modInfo->kelaspelayananadmisi_nama;
      $modInfo->carabayar_nama = $modInfo->carabayaradmisi_nama;
      $modInfo->penjamin_nama = $modInfo->penjaminadmisi_nama;
    }

    // untuk load data tindakan
    $criteriaTindakan = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    if (!empty($pembayaranpelayanan_id)) {
      //			$criteriaTindakan->addCondition('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
    }
    $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');
    $criteriaTindakan->group = 'pendaftaran_id, pasien_id, instalasi_id, ruangan_id, kelaspelayanan_id, tgl_tindakan, instalasi_nama, ruangan_nama, kelaspelayanan_nama';
    //		$criteriaTindakan->select = $criteriaTindakan->group.', sum(tarif_satuan) as tarif_tindakan, sum(tarif_medis) as tarif_medis, sum(tarif_bhp) as tarif_bhp, sum(tarif_paramedis) as tarif_paramedis, sum(tarifcyto_tindakan) as tarifcyto_tindakan';
    $criteriaTindakan->select = $criteriaTindakan->group . ', sum(tarif_satuan*qty_tindakan) as tarif_tindakan, sum(tarif_medis) as tarif_medis, sum(tarif_bhp) as tarif_bhp, sum(tarif_paramedis) as tarif_paramedis, sum(tarifcyto_tindakan) as tarifcyto_tindakan'; //RSSP-765
    $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincianTindakan = RincianbayartindakanV::model()->findAll($criteriaTindakan);

    // untuk load data obat
    $criteriaObatAlkes = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaObatAlkes->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    if (!empty($pembayaranpelayanan_id)) {
      $criteriaObatAlkes->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
    }
    $criteriaObatAlkes->addCondition('oasudahbayar_id is not null');
    $criteriaObatAlkes->group = 'pendaftaran_id, ruangan_id, kelaspelayanan_id, penjualanresep_id, instalasi_nama, ruangan_nama, kelaspelayanan_nama, noresep, tglpelayanan, qty_oa';
    $criteriaObatAlkes->select = $criteriaObatAlkes->group . ', sum(hargajual_oa) as hargajual_oa, sum(harganetto_oa) as harganetto_oa, sum(hargasatuan_oa) as hargasatuan_oa';
    $criteriaObatAlkes->order  = 'ruangan_id, penjualanresep_id, tglpelayanan';
    $modRincianObatAlkes = RincianbayarobatalkesV::model()->findAll($criteriaObatAlkes);

    if (empty($pembayaranpelayanan_id)) {
      $modPembayaranPelayanan = new PembayaranpelayananT();
      $modPemakaianUangMuka = new PemakaianuangmukaT();
      $modTandaBuktiBayar = new TandabuktibayarT();
    } else {
      // untuk load pembayaran pelayanan
      $modPembayaranPelayanan = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
      // untuk load pemakaian uang muka
      $modPemakaianUangMuka = PemakaianuangmukaT::model()->findByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
      // untuk load tanda bukti bayar
      $modTandaBuktiBayar = TandabuktibayarT::model()->findByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
    }


    $this->render('billingKasir.views.pembayaranTagihanPasien.printRincianPembayaranPasien', array(
      'format' => $format,
      'modInfo' => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
      'modRincianObatAlkes' => $modRincianObatAlkes,
      'modPembayaranPelayanan' => $modPembayaranPelayanan,
      'modPemakaianUangMuka' => $modPemakaianUangMuka,
      'modTandaBuktiBayar' => $modTandaBuktiBayar
    ));
  }


  /**
   * actionPrintRincianBelumBayar 
   * @params $instalasi_id = RJ / RD / RI
   * @params $pendaftaran_id
   * @params $pasienadmisi_id (RI saja)
   */
  //fungsi ini diambil dari bilingkasir/controller/PembayaranTagihanPasienController
  //RSPMC-1171
  public function actionPrintRincianBelumBayar($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';

    $modRincians = RinciantagihanpasienV::model()->findAll($criteria);
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    /*
        if($instalasi_id == Params::INSTALASI_ID_RJ){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'unitlayanan_nama, tgl_tindakan';
            $modRincians = BKRincianbelumbayarrjV::model()->findAll($criteria);
			$modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RD){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->order = 'ruangantindakan_id';
            $modRincians = BKRincianbelumbayarrdV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }else if($instalasi_id == Params::INSTALASI_ID_RI || $instalasi_id == Params::INSTALASI_ID_ICU){
            $criteria = new CDbCriteria();
            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
            $criteria->order = 'ruangantindakan_id';
            $criteria->order = 'tgl_tindakan';
            $modRincians = BKRincianbelumbayarrawatinapV::model()->findAll($criteria);
            $modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
        }
         * 
         */

    $modInstalasi = InstalasiM::model()->findByPk($instalasi_id);
    $this->render('billingKasir.views.pembayaranTagihanPasien.printRincianBelumBayar', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran, 'modInstalasi' => $modInstalasi));
  }

  public function simpanUbahDokters($modUbahDokter, $admisi, $param, $item)
  {
    $ok = true;

    $dpjp = array(
      'pegawai_id' => 1,
      'dpjp2_id' => 2,
      'dpjp3_id' => 3,
    );

    $model = new UbahdokterR();
    $model->attributes = $modUbahDokter->attributes;
    $model->dokterlama_id = $admisi[$param];
    $model->dokterbaru_id = $item;
    $model->dpjp = $dpjp[$param];

    if ($model->dokterlama_id == $model->dokterbaru_id) return true;

    if ($model->validate()) {
      $ok = $ok && $model->save();
    } else $ok = false;


    if ($param == 'pegawai_id') {
      $masukkamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id' => $admisi->pasienadmisi_id));
      if (!empty($masukkamar)) {
        MasukkamarT::model()->updateByPk($masukkamar->masukkamar_id, array('pegawai_id' => $item));
      }
    }

    PasienadmisiT::model()->updateByPk($admisi->pasienadmisi_id, array($param => $item));

    return true;
  }
  
  public function actionRiwayatDokfilerm($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $crit = new CDbCriteria();
    $crit->addCondition('pasien_id ='. $modPasien->pasien_id);
    $modDokfilerm = DokfilermR::model()->findAll($crit);
    $modDokfilerms =[];
    foreach ($modDokfilerm as $dok) {
        if (in_array( Yii::app()->user->getState('instalasi_id'), (array)$dok->instalasi_ids)) {
            $modDokfilerms[]=$dok; 
        }
    }
    $this->render('_listDokfilerm', array('modDokfilerm' => $modDokfilerms));
  }
}

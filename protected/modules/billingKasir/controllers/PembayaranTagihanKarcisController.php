<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of PembayaranTagihanKarcisController
 *
 * @author programmer
 */
class PembayaranTagihanKarcisController extends PembayaranTagihanPasienController {
    
    /**
   * Membuat dan menyimpan data baru.
   * jika dari informasi menggunakan
   * @params type $id
   * - $_GET['instalasi_id']
   * - $_GET['pendaftaran_id']
   * - $_GET['pasienadmisi_id'] (untuk RI saja)
   * layout frame=1 -> frameDialog
   */
  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Tagihan Pasien";
    $format = new MyFormatter();
    $modKunjungan = new BKInformasikasirinappulangV;
    $modKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;
    $model = new BKPembayaranpelayananT;
    $modTandabukti = new BKTandabuktibayarT;
    $modTandabukti->is_menggunakankartu = 0;
    $modTindakansudahbayar = new BKTindakansudahbayarT;
    $modOasudahbayar = new BKOasudahbayarT;
    $modBayaruangmuka = new BKBayaruangmukaT;
    $modPemakaianuangmuka = new BKPemakaianuangmukaT;
    $modBayarangsuran = new BKBayarangsuranpelayananT;
    $modAntrian = new BKAntrianT;
    $dataTindakans = array();
    $dataOas = array();
    $modPiutangAsuransi = new BKPiutangasuransiT();
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

    // Uncomment the following line if AJAX validation is needed

    if (isset($_GET['instalasi_id'])) {
      if ($_GET['instalasi_id'] == Params::INSTALASI_ID_RJ) {
        $loadKunjungan = BKInformasikasirrawatjalanV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
      } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_RD) {
        $loadKunjungan = BKInformasikasirrdpulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));;
      } else if (in_array($_GET['instalasi_id'], array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_ICU))) {
        $pulang = PasienpulangT::model()->findByAttributes(array(
          'pasienadmisi_id' => isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : $model->pasienadmisi_id,
        ));

        if (!empty($pulang) && $pulang->carakeluar_id == Params::CARAKELUAR_ID_MELARIKANDIRI) {
          $loadKunjungan = BKInfokunjunganRIV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
        } else {
          $loadKunjungan = BKInformasikasirinappulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id'], 'pasienadmisi_id' => isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : $model->pasienadmisi_id));
        }
      } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_MCU) {
        $loadKunjungan = BKInformasikasirmcuV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));;
      } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_HD) {
        $loadKunjungan = BKInformasikasirhdpulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));;
      } else if ($_GET['instalasi_id'] == Params::INSTALASI_ID_PERSALINAN) {
        $loadKunjungan = BKInformasikasirrdpulangV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));;
      }
      if (isset($loadKunjungan)) {
        $modKunjungan = $loadKunjungan;
      }
    }

    if (isset($_GET['frame'])) {
      $this->layout = "//layouts/iframe";
    }

    if (isset($_POST['pendaftaran_id']) && isset($_POST['BKPembayaranpelayananT']) && (isset($_POST['BKTindakanPelayananT']) || isset($_POST['BKObatalkesPasienT']))) {
      // var_dump($_POST); die;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modKunjungan->attributes = $_POST;
        $modBayaruangmuka = BKBayaruangmukaT::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id'])); //RSN-1195
        $model = $this->simpanPembayaranPelayanan($model, $_POST['BKPembayaranpelayananT']);

        if (isset($_POST['BKPembayaranpelayananT']['total_inacbg_2'])) {
          $this->simpanAsuransiKelas($model, $_POST['BKPembayaranpelayananT']['total_inacbg_2']);
        }

        /*
                if (isset($_POST['subsidiasuransi'])) {
                    $this->simpanAsuransiKelas($model, $_POST['subsidiasuransi']);
                }
                 *
                 */

        // $this->simpanAsuransiKelas($model, $_POST[''])

        $modTandabukti = $this->simpanTandaBuktiBayar($model, $modTandabukti, $_POST['BKTandabuktibayarT']);
        if ($_POST['BKPemakaianuangmukaT']['pemakaianuangmuka'] > 0) { //jika ada pemakaian uang muka
          $modPemakaianuangmuka = $this->simpanPemakaianUangMuka($model, $modPemakaianuangmuka, $_POST['BKPemakaianuangmukaT'], $modBayaruangmuka);
          TandabuktibayarT::model()->updateByPk($modTandabukti->tandabuktibayar_id, array(
            'bayaruangmuka_id' => $modPemakaianuangmuka->bayaruangmuka_id,
          ));
        } else {
          $this->pemakaianuangmuka_tersimpan = true; //bypass uang muka
        }

        if (isset($_POST['BKPembayaranpelayananT']['totalsisatagihan'])) {
          if ($_POST['BKPembayaranpelayananT']['totalsisatagihan'] > 0) {
            $modBayarangsuran = $this->simpanBayarAngsuran($model, $modTandabukti, $modBayarangsuran);
          } else {
            $this->bayarangsuran_tersimpan = true; //bypass bayar angsuran = LUNAS / PIUTANG
          }
        } else {
          $this->bayarangsuran_tersimpan = true; //bypass bayar angsuran = LUNAS / PIUTANG
        }

        if (isset($_POST['BKTindakanPelayananT'])) {
          $dataTindakans = $this->simpanBayarTindakans($model, $modTindakansudahbayar, $_POST['BKTindakanPelayananT']);
        } else {
          $this->tindakansudahbayar_tersimpan = true; //bypass tindakan jika tidak ada
          $this->bayarsemuatindakanoa = true;
        }
        if (isset($_POST['BKObatalkesPasienT'])) {
          $dataOas = $this->simpanBayarOas($model, $modOasudahbayar, $_POST['BKObatalkesPasienT']);
        } else {
          $this->oasudahbayar_tersimpan = true; //bypass oa jika tidak ada
        }
        

        $td = TindakanpelayananT::model()->findByAttributes(array(
          'pendaftaran_id' => $model->pendaftaran_id
        ), array(
          'condition' => 'tindakansudahbayar_id is null and qty_tindakan <> 0'
        ));

        $oa = ObatalkespasienT::model()->findByAttributes(array(
          'pendaftaran_id' => $model->pendaftaran_id
        ), array(
          'condition' => 'oasudahbayar_id is null and qty_oa <> 0'
        ));

        $this->bayarsemuatindakanoa = empty($td) && empty($oa);

        /**
         * Jika pasien adalah rawat jalan dan belum dirujuk ke rawat inap,
         * status akan berubah menjadi SUDAH PULANG.
         */
        $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
        $ok = true;
//        if (empty($pendaftaran->pasienadmisi_id) && $pendaftaran->alihstatus != true && !in_array($pendaftaran->instalasi_id, array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_ICU))) {
//          PendaftaranT::model()->updateByPk($pendaftaran->pendaftaran_id, array(
//            'statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG,
//          ));
//          // echo "test";
//          $ok = $ok && $this->broadcastNotifBayarTagihanRJ($modKunjungan, $pendaftaran, $model);
//        } else {
//          $ok = $ok && $this->broadcastNotifBayarTagihanRDRI($modKunjungan, $pendaftaran, $model);
//        }

        // die;

//        if ($this->bayarsemuatindakanoa) { //jika semua terbayar
//          //                    BELUM JELAS AKHIR DARI PEMBAYARAN KARENA PEMBAYARAN BISA LEBIH DARI 1 KALI
//          // LNG-2450
//          if ($_POST['instalasi_id'] == Params::INSTALASI_ID_RI) {
//            $modUpdateAdmisi = PasienadmisiT::model()->updateByPk($model->pasienadmisi_id, array('pembayaranpelayanan_id' => $model->pembayaranpelayanan_id));
//          } else {
//            $modUpdatePendaftaran = PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('pembayaranpelayanan_id' => $model->pembayaranpelayanan_id));
//          }
//
//          $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
//          $pp = PasienpulangT::model()->findByAttributes(array(
//            'pendaftaran_id' => $pendaftaran->pendaftaran_id,
//          ));
//          /*
//                    if (Params::INSTALASI_ID_RD) {
//                        $p = PendaftaranT::model()->findByPk($model->pendaftaran_id);
//                        $modUpdatePendaftaran = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);
//                        $modUpdatePendaftaran = PendaftaranT::model()->updateByPk($model->pendaftaran_id,array('pembayaranpelayanan_id'=>$model->pembayaranpelayanan_id));
//                    } */
//        }

//        $pasienMskPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id, 'ruangan_id' => 90));

//        if (isset($pasienMskPenunjang)) {
//          PasienmasukpenunjangT::model()->updateByPk($pasienMskPenunjang->pasienmasukpenunjang_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG));
//        }

        // $this->broadcastNotifBayarKarcisUmum($modKunjungan, $model);
        // if (!$this->isbayarkarcis)
        // $this->broadcastNotifBayarTagihanPasien($modKunjungan, $model);
        // var_dump($ok); die;
        // die;

        // var_dump($this->pembayaranpelayanan_tersimpan, $this->tandabuktibayar_tersimpan, $this->tindakansudahbayar_tersimpan, $this->oasudahbayar_tersimpan && $this->pemakaianuangmuka_tersimpan && $this->bayarangsuran_tersimpan);
        // die;

        if (!empty($model->pembayaranpelayanan_id)) {
          $res = Yii::app()->db
            ->createCommand("select setpembayaran_fix_bkm3(" . $model->pembayaranpelayanan_id . ") as simpan")
            ->queryRow();

          if (!empty($res)) {
            $this->pembayaranpelayanan_tersimpan = $this->pembayaranpelayanan_tersimpan && $res['simpan'];
          }

          // var_dump($res);
        }

        if (isset($_POST['BKPembayaranpelayananT']['antrian_id'])) {
          BKAntrianT::model()->updateByPk($_POST['BKPembayaranpelayananT']['antrian_id'], array(
            'pendaftaran_id' => $model->pendaftaran_id
          ));
        }
       
        /*
                var_dump(
                        $this->pembayaranpelayanan_tersimpan,
                        $this->tandabuktibayar_tersimpan,
                        $this->tindakansudahbayar_tersimpan,
                        $this->oasudahbayar_tersimpan,
                        $this->pemakaianuangmuka_tersimpan,
                        $this->bayarangsuran_tersimpan
                ); die;
                // *
                // */
        
        if ($this->pembayaranpelayanan_tersimpan && $this->tandabuktibayar_tersimpan && $this->tindakansudahbayar_tersimpan && $this->oasudahbayar_tersimpan && $this->pemakaianuangmuka_tersimpan && $this->bayarangsuran_tersimpan) {
          //Di set di form >> Yii::app()->user->setFlash('success', 'Data pembayaran berhasil disimpan !');
          // echo "Kick"; die;
          // SMS GATEWAY
          $modPasien = $model->pasien;
          $sms = new Sms();
          $smspasien = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modTandabukti->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $model->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }

              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modTandabukti->tglbuktibayar), $isiPesan);

              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
          }
          // END SMS GATEWAY
          Yii::app()->user->setFlash('success', 'Data Pembayaran Pasien ' . $pendaftaran->pasien->nama_pasien . ' berhasil disimpan !');
          $transaction->commit();
          if (isset($_GET['frame'])) {
            $this->redirect(array('index', 'id' => $model->pembayaranpelayanan_id, 'pendaftaran_id' => $model->pendaftaran_id, 'instalasi_id' => $modKunjungan->instalasi_id, 'sukses' => 1, 'frame' => 1, 'smspasien' => $smspasien));
          } else {
            $this->redirect(array('index', 'id' => $model->pembayaranpelayanan_id, 'pendaftaran_id' => $model->pendaftaran_id, 'instalasi_id' => $modKunjungan->instalasi_id, 'sukses' => 1, 'smspasien' => $smspasien));
          }
        } else {

          // var_dump();

          Yii::app()->user->setFlash('error', 'Data pembayaran gagal disimpan !');
          $model->isNewRecord = true;
          $model->pembayaranpelayanan_id = null;
          $transaction->rollback();
          //                    echo "1.". $this->pembayaranpelayanan_tersimpan."<br>";
          //                    echo "2.". $this->tandabuktibayar_tersimpan."<br>";
          //                    echo "3.". $this->tindakansudahbayar_tersimpan."<br>";
          //                    echo "4.". $this->oasudahbayar_tersimpan."<br>";
          //                    echo "5.". $this->pemakaianuangmuka_tersimpan."<br>";
          //                    echo "6.". $this->bayarangsuran_tersimpan."<br>";
          //                    exit;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        echo $exc->getMessage() . "<br/><br/>" . $exc->getTraceAsString();
        die;

        Yii::app()->user->setFlash('error', "Data pembayaran gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id, 'instalasi_id' => $modKunjungan->instalasi_id));
      }
    }

    if (!empty($id)) {
      $model = BKPembayaranpelayananT::model()->findByPk($id);
      $modTandabukti = BKTandabuktibayarT::model()->findByPk($model->tandabuktibayar_id);
      $modTandabukti->is_menggunakankartu = 0;
      $modPemakaianuangmuka = BKPemakaianuangmukaT::model()->findByPk($model->pembayaranpelayanan_id);
      if (!isset($modPemakaianuangmuka)) {
        $modPemakaianuangmuka = new BKPemakaianuangmukaT;
      }
      $modBayarangsuran = new BKBayarangsuranpelayananT;
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);
    
    $this->render($this->path_view.'index', array(
      'model' => $model,
      'modTandabukti' => $modTandabukti,
      'modKunjungan' => $modKunjungan,
      'dataTindakans' => $dataTindakans,
      'dataOas' => $dataOas,
      'modPemakaianuangmuka' => $modPemakaianuangmuka,
      'modAntrian' => $modAntrian,
      'modPiutangAsuransi'=>$modPiutangAsuransi
    ));
  }
  
  /**
   * Mengurai data kunjungan berdasarkan:
   * - instalasi_id
   * - pendaftaran_id
   * - pasienadmisi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $notif = array('ok' => 1, 'msg' => '');
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      if (!empty($pasienadmisi_id)) {
        $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
      }
      if (!empty($instalasi_id)) {
        $criteria->addCondition("instalasi_id = " . $instalasi_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));


      $returnVal['dpjp1'] = "";
      $returnVal['dpjp2'] = "";
      $returnVal['dpjp3'] = "";
      $returnVal['dokterpenerima'] = "";
      $returnVal['persen_diskon'] = '0,00';
      $returnVal['persen_admin'] = '0,00';
      $returnVal['nilai_admin'] = '0';

      $reseptur = ResepturT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
      ), array(
        'condition' => 'penjualanresep_id is null',
      ));

      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $model = BKInformasikasirrawatjalanV::model()->find($criteria);

        $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

        $no_rm = $model->no_rekam_medik;
        $nama = $model->namadepan . $model->nama_pasien;
        $status = $model->statusperiksa;
        $ruangan = $model->ruangan_nama;

        // $returnVal['persen_diskon'] = number_format($penjamin->diskon_rj, 2, ",", "");
        // $returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");

        /*
				if ($model->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
                    if ($model->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        $notif['ok'] = 9;
                        $notif['msg'] = "Pasien ${nama} (${no_rm}) ${status}. Apakah Anda akan menyelesaikan sisa tagihan pasien ?";
                    } else {
                        $notif['ok'] = 0;
                        $notif['msg'] = "Pasien ${nama} (${no_rm}) masih dalam status ${status}"
                        . " di ${ruangan}";
                    }
				} else if (count((array)$reseptur) > 0) {
                    $notif['ok'] = 0;
                    $notif['msg'] = "Resep untuk Pasien ${nama} belum dilakukan verifikasi oleh Farmasi.";

                    $this->breadcastNotifResepturPasien($model, $reseptur);
                } else if ($this->cekVerifikasiLab($model)) {
                    $notif['ok'] = 0;
                    $notif['msg'] = "Pemeriksaan Lab untuk Pasien ${nama} belum diverifikasi.";
                } else if ($this->cekVerifikasiRad($model)) {
                    $notif['ok'] = 0;
                    $notif['msg'] = "Pemeriksaan Radiologi untuk Pasien ${nama} belum diverifikasi.";
                }
                // */
      } else if ($instalasi_id == Params::INSTALASI_ID_MCU) {
        $model = BKInformasikasirmcuV::model()->find($criteria);

        $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

        $no_rm = $model->no_rekam_medik;
        $nama = $model->namadepan . $model->nama_pasien;
        $status = $model->statusperiksa;
        $ruangan = $model->ruangan_nama;

        // $returnVal['persen_diskon'] = number_format($penjamin->diskon_rj, 2, ",", "");
        // $returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");


      } else if ($instalasi_id == Params::INSTALASI_ID_HD) {
        $model = BKInformasikasirhdpulangV::model()->find($criteria);

        $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

        $no_rm = $model->no_rekam_medik;
        $nama = $model->namadepan . $model->nama_pasien;
        $status = $model->statusperiksa;
        $ruangan = $model->ruangan_nama;

        // $returnVal['persen_diskon'] = number_format($penjamin->diskon_rj, 2, ",", "");
        // $returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");

        // */

      } else if ($instalasi_id == Params::INSTALASI_ID_RD || $instalasi_id == Params::INSTALASI_ID_PERSALINAN) {
        $model = BKInformasikasirrdpulangV::model()->find($criteria);

        $penjamin = PenjaminpasienM::model()->findByPk($model->penjamin_id);

        $no_rm = $model->no_rekam_medik;
        $nama = $model->namadepan . $model->nama_pasien;
        $status = $model->statusperiksa;
        $ruangan = $model->ruangan_nama;

        // $returnVal['persen_diskon'] = number_format($penjamin->diskon_rd, 2, ",", "");
        //$returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");
        // /*
        if ($model->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
          if ($model->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
            $notif['ok'] = 9;
            $notif['msg'] = "Pasien ${nama} (${no_rm}) ${status}. Apakah Anda akan menyelesaikan sisa tagihan pasien ?";
          }
        }
        // *
        // */
      } else if (in_array($instalasi_id, array(Params::INSTALASI_ID_RI, Params::INSTALASI_ID_ICU))) {

        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        $pulang = PasienpulangT::model()->findByAttributes(array(
          'pasienadmisi_id' => $pendaftaran->pasienadmisi_id,
        ));




        $admisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
        $nama = $model->namadepan . $model->nama_pasien;
        $ruangan = $model->ruangan_nama;


        $penjamin = PenjaminpasienM::model()->findByPk($admisi->penjamin_id);

        if (!empty($admisi->dokterpenerima_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
          $returnVal['dokterpenerima'] = $peg->namaLengkap;
        }

        if (!empty($admisi->pegawai_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
          $returnVal['dpjp1'] = $peg->namaLengkap;
        }

        if (!empty($admisi->dpjp2_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id);
          $returnVal['dpjp2'] = $peg->namaLengkap;
        }

        if (!empty($admisi->dpjp3_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id);
          $returnVal['dpjp3'] = $peg->namaLengkap;
        }

        $returnVal['persen_diskon'] = number_format($penjamin->diskon_ri, 2, ",", "");
        $returnVal['persen_admin'] = number_format($penjamin->biaya_administrasi, 2, ",", "");
        $returnVal['nilai_admin'] = 0;

        $verifikasi = VerifikasitagihanT::model()->findByAttributes(array(
          'pendaftaran_id' => $model->pendaftaran_id,
        ), array(
          'order' => 'verifikasitagihan_id desc',
        ));

        if (!empty($verifikasi) && $verifikasi->biaya_administrasi != 0) {
          $returnVal['persen_admin'] = "0,00";
          $returnVal['nilai_admin'] = MyFormatter::formatNumberForPrint($verifikasi->biaya_administrasi);
        }

        // /*
        
      }

      $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
      $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }


      $returnVal['kelastanggungan_id'] = null;
      $returnVal['kelastanggungan_nama'] = null;

      $returnVal['kelastanggungan_nilai'] = null;
      $returnVal['kelaspelayanan_nilai'] = Params::kelasPelayananNilai($model->kelaspelayanan_id);

      if (!empty($asuransi)) {
        $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
        $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id;
        $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama;
        $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id);
      }

      $carabayar = CarabayarM::model()->findByPk($model->carabayar_id);
      $returnVal["metode_pembayaran"] = strtoupper($carabayar->metode_pembayaran);


      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["notif"] = $notif;
      //load uang muka
      $crit_uangmuka = new CDbCriteria();
      if (!empty($model->pendaftaran_id)) {
        $crit_uangmuka->addCondition("pendaftaran_id = " . $model->pendaftaran_id);
      }
      if (!empty($model->pasienadmisi_id)) {
        $crit_uangmuka->addCondition("pasienadmisi_id = " . $model->pasienadmisi_id);
      }
      //perubahan pengambilan uang muka (RSN-1195)
      $modBayarUangMuka = BKBayaruangmukaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      if (!empty($modBayarUangMuka)) {
        $modPemakaianUangMuka = PemakaianuangmukaT::model()->findByAttributes(array('bayaruangmuka_id' => $modBayarUangMuka->bayaruangmuka_id), array('order' => 'pemakaianuangmuka_id DESC', 'limit' => 1));
        if (!empty($modPemakaianUangMuka)) {
          $returnVal["jumlahuangmuka"] = (isset($modPemakaianUangMuka->sisauangmuka) ? $modPemakaianUangMuka->sisauangmuka : 0);
        } else {
          $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
          $crit_uangmuka->addCondition("pembatalanuangmuka_id IS NULL");
          $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
          $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
          $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
        }
      }




      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  
  /**
   * menampilkan form rincian tagihan tindakan
   */
  public function actionSetRincianTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
      $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
      $modPendaftaran = new PendaftaranT;
      $modAsuransiPasien = new AsuransipasienM;
      $modTanggungan = new TanggunganpenjaminM;
      $form = '';
      if (!empty($pendaftaran_id)) {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        if ($modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) {
          $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'penjamin_id' => $penjamin_id));
        } else if (isset($modPendaftaran->asuransipasien_id)) {
          $modAsuransiPasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
          if (isset($modAsuransiPasien->kelastanggunganasuransi_id) && isset($penjamin_id)) {
            $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $modAsuransiPasien->kelastanggunganasuransi_id, 'penjamin_id' => $penjamin_id));
          }
        }
      }
      $dataTindakans = array();
      if (!empty($pendaftaran_id)) {
        $criteria = new CdbCriteria();
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        //                ADA BEBERAPA TINDAKAN YG TIDAK TERBAYAR >> RND-3592
        //                TINDAKAN SELAIN ADMISI JUGA BOLEH DI BAYARKAN DISINI
        //                if(!empty($pasienadmisi_id)){
        //                    $criteria->addCondition("pasienadmisi_id = ".$pasienadmisi_id);
        //                }else{
        //                    $criteria->addCondition("pasienadmisi_id IS NULL");
        //                }
        $criteria->addCondition("tindakansudahbayar_id IS NULL and karcis_id is not null");
        $criteria->order = "ruangan_id, tgl_tindakan";
        if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_LAB){
          // if (!empty($instalasi_id)) {
            // $criteria->addCondition("instalasi_id = " . Params::INSTALASI_ID_LAB);
          // }
          // if (!empty($ruangan_id)) {
            $criteria->addCondition("ruangan_id = " . Params::RUANGAN_ID_LAB_KLINIK);
          // }
        // $dataTindakans = LBTindakanPelayananT::model()->findByAttributes(array('ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK));
      }
      if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RAD){
        $criteria->addCondition("ruangan_id = " . Params::RUANGAN_ID_RAD);
      }
        $dataTindakans = BKTindakanPelayananT::model()->findAll($criteria);
      }
      $form = $this->renderPartial($this->path_view . '_formRincianTindakan', array('modPendaftaran' => $modPendaftaran, 'dataTindakans' => $dataTindakans, 'modTanggungan' => $modTanggungan, 'penjamin_id' => $penjamin_id), true);
      $data['form'] = $form;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  
  /**
   * menampilkan form rincian tagihan obat alkes
   */
  public function actionSetRincianObatalkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
      $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
      $form = '';
      $modPendaftaran = new PendaftaranT;
      $modTanggungan = null;
      if (!empty($pendaftaran_id)) {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        if ($modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) {
          $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $kelaspelayanan_id, 'penjamin_id' => $penjamin_id));
        } else if (isset($modPendaftaran->asuransipasien_id)) {
          $modAsuransiPasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
          if (isset($modAsuransiPasien->kelastanggunganasuransi_id) && isset($penjamin_id)) {
            $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $modAsuransiPasien->kelastanggunganasuransi_id, 'penjamin_id' => $penjamin_id));
          }
        }
      }
      $dataOas = array();
//      if (!empty($pendaftaran_id)) {
//        $criteria = new CdbCriteria();
//        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
//        $criteria->addCondition("oasudahbayar_id IS NULL");
//        $criteria->order = "tglpelayanan";
//        $dataOas = BKObatalkesPasienT::model()->findAll($criteria);
//      }
      $form = $this->renderPartial($this->path_view . '_formRincianObatalkes', array('modPendaftaran' => $modPendaftaran, 'modTanggungan' => $modTanggungan, 'dataOas' => $dataOas, 'penjamin_id' => $penjamin_id), true);
      $data['form'] = $form;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrintRincianSudahBayar2($pembayaranpelayanan_id){
    $this->layout='//layouts/printWindows';
    if (isset($_GET['frame'])){
        $this->layout='//layouts/iframe';
    }
    $modRincians = null;
    $modPembayaran = BKPembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = '.$modPembayaran->pendaftaran_id);
    $criteria->addCondition('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
    $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
    $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
    $modPendaftaran = PendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
    $modPenanggungjawab=PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);
    $namaperusahaan = '';
    $noasuransi = '';
    $penanggung = '';
    $subsidiasuransi_tindakan = '';
    $penjamin = PenjaminpasienM::model()->findByPk($modPembayaran->penjamin_id);
    // var_dump($penjamin);die;
    $carabayar = CarabayarM::model()->findAllByPk($modPembayaran->carabayar_id);
    // var_dump($carabayar);die;
    // var_dump($modRincians[0]->namaperusahaan);die;
    if (count((array)$modRincians)>0){
        foreach ($modRincians as $mod => $items){
            $nama_perusahaan = $items->namaperusahaan;
            $noasuransi = $items->no_asuransi;
            $penanggung= $items->namapemilik_asuransi;
            $subsidiasuransi_tindakan= $items->subsidiasuransi_tindakan;
            $penjamin_nama = $items->penjamin_nama;
        }
    }
    $modAsuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);

    $caraPrint = isset($_GET['caraPrint'])?$_GET['caraPrint']:'';
    if ($caraPrint == 'EXCEL'){
      $this->render($this->path_view.'printRincianSudahBayarExcel', array('modRincians'=>$modRincians,'modPendaftaran'=>$modPendaftaran, 'modPembayaran'=>$modPembayaran));
    }else{
      $this->render($this->path_view.'printRincianSudahBayarV2', array('modAsuransi'=>$modAsuransi,'penjamin'=>$penjamin,'penjamin_nama'=>$penjamin_nama,'modPenanggungjawab'=>$modPenanggungjawab,'subsidiasuransi_tindakan'=>$subsidiasuransi_tindakan,'nama_perusahaan'=>$nama_perusahaan,'noasuransi'=>$noasuransi,'penanggung'=>$penanggung,'modRincians'=>$modRincians,'modPendaftaran'=>$modPendaftaran, 'modPembayaran'=>$modPembayaran));
    }
  }

    /**
     * method untuk print kwitansi
     * @param int $pembayaranpelayanan_id pembayaranpelayanan_id
     */
    public function actionPrintKuitansi($pembayaranpelayanan_id)
    {
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }
        $judulKuitansi = '----- KUITANSI -----';
        $format = new MyFormatter();
        $modBayar = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
        $modPasien = PasienM::model()->findByPk($modBayar->pasien_id);
        $modTandaBukti = TandabuktibayarT::model()->findByPk($modBayar->tandabuktibayar_id);
        $criteria = new CdbCriteria();
        $criteria->addCondition('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
        $tindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteria);
        if(!empty($modBayar->pendaftaran_id)){
            $modPendaftaran = PendaftaranT::model()->findByPk($modBayar->pendaftaran_id);
            $modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modBayar->pendaftaran->tgl_pendaftaran);
        }else{
            $modPendaftaran = new PendaftaranT;
        }
        $rincianpembayaran = array();
        $tindakan = array();
        $harga = 0;
		$discount = 0;
		$totalsemua = 0;
        if (count((array)$tindakanSudahBayar) > 0){
            $totalTindakan=0;
            foreach ($tindakanSudahBayar as $key => $value) {
                $tindakan[$value->daftartindakan->kelompoktindakan_id]['kelompoktindakan'] = $value->daftartindakan->kelompoktindakan->kelompoktindakan_nama;
                $harga += $value->jmlbiaya_tindakan;
                $tindakan[$value->daftartindakan->kelompoktindakan_id]['harga'] = $harga;
                $discount += $value->tindakanpelayanan->discount_tindakan;
                $tindakan[$value->daftartindakan->kelompoktindakan_id]['discount'] = $discount;
                $totalTindakan += ($value->jmlbiaya_tindakan - $value->tindakanpelayanan->discount_tindakan);
            }
            $rincianpembayaran['tindakan'] = $tindakan;
            $rincianpembayaran['tindakan']['totalTindakan'] = $totalTindakan;
			$totalsemua += $totalTindakan;
        }
        $oaSudahBayar = OasudahbayarT::model()->findAll($criteria);
        $oa = array();
        if (count((array)$oaSudahBayar) > 0 ){
            $totalOa=0;
            $oa[0]['harga'] = 0;
            $oa[0]['discount'] = 0;
            $oa[0]['biayaadministrasi'] = 0;
            $oa[0]['biayaservice'] = 0;
            $oa[0]['biayakonseling'] = 0;
            foreach ($oaSudahBayar as $key => $value) {
                    $oa[0]['kelompoktindakan'] = ($value->obatalkes->jenisobatalkes) ? $value->obatalkes->jenisobatalkes->jenisobatalkes_nama : "-";
                    $oa[0]['harga'] += ($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
                    $discount = ($value->obatalkespasien->discount > 0 ) ? $value->obatalkespasien->discount/100 : 0 ;
                    $oa[0]['discount'] += ($discount*$value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa);
                    $oa[0]['biayaadministrasi'] += $value->obatalkespasien->biayaadministrasi;
                    $oa[0]['biayaservice'] += $value->obatalkespasien->biayaservice;
                    $oa[0]['biayakonseling'] += $value->obatalkespasien->biayakonseling;
                    $totalOa += (($value->obatalkespasien->hargasatuan_oa * $value->obatalkespasien->qty_oa) - $oa[0]['discount'] + $oa[0]['biayaadministrasi'] + $oa[0]['biayaservice'] + $oa[0]['biayakonseling']);
            }
            $rincianpembayaran['oa'] = $oa;
            $rincianpembayaran['oa']['totalOa'] = $totalOa;
			$totalsemua += $totalOa;
        }

        if($modTandaBukti->jmlpembayaran == 0 && $modBayar->carabayar_id != 2)
        { //jika jmlpembayaran nol
            $modTandaBukti->jmlpembayaran = $totalsemua;
        }

        $caraPrint=isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if ($caraPrint) {

                if($caraPrint=='PRINT') {
                    $this->layout='//layouts/printWindows';
                    $this->render($this->path_view.'printKuitansiKarcis', array( 'modPendaftaran'=>$modPendaftaran, 'judulKuitansi'=>$judulKuitansi, 'caraPrint'=>$caraPrint, 'rincianpembayaran'=>$rincianpembayaran,
                                        'modTandaBukti'=>$modTandaBukti,
                                        'modBayar'=>$modBayar,
                                      'modPasien'=>$modPasien));
                    //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
                }
                else if($caraPrint=='EXCEL') {
                    $this->layout='//layouts/printExcel';
                    $this->render($this->path_view.'printKuitansiKarcis',array( 'modPendaftaran'=>$modPendaftaran, 'judulKuitansi'=>$judulKuitansi, 'caraPrint'=>$caraPrint,'rincianpembayaran'=>$rincianpembayaran,
                                        'modTandaBukti'=>$modTandaBukti,
                                        'modBayar'=>$modBayar,
                                        'modPasien'=>$modPasien));
                }
                else if($caraPrint=='PDF') {
        //                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                    //$ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
                    $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                    //$mpdf = new MyPDF60('',$ukuranKertasPDF);
                    //$mpdf = new MyPDF60('','B5-L');
                    $mpdf = new MyPDF60('','','15', '', 15, 15, 16, 16, 9, 9, 'B5');
                    //$mpdf->useOddEven = 2;
                    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                    $mpdf->WriteHTML($stylesheet,1);
                    /*
                    * cara ambil margin
                    * tinggi_header * 72 / (72/25.4)
                    *  tinggi_header = inchi
                    */

                    /*font-family: tahoma;*/
                    // $header = 0.50 * 72 / (72/25.4);
                    $header = 0.3 * 72 / (72/25.4);
                    $mpdf->AddPage($posisi,'','','','',3,8,$header,5,0,0);
                    $mpdf->WriteHTML(
                        $this->renderPartial(
                            $this->path_view.'printKuitansiKarcis',
                            array(
                              'modPendaftaran'=>$modPendaftaran, 
                              'judulKuitansi'=>$judulKuitansi, 
                              'caraPrint'=>$caraPrint,
                              'rincianpembayaran'=>$rincianpembayaran,
                              'modTandaBukti'=>$modTandaBukti,
                              'modBayar'=>$modBayar,
                              'modPasien'=>$modPasien
                            ),true
                        )
                    );
                    $mpdf->Output();
                }
        }else{

        $this->render($this->path_view.'printKuitansiKarcis', array(
            // 'model'=>$model,
            // 'pembayarans'=>$pembayarans,
            'modPendaftaran'=>$modPendaftaran,
            'judulKuitansi'=>$judulKuitansi,
            'caraPrint'=>$caraPrint,
            'rincianpembayaran'=>$rincianpembayaran,
                'modTandaBukti'=>$modTandaBukti,
                'modBayar'=>$modBayar,
                'modPasien'=>$modPasien,
                
        ));

        }
    }
    
}

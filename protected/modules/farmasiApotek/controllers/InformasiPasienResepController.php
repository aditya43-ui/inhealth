<?php

Yii::import('rawatInap.models.*');
class InformasiPasienResepController extends MyAuthController
{
  public $path_view = "farmasiApotek.views.informasiPasienResep.";
  public function actionIndex()
  {
    $model = new FAInformasiresepturV('searchInformasiPasienResep');
    $model->unsetAttributes();
    $model->tgl_awal = date("d M Y");
    $model->tgl_akhir = date("d M Y");
    $model->isbatal = false;
    if(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_UPFRAJALUMUM) {
      $model->carabayar_id = [1, 3];
    } else if(Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_UPFRAJALJKN){
      $model->carabayar_id = Params::CARABAYAR_ID_BPJS;
    }
    if (isset($_GET['FAInformasiresepturV'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['FAInformasiresepturV'];
      $model->statusJual = isset($_GET['FAInformasiresepturV']['statusJual']) ? $_GET['FAInformasiresepturV']['statusJual'] : null;
      $model->statusperiksa = isset($_GET['FAInformasiresepturV']['statusperiksa']) ? $_GET['FAInformasiresepturV']['statusperiksa'] : null;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasiresepturV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasiresepturV']['tgl_akhir']);
      $model->statuspasien = isset($_GET['FAInformasiresepturV']['statuspasien']) ? $_GET['FAInformasiresepturV']['statuspasien'] : null;

      if(Yii::app()->request->isAjaxRequest) {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'pencarianpasien-grid') {
          $this->renderPartial('_table', ['model' => $model]);
          Yii::app()->end();
        }
      }
    }

    $this->render('index', array('model' => $model));
  }

  public function actionCreate($pendaftaran_id, $pasienadmisi_id = null, $id = null)
  {
    $this->layout = '//layouts/iframe';

    if (!empty($pasienadmisi_id)) {
      $kunjungan = InfokunjunganriV::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
      ));
    } else {
      $kunjungan = PendaftaranT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
      ));
    }

    $model = CatatanpemberianobatT::model()->findByPk($id);

    $modPemberianObatDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id' => $id));



    if (empty($modPemberianObatDet)) {

      $modPemberianObatDet = new CatatanpemberianobatdetT;
    }

    // echo print_r($modPemberianObatDet).exit();

    if (empty($model)) {
      $model = new CatatanpemberianobatT;
      $model->pendaftaran_id = $kunjungan->pendaftaran_id;
      $model->pasien_id = $kunjungan->pasien_id;
    }


    if (!empty($model->obatalkes)) {
      $model->obatalkes_nama = $model->obatalkes->obatalkes_nama;
    }

    if (!empty($model->petugaspengisi)) {
      $model->petugaspengisi_nama = $model->petugaspengisi->namaLengkap;
    }

    $conditionRiwayat_infus = array();
    $riwayat_oral = array();
    if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_VK) {
      $conditionRiwayat_infus = array('condition' => "jenisinfus in ('INJEKSI','INFUS')");

      $riwayat_oral = CatatanpemberianobatT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
      ), array('condition' => "jenisinfus in ('ORAL','OBAT LUAR')"));
    }

    $riwayat_infus = CatatanpemberianobatT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ), $conditionRiwayat_infus);


    if (isset($_POST['CatatanpemberianobatT'])) {
      $model->attributes = $_POST['CatatanpemberianobatT'];


      if ($model->isNewRecord) {
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      }
      $model->isalergiobat = $_POST['CatatanpemberianobatT']['isalergiobat'];
      $model->carapemberian = $_POST['CatatanpemberianobatT']['carapemberian'];
      $model->cairanmasuk = $_POST['CatatanpemberianobatT']['cairanmasuk'];
      $model->jeniscairanmasuk = $_POST['CatatanpemberianobatT']['jeniscairanmasuk'];
      $model->pegawai_id = $_POST['CatatanpemberianobatT']['pegawai_id'];
      $model->update_time = date('Y-m-d H:i:s');
      $model->update_loginpemakai = Yii::app()->user->id;

      if ($model->save()) {
        $sukses = true;
        if (!empty($modPemberianObatDet)) {
          // echo print_r($modPemberianObatDet).exit();
          $hapusRiwayat = CatatanpemberianobatdetT::model()->deleteAll('catatanpemberianobat_id=' . $model->catatanpemberianobat_id . '');
        }
        if (isset($_POST['CatatanpemberianobatdetT'])) {

          if (count($_POST['CatatanpemberianobatdetT']) > 0) {
            $modPemberianObatDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id' => $model->catatanpemberianobat_id));


            foreach ($_POST['CatatanpemberianobatdetT'] as $det) {
              $modPemberianObatDet = new CatatanpemberianobatdetT;
              $modPemberianObatDet->catatanpemberianobat_id = $model->catatanpemberianobat_id;
              $modPemberianObatDet->tanggal_pemberian = MyFormatter::formatDateTimeForDB($det['tanggal_pemberian']);
              $modPemberianObatDet->tanda = $det['tanda'];
              $modPemberianObatDet->initial = $det['initial'];
              $modPemberianObatDet->jam_pemberian = $det['jam_pemberian'];
              $modPemberianObatDet->waktu_monitoring = $det['waktu_monitoring'];
              if ($modPemberianObatDet->save()) {
                $sukses = true;
              } else {
                $sukses = false;
              }
            }
          }
        }
      } else {
        $sukses = false;
      }

      if ($sukses) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create', 'pendaftaran_id' => $model->pendaftaran_id, 'pasienadmisi_id' => $kunjungan->pasienadmisi_id, 'type' => (!empty($_GET['type']) ? $_GET['type'] : ""), 'frame' => (!empty($_GET['frame']) ? $_GET['frame'] : "")));
      }
    }
    // echo print_r(($modPemberianObatDet)).exit();
    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'kunjungan' => $kunjungan,
      'riwayat_infus' => $riwayat_infus,
      'riwayat_oral' => $riwayat_oral,
      'modPemberianObatDet' => $modPemberianObatDet
    ));
  }

  public function actionAutocompleteObat($term = "")
  {
    $modObatAlkes = new RIObatalkesM('search'); //ResepturdetailT
    $modObatAlkes->unsetAttributes();
    $modObatAlkes->pendaftaran_id = $_GET['pendaftaran_id'];
    $modObatAlkes->obatalkes_nama = $term;

    $prov = $modObatAlkes->searchObatAlkesPasienDijual();
    $prov->pagination = false;

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->obatalkes_nama;
      $sub['value'] = $item->obatalkes_id;
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  public function actionPrintResepDokter()
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else {
      $this->layout = '//layouts/printWindows';
    }

    $reseptur_id = $_GET['id'];
    $modReseptur = FAResepturT::model()->findByPk($reseptur_id);
    $pendaftaran_id = $modReseptur->pendaftaran_id;
    $criteria = new CDbCriteria;
    $criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
    $maxtime = FAResepturT::model()->find($criteria);
    $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $maxtime->reseptur_id));
    $modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);

    $judulLaporan = '';

    $criteriakl = new CDbCriteria;
    $criteriakl->addCondition("reseptur_id = " . $reseptur_id);
    $criteriakl->select = 'racikan_id, rke, iter, reseptur_id, jmlkemasan_reseptur';
    $criteriakl->group = 'racikan_id, rke, iter, reseptur_id, jmlkemasan_reseptur';
    if (isset($_GET['racikan_id'])) {
      $criteriakl->compare('racikan_id', $_GET['racikan_id']);
    }
    $kerangkaLooping = ResepturdetailT::model()->findAll($criteriakl);

    $this->render('Print', array(
      'modPendaftaran' => $modPendaftaran,
      'judulLaporan' => $judulLaporan,
      "modDetailResep" => $modDetailResep,
      'modReseptur' => $modReseptur,
      'kerangkaLooping' => $kerangkaLooping
    ));
  }

  public function actionPrintResepDokterManual()
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else {
      $this->layout = '//layouts/printWindows';
    }

    $pendaftaran_id = $_GET['id'];
    $modPenjualanResep = FAPenjualanresepT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));
    $modObatAlkesPasien = ObatalkespasienT::model()->findAllByAttributes(array(
      'penjualanresep_id' => $modPenjualanResep->penjualanresep_id,
    ));
    $modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);


    // $modReseptur = FAResepturT::model()->findByPk($reseptur_id);
    // $pendaftaran_id = $modReseptur->pendaftaran_id;
    // $criteria = new CDbCriteria;
    // $criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
    // $maxtime = FAResepturT::model()->find($criteria);
    // $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $maxtime->reseptur_id));
   
    $judulLaporan = '';

    // $criteriakl = new CDbCriteria;
    // $criteriakl->addCondition("reseptur_id = " . $reseptur_id);
    // $criteriakl->select = 'racikan_id, rke, iter, reseptur_id, jmlkemasan_reseptur';
    // $criteriakl->group = 'racikan_id, rke, iter, reseptur_id, jmlkemasan_reseptur';
    // if (isset($_GET['racikan_id'])) {
    //   $criteriakl->compare('racikan_id', $_GET['racikan_id']);
    // }
    // $kerangkaLooping = ResepturdetailT::model()->findAll($criteriakl);

    $this->render('Print_manual', array(
      'modPendaftaran' => $modPendaftaran,
      'judulLaporan' => $judulLaporan,
      'modPenjualanResep'=> $modPenjualanResep,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      // "modDetailResep" => $modDetailResep,
      // 'modReseptur' => $modReseptur,
      // 'kerangkaLooping' => $kerangkaLooping
    ));
  }
  /**
   * action ketika tombol panggil di klik
   */
  public function actionPanggilAntrian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $antrianfarmasi_id = ($_POST['antrianfarmasi_id']);
      $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
      $modAntrianFarmasi = AntrianfarmasiT::model()->findByPk($antrianfarmasi_id);
      $modReseptur = ResepturT::model()->findByPk($modAntrianFarmasi->reseptur_id);

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
      $data['smspasien'] = 1;
      $data['nama_pasien'] = '';

      if (isset($modReseptur)) {
        if (isset($modAntrianFarmasi)) {
          if (($modAntrianFarmasi->panggilantrian == true && $modAntrianFarmasi->jumlah_panggil == 3)) {
            if ($keterangan == "batal") {
              $modAntrianFarmasi->panggilantrian = false;
              if ($modAntrianFarmasi->update()) {
                // SMS GATEWAY
                $modPasien = $modPenjualanResep->pasien;
                $sms = new Sms();
                $smspasien = 1;
                foreach ($modSmsgateway as $i => $smsgateway) {
                  $isiPesan = $smsgateway->templatesms;

                  $attributes = $modPasien->getAttributes();
                  foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                  }
                  $attributes = $modReseptur->getAttributes();
                  foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                  }
                  $attributes = $modAntrianFarmasi->getAttributes();
                  foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                  }

                  if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                    if (!empty($modPasien->no_mobile_pasien)) {
                      $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                    } else {
                      $smspasien = 0;
                    }
                  }
                }
                // END SMS GATEWAY
                $data['smspasien'] = $smspasien;
                $data['nama_pasien'] = $modPasien->nama_pasien;
                $data['pesan'] = "Pemanggilan no. antrian " . $modAntrianFarmasi->noantrian . " dibatalkan !";
              }
            } else {
              $data['pesan'] = "No. antrian " . $modAntrianFarmasi->noantrian . " sudah dipanggil sebelumnya !";
            }
          } else {
            $modAntrianFarmasi->panggilantrian = true;
            $modAntrianFarmasi->jumlah_panggil++;
            if ($modAntrianFarmasi->update()) {
              $data['pesan'] = "No. antrian " . $modAntrianFarmasi->noantrian . " dipanggil! (" . $modAntrianFarmasi->jumlah_panggil . " kali)";

              if (!empty($modReseptur)) {
                $pendaftaran = PendaftaranT::model()->findByPk($modReseptur->pendaftaran_id);
                $kodebooking = $pendaftaran->no_pendaftaran;
                if (!empty($pendaftaran->buatjanjipoli_id)) {
                  $buatjanjipoli = BuatjanjipoliT::model()->findByPk($pendaftaran->buatjanjipoli_id);

                  if (!empty($buatjanjipoli)) {
                    $kodebooking = $buatjanjipoli->no_buatjanji;
                  }
                }
                if (!empty($pendaftaran) && $pendaftaran->instalasi_id == Params::INSTALASI_ID_RJ && (empty($pendaftaran->pasienadmisi_id))) {
                  $waktutunggupelayanan = new WaktutunggupelayananT();
                  $waktutunggupelayanan->pendaftaran_id = $pendaftaran->pendaftaran_id;
                  $waktutunggupelayanan->pasien_id = $pendaftaran->pasien_id;
                  $waktutunggupelayanan->task_id = 5;
                  $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
                  $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
                  $waktutunggupelayanan->tanggal = date('Y-m-d H:i:s');
                  $waktutunggupelayanan->kode_booking = $kodebooking;//$pendaftaran->no_pendaftaran;
                  $waktutunggupelayanan->statuskirim = 0;
                  $waktutunggupelayanan->create_time = date('Y-m-d H:i:s');
                  $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
                  $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                  $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s');
                  $waktutunggupelayanan->save();
                }
              }
            }
          }
        } else {
          $data['pesan'] = "Pasien tidak ada dalam No. Antrian";
        }
      }

      if (isset($antrianfarmasi_id)) {
        $attributes = $modAntrianFarmasi->attributeNames();
        foreach ($attributes as $i => $attribute) {
          $data["$attribute"] = $modAntrianFarmasi->$attribute;
        }
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  //print penjualan 
  public function actionPrintResepPenjualan($penjualanresep_id)
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else {
      if ($_GET['caraPrint'] == 'PRINT') {
        $this->layout = '//layouts/printWindows';
      }
    }

    $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
    $modReseptur = FAResepturT::model()->findByPk($modPenjualan->reseptur_id);
    $modDetailResep = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
    // $modInfo = FAInformasipenjualanresepV::model()->findByAttributes(['penjualanresep_id' => $modDetailResep->penjualanresep_id]);
    $modPendaftaran = FAPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($modPenjualan->pendaftaran_id);
    $modPegawai = FAPegawaiM::model()->findByPk($modPenjualan->pegawai_id);

    $judulLaporan = '';

    $data = [];
    foreach ($modDetailResep as $key => $value) {
      $rke = $value->rke;
      $oa = $value->obatalkes_id;

      $data[$rke]['rke'] =  $rke;
      $data[$rke]['jmlkemasan_oa'] =  $value->jmlkemasan_oa;
      $data[$rke]['racikan_id'] =  $value->racikan_id;
      $data[$rke]['signa_oa'] =  $value->signa_oa;
      $data[$rke]['satuansediaan'] =  !empty($value->satuansediaan) ? $value->satuansediaan : '';
      $data[$rke]['det'][$oa]['obatalkes_id'] =  $value->obatalkes_id;
      $data[$rke]['det'][$oa]['obatalkes_nama'] =  $value->obatalkes->obatalkes_nama;
      $data[$rke]['det'][$oa]['satuankecil_nama'] =  $value->satuankecil->satuankecil_nama;
      $data[$rke]['det'][$oa]['qty_oa'] =  $value->qty_oa;
      $data[$rke]['det'][$oa]['signa_oa'] =  $value->signa_oa;
      $data[$rke]['det'][$oa]['permintaan_oa'] =  !empty($value->permintaan_oa) ? $value->permintaan_oa : 0;
      $data[$rke]['det'][$oa]['kekuatan_oa'] =  !empty($value->kekuatan_oa) ? $value->kekuatan_oa : 0;
      $data[$rke]['det'][$oa]['etiket'] = $value->etiket;
      $data[$rke]['det'][$oa]['keterangan'] = !empty($value->keterangan) ? $value->keterangan : "-";
      // if ($value->is_permintaandosispecahan == false) {
      //     $data[$rke]['det'][$oa]['satuankekuatan_oa'] =  !empty($value->satuankekuatan_oa) ? $value->satuankekuatan_oa : '';
      // } else {
      //     $data[$rke]['det'][$oa]['permintaan_oa'] = $value->permintaandosis_pembilang . '/' .$value->permintaandosis_penyebut ;
      //     $data[$rke]['det'][$oa]['satuankekuatan_oa'] = '';
      // }
    }

    if (isset($_GET['frame'])) {
      $this->render('PrintPenjualan', array(
        'modPendaftaran' => $modPendaftaran,
        'judulLaporan' => $judulLaporan,
        "modDetailResep" => $modDetailResep,
        'modPenjualan' => $modPenjualan,
        'modPegawai' => $modPegawai,
        'modReseptur' => $modReseptur,
        'data' => $data,
        // 'modInfo' => $modInfo,
      ));
    } else {
      if ($_GET['caraPrint'] == 'PRINT') {
        $this->render('PrintPenjualan', array(
          'modPendaftaran' => $modPendaftaran,
          'judulLaporan' => $judulLaporan,
          "modDetailResep" => $modDetailResep,
          'modPenjualan' => $modPenjualan,
          'modPegawai' => $modPegawai,
          'modReseptur' => $modReseptur,
          'data' => $data,
          // 'modInfo' => $modInfo,
        ));
      } else if ($_GET['caraPrint'] == 'PDF') {
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', [250, 150]);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 10);
        $mpdf->WriteHTML($this->renderPartial('PrintPenjualan', array(
          'modPendaftaran' => $modPendaftaran,
          'judulLaporan' => $judulLaporan,
          "modDetailResep" => $modDetailResep,
          'modPenjualan' => $modPenjualan,
          'modPegawai' => $modPegawai,
          'modReseptur' => $modReseptur,
          'data' => $data,
          // 'modInfo' => $modInfo,
        ), true));
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->Output("Laporan" . '-' . date('Y/m/d') . '.pdf', 'I');
      }
    }
  }

  // public function actionBatalResep() {
  //     if (Yii::app()->request->isAjaxRequest) {

  //         $id = $_POST['id'];

  //         $ok = true;
  //         $trans = Yii::app()->db->beginTransaction();
  //         try {
  //             $reseptur = ResepturT::model()->findByPk($id);
  //             $reseptur->isbatal = true;
  //             $reseptur->petugasbatal_id = Yii::app()->user->getState('pegawai_id');
  //             $reseptur->waktu_batal = date('Y-m-d H:i:s');
  //             $ok &= $reseptur->update(['isbatal','petugasbatal_id','waktu_batal']);                                

  //             if ($ok) {
  //                 $trans->commit();
  //             } else {
  //                 $trans->rollback();
  //             }
  //         } catch (Exception $e) {
  //             $ok &= false;
  //             $trans->rollback();
  //         }

  //         echo json_encode([
  //             'sukses' => $ok ? 1 : 0
  //         ]);
  //         Yii::app()->end();
  //     }
  // }

  public function actionHapusRiwayatReseptur()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $detailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $_POST['reseptur_id']));
        $resep = ResepturT::model()->findByPk($_POST['reseptur_id']);
        if (!empty($resep->penjualanresep_id)) {
          $data['pesan'] = "Reseptur " . $resep->noresep . " sudah terjual.";
          $data['sukses'] = 0;
          $transaction->rollback();
          goto prints;
        }

        $deleteDetailResep = ResepturdetailT::model()->deleteAllByAttributes(array('reseptur_id' => $_POST['reseptur_id']));
        if ($deleteDetailResep) {
          if ($resep->delete()) {
            $data['pesan'] = "Riwayat Resep Termasuk Detail Resep Berhasil Dihapus!";
            $data['sukses'] = 1;
            $transaction->commit();
          } else {
            $transaction->rollback();
            $data['pesan'] = "Gagal Menghapus Reseptur";
            $data['sukses'] = 0;
          }
        } else {
          $transaction->rollback();
          $data['pesan'] = "Gagal Menghapus Detail Reseptur";
          $data['sukses'] = 0;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Transaksi Gagal :" . MyExceptionMessage::getMessage($exc, true);
      }
      prints:
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
}

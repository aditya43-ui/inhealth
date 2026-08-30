<?php

class TransaksiVisiteDokterController extends MyAuthController
{
  public $succesSave = false;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Visite Dokter";
    $format = new MyFormatter();
    $model = new PIInfopasienmasukkamarV('searchPIVisiteDokter');
    $model->is_dokter = 0;
    $model->tanggalVisite = date('d M Y');
    $model->tanggalVisite = date('d M Y');
    // $model = new PIPasienrawatinapV;
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

    if (isset($_POST['PITindakanPelayananT'])) {
      $jumlahPasien = count((array)$_POST['PITindakanPelayananT']);
      $jumlahCeklist = 0;
      $jumlahTersimpan = 0;

      $transaction = Yii::app()->db->beginTransaction();
      try {
        if ($jumlahPasien > 0) {
          foreach ($_POST['PITindakanPelayananT'] as $i => $detail) {
            if ($_POST['PITindakanPelayananT'][$i]['dipilih'] == 'Ya') { //Jika Diceklist   
              $modelTarifTindakan = TariftindakanM::model()->find(
                'daftartindakan_id = ' . $_POST['PITindakanPelayananT'][$i]['daftartindakan_id'] . ' AND kelaspelayanan_id =' . $_POST['PIInfopasienmasukkamarV'][$i]['kelaspelayanan_id'] . ''
              );
              $jumlahCeklist++;
              $modTindakans = new PITindakanPelayananT;
              $modTindakans->penjamin_id = $_POST['PITindakanPelayananT'][$i]['penjamin_id'];
              $modTindakans->pasienadmisi_id = $_POST['PITindakanPelayananT'][$i]['pasienadmisi_id'];
              $modTindakans->pasien_id = $_POST['PITindakanPelayananT'][$i]['pasien_id'];
              $modTindakans->kelaspelayanan_id = $_POST['PIInfopasienmasukkamarV'][$i]['kelaspelayanan_id'];
              $modTindakans->instalasi_id = Yii::app()->user->getState('instalasi_id');
              $modTindakans->pendaftaran_id = $_POST['PITindakanPelayananT'][$i]['pendaftaran_id'];
              $modTindakans->shift_id = Yii::app()->user->getState('shift_id');
              $modTindakans->daftartindakan_id = $_POST['PITindakanPelayananT'][$i]['daftartindakan_id'];
              $modTindakans->carabayar_id = $_POST['PITindakanPelayananT'][$i]['carabayar_id'];
              $modTindakans->jeniskasuspenyakit_id = $_POST['PITindakanPelayananT'][$i]['jeniskasuspenyakit_id'];
              //                            $modTindakans->tgl_tindakan = $format->formatDateTimeForDb(trim($_POST['tanggalVisite']));
              $modTindakans->tgl_tindakan = $format->formatDateTimeForDb($_POST['PIInfopasienmasukkamarV']['tanggalVisite']);
              //                            $modTindakans->dokterpemeriksa1_id = $_POST['PITindakanPelayananT']['pegawai_id'][$i];
              //                            $modTindakans->dokterpemeriksa1_id = $_POST['PIInfopasienmasukkamarV']['pegawai_id'];
              $modTindakans->dokterpemeriksa1_id = $_POST['PITindakanPelayananT'][$i]['pegawai_id'];
              //                            $modTindakans->ruangan_id = Yii::app()->user->getState('ruangan_id');
              $modTindakans->ruangan_id = $_POST['PIInfopasienmasukkamarV'][$i]['ruangan_id']; //untuk cover jiga berdasarkan nursestation
              $modTindakans->satuantindakan = Params::SATUAN_TINDAKAN_VISITE; //'KALI';
              $modTindakans->qty_tindakan = 1;
              $modTindakans->tarif_satuan = !empty($modelTarifTindakan->harga_tariftindakan) ? $modelTarifTindakan->harga_tariftindakan : 0;
              //                            $modTindakans->tarif_tindakan = !empty($modelTarifTindakan->harga_tariftindakan) ? $modelTarifTindakan->harga_tariftindakan : 0;
              $modTindakans->tarif_tindakan = ($modTindakans->qty_tindakan * $modTindakans->tarif_satuan);
              $modTindakans->cyto_tindakan = 0;
              $modTindakans->tarifcyto_tindakan = 0;
              $modTindakans->discount_tindakan = 0;
              $modTindakans->pembebasan_tindakan = 0;
              $modTindakans->subsidiasuransi_tindakan = 0;
              $modTindakans->subsidipemerintah_tindakan = 0;
              $modTindakans->subsisidirumahsakit_tindakan = 0;
              $modTindakans->iurbiaya_tindakan = 0;
              $modTindakans->tm = 'TM';
              $modTindakans->create_time = date('Y-m-d H:i:s');
              $modTindakans->create_loginpemakai_id = Yii::app()->user->id;
              $modTindakans->create_ruangan = Yii::app()->user->getState('ruangan_id');


              if ($modTindakans->save()) {
                // SMS GATEWAY
                $modPegawai = $modTindakans->dokter1;
                $modPasien = $modTindakans->pasien;
                $modRuangan = $modTindakans->ruangan;
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
                  $attributes = $modTindakans->getAttributes();
                  foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                  }

                  $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modTindakans->tgl_tindakan), $isiPesan);



                  if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                    if (!empty($modPasien->no_mobile_pasien)) {
                      $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                    }
                  } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
                    if (!empty($modPegawai->nomobile_pegawai)) {
                      $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
                    }
                  }
                }
                // END SMS GATEWAY
                $jumlahTersimpan++;
              }
            }
          }

          if ($jumlahCeklist == $jumlahTersimpan) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Berhasil disimpan ");
            $this->redirect(array('index', 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . '<pre>' . print_r($modTindakans->getErrors(), 1) . '</pre>');
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    if (isset($_POST['PIInfopasienmasukkamarV'])) {
      $model->unsetAttributes();
      $model->attributes = $_POST['PIInfopasienmasukkamarV'];
      $model->no_rekam_medik = $_POST['PIInfopasienmasukkamarV']['no_rekam_medik'];
      $model->nama_pasien = $_POST['PIInfopasienmasukkamarV']['nama_pasien'];
      if ($_POST['PIInfopasienmasukkamarV']['is_dokter'] == 1) {
        $model->nama_pegawai = $_POST['PIInfopasienmasukkamarV']['nama_pegawai'];
      } else {
        $model->nama_pegawai = '';
      }
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function actionGetTarifTindakan()
  {

    if (Yii::app()->request->isAjaxRequest) {
      $daftartindakan_id = $_POST['daftartindakan_id'];
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];

      $modelTarifTindakan = TariftindakanM::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' AND kelaspelayanan_id =' . $kelaspelayanan_id . '');
      if (!empty($modelTarifTindakan)) {
        $data['status'] = 'Ada';
        //$data['tarif_tindakan'] = $modelTarifTindakan->harga_tariftindakan;
      } else {
        $data['status'] = 'Tidak';
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetDaftarTindakanVisite()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
      $criteria->compare('daftartindakan_visite', TRUE);
      $criteria->addCondition('daftartindakan_aktif = true');
      $criteria->limit = 5;
      $models = DaftartindakanM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        //                    $returnVal[$i]['label'] = $model->daftartindakan_id.'-'.$model->daftartindakan_nama;
        $returnVal[$i]['label'] = $model->daftartindakan_nama;
        $returnVal[$i]['value'] = $model->daftartindakan_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLoadFormVisiteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';

      $pegawai_id = $_POST['pegawai_id'];
      $nama_pegawai = $_POST['nama_pegawai'];
      $ruangan = Yii::app()->user->getState('ruangan_id');
      //			$kelaspelayananruangan = Yii::app()->user->getState('kelaspelayananruangan');
      $kelaspelayananruangan = CHtml::listData(KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan . ' and kelaspelayanan_aktif = true'), 'kelaspelayanan_id', 'kelaspelayanan_id');
      $tgl = isset($_POST['tgl_visit']) ? MyFormatter::formatDateTimeForDb($_POST['tgl_visit']) : date("Y-m-d");
      $tgl2 = isset($_POST['tanggalVisite_akhir']) ? MyFormatter::formatDateTimeForDb($_POST['tanggalVisite_akhir']) : date("Y-m-d");
      $is_dokter = isset($_POST['is_dokter']) ? $_POST['is_dokter'] : 0;
      $is_nurse_station = isset($_POST['is_nurse_station']) ? $_POST['is_nurse_station'] : 0;
      $daftartindakan_id = $_POST['daftartindakan_id'];

      $nurseStation = array();
      $ruangaNurse = NursestationruanganM::model()->findByAttributes(array('ruangan_id' => $ruangan));
      //          $ruangAllNurse = NursestationruanganM::model()->findAll('nursestation_id=' . $ruangaNurse->nursestation_id);
      if (!empty($ruangaNurse)) {
        $ruangAllNurse = NursestationruanganM::model()->findAll('nursestation_id=' . $ruangaNurse->nursestation_id);
        foreach ($ruangAllNurse as $value) {
          $nurseStation[] = $value->ruangan_id;
        }
      }

      $modTindakans = new PITindakanPelayananT;
      $criteria = new CDbCriteria;

      if (count((array)$nurseStation) > 0 && $is_nurse_station != 0) {
        $criteria->addInCondition('ruangan_id', $nurseStation);
      } else {
        $criteria->addCondition('ruangan_id = ' . $ruangan);
      }

      if (count((array)$kelaspelayananruangan) > 0) {
        if (is_array($kelaspelayananruangan)) {
          $criteria->addInCondition("kelaspelayanan_id", $kelaspelayananruangan);
        } else {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayananruangan);
        }
      }
      if ($is_dokter == 1) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      }
      //			$criteria->addBetweenCondition("DATE(tglmasukkamar)",$tgl,$tgl);
      $criteria->addBetweenCondition("DATE(tglmasukkamar)", $tgl, $tgl2);
      $modInformasiVisite = PIInfopasienmasukkamarV::model()->findAll($criteria);
      if (count((array)$modInformasiVisite) == 0) {
        $pesan = 'Data Tidak Ada !';
      }

      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'pesan' => $pesan,
          'form' => $this->renderPartial('_rowVisiteDokter', array(
            //'format'=>$format,
            'modInformasiVisite' => $modInformasiVisite,
            'modTindakans' => $modTindakans,
            'daftartindakan_id' => $daftartindakan_id
          ), true)
        )
      );
      exit;
    }
  }

  public function actionAutocompleteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 5;
      $models = PIDokterV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}

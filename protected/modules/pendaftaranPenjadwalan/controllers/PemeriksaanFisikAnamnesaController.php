<?php

class PemeriksaanFisikAnamnesaController extends MyAuthController
{
  public $path_view = 'pendaftaranPenjadwalan.views.pemeriksaanFisikAnamnesa.';
  public $layout = '//layouts/column1';
  public function actionIndexAnamnesa($pendaftaran_id)
  {
    $format = new MyFormatter;
    //        if(isset($_GET['frame']))
    //        {
    //            $this->layout = '//layouts/';
    //        }
    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);

    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $dataPendaftaran = PPPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tgl_pendaftaran DESC'));
    //print_r($lastPendaftaran);
    //echo $modPasien->pasien_id;exit();
    $i = 1;
    if (count((array)$dataPendaftaran) > 1) {
      foreach ($dataPendaftaran as $row) {
        if ($i == 2) {
          $lastPendaftaran = $row->pendaftaran_id;
        }
        $i++;
      }
    } else {
      $lastPendaftaran = $pendaftaran_id;
    }


    $cekAnamnesa = PPAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modDiagnosa = new PPDiagnosaM;

    if (!empty($cekAnamnesa)) {  //Jika Pasien Sudah Melakukan Anamnesa Sebelumnya
      $modAnamnesa = $cekAnamnesa;
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modAnamnesa->paramedis_nama = $pegawai->nama_pegawai;
      //$modAnamnesa->riwayatimunisasi = $modPendaftaran->statuspasien;
    } else {
      ////Jika Pasien Belum Pernah melakukan Anamnesa
      $modAnamnesa = new PPAnamnesaT;
      $modAnamnesa->pegawai_id = $modPendaftaran->pegawai_id;
      $modAnamnesa->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modAnamnesa->pasien_id = $modPendaftaran->pasien_id;
      $modAnamnesa->tglanamnesis = date('Y-m-d H:i:s');
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modAnamnesa->paramedis_nama = $pegawai->nama_pegawai;
    }

    if ($modPendaftaran->statuspasien == "PENGUNJUNG LAMA") {
      $modDiagnosaTerdahulu = PPPasienMorbiditasT::model()->with('diagnosa')->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id, 'pendaftaran_id' => $lastPendaftaran));

      $hasilImunisasi = array();
      $hasilDiagnosaDahulu = array();
      foreach ($modDiagnosaTerdahulu as $row) {
        if ($row->diagnosa->diagnosa_imunisasi == true)
          $hasilImunisasi[] = $row->diagnosa->diagnosa_nama;
        else
          $hasilDiagnosaDahulu[] = $row->diagnosa->diagnosa_nama;
      }
      if (empty($modAnamnesa->riwayatimunisais)) {
        $modAnamnesa->riwayatimunisasi = implode(', ', $hasilImunisasi);
      }
      if (empty($modAnamnesa->riwayatpenyakitterdahulu)) {
        $modAnamnesa->riwayatpenyakitterdahulu = implode(', ', $hasilDiagnosaDahulu);
      }
    }

    if (isset($_POST['PPAnamnesaT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modAnamnesa->attributes = $_POST['PPAnamnesaT'];
        $modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($modAnamnesa->tglanamnesis);
        $modAnamnesa->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modAnamnesa->create_loginpemakai_id = Yii::app()->user->id;
        $modAnamnesa->create_time = date("Y-m-d H:i:s");
        $modAnamnesa->keluhanutama = isset($_POST['PPAnamnesaT']['keluhanutama']) ? (count((array)$_POST['PPAnamnesaT']['keluhanutama']) > 0) ? implode(', ', $_POST['PPAnamnesaT']['keluhanutama']) : '' : "";
        $modAnamnesa->keluhantambahan = isset($_POST['PPAnamnesaT']['keluhantambahan']) ? (count((array)$_POST['PPAnamnesaT']['keluhantambahan']) > 0) ? implode(', ', $_POST['PPAnamnesaT']['keluhantambahan']) : '' : "";
        if ($modAnamnesa->save()) {
          $updateStatusPeriksa = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Anamnesa berhasil disimpan");
          $this->redirect($_POST['url']);
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modAnamnesa->tglanamnesis = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modAnamnesa->tglanamnesis, 'yyyy-MM-dd hh:mm:ss')
    );

    $modDataDiagnosa = new PPDiagnosaM('search');
    $modDataDiagnosa->unsetAttributes();
    if (isset($_GET['PPDiagnosaM'])) {
      $modDataDiagnosa->attributes = $_GET['PPDiagnosaM'];
    }
    $this->render($this->path_view . 'indexAnamnesis', array(
      'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa, 'modDiagnosa' => $modDiagnosa, 'modDataDiagnosa' => $modDataDiagnosa, 'frame' => true
    ));
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintAnamnesa($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAnamnesa = PPAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'ANAMNESIS';
    $this->render($this->path_view . 'printAnamnesa', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
    ));
  }

  public function actionMasterKeadaanUmum()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(keadaanumum_nama)', strtolower($_GET['tag']), true);
      $keluhans = KeadaanumumM::model()->findAll($criteria);
      $data = array();
      foreach ($keluhans as $i => $keluhan) {
        $data[$i] = array(
          'key' => $keluhan->keadaanumum_nama,
          'value' => $keluhan->keadaanumum_nama
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionGetMetodeGCS()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $gcs_eye = $_POST['gcs_eye'];
      $gcs_motorik = $_POST['gcs_motorik'];
      $gcs_verbal = $_POST['gcs_verbal'];

      $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;

      $namaGCS = GcsM::model()->find('' . $jumlah . '>=gcs_nilaimin AND ' . $jumlah . '<=gcs_nilaimax AND gcs_aktif=TRUE');
      if (!empty($namaGCS)) { //Jika Nilai GCSnya ada
        $data['idGCS'] = $namaGCS->gcs_id;
        $data['namaGCS'] = $namaGCS->gcs_nama;
      } else {
        $data['pesan'] = 'Nilai GCS Tidak Ditemukan';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetTextTekananDarah()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $systolic = $_POST['systolic'];
      $diastolic = $_POST['diastolic'];
      $criteria2 = new CDbCriteria();
      $criteria2->select = 'max(systolic_min) as sys_max';
      $modSys = SysdiaM::model()->find($criteria2);
      $criteria3 = new CDbCriteria();
      $criteria3->select = 'max(diastolic_min) as dias_max';
      $modDia = SysdiaM::model()->find($criteria3);

      $criteria = new CDbCriteria();

      if ($systolic > $modSys->sys_max) {
        $criteria->condition = 'systolic_min <= ' . $systolic . ' and systolic_max = 0';
      } else {
        $criteria->addCondition($systolic . ' >= systolic_min');
        $criteria->addCondition($systolic . ' <= systolic_max');
      }

      if ($diastolic > $modDia->dias_max) {
        $criteria->condition = 'diastolic_min <= ' . $diastolic . ' and diastolic_max = 0';
      } else {
        $criteria->addCondition($diastolic . ' >= diastolic_min');
        $criteria->addCondition($diastolic . ' <= diastolic_max');
      }

      $modSysDia = SysdiaM::model()->find($criteria);
      $data['text'] = $modSysDia->sysdia_nama;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetBMIText()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bmi = (isset($_POST['bmi']) ? $_POST['bmi'] : null);
      $criteria2 = new CDbCriteria();
      $criteria2->select = 'max(bmi_minimum) as max_bmi';
      $modBMI = BodymassindexM::model()->find($criteria2);
      $criteria = new CDbCriteria();
      //$criteria->addCondition($bmi.' >= bmi_minimum');

      if ($bmi > $modBMI->max_bmi) {
        $criteria->condition = 'bmi_minimum <= ' . $bmi . ' and bmi_maksimum = 0';
        //$criteria->condition('0 <= bmi_maksimum');
      } else {
        $criteria->addCondition($bmi . ' >= bmi_minimum');
        $criteria->addCondition($bmi . ' <= bmi_maksimum');
      }
      //echo $bmi;exit();
      //$criteria->order='bmi_minimum ASC';
      $data = array();
      $data['text'] = BodymassindexM::model()->find($criteria)->bmi_defenisi;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetfromDevice()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $file = dirname('c:/OstarP2/x') . '/OstarXML.xml';
      } else {
        $file = Yii::app()->getBaseUrl('webroot') . '/data/xml/ostar.xml';
      }

      $data2 = simplexml_load_file($file);
      $a = $data2->BPMRecord[0]['H'];
      $b = $data2->BPMRecord[0]['L'];
      $c = $data2->BPMRecord[0]['P'];

      $tambah = '';
      if (strlen($a) < 3) {
        for ($i = strlen($a); $i < 3; $i++) {
          $tambah = $tambah . '0';
        }
        $a = $tambah . $a;
      }
      $tambah = '';
      if (strlen($b) < 3) {
        for ($i = strlen($b); $i < 3; $i++) {
          $tambah = $tambah . '0';
        }
        $b = $tambah . $b;
      }

      $data['sys'] = "$a";
      $data['dias'] = "$b";
      $data['detaknadi'] = "$c";
      $data['tekanandarah'] = $a . ' / ' . $b;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionParamedis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 10;
      $models = ParamedisV::model()->findAll($criteria);
      foreach ($models as $item) {
        $arr[] = $item->nama_pegawai; //array(
        //'no_rekam_medik' => $item->no_rekam_medik,
        //'value' => $item->city,
        //'label' => $item->city . ' (' . $item->province . ')',
        //);
      }

      echo CJSON::encode($arr);
    }
    Yii::app()->end();
  }


  public function actionIndexPemeriksaanFisik($pendaftaran_id)
  {
    //            $result = $this->xmlParser();

    //        if(isset($_GET['frame']))
    //        {
    //            $this->layout = '//layouts/iframe';
    //        }
    $format = new MyFormatter();
    $modPendaftaran = PPPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    //$modRJMetodeGSCM = RJMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_singkatan,metodegcs_nilai DESC');
    $modRJMetodeGSCM = PPMetodeGCSM::model()->findAll('metodegcs_aktif=TRUE ORDER BY metodegcs_id');
    $cekPemeriksaanFisik = PPPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (!empty($cekPemeriksaanFisik)) {  //Jika Pasien Sudah Melakukan Pemeriksaan Fisik  Sebelumnya
      $modPemeriksaanFisik = $cekPemeriksaanFisik;
      $modPemeriksaanFisik->update_time = date('Y-m-d H:i:s');
      $modPemeriksaanFisik->update_loginpemakai_id = Yii::app()->user->id;
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modPemeriksaanFisik->paramedis_nama = $pegawai->nama_pegawai;
    } else {  //Jika Pasien Belum Pernah melakukan Pemeriksaan Fisik
      $modPemeriksaanFisik = new PPPemeriksaanFisikT;
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modPemeriksaanFisik->paramedis_nama = $pegawai->nama_pegawai;
      $modPemeriksaanFisik->pegawai_id = $modPendaftaran->pegawai_id;
      $modPemeriksaanFisik->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modPemeriksaanFisik->pasien_id = $modPasien->pasien_id;
      $modPemeriksaanFisik->tglperiksafisik = date('Y-m-d H:i:s');
      $modPemeriksaanFisik->create_time = date('Y-m-d H:i:s');
      $modPemeriksaanFisik->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPemeriksaanFisik->create_loginpemakai_id = Yii::app()->user->id;
    }
    //            $modPemeriksaanFisik->td_diastolic = $result[2];
    //            $modPemeriksaanFisik->td_systolic = $result[1];
    //            $modPemeriksaanFisik->detaknadi = $result[3];
    //            
    //            $modPemeriksaanFisik->tekanandarah = $this->panjangText($modPemeriksaanFisik->td_diastolic, $modPemeriksaanFisik->td_systolic);;
    //            echo $modPemeriksaanFisik->tekanandarah;exit();
    if (isset($_POST['PPPemeriksaanFisikT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPemeriksaanFisik->attributes = $_POST['PPPemeriksaanFisikT'];
        $modPemeriksaanFisik->keadaanumum = isset($_POST['PPPemeriksaanFisikT']['keadaanumum']) ? ((count((array)$_POST['PPPemeriksaanFisikT']['keadaanumum']) > 0) ? implode(', ', $_POST['PPPemeriksaanFisikT']['keadaanumum']) : '') : '';
        $modPemeriksaanFisik->tglperiksafisik = $format->formatDateTimeForDb($_POST['PPPemeriksaanFisikT']['tglperiksafisik']);

        if ($modPemeriksaanFisik->validate()) {
          if ($modPemeriksaanFisik->save()) {
            $updateStatusPeriksa = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Anamnesa berhasil disimpan");
            $this->redirect($_POST['url']);
          } else {
            echo "gagal Simpan";
            exit;
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Pemeriksaan Fisik gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $modPemeriksaanFisik->tglperiksafisik = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modPemeriksaanFisik->tglperiksafisik, 'yyyy-MM-dd hh:mm:ss')
    );

    $this->render($this->path_view . 'indexPemeriksaanFisik', array(
      'modPasien' => $modPasien,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'modPendaftaran' => $modPendaftaran,
      'modRJMetodeGSCM' => $modRJMetodeGSCM, 'frame' => true
    ));
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintPemeriksaanFisik($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPemeriksaanFisik = PPPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $jumlah = 0;
    $hasil = null;
    $gcs_eye = $modPemeriksaanFisik->gcs_eye;
    $gcs_motorik = $modPemeriksaanFisik->gcs_motorik;
    $gcs_verbal = $modPemeriksaanFisik->gcs_verbal;

    $jumlah = $gcs_eye + $gcs_motorik + $gcs_verbal;
    $namaGCS = GcsM::model()->find('' . $jumlah . '>=gcs_nilaimin AND ' . $jumlah . '<=gcs_nilaimax AND gcs_aktif=TRUE');
    if (!empty($namaGCS)) { //Jika Nilai GCSnya ada
      $hasil = $namaGCS->gcs_nama;
    } else {
      $hasil = 'Nilai GCS Tidak Ditemukan';
    }

    $judul_print = 'PEMERIKSAAN FISIK';
    $this->render($this->path_view . 'printPemeriksaanFisik', array(
      'format' => $format,
      'hasil' => $hasil,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
    ));
  }

  public function actionMasterKeluhan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(keluhananamnesis_nama)', strtolower($_GET['tag']), true);
      $keluhans = KeluhananamnesisM::model()->findAll($criteria);
      $data = array();
      foreach ($keluhans as $i => $keluhan) {
        $data[$i] = array(
          'key' => $keluhan->keluhananamnesis_nama,
          'value' => $keluhan->keluhananamnesis_nama
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
}

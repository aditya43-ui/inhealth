<?php

class TreadmillController extends MyAuthController
{
  public $successsavetreadmill = false;
  public $successsavetreadmilldetail = true; // looping

  public function actionIndex($id = null)
  {
    $modTreadmill = new RJTreadmillT();
    $modTreadmillDetail = new RJTreadmilldetailT();

    if (!empty($id)) {
      $modTreadmill = RJTreadmillT::model()->findByPk($id);
      $modTreadmillDetail = RJTreadmilldetailT::model()->findAllByAttributes(array('treadmill_id' => $id));
    }

    if (isset($_POST['RJTreadmillT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPendaftaran = RJPendaftaranT::model()->findByPk($_POST['RJTreadmillT']['pendaftaran_id']);
        $modTreadmill = $this->simpanTreadmill($modPendaftaran, $modTreadmill, $_POST['RJTreadmillT']);
        if (isset($_POST['RJTreadmilldetailT']) && count((array)$_POST['RJTreadmilldetailT']) > 0) {
          if (!empty($_POST['RJTreadmillT']['treadmill_id'])) {
            $modTreadmillDetail->deleteAllByAttributes(array('treadmill_id' => $_POST['RJTreadmillT']['treadmill_id']));
          }
          foreach ($_POST['RJTreadmilldetailT'] as $i => $details) {
            $modDetails[$i] = $this->simpanTreadmillDetail($_POST['RJTreadmilldetailT'], $details, $modTreadmill);
          }
        }
        if ($this->successsavetreadmill && $this->successsavetreadmilldetail) {
          $transaction->commit();
          $this->redirect(array('index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'id' => $modTreadmill->treadmill_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Treadmill gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'modTreadmill' => $modTreadmill,
      'modTreadmillDetail' => $modTreadmillDetail

    ));
  }

  public function simpanTreadmill($modPendaftaran, $post, $modTreadmill)
  {
    $format = new MyFormatter();
    if (!empty($_POST['RJTreadmillT']['treadmill_id'])) {
      $modTreadmill = RJTreadmillT::model()->findByPk($_POST['RJTreadmillT']['treadmill_id']);
      $modTreadmill->update_time = date('Y-m-d H:i:s');
      $modTreadmill->update_loginpemakai_id = Yii::app()->user->getState('ruangan_id');
    } else {
      $modTreadmill = new RJTreadmillT;
    }
    $modTreadmill->attributes = $_POST['RJTreadmillT'];
    $modTreadmill->pasien_id = $modPendaftaran->pasien_id;
    $modTreadmill->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTreadmill->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTreadmill->pegawai_id = $modPendaftaran->pegawai_id;
    $modTreadmill->tgltreadmill = date('Y-m-d H:i:s');
    $modTreadmill->create_time = date('Y-m-d H:i:s');
    $modTreadmill->create_loginpemakai_id = Yii::app()->user->id;
    $modTreadmill->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTreadmill->resttime_menit = !empty($_POST['RJTreadmillT']['resttime_menit']) ? $_POST['RJTreadmillT']['resttime_menit'] : 0;
    $modTreadmill->worktime_menit = !empty($_POST['RJTreadmillT']['worktime_menit']) ? $_POST['RJTreadmillT']['worktime_menit'] : 0;
    $modTreadmill->recoverytime_menit = !empty($_POST['RJTreadmillT']['recoverytime_menit']) ? $_POST['RJTreadmillT']['recoverytime_menit'] : 0;
    $modTreadmill->totaltime_menit = !empty($_POST['RJTreadmillT']['totaltime_menit']) ? $_POST['RJTreadmillT']['totaltime_menit'] : 0;

    if ($modTreadmill->validate()) {
      $modTreadmill->save();
      $this->successsavetreadmill = true;
    }
    return $modTreadmill;
  }

  protected function simpanTreadmillDetail($postTreadmillDetail, $details, $postTreadmill)
  {

    $format = new MyFormatter;
    $modTreadmillDetail = new RJTreadmilldetailT;
    $modTreadmillDetail->attributes = $details;
    $modTreadmillDetail->treadmill_id = $postTreadmill->treadmill_id;

    if ($modTreadmillDetail->validate()) {
      $modTreadmillDetail->save();
      $this->successsavetreadmilldetail = true;
    } else {
      $this->successsavetreadmilldetail = false;
    }
    return $modTreadmillDetail;
  }

  public function actionSetPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = "";
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $modKunjungan = RJInfokunjunganrjV::model()->findByAttributes(array('pasien_id' => $pasien_id));
      $modKunjungan->tgl_pendaftaran = MyFormatter::formatDateTimeId($modKunjungan->tgl_pendaftaran);
      $modKunjungan->tanggal_lahir = MyFormatter::formatDateTimeId($modKunjungan->tanggal_lahir);
      $modKunjungan->golongandarah = !empty($modKunjungan->golongandarah) ? $modKunjungan->golongandarah : ' - ';
      $modKunjungan->nama_bin = !empty($modKunjungan->nama_bin) ? $modKunjungan->nama_bin : ' - ';

      $modTreadmill = RJTreadmillT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'treadmill_id DESC'));
      if (!empty($modTreadmill)) {
        $modTreadmillDetail = RJTreadmilldetailT::model()->findAllByAttributes(array('treadmill_id' => $modTreadmill->treadmill_id));
        foreach ($modTreadmillDetail as $key => $treadmillDetail) {
          $form .= $this->renderPartial('_rowTreadmill', array('modTreadmillDetail' => $treadmillDetail), true);
        }
      } else {
        $modTreadmill = null;
        $modTreadmillDetail = null;
      }

      echo CJSON::encode(array('modKunjungan' => $modKunjungan, 'modTreadmill' => $modTreadmill, 'modTreadmillDetail' => $modTreadmillDetail, 'form' => $form));
    }
    Yii::app()->end();
  }

  public function actionSetFormTreadmill()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $duration = isset($_POST['duration']) ? $_POST['duration'] : null;
      $td_systolic = isset($_POST['td_systolic']) ? $_POST['td_systolic'] : null;
      $td_diastolic = isset($_POST['td_diastolic']) ? $_POST['td_diastolic'] : null;
      $heart_rate = isset($_POST['heart_rate']) ? $_POST['heart_rate'] : null;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modKlasifikasi = KlasifikasifitnesM::model()->findByPk($duration);
      $modTreadmillDetail = new RJTreadmilldetailT;
      if (!empty($duration)) {
        $modTreadmillDetail->duration_treadmill = $modKlasifikasi->lama_menit;
        $modTreadmillDetail->age_elev = $modKlasifikasi->age_elev;
        $modTreadmillDetail->workload_kph = $modKlasifikasi->workload_kph;
        $modTreadmillDetail->est02_rate_min = $modKlasifikasi->estimasirate;
        $modTreadmillDetail->max02_intake = $modKlasifikasi->max_intake;
        $modTreadmillDetail->mets_treadmill = $modKlasifikasi->mets;
        $modTreadmillDetail->fitnessclassification = $modKlasifikasi->klasifikasifitnes;
        $modTreadmillDetail->functional_class_treadmill = $modKlasifikasi->functional_class;
        $modTreadmillDetail->walking_kmhr_treadmill = $modKlasifikasi->walking_kmhr;
        $modTreadmillDetail->jogging_kmhr_treadmill = $modKlasifikasi->jogging_kmhr;
        $modTreadmillDetail->bicycling_kmhr_treadmill = $modKlasifikasi->bicycling_kmhr;
        $modTreadmillDetail->sports_kmhr_treadmill = $modKlasifikasi->other_sports;
        $modTreadmillDetail->td_systolic = $td_systolic;
        $modTreadmillDetail->td_diastolic = $td_diastolic;
        $modTreadmillDetail->heartrate_treadmill = $heart_rate;
        $form .= $this->renderPartial('_rowTreadmill', array('modTreadmillDetail' => $modTreadmillDetail), true);
      } else {
        $pesan = "Data Treadmill tidak ditemukan!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionAutocompletePemeriksa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 10;
      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $item) {
        $arr[] = $item->NamaLengkap;
      }

      echo CJSON::encode($arr);
    }
    Yii::app()->end();
  }

  public function actionPrint($treadmill_id, $pendaftaran_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modTreadmill = RJTreadmillT::model()->findByPk($treadmill_id);
    $modTreadmillDetail = RJTreadmilldetailT::model()->findAllByAttributes(array('treadmill_id' => $treadmill_id));
    $modPendaftaran = RJPendaftaranT::model()->findByPk($modTreadmill->pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $judul_print = 'TREADMILL EXCERCISE TEST (' . $modTreadmill->pasien->jeniskelamin . ')';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else if ($caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/iframeNeon';
    }

    $this->render('Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modTreadmill' => $modTreadmill,
      'modTreadmillDetail' => $modTreadmillDetail,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'caraPrint' => $caraPrint
    ));
  }

  public function actionGrafik($treadmill_id, $pendaftaran_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframeNeon';
    $format = new MyFormatter;
    $modTreadmill = RJTreadmillT::model()->findByPk($treadmill_id);
    $modTreadmillDetail = RJTreadmilldetailT::model()->findAllByAttributes(array('treadmill_id' => $treadmill_id), array('order' => 'treadmilldetail_id asc'));
    $modTreadmillDetailMax = RJTreadmilldetailT::model()->findByAttributes(array('treadmill_id' => $treadmill_id), array('order' => 'treadmilldetail_id desc'));
    $modPendaftaran = RJPendaftaranT::model()->findByPk($modTreadmill->pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $judul_print = 'TREADMILL EXCERCISE TEST (' . $modTreadmill->pasien->jeniskelamin . ')';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if ($caraPrint == 'PRINT' || $caraPrint == "GRAFIK") {
      $this->layout = '//layouts/printWindows';
      $this->render('PrintDiagram', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modTreadmill' => $modTreadmill,
        'modTreadmillDetail' => $modTreadmillDetail,
        'modPasien' => $modPasien,
        'modPendaftaran' => $modPendaftaran,
        'caraPrint' => $caraPrint,
        'type' => $type,
        'modTreadmillDetailMax' => $modTreadmillDetailMax
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('PrintDiagram', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modTreadmill' => $modTreadmill,
        'modTreadmillDetail' => $modTreadmillDetail,
        'modPasien' => $modPasien,
        'modPendaftaran' => $modPendaftaran,
        'caraPrint' => $caraPrint,
        'type' => $type,
        'modTreadmillDetailMax' => $modTreadmillDetailMax
      ));
    } else {
      $this->render('Diagram', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modTreadmill' => $modTreadmill,
        'modTreadmillDetail' => $modTreadmillDetail,
        'modPasien' => $modPasien,
        'modPendaftaran' => $modPendaftaran,
        'caraPrint' => $caraPrint,
        'modTreadmillDetailMax' => $modTreadmillDetailMax
      ));
    }
  }
}

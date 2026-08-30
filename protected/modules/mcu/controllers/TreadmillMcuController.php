<?php
Yii::import('rawatJalan.models.*');
class TreadmillMcuController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $treadmilltersimpan = false;
  public $treadmilldetailtersimpan = false;
  protected $path_view = 'mcu.views.treadmillMcu.';

  public function actionIndex($pendaftaran_id, $id = null)
  {
    $format = new MyFormatter();
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id =' . $pendaftaran_id);
    $criteria->order = 'treadmill_id DESC';
    $modTreadmilRiwayat = MCTreadmillT::model()->find($criteria);
    //$modTreadmilRiwayat->tgltreadmill = date('Y-m-d H:i:s');
    if (isset($pendaftaran_id)) {
      $modTreadmilRiwayat = MCTreadmillT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $modPendaftaran->pegawai_id));
    }

    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTreadmill = new MCTreadmillT;
    $modTreadmillDetail = new MCTreadmilldetailT;
    $modDetails = array();

    if (!empty($id)) {
      $modTreadmill = MCTreadmillT::model()->findByPk($id);
    }


    if (isset($_POST['MCTreadmillT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modTreadmill = $this->simpanTreadmill($modPendaftaran, $modTreadmill, $_POST['MCTreadmillT']);
        if (isset($_POST['MCTreadmilldetailT']) && count((array)$_POST['MCTreadmilldetailT']) > 0) {
          foreach ($_POST['MCTreadmilldetailT'] as $i => $details) {
            $modDetails[$i] = $this->simpanTreadmillDetail($_POST['MCTreadmilldetailT'], $details, $modTreadmill);
          }
        } else {
          $this->treadmilldetailtersimpan = true;
        }

        if ($this->treadmilltersimpan && $this->treadmilldetailtersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'id' => $modTreadmill->treadmill_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Treadmill gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data Treadmill gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modTreadmill' => $modTreadmill,
      'modTreadmillDetail' => $modTreadmillDetail,
      'modTreadmilRiwayat' => $modTreadmilRiwayat,
      'format' => $format,
      'modPegawai' => $modPegawai
    ));
  }

  public function actionDetail($id)
  {
    $this->layout = "//layouts/iframe";
    $modTreadmill = MCTreadmillT::model()->findByPk($id);
    $modTreadmillDetail = MCTreadmilldetailT::model()->findByAttributes(array('treadmill_id' => $modTreadmill->treadmill_id));

    $this->render($this->path_view . 'detail', array(
      'modTreadmill' => $modTreadmill,
      'modTreadmillDetail' => $modTreadmillDetail,
    ));
  }

  public function actionUpdate($id)
  {
    $this->layout = "//layouts/iframe";
    $modTreadmilRiwayat = MCTreadmillT::model()->findByPk($id);
    $modTreadmill = MCTreadmillT::model()->findByPk($id);
    $modTreadmillDetail = MCTreadmilldetailT::model()->findByAttributes(array('treadmill_id' => $modTreadmill->treadmill_id));

    // if (!empty($model->pengetahui_id)) {
    //     $modPegawai = PegawaiM::model()->findByPk($model->pengetahui_id);

    //     $model->mengetahui_nama = $modPegawai->namaLengkap;
    // }

    if (isset($_POST['MCTreadmillT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = MCTreadmillT::model()->findByPk($id);
        $model->attributes = $_POST['MCTreadmillT'];
        //$model->spirometri_tgl = $format->formatDateTimeForDb($_POST['MCTreadmillT']['treadmill_id']);
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;

        if ($model->update()) {
          $ok = true;
        } else {
          $ok = false;
        }
        if ($ok == true) {

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil diubah");
          $this->redirect(array('update', 'id' => $model->treadmill_id, 'sukses' => 1));
          // die();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Treadmill gagal diubah !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Treadmill gagal diubah ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render($this->path_view . 'ubah/_formUbah', array(
      'modTreadmilRiwayat' => $modTreadmilRiwayat,
      'modTreadmill' => $modTreadmill,
      'modTreadmillDetail' => $modTreadmillDetail,
      //'modPegawai'=>$modPegawai,

    ));
  }

  public function actionSetDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $treadmill_id = isset($_POST['id']) ? $_POST['id'] : " ";
      $model = MCTreadmillT::model()->findByPk($treadmill_id);

      if ($model->delete()) {
        $data['status'] = true;
        $data['pesan'] = 'data treadmil berhasil dihapus !!';
      } else {
        $data['status'] = false;
        $data['pesan'] = 'data treadmil gagal dihapus !!';
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan obat
   * @return row table 
   */
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
      $modTreadmillDetail = new MCTreadmilldetailT;
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
        $form .= $this->renderPartial($this->path_view . '_rowTreadmill', array('modTreadmillDetail' => $modTreadmillDetail), true);
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
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $item) {
        $arr[] = $item->NamaLengkap;
      }

      echo CJSON::encode($arr);
    }
    Yii::app()->end();
  }

  /**
   * proses simpan data treadmill
   * @param type $model
   * @param type $post
   * @return type
   */
  public function simpanTreadmill($modPendaftaran, $post, $modTreadmill)
  {
    $format = new MyFormatter();
    $modTreadmill = new MCTreadmillT;
    $modTreadmill->attributes = $_POST['MCTreadmillT'];
    $modTreadmill->pasien_id = $modPendaftaran->pasien_id;
    $modTreadmill->ruangan_id = $modPendaftaran->ruangan_id;
    $modTreadmill->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTreadmill->pegawai_id = $modPendaftaran->pegawai_id;
    $modTreadmill->tgltreadmill = date('Y-m-d H:i:s');
    $modTreadmill->create_time = date('Y-m-d H:i:s');
    $modTreadmill->create_loginpemakai_id = Yii::app()->user->id;
    $modTreadmill->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTreadmill->resttime_menit = !empty($_POST['MCTreadmillT']['resttime_menit']) ? $_POST['MCTreadmillT']['resttime_menit'] : 0;
    $modTreadmill->worktime_menit = !empty($_POST['MCTreadmillT']['worktime_menit']) ? $_POST['MCTreadmillT']['worktime_menit'] : 0;
    $modTreadmill->recoverytime_menit = !empty($_POST['MCTreadmillT']['recoverytime_menit']) ? $_POST['MCTreadmillT']['recoverytime_menit'] : 0;
    $modTreadmill->totaltime_menit = !empty($_POST['MCTreadmillT']['totaltime_menit']) ? $_POST['MCTreadmillT']['totaltime_menit'] : 0;

    if ($modTreadmill->validate()) {
      $modTreadmill->save();
      $this->treadmilltersimpan = true;
    }

    return $modTreadmill;
  }

  /**
   * simpan TreadmilldetailT
   * @param type $model
   * @param type $postKacamata
   * @return \TreadmilldetailT
   */
  protected function simpanTreadmillDetail($postTreadmillDetail, $details, $postTreadmill)
  {

    $format = new MyFormatter;
    $modTreadmillDetail = new MCTreadmilldetailT;
    $modTreadmillDetail->attributes = $details;
    $modTreadmillDetail->treadmill_id = $postTreadmill->treadmill_id;

    if ($modTreadmillDetail->validate()) {
      $modTreadmillDetail->save();
      $this->treadmilldetailtersimpan = true;
    } else {
      $this->treadmilldetailtersimpan = false;
    }
    return $modTreadmillDetail;
  }

  /**
   * untuk print data treadmill
   */
  public function actionPrint($treadmill_id, $pendaftaran_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modTreadmill = MCTreadmillT::model()->findByPk($treadmill_id);
    $modTreadmillDetail = MCTreadmilldetailT::model()->findAllByAttributes(array('treadmill_id' => $treadmill_id));
    $modPendaftaran = MCPendaftaranT::model()->findByPk($modTreadmill->pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $judul_print = 'TREADMILL EXCERCISE TEST (' . $modTreadmill->pasien->jeniskelamin . ')';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else if ($caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/iframeNeon';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modTreadmill' => $modTreadmill,
      'modTreadmillDetail' => $modTreadmillDetail,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'caraPrint' => $caraPrint
    ));
  }

  /**
   * untuk print data treadmill
   */
  public function actionGrafik($treadmill_id, $pendaftaran_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframeNeon';
    $format = new MyFormatter;
    $modTreadmill = MCTreadmillT::model()->findByPk($treadmill_id);
    $modTreadmillDetail = MCTreadmilldetailT::model()->findAllByAttributes(array('treadmill_id' => $treadmill_id), array('order' => 'treadmilldetail_id asc'));
    $modTreadmillDetailMax = MCTreadmilldetailT::model()->findByAttributes(array('treadmill_id' => $treadmill_id), array('order' => 'treadmilldetail_id desc'));
    $modPendaftaran = MCPendaftaranT::model()->findByPk($modTreadmill->pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $judul_print = 'TREADMILL EXCERCISE TEST (' . $modTreadmill->pasien->jeniskelamin . ')';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if ($caraPrint == 'PRINT' || $caraPrint == "GRAFIK") {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'PrintDiagram', array(
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
      $this->render($this->path_view . 'PrintDiagram', array(
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
      $this->render($this->path_view . 'Diagram', array(
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

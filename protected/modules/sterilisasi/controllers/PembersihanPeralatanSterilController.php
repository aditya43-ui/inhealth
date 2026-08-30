<?php

/**
 *   - digunakan sebagai url utama untuk mengelola transaksi Pembersihan Peralatan Sterilisasi
 *   @author	Rusdiyanto <rusdiyanto@.com>
 *   @website	<.com>
 */
class PembersihanPeralatanSterilController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sterilisasi.views.pembersihanPeralatanSteril.';

  public function actionIndex($dekontaminasi_id, $pembersihan_id = null)
  {
    $format = new MyFormatter();
    $modInspeksiinstrument = new InspeksiinstrumenT();
    $modPembersihan = new STPembersihanT();
    $modPembersihan->no_pembersihan = '-- Otomatis --';
    $modPembersihan->tgl_pembersihan = date('Y-m-d H:i:s');
    $modPenerimaanSterilDetail = array();
    $modDekontaminasiDetail = array();
    $modPenerimaanSteril = new PenerimaansterilisasiT();

    if (!empty($pembersihan_id)) {
      $modPembersihan = STPembersihanT::model()->findByPk($pembersihan_id);
    }

    if (isset($dekontaminasi_id)) {
      $modDekontaminasi = STDekontaminasiT::model()->findByPk($dekontaminasi_id);
      if (isset($modDekontaminasi)) {
        $modDekontaminasiDetail = STDekontaminasidetailT::model()->findAllByAttributes(array('dekontaminasi_id' => $modDekontaminasi->dekontaminasi_id));
        if (count((array)$modDekontaminasiDetail) > 0) {
          foreach ($modDekontaminasiDetail as $modDekontaminasi) {
            $penerimaansterilisasi_id = $modDekontaminasi->penerimaansterilisasi_id;
          }
          $modPenerimaanSteril = PenerimaansterilisasiT::model()->findByPk($penerimaansterilisasi_id);

          if (isset($modPenerimaanSteril)) {
            $modPenerimaanSterilDetail = STPenerimaansterilisasidetT::model()->findAllByAttributes(array('penerimaansterilisasi_id' => $modPenerimaanSteril->penerimaansterilisasi_id));
          }
        }
      }
    }

    if (isset($_POST['STPembersihanT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modPembersihan->attributes = $_POST['STPembersihanT'];
        $modPembersihan->tgl_pembersihan = $format->formatDateTimeForDb($_POST['STPembersihanT']['tgl_pembersihan']);
        $modPembersihan->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $modPembersihan->dekontaminasi_id = $dekontaminasi_id;
        $modPembersihan->no_pembersihan = MyGenerator::noPembersihan();
        $modPembersihan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPembersihan->create_time = date('Y-m-d H:i:s');
        $modPembersihan->statuspembersihan = Params::STATUSPEMBERSIHAN_MULAI;

        $ok = $ok && $modPembersihan->save();
        if ($ok) {

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data " . $modPembersihan->no_pembersihan . " Berhasil Disimpan");
          $this->redirect(array('index', 'dekontaminasi_id' => $dekontaminasi_id, 'pembersihan_id' => $modPembersihan->pembersihan_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modPembersihan));
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Pembersihan Sterilisasi gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modInspeksiinstrument' => $modInspeksiinstrument,
      'modPembersihan' => $modPembersihan,
      'modDekontaminasi' => $modDekontaminasi,
      'modDekontaminasiDetail' => $modDekontaminasiDetail,
      'modPenerimaanSterilDetail' => $modPenerimaanSterilDetail,
      'modPenerimaanSteril' => $modPenerimaanSteril
    ));
  }

  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Pembersihan";
    $model = new STPembersihanT();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $format = new MyFormatter();

    if (isset($_GET['STPembersihanT'])) {
      $model->attributes = $_GET['STPembersihanT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['STPembersihanT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['STPembersihanT']['tgl_akhir']);
    }

    $this->render($this->path_view . 'informasi/_table', array(
      'model' => $model,
      'format' => $format
    ));
  }

  public function actionSetStatusPembersihan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pembersihan_id = isset($_POST['pembersihan_id']) ? $_POST['pembersihan_id'] : null;
      $modPembersihan = PembersihanT::model()->findByPk($pembersihan_id);
      if (!empty($modPembersihan) && $modPembersihan->statuspembersihan == Params::STATUSPEMBERSIHAN_MULAI) {
        $modPembersihan->statuspembersihan = Params::STATUSPEMBERSIHAN_SEDANGCUCI;
        $modPembersihan->mulaipembersiha = date('Y-m-d H:i:s');
        $modPembersihan->update();
        $data['status'] = true;
      } else {
        $data['status'] = false;
        $data['pesan'] = 'Update Gagal Di Lakukan !';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetCuciUlang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pembersihan_id = isset($_POST['pembersihan_id']) ? $_POST['pembersihan_id'] : null;
      $modPembersihan = STPembersihanT::model()->findByPk($pembersihan_id);
      if (!empty($modPembersihan)) {
        $modPembersihan->iscuciulang = true;
        $modPembersihan->update();
        $data['status'] = true;
      } else {
        $data['status'] = false;
        $data['pesan'] = 'Update Gagal Di Lakukan !';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionUpdatePembersihan()
  {

    $model = new PembersihanT;

    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");

    if (isset($_POST['PembersihanT'])) {

      if ($_POST['PembersihanT']['pembersihan_id'] != "") {
        $modUpdate = STPembersihanT::model()->findByPk($_POST['PembersihanT']['pembersihan_id']);
        $modUpdate->ind_visual = $_POST['PembersihanT']['ind_visual'];
        $modUpdate->ind_kimia = $_POST['PembersihanT']['ind_kimia'];
        $modUpdate->ind_protein = $_POST['PembersihanT']['ind_protein'];
        $modUpdate->ind_character = $_POST['PembersihanT']['ind_character'];
        $modUpdate->selesaipembersihan = MyFormatter::formatDateTimeForDb($_POST['PembersihanT']['selesaipembersihan']);
        $modUpdate->statuspembersihan = Params::STATUSPEMBERSIHAN_SELESAI;
        $modUpdate->update_time = date('Y-m-d H:i:s');
        $modUpdate->update_loginpemakai_id = Yii::app()->user->id;
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modUpdate->save()) {
            $transaction->commit();

            echo CJSON::encode(
              array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data berhasil disimpan.</div>",
                'msg' => 'Data berhasil disimpan.',
                'ok' => 1,
              )
            );
          } else {
            $transaction->rollback();
            echo CJSON::encode(
              array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
                'msg' => 'Data gagal disimpan.',
                'ok' => 0,
              )
            );
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
          echo CJSON::encode(
            array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
              'msg' => 'Data gagal disimpan.',
              'ok' => 0,
            )
          );
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            'msg' => 'Data gagal disimpan.',
            'ok' => 0,
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      $pembersihan_id = (isset($_POST['id']) ? $_POST['id'] : '');
      $model->selesaipembersihan = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'div' => $this->renderPartial($this->path_view . 'informasi/_formUpdate', array('model' => $model, 'menu' => $menu, 'pembersihan_id' => $pembersihan_id), true)
        )
      );
      Yii::app()->end();
    }
  }

  public function actionDetail($pembersihan_id = null)
  {
    $this->layout = 'iframe';
    $format = new MyFormatter();
    $model = STPembersihanT::model()->findByPk($pembersihan_id);
    $judulLaporan = 'Pembersihan Sterilisasi';
    $deskripsi = $format->formatDateTimeForUser($model->tgl_pembersihan);
    $this->render($this->path_view . 'informasi/_detail', array(
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi
    ));
  }

  public function actionCuciUlang($pembersihan_id)
  {

    $format = new MyFormatter();
    $modPembersihan = new STPembersihanT();
    $modPembersihan->tgl_pembersihan = date('Y-m-d H:i:s');


    $modPembersihan->no_pembersihan = '-- Otomatis --';

    $modPenerimaanSterilDetail = array();
    $dekontaminasi_id = STPembersihanT::model()->findByAttributes(array('pembersihan_id' => $pembersihan_id))->dekontaminasi_id;
    if (isset($dekontaminasi_id)) {
      $modDekontaminasi = STDekontaminasiT::model()->findByPk($dekontaminasi_id);
      if (isset($modDekontaminasi)) {
        $modDekontaminasiDetail = STDekontaminasidetailT::model()->findAllByAttributes(array('dekontaminasi_id' => $modDekontaminasi->dekontaminasi_id));
        if (count((array)$modDekontaminasiDetail) > 0) {
          foreach ($modDekontaminasiDetail as $modDekontaminasi) {
            $penerimaansterilisasi_id = $modDekontaminasi->penerimaansterilisasi_id;
          }
          $modPenerimaanSteril = PenerimaansterilisasiT::model()->findByPk($penerimaansterilisasi_id);

          if (isset($modPenerimaanSteril)) {
            $modPenerimaanSterilDetail = STPenerimaansterilisasidetT::model()->findAllByAttributes(array('penerimaansterilisasi_id' => $modPenerimaanSteril->penerimaansterilisasi_id));
          }
        }
      }
    }

    if (isset($_POST['STPembersihanT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modPembersihan->attributes = $_POST['STPembersihanT'];
        $modPembersihan->tgl_pembersihan = $format->formatDateTimeForDb($_POST['STPembersihanT']['tgl_pembersihan']);
        $modPembersihan->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $modPembersihan->dekontaminasi_id = $dekontaminasi_id;

        $modPembersihan->no_pembersihan = MyGenerator::noPembersihan();

        $modPembersihan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modPembersihan->create_time = date('Y-m-d H:i:s');
        $modPembersihan->statuspembersihan = Params::STATUSPEMBERSIHAN_MULAI;
        $ok = $ok && $modPembersihan->save();
        if ($ok) {
          /* proses update ke data pencucian sebelumnya */
          $updatePembersihanSebelumnya = STPembersihanT::model()->findByPk($pembersihan_id);
          $updatePembersihanSebelumnya->iscuciulang = true;
          $updatePembersihanSebelumnya->cuciulang_id = $modPembersihan->pembersihan_id;
          $updatePembersihanSebelumnya->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $updatePembersihanSebelumnya->update_time = date('Y-m-d H:i:s');


          $updatePembersihanSebelumnya->statuspembersihan = Params::STATUSPEMBERSIHAN_CUCIULANG;

          $updatePembersihanSebelumnya->update();
          /* end */
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan");
          $this->redirect(array('cuciUlang', 'pembersihan_id' => $modPembersihan->pembersihan_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($modPembersihan));
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Pembersihan Sterilisasi gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }
    $this->render($this->path_view . 'cuciUlang/formCuciUlang', array(
      'modPembersihan' => $modPembersihan,
      'format' => $format,
      'pembersihan_id' => $pembersihan_id,
      'modDekontaminasi' => $modDekontaminasi,
      'modDekontaminasiDetail' => $modDekontaminasiDetail,
      'modPenerimaanSterilDetail' => $modPenerimaanSterilDetail,
      'modPenerimaanSteril' => $modPenerimaanSteril
    ));
  }
}

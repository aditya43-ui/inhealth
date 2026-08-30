<?php

class InformasiVerifikasiBerkasMcuController extends MyAuthController
{
  protected $verifikasiberkastersimpan = true;
  public $path_view = 'keuangan.views.informasiVerifikasiBerkasMcu.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new KUVerifikasiberkasmcuV('searchInformasi');

    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KUVerifikasiberkasmcuV'])) {
      $model->attributes = $_GET['KUVerifikasiberkasmcuV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUVerifikasiberkasmcuV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUVerifikasiberkasmcuV']['tgl_akhir']);
    }

    $this->render('index', array(
      'model' => $model
    ));
  }

  public function actionUbahVerifikasi($verifikasiberkasmcu_id = null)
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $format = new MyFormatter();
    $model = new KUVerifikasiberkasmcuT;

    if (!empty($verifikasiberkasmcu_id)) {
      $model = KUVerifikasiberkasmcuT::model()->findByPk($verifikasiberkasmcu_id);
    }

    if (isset($_POST['KUVerifikasiberkasmcuT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['KUVerifikasiberkasmcuT'];
        $model->tglberkasmcumasuk = $format->formatDateTimeForDb($_POST['KUVerifikasiberkasmcuT']['tglberkasmcumasuk']);

        if ($model->validate()) {
          $model->save();
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Verifikasi Berkas berhasil disimpan");
          $this->redirect(array('ubahVerifikasi', 'verifikasiberkasmcu_id' => $model->verifikasiberkasmcu_id, 'frame' => 1, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Verifikasi Berkas MCU gagal disimpan !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('_formUbahVerifikasi', array(
      'model' => $model
    ));
  }
}

<?php

class CatatanAtasLaporanKeuanganTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $calk = false;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Catatan Atas Laporan Keuangan";
    $format = new MyFormatter;
    $model = new AKCalkT;
    $model->unsetAttributes();  // clear any default values
    $model->calk_tgl = $format->formatDateTimeForUser(date("Y-m-d"), strtotime($model->calk_tgl));

    if (isset($_POST['AKCalkT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['AKCalkT'];
        $model->rekperiod_id = $_POST['AKCalkT']['rekperiod_id'];
        $model->calk_no = $_POST['AKCalkT']['calk_no'];
        $model->calk_tgl = $format->formatDateTimeForDb($_POST['AKCalkT']['calk_tgl']);
        $model->calk_catatan = $_POST['calk_catatan'];
        $model->create_time = date("Y-m-d H:i:s");
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->save()) {
          $this->calk = true;
        }

        if ($this->calk) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data " . $model->calk_no . " berhasil disimpan ");
          $this->redirect(array('index', 'calk_id' => $model->calk_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'model' => $model,
    ));
  }

  /**
   * untuk print data catatan atas laporan keuangan
   */
  public function actionPrint($calk_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modCALK = AKCalkT::model()->findByPk($calk_id);
    $judul_print = 'Catatan Atas Laporan Keuangan';
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
      'modCALK' => $modCALK,
      'caraPrint' => $caraPrint
    ));
  }
}

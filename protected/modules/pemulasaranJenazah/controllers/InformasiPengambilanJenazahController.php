<?php

class InformasiPengambilanJenazahController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pengambilan Jenazah";
    $model = new PJInformasiambiljenazahV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['PJInformasiambiljenazahV'])) {
      $model->attributes = $_GET['PJInformasiambiljenazahV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJInformasiambiljenazahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJInformasiambiljenazahV']['tgl_akhir']);
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function actionPrint($id)
  {
    $format = new MyFormatter();
    $model = PJInformasiambiljenazahV::model()->findByAttributes(array('ambiljenazah_id' => $id));
    $modDetails = PenyerahanbarangpasienT::model()->findAllByAttributes(array('ambiljenazah_id' => $id));

    $judulLaporan = 'Data Pengambilan Jenazah';
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
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'caraPrint' => $caraPrint,
      'modDetails' => $modDetails,
      'format' => $format
    ));
  }
}

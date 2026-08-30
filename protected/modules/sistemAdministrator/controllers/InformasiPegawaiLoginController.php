<?php

class InformasiPegawaiLoginController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.informasiPegawaiLogin.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pegawai Login";
    $model = new SAPegawailoginV("searchInformasi");
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['SAPegawailoginV'])) {
      $model->attributes = $_GET['SAPegawailoginV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['SAPegawailoginV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SAPegawailoginV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'format' => $format
    ));
  }

  public function actionDynamicRuangan()
  {
    $instalasi_id = (isset($_POST['SAPegawailoginV']['instalasi_nama']) ? $_POST['SAPegawailoginV']['instalasi_nama'] : null);
    $criteria = new CDbCriteria;
    $criteria->with = array("instalasi");

    $criteria->compare('instalasi.instalasi_nama', $instalasi_id, true);
    $criteria->addCondition('ruangan_aktif = true');
    $criteria->order = "ruangan_nama";

    $dataList = RuanganM::model()->findAll($criteria);

    $data = CHtml::listData($dataList, 'ruangan_nama', 'ruangan_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
  }

  public function actionPrint($caraPrint)
  {
    $model = new SAPegawailoginV("searchPrintInformasi");
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['SAPegawailoginV'])) {
      $model->attributes = $_GET['SAPegawailoginV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['SAPegawailoginV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SAPegawailoginV']['tgl_akhir']);
    }

    $this->printFunction($model, $caraPrint, "Informasi Pegawai Login", $this->path_view . "print");
  }


  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}

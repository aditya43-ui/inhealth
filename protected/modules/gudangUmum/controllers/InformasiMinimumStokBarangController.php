<?php

class InformasiMinimumStokBarangController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangUmum.views.informasiMinimumStokBarang.';

  public function actionIndex()
  {
    $disabled = true;
    $model = new GUInformasistokbarangV('search');

    $model->unsetAttributes();  // clear any default values
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GUDANG_UMUM) {
      $disabled = false;
    }
    if (isset($_GET['GUInformasistokbarangV'])) {
      $model->attributes = $_GET['GUInformasistokbarangV'];
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'disabled' => $disabled,
    ));
  }

  public function actionPrint()
  {
    $model = new GUInformasistokbarangV;
    $model->unsetAttributes();  // clear any default values
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GUDANG_UMUM) {
      $disabled = false;
    }
    if (isset($_GET['GUInformasistokbarangV'])) {
      $model->attributes = $_GET['GUInformasistokbarangV'];
    }
    $judulLaporan = ' Informasi Minimum Stok barang';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}

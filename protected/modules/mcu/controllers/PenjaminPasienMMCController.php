<?php
Yii::import('sistemAdministrator.controllers.PenjaminPasienMController');
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.views.penjaminPasienM');
class PenjaminPasienMMCController extends PenjaminPasienMController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.penjaminPasienM.';
  public $path_view_penjamin = 'mcu.views.penjaminPasienMMC.';

  public function actionAdmin($id = '')
  {
    $this->pageTitle = Yii::app()->name . " - Perusahaan Penjamin Pasien";
    $model = new SAPenjaminPasienM('searchPenjaminMCU');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPenjaminPasienM']))
      $model->attributes = $_GET['SAPenjaminPasienM'];

    $this->render($this->path_view_penjamin . 'admin', array(
      'model' => $model,
    ));
  }

  public function actionPrint()
  {
    $model = new SAPenjaminPasienM;
    $model->unsetAttributes();
    if (isset($_REQUEST['SAPenjaminPasienM'])) {
      $model->attributes = $_REQUEST['SAPenjaminPasienM'];
    }
    $judulLaporan = 'Laporan Data Penjamin Pasien';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view_penjamin . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view_penjamin . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view_penjamin . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}

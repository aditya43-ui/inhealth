<?php

/**
 * Digunakan untuk modul mcu laporan pemeriksaan fisik pasien
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.mcu
 * @subpackage controllers
 */
class LaporanPemeriksaanFisikPasienController extends MyAuthController
{
  /**
   * digunakan untuk menampilkan laporan pemeriksaan fisik pasien
   */
  public function actionIndex()
  {
    $model = new MCPemeriksaanfisikpasienV('search');
    $model->tgl_awal = date('d M Y', strtotime('first day of this month'));
    $model->tgl_akhir = date("d M Y");
    if (!empty($_GET['MCPemeriksaanfisikpasienV'])) {
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MCPemeriksaanfisikpasienV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MCPemeriksaanfisikpasienV']['tgl_akhir']);
    }
    $this->render('index', array('model' => $model));
  }

  /**
   * Fungsi untuk mendapatkan laporan yang dicari
   */
  public function actionGetLaporan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modLaporan = MCPemeriksaanfisikpasienV::model()->findAll();
      $model = new PersonForm;

      $tr = $this->renderPartial('_detailLaporan', array('model' => $modLaporan), true);
      echo json_encode($tr);
      Yii::app()->end();
    }
  }

  /**
   * digunakan untuk cetak laporan
   */
  public function actionPrint()
  {
    $model = new MCPemeriksaanfisikpasienV('search');

    $format = new MyFormatter();
    $judulLaporan = 'Laporan Pemeriksaan Fisik Pasien';
    if (isset($_REQUEST['MCPemeriksaanfisikpasienV'])) {
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['MCPemeriksaanfisikpasienV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['MCPemeriksaanfisikpasienV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'Print';

    $this->printFunction($model, $caraPrint, $judulLaporan, $target);
  }

  /**
   * Fungsi untuk mencetak laporan
   * @param type $model
   * @param type $caraPrint
   * @param type $judulLaporan
   * @param type $target
   */
  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows3';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $kertas = Params::getUkuranKertas();
      $mpdf = new MyPDF60('', $kertas['F4']);
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 10), true));
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 20, 20, 55, 20, 20);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}

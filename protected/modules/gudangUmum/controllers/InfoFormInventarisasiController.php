<?php
class InfoFormInventarisasiController extends MyAuthController
{
  public $path_view = 'gudangUmum.views.infoFormInventarisasi.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Formulir Inventarisasi Barang";
    $format = new MyFormatter();
    $model = new GUInfoformulirinvbarangV('searchInformasi');

    $model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GUInfoformulirinvbarangV'])) {
      $model->attributes = $_GET['GUInfoformulirinvbarangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInfoformulirinvbarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInfoformulirinvbarangV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'format' => $format
    ));
  }

  /**
   * menampilkan url untuk print karena nama controller tiap modul yg extend berbeda
   * @return type
   */
  public function getUrlPrint()
  {
    return $this->createUrl("FormInventarisasiBarang/Print");
  }
  /**
   * menampilkan url untuk action stock opname karena nama controller tiap modul yg extend berbeda
   * @return type
   */
  public function getUrlInventarisasi()
  {
    return $this->createUrl("InventarisasiBarang/Index");
  }


  public function actionPrint($caraPrint)
  {
    $format = new MyFormatter();
    $model = new GUInfoformulirinvbarangV('searchInformasi');

    $model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GUInfoformulirinvbarangV'])) {
      $model->attributes = $_GET['GUInfoformulirinvbarangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInfoformulirinvbarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInfoformulirinvbarangV']['tgl_akhir']);
    }

    $this->printFunction($model, $caraPrint, "Informasi Formulir Inventarisasi Barang", "print");
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
      //            //$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    } else if ($caraPrint == "CSV") {
      CSV::konversiTabel($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
    }
  }
}

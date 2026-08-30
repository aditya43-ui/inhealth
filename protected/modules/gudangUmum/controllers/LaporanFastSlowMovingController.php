<?php

class LaporanFastSlowMovingController extends Controller
{
  public function actionIndexFast()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Fast Moving";
    $model = new GUInventarisasiruanganT;
    $model->unsetAttributes();
    $model->tgl_awal = $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GUInventarisasiruanganT'])) {
      $model->attributes = $_GET['GUInventarisasiruanganT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_akhir']);
      $model->barang_type = $_GET['GUInventarisasiruanganT']['barang_type'];
    }

    $this->render('indexFast', array(
      'model' => $model,
    ));
  }

  public function actionIndexSlow()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Slow Moving";
    $model = new GUInventarisasiruanganT;
    $model->unsetAttributes();
    $model->tgl_awal = $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GUInventarisasiruanganT'])) {
      $model->attributes = $_GET['GUInventarisasiruanganT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_akhir']);
      $model->barang_type = $_GET['GUInventarisasiruanganT']['barang_type'];
    }

    $this->render('indexSlow', array(
      'model' => $model,
    ));
  }

  public function actionPrintFast()
  {
    $model = new GUInventarisasiruanganT;
    //$model->unsetAttributes();
    $model->tgl_awal = $model->tgl_akhir = date('Y-m-d');

    $judulLaporan = 'Laporan Fast Moving Barang';

    $data['title'] = 'Grafik Fast Moving Barang';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
    if (isset($_GET['GUInventarisasiruanganT'])) {
      $model->attributes = $_GET['GUInventarisasiruanganT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_akhir']);
      $model->barang_type = $_GET['GUInventarisasiruanganT']['barang_type'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'printFast';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintSlow()
  {
    $model = new GUInventarisasiruanganT;
    $model->unsetAttributes();
    $model->tgl_awal = $model->tgl_akhir = date('Y-m-d');

    $judulLaporan = 'Laporan Slow Moving Barang';

    $data['title'] = 'Grafik Slow Moving Barang';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
    if (isset($_GET['GUInventarisasiruanganT'])) {
      $model->attributes = $_GET['GUInventarisasiruanganT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_akhir']);
      $model->barang_type = $_GET['GUInventarisasiruanganT']['barang_type'];
    }


    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'printSlow';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $searchdata = null)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'searchdata' => $searchdata));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
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

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionFrameFast()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();

    $model = new GUInventarisasiruanganT;
    $model->unsetAttributes();
    $model->tgl_awal = $model->tgl_akhir = date('Y-m-d');

    $judulLaporan = 'Laporan Fast Moving Barang';

    $data['title'] = 'Grafik Fast Moving Barang';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
    //$data['type'] = isset($_GET['type'])?$_GET['type']:null;
    if (isset($_REQUEST['GUInventarisasiruanganT'])) {
      $model->attributes = $_GET['GUInventarisasiruanganT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_akhir']);
      $model->barang_type = $_GET['GUInventarisasiruanganT']['barang_type'];
    }

    $searchData = $model->searchGrafikFastMoving();
    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
      'searchdata' => $searchData,
    ));
  }

  public function actionFrameSlow()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();

    $model = new GUInventarisasiruanganT;
    $model->unsetAttributes();
    $model->tgl_awal = $model->tgl_akhir = date('Y-m-d');

    $judulLaporan = 'Laporan Slow Moving Barang';

    $data['title'] = 'Grafik Slow Moving Barang';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
    if (isset($_GET['GUInventarisasiruanganT'])) {
      $model->attributes = $_GET['GUInventarisasiruanganT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_akhir']);
      $model->barang_type = $_GET['GUInventarisasiruanganT']['barang_type'];
    }

    $searchData = $model->searchGrafikSlowMoving();
    $this->render('gudangUmum.views.laporan._grafik', array(
      'model' => $model,
      'data' => $data,
      'searchdata' => $searchData,
    ));
  }
}

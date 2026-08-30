<?php

class LaporanRekapPenerimaanKasHarianIGDController extends MyAuthController
{
  public function actionIndex()
  {
    $model = new BKRekapitulasipenerimaansejenisV('searchPenerimanRD');
    $this->pageTitle = Yii::app()->name . ' - Laporan Laboratorium';
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['BKRekapitulasipenerimaansejenisV'])) {
      $model->attributes = $_GET['BKRekapitulasipenerimaansejenisV'];
      $model->jns_periode = $_GET['BKRekapitulasipenerimaansejenisV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKRekapitulasipenerimaansejenisV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKRekapitulasipenerimaansejenisV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKRekapitulasipenerimaansejenisV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKRekapitulasipenerimaansejenisV']['bln_akhir']);
      $model->thn_awal = $_GET['BKRekapitulasipenerimaansejenisV']['thn_awal'];
      $model->thn_akhir = $_GET['BKRekapitulasipenerimaansejenisV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render('rekapRD/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanIGD()
  {
    $model = new BKRekapitulasipenerimaansejenisV('searchPrintPenerimaanRD');
    $this->pageTitle = Yii::app()->name . ' - Laporan Laboratorium';
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $modDetail = null;
    $modRincian = null;

    if (isset($_GET['BKRekapitulasipenerimaansejenisV'])) {
      $model->attributes = $_GET['BKRekapitulasipenerimaansejenisV'];
      $model->jns_periode = $_GET['BKRekapitulasipenerimaansejenisV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKRekapitulasipenerimaansejenisV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKRekapitulasipenerimaansejenisV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKRekapitulasipenerimaansejenisV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKRekapitulasipenerimaansejenisV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $data = array();
    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekap Penerimaan Kas Harian IGD';
    $judulLaporan = 'Rekapitulasi Penerimaan Kas Harian IGD';
    $rincianUang = array();
    $data['type'] = $_REQUEST['type'];

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'rekapRD/_print';

    $this->printFunction($model, $modDetail, $data, $caraPrint, $judulLaporan, $target, $modRincian, $rincianUang);
  }


  protected function printFunction($model, $modDetail, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $rincianUang = array();
    $modRincian = array();
    $periode = MyFormatter::formatDateTimeForUser($model->tgl_awal) . ' s/d ' . MyFormatter::formatDateTimeForUser($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('modDetail' => $modDetail, 'rincianUang' => $rincianUang, 'model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian' => $modRincian));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('modDetail' => $modDetail, 'rincianUang' => $rincianUang, 'model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian' => $modRincian));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('modDetail' => $modDetail, 'rincianUang' => $rincianUang, 'model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian' => $modRincian), true));
      $mpdf->Output();
    }
  }

  protected function parserTanggal($tgl)
  {
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row) {
      if (!empty($row)) {
        $result[] = $row;
      }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'), 'medium', null) . ' ' . $result[1];
  }
}

<?php
class LaporanPendapatanInstalasiController extends MyAuthController
{
  /*
     * Laporan Pendapatan Instalasi
     */

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pendapatan Instalasi";
    $format = new MyFormatter();
    //$model = new KULaporanrekappendapatanV;
    //$model = new KURinciantagihanpasiensudahbayarV;
    $model = new KUInformasipasiensudahbayarV();

    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month')); //, strtotime('first day of this month');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['KUInformasipasiensudahbayarV'])) {
      $model->attributes = $_GET['KUInformasipasiensudahbayarV'];
      $model->jns_periode = $_GET['KUInformasipasiensudahbayarV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasipasiensudahbayarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasipasiensudahbayarV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KUInformasipasiensudahbayarV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KUInformasipasiensudahbayarV']['bln_akhir']);
      $model->thn_awal = $_GET['KUInformasipasiensudahbayarV']['thn_awal'];
      $model->thn_akhir = $_GET['KUInformasipasiensudahbayarV']['thn_akhir'];
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
      $model->carabayar_id = isset($_GET['KUInformasipasiensudahbayarV']['carabayar_id']) ? $_GET['KUInformasipasiensudahbayarV']['carabayar_id'] : null;
      $model->penjamin_id = isset($_GET['KUInformasipasiensudahbayarV']['penjamin_id']) ? $_GET['KUInformasipasiensudahbayarV']['penjamin_id'] : null;
    }

    $this->render('index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanPendapatanInstalasi()
  {
    $model = new KUInformasipasiensudahbayarV('search');
    $model->tgl_awal = date('Y-m-d'); //, strtotime('first day of this month');
    $model->tgl_akhir = date('Y-m-d ');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'LAPORAN PENDAPATAN INSTALASI';

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN PENDAPATAN INSTALASI';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['KUInformasipasiensudahbayarV'])) {
      $model->attributes = $_REQUEST['KUInformasipasiensudahbayarV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['KUInformasipasiensudahbayarV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasipasiensudahbayarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasipasiensudahbayarV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KUInformasipasiensudahbayarV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KUInformasipasiensudahbayarV']['bln_akhir']);
      $model->thn_awal = $_GET['KUInformasipasiensudahbayarV']['thn_awal'];
      $model->thn_akhir = $_GET['KUInformasipasiensudahbayarV']['thn_akhir'];
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
      $model->carabayar_id = isset($_GET['KUInformasipasiensudahbayarV']['carabayar_id']) ? $_GET['KUInformasipasiensudahbayarV']['carabayar_id'] : null;
      $model->penjamin_id = isset($_GET['KUInformasipasiensudahbayarV']['penjamin_id']) ? $_GET['KUInformasipasiensudahbayarV']['penjamin_id'] : null;
      // $model->ruangan_id = isset($_GET['KULaporanrekappendapatanV']['ruangan_id'])?$_GET['KULaporanrekappendapatanV']['ruangan_id']:null;
      // $model->instalasi_id = isset($_GET['KULaporanrekappendapatanV']['instalasi_id'])?$_GET['KULaporanrekappendapatanV']['instalasi_id']:null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPendapatanInstalasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new KUInformasipasiensudahbayarV('search');
    $model->tgl_awal = date('Y-m-d'); //, strtotime('first day of this month');
    $model->tgl_akhir = date('Y-m-d ');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN PENDAPATA INSTALASI';
    $data['type'] = $_GET['type'];
    if (isset($_GET['KUInformasipasiensudahbayarV'])) {
      $model->attributes = $_GET['KUInformasipasiensudahbayarV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['KUInformasipasiensudahbayarV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasipasiensudahbayarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasipasiensudahbayarV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KUInformasipasiensudahbayarV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KUInformasipasiensudahbayarV']['bln_akhir']);
      $model->thn_awal = $_GET['KUInformasipasiensudahbayarV']['thn_awal'];
      $model->thn_akhir = $_GET['KUInformasipasiensudahbayarV']['thn_akhir'];
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
      $model->carabayar_id = isset($_GET['KUInformasipasiensudahbayarV']['carabayar_id']) ? $_GET['KUInformasipasiensudahbayarV']['carabayar_id'] : null;
      $model->penjamin_id = isset($_GET['KUInformasipasiensudahbayarV']['penjamin_id']) ? $_GET['KUInformasipasiensudahbayarV']['penjamin_id'] : null;
      //$model->ruangan_id = isset($_GET['KULaporanrekappendapatanV']['ruangan_id'])?$_GET['KULaporanrekappendapatanV']['ruangan_id']:null;
      //$model->instalasi_id = isset($_GET['KULaporanrekappendapatanV']['instalasi_id'])?$_GET['KULaporanrekappendapatanV']['instalasi_id']:null;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if (empty($model->tgl_awal)) {
      $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    }
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => $judulLaporan,  'periode' => $periode, 'colspan' => 10), true));
      $mpdf->SetHTMLFooter('{PAGENO}');
      ////$mpdf->useOddEven = 1;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}

<?php

class LaporanFakturPembelianUmumController extends MyAuthController
{
  public $path_view = 'keuangan.views.laporanFakturPembelianUmum.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Faktur Pembelian Umum";
    $model = new KUInformasifakturumumV('searchLaporan');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['KUInformasifakturumumV'])) {
      $model->attributes = $_GET['KUInformasifakturumumV'];
      $model->jns_periode = $_GET['KUInformasifakturumumV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasifakturumumV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasifakturumumV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KUInformasifakturumumV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KUInformasifakturumumV']['bln_akhir']);
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
      $model->filter = $_GET['KUInformasifakturumumV']['filter'];
      $model->statusBayar = isset($_GET['KUInformasifakturumumV']['statusBayar']) ? $_GET['KUInformasifakturumumV']['statusBayar'] : null;

      //		if($_GET['berdasarkanJatuhTempo']>0){
      //                $modFaktur->tglAwalJatuhTempo = $format->formatDateTimeForDB($_GET['InformasifakturgudangumumV']['tglAwalJatuhTempo']);
      //                $modFaktur->tglAkhirJatuhTempo = $format->formatDateTimeForDB($_GET['InformasifakturgudangumumV']['tglAkhirJatuhTempo']);
      //		} else {
      //                $modFaktur->tglAwalJatuhTempo = null;
      //                $modFaktur->tglAkhirJatuhTempo = null;
      //		}
    }

    $this->render('index', array(
      'model' => $model,
    ));
  }
  public function actionPrint()
  {
    $model = new KUInformasifakturumumV('searchLaporan');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Faktur Pembelian Umum';
    //Data Grafik
    $data['title'] = 'Laporan Faktur Pembelian Umum';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['KUInformasifakturumumV'])) {
      $model->attributes = $_REQUEST['KUInformasifakturumumV'];
      $model->jns_periode = $_GET['KUInformasifakturumumV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasifakturumumV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasifakturumumV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KUInformasifakturumumV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KUInformasifakturumumV']['bln_akhir']);
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
      $model->filter = $_GET['KUInformasifakturumumV']['filter'];
      $model->statusBayar = isset($_GET['KUInformasifakturumumV']['statusBayar']) ? $_GET['KUInformasifakturumumV']['statusBayar'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'Print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafik()
  {
    $this->layout = '//layouts/iframe';
    $model = new KUInformasifakturumumV('searchLaporan');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');



    //Data Grafik
    $data['title'] = 'Grafik Laporan Faktur Pembelian Umum';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

    if (isset($_GET['KUInformasifakturumumV'])) {
      $model->attributes = $_GET['KUInformasifakturumumV'];
      $model->jns_periode = $_GET['KUInformasifakturumumV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasifakturumumV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasifakturumumV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KUInformasifakturumumV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KUInformasifakturumumV']['bln_akhir']);
      $model->thn_awal = $_GET['KUInformasifakturumumV']['thn_awal'];
      $model->thn_akhir = $_GET['KUInformasifakturumumV']['thn_akhir'];
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
      $model->filter = $_GET['KUInformasifakturumumV']['filter'];
      $model->statusBayar = isset($_GET['KUInformasifakturumumV']['statusBayar']) ? $_GET['KUInformasifakturumumV']['statusBayar'] : null;
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
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}

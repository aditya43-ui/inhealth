<?php

/**
 * digunakan untuk fungsi laporan modul gizi
 * BMB-299
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.gizi
 * @subpackage      controllers
 * 
 */
class LaporanController extends MyAuthController
{
  public $tgl_awal = "d M Y 00:00:00";
  public $tgl_akhir = "d M Y 23:59:59";

  /**
   * digunakan untuk menampilkan informasi laporan penerimaan makanan 
   */
  public function actionLaporanBahanPenerimaanMakanan()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Bahan Makanan";
    $model = new GZLaporanpenerimaanbhnmakananV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d 23:59:59');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['GZLaporanpenerimaanbhnmakananV'])) {
      $model->attributes = $_GET['GZLaporanpenerimaanbhnmakananV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanpenerimaanbhnmakananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanpenerimaanbhnmakananV']['tgl_akhir']);
    }
    $this->render('terimaBahanMak/admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * digunakan sebagai fungsi print  bahan penerimaan makanan
   */
  public function actionPrintLaporanBahanPenerimaanMakanan()
  {
    $model = new GZLaporanpenerimaanbhnmakananV('search');
    $judulLaporan = 'Laporan Penerimaan Bahan Makanan';
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    //Data Grafik
    $berdasarkan = 'Berdasarkan Supplier';
    if (isset($_GET['filter'])) {
      $berdasarkan = 'Berdasarkan Supplier';
    }
    if (isset($_GET['filter1'])) {
      $berdasarkan = 'Berdasarkan Golongan Bahan Makanan';
    }
    if (isset($_GET['filter2'])) {
      $berdasarkan = 'Berdasarkan Jenis Bahan Makanan';
    }
    if (isset($_GET['filter3'])) {
      $berdasarkan = 'Berdasarkan Kelompok Bahan Makanan';
    }

    $data['title'] = 'Grafik Laporan Penerimaan Bahan Makanan ' . $berdasarkan;
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : "");

    if (isset($_REQUEST['GZLaporanpenerimaanbhnmakananV'])) {
      $model->attributes = $_REQUEST['GZLaporanpenerimaanbhnmakananV'];
      $model->jns_periode = $_GET['GZLaporanpenerimaanbhnmakananV']['jns_periode'];
      $model->tgl_awal = date('Y-m-d', strtotime($format->formatDateTimeForDb($_GET['GZLaporanpenerimaanbhnmakananV']['tgl_awal'])));
      $model->tgl_akhir = date('Y-m-d', strtotime($format->formatDateTimeForDb($_GET['GZLaporanpenerimaanbhnmakananV']['tgl_akhir'])));
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanpenerimaanbhnmakananV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanpenerimaanbhnmakananV']['bln_akhir']);
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
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'terimaBahanMak/_print';

    $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan garafik bahan penerimaan makanan
   */
  public function actionFrameGrafikLaporanBahanPenerimaanMakanan()
  {
    $this->layout = '//layouts/iframe';
    $model = new GZLaporanpenerimaanbhnmakananV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //Data Grafik
    //Data Grafik
    $berdasarkan = 'Berdasarkan Supplier';
    if (isset($_GET['filter'])) {
      $berdasarkan = 'Berdasarkan Supplier';
    }
    if (isset($_GET['filter1'])) {
      $berdasarkan = 'Berdasarkan Golongan Bahan Makanan';
    }
    if (isset($_GET['filter2'])) {
      $berdasarkan = 'Berdasarkan Jenis Bahan Makanan';
    }
    if (isset($_GET['filter3'])) {
      $berdasarkan = 'Berdasarkan Kelompok Bahan Makanan';
    }

    $data['title'] = 'Grafik Laporan Penerimaan Bahan Makanan ' . $berdasarkan;

    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : "");
    if (isset($_GET['GZLaporanpenerimaanbhnmakananV'])) {
      $model->attributes = $_GET['GZLaporanpenerimaanbhnmakananV'];
      $model->jns_periode = $_GET['GZLaporanpenerimaanbhnmakananV']['jns_periode'];
      $model->tgl_awal = date('Y-m-d', strtotime($format->formatDateTimeForDb($_GET['GZLaporanpenerimaanbhnmakananV']['tgl_awal'])));
      $model->tgl_akhir = date('Y-m-d', strtotime($format->formatDateTimeForDb($_GET['GZLaporanpenerimaanbhnmakananV']['tgl_akhir'])));
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanpenerimaanbhnmakananV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanpenerimaanbhnmakananV']['bln_akhir']);
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
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /* END LAPORAN PENERIMAAN BAHAN MAKANAN */

  /**
   * digunakan untuk menampilkan informasi laporan konsul gizi
   */
  public function actionLaporanKonsulGizi()
  {
    $this->pageTitle = Yii::app()->name . " - Konsultasi Gizi Berdasarkan Kelas Pelayanan";
    $model = new GZLaporankonsultasigiziV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['GZLaporankonsultasigiziV'])) {
      $model->attributes = $_GET['GZLaporankonsultasigiziV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_akhir']);
    }
    $this->render('konsulGizi/admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * digunakan sebagai fungsi cetak laporan konusl gizi
   */
  public function actionPrintLaporanKonsulGizi()
  {
    $model = new GZLaporankonsultasigiziV('search');
    $judulLaporan = 'LAPORAN KONSULTASI GIZI <BR/> INSTALASI GIZI BULAN';
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Konsultasi Gizi';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['GZLaporankonsultasigiziV'])) {
      $model->attributes = $_REQUEST['GZLaporankonsultasigiziV'];
      $model->jns_periode = $_GET['GZLaporankonsultasigiziV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporankonsultasigiziV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporankonsultasigiziV']['bln_akhir']);
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
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'konsulGizi/_print';

    $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik laporan konsul gizi
   */
  public function actionFrameGrafikLaporanKonsulGizi()
  {
    $this->layout = '//layouts/iframe';
    $model = new GZLaporankonsultasigiziV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Konsultasi Gizi';
    $data['type'] = $_GET['type'];
    if (isset($_GET['GZLaporankonsultasigiziV'])) {
      $model->attributes = $_GET['GZLaporankonsultasigiziV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigiziV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * digunakan untuk menampilkan informasi laporan gizi rekap
   */
  public function actionLaporanKonsulGiziRekap()
  {
    $this->pageTitle = Yii::app()->name . " - Konsultasi Gizi Berdasarkan Ruangan";
    $model = new GZLaporankonsultasigizirekapV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['GZLaporankonsultasigizirekapV'])) {
      $model->attributes = $_GET['GZLaporankonsultasigizirekapV'];
      $model->jns_periode = $_GET['GZLaporankonsultasigizirekapV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporankonsultasigizirekapV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporankonsultasigizirekapV']['bln_akhir']);
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
    $models = $model->findAll($model->searchTable());
    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial(
        'gizi.views.laporan.konsulGiziRekap/_table',
        array(
          'model' => $model,
          'models' => $models,
          'format' => $format
        ),
        true
      );
    } else {
      $this->render('konsulGiziRekap/admin', array(
        'model' => $model,
        'models' => $models,
        'format' => $format
      ));
    }
  }

  // public function actionPrintLaporanKonsulGiziRekap2() {
  //     $model = new GZLaporankonsultasigizirekapV('search');
  //     $judulLaporan = 'LAPORAN KONSULTASI GIZI <BR/> INSTALASI GIZI BULAN';
  //     //Data Grafik
  //     $data['title'] = 'Laporan Konsultasi Gizi';
  //     $data['type'] = $_REQUEST['type'];
  //     if (isset($_REQUEST['GZLaporankonsultasigizirekapV'])) {
  //         $model->attributes = $_REQUEST['GZLaporankonsultasigizirekapV'];
  //         $format = new MyFormatter();
  //         $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GZLaporankonsultasigizirekapV']['tgl_awal']);
  //         $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GZLaporankonsultasigizirekapV']['tgl_akhir']);
  //     }
  //     $caraPrint = $_REQUEST['caraPrint'];
  //     $target ='konsulGiziRekap/_print';
  //     $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  // }

  /**
   * digunakan sebagai fungsi cetak laporan konsul gizi rekap
   */
  public function actionPrintLaporanKonsulGiziRekap()
  {
    $this->layout = '//layouts/printWindows';
    $model = new GZLaporankonsultasigizirekapV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['GZLaporankonsultasigizirekapV'])) {
      $model->attributes = $_GET['GZLaporankonsultasigizirekapV'];
      $model->jns_periode = $_GET['GZLaporankonsultasigizirekapV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporankonsultasigizirekapV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporankonsultasigizirekapV']['bln_akhir']);
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
    $models = $model->findAll($model->searchTable());
    $periode = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->tgl_awal))) . " s/d " . MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->tgl_akhir)));
    $data = array();
    $data['judulLaporan'] = 'Laporan Pasien Konsultasi Gizi Berdasarkan Ruangan';
    $data['periode'] = 'Periode : ' . $format->formatDateTimeForUser($model->tgl_awal) . ' sampai dengan ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML(
        $this->render('gizi.views.laporan.konsulGiziRekap/_print', array(
          'model' => $model,
          'models' => $models,
          'data' => $data,
          'periode' => $periode,
          'judulLaporan' => "Laporan Konsultasi Gizi Berdasarkam Ruangan",

          'caraPrint' => $_REQUEST['caraPrint']
        ), true)
      );
      $mpdf->Output($data['judulLaporan'] . '_' . date('Y-m-d') . '.pdf', 'I');
    } else if ($_REQUEST['caraPrint'] == 'EXCEL') {

      $this->render('gizi.views.laporan.konsulGiziRekap/_print', array(
        'model' => $model,
        'models' => $models,
        'data' => $data,
        'periode' => $periode,
        'judulLaporan' => "Laporan Konsultasi Gizi Berdasarkam Ruangan",
        'caraPrint' => $_REQUEST['caraPrint']
      ), true);
    } else {
      $this->render('gizi.views.laporan.konsulGiziRekap/_print', array(
        'model' => $model,
        'models' => $models,
        'periode' => $periode,
        'caraPrint' => $_REQUEST['caraPrint'],
        'judulLaporan' => "Laporan Konsultasi Gizi Berdasarkam Ruangan",
        'data' => $data
      ));
    }
  }

  /**
   * digunakan untuk menampilkan grafik laporan konsul gizi rekap
   */
  public function actionFrameGrafikLaporanKonsulGiziRekap()
  {
    $this->layout = '//layouts/iframe';
    $model = new GZLaporankonsultasigizirekapV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Konsultasi Gizi Berdasarkan Ruangan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['GZLaporankonsultasigizirekapV'])) {
      $model->attributes = $_GET['GZLaporankonsultasigizirekapV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporankonsultasigizirekapV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * digunakan untuk menampilkan informasi laporan jasa konsul gizi
   */
  public function actionLaporanJasaKonsulGizi()
  {
    $this->pageTitle = Yii::app()->name . " - Jasa Konsultasi Gizi";
    $model = new GZLaporanjasakomponengiziV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['GZLaporanjasakomponengiziV'])) {
      $model->attributes = $_GET['GZLaporanjasakomponengiziV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_akhir']);
    }

    $this->render('jasaKonsulGizi/admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * digunakan untuk fungsi cetak jasa konsul gizi
   */
  public function actionPrintLaporanJasaKonsulGizi()
  {
    $model = new GZLaporanjasakomponengiziV('search');
    $judulLaporan = 'Laporan Jasa Konsultasi Gizi';
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Konsultasi Gizi';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['GZLaporanjasakomponengiziV'])) {

      $model->attributes = $_REQUEST['GZLaporanjasakomponengiziV'];

      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'jasaKonsulGizi/_print';

    $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik laporan konsul gizi
   */
  public function actionFrameGrafikLaporanJasaKonsulGizi()
  {
    $this->layout = '//layouts/iframe';
    $model = new GZLaporanjasakomponengiziV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Konsultasi Gizi';
    $data['type'] = $_GET['type'];
    if (isset($_GET['GZLaporanjasakomponengiziV'])) {
      $model->attributes = $_GET['GZLaporanjasakomponengiziV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjasakomponengiziV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * digunakan untuk menampilkan informasi laporan makanan harian
   */
  public function actionLaporanMakananHarian()
  {
    $this->pageTitle = Yii::app()->name . " - Makanan Harian";
    $model = new GZLaporanmakanangiziV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['GZLaporanmakanangiziV'])) {
      $model->attributes = $_GET['GZLaporanmakanangiziV'];
      if (isset($_GET['GZLaporanmakanangiziV']['instalasi_id'])) {
        $model->instalasi_id = $_GET['GZLaporanmakanangiziV']['instalasi_id'];
      }
      if (isset($_GET['GZLaporanmakanangiziV']['ruangan_id'])) {
        $model->ruangan_id = $_GET['GZLaporanmakanangiziV']['ruangan_id'];
      }
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_akhir']);
    }

    $this->render('makananHarian/admin', array(
      'model' => $model, 'format' => $format
    ));
  }
  /**
   * digunakan untuk menampilkan informasi laporan makanan harian
   */
  public function actionLaporanMakananHarianPendamping()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Makanan Harian Untuk Pendamping";
    $model = new GZLaporanmakanangizipendampingV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['GZLaporanmakanangizipendampingV'])) {
      $model->attributes = $_GET['GZLaporanmakanangizipendampingV'];
      if (isset($_GET['GZLaporanmakanangizipendampingV']['instalasi_id'])) {
        $model->instalasi_id = $_GET['GZLaporanmakanangizipendampingV']['instalasi_id'];
      }
      if (isset($_GET['GZLaporanmakanangizipendampingV']['ruangan_id'])) {
        $model->ruangan_id = $_GET['GZLaporanmakanangizipendampingV']['ruangan_id'];
      }
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanmakanangizipendampingV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanmakanangizipendampingV']['tgl_akhir']);
    }

    $this->render('makananHarianPendamping/admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * digunakan sebagai fungsi cetak laporan makanan harian
   */
  public function actionPrintLaporanMakananHarianPendamping()
  {
    $model = new GZLaporanmakanangizipendampingV('search');
    $judulLaporan = 'Laporan Makanan Harian Pendamping';
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Makanan Harian Pendamping';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['GZLaporanmakanangizipendampingV'])) {
      $model->attributes = $_REQUEST['GZLaporanmakanangizipendampingV'];
      if (isset($_GET['GZLaporanmakanangizipendampingV']['instalasi_id'])) {
        $model->instalasi_id = $_GET['GZLaporanmakanangizipendampingV']['instalasi_id'];
      }
      if (isset($_GET['GZLaporanmakanangizipendampingV']['ruangan_id'])) {
        $model->ruangan_id = $_GET['GZLaporanmakanangizipendampingV']['ruangan_id'];
      }
      $model->jns_periode = $_GET['GZLaporanmakanangizipendampingV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanmakanangizipendampingV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanmakanangizipendampingV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanmakanangizipendampingV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanmakanangizipendampingV']['bln_akhir']);
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'makananHarianPendamping/_print';

    $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
  }


  /**
   * digunakan sebagai fungsi cetak laporan makanan harian
   */
  public function actionPrintLaporanMakananHarian()
  {
    $model = new GZLaporanmakanangiziV('search');
    $judulLaporan = 'Laporan Makanan Harian';
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Makanan Harian';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['GZLaporanmakanangiziV'])) {
      $model->attributes = $_REQUEST['GZLaporanmakanangiziV'];
      if (isset($_GET['GZLaporanmakanangiziV']['instalasi_id'])) {
        $model->instalasi_id = $_GET['GZLaporanmakanangiziV']['instalasi_id'];
      }
      if (isset($_GET['GZLaporanmakanangiziV']['ruangan_id'])) {
        $model->ruangan_id = $_GET['GZLaporanmakanangiziV']['ruangan_id'];
      }
      $model->jns_periode = $_GET['GZLaporanmakanangiziV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanmakanangiziV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanmakanangiziV']['bln_akhir']);
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'makananHarian/_print';

    $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik laporan makanan harian
   */
  public function actionFrameGrafikLaporanMakananHarian()
  {
    $this->layout = '//layouts/iframe';
    $model = new GZLaporanmakanangiziV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Makanan Harian';
    $data['type'] = $_GET['type'];
    if (isset($_GET['GZLaporanmakanangiziV'])) {
      $model->attributes = $_GET['GZLaporanmakanangiziV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanmakanangiziV']['tgl_akhir']);

      if (isset($_GET['GZLaporanmakanangiziV']['instalasi_id'])) {
        $model->instalasi_id = $_GET['GZLaporanmakanangiziV']['instalasi_id'];
      }
      if (isset($_GET['GZLaporanmakanangiziV']['ruangan_id'])) {
        $model->ruangan_id = $_GET['GZLaporanmakanangiziV']['ruangan_id'];
      }
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * digunakan untuk menampilkan informasi jumlah pasien harian
   */
  public function actionLaporanJumlahPasienHarian()
  {
    $this->pageTitle = Yii::app()->name . " - Jumlah Pasien Harian";
    $model = new GZLaporanjmlpasienhariangiziV('searchLaporan');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->pilihan_tab = 'report';
    if (isset($_GET['GZLaporanjmlpasienhariangiziV'])) {
      $model->attributes = $_GET['GZLaporanjmlpasienhariangiziV'];
      $model->pilihan_tab = $_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'];
      $model->jns_periode = $_GET['GZLaporanjmlpasienhariangiziV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlpasienhariangiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlpasienhariangiziV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanjmlpasienhariangiziV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanjmlpasienhariangiziV']['bln_akhir']);
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

    $models = $model->findAll($model->searchLaporan());
    $modRekaps = $model->findAll($model->searchRekap());
    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial(
        'gizi.views.laporan.jumlahPasienHarian/_tables',
        array(
          'model' => $model,
          'models' => $models,
          'modRekaps' => $modRekaps,
          'pilihan_tab' => $_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'],
        ),
        true
      );
    } else {

      $this->render('jumlahPasienHarian/adminJmlPasienHarian', array(
        'model' => $model,
        'models' => $models,
        'modRekaps' => $modRekaps,
      ));
    }
  }

  /**
   * digunakan sebagai fungsi cetak jumlah pasien harian
   */
  public function actionPrintLaporanJumlahPasienHarian()
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $model = new GZLaporanjmlpasienhariangiziV('searchLaporan');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->pilihan_tab = 'report';
    if (isset($_GET['GZLaporanjmlpasienhariangiziV'])) {
      $model->attributes = $_GET['GZLaporanjmlpasienhariangiziV'];
      $model->pilihan_tab = $_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'];
      $model->jns_periode = $_GET['GZLaporanjmlpasienhariangiziV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlpasienhariangiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlpasienhariangiziV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanjmlpasienhariangiziV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanjmlpasienhariangiziV']['bln_akhir']);
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
    $models = $model->findAll($model->searchLaporan());
    $modRekaps = $model->findAll($model->searchRekap());
    // $data = array();
    $judulLaporan = "";
    if ($_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'] == 'rekap') {
      $judulLaporan = 'Laporan Rekap Jumlah';
    } else {
      $judulLaporan = 'Laporan Jumlah Harian';
    }

    $periodeLaporan = 'Periode : ' . date("d F Y", strtotime($model->tgl_awal)) . ' s/d ' . date("d F Y", strtotime($model->tgl_akhir));
        
        $targetAttr = array(
            'model' => $model,
            'models' => $models,
            'modRekaps' => $modRekaps,
            'pilihanTab' => $_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'],
            'caraPrint' => $_REQUEST['caraPrint'],
            'judulLaporan' => $judulLaporan,
            'periodeLaporan' => $periodeLaporan);

    $target = 'gizi.views.laporan.jumlahPasienHarian/_print';
    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      // $mpdf->WriteHTML($this->renderPartial('gizi.views.laporan.jumlahPasienHarian/print', array(
      //   'model' => $model,
      //   'models' => $models,
      //   'modRekaps' => $modRekaps,
      //   'pilihanTab' => $_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'],
      //   'caraPrint' => $_REQUEST['caraPrint'],
      //   'data' => $data
      // ), true));
      // $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
      $mpdf->WriteHTML($this->renderPartial($target, $targetAttr, true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    } else {
      // $this->render('gizi.views.laporan.jumlahPasienHarian/print', array(
      //   'model' => $model,
      //   'models' => $models,
      //   'modRekaps' => $modRekaps,
      //   'pilihanTab' => $_GET['GZLaporanjmlpasienhariangiziV']['pilihan_tab'],
      //   'caraPrint' => $_REQUEST['caraPrint'],
      //   'data' => $data
      // ));
      $this->render($target, $targetAttr);
    }
  }

  /**
   * digunakan untuk menampilkan informasi laporan extra fooding
   */
  public function actionLaporanExtraFooding()
  {
    $this->pageTitle = Yii::app()->name . " - Extra Fooding";
    $model = new GZLaporangizipmtradiologiV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['GZLaporangizipmtradiologiV'])) {
      $model->attributes = $_GET['GZLaporangizipmtradiologiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporangizipmtradiologiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporangizipmtradiologiV']['tgl_akhir']);
    }
    $models = $model->findAll($model->searchTable());

    $this->render('extraFooding/admin', array(
      'model' => $model, 'format' => $format, 'models' => $models,
    ));
  }

  /**
   * digunakan sebagai fungsi cetak laporan
   */
  public function actionPrintLaporanExtraFooding()
  {
    $model = new GZLaporangizipmtradiologiV();
    $judulLaporan = 'Laporan Extra Fooding';
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['GZLaporangizipmtradiologiV'])) {
      $model->attributes = $_GET['GZLaporangizipmtradiologiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporangizipmtradiologiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporangizipmtradiologiV']['tgl_akhir']);
    }
    $models = $model->findAll($model->searchTable());
    $judulLaporan = 'Laporan PMT RADIOLOGI';

    $data['periode'] = 'Periode : ' . date("d-m-Y", strtotime($model->tgl_awal)) . ' s/d ' . date("d-m-Y", strtotime($model->tgl_akhir));
    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial('gizi.views.laporan.extraFooding/_print', array(
        'model' => $model,
        'models' => $models,
        'caraPrint' => $_REQUEST['caraPrint'],
        'judulLaporan' => $judulLaporan
      ), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    } else {
      $this->layout = '//layouts/printWindows';
      $this->render('gizi.views.laporan.extraFooding/_print', array(
        'model' => $model,
        'models' => $models,
        'caraPrint' => $_REQUEST['caraPrint'],
        'judulLaporan' => $judulLaporan
      ));
    }
  }

  /**
   * digunakan untuk menampilkan grafik laporan extra fooding
   */
  public function actionFrameGrafikLaporanExtraFooding()
  {
    $this->layout = '//layouts/iframe';
    $model = new GZLaporanextrafoodinggiziV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Extra Fooding';
    $data['type'] = $_GET['type'];
    if (isset($_GET['GZLaporanextrafoodinggiziV'])) {
      $model->attributes = $_GET['GZLaporanextrafoodinggiziV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanextrafoodinggiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanextrafoodinggiziV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * digunakan untuk menampilkan informasi laporan jumlah porsi kelas
   */
  public function actionLaporanJumlahPorsiKelas()
  {
    $this->pageTitle = Yii::app()->name . " - Jumlah Porsi Per Kelas";
    $model = new GZLaporanjmlporsikelasruanganV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['GZLaporanjmlporsikelasruanganV'])) {
      $model->attributes = $_GET['GZLaporanjmlporsikelasruanganV'];
      $model->jns_periode = $_GET['GZLaporanjmlporsikelasruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_akhir']);
    }

    $this->render('jmlPorsiKelas/admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * digunakan sebagai fungsi cetak laporan jumlah porsi kelas
   */
  public function actionPrintLaporanJumlahPorsiKelas()
  {
    $model = new GZLaporanjmlporsikelasruanganV('search');
    $judulLaporan = 'Laporan Jumlah Porsi per Kelas';
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jumlah Porsi per Kelas';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['GZLaporanjmlporsikelasruanganV'])) {
      $model->attributes = $_REQUEST['GZLaporanjmlporsikelasruanganV'];
      $model->jns_periode = $_GET['GZLaporanjmlporsikelasruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanjmlporsikelasruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanjmlporsikelasruanganV']['bln_akhir']);
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'jmlPorsiKelas/_print';

    $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik laporan jumlah porsi kelas
   */
  public function actionFrameGrafikLaporanJumlahPorsiKelas()
  {
    $this->layout = '//layouts/iframe';
    $model = new GZLaporanjmlporsikelasruanganV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jumlah Porsi per Kelas';
    $data['type'] = $_GET['type'];
    if (isset($_GET['GZLaporanjmlporsikelasruanganV'])) {
      $model->attributes = $_GET['GZLaporanjmlporsikelasruanganV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanjmlporsikelasruanganV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * digunakan untuk menampilkan informasi laporan jumlah porsi gizi
   */
  public function actionLaporanJumlahPorsiGizi()
  {
    $this->pageTitle = Yii::app()->name . " - Jumlah Porsi";
    $model = new GZLaporanJumlahPorsiV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['GZLaporanJumlahPorsiV'])) {
      $model->attributes = $_GET['GZLaporanJumlahPorsiV'];
      $model->jns_periode = $_GET['GZLaporanJumlahPorsiV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_akhir']);
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

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial(
        'gizi.views.laporan.jumlahPorsi/_tableJumlahPorsi',
        array(
          'model' => $model,
        ),
        true
      );
    } else {
      $this->render('jumlahPorsi/adminJumlahPorsi', array(
        'model' => $model
      ));
    }
  }

  /**
   * digunakan sebagai fungsi cetak laporan jumlah porsi gizi
   */
  public function actionPrintLaporanJumlahPorsiGizi()
  {
    $model = new GZLaporanJumlahPorsiV('');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Jumlah Porsi Berdasarkan Ruangan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['GZLaporanJumlahPorsiV'])) {
      $model->attributes = $_REQUEST['GZLaporanJumlahPorsiV'];
      $model->jns_periode = $_GET['GZLaporanJumlahPorsiV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanJumlahPorsiV']['bln_akhir']);
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

    $judulLaporan = "Laporan Jumlah Porsi Berdasarkan " . (empty($model->ruangan_id) ? 'Semua Ruangan' : 'Ruangan ' . $model->getRuangan($model->ruangan_id));

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'jumlahPorsi/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik jumlah porsi gizi
   */
  public function actionFrameGrafikLaporanJumlahPorsiGizi()
  {
    $this->layout = '//layouts/iframe';
    $model = new GZLaporanJumlahPorsiV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jumlah Porsi Berdasarkan Ruangan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['GZLaporanJumlahPorsiV'])) {
      $model->attributes = $_GET['GZLaporanJumlahPorsiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanJumlahPorsiV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * digunakan untuk menampilkan  informasi laporan pemakai obat alkes
   */
  public function actionLaporanPemakaiObatAlkes()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Pemakaian Obat Ruangan";
    $model = new GZLaporanpemakaiobatalkesruanganV;
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $jenisObat = CHtml::listData($model->getJenisobatalkesItems(), 'jenisobatalkes_id', 'jenisobatalkes_id');
    $model->jenisobatalkes_id = $jenisObat;
    if (isset($_GET['GZLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['GZLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['GZLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render('pemakaiObatAlkes/adminPemakaiObatAlkes', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * digunakan untuk mencetak laporan pemakai obat alkes
   */
  public function actionPrintLaporanPemakaiObatAlkes()
  {
    $model = new GZLaporanpemakaiobatalkesruanganV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Info Pemakai Obat Alkes Rawat Jalan';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['GZLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_REQUEST['GZLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['GZLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pemakaiObatAlkes/_printPemakaiObatAlkes';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik pemakai obat alkes
   */
  public function actionFrameGrafikLaporanPemakaiObatAlkes()
  {
    $this->layout = '//layouts/iframe';
    $model = new GZLaporanpemakaiobatalkesruanganV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
    $data['type'] = $_GET['type'];
    if (isset($_GET['GZLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['GZLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['GZLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GZLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['GZLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * digunakan sebagai fungsi print global untuk gizi
   * @param object $model menampung data yang dikirim  
   * @param array $data menampung data informasi grafik
   * @param string $caraPrint digunakan untuk seleksi jenis print
   * @param string $judulLaporan menampung jul halaman cetak
   * @param string $target menampung halaman tujuan
   */
  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' sampai dengan ' . $format->formatDateTimeForUser($model->tgl_akhir);

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

  /**
   * digunakan sebagai fungsi print global untuk gizi
   * @param object $model menampung data yang dikirim  
   * @param array $data menampung data informasi grafik
   * @param string $caraPrint digunakan untuk seleksi jenis print
   * @param string $judulLaporan menampung jul halaman cetak
   * @param string $target menampung halaman tujuan
   */
  protected function printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target, $posisi = null)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' sampai dengan ' . $format->formatDateTimeForUser($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      if($posisi == null) {
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      }
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

  /**
   * digunakan untuk parser tanggal
   * @param date $tgl menampung tanggal yang akan di explode
   * @return date 
   */
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

  function actionSuratPemberianMakanan() {
    $format = new MyFormatter();

    $model = new LaporanspmgiziV();

    $model->unsetAttributes();  // clear any default values
    $model->tglpesanmenu = date('Y-m-d');

    // echo '<pre>';var_dump($model->searchTable()->data);die;
    // $model = new GZPesanmenudietT('searchSuratPemberianMakanan');

    if (isset($_GET['LaporanspmgiziV'])) {
      $model->attributes = $_GET['LaporanspmgiziV'];
      $model->tglpesanmenu = $format->formatDateTimeForDb($_GET['LaporanspmgiziV']['tglpesanmenu']);
      if (isset($_GET['LaporanspmgiziV']['instalasi_id'])) {
        $model->instalasi_id = $_GET['LaporanspmgiziV']['instalasi_id'];
      }
      if (isset($_GET['LaporanspmgiziV']['ruangan_id'])) {
        $model->ruangan_id = $_GET['LaporanspmgiziV']['ruangan_id'];
      }
    }
    
    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'tableLaporan') {
        $this->renderPartial('suratPemberianMakanan/_table', ['model' => $model]);
        Yii::app()->end();
      }
    }
    $this->render('suratPemberianMakanan/index', ['model' => $model]);
  }

  public function actionPrintSuratPemberianMakanan()
  {
    $model = new LaporanspmgiziV('searchSuratPemberianMakanan');
    $judulLaporan = 'LAPORAN SURAT PERMINTAAN MAKANAN PASIEN';
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tglpesanmenu = date('Y-m-d');
   
    //Data Grafik
    $data['title'] = 'Grafik Laporan Makanan Harian';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['LaporanspmgiziV'])) {
      $model->attributes = $_GET['LaporanspmgiziV'];
      $model->tglpesanmenu = $format->formatDateTimeForDb($_GET['LaporanspmgiziV']['tglpesanmenu']);
      
      if (isset($_GET['LaporanspmgiziV']['instalasi_id'])) {
        $model->instalasi_id = $_GET['LaporanspmgiziV']['instalasi_id'];
      }
      if (isset($_GET['LaporanspmgiziV']['ruangan_id'])) {
        $model->ruangan_id = $_GET['LaporanspmgiziV']['ruangan_id'];
        $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);
        if(!empty($modRuangan)) {
          $model->ruangan_nama = $modRuangan->ruangan_nama;
        }
      }

      if(!empty($model->kelaspelayanan_id)) {
        $modKelasPelayanan = KelaspelayananM::model()->findByPk($model->kelaspelayanan_id);
        if(!empty($modKelasPelayanan)) {
          $model->kelaspelayanan_nama = $modKelasPelayanan->kelaspelayanan_nama;
        }
      }
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'suratPemberianMakanan/_print';

    $this->printFunctionNew($model, $data, $caraPrint, $judulLaporan, $target, 'L');
  }
}

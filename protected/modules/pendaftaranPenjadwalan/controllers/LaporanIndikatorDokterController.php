<?php

class LaporanIndikatorDokterController extends MyAuthController
{
  public $path_viewPP = 'pendaftaranPenjadwalan.views.laporan.';

  /**
   * Laporan Indikator Dokter
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Indikator Dokter";
    $model = new PPLaporanindikatordokterV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPLaporanindikatordokterV'])) {
      $model->attributes = $_GET['PPLaporanindikatordokterV'];
      $model->jns_periode = $_GET['PPLaporanindikatordokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporanindikatordokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporanindikatordokterV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporanindikatordokterV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporanindikatordokterV']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporanindikatordokterV']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporanindikatordokterV']['thn_akhir'];
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

    $this->render('index', array(
      'model' => $model, 'format' => $format
    ));
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    //        $periode = $this->parserTanggal($model->tgl_awal).' s/d '.$this->parserTanggal($model->tgl_akhir);
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
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
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintLaporanIndikatorDokter()
  {
    $model = new PPLaporanindikatordokterV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Indikator Dokter';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Indikator Dokter';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPLaporanindikatordokterV'])) {
      $model->attributes = $_GET['PPLaporanindikatordokterV'];
      $model->jns_periode = $_GET['PPLaporanindikatordokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporanindikatordokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporanindikatordokterV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporanindikatordokterV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporanindikatordokterV']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporanindikatordokterV']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporanindikatordokterV']['thn_akhir'];
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
    $target = '_printIndikatorDokter';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikIndikatorDokter()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPLaporanindikatordokterV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Grafik Indikator Dokter';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPLaporanindikatordokterV'])) {
      $model->attributes = $_GET['PPLaporanindikatordokterV'];
      $model->jns_periode = $_REQUEST['PPLaporanindikatordokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPLaporanindikatordokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPLaporanindikatordokterV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPLaporanindikatordokterV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPLaporanindikatordokterV']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporanindikatordokterV']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporanindikatordokterV']['thn_akhir'];
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

    $this->render($this->path_viewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * update nilai grafik garis dan speedo dari request ajax
   */
  public function actionUpdateGrafik()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = new PPLaporanindikatordokterV();
      $format = new MyFormatter();
      if (isset($_GET['PPLaporanindikatordokterV'])) {
        $model->attributes = $_GET['PPLaporanindikatordokterV'];
        $model->jns_periode = $_REQUEST['PPLaporanindikatordokterV']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPLaporanindikatordokterV']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPLaporanindikatordokterV']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPLaporanindikatordokterV']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPLaporanindikatordokterV']['bln_akhir']);
        $model->thn_awal = $_GET['PPLaporanindikatordokterV']['thn_awal'];
        $model->thn_akhir = $_GET['PPLaporanindikatordokterV']['thn_akhir'];
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

      $index_garis = array();
      $result_garis = array();
      $periodeGrafik = $format->formatDateTimeId(date('Y-m-d', (strtotime($model->tgl_awal)))) . " s.d " . $format->formatDateTimeId(date('Y-m-d', (strtotime($model->tgl_akhir))));
      $return['title'] = "Grafik Laporan Indikator Dokter <br> Periode: " . $periodeGrafik;

      $dataProviderGaris = $model->searchGrafik();
      $dataProviderSpeedo = $model->searchGrafik();
      $hasilGaris = $dataProviderGaris->getData();
      foreach ($hasilGaris as $i => $v) {
        if (strlen($v['data']) > 2) {
          $index_garis[] = $format->formatDateTimeForUser($v['data']);
        } else {
          $index_garis[] = $format->getMonthUser((int)$v['data']) . " " . $v['data_2'];
        }
        $result_garis[] = array($i + 1, (int)$v['jumlah']);
      }
      $return['garis']['result'] = $result_garis;
      $return['garis']['index'] = $index_garis;
      $return['speedo']['result'] = (int)$dataProviderSpeedo->getTotalItemCount();

      echo json_encode($return);
      Yii::app()->end();
    }
  }

  /**
   * untuk menampilkan data dokter dari autocomplete
   * - nama_pegawai
   */
  public function actionAutocompleteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nomorindukpegawai, nama_pegawai';
      $criteria->limit = 5;

      $models = PPPegawaiM::model()->findAll($criteria); //default

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}

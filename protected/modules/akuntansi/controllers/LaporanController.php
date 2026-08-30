<?php

class LaporanController extends MyAuthController
{
  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $this->parserTanggal($model->tglAwal) . ' s/d ' . $this->parserTanggal($model->tglAkhir);

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
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
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

  /*
     * Laporan Pembelian -> Pemindahan dari Modul Gudang Farmasi : Menu - Faktur Pembelian
     */
  public function actionLaporanPembelian()
  {
    $model = new AKFakturpembelianT('searchLaporan');
    $model->tglAwal = date('d M Y 00:00:00');
    $model->tglAkhir = date('d M Y 23:59:59');

    if (isset($_GET['AKFakturpembelianT'])) {
      $format = new MyFormatter;
      $model->attributes = $_GET['AKFakturpembelianT'];
      $model->tglAwal = $format->formatDateTimeForDb($_GET['AKFakturpembelianT']['tglAwal']);
      $model->tglAkhir = $format->formatDateTimeForDb($_GET['AKFakturpembelianT']['tglAkhir']);
    }
    $this->render('fakturPembelianT/index', array(
      'model' => $model,
      'tglAwal' => $model->tglAwal,
      'tglAkhir' => $model->tglAkhir,
    ));
  }

  public function actionPrintLaporanPembelian()
  {
    $model = new AKFakturpembelianT();
    $model->tglAwal = date('d M Y 00:00:00');
    $model->tglAkhir = date('d M Y 23:59:59');

    $judulLaporan = "Laporan Faktur Pembelian";
    if ($_GET['filter_tab'] == "rekap") {
      $judulLaporan = 'Total Faktur Pembelian';
      $data['title'] = 'Grafik Total Faktur Pembelian';
    } else if ($_REQUEST['filter_tab'] == "detail") {
      $judulLaporan = 'Detail Faktur';
      $data['title'] = 'Grafik Detail Faktur';
    }

    //Data Grafik
    isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
    if (isset($_REQUEST['AKFakturpembelianT'])) {
      $model->attributes = $_REQUEST['AKFakturpembelianT'];
      $format = new MyFormatter();
      $model->tglAwal = $format->formatDateTimeForDb($_REQUEST['AKFakturpembelianT']['tglAwal']);
      $model->tglAkhir = $format->formatDateTimeForDb($_REQUEST['AKFakturpembelianT']['tglAkhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'fakturPembelianT/Print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintDetailFakturPembelian($idFaktur = null)
  {
    $idFaktur = $idFaktur;
    $model = new AKFakturpembelianT();
    $modFaktur = AKFakturpembelianT::model()->findByPk($idFaktur);
    $modFakturDetail = GFFakturDetailT::model()->findAllByAttributes(array('fakturpembelian_id' => $idFaktur));
    $modTerima = GFPenerimaanBarangT::model()->findAllByAttributes(array('fakturpembelian_id' => $idFaktur));
    $modDetail = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id' => $modTerima->penerimaanbarang_id));

    $model->tglAwal = date('d M Y 00:00:00');
    $model->tglAkhir = date('d M Y 23:59:59');

    $judulLaporan = 'Detail Faktur';

    //Data Grafik
    $data['title'] = 'Grafik Detail Faktur';
    isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
    if (isset($_REQUEST['AKFakturpembelianT'])) {
      $model->attributes = $_REQUEST['AKFakturpembelianT'];
      $format = new MyFormatter();
      $model->tglAwal = $format->formatDateTimeForDb($_REQUEST['AKFakturpembelianT']['tglAwal']);
      $model->tglAkhir = $format->formatDateTimeForDb($_REQUEST['AKFakturpembelianT']['tglAkhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'fakturPembelianT/detailPrint';

    $format = new MyFormatter();
    $periode = $this->parserTanggal($model->tglAwal) . ' s/d ' . $this->parserTanggal($model->tglAkhir);

    $this->layout = '//layouts/printWindows';
    $this->render($target, array('model' => $model, 'idFaktur' => $idFaktur, 'tglAwal' => $model->tglAwal, 'modFaktur' => $modFaktur, 'tglAkhir' => $model->tglAkhir, 'modDetail' => $modDetail, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
  }

  public function actionFrameGrafikLaporanPembelian()
  {
    $this->layout = '//layouts/frameDialog';

    $model = new AKFakturpembelianT('search');
    $model->tglAwal = date('d M Y 00:00:00');
    $model->tglAkhir = date('d M Y 23:59:59');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Faktur Pembelian';
    isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;

    if (isset($_GET['AKFakturpembelianT'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['AKFakturpembelianT'];
      $model->tglAwal = $format->formatDateMediumForDB($_GET['AKFakturpembelianT']['tglAwal']);
      $model->tglAkhir = $format->formatDateMediumForDB($_GET['AKFakturpembelianT']['tglAkhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /*
     * End Laporan Pembelian
     */
}

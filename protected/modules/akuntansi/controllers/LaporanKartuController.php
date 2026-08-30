<?php

/**
 * - digunakan untuk memanggil view Laporankartuhutang_v, hanya untuk modul akuntansi
 *
 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author       Deni Hamdani    <denihamdani@piindonesia.co.id>
 * @website      <piindonesia.co.id>
 * @wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
 * @package      application.modules.akuntansi
 * @subpackage   controllers
 * @category     controller
 */
class LaporanKartuController extends MyAuthController
{
  public $path_view_ku = 'akuntansi.views.laporanKartu.';

  /**
   * Menampilkan form Laporan Piutang
   */
  public function actionHutang()
  {
    $this->pageTitle = Yii::app()->name . " - Kartu Hutang";
    $model = new AKLaporankartuhutangV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();

    if (isset($_GET['AKLaporankartuhutangV'])) {
      $model->attributes = $_GET['AKLaporankartuhutangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporankartuhutangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporankartuhutangV']['tgl_akhir']);
    }

    $this->render($this->path_view_ku . 'hutang.admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * Menampilkan printout Kartu Hutang
   */
  public function actionPrintHutang()
  {

    $model = new AKLaporankartuhutangV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN KARTU HUTANG';
    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN KARTU HUTANG';
    // $data['type'] = $_REQUEST['type'];

    if (isset($_GET['AKLaporankartuhutangV'])) {
      $model->attributes = $_GET['AKLaporankartuhutangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporankartuhutangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporankartuhutangV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];

    $target = $this->path_view_ku . 'hutang/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * Menampilkan grafik Kartu Piutang
   */
  public function actionFrameGrafikHutang()
  {
    $this->layout = '//layouts/iframe';
    $model = new AKLaporankartuhutangV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN KARTU HUTANG';
    //Data Grafik
    $data['title'] = 'GRAFIK KARTU HUTANG';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['AKLaporankartuhutangV'])) {
      $model->attributes = $_GET['AKLaporankartuhutangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporankartuhutangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporankartuhutangV']['tgl_akhir']);
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * Menampilkan laporan kartu piutang
   */
  public function actionPiutang()
  {
    $this->pageTitle = Yii::app()->name . " - Kartu Piutang";
    $model = new AKLaporankartupiutangV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();

    if (isset($_GET['AKLaporankartupiutangV'])) {
      $model->attributes = $_GET['AKLaporankartupiutangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporankartupiutangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporankartupiutangV']['tgl_akhir']);
    }

    $this->render($this->path_view_ku . 'piutang.admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * Mengambil data Penjamin berdasarkan ada tidak-nya data laporan pada periode yang dipilih.
   * 
   * @param string $tgl_awal  Tanggal Awal Laporan
   * @param string $tgl_akhir Tanggal Akhir Laporan
   */
  public function actionAjaxLaporanKartuPiutang($tgl_awal, $tgl_akhir)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new AKLaporankartupiutangV();
    $model->unsetAttributes();
    $model->tgl_awal = MyFormatter::formatDateTimeForDb($tgl_awal);
    $model->tgl_akhir = MyFormatter::formatDateTimeForDb($tgl_akhir);
    $model->penjamin_id = (!isset($_GET['penjamin_id']) || $_GET['penjamin_id'] == "null") ? null : $_GET['penjamin_id'];

    $res = $model->getLaporanPenjaminList();

    echo CJSON::encode(array(
      'penjamin' => $res,
      'row_total' => $this->renderPartial($this->path_view_ku . 'piutang/_tableTotal', array(), true)
    ));
  }

  /**
   * Mengambil data laporan kartu piutang berdasarkan penjamin dan periode yang dipilih.
   * 
   * @param string $tgl_awal    Tanggal Awal Laporan
   * @param string $tgl_akhir   Tanggal Akhit Laporan
   * @param string $penjamin_id Penjamin
   */
  public function actionAjaxLaporanKartuPiutangPenjamin($tgl_awal, $tgl_akhir, $penjamin_id = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $model = new AKLaporankartupiutangV();
    $model->tgl_awal = MyFormatter::formatDateTimeForDb($tgl_awal);
    $model->tgl_akhir = MyFormatter::formatDateTimeForDb($tgl_akhir);
    $model->penjamin_id = $penjamin_id;

    $data = $model->getLaporanKartuPiutangPenjamin();

    //$data = $model->searchTable();
    //$data->pagination = false;

    $res = array();

    foreach ($data as $item) {
      $res[$item['penjamin_id']]['id'] = $item["penjamin_id"];
      $res[$item['penjamin_id']]['nama'] = $item["penjamin_nama"];
      $res[$item['penjamin_id']]['data'][$item['ref_id']]['ref_id'][] = $item->attributes;
    }

    $str = $this->renderPartial($this->path_view_ku . 'piutang/_tablePenjamin', array(
      'res' => $res,
    ), true);

    echo CJSON::encode(array('html' => $str));
  }

  /**
   * Printout Laporan Kartu Piutang
   */
  public function actionPrintPiutang()
  {

    $model = new AKLaporankartupiutangV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'LAPORAN KARTU PIUTANG';
    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN KARTU PIUTANG';
    //    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['AKLaporankartupiutangV'])) {
      $model->attributes = $_GET['AKLaporankartupiutangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporankartupiutangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporankartupiutangV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];

    $target = $this->path_view_ku . 'piutang/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * Menampilkan grafik laporan kartu piutang
   */
  public function actionFrameGrafikPiutang()
  {
    $this->layout = '//layouts/iframe';
    $model = new AKLaporankartupiutangV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();
    $judulLaporan = 'Laporan Pengajuan Anggaran Operasional';
    //Data Grafik
    $data['title'] = 'Grafik Pengajuan Anggaran Operasional';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['AKLaporankartupiutangV'])) {
      $model->attributes = $_GET['AKLaporankartupiutangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporankartupiutangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporankartupiutangV']['tgl_akhir']);
    }

    $this->render($this->path_view_ku . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * Fungsi printout.
   * 
   * @param mixed  $model
   * @param mixed  $data
   * @param string $caraPrint
   * @param string $judulLaporan
   * @param string $target
   * @param string $tab
   */
  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab = 'rs')
  {
    $format = new MyFormatter();
    $periode = $periode = $format->formatDateTimeId($model->tgl_awal) . ' s/d ' . $format->formatDateTimeId($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array(), true));
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}

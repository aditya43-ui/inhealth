<?php

/**
 * digunakan sebagai Informasi Rincian Tagian Pasien
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * */
class InformasiRincianTagihanController extends MyAuthController
{

  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'bankDarah.views.informasiRincianTagihan.';

  /**
   * Menampilkan halaman informasi
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Informasi Rincian Tagihan Pasien";
    $model = new RinciantagihanpasienbankdarahV('search');

    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    if (isset($_GET['RinciantagihanpasienbankdarahV'])) {
      $model->attributes = $_GET['RinciantagihanpasienbankdarahV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['RinciantagihanpasienbankdarahV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['RinciantagihanpasienbankdarahV']['tgl_akhir']);
      if (isset($_GET['RinciantagihanpasienbankdarahV']['no_permintaandarah'])) {
        $model->no_permintaandarah = $_GET['RinciantagihanpasienbankdarahV']['no_permintaandarah'];
      }
      if (isset($_GET['RinciantagihanpasienbankdarahV']['status_bayar'])) {
        $model->status_bayar = $_GET['RinciantagihanpasienbankdarahV']['status_bayar'];
      }
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }

  /**
   * Menampilkan halaman detail rincian tagihan
   * @param type $id
   */
  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';

    $model = RinciantagihanpasienbankdarahV::model()->findByAttributes(array('permintaandarah_id' => $id));
    $model->tgl_pendaftaran = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tgl_pendaftaran)));

    $modelDetail = PermintaandarahdetT::model()->findAllByAttributes(array('permintaandarah_id' => $id));

    $modelPermintaan = PermintaandarahT::model()->findByPk($id);
    $modelPermintaan->tglpengambilansampel = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modelPermintaan->tglpengambilansampel)));

    $modelPenyerahan = PenyerahandarahT::model()->findByAttributes(array('permintaandarah_id' => $id));
    if (!empty($modelPenyerahan)) {
      $modelPenyerahan->tglpenyerahan = MyFormatter::formatDateTimeForUser($modelPenyerahan->tglpenyerahan);
    } else {
      $modelPenyerahan = new PenyerahandarahT();
      $modelPenyerahan->tglpenyerahan = '-';
    }
    $modelPendaftaran = PendaftaranT::model()->findByPk($modelPermintaan->pendaftaran_id);
    $modelRuangan = RuanganM::model()->findByPk($modelPendaftaran->ruangan_id);
    $modelInstalasi = InstalasiM::model()->findByPk($modelPendaftaran->instalasi_id);
    $modelCaraBayar = CarabayarM::model()->findByPk($modelPendaftaran->carabayar_id);

    $dokter = PegawaiM::model()->findByPk($modelPermintaan->dpjp_id);
    // $dokter = PegawaiM::model()->findByPk(3224);
    $modelPermintaan->dokter_nama = $dokter->namaLengkap;
    $grand_total = 0;
    $total = 0;
    foreach ($modelDetail as $details) {
      $total = $details['jml_kantong'] * $details['tarif_satuan'];
      $grand_total = $grand_total + $total;
    }
    $this->render($this->path_view . '_detail', array(
      'model' => $model,
      'modelPermintaan' => $modelPermintaan,
      'modelDetail' => $modelDetail,
      'grand_total' => $grand_total,
      'modelCaraBayar' => $modelCaraBayar,
      'modelRuangan' => $modelRuangan,
      'modelInstalasi' => $modelInstalasi,
      'modelPenyerahan' => $modelPenyerahan,
    ));
  }

  /**
   * Menampilkan cetak dokumen 
   * @param type $id
   * @param type $caraPrint
   */
  public function actionPrint($id, $caraPrint)
  {
    $model = RinciantagihanpasienbankdarahV::model()->findByAttributes(array('permintaandarah_id' => $id));
    $model->tgl_pendaftaran = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($model->tgl_pendaftaran)));

    $modelDetail = PermintaandarahdetT::model()->findAllByAttributes(array('permintaandarah_id' => $id));

    $modelPermintaan = PermintaandarahT::model()->findByPk($id);
    //$modelPermintaan->tglpengambilansampel = MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modelPermintaan->tglpengambilansampel)));
    $modelPermintaan->tglpengambilansampel = MyFormatter::formatDateTimeForUser($modelPermintaan->tglpengambilansampel);

    $modelPenyerahan = PenyerahandarahT::model()->findByAttributes(array('permintaandarah_id' => $id));
    if (!empty($modelPenyerahan)) {
      $modelPenyerahan->tglpenyerahan = MyFormatter::formatDateTimeForUser($modelPenyerahan->tglpenyerahan);
    } else {
      $modelPenyerahan = new PenyerahandarahT();
      $modelPenyerahan->tglpenyerahan = '-';
    }

    $modelPendaftaran = PendaftaranT::model()->findByPk($modelPermintaan->pendaftaran_id);
    $modelRuangan = RuanganM::model()->findByPk($modelPendaftaran->ruangan_id);
    $modelInstalasi = InstalasiM::model()->findByPk($modelPendaftaran->instalasi_id);
    $modelCaraBayar = CarabayarM::model()->findByPk($modelPendaftaran->carabayar_id);

    $dokter = PegawaiM::model()->findByPk(3224);
    $modelPermintaan->dokter_nama = $dokter->namaLengkap;
    $grand_total = 0;
    $total = 0;
    foreach ($modelDetail as $details) {
      $total = $details['jml_kantong'] * $details['tarif_satuan'];
      $grand_total = $grand_total + $total;
    }

    $judulLaporan = 'Data Rincian Tagihan Pasien';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array(
        'model' => $model,
        'modelPermintaan' => $modelPermintaan,
        'modelDetail' => $modelDetail,
        'grand_total' => $grand_total,
        'modelCaraBayar' => $modelCaraBayar,
        'modelRuangan' => $modelRuangan,
        'modelInstalasi' => $modelInstalasi,
        'judulLaporan' => $judulLaporan,
        'caraPrint' => $caraPrint,
        'modelPenyerahan' => $modelPenyerahan,
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array(
        'model' => $model,
        'modelPermintaan' => $modelPermintaan,
        'modelDetail' => $modelDetail,
        'grand_total' => $grand_total,
        'modelCaraBayar' => $modelCaraBayar,
        'modelRuangan' => $modelRuangan,
        'modelInstalasi' => $modelInstalasi,
        'judulLaporan' => $judulLaporan,
        'caraPrint' => $caraPrint,
        'modelPenyerahan' => $modelPenyerahan,
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array(
        'model' => $model,
        'modelPermintaan' => $modelPermintaan,
        'modelDetail' => $modelDetail,
        'grand_total' => $grand_total,
        'modelCaraBayar' => $modelCaraBayar,
        'modelRuangan' => $modelRuangan,
        'modelInstalasi' => $modelInstalasi,
        'judulLaporan' => $judulLaporan,
        'modelPenyerahan' => $modelPenyerahan,
        'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}

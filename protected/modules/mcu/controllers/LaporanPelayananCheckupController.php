<?php

/**
 * digunakan untuk modul mcu lapaoran pelayanan checkup
 * RSST-3651
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.mcu
 * @subpackage      controllers
 * 
 */
class LaporanPelayananCheckupController extends MyAuthController
{
  public $path_view = 'mcu.views.laporanPelayananCheckup.';
  /**
   * digunakan untuk menampilkan informasi str dan sip
   */
  public function actionIndex()
  {
    $model = new MCLaporanpelayanancheckupV('search');
    $model->tanggalawal = date("d M Y");
    $model->tanggalakhir = date("d M Y");
    if (!empty($_GET['MCLaporanpelayanancheckupV'])) {
      $model->tanggalawal = MyFormatter::formatDateTimeForDb($_GET['MCLaporanpelayanancheckupV']['tanggalawal']);
      $model->tanggalakhir = MyFormatter::formatDateTimeForDb($_GET['MCLaporanpelayanancheckupV']['tanggalakhir']);
      $model->tipe = isset($_GET['MCLaporanpelayanancheckupV']['tipe']) ? $_GET['MCLaporanpelayanancheckupV']['tipe'] : null;
      $model->tipepaket_id = isset($_GET['MCLaporanpelayanancheckupV']['tipepaket_id']) ? $_GET['MCLaporanpelayanancheckupV']['tipepaket_id'] : null;
    }
    $this->render('index', array('model' => $model));
  }

  /**
   * digunakan untuk cetak laporan
   */
  public function actionPrintLaporanPelayanan()
  {
    $model = new MCLaporanpelayanancheckupV('search');
    //$model->tanggalawal = date("d M Y");
    //$model->tanggalakhir = date("d M Y");

    $judulLaporan = 'Laporan Pelayanan Checkup ';

    $format = new MyFormatter();

    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['MCLaporanpelayanancheckupV'])) {

      $model->tanggalawal = MyFormatter::formatDateTimeForDb($_GET['MCLaporanpelayanancheckupV']['tanggalawal']);
      $model->tanggalakhir = MyFormatter::formatDateTimeForDb($_GET['MCLaporanpelayanancheckupV']['tanggalakhir']);
      $model->tipe = isset($_GET['MCLaporanpelayanancheckupV']['tipe']) ? $_GET['MCLaporanpelayanancheckupV']['tipe'] : null;
      $model->tipepaket_id = isset($_GET['MCLaporanpelayanancheckupV']['tipepaket_id']) ? $_GET['MCLaporanpelayanancheckupV']['tipepaket_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . '_printPelayanan';

    $this->printFunction($model, $caraPrint, $judulLaporan, $target);
  }

  /**
   * berfungsi sebagai format cetak laporan modul-modul yang ter-extends
   * @param type object $model  membawa data yang akan ditampilkan
   * @param type string $caraPrint digunakan untuk validasi ketika cetak
   * @param type string $judulLaporan menampilkan laporan yang ditulis
   * @param type string $target  memuat link halaman terkait
   */
  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tanggalawal) . ' s/d ' . $format->formatDateTimeForUser($model->tanggalakhir);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows3';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      //$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $kertas = Params::getUkuranKertas();
      $mpdf = new MyPDF60('', $kertas['F4']);
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 10), true));
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 20, 20, 55, 20, 20);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}

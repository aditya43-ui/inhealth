<?php

/**
 * membuat laporan edukasi
 * perbaikan cara menampilkan laporan
 * RSST-3425,RSST-3916 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.remunerasi
 * @subpackage      controllers
 * 
 */
class LaporanEdukasiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $defaultAction = 'index';
  public $path_view = 'informasi.views.laporanEdukasi.';
  public $tahun;
  /**
   * digunakan untuk halaman utama
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Edukasi";
    $this->layout = '//layouts/mainNeonSidebar';

    $model = new LaporanedukasiV();
    $model->tahun = date('Y');


    if (isset($_GET['LaporanedukasiV'])) {
      $model->attributes = $_GET['LaporanedukasiV'];
      $model->tahun = $_GET['LaporanedukasiV']['tahun'];
      $model->attributes = $_GET['LaporanedukasiV'];
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }

  /**
   * digunakan untuk cetak laporan
   */
  public function actionPrint()
  {

    $model = new LaporanedukasiV;
    $pegawaiMengetahui = "";
    if (!empty($_GET['LaporanedukasiV'])) {
      $model->attributes = $_GET['LaporanedukasiV'];
      $model->tahun = $_GET['LaporanedukasiV']['tahun'];
      if (!empty($_GET['LaporanedukasiV']['pegawai_id'])) {
        $pegawaiMengetahui = PegawaiV::model()->findByAttributes(array('pegawai_id' => $_GET['LaporanedukasiV']['pegawai_id']));
      }
    }
    $judulLaporan = '';
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'printset';
    $format = new MyFormatter();
    $periode = $model->tahun;

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {

      if ($caraPrint == 'GRAFIK') {
        $this->layout = '//layouts/printWindows';
      } else {
        $this->layout = '//layouts/printWindows3';
      }
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'pegawaiMengetahui' => $pegawaiMengetahui));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';

      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $kertas = Params::getUkuranKertas();
      $mpdf = new MyPDF60('', $kertas['F4']);
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf->SetHTMLFooter($this->renderPartial('application.views.headerReport.footerLaporanBukuRegister', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 10), true));
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 20, 20, 30, 20, 20);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'pegawaiMengetahui' => $pegawaiMengetahui), true));
      //$mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /**
   * digunakan untuk grafik
   */
  public function actionFrameInformasiEdukasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new LaporanedukasiV;
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik

    $data['title'] = 'Grafik Informasi Edukasi';

    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : "");
    if (isset($_GET['LaporanedukasiV'])) {
      $model->attributes = $_GET['LaporanedukasiV'];
      $model->tgl_awal = date('Y-m-d', strtotime($format->formatDateTimeForDb($_GET['LaporanedukasiV']['tgl_awal'])));
      $model->tgl_akhir = date('Y-m-d', strtotime($format->formatDateTimeForDb($_GET['LaporanedukasiV']['tgl_akhir'])));
    }

    $searchData = $model->searchGrafik();
    $this->render($this->path_view . '_grafik', array(
      'model' => $model,
      'data' => $data,
      'searchdata' => $searchData,
    ));
  }
}

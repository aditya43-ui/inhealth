<?php
Yii::import('rawatJalan.models.*');
class LaporanPenjaminPasienController extends MyAuthController
{
  public $path_view_mcu = 'mcu.views.laporanPenjaminPasien.';

  public function actionIndex()
  {
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view_mcu . '_table', array('model' => $model), true);
    } else {
      $this->render($this->path_view_mcu . 'admin', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanPenjaminPasien()
  {
    $model = new RJInfokunjunganrjV('search');
    $judulLaporan = 'Laporan Penjamin Pasien';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Penjamin Pasien';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['RJInfokunjunganrjV'])) {
      $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJInfokunjunganrjV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view_mcu . '_print';

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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionFrameGrafikPenjaminPasien()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJInfokunjunganrjV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    //Data Grafik
    $data['title'] = 'Grafik Penjamin Pasien';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
    }

    $this->render($this->path_view_mcu . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
}

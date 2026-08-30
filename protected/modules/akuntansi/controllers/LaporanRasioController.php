<?php
class LaporanRasioController extends MyAuthController
{
  public $path_view = 'akuntansi.views.laporanRasio.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new AKLaporanrasioR('searchLaporan');
    $model->unsetAttributes();
    // $model->tgl_awal = date('m-d', strtotime('first day of this month'));
    //$model->thn_awal = date('Y');

    if (isset($_GET['AKLaporanrasioR'])) {

      $model->attributes = $_GET['AKLaporanrasioR'];
      $format = new MyFormatter();
      //$model->bulan = $_GET['AKLaporanrasioR']['bulan'];
      //$model->thn_awal = $_GET['AKLaporanrasioR']['thn_awal'];
    }
    $models = $model->findAll($model->searchLaporan());
    echo $this->render(
      $this->path_view . 'admin',
      array(
        'model' => $model,
        'models' => $models,
      ),
      true
    );
  }

  public function actionPrintLaporanRasio()
  {
    $model = new AKLaporanrasioR('searchLaporan');
    $model->unsetAttributes();
    //$model->tgl_awal = date('m-d', strtotime('first day of this month'));
    //$model->thn_awal = date('Y');
    $judulLaporan = 'Laporan Rasio';

    if (!empty($model->unitkerja_id)) {
      $uk = UnitkerjaM::model()->findByPk($model->unitkerja_id);
      $judulLaporan .= " - " . $uk->namaunitkerja;
    }
    //Data Grafik       
    $data['title'] = 'Grafik Laporan Rasio';
    isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : $data['type'] = null;
    if (isset($_REQUEST['AKLaporanrasioR'])) {
      $model->attributes = $_REQUEST['AKLaporanrasioR'];
      $format = new MyFormatter();
      //$model->bulan = $_GET['AKLaporanrasioR']['bulan'];
      //$model->thn_awal = $_GET['AKLaporanrasioR']['thn_awal'];
    }
    $models = $model->findAll($model->searchLaporan());
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . '_print';

    $format = new MyFormatter();
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');    //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');     //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}

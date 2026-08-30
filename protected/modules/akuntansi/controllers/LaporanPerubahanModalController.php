<?php
class LaporanPerubahanModalController extends MyAuthController
{
  public $path_view = 'akuntansi.views.laporanPerubahanModal.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new AKLaporanperubahanmodalV('searchLaporan2');
    $model->unsetAttributes();
    $model->tgl_awal = date('m-d', strtotime('first day of this month'));
    $model->thn_awal = date('Y');
    $tgl_periode = AKLaporanperubahanmodalV::model()->getTglPeriode();
    $model->periodeposting_id = (isset($tgl_periode->periodeposting_id) ? $tgl_periode->periodeposting_id : NULL);

    if (isset($_GET['AKLaporanperubahanmodalV'])) {
      $model->attributes = $_GET['AKLaporanperubahanmodalV'];
      //			$model->periodeposting_id = (isset($_GET['AKLaporanperubahanmodalV']['periodeposting_id']) ? $_GET['AKLaporanperubahanmodalV']['periodeposting_id'] : NULL);
      //			$model->ruangan_id = (isset($_GET['AKLaporanperubahanmodalV']['ruangan_id']) ? $_GET['AKLaporanperubahanmodalV']['ruangan_id'] : NULL);

      $model->bulan = $_GET['AKLaporanperubahanmodalV']['bulan'];
      $model->thn_awal = $_GET['AKLaporanperubahanmodalV']['thn_awal'];
    }
    $models = $model->findAll($model->searchLaporan2());

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
      'models' => $models,
      'format' => $format
    ));
  }

  public function actionPrintLaporanPerubahanModal()
  {
    $format = new MyFormatter();
    $model = new AKLaporanperubahanmodalV('searchLaporan2');
    $model->unsetAttributes();
    $model->tgl_awal = date('m-d', strtotime('first day of this month'));
    $model->thn_awal = date('Y');

    $judulLaporan = 'Laporan Perubahan Modal';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Arus Kas';
    isset($_REQUEST['type']) ? $data['type'] = $_REQUEST['type'] : "";
    if (isset($_REQUEST['AKLaporanperubahanmodalV'])) {
      $model->attributes = $_REQUEST['AKLaporanperubahanmodalV'];
      //			$model->periodeposting_id = $_GET['AKLaporanperubahanmodalV']['periodeposting_id'];
      //			$model->ruangan_id = $_GET['AKLaporanperubahanmodalV']['ruangan_id'];

      $model->bulan = $_GET['AKLaporanperubahanmodalV']['bulan'];
      $model->thn_awal = $_GET['AKLaporanperubahanmodalV']['thn_awal'];
    }
    $models = $model->findAll($model->searchLaporan2());

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . '_print';

    //		$periodeposting_id = AKPeriodepostingM::model()->findByPk($model->periodeposting_id);
    //
    //		$periode = $periodeposting_id->periodeposting_nama;

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'format' => $format));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'models' => $models, /* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'format' => $format));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');    //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');     //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A5.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'models' => $models,/* 'periode' => $periode, */ 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'format' => $format), true));
      $mpdf->Output();
    }
  }
}

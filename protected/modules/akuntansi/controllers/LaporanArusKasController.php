<?php
class LaporanArusKasController extends MyAuthController
{
  public $path_view = 'akuntansi.views.laporanArusKas.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new AKLaporanaruskasV('searchLaporan2');
    $model->unsetAttributes();
    $model->tgl_awal = date('m-d', strtotime('first day of this month'));
    $model->thn_awal = date('Y');
    //		$model->periodeposting_id = AKLaporanaruskasV::model()->getTglPeriode()->periodeposting_id;
    if (isset($_GET['AKLaporanaruskasV'])) {
      $model->attributes = $_GET['AKLaporanaruskasV'];
      $model->bulan = $_GET['AKLaporanaruskasV']['bulan'];
      $model->thn_awal = $_GET['AKLaporanaruskasV']['thn_awal'];

      //			$model->ruangan_id = $_GET['AKLaporanaruskasV']['ruangan_id'];
      //			$model->periodeposting_id = $_GET['AKLaporanaruskasV']['periodeposting_id'];
    }
    $models = $model->findAll($model->searchLaporan2());
    $this->render($this->path_view . 'admin', array('model' => $model, 'models' => $models));
  }

  public function actionPrintLaporanArusKas()
  {
    $model = new AKLaporanaruskasV('searchLaporan2');

    $criteria = new CDbCriteria;
    if (isset($_GET['AKLaporanaruskasV'])) {
      $model->attributes = $_GET['AKLaporanaruskasV'];
      $model->bulan = $_GET['AKLaporanaruskasV']['bulan'];
      $model->thn_awal = $_GET['AKLaporanaruskasV']['thn_awal'];
    }

    $models = $model->findAll($model->searchLaporan2());

    $caraPrint = $_REQUEST['caraPrint'];
    $judulLaporan = 'Laporan Arus Kas';

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . '_print', array('model' => $model, 'models' => $models, /* 'periode' => $periode, */ 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . '_print', array('model' => $model, 'models' => $models, /* 'periode' => $periode, */ 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');    //Ukuran Kertas Pdf
      $posisi = 'L';     //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 0, 5, 15, 15);
      $mpdf->tMargin = 5;
      $mpdf->WriteHTML($this->renderPartial($this->path_view . '_print', array('model' => $model, 'models' => $models, /* 'periode' => $periode, */ 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}

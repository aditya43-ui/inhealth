<?php

class LaporanstokinventarisbarangController extends MyAuthController
{
  public function actionFrameInventaris()
  {
    $this->render('frameInventaris');
  }

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Stok Barang";
    $model = new GUInventarisasiruanganT();

    $format = new MyFormatter();
    $model->unsetAttributes();

    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['GUInventarisasiruanganT'])) {
      $model->attributes = $_GET['GUInventarisasiruanganT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_akhir']);
      // var_dump($_GET); die;
    }

    $this->render('index', array(
      'model' => $model, 'format' => $format,
    ));
  }

  public function actionPrint()
  {
    $model = new GUInventarisasiruanganT();

    $format = new MyFormatter();
    $model->unsetAttributes();

    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $judulLaporan = 'Laporan Stok Barang';

    $data = array();
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['GUInventarisasiruanganT'])) {
      $model->attributes = $_GET['GUInventarisasiruanganT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInventarisasiruanganT']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $searchdata = null)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'searchdata' => $searchdata));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}

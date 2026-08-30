<?php

class LaporanMutasiBarangController extends MyAuthController
{
  public function actionGrafik()
  {
    $this->render('grafik');
  }

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Mutasi Barang";
    $model = new LaporanmutasibarangV;
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['LaporanmutasibarangV'])) {
      $model->attributes = $_GET['LaporanmutasibarangV'];
      $model->jns_periode = $_GET['LaporanmutasibarangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporanmutasibarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporanmutasibarangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['LaporanmutasibarangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['LaporanmutasibarangV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
    }
    $searchData = null; //$model->searchGrafik();

    $this->render('index', array(
      'model' => $model, 'format' => $format, 'searchdata' => $searchData
    ));
  }

  public function actionPrint()
  {

    $model = new LaporanmutasibarangV;
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Mutasi Barang';

    //Data Grafik
    $data['title'] = 'Grafik Mutasi Barang';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['LaporanmutasibarangV'])) {
      $model->attributes = $_REQUEST['LaporanmutasibarangV'];
      $model->jns_periode = $_REQUEST['LaporanmutasibarangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LaporanmutasibarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LaporanmutasibarangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['LaporanmutasibarangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['LaporanmutasibarangV']['bln_akhir']);
      $model->thn_awal = $_GET['LaporanmutasibarangV']['thn_awal'];
      $model->thn_akhir = $_GET['LaporanmutasibarangV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameMutasiBarang()
  {
    $this->layout = '//layouts/iframe';
    $model = new LaporanmutasibarangV;
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
    //Data Grafik
    //Data Grafik

    $data['title'] = 'Grafik Mutasi Barang';

    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : "");
    if (isset($_GET['LaporanmutasibarangV'])) {
      $model->attributes = $_GET['LaporanmutasibarangV'];
      $model->jns_periode = $_GET['LaporanmutasibarangV']['jns_periode'];
      $model->tgl_awal = date('Y-m-d',  strtotime($format->formatDateTimeForDb($_GET['LaporanmutasibarangV']['tgl_awal'])));
      $model->tgl_akhir = date('Y-m-d',  strtotime($format->formatDateTimeForDb($_GET['LaporanmutasibarangV']['tgl_akhir'])));
      $model->bln_awal = $format->formatMonthForDb($_GET['LaporanmutasibarangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['LaporanmutasibarangV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
    }
    $searchData = $model->searchGrafik();
    $this->render('gudangUmum.views.laporan._grafik', array(
      'model' => $model,
      'data' => $data,
      'searchdata' => $searchData,
    ));
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

<?php

/**
 * - controller utama laporan dinas
 * 
 * @category		controller
 * @author		Deni Hamdani 
 * @website		<piindonesia.co.id>
 * @wiki			<https://piiproject.atlassian.net/wiki/display/MDO>
 * 
 */
class LaporanDinasController extends MyAuthController
{
  public $defaultAction = 'LaporanPasienDBD';
  public $path_view = 'rekamMedis.views.laporanDinas.';

  public function actionLaporanAngkaKematian()
  {
    $model = new LaporanangkakematianV();
    $model->unsetAttributes();
    $model->tahun = date('Y');
    $model->bulan = date('n');

    if (isset($_GET['LaporanangkakematianV'])) {
      $model->attributes = $_GET['LaporanangkakematianV'];
      $model->bulan = (int) $model->bulan;
    }

    $this->render('laporanAngkaKematian', array('model' => $model));
  }

  public function actionPrintLaporanAngkaKematian()
  {
    $this->layout = '//layouts/printWindows';
    $model = new LaporanangkakematianV();
    $model->unsetAttributes();

    if (isset($_GET['LaporanangkakematianV'])) {
      $model->attributes = $_GET['LaporanangkakematianV'];
      $model->bulan = (int) $model->bulan;
    }

    if (isset($_GET['caraPrint'])) {
      $caraPrint = $_GET['caraPrint'];
    } else $caraPrint = 'PRINT';

    $target = 'printLaporanAngkaKematian';
    $judulLaporan = 'ANGKA KEMATIAN PASIEN DI RUMAH SAKIT';

    $periode = MyFormatter::getMonthId($model->bulan) . ' ' . $model->tahun;

    $this->printFunction($model, $caraPrint, $judulLaporan, $target, $periode);
  }


  public function actionLaporanPasienDBD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Dinas Kesehatan";
    $model = new LaporanpasiendbdV;
    $model->tahun = date('Y');
    $model->bulan = date('m');

    $model->unsetAttributes();

    if (isset($_GET['LaporanpasiendbdV'])) {
      $model->attributes = $_GET['LaporanpasiendbdV'];
      $model->bulan = (int) $model->bulan;
    }

    $this->render($this->path_view . 'laporanPasienDBD', array('model' => $model));
  }

  public function actionPrintLaporanPasienDBD()
  {
    $model = new LaporanpasiendbdV;
    $model->tahun = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Pasien DBD';
    $this->path_view = 'rekamMedis.views.laporanDinas.';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien DBD';
    // $data['type'] = $_REQUEST['type'];

    if (isset($_GET['LaporanpasiendbdV'])) {
      $model->attributes = $_GET['LaporanpasiendbdV'];
      $model->bulan = (int) $_GET['LaporanpasiendbdV']['bulan'];
      $model->tahun = $_GET['LaporanpasiendbdV']['tahun'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'printLaporanPasienDBD';

    $periode = MyFormatter::getMonthId($model->bulan) . ' ' . $model->tahun;
    $this->printFunction($model, $caraPrint, $judulLaporan, $target, $periode);
  }

  /**
   * - laporan kunjungan
   */
  public function actionLaporanKunjungan()
  {
    $model = new RKlaporankunjunganrsV;
    $model->tahun = date('Y');
    $model->bulan = (int)date('m');

    $model->unsetAttributes();

    if (isset($_GET['RKlaporankunjunganrsV'])) {
      $model->attributes = $_GET['RKlaporankunjunganrsV'];
      $model->bulan = (int) $_GET['RKlaporankunjunganrsV']['bulan'];
      $model->tahun = $_GET['RKlaporankunjunganrsV']['tahun'];
    }

    $this->render($this->path_view . 'kunjungan.admin', array('model' => $model));
  }

  public function actionPrintLaporanKunjungan()
  {
    $model = new RKlaporankunjunganrsV;
    $model->tahun = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan';
    $this->path_view = 'rekamMedis.views.laporanDinas.';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan';
    // $data['type'] = $_REQUEST['type'];

    if (isset($_GET['RKlaporankunjunganrsV'])) {
      $model->attributes = $_GET['RKlaporankunjunganrsV'];
      $model->bulan = (int) $_GET['RKlaporankunjunganrsV']['bulan'];
      $model->tahun = $_GET['RKlaporankunjunganrsV']['tahun'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'kunjungan._print';

    $periode = MyFormatter::getMonthId($model->bulan) . ' ' . $model->tahun;
    $this->printFunction($model, $caraPrint, $judulLaporan, $target, $periode);
  }

  /**
   * - laporan Kinerja
   */
  public function actionLaporanKinerja()
  {
    $model = new RKLaporankinerjadinkesV();
    $model->tahun = date('Y');
    $model->bulan = date('m');

    if (isset($_GET['RKLaporankinerjadinkesV'])) {
      $model->attributes = $_GET['RKLaporankinerjadinkesV'];
      $model->bulan = (int) $_GET['RKLaporankinerjadinkesV']['bulan'];
      $model->tahun = $_GET['RKLaporankinerjadinkesV']['tahun'];
    }

    $this->render($this->path_view . 'kinerja.admin', array('model' => $model));
  }

  public function actionPrintLaporanKinerja()
  {
    $model = new RKLaporankinerjadinkesV;
    $model->tahun = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kinerja';
    $this->path_view = 'rekamMedis.views.laporanDinas.';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kinerja';
    // $data['type'] = $_REQUEST['type'];

    if (isset($_GET['RKLaporankinerjadinkesV'])) {
      $model->attributes = $_GET['RKLaporankinerjadinkesV'];
      $model->bulan = (int) $_GET['RKLaporankinerjadinkesV']['bulan'];
      $model->tahun = $_GET['RKLaporankinerjadinkesV']['tahun'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'kinerja._print';

    $periode = MyFormatter::getMonthId($model->bulan) . ' ' . $model->tahun;
    $this->printFunction($model, $caraPrint, $judulLaporan, $target, $periode);
  }

  /**
   * - action yang digunatan untuk memasuki halaman laporan ispa
   * 
   * @category		controller
   * @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @website		<piindonesia.co.id>
   * @wiki			<https://piiproject.atlassian.net/wiki/display/MDO>
   * 
   */
  public function actionLaporanIspa()
  {
    $model = new RKLaporanispadinasV();
    $model->tahun = date('Y');
    $model->bulan = (int) date('m');

    if (isset($_GET['RKLaporanispadinasV'])) {
      $model->attributes = $_GET['RKLaporanispadinasV'];
      $model->bulan = (int) $_GET['RKLaporanispadinasV']['bulan'];
      $model->tahun = $_GET['RKLaporanispadinasV']['tahun'];
    }

    $this->render($this->path_view . 'ispa.admin', array('model' => $model));
  }


  /**
   * - action yang digunatan untuk menampilkan prinout halaman laporan ispa
   * 
   * @category		controller
   * @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @website		<piindonesia.co.id>
   * @wiki			<https://piiproject.atlassian.net/wiki/display/MDO>
   * 
   */
  public function actionPrintLaporanIspa()
  {
    $model = new RKLaporanispadinasV;
    $model->tahun = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan ISPA';
    $this->path_view = 'rekamMedis.views.laporanDinas.';

    //Data Grafik
    $data['title'] = 'Grafik Laporan ISPA';
    // $data['type'] = $_REQUEST['type'];

    if (isset($_GET['RKLaporanispadinasV'])) {
      $model->attributes = $_GET['RKLaporanispadinasV'];
      $model->bulan = (int) $_GET['RKLaporanispadinasV']['bulan'];
      $model->tahun = $_GET['RKLaporanispadinasV']['tahun'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'ispa._print';

    $periode = MyFormatter::getMonthId($model->bulan) . ' ' . $model->tahun;
    $this->printFunction($model, $caraPrint, $judulLaporan, $target, $periode);
  }

  /**
   * - action yang digunatan untuk memasuki halaman laporan pasien diare
   * 
   * @category		controller
   * @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @website		<piindonesia.co.id>
   * @wiki			<https://piiproject.atlassian.net/wiki/display/MDO>
   * 
   */
  public function actionLaporanPasienDiare()
  {
    $model = new RKLaporanpasiendiaredinasV();
    $model->tahun = date('Y');
    $model->bulan = (int) date('m');

    if (isset($_GET['RKLaporanpasiendiaredinasV'])) {
      $model->attributes = $_GET['RKLaporanpasiendiaredinasV'];
      $model->bulan = (int) $_GET['RKLaporanpasiendiaredinasV']['bulan'];
      $model->tahun = $_GET['RKLaporanpasiendiaredinasV']['tahun'];
    }

    $this->render($this->path_view . 'diare.admin', array('model' => $model));
  }


  /**
   * - action yang digunatan untuk menampilkan prinout halaman laporan ispa
   * 
   * @category		controller
   * @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @website		<piindonesia.co.id>
   * @wiki			<https://piiproject.atlassian.net/wiki/display/MDO>
   * 
   */
  public function actionPrintLaporanPasienDiare()
  {
    $model = new RKLaporanpasiendiaredinasV;
    $model->tahun = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Pasien Diare';
    $this->path_view = 'rekamMedis.views.laporanDinas.';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien Diare';
    // $data['type'] = $_REQUEST['type'];

    if (isset($_GET['RKLaporanpasiendiaredinasV'])) {
      $model->attributes = $_GET['RKLaporanpasiendiaredinasV'];
      $model->bulan = (int) $_GET['RKLaporanpasiendiaredinasV']['bulan'];
      $model->tahun = $_GET['RKLaporanpasiendiaredinasV']['tahun'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'diare._print';

    $periode = MyFormatter::getMonthId($model->bulan) . ' ' . $model->tahun;
    $this->printFunction($model, $caraPrint, $judulLaporan, $target, $periode);
  }


  protected function printFunction($model, $caraPrint, $judulLaporan, $target, $periode, $initial = '')
  {
    $format = new MyFormatter();


    //if ()
    //$periode = $format->formatDateTimeForUser($model->tgl_awal).' sampai dengan '.$format->formatDateTimeForUser($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows2';
      $this->render($target, array('initial' => $initial, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('initial' => $initial, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait                    
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $footer = '<table width="100%"><tr>'
        . '<td style = "text-align:left;font-size:8px;"><i><b>generated by eHealthsys</b></i></td>'
        . '<td style = "text-align:right;font-size:8px;"><i><b>Print Count :</b></i></td>'
        . '</tr></table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('initial' => $initial, 'model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode), true));
      $mpdf->Output($judulLaporan . '-' . date('Y_m_d') . '.pdf', 'I');
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

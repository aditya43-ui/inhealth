<?php
Yii::import('farmasiApotek.controllers.LaporanFarmasiController');
Yii::import('farmasiApotek.views.laporanFarmasi.*');
/**
 * controller utama laporan
 * 
 * @package application.modules.farmasiApotek
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class LaporanController extends LaporanFarmasiController
{
  //untuk range tanggal default
  public $tgl_awal = "d M Y 00:00:00";
  public $tgl_akhir = "d M Y 23:59:59";

  /**
   * laporan penjualan obat
   */
  public function actionLaporanPenjualanObat()
  {
    $model = new FALaporanpenjualanobatV();
    $format = new MyFormatter();
    $model->tgl_awal = date("d M Y");
    $model->tgl_akhir = date("d M Y");
    $model->unsetAttributes();
    if (isset($_GET['FALaporanpenjualanobatV'])) {
      $model->attributes = $_GET['FALaporanpenjualanobatV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_akhir']);
      $model->jenispenjualan = isset($_GET['FALaporanpenjualanobatV']['jenispenjualan']) ? $_GET['FALaporanpenjualanobatV']['jenispenjualan'] : null;
      $model->obatalkes_nama = isset($_GET['FALaporanpenjualanobatV']['obatalkes_nama']) ? $_GET['FALaporanpenjualanobatV']['obatalkes_nama'] : '';
      $model->pegawai_id = isset($_GET['FALaporanpenjualanobatV']['pegawai_id']) ? $_GET['FALaporanpenjualanobatV']['pegawai_id'] : '';
    }



    $this->render('penjualanObat/index', array(
      'model' => $model,
    ));
  }

  /**
   * mencetak prinout laporan penjualan obat
   */
  public function actionPrintLaporanPenjualanObat()
  {
    $model = new FALaporanpenjualanobatV('search');
    $judulLaporan = 'Laporan Penjualan Obat';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Penjualan Obat';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['FALaporanpenjualanobatV'])) {
      $model->attributes = $_REQUEST['FALaporanpenjualanobatV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanpenjualanobatV']['tgl_akhir']);
      $model->jenispenjualan = isset($_GET['FALaporanpenjualanobatV']['jenispenjualan']) ? $_GET['FALaporanpenjualanobatV']['jenispenjualan'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'penjualanObat/_printPenjualanObat';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * menegenerate laporan penjualan obat ke dalam bentuk grafik
   */
  public function actionFrameGrafikPenjualanObat()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanpenjualanobatV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    //Data Grafik
    $data['title'] = 'Grafik Penjualan Obat';
    $data['type'] = $_GET['type'];
    if (isset($_GET['FALaporanpenjualanobatV'])) {
      $model->attributes = $_GET['FALaporanpenjualanobatV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpenjualanobatV']['tgl_akhir']);
      $model->jenispenjualan = isset($_GET['FALaporanpenjualanobatV']['jenispenjualan']) ? $_GET['FALaporanpenjualanobatV']['jenispenjualan'] : null;
    }
    //        echo "<pre>";
    //        print_r($_GET['FALaporanpenjualanobatV']);
    //        exit;
    $this->render('penjualanObat/_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * menegenerate laporan lembar resep
   */
  public function actionLaporanLembarResep()
  {
    $this->pageTitle = Yii::app()->name . " - Lembar Resep";
    $model = new FALaporanlembarresepV('search');
    $format = new MyFormatter;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['FALaporanlembarresepV'])) {
      $model->attributes = $_GET['FALaporanlembarresepV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_akhir']);

      //	$model->instalasi_id = isset($_GET['FALaporanlembarresepV']['instalasi_id'])?$_GET['FALaporanlembarresepV']['instalasi_id']:null;
      //$model->instalasiasal_nama = isset($_GET['FALaporanlembarresepV']['instalasiasal_nama'])?$_GET['FALaporanlembarresepV']['instalasiasal_nama']:null;
      //$model->ruanganasal_nama = isset($_GET['FALaporanlembarresepV']['ruanganasal_nama'])?$_GET['FALaporanlembarresepV']['ruanganasal_nama']:null;
    }
    $this->render('laporanlembarresepV/index', array(
      'model' => $model,
      'tgl_awal' => $model->tgl_awal,
      'tgl_akhir' => $model->tgl_akhir,
    ));
  }

  /**
   * menegenerate prinout laporan lembar resep
   */
  public function actionPrintLaporanLembarResep()
  {
    $model = new FALaporanlembarresepV('search');
    $judulLaporan = 'Laporan Lembar Resep';

    //Data Grafik  

    $data['title'] = 'Grafik Laporan Penjualan Obat';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
    if (isset($_REQUEST['FALaporanlembarresepV'])) {
      $model->attributes = $_REQUEST['FALaporanlembarresepV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanlembarresepV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanlembarresepV']['tgl_akhir']);
    }

    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'laporanlembarresepV/Print';

    //        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tgl_awal' => $model->tgl_awal, 'tgl_akhir' => $model->tgl_akhir));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tgl_awal' => $model->tgl_awal, 'tgl_akhir' => $model->tgl_akhir));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 0, 5, 15, 15);
      $mpdf->tMargin = 5;
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tgl_awal' => $model->tgl_awal, 'tgl_akhir' => $model->tgl_akhir), true));
      $mpdf->Output();
    }
  }

  /**
   * menegenerate data grafik lembar resep
   */
  public function actionframeGrafikLaporanLembarResep()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanlembarresepV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Lembar Resep';
    $data['type'] = $_GET['type'];
    $searchdata = $model->searchGrafik();
    if (isset($_GET['FALaporanlembarresepV'])) {
      $model->attributes = $_GET['FALaporanlembarresepV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanlembarresepV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
      'searchdata' => $searchdata
    ));
  }

  /**
   * mengenerate data lembar resep luar
   */
  public function actionLaporanLembarResepLuar()
  {
    $this->pageTitle = Yii::app()->name . " - Lembar Resep Luar";
    $model = new FALaporanlembarresepluarV('search');
    $format = new MyFormatter;
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['FALaporanlembarresepluarV'])) {
      $model->attributes = $_GET['FALaporanlembarresepluarV'];
      $model->jns_periode = $_GET['FALaporanlembarresepluarV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanlembarresepluarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanlembarresepluarV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['FALaporanlembarresepluarV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['FALaporanlembarresepluarV']['bln_akhir']);
      $model->thn_awal = $_GET['FALaporanlembarresepluarV']['thn_awal'];
      $model->thn_akhir = $_GET['FALaporanlembarresepluarV']['thn_akhir'];
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
    $this->render('laporanlembarresepluarV/index', array(
      'model' => $model,
    ));
  }

  /**
   * mnegenerate data ke dalam bentuk grafik
   */
  public function actionframeGrafikLaporanLembarResepLuar()
  {
    $this->layout = '//layouts/iframe';
    $model = new FALaporanlembarresepluarV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y 23:59:59');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Lembar Resep Luar';
    $data['type'] = $_GET['type'];
    $searchdata = $model->searchGrafik();
    if (isset($_GET['FALaporanlembarresepV'])) {
      $model->attributes = $_GET['FALaporanlembarresepV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanlembarresepluarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanlembarresepluarV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
      'searchdata' => $searchdata
    ));
  }

  /**
   * prinout untuk mencetak lembar resep luar
   */
  public function actionPrintLaporanLembarResepLuar()
  {
    $model = new FALaporanlembarresepluarV('search');
    $judulLaporan = 'Laporan Lembar Resep Luar';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Lembar Resep Luar';
    if (isset($_REQUEST['type'])) {
      $data['type'] = $_REQUEST['type'];
    } else {
      $data['type'] = null;
    }
    if (isset($_REQUEST['FALaporanlembarresepluarV'])) {
      $model->attributes = $_REQUEST['FALaporanlembarresepluarV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['FALaporanlembarresepluarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['FALaporanlembarresepluarV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'laporanlembarresepluarV/Print';
    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  //    YANG INI ERROR JADI MENGGUNAKAN CONTROLLER LaporanFarmasiController 
  //    protected function printFunction($model, $modDetail, $data, $caraPrint, $judulLaporan, $target){
  //        $format = new MyFormatter();
  //        $periode = $this->parserTanggal($model->tgl_awal).' s/d '.$this->parserTanggal($model->tgl_akhir);
  ////        echo $caraPrint;
  //        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
  //            $this->layout = '//layouts/printWindows';
  //            $this->render($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint , 'modRincian'=>$modRincian));
  //        } else if ($caraPrint == 'EXCEL') {
  //            $this->layout = '//layouts/printExcel';
  //            $this->render($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian'=>$modRincian));
  //        } else if ($_REQUEST['caraPrint'] == 'PDF') {
  //            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
  //            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
  //            $mpdf = new MyPDF60('', $ukuranKertasPDF);
  //            $mpdf->mirrorMargins = 2;
  //            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
  //            $mpdf->WriteHTML($stylesheet, 1);
  //            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
  //            $mpdf->WriteHTML($this->renderPartial($target, array('modDetail'=>$modDetail,'rincianUang'=>$rincianUang,'model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modRincian'=>$modRincian), true));
  //            $mpdf->Output();
  //        }
  //    }

  /**
   * format tanggal, sesuai dengan parameter yang dikirimkan
   * @param type $tgl
   * @return type
   */
  protected function parserTanggal($tgl)
  {
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row) {
      if (!empty($row)) {
        $result[] = $row;
      }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'), 'medium', null) . ' ' . $result[1];
  }

  /**
   * mengenerate data riwayat obat pasien
   */
  public function actionRiwayatObatPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Riwayat Obat Pasien";
    $model = new FAInformasipenjualanresepV();
    $format = new MyFormatter();

    if (isset($_REQUEST['FAInformasipenjualanresepV'])) {
      $model->attributes = $_REQUEST['FAInformasipenjualanresepV'];
      $model->instalasiterakhir_id = $_REQUEST['FAInformasipenjualanresepV']['instalasiterakhir_id'];
    }

    $this->render('riwayatObatPasien/index', array(
      'model' => $model,
    ));
  }

  /**
   * mengenerate data ke dalam prinout
   */
  public function actionPrintRiwayatObatPasien()
  {
    $model = new FAInformasipenjualanresepV('search');
    $judulLaporan = 'Laporan Penjualan Obat';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Riwayat Obat Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['FAInformasipenjualanresepV'])) {
      $model->attributes = $_REQUEST['FAInformasipenjualanresepV'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'riwayatObatPasien/Print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * mengenerate data ke dalam format grafik
   */
  public function actionFrameGrafikRiwayatObatPasien()
  {
    $this->layout = '//layouts/iframe';
    $model = new FAInformasipenjualanresepV('search');

    $data['title'] = 'Grafik Riwayat Obat Pasien';
    $data['type'] = $_GET['type'];
    if (isset($_GET['FAInformasipenjualanresepV'])) {
      $model->attributes = $_GET['FAInformasipenjualanresepV'];
    }
    //        echo "<pre>";
    //        print_r($_GET['FALaporanpenjualanobatV']);
    //        exit;
    $this->render('riwayatObatPasien/_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
}

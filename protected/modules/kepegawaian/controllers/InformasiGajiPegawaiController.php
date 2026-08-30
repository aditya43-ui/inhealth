<?php
class InformasiGajiPegawaiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $path_view = 'kepegawaian.views.informasiGajiPegawai.';
  public $path_view_gj = 'penggajian.views.penggajianpegT.';
  public $init = '';

  public function actionIndex($pegawai = null)
  {
    $format = new MyFormatter();
    $modelpegawai = KPPegawaiM::model()->findByPK(Yii::app()->user->getState('pegawai_id'));
    if (empty($modelpegawai)) {
      $modelpegawai = new KPPegawaiM;
    }
    //$model = new KPPenggajianpegawaiV;
    $model = new PenggajianpegT;
    $model->tgl_awal = date('Y-m-01');
    $model->tgl_akhir = date('Y-m-t');
    $pegawai = Yii::app()->user->getState('pegawai_id');
    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['PenggajianpegT'])) {
      $model->attributes = $_GET['PenggajianpegT'];
      $model->tgl_awal = date("Y-m-01", strtotime($format->formatMonthForDb($_GET['PenggajianpegT']['tgl_awal'])));
      $model->tgl_akhir = date("Y-m-t", strtotime($format->formatMonthForDb($_GET['PenggajianpegT']['tgl_awal'])));
    }

    $this->render($this->path_view . 'index', array(
      'modelpegawai' => $modelpegawai,
      'model' => $model,
      'pegawai' => $pegawai,
      'format' => $format,
    ));
  }

  public function actionDetailGaji($pegawai_id, $nopenggajian)
  {
    $this->layout = '//layouts/iframe';
    $modelpegawai = KPPegawaiM::model()->findByPk($pegawai_id);
    $model = PenggajianpegT::model()->findByAttributes(array('nopenggajian' => $nopenggajian));
    $modDetail = PenggajiankompT::model()->findAllByAttributes(array('penggajianpeg_id' => $model->penggajianpeg_id));
    $this->render($this->path_view . 'PrintBaru', array(
      'modelpegawai' => $modelpegawai,
      'model' => $model,
      'modDetail' => $modDetail,
      'caraPrint' => ''
    ));
  }

  public function actionPrintPenggajian($id, $gaji_id)
  {
    $modelpegawai = KPPegawaiM::model()->findByPk($id);
    $modDetail = PenggajiankompT::model()->findAll('penggajianpeg_id = ' . $gaji_id . '');
    $model = PenggajianpegT::model()->findByPk($gaji_id);
    $modelpegawai->attributes = (isset($_REQUEST['KPPegawaiM']) ? $_REQUEST['KPPegawaiM'] : null);
    $date = MyFormatter::getMonthId(date('m', strtotime($model->periodegaji)));
    $judulLaporan = '--- SLIP GAJI ' . strtoupper($date) . ' ---';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'PrintBaru', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'PrintBaruExcel', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintBaru', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}

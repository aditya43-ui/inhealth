<?php
class InformasiGajiPegawaiController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'penggajian.views.informasiGajiPegawai.';

  public function actionIndex($pegawai = null)
  {
    $this->pageTitle = Yii::app()->name . " - Penggajian Pegawai";
    $format = new MyFormatter();
    $pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;
    if (!empty($modelpegawai)) {
      $modelpegawai = GJPegawaiM::model()->findByPk($pegawai_id);
    } else {
      $modelpegawai = new GJPegawaiM;
    }
    $model = new GJPenggajianpegawaiV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $pegawai = $pegawai_id;
    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['GJPenggajianpegawaiV'])) {
      $model->attributes = $_GET['GJPenggajianpegawaiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJPenggajianpegawaiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJPenggajianpegawaiV']['tgl_akhir']);
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
    $modelpegawai = GJPegawaiM::model()->findByPk($pegawai_id);
    $model = PenggajianpegT::model()->findByAttributes(array('nopenggajian' => $nopenggajian));
    $modDetail = PenggajiankompT::model()->findAllByAttributes(array('penggajianpeg_id' => $model->penggajianpeg_id));
    $this->render($this->path_view . 'detailPenggajian', array(
      'modelpegawai' => $modelpegawai,
      'model' => $model,
      'modDetail' => $modDetail,
    ));
  }

  public function actionPrintPenggajian($id, $gaji_id)
  {
    $modelpegawai = GJPegawaiM::model()->findByPk($id);
    $modDetail = PenggajiankompT::model()->findAll('penggajianpeg_id = ' . $gaji_id . '');
    $model = PenggajianpegT::model()->findByPk($gaji_id);
    $modelpegawai->attributes = (isset($_REQUEST['KPPegawaiM']) ? $_REQUEST['KPPegawaiM'] : null);
    $judulLaporan = '--- Detail Penggajian Pegawai ---';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'PrintPenggajian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'PrintPenggajian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintPenggajian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}

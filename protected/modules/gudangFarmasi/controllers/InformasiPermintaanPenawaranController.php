<?php

class InformasiPermintaanPenawaranController extends MyAuthController
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $model = new GFInformasipermintaanpenawaranV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GFInformasipermintaanpenawaranV'])) {
      $model->attributes = $_GET['GFInformasipermintaanpenawaranV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasipermintaanpenawaranV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasipermintaanpenawaranV']['tgl_akhir']);
    }
    $this->render('index', array('format' => $format, 'model' => $model));
  }

  public function actionMenyetujui($permintaanpenawaran_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFInformasipermintaanpenawaranV::model()->findByAttributes(array('permintaanpenawaran_id' => $permintaanpenawaran_id));
    $modDetails = GFPenawaranDetailT::model()->findAllByAttributes(array('permintaanpenawaran_id' => $permintaanpenawaran_id));
    if ($approve) {
      $update = GFPermintaanPenawaranT::model()->updateByPk($permintaanpenawaran_id, array('tglmenyetujui' => date("Y-m-d")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('menyetujui', 'permintaanpenawaran_id' => $permintaanpenawaran_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    if ($tolak) {
      $update = GFPermintaanPenawaranT::model()->updateByPk($permintaanpenawaran_id, array('statuspenawaran' => "DITOLAK"));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('menyetujui', 'permintaanpenawaran_id' => $permintaanpenawaran_id, 'sukses' => 1, 'ditolak' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Permintaan Penawaran';
    $deskripsi = '';
    $this->render('_menyetujui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails
    ));
  }

  public function actionPrintMenyetujui($permintaanpenawaran_id)
  {
    $format = new MyFormatter();
    $model = GFInformasipermintaanpenawaranV::model()->findByAttributes(array('permintaanpenawaran_id' => $permintaanpenawaran_id));
    $modDetails = GFPenawaranDetailT::model()->findAllByAttributes(array('permintaanpenawaran_id' => $permintaanpenawaran_id));
    $judulLaporan = 'Permintaan Penawaran';
    $deskripsi = '';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printMenyetujui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printMenyetujui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printMenyetujui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionMengetahui($permintaanpenawaran_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFInformasipermintaanpenawaranV::model()->findByAttributes(array('permintaanpenawaran_id' => $permintaanpenawaran_id));
    $modDetails = GFPenawaranDetailT::model()->findAllByAttributes(array('permintaanpenawaran_id' => $permintaanpenawaran_id));
    if ($approve) {
      $update = GFPermintaanPenawaranT::model()->updateByPk($permintaanpenawaran_id, array('tglmengetahui' => date("Y-m-d"), 'statuspenawaran' => "DISETUJUI"));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('mengetahui', 'permintaanpenawaran_id' => $permintaanpenawaran_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Permintaan Penawaran';
    $deskripsi = '';
    $this->render('_mengetahui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails
    ));
  }

  public function actionPrintMengetahui($permintaanpenawaran_id)
  {
    $format = new MyFormatter();
    $model = GFInformasipermintaanpenawaranV::model()->findByAttributes(array('permintaanpenawaran_id' => $permintaanpenawaran_id));
    $modDetails = GFPenawaranDetailT::model()->findAllByAttributes(array('permintaanpenawaran_id' => $permintaanpenawaran_id));
    $judulLaporan = 'Permintaan Penawaran';
    $deskripsi = '';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printMengetahui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printMengetahui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printMengetahui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionRincian($permintaanpenawaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFInformasipermintaanpenawaranV::model()->findByAttributes(array('permintaanpenawaran_id' => $permintaanpenawaran_id));
    $modDetails = GFPenawaranDetailT::model()->findAllByAttributes(array('permintaanpenawaran_id' => $permintaanpenawaran_id));
    $judulLaporan = 'Permintaan Penawaran';
    $deskripsi = '';
    $this->render('_rincian', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails
    ));
  }
}

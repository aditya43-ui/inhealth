<?php

class InformasiPermintaanPembelianController extends MyAuthController
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $model = new GFInformasipermintaanpembelianV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GFInformasipermintaanpembelianV'])) {
      $model->attributes = $_GET['GFInformasipermintaanpembelianV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasipermintaanpembelianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasipermintaanpembelianV']['tgl_akhir']);
    }
    $this->render('index', array('format' => $format, 'model' => $model));
  }

  public function actionMenyetujui($permintaanpembelian_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFPermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $modDetails = GFPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    if ($approve) {
      $update = GFPermintaanpembelianT::model()->updateByPk($permintaanpembelian_id, array('tglmenyetujui' => date("Y-m-d")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('menyetujui', 'permintaanpembelian_id' => $permintaanpembelian_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    if ($tolak) {
      $update = GFPermintaanpembelianT::model()->updateByPk($permintaanpembelian_id, array('statuspembelian' => "DITOLAK"));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('menyetujui', 'permintaanpembelian_id' => $permintaanpembelian_id, 'sukses' => 1, 'ditolak' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Permintaan Pembelian';
    $deskripsi = '';
    $this->render('_menyetujui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails
    ));
  }

  public function actionPrintMenyetujui($permintaanpembelian_id)
  {
    $format = new MyFormatter();
    $model = GFPermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $modDetails = GFPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $judulLaporan = 'Permintaan Pembelian';
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

  public function actionMengetahui($permintaanpembelian_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFPermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $modDetails = GFPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    if ($approve) {
      $update = GFPermintaanpembelianT::model()->updateByPk($permintaanpembelian_id, array('tglmengetahui' => date("Y-m-d"), 'statuspembelian' => "DISETUJUI"));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('mengetahui', 'permintaanpembelian_id' => $permintaanpembelian_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Permintaan Pembelian';
    $deskripsi = '';
    $this->render('_mengetahui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails
    ));
  }

  public function actionPrintMengetahui($permintaanpembelian_id)
  {
    $format = new MyFormatter();
    $model = GFPermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $modDetails = GFPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $judulLaporan = 'Permintaan Pembelian';
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

  public function actionRincian($permintaanpembelian_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = GFPermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $modDetails = GFPermintaanDetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $judulLaporan = 'Permintaan Pembelian';
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

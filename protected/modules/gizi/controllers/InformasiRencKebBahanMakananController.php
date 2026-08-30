<?php

class InformasiRencKebBahanMakananController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.informasiRencKebBahanMakanan.';
  public $controllerPembelian = 'pengajuanbahanmkn';
  public $path_rencana = 'RencanaKebBahanMakanan';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Kebutuhan Bahan Makanan";
    $model = new InformasirenkebbahanmakananV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['InformasirenkebbahanmakananV'])) {
      $model->attributes = $_GET['InformasirenkebbahanmakananV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['InformasirenkebbahanmakananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasirenkebbahanmakananV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array('format' => $format, 'model' => $model));
  }

  // Aksi untuk membatalkan rencana kebutuhan Barang
  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $detail = RenkebbahanmakanandetT::model()->deleteAll('renkebbahanmakanan_id=:renkebbahanmakanan_id', array(':renkebbahanmakanan_id' => $id));
        $model = RenkebbahanmakananT::model()->deleteAll('renkebbahanmakanan_id=:renkebbahanmakanan_id', array(':renkebbahanmakanan_id' => $id));
        $transaction->commit();
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
          ));
          exit;
        }
        if (!isset($_GET['ajax']))
          $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal dihapus.');
      }
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionPrint($renkebbahanmakanan_id, $caraprint = null)
  {
    // $this->layout='//layouts/printWindows';
    // if (isset($_GET['frame'])){
    //   $this->layout='//layouts/iframe';
    //}elseif($caraprint=='EXCEL') {
    //  $this->layout='//layouts/printExcel';
    //}
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modRencanaKebBarang = RenkebbahanmakananT::model()->findByPk($renkebbahanmakanan_id);
    $criteria = new CDbCriteria();
    $criteria->addCondition('renkebbahanmakanan_id = ' . $renkebbahanmakanan_id);
    $modRencanaKebBarangDetail = RenkebbahanmakanandetT::model()->findAll($criteria);

    $judul_print = 'Rencana Kebutuhan Bahan Makanan';

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modRencanaKebBarang' => $modRencanaKebBarang,
        'modRencanaKebBarangDetail' => $modRencanaKebBarangDetail,
        'caraprint' => $caraPrint
      ));
    } elseif ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modRencanaKebBarang' => $modRencanaKebBarang,
        'modRencanaKebBarangDetail' => $modRencanaKebBarangDetail,
        'caraprint' => $caraPrint
      ));
    } elseif ($caraPrint == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->render($this->path_view . 'Print', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modRencanaKebBarang' => $modRencanaKebBarang,
        'modRencanaKebBarangDetail' => $modRencanaKebBarangDetail,
        'caraprint' => $caraPrint
      ), true));
      $mpdf->Output($judul_print . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionRincian($renkebbahanmakanan_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = InformasirenkebbahanmakananV::model()->findByAttributes(array('renkebbahanmakanan_id' => $renkebbahanmakanan_id));
    $modHead = RenkebbahanmakananT::model()->findByPk($renkebbahanmakanan_id);
    $modDetails = RenkebbahanmakanandetT::model()->findAllByAttributes(array('renkebbahanmakanan_id' => $renkebbahanmakanan_id));
    $judulLaporan = 'Rencana Kebutuhan Bahan Makanan';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->renkebbahanmakanan_tgl);
    $this->render($this->path_view . '_rincian', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modHead' => $modHead,
      'modDetails' => $modDetails
    ));
  }

  public function actionPrintInformasi($caraPrint)
  {
    $model = new InformasirenkebbahanmakananV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');


    if (isset($_GET['InformasirenkebbahanmakananV'])) {
      $model->attributes = $_GET['InformasirenkebbahanmakananV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['InformasirenkebbahanmakananV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasirenkebbahanmakananV']['tgl_akhir']);
    }

    $this->printFunction($model, $caraPrint, "Informasi Rencana Kebutuhan Bahan Makanan", $this->path_view . "printInformasi");
  }

  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    } else if ($caraPrint == "CSV") {
      CSV::konversiTabel($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
    }
  }

  public function actionApproveMenyetujui($renkebbahanmakanan_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();

    $model = RenkebbahanmakananT::model()->findByAttributes(array('renkebbahanmakanan_id' => $renkebbahanmakanan_id));
    $modDetails = RenkebbahanmakanandetT::model()->findAllByAttributes(array('renkebbahanmakanan_id' => $renkebbahanmakanan_id));
    if ($approve) {
      $update = RenkebbahanmakananT::model()->updateByPk($renkebbahanmakanan_id, array('tglmenyetujui' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMenyetujui', 'renkebbahanmakanan_id' => $renkebbahanmakanan_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Rencana Kebutuhan Bahan Makanan';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($model->renkebbahanmakanan_tgl)));
    $this->render($this->path_view . '_menyetujui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails
    ));
  }

  public function actionPrintApproveMenyetujui($renkebbahanmakanan_id)
  {
    $format = new MyFormatter();
    $model = RenkebbahanmakananT::model()->findByAttributes(array('renkebbahanmakanan_id' => $renkebbahanmakanan_id));
    $modDetails = RenkebbahanmakanandetT::model()->findAllByAttributes(array('renkebbahanmakanan_id' => $renkebbahanmakanan_id));
    $judulLaporan = 'Rencana Kebutuhan Barang Umum';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->renkebbahanmakanan_tgl);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'modDetails' => $modDetails, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}

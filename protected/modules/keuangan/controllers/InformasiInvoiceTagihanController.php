<?php

class InformasiInvoiceTagihanController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'keuangan.views.informasiInvoiceTagihan.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Invoice Tagihan";
    $model = new KUInformasiinvoicetagihanV;
    $model->unsetAttributes();  // clear any default values
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KUInformasiinvoicetagihanV'])) {
      $model->attributes = $_GET['KUInformasiinvoicetagihanV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasiinvoicetagihanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasiinvoicetagihanV']['tgl_akhir']);
    }

    $this->render('index', array(
      'model' => $model,
      'format' => $format
    ));
  }

  public function actionStatus($invoicetagihan_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = KUInvoicetagihanT::model()->findByPk($invoicetagihan_id);
    if (isset($_POST['KUInvoicetagihanT'])) {
      $model->attributes = $_POST['KUInvoicetagihanT'];
      $model->tgl_verfikasi_tagihan = $format->formatDateTimeForDb($_POST['KUInvoicetagihanT']['tgl_verfikasi_tagihan']);
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      }
    }
    $this->render('_status', array(
      'format' => $format,
      'model' => $model,
    ));
  }

  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modInvoice = KUInvoicetagihanT::model()->findByPk($id);
    $modDetPosisi = InvoicedisposisiT::model()->findAll('invoicetagihan_id = ' . $modInvoice->invoicetagihan_id);
    $modTagDet = InvoicetagdetailT::model()->findAll('invoicetagihan_id = ' . $modInvoice->invoicetagihan_id);

    $this->render('detail', array(
      'modInvoice' => $modInvoice,
      'format' => $format,
      'modDetPosisi' => $modDetPosisi,
      'modTagDet' => $modTagDet
    ));
  }
  public function actionPrint($id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modInvoice = KUInvoicetagihanT::model()->findByPk($id);
    $modDetPosisi = InvoicedisposisiT::model()->findAll('invoicetagihan_id = ' . $modInvoice->invoicetagihan_id);
    $modTagDet = InvoicetagdetailT::model()->findAll('invoicetagihan_id = ' . $modInvoice->invoicetagihan_id);

    $judul_print = 'Invoice Tagihan';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render('Print', array(
      'judul_print' => $judul_print,
      'modInvoice' => $modInvoice,
      'format' => $format,
      'modDetPosisi' => $modDetPosisi,
      'modTagDet' => $modTagDet,
      'caraPrint' => $caraPrint
    ));
  }

  public function actionBatalInvoice($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $deleteDetTagihan = KUInvoicetagdetailT::model()->deleteAllByAttributes(array('invoicetagihan_id' => $id));
      $deletePosisi = KUInvoicedisposisiT::model()->deleteAllByAttributes(array('invoicetagihan_id' => $id));
      $deleteInvoice = KUInvoicetagihanT::model()->deleteByPk($id);
      if ($deleteDetTagihan && $deletePosisi && $deleteInvoice) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }
}

<?php

class InformasiPenerimaanBarangController extends MyAuthController
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Obat Alkes";
    $model = new GFInformasipenerimaanbarangV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d', strtotime("-7 days"));
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GFInformasipenerimaanbarangV'])) {
      $model->attributes = $_GET['GFInformasipenerimaanbarangV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasipenerimaanbarangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasipenerimaanbarangV']['tgl_akhir']);
      $model->statusFaktur = isset($_GET['GFInformasipenerimaanbarangV']['statusFaktur']) ? $_GET['GFInformasipenerimaanbarangV']['statusFaktur'] : null;
      $model->pegawaipenerima_id = isset($_GET['GFInformasipenerimaanbarangV']['pegawaipenerima_id']) ? $_GET['GFInformasipenerimaanbarangV']['pegawaipenerima_id'] : null;
      $model->statusBayar = isset($_GET['GFInformasipenerimaanbarangV']['statusBayar']) ? $_GET['GFInformasipenerimaanbarangV']['statusBayar'] : null;
    }
    $this->render('index', array('format' => $format, 'model' => $model));
  }
}

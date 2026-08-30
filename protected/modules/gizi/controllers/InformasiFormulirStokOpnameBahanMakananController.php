<?php

class InformasiFormulirStokOpnameBahanMakananController extends Controller
{
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.informasiFormulirStokOpnameBahanMakanan.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Formulir Stok Opname Bahan Makanan";
    $model = new InformasiformuliropnamegiziV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['InformasiformuliropnamegiziV'])) {
      $model->attributes = $_GET['InformasiformuliropnamegiziV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['InformasiformuliropnamegiziV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['InformasiformuliropnamegiziV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array('format' => $format, 'model' => $model));
  }

  /**
   * menampilkan url untuk print karena nama controller tiap modul yg extend berbeda
   * @return type
   */
  public function getUrlPrint()
  {
    return $this->createUrl("formulirStokOpnameBahanMakanan/Print");
  }

  /**
   * menampilkan url untuk action stock opname karena nama controller tiap modul yg extend berbeda
   * @return type
   */
  public function getUrlStokOpname()
  {
    return $this->createUrl("StokOpnameBahanMakanan/Index");
  }
}

<?php

class InformasiFormulirStockOpnameObatAlkesController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiFormulirStockOpnameObatAlkes.';

  public function actionIndex($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Formulir Opname Obat Alkes";
    $model = new GFInformasiformuliropnameV;
    $format = new MyFormatter();
    $model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (Yii::app()->user->getState('ruangan_id') !== Params::RUANGAN_ID_GUDANG_FARMASI) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    if (isset($_GET['GFInformasiformuliropnameV'])) {
      $model->attributes = $_GET['GFInformasiformuliropnameV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasiformuliropnameV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasiformuliropnameV']['tgl_akhir']);
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(1284);

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'linkHalaman' => $linkHalaman
  ));
  }

  /**
   * menampilkan url untuk print karena nama controller tiap modul yg extend berbeda
   * @return type
   */
  public function getUrlPrint()
  {
    $init = '';
    if (Yii::app()->user->getState('modul_id') !== Params::MODUL_ID_GUDANGFARMASI) {
      $modModul = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
      $init = $modModul->modul_key;
    }

    return $this->createUrl("formulirStockOpnameObatAlkes".$init."/Print");
  }
  /**
   * menampilkan url untuk action stock opname karena nama controller tiap modul yg extend berbeda
   * @return type
   */
  public function getUrlStokOpname()
  {
    $init = '';
    if (Yii::app()->user->getState('modul_id') !== Params::MODUL_ID_GUDANGFARMASI) {
      $modModul = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
      $init = $modModul->modul_key;
    }
    return $this->createUrl("StockOpnameObatAlkes".$init."/Index");
  }
}

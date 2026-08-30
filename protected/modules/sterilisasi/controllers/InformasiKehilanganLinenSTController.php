<?php

//Yii::import('laundry.models.*');
//Yii::import('laundry.controllers.InformasiKehilanganLinenController');
class InformasiKehilanganLinenSTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'sterilisasi.views.informasiKehilanganLinenST.';
  public $path_tips = 'sterilisasi.views.penerimaanPeralatanSteril.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Kehilangan Alat Cssd";
    $format = new MyFormatter;
    $model = new STPenerimaansterilisasiT;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");

    if (isset($_GET['STPenerimaansterilisasiT'])) {
      $model->attributes = $_GET['STPenerimaansterilisasiT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['STPenerimaansterilisasiT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['STPenerimaansterilisasiT']['tgl_akhir']);
      $model->ruangan_id = $_GET['STPenerimaansterilisasiT']['ruangan_id'];
    }

    $linkHalaman = CustomFunction::getUrlByMenuID(3296);
    $this->render($this->path_view . 'informasi', array(
      'format' => $format,
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
  }
}

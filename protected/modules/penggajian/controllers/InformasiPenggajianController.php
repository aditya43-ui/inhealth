<?php

class InformasiPenggajianController extends MyAuthController
{
  public $path_view = 'penggajian.views.informasiPenggajian.';
  public function actionIndex()
  {
    $model = new GJInfoPenggajianpegT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GJInfoPenggajianpegT']))
      $model->attributes = $_GET['GJInfoPenggajianpegT'];

    $this->render($this->path_view . 'index', array(
      'model' => $model,
    ));
  }
}

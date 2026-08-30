<?php

class InformasiPenggajianController extends MyAuthController
{
  public function actionIndex()
  {
    $model = new KUInfoPenggajianpegT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KUInfoPenggajianpegT']))
      $model->attributes = $_GET['KUInfoPenggajianpegT'];

    $this->render('index', array(
      'model' => $model,
    ));
  }
}

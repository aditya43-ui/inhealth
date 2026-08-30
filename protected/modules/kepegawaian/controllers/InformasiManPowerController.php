<?php

class InformasiManPowerController extends MyAuthController
{
  public function actionIndex()
  {
    $model = new KPPegawaiM;
    $model->unsetAttributes();
    $model->bln_periode = date('Y-m');

    if (isset($_GET['KPPegawaiM'])) {
      $model->attributes = $_GET['KPPegawaiM'];
      $model->bln_periode = MyFormatter::formatMonthForDb($_GET['KPPegawaiM']['bln_periode']);
    }


    $this->render('index', array(
      'model' => $model,
    ));
  }
}

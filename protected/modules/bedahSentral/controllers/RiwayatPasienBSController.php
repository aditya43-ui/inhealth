<?php

class RiwayatPasienBSController extends MyAuthController
{
  public function actionIndex($id)
  {
    Yii::app()->runController("rawatJalan/daftarPasien/getRiwayatPasien", array(
      'id' => $id,
    ));
  }
}

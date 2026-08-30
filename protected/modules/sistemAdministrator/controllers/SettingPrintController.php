<?php

class SettingPrintController extends MyAuthController
{
  public function actionIndex()
  {
    if (Yii::app()->user->isGuest)
      $this->redirect(Yii::app()->homeUrl);

    if (isset($_POST['print'])) {
      Yii::app()->user->setState('ukuran_kertas', $_POST['print']['ukuranKertas']);
      Yii::app()->user->setState('posisi_kertas', $_POST['print']['posisiKertas']);
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    }
    $this->render('index');
  }
}

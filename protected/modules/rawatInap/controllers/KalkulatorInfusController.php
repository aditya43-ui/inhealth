<?php

class KalkulatorInfusController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'rawatInap.views.kalkulatorInfus.';

  public function actionIndex()
  {
    if (isset($_GET['iframe'])) {
      $this->layout = '//layouts/iframe';
    }
    $this->render($this->path_view . 'index', array());
  }

  public function actionWaktuHabis()
  {
    $this->layout = '//layouts/iframe';
    $this->render($this->path_view . 'waktuHabis', array());
  }

  public function actionTingkatTetesan()
  {
    $this->layout = '//layouts/iframe';
    $this->render($this->path_view . 'tingkatTetesan', array());
  }

  public function actionDosisObat($pendaftaran_id = null)
  {
    $this->layout = '//layouts/iframe';
    $bb = 0;
    if (!empty($pendaftaran_id)) {
      $fisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'tglperiksafisik DESC', 'limit' => 1));
      if (!empty($fisik)) {
        $bb = (!empty($fisik->beratbadan_kg) ? $fisik->beratbadan_kg : 0);
      }
    }
    $this->render($this->path_view . 'dosisObat', array(
      'bb' => $bb,
    ));
  }
}

<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterRuanganController');
class MasterRuanganMCUController extends MasterRuanganController
{
  public $defaultAction = 'index';
  public $init = '';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Master Ruangan";
    $this->render($this->path_view . 'index');
  }

  public function getUrlPegawaiRuangan()
  {
    return $this->module->id . '/RuanganpegawaiMMC/Admin';
  }

  public function getUrlKelasRuangan()
  {
    return $this->module->id . '/KelasRuanganMMC/Admin';
  }

  public function getUrlKasusPenyakitRuangan()
  {
    return $this->module->id . '/KasuspenyakitruanganMMC/Admin';
  }

  public function getUrlKasusPenyakitDiagnosa()
  {
    return $this->module->id . '/KasusPenyakitDiagnosaMC/Admin';
  }

  public function getUrlTindakanRuangan()
  {
    return $this->module->id . '/TindakanRuanganMC/Admin';
  }
}

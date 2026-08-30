<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterRuanganController');
class MasterRuanganPIController extends MasterRuanganController
{
  public $defaultAction = 'index';
  public $init = '';

  public function actionIndex()
  {
    $this->render($this->path_view . 'index');
  }

  public function getUrlPegawaiRuangan()
  {
    return $this->module->id . '/RuanganpegawaiMPI/Admin';
  }

  public function getUrlKelasRuangan()
  {
    return $this->module->id . '/KelasRuanganMPI/Admin';
  }

  public function getUrlKasusPenyakitRuangan()
  {
    return $this->module->id . '/KasuspenyakitruanganMPI/Admin';
  }

  public function getUrlKasusPenyakitDiagnosa()
  {
    return $this->module->id . '/KasusPenyakitDiagnosaPI/Admin';
  }

  public function getUrlTindakanRuangan()
  {
    return $this->module->id . '/TindakanRuanganPI/Admin';
  }
}

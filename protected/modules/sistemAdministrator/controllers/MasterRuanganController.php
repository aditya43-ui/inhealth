<?php

class MasterRuanganController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterRuangan.';
  public $init = '';

  public function actionIndex()
  {
    $this->render($this->path_view . 'index');
  }

  public function getUrlPegawaiRuangan()
  {
    return $this->module->id . '/RuanganpegawaiM/Admin';
  }

  public function getUrlKelasRuangan()
  {
    return $this->module->id . '/KelasRuanganM/Admin';
  }

  public function getUrlKasusPenyakitRuangan()
  {
    return $this->module->id . '/KasuspenyakitruanganM/Admin';
  }

  public function getUrlKasusPenyakitDiagnosa()
  {
    return $this->module->id . '/KasuspenyakitdiagnosaM/Admin';
  }

  public function getUrlTindakanRuangan()
  {
    return $this->module->id . '/TindakanRuangan/Admin';
  }
}

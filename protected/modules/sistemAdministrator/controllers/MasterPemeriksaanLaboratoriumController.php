<?php

/**
 * tabulasi:
 * - nilai rujukan
 * - jenis pemeriksaan
 * - pemeriksaan lab
 * - Detail pemeriksaan
 */
class MasterPemeriksaanLaboratoriumController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterPemeriksaanLaboratorium.';
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pemeriksaan Laboratorium";
    $this->render($this->path_view . 'index');
  }
  /**
   * untuk url tab menu
   */
  public function getUrlKelompokUmur()
  {
    return $this->module->id . "/kelompokUmurHasilLab";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlSatuanHasil()
  {
    return $this->module->id . "/satuanHasilLab";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlNilaiRujukan()
  {
    return $this->module->id . "/nilaiRujukanLab";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlJenisPemeriksaan()
  {
    return $this->module->id . "/jenisPemeriksaanLab";
  }

  public function getUrlFormLab()
  {
    return $this->module->id . "/jenisFormLab";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlSubJenisPemeriksaan()
  {
    return $this->module->id . "/subJenisPemeriksaanLab";
  }

  public function getUrlJenisFormLabDet()
  {
    return $this->module->id . "/jenisFormLabDet";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlKelompokPemeriksaan()
  {
    return $this->module->id . "/kelompokPemeriksaanLab";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlPemeriksaanLab()
  {
    return $this->module->id . "/PemeriksaanLab";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlDetailPemeriksaanLab()
  {
    return $this->module->id . "/DetailPemeriksaanLab";
  }

  // untuk jenis kegiatan lab
  public function getUrlJenisKegiatanLab()
  {
    return $this->module->id . "/JenisKegiatanLab";
  }
}

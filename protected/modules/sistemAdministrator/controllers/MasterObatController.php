<?php
class MasterObatController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterObat.';
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->render($this->path_view . 'index');
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlJenisObat()
  {
    return $this->module->id . '/JenisObatAlkesM/Admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlJenisKelompok()
  {
    return $this->module->id . '/JenisKelompok/Admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlGenerik()
  {
    return $this->module->id . '/generikM/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlAsalBarang()
  {
    return $this->module->id . '/SumberDanaM/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlTherapiObat()
  {
    return $this->module->id . '/therapiObatM/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKadarObat()
  {
    return $this->module->id . '/kadarObatM/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlSatuanKecil()
  {
    return $this->module->id . '/satuanKecilM/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlSatuanBesar()
  {
    return $this->module->id . '/satuanBesarM/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlLokasiGudang()
  {
    return $this->module->id . '/lokasiGudangM/admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKategori()
  {
    return $this->module->id . '/obatalkesKategori/admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlGolongan()
  {
    return $this->module->id . '/obatalkesGolongan/admin';
  }
}

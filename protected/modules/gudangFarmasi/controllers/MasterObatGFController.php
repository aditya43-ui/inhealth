<?php
Yii::import('sistemAdministrator.controllers.MasterObatController');
Yii::import('sistemAdministrator.models.*');

class MasterObatGFController extends MasterObatController
{
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlJenisObat()
  {
    return $this->module->id . '/JenisObatAlkesMGF/Admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlJenisKelompok()
  {
    return $this->module->id . '/JenisKelompokGF/Admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlGenerik()
  {
    return $this->module->id . '/generikMGF/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlAsalBarang()
  {
    return $this->module->id . '/SumberDanaMGF/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlTherapiObat()
  {
    return $this->module->id . '/therapiObatMGF/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKadarObat()
  {
    return $this->module->id . '/kadarObatMGF/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlSatuanKecil()
  {
    return $this->module->id . '/satuanKecilMGF/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlSatuanBesar()
  {
    return $this->module->id . '/satuanBesarMGF/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlLokasiGudang()
  {
    return $this->module->id . '/lokasiGudangMGF/admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKategori()
  {
    return $this->module->id . '/kategoriObatM/admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlGolongan()
  {
    return $this->module->id . '/golonganObatM/admin';
  }
}

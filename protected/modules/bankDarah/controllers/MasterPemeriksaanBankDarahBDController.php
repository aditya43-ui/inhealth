<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterPemeriksaanLaboratoriumController');
class MasterPemeriksaanBankDarahBDController extends MasterPemeriksaanLaboratoriumController
{
  /**
   * untuk url tab menu
   */
  public function getUrlKelompokUmur()
  {
    return $this->module->id . "/kelompokUmurHasilBankDarahBD";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlSatuanHasil()
  {
    return $this->module->id . "/satuanHasilBankDarahBD";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlNilaiRujukan()
  {
    return $this->module->id . "/nilaiRujukanBankDarahBD";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlJenisPemeriksaan()
  {
    return $this->module->id . "/jenisPemeriksaanBankDarahBD";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlKelompokPemeriksaan()
  {
    return $this->module->id . "/kelompokPemeriksaanBankDarahBD";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlPemeriksaanLab()
  {
    return $this->module->id . "/PemeriksaanBankDarahBD";
  }
  /**
   * untuk url tab menu
   */
  public function getUrlDetailPemeriksaanLab()
  {
    return $this->module->id . "/DetailPemeriksaanBankDarahBD";
  }
}

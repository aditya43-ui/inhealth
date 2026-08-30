<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterPemeriksaanLaboratoriumController');
class MasterPemeriksaanLaboratoriumLBController extends MasterPemeriksaanLaboratoriumController
{
	/**
	 * untuk url tab menu
	 */
	public function getUrlKelompokUmur(){
		return $this->module->id."/kelompokUmurHasilLabLB";
	}
	/**
	 * untuk url tab menu
	 */
	public function getUrlSatuanHasil(){
		return $this->module->id."/satuanHasilLabLB";
	}
	/**
	 * untuk url tab menu
	 */
	public function getUrlNilaiRujukan(){
		return $this->module->id."/nilaiRujukanLabLB";
	}
	/**
	 * untuk url tab menu
	 */
	public function getUrlJenisPemeriksaan(){
		return $this->module->id."/jenisPemeriksaanLabLB";
	}
	/**
	 * untuk url tab menu
	 */
	public function getUrlKelompokPemeriksaan(){
		return $this->module->id."/kelompokPemeriksaanLabLB";
	}
	/**
	 * untuk url tab menu
	 */
	public function getUrlPemeriksaanLab(){
		return $this->module->id."/PemeriksaanLabLB";
	}
	/**
	 * untuk url tab menu
	 */
	public function getUrlDetailPemeriksaanLab(){
		return $this->module->id."/DetailPemeriksaanLabLB";
	}
}


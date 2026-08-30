<?php
Yii::import('sistemAdministrator.controllers.MasterKondisiDaruratController');
Yii::import('sistemAdministrator.models.*');
class MasterKondisiDaruratHDController extends MasterKondisiDaruratController
{
	
	/**
	 * url untuk tab menu
	 * @return string
	 */
	public function getUrlKeadaanMasuk(){
		return $this->module->id."/KeadaanMasukMHD/Admin";
	}
	/**
	 * url untuk tab menu
	 * @return string
	 */
	public function getUrlTransportasi(){
		return $this->module->id."/TransportasiMHD/Admin";
	}
	/**
	 * url untuk tab menu
	 * @return string
	 */
	public function getUrlTriase(){
		return $this->module->id."/TriaseMHD/Admin";
	}
	/**
	 * url untuk tab menu
	 * @return string
	 */
	public function getUrlKondisiPulang(){
		return $this->module->id."/KondisiPulangMHD/Admin";
	}
	/**
	 * url untuk tab menu
	 * @return string
	 */
	public function getUrlCaraKeluar(){
		return $this->module->id."/CaraKeluarMHD/Admin";
	}
}

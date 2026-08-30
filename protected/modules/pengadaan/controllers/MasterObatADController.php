<?php
Yii::import('sistemAdministrator.controllers.MasterObatController');

class MasterObatADController extends MasterObatController
{
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlJenisObat(){
		return '/sistemAdministrator/JenisObatAlkesM/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlGenerik(){
		return '/sistemAdministrator/generikM/admin';
	}
        /**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlJenisKelompok(){
		return '/sistemAdministrator/JenisKelompok/Admin';
	}
        /**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlKategori(){
		return '/gudangFarmasi/kategoriObatM/admin';
	}
        /**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlGolongan(){
		return '/gudangFarmasi/golonganObatM/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAsalBarang(){
		return '/sistemAdministrator/SumberDanaM/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlTherapiObat(){
		return '/sistemAdministrator/therapiObatM/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlKadarObat(){
		return '/sistemAdministrator/kadarObatM/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlSatuanKecil(){
		return '/sistemAdministrator/satuanKecilM/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlSatuanBesar(){
		return '/sistemAdministrator/satuanBesarM/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlLokasiGudang(){
		return '/sistemAdministrator/lokasiGudangM/admin';
	}
}

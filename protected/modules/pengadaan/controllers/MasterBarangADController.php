
<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterBarangController');
class MasterBarangADController extends MasterBarangController
{
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlGolongan(){
		return $this->module->id.'/GolonganMAD/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlKelompok(){
		return $this->module->id.'/KelompokMAD/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlSubKelompok(){
		return $this->module->id.'/SubkelompokMAD/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlBidang(){
		return $this->module->id.'/BidangMAD/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlSatuanBarang(){
		return $this->module->id.'/lookupMAD/admin';
	}
        
        public function getUrlSubSubKelompok(){
		return '/sistemAdministrator/SubsubkelompokM/admin';
	}
        
        public function getUrlJenisBarang(){
		return '/sistemAdministrator/jenisbarangM/admin';
	}
}

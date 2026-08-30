<?php
Yii::import('farmasiApotek.models.*');
Yii::import('farmasiApotek.controllers.InformasipemakaiobatalkesruanganVController');
class InformasipemakaiobatalkesruanganRMController extends InformasipemakaiobatalkesruanganVController
{

	/**
	 * menampilkan url lihat karna setiap modul berbeda
	 */
	public function getUrlRincian(){
		return $this->createUrl('PemakaianObatRM/rincianDetail');
	}
	
	/**
	 * url ubah karna setiap modul berbeda
	 */
	public function getUrlUbah(){
		return $this->createUrl('PemakaianObatRM/Index');
	}
}
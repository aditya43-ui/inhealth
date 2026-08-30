<?php
Yii::import('farmasiApotek.models.*');
Yii::import('farmasiApotek.controllers.InformasipemakaiobatalkesruanganVController');
class InformasipemakaiobatalkesruanganHDController extends InformasipemakaiobatalkesruanganVController
{

	/**
	 * menampilkan url lihat karna setiap modul berbeda
	 */
	public function getUrlRincian(){
		return $this->createUrl('PemakaianObatHD/rincianDetail');
	}
	
	/**
	 * url ubah karna setiap modul berbeda
	 */
	public function getUrlUbah(){
		return $this->createUrl('PemakaianObatHD/Index');
	}
}
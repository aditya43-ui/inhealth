<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesMasukController');
class InformasiPemesananObatAlkesMasukLBController extends InformasiPemesananObatAlkesMasukController
{
	/**
	 * menampilkan url print karna setiap modul berbeda
	 */
	public function getUrlPrint(){
		return $this->createUrl('pemesananObatAlkesLB/print');
	}
	/**
	 * menampilkan url action transaksi mutasi karna setiap modul berbeda
	 */
	public function getUrlMutasi(){
		return $this->createUrl("MutasiObatAlkesLB/Index");
	}
}
<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - model yang digunakan untuk mengambil data tabel Gambarnyeri_t, hanya untuk di modul bank darah
* RSST-1498
*/
class BDGambarnyeriT extends GambarnyeriT
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
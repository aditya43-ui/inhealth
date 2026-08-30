<?php
class KUFakturdetailT extends FakturdetailT
{
    public $harganettopermaster, $namaobatmaster, $hppcheck, $harganettoper, $persenppn, $persenpph, $jmlppn, $jmlpph, $hargasatuanper, $subtotal;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
<?php
class KPPertukaranjadwalT extends PertukaranjadwalT
{
	public $ygmengajukan1_nama,$ygmengajukan2_nama,$ygmenyetujui1_nama,$ygmenyetujui2_nama,$ygmengetahui_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
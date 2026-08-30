<?php

class FAPermintaanpembelianT extends PermintaanpembelianT
{
	public $tglkadaluarsa, $total_harganetto;
	public $tgl_awal, $tgl_akhir;
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	public $tick;
	public $data;
	public $jumlah;
	public $obatAlkes;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
}
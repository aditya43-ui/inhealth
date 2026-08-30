<?php

class STTerimaperlinensterildetT extends TerimaperlinensterildetT{
	public $tgl_awal,$tgl_akhir,$instalasi_id,$ruangan_id,$penerimaansterilisasi_no;
	public $barang_nama,$ruangan_nama,$bahansterilisasi_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
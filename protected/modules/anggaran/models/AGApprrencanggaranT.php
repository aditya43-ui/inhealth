<?php

class AGApprrencanggaranT extends ApprrencanggaranT{
	public $no_urut,$programkerja_kode,$subprogramkerja_kode,$kegiatanprogram_kode;
	public $subkegiatanprogram_kode,$subkegiatanprogram_nama,$bulanrencana,$total_nilairencpeng,$nilaiapprove;
	public $nilairencpengeluaran;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

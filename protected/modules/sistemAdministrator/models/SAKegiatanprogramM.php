<?php

class SAKegiatanprogramM extends KegiatanprogramM {
	public $programkerja_id,$programkerja_kode,$subprogramkerja_kode;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
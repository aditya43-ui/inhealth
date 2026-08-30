<?php

class LAPenlinenruanganT extends PenlinenruanganT {
	public $pegawaimenerima_nama, $pegawaimengetahui_nama,$ruanganasal_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	
}


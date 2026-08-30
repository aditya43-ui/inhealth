<?php

class STPesanperlinensterildetT extends PesanperlinensterildetT{
	public $namaPeralatan, $namaLinen;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	
}
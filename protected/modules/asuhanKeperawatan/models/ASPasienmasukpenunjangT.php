<?php
class ASPasienmasukpenunjangT extends PasienmasukpenunjangT
{
	public $ruangan_nama,$jeniskasuspenyakit_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
}
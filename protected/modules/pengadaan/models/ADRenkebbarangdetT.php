<?php

class ADRenkebbarangdetT extends RenkebbarangdetT
{
	public $subtotal,$asal_barang,$barang_nama,$harga_barang;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
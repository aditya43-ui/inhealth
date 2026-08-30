<?php

class AMObatalkesPasienT extends ObatalkespasienT
{
    public $qty_stok;
	public $obatalkespasien_id,$stokobatalkes_id,$obatalkes_nama,$hargajual;
	public $satuankecil_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
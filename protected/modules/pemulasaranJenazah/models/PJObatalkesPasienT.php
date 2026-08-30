<?php

class PJObatalkesPasienT extends ObatalkespasienT
{
    public $qty_stok;
    public $stokobatalkes_id;
    public $satuankecil_nama;
    public $obatalkes_nama;
    public $hargajual;
    public $harganetto;
    public $hargasatuan;
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
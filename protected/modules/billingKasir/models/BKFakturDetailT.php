<?php

class BKFakturDetailT extends FakturdetailT
{
	public $subtotal;
	public $jmlppn;
	public $satuanobat;
	public $satuankecil_nama;
	public $satuanbesar_nama;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FakturdetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
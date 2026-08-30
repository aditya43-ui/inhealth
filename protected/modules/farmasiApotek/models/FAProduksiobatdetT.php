<?php

class FAProduksiobatdetT extends ProduksiobatdetT
{
        public $obatalkes_id, $obatalkes_kode, $obatalkes_nama, $dosis, $kemasan, $kekuatan, $satuankecil_nama; //untuk form detail
        public $stokobatalkes_id,$kemasanbesar;
        public $qtystok,$tglterima;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProduksiobatdetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}
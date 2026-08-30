<?php

class GFMutasioadetailT extends MutasioadetailT
{
        public $stokobatalkes_id;
        public $tglterima; //tanggal terima dari penerimaanbarang_t
        public $jmlstok; //stok terakhir sebelum mutasi
        public $jmlterima;
        public $harganettoterima;
        public $hargajualterim;
        public $satuankecil_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MutasioadetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
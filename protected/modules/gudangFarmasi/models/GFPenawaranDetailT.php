<?php

class GFPenawaranDetailT extends PenawarandetailT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenawarandetailT the static model class
	 */
        public $satuanobat,$subtotal,$stokakhir,$maksimalstok,$minimalstok;
        public $sumberdana_nama;
        public $obatalkes_kategori;
        public $obatalkes_nama;
        public $jmlkemasan;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
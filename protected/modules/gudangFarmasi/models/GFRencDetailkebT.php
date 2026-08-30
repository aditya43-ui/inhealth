<?php

class GFRencDetailkebT extends RencdetailkebT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencdetailkebT the static model class
	 */
        public $satuanobat,$subtotal;
        public $sumberdana_nama;
        public $obatalkes_kategori;
        public $obatalkes_nama;
		public $jenis_material;
		public $ven;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
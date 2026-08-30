<?php
class GFTerimamutasidetailT extends TerimamutasidetailT
{
        public $stokobatalkes_id;
        public $jmlkemasan;
        public $tglterima;
        public $jmlstok;
        public $harganetto;
        public $hargajualsatuan;
        public $totalharga;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimamutasidetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
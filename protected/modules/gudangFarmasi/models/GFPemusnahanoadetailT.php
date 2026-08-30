<?php
class GFPemusnahanoadetailT extends PemusnahanoadetailT
{
        public $stokobatalkes_id;
        public $ruangan_nama;
        public $hargajualsatuan;
        public $sumberdana_id;
        public $jmlstok;
        public $satuankecil_id;
        public $totalharga;
        public $ruanganasal_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemusnahanoadetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
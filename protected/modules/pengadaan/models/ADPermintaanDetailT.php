<?php

class ADPermintaanDetailT extends PermintaandetailT
{
        public $satuanobat;
        public $subtotal;
        public $diskon;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermintaandetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
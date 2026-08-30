<?php

class AKRekening4M extends Rekening4M
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
        public $kdrekening1;
        public $kdrekening2;
        public $kdrekening3;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
?>

<?php

class AKRekening2M extends Rekening2M
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
        public $kdrekening1;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
?>

<?php

class AKRekening5M extends Rekening5M
{
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public $parent_nmrekening5;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
?>

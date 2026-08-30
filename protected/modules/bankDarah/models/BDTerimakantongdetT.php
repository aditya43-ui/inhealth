<?php

class BDTerimakantongdetT extends TerimakantongdetT
{
    public $checklist,$kantongdarah_id,$detail;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TerimakantongdetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}
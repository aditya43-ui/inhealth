<?php

class ANLoketM extends LoketM
{
    public $modelantrian_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LoketM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
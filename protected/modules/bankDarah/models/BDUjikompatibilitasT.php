<?php

class BDUjikompatibilitasT extends UjikompatibilitasT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UjikompatibilitasT the static model class
	 */
	public $ujikomp_mayor, $ujikomp_minor;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
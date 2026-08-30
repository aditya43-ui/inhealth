<?php

class GFReturPembelianT extends ReturpembelianT
{
	public $nofaktur;	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturpembelianT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
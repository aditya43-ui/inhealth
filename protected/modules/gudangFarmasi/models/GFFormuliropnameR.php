<?php
class GFFormuliropnameR extends FormuliropnameR
{
    public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormuliropnameR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
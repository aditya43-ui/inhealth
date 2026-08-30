<?php

class KUTandabuktikeluarT extends TandabuktikeluarT
{
    public $pajak_nama, $totalhutang, $jmlsetoran, $sisahutang;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandabuktikeluarT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
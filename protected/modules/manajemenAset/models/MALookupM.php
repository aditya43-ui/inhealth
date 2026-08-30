<?php

class MALookupM extends LookupM
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function jenis(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("lookup_type='inventariskeadaan'");
		return self::model()->findAll($criteria);
	}
	
	public static function getItemsTipeHapus(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("lookup_type='tipepenghapusan'");
		return self::model()->findAll($criteria);
	}
}
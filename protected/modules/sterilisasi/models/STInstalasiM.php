<?php
class STInstalasiM extends InstalasiM
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getInstalasiItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('instalasi_aktif = TRUE');
		$criteria->order = "instalasi_nama";
		return self::model()->findAll($criteria);
	}
}
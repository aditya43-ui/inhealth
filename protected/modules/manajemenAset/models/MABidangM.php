<?php

class MABidangM extends BidangM
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function getBidangItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('bidang_aktif = TRUE');
		$criteria->order = "bidang_nama";
		return self::model()->findAll($criteria);
	}
}
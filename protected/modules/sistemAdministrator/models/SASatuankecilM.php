<?php

class SASatuankecilM extends SatuankecilM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SatuankecilM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("satuankecil_aktif = TRUE");
		$criteria->order = "satuankecil_nama";
		return self::model()->findAll($criteria);
	}

}
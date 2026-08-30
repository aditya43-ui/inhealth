<?php

class RKCarabayarM extends CarabayarM{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * menampilkan semua cara bayar
	 * @param type $carabayar_id
	 * @return type
	 */
	public static function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("carabayar_aktif = TRUE");
		$criteria->order = "carabayar_nama";
		return self::model()->findAll($criteria);
	}

}

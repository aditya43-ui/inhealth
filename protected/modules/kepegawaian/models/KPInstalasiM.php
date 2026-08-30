<?php
class KPInstalasiM extends InstalasiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InstalasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * menampilkan instalasi penerima mutasi
	 */
	public static function getInstalasiItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('instalasi_aktif = TRUE');
		$criteria->addNotInCondition('instalasi_id', array(Params::INSTALASI_ID_KASIR));
		$criteria->order = "instalasi_nama";
		return self::model()->findAll($criteria);
	}
}
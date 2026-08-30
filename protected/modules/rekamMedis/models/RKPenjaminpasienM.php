<?php

class RKPenjaminpasienM extends PenjaminpasienM{
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
	 * menampilkan semua penjamin
	 * @param type $carabayar_id
	 * @return type
	 */
	public static function getItems($carabayar_id = null){
		$criteria = new CDbCriteria();
		if(!empty($carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$carabayar_id);
		}
		$criteria->addCondition("penjamin_aktif = TRUE");
		$criteria->order = "penjamin_nama";
		return self::model()->findAll($criteria);

	}

}

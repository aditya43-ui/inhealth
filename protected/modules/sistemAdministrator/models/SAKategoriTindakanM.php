<?php

/**
 * This is the model class for table "kategoritindakan_m".
 *
 * The followings are the available columns in table 'kategoritindakan_m':
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property string $kategoritindakan_namalainnya
 * @property boolean $kategoritindakan_aktif
 */
class SAKategoriTindakanM extends KategoritindakanM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KategoritindakanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("kategoritindakan_aktif = TRUE");
		$criteria->order = "kategoritindakan_nama";
		
		return self::model()->findAll($criteria);
	}
}
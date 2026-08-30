<?php

/**
 * This is the model class for table "kelompokumur_m".
 *
 * The followings are the available columns in table 'kelompokumur_m':
 * @property integer $kelompokumur_id
 * @property string $kelompokumur_nama
 * @property string $kelompokumur_namalainnya
 * @property string $kelompokumur_minimal
 * @property string $kelompokumur_maksimal
 * @property boolean $kelompokumur_aktif
 */
class SAKelompokUmurM extends KelompokumurM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompokumurM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("kelompokumur_aktif = TRUE");
		$criteria->order = "kelompokumur_minimal";
		return self::model()->findAll($criteria);
	}

}
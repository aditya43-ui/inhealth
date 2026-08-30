<?php

/**
 * This is the model class for table "suku_m".
 *
 * The followings are the available columns in table 'suku_m':
 * @property integer $suku_id
 * @property string $suku_nama
 * @property string $suku_namalainnya
 * @property boolean $suku_aktif
 */
class SASukuM extends SukuM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SukuM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
}
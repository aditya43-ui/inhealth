<?php

/**
 * This is the model class for table "pendidikan_m".
 *
 * The followings are the available columns in table 'pendidikan_m':
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property string $pendidikan_namalainnya
 * @property boolean $pendidikan_aktif
 */
class KPPendidikanM extends PendidikanM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendidikanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	
}
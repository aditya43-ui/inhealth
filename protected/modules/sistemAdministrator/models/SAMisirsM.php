<?php

/**
 * This is the model class for table "misirs_m".
 *
 * The followings are the available columns in table 'misirs_m':
 * @property integer $misi_id
 * @property integer $profilrs_id
 * @property string $misi
 */
class SAMisirsM extends MisirsM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MisirsM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
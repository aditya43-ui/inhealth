<?php

/**
 * This is the model class for table "pekerjaan_m".
 *
 * The followings are the available columns in table 'pekerjaan_m':
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
 * @property string $pekerjaan_namalainnya
 * @property boolean $pekerjaan_aktif
 */
class SAPekerjaanM extends PekerjaanM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PekerjaanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
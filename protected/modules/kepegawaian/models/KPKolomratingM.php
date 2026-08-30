<?php

/**
 * This is the model class for table "kolomrating_m".
 *
 * The followings are the available columns in table 'kolomrating_m':
 * @property integer $kolomrating_id
 * @property string $kolomrating_nama
 * @property integer $kolomrating_point
 * @property integer $kolomrating_nilaiwal
 * @property integer $kolomrating_nilaiakhir
 * @property boolean $kolomrating_aktif
 */
class KPKolomratingM extends KolomratingM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KolomratingM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
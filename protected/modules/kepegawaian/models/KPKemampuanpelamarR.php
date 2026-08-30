<?php

/**
 * This is the model class for table "kemampuanpelamar_r".
 *
 * The followings are the available columns in table 'kemampuanpelamar_r':
 * @property integer $pelamar_id
 * @property string $kemampuan_nama
 * @property string $kemampuan_tingkat
 */
class KPKemampuanpelamarR extends KemampuanpelamarR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KemampuanpelamarR the static model class
	 */
	public $no_urut;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
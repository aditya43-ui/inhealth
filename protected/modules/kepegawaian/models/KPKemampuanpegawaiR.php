<?php

/**
 * This is the model class for table "kemampuanpegawai_r".
 *
 * The followings are the available columns in table 'kemampuanpegawai_r':
 * @property integer $pegawai_id
 * @property string $kemampuanpegawai_nama
 * @property string $kemampuanpegawai_tingkat
 */
class KPKemampuanpegawaiR extends KemampuanpegawaiR
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KemampuanpegawaiR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
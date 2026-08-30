<?php

/**
 * This is the model class for table "pangkat_m".
 *
 * The followings are the available columns in table 'pangkat_m':
 * @property integer $pangkat_id
 * @property integer $golonganpegawai_id
 * @property string $pangkat_nama
 * @property string $pangkat_namalainnya
 * @property boolean $pangkat_aktif
 */
class SAPangkatM extends PangkatM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PangkatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
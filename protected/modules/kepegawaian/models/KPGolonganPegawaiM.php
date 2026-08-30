<?php

/**
 * This is the model class for table "golonganpegawai_m".
 *
 * The followings are the available columns in table 'golonganpegawai_m':
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property string $golonganpegawai_namalainnya
 * @property boolean $golonganpegawai_aktif
 */
class KPGolonganPegawaiM extends GolonganpegawaiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolonganpegawaiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
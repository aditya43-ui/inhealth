<?php

/**
 * This is the model class for table "golongangaji_m".
 *
 * The followings are the available columns in table 'golongangaji_m':
 * @property integer $golongangaji_id
 * @property integer $golonganpegawai_id
 * @property integer $masakerja
 * @property double $jmlgaji
 * @property string $jenisgolongan
 * @property boolean $golongangaji_aktif
 */
class KPHariKerjaGolM extends HariKerjaGolM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GolonganGajiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
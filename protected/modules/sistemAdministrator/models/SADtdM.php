<?php

/**
 * This is the model class for table "dtd_m".
 *
 * The followings are the available columns in table 'dtd_m':
 * @property integer $dtd_id
 * @property integer $diagnosa_id
 * @property string $dtd_no
 * @property string $dtd_noterperinci
 * @property string $dtd_nama
 * @property string $dtd_namalainnya
 * @property string $dtd_katakunci
 * @property integer $dtd_nourut
 * @property boolean $dtd_menular
 * @property boolean $dtd_aktif
 */
class SADtdM extends DtdM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DtdM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
<?php

/**
 * This is the model class for table "atc_m".
 *
 * The followings are the available columns in table 'atc_m':
 * @property integer $atc_id
 * @property string $atc_kode
 * @property string $atc_nama
 * @property string $atc_namalain
 * @property string $atc_singkatan
 * @property string $atc_ddd
 * @property string $atc_units
 * @property string $atc_admr
 * @property string $atc_note
 * @property boolean $atc_aktif
 *
 * The followings are the available model relations:
 * @property ObatalkesM[] $obatalkesMs
 */
class SAAtcM extends AtcM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AtcM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
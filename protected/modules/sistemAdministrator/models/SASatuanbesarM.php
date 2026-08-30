<?php

/**
 * This is the model class for table "satuanbesar_m".
 *
 * The followings are the available columns in table 'satuanbesar_m':
 * @property integer $satuanbesar_id
 * @property string $satuanbesar_nama
 * @property string $satuanbesar_namalain
 * @property boolean $satuanbesar_aktif
 */
class SASatuanbesarM extends SatuanbesarM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SatuanbesarM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}

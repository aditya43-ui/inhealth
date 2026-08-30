<?php

/**
 * This is the model class for table "lokasigudang_m".
 *
 * The followings are the available columns in table 'lokasigudang_m':
 * @property integer $lokasigudang_id
 * @property string $lokasigudang_nama
 * @property string $lokasigudang_namalain
 * @property boolean $lokasigudang_aktif
 */
class SALokasigudangM extends LokasigudangM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LokasigudangM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}
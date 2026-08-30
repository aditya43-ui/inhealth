<?php

/**
 * This is the model class for table "jenissterilisasi_m".
 *
 * The followings are the available columns in table 'jenissterilisasi_m':
 * @property integer $jenissterilisasi_id
 * @property string $jenissterilisasi_nama
 * @property string $jenissterilisasi_namalain
 * @property boolean $jenissterilisasi_aktif
 */
class SAJenissterilisasiM extends JenissterilisasiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenissterilisasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
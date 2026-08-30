<?php

/**
 * This is the model class for table "jenisanastesi_m".
 *
 * The followings are the available columns in table 'jenisanastesi_m':
 * @property integer $jenisanastesi_id
 * @property string $jenisanastesi_nama
 * @property string $jenisanastesi_namalainnya
 * @property string $jenisanastesi_teknik
 * @property boolean $jenisanastesi_aktif
 */
class SAJenisanastesiM extends JenisanastesiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisanastesiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
<?php

/**
 * This is the model class for table "diagnosatindakan_m".
 *
 * The followings are the available columns in table 'diagnosatindakan_m':
 * @property integer $diagnosatindakan_id
 * @property string $diagnosatindakan_kode
 * @property string $diagnosatindakan_nama
 * @property string $diagnosatindakan_namalainnya
 * @property string $diagnosatindakan_katakunci
 * @property integer $diagnosatindakan_nourut
 * @property boolean $diagnosatindakan_aktif
 */
class SADiagnosaTindakanM extends DiagnosatindakanM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosatindakanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

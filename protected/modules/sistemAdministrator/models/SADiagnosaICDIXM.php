<?php

/**
 * This is the model class for table "diagnosaicdix_m".
 *
 * The followings are the available columns in table 'diagnosaicdix_m':
 * @property integer $diagnosaicdix_id
 * @property string $diagnosaicdix_kode
 * @property string $diagnosaicdix_nama
 * @property string $diagnosaicdix_namalainnya
 * @property string $diagnosatindakan_katakunci
 * @property integer $diagnosaicdix_nourut
 * @property boolean $diagnosaicdix_aktif
 */
class SADiagnosaICDIXM extends DiagnosaicdixM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosaicdixM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}
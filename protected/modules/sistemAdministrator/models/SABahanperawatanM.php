<?php

/**
 * This is the model class for table "bahanperawatan_m".
 *
 * The followings are the available columns in table 'bahanperawatan_m':
 * @property integer $bahanperawatan_id
 * @property string $bahanperawatan_jenis
 * @property string $bahanperawatan_nama
 * @property string $bahanperawatan_namalain
 * @property boolean $bahanperawatan_aktif
 */
class SABahanperawatanM extends BahanperawatanM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BahanperawatanM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
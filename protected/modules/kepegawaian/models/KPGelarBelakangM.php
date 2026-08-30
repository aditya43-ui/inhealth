<?php

/**
 * This is the model class for table "gelarbelakang_m".
 *
 * The followings are the available columns in table 'gelarbelakang_m':
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $gelarbelakang_namalainnya
 * @property boolean $gelarbelakang_aktif
 */
class KPGelarBelakangM extends GelarbelakangM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GelarbelakangM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
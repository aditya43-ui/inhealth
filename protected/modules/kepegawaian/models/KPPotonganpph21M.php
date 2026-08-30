<?php

/**
 * This is the model class for table "potonganpph21_m".
 *
 * The followings are the available columns in table 'potonganpph21_m':
 * @property integer $potonganpph21_id
 * @property double $penghasilandari
 * @property double $sampaidgn_thn
 * @property double $persentarifpenghsl
 */
class KPPotonganpph21M extends Potonganpph21M
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Potonganpph21M the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
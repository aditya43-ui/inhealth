<?php

/**
 * This is the model class for table "sumlabarugi_v".
 *
 * The followings are the available columns in table 'sumlabarugi_v':
 * @property integer $rekperiod_id
 * @property string $jenissaldo
 * @property double $laba
 * @property double $rugi
 * @property double $pajak
 */
class AKSumlabarugiV extends SumlabarugiV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SumlabarugiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}
<?php

/**
 * This is the model class for table "dtddiagnosa_m".
 *
 * The followings are the available columns in table 'dtddiagnosa_m':
 * @property integer $dtd_id
 * @property integer $diagnosa_id
 */
class SADTDDiagnosaM extends DtddiagnosaM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DtddiagnosaM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}
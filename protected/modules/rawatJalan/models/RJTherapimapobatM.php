<?php

/**
 * This is the model class for table "therapimapobat_m".
 *
 * The followings are the available columns in table 'therapimapobat_m':
 * @property integer $therapiobat_id
 * @property integer $obatalkes_id
 */
class RJTherapimapobatM extends TherapimapobatM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TherapimapobatM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
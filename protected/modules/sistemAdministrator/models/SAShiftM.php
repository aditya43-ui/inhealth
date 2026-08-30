<?php
/**
 * This is the model class for table "shift_m".
 *
 * The followings are the available columns in table 'shift_m':
 * @property integer $shift_id
 * @property string $shift_nama
 * @property string $shift_namalainnya
 * @property string $shift_jamawal
 * @property string $shift_jamakhir
 * @property boolean $shift_aktif
 */
class SAShiftM extends ShiftM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShiftM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}

<?php
class KPShiftM extends ShiftM
{
	public $ruangan_id,$ruangan_nama,$pola_shift,$jmlpegawai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShiftM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getData(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("shift_aktif = TRUE");
		$criteria->order = "shift_urutan";
		$modShift = KPShiftM::model()->findAll($criteria);
		if($modShift)
			return $modShift;
		else
			return array();
	}
}
<?php

/**
 * This is the model class for table "treadmill_t".
 *
 * The followings are the available columns in table 'treadmill_t':
 * @property integer $treadmill_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property string $tgltreadmill
 * @property string $resttime_menit
 * @property string $worktime_menit
 * @property string $recoverytime_menit
 * @property string $totaltime_menit
 * @property string $interpretation_tradmill
 * @property string $hasiltreadmill
 * @property string $namapemeriksa_treadmill
 * @property string $tingkatkebugaran
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class RJTreadmillT extends TreadmillT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TreadmillT the static model class
	 */
	public $duration_treadmill,$blood_preasure,$td_systolic,$td_diastolic,$heart_rate;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
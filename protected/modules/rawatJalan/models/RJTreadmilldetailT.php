<?php

/**
 * This is the model class for table "treadmilldetail_t".
 *
 * The followings are the available columns in table 'treadmilldetail_t':
 * @property integer $treadmilldetail_id
 * @property integer $treadmill_id
 * @property string $age_elev
 * @property string $duration_treadmill
 * @property string $workload_kph
 * @property string $est02_rate_min
 * @property string $max02_intake
 * @property string $mets_treadmill
 * @property integer $td_systolic
 * @property integer $td_diastolic
 * @property string $heartrate_treadmill
 * @property string $fitnessclassification
 * @property string $functional_class_treadmill
 * @property string $walking_kmhr_treadmill
 * @property string $jogging_kmhr_treadmill
 * @property string $bicycling_kmhr_treadmill
 * @property string $sports_kmhr_treadmill
 */
class RJTreadmilldetailT extends TreadmilldetailT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TreadmilldetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
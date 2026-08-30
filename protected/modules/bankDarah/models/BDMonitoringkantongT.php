<?php

/**
 * @author Tantowy <tantowijaya@.com>
 * 
 * class anak model modul bank darah dari model MonitoringkantongT
 *
 */

class BDMonitoringkantongT extends MonitoringkantongT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringkantongT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'monitoringkantong_t';
	}

}
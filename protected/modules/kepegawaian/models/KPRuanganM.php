<?php
class KPRuanganM extends RuanganM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RuanganM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getRuanganItems($instalasi_id = null){
		$ruanganlogin_id = Yii::app()->user->getState('ruangan_id');
		$criteria = new CDbCriteria();
		if(!empty($instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$instalasi_id);
		}
		$criteria->addCondition("ruangan_aktif = TRUE");
		$criteria->order = "ruangan_nama";
		return self::model()->findAll($criteria);
	}

}
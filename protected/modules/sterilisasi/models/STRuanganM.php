<?php
class STRuanganM extends RuanganM
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getRuanganByInstalasiST($instalasi_id = null){
		$ruanganlogin_id = Yii::app()->user->getState('ruangan_id');
		$criteria = new CDbCriteria();
		if(!empty($instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$instalasi_id);
		}
		$criteria->addCondition("ruangan_aktif = TRUE");
		$criteria->order = "ruangan_nama";
		return self::model()->findAll($criteria);
	}
	
	public static function getRuangan(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("ruangan_aktif = TRUE");
		$criteria->order = "ruangan_nama";
		return self::model()->findAll($criteria);
	}
}
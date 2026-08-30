<?php
class LARuanganM extends RuanganM
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
	
	public static function getRuanganByInstalasi($instalasi=null,$ruangan_id=array()) {
		$ruanganlogin_id = Yii::app()->user->getState('ruangan_id');
		$criteria = new CDbCriteria();
		if(!empty($instalasi)){
			$criteria->compare('instalasi_id', $instalasi);
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
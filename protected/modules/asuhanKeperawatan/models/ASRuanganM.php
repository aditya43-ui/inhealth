<?php
class ASRuanganM extends RuanganM
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
	
	public static function getRuanganByInstalasi($instalasi = '', $ruangan_id = array()){
		$ruanganlogin_id = Yii::app()->user->getState('ruangan_id');
		$criteria = new CDbCriteria();
		if(!empty($instalasi)){
			$criteria->addCondition('instalasi_id = '.$instalasi);
		}
		$criteria->addCondition("ruangan_aktif = TRUE");
		$criteria->order = "ruangan_nama";
		return self::model()->findAll($criteria);
	}
	
	public static function getRuangan(){
		$criteria = new CDbCriteria();
        $criteria->join = "join instalasi_m on instalasi_m.instalasi_id = t.instalasi_id";
		$criteria->addCondition("t.ruangan_aktif = TRUE and instalasi_m.instalasi_aktif = true");
		$criteria->order = "t.ruangan_nama";
		return self::model()->findAll($criteria);
	}
}
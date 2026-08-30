<?php

class GURuanganM extends RuanganM
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
	
	/**
	 * menampilkan ruangan penerima persediaan
	 * @param type $instalasi_id
	 * @return type
	 */
	public static function getRuanganPenerimas($instalasi_id = null){
		$criteria = new CDbCriteria();
		if(!empty($instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$instalasi_id);
		}
		$criteria->addCondition("ruangan_aktif = TRUE");
		$criteria->order = "ruangan_nama";
		return self::model()->findAll($criteria);
	}
	/**
	 * menampilkan ruangan pemesan barang
	 * @param type $instalasi_id
	 * @return type
	 */
	public static function getRuanganPemesans($instalasi_id = null){
		$criteria = new CDbCriteria();
		if(!empty($instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$instalasi_id);
		}
		$criteria->addCondition("ruangan_aktif = TRUE");
		$criteria->order = "ruangan_nama";
		return self::model()->findAll($criteria);
	}
	/**
	 * menampilkan ruangan tujuan mutasi barang
	 * @param type $instalasi_id
	 * @return type
	 */
	public static function getRuanganTujuanMutasis($instalasi_id = null){
		$ruanganlogin_id = Yii::app()->user->getState('ruangan_id');
		$criteria = new CDbCriteria();
		if(!empty($instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$instalasi_id);
		}
		$criteria->addCondition("ruangan_aktif = TRUE");
		$criteria->addNotInCondition('ruangan_id', array($ruanganlogin_id));
		$criteria->order = "ruangan_nama";
		return self::model()->findAll($criteria);
	}
	
	/**
	 * menampilkan ruangan penerima persediaan
	 * @param type $instalasi_id
	 * @return type
	 */
	public static function getRuanganStokBarangs($instalasi_id = null){
		$criteria = new CDbCriteria();
		if(!empty($instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$instalasi_id);
		}
		$criteria->addCondition("ruangan_aktif = TRUE");
		$criteria->order = "ruangan_nama";
		return self::model()->findAll($criteria);
	}
	
	public function getLokasiItems(){
		return LookupM::model()->findAllByAttributes(array('lookup_type'=>'ruangan_lokasi', 'lookup_aktif'=>true), array('order'=>'lookup_urutan'));
	}

}
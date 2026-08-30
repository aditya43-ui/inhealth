<?php

class GFInstalasiM extends InstalasiM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InstalasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         * menampilkan instalasi penerima mutasi
         */
	public static function getInstalasiTujuanMutasis(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('instalasi_aktif = TRUE');
            $criteria->addNotInCondition('instalasi_id', array(Params::INSTALASI_ID_KASIR));
            $criteria->order = "instalasi_nama";
            return self::model()->findAll($criteria);
        }
        /**
         * menampilkan instalasi yg memiliki stok obat alkes
         */
	public static function getInstalasiStokOas(){
            $criteria = new CDbCriteria();
            $criteria->addCondition('instalasi_aktif = TRUE');
            $criteria->addNotInCondition('instalasi_id', array(Params::INSTALASI_ID_KASIR));
            $criteria->order = "instalasi_nama";
            return self::model()->findAll($criteria);
        }
        /**
         * menampilkan instalasi pemesanan obat alkes
         */
	public static function getInstalasiPemesananObatAlkes(){
            $instalasilogin_id = Yii::app()->user->getState('instalasi_id');
            $criteria = new CDbCriteria();
            $criteria->addCondition('instalasi_aktif = TRUE');
            $criteria->addNotInCondition('instalasi_id', array(Params::INSTALASI_ID_KASIR));
            $criteria->order = "instalasi_nama";
            return self::model()->findAll($criteria);
        }
        
        /**
         * menampilkan instalasi pemesanan obat alkes
         */
	public static function getInstalasiPemusnahanObatAlkes(){
            $instalasilogin_id = Yii::app()->user->getState('instalasi_id');
            $criteria = new CDbCriteria();
            $criteria->addCondition('instalasi_aktif = TRUE');
            $criteria->addNotInCondition('instalasi_id', array(Params::INSTALASI_ID_KASIR));
            $criteria->order = "instalasi_nama";
            return self::model()->findAll($criteria);
        }
}
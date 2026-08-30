<?php

class GFRuanganM extends RuanganM
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
         * menampilkan ruangan tujuan mutasi
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
         * menampilkan ruangan yang memiliki stok obat
         * @param type $instalasi_id
         * @return type
         */
	public static function getRuanganStokOas($instalasi_id = null){
            $criteria = new CDbCriteria();
			if(!empty($instalasi_id)){
				$criteria->addCondition('instalasi_id = '.$instalasi_id);
			}
            $criteria->addCondition("ruangan_aktif = TRUE");
            $criteria->order = "ruangan_nama ASC";
            return self::model()->findAll($criteria);
        }
        /**
         * menampilkan ruangan pemesanan obat alkes
         * @param type $instalasi_id
         * @return type
         */
	public static function getRuanganPemesananObatAlkes($instalasi_id = null){
            $ruanganlogin_id = Yii::app()->user->getState('ruangan_id');
            $criteria = new CDbCriteria();
			if(!empty($instalasi_id)){
				$criteria->addCondition('instalasi_id = '.$instalasi_id);
			}
            $criteria->addCondition("ruangan_aktif = TRUE");
            $criteria->order = "ruangan_nama";
            return self::model()->findAll($criteria);
        }
        /**
         * menampilkan ruangan asal pemusnahan
         * @param type $instalasi_id
         * @return type
         */
	public static function getRuanganAsalPemusnahan($instalasi_id = null){
            $criteria = new CDbCriteria();
			if(!empty($instalasi_id)){
				$criteria->addCondition('instalasi_id = '.$instalasi_id);
			}
            $criteria->addCondition("ruangan_aktif = TRUE");
            $criteria->order = "ruangan_nama";
            return self::model()->findAll($criteria);
        }
}
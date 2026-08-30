<?php

/**
 * This is the model class for table "ruangan_m".
 *
 * The followings are the available columns in table 'ruangan_m':
 * @property integer $ruangan_id
 * @property integer $instalasi_id
 * @property string $ruangan_nama
 * @property string $ruangan_namalainnya
 * @property string $ruangan_lokasi
 * @property boolean $ruangan_aktif
 */
class BKRuanganM extends RuanganM {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RuanganM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    /**
     * static agar bisa menerima nilai dari parameter
     * @param type $instalasi_id
     * @return type
     */
    public static function getItems($instalasi_id = null) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("ruangan_aktif = TRUE");
        $criteria->order = 'ruangan_nama ASC';
        if (!empty($instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $instalasi_id);
            return self::model()->findAll($criteria);
        } else {
            return array();
        }
    }

    public static function getItemsList() {
        $criteria = new CDbCriteria();
        $criteria->addCondition("ruangan_aktif = TRUE");
        $criteria->order = "ruangan_nama";

        return self::model()->findAll($criteria);
    }
	
	public static function getRuanganByInstalasi($instalasi_id = null){
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

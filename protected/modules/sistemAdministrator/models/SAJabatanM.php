<?php
class SAJabatanM extends JabatanM {

    public static function model($class = __CLASS__){
        return parent::model($class);
    }
	
	public static function getJabatanItems()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('jabatan_aktif = true');
		$criteria->order = "jabatan_nama";
		return self::model()->findAll($criteria);
	}

}
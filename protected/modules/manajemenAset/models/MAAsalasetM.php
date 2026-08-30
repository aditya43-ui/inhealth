<?php

class MAAsalasetM extends AsalasetM
{
     
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	public static function getAsalAsetItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('asalaset_aktif = TRUE');
		$criteria->order = "asalaset_nama";
		return self::model()->findAll($criteria);
	}	
}
?>

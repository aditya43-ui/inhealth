<?php

class RKPeminjamanrmT extends PeminjamanrmT {


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchPengiriman()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('pendaftaran', 'warnadokrm');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

class STMonitoringsterilisasiT extends MonitoringsterilisasiT
{
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	function getOperatorItems() {
            $criteria = new CDbCriteria;
	    $criteria->join = 'LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id LEFT JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id = pegawai_m.kelompokpegawai_id';
//	    $ruangan_id = Yii::app()->user->getState('ruangan_id');
//	    $criteria->addCondition('t.ruangan_id='.$ruangan_id); 
	    $pegawai = 1;
	    $criteria->addCondition('kelompokpegawai_m.kelompokpegawai_id='.$pegawai);
	    
	    return RuanganpegawaiM::model()->findAll($criteria);   
            
        }
}
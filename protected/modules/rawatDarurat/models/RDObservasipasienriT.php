<?php

class RDObservasipasienriT extends ObservasipasienriT
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function searchRiwayatAnak($pendaftaran_id, $pasienadmisi_id)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
        if(!empty($pasienadmisi_id)){
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
        }
        
        $criteria->addCondition('isobservasi_anakbayi = true');

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function searchRiwayatDewasa($pendaftaran_id, $pasienadmisi_id)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
        if(!empty($pasienadmisi_id)){
            $criteria->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
        }
        $criteria->addCondition('isobservasi_anakbayi = false');

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}
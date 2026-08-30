<?php

class HDObservasiTransfusiDarahT extends ObservasiTransfusiDarahT
{
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienpulangT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getKantongDarah($pendaftaran_id){
        $kantong = KantongTransfusiDarahDetT::model()->findAll("pendaftaran_id = ".$pendaftaran_id);
        return $kantong;
    }
}


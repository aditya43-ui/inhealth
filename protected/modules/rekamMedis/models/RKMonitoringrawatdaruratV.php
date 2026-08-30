<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class RKMonitoringrawatdaruratV extends MonitoringrawatdaruratV {

    public static function model($className = __CLASS__) {
        parent::model($className);
    }
    
    public function getCarakeluarItems()
    {
        return CarakeluarM::model()->findAllByAttributes(array('carakeluar_aktif'=>true),array('order'=>'carakeluar_nama'));
    }
    
    public function getKondisikeluarItems()
    {
        return KondisiKeluarM::model()->findAllByAttributes(array('kondisikeluar_aktif'=>true),array('order'=>'kondisikeluar_nama'));
    }
}

?>

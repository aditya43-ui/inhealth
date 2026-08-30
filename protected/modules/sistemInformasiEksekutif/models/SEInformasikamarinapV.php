<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SEInformasikamarinapV
 *
 * @author programmer
 */
class SEInformasikamarinapV extends InformasikamarinapV {
    
    public $terpakai_bed, $total_bed;
    
    public function searchListKamar() {
        
        $cr = new CDbCriteria;
        $cr->group = 'ruangan_nama, kelaspelayanan_nama';
        $cr->select = $cr->group.", sum(case when kamarruangan_status = true then 0 else 1 end) as terpakai_bed, count(kamarruangan_id) as total_bed";
        $cr->addCondition('kamarruangan_aktif = true');
        $cr->order = 'ruangan_nama, kelaspelayanan_nama';
        $cr->compare('instalasi_id', Params::INSTALASI_ID_RI);
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$cr,
            'pagination'=>false,
        ));
    }
    
}

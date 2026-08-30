<?php

class GZInformasistokbahanmakananV extends InformasistokbahanmakananV {

    public $tgl_awal, $tgl_akhir, $ceklisminimal;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi() {
        $criteria = new CDbCriteria();
        
        if ($this->ceklisminimal == 1){			
            $criteria->addCondition('qtystok <= jmlminimal');
        }
         $criteria->compare('LOWER(namabahanmakanan)', strtolower($this->namabahanmakanan), TRUE);
         $criteria->compare('LOWER(kelbahanmakanan)',strtolower($this->kelbahanmakanan),true);
         $criteria->order = "namabahanmakanan ASC";
         
         return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function searchInformasiPrint() {
        $criteria = new CDbCriteria();
        
        if ($this->ceklisminimal == 1){			
            $criteria->addCondition('qtystok <= jmlminimal');
        }
         $criteria->compare('LOWER(namabahanmakanan)', strtolower($this->namabahanmakanan), TRUE);
         $criteria->compare('LOWER(kelbahanmakanan)',strtolower($this->kelbahanmakanan),true);
         $criteria->order = "namabahanmakanan ASC";
         
         return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
             'pagination'=>false
        ));
    }
}
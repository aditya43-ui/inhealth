<?php

class GZInformasikomposisibahanmakananV extends InformasikomposisibahanmakananV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getDokterItemsKonsul()
    {
            return DokterV::model()->findAll();
    }
   

    public function searchInformasi()
    {
            $criteria=new CDbCriteria;
            $criteria->select = "namabahanmakanan, sum(kalori) as kalori, sum(protein) as protein, sum(lemak) as lemak, sum(hidrat_arang) as hidrat_arang, sum(calsium) as calsium, sum(fosfor) as fosfor, sum(fe) as fe, sum(vit_a) as vit_a, sum(vit_b1) as vit_b1, sum(vit_c) as vit_c, sum(air) as air, sum(bkaroten) as bkaroten";
            $criteria->group = "namabahanmakanan";
            $criteria->compare('LOWER(namabahanmakanan)',strtolower($this->namabahanmakanan),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
}

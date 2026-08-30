<?php

class INInformasipenjualanresepV extends InformasipenjualanresepV {
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasipenjualanresepV the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchAntrianFarmasi() {
        $criteria=new CDbCriteria;
        if (!empty($this->racikanantrian_id)){
            $criteria->addCondition('racikanantrian_id ='.$this->racikanantrian_id);
        }
        $criteria->compare('LOWER(racikanantrian_nama)',strtolower($this->racikanantrian_nama),true);
        $criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
        $criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
        $criteria->addCondition('noantrian IS NOT NULL');
        $criteria->addCondition('pendaftaran_id IS NOT NULL');
        $criteria->compare('DATE(tglpenjualan)', date("Y-m-d"));
        $criteria->order = 'noantrian';
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function getRacikan(){
        $criteria = new CDbCriteria;
        $criteria->addCondition('racikan_aktif = TRUE');
        $criteria->order = 'racikan_id';
        return RacikanM::model()->findAll($criteria);
    }
}
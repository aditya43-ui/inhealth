<?php

class INAntrianT extends AntrianT {
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AntrianT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchAntrian() {
        $criteria=new CDbCriteria;
        
        $criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
        $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
        //$criteria->addCondition('loket_id IS NOT NULL');
        $criteria->order = 'tglantrian';
         return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
        ));
    }
    
    public function getLoket(){
        $criteria = new CDbCriteria;
        $criteria->addCondition('loket_aktif = TRUE');
        return LoketM::model()->findAll($criteria);
    }
}
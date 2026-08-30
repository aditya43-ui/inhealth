<?php

class RIPindahkamarT  extends PindahkamarT
{
    public $langsungMasukKamar = true;
    public $instalasi_id, $is_titipan;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PindahkamarT the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getInstalasiItems()
        {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('instalasi_id', Params::INSTALASI_ID_RI_ARR);
            $criteria->addCondition('instalasi_aktif is true');
            $criteria->order = 'instalasi_nama';
            return InstalasiM::model()->findAll($criteria);
        }
}
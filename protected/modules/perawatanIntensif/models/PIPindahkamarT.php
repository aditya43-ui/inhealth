<?php

class PIPindahkamarT  extends PindahkamarT
{
    public $langsungMasukKamar = true;
    public $instalasi_id, $ruangan_nama;
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
            return InstalasiM::model()->findAll('instalasi_aktif=TRUE AND instalasi_id IN (4, 79, 38, 14, 100, 20, 85) ORDER BY instalasi_nama');
        }

    public function getPindahKamar($id)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 't.*, ruangan_nama';
        $criteria->order = 'tglpindahkamar DESC';
        $criteria->limit = 1;
        $criteria->join = 'JOIN ruangan_m r on r.ruangan_id = t.ruangan_id';
        $criteria->addCondition('t. pasienadmisi_id = '. $id);

        return PIPindahkamarT::model()->findAll($criteria);
    }
    
}
<?php

class RJParamedisV extends ParamedisV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchParamedisdialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->order = 't.nama_pegawai DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));	

    }
}
?>
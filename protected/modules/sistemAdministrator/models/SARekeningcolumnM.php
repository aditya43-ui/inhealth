<?php

class SARekeningcolumnM extends RekeningcolumnM
{
    public $table_name_nama, $rekDebit, $rekKredit;

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchPrint()
    {
        $criteria=new CDbCriteria;

        if(!empty($this->rekeningcolumn_id)){
            $criteria->addCondition('rekeningcolumn_id ='.$this->rekeningcolumn_id);
        }
        $criteria->compare('table_name',$this->table_name,true);
        $criteria->compare('column_name',$this->column_name,true);
        if(!empty($this->rekening5_id)){
            $criteria->addCondition('rekening5_id ='.$this->rekening5_id);
        }
        $criteria->compare('debitkredit',$this->debitkredit,true);
        $criteria->compare('keterangan',$this->keterangan,true);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false
        ));
    }
}
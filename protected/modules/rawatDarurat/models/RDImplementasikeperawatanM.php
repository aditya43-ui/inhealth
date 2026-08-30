<?php

class RDImplementasikeperawatanM extends ImplementasikeperawatanM{

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;

				if(!empty($this->implementasikeperawatan_id)){
					$criteria->addCondition("implementasikeperawatan_id = ".$this->implementasikeperawatan_id);				
				}
				if(!empty($this->diagnosakeperawatan_id)){
					$criteria->addCondition("diagnosakeperawatan_id = ".$this->diagnosakeperawatan_id);				
				}
				if(!empty($this->rencanakeperawatan_id)){
					$criteria->addCondition("rencanakeperawatan_id = ".$this->rencanakeperawatan_id);				
				}
                $criteria->compare('LOWER(implementasikeperawatan_kode)',strtolower($this->implementasikeperawatan_kode),true);
                $criteria->compare('LOWER(implementasi_nama)',strtolower($this->implementasi_nama),true);
                $criteria->compare('iskolaborasiimplementasi',isset($this->iskolaborasiimplementasi)?$this->iskolaborasiimplementasi:true);

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }

}
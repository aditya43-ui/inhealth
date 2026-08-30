<?php

class SALinenM extends LinenM {
        
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchDialog()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria=new CDbCriteria;
            $criteria->compare('LOWER(namalinen)',strtolower($this->namalinen),true);
            $criteria->compare('LOWER(kodelinen)',strtolower($this->kodelinen),true);
            $criteria->compare('LOWER(noregisterlinen)',strtolower($this->noregisterlinen),true);
            $criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
//            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
}
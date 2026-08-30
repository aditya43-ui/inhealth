<?php
class KPLookupM extends LookupM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchAdmin()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $lookup_type = 'minatpekerjaan';
            $criteria=new CDbCriteria;

			if(!empty($this->lookup_id)){
				$criteria->addCondition("lookup_id = ".$this->lookup_id);			
			}
            $criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
            $criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
            $criteria->compare('LOWER(lookup_type)',strtolower($lookup_type),true);
            $criteria->compare('lookup_urutan',$this->lookup_urutan);
            $criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
            $criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);
            $criteria->order = 'lookup_type, lookup_urutan';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    public function searchPrint()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $lookup_type = 'minatpekerjaan';
            $criteria=new CDbCriteria;

			if(!empty($this->lookup_id)){
				$criteria->addCondition("lookup_id = ".$this->lookup_id);			
			}
            $criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
            $criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
            $criteria->compare('LOWER(lookup_type)',strtolower($lookup_type),true);
            $criteria->compare('lookup_urutan',$this->lookup_urutan);
            $criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
            $criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);
            $criteria->order = 'lookup_type, lookup_urutan';
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
}
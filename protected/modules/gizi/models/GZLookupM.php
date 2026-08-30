<?php

class GZLookupM extends LookupM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('lookup_id', $this->lookup_id);
        $criteria->compare('lookup_type', $this->lookup_type, true);
        $criteria->compare('lookup_name', $this->lookup_name, true);
        $criteria->compare('lookup_value', $this->lookup_value, true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('lookup_kode', $this->lookup_kode, true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
	
        $criteria = new CDbCriteria;

            
        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id =' . $this->lookup_id);
        }
        if (!empty($this->lookup_type)) {
             $criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
        }        
        $criteria->compare('LOWER(lookup_name)', strtolower($this->lookup_name), true);
        $criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value), true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('LOWER(lookup_kode)', strtolower($this->lookup_kode), true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    public function searchLookup($lookup_type = null) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id =' . $this->lookup_id);
        }
        if (!empty($lookup_type)) {
            $criteria->compare('LOWER(lookup_type)', strtolower($lookup_type), true);
        }
        $criteria->compare('lookup_type', $this->lookup_type, true);
        $criteria->compare('LOWER(lookup_name)', strtolower($this->lookup_name), true);
        $criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value), true);
        $criteria->compare('lookup_urutan', $this->lookup_urutan);
        $criteria->compare('LOWER(lookup_kode)', strtolower($this->lookup_kode), true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    public function searchLookupMasterRS($lookup_type = null) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->lookup_id)) {
            $criteria->addCondition('lookup_id  = ' . $this->lookup_id);
        }
        $criteria->compare('lookup_aktif', $this->lookup_aktif);
        $criteria->compare('LOWER(lookup_type)', strtolower($lookup_type), true);
        $criteria->compare('LOWER(lookup_name)', strtolower($this->lookup_name), true);
        $criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value), true);
        $criteria->compare('LOWER(lookup_urutan)', strtolower($this->lookup_urutan), true);
        $criteria->compare('LOWER(lookup_kode)', strtolower($this->lookup_kode), true);
        $criteria->compare('lookup_aktif', isset($this->lookup_aktif) ? $this->lookup_aktif : true);
        //$criteria->compare('lookup_aktif',$this->lookup_aktif);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
       

	public function searchAdmin()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.            
            $criteria=new CDbCriteria;

			if(!empty($this->lookup_id)){
				$criteria->addCondition("lookup_id = ".$this->lookup_id);			
			}
            $criteria->compare('LOWER(lookup_name)',strtolower($this->lookup_name),true);
            $criteria->compare('LOWER(lookup_value)',strtolower($this->lookup_value),true);
            $criteria->compare('LOWER(lookup_type)',strtolower($this->lookup_type),true);
            $criteria->compare('lookup_urutan',$this->lookup_urutan);
            $criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
            $criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);
            //$criteria->order = 'lookup_type, lookup_urutan';

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    
            ));
    }	

}

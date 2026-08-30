<?php
class KULookupM extends LookupM {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
   public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lookup_id',$this->lookup_id);
		$jenis = 'jenistransaksi';
		$criteria->addCondition("lookup_type= "."'".$jenis."'");
		$criteria->compare('lookup_name',$this->lookup_name,true);
		$criteria->compare('lookup_value',$this->lookup_value,true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('lookup_kode',$this->lookup_kode,true);
		//$criteria->compare('lookup_aktif',$this->lookup_aktif);
		$criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}
        
    public function searchLookup($lookup_type = null)
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;

            $criteria->compare('lookup_id',$this->lookup_id);
            if(!empty($lookup_type)){
                $criteria->compare('LOWER(lookup_type)',strtolower($lookup_type),true);
            }
            $criteria->compare('lookup_type',$this->lookup_type,true);
            $criteria->compare('lookup_name',$this->lookup_name,true);
            $jenis = 'jenistransaksi';
	    $criteria->addCondition("lookup_type= "."'".$jenis."'");
            $criteria->compare('lookup_urutan',$this->lookup_urutan);
            $criteria->compare('lookup_kode',$this->lookup_kode,true);
            //$criteria->compare('lookup_aktif',$this->lookup_aktif);
			$criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false
            ));
    }
    
    public function searchJenisTransaksi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lookup_id',$this->lookup_id);
//		$criteria->compare('lookup_type',$this->lookup_type,true);
		$jenis = 'jenistransaksi';
		$criteria->addCondition("lookup_type= "."'".$jenis."'");
		$criteria->compare('LOWER(lookup_name)',  strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value),true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('lookup_kode',$this->lookup_kode,true);
		//$criteria->compare('lookup_aktif',$this->lookup_aktif);
		$criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchBank()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lookup_id',$this->lookup_id);
//		$criteria->compare('lookup_type',$this->lookup_type,true);
		$jenis = "bank";
		$criteria->addCondition("lookup_type= "."'".$jenis."'");
		$criteria->compare('LOWER(lookup_name)',  strtolower($this->lookup_name),true);
		$criteria->compare('LOWER(lookup_value)', strtolower($this->lookup_value),true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('lookup_kode',$this->lookup_kode,true);
		//$criteria->compare('lookup_aktif',$this->lookup_aktif);
		$criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrintBank()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lookup_id',$this->lookup_id);
		$jenis = 'bank';
		$criteria->addCondition("lookup_type= "."'".$jenis."'");
		$criteria->compare('lookup_name',$this->lookup_name,true);
		$criteria->compare('lookup_value',$this->lookup_value,true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('lookup_kode',$this->lookup_kode,true);
		//$criteria->compare('lookup_aktif',$this->lookup_aktif);
		$criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}
}
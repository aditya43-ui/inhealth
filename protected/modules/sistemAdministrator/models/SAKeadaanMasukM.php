<?php

class SAKeadaanMasukM extends LookupM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JadwaldokterM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function attributeLabels()
	{
		return array(
			'lookup_id' => 'ID',
			'lookup_type' => 'Tipe',
			'lookup_name' => 'Keadaan Masuk',
			'lookup_value' => 'Isi',
			'lookup_urutan' => 'Urutan',
			'lookup_kode' => 'Kode',
			'lookup_aktif' => 'Status Aktif',
		);
	}
        
    public function searchKeadaanMasuk()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->lookup_id)){
			$criteria->addCondition("lookup_id = ".$this->lookup_id);				
		}
		$criteria->compare('lookup_type','keadaanmasuk');
		$criteria->compare('LOWER(lookup_name)',  strtolower($this->lookup_name),true);
		$criteria->compare('lookup_value',$this->lookup_value,true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('LOWER(lookup_kode)',strtolower($this->lookup_kode),true);
		$criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->lookup_id)){
			$criteria->addCondition("lookup_id = ".$this->lookup_id);				
		}
		$criteria->compare('lookup_type','keadaanmasuk');
		$criteria->compare('lookup_name',$this->lookup_name,true);
		$criteria->compare('lookup_value',$this->lookup_value,true);
		$criteria->compare('lookup_urutan',$this->lookup_urutan);
		$criteria->compare('lookup_kode',$this->lookup_kode,true);
		$criteria->compare('lookup_aktif',isset($this->lookup_aktif)?$this->lookup_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}
//    public function beforeSave() 
//   {
//        return parent::beforeSave();
//        $this->lookup_name = ucwords(strtolower($this->lookup_name));
//        $this->lookup_name = strtoupper($this->lookup_name);
//        $this->lookup_value = ucwords(strtolower($this->lookup_value));
//        $this->lookup_value = strtoupper($this->lookup_value);
//    }
}
?>

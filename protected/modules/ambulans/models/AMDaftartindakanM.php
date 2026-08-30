<?php

class AMDaftartindakanM extends DaftartindakanM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DaftartindakanM the static model class
	 */
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('komponenunit','kelompoktindakan','kategoritindakan');
		$criteria->compare('daftartindakan_id',$this->daftartindakan_id);
		if(!empty($this->komponenunit_id)){
			$criteria->addCondition('t.komponenunit_id = '.$this->komponenunit_id);
		}
		if(!empty($this->kategoritindakan_id)){
			$criteria->addCondition('t.kategoritindakan_id = '.$this->kategoritindakan_id);
		}
		if(!empty($this->kelompoktindakan_id)){
			$criteria->addCondition('t.kelompoktindakan_id = '.$this->kelompoktindakan_id);
		}
		
		$criteria->compare('LOWER(t.daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(t.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(t.tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
		$criteria->compare('LOWER(t.daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(t.daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('LOWER(kategoritindakan.kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
		$criteria->compare('LOWER(kelompoktindakan.kelompoktindakan_nama)',strtolower($this->kelompoktindakan_nama),true);
		$criteria->compare('t.daftartindakan_karcis',$this->daftartindakan_karcis);
		$criteria->compare('t.daftartindakan_visite',$this->daftartindakan_visite);
		$criteria->compare('t.daftartindakan_konsul',$this->daftartindakan_konsul);
		$criteria->compare('t.daftartindakan_akomodasi',$this->daftartindakan_akomodasi);		
		$criteria->limit = 5;
//		$dataprovider = new CActiveDataProvider(get_class($this));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
        
        public function searchDialogTarif()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($this->komponenunit_id)){
			$criteria->addCondition('t.komponenunit_id = '.$this->komponenunit_id);
		}
		if(!empty($this->kategoritindakan_id)){
			$criteria->addCondition('t.kategoritindakan_id = '.$this->kategoritindakan_id);
		}
		if(!empty($this->kelompoktindakan_id)){
			$criteria->addCondition('t.kelompoktindakan_id = '.$this->kelompoktindakan_id);
		}
		
		$criteria->compare('LOWER(t.daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(t.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(t.tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
		$criteria->compare('LOWER(t.daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(t.daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('t.daftartindakan_karcis',$this->daftartindakan_karcis);
		$criteria->compare('t.daftartindakan_visite',$this->daftartindakan_visite);
		$criteria->compare('t.daftartindakan_konsul',$this->daftartindakan_konsul);
		$criteria->compare('t.daftartindakan_akomodasi',$this->daftartindakan_akomodasi);		
		$criteria->limit = 10;
//		$dataprovider = new CActiveDataProvider(get_class($this));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//			'pagination'=>false,
		));
	} 
        
         public function searchDialogTarifAmbulan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//		if(!empty($this->komponenunit_id)){
			$criteria->addCondition("t.komponenunit_id = '".Params::KOMPONENUNIT_ID_AMBULANS."' ");
//		}
		if(!empty($this->kategoritindakan_id)){
			$criteria->addCondition('t.kategoritindakan_id = '.$this->kategoritindakan_id);
		}
		if(!empty($this->kelompoktindakan_id)){
			$criteria->addCondition('t.kelompoktindakan_id = '.$this->kelompoktindakan_id);
		}
		
		$criteria->compare('LOWER(t.daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
		$criteria->compare('LOWER(t.daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(t.tindakanmedis_nama)',strtolower($this->tindakanmedis_nama),true);
		$criteria->compare('LOWER(t.daftartindakan_namalainnya)',strtolower($this->daftartindakan_namalainnya),true);
		$criteria->compare('LOWER(t.daftartindakan_katakunci)',strtolower($this->daftartindakan_katakunci),true);
		$criteria->compare('t.daftartindakan_karcis',$this->daftartindakan_karcis);
		$criteria->compare('t.daftartindakan_visite',$this->daftartindakan_visite);
		$criteria->compare('t.daftartindakan_konsul',$this->daftartindakan_konsul);
		$criteria->compare('t.daftartindakan_akomodasi',$this->daftartindakan_akomodasi);		
		$criteria->limit = 10;
//		$dataprovider = new CActiveDataProvider(get_class($this));
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//			'pagination'=>false,
		));
	}

}
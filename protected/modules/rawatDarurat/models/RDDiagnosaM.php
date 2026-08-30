<?php


class RDDiagnosaM extends DiagnosaM
{
        public $dtd_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DiagnosaM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchRJ()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);				
		}
		if(!empty($this->klasifikasidiagnosa_id)){
			$criteria->addCondition("klasifikasidiagnosa_id = ".$this->klasifikasidiagnosa_id);				
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('diagnosa_imunisasi',$this->diagnosa_imunisasi);
		if(!empty($this->dtd_id)){
			$criteria->addCondition("dtd_id = ".$this->dtd_id);				
		}
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDiagnosis()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);				
		}
		if(!empty($this->klasifikasidiagnosa_id)){
			$criteria->addCondition("klasifikasidiagnosa_id = ".$this->klasifikasidiagnosa_id);				
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('diagnosa_imunisasi',$this->diagnosa_imunisasi);
		$criteria->compare('diagnosa_aktif',true);
		if(!empty($this->dtd_id)){
			$criteria->addCondition("dtd_id = ".$this->dtd_id);				
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                         'pagination'=>10,
		));
	}
        
        public function searchKeluhanPenyakit()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);				
		}
		if(!empty($this->klasifikasidiagnosa_id)){
			$criteria->addCondition("klasifikasidiagnosa_id = ".$this->klasifikasidiagnosa_id);				
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                         'pagination'=>10,
		));
	}
        
        public function searchImunisasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);				
		}
		if(!empty($this->klasifikasidiagnosa_id)){
			$criteria->addCondition("klasifikasidiagnosa_id = ".$this->klasifikasidiagnosa_id);				
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->condition = "diagnosa_imunisasi = true";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                         'pagination'=>10,
		));
	}
        
	public function searchDiagnosaAnamnesa()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);				
		}
		if(!empty($this->klasifikasidiagnosa_id)){
			$criteria->addCondition("klasifikasidiagnosa_id = ".$this->klasifikasidiagnosa_id);				
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                         'pagination'=>false,
		));
	}
}
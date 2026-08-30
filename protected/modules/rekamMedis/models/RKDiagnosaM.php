<?php

class RKDiagnosaM extends DiagnosaM{
	public $diagnosaawal;
	public $dtd_id;
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
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('diagnosa_imunisasi',$this->diagnosa_imunisasi);
		if(!empty($this->dtd_id)){
			$criteria->addCondition("dtd_id = ".$this->dtd_id);			
		}
		//$criteria->with=array('dtdDiagnosa');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
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
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->compare('diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('diagnosa_imunisasi',$this->diagnosa_imunisasi);
		if(!empty($this->dtd_id)){
			$criteria->addCondition("dtd_id = ".$this->dtd_id);			
		}
		//$criteria->with=array('dtdDiagnosa');

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
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		//$criteria->with=array('dtdDiagnosa');

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
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->condition = "diagnosa_imunisasi = true";
		//$criteria->with=array('dtdDiagnosa');

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

		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->compare('diagnosa_aktif',true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                         'pagination'=>false,
		));
	}
}


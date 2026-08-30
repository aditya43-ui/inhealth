<?php

class RIKasusPenyakitDiagnosaM extends KasuspenyakitdiagnosaM
{
    public $diagnosa_nourut;
    public $diagnosa_kode;
    public $diagnosa_nama;
    public $diagnosa_namalainnya;
    public $diagnosa_katakunci;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('diagnosa');
		$criteria->compare('LOWER(diagnosa.diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa.diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		$criteria->compare('LOWER(diagnosa.diagnosa_namalainnya)',strtolower($this->diagnosa_namalainnya),true);
		$criteria->compare('LOWER(diagnosa.diagnosa_katakunci)',strtolower($this->diagnosa_katakunci),true);
		$criteria->compare('diagnosa.diagnosa_nourut',$this->diagnosa_nourut);
		$criteria->compare('diagnosa.diagnosa_aktif',true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id); 	
		}
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id); 	
		}
		if(!empty($this->klasifikasidiagnosa_id)){
			$criteria->addCondition("klasifikasidiagnosa_id = ".$this->klasifikasidiagnosa_id);				
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
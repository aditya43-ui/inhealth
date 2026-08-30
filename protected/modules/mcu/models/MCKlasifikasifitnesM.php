<?php

class MCKlasifikasifitnesM  extends KlasifikasifitnesM{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->klasifikasifitnes_id)){
			$criteria->addCondition('klasifikasifitnes_id = '.$this->klasifikasifitnes_id);
		}
		$criteria->compare('LOWER(age_elev)',strtolower($this->age_elev),true);
		//$criteria->compare('LOWER(lama_menit)',strtolower($this->lama_menit),true);
		if(!empty($this->lama_menit)){
			$criteria->addCondition('lama_menit = '.$this->lama_menit);
		}
		//$criteria->compare('LOWER(workload_kph)',strtolower($this->workload_kph),true);
		if(!empty($this->workload_kph)){
			$criteria->addCondition('workload_kph= '.$this->workload_kph);
		}
		//$criteria->compare('LOWER(estimasirate)',strtolower($this->estimasirate),true);
		if(!empty($this->estimasirate)){
			$criteria->addCondition('estimasirate= '.$this->estimasirate);
		}
		//$criteria->compare('LOWER(max_intake)',strtolower($this->max_intake),true);
		if(!empty($this->max_intake)){
			$criteria->addCondition('max_intake= '.$this->max_intake);
		}
		if(!empty($this->umur_min)){
			$criteria->addCondition('umur_min = '.$this->umur_min);
		}
		if(!empty($this->umur_maks)){
			$criteria->addCondition('umur_maks = '.$this->umur_maks);
		}
		//$criteria->compare('LOWER(mets)',strtolower($this->mets),true);
		if(!empty($this->mets)){
			$criteria->addCondition('mets = '.$this->mets);
		}
		$criteria->compare('LOWER(klasifikasifitnes)',strtolower($this->klasifikasifitnes),true);
		$criteria->compare('LOWER(functional_class)',strtolower($this->functional_class),true);
	    $criteria->compare('LOWER(walking_kmhr)',strtolower($this->walking_kmhr),true);
		$criteria->compare('LOWER(jogging_kmhr)',strtolower($this->jogging_kmhr),true);
		$criteria->compare('LOWER(bicycling_kmhr)',strtolower($this->bicycling_kmhr),true);
		$criteria->compare('LOWER(other_sports)',strtolower($this->other_sports),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		if(!empty($this->klasifikasifitnes_aktif)){
			$criteria->addCondition('klasifikasifitnes_aktif = '.$this->klasifikasifitnes_aktif);
		}
		return $criteria;
	}
}
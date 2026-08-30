<?php

class GFPabrikM extends PabrikM {
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pabrik_id)){
			$criteria->addCondition('pabrik_id = '.$this->pabrik_id);
		}
		$criteria->compare('LOWER(pabrik_kode)',strtolower($this->pabrik_kode),true);
		$criteria->compare('LOWER(pabrik_nama)',strtolower($this->pabrik_nama),true);
		$criteria->compare('LOWER(pabrik_namalain)',strtolower($this->pabrik_namalain),true);
		$criteria->compare('LOWER(pabrik_alamat)',strtolower($this->pabrik_alamat),true);
		$criteria->compare('LOWER(pabrik_propinsi)',strtolower($this->pabrik_propinsi),true);
		$criteria->compare('LOWER(pabrik_kabupaten)',strtolower($this->pabrik_kabupaten),true);
		$criteria->compare('pabrik_aktif',$this->pabrik_aktif);
		//$criteria->compare('pabrik_aktif',isset($this->pabrik_aktif)?$this->pabrik_aktif:true);

		return $criteria;
	}
}

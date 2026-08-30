<?php

class STLokasipenyimpananM extends LokasipenyimpananM {
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	
	
	public function searchLokasiPenyimpanan(){
		$criteria=new CDbCriteria;

		if(!empty($this->lokasipenyimpanan_id)){
			$criteria->addCondition('lokasipenyimpanan_id = '.$this->lokasipenyimpanan_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(lokasipenyimpanan_kode)',strtolower($this->lokasipenyimpanan_kode),true);
		$criteria->compare('LOWER(lokasipenyimpanan_nama)',strtolower($this->lokasipenyimpanan_nama),true);
		$criteria->compare('LOWER(lokasipenyimpanan_namalain)',strtolower($this->lokasipenyimpanan_namalain),true);
		$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
	
}

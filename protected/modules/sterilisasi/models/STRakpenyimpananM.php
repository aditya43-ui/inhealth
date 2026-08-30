<?php

class STRakpenyimpananM extends RakpenyimpananM{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	
	
	public function searchRakPenyimpanan(){
		$criteria=new CDbCriteria;

		if(!empty($this->rakpenyimpanan_id)){
			$criteria->addCondition('rakpenyimpanan_id = '.$this->rakpenyimpanan_id);
		}
		if(!empty($this->lokasipenyimpanan_id)){
			$criteria->addCondition('lokasipenyimpanan_id = '.$this->lokasipenyimpanan_id);
		}
		$criteria->compare('LOWER(rakpenyimpanan_label)',strtolower($this->rakpenyimpanan_label),true);
		$criteria->compare('LOWER(rakpenyimpanan_kode)',strtolower($this->rakpenyimpanan_kode),true);
		$criteria->compare('LOWER(rakpenyimpanan_nama)',strtolower($this->rakpenyimpanan_nama),true);
		$criteria->compare('LOWER(rakpenyimpanan_namalain)',strtolower($this->rakpenyimpanan_namalain),true);
		$criteria->limit = 5;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}

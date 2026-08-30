<?php

class AGUnitkerjaM	extends UnitkerjaM{
	public $ruangan_nama,$ruangan_id,$nama_instalasi;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
		
	public function searchUnit(){
		$criteria=new CDbCriteria;
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		$criteria->compare('LOWER(kodeunitkerja)',strtolower($this->kodeunitkerja),true);
		$criteria->compare('LOWER(namaunitkerja)',strtolower($this->namaunitkerja),true);
		$criteria->compare('LOWER(namalain)',strtolower($this->namalain),true);
		$criteria->compare('unitkerja_aktif',$this->unitkerja_aktif);
		$criteria->limit=10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
}
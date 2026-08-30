<?php

class SAHariliburM extends HariliburM {
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchHariLibur()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->harilibur_id)){
			$criteria->addCondition('harilibur_id = '.$this->harilibur_id);
		}
		$criteria->compare('DATE(tglharilibur)',  MyFormatter::formatDateTimeForDb($this->tglharilibur));
		$criteria->compare('LOWER(namaharilibur)',strtolower($this->namaharilibur),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		$criteria->compare('harilibur_aktif',$this->harilibur_aktif);
//		$criteria->compare('LOWER(keterangan_harilibur)',strtolower($this->keterangan_harilibur),true);
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}
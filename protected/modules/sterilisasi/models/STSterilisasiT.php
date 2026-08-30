<?php
class STSterilisasiT extends SterilisasiT
{
	public $pegsterilisasi_nama,$pegmengetahui_nama;
	public $tgl_awal,$tgl_akhir,$ruangan_id, $instalasi_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(sterilisasi_tgl)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->sterilisasi_id)){
			$criteria->addCondition('sterilisasi_id = '.$this->sterilisasi_id);
		}
		$criteria->compare('LOWER(sterilisasi_no)',strtolower($this->sterilisasi_no),true);
		$criteria->compare('LOWER(sterilisasi_tgl)',strtolower($this->sterilisasi_tgl),true);
		$criteria->compare('LOWER(sterilisasi_ket)',strtolower($this->sterilisasi_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegsterilisasi_id)){
			$criteria->addCondition('pegsterilisasi_id = '.$this->pegsterilisasi_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('create_ruangan = '.$this->ruangan_id);
		}
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}
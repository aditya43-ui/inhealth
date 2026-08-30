<?php

class STPenyimpanansterilT extends PenyimpanansterilT{
	public $instalasi_id, $instalasi_nama, $ruangan_id, $ruangan_nama;
	public $tgl_awal,$tgl_akhir;
	public $rakpenyimpanan_id,$rakpenyimpanan_nama,$lokasipenyimpanan_id,$lokasipenyimpanan_nama;
	public $pegmengetahui_nama,$pegpenyimpanan_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(penyimpanansteril_tgl)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->penyimpanansteril_id)){
			$criteria->addCondition('penyimpanansteril_id = '.$this->penyimpanansteril_id);
		}
		$criteria->compare('LOWER(penyimpanansteril_no)',strtolower($this->penyimpanansteril_no),true);
		$criteria->compare('LOWER(penyimpanansteril_ket)',strtolower($this->penyimpanansteril_ket),true);
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
		if(!empty($this->pegpenyimpanan_id)){
			$criteria->addCondition('pegpenyimpanan_id = '.$this->pegpenyimpanan_id);
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
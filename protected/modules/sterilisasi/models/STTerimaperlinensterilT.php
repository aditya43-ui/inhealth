<?php

class STTerimaperlinensterilT extends TerimaperlinensterilT {
	public $pegawaipenerima_nama, $pegawaimengetahui_nama;
	public $tgl_awal,$tgl_akhir,$instalasi_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(terimaperlinensteril_tgl)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->terimaperlinensteril_id)){
			$criteria->addCondition('terimaperlinensteril_id = '.$this->terimaperlinensteril_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->kirimperlinensteril_id)){
			$criteria->addCondition('kirimperlinensteril_id = '.$this->kirimperlinensteril_id);
		}
		$criteria->compare('LOWER(terimaperlinensteril_no)',strtolower($this->terimaperlinensteril_no),true);
		$criteria->compare('LOWER(terimaperlinensteril_tgl)',strtolower($this->terimaperlinensteril_tgl),true);
		$criteria->compare('LOWER(terimaperlinensteril_ket)',strtolower($this->terimaperlinensteril_ket),true);
		if(!empty($this->pegpenerima_id)){
			$criteria->addCondition('pegpenerima_id = '.$this->pegpenerima_id);
		}
		if(!empty($this->pegmengetahui_id)){
			$criteria->addCondition('pegmengetahui_id = '.$this->pegmengetahui_id);
		}
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
		
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}
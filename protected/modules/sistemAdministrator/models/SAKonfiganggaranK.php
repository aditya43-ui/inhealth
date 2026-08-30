<?php

class SAKonfiganggaranK extends KonfiganggaranK {
	
	public $tgl, $tgl_awal, $tgl_akhir, $format;
			
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
       // $criteria->addBetweenCondition('DATE(tgl)',$this->tglanggaran,$this->sd_tglanggaran);
		
		if(!empty($this->konfiganggaran_id)){
			$criteria->addCondition('konfiganggaran_id = '.$this->konfiganggaran_id);
		}
		$criteria->compare('LOWER(deskripsiperiode)',strtolower($this->deskripsiperiode),true);
//		$criteria->compare('LOWER(tglanggaran)',strtolower($this->tglanggaran),true);
//		$criteria->compare('LOWER(sd_tglanggaran)',strtolower($this->sd_tglanggaran),true);
//		$criteria->compare('LOWER(tglrencanaanggaran)',strtolower($this->tglrencanaanggaran),true);
//		$criteria->compare('LOWER(sd_tglrencanaanggaran)',strtolower($this->sd_tglrencanaanggaran),true);
//		$criteria->compare('LOWER(tglrevisianggaran)',strtolower($this->tglrevisianggaran),true);
//		$criteria->compare('LOWER(sd_tglrevisianggaran)',strtolower($this->sd_tglrevisianggaran),true);
		$criteria->compare('DATE(tglanggaran)',  MyFormatter::formatDateTimeForDb($this->tglanggaran));
		$criteria->compare('DATE(sd_tglanggaran)',  MyFormatter::formatDateTimeForDb($this->sd_tglanggaran));
		$criteria->compare('DATE(tglrencanaanggaran)',  MyFormatter::formatDateTimeForDb($this->tglrencanaanggaran));
		$criteria->compare('DATE(sd_tglrencanaanggaran)',  MyFormatter::formatDateTimeForDb($this->sd_tglrencanaanggaran));
		$criteria->compare('DATE(tglrevisianggaran)',  MyFormatter::formatDateTimeForDb($this->tglrevisianggaran));
		$criteria->compare('DATE(sd_tglrevisianggaran)',  MyFormatter::formatDateTimeForDb($this->sd_tglrevisianggaran));
	
		$criteria->compare('isclosing_anggaran',$this->isclosing_anggaran);
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

		return $criteria;
	}
}

<?php

class RJAsuhankeperawatanT extends AsuhankeperawatanT {
    public $diagnosakeperawatan_nama;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchDetail($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->asuhankeperawatan_id)){
			$criteria->addCondition("asuhankeperawatan_id = ".$this->asuhankeperawatan_id);		
		}
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);		
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);		
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);		
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id);		
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id);		
		}
		if(!empty($data)){
			$criteria->addCondition("pendaftaran_id = ".$data);		
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);		
		}
		if(!empty($this->diagnosakeperawatan_id)){
			$criteria->addCondition("diagnosakeperawatan_id = ".$this->diagnosakeperawatan_id);		
		}
		$criteria->compare('datet(tglaskep)',strtolower($this->tglaskep),true);
		$criteria->compare('LOWER(evaluasi_subjektif)',strtolower($this->evaluasi_subjektif),true);
		$criteria->compare('LOWER(evaluasi_objektif)',strtolower($this->evaluasi_objektif),true);
		$criteria->compare('LOWER(tglassesment)',strtolower($this->tglassesment),true);
		$criteria->compare('LOWER(evaluasi_assesment)',strtolower($this->evaluasi_assesment),true);
		$criteria->compare('LOWER(askep_tujuan)',strtolower($this->askep_tujuan),true);
		$criteria->compare('LOWER(askep_kriteriahasil)',strtolower($this->askep_kriteriahasil),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->with = array('diagnosakeperawatan');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
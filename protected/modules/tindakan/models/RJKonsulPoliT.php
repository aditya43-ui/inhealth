<?php

class RJKonsulPoliT extends KonsulpoliT
{
	public $instalasi_id, $instalasi_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasiendirujukkeluarT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	public function searchDetail($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id);
		if(!empty($this->konsulpoli_id)){
			$criteria->addCondition("konsulpoli_id = ".$this->konsulpoli_id);		
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);		
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);		
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);		
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);		
		}
		$criteria->compare('LOWER(tglkonsulpoli)',strtolower($this->tglkonsulpoli),true);
		$criteria->compare('LOWER(asalpoliklinikkonsul_id)',strtolower($this->asalpoliklinikkonsul_id),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(catatan_dokter_konsul)',strtolower($this->catatan_dokter_konsul),true);
		$criteria->compare('LOWER(subjective)',strtolower($this->subjective),true);
		$criteria->compare('LOWER(objective)',strtolower($this->objective),true);
		$criteria->compare('LOWER(assessment)',strtolower($this->assessment),true);
		$criteria->compare('LOWER(planning)',strtolower($this->planning),true);
		$criteria->compare('LOWER(subjektif_jawaban)',strtolower($this->subjektif_jawaban),true);
		$criteria->compare('LOWER(objektif_jawaban)',strtolower($this->objektif_jawaban),true);
		$criteria->compare('LOWER(assesment_jawbaan)',strtolower($this->assesment_jawbaan),true);
		$criteria->compare('LOWER(planning_jawaban)',strtolower($this->planning_jawaban),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}        
	
		/**
         * Mengambil daftar semua ruangan 
         * @return CActiveDataProvider 
         */
        public function getRuanganInstalasi()
        {
			return RuanganM::model()->findAll();
        }
}
?>

<?php

class LBPasienbatalperiksaR extends PasienbatalperiksaR{
	public $tgl_awal,$tgl_akhir;
	public $nama_pasien,$no_pendaftaran,$no_rekam_medik,$no_masukpenunjang;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasiBatalPeriksa()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join = "JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id
							JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id
							JOIN pasienmasukpenunjang_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id";
		
		$criteria->addBetweenCondition('DATE(pendaftaran_t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->pasienbatalperiksa_id)){
			$criteria->addCondition("pasienbatalperiksa_id = ".$this->pasienbatalperiksa_id);		
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("t.pasien_id = ".$this->pasien_id);		
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);		
		}
		$criteria->compare('LOWER(pasienmasukpenunjang_t.no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(pasien_m.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pendaftaran_t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(pasien_m.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(tglbatal)',strtolower($this->tglbatal),true);
		$criteria->compare('LOWER(keterangan_batal)',strtolower($this->keterangan_batal),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

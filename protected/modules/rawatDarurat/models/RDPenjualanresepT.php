<?php

class RDPenjualanresepT extends PenjualanresepT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchDetailTerapi($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('obatalkes');
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("daftartindakan_id = ".$this->daftartindakan_id);				
		}
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);				
		}
		if(!empty($this->reseptur_id)){
			$criteria->addCondition("reseptur_id = ".$this->reseptur_id);				
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id);				
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);				
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);				
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);				
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);				
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);				
		}
		$criteria->condition = 't.pendaftaran_id = '.$data;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * getDetailObatTerapi untuk menampilkan detail obat terapi (obatalkespasien_t)
	 * @param type $idPenjualanResep 
	 */
	public function getObatTerapi($idPenjualanResep){
		$modObatTerapi = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$idPenjualanResep));
		return $modObatTerapi;
	}

}
<?php

class BKPasienrujukanluardokterV extends PasienrujukanluardokterV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienrujukanluardokterV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function criteriaSearch(){
            $criteria=new CDbCriteria;

			if(!empty($this->pasien_id)){
				$criteria->addCondition("pasien_id = ".$this->pasien_id);					
			}
			if(!empty($this->profilrs_id)){
				$criteria->addCondition("profilrs_id = ".$this->profilrs_id);					
			}
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
            $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
            $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('rt',$this->rt);
            $criteria->compare('rw',$this->rw);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
            $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);					
			}
            $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->tindakanpelayanan_id)){
				$criteria->addCondition("tindakanpelayanan_id = ".$this->tindakanpelayanan_id);					
			}
            $criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
            $criteria->compare('tarif_satuan',$this->tarif_satuan);
            $criteria->compare('tarif_tindakan',$this->tarif_tindakan);
            $criteria->compare('qty_tindakan',$this->qty_tindakan);
            $criteria->compare('LOWER(satuantindakan)',strtolower($this->satuantindakan),true);
            $criteria->compare('cyto_tindakan',$this->cyto_tindakan);
            $criteria->compare('tarifcyto_tindakan',$this->tarifcyto_tindakan);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);					
			}
            $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->daftartindakan_id)){
				$criteria->addCondition("daftartindakan_id = ".$this->daftartindakan_id);					
			}
            $criteria->compare('LOWER(daftartindakan_kode)',strtolower($this->daftartindakan_kode),true);
            $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
			if(!empty($this->kategoritindakan_id)){
				$criteria->addCondition("kategoritindakan_id = ".$this->kategoritindakan_id);					
			}
            $criteria->compare('LOWER(kategoritindakan_nama)',strtolower($this->kategoritindakan_nama),true);
			if(!empty($this->tindakankomponen_id)){
				$criteria->addCondition("tindakankomponen_id = ".$this->tindakankomponen_id);					
			}
			if(!empty($this->komponentarif_id)){
				$criteria->addCondition("komponentarif_id = ".$this->komponentarif_id);					
			}
            $criteria->compare('LOWER(komponentarif_nama)',strtolower($this->komponentarif_nama),true);
            $criteria->compare('iurbiayakomp',$this->iurbiayakomp);
            $criteria->compare('tarif_tindakankomp',$this->tarif_tindakankomp);
            $criteria->compare('tarifcyto_tindakankomp',$this->tarifcyto_tindakankomp);
            $criteria->compare('tarif_kompsatuan',$this->tarif_kompsatuan);
			if(!empty($this->pasienmasukpenunjang_id)){
				$criteria->addCondition("pasienmasukpenunjang_id = ".$this->pasienmasukpenunjang_id);					
			}
            $criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
            $criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
            $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
			if(!empty($this->rujukan_id)){
				$criteria->addCondition("rujukan_id = ".$this->rujukan_id);					
			}
			if(!empty($this->asalrujukan_id)){
				$criteria->addCondition("asalrujukan_id = ".$this->asalrujukan_id);					
			}
            $criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
			if(!empty($this->rujukandari_id)){
				$criteria->addCondition("rujukandari_id = ".$this->rujukandari_id);					
			}
            $criteria->compare('LOWER(namaperujuk)',strtolower($this->namaperujuk),true);
            $criteria->compare('LOWER(spesialis)',strtolower($this->spesialis),true);
            $criteria->compare('LOWER(alamatlengkap)',strtolower($this->alamatlengkap),true);
            
            return $criteria;
        }
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}
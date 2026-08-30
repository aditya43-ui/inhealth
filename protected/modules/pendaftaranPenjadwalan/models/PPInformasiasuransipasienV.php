<?php

class PPInformasiasuransipasienV extends InformasiasuransipasienV{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    public function getNamaLengkap()
    {
        return (isset($this->namadepan) ? $this->namadepan : "").' '.$this->nama_pasien;
    }
	
    public function getNamaLengkapPegawai()
    {
        return (isset($this->pegawaipenanggung_gelardepan) ? $this->pegawaipenanggung_gelardepan : "").' '.(isset($this->pegawaipenanggung_nama) ? $this->pegawaipenanggung_nama : "-").(isset($this->pegawaipenanggung_gelarbelakang) ? ', '.$this->pegawaipenanggung_gelarbelakang : "");
    }
	
    public function getKelasTanggungan()
    {
        return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'kelaspelayanan_nama ASC'));
    }
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->rt)){
			$criteria->addCondition('rt = '.$this->rt);
		}
		if(!empty($this->rw)){
			$criteria->addCondition('rw = '.$this->rw);
		}
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
		if(!empty($this->pegawaipenanggung_id)){
			$criteria->addCondition('pegawaipenanggung_id = '.$this->pegawaipenanggung_id);
		}
		$criteria->compare('LOWER(pegawaipenanggung_nip)',strtolower($this->pegawaipenanggung_nip),true);
		$criteria->compare('LOWER(pegawaipenanggung_jenisidentitas)',strtolower($this->pegawaipenanggung_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaipenanggung_noidentitas)',strtolower($this->pegawaipenanggung_noidentitas),true);
		$criteria->compare('LOWER(pegawaipenanggung_gelardepan)',strtolower($this->pegawaipenanggung_gelardepan),true);
		$criteria->compare('LOWER(pegawaipenanggung_nama)',strtolower($this->pegawaipenanggung_nama),true);
		$criteria->compare('LOWER(pegawaipenanggung_gelarbelakang)',strtolower($this->pegawaipenanggung_gelarbelakang),true);
		if(!empty($this->asuransipasien_id)){
			$criteria->addCondition('asuransipasien_id = '.$this->asuransipasien_id);
		}
		if(!empty($this->jenispeserta_id)){
			$criteria->addCondition('jenispeserta_id = '.$this->jenispeserta_id);
		}
		$criteria->compare('LOWER(jenispeserta_nama)',strtolower($this->jenispeserta_nama),true);
		$criteria->compare('LOWER(jenispeserta_keterangan)',strtolower($this->jenispeserta_keterangan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->kelastanggunganasuransi_id)){
			$criteria->addCondition('kelastanggunganasuransi_id = '.$this->kelastanggunganasuransi_id);
		}
		$criteria->compare('LOWER(kelastanggunganasuransi_nama)',strtolower($this->kelastanggunganasuransi_nama),true);
		$criteria->compare('LOWER(nokartuasuransi)',strtolower($this->nokartuasuransi),true);
		$criteria->compare('LOWER(nopeserta)',strtolower($this->nopeserta),true);
		$criteria->compare('LOWER(namapemilikasuransi)',strtolower($this->namapemilikasuransi),true);
		$criteria->compare('LOWER(hubkeluarga)',strtolower($this->hubkeluarga),true);
		$criteria->compare('LOWER(tglcetakkartuasuransi)',strtolower($this->tglcetakkartuasuransi),true);
		$criteria->compare('LOWER(tgl_konfirmasi)',strtolower($this->tgl_konfirmasi),true);
		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		$criteria->compare('LOWER(kodefeskestk1)',strtolower($this->kodefeskestk1),true);
		$criteria->compare('LOWER(nama_feskestk1)',strtolower($this->nama_feskestk1),true);
		$criteria->compare('LOWER(kodefeskesgigi)',strtolower($this->kodefeskesgigi),true);
		$criteria->compare('LOWER(namafeskesgigi)',strtolower($this->namafeskesgigi),true);
		$criteria->compare('LOWER(namaperusahaan)',strtolower($this->namaperusahaan),true);
		$criteria->compare('LOWER(nomorpokokperusahaan)',strtolower($this->nomorpokokperusahaan),true);
		$criteria->compare('LOWER(masaberlakukartu)',strtolower($this->masaberlakukartu),true);
		$criteria->compare('LOWER(nokartukeluarga)',strtolower($this->nokartukeluarga),true);
		$criteria->compare('LOWER(nopassport)',strtolower($this->nopassport),true);
		$criteria->compare('asuransipasien_aktif',$this->asuransipasien_aktif);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		
		$criteria->order='namapemilikasuransi';
		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}
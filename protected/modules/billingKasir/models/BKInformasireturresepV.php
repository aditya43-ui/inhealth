<?php
class BKInformasireturresepV extends InformasireturresepV
{
        public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasireturresepV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasiRetur()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('date(tglretur)',$this->tgl_awal,$this->tgl_akhir,true);
                
		if(!empty($this->returresep_id)){
			$criteria->addCondition('returresep_id = '.$this->returresep_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition('penjualanresep_id = '.$this->penjualanresep_id);
		}
		$criteria->compare('tglpenjualan',$this->tglpenjualan,true);
		$criteria->compare('LOWER(jenispenjualan)',strtolower($this->jenispenjualan),true);
		$criteria->compare('tglresep',$this->tglresep,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('LOWER(noresep)',strtolower($this->noresep),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
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
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('no_telepon_pasien',$this->no_telepon_pasien,true);
		$criteria->compare('no_mobile_pasien',$this->no_mobile_pasien,true);
		$criteria->compare('LOWER(warga_negara)',strtolower($this->warga_negara),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
        $criteria->compare('belumbayar', $this->belumbayar);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		$criteria->compare('tgladmisi',$this->tgladmisi,true);		
		$criteria->compare('LOWER(noreturresep)',strtolower($this->noreturresep),true);
		$criteria->compare('LOWER(alasanretur)',strtolower($this->alasanretur),true);
		$criteria->compare('LOWER(keteranganretur)',strtolower($this->keteranganretur),true);
		$criteria->compare('totalretur',$this->totalretur);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('pegawaimengetahui_nip',$this->pegawaimengetahui_nip,true);
		$criteria->compare('pegawaimengetahui_jenisidentitas',$this->pegawaimengetahui_jenisidentitas,true);
		$criteria->compare('pegawaimengetahui_noidentitas',$this->pegawaimengetahui_noidentitas,true);
		$criteria->compare('LOWER(pegawaimengetahui_gelardepan)',  strtolower($this->pegawaimengetahui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelarbelakang)',strtolower($this->pegawaimengetahui_gelarbelakang),true);
		if(!empty($this->pegawairetur_id)){
			$criteria->addCondition('pegawairetur_id = '.$this->pegawairetur_id);
		}
		$criteria->compare('pegawairetur_nip',$this->pegawairetur_nip,true);
		$criteria->compare('pegawairetur_jenisidentitas',$this->pegawairetur_jenisidentitas,true);
		$criteria->compare('pegawairetur_noidentitas',$this->pegawairetur_noidentitas,true);
		$criteria->compare('pegawairetur_gelardepan',$this->pegawairetur_gelardepan,true);
		$criteria->compare('pegawairetur_nama',$this->pegawairetur_nama,true);
		$criteria->compare('pegawairetur_gelarbelakang',$this->pegawairetur_gelarbelakang,true);
		if(!empty($this->returbayarpelayanan_id)){
			$criteria->addCondition('returbayarpelayanan_id = '.$this->returbayarpelayanan_id);
		}
		$criteria->compare('tglreturpelayanan',$this->tglreturpelayanan,true);
		$criteria->compare('noreturbayar',$this->noreturbayar,true);
		$criteria->compare('totaloaretur',$this->totaloaretur);
		if(!empty($this->tandabuktibayar_id)){
			$criteria->addCondition('tandabuktibayar_id = '.$this->tandabuktibayar_id);
		}
		$criteria->compare('tglbuktibayar',$this->tglbuktibayar,true);
		$criteria->compare('nobuktibayar',$this->nobuktibayar,true);
		if(!empty($this->tandabuktikeluar_id)){
			$criteria->addCondition('tandabuktikeluar_id = '.$this->tandabuktikeluar_id);
		}
		$criteria->compare('tglkaskeluar',$this->tglkaskeluar,true);
		$criteria->compare('nokaskeluar',$this->nokaskeluar,true);

        
        // var_dump($criteria); die;
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
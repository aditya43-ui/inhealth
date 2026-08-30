<?php
class LBInfokunjunganrjrdriV extends InfokunjunganrjrdriV
{
    public $tgl_awal,$tgl_akhir;
    public $instalasiasal_id;
    public $instalasiasal_nama;
    public $ruanganasal_id;
    public $ruanganasal_nama;
    public $nama_bin;
    public $pegawai_id;
    public $catatandokterpengirim;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganrjrdriV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir,true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('jenisidentitas',$this->jenisidentitas);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien);
		$criteria->compare('namadepan',$this->namadepan);
		$criteria->compare('LOWER(nama_pasien)',  strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(alias)', strtolower($this->alias),true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin);
		$criteria->compare('tempat_lahir',$this->tempat_lahir);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir);
		$criteria->compare('alamat_pasien',$this->alamat_pasien);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('agama',$this->agama);
		$criteria->compare('golongandarah',$this->golongandarah);
		$criteria->compare('photopasien',$this->photopasien);
		$criteria->compare('alamatemail',$this->alamatemail);
		$criteria->compare('statusrekammedis',$this->statusrekammedis);
		$criteria->compare('statusperkawinan',$this->statusperkawinan);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik);
		$criteria->compare('tgl_rekam_medik',$this->tgl_rekam_medik);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran);
		$criteria->compare('no_urutantri',$this->no_urutantri);
		$criteria->compare('transportasi',$this->transportasi);
		$criteria->compare('keadaanmasuk',$this->keadaanmasuk);
		$criteria->compare('statusperiksa',$this->statusperiksa);
		$criteria->compare('statuspasien',$this->statuspasien);
		$criteria->compare('kunjungan',$this->kunjungan);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('statusmasuk',$this->statusmasuk);
		$criteria->compare('umur',$this->umur);
		$criteria->compare('no_asuransi',$this->no_asuransi);
		$criteria->compare('namapemilik_asuransi',$this->namapemilik_asuransi);
		$criteria->compare('nopokokperusahaan',$this->nopokokperusahaan);
		$criteria->compare('create_time',$this->create_time);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		$criteria->compare('create_ruangan',$this->create_ruangan);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',  strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama));
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition('caramasuk_id = '.$this->caramasuk_id);
		}
		$criteria->compare('caramasuk_nama',$this->caramasuk_nama);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition('golonganumur_id = '.$this->golonganumur_id);
		}
		$criteria->compare('golonganumur_nama',$this->golonganumur_nama);
		$criteria->compare('no_rujukan',$this->no_rujukan);
		$criteria->compare('nama_perujuk',$this->nama_perujuk);
		$criteria->compare('tanggal_rujukan',$this->tanggal_rujukan);
		$criteria->compare('diagnosa_rujukan',$this->diagnosa_rujukan);
		if(!empty($this->asalrujukan_id)){
			$criteria->addCondition('asalrujukan_id = '.$this->asalrujukan_id);
		}
		$criteria->compare('asalrujukan_nama',$this->asalrujukan_nama);
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition('penanggungjawab_id = '.$this->penanggungjawab_id);
		}
		$criteria->compare('pengantar',$this->pengantar);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga);
		$criteria->compare('nama_pj',$this->nama_pj);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('ruangan_nama',$this->ruangan_nama);
		$criteria->compare('ruangan_singkatan',$this->ruangan_singkatan);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('instalasi_nama',$this->instalasi_nama);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama);
		$criteria->compare('gelardepan',$this->gelardepan);
		$criteria->compare('nama_pegawai',$this->nama_pegawai);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->masukkamar_id)){
			$criteria->addCondition('masukkamar_id = '.$this->masukkamar_id);
		}
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getNamaNamaAlias(){
            return $this->nama_pasien." /<br> ".$this->alias;
        }
        
        public function getSapaanPasien(){
            return $this->namadepan." ".$this->nama_pasien;
        }
        
        public function getNamaLengkap(){
            return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama;
        }
}
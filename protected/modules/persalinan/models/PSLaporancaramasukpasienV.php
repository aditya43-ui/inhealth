<?php

class PSLaporancaramasukpasienV extends LaporancaramasukpasienV {
	
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir,$tglAwal,$tglAkhir;
	public $data, $tick, $jumlah;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
       
        $criteria->select = "count(pendaftaran_id) as jumlah, (CASE WHEN asalrujukan_id IS NULL THEN 'Tidak Ada Rujukan' ELSE asalrujukan_nama END) as data";
		$criteria->group = "asalrujukan_id, asalrujukan_nama";
        
        

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    protected function functionCriteria() {

        $criteria = new CDbCriteria;

        if(is_array($this->asalrujukan_id)){
            $criteria->addInCondition("asalrujukan_id", $this->asalrujukan_id);
        }else{
            if (!empty($this->asalrujukan_id)){
                $criteria->addCondition("asalrujukan_id", $this->asalrujukan_id);
            }
        }	
        
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id ='.$this->shift_id);
		}

		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id ='.$this->jeniskasuspenyakit_id);
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);		
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id ='.$this->pasienadmisi_id);
		}
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		if(!empty($this->pasienkirimkeunitlain_id)){
			$criteria->addCondition('pasienkirimkeunitlain_id ='.$this->pasienkirimkeunitlain_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id ='.$this->pegawai_id);
		}
		if(!empty($this->rujukan_id)){
			$criteria->addCondition('rujukan_id ='.$this->rujukan_id);
		}

        $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
        $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
        $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
        $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
        $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
        
        return $criteria;
    }

}

?>

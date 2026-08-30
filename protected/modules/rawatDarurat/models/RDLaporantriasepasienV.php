<?php

class RDLaporantriasepasienV extends LaporantriasepasienV{
    
    public $tick, $jumlah, $data,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir, $jns_periode;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchGrafik() {

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        $criteria->select = 'count(pendaftaran_id) as jumlah, triase_nama as data';
        $criteria->group = 'triase_nama';//pendaftaran_id
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    public function searchPrint() {

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false,
        ));
    }
    public function searchTable() {

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    protected function functionCriteria()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);				
		}
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
//		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id);				
		}
//		if(!empty($this->ruangan_id)){
//			$criteria->addCondition("ruangan_id =".$this->ruangan_id);				
//		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
                
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
                
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);				
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("rujukan_id = ".$this->rujukan_id);				
		}
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition("pasienpulang_id = ".$this->pasienpulang_id);				
		}
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('LOWER(satuanlamarawat)',strtolower($this->satuanlamarawat),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		if(!empty($this->pasienbatalpulang_id)){
			$criteria->addCondition("pasienbatalpulang_id = ".$this->pasienbatalpulang_id);				
		}
		if (is_array($this->triase_id)){
			$criteria->addInCondition('triase_id',$this->triase_id);
		}
		else{
			$criteria->addCondition('triase_id is null');
		}
		$criteria->compare('LOWER(triase_nama)',strtolower($this->triase_nama),true);
		$criteria->compare('LOWER(warna_triase)',strtolower($this->warna_triase),true);
		$criteria->compare('LOWER(kode_warnatriase)',strtolower($this->kode_warnatriase),true);
		$criteria->compare('LOWER(keterangan_triase)',strtolower($this->keterangan_triase),true);
		if(!empty($this->anamesa_id)){
			$criteria->addCondition("anamesa_id = ".$this->anamesa_id);				
		}
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition("diagnosa_id = ".$this->diagnosa_id);				
		}
		$criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
		$criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);

		return $criteria;
	}
        
        public function getNoPenNoRM(){
            return $this->no_pendaftaran.'/'.PHP_EOL.$this->no_rekam_medik;
        }
        
        public function getNamaBin(){
            return $this->nama_pasien.'/'.PHP_EOL.$this->nama_bin;
        }
        
        public function getAlamatRtRw(){
            return $this->alamat_pasien.'/'.PHP_EOL.' RT.'.$this->rt.'/ RW.'.$this->rw;
        }
        
        public function getJenisKelaminUmur(){
            return $this->jeniskelamin.'/'.PHP_EOL.$this->umur;
        }
        
        public function getCaraBayarPenjamin(){
            return $this->carabayar_nama.'/'.PHP_EOL.$this->penjamin_nama;
        }        
        
        public function getCaraKeluarKondisi(){
            return $this->carakeluar.'/'.PHP_EOL.$this->kondisipulang;
        }
}

?>

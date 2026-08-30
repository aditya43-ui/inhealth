<?php

class RDLaporanpasienkecelakaanV extends LaporanpasienkecelakaanV
{
    public $jumlah, $tick, $data, $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
//    public function getTanggal(){
//        return $this->tgl_pendaftaran."  /   ".$this->tglkecelakaan;
//    }
    public function getRM(){
        return $this->no_pendaftaran."  /   ".$this->no_rekam_medik;
    }
    public function getNama(){
        return $this->nama_pasien."   /   ".$this->nama_bin;
    }
    public function getUmur(){
        return $this->jeniskelamin."   /   ".$this->umur;
    }
    public function getStatus(){
        return $this->golongandarah."   /   ".$this->statusperiksa;
    }
    public function getTransportasi(){
        return $this->transportasi."   /   ".$this->keadaanmasuk;
    }

    public function getCarabayar(){
        return $this->carabayar_nama."   /   ".$this->penjamin_nama;
    }
    public function getAlamat(){
        return $this->alamat_pasien."   RT.   ".$this->rt."   RW.   ".$this->rw;
    }
    public function searchTable(){
        $criteria=new CDbCriteria;
        $criteria = $this->functionCriteria();
        $criteria->order = "tgl_pendaftaran ASC";
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function searchGrafik(){
        $criteria=new CDbCriteria;
        $criteria = $this->functionCriteria();
        $criteria->select = 'count(pendaftaran_id) as jumlah';
        if (isset($_GET['filter']) == 'wilayah') {
            if (!empty($this->kelurahan_id)) {
                $criteria->select .= ', kelurahan_nama as data';
                $criteria->group = 'kelurahan_nama';
            } else if (!empty($this->kecamatan_id)) {
                $criteria->select .= ', kelurahan_nama as data';
                $criteria->group = 'kelurahan_nama';
            } else if (!empty($this->kabupaten_id)) {
                $criteria->select .= ', kecamatan_nama as data';
                $criteria->group = 'kecamatan_nama';
            } else if (!empty($this->propinsi_id)) {
                $criteria->select .= ', kabupaten_nama as data';
                $criteria->group = 'kabupaten_nama';
            } else {
                $criteria->select .= ', propinsi_nama as data';
                $criteria->group = 'propinsi_nama';
            }
        }    
        else {
            $criteria->select .= ', jeniskecelakaan_nama as data';
            $criteria->group .= 'jeniskecelakaan_nama';
        }
        

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function searchPrint(){
        $criteria=new CDbCriteria;

        $criteria = $this->functionCriteria();
        $criteria->order = "tgl_pendaftaran ASC";
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    protected function functionCriteria(){

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
		if(!empty($this->propinsi_id)){
			$criteria->addInCondition("propinsi_id", $this->propinsi_id);				
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addInCondition("kabupaten_id", $this->kabupaten_id);				
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
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
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
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
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);				
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);				
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->pasienkecelakaan_id)){
			$criteria->addCondition("pasienkecelakaan_id = ".$this->pasienkecelakaan_id);				
		}
		if(!empty($this->jeniskecelakaan_id)){
			$criteria->addInCondition("jeniskecelakaan_id",$this->jeniskecelakaan_id);				
		}
		$criteria->compare('LOWER(jeniskecelakaan_nama)',strtolower($this->jeniskecelakaan_nama),true);
		$criteria->compare('LOWER(tglkecelakaan)',strtolower($this->tglkecelakaan),true);
		$criteria->compare('LOWER(tempatkecelakaan)',strtolower($this->tempatkecelakaan),true);
		$criteria->compare('LOWER(keterangankecelakaan)',strtolower($this->keterangankecelakaan),true);

		return $criteria;
    }
        public function getNamaModel(){
        return __CLASS__;
    }

	/**
	 * Mengambil daftar semua propinsi
	 * @return CActiveDataProvider 
	 */
	public function getPropinsiItems()
	{
		return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
	}
	
	/**
	 * Mengambil daftar semua kabupaten berdasarkan propinsi
	 * @return CActiveDataProvider 
	 */
	public function getKabupatenItems($propinsi_id=null)
	{
		$criteria = new CDbCriteria();
		if(!empty($propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$propinsi_id); 			
		}
		$criteria->compare('kabupaten_aktif', true);
		$criteria->order='kabupaten_nama';
		$models = KabupatenM::model()->findAll($criteria);
		return $models;
	}
	/**
	 * Mengambil daftar semua kecamatan berdasarkan kabupaten
	 * @return CActiveDataProvider 
	 */
	public function getKecamatanItems($kabupaten_id=null)
	{
		$criteria = new CDbCriteria();
		if(!empty($kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$kabupaten_id); 			
		}
		$criteria->compare('kecamatan_aktif', true);
		$criteria->order='kecamatan_nama';
		$models = KecamatanM::model()->findAll($criteria);
		return $models;
	}
	
	/**
	 * Mengambil daftar semua kelurahan berdasarkan kecamatan
	 * @return CActiveDataProvider 
	 */
	public function getKelurahanItems($kecamatan_id=null)
	{
		$criteria = new CDbCriteria();
		if(!empty($kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$kecamatan_id); 			
		}
		$criteria->compare('kelurahan_aktif', true);
		$criteria->order='kelurahan_nama';
		$models = KelurahanM::model()->findAll($criteria);
		return $models;
	}

}
?>

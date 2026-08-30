<?php
class PPLaporankunjunganbydokterV extends LaporankunjunganbydokterV
{
    
    public $nama_pegawai;
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
      public static function model($className = __CLASS__) {
        return parent::model($className);
     }
     
     public function searchTable() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'tgl_pendaftaran DESC, instalasi_nama ASC, ruangan_nama ASC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
     }
     
     public function searchPrint() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'tgl_pendaftaran DESC, instalasi_nama ASC, ruangan_nama ASC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false
                ));
     }
     
     protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        if(!empty($this->ruangan_id)){                    
             $criteria->addInCondition('ruangan_id', $this->ruangan_id);
        }else{
            if (!empty($this->instalasi_id)){
                $criteria->addInCondition("instalasi_id ",$this->instalasi_id);
            }
        }
        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
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
        $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
        if(!empty($this->pendaftaran_id)){
                $criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 			
        }
        $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
        $criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
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
        if(!empty($this->shift_id)){
                $criteria->addCondition("shift_id = ".$this->shift_id); 			
        }		
						
        if(!empty($this->jeniskasuspenyakit_id)){
                $criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id); 			
        }
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
        if(!empty($this->kelaspelayanan_id)){
                $criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 			
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        if(!empty($this->rujukan_id)){
                $criteria->addCondition("rujukan_id = ".$this->rujukan_id); 			
        }
        if(!empty($this->pasienpulang_id)){
                $criteria->addCondition("pasienpulang_id = ".$this->pasienpulang_id); 			
        }
        if(!empty($this->profilrs_id)){
                $criteria->addCondition("profilrs_id = ".$this->profilrs_id); 			
        }
        if(!empty($this->dokter_id)){
                $criteria->addCondition("dokter_id = ".$this->dokter_id); 			
        }
        $criteria->compare('LOWER(gelardokter)',strtolower($this->gelardokter),true);
        $criteria->compare('LOWER(dokter_nama)',strtolower($this->dokter_nama),true);
                
        return $criteria;
    }
     
     public function searchGrafik()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "count(pasien_id) as jumlah, CONCAT_WS(' ', gelardokter,dokter_nama) as data";
		$criteria->group = 'dokter_nama, gelardokter';
//                $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		
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
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 			
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
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
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id); 			
		}
		if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
               }else{
                   if (!empty($this->instalasi_id)){
                       $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                   }
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
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("rujukan_id = ".$this->rujukan_id); 			
		}
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition("pasienpulang_id = ".$this->pasienpulang_id); 			
		}
		if(!empty($this->profilrs_id)){
			$criteria->addCondition("profilrs_id = ".$this->profilrs_id); 			
		}
		if(!empty($this->dokter_id)){
			$criteria->addCondition("dokter_id = ".$this->dokter_id); 			
		}
		$criteria->compare('LOWER(gelardokter)',strtolower($this->gelardokter),true);
		$criteria->compare('LOWER(dokter_nama)',strtolower($this->dokter_nama),true);
               
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
               // $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

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
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 			
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
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
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("rujukan_id = ".$this->rujukan_id); 			
		}
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition("pasienpulang_id = ".$this->pasienpulang_id); 			
		}
		if(!empty($this->profilrs_id)){
			$criteria->addCondition("profilrs_id = ".$this->profilrs_id); 			
		}
		if(!empty($this->dokter_id)){
			$criteria->addCondition("dokter_id = ".$this->dokter_id); 			
		}
		$criteria->compare('LOWER(gelardokter)',strtolower($this->gelardokter),true);
		$criteria->compare('LOWER(dokter_nama)',strtolower($this->dokter_nama),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getNamaModel() 
	{
        return __CLASS__;
	}

    public static function berdasarkanStatus() 
    {
        $status = array(
            'pengunjung' => 'Berdasarkan Pengunjung',
            'kunjungan' => 'Berdasarkan Kunjungan',
        );
        return $status;
    }
}
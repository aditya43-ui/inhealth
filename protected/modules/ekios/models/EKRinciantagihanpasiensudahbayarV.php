<?php

class EKRinciantagihanpasiensudahbayarV extends RinciantagihapasiensudahbayarV{
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
      
    public function searchRincianTagihan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->select = array(
                                'tgl_pendaftaran',
                                'no_pendaftaran',
                                'no_rekam_medik',
                                'nama_pasien',
                                'nama_bin',
                                'nama_pegawai',
                                'pendaftaran_id',
                                'jeniskelamin',
                                'carabayar_nama',
                                'penjamin_nama',
                                'jeniskasuspenyakit_id',
                                'jeniskasuspenyakit_nama',
                                'sum(tarif_tindakan) as totaltagihan',
                                'pembayaranpelayanan_id',
                            );
                
                $criteria->group = 'nama_pegawai, pendaftaran_id,tgl_pendaftaran, no_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, 
                            carabayar_nama, penjamin_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, pembayaranpelayanan_id';
                
		$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition("tindakanpelayanan_id = ".$this->tindakanpelayanan_id);					
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);					
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);					
		}
		$criteria->addCondition('ruanganpendaftaran_id = 18');
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
                if ($this->statusBayar == 'LUNAS'){
                    $criteria->addCondition('pembayaranpelayanan_id is not null');
                }else if ($this->statusBayar == 'BELUM LUNAS'){
                    $criteria->addCondition('pembayaranpelayanan_id is null');
                }
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchDataRincian()
        {
            $criteria = new CDbCriteria();
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
			}
            $criteria->order = 'ruangan_nama';
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
        public function getSubTotal(){
            return ($this->tarif_satuan*$this->qty_tindakan)-$this->tarifcyto_tindakan+$this->discount_tindakan;
        }
        public function getTandaBukti($attribute){
            $model = PembayaranpelayananT::model()->findByPk($this->pembayaranpelayanan_id);
            if($model->tandabuktibayar_id){
                $modTandabukti = TandabuktibayarT::model()->findByPk($model->tandabuktibayar_id);
            }else{
                $modTandabukti = new TandabuktibayarT;
            }
            return $modTandabukti->$attribute;
        }
        
        
        public function getNamaPasienPendaftar()
        {
                    return $this->namadepan.' '.$this->nama_pasien; 	     
        }

        public function getAlamatPasienPendaftar()
        {
                    return $this->alamat_pasien.' Rt/Rw. '.$this->rt.' / '.$this->rw; 	     
        }

        public function getDokterPemeriksa()
        {
                    return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama; 	     
        }

        public function getCarabayarPenjamin()
        {
                    return $this->carabayar_nama.' / '.$this->penjamin_nama; 	     
        }    

        public function getDokterTindakan()
        {
            $modDokter = PegawaiM::model()->findByPk($this->pegawai_id);

            $nama_lengkap_dokter = (isset($modDokter->gelardepan) ? $modDokter->gelardepan : "").' '.(isset($modDokter->nama_pegawai) ? $modDokter->nama_pegawai : "").' '.(isset($modDokter->gelarbelakang_nama) ? $modDokter->gelarbelakang_nama : ""); 	     

            return $nama_lengkap_dokter;
        }
        /**
         * untuk print rincian rumah sakit
         */
        public function getJasaRumahSakit(){
            $tarif = 0;
            $criteria = new CDbCriteria();
            $modTindKomponen = TindakankomponenT::model()->findByAttributes(array("tindakanpelayanan_id"=>$this->tindakanpelayanan_id, "komponentarif_id"=>7)); // disesuaikan dengan kebutuhan RS
            if(isset($modTindKomponen)){
                $tarif = $modTindKomponen->tarif_kompsatuan * $this->qty_tindakan;
            }
            return $tarif;
        }
        
        /**
         * untuk print rincian rumah sakit
         */
        public function getJasaPelayanan(){
            $tarif = 0;
            $criteria = new CDbCriteria();
            $modTindKomponen = TindakankomponenT::model()->findByAttributes(array("tindakanpelayanan_id"=>$this->tindakanpelayanan_id, "komponentarif_id"=>8)); // disesuaikan dengan kebutuhan RS
            if(isset($modTindKomponen)){
                $tarif = $modTindKomponen->tarif_kompsatuan * $this->qty_tindakan;
            }
            return $tarif;
        }
        
        /**
         * untuk print rincian rumah sakit
         */
        public function getJasaRFS(){
            $tarif = 0;
            $criteria = new CDbCriteria();
            $modTindKomponen = TindakankomponenT::model()->findByAttributes(array("tindakanpelayanan_id"=>$this->tindakanpelayanan_id, "komponentarif_id"=>10));// disesuaikan dengan kebutuhan RS
            if(isset($modTindKomponen)){
                $tarif = $modTindKomponen->tarif_kompsatuan * $this->qty_tindakan;
            }
            return $tarif;
        }
        
        /**
         * untuk print rincian rumah sakit
         */
        public function getJasaDMK(){
            $tarif = 0;
            $criteria = new CDbCriteria();
            $modTindKomponen = TindakankomponenT::model()->findByAttributes(array("tindakanpelayanan_id"=>$this->tindakanpelayanan_id, "komponentarif_id"=>9)); // disesuaikan dengan kebutuhan RS
            if(isset($modTindKomponen)){
                $tarif = $modTindKomponen->tarif_kompsatuan * $this->qty_tindakan;
            }
            return $tarif;
        }
        
        /* =====================================================================
         * Fungsi untuk Rincian Tagihan Pasien
         * =====================================================================
         */
        
        public function getNamaUnitGrupRincian($modPendaftaran, $modAdmisi) {
            
            /* Karcis dari Ruangan loket */
            if ($this->ruangan_id == Params::RUANGAN_ID_LOKET_PENDAFTARAN) {
                if (!empty($modAdmisi) && (strtotime($this->tgl_tindakan) >= strtotime($modAdmisi->tgladmisi))) {
                    $masuk = MasukkamarT::model()->findByAttributes(array(
                        'pasienadmisi_id'=>$modAdmisi->pasienadmisi_id
                    ), array(
                        'condition'=>'ruangan_id is not null',
                        'order'=>'masukkamar_id asc',
                    ));
                    
                    if (!empty($masuk->kelaspelayanan_id)) {
                        $kelas = KelaspelayananM::model()->findByPk($masuk->kelaspelayanan_id);
                        return $kelas->kelaspelayanan_nama;
                    }
                }
                
                return $modPendaftaran->ruangan->ruangan_nama;
            }
            
            if ($this->instalasi_id == Params::INSTALASI_ID_RI) {
                return $this->kelaspelayanan_nama;
            }
            
            if ($this->is_alkes) {
                return "Apotek";
            }
            
            return $this->ruangan_nama;
        }
        
        
        function getKodeJenisTindakan2() {
            if ($this->is_alkes) return null;
            
            $daftartindakan = DaftartindakanM::model()->findByPk($this->daftartindakan_id);
            $tindakan = TindakanpelayananT::model()->findByPk($this->tindakanpelayanan_id);
            if ($daftartindakan->daftartindakan_id == 707) {
                return "1.8";
            } else if ($daftartindakan->daftartindakan_id == 704) {
                return "1.6";
            } else if ($daftartindakan->daftartindakan_id == 705) {
                return "1.5";
            } else if ($daftartindakan->daftartindakan_karcis) {
                return "1.99";
            } else if (in_array($daftartindakan->daftartindakan_nama, array(1004, 447))) {
                return "4.99";
            } else if ($daftartindakan->daftartindakan_tindakan) {
                // if (!empty($tindakan->bidan_id)) return "1.2.2";
                if (!empty($tindakan->perawat1_id) || !empty($tindakan->perawat2_id || !empty($tindakan->suster_id)))
                    return "1.2";
                if ($tindakan->ruangan_id == Params::RUANGAN_ID_FISIOTERAPI)
                    return "1.2.3";
                return "1.2.1";
            } else if ($daftartindakan->daftartindakan_periksa) {
                if (!empty($tindakan->bidan_id)) return "1.3.1";
                return "1.3";
            } else if ($daftartindakan->daftartindakan_konsul) {
                if ($tindakan->ruangan_id <> 23) return "1.8"; // klinik umum
                return "1.1";
            } else if ($daftartindakan->daftartindakan_akomodasi) {
                if ($this->ruangan_id == Params::RUANGAN_ID_BERSALIN) {
                    return "9.1";
                }
                return "6.".$tindakan->kelaspelayanan_id;
            } else if ($daftartindakan->daftartindakan_alatmedis) {
                return "2.99";
            } 
            
            return null;
        }
        
        function getKodeJenisTindakan() {
            if ($this->is_alkes) return null;
            
            $daftartindakan = DaftartindakanM::model()->findByPk($this->daftartindakan_id);
            // var_dump($daftartindakan->attributes);
            if ($daftartindakan->daftartindakan_tindakan) {
                $tindakan = TindakanpelayananT::model()->findByPk($this->tindakanpelayanan_id);
                
                return "1.2";
            } else if ($daftartindakan->daftartindakan_periksa) {
                return "1.3";
            } else if ($daftartindakan->daftartindakan_id == 707) {
                return "1.8";
            } 
            
            return null;
        }
        
        function getKodeJenisKonsultasi() {
            if ($this->is_alkes) return null;
            
            $daftartindakan = DaftartindakanM::model()->findByPk($this->daftartindakan_id);
            // var_dump($daftartindakan->attributes);
            if ($daftartindakan->daftartindakan_konsul) {
                return "1.1";
            }
            
            return null;
        }
        
        function getKodeJenisVisite() {
            if ($this->is_alkes) return null;
            
            $daftartindakan = DaftartindakanM::model()->findByPk($this->daftartindakan_id);
            // var_dump($daftartindakan->attributes);
            if ($daftartindakan->daftartindakan_id == 704) {
                return "1.6";
            } else if ($daftartindakan->daftartindakan_id == 705) {
                return "1.5";
            } else if ($daftartindakan->daftartindakan_id == 577) {
                return "1.7";
            } 
            
            return null;
        }
        
}

?>

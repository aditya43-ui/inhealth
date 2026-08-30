<?php

class ROLaporanpendapatanruanganV extends LaporanpendapatanruanganV {
    public static function model($className = __CLASS__) {
        return parent::model($className);
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

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();

        if ($_GET['tampilGrafik'] == 'kelaspelayanan'){
            $criteria->select = "count(t.pendaftaran_id) as jumlah, t.kelaspelayanan_nama as data";
            $criteria->group = 'data';
        }elseif ($_GET['tampilGrafik'] == 'carabayar'){
            $criteria->select = "count(t.pendaftaran_id) as jumlah, t.carabayar_nama as data";
            $criteria->group = 'data';
        }elseif ($_GET['tampilGrafik'] == 'dokter'){
            $criteria->select = "count(t.pendaftaran_id) as jumlah, (CONCAT(p.gelardepan, ' ', p.nama_pegawai,' ',gb.gelarbelakang_nama) ) as data";
            $criteria->group = 'data';
        }
		
		$criteria->order= 'jumlah DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
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
    
    public function functionCriteria(){
        $criteria = new CDbCriteria();
        $format = new MyFormatter();
        
       // $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
       // $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(t.tgl_tindakan)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->join = ""
                        . " JOIN pegawai_m p ON p.pegawai_id = t.dokterpemeriksa1_id "
                        . " LEFT JOIN gelarbelakang_m gb ON p.gelarbelakang_id = gb.gelarbelakang_id ";
		if(!empty($this->profilrs_id)){
			$criteria->addCondition("t.profilrs_id = ".$this->profilrs_id);					
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("t.pasien_id = ".$this->pasien_id);					
		}
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        $criteria->compare('LOWER(t.jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(t.no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(t.namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(t.tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(t.tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(t.alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('t.rt', $this->rt);
        $criteria->compare('t.rw', $this->rw);
        $criteria->compare('LOWER(t.statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(t.agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(t.golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(t.rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('t.anakke', $this->anakke);
        $criteria->compare('t.jumlah_bersaudara', $this->jumlah_bersaudara);
        $criteria->compare('LOWER(t.no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
        $criteria->compare('LOWER(t.no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->compare('LOWER(t.warga_negara)', strtolower($this->warga_negara), true);
        $criteria->compare('LOWER(t.photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(t.alamatemail)', strtolower($this->alamatemail), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);					
		}
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(t.umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(t.no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(t.namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(t.nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(t.namaperusahaan)', strtolower($this->namaperusahaan), true);
        $criteria->compare('LOWER(t.tglselesaiperiksa)', strtolower($this->tglselesaiperiksa), true);
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition("t.tindakanpelayanan_id = ".$this->tindakanpelayanan_id);					
		}
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition("t.penjamin_id",$this->penjamin_id);					
		}
        $criteria->compare('LOWER(t.penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);					
		}
        $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
        if (is_array($this->kelaspelayanan_id)){
            $criteria->addInCondition('t.kelaspelayanan_id', $this->kelaspelayanan_id);
        }
        else{
            $criteria->addCondition('t.kelaspelayanan_id is null');
        }
        $criteria->compare('LOWER(t.kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);					
		}
        $criteria->compare('LOWER(t.instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("t.daftartindakan_id = ".$this->daftartindakan_id);					
		}
        $criteria->compare('LOWER(t.daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
        $criteria->compare('LOWER(t.daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition("t.tipepaket_id = ".$this->tipepaket_id);					
		}
        $criteria->compare('LOWER(t.tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        $criteria->compare('t.daftartindakan_karcis', $this->daftartindakan_karcis);
        $criteria->compare('t.daftartindakan_visite', $this->daftartindakan_visite);
        $criteria->compare('t.daftartindakan_konsul', $this->daftartindakan_konsul);
        $criteria->compare('t.tarif_rsakomodasi', $this->tarif_rsakomodasi);
        $criteria->compare('t.tarif_medis', $this->tarif_medis);
        $criteria->compare('t.tarif_paramedis', $this->tarif_paramedis);
        $criteria->compare('t.tarif_bhp', $this->tarif_bhp);
        $criteria->compare('t.tarif_satuan', $this->tarif_satuan);
        $criteria->compare('t.tarif_tindakan', $this->tarif_tindakan);
        $criteria->compare('t.LOWER(satuantindakan)', strtolower($this->satuantindakan), true);
        $criteria->compare('t.qty_tindakan', $this->qty_tindakan);
        $criteria->compare('t.cyto_tindakan', $this->cyto_tindakan);
        $criteria->compare('t.tarifcyto_tindakan', $this->tarifcyto_tindakan);
        $criteria->compare('t.discount_tindakan', $this->discount_tindakan);
        $criteria->compare('t.pembebasan_tindakan', $this->pembebasan_tindakan);
        $criteria->compare('t.subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
        $criteria->compare('t.subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
        $criteria->compare('t.subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
        $criteria->compare('t.iurbiaya_tindakan', $this->iurbiaya_tindakan);
        $criteria->compare('t.LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('t.LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('t.LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('t.LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('t.LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		if(!empty($this->tindakansudahbayar_id)){
			$criteria->addCondition("t.tindakansudahbayar_id = ".$this->tindakansudahbayar_id);					
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition("t.shift_id = ".$this->shift_id);					
		}
        $criteria->compare('LOWER(t.shift_nama)', strtolower($this->shift_nama), true);
        $criteria->compare('LOWER(t.dokterpemeriksa1_id)', strtolower($this->dokterpemeriksa1_id), true);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.dokterpemeriksa2_id)', strtolower($this->dokterpemeriksa2_id), true);
        $criteria->compare('LOWER(t.dokterpendamping_id)', strtolower($this->dokterpendamping_id), true);
        $criteria->compare('LOWER(t.dokteranastesi_id)', strtolower($this->dokteranastesi_id), true);
        $criteria->compare('LOWER(t.dokterdelegasi_id)', strtolower($this->dokterdelegasi_id), true);
        $criteria->compare('LOWER(t.bidan_id)', strtolower($this->bidan_id), true);
        $criteria->compare('LOWER(t.suster_id)', strtolower($this->suster_id), true);
		if(!empty($this->perawat_id)){
			$criteria->addCondition("t.perawat_id = ".$this->perawat_id);					
		}
        
        return $criteria;
    }

    public function getNamaModel() {
        return __CLASS__;
    }
}

?>

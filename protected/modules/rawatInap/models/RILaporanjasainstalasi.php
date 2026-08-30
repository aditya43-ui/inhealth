<?php

class RILaporanjasainstalasi extends LaporanjasainstalasiV {
    
    public $tgl_awal;
    public $tgl_akhir;
    public $subtotal;
    public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    

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
    
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }
    
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        
        $criteria->select = "count(t.pendaftaran_id) as jumlah, case when t.tindakansudahbayar_id is null then 'BELUM BAYAR' else 'SUDAH BAYAR' end as data";
        $criteria->group = 'data';
        if (!empty($this->carabayar_id)){
            $criteria->select .= ', t.penjamin_nama as tick';
            $criteria->group .= ', t.penjamin_nama';
        }else{
            $criteria->select .= ', t.carabayar_nama as tick';
            $criteria->group .= ', t.carabayar_nama';
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function functionCriteria(){
        $criteria = new CDbCriteria;
//        $criteria->select='count(pendaftaran_id) as pendaftaran_id';
//        $criteria->order = 'pendaftaran_id';
//        $criteria->select = 'no_rekam_medik, nama_pasien,no_pendaftaran, kelaspelayanan_nama,daftartindakan_nama,
//                qty_tindakan, tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, 
//                case when daftartindakan_karcis = true then daftartindakan_nama end as karcisnama, 
//                case when daftartindakan_karcis = true then qty_tindakan else 0 end as karcisqty, 
//                case when daftartindakan_karcis = true then tarif_rsakomodasi else 0 end as karcisrs, 
//                case when daftartindakan_karcis = true then tarif_medis else 0 end as karcisMedis, 
//                tgl_pendaftaran, ruangan_id, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama';
        $criteria->join = " JOIN tindakanpelayanan_t tp ON t.tindakanpelayanan_id = tp.tindakanpelayanan_id "
                        . " JOIN pegawai_m p ON p.pegawai_id = tp.dokterpemeriksa1_id";        
        $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(p.nama_pegawai)', strtolower($this->nama_pegawai), true);
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
			if(is_array($this->penjamin_id)){
				$criteria->addInCondition("t.penjamin_id",$this->penjamin_id);		
			}else{
				$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
			}
		}
        $criteria->compare('LOWER(t.penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);		
		}
        $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("t.kelaspelayanan_id = ".$this->kelaspelayanan_id);		
		}
        $criteria->compare('LOWER(t.kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->addCondition('t.instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
        $criteria->compare('LOWER(t.instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(t.tgl_tindakan)', strtolower($this->tgl_tindakan), true);
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
        $criteria->compare('LOWER(t.satuantindakan)', strtolower($this->satuantindakan), true);
        $criteria->compare('t.qty_tindakan', $this->qty_tindakan);
        $criteria->compare('t.cyto_tindakan', $this->cyto_tindakan);
        $criteria->compare('t.tarifcyto_tindakan', $this->tarifcyto_tindakan);
        $criteria->compare('t.discount_tindakan', $this->discount_tindakan);
        $criteria->compare('t.pembebasan_tindakan', $this->pembebasan_tindakan);
        $criteria->compare('t.subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
        $criteria->compare('t.subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
        $criteria->compare('t.subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
        $criteria->compare('t.iurbiaya_tindakan', $this->iurbiaya_tindakan);
        $criteria->compare('LOWER(t.create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(t.update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(t.create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(t.update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(t.create_ruangan)', strtolower($this->create_ruangan), true);
//        $criteria->group='pendaftaran_id';
        if (is_array($this->tindakansudahbayar_id)){
            $status = array();
            foreach ($this->tindakansudahbayar_id as $i=>$v){                
                if ($v == 1){
                    $status[] = 't.tindakansudahbayar_id is not null';
                }
                else{
                    $status[] = 't.tindakansudahbayar_id is null';
                }
            }
            $criteria->addCondition('('.implode(' OR ',$status).')');
            //$criteria->addCondition('tindakansudahbayar_id is null');
        }
        
        if (!empty($this->ruangan_id)){
            $criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
        }
        
        if(!empty($this->shift_id)){
			$criteria->addCondition("t.shift_id = ".$this->shift_id);		
		}
        $criteria->compare('LOWER(t.shift_nama)', strtolower($this->shift_nama), true);
        
        return $criteria;
    }    
    
    
    
    public function getNamaModel(){
        return __CLASS__;
    }

}
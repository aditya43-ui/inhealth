<?php

class BSLaporanjasainstalasi extends LaporanjasainstalasiV {
    
    public $jns_periode;
    public $tgl_awal,$bln_awal,$thn_awal;
    public $tgl_akhir,$bln_akhir,$thn_akhir;
    public $subtotal;

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
		$criteria->order = 'tgl_pendaftaran ASC';
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
        
		if ($_GET['tampilGrafik'] == 'statusbayar'){
			$criteria->select = "count(pendaftaran_id) as jumlah, case when tindakansudahbayar_id is null then 'BELUM BAYAR' else 'SUDAH BAYAR' end as data";
			$criteria->group = 'data  ';
		}elseif($_GET['tampilGrafik'] == 'carabayar'){
			if (!empty($this->penjamin_nama)){
				$criteria->select = "count(pendaftaran_id) as jumlah, penjamin_nama as data";
				$criteria->group = 'data';
			}else{
				$criteria->select = "count(pendaftaran_id) as jumlah, carabayar_nama as data";
				$criteria->group = 'data';
			}
		}
        
		$criteria->order = 'jumlah DESC';
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    protected function functionCriteria(){
        $criteria = new CDbCriteria;
        //$criteria->order = 'pendaftaran_id';
//        $criteria->select = 'no_rekam_medik, nama_pasien,no_pendaftaran, kelaspelayanan_nama,daftartindakan_nama,
//                qty_tindakan, tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, 
//                case when daftartindakan_karcis = true then daftartindakan_nama end as karcisnama, 
//                case when daftartindakan_karcis = true then qty_tindakan else 0 end as karcisqty, 
//                case when daftartindakan_karcis = true then tarif_rsakomodasi else 0 end as karcisrs, 
//                case when daftartindakan_karcis = true then tarif_medis else 0 end as karcisMedis, 
//                tgl_pendaftaran, ruangan_id, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama';
         $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
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
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('anakke', $this->anakke);
        $criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
        $criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
        $criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(namaperusahaan)', strtolower($this->namaperusahaan), true);
        $criteria->compare('LOWER(tglselesaiperiksa)', strtolower($this->tglselesaiperiksa), true);
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		
		if (!empty($this->penjamin_id)){
            $criteria->addCondition('penjamin_id ='.$this->penjamin_id);
        }else{
			if (!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
			}
        }
		
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
        $criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id = '.$this->tipepaket_id);
		}
        $criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
        
        $criteria->compare('daftartindakan_karcis', $this->daftartindakan_karcis);
        $criteria->compare('daftartindakan_visite', $this->daftartindakan_visite);
        $criteria->compare('daftartindakan_konsul', $this->daftartindakan_konsul);
        $criteria->compare('tarif_rsakomodasi', $this->tarif_rsakomodasi);
        $criteria->compare('tarif_medis', $this->tarif_medis);
        $criteria->compare('tarif_paramedis', $this->tarif_paramedis);
        $criteria->compare('tarif_bhp', $this->tarif_bhp);
        $criteria->compare('tarif_satuan', $this->tarif_satuan);
        $criteria->compare('tarif_tindakan', $this->tarif_tindakan);
        $criteria->compare('LOWER(satuantindakan)', strtolower($this->satuantindakan), true);
        $criteria->compare('qty_tindakan', $this->qty_tindakan);
        $criteria->compare('cyto_tindakan', $this->cyto_tindakan);
        $criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
        $criteria->compare('discount_tindakan', $this->discount_tindakan);
        $criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
        $criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
        $criteria->compare('subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
        $criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
        $criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        if (is_array($this->tindakansudahbayar_id)){
            $status = array();
            foreach ($this->tindakansudahbayar_id as $i=>$v){
                if ($v == 1){
                    $status[] = 'tindakansudahbayar_id is not null';
                }
                else{
                    $status[] = 'tindakansudahbayar_id is null';
                }
            }
            
            $criteria->addCondition('('.implode(' or ',$status).')');
            
        }
        if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
        $criteria->compare('LOWER(shift_nama)', strtolower($this->shift_nama), true);
        
        return $criteria;
    }           
    
    
    
    public function getNamaModel(){
        return __CLASS__;
    }

}
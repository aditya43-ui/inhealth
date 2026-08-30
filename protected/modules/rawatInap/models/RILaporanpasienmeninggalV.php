<?php

class RILaporanpasienmeninggalV extends LaporanpasienmeninggalV {
    
    public $jumlah, $tick, $data;
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function getTanggal(){
        return $this->tgl_pendaftaran."  /   ".$this->tgl_meninggal;
    }
    public function getRM(){
        return $this->no_pendaftaran."  /   ".$this->no_rekam_medik;
    }
    public function getNama(){
        return $this->nama_pasien."   /   ".$this->nama_bin;
    }
    public function getUmur(){
        return $this->jeniskelamin."   /   ".$this->umur;
    }
    public function getAgama(){
        return $this->agama."   /   ".$this->golonganumur_nama;
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
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }

    public function searchDashboard(){
        $criteria=new CDbCriteria;
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->order = "tgl_meninggal DESC";
        $criteria->limit=10; 
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
    }
    public function searchGrafik(){
        $criteria=new CDbCriteria;
        $criteria = $this->functionCriteria();
        
        $criteria->select = 'count(pendaftaran_id) as jumlah, caramasuk_nama as data, caramasuk_nama as tick';
        $criteria->group = 'caramasuk_nama';

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    public function searchPrint(){
        $criteria=new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
    
    protected function functionCriteria(){
        $criteria=new CDbCriteria;

        $criteria->addBetweenCondition('DATE(tglpasienpulang)', $this->tgl_awal, $this->tgl_akhir);
		
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 	
		}
        $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
        $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
        $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
        $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
        $criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
        $criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
        $criteria->compare('anakke',$this->anakke);
        $criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
        $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
        $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
        $criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
        $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
        $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
        $criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
        $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
        $criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
        $criteria->compare('LOWER(kelompokumur_nama)',strtolower($this->kelompokumur_nama),true);
        $criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
		}
		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition("kelompokumur_id = ".$this->kelompokumur_id); 	
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id); 	
		}
        $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id); 	
		}
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 	
		}
        $criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 	
		}
        $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 	
		}
        $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 	
		}
        $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
        $criteria->compare('LOWER(agama)',strtolower($this->agama),true);
        $criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
        $criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 	
		}
                if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 	
		}
        $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->caramasuk_id)){
			$criteria->addInCondition("caramasuk_id",$this->caramasuk_id); 	
			if (is_array($this->caramasuk_id)){
				$criteria->addInCondition("caramasuk_id",$this->caramasuk_id); 	
			}else{
				$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id); 	
			}
		}
        $criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
        $criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
        $criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
        $criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition("pasienpulang_id = ".$this->pasienpulang_id); 	
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id); 	
		}
        $criteria->compare('rt',$this->rt);
        $criteria->compare('rw',$this->rw);
        $criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
        $criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
        $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
        $criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
        $criteria->compare('lamarawat',$this->lamarawat);
        $criteria->compare('LOWER(satuanlamarawat)',strtolower($this->satuanlamarawat),true);
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

        return $criteria;
    }
        public function getNamaModel(){
        return __CLASS__;
    }

}
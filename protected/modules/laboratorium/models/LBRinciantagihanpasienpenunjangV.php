<?php

class LBRinciantagihanpasienpenunjangV extends RinciantagihanpasienV{
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public $ruanganpenunjang_id;
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
                                'pembayaranpelayanan_id'
                            );
                
                $criteria->group = 'nama_pegawai, pendaftaran_id,tgl_pendaftaran, no_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, 
                            carabayar_nama, penjamin_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, pembayaranpelayanan_id,ruanganpenunjang_id';
                
		$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->addCondition('ruanganpenunjang_id = '.Yii::app()->user->getState('ruangan_id'));
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
				$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
			}
            $criteria->order = 'ruangan_nama';
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
        public function getSubTotal(){
            return ($this->tarif_satuan*$this->qty_tindakan)+$this->tarifcyto_tindakan+$this->discount_tindakan;
        }
        
        public function getNamaModel(){
            return __CLASS__;
        }      
        
        /**
         * searchDataPemeriksanLabRad() menampilkan informasi model ini + pemeriksaan lab dan rad
         */
        public $hasilpemeriksaanrad_id, $pemeriksaanrad_id, $pemeriksaanrad_nama, $pemeriksaanrad_jenis; //radiologi
        public $detailhasilpemeriksaanlab_id, $pemeriksaanlab_id, $pemeriksaanlab_nama, $jenispemeriksaanlab_id, $jenispemeriksaanlab_nama; //laboratorium
        public function searchDataPemeriksaanLabRad($pendaftaran_id){
            $criteria = new CDbCriteria();
            $criteria->select = " 
                hasilpemeriksaanrad_t.hasilpemeriksaanrad_id
                , pemeriksaanrad_m.pemeriksaanrad_id
                , pemeriksaanrad_m.pemeriksaanrad_nama
                , pemeriksaanrad_m.pemeriksaanrad_jenis

               
                , * 
                ";
            // JOIN DENGAN DETAIL PEMERIKSAAN LAB BERMASALAH SAAT MENAMPILKAN DATA PEMERIKSAAN LAB JADI TIDAK SESUAI:
            // - TOTAL TAGIHAN
            // - LIST PEMERIKSAAN
            //, jenispemeriksaanlab_m.jenispemeriksaanlab_nama
//             , detailhasilpemeriksaanlab_t.detailhasilpemeriksaanlab_id
//                , pemeriksaanlab_m.pemeriksaanlab_id
//                , pemeriksaanlab_m.pemeriksaanlab_nama
//                , pemeriksaanlab_m.jenispemeriksaanlab_id
            $criteria->join = "
                
                LEFT JOIN hasilpemeriksaanrad_t ON t.tindakanpelayanan_id = hasilpemeriksaanrad_t.tindakanpelayanan_id
                LEFT JOIN pemeriksaanrad_m ON hasilpemeriksaanrad_t.pemeriksaanrad_id = pemeriksaanrad_m.pemeriksaanrad_id
                ";
//            LEFT JOIN detailhasilpemeriksaanlab_t ON t.tindakanpelayanan_id = detailhasilpemeriksaanlab_t.tindakanpelayanan_id
//                LEFT JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = detailhasilpemeriksaanlab_t.pemeriksaanlab_id
//                LEFT JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
//                
			if(!empty($pendaftaran_id)){
				$criteria->addCondition('t.pendaftaran_id = '.$pendaftaran_id);
			}
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
                
        }
        public function getNamaDokter(){
            $dokter = DokterV::model()->findByAttributes(array('pegawai_id'=>$this->pegawai_id));
            return $dokter->gelardepan." ".$dokter->nama_pegawai.", ".$dokter->gelarbelakang_nama;
        }
}

?>

<?php

class RDRinciantagihanpasienV extends RinciantagihanpasienV{
    
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
		$criteria->addCondition('ruanganpendaftaran_id = '.Yii::app()->user->getState('ruangan_id'));
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
            return ($this->tarif_satuan*$this->qty_tindakan)+$this->tarifcyto_tindakan+$this->discount_tindakan;
        }
        

}

?>

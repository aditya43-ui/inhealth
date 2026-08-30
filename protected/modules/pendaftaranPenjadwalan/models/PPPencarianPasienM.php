<?php

class PPPencarianPasienM extends PendaftaranT{
        public $penanggungjawab_nama;
        public $ruangan;
        public $ruangan_nama;

        
        public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pasien_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statusperiksa, statuspasien, kunjungan, statusmasuk, umur, ruangan_id, penanggungjawab_id, carabayar_id, penjamin_id', 'required'),
			array('penjamin_id, caramasuk_id, carabayar_id, pasien_id, shift_id, golonganumur_id, kelaspelayanan_id, rujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, no_urutantri', 'numerical', 'integerOnly'=>true),
			array('no_pendaftaran', 'length', 'max'=>12),
			array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk', 'length', 'max'=>50),
			array('umur', 'length', 'max'=>30),
			array('pegawai_id, alihstatus, byphone, kunjunganrumah, nopendaftaran_aktif,noRekamMedik, namaPasien, namaBin, alamat, propinsi, kabupaten, kecamatan, kelurahan, rt, rw', 'safe'),
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s', time()),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, penjamin_id, caramasuk_id, carabayar_id, pasien_id, shift_id, golonganumur_id, kelaspelayanan_id, rujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, create_time, upate_time, create_loginpemakai_id, upate_loginpemakai_id, create_ruangan, nopendaftaran_aktif,noRekamMedik, namaPasien, namaBin, alamat, propinsi, kabupaten, kecamatan, kelurahan, rt, rw', 'safe', 'on'=>'search'),
			array('noRekamMedik, namaPasien, namaBin, alamat, propinsi, kabupaten, kecamatan, kelurahan, rt, rw ', 'safe', 'on'=>'searchPasienPendaftaran'),
		);
	}
    /**
      * Retrieves a list of models based on the current search/filter conditions.
      * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
      */
        public function searchPasienPendaftaran()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->with=array('pasien','penanggungJawab');
                $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->noRekamMedik),true);
                $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->namaPasien),true);
                $criteria->compare('LOWER(pasien.nama_bin)',  strtolower($this->namaBin),true);
                $criteria->compare('LOWER(pasien.alamat_pasien)',  strtolower($this->alamat),true);
				if(!empty($this->propinsi)){
					$criteria->addCondition("pasien.propinsi_id = ".$this->propinsi); 			
				}
				if(!empty($this->kabupaten)){
					$criteria->addCondition("pasien.kabupaten_id = ".$this->kabupaten); 			
				}
				if(!empty($this->kecamatan)){
					$criteria->addCondition("pasien.kecamatan_id = ".$this->kecamatan); 			
				}
				if(!empty($this->kelurahan)){
					$criteria->addCondition("pasien.kelurahan_id = ".$this->kelurahan); 			
				}
				if(!empty($this->rt)){
					$criteria->addCondition("pasien.rt = ".$this->rt); 			
				}
				if(!empty($this->rw)){
					$criteria->addCondition("pasien.rw = ".$this->rw); 			
				}
				if(!empty($this->pendaftaran_id)){
					$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 			
				}
				if(!empty($this->penjamin_id)){
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 			
				}
				if(!empty($this->caramasuk_id)){
					$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id); 			
				}
				if(!empty($this->carabayar_id)){
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 			
				}
				if(!empty($this->pasien_id)){
					$criteria->addCondition("pasien_id = ".$this->pasien_id); 			
				}
				if(!empty($this->shift_id)){
					$criteria->addCondition("shift_id = ".$this->shift_id); 			
				}
				if(!empty($this->golonganumur_id)){
					$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id); 			
				}
				if(!empty($this->kelaspelayanan_id)){
					$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 			
				}
				if(!empty($this->rujukan_id)){
					$criteria->addCondition("rujukan_id = ".$this->rujukan_id); 			
				}
				if(!empty($this->penanggungjawab_id)){
					$criteria->addCondition("penanggungjawab_id = ".$this->penanggungjawab_id); 			
				}
				if(!empty($this->ruangan_id)){
					$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 			
				}
                $criteria->compare('LOWER(ruangan.ruangan_nama)',strtolower($this->ruangan_nama),true);
				if(!empty($this->instalasi_id)){
					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
				}
				if(!empty($this->jeniskasuspenyakit_id)){
					$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id); 			
				}
                $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
                $criteria->compare('no_urutantri',$this->no_urutantri);
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
                $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
                $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
                $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
                $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
                $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('nopendaftaran_aktif',$this->nopendaftaran_aktif);
                $criteria->order='tgl_pendaftaran DESC';
                
                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
}
?>

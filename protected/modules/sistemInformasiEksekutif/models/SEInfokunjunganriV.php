<?php

class SEInfokunjunganriV extends InfokunjunganriV
{
        public $jumlah;
        public $data;
        public $tick;
        public $Jenis_kasus_nama_penyakit;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganriV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchRI()
	{

		$criteria=new CDbCriteria;
                
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);			
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id);			
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);			
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);			
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id);			
		}
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);			
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition("kamarruangan_id = ".$this->kamarruangan_id);			
		}
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);			
		}
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);			
		}
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);			
		}
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);			
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);			
		}
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getNamaModel()
        {
            return __CLASS__;
        }
        
        public function primaryKey(){
            return 'pendaftaran_id';
        }
	
        
        public function searchDashboard(){
               
                $criteria = new CDbCriteria();
                $criteria->select = 'ruangan_nama as data, count(pendaftaran_id) as jumlah';
                
                $criteria->group = 'ruangan_nama';
                
                $criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
        public function searchGrafik(){
               
			$criteria = new CDbCriteria();
			$criteria->select = 'kunjungan as data, count(pendaftaran_id) as jumlah';

			$criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
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
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);			
			}
			$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);			
			}
			$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);			
			}
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        
        public function searchDashboardBatang(){
               
                $criteria = new CDbCriteria();
                $criteria->select = 'count(pendaftaran_id) as jumlah, caramasuk_nama as data';
                $criteria->group = 'caramasuk_nama';
                
                $criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
//		                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        public function searchDashboardPie(){
               
                $criteria = new CDbCriteria();
                $criteria->select = 'count(pendaftaran_id) as jumlah, kelaspelayanan_nama as tick';
                $criteria->group = 'kelaspelayanan_nama';
                
                $criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
//		                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
}
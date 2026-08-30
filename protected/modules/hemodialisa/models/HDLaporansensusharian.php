<?php

class HDLaporansensusharian extends LaporansensuharianrdV {

    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir,$thn_awal, $thn_akhir;
    public $jns_periode;
    public $data;
    public $jumlah;
    public $tick;
	public $id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	protected function functionCriteria() {
        $criteria = new CDbCriteria();
        
        $criteria->select = 'nama_pasien, nama_bin, no_rekam_medik, umur, jeniskelamin, alamat_pasien, kunjungan, statuspasien, diagnosa_nama, carabayar_nama, carabayar_id, penjamin_nama, penjamin_id, pendaftaran_id, ruangan_id, diagnosa_id, diagnosa_nama';
        $criteria->group = 'nama_pasien, nama_bin, no_rekam_medik, umur, jeniskelamin, alamat_pasien, kunjungan, statuspasien, diagnosa_nama, carabayar_nama, carabayar_id, penjamin_nama, penjamin_id, pendaftaran_id, ruangan_id, diagnosa_id, diagnosa_nama';
        
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
//		if(!empty($this->propinsi_id)){
//			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
//		}
//        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
//		if(!empty($this->kabupaten_id)){
//			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
//		}
//        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
//		if(!empty($this->kelurahan_id)){
//			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
//		}
//        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
//		if(!empty($this->kecamatan_id)){
//			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
//		}
//        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
		}
//		if(!empty($this->carabayar_id)){
//			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
//		}
//        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
//		if(!empty($this->penjamin_id)){
//			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
//		}
//        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        //Carabayar
        if(!empty($this->carabayar_id)){
                $criteria->addInCondition("carabayar_id ", $this->carabayar_id);
        }
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if(!empty($this->penjamin_id)){
                $criteria->addInCondition("penjamin_id ", $this->penjamin_id);
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);


        //Wilayah
        if(!empty($this->propinsi_id)){
                $criteria->addInCondition("propinsi_id ", $this->propinsi_id);
        }
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        if(!empty($this->kabupaten_id)){
                $criteria->addInCondition("kabupaten_id ", $this->kabupaten_id);
        }
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        if(!empty($this->kecamatan_id)){
                $criteria->addInCondition("kecamatan_id ", $this->kecamatan_id);
        }
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        if(!empty($this->kelurahan_id)){
                $criteria->addInCondition("kelurahan_id ", $this->kelurahan_id);
        }
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);  
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        
        return $criteria;
    }
	
    public function searchTable() {
        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();

        $criteria->select = 'count(pendaftaran_id) as jumlah, penjamin_nama';

        if (!empty($this->penjamin_id)) {
            $criteria->select .= ', penjamin_nama as data';
            $criteria->group .= ', penjamin_nama';
        }else if (!empty($this->carabayar_id)) {
            $criteria->select .= ', carabayar_nama as data';
            $criteria->group .= ', carabayar_nama';
        }else if (!empty($this->kabupaten_id)) {
            $criteria->select .= ', kabupaten_nama as tick';
            $criteria->group .= ', kabupaten_nama';
        }else if (!empty($this->propinsi_id)) {
            $criteria->select .= ', propinsi_nama as tick';
            $criteria->group .= ', propinsi_nama';
        }else if ($this->pilihanx == 'pengunjung') {
			$criteria->select .= ', statuspasien as data';
			$criteria->group .= ', statuspasien';
		} else if ($this->pilihanx == 'kunjungan') {
			$criteria->select .= ', kunjungan as data';
			$criteria->group .= ', kunjungan';
		}else if ($this->pilihanx == 'rujukan'){
			$criteria->select .= ', statusmasuk as data';
			$criteria->group .= ', statusmasuk';
		}else{
			$criteria->select .= ', penjamin_nama as data';
			$criteria->group .= ', penjamin_nama';
		}
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination'=>false,
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

    public function getNamaModel() {
        return __CLASS__;
    }

    public static function statusPasien() {
        $status = array('baru' => 'PENGUNJUNG BARU',
            'lama' => 'PENGUNJUNG LAMA');
        return $status;
    }

    public static function statusKunjungan() {
        $status = array('baru' => 'KUNJUNGAN BARU',
            'lama' => 'KUNJUNGAN LAMA');
        return $status;
    }

    public static function berdasarkanStatus() {
        $status = array('pengunjung' => 'Berdasarkan Pengunjung',
            'kunjungan' => 'Berdasarkan Kunjungan');
        return $status;
    }

}
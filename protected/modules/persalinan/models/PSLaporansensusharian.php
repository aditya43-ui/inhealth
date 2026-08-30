<?php

class PSLaporansensusharian extends LaporansensuharianpersalinanV {

    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public $data;
    public $jumlah;
    public $tick;
    public $pilihanx;

    public static function model($className = __CLASS__) {
        return parent::model($className);
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
        
        $criteria->select = 'count(pendaftaran_id) as jumlah ';
        
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->propinsi_id)){
			$criteria->addInCondition('propinsi_id', $this->propinsi_id);
		}
		if(!empty($this->kabupaten_id)){
			$criteria->addInCondition('kabupaten_id', $this->kabupaten_id);
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
		if(!empty($this->kabupaten_id)){
			$criteria->addInCondition('kabupaten_id', $this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id ='.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id ='.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition('carabayar_id', $this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition('penjamin_id', $this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);        
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        
        if (!empty($this->pilihanx)){
            $type = 'tick';
        }else{
            $type = 'data';
        }
        
        if ($_GET['filter'] == 'carabayar') {
            if (!empty($this->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group .= ' penjamin_nama';
            } else if (!empty($this->carabayar_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group .= ' penjamin_nama';
            }
            else{
                $criteria->select .= ', carabayar_nama as '.$type;
                $criteria->group .= ' carabayar_nama';
            }
        } else if ($_GET['filter'] == 'wilayah') {
            
            if (!empty($this->kelurahan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= ' kelurahan_nama';
            } else if (!empty($this->kecamatan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= ' kelurahan_nama';
            } else if (!empty($this->kabupaten_id)) {
                $criteria->select .= ', kecamatan_nama as '.$type;
                $criteria->group .= ' kecamatan_nama';
            } else if (!empty($this->propinsi_id)) {
                $criteria->select .= ', kabupaten_nama as '.$type;
                $criteria->group .= ' kabupaten_nama';
            } else {
                $criteria->select .= ', propinsi_nama as '.$type;
                $criteria->group .= ' propinsi_nama';
            }
        }
        
        $group = ' group by nama_pasien, nama_bin, no_rekam_medik, umur, jeniskelamin, alamat_pasien, diagnosa_nama, carabayar_nama, carabayar_id, penjamin_nama, penjamin_id, pendaftaran_id, ruangan_id, propinsi_id, kecamatan_id, kelurahan_id, kabupaten_id, propinsi_nama, kecamatan_nama, kelurahan_nama, kabupaten_nama,statuspasien, kunjungan ';

        if (!empty($group2) && (!empty($this->pilihanx))) {
            $criteria->group .=',';
        }
        if ($this->pilihanx == 'pengunjung') {
            $criteria->select .= ', statuspasien as data';
            $criteria->group .= ' statuspasien';
        } else if ($this->pilihanx == 'kunjungan') {
            $criteria->select .= ', kunjungan as data';
            $criteria->group .= ' kunjungan';
        }
        

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
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

    protected function functionCriteria() {
        $criteria = new CDbCriteria();
        
        $criteria->select = 'no_pendaftaran, tgl_pendaftaran, nama_pasien, namadepan, no_rekam_medik, umur, jeniskelamin, alamat_pasien, kunjungan, statuspasien, diagnosa_nama, carabayar_nama, carabayar_id, penjamin_nama, penjamin_id, pendaftaran_id, ruangan_id, diagnosa_id, diagnosa_nama';
        $criteria->group = 'no_pendaftaran, tgl_pendaftaran, nama_pasien, namadepan, no_rekam_medik, umur, jeniskelamin, alamat_pasien, kunjungan, statuspasien, diagnosa_nama, carabayar_nama, carabayar_id, penjamin_nama, penjamin_id, pendaftaran_id, ruangan_id, diagnosa_id, diagnosa_nama';
        
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id ='.$this->propinsi_id);
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id ='.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id ='.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        
        return $criteria;
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
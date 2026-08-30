<?php
/**
 * model yang digunakan untuk mengakses laporansensusharianri_v pada modul rawat inap
 * 
 * @package application.modules.rawatInap
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class RILaporansensusharian extends LaporansensuharianriV {
    public $data;
    public $jumlah;
    public $tick;
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    
    /**
     * load fungsi yii dari CActiveRecord
     * @param type $className
     * @return type
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * load data sesuai pencariannya
     * @return \CActiveDataProvider
     */
    public function searchTable() {
        $criteria = new CDbCriteria;
        
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id); 	
		}
        
        // var_dump($this->tgl_awal, $this->tgl_akhir); die;
        
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
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
		if(!empty($this->propinsi_id)){
			$criteria->addInCondition("propinsi_id ",$this->propinsi_id); 	
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
		if(!empty($this->kabupaten_id)){
			$criteria->addInCondition("kabupaten_id ",$this->kabupaten_id); 	
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 	
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 	
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 	
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        
        
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id); 	
		}
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 	
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id); 	
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 	
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    /** fungsi untuk generate filter / criteria pada model untuk grafik
    * $model adalah model yang akan digunakan untuk grafik
    * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
    * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
    */
    public static function criteriaGrafik($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(pendaftaran_id) as jumlah';
        if (!empty($model->carabayar_id) || !empty($model->penjamin_id)) {
            if (!empty($model->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group .= 'penjamin_nama';
            } else if (!empty($model->carabayar_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group = 'penjamin_nama';
            } else {
                $criteria->select .= ', carabayar_nama as '.$type;
                $criteria->group = 'carabayar_nama';
            }
        } else if (!empty($model->propinsi_id) || !empty($model->kabupaten_id)) {
            if (!empty($model->kelurahan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama';
            } else if (!empty($model->kecamatan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama';
            } else if (!empty($model->kabupaten_id)) {
                $criteria->select .= ', kecamatan_nama as '.$type;
                $criteria->group .= 'kecamatan_nama';
            } else if (!empty($model->propinsi_id)) {
                $criteria->select .= ', kabupaten_nama as '.$type;
                $criteria->group .= 'kabupaten_nama';
            } else {
                $criteria->select .= ', propinsi_nama as '.$type;
                $criteria->group .= 'propinsi_nama';
            }
        } else {
            $criteria->select .= ', propinsi_nama as '.$type;
            $criteria->group .= 'propinsi_nama';
        }

        if (is_array($addCols) && count((array)$addCols) > 0){
            foreach ($addCols as $i => $v){
                $criteria->group .= ','.$v;
                $criteria->select .= ','.$v.' as '.$i;
            }            
        }

        return $criteria;
    }
    
    /**
     * load data grafik, sesuai dengan kriteria di grupnya
     * @return \CActiveDataProvider
     */
    public function searchGrafik() {
        
        $criteria = $this->criteriaGrafik($this, 'tick');
        
        if (!empty($criteria->group) &&(!empty($this->pilihanx))){
            $criteria->group .=',';
        }
        if ($this->pilihanx == 'pengunjung'){
            $criteria->select .= ', statuspasien as data';
            $criteria->group .= ' statuspasien';
        }else if ($this->pilihanx == 'kunjungan'){
            $criteria->select .= ', kunjungan as data';
            $criteria->group .= ' kunjungan';
        }
        
        if (empty($this->pilihanx)){
            $criteria = $this->criteriaGrafik($this, 'data');
        }

        if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id); 	
		}
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
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
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
		if(!empty($this->propinsi_id)){
			$criteria->addInCondition("propinsi_id",$this->propinsi_id); 	
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
		if(!empty($this->kabupaten_id)){
			$criteria->addInCondition("kabupaten_id",$this->kabupaten_id); 	
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 	
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 	
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 	
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id); 	
		}
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 	
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id); 	
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 	
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    /**
     * load data sesuai pencariannya, digunakan untuk mencetak
     * @return \CActiveDataProvider
     */
    public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

		$criteria=new CDbCriteria;
		
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id); 	
		}
		$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		if(!empty($this->propinsi_id)){
                    if (is_array($this->propinsi_id)){
			$criteria->addInCondition("propinsi_id",$this->propinsi_id); 	
                    }else{
                        $criteria->addCondition("propinsi_id = ".$this->propinsi_id); 	
                    }
		}
		
		if(!empty($this->kabupaten_id)){
                    if (is_array($this->kabupaten_id)){
			$criteria->addInCondition("kabupaten_id",$this->kabupaten_id); 	
                    }else{
                        $criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 	
                    }			
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 	
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 	
		}
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 	
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
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
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id); 	
		}
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 	
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id); 	
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 	
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
    
    /**
     * load nama model
     * @return system
     */
    public function getNamaModel(){
        return __CLASS__;
    }
    
    /**
     * load data status pasien
     * @return string
     */
    public static function statusPasien()
    {
        $status = array('baru'=>'PENGUNJUNG BARU',
                        'lama'=>'PENGUNJUNG LAMA');
        return $status;
    }
    
    /**
     * load data kunjungan
     * @return string
     */
    public static function statusKunjungan()
    {
        $status = array('baru'=>'KUNJUNGAN BARU',
                        'lama'=>'KUNJUNGAN LAMA');
        return $status;
    }
    
    /**
     * load data status
     * @return string
     */
    public static function berdasarkanStatus(){
        $status = array('pengunjung'=>'Berdasarkan Pengunjung', 
                        'kunjungan'=>'Berdasarkan Kunjungan');
        return $status;
    }

}
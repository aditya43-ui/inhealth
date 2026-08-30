<?php

class FALaporanpenjualanjenisoaV extends LaporanpenjualanjenisoaV {
    
    public $jns_periode, $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jumlah, $data, $tick;
	public $nama_pasien, $no_pendaftaran;
	public $alamat_pasien;
	public $gelardepan, $gelarbelakang_nama, $nama_pegawai;
	public $satuankecil_nama;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getNamaModel() {
        return __CLASS__;
    }
    
    public function primaryKey() {
        return 'penjualanresep_id';
    }

    public function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        $criteria = new CDbCriteria;
        $criteria->order = 'obatalkes_nama';
        $criteria->select = 'jenisobatalkes_nama,obatalkes_golongan,obatalkes_kategori,obatalkes_nama, count(r) as r,sum(qty_oa) as qty_oa';
        $criteria->group = 'jenisobatalkes_nama,obatalkes_golongan,obatalkes_kategori,obatalkes_nama';
		if(!empty($this->penjualanresep_id)){
			$criteria->addCondition("penjualanresep_id = ".$this->penjualanresep_id);						
		}
        
        $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tglpenjualan)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);						
		}
        if (!is_array($this->jenisobatalkes_id)){
            $this->jenisobatalkes_id = 0;
        }
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addInCondition("jenisobatalkes_id",$this->jenisobatalkes_id);						
		}
		if(!empty($this->obatalkes_golongan)){
			if (is_array($this->obatalkes_golongan)){
				$criteria->addInCondition("obatalkes_golongan",$this->obatalkes_golongan);						
			}else{
				$criteria->addCondition(" obatalkes_golongan = ".$this->obatalkes_golongan." ");
			}
		}
		if(!empty($this->obatalkes_kategori)){
			if (is_array($this->obatalkes_kategori)){
				$criteria->addInCondition("obatalkes_kategori",$this->obatalkes_kategori);						
			}else{
				$criteria->addCondition(" obatalkes_kategori = ".$this->obatalkes_kategori." ");
			}
		}
        $criteria->compare('LOWER(jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
       // $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
        //$criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
        $this->r = 'R/';
        $criteria->compare('LOWER(r)', strtolower($this->r), true);
        $criteria->compare('rke', $this->rke);
        $criteria->compare('qty_oa', $this->qty_oa);
        
        return $criteria;
    }

    public function searchPrint() {
        $criteria = $this->functionCriteria();
		$criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    public function searchGrafik(){
        
            $criteria = $this->functionCriteria();

            $criteria2 = $criteria;
            $criteria2->select = 'count(jenisobatalkes_nama) as jumlah, jenisobatalkes_nama as data'; 
            $criteria2->group = 'obatalkes_nama, jenisobatalkes_nama';

            return  new CActiveDataProvider($this, array(
                        'criteria'=>$criteria2,
            ));

        }

    public function searchTable() {
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
	
	public function functionCriteriaNarkotika() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        $criteria = new CDbCriteria;
        $criteria->join = " JOIN penjualanresep_t pr ON pr.penjualanresep_id = t.penjualanresep_id "
						. "	JOIN obatalkes_m oa ON oa.obatalkes_id = t.obatalkes_id "
						. "	LEFT JOIN satuankecil_m sk ON sk.satuankecil_id = oa.satuankecil_id "
						. "	LEFT JOIN pegawai_m peg ON peg.pegawai_id = pr.pegawai_id "
						. "	LEFT JOIN gelarbelakang_m gelarbel ON gelarbel.gelarbelakang_id = peg.gelarbelakang_id "
						. "	LEFT JOIN pendaftaran_t p ON p.pendaftaran_id = pr.pendaftaran_id "
						. "	LEFT JOIN pasien_m pas ON pas.pasien_id = p.pasien_id ";
        $criteria->select = 'sk.satuankecil_nama, peg.gelardepan, peg.nama_pegawai, gelarbel.gelarbelakang_nama, pas.alamat_pasien, p.no_pendaftaran, pas.nama_pasien, t.noresep,t.tglresep,t.jenisobatalkes_nama,t.obatalkes_golongan,t.obatalkes_kategori,t.obatalkes_nama, count(r) as r,sum(qty_oa) as qty_oa';
        $criteria->group  = 'sk.satuankecil_nama, peg.gelardepan, peg.nama_pegawai, gelarbel.gelarbelakang_nama, pas.alamat_pasien, p.no_pendaftaran, pas.nama_pasien, t.noresep,t.tglresep,t.jenisobatalkes_nama,t.obatalkes_golongan,t.obatalkes_kategori,t.obatalkes_nama';
		
        
        $this->tgl_awal = MyFormatter::formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = MyFormatter::formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(t.tglresep)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.noresep)', strtolower($this->noresep), true);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("t.obatalkes_id = ".$this->obatalkes_id);						
		}
        if (!is_array($this->jenisobatalkes_id)){
            $this->jenisobatalkes_id = 0;
        }
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addInCondition("t.jenisobatalkes_id",$this->jenisobatalkes_id);						
		}
		if(!empty($this->obatalkes_golongan)){
			if (is_array($this->obatalkes_golongan)){
				$criteria->addInCondition("t.obatalkes_golongan",$this->obatalkes_golongan);						
			}else{
				$criteria->addCondition(" t.obatalkes_golongan = ".$this->obatalkes_golongan." ");
			}
		}else{
			$criteria->addInCondition(" t.obatalkes_golongan ",array(Params::OBATALKESPASIEN_GOLONGAN_NARKOTIKA, Params::OBATALKESPASIEN_GOLONGAN_PSIKOTROPIKA));
		}
		if(!empty($this->obatalkes_kategori)){
			if (is_array($this->obatalkes_kategori)){
				$criteria->addInCondition("t.obatalkes_kategori",$this->obatalkes_kategori);						
			}else{
				$criteria->addCondition(" t.obatalkes_kategori = ".$this->obatalkes_kategori." ");
			}
		}
        $criteria->compare('LOWER(t.jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
        $criteria->compare('LOWER(t.obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($this->obatalkes_nama), true);

        
        return $criteria;
    }
	
	public function searchTableNarkotika() {
        $criteria = $this->functionCriteriaNarkotika();
		$criteria->order = " t.tglresep ASC, t.noresep ASC, t.obatalkes_nama ASC ";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
	
	public function searchPrintNarkotika() {
        $criteria = $this->functionCriteriaNarkotika();
		$criteria->order = " t.tglresep ASC, t.noresep ASC, t.obatalkes_nama ASC ";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
					'pagination'=>false
                ));
    }
	
	 public function searchGrafikNarkotika(){
        
		$criteria = $this->functionCriteriaNarkotika();
		
		$criteria->select = 'count(t.obatalkes_id) as jumlah, t.obatalkes_golongan as data'; 
		$criteria->group = 'data';

		return  new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
		));

	}

}
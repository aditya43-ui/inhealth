<?php
class PPLaporanantrianV extends LaporanantrianV
{
    
    public $nama_pegawai, $data, $jumlah;
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	
      public static function model($className = __CLASS__) {
        return parent::model($className);
     }
     
     public function searchTable() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'tglantrian DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
     }
     
     public function searchPrint() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'tglantrian DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false
                ));
     }
     
     protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        if(!empty($this->ruangan_id)){                    
             $criteria->addInCondition('ruangan_id', $this->ruangan_id);
        }

        $criteria->addBetweenCondition('DATE(tglantrian)', $this->tgl_awal, $this->tgl_akhir);

		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('noantrian',$this->noantrian,true);
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('tglantrian',$this->tglantrian,true);
		$criteria->compare('jenis_kunjungan',$this->jenis_kunjungan,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_singkatan',$this->ruangan_singkatan,true);
		$criteria->compare('loket_id',$this->loket_id);
		$criteria->compare('loket_nama',$this->loket_nama,true);
		$criteria->compare('modelantrian_id',$this->modelantrian_id);
		$criteria->compare('modelantrian_nama',$this->modelantrian_nama,true);
		$criteria->compare('modelantrian_singkatan',$this->modelantrian_singkatan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
                
        return $criteria;
    }
     
     public function searchGrafik()
        {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select = "count(ruangan_id) as jumlah, ruangan_nama as data";
		$criteria->group = 'ruangan_nama';

		$criteria->addBetweenCondition('DATE(tglantrian)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('jenis_kunjungan',$this->jenis_kunjungan,true);
		if(!empty($this->ruangan_id)){                    
			$criteria->addInCondition('ruangan_id', $this->ruangan_id);
	    }

		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		
		$model = self::model()->findAll($criteria);

        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));

        }
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id); 			
		}
		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('noantrian',$this->noantrian,true);
		$criteria->compare('barcode',$this->barcode,true);
		$criteria->compare('tglantrian',$this->tglantrian,true);
		$criteria->compare('jenis_kunjungan',$this->jenis_kunjungan,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_singkatan',$this->ruangan_singkatan,true);
		$criteria->compare('loket_id',$this->loket_id);
		$criteria->compare('loket_nama',$this->loket_nama,true);
		$criteria->compare('modelantrian_id',$this->modelantrian_id);
		$criteria->compare('modelantrian_nama',$this->modelantrian_nama,true);
		$criteria->compare('modelantrian_singkatan',$this->modelantrian_singkatan,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getNamaModel() 
	{
        return __CLASS__;
	}

    public static function berdasarkanStatus() 
    {
        $status = array(
            'pengunjung' => 'Berdasarkan Pengunjung',
            'kunjungan' => 'Berdasarkan Kunjungan',
        );
        return $status;
    }
}
<?php


class PPLaporanJumlahPemeriksaanDokterV extends LaporanjumlahpemeriksaandokterV
{
    public $nama_pegawai,$tglAwal,$tglAkhir,$tick,$data,$jumlah;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode;
    public $type;
    
        
      public static function model($className = __CLASS__) {
        return parent::model($className);
     }
     
     public function searchTable() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'instalasi_nama, ruangan_nama';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
     }
     
     protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->addBetweenCondition('date(tgl_tindakan)', $this->tgl_awal, $this->tgl_akhir);
           $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
//		$criteria->compare('(dokter_id)',($this->dokter_id));
		
                if(!empty($this->dokter_id)){
                    $criteria->addCondition("dokter_id = ".$this->dokter_id);
                }
                if(!empty($this->penjamin_id)){
                    $criteria->addCondition("penjamin_id = ".$this->penjamin_id);
                }
                
                $criteria->compare('LOWER(dokter_nama)',strtolower($this->dokter_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
//		$criteria->compare('tarif_satuan',$this->tarif_satuan);
//		$criteria->compare('qty_tindakan',$this->qty_tindakan);
//		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		//$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
//		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
                if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                   }
                }
		$criteria->compare('LOWER(statusdokter)',strtolower($this->statusdokter),true);


        return $criteria;
    }
     
     public function searchGrafik()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->select = "count(nama_pasien) as jumlah, CONCAT_WS(' ',gelardepan , dokter_nama, gelarbelakang_nama) as data";
                $criteria->group = 'dokter_nama, gelardepan, gelarbelakang_nama';
//                $criteria->addBetweenCondition('tgl_pendaftaran', $this->tglAwal, $this->tglAkhir);
                $criteria->addBetweenCondition('date(tgl_tindakan)', $this->tgl_awal, $this->tgl_akhir);
           $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
//		$criteria->compare('dokter_id',$this->dokter_id);
		if(!empty($this->dokter_id)){
                    $criteria->addCondition("dokter_id = ".$this->dokter_id);
                }
                if(!empty($this->penjamin_id)){
                    $criteria->addCondition("penjamin_id = ".$this->penjamin_id);
                }
                $criteria->compare('LOWER(dokter_nama)',strtolower($this->dokter_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
//		$criteria->compare('tarif_satuan',$this->tarif_satuan);
//		$criteria->compare('qty_tindakan',$this->qty_tindakan);
//		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		//$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
//		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                   }
                }
		$criteria->compare('LOWER(statusdokter)',strtolower($this->statusdokter),true);
                $criteria->order = 'jumlah DESC';
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
               // $criteria->limit=-1; 

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
                                     $criteria->addBetweenCondition('tgl_tindakan', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		$criteria->compare('LOWER(dokter_id)',strtolower($this->dokter_id),true);
		$criteria->compare('LOWER(dokter_nama)',strtolower($this->dokter_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		//$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(statusdokter)',strtolower($this->statusdokter),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                 $criteria->addBetweenCondition('date(tgl_tindakan)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
		
                if(!empty($this->dokter_id)){
                    $criteria->addCondition("dokter_id = ".$this->dokter_id);
                }
                if(!empty($this->penjamin_id)){
                    $criteria->addCondition("penjamin_id = ".$this->penjamin_id);
                }
//                $criteria->compare('LOWER(dokter_id)',strtolower($this->dokter_id),true);
		$criteria->compare('LOWER(dokter_nama)',strtolower($this->dokter_nama),true);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
//		$criteria->compare('tarif_satuan',$this->tarif_satuan);
//		$criteria->compare('qty_tindakan',$this->qty_tindakan);
//		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		//$criteria->compare('LOWER(tgl_tindakan)',strtolower($this->tgl_tindakan),true);
//		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		if(!empty($this->ruangan_id)){                    
                    $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                }else{
                   if (!empty($this->instalasi_id)){
                       $criteria->addCondition("instalasi_id = '".$this->instalasi_id."' ");
                   }
                }
		$criteria->compare('LOWER(statusdokter)',strtolower($this->statusdokter),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
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
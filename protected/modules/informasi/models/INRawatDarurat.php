<?php
class INRawatDarurat  extends InfokunjunganrdV
{
	public $tgl_awal,$tgl_akhir;
	public $tgl_awall,$tgl_akhirl;
	public $ceklis = false;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TariftindakanperdaruanganV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function getInstalasiRuangan(){
        return $this->instalasi_nama."  /   ".$this->ruangan_nama;
    } 

        public function searchRD()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
                
        $criteria->addBetweenCondition('date(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
		if($this->ceklis)
			{
				$criteria->addBetweenCondition('DATE(tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
			}
        $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        // $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
        // $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
        // $criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar ),true);
        $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
        // $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
        // $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
        // $criteria->compare('propinsi_id',$this->propinsi_id);
        // $criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
        // $criteria->compare('kabupaten_id',$this->kabupaten_id);
        // $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
        // $criteria->compare('kecamatan_id',$this->kecamatan_id);         
        // $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
        // $criteria->compare('kelurahan_id',$this->kelurahan_id);
        // $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
        // $criteria->compare('instalasi_id',$this->instalasi_id);
        // $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
        // $criteria->compare('carabayar_id',$this->carabayar_id);
        // $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
        // $criteria->compare('penjamin_id',$this->penjamin_id);
        // $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
        // $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
        // $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
        // $criteria->compare('rujukan_id',$this->rujukan_id);
        // $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }      
        
        public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

               // if ((!empty($this->kelaspelayanan_id)) || (!empty($this->daftartindakan_id)) || (!empty($this->kategoritindakan_id)) || (!empty($this->ruangan_id))|| (!empty($this->instalasi_id))){
                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                    $criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_id),true);
                    $criteria->compare('kategoritindakan_id',  $this->kategoritindakan_id);
                    $criteria->compare('instalasi_id',  $this->instalasi_id);
                    $criteria->compare('ruangan_id',$this->ruangan_id);
//                }
//                else{
//                    $criteria->compare('ruangan_id', 0);
//                }
		
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
//        public function searchInformasiPrint()
//	{
//		// Warning: Please modify the following code to remove attributes that
//		// should not be searched.
//
//		$criteria=new CDbCriteria;
//
//                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
//                    $criteria->compare('LOWER(daftartindakan_nama)',  strtolower($this->daftartindakan_id),true);
//                    $criteria->compare('kategoritindakan_id',  $this->kategoritindakan_id);
//                    $criteria->compare('instalasi_id',  $this->instalasi_id);
//                    $criteria->compare('ruangan_id',$this->ruangan_id);
//                    $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
//                    $criteria->compare('daftartindakan_nama',$this->daftartindakan_nama);
//                    $criteria->group='daftartindakan_nama';
//                    $criteria->limit = 100;
//		return new CActiveDataProvider($this, array(
//			'criteria'=>$criteria,
//                        'pagination'=>false,
//		));
//	}
        
         public function criteriaInformasiTarif()
                {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                                $criteria->select = 'instalasi_nama,ruangan_nama,kelompoktindakan_nama,kategoritindakan_nama,daftartindakan_nama';
                                $criteria->order = 'instalasi_nama';
                                $criteria->group = 'instalasi_nama,ruangan_nama,kelompoktindakan_nama,kategoritindakan_nama,daftartindakan_nama';
//                                $criteria->join = 'INNER JOIN pegawai_m ON pegawai_m.pegawai_id=t.pegawai_id';
                                
//                                $criteria->addBetweenCondition('tglpresensi',$this->tglpresensi, $this->tglpresensi_akhir);
                                $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
                                $criteria->compare('instalasi_id',$this->instalasi_id);
                                $criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
                                $criteria->compare('kategoritindakan_id',$this->kategoritindakan_id);
                                
                                return $criteria;
                }
                public function searchInformasiPrint()
	{
		return new CActiveDataProvider($this, array(
			'criteria'=>$this->criteriaInformasiTarif(),
                                                'pagination'=>array(
                                                    'pageSize'=>1000,
                                                )
		));
	}
        
        public function getInstalasiItems()
        {
//            return InstalasipelayananV::model()->findAll('instalasi_aktif=TRUE  ORDER BY instalasi_nama');
            return Yii::app()->db->createCommand('SELECT instalasi_id, instalasi_nama FROM instalasi_m WHERE instalasi_aktif=TRUE ORDER BY instalasi_nama');
        }
        

	
}


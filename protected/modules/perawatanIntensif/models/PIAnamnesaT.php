<?php

class PIAnamnesaT extends AnamnesaT
{   
        public $catatandiagnosautama_dokter,$catatandiagnosatambahan_dokter;
        public $satuanWaktu;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
      
	/**
	 * @return array customized attribute labels (name=>label)
	 */
        /*
	public function attributeLabels()
	{
		return array(
			'anamesa_id' => 'Anamnesis',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'triase_id' => 'Triase',
			'pasienadmisi_id' => 'Pasien Admisi',
			'pegawai_id' => 'Dokter Pemeriksa',
			'tglanamnesis' => 'Tanggal Anamnesis',
			'keluhanutama' => 'Keluhan Utama',
			'keluhantambahan' => 'Keluhan Tambahan',
			'riwayatpenyakitterdahulu' => 'Riwayat Penyakit Terdahulu',
			'riwayatpenyakitkeluarga' => 'Riwayat Penyakit Keluarga',
			'lamasakit' => 'Lama Sakit',
			'pengobatanygsudahdilakukan' => 'Pengobatan yang sudah dilakukan',
			'riwayatalergiobat' => 'Riwayat Alergi Obat',
			'riwayatkelahiran' => 'Riwayat Kelahiran',
			'riwayatmakanan' => 'Riwayat Alergi Makanan',
			'riwayatimunisasi' => 'Riwayat Imunisasi',
			'paramedis_nama' => 'Paramedis',
			'keterangananamesa' => 'Keterangan Anamesa',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'petugas_triase_id' => 'Petugas Triase',
			'statusmerokok' => 'Status Merokok',
			'jmlrokok_btg_hr' => 'Jml. Rokok / Hari ',
			'riwayatimunisasiblm' => 'Riwayat Imunisasi',
			'riwayatobatygsering' => 'Riwayat Obat',
			'keb_olahraga' => 'Keb. Olahraga',
			'keb_jnsolahraga' => 'Keb. Jenis Olahraga',
			'keb_frekuensi_kaliminggu' => 'Keb. Frekuensi Kaliminggu',
			'keb_konsumsialkohol' => 'Keb. Konsumsi Alkohol',
			'keb_minumkopi' => 'Keb. Minum Kopi',
			'riwayat_kecelakaan' => 'Riwayat Kecelakaan',
			'riwayat_operasi' => 'Riwayat Operasi',
			'keb_konsumsidrug' => 'Keb. Konsumsi Narkoba',
			'riwayatperjalananpasien' => 'Riwayat Perjalanan Pasien',
			'produkperawatan_terakhir' => 'Produk Perawatan Yang Terakhir',
			'jeniskontrasepsi' => 'Jenis KOntrasepsi',
			'pernahdirawat' => 'Pernah Dirawat',
			'dirawatdimana' => 'Dirawat Dimana',
			'riwpenyakitkeldari' => 'Riwayat Penyakit Keluarga Dari',
			'penyakitmayor' => 'Penyakit Mayor',
			'reaksialergiobat' => 'Reaksi Alergi Obat',
			'reaksialergimakanan' => 'Reaksi Alergi Makanan',
			'riwayatalergilainnya' => 'Riwayat Alergi Lainnya',
			'reaksialergilainnya' => 'Reaksi Alergi Lainnya',
			'gelangtandaalergi' => 'Gelang Tanda Alergi Di Pasang',
			'statuspsikologis' => 'Status Psikologis',
			'statusmental' => 'Status Mental',
			'masalahsebelumnya' => 'Masalah Sebelumnya',
			'prilakukekerasansebelumnya' => 'Perilaku Kekerasan Sebelumnya',
			'penurunanbb_3bln' => 'Penurunan BB (3 Bulan)',
			'asupanberkurang' => 'Asupan Berkurang',
			'aktifitas_mobilisasi' => 'Aktifitas Mobilisasi',
			'sebutkan_bantuan' => 'Sebutkan Bantuan',
			'resikocedera' => 'Resiko Cedera',
			'isgelangresiko' => 'Gelang Resiko Jatuh Terpasang Dilengan Pasien',
			'tandasegitigaterpasang' => 'Tanda Segitiga Terpasang',
			'skriningnyeri' => 'Skrining Nyeri',
			'skalanyeri' => 'Skala Nyeri',
			'karakteristiknyeri' => 'Karakteristik Nyeri',
			'lokasinyeri' => 'Lokasi Nyeri',
			'nyeriterasa' => 'Nyeri Terasa',
			'nyerihilangbila' => 'Nyeri Hilang Bila',
			'hubungankeluarga' => 'Hubungan Keluarga',
			'tempattinggal' => 'Tempat Tinggal',
			'menarcheumur_thn' => 'Menarche Umur (Thn)',
			'siklusmenstruasi_hari' => 'Siklus Menstruasi (hari)',
			'siklusmenstruasiteratur' => 'Siklus Menstruasi Teratur',
			'dismenorche' => 'Dismenorche',
			'hpht' => 'HPHT',
			'taksiranpersalinan' => 'Taksiran Persalinan',
			'keluhansaathamil' => 'Keluhan Saat Hamil',
			'anc' => 'ANC',
			'riwayatkb' => 'Riwayat KB',
			'frekmakan_hari' => 'Frekmakan Hari',
			'makananyangdipantang' => 'Makanan Yang Dipantang',
			'ketmakananyangdipantang' => 'Ket. Makanan Yang Dipantang',
			'lamatidur_jam_hari' => 'Lama Tidur (jam)',
			'masalah' => 'Masalah',
			'ketmasalah' => 'Ket. Masalah',
			'kegiatan_aktivitas' => 'Kegiatan Aktivitas',
			'olahraga' => 'Olahraga',
			'ketergantunganobat' => 'Ketergantungan Obat',
			'minumankeras' => 'Minuman Keras',
		);
	}
         * 
         */
	
        public function searchAlergi($pendaftaran_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->select = 'anamesa_id, riwayatalergiobat';
		$criteria->addCondition('pendaftaran_id = '.$pendaftaran_id.'');
		if(!empty($this->anamesa_id)){
			$criteria->addCondition("anamesa_id = ".$this->anamesa_id); 	
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id); 	
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 	
		}	
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id); 	
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id); 	
		}
		if(!empty($this->triase_id)){
			$criteria->addCondition("triase_id = ".$this->triase_id); 	
		}
		$criteria->compare('LOWER(tglanamnesis)',strtolower($this->tglanamnesis),true);
		$criteria->compare('LOWER(keluhanutama)',strtolower($this->keluhanutama),true);
		$criteria->compare('LOWER(keluhantambahan)',strtolower($this->keluhantambahan),true);
		$criteria->compare('LOWER(riwayatpenyakitterdahulu)',strtolower($this->riwayatpenyakitterdahulu),true);
		$criteria->compare('LOWER(riwayatpenyakitkeluarga)',strtolower($this->riwayatpenyakitkeluarga),true);
		$criteria->compare('LOWER(lamasakit)',strtolower($this->lamasakit),true);
		$criteria->compare('LOWER(pengobatanygsudahdilakukan)',strtolower($this->pengobatanygsudahdilakukan),true);
		$criteria->compare('LOWER(riwayatalergiobat)',strtolower($this->riwayatalergiobat),true);
		$criteria->compare('LOWER(riwayatkelahiran)',strtolower($this->riwayatkelahiran),true);
		$criteria->compare('LOWER(riwayatmakanan)',strtolower($this->riwayatmakanan),true);
		$criteria->compare('LOWER(riwayatimunisasi)',strtolower($this->riwayatimunisasi),true);
		$criteria->compare('LOWER(paramedis_nama)',strtolower($this->paramedis_nama),true);
		$criteria->compare('LOWER(keterangananamesa)',strtolower($this->keterangananamesa),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	* menampilkan paramedis
	* @param type $ruangan_id
	* @return type
	*/
	public function getParamedisItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->join = 'LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id LEFT JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id = pegawai_m.kelompokpegawai_id';
	    $ruangan_id = Yii::app()->user->getState('ruangan_id');
	    $criteria->addCondition('t.ruangan_id='.$ruangan_id);
	    $paramedis = array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN);
        
        if (in_array($ruangan_id, array(Params::RUANGAN_ID_NICU, Params::RUANGAN_ID_BAYI_SAKIT))) {
            $paramedis[] = Params::KELOMPOKPEGAWAI_ID_BIDAN;
        }
        
	    $criteria->compare('kelompokpegawai_m.kelompokpegawai_id', $paramedis);
	    
	    return RuanganpegawaiM::model()->findAll($criteria);
	}

	public function getPPDS(){
							
		return PpdsM::model()->findAllByAttributes(array('ppds_aktif'=>true),array('order'=>'ppds_nama ASC'));
	}
        

}
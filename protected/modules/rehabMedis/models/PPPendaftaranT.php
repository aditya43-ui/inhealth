<?php

class PPPendaftaranT extends PendaftaranT
{
        public $prefix_pendaftaran;
        public $is_adapjpasien = 0;
        public $is_pasienrujukan = 0;
        public $is_adakarcis = 0;
        public $is_bayarkarcis = 0;
        public $is_pasienkecelakaan = 0;
        public $is_adasample = 0;
        public $is_bpjs = 0;
        public $is_vaksinasi = 0;
        public $tgl_awal,$tgl_akhir;
        public $tgl_awalrenkon,$tgl_akhirrenkon;
        public $no_rekam_medik,$nama_pasien,$alamat_pasien,$dokter,$kecamatan_nama,$jumlahpasien,$longitude,$latitude;
		public $ceklis = false;
		public $jumlah,$tahun,$bulan,$hari;
		public $nama_pegawai,$kabupaten_nama,$longitude_kab,$latitude_kab;
		public $buatjanjipoli_id;
		public $is_asubadak = 0;
		public $is_asudepartemen = 0;
		public $is_asupekerja = 0;
        public $is_langsung_briging,$no_rujukan,$jenis_rujukan;
        public $jadwalhemodialisa_id;
        public $nama_ppjp;
        public $kelahiranbayi_id;
				public $is_multipoli = 0;
				public $ket_bridging;
				public $no_kontrol_bpjs;
				public $kode_ruangan_bpjs;
		public $slotantrian;
		public $no_luarjadwal, $is_bpjs_manual, $no_buatjanji;
				
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendaftaranT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
	 * @return array validation rules for model attributes.
         * penambahan required
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokumur_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, statuspasien, kunjungan, statusmasuk, umur, create_time, create_loginpemakai_id, pegawai_id, ruangan_id, kelaspelayanan_id, carabayar_id, penjamin_id, jeniskasuspenyakit_id', 'required'),
			array('pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jeniskasuspenyakit_id', 'required', 'on'=>'daftar_bayi'),
            array('no_pendaftaran', 'length', 'max'=>20),
			array('no_urutantri', 'length', 'max'=>6),
			array('transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, status_konfirmasi', 'length', 'max'=>50),
			array('umur', 'length', 'max'=>30),
			array('info_rs_dari, nursestation_id, isumumkebpjs, alihstatus, byphone, kunjunganrumah, tglselesaiperiksa, keterangan_reg, update_time, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, tgl_konfirmasi, jeniskasuspenyakit_id, tglrenkontrol, statusfarmasi, slotantrian', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pendaftaran_id, pasienpulang_id, pasienbatalperiksa_id, penanggungjawab_id, penjamin_id, shift_id, pasien_id, persalinan_id, pegawai_id, instalasi_id, caramasuk_id, pengirimanrm_id, peminjamanrm_id, jeniskasuspenyakit_id, pembayaranpelayanan_id, kelaspelayanan_id, carabayar_id, pasienadmisi_id, kelompokumur_id, golonganumur_id, rujukan_id, antrian_id, karcis_id, ruangan_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, tglselesaiperiksa, keterangan_reg, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, nopendaftaran_aktif, status_konfirmasi, tgl_konfirmasi, tglrenkontrol, statusfarmasi, slotantrian', 'safe', 'on'=>'search'),
		);
	}
        /**
         * Mengambil daftar semua ruangan
         * @return CActiveDataProvider 
         */
        public function getRuanganItems($instalasi_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($instalasi_id)){
                            //RSPMC-1046
                            if($instalasi_id == Params::INSTALASI_ID_RJ){
//                                $criteria->addCondition(" instalasi_id= ".$instalasi_id." OR instalasi_id=".Params::INSTALASI_ID_HD); RSPMC-1802
                                $criteria->addCondition(" instalasi_id= ".$instalasi_id);
                            }
                            else{
								$criteria->addCondition("instalasi_id= ".$instalasi_id);
                            }			
			}
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama";
            return RuanganM::model()->findAll($criteria);
        }

		 /**
         * Mengambil daftar ruangan persalinan
         * @return CActiveDataProvider 
         */
        public function getRuanganItemsVK($instalasi_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($instalasi_id)){
                            //RSPMC-1046
                $criteria->addCondition(" instalasi_id= ".$instalasi_id);
				$criteria->addCondition("ruangan_id IN('".Params::RUANGAN_ID_PERAWATAN_DARURAT."')");
			}
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama";
            return RuanganM::model()->findAll($criteria);
        }

		public function getRuanganItemsVK2($instalasi_id=null)
        {
            $criteria = new CDbCriteria();
			if(!empty($instalasi_id)){
                            //RSPMC-1046
                $criteria->addCondition(" instalasi_id= ".$instalasi_id);
				$criteria->addCondition("ruangan_id IN('".Params::RUANGAN_ID_VK."')");
			}
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama";
            return RuanganM::model()->findAll($criteria);
        }
        
        public function getRuanganJadwalDokter()
        {
            $criteria = new CDbCriteria();            
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->addCondition("instalasi_id IN ('".Params::INSTALASI_ID_RJ."','".Params::INSTALASI_ID_RD."','".Params::INSTALASI_ID_REHAB."') ");
            $criteria->order = "ruangan_nama";
            return RuanganM::model()->findAll($criteria);
        }
        /**
         * Mengambil daftar semua ruangan
         * @return CActiveDataProvider 
         */
        public function getRuanganPenunjangItems()
        {
            $criteria = new CDbCriteria();
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->order = "ruangan_nama";
            return RuanganpenunjangV::model()->findAll($criteria);
        }
        /**
         * mengambil data jenis kasus penyakit berdasarkan ruangan
         * @param type $ruangan_id
         */
        public function getJenisKasusPenyakitItems($ruangan_id = null)
        {            
            $criteria = new CdbCriteria();
            if(!empty($ruangan_id)){
				$criteria->join = "JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id";
				$criteria->addCondition('kasuspenyakitruangan_m.ruangan_id = '.$ruangan_id);
			}
            $criteria->addCondition('t.jeniskasuspenyakit_aktif = true');
            $criteria->order = "t.jeniskasuspenyakit_nama ASC";
            return JeniskasuspenyakitM::model()->findAll($criteria);
        }
	
		/**
         * Mengambil daftar semua kelaspelayanan berdasarkan ruangan_id
         * @return CActiveDataProvider 
		 * RND-5378
         */
        public static function getKelasPelayananItems($ruangan_id = null)
        {
            
			$criteria = new CdbCriteria();
			if(!empty($ruangan_id)){
				$criteria->join = "JOIN kelasruangan_m on t.kelaspelayanan_id = kelasruangan_m.kelaspelayanan_id";
				$criteria->addCondition('kelasruangan_m.ruangan_id ='.$ruangan_id);
			}
			$criteria->addCondition('t.kelaspelayanan_aktif = true');
			$criteria->order = "t.kelaspelayanan_nama ASC";
			return KelaspelayananM::model()->findAll($criteria);
        }
        
        /**
         * Mengambil daftar semua kelaspelayanan
         * @return CActiveDataProvider 
         */
        public function getKelasTanggunganItems()
        {
			$cri = new CDbCriteria();
			$cri->addCondition(" kelaspelayanan_aktif = TRUE ");
			$cri->addCondition(" kelasbpjs_id IS NOT NULL ");
			$cri->order = " urutankelas ASC ";
            //return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'kelaspelayanan_nama'));
			return KelaspelayananM::model()->findAll($cri);
        }
		
		
        
        /**
         * Mengambil daftar semua carabayar
         * @return CActiveDataProvider 
         */
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nama'));
        }
        /**
         * Mengambil daftar semua penjamin
         * @return CActiveDataProvider 
         */
        public function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
            else
                    return array();
        }
        /**
         * menampilkan dokter 
         * @param type $ruangan_id
         * @return type
         */
        public function getDokterItems($ruangan_id='')
        {
            $criteria = new CdbCriteria();
			if(!empty($ruangan_id)){
				$criteria->addCondition("ruangan_id= ".$ruangan_id);			
			}
            $criteria->addCondition('pegawai_aktif = true');
            $criteria->order = "nama_pegawai ASC";
            $modDokter = DokterV::model()->findAll($criteria);
            return $modDokter;
        }

        public function criteriaSearch()
		{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.

			$criteria=new CDbCriteria;

			$criteria->with=array('pasien');

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id= ".$this->pendaftaran_id);			
			}
			if(!empty($this->pasienpulang_id)){
				$criteria->addCondition("pasienpulang_id= ".$this->pasienpulang_id);			
			}
			if(!empty($this->pasienbatalperiksa_id)){
				$criteria->addCondition("pasienbatalperiksa_id= ".$this->pasienbatalperiksa_id);			
			}
			if(!empty($this->penanggungjawab_id)){
				$criteria->addCondition("penanggungjawab_id= ".$this->penanggungjawab_id);			
			}
			if(!empty($this->penjamin_id)){
				$criteria->addCondition("penjamin_id= ".$this->penjamin_id);			
			}
			if(!empty($this->shift_id)){
				$criteria->addCondition("shift_id= ".$this->shift_id);			
			}
			if(!empty($this->pasien_id)){
				$criteria->addCondition("pasien_id= ".$this->pasien_id);			
			}
			if(!empty($this->persalinan_id)){
				$criteria->addCondition("persalinan_id= ".$this->persalinan_id);			
			}
			if(!empty($this->pegawai_id)){
				$criteria->addCondition("pegawai_id= ".$this->pegawai_id);			
			}
			if(!empty($this->instalasi_id)){
				$criteria->addCondition("instalasi_id= ".$this->instalasi_id);			
			}
			if(!empty($this->caramasuk_id)){
				$criteria->addCondition("caramasuk_id= ".$this->caramasuk_id);			
			}
			if(!empty($this->pengirimanrm_id)){
				$criteria->addCondition("pengirimanrm_id= ".$this->pengirimanrm_id);			
			}
			if(!empty($this->peminjamanrm_id)){
				$criteria->addCondition("peminjamanrm_id= ".$this->peminjamanrm_id);			
			}
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition("jeniskasuspenyakit_id= ".$this->jeniskasuspenyakit_id);			
			}
			if(!empty($this->pembayaranpelayanan_id)){
				$criteria->addCondition("pembayaranpelayanan_id= ".$this->pembayaranpelayanan_id);			
			}
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id= ".$this->kelaspelayanan_id);			
			}
			if(!empty($this->carabayar_id)){
				$criteria->addCondition("carabayar_id= ".$this->carabayar_id);			
			}
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id= ".$this->pasienadmisi_id);			
			}
			if(!empty($this->kelompokumur_id)){
				$criteria->addCondition("kelompokumur_id= ".$this->kelompokumur_id);			
			}
			if(!empty($this->golonganumur_id)){
				$criteria->addCondition("golonganumur_id= ".$this->golonganumur_id);			
			}
			if(!empty($this->rujukan_id)){
				$criteria->addCondition("rujukan_id= ".$this->rujukan_id);			
			}
			if(!empty($this->antrian_id)){
				$criteria->addCondition("antrian_id= ".$this->antrian_id);			
			}
			if(!empty($this->karcis_id)){
				$criteria->addCondition("karcis_id= ".$this->karcis_id);			
			}
			if(!empty($this->ruangan_id)){
				$criteria->addCondition("ruangan_id= ".$this->ruangan_id);			
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
			$criteria->compare('LOWER(tglselesaiperiksa)',strtolower($this->tglselesaiperiksa),true);
			$criteria->compare('LOWER(keterangan_reg)',strtolower($this->keterangan_reg),true);
			$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
			$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
			$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
			$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
			$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
			$criteria->compare('nopendaftaran_aktif',$this->nopendaftaran_aktif);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			$criteria->compare('LOWER(tgl_konfirmasi)',strtolower($this->tgl_konfirmasi),true);
			$criteria->compare('LOWER(tglrenkontrol)',strtolower($this->tglrenkontrol),true);
			$criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(pasien.alamat_pasien)',strtolower($this->alamat_pasien),true);
			$criteria->compare('statusfarmasi',$this->statusfarmasi);

			return $criteria;
		}
        /**
         * menampilkan riwayat pendaftaran pasien di:
         * - pendaftaran RJ
         * - pendaftaran RD
         * - pendaftaran RI
         * @return \CActiveDataProvider
         */
        public function searchRiwayatPasien(){
            $criteria=new CDbCriteria;
            $criteria->addCondition('pasien_id = '.$this->pasien_id);
            $criteria->order = 'tgl_pendaftaran desc';          
            $criteria->limit = 5;          
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchKontrolPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('pasien');
		
		$criteria->addCondition('tglrenkontrol IS NOT NULL');
		
		if($this->ceklis == 1)
		{
			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
                        $criteria->order = "tgl_pendaftaran DESC";
			
		}else{
			$criteria->addBetweenCondition('tglrenkontrol::date',$this->tgl_awalrenkon,$this->tgl_akhirrenkon);
                        $criteria->order = "tglrenkontrol DESC";
		}
		
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id= ".$this->pendaftaran_id);			
		}
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition("pasienpulang_id= ".$this->pasienpulang_id);			
		}
		if(!empty($this->pasienbatalperiksa_id)){
			$criteria->addCondition("pasienbatalperiksa_id= ".$this->pasienbatalperiksa_id);			
		}
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition("penanggungjawab_id= ".$this->penanggungjawab_id);			
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id= ".$this->penjamin_id);			
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id= ".$this->shift_id);			
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id= ".$this->pasien_id);			
		}
		if(!empty($this->persalinan_id)){
			$criteria->addCondition("persalinan_id= ".$this->persalinan_id);			
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id= ".$this->pegawai_id);			
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id= ".$this->instalasi_id);			
		}
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition("caramasuk_id= ".$this->caramasuk_id);			
		}
		if(!empty($this->pengirimanrm_id)){
			$criteria->addCondition("pengirimanrm_id= ".$this->pengirimanrm_id);			
		}
		if(!empty($this->peminjamanrm_id)){
			$criteria->addCondition("peminjamanrm_id= ".$this->peminjamanrm_id);			
		}
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id= ".$this->jeniskasuspenyakit_id);			
		}
		if(!empty($this->pembayaranpelayanan_id)){
			$criteria->addCondition("pembayaranpelayanan_id= ".$this->pembayaranpelayanan_id);			
		}
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id= ".$this->kelaspelayanan_id);			
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id= ".$this->carabayar_id);			
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id= ".$this->pasienadmisi_id);			
		}
		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition("kelompokumur_id= ".$this->kelompokumur_id);			
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition("golonganumur_id= ".$this->golonganumur_id);			
		}
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("rujukan_id= ".$this->rujukan_id);			
		}
		if(!empty($this->antrian_id)){
			$criteria->addCondition("antrian_id= ".$this->antrian_id);			
		}
		if(!empty($this->karcis_id)){
			$criteria->addCondition("karcis_id= ".$this->karcis_id);			
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id= ".$this->ruangan_id);			
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->prefix_pendaftaran.$this->no_pendaftaran),true);
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
		$criteria->compare('LOWER(tglselesaiperiksa)',strtolower($this->tglselesaiperiksa),true);
		$criteria->compare('LOWER(keterangan_reg)',strtolower($this->keterangan_reg),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('nopendaftaran_aktif',$this->nopendaftaran_aktif);
		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		$criteria->compare('LOWER(tgl_konfirmasi)',strtolower($this->tgl_konfirmasi),true);
		$criteria->compare('LOWER(tglrenkontrol)',strtolower($this->tglrenkontrol),true);
		$criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(pasien.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('statusfarmasi',$this->statusfarmasi);
                

		$criteria->limit=10;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchListKunjungan(){
		$criteria = new CDBCriteria();
		if(!empty($this->pasien_id)){
			// exit($this->pasien_id);
			if(is_array($this->pasien_id)){
				$criteria->addInCondition("pasien_id",$this->pasien_id);			

			}else{
				$criteria->addCondition("pasien_id= ".$this->pasien_id);			

			}
		}
		$criteria->order = 'tgl_pendaftaran DESC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
		
	public function getJumlahKunjungan(){
        $criteria = new CDBCriteria();
        $criteria->select = 'count(pasien_id) as jumlah';
        $criteria->group = 'pasien_id';
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id= ".$this->pasien_id);			
		}
        return PPPendaftaranT::model()->find($criteria)->jumlah;
    }

    public function getJumlahPasienRI(){
        $criteria = new CDBCriteria();
        $criteria->select = 'count(pasien_id) as jumlah';
        $criteria->group = 'pasien_id';
        $criteria->addCondition('pasienadmisi_id is not null');
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id= ".$this->pasien_id);			
		}
        return isset(PPPendaftaranT::model()->find($criteria)->jumlah)?PPPendaftaranT::model()->find($criteria)->jumlah:0;
    }

    public function getJumlahPasienRJ(){
        $criteria = new CDBCriteria();
        $criteria->select = 'count(pasien_id) as jumlah';
        $criteria->group = 'pasien_id';
        $criteria->addCondition('instalasi_id ='.Params::INSTALASI_ID_RJ);
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id= ".$this->pasien_id);			
		}
        return isset(PPPendaftaranT::model()->find($criteria)->jumlah)?PPPendaftaranT::model()->find($criteria)->jumlah:0;
    }

    public function getJumlahPasienRD(){
        $criteria = new CDBCriteria();
        $criteria->select = 'count(pasien_id) as jumlah';
        $criteria->group = 'pasien_id';
        $criteria->addCondition('instalasi_id ='.Params::INSTALASI_ID_RD);
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id= ".$this->pasien_id);			
		}
        return isset(PPPendaftaranT::model()->find($criteria)->jumlah)?PPPendaftaranT::model()->find($criteria)->jumlah:0;
    }    
	
	public function getDokterItemsInstalasi($instalasi_id='')
	{
		if(!empty($instalasi_id))
			return DokterV::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id,'pegawai_aktif'=>true), array('order'=>'nama_pegawai asc'));
		else
			return array();
	}
    
    public function getRuanganHD()
    {
        $criteria = new CDbCriteria();
        $criteria->order = "ruangan_nama";
        return RuanganhemodialisaV::model()->findAll($criteria);
    }
        
}


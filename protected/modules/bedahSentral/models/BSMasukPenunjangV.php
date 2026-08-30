<?php

/**
 * This is the model class for table "pasienmasukpenunjang_v".
 *
 * The followings are the available columns in table 'pasienmasukpenunjang_v':
 * @property integer $pasien_id
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $pendaftaran_id
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $keadaanmasuk
 * @property string $statuspasien
 * @property boolean $alihstatus
 * @property string $statusmasuk
 * @property string $umur
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $caramasuk_id
 * @property string $caramasuk_nama
 * @property integer $shift_id
 * @property integer $golonganumur_id
 * @property string $golonganumur_nama
 * @property string $no_rujukan
 * @property string $nama_perujuk
 * @property string $tanggal_rujukan
 * @property string $diagnosa_rujukan
 * @property integer $asalrujukan_id
 * @property string $asalrujukan_nama
 * @property integer $penanggungjawab_id
 * @property string $pengantar
 * @property string $hubungankeluarga
 * @property string $nama_pj
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property integer $instalasiasal_id
 * @property string $instalasiasal_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $gelardokterasal
 * @property string $nama_dokterasal
 * @property string $gelarbelakang_nama
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property string $no_urutperiksa
 * @property string $kunjungan
 * @property string $statusperiksa
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $pegawai_id
 */
class BSMasukPenunjangV extends PasienmasukpenunjangV
{
        public $ceklis = false;
		public $tgl_awall,$tgl_akhirl;
		public $statuspendaftaran;
		public $dokterpenerima_nama;

	public $ppds_id, $ppds_nama;
		public $dpjp_nama;
		public $kelastanggungan_nama;
		public $kamarruangan_nokamar;
		public $kamarruangan_nobed, $nosep;
		
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienmasukpenunjangV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	
        public function searchBS()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.


		// echo '<pre>';
        // var_dump($this->tgl_awal, $this->tgl_akhir);
        // var_dump($this->tgl_awall, $this->tgl_akhirl);
        //  die;
		$criteria=new CDbCriteria;
		$criteria->join = " JOIN pendaftaran_t p ON p.pendaftaran_id = t.pendaftaran_id ";
		$criteria->select = " t.*, p.statusperiksa as statuspendaftaran ";

		if (!empty($this->statuspendaftaran)){
			$criteria->addCondition(" p.statusperiksa ilike '".strtolower($this->statuspendaftaran)."' ");
		}
		
		if(!empty($this->pasien_id)){
			$criteria->addCondition('t.pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->nama_pasien) || !empty($this->no_rekam_medik) || !empty($this->no_identitas_pasien)){
			$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
			$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		}else{
			$criteria->addCondition('DATE(t.tglmasukpenunjang) BETWEEN \''.MyFormatter::formatDateTimeForDb($this->tgl_awal).'\' AND \''. MyFormatter::formatDateTimeForDb($this->tgl_akhir).'\'');
		}
		$criteria->compare('LOWER(t.jenisidentitas)',strtolower($this->jenisidentitas),true);
		
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('t.rt',$this->rt);
		$criteria->compare('t.rw',$this->rw);
		$criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(t.golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(t.photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(t.alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(t.statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(vstatusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->addBetweenCondition('DATE(tglmasukpenunjang)', MyFormatter::formatDateTimeForDb($this->tgl_awal), MyFormatter::formatDateTimeForDb($this->tgl_akhir));
		$criteria->compare('LOWER(t.tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('t.propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('t.kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('t.kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('t.kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition('t.pekerjaan_id = '.$this->pekerjaan_id);
		}
		$criteria->compare('LOWER(t.pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                
//		if($this->ceklis)
//		{
			
//		}
		
		if ($this->ceklis) {
			$criteria->addBetweenCondition('DATE(t.tanggal_lahir)', MyFormatter::formatDateTimeForDb($this->tgl_awall), MyFormatter::formatDateTimeForDb($this->tgl_akhirl));
			}
                
		$criteria->compare('LOWER(t.keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(t.statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('t.alihstatus',$this->alihstatus);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(t.no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(t.namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(t.nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition('t.caramasuk_id = '.$this->caramasuk_id);
		}
		$criteria->compare('LOWER(t.caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('t.shift_id = '.$this->shift_id);
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition('t.golonganumur_id = '.$this->golonganumur_id);
		}
		$criteria->compare('LOWER(t.golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('LOWER(t.no_rujukan)',strtolower($this->no_rujukan),true);
		$criteria->compare('LOWER(t.nama_perujuk)',strtolower($this->nama_perujuk),true);
		$criteria->compare('LOWER(t.tanggal_rujukan)',strtolower($this->tanggal_rujukan),true);
		$criteria->compare('LOWER(t.diagnosa_rujukan)',strtolower($this->diagnosa_rujukan),true);
		if(!empty($this->asalrujukan_id)){
			$criteria->addCondition('t.asalrujukan_id = '.$this->asalrujukan_id);
		}
		$criteria->compare('LOWER(t.asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition('t.penanggungjawab_id = '.$this->penanggungjawab_id);
		}
		$criteria->compare('LOWER(t.pengantar)',strtolower($this->pengantar),true);
		$criteria->compare('LOWER(t.hubungankeluarga)',strtolower($this->hubungankeluarga),true);
		$criteria->compare('LOWER(t.nama_pj)',strtolower($this->nama_pj),true);
		if(!empty($this->ruanganasal_id)){
			$criteria->addCondition('t.ruanganasal_id = '.$this->ruanganasal_id);
		}
		$criteria->compare('LOWER(t.ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->instalasiasal_id)){
			$criteria->addCondition('t.instalasiasal_id = '.$this->instalasiasal_id);
		}
		$criteria->compare('LOWER(t.instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('t.jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('t.kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(t.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(t.gelardokterasal)',strtolower($this->gelardokterasal),true);
		$criteria->compare('LOWER(t.nama_dokterasal)',strtolower($this->nama_dokterasal),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(t.no_urutperiksa)',strtolower($this->no_urutperiksa),true);
		$criteria->compare('LOWER(t.kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id') );
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('t.pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('t.pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}

		$criteria->addCondition('t.pasienbatalperiksa_id is null');
		
		$criteria->order='t.tglmasukpenunjang DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Mengambil daftar semua dokter ruangan
         * @return CActiveDataProvider 
         */
        public function getDokterItems($ruangan_id = '')
        {
            return DokterV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id')),array('order'=>'nama_pegawai'));
        }
        
        public function getKamarKosongItems($ruangan_id = '')
        {
            if(!empty($ruangan_id))
                return $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true, 'kamarruangan_aktif'=>true));
            else
                return array();
        }
        
        public function getParamedisItems($ruangan_id='')
        {
            if(!empty($ruangan_id))
                return ParamedisV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id));
            else
                return array();
        }
		
		public function getStatusOperasi($pasienmasukpenunjang_id){
			$res = "";
			$criteria = new CDbCriteria;
			$criteria->addCondition('pasienmasukpenunjang_id = '.$pasienmasukpenunjang_id);
			$model = BSRencanaOperasiT::model()->find($criteria);
			return empty($model->statusoperasi) ? null : $model->statusoperasi;
		}
                
                public function getPegawaiMengetahuiOperasi($pasienmasukpenunjang_id){
			$res = "";
			$criteria = new CDbCriteria;
			$criteria->addCondition('pasienmasukpenunjang_id = '.$pasienmasukpenunjang_id);
			$model = BSRencanaOperasiT::model()->find($criteria);
			return empty($model->pegmengetahui_id) ? null : $model->pegmengetahui_id;
		}
                
		public function getStatusDokumen($pengirimanrm_id,$status,$pendaftaran_id){
			$status_dokumen = '';
			$statusruangan = '';
			$tombol = '';
			$status_dok = $status;
			$modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
			if(empty($status) && empty($pengirimanrm_id)){
					$status = 'BELUM DIKIRIM';
			}else if(empty($status) || !empty($pengirimanrm_id)){
					$status = 'SUDAH DIKIRIM';
			}
			// return $pengirimanrm_id;
			if(!empty($pengirimanrm_id)){
					$modPengiriman = PengirimanrmT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id),array('order'=>'pengirimanrm_id desc'));
					$ruanganpenerima_id = $modPengiriman->ruanganpenerima_id;
					if(!empty($modPengiriman)){
							if(!empty($modPengiriman->ruangan_id) && $modPengiriman->ruanganpenerima_id == Yii::app()->user->getState('ruangan_id')){
									$statusruangan = " DARI ".strtoupper($modPengiriman->ruanganpengirim->ruangan_nama);
									$status = 'SUDAH DIKIRIM'.$statusruangan;
									$status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="verifikasiKirimanRM('.$pendaftaran_id.','.$pengirimanrm_id.')">'.$status.'</button>';
									$tombol = "";
							}else if(!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id != Yii::app()->user->getState('ruangan_id')){
									if (!empty($modPengiriman->tglterimadokrm)) {
										$statusruangan = " OLEH ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
										$status = 'SUDAH DITERIMA '.$statusruangan;
										$func = 'return false;';
									} else {
										$statusruangan = " KE ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
										$status = 'SUDAH DIKIRIM'.$statusruangan;
										$func = 'setPenerimaan(this,'.$pengirimanrm_id.','.$ruanganpenerima_id.',\''.$status_dok.'\','.$pendaftaran_id.')';
									}
									$status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="'.$func.'">'.$status.'</button>';
							} //else if (!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id == Yii::app()->user->getState('ruangan_id') && !empty($modPengiriman->tglterimadokrm)) {
							 //       $statusruangan = " DARI ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
							//	$status = 'SUDAH DITERIMA'.$statusruangan;
							//        $status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="return false;">'.$status.'</button>';
							//}
					}
			}
	
			if(!empty($modPendaftaran)){
					if(!empty($modPendaftaran->pengirimanrm_id)){
	//				$status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="setStatusDokumen(this,'.$pengirimanrm_id.',\''.$status.'\','.$pendaftaran_id.')">'.$status.'</button>';
							$status_dokumen = $status_dokumen;
					}else{
							$status_dokumen = '<button id="green" class="btn btn-danger" name="yt1">'.$status.'</button>';
					}
			}		
			return $status_dokumen;
	   }
	   
	       /**
  
    * 
    * @return type String Link HTML untuk pemeriksan pasien
    */
	public function getLinkPeriksaPasien() {
		$pendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);
		$konsul = KonsulpoliT::model()->findByAttributes(array(
			'pendaftaran_id'=>$this->pendaftaran_id,
			'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
		));

		$criteria = new CDbCriteria;
		$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		$model = BSRencanaOperasiT::model()->find($criteria);

		$disabled = false;

		if(!empty($model)) {
			$disabled = $model->statusoperasi == 'BATAL' ? 'fa-disabled' : '';
		}
		
	 //    if ($this->waktuverifikasipasien != NULL && $this->waktuspanggilpasien != NULL) {
		 if ($this->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
			 return CHtml::link("<i class='icon-form-periksa $disabled'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Pasien sudah dipulangkan.'); return false;"));
		 }

		 if ($this->statusperiksa == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP || $this->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
			return CHtml::link("<i class='icon-form-periksa'></i> ", Yii::app()->controller->createUrl("/bedahSentral/pemeriksaanPasienTBS",array("pendaftaran_id"=>$this->pendaftaran_id, 'pasienmasukpenunjang_id' => $this->pasienmasukpenunjang_id)),array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
		}
		  
		 if (!empty($konsul)) { //RSPMC-1645
			 return CHtml::link("<i class='icon-form-periksa $disabled'></i> ", Yii::app()->controller->createUrl("/bedahSentral/pemeriksaanPasienTBS",array("pendaftaran_id"=>$this->pendaftaran_id, 'pasienmasukpenunjang_id' => $this->pasienmasukpenunjang_id)),array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
		 }
		 
		//   if (!empty($pendaftaran->pasienpulang_id)) {
			//   return CHtml::link("<i class='icon-form-periksa $disabled'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Pasien sedang di rawat inap.'); return false;"));
			//   return CHtml::link("<i class='icon-form-periksa $disabled'></i> ", '', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
		//   }
		 
		 
		 if ($this->penjamin_id == Params::PENJAMIN_ID_UMUM) {
			 
			  if (!empty($pendaftaran->karcis_id)) {
				  $tindakan = TindakanpelayananT::model()->findByAttributes(array(
					  'pendaftaran_id'=>$this->pendaftaran_id,
					  'karcis_id'=>$pendaftaran->karcis_id,
				  ));
			  } else {
				  if (empty($tindakan)) {
					  $tindakan = TindakanpelayananT::model()->findByAttributes(array(
						  'pendaftaran_id'=>$this->pendaftaran_id,
						  'ruangan_id'=>2,
					  ), array(
						  'condition'=>'karcis_id is not null'
					  ));
				  }
			  }
			  
			  // return $tindakan->tindakanpelayanan_id;
			  
			  if (!empty($tindakan)) {
				  if (empty($tindakan->tindakansudahbayar_id)) {
					 // return CHtml::link("<i class='icon-form-periksa'></i> ", '#', array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien", "onclick"=>"myAlert('Pasien belum membayar karcis.'); return false;"));
				  }
			  }
		 }
		 
		//  if (!$this->alihstatus) {
			if(!empty($this->pendaftaran_id)){
				return CHtml::link("<i class='icon-form-periksa'></i> ", Yii::app()->controller->createUrl("/bedahSentral/pemeriksaanPasienTBS",array("pendaftaran_id"=>$this->pendaftaran_id, 'pasienmasukpenunjang_id' => $this->pasienmasukpenunjang_id)),array("id"=>$this->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
			} else {
				return CHtml::link("<i class='icon-form-periksa fa-disabled'></i> ", '', array());
			}
		//  } else {
		// 	if(!empty($this->pendaftaran_id)){
		// 		return CHtml::link("<i class='icon-list-alt'></i>", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
		// 	} else {
		// 		return CHtml::link("<i class='icon-form-periksa fa-disabled'></i> ", '', array());
		// 	}
		//  }
	 //    }else{
	 //     return CHtml::link("<i style='font-size:30px' class='" . MyIcon::getIcons('periksa') . "'></i> ", "", array("onclick" => 'myAlert("Pasien Belum Dilakukan Verifikasi");', "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien"));
	 //    }
 
		
	}

	public function searchPasienOperasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.


		// echo '<pre>';
        // var_dump($this->tgl_awal, $this->tgl_akhir);
        // var_dump($this->tgl_awall, $this->tgl_akhirl);
        //  die;
		$criteria=new CDbCriteria;
		$criteria->join = "LEFT JOIN sep_t sep ON sep.sep_id = t.sep_id ";
		$criteria->select = " t.*, sep.nosep";
		
		if(!empty($this->pasien_id)){
			$criteria->addCondition('t.pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->nama_pasien) || !empty($this->no_rekam_medik) || !empty($this->no_identitas_pasien)){
			$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
			$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		}else{
			$criteria->addCondition('DATE(t.tglmasukpenunjang) BETWEEN \''.MyFormatter::formatDateTimeForDb($this->tgl_awal).'\' AND \''. MyFormatter::formatDateTimeForDb($this->tgl_akhir).'\'');
		}
		$criteria->compare('LOWER(t.jenisidentitas)',strtolower($this->jenisidentitas),true);
		
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('t.rt',$this->rt);
		$criteria->compare('t.rw',$this->rw);
		$criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(t.golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(t.photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(t.alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(t.statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(vstatusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->addBetweenCondition('DATE(tglmasukpenunjang)', MyFormatter::formatDateTimeForDb($this->tgl_awal), MyFormatter::formatDateTimeForDb($this->tgl_akhir));
		$criteria->compare('LOWER(t.tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('t.propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(t.propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('t.kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(t.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('t.kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('t.kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition('t.pekerjaan_id = '.$this->pekerjaan_id);
		}
		$criteria->compare('LOWER(t.pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		
		if ($this->ceklis) {
			$criteria->addBetweenCondition('DATE(t.tanggal_lahir)', MyFormatter::formatDateTimeForDb($this->tgl_awall), MyFormatter::formatDateTimeForDb($this->tgl_akhirl));
			}
                
		$criteria->compare('LOWER(t.keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(t.statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('t.alihstatus',$this->alihstatus);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(t.no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(t.namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(t.nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition('t.caramasuk_id = '.$this->caramasuk_id);
		}
		$criteria->compare('LOWER(t.caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('t.shift_id = '.$this->shift_id);
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition('t.golonganumur_id = '.$this->golonganumur_id);
		}
		$criteria->compare('LOWER(t.golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('LOWER(t.no_rujukan)',strtolower($this->no_rujukan),true);
		$criteria->compare('LOWER(t.nama_perujuk)',strtolower($this->nama_perujuk),true);
		$criteria->compare('LOWER(t.tanggal_rujukan)',strtolower($this->tanggal_rujukan),true);
		$criteria->compare('LOWER(t.diagnosa_rujukan)',strtolower($this->diagnosa_rujukan),true);
		if(!empty($this->asalrujukan_id)){
			$criteria->addCondition('t.asalrujukan_id = '.$this->asalrujukan_id);
		}
		$criteria->compare('LOWER(t.asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition('t.penanggungjawab_id = '.$this->penanggungjawab_id);
		}
		$criteria->compare('LOWER(t.pengantar)',strtolower($this->pengantar),true);
		$criteria->compare('LOWER(t.hubungankeluarga)',strtolower($this->hubungankeluarga),true);
		$criteria->compare('LOWER(t.nama_pj)',strtolower($this->nama_pj),true);
		if(!empty($this->ruanganasal_id)){
			$criteria->addCondition('t.ruanganasal_id = '.$this->ruanganasal_id);
		}
		$criteria->compare('LOWER(t.ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->instalasiasal_id)){
			$criteria->addCondition('t.instalasiasal_id = '.$this->instalasiasal_id);
		}
		$criteria->compare('LOWER(t.instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('t.jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('t.kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(t.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(t.gelardokterasal)',strtolower($this->gelardokterasal),true);
		$criteria->compare('LOWER(t.nama_dokterasal)',strtolower($this->nama_dokterasal),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(t.no_urutperiksa)',strtolower($this->no_urutperiksa),true);
		$criteria->compare('LOWER(t.kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->addInCondition('t.ruangan_id', [Params::RUANGAN_ID_BEDAH, Params::RUANGAN_ID_OK_EMERGENCY]);
		
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('t.pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('t.pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}

		if(!empty($this->nosep)) {
			$criteria->addCondition("sep.nosep = '".$this->nosep . "'");
		}

		$criteria->addCondition('t.pasienbatalperiksa_id is null');
		
		$criteria->order='t.tglmasukpenunjang DESC';

		// echo '<pre>';var_dump($criteria);die;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
                
}
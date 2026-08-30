<?php

class BDPasienMasukPenunjangV extends PasienmasukpenunjangV
{
    public $statusperiksahasil;
    public $printhasillab;
    public $isPasienBatalPeriksa = false; //MENAMPILKAN PASIEN YG DIBATALKAN
    public $bulan;
    public $tgl_awal,$tgl_akhir;
	public $perawat_id = null; //untuk tindakanpelayanan_t (analis lab)
    public $diagnosa_nama, $kadarhb, $plt, $catatandokterpengirim, $jenis_permintaan;
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
     * untuk Lab Klinik
     * @return \CActiveDataProvider
     */
    public function searchLab()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->select = "*, pasienbatalperiksa_id, tglbatal, keterangan_batal";
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            if(!empty($this->isPasienBatalPeriksa)) //Jika ada filter berdasarkan pasien yg dibatalkan
                $criteria->addCondition('t.pasienbatalperiksa_id <> '.$this->isPasienBatalPeriksa);
            else
                $criteria->addCondition('t.pasienbatalperiksa_id is null');
            $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
            $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->order = "t.tglmasukpenunjang ASC"; //tglmasukpenunjang = tgl pendaftaran
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));


    }

    public function searchPemeriksaan(){
        $criteria=new CDbCriteria;
        $criteria->addCondition('instalasiasal_id = '.Params::INSTALASI_ID_LAB);
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));
    }

    public function searchRincian()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
                $criteria->select = 't.tgl_pendaftaran, t.no_rekam_medik,t.no_pendaftaran,t.nama_pasien,t.nama_bin,t.carabayar_nama,t.nama_pegawai,t.jeniskasuspenyakit_nama,t.pendaftaran_id,t.pembayaranpelayanan_id,t.pembayaranpelayanan_id';
        $criteria->group = 't.tgl_pendaftaran, t.no_rekam_medik,t.no_pendaftaran,t.nama_pasien,t.nama_bin,t.carabayar_nama,t.nama_pegawai,t.jeniskasuspenyakit_nama,t.pendaftaran_id,t.pembayaranpelayanan_id,t.pembayaranpelayanan_id';
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
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
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
        $criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition('pekerjaan_id = '.$this->pekerjaan_id);
		}
        $criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
        $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
        $criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
        $criteria->compare('alihstatus',$this->alihstatus);
        $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
        $criteria->compare('LOWER(umur)',strtolower($this->umur),true);
        $criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
        $criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
        $criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition('caramasuk_id = '.$this->caramasuk_id);
		}
        $criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition('golonganumur_id = '.$this->golonganumur_id);
		}
        $criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
        $criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
        $criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
        $criteria->compare('LOWER(tanggal_rujukan)',strtolower($this->tanggal_rujukan),true);
        $criteria->compare('LOWER(diagnosa_rujukan)',strtolower($this->diagnosa_rujukan),true);
		if(!empty($this->asalrujukan_id)){
			$criteria->addCondition('asalrujukan_id = '.$this->asalrujukan_id);
		}
        $criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition('penanggungjawab_id = '.$this->penanggungjawab_id);
		}
        $criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
        $criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
        $criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		if(!empty($this->ruanganasal_id)){
			$criteria->addCondition('ruanganasal_id = '.$this->ruanganasal_id);
		}
        $criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->instalasiasal_id)){
			$criteria->addCondition('instalasiasal_id = '.$this->instalasiasal_id);
		}
        $criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
        $criteria->compare('LOWER(gelardokterasal)',strtolower($this->gelardokterasal),true);
        $criteria->compare('LOWER(nama_dokterasal)',strtolower($this->nama_dokterasal),true);
        $criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
        $criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
        $criteria->compare('LOWER(tglmasukpenunjang)',strtolower($this->tglmasukpenunjang),true);
        $criteria->compare('LOWER(no_urutperiksa)',strtolower($this->no_urutperiksa),true);
        $criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
        $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
        $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
        $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
        $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
        $criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
        $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}                
		if($this->statusBayar == 'LUNAS'){
			$criteria->addCondition('pembayaranpelayanan_id is not null');
		}else if($this->statusBayar == 'BELUM LUNAS'){
			$criteria->addCondition('pembayaranpelayanan_id is null');
		}
        $criteria->order='tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    /**
     * untuk lab patologi anatomi
     * @return \CActiveDataProvider
     */
    public function searchLabAnatomi()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
            
            $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            // $criteria->compare('LOWER(hasilpemeriksaanlab_t.statusperiksahasil)',strtolower($this->statusperiksahasil),true);
            if(!empty($this->isPasienBatalPeriksa)) //Jika ada filter berdasarkan pasien yg dibatalkan
                $criteria->addCondition('t.pasienbatalperiksa_id <> '.$this->isPasienBatalPeriksa);
            else
                $criteria->addCondition('t.pasienbatalperiksa_id is null');
            $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
//                $criteria->compare('LOWER(nama_bin )',strtolower($this->nama),true);
//                $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
            $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
            $criteria->order = "t.tglmasukpenunjang ASC"; //tglmasukpenunjang = tgl pendaftaran
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
                
        
    }

    public function searchDialogLab()
    {
        $criteria=new CDbCriteria;
        $criteria->select = "*, pasienbatalperiksa_id, tglbatal, keterangan_batal";
        $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
        if(!empty($this->isPasienBatalPeriksa)) //Jika ada filter berdasarkan pasien yg dibatalkan
            $criteria->addCondition('t.pasienbatalperiksa_id <> '.$this->isPasienBatalPeriksa);
        else
            $criteria->addCondition('t.pasienbatalperiksa_id is null');
        $criteria->addCondition('t.ruangan_id='.Yii::app()->user->getState('ruangan_id'));

        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
        ));
                
    }
        
    public function getNamaLengkapDokter($pegawai_id)
    {
        $dokter = DokterV::model()->findByAttributes(array('pegawai_id'=>$pegawai_id));
        if(!empty($dokter->nama_pegawai)){
            return (isset($dokter->gelardepan) ? $dokter->gelardepan." " : "").$dokter->nama_pegawai.", ".(isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
        }else{
            return "-";
        }
    }

    public function getNamaPegawai($pegawai_id)
    {
        $dokter = PegawaiM::model()->findByAttributes(
            array('pegawai_id'=>$pegawai_id)
        );
        return $dokter->nama_pegawai;
    }        

    /**
     * menampilkan data terakhir daftar
     */
    public function searchPendaftaranTerakhir()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
            $criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
            $criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
			if(!empty($this->propinsi_id)){
				$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
			}
            $criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
			if(!empty($this->kabupaten_id)){
				$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
			}
            $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
			}
            $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
			}
            $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			if(!empty($this->instalasiasal_id)){
				$criteria->addCondition('instalasiasal_id = '.$this->instalasiasal_id);
			}
            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
			}
            $criteria->compare('LOWER(nama_pegawai)',($this->nama_pegawai));
            $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
            $criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
            $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
            $criteria->order = 'tgl_pendaftaran DESC';
            $criteria->limit = 10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }

    
    /**
     * menampilkan dialog kunjungan
     */
    public function searchDialogKunjungan()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$format = new MyFormatter();
//		$this->tglmasukpenunjang = empty($this->tglmasukpenunjang) ? date("Y-m-d") : $format->formatDateTimeForDb($this->tglmasukpenunjang); //filter grid
//		$criteria->addBetweenCondition("DATE(tglmasukpenunjang)",$this->tglmasukpenunjang." 00:00:00",$this->tglmasukpenunjang." 23:59:59");
                $tglmasukpenunjang = $this->getKonverviDateRange($this->tglmasukpenunjang);
                $criteria->addBetweenCondition('DATE(tglmasukpenunjang)', $tglmasukpenunjang[0]." 00:00:00", $tglmasukpenunjang[1]." 23:59:59");
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_masukpenunjang)',strtolower($this->no_masukpenunjang),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(nama_pegawai)',($this->nama_pegawai));
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->limit = 5;
//		$this->tglmasukpenunjang = $format->formatDateTimeForUser($this->tglmasukpenunjang);
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>array(
                                    'pageSize'=>5
                                ),
		));
    }
    
    public function getNamaModel()
    {
        return __CLASS__;
    }
	
	/**
	 * perawat_id tindakanpelayanan_t yg sudah ada
	 */
	public function getPerawatId(){
		$loadTindakan = BDTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$this->pasienmasukpenunjang_id),"perawat_id IS NOT NULL");
		if(isset($loadTindakan->perawat_id)){
			if(!empty($loadTindakan->perawat_id)){
				return $loadTindakan->perawat_id;
			}else{
				return null;
			}
		}else{
			return null;
		}
	}
	
	public function getStatusBD($status,$pasienmasukpenunjang_id,$pendaftaran_id){
	   if($status == "SEDANG PERIKSA"){
		   $status = '<button id="red" class="btn btn-primary" name="yt1" onclick="setStatus(this,\''.$status.'\','.$pasienmasukpenunjang_id.','.$pendaftaran_id.')">'.$status.'</button>';

	   }else if($status == "ANTRIAN"){
		   $status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setStatus(this,\''.$status.'\','.$pasienmasukpenunjang_id.','.$pendaftaran_id.')">'.$status.'</button>';
	   }else if($status == "SUDAH PULANG"){
		   $status = '<button id="blue" class="btn btn-danger-yellow" name="yt1" onclick="setStatus(this,\''.$status.'\','.$pasienmasukpenunjang_id.','.$pendaftaran_id.')">'.$status.'</button>';
	   }else{
		   $status = '<button id="orange" class="btn btn-danger-blue"  name="yt1">'.$status.'</button>';
	   }
	   return $status;
   }
   
   /**
	* untuk status dokumen rekam medis
	*/
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

	   if(!empty($pengirimanrm_id)){
		   $modPengiriman = PengirimanrmT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id),array('order'=>'pengirimanrm_id desc'));
		   $ruanganpenerima_id = $modPengiriman->ruanganpenerima_id;
		   if(!empty($modPengiriman)){
			   if(!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id == Yii::app()->user->getState('ruangan_id')){
				   $statusruangan = " DARI ".strtoupper($modPengiriman->ruanganpengirim->ruangan_nama);
				   $status = 'SUDAH DIKIRIM'.$statusruangan;
				   $status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="penerimaanDokumen(this,'.$pengirimanrm_id.',\''.$status_dok.'\','.$pendaftaran_id.')">'.$status.'</button>';
				   $tombol = "";
			   }else if(!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id != Yii::app()->user->getState('ruangan_id')){
				   $statusruangan = " KE- ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
				   $status = 'SUDAH DIKIRIM'.$statusruangan;
				   if(empty($ruanganpenerimaan_id)){
					   $ruanganpenerima_id = 99;
				   }
				   $status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="setPenerimaan(this,'.$pengirimanrm_id.','.$ruanganpenerima_id.',\''.$status_dok.'\','.$pendaftaran_id.')">'.$status.'</button>';
			   }
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
  
    public function getKonverviDateRange($tgl){
        $Tgl = (explode(" - ",$tgl));

        //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
        $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
        $Tgl[0] = $Tgl[0]->format('Y-m-d');
        $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
        $Tgl[1] = $Tgl[1]->format('Y-m-d');
        return array($Tgl[0],$Tgl[1]);
    }
        
}
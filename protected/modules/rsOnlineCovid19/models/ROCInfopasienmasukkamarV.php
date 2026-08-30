<?php

class ROCInfopasienmasukkamarV extends InfopasienmasukkamarV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienrawatinapV the static model class
     */
    public $ceklis = false;
    public $carakeluar;
	public $is_dokter = 0;
	public $pegawai_id;
	public $pilih,$daftartindakan_id,$ceklist;
	public $tgl_awall, $tgl_akhirl;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchRI()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        
		$criteria=new CDbCriteria;
		
		$criteria->addCondition('t.instalasi_id = '. Params::INSTALASI_ID_RI);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id); 	
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id); 	
		}
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition("t.caramasuk_id = ".$this->caramasuk_id); 	
		}
                if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("t.kelaspelayanan_id = ".$this->kelaspelayanan_id); 	
		}
                if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("t.jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id); 	
		}
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->prefix_pendaftaran.$this->no_pendaftaran),true);
        
		if($this->ceklis == 1)
		{
			$criteria->addBetweenCondition('DATE(t.tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
		}
        $criteria->compare('t.dokterpenerima_id', $this->dokterpenerima_id);
        
        if (!empty($this->pegawai_id)) {
            $criteria->addCondition(
                "(t.dpjp1_id = ".$this->pegawai_id." or t.dpjp2_id = ".$this->pegawai_id." or t.dpjp3_id = ".$this->pegawai_id.")"
            );
        }
		//$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
                $criteria->compare('t.kamarruangan_id', $this->kamarruangan_id);                
                if (!empty($this->tgl_pendaftaran)){
                    $criteria->addCondition(" DATE(t.tgl_pendaftaran) = '".MyFormatter::formatDateTimeForDb($this->tgl_pendaftaran)."' ");
                }
		//if($this->ceklis == 1)
		//{
        if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {     
                
			$criteria->addBetweenCondition('DATE(t.tglmasukkamar)',$this->tgl_awal,$this->tgl_akhir);
        }
		//}
                $criteria->order = "t.tgl_pendaftaran DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchRIDialog() {
        $prov = $this->searchRI();
        $prov->criteria->addCondition('a.rencanapulang is not null');
        $prov->criteria->join = "left join pasienadmisi_t a on a.pasienadmisi_id = t.pasienadmisi_id "
                . "left join (select a.pendaftaran_id, count(a.tindakanpelayanan_id) as total_tindakan from tindakanpelayanan_t a where a.tindakansudahbayar_id is not null group by a.pendaftaran_id) tp on tp.pendaftaran_id = t.pendaftaran_id "
                . "left join (select b.pendaftaran_id, count(b.obatalkespasien_id) as total_oa from obatalkespasien_t b where b.oasudahbayar_id is not null group by b.pendaftaran_id) oa on oa.pendaftaran_id = t.pendaftaran_id";
        $prov->criteria->addCondition("(tp.total_tindakan > 0 or oa.total_oa > 0)");
 
        
        return $prov;
    }
        
	public function getLamaRawat(){
				return CustomFunction::hitungHari($this->tglmasukkamar );
	}
        
	public function searchRILagi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		
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
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 	
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 	
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
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition("pekerjaan_id = ".$this->pekerjaan_id); 	
		}
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id); 	
		}
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id); 	
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id); 	
		}
		$criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
		$criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
		$criteria->compare('LOWER(tanggal_rujukan)',strtolower($this->tanggal_rujukan),true);
		$criteria->compare('LOWER(diagnosa_rujukan)',strtolower($this->diagnosa_rujukan),true);
		if(!empty($this->asalrujukan_id)){
			$criteria->addCondition("asalrujukan_id = ".$this->asalrujukan_id); 	
		}
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition("penanggungjawab_id = ".$this->penanggungjawab_id); 	
		}
		$criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
		$criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
                
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
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id); 	
		}                
		if($this->ceklis)
		{
			$criteria->addBetweenCondition('tgladmisi', $this->tgl_awal, $this->tgl_akhir);
			//$criteria->addCondition('tgladmisi BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
		}                
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('statuskeluar',$this->statuskeluar);
		$criteria->compare('rawatgabung',$this->rawatgabung);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition("kamarruangan_id = ".$this->kamarruangan_id); 	
		}
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
		$criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
		$criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
		$criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
		$criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	public function searchRIVisiteDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		$kelaspelayananruangan = Yii::app()->user->getState('kelaspelayananruangan');
		if(!empty($kelaspelayananruangan)){
			$criteria->addInCondition("kelaspelayanan_id",$kelaspelayananruangan); 	
			if (is_array($kelaspelayananruangan)){
				$criteria->addInCondition("kelaspelayanan_id",$kelaspelayananruangan); 	
			}else{
				$criteria->addCondition("kelaspelayanan_id = ".$kelaspelayananruangan); 	
			}
		}


		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}

        
	public function getTotaltagihan(){
		$criteria = new CDbCriteria();
		$criteria->select = 'sum(tarif_satuan * qty_tindakan) as tarif_satuan';
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 	
		}
		$jumlah = RincianbelumbayarrawatinapV::model()->find($criteria)->tarif_satuan;
		if (empty($jumlah)){
			$jumlah = 0;
		}
		return $jumlah;
	}
        
	public function searchRincianTagihan(){
		$criteria = new CDbCriteria();

		$criteria->with = array('pendaftaran');
		$criteria->addBetweenCondition('date(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->prefix_pendaftaran.$this->no_pendaftaran),true);
		$criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		if ($this->statusBayar == 'LUNAS'){
			$criteria->addCondition('pendaftaran.pembayaranpelayanan_id is not null');
		}else if ($this->statusBayar == 'BELUM LUNAS'){
			$criteria->addCondition('pendaftaran.pembayaranpelayanan_id is null');
		}

		return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
			));
	}
        
	/**
	 * Untuk menampilkan informasi pindahan dari
	 */
	public function getPindahanDari(){
		$retVal = array();
		$pindahkamar_id = null;
		$modPindahkamar = RIPindahkamarT::model()->findByAttributes(array('masukkamar_id'=>$this->masukkamar_id));
		$pindahkamar_id = (isset($modPindahKamar->pasienkamar_id) ? $modPindahkamar->pasienkamar_id : null);
		$modMasukkamarlama = RIMasukKamarT::model()->findByAttributes(array('pindahkamar_id'=>$pindahkamar_id));
		if(!$modPindahkamar)
			$modMasukkamarlama = new RIMasukKamarT;
		return $modMasukkamarlama;
	}
	/**
	 * Untuk mengecek tindakan dan obat dari pasienadmisi
	 */
	public function getTindakanDanObat(){
		$retVal = array();
		$retVal['ada'] = 0;
		$retVal['jmltindakan'] = 0;
		$retVal['jmlobat'] = 0;
		$retVal['msg'] = "";
		$modTindakan = TindakanpelayananT::model()->findAllByAttributes(array('pasienadmisi_id'=>$this->pasienadmisi_id, 'ruangan_id'=>  Yii::app()->user->getState('ruangan_id')));
		$retVal['jmltindakan'] = count($modTindakan);
		if($retVal['jmltindakan'] > 0)
			$retVal['msg'] .= $retVal['jmltindakan']." tindakan ";
		$modObatalkes = ObatalkespasienT::model()->findAllByAttributes(array('pasienadmisi_id'=>$this->pasienadmisi_id));
		$retVal['jmlobat'] = count($modObatalkes);
		if($retVal['jmlobat'] > 0)
			$retVal['msg'] .= $retVal['jmlobat']." obat ";
		$retVal['ada'] = $retVal['jmltindakan'] + $retVal['jmlobat'];
		return $retVal;
	}
        
	public function searchDialogKunjungan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		
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
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id); 	
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id); 	
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
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition("pekerjaan_id = ".$this->pekerjaan_id); 	
		}
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id); 	
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id); 	
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id); 	
		}
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id); 	
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id); 	
		}
		$criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
		$criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
		$criteria->compare('LOWER(tanggal_rujukan)',strtolower($this->tanggal_rujukan),true);
		$criteria->compare('LOWER(diagnosa_rujukan)',strtolower($this->diagnosa_rujukan),true);
		if(!empty($this->asalrujukan_id)){
			$criteria->addCondition("asalrujukan_id = ".$this->asalrujukan_id); 	
		}
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition("penanggungjawab_id = ".$this->penanggungjawab_id); 	
		}
		$criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
		$criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
                
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
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id); 	
		}
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('statuskeluar',$this->statuskeluar);
		$criteria->compare('rawatgabung',$this->rawatgabung);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition("kamarruangan_id = ".$this->kamarruangan_id); 	
		}
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
		$criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
		$criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
		$criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
		$criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);
		$criteria->order = 'tgladmisi DESC';
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    //'pagination'=>false,
            ));
	}
        
	public function getStatusDokumen($pengirimanrm_id,$status,$pendaftaran_id){
            //return $pengirimanrm_id." - ".$status." - ".$pendaftaran_id;
            
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
            
            // return $modPengiriman->pendaftaran_id." - ".$pendaftaran_id;
            
			if(!empty($modPengiriman)){
                $ruanganpenerima_id = $modPengiriman->ruanganpenerima_id;
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
                                            $statusruangan = " KE- ".strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
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
   
   
   public function searchDialogEresep(){
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
		
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->addCondition("t.statusperiksa NOT IN ('".Params::STATUSPERIKSA_SUDAH_PULANG."', '".Params::STATUSPERIKSA_BATAL_PERIKSA."', '".Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO."') ");
        $criteria->with = array('pendaftaran');
        $criteria->order = 't.tgl_pendaftaran DESC';
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
   public function searchDialogEresepPC(){
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
		
       if ($this->instalasi_id == Params::INSTALASI_ID_RI){
                $model = new ROCInfopasienmasukkamarV;
                $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
            }elseif ($this->instalasi_id == Params::INSTALASI_ID_RJ){
                $model = new InfokunjunganrjV;
                $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
            }elseif ($this->instalasi_id == Params::INSTALASI_ID_RD){
                $model = new InfokunjunganrdV;
                $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
            }elseif ($this->instalasi_id == Params::INSTALASI_ID_RD && $this->ruangan_id == Params::RUANGAN_ID_VK){
                $model = new InfokunjunganpersalinanV;
                $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
            }else{
                $model = $this;
            }
            
            if (!empty($this->instalasi_id)){
                $criteria->addCondition(" instalasi_id = '".$this->instalasi_id."' ");
            }
            
            return new CActiveDataProvider($model, array(
                    'criteria'=>$criteria,
            ));
    }
    
    public function getAlergiObat() {
        $nama = ''; 
        $modAnamnesa = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $this->pendaftaran_id));
        
        
        if (count($modAnamnesa)) {
            $no = 1;
            $checkAlergi = 0;
            foreach ($modAnamnesa as $anamnesa => $val) {
                if(!empty(trim($val->riwayatalergiobat))){
                    $val->riwayatalergiobat = preg_replace('/\s+/', '', $val->riwayatalergiobat);
                    $datatable = explode(',', trim($val->riwayatalergiobat));
                    if(!empty($datatable)){
                        foreach ($datatable as $key => $value) {
                            $nama .=' ' . $no . '.' . $value . '<br>';
                            $no++;
                        }
                    }
                    $checkAlergi++;
                }else{
                    if($checkAlergi > 1){
                        $checkAlergi--;
                    }
                }
            }    
            if($checkAlergi == 0){
                $nama = 'TIDAK ADA'; 
            }
        }else{
            $nama = 'TIDAK ADA'; 
        }
        return $nama;
    }
   
   
   
   
	        
}
?>

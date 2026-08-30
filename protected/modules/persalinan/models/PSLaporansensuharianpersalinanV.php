<?php

class PSLaporansensuharianpersalinanV extends LaporansensuharianpersalinanV {

    public $tglAwal;
    public $tglAkhir;
    public $data;
    public $jumlah;
    public $tick;
    public $pilihanx;
	public $ceklis = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDaftarPasien() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tglAwal, $this->tglAkhir);
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->with = array('pendaftaran');
        //$criteria->condition = 'pasienpulang.pendaftaran_id = t.pendaftaran_id';
        $criteria->order = 't.tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //'pasienpulang'=> array(self::HAS_ONE, 'PasienpulangT', 'pendaftaran_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'RDPendaftaranT', 'pendaftaran_id'),
                //'operasi'=>array(self::BELONGS_TO, 'OperasiM', 'operasi_id'),
        );
    }

    public function primaryKey() {
        return 'pendaftaran_id';
    }

    public static function berdasarkanStatus() {
        $status = array('pengunjung' => 'Berdasarkan Pengunjung',
            'kunjungan' => 'Berdasarkan Kunjungan',
            'rujukan' => 'Berdasarkan Rujukan'
        );
        return $status;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

    public function searchTable() {

        $criteria = new CDbCriteria;

		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tglAwal, $this->tglAkhir);
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
			$criteria->addCondition('propinsi_id ='.$this->propinsi_id);
		}
        $criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id ='.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id ='.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
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
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id ='.$this->shift_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id ='.$this->instalasi_id);
		}
        $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id ='.$this->jeniskasuspenyakit_id);
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition('diagnosa_id ='.$this->diagnosa_id);
		}
        $criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
        $criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id ='.$this->daftartindakan_id);
		}
        $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
        $criteria->order = 'tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        
        
        $criteria = MyFunction::criteriaGrafik1($this, 'tick');
        $criteria->select = 'count(pasien_id) as jumlah, pasien_id, kunjungan as data';
        $criteria->group = 'kunjungan, pasien_id';
        $criteria->order = 'jumlah DESC';
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tglAwal, $this->tglAkhir);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id ='.$this->propinsi_id);
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id ='.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id ='.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        // $criteria->order = 'tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition('tgl_pendaftaran BETWEEN \'' . $this->tglAwal . '\' AND \'' . $this->tglAkhir . '\'');
		
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id ='.$this->pasien_id);
		}
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tglAwal, $this->tglAkhir);
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
			$criteria->addCondition('propinsi_id ='.$this->propinsi_id);
		}
        $criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
		}
        $criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id ='.$this->kelurahan_id);
		}
        $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id ='.$this->kecamatan_id);
		}
        $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
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
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id ='.$this->shift_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
        $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id ='.$this->instalasi_id);
		}
        $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id ='.$this->jeniskasuspenyakit_id);
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->diagnosa_id)){
			$criteria->addCondition('diagnosa_id ='.$this->diagnosa_id);
		}
        $criteria->compare('LOWER(diagnosa_kode)',strtolower($this->diagnosa_kode),true);
        $criteria->compare('LOWER(diagnosa_nama)',strtolower($this->diagnosa_nama),true);
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id ='.$this->daftartindakan_id);
		}
        $criteria->compare('LOWER(daftartindakan_nama)',strtolower($this->daftartindakan_nama),true);
        $criteria->order = 'tgl_pendaftaran DESC';
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    
    public function getTotaltagihan(){
        $criteria = new CDbCriteria();
        $criteria->select = 'sum(tarif_tindakan) as tarif_tindakan';
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id ='.$this->pendaftaran_id);
		}
        $jumlah = RinciantagihanpasienV::model()->find($criteria)->tarif_tindakan;
        if (empty($jumlah)){
            $jumlah = 0;
        }
        return $jumlah;
    }
    
    public function searchDaftarPasienRincian() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tglAwal, $this->tglAkhir);
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->order = 't.tgl_pendaftaran DESC';
        if ($this->statusBayar == 'LUNAS'){
            
            $criteria->addCondition('pendaftaran.pembayaranpelayanan_id is not null');
        }else if ($this->statusBayar == 'BELUM LUNAS'){
            $criteria->addCondition('pendaftaran.pembayaranpelayanan_id is null');
        }
        
//        echo $this->statusBayar;
        $criteria->with = array('pendaftaran');
        //$criteria->condition = 'pasienpulang.pendaftaran_id = t.pendaftaran_id';
        //$criteria->order = 'no_urutantri';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

	public function searchRD()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id ='.$this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id ='.$this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id ='.$this->kecamatan_id);
		}             
		if($this->ceklis)
		{
			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tglAwal, $this->tglAkhir);
		}                
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id ='.$this->kelurahan_id);
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id ='.$this->instalasi_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->rujukan_id)){
			$criteria->addCondition('rujukan_id ='.$this->rujukan_id);
		}
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->order = 'tgl_pendaftaran DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	protected function afterFind(){
		foreach($this->metadata->tableSchema->columns as $columnName => $column){

			if (!strlen($this->$columnName)) continue;

			if ($column->dbType == 'date'){                         
					$this->$columnName = Yii::app()->dateFormatter->formatDateTime(
									CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
					}elseif ($column->dbType == 'timestamp without time zone'){
							$this->$columnName = Yii::app()->dateFormatter->formatDateTime(
									CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
					}
		}
		return true;
	}
        
        
	function getNamaPasienNamaBin()
	{
		return $this->nama_pasien.' bin '.$this->nama_bin;
	}
	
	
	public function getInsatalasiRuangan()
	{
		   
		return $this->instalasi_nama.' / '.$this->ruangan_nama;
	}
        
        public function getStatus($status,$id){
            if($status == "ANTRIAN"){
                $status = '<button id="red" class="btn btn-primary" name="yt1">'.$status.'</button>';

            }else if($status == "SEDANG PERIKSA"){
                $status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
            }else if($status == "SUDAH PULANG"){
                $status = '<button id="blue" class="btn btn-danger-yellow" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
            }else if($status == "SUDAH DI PERIKSA"){
                $status = '<button id="red" class="btn btn-danger-red" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
            }else{
                $status = '<button id="orange" class="btn btn-danger-blue"  name="yt1">'.$status.'</button>';
            }
            return $status;
        }
}

?>

<?php

/**
 * This is the model class for table "infokunjunganri_v".
 *
 * The followings are the available columns in table 'infokunjunganri_v':
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pasienadmisi_id
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $caramasuk_id
 * @property string $caramasuk_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $kamarruangan_id
 * @property string $tgladmisi
 * @property string $kamarruangan_nokamar
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 */
class PPInfoKunjunganRIV extends InfokunjunganriV
{
        public $jumlah;
        public $data;
        public $tick;
        public $tgl_awal,$tgl_akhir;
        public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        public $carakeluar_nama;
		public $tgl_awall,$tgl_akhirl;
		public $ceklis, $is_anamnesa, $is_periksafisik, $is_diagnosa, $is_tindakan, $carakeluar_id, $pilihanPeriode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganriV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * untuk set jenis kasus penyakit nama di laporan pasien rawat inap gatau kenapa pake bukan dari attribute tablenya langsung
         * @return string
         */
        public function getJenis_kasus_nama_penyakit(){
            return $this->jeniskasuspenyakit_nama;
        }
        
        /**
         * get status pasien
         * @return string
         */
        public function getStatusPasienRawatInap(){
            $pendaftaran = PendaftaranT::model()->findByPk($this->pendaftaran_id);
            return $status = (isset($pendaftaran->pasienpulang_id)) ? 'Dipulangkan' : 'Sedang Dirawat Inap';
        }
        
        public function searchRI()
	{

		$criteria=new CDbCriteria;
                
		//$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id "
                        . "left join rujukan_t r on r.rujukan_id = p.rujukan_id "
            . "left join pasienadmisi_t a on a.pasienadmisi_id = t.pasienadmisi_id";
                
                $criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
                $criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		
                $criteria->compare('t.pegawai_id', $this->pegawai_id);
                $criteria->compare('a.dokterpenerima_id', $this->dokterpenerima_id);
                $criteria->compare('t.kamarruangan_id', $this->kamarruangan_id);
                $criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
                
                $criteria->compare('t.asalrujukan_id', $this->asalrujukan_id);
                $criteria->compare('r.rujukandari_id', $this->rujukandari_id);
                
		if ($this->ceklis) {
			$criteria->addBetweenCondition('DATE(t.tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
		}
        if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id); 			
		}
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);                
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("t.pasienadmisi_id = ".$this->pasienadmisi_id); 			
		}
		
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("t.kelaspelayanan_id = ".$this->kelaspelayanan_id); 			
		}
		$criteria->compare('LOWER(t.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->kamarruangan_id)){
			$criteria->addCondition("t.kamarruangan_id = ".$this->kamarruangan_id); 			
		}
		$criteria->compare('LOWER(t.tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(t.kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		
                $criteria->compare('t.asalrujukan_id', $this->asalrujukan_id);
                $criteria->compare('lower(t.nama_perujuk)', strtolower($this->nama_perujuk), true);
		
		$criteria->compare('LOWER(t.status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		if(!empty($this->propinsi_id)){
			if (is_array($this->propinsi_id)){
				$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
			}else{
				$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
			}
		}	
		
		if(!empty($this->kabupaten_id)){
			if (is_array($this->kabupaten_id)){
				$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
			}else{
				$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
			}
		}
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id); 			
		}
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("t.kelurahan_id = ".$this->kelurahan_id); 			
		}
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		if (!empty($this->ruangan_id)){
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
			}else{
				$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
			}
		}
		
		if (!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
			}else{
				$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
			}
		}
		
		if (!empty($this->carabayar_id)){
			if (is_array($this->carabayar_id)){
				$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
			}else{
				$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
			}
		}
		
		if (!empty($this->penjamin_id)){
			if (is_array($this->penjamin_id)){
				$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
			}else{
				$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
			}
		}
		if($this->is_verifikasidiagnosa != '') {
			if($this->is_verifikasidiagnosa) {
				$criteria->addCondition("t.is_verifikasidiagnosa is true");
			} else {
				$criteria->addCondition("t.is_verifikasidiagnosa is false");
			}
		}
		if(!empty($this->carakeluar_id)) {
			$criteria->addCondition('carakeluar_id='.$this->carakeluar_id);
		}
		if(!empty($this->kondisikeluar_id)) {
			$criteria->addCondition('kondisikeluar_id='.$this->kondisikeluar_id);
		}
		if(!empty($this->pilihanPeriode)) {
			if($this->pilihanPeriode == '1') {
				$criteria->addBetweenCondition('DATE(t.tgladmisi)', $this->tgl_awal, $this->tgl_akhir);
			} else if($this->pilihanPeriode == '2') {
				$criteria->addBetweenCondition('DATE(t.tglpulang)', $this->tgl_awal, $this->tgl_akhir);
			} else {
				$criteria->addBetweenCondition('DATE(t.tgladmisi)', $this->tgl_awal, $this->tgl_akhir);
			}
		} else {
			$criteria->addBetweenCondition('DATE(t.tgladmisi)', $this->tgl_awal, $this->tgl_akhir);
		}
		$criteria->order = 't.tgl_pendaftaran DESC';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * menampilkan data terakhir daftar
         */
        public function searchPendaftaranTerakhir()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$time_awal = date('Y-m-d 00:00:00');
		$time_akhir = date('Y-m-d 23:59:59');
		$criteria->addBetweenCondition('DATE(tgladmisi)', $time_awal, $time_akhir);
		$criteria->order = 'tgladmisi DESC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
        
        /** fungsi untuk generate filter / criteria pada model untuk grafik
         * $model adalah model yang akan digunakan untuk grafik
         * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
         * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
         */
        public static function criteriaGrafik($model, $type='data', $addCols = array()){
            $criteria = new CDbCriteria;
            $criteria->select = 'count(pendaftaran_id) as jumlah';
			$criteria->select .= ', carabayar_nama as '.$type;
			$criteria->group .= 'carabayar_nama';
			$criteria->order = " jumlah DESC ";
            /*if ($_GET['filter'] == 'carabayar') {
                if (!empty($model->penjamin_id)) {
                    $criteria->select .= ', penjamin_nama as '.$type;
                    $criteria->group .= 'penjamin_nama';
                } else if (!empty($model->carabayar_id)) {
                    $criteria->select .= ', penjamin_nama as '.$type;
                    $criteria->group = 'penjamin_nama';
                } else {
                    $criteria->select .= ', carabayar_nama as '.$type;
                    $criteria->group = 'carabayar_nama';
                }
            } else if ($_GET['filter'] == 'wilayah') {
                if (!empty($model->kelurahan_id)) {
                    $criteria->select .= ', kelurahan_nama as '.$type;
                    $criteria->group .= 'kelurahan_nama';
                } else if (!empty($model->kecamatan_id)) {
                    $criteria->select .= ', kelurahan_nama as '.$type;
                    $criteria->group .= 'kelurahan_nama';
                } else if (!empty($model->kabupaten_id)) {
                    $criteria->select .= ', kecamatan_nama as '.$type;
                    $criteria->group .= 'kecamatan_nama';
                } else if (!empty($model->propinsi_id)) {
                    $criteria->select .= ', kabupaten_nama as '.$type;
                    $criteria->group .= 'kabupaten_nama';
                } else {
                    $criteria->select .= ', propinsi_nama as '.$type;
                    $criteria->group .= 'propinsi_nama';
                }
            }else{
				$criteria->select .= ', carabayar_nama as '.$type;
				$criteria->group = 'carabayar_nama';
			}

            if (!isset($_GET['filter'])){
                $criteria->select .= ', propinsi_nama as '.$type;
                $criteria->group .= 'propinsi_nama';
            }

            if (count((array)$addCols) > 0){
                if (is_array($addCols)){
                    foreach ($addCols as $i => $v){
                        $criteria->group .= ','.$v;
                        $criteria->select .= ','.$v.' as '.$i;
                    }
                }            
            }*/

            return $criteria;
        }
        
        public function searchGrafik(){
            
			$criteria = $this->criteriaGrafik($this, 'data', array('tick'=>'ruangan_nama'));

			//$criteria->order = 'ruangan_nama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
			$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
			$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
			$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
			$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
			$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 			
			}
			$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);                
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id); 			
			}
			
			$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 			
			}
			$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->kamarruangan_id)){
				$criteria->addCondition("kamarruangan_id = ".$this->kamarruangan_id); 			
			}
			$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
			$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
			
			$criteria->limit = -1;
			
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
			));
        }
        
    public function searchGrafikPemeriksaan() {
        $criteria = new CDbCriteria;
        $criteria->select = 'count(pendaftaran_id) as jumlah, ruangan_nama as data';
	$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
        $criteria->group = 'ruangan_nama';
        $criteria->order = 'ruangan_nama ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function searchTableLaporan()
		{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

			$criteria=new CDbCriteria;
                      /*  $criteria->join = " JOIN pasienadmisi_t pa ON pa.pasienadmisi_id = t.pasienadmisi_id "
                                        . " LEFT JOIN pasienpulang_t pp ON pp.pasienpulang_id = pa.pasienpulang_id "
                                        . " LEFT JOIN carakeluar_m ck ON ck.carakeluar_id = pp.carakeluar_id ";*/
			$criteria->addBetweenCondition('date(t.tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
			$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
			$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
			$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
			$criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
			$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
			$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
			$criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
			
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id); 			
			}
			$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);                
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition("t.pasienadmisi_id = ".$this->pasienadmisi_id); 			
			}
			
			if(!empty($this->caramasuk_id)){
				$criteria->addCondition("t.caramasuk_id = ".$this->caramasuk_id); 			
			}
			
			$criteria->compare('LOWER(t.caramasuk_nama)',strtolower($this->caramasuk_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("t.kelaspelayanan_id = ".$this->kelaspelayanan_id); 			
			}
			$criteria->compare('LOWER(t.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->kamarruangan_id)){
				$criteria->addCondition("t.kamarruangan_id = ".$this->kamarruangan_id); 			
			}
			$criteria->compare('LOWER(t.tgladmisi)',strtolower($this->tgladmisi),true);
			$criteria->compare('LOWER(t.kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
			
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id); 			
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("t.kelurahan_id = ".$this->kelurahan_id); 			
			}
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
			
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(t.status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			

			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
        
        public function searchPrint()
		{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

			$criteria=new CDbCriteria;
                
			$criteria->addBetweenCondition('date(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
			$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
			$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
			$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
			$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
			$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
			$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 			
			}
			$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);                
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id); 			
			}
			
			if(!empty($this->caramasuk_id)){
				$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id); 			
			}
			$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id); 			
			}
			$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->kamarruangan_id)){
				$criteria->addCondition("kamarruangan_id = ".$this->kamarruangan_id); 			
			}
			$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
			$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
			
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
			
			$criteria->limit = -1;

			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
			));
		}
        
        public function getNamaModel()
        {
            return __CLASS__;
        }
        
         public function searchGrafikAgama(){
             
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, agama as data';
			$criteria->group = 'agama';
			$criteria->order = 'agama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
				
			
			$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikUmur(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, golonganumur_nama as data';
			$criteria->group = 'golonganumur_nama';
			$criteria->order = 'golonganumur_nama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);$criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
			
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikJk(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, jeniskelamin as data';
			$criteria->group = 'jeniskelamin';
			$criteria->order = 'jeniskelamin';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
			
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikStatus(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, statuspasien as data';
			$criteria->group = 'statuspasien';
			$criteria->order = 'statuspasien';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikPekerjaan(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, pekerjaan_nama as data';
			$criteria->group = 'pekerjaan_nama';
			$criteria->order = 'pekerjaan_nama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikStatusPerkawinan(){
            
			$criteria=new CDbCriteria;

			$criteria->select = "count(pendaftaran_id) as jumlah, (CASE WHEN statusperkawinan = '' THEN 'Tidak Diketahui' ELSE statusperkawinan END ) as data";
			$criteria->group = 'statusperkawinan';
			$criteria->order = 'statusperkawinan';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
			
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikKecamatan(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, kecamatan_nama as data';
			$criteria->group = 'kecamatan_nama';
			$criteria->order = 'kecamatan_nama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
			
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikKabupaten(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, kabupaten_nama as data';
			$criteria->group = 'kabupaten_nama';
			$criteria->order = 'kabupaten_nama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikCaraMasuk(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, caramasuk_nama as data';
			$criteria->group = 'caramasuk_nama';
			$criteria->order = 'caramasuk_nama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
			
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        public function searchGrafikDokterPemeriksa(){
            
            $criteria=new CDbCriteria;

            $criteria->select = "count(pendaftaran_id) as jumlah, CONCAT(gelardepan,' ',nama_pegawai,' ',gelarbelakang_nama) as data";
            $criteria->group = 'data';
            $criteria->order = 'jumlah DESC';

            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
            $criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
            $criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
            $criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
//		                
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        public function searchGrafikUnitPelayanan(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, ruangan_nama as data';
			$criteria->group = 'ruangan_nama';
			$criteria->order = 'ruangan_nama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        
         public function searchGrafikPenjamin(){
            
                $criteria=new CDbCriteria;
               
                $criteria->select = 'count(pendaftaran_id) as jumlah, penjamin_nama as data';
                $criteria->group = 'penjamin_nama';
                $criteria->order = 'penjamin_nama';
                
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
				
				if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
				}
				$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
				if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
				}
				$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
				
				$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
				
				if(!empty($this->propinsi_id)){
					if (is_array($this->propinsi_id)){
						$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
					}else{
						$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
					}
				}	

				if(!empty($this->kabupaten_id)){
					if (is_array($this->kabupaten_id)){
						$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
					}else{
						$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
					}
				}

				if (!empty($this->ruangan_id)){
					if (is_array($this->ruangan_id)){
						$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
					}else{
						$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
					}
				}

				if (!empty($this->instalasi_id)){
					if (is_array($this->instalasi_id)){
						$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
					}else{
						$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
					}
				}

				if (!empty($this->carabayar_id)){
					if (is_array($this->carabayar_id)){
						$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
					}else{
						$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
					}
				}

				if (!empty($this->penjamin_id)){
					if (is_array($this->penjamin_id)){
						$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
					}else{
						$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
					}
				}
		//		                
				return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
				));
        }
        
        public function searchGrafikAlamat(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, alamat_pasien as data';
			$criteria->group = 'alamat_pasien';
			$criteria->order = 'alamat_pasien';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        
         public function searchGrafikRujukan(){
            
			$criteria=new CDbCriteria;

			$criteria->select = "count(pendaftaran_id) as jumlah, (CASE WHEN nama_perujuk IS NULL THEN 'Tidak Diketahui' ELSE nama_perujuk END ) as data";
			$criteria->group = 'nama_perujuk';
			$criteria->order = 'nama_perujuk';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
			
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
         public function searchGrafikrmRI(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, nama_pasien as data';
			$criteria->group = 'nama_pasien';
			$criteria->order = 'nama_pasien';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        
        public function searchGrafikKetPulang(){
            
                $criteria=new CDbCriteria;
               
                $criteria->select = 'count(pendaftaran_id) as jumlah, statusperiksa as data';
                $criteria->group = 'statusperiksa';
                $criteria->order = 'statusperiksa';
                
                $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
				
				if(!empty($this->kecamatan_id)){
					$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
				}
				$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
				if(!empty($this->kelurahan_id)){
					$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
				}
				$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
				
				$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
				
				if(!empty($this->propinsi_id)){
					if (is_array($this->propinsi_id)){
						$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
					}else{
						$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
					}
				}	

				if(!empty($this->kabupaten_id)){
					if (is_array($this->kabupaten_id)){
						$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
					}else{
						$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
					}
				}

				if (!empty($this->ruangan_id)){
					if (is_array($this->ruangan_id)){
						$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
					}else{
						$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
					}
				}

				if (!empty($this->instalasi_id)){
					if (is_array($this->instalasi_id)){
						$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
					}else{
						$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
					}
				}

				if (!empty($this->carabayar_id)){
					if (is_array($this->carabayar_id)){
						$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
					}else{
						$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
					}
				}

				if (!empty($this->penjamin_id)){
					if (is_array($this->penjamin_id)){
						$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
					}else{
						$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
					}
				}
		//		                
				return new CActiveDataProvider($this, array(
					'criteria'=>$criteria,
				));
        }
			public function searchGrafikKamarRuangan(){
            
			$criteria=new CDbCriteria;

			$criteria->select = 'count(pendaftaran_id) as jumlah, ruangan_nama as data';
			$criteria->group = 'ruangan_nama';
			$criteria->order = 'ruangan_nama';

			$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			
			
			$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        
        public function searchGrafikAlasanPulang(){
            
			$criteria=new CDbCriteria;
                        $criteria->join = " LEFT JOIN pendaftaran_t p ON p.no_pendaftaran = t.no_pendaftaran
                                            LEFT JOIN pasienadmisi_t pa ON pa.pendaftaran_id = p.pendaftaran_id
                                            LEFT JOIN pasienpulang_t pp ON pp.pasienadmisi_id = pa.pasienadmisi_id
                                            LEFT JOIN carakeluar_m ck ON ck.carakeluar_id = pp.carakeluar_id ";
			$criteria->select = "count(p.pendaftaran_id) as jumlah, (CASE WHEN ck.carakeluar_nama is NULL THEN 'Tidak Diketahui' ELSE ck.carakeluar_nama  END) as data";
			$criteria->group = 'ck.carakeluar_nama';
			$criteria->order = 'ck.carakeluar_nama';

			$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id); 			
			}
			$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("t.kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	

			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}

			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}

			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}

			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
            
			$criteria->compare('LOWER(t.status_konfirmasi)',strtolower($this->status_konfirmasi),true);
	//		                
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
        }
        
        public function getNamaAlias()
        {
            if(!empty($this->nama_bin)){
                return $this->nama_pasien.' Alias '.$this->nama_bin;
            }else{
                return $this->nama_pasien;
            }
            
        }
        
        public function primaryKey() {
            return 'pendaftaran_id';
        }
	
        /**
         * menampilkan morbiditas pasien
         * @return type
         */
        public function getMorbiditas(){
            $criteria = new CDbCriteria();
            $criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);
            $modDiagnosa = PasienmorbiditasT::model()->find($criteria);
            return $modDiagnosa;
        }

		public function searchInformasiRI()
		{

			$criteria=new CDbCriteria;
					
			//$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
			$criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id "
							. "left join rujukan_t r on r.rujukan_id = p.rujukan_id "
				. "left join pasienadmisi_t a on a.pasienadmisi_id = t.pasienadmisi_id";
					
					$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
			$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
			$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
			$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
			$criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
			$criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
			$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
			$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
					$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
			
					$criteria->compare('t.pegawai_id', $this->pegawai_id);
					$criteria->compare('a.dokterpenerima_id', $this->dokterpenerima_id);
					$criteria->compare('t.kamarruangan_id', $this->kamarruangan_id);
					$criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
					
					$criteria->compare('t.asalrujukan_id', $this->asalrujukan_id);
					$criteria->compare('r.rujukandari_id', $this->rujukandari_id);
					
			if ($this->ceklis) {
				$criteria->addBetweenCondition('DATE(t.tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
			}
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id); 			
			}
			$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);                
			if(!empty($this->pasienadmisi_id)){
				$criteria->addCondition("t.pasienadmisi_id = ".$this->pasienadmisi_id); 			
			}
			
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition("t.kelaspelayanan_id = ".$this->kelaspelayanan_id); 			
			}
			$criteria->compare('LOWER(t.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->kamarruangan_id)){
				$criteria->addCondition("t.kamarruangan_id = ".$this->kamarruangan_id); 			
			}
			$criteria->compare('LOWER(t.tgladmisi)',strtolower($this->tgladmisi),true);
			$criteria->compare('LOWER(t.kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
			
					$criteria->compare('t.asalrujukan_id', $this->asalrujukan_id);
					$criteria->compare('lower(t.nama_perujuk)', strtolower($this->nama_perujuk), true);
			
			$criteria->compare('LOWER(t.status_konfirmasi)',strtolower($this->status_konfirmasi),true);
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
				}else{
					$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
				}
			}	
			
			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
				}else{
					$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
				}
			}
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id); 			
			}
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("t.kelurahan_id = ".$this->kelurahan_id); 			
			}
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
			if (!empty($this->ruangan_id)){
				if (is_array($this->ruangan_id)){
					$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
				}else{
					$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
				}
			}
			
			if (!empty($this->instalasi_id)){
				if (is_array($this->instalasi_id)){
					$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
				}else{
					$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
				}
			}
			
			if (!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
				}else{
					$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
				}
			}
			
			if (!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
				}else{
					$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
				}
			}
			if($this->is_verifikasidiagnosa != '') {
				if($this->is_verifikasidiagnosa) {
					$criteria->addCondition("t.is_verifikasidiagnosa is true");
				} else {
					$criteria->addCondition("t.is_verifikasidiagnosa is false");
				}
			}
			if(!empty($this->carakeluar_id)) {
				$criteria->addCondition('carakeluar_id='.$this->carakeluar_id);
			}
			if(!empty($this->kondisikeluar_id)) {
				$criteria->addCondition('kondisikeluar_id='.$this->kondisikeluar_id);
			}
			if(!empty($this->tgl_awal)) {
				$criteria->addBetweenCondition('DATE(t.tgladmisi)', $this->tgl_awal, $this->tgl_akhir);
			}
			$criteria->order = 't.tgladmisi DESC';
					
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
}
<?php

class HDLaporankunjunganrdV extends LaporankunjunganrdV
{
        public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir,$thn_awal, $thn_akhir;
        public $jns_periode;
        public $data,$jumlah,$tick;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankunjunganrdV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
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
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id);				
		}
//		if(!empty($this->ruangan_id)){
//			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
//		}
//		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
//		if(!empty($this->instalasi_id)){
//			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
//		}
//		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);				
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);				
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("rujukan_id = ".$this->rujukan_id);				
		}
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition("pasienpulang_id = ".$this->pasienpulang_id);				
		}
		if(!empty($this->profilrd_id)){
			$criteria->addCondition("profilrd_id = ".$this->profilrd_id);				
		}
                //Carabayar
                if(!empty($this->carabayar_id)){
                        $criteria->addInCondition("carabayar_id ", $this->carabayar_id);
                }
                $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
                if(!empty($this->penjamin_id)){
                        $criteria->addInCondition("penjamin_id ", $this->penjamin_id);
                }
                $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);

                //Wilayah
                if(!empty($this->propinsi_id)){
                        $criteria->addInCondition("propinsi_id ", $this->propinsi_id);
                }
                $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
                if(!empty($this->kabupaten_id)){
                        $criteria->addInCondition("kabupaten_id ", $this->kabupaten_id);
                }
                $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
                if(!empty($this->kecamatan_id)){
                        $criteria->addInCondition("kecamatan_id ", $this->kecamatan_id);
                }
                $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
                if(!empty($this->kelurahan_id)){
                        $criteria->addInCondition("kelurahan_id ", $this->kelurahan_id);
                }
                $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);

                //Instalasi
                if(!empty($this->instalasi_id)){
                    $criteria->addInCondition("instalasi_id ", $this->instalasi_id);    
                }
                $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);

                if(!empty($this->ruangan_id)){
                    $criteria->addInCondition("ruangan_id ", $this->ruangan_id);  
                }
                $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
	public function searchPrint()
	{
			// Warning: Please modify the following code to remove attributes that
			// should not be searched.
		$format = new MyFormatter();
		$criteria = new CDbCriteria;

			if(!empty($this->pasien_id)){
				$criteria->addCondition("pasien_id = ".$this->pasien_id);				
			}
			$criteria->addBetweenCondition('date(tgl_pendaftaran)', $format->formatDateTimeForDb($this->tgl_awal), $format->formatDateTimeForDb($this->tgl_akhir));
			
//			if(!empty($this->propinsi_id)){
//				$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
//			}
//			$criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true); 
//			$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true); 
//			$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
//			if(!empty($this->kabupaten_id)){
//				$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
//			}
//			$criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
//			if(!empty($this->kelurahan_id)){
//				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
//			}
//			$criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
//			if(!empty($this->kecamatan_id)){
//				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
//			}
//			$criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
			}
			
//			if(!empty($this->carabayar_id)){
//				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
//			}
//			$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
//			if(!empty($this->penjamin_id)){
//				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
//			}
//			
//			if(!empty($this->instalasi_id)){
//				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
//			}
//			if(!empty($this->ruangan_id)){
//				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
//			}else{
//				$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
//			}
			//Carabayar
                        if(!empty($this->carabayar_id)){
                                $criteria->addInCondition("carabayar_id ", $this->carabayar_id);
                        }
                        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
                        if(!empty($this->penjamin_id)){
                                $criteria->addInCondition("penjamin_id ", $this->penjamin_id);
                        }
                        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);

                        //Wilayah
                        if(!empty($this->propinsi_id)){
                                $criteria->addInCondition("propinsi_id ", $this->propinsi_id);
                        }
                        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
                        if(!empty($this->kabupaten_id)){
                                $criteria->addInCondition("kabupaten_id ", $this->kabupaten_id);
                        }
                        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
                        if(!empty($this->kecamatan_id)){
                                $criteria->addInCondition("kecamatan_id ", $this->kecamatan_id);
                        }
                        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
                        if(!empty($this->kelurahan_id)){
                                $criteria->addInCondition("kelurahan_id ", $this->kelurahan_id);
                        }
                        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);

                        //Instalasi
                        if(!empty($this->instalasi_id)){
                            $criteria->addInCondition("instalasi_id ", $this->instalasi_id);    
                        }
                        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);

                        if(!empty($this->ruangan_id)){
                            $criteria->addInCondition("ruangan_id ", $this->ruangan_id);  
                        }
                        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);   
			
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}

	public function searchTable() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$format = new MyFormatter();
		$criteria = new CDbCriteria;

			if(!empty($this->pasien_id)){
				$criteria->addCondition("pasien_id = ".$this->pasien_id);				
			}
			$criteria->addBetweenCondition('date(tgl_pendaftaran)', $format->formatDateTimeForDb($this->tgl_awal), $format->formatDateTimeForDb($this->tgl_akhir));
			
//			if(!empty($this->propinsi_id)){
//				$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
//			}
//			$criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true); 
			$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true); 
			$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
//			if(!empty($this->kabupaten_id)){
//				$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
//			}
//			$criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
//			if(!empty($this->kelurahan_id)){
//				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
//			}
//			$criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
//			if(!empty($this->kecamatan_id)){
//				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
//			}
//			$criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
			}
			
//			if(!empty($this->carabayar_id)){
//				$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
//			}
//			$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
//			if(!empty($this->penjamin_id)){
//				$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
//			}
//			
//			if(!empty($this->instalasi_id)){
//				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
//			}
//			if(!empty($this->ruangan_id)){
//				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
//			}else{
//				$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
//			}
                        //Carabayar
                        if(!empty($this->carabayar_id)){
                                $criteria->addInCondition("carabayar_id ", $this->carabayar_id);
                        }
                        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
                        if(!empty($this->penjamin_id)){
                                $criteria->addInCondition("penjamin_id ", $this->penjamin_id);
                        }
                        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);

                        //Wilayah
                        if(!empty($this->propinsi_id)){
                                $criteria->addInCondition("propinsi_id ", $this->propinsi_id);
                        }
                        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
                        if(!empty($this->kabupaten_id)){
                                $criteria->addInCondition("kabupaten_id ", $this->kabupaten_id);
                        }
                        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
                        if(!empty($this->kecamatan_id)){
                                $criteria->addInCondition("kecamatan_id ", $this->kecamatan_id);
                        }
                        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
                        if(!empty($this->kelurahan_id)){
                                $criteria->addInCondition("kelurahan_id ", $this->kelurahan_id);
                        }
                        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);

                        //Instalasi
                        if(!empty($this->instalasi_id)){
                            $criteria->addInCondition("instalasi_id ", $this->instalasi_id);    
                        }
                        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);

                        if(!empty($this->ruangan_id)){
                            $criteria->addInCondition("ruangan_id ", $this->ruangan_id);  
                        }
                        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);   
			

		return new CActiveDataProvider($this, array(
					'criteria' => $criteria,
				));
	}

	public function searchGrafik() {
		$criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();

        $criteria->select = 'count(pendaftaran_id) as jumlah';
		$pilihanx = isset($_GET['HDLaporankunjunganrdV']['pilihanx']) ? $_GET['HDLaporankunjunganrdV']['pilihanx'] : null;
        if (!empty($this->penjamin_id)) {
            $criteria->select .= ', penjamin_nama as data';
            $criteria->group .= 'penjamin_nama';
        }else if (!empty($this->carabayar_id)) {
            $criteria->select .= ', carabayar_nama as data';
            $criteria->group .= 'carabayar_nama';
        }else if (!empty($this->kabupaten_id)) {
            $criteria->select .= ', kabupaten_nama as tick';
            $criteria->group .= ',kabupaten_nama';
        }else if (!empty($this->propinsi_id)) {
            $criteria->select .= ', propinsi_nama as tick';
            $criteria->group .= ',propinsi_nama';
        }else if ($pilihanx == 'pengunjung') {
			$criteria->select .= ', statuspasien as data';
			$criteria->group .= ' statuspasien';
		} else if ($pilihanx == 'kunjungan') {
			$criteria->select .= ', kunjungan as data';
			$criteria->group .= ' kunjungan';
		}else if ($pilihanx == 'rujukan'){
			$criteria->select .= ', statusmasuk as data';
			$criteria->group .= ' statusmasuk';
		}else{
			$criteria->select .= ', penjamin_nama as data';
			$criteria->group .= ' penjamin_nama';
		}
		
		return new CActiveDataProvider($this, array(
					'criteria' => $criteria,
				));
	}
	
	protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
		$format = new MyFormatter();
        $criteria = new CDbCriteria;
        
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $format->formatDateTimeForDb($this->tgl_awal), $format->formatDateTimeForDb($this->tgl_akhir));
		
//		if(!empty($this->propinsi_id)){
//			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
//		}
//		$criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true); 
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true); 
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
//		if(!empty($this->kabupaten_id)){
//			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
//		}
//		$criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
//		if(!empty($this->kelurahan_id)){
//			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
//		}
//		$criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
//		if(!empty($this->kecamatan_id)){
//			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
//		}
//		$criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
//		if(!empty($this->carabayar_id)){
//			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
//		}
//		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
//		if(!empty($this->penjamin_id)){
//			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
//		}
//		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
//		
//			if(!empty($this->instalasi_id)){
//				$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
//			}
//			if(!empty($this->ruangan_id)){
//				$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
//			}else{
//				$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
//			}
			
		//$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
//		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
                //Carabayar
                        if(!empty($this->carabayar_id)){
                                $criteria->addInCondition("carabayar_id ", $this->carabayar_id);
                        }
                        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
                        if(!empty($this->penjamin_id)){
                                $criteria->addInCondition("penjamin_id ", $this->penjamin_id);
                        }
                        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);

                        //Wilayah
                        if(!empty($this->propinsi_id)){
                                $criteria->addInCondition("propinsi_id ", $this->propinsi_id);
                        }
                        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
                        if(!empty($this->kabupaten_id)){
                                $criteria->addInCondition("kabupaten_id ", $this->kabupaten_id);
                        }
                        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
                        if(!empty($this->kecamatan_id)){
                                $criteria->addInCondition("kecamatan_id ", $this->kecamatan_id);
                        }
                        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
                        if(!empty($this->kelurahan_id)){
                                $criteria->addInCondition("kelurahan_id ", $this->kelurahan_id);
                        }
                        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);

                        //Instalasi
                        if(!empty($this->instalasi_id)){
                            $criteria->addInCondition("instalasi_id ", $this->instalasi_id);    
                        }
                        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);

                        if(!empty($this->ruangan_id)){
                            $criteria->addInCondition("ruangan_id ", $this->ruangan_id);  
                        }
                        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);   
        return $criteria;
    }	 
	
	public function getTindakan(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);
		$modDiagnosa = TindakanpelayananT::model()->findAll($criteria);
		$data = "<ul>";
		foreach($modDiagnosa as $value){ 
			
			if(isset($value->create_loginpemakai_id)) {
				 
				$Pemakai = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id'=>$value->create_loginpemakai_id));  
			
				if(isset($Pemakai->loginpemakai_id)) {
			        $data .= "<li>".$value->daftartindakan->daftartindakan_nama."/".$Pemakai->nama_pemakai."</li>";
		} 
		} 
		}
		$data .= "</ul>";
		return $data;
	}  
	
	public function getPegawai($create_loginpemakai_id){
		$hasil =''; 
		
		$modPegawai=  LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id'=>$create_loginpemakai_id)); 
		if(isset($modPegawai->nama_pemakai)) {
			$hasil = $modPegawai->nama_pemakai;
		} 
		
		return $hasil;
		
	}
        
        public function getInstalasiItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->addCondition('instalasi_aktif is TRUE');
		
	    return InstalasiM::model()->findAll($criteria);
	}
        public function getRuanganItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->addCondition('ruangan_aktif is TRUE');
		
	    return RuanganM::model()->findAll($criteria);
	}
}
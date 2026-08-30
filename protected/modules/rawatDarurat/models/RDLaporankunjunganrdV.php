<?php

class RDLaporankunjunganrdV extends LaporankunjunganrdV
{
        public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir, $jns_periode;
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
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id);				
		}
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
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("rujukan_id = ".$this->rujukan_id);				
		}
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition("pasienpulang_id = ".$this->pasienpulang_id);				
		}
		if(!empty($this->profilrd_id)){
			$criteria->addCondition("profilrd_id = ".$this->profilrd_id);				
		}

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
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("propinsi_id",$this->propinsi_id);				
				}else{
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
				}
			}
			$criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("kabupaten_id",$this->kabupaten_id);				
				}else{
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
				}		
			}
			$criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
			}
			$criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
			}
			$criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
			}
			
			if(!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("carabayar_id",$this->carabayar_id);				
				}else{
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
				}			
			}
			$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
			if(!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("penjamin_id",$this->penjamin_id);				
				}else{
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
				}				
			}
			$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

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

			
			$criteria->addBetweenCondition('date(tgl_pendaftaran)', $format->formatDateTimeForDb($this->tgl_awal), $format->formatDateTimeForDb($this->tgl_akhir));
			
			if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("propinsi_id",$this->propinsi_id);				
				}else{
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
				}
			}
			$criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("kabupaten_id",$this->kabupaten_id);				
				}else{
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
				}		
			}
			$criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
			}
			$criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
			}
			$criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
			}
			
			if(!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("carabayar_id",$this->carabayar_id);				
				}else{
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
				}			
			}
			$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
			if(!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("penjamin_id",$this->penjamin_id);				
				}else{
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
				}				
			}
			$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

		return new CActiveDataProvider($this, array(
					'criteria' => $criteria,
				));
	}

	public static function criteriaGrafik($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(pendaftaran_id) as jumlah';
        $filter = isset($_GET['filter'])?$_GET['filter']:null;
        if ( $filter == 'carabayar') {
            if (!empty($model->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group .= 'penjamin_nama';
            } elseif (!empty($model->carabayar_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group = 'penjamin_nama';
            } else {
                $criteria->select .= ', carabayar_nama as '.$type;
                $criteria->group = 'carabayar_nama';
            }
        } elseif ( $filter == 'wilayah') {
            if (!empty($model->kelurahan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama';
            } elseif (!empty($model->kecamatan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama';
            } elseif (!empty($model->kabupaten_id)) {
                $criteria->select .= ', kecamatan_nama as '.$type;
                $criteria->group .= 'kecamatan_nama';
            } elseif (!empty($model->propinsi_id)) {
                $criteria->select .= ', kabupaten_nama as '.$type;
                $criteria->group .= 'kabupaten_nama';
            } else {
                $criteria->select .= ', propinsi_nama as '.$type;
                $criteria->group .= 'propinsi_nama';
            }
        }

        if (!isset($_GET['filter'])){
            $criteria->select .= ', propinsi_nama as '.$type;
            $criteria->group .= 'propinsi_nama';
        }

        if (is_array($addCols) && count((array)$addCols) > 0){
            foreach ($addCols as $i => $v){
                $criteria->group .= ','.$v;
                $criteria->select .= ','.$v.' as '.$i;
            }            
        }

        return $criteria;
    }
    
     public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
         $format = new MyFormatter();
        $criteria = $this->criteriaGrafik($this, 'tick');
        if (!empty($criteria->group) &&(!empty($this->pilihanx))){
            $criteria->group .=',';
        }
        if ($this->pilihanx == 'pengunjung') {
            $criteria->select .= ', statuspasien as data';
            $criteria->group .= ' statuspasien';
        } elseif ($this->pilihanx == 'kunjungan') {
            $criteria->select .= ', kunjungan as data';
            $criteria->group .= ' kunjungan';
        }
        elseif ($this->pilihanx == 'rujukan'){
            $criteria->select .= ', statusmasuk as data';
            $criteria->group .= ' statusmasuk';
        }
        
        if (empty($this->pilihanx)){
            $criteria = $this->criteriaGrafik($this, 'data');
        }

        if(!empty($this->pasien_id)){
                $criteria->addCondition("pasien_id = ".$this->pasien_id);				
        }
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $format->formatDateTimeForDb($this->tgl_awal), $format->formatDateTimeForDb($this->tgl_akhir));

        if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("propinsi_id",$this->propinsi_id);				
				}else{
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
				}
			}
			$criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("kabupaten_id",$this->kabupaten_id);				
				}else{
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
				}		
			}
			$criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
			}
			$criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
			}
			$criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
			}
			
			if(!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("carabayar_id",$this->carabayar_id);				
				}else{
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
				}			
			}
			$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
			if(!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("penjamin_id",$this->penjamin_id);				
				}else{
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
				}				
			}
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

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
		
		if(!empty($this->propinsi_id)){
				if (is_array($this->propinsi_id)){
					$criteria->addInCondition("propinsi_id",$this->propinsi_id);				
				}else{
					$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
				}
			}
			$criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
			if(!empty($this->kabupaten_id)){
				if (is_array($this->kabupaten_id)){
					$criteria->addInCondition("kabupaten_id",$this->kabupaten_id);				
				}else{
					$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
				}		
			}
			$criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
			if(!empty($this->kelurahan_id)){
				$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
			}
			$criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
			if(!empty($this->kecamatan_id)){
				$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
			}
			$criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
			}
			
			if(!empty($this->carabayar_id)){
				if (is_array($this->carabayar_id)){
					$criteria->addInCondition("carabayar_id",$this->carabayar_id);				
				}else{
					$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
				}			
			}
			$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
			if(!empty($this->penjamin_id)){
				if (is_array($this->penjamin_id)){
					$criteria->addInCondition("penjamin_id",$this->penjamin_id);				
				}else{
					$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
				}				
			}
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);

        return $criteria;
    }	
}
<?php
class BDPasienKirimKeUnitLainV extends PasienkirimkeunitlainV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienkirimkeunitlainV the static model class
	 */
    
        public $permintaankepenunjang_id,$pemeriksaanlab_id,$pemeriksaanlab_nama,$daftartindakanlab_id,$pemeriksaanrad_id,
               $pemeriksaanrad_nama,$daftartindakanrad_id,$qtypermintaan,$noperminatanpenujang,$tglpermintaankepenunjang,$umur;
        public $tgl_awal,$tgl_akhir, $pegawai_nama, $kadarhb, $plt, $jenis_permintaan;
        public $cbTglMasuk=0;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function searchPasienLAB()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasienkirimkeunitlain_id)){
			$criteria->addCondition('pasienkirimkeunitlain_id = '.$this->pasienkirimkeunitlain_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(tgl_kirimpasien)',strtolower($this->tgl_kirimpasien),true);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		if(!empty($this->gelarbelakang_id)){
			$criteria->addCondition('gelarbelakang_id = '.$this->gelarbelakang_id);
		}
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
		if(!empty($this->ruanganasal_id)){
			$criteria->addCondition('ruanganasal_id = '.$this->ruanganasal_id);
		}
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if(!empty($this->instalasiasal_id)){
			$criteria->addCondition('instalasiasal_id = '.$this->instalasiasal_id);
		}
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->addCondition('ruangan_id = '.Params::RUANGAN_ID_LAB);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		if(!empty($this->permintaankepenunjang_id)){
			$criteria->addCondition('permintaankepenunjang_id = '.$this->permintaankepenunjang_id);
		}
		if(!empty($this->pemeriksaanlab_id)){
			$criteria->addCondition('pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
		}
		$criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
		if(!empty($this->daftartindakanlab_id)){
			$criteria->addCondition('daftartindakanlab_id = '.$this->daftartindakanlab_id);
		}
		if(!empty($this->pemeriksaanrad_id)){
			$criteria->addCondition('pemeriksaanrad_id = '.$this->pemeriksaanrad_id);
		}
		$criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
		if(!empty($this->daftartindakanrad_id)){
			$criteria->addCondition('daftartindakanrad_id = '.$this->daftartindakanrad_id);
		}
		$criteria->compare('qtypermintaan',$this->qtypermintaan);
		$criteria->compare('LOWER(noperminatanpenujang)',strtolower($this->noperminatanpenujang),true);
		$criteria->compare('LOWER(tglpermintaankepenunjang)',strtolower($this->tglpermintaankepenunjang),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPasienRujukan()
	{
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            
            if($this->cbTglMasuk)
            {
                $criteria->addBetweenCondition('DATE(tgl_kirimpasien)',$this->tgl_awal,$this->tgl_akhir);
            }
			if(!empty($this->pasienkirimkeunitlain_id)){
				$criteria->addCondition('pasienkirimkeunitlain_id = '.$this->pasienkirimkeunitlain_id);
			}
            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
            $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
            $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('LOWER(agama)',strtolower($this->agama),true);
            $criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
            $criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
            $criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
			}
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);                
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
			}
            $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
			}
            $criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
			}
            $criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
			}
            $criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->pegawai_id)){
				$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
			}
            $criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
            $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
			if(!empty($this->gelarbelakang_id)){
				$criteria->addCondition('gelarbelakang_id = '.$this->gelarbelakang_id);
			}
            $criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
            $criteria->compare('LOWER(catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
			if(!empty($this->ruanganasal_id)){
				$criteria->addCondition('ruanganasal_id = '.$this->ruanganasal_id);
			}
            $criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
			if(!empty($this->instalasiasal_id)){
				$criteria->addCondition('instalasiasal_id = '.$this->instalasiasal_id);
			}
            $criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
			}
            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
			}
			if(!empty($this->pasienmasukpenunjang_id)){
				$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
			}
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
			if(!empty($this->permintaankepenunjang_id)){
				$criteria->addCondition('permintaankepenunjang_id = '.$this->permintaankepenunjang_id);
			}
			if(!empty($this->pemeriksaanlab_id)){
				$criteria->addCondition('pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
			}
            $criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
			if(!empty($this->daftartindakanlab_id)){
				$criteria->addCondition('daftartindakanlab_id = '.$this->daftartindakanlab_id);
			}
			if(!empty($this->pemeriksaanrad_id)){
				$criteria->addCondition('pemeriksaanrad_id = '.$this->pemeriksaanrad_id);
			}
            $criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
			if(!empty($this->daftartindakanrad_id)){
				$criteria->addCondition('daftartindakanrad_id = '.$this->daftartindakanrad_id);
			}
            $criteria->compare('qtypermintaan',$this->qtypermintaan);
            $criteria->compare('LOWER(noperminatanpenujang)',strtolower($this->noperminatanpenujang),true);
            $criteria->compare('LOWER(tglpermintaankepenunjang)',strtolower($this->tglpermintaankepenunjang),true);
			$criteria->order = 'tgl_kirimpasien DESC';
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
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
//			$this->tgl_kirimpasien = empty($this->tgl_kirimpasien) ? date("Y-m-d") : $format->formatDateTimeForDb($this->tgl_kirimpasien); //filter grid
//			$criteria->addBetweenCondition("DATE(tgl_kirimpasien)",$this->tgl_kirimpasien." 00:00:00",$this->tgl_kirimpasien." 23:59:59");
            $tgl_kirimpasien = $this->getKonverviDateRange($this->tgl_kirimpasien);
            $criteria->addBetweenCondition('DATE(tgl_kirimpasien)', $tgl_kirimpasien[0]." 00:00:00", $tgl_kirimpasien[1]." 23:59:59");
            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
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
            $criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
            $criteria->limit = 5;
//			$this->tgl_kirimpasien = $format->formatDateTimeForUser($this->tgl_kirimpasien);
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>5
                    ),
            ));
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

	public function searchDialogKunjunganBD()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$format = new MyFormatter();
		$this->tgl_kirimpasien = empty($this->tgl_kirimpasien) ? date("Y-m-d") : $format->formatDateTimeForDb($this->tgl_kirimpasien); //filter grid
		$criteria->addBetweenCondition("DATE(tgl_kirimpasien)",$this->tgl_kirimpasien." 00:00:00",$this->tgl_kirimpasien." 23:59:59");
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
		$criteria->compare('LOWER(ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
		if (!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id ='.$this->carabayar_id);
		}
		if (!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id ='.$this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		if (!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
		$criteria->compare('LOWER(nama_pegawai)',($this->nama_pegawai));
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->limit = 5;
		$this->tgl_kirimpasien = $format->formatDateTimeForUser($this->tgl_kirimpasien);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}
}
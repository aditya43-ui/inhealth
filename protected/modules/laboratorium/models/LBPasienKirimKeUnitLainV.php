<?php
class LBPasienKirimKeUnitLainV extends PasienkirimkeunitlainV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienkirimkeunitlainV the static model class
	 */
    
        public $permintaankepenunjang_id,$pemeriksaanlab_id,$pemeriksaanlab_nama,$daftartindakanlab_id,$pemeriksaanrad_id,
               $pemeriksaanrad_nama,$daftartindakanrad_id,$qtypermintaan,$noperminatanpenujang,$tglpermintaankepenunjang,$umur;
        public $tgl_awal,$tgl_akhir;
        public $cbTglMasuk=0;
		public $statusperiksa;
		public $dokterperujuk;
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
            
			if(!empty($this->pasienkirimkeunitlain_id)){
				$criteria->addCondition('t.pasienkirimkeunitlain_id = '.$this->pasienkirimkeunitlain_id);
			}
			if(!empty($this->no_rekam_medik) || !empty($this->nama_pasien)){
				$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
				$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
			}else{
				
				if ($this->isPilihTglRencana == 1){
					if (!empty($this->tgl_rencana_awal) && !empty($this->tgl_rencana_akhir)) {
						$criteria->addBetweenCondition('t.tglrencanapemeriksaan::date', $this->tgl_rencana_awal, $this->tgl_rencana_akhir);
					}
				}else{
					if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
						$criteria->addBetweenCondition('t.tgl_kirimpasien::date', $this->tgl_awal, $this->tgl_akhir);
					}
				}
				
			}
            $criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
            $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
            $criteria->compare('LOWER(t.tempat_lahir)',strtolower($this->tempat_lahir),true);
            $criteria->compare('LOWER(t.tanggal_lahir)',strtolower($this->tanggal_lahir),true);
            $criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
            $criteria->compare('LOWER(t.golongandarah)',strtolower($this->golongandarah),true);
            $criteria->compare('LOWER(t.rhesus)',strtolower($this->rhesus),true);
            $criteria->compare('LOWER(t.nourut)',strtolower($this->nourut),true);
			$criteria->compare('LOWER(t.pasien_id)',strtolower($this->pasien_id),true);
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition('t.pendaftaran_id = '.$this->pendaftaran_id);
			}
            $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->prefix_pendaftaran.$this->no_pendaftaran),true);                
			if(!empty($this->jeniskasuspenyakit_id)){
				$criteria->addCondition('t.jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
			}
            $criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
			if(!empty($this->carabayar_id)){
				$criteria->addCondition('t.carabayar_id = '.$this->carabayar_id);
			}
            $criteria->compare('LOWER(t.carabayar_nama)',strtolower($this->carabayar_nama),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition('t.penjamin_id = '.$this->penjamin_id);
			}
            $criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
			if(!empty($this->kelaspelayanan_id)){
				$criteria->addCondition('t.kelaspelayanan_id = '.$this->kelaspelayanan_id);
			}
            $criteria->compare('LOWER(t.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
			if(!empty($this->pegawai_id)){
				$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
			}
            $criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
            //$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
			if(!empty($this->gelarbelakang_id)){
				$criteria->addCondition('t.gelarbelakang_id = '.$this->gelarbelakang_id);
			}
            $criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
            $criteria->compare('LOWER(t.catatandokterpengirim)',strtolower($this->catatandokterpengirim),true);
			if(!empty($this->ruanganasal_id)){
				$criteria->addCondition('t.ruanganasal_id = '.$this->ruanganasal_id);
			}
            $criteria->compare('LOWER(t.ruanganasal_nama)',strtolower($this->ruanganasal_nama),true);
			if(!empty($this->instalasiasal_id)){
				$criteria->addCondition('t.instalasiasal_id = '.$this->instalasiasal_id);
			}
            $criteria->compare('LOWER(t.instalasiasal_nama)',strtolower($this->instalasiasal_nama),true);
			if(!empty($this->ruangan_id)){
				$criteria->addCondition('t.ruangan_id = '.$this->ruangan_id);
			}
            $criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
			if(!empty($this->instalasi_id)){
				$criteria->addCondition('t.instalasi_id = '.$this->instalasi_id);
			}
			if(!empty($this->pasienmasukpenunjang_id)){
				$criteria->addCondition('t.pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
			}
            $criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
			if(!empty($this->permintaankepenunjang_id)){
				$criteria->addCondition('t.permintaankepenunjang_id = '.$this->permintaankepenunjang_id);
			}
			if(!empty($this->pemeriksaanlab_id)){
				$criteria->addCondition('t.pemeriksaanlab_id = '.$this->pemeriksaanlab_id);
			}
            $criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($this->pemeriksaanlab_nama),true);
			if(!empty($this->daftartindakanlab_id)){
				$criteria->addCondition('t.daftartindakanlab_id = '.$this->daftartindakanlab_id);
			}
			if(!empty($this->pemeriksaanrad_id)){
				$criteria->addCondition('t.pemeriksaanrad_id = '.$this->pemeriksaanrad_id);
			}
            $criteria->compare('LOWER(pemeriksaanrad_nama)',strtolower($this->pemeriksaanrad_nama),true);
			if(!empty($this->daftartindakanrad_id)){
				$criteria->addCondition('t.daftartindakanrad_id = '.$this->daftartindakanrad_id);
			}
            $criteria->compare('t.qtypermintaan',$this->qtypermintaan);
            $criteria->compare('LOWER(t.noperminatanpenujang)',strtolower($this->noperminatanpenujang),true);
            $criteria->compare('LOWER(t.tglpermintaankepenunjang)',strtolower($this->tglpermintaankepenunjang),true);

			if (!empty($this->namaDokter)){
				$criteria->addCondition(" t.nama_pegawai = ".$this->namaDokter." ");
			}
			
            
            $criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
            $criteria->addCondition('p.pasienbatalperiksa_id is null');
			$criteria->select = " t.*,  p.statusperiksa ";
			if (!empty($this->statusperiksa)){
				$criteria->addCondition(" p.statusperiksa ilike '".strtolower($this->statusperiksa)."' ");
			}
			$criteria->order = 'CASE WHEN is_bga = true THEN 0 ELSE 1 END, CASE WHEN is_cyto = true THEN 0 ELSE 1 END, t.tgl_kirimpasien::date DESC';
            
			// echo '<pre>';var_dump($criteria);die;
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
            $criteria->order = 'tgl_pendaftaran DESC';
            $criteria->limit = 10;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
}
<?php

class RKPasienM extends PasienM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return 
	 */
    public $tgl_rekam_medik_akhir;
    public $instalasi_id;
    public $ruangan_id;
    public $tgl_pendaftaran_cari;
    public $no_pendaftaran;
    public $instalasi_nama;
    public $ruangan_nama;
    public $carabayar_nama;
    public $tgl_pendaftaran;
    public $umur;
    public $jeniskasuspenyakit_nama;
    public $pendaftaran_id;
    public $carabayar_id;
    public $penjamin_id;
    public $kelaspelayanan_id;
    public $pasienadmisi_id;
    public $penjamin_nama;
	public $caramasuk_id;
	public $cari_kelurahan_nama, $cari_kecamatan_nama; //filter pencarian
	public $nomorindukpegawai;
    

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);			
		}
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		if (!empty($this->tgl_rekam_medik_akhir)){
            $criteria->addBetweenCondition('date(t.tgl_rekam_medik)', $this->tgl_rekam_medik, $this->tgl_rekam_medik_akhir);
        }
        else{
            $criteria->compare('DATE(t.tgl_rekam_medik)',$this->tgl_rekam_medik);    
        }
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		if(!empty($this->kelompokumur_id)){
			$criteria->addCondition("kelompokumur_id = ".$this->kelompokumur_id);			
		}
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(warga_negara)',strtolower($this->warga_negara),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
		$criteria->addCondition('dokrekammedis_id is NULL AND ispasienluar=FALSE');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchDialogBadak()
	{
		$criteria=$this->criteriaSearch();
		$criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
									 JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id
									 LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
		$criteria->compare('LOWER(kecamatan_m.kecamatan_nama)',  strtolower($this->cari_kecamatan_nama), true);
		$criteria->compare('LOWER(kelurahan_m.kelurahan_nama)',  strtolower($this->cari_kelurahan_nama), true);
		$criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',  strtolower($this->nomorindukpegawai), true);
				if($this->ispasienluar){
					$criteria->addCondition('ispasienluar = TRUE');
				}else{
					$criteria->addCondition('ispasienluar = FALSE');
				}
		$criteria->limit=5;
				return new CActiveDataProvider($this, array(
						'criteria'=>$criteria,
						'pagination'=>false,
				));
	}
    
    /**
     * untuk menampilkan data pada grid dialog pasien
     * @return \CActiveDataProvider
     */
    public function searchDialog() {
        $criteria = $this->criteriaSearch();
        $criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
                            LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
        $criteria->compare('LOWER(kecamatan_m.kecamatan_nama)', strtolower($this->cari_kecamatan_nama), true);
        $criteria->compare('LOWER(kelurahan_m.kelurahan_nama)', strtolower($this->cari_kelurahan_nama), true);
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

	public function searchKunjunganPasienTerakhir() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->join = 'left join (
                                select distinct on (a.pasien_id) a.pasien_id, a.tgl_pendaftaran, a.no_pendaftaran, 
                                    (case when a.pasienadmisi_id is null then a.ruangan_id else ad.ruangan_id end) as ruangan_id 
                                        from pendaftaran_t a left join pasienadmisi_t ad on ad.pasienadmisi_id = a.pasienadmisi_id 
                                        order by a.pasien_id, a.tgl_pendaftaran desc
                                    ) p on p.pasien_id = t.pasien_id 
                            left join ruangan_m r on r.ruangan_id = p.ruangan_id 
                            left join instalasi_m i on i.instalasi_id = r.instalasi_id 
                            join inaktifrekammedisdet_t ird on ird.pasien_id = t.pasien_id and ird.is_pemusnahan = false 
                            join dokrekammedis_m dok on dok.pasien_id = t.pasien_id
                            join satelitrm_m satelit on satelit.satelitrm_id = dok.satelitrm_id
                            join lokasirak_m lokasi on dok.lokasirak_id = lokasi.lokasirak_id
                            join subrak_m subrak on subrak.subrak_id = dok.subrak_id ';

        $criteria->select = "t.*, p.tgl_pendaftaran as tglkunjunganterakhir, 
                            p.no_pendaftaran as no_pendaftaran, 
                            r.instalasi_id, 
                            i.instalasi_nama, 
                            p.ruangan_id, 
                            r.ruangan_nama, 
                            ird.inaktifrekammedisdet_id,
                            satelit.satelitrm_nama,
                            lokasi.lokasirak_nama,
                            subrak.subrak_nama";

        $criteria->compare('r.instalasi_id', $this->instalasi_id);
        $criteria->compare('r.ruangan_id', $this->ruangan_id);

        if (!empty($this->pasien_id)) {
            $criteria->addCondition("t.pasien_id = " . $this->pasien_id);
        }
        if (!empty($this->no_rekam_medik_akhir)) {
            $criteria->addCondition("no_rekam_medik ~ '^[0-9\.]+$'");
            $criteria->addCondition("CAST(t.no_rekam_medik as integer) between " . $this->no_rekam_medik . " and " . $this->no_rekam_medik_akhir);
        } else {
            $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        }
        if (!empty($this->tglkunjungan_akhir)) {
            $criteria->addBetweenCondition('date(p.tgl_pendaftaran)', $this->tglkunjunganterakhir, $this->tglkunjungan_akhir);
        } else {
            $criteria->compare('DATE(p.tgl_pendaftaran)', $this->tglkunjunganterakhir);
        }
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        if (!empty($this->pasien_id)) {
            $criteria->addCondition("pasien_id = " . $this->pasien_id);
        }

        $criteria->order = 't.pasien_id, p.tgl_pendaftaran desc';

//		$criteria->addCondition('dokrekammedis_id is NULL AND ispasienluar=FALSE');
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * menampilkan data pasien, berdaarkan no pendaftaran terakhir sesuai ruanganya masing - masing 
     * @return \CActiveDataProvider
     */
    public function searchPasienPendaftaranAkhir() {
        $criteria = new CDbCriteria();
        $criteria->compare("LOWER(t.nama_pasien)", strtolower($this->nama_pasien), true);
        $criteria->compare("LOWER(t.no_rekam_medik)", strtolower($this->no_rekam_medik), true);
        $criteria->compare("LOWER(t.jeniskelamin)", strtolower($this->jeniskelamin), true);
        $criteria->compare("LOWER(t.instalasi_nama)", strtolower($this->instalasi_nama), true);
        $criteria->compare("LOWER(t.ruangan_nama)", strtolower($this->ruangan_nama), true);
        $criteria->compare("LOWER(t.carabayar_nama)", strtolower($this->carabayar_nama), true);

        if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KLINIK_MCU || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_KLINIK_MCU_GRAHAMERTA) {
            $criteria->addCondition("  penunjang.ruanganasal_id = '" . Yii::app()->user->getState('ruangan_id') . "' ");
            $criteria->select = 'pendaftaran_t.pendaftaran_id, pasienadmisi_t.caramasuk_id, t.pasien_id, pendaftaran_t.pasienadmisi_id, t.nama_pasien,
                                 pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran,jeniskelamin,no_rekam_medik,
                                 carabayar_m.carabayar_id,carabayar_m.carabayar_nama,penjaminpasien_m.penjamin_id,penjaminpasien_m.penjamin_nama,
                                 umur,jeniskasuspenyakit_m.jeniskasuspenyakit_nama,ruangan_m.ruangan_nama, t.namadepan';
            $criteria->join = ' JOIN (
                                    select distinct ON(pasien_id, ruangan_id) * 
                                    FROM pasienmasukpenunjang_t 
                                    ORDER BY pasien_id, ruangan_id, tglmasukpenunjang DESC
                                ) as penunjang ON penunjang.pasien_id = t.pasien_id
                JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = penunjang.pendaftaran_id 
                LEFT JOIN pasienadmisi_t ON pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id
                LEFT JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
                LEFT JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
                LEFT JOIN ruangan_m ON penunjang.ruangan_id = ruangan_m.ruangan_id
                LEFT JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
                LEFT JOIN jeniskasuspenyakit_m ON penunjang.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id';
            $criteria->order = 'tglmasukpenunjang DESC';
        } else {
            $criteria->select = 'pendaftaran_t.pendaftaran_id, pasienadmisi_t.caramasuk_id, t.pasien_id, pendaftaran_t.pasienadmisi_id, t.nama_pasien,
                                 pendaftaran_t.no_pendaftaran, pendaftaran_t.tgl_pendaftaran,jeniskelamin,no_rekam_medik,
                                 carabayar_m.carabayar_id,carabayar_m.carabayar_nama,penjaminpasien_m.penjamin_id,penjaminpasien_m.penjamin_nama,
                                 umur,jeniskasuspenyakit_m.jeniskasuspenyakit_nama,ruangan_m.ruangan_nama, t.namadepan';
            $criteria->join = ' 
                                JOIN pendaftaran_t ON pendaftaran_t.pasien_id = t.pasien_id 
                                LEFT JOIN pasienadmisi_t ON pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id 
                                LEFT JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id 
                                LEFT JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id 
                                LEFT JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id 
                                LEFT JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id 
                                LEFT JOIN jeniskasuspenyakit_m ON pendaftaran_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id';
            $criteria->order = 'tglpendaftaran DESC';
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchDialogRekamMedik() {
        $criteria = $this->criteriaSearch();
        $criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
                            LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
        $criteria->compare('LOWER(kecamatan_m.kecamatan_nama)', strtolower($this->cari_kecamatan_nama), true);
        $criteria->compare('LOWER(kelurahan_m.kelurahan_nama)', strtolower($this->cari_kelurahan_nama), true);
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


}
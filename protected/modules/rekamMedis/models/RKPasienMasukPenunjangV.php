<?php

class RKPasienMasukPenunjangV extends PasienmasukpenunjangV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasiendirujukkeluarT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchLAB()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = "*, hasilpemeriksaanlab_t, pasienbatalperiksa_id, tglbatal, keterangan_batal";
//                $criteria->select = "t.pasien_id, t.jenisidentitas, t.no_identitas_pasien, t.namadepan, t.nama_pasien, t.nama_bin, t.jeniskelamin, t.tempat_lahir, t.tanggal_lahir, t.alamat_pasien, t.rt, t.rw, t.agama, t.golongandarah, t.photopasien, t.alamatemail, t.statusrekammedis, t.statusperkawinan, t.tgl_rekam_medik, propinsi_m.propinsi_id, propinsi_m.propinsi_nama, kabupaten_m.kabupaten_id, kabupaten_m.kabupaten_nama, kelurahan_m.kelurahan_id, kelurahan_m.kelurahan_nama, kecamatan_m.kecamatan_id, kecamatan_m.kecamatan_nama, pendaftaran_t.pendaftaran_id, pekerjaan_m.pekerjaan_id, pekerjaan_m.pekerjaan_nama, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.keadaanmasuk, pendaftaran_t.statuspasien, pendaftaran_t.alihstatus, pendaftaran_t.statusmasuk, pendaftaran_t.umur, pendaftaran_t.no_asuransi, pendaftaran_t.namapemilik_asuransi, pendaftaran_t.nopokokperusahaan, carabayar_m.carabayar_id, carabayar_m.carabayar_nama, penjaminpasien_m.penjamin_id, penjaminpasien_m.penjamin_nama, caramasuk_m.caramasuk_id, caramasuk_m.caramasuk_nama, pendaftaran_t.shift_id, golonganumur_m.golonganumur_id, golonganumur_m.golonganumur_nama, rujukan_t.no_rujukan, rujukan_t.nama_perujuk, rujukan_t.tanggal_rujukan, rujukan_t.diagnosa_rujukan, asalrujukan_m.asalrujukan_id, asalrujukan_m.asalrujukan_nama, penanggungjawab_m.penanggungjawab_id, penanggungjawab_m.pengantar, penanggungjawab_m.hubungankeluarga, penanggungjawab_m.nama_pj, ruanganasal_m.ruangan_id AS ruanganasal_id, ruanganasal_m.ruangan_nama AS ruanganasal_nama, instalasiasal_m.instalasi_id AS instalasiasal_id, instalasiasal_m.instalasi_nama AS instalasiasal_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama, kelaspelayanan_m.kelaspelayanan_id, kelaspelayanan_m.kelaspelayanan_nama, dokterasal_m.gelardepan AS gelardokterasal, dokterasal_m.nama_pegawai AS nama_dokterasal, gelarbelakang_m.gelarbelakang_nama, pasienmasukpenunjang_t.no_masukpenunjang, pasienmasukpenunjang_t.tglmasukpenunjang, pasienmasukpenunjang_t.no_urutperiksa, pasienmasukpenunjang_t.kunjungan, pasienmasukpenunjang_t.statusperiksa, ruangan_m.ruangan_id, ruangan_m.ruangan_nama, pasienmasukpenunjang_t.pasienadmisi_id, pasienmasukpenunjang_t.pasienmasukpenunjang_id, pasienmasukpenunjang_t.create_time, pasienmasukpenunjang_t.create_loginpemakai_id, pasienmasukpenunjang_t.create_ruangan, pegawai_m.gelardepan, pegawai_m.nama_pegawai, pegawai_m.pegawai_id, pengambilansample_t.pengambilansample_id, t.no_rekam_medik, pendaftaran_t.no_pendaftaran, pengambilansample_t.tglpengambilansample, pengambilansample_t.no_pengambilansample, rujukan_t.rujukandari_id, rujukandari_m.namaperujuk, rujukandari_m.alamatlengkap AS alamatlengkapperujuk, rujukandari_m.notelp AS notelpperujuk, hasilpemeriksaanlab_t.hasilpemeriksaanlab_id, hasilpemeriksaanlab_t.statusperiksahasil, hasilpemeriksaanlab_t.printhasillab";
//                $criteria->join = "
//                    JOIN pendaftaran_t ON t.pasien_id = pendaftaran_t.pasien_id
//                    JOIN propinsi_m ON t.propinsi_id = propinsi_m.propinsi_id
//                    JOIN kabupaten_m ON t.kabupaten_id = kabupaten_m.kabupaten_id
//                    LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id
//                    JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
//                    LEFT JOIN pekerjaan_m ON t.pekerjaan_id = pekerjaan_m.pekerjaan_id
//                    JOIN carabayar_m ON pendaftaran_t.carabayar_id = carabayar_m.carabayar_id
//                    JOIN penjaminpasien_m ON pendaftaran_t.penjamin_id = penjaminpasien_m.penjamin_id
//                    LEFT JOIN caramasuk_m ON pendaftaran_t.caramasuk_id = caramasuk_m.caramasuk_id
//                    JOIN golonganumur_m ON pendaftaran_t.golonganumur_id = golonganumur_m.golonganumur_id
//                    LEFT JOIN rujukan_t ON pendaftaran_t.rujukan_id = rujukan_t.rujukan_id
//                    LEFT JOIN asalrujukan_m ON rujukan_t.asalrujukan_id = asalrujukan_m.asalrujukan_id
//                    LEFT JOIN rujukandari_m ON rujukan_t.rujukandari_id = rujukandari_m.rujukandari_id
//                    LEFT JOIN penanggungjawab_m ON pendaftaran_t.penanggungjawab_id = penanggungjawab_m.penanggungjawab_id
//                    LEFT JOIN pegawai_m dokterasal_m ON pendaftaran_t.pegawai_id = dokterasal_m.pegawai_id
//                    JOIN pasienmasukpenunjang_t ON pendaftaran_t.pendaftaran_id = pasienmasukpenunjang_t.pendaftaran_id
//                    JOIN ruangan_m ON pasienmasukpenunjang_t.ruangan_id = ruangan_m.ruangan_id
//                    JOIN jeniskasuspenyakit_m ON pasienmasukpenunjang_t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
//                    JOIN kelaspelayanan_m ON pasienmasukpenunjang_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
//                    JOIN pegawai_m ON pegawai_m.pegawai_id = pasienmasukpenunjang_t.pegawai_id
//                    LEFT JOIN gelarbelakang_m ON pegawai_m.gelarbelakang_id = gelarbelakang_m.gelarbelakang_id
//                    JOIN ruangan_m ruanganasal_m ON ruanganasal_m.ruangan_id = pasienmasukpenunjang_t.ruanganasal_id
//                    JOIN instalasi_m instalasiasal_m ON ruanganasal_m.instalasi_id = instalasiasal_m.instalasi_id
//                    LEFT JOIN pengambilansample_t ON pasienmasukpenunjang_t.pasienmasukpenunjang_id = pengambilansample_t.pasienmasukpenunjang_id
//                    JOIN hasilpemeriksaanlab_t ON hasilpemeriksaanlab_t.pasien_id = t.pasien_id AND hasilpemeriksaanlab_t.pendaftaran_id = pendaftaran_t.pendaftaran_id AND hasilpemeriksaanlab_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
//                ";
                $criteria->join = "
                    JOIN hasilpemeriksaanlab_t ON hasilpemeriksaanlab_t.pasien_id = t.pasien_id AND hasilpemeriksaanlab_t.pendaftaran_id = t.pendaftaran_id AND hasilpemeriksaanlab_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id
                ";
      		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
                $criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
                $criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
                $criteria->compare('LOWER(hasilpemeriksaanlab_t.statusperiksahasil)',strtolower($this->statusperiksahasil),true);
                if(!empty($this->isPasienBatalPeriksa)) //Jika ada filter berdasarkan pasien yg dibatalkan
                    $criteria->addCondition('t.pasienbatalperiksa_id <> '.$this->isPasienBatalPeriksa);
                else
                    $criteria->addCondition('t.pasienbatalperiksa_id is null');
                $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
//                $criteria->compare('LOWER(nama_bin )',strtolower($this->nama),true);
//                $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
                $criteria->addBetweenCondition('tglmasukpenunjang', $this->tgl_awal, $this->tgl_akhir);
//                $criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
                $criteria->order = "t.tglmasukpenunjang DESC"; //tglmasukpenunjang = tgl pendaftaran
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
                
		
	}
        
        public function getNamaLengkapDokter($pegawai_id)
        {
            $dokter = DokterV::model()->findByAttributes(array('pegawai_id'=>$pegawai_id));
            return $dokter->gelardepan." ".$dokter->nama_pegawai.", ".$dokter->gelarbelakang_nama;
        }
        
        public function getNamaPegawai($pegawai_id)
        {
            $dokter = PegawaiM::model()->findByAttributes(
                array('pegawai_id'=>$pegawai_id)
            );
            return $dokter->nama_pegawai;
        }       
}
?>

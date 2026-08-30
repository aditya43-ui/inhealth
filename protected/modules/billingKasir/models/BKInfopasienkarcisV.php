<?php
class BKInfopasienkarcisV extends InfopasienkarcisV
{
        public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopasienkarcisV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchPasienKarcis()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('photopasien',$this->photopasien,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('statusrekammedis',$this->statusrekammedis,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('tgl_rekam_medik',$this->tgl_rekam_medik,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('propinsi_nama',$this->propinsi_nama,true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition('kelurahan_id = '.$this->kelurahan_id);
		}
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition('kecamatan_id = '.$this->kecamatan_id);
		}
		$criteria->compare('kecamatan_nama',$this->kecamatan_nama,true);
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition('pekerjaan_id = '.$this->pekerjaan_id);
		}
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		if(!empty($this->suku_id)){
			$criteria->addCondition('suku_id = '.$this->suku_id);
		}
		$criteria->compare('suku_nama',$this->suku_nama,true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('no_urutantri',$this->no_urutantri,true);
		$criteria->compare('transportasi',$this->transportasi,true);
		$criteria->compare('keadaanmasuk',$this->keadaanmasuk,true);
		$criteria->compare('statusperiksa',$this->statusperiksa,true);
		$criteria->compare('statuspasien',$this->statuspasien,true);
		$criteria->compare('kunjungan',$this->kunjungan,true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('statusmasuk',$this->statusmasuk,true);
		$criteria->compare('umur',$this->umur,true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition('tindakanpelayanan_id = '.$this->tindakanpelayanan_id);
		}
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		$criteria->compare('shift_nama',$this->shift_nama,true);
		if(!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id = '.$this->tipepaket_id);
		}
		$criteria->compare('tipepaket_nama',$this->tipepaket_nama,true);
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition('daftartindakan_id = '.$this->daftartindakan_id);
		}
		$criteria->compare('daftartindakan_kode',$this->daftartindakan_kode,true);
		$criteria->compare('daftartindakan_nama',$this->daftartindakan_nama,true);
		if(!empty($this->karcis_id)){
			$criteria->addCondition('karcis_id = '.$this->karcis_id);
		}
		$criteria->compare('karcis_nama',$this->karcis_nama,true);
		if(!empty($this->pasienmasukpenunjang_id)){
			$criteria->addCondition('pasienmasukpenunjang_id = '.$this->pasienmasukpenunjang_id);
		}
		$criteria->compare('no_masukpenunjang',$this->no_masukpenunjang,true);
		$criteria->compare('tglmasukpenunjang',$this->tglmasukpenunjang,true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		$criteria->compare('tgladmisi',$this->tgladmisi,true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition('caramasuk_id = '.$this->caramasuk_id);
		}
		$criteria->compare('caramasuk_nama',$this->caramasuk_nama,true);
		$criteria->compare('tgl_tindakan',$this->tgl_tindakan,true);
		$criteria->compare('tarif_rsakomodasi',$this->tarif_rsakomodasi);
		$criteria->compare('tarif_medis',$this->tarif_medis);
		$criteria->compare('tarif_paramedis',$this->tarif_paramedis);
		$criteria->compare('tarif_bhp',$this->tarif_bhp);
		$criteria->compare('tarif_satuan',$this->tarif_satuan);
		$criteria->compare('tarif_tindakan',$this->tarif_tindakan);
		$criteria->compare('satuantindakan',$this->satuantindakan,true);
		$criteria->compare('qty_tindakan',$this->qty_tindakan);
		$criteria->compare('cyto_tindakan',$this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan',$this->tarifcyto_tindakan);
		if(!empty($this->kelastanggungan_id)){
			$criteria->addCondition('kelastanggungan_id = '.$this->kelastanggungan_id);
		}
		$criteria->compare('kelastanggungan_nama',$this->kelastanggungan_nama,true);
		$criteria->compare('pembebasan_tindakan',$this->pembebasan_tindakan);
		$criteria->compare('subsidiasuransi_tindakan',$this->subsidiasuransi_tindakan);
		$criteria->compare('subsidipemerintah_tindakan',$this->subsidipemerintah_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan',$this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan',$this->iurbiaya_tindakan);
		$criteria->compare('tm',$this->tm,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		if(!empty($this->verifikasitagihan_id)){
			$criteria->addCondition('verifikasitagihan_id = '.$this->verifikasitagihan_id);
		}
		if(!empty($this->jurnalrekening_id)){
			$criteria->addCondition('jurnalrekening_id = '.$this->jurnalrekening_id);
		}
		$criteria->compare('keterangantindakan',$this->keterangantindakan,true);
		if(!empty($this->tindakansudahbayar_id)){
			$criteria->addCondition('tindakansudahbayar_id = '.$this->tindakansudahbayar_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
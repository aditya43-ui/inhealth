<?php
class PJInformasiambiljenazahV extends InformasiambiljenazahV
{
	public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiambiljenazahV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tglpengambilan)', $this->tgl_awal, $this->tgl_akhir,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasimeninggal_id',$this->instalasimeninggal_id);
		$criteria->compare('instalasimeninggal_nama',$this->instalasimeninggal_nama,true);
		$criteria->compare('ruanganmeninggal_id',$this->ruanganmeninggal_id);
		$criteria->compare('ruanganmeninggal_nama',$this->ruanganmeninggal_nama,true);
		$criteria->compare('ambiljenazah_id',$this->ambiljenazah_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kecamatan_nama',$this->kecamatan_nama,true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('propinsi_nama',$this->propinsi_nama,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('no_telepon_pasien',$this->no_telepon_pasien,true);
		$criteria->compare('no_mobile_pasien',$this->no_mobile_pasien,true);
		$criteria->compare('warga_negara',$this->warga_negara,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('tglmeninggal',$this->tglmeninggal,true);
		$criteria->compare('LOWER(nama_pengambiljenazah)',strtolower($this->nama_pengambiljenazah),true);
		$criteria->compare('hubungan_pengjenazah',$this->hubungan_pengjenazah,true);
		$criteria->compare('noidentitas_pengjenazah',$this->noidentitas_pengjenazah,true);
		$criteria->compare('alamat_pengjenazah',$this->alamat_pengjenazah,true);
		$criteria->compare('notelepon_pengjenazah',$this->notelepon_pengjenazah,true);
		$criteria->compare('keterangan_pengambilan',$this->keterangan_pengambilan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
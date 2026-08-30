<?php

class PJPemakaianambulansT extends PemakaianambulansT
{
    public $supir_nama;
    public $pelaksana_nama;
    public $paramedis1_nama;
    public $paramedis2_nama;
    public $mobilambulans_nama;
    public $ruangan_nama;
    public $daftartindakanId;
    public $rt,$rw, $pelayanan_ambulan, $isPendamping, $isDokter;
    public $jenispelayanan_ambulans_id;
//    public $instalasi_id, $instalasi_nama, $no_pendaftaran, $tgl_pendaftaran, $tglselesaiperiksa, $kelaspelayanan_id, $kelaspelayanan_nama, $jeniskasuspenyakit_id, $jeniskasuspenyakit_nama;
//    public $carabayar_id, $carabayar_nama, $penjamin_id, $penjamin_nama, $alamat_pasien, $no_rekam_medik, $namadepan, $nama_pasien, $nama_bin, $tanggal_lahir, $umur, $jeniskelamin;
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
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
                
                $criteria->with = array('supir','paramedis1','ruanganpemesan','mobil');
		$criteria->addBetweenCondition('tglpemakaianambulans', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(mobil.nopolisi)',strtolower($this->nopolisi),true);
		$criteria->compare('LOWER(ruanganpemesan.ruangan_nama)',$this->ruangan_nama,true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(norekammedis)',strtolower($this->norekammedis),true);
		$criteria->compare('LOWER(namapasien)',strtolower($this->namapasien),true);
		$criteria->compare('LOWER(tempattujuan)',strtolower($this->tempattujuan),true);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('LOWER(alamattujuan)',strtolower($this->alamattujuan),true);
		$criteria->compare('LOWER(rt_rw)',strtolower($this->rt_rw),true);
		$criteria->compare('LOWER(nomobile)',strtolower($this->nomobile),true);
		$criteria->compare('LOWER(notelepon)',strtolower($this->notelepon),true);
		$criteria->compare('LOWER(namapj)',strtolower($this->namapj),true);
		$criteria->compare('LOWER(hubunganpj)',strtolower($this->hubunganpj),true);
		$criteria->compare('LOWER(alamatpj)',strtolower($this->alamatpj),true);
		$criteria->compare('kmawal',$this->kmawal);
		$criteria->compare('kmakhir',$this->kmakhir);
		$criteria->compare('jmlbbmliter',$this->jmlbbmliter);
		$criteria->compare('jumlahkm',$this->jumlahkm);
		$criteria->compare('tarifperkm',$this->tarifperkm);
		$criteria->compare('totaltarifambulans',$this->totaltarifambulans);
		$criteria->compare('LOWER(tglkembaliambulans)',strtolower($this->tglkembaliambulans),true);
		$criteria->compare('LOWER(untukkeperluan)',strtolower($this->untukkeperluan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
?>

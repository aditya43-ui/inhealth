<?php
class RKInformasipeminjamanrmV extends InformasipeminjamanrmV
{
	public $tgl_awal;
	public $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipeminjamanrmV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(t.tglpeminjamanrm)', $this->tgl_awal, $this->tgl_akhir,true);
		$criteria->compare('peminjamanrm_id',$this->peminjamanrm_id);
		$criteria->compare('dokrekammedis_id',$this->dokrekammedis_id);
		$criteria->compare('LOWER(nodokumenrm)',strtolower($this->nodokumenrm),true);
		$criteria->compare('warnadokrm_id',$this->warnadokrm_id);
		$criteria->compare('LOWER(warnadokrm_namawarna)',strtolower($this->warnadokrm_namawarna),true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
	//	$criteria->compare('ruangan_id',$this->ruangan_id);
	//	$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
	//	$criteria->compare('instalasi_id',$this->instalasi_id);
	//	$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if (!empty($this->instalasi_id)){
			$criteria->addInCondition("instalasi_id", $this->instalasi_id);
		}
		
		if (!empty($this->ruangan_id)){
			$criteria->addInCondition("ruangan_id", $this->ruangan_id);
		}
		$criteria->compare('LOWER(nourut_pinjam)',strtolower($this->nourut_pinjam),true);		
		$criteria->compare('LOWER(untukkepentingan)',strtolower($this->untukkepentingan),true);
		$criteria->compare('LOWER(keteranganpeminjaman)',strtolower($this->keteranganpeminjaman),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php
class AMPasienM extends PasienM
{
    public $propinsiNama,$kabupatenNama,$kecamatanNama,$kelurahanNama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchPasien()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        
		$criteria=new CDbCriteria;

        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->addCondition("ispasienluar = true");    

        $criteria->order = 'pasien_id DESC';
		// $criteria->limit=5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			// 'pagination'=>false
		));
	}
    
    /**
     * searchPasienApotek menampilkan pasien
     * @return \CActiveDataProvider
     */
    public function searchPasienAmbulan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->pasien_id)) {
            $criteria->addCondition("pasien_id = " . $this->pasien_id);
        }
        if (!empty($this->pekerjaan_id)) {
            $criteria->addCondition("pekerjaan_id = " . $this->pekerjaan_id);
        }
        if (!empty($this->pendidikan_id)) {
            $criteria->addCondition("pendidikan_id = " . $this->pendidikan_id);
        }
        if (!empty($this->propinsi_id)) {
            $criteria->addCondition("t.propinsi_id = " . $this->propinsi_id);
        }
        if (!empty($this->kabupaten_id)) {
            $criteria->addCondition("t.kabupaten_id = " . $this->kabupaten_id);
        }
        if (!empty($this->kecamatan_id)) {
            $criteria->addCondition("t.kecamatan_id = " . $this->kecamatan_id);
        }
        if (!empty($this->kelurahan_id)) {
            $criteria->addCondition("t.kelurahan_id = " . $this->kelurahan_id);
        }
        $criteria->compare('LOWER(propinsi.propinsi_nama)', strtolower($this->propinsiNama), true);
        $criteria->compare('LOWER(kabupaten.kabupaten_nama)', strtolower($this->kabupatenNama), true);
        $criteria->compare('LOWER(kecamatan.kecamatan_nama)', strtolower($this->kecamatanNama), true);
        $criteria->compare('LOWER(kelurahan.kelurahan_nama)', strtolower($this->kelurahanNama), true);
        if (!empty($this->suku_id)) {
            $criteria->addCondition("suku_id = " . $this->suku_id);
        }
        if (!empty($this->profilrs_id)) {
            $criteria->addCondition("profilrs_id = " . $this->profilrs_id);
        }
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        if (!empty($this->kelompokumur_id)) {
            $criteria->addCondition("kelompokumur_id = " . $this->kelompokumur_id);
        }
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('anakke', $this->anakke);
        $criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
        $criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
        $criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
        $criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower(Params::STATUSREKAMMEDIS_AKTIF), true);
        $criteria->compare('LOWER(tgl_meninggal)', strtolower($this->tgl_meninggal), true);
        $criteria->compare('t.ispasienluar', $this->ispasienluar);
        //Jika di filter berdasarkan No. Lab dan Rad
        if (isset($this->create_ruangan)) {
            $criteria->compare('create_ruangan', $this->create_ruangan);
        }

        $criteria->with = array('propinsi', 'kabupaten', 'kecamatan', 'kelurahan');
        $criteria->order = 'pasien_id DESC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    
}
?>

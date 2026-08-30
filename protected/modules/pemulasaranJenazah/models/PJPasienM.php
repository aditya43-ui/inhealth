<?php
class PJPasienM extends PasienM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public $umur;
    public $propinsi_nama,$kabupaten_nama,$kecamatan_nama,$kelurahan_nama;
    public $cari_kelurahan_nama, $cari_kecamatan_nama;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
     /**
      * 
      * @param type $cek mixed array
      * @return CActiveDataProvider 
      */
     public function searchPasien(){
         
            $criteria=new CDbCriteria;
//            $criteria->addBetweenCondition('tgl_rekam_medik', $this->tgl_rm_awal, $this->tgl_rm_akhir);
            $criteria->addCondition('tgl_rekam_medik BETWEEN \''.$this->tgl_rm_awal.'\' AND \''.$this->tgl_rm_akhir.'\'');
            $criteria->compare('TRIM(no_rekam_medik)', trim($this->no_rekam_medik),true);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
            $criteria->compare('t.propinsi_id',$this->propinsi_id);
            $criteria->compare('t.kabupaten_id',$this->kabupaten_id);
            $criteria->compare('t.kecamatan_id',$this->kecamatan_id);
            $criteria->compare('t.kelurahan_id',$this->kelurahan_id);
            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
            $criteria->compare('rt',$this->rt);
            $criteria->compare('rw',$this->rw);
            $criteria->with = array('propinsi','kabupaten','kecamatan','kelurahan');
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }
        
    /**
     * mengambil daftar semua propinsi
     */
    public function getPropinsiItems()
    {
        return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
    }
    
    /**
     * Mengambil daftar semua kabupaten berdasarkan propinsi
     * @return CActiveDataProvider 
     */
    public function getKabupatenItems($propinsi_id=null)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('propinsi_id', $propinsi_id);
        $criteria->compare('kabupaten_aktif', true);
        $criteria->order='kabupaten_nama';
        $models = KabupatenM::model()->findAll($criteria);
        return $models;
    }
    /**
     * Mengambil daftar semua kecamatan berdasarkan kabupaten
     * @return CActiveDataProvider 
     */
    public function getKecamatanItems($kabupaten_id=null)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('kabupaten_id', $kabupaten_id);
        $criteria->compare('kecamatan_aktif', true);
        $criteria->order='kecamatan_nama';
        $models = KecamatanM::model()->findAll($criteria);
        return $models;
    }
    /**
     * Mengambil daftar semua kelurahan berdasarkan kecamatan
     * @return CActiveDataProvider 
     */
    public function getKelurahanItems($kecamatan_id=null)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('kecamatan_id', $kecamatan_id);
        $criteria->compare('kelurahan_aktif', true);
        $criteria->order='kelurahan_nama';
        $models = KelurahanM::model()->findAll($criteria);
        return $models;
    }
    
    /**
     * Mengambil semua daftar pekerjaan
     */
    public function getPekerjaanItems()
    {
        return PekerjaanM::model()->findAll('pekerjaan_aktif=TRUE ORDER BY pekerjaan_nama');
    }
        
    /**
     * Mengambil semua daftar pendidikan
     */
    public function getPendidikanItems()
    {
       return PendidikanM::model()->findAll('pendidikan_aktif=TRUE ORDER BY pendidikan_nama');
    }
    
    /**
     * Mengambil semua daftar suku
     */
    public function getSukuItems()
    {
        return SukuM::model()->findAll('suku_aktif=TRUE ORDER BY suku_nama');
    }
    
    /**
     * untuk dialog
     */
     public function searchDialog()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('pasien_id',$this->pasien_id);
        $criteria->compare('pekerjaan_id',$this->pekerjaan_id);
        $criteria->compare('pendidikan_id',$this->pendidikan_id);
        $criteria->compare('t.propinsi_id',$this->propinsi_id);
        $criteria->compare('t.kabupaten_id',$this->kabupaten_id);
        $criteria->compare('t.kecamatan_id',$this->kecamatan_id);
        $criteria->compare('t.kelurahan_id',$this->kelurahan_id);
        $criteria->compare('LOWER(propinsi.propinsi_nama)',strtolower($this->propinsi_nama),true);
        $criteria->compare('LOWER(kabupaten.kabupaten_nama)',strtolower($this->kabupaten_nama),true);
        $criteria->compare('LOWER(kecamatan.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
        $criteria->compare('LOWER(kelurahan.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
        $criteria->compare('suku_id',$this->suku_id);
        $criteria->compare('profilrs_id',$this->profilrs_id);
        $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
        $criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
        $criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
        $criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
        $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
        $criteria->compare('kelompokumur_id',$this->kelompokumur_id);
        $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
        $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
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
        $criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		if(!empty($this->statusrekammedis)){
			$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		}else{
			$criteria->compare('LOWER(statusrekammedis)',strtolower(Params::STATUSREKAMMEDIS_AKTIF),true);
		}
        
        $criteria->compare('LOWER(norm_lama)',strtolower($this->norm_lama),true);
        $criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
        $criteria->compare('t.ispasienluar',1);
        //Jika di filter berdasarkan No. Lab dan Rad
        $criteria->addCondition('create_ruangan IN ('.Params::RUANGAN_ID_RAD.','.Params::RUANGAN_ID_LAB.')');
        $criteria->with = array('propinsi','kabupaten','kecamatan','kelurahan');
        $criteria->limit = 5;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>false,
        ));
    }
        
        
}
?>

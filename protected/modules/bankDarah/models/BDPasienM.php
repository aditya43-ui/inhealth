<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class BDPasienM extends PasienM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public $umur, $tgl_rm_awal, $tgl_rm_akhir;
    //===  SUDAH TIDAK DIGUNAKAN ?
    public $propinsiNama;
    public $kabupatenNama;
    public $kecamatanNama;
    public $kelurahanNama;
    //===
    public $no_pendaftaran;
    public $tgl_pendaftaran;
    public $jeniskasuspenyakit_nama;
    public $noRekamMedik;
    public $cari_kelurahan_nama, $cari_kecamatan_nama; //filter pencarian

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    public function searchRiwayatPemeriksaan()
    {
        $criteria=new CDbCriteria;

        $criteria->select = 't.pasien_id, t.no_rekam_medik, t.tgl_rekam_medik, t.namadepan, t.nama_pasien, t.nama_bin, t.tanggal_lahir, t.alamat_pasien';
        $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->addCondition('t.pasien_id is NOT NULL');
        
//        $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tgl_rm_awal, $this->tgl_rm_akhir);
        $criteria->join = 'RIGHT JOIN hasilpemeriksaanlab_t ON hasilpemeriksaanlab_t.pasien_id = t.pasien_id RIGHT JOIN pasienkirimkeunitlain_t ON pasienkirimkeunitlain_t.pasien_id=hasilpemeriksaanlab_t.pasien_id';
        $criteria->group = 't.pasien_id, t.no_rekam_medik, t.tgl_rekam_medik, t.namadepan, t.nama_pasien, t.nama_bin, t.tanggal_lahir, t.alamat_pasien';
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

        
    /**
     * untuk menampilkan data pada grid dialog pasien
     * @return \CActiveDataProvider
     */
    public function searchDialog()
    {
            $criteria=$this->criteriaSearch();
            $criteria->join = " LEFT JOIN kecamatan_m ON t.kecamatan_id = kecamatan_m.kecamatan_id
                            LEFT JOIN kelurahan_m ON t.kelurahan_id = kelurahan_m.kelurahan_id ";
            $criteria->compare('LOWER(kecamatan_m.kecamatan_nama)',  strtolower($this->cari_kecamatan_nama), true);
            $criteria->compare('LOWER(kelurahan_m.kelurahan_nama)',  strtolower($this->cari_kelurahan_nama), true);
            $criteria->limit=5;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }




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
    
    public function getPekerjaanItems()
    {
        return PekerjaanM::model()->findAll('pekerjaan_aktif=TRUE ORDER BY pekerjaan_nama');
    }
        
    public function getPendidikanItems()
    {
       return PendidikanM::model()->findAll('pendidikan_aktif=TRUE ORDER BY pendidikan_nama');
    }
    
    public function getSukuItems()
    {
        return SukuM::model()->findAll('suku_aktif=TRUE ORDER BY suku_nama');
    }

}
?>


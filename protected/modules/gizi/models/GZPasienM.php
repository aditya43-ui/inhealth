<?php

class GZPasienM extends PasienM {

    public $cari_kecamatan_nama,$cari_kelurahan_nama;
    public static function model($className = __CLASS__) {
        return parent::model($className);
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
			$criteria->addCondition("create_ruangan = ".Yii::app()->user->getState('ruangan_id'));
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

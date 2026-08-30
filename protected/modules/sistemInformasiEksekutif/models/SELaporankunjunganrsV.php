<?php

/**
 * Model extend dari laporankunjunganrs_v hanya untuk di module Sistem Informasi Eksekutif
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.sistemInformasiEksekutif
 * @subpackage models
 * @category model
 */
class SELaporankunjunganrsV extends LaporankunjunganrsV{
    public $jns_periode;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporankunjunganrsV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * criteria pencarian
     * @return \CDbCriteria
     */
    protected function searchCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->pasien_id)){
            $criteria->addCondition("pasien_id = ".$this->pasien_id);			
        }
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
        if(!empty($this->pendaftaran_id)){
            $criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);			
        }
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
        if(!empty($this->shift_id)){
            $criteria->addCondition("shift_id = ".$this->shift_id);			
        }
        if(!empty($this->ruangan_id)){
            $criteria->addCondition("ruangan_id = ".$this->ruangan_id);			
        }
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        if(!empty($this->instalasi_id)){
            $criteria->addCondition("instalasi_id = ".$this->instalasi_id);			
        }
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        if(!empty($this->jeniskasuspenyakit_id)){
            $criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);			
        }
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        if(!empty($this->kelaspelayanan_id)){
            $criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);			
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        if(!empty($this->rujukan_id)){
            $criteria->addCondition("rujukan_id = ".$this->rujukan_id);			
        }
        if(!empty($this->pasienpulang_id)){
            $criteria->addCondition("pasienpulang_id = ".$this->pasienpulang_id);			
        }
        if(!empty($this->profilrs_id)){
            $criteria->addCondition("profilrs_id = ".$this->profilrs_id);			
        }

        return $criteria;
    }
    
    /**
     * untuk grafik garis:
     * @return CActiveDataProvider : tgl_pendaftaran, jumlah
     */
    public function searchGrafikGaris() {
        $criteria = $this->searchCriteria();
        $tgl_awal = date("Y-m-d",strtotime($this->tgl_awal));
        $tgl_akhir = date("Y-m-d",strtotime($this->tgl_akhir));
        $jmlhari = floor(abs(strtotime($this->tgl_awal)-strtotime($this->tgl_akhir))/(60*60*24));
        if($jmlhari > 30){
            $criteria->select = 'count(pendaftaran_id) as jumlah, EXTRACT(MONTH FROM tgl_pendaftaran::timestamp) as data, EXTRACT(YEAR FROM tgl_pendaftaran::timestamp) as data_2';
            $criteria->group = 'data_2,data';
        }else{
            $criteria->select = 'count(pendaftaran_id) as jumlah, date(tgl_pendaftaran) as data';
            $criteria->group = 'data';
        }
        $criteria->order = $criteria->group;
        $criteria->limit = -1;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * untuk grafik batang dan pie instalasi (kunjungan instalasi):
     * @return CActiveDataProvider : instalasi_nama, jumlah
     */
    public function searchGrafikBatangPieInstalasi() {
        $criteria = $this->searchCriteria();
        $criteria->select = 'count(pendaftaran_id) as jumlah, instalasi_nama as data';
        $criteria->group = 'instalasi_nama';
        $criteria->order = $criteria->group;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * untuk grafik batang dan pie  (kunjungan rumah sakit):
     * @return CActiveDataProvider : statuspasien, jumlah
     */
    public function searchGrafikBatangPieRumahSakit() {
        $criteria = $this->searchCriteria();
        $criteria->select = 'count(pendaftaran_id) as jumlah, statuspasien as data';
        $criteria->group = 'statuspasien';
        $criteria->order = $criteria->group;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * untuk speedo meter
     * @return CActiveDataProvider : persen
     */
    public function searchSpeedo() {
        $criteria = $this->searchCriteria();
        $criteria->select = 'count(pendaftaran_id) as data';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
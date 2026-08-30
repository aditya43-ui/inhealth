<?php

class GZPasienMasukPenunjangT extends PasienmasukpenunjangT {

    public $is_adakarcis = 0;
    public $namadepan,$nama_bin,$no_pendaftaran,$statusBayar,$tgl_pendaftaran,$jeniskelamin,$carabayar_nama,$caramasuk_nama,$umur;
    public $nama_pegawai,$kelaspelayanan_nama,$jeniskasuspenyakit_nama,$Totaltagihan;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getTotaltagihan(){
        $criteria = new CDbCriteria();
        $namaInstalasi = 'GIZI';
        $criteria->select = 'sum(tarif_tindakan) as tarif_tindakan';
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('instalasi_nama',$namaInstalasi);
        
        $jumlah = RinciantagihanpasienV::model()->find($criteria)->tarif_tindakan;
        if (empty($jumlah)){
            $jumlah = 0;
        }
        return $jumlah;
        
    }
    public function searchRincianTagihan(){
        $criteria = new CDbCriteria();

        $criteria->with = array('pendaftaran','pasien');
        $criteria->addBetweenCondition('date(pendaftaran.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(pasien.namadepan)',strtolower($this->namadepan),true);
        $criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(pasien.nama_bin)',strtolower($this->nama_bin),true);
        $criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->order='pendaftaran.tgl_pendaftaran DESC';
        if ($this->statusBayar == 'LUNAS'){
            $criteria->addCondition('pendaftaran.pembayaranpelayanan_id is not null');
        }else if ($this->statusBayar == 'BELUM LUNAS'){
            $criteria->addCondition('pendaftaran.pembayaranpelayanan_id is null');
        }

        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    public function getNoRmNoPend()
    {
            return $this->no_rekam_medik.' / '.$this->no_pendaftaran;
    }

    function getNamaPasienNamaBin()
    {
        return $this->nama_pasien.' bin '.$this->nama_bin;
    }
        
    
}

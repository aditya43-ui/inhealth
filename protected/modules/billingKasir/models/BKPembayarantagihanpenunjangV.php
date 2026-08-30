<?php

class BKPembayarantagihanpenunjangV extends PembayarantagihanpenunjangV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TindakankomponenT the static model class
     */
    public $totaltagihan;
    public $is_sudahbayar;
    public $statusperiksa;
    public $instalasipenunjang_id;
    public $is_alkes;
    public $komponenunit_id;
    public $kelaspelayanan_id, $carabayar_id, $tanggal_lahir, $nama_pegawai, $penjamin_id;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function searchCriteria()
    {

        $criteria = new CDbCriteria();

        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(t.namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(t.instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(t.totaltagihan)', strtolower($this->totaltagihan), true);
        $criteria->compare('t.instalasi_id', $this->instalasi_id);
        $criteria->compare('t.statusperiksa', $this->statusperiksa);
        $criteria->compare('t.carabayar_nama', $this->carabayar_nama);

        return $criteria;
    }

    public function searchRincianTagihan()
    {
        $criteria = $this->searchCriteria();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}

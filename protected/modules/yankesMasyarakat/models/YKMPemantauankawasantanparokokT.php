<?php
/**
 * Model untuk PemantauankawasantanparokokT di modul pelayanan kesehatan masyarakat
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models
 * @category model
 */
class YKMPemantauankawasantanparokokT extends PemantauankawasantanparokokT{
    public $unitkerja_pemantauan_nama, $pelapor_nama, $mengetahui_pegawai_nama,
           $pegawai_mengetahui1_nama, $pegawai_mengetahui2_nama, $NamaLengkap, $namaunitkerja;
    public $mengetahuipegawai_nama, $unitkerja_kejadian_nama, $unitkeja_kejadian_nama;
    public $tanggal_awal, $tanggal_awal2, $tanggal_akhir, $tanggal_akhir2;
    public $tipeLapor, $tipeInsiden, $status_verifikasi;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InsidenrsSelainpasienT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    /**
     * Load data informasi
     * @return \CActiveDataProvider
     */
    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        if ($this->tipeLapor == true) {
                $criteria->addBetweenCondition('DATE(t.tgl_pelaporan)', $this->tanggal_awal, $this->tanggal_akhir);
        }
        if ($this->tipeInsiden == true) {
            $criteria->addBetweenCondition('DATE(t.tgl_inspeksi)', $this->tanggal_awal2, $this->tanggal_akhir2);
        }
        if (!empty($this->status_verifikasi == 'Belum')){
            $criteria->addCondition("t.tg_verifikasi IS NULL");
        }else if (!empty($this->status_verifikasi == 'Sudah')){
            $criteria->addCondition("t.tg_verifikasi IS NOT NULL");
        }
        $criteria->join = "left join pegawai_m on pegawai_m.pegawai_id = t.pelapor_id";
        $criteria->select = "t.*, pegawai_m.nama_pegawai";
        $criteria->compare('lower(pegawai_m.nama_pegawai)', strtolower($this->pelapor_nama), true);
        $criteria->order = "tgl_pelaporan DESC";
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}

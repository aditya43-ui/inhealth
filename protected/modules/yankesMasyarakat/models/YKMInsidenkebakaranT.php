<?php
/**
 * Model untuk InsidenkebakaranT di modul pelayanan kesehatan masyarakat
 * @author   Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models
 * @category model
 */
class YKMInsidenkebakaranT extends InsidenkebakaranT{
    public $pelapor_nama, $mengetahuipegawai_nama, $unitkerja_kejadian_nama, $unitkeja_kejadian_nama;
    public $tanggal_awal, $tanggal_awal2, $tanggal_akhir, $tanggal_akhir2;
    public $tipeLapor, $tipeInsiden, $status_verifikasi;
    public $unitkerja_pelapor_nama, $pegawai_mengetahuikejadian_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InsidenkebakaranT the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    /**
     * Search Informasi
     * @return \CActiveDataProvider
     */
    public function searchInformasi(){
        $criteria = $this->criteriaSearch();
        if ($this->tipeLapor == true) {
                $criteria->addBetweenCondition('DATE(t.tgl_pelaporan)', $this->tanggal_awal, $this->tanggal_akhir);
        }
        if ($this->tipeInsiden == true) {
            $criteria->addBetweenCondition('DATE(t.tgl_kejadian)', $this->tanggal_awal2, $this->tanggal_akhir2);
        }
        if (!empty($this->status_verifikasi == 'Belum')){
            $criteria->addCondition("t.tglverifikasi_pelaporan IS NULL");
        }else if (!empty($this->status_verifikasi == 'Sudah')){
            $criteria->addCondition("t.tglverifikasi_pelaporan IS NOT NULL");
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


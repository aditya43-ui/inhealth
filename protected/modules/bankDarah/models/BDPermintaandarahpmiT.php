<?php

/**
 * Class model tabel "permintaandarahpmi_t" pada module Bank Darah
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDPermintaandarahpmiT extends PermintaandarahpmiT {

    public $tgl_awal, $tgl_akhir, $nama_pegawai;
    public $status;
           
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PermintaandarahpmiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * Load data Informasi Permintaan Darah PMI
     * @return \CActiveDataProvider
     */
    public function searchInformasi(){
        $criteria = new CDbCriteria;
        $criteria->addCondition('isbatal = false'); 
        $criteria->join = 'LEFT JOIN pegawai_m p ON t.petugas_id = p.pegawai_id ';
        $criteria->select = 't.*, p.nama_pegawai';
        $criteria->order = 't.penerimaandarahpmi_id DESC ';
        
        if($this->status == 'Sudah'){
            $criteria->addCondition('t.penerimaandarahpmi_id IS NOT NULL');
        }else if ($this->status == 'Belum'){
            $criteria->addCondition('t.penerimaandarahpmi_id IS NULL');
        }
        
        if (!empty($this->permintaandarahpmi_id)) {
            $criteria->addCondition('permintaandarahpmi_id = ' . $this->permintaandarahpmi_id);
        }
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        if (!empty($this->petugas_id)) {
            $criteria->addCondition('petugas_id = ' . $this->petugas_id);
        }
        
        $criteria->addBetweenCondition('DATE(tgl_permintaan)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(no_permintaan)', strtolower($this->no_permintaan), true);
        $criteria->compare('LOWER(p.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(keterangan_permintaan)', strtolower($this->keterangan_permintaan), true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /*    
     * Pencarian permintaan darah dari PMI yang belum dilakukan transaksi
     * penerimaan.
     * 
     * @return \CActiveDataProvider
     */
    public function searchDialogUntukPenerimaan() {
        $criteria = new CDbCriteria();
        $criteria->join = 'left join pegawai_m p on p.pegawai_id = t.petugas_id '
            . 'left join penerimaandarahpmi_t m on m.permintaandarahpmi_id = t.permintaandarahpmi_id';
        $criteria->compare('lower(t.no_permintaan)', strtolower($this->no_permintaan), true);
        $criteria->compare('lower(p.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->addCondition('t.penerimaandarahpmi_id is null and t.isbatal = false');
        $criteria->order = 't.tgl_permintaan';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}

<?php

/**
 * This is the model class for table "penialian_kelayakan_spesimen_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage models
 * @category model
 */
class MKPenialianKelayakanSpesimenT extends PenialianKelayakanSpesimenT {

    public $tgl_awal, $kelaspelayanan_id, $tgl_akhir, $no_rekam_medik, $prefix_pendaftaran, $no_pendaftaran, $nama_pasien, 
           $instalasiasal_id, $ruanganasal_id, $carabayar_id, $penjamin_id, $tgl_pendaftaran, 
           $tglmasukpenunjang, $no_masukpenunjang, $nama_dokterasal, $ruanganasal_nama, $namadepan, $jeniskelamin,
           $umur, $alamat_pasien, $carabayar_nama, $penjamin_nama, $statusperiksa; 
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PenialianKelayakanSpesimenT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * Load data informasi daftar oasien
     * @return \CActiveDataProvider
     */
    public function searchPasienMikrobiologi() {
        $criteria = new CDbCriteria;
        $criteria->select = "t.*, pasien.*";
        $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(pasien.no_pendaftaran)', strtolower($this->prefix_pendaftaran . $this->no_pendaftaran), true);
        $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('pasien.instalasiasal_id',$this->instalasiasal_id);
        $criteria->compare('pasien.ruanganasal_id',$this->ruanganasal_id);
        $criteria->compare('pasien.penjamin_id',$this->penjamin_id);
        $criteria->compare('pasien.carabayar_id',$this->carabayar_id);        
        
        $criteria->join = "join pasienmasukpenunjang_v pasien on t.pasienmasukpenunjang_id = pasien.pasienmasukpenunjang_id ";        $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->order = "pasien.tglmasukpenunjang DESC"; //tglmasukpenunjang = tgl pendaftaran
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * load data cara bayar dan penjamin, yang ditampilkan menjadi 1 data 
     * @return type
     */
    public function getCaraBayarPenjamin()
    {
        return $this->carabayar_nama.' / '.$this->penjamin_nama;
    }
}

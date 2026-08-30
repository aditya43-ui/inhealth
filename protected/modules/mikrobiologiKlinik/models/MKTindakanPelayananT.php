<?php

/**
 * Class model tabel tindakanpelayanan_t pada modul mikrobiologi
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage models
 * @category model
 */
class MKTindakanPelayananT extends TindakanpelayananT {

    public $pemeriksaanlab_id, $jenistarif_id, $spesimen_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TindakanpelayananT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * menampilkan pemeriksaan lab berdasarkan daftartindakan_id
     * @return type
     */
    public function getPemeriksaanLab() {
        return PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $this->daftartindakan_id));
    }

}

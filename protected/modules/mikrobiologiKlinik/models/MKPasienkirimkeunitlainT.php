<?php
/**
 * Model extend pasienkirimkeunitlain_t di modul mikrobiologi klinik
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage models
 * @category model
 */
class MKPasienkirimkeunitlainT extends PasienkirimkeunitlainT{
    
    public $no_pendaftaran, $carabayar_id, $carabayar_nama, $penjamin_id, $penjamin_nama, 
           $namadepan, $tanggal_lahir, $instalasiasal_id, $instalasiasal_nama, $ruanganasal_id, $ruanganasal_nama, 
           $gelardepan, $gelarbelakang_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienkirimkeunitlainT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
<?php

/**
 * Model yang digunakan untuk mengambil data tabel seleksipendonor_t, hanya untuk di modul bank darah
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Tantowy <tantowijaya@.com>
 * @version     2.0.0
 * @package application.modules.bankDarah
 * @subpackage models 
 * @category model
 * RSST-1498
 */
class BDSeleksipendonorT extends SeleksipendonorT {

    public $is_gagalseleksiawal, $gagal_seleksi_wanita, $dokter_nama, $gol_darah, $rhesus, $dpjpkuesioner_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SeleksipendonorT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

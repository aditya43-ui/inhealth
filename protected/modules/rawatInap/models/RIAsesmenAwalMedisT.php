<?php

/**
 * @author     Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.rawatInap
 * @subpackage models
 */
class RIAsesmenAwalMedisT extends AsesmenAwalMedisT {

    public $riwayat_obat, $dokterdpjp_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsesmenAwalMedisT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * untuk mengambil MetodeGCSnamaItems
     * @return type object memanggil data berdasarkan criteria
     */
    function getMetodeGCSnamaItems() {

        return MetodegcsM::model()->findAllByAttributes(array('metodegcs_aktif' => true));
    }

}

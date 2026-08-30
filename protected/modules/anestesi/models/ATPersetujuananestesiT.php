<?php

/**
 * Class model anak dari PersetujuananestesiT
 * @author Tantowi J <tantowijaya@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.anestesi
 * @subpackage models  
 */
class ATPersetujuananestesiT extends PersetujuananestesiT {

    public $nama_pembuatpernyataan, $identitas_pembuatpernyataan, $diagnosa_nama, $dokteranestesi_nama, $dokteranestesi_nama2, $saksipihakrs_nama, $jnsanestesi_regional;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PersetujuananestesiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

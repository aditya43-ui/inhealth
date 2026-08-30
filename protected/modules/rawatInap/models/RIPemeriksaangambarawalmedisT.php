<?php

/**
 * @author     Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.rawatInap
 * @subpackage models
 */
class RIPemeriksaangambarawalmedisT extends PemeriksaangambarawalmedisT {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PemeriksaangambarawalmedisT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public $namabagtubuh;

}

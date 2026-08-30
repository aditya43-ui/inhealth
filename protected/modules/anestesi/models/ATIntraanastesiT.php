<?php

/**
 * Class model untuk tabel "intraanastesi_t" di module anestesi.
 *
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.anestesi
 * @subpackage models
 */
class ATIntraanastesiT extends IntraanastesiT {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return IntraanestesiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

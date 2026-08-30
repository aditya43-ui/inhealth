<?php

/**
 * Model untuk Asesmen awal gizi di modul rawat inap
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.rawatJalan
 * @subpackage models
 */
class RIAsesmenawalgiziranapT extends AsesmenawalgiziranapT {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsesmenawalgiziT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

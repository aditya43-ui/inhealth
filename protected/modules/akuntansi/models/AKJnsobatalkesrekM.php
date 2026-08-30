<?php

/**
 * model extends untuk tabel jnsobatalkesrek_m
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.akuntansi
 * @subpackage models
 * @category model
 */
class AKJnsobatalkesrekM extends JnsobatalkesrekM {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JnsobatalkesrekM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

?>
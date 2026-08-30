<?php

class ROReferensiHasilRadM extends ReferensihasilradM
{
    public $refhasilrad_id;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AgamaM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
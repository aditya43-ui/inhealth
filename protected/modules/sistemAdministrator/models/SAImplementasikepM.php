<?php

class SAImplementasikepM extends ImplementasikepM
{
	public $diagnosakep_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
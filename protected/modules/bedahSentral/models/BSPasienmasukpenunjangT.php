<?php

class BSPasienmasukpenunjangT extends PasienmasukpenunjangT{
    
    public $is_adakarcis = 0;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienmasukpenunjangT the static model class
     */
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
}
?>


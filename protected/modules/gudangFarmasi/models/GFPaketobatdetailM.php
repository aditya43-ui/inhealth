<?php

class GFPaketobatdetailM extends PaketobatdetailM
{	

    public $obatalkes_kode;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaketobatdetailM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

}
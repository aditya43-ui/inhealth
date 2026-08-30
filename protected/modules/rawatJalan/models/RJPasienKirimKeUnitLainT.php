<?php

class RJPasienKirimKeUnitLainT extends PasienkirimkeunitlainT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasiendirujukkeluarT the static model class
     */
    public $namadiagnosa;
    public $estimasioperasi;
    public $is_cito_tb, $is_cito_hiv;

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>

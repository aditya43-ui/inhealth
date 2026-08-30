<?php
class ANInformasipenjualanaresepV extends InformasipenjualanaresepV
{
    public $jumlahoa; //untuk di daftar tampil antrian farmasi
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasipenjualanaresepV the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

}
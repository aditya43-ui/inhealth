<?php

class FAInformasipasientriageV extends InformasipasientriageV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasipasientriageV the static model class
     */
public $obatalkes_id,$harga_satuanpakai,$jmlstok,$biayaadministrasi,$obatalkes_nama;
     public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

}

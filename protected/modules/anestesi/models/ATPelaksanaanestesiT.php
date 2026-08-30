<?php
/**
 * @author Rusdiyanto<rusdiyanto@.com>
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.anestesi
 * @subpackage models
 */
class ATPelaksanaanestesiT extends PelaksanaanestesiT
{
    public $pegawai_nama, $ppds_nama, $perawat_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PelaksanaanestesiT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

	
}
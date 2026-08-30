<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class PPPenanggungJawabM extends PenanggungjawabM
{
    public $umur_pj, $nama_pegawai, $jabatan_nama, $unit_perusahaan, $umur;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>

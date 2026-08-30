<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class LBPermintaanKePenunjangT extends PermintaankepenunjangT
{
    public $kelaspelayanan_id;
    public $jenispemeriksaanlab_nama;
    public $jenispemeriksaanlab_id;
    public $jenispemeriksaanlab_kelompok;
    public $subjenis_pemeriksaanlab_id;
    public $subjenis_pemeriksaanlab_nama;
    public $samplelab_id_hiv;
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

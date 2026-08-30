<?php

class KUSetoranbdharaT extends SetoranbdharaT {
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KUSetoranbdharaT the static model class
     */
    
    public $pegawai_nama, $mengetahui_nama;
	public $tgl_awal, $tgl_akhir;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
            
            
    }
    
}

<?php
/**
 * Digunakan di modul Asuhan Keperawatan 
 * 
 * @author Wahyu Wicaksono <wahyuwicaksono@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage models
 */
class SAKelompokfaktorrisikodaftarM extends KelompokfaktorrisikodaftarM
{
    /**
     * 
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public $faktorrisiko_daftar_nama;
    public $faktorrisiko_daftar_namalain;
    
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.            
            return [
                ['faktorrisiko_daftar_nama, faktorrisiko_daftar_namalain, jenisfaktorrisiko_id', 'safe', 'on'=>'search']
            ];
    }


    public function searchDialog()
    {
        $cri = new CDbCriteria();
        $cri->select = "t.kelompokfaktorrisikodaftar_id"
                . ", jenisfaktorrisiko_id"
                . ", faktorrisiko_daftar_nama"
                . ", faktorrisiko_daftar_namalain";
        $cri->join = "left join faktorrisiko_daftar_m f on f.faktorrisiko_daftar_id = t.faktorrisiko_daftar_id";
        
        $cri->compare('jenisfaktorrisiko_id',$this->jenisfaktorrisiko_id);
        $cri->compare('LOWER(faktorrisiko_daftar_nama)', strtolower($this->faktorrisiko_daftar_nama), true);
        $cri->compare('LOWER(faktorrisiko_daftar_namalain)', strtolower($this->faktorrisiko_daftar_namalain), true);
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$cri,
        ));
    }
}
?>
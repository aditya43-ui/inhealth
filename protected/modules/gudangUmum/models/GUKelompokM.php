<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GUKelompokM extends KelompokM
{
    public $golongan_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JeniskasuspenyakitM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    public function getGolonganNama(){
        return $this->golongan->golongan_nama;
    }
    
    public function getGolonganItems()
    {
        return GolonganM::model()->findAll('golongan_aktif = true ORDER BY golongan_nama');
    }
}
?>

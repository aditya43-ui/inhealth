<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class GUSubkelompokM extends SubkelompokM
{
    public $kelompok_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JeniskasuspenyakitM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    public function getKelompokNama(){
        return $this->kelompok->kelompok_nama;
    }

    public function getKelompokItems()
    {
        return KelompokM::model()->findAll('kelompok_aktif = true ORDER BY kelompok_nama');
    }
}
?>

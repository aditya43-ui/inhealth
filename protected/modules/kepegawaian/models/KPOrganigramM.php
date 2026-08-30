<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPOrganigramM extends OrganigramM {
    
    public $tgl_awal;
    public $tgl_akhir;
    public $nama_pegawai;    
    public $nomorindukpegawai;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    
    
    public function searchInformasi(){
        $criteria=new CDbCriteria;
        $criteria->with = array('pegawai');
        $criteria->addBetweenCondition('date(t.organigram_periode)', $this->tgl_awal, $this->tgl_akhir);        
        $criteria->compare('LOWER(t.organigram_kode)', strtolower($this->organigram_kode), true);
        $criteria->compare('LOWER(pegawai.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(pegawai.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        if (!empty($this->jabatan_id)){
            $criteria->addCondition(" t.jabatan_id = '".$this->jabatan_id."' ");
        }
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

}

?>

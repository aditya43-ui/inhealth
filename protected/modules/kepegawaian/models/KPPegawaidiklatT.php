<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPPegawaidiklatT extends PegawaidiklatT {
    
    public $tgl_awal;
    public $tgl_akhir;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchInfo($pegawai = null)
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.
            $criteria=new CDbCriteria;
            $criteria->with = array('jenisdiklat');
            //if(!empty($pegawai)){
            //$criteria->addCondition('pegawai_id = '.$pegawai);
           // }
            if(!empty($this->pegawaidiklat_id)){
            $criteria->addCondition('pegawaidiklat_id = '.$this->pegawaidiklat_id);
            }
            if(!empty($this->jenisdiklat_id)){
            $criteria->addCondition('t.jenisdiklat_id = '.$this->jenisdiklat_id);
            }
            $criteria->compare('LOWER(pegawaidiklat_nama)',strtolower($this->pegawaidiklat_nama),true);
            $criteria->compare('LOWER(pegawaidiklat_namalainnya)',strtolower($this->pegawaidiklat_namalainnya),true);
            $criteria->compare('LOWER(pegawaidiklat_lamanya)',strtolower($this->pegawaidiklat_lamanya),true);
            $criteria->compare('DATE(pegawaidiklat_tahun)',$this->pegawaidiklat_tahun);
            $criteria->compare('LOWER(pegawaidiklat_tempat)',strtolower($this->pegawaidiklat_tempat),true);
            $criteria->compare('LOWER(nomorkeputusandiklat)',strtolower($this->nomorkeputusandiklat),true);
            $criteria->compare('LOWER(tglditetapkandiklat)',strtolower($this->tglditetapkandiklat),true);
            $criteria->compare('LOWER(pejabatygmemdiklat)',strtolower($this->pejabatygmemdiklat),true);
            $criteria->compare('LOWER(pegawaidiklat_keterangan)',strtolower($this->pegawaidiklat_keterangan),true);
            $criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
            $criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
            $criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
            $criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
            $criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
            $criteria->addCondition('jenisdiklat.jenisdiklat_aktif IS TRUE');
            $criteria->order='pegawaidiklat_nama';
            $criteria->limit=5; 
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    
    public function searchInformasi(){
        $criteria=new CDbCriteria;
        $criteria->addBetweenCondition('date(tglditetapkandiklat)', $this->tgl_awal, $this->tgl_akhir);        
        $criteria->compare('LOWER(nomorkeputusandiklat)', strtolower($this->nomorkeputusandiklat), true);
        $criteria->compare('LOWER(pegawaidiklat_nama)', strtolower($this->pegawaidiklat_nama), true);
        if (!empty($this->jenisdiklat_id)){
            $criteria->addCondition(" jenisdiklat_id = '".$this->jenisdiklat_id."' ");
        }
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

}

?>

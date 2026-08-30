<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SASubsubkelompokM extends SubsubkelompokM
{
    public $subkelompok_nama;
    public $golongan_id, $bidang_id, $kelompok_id;
    public $temp_subkel_id;
    public $temp_kode_subsubkel;
    public $dropdown_bidang;
    public $dropdown_kelompok;    
    public $dropdown_subkelompok;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JeniskasuspenyakitM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    public function getSubKelompokNama(){
        return $this->subkelompok->subkelompok_nama;
    }
    
    public function getBidang()
    {        
        if (!empty($this->golongan_id)){
            return SABidangM::model()->findAll(("golongan_id = '$this->golongan_id' AND bidang_aktif = TRUE ORDER BY bidang_kode ASC"));
        }else{
            return array();
        }
    }
    
    public function getKelompok()
    {        
        if (!empty($this->bidang_id)){
            return SAKelompokM::model()->findAll(("bidang_id = '$this->bidang_id' AND kelompok_aktif = TRUE ORDER BY kelompok_kode ASC"));
        }else{
            return array();
        }
    }
    
    public function getSubKelompok()
    {        
        if (!empty($this->kelompok_id)){
            return SASubkelompokM::model()->findAll(("kelompok_id = '$this->kelompok_id' AND subkelompok_aktif = TRUE ORDER BY subkelompok_kode ASC"));
        }else{
            return array();
        }
    }
    
    public function search()
    {           
            $criteria=new CDbCriteria;
            $criteria->join =   " JOIN subkelompok_m sk ON sk.subkelompok_id = t.subkelompok_id "
                    .           " JOIN kelompok_m k ON k.kelompok_id = sk.kelompok_id "
                    .           " JOIN bidang_m b ON b.bidang_id = k.bidang_id "
                    .           " JOIN golongan_m g ON g.golongan_id = b.golongan_id ";
            $criteria->compare('t.subsubkelompok_id',$this->subsubkelompok_id);
            $criteria->compare('t.subkelompok_id',$this->subkelompok_id);
            $criteria->compare('LOWER(t.subsubkelompok_kode)',  strtolower($this->subsubkelompok_kode),true);
            $criteria->compare('LOWER(t.subsubkelompok_nama)',  strtolower($this->subsubkelompok_nama),true);
            $criteria->compare('LOWER(t.subsubkelompok_namalainnya)',  strtolower($this->subsubkelompok_namalainnya),true);
            $criteria->compare('t.subsubkelompok_aktif',isset($this->subsubkelompok_aktif)?$this->subsubkelompok_aktif:true);
            if (!empty($this->golongan_id)){
                $criteria->addCondition("g.golongan_id = '".$this->golongan_id."' ");
            }
            if (!empty($this->bidang_id)){
                $criteria->addCondition("b.bidang_id = '".$this->bidang_id."' ");
            }
            if (!empty($this->kelompok_id)){
                $criteria->addCondition("k.kelompok_id = '".$this->kelompok_id."' ");
            }            

            $criteria->limit = 10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,                   
            ));
    }

    public function searchPrint()
    {           
            $criteria=new CDbCriteria;
            $criteria->join =   " JOIN subkelompok_m sk ON sk.subkelompok_id = t.subkelompok_id "
                    .           " JOIN kelompok_m k ON k.kelompok_id = sk.kelompok_id "
                    .           " JOIN bidang_m b ON b.bidang_id = k.bidang_id "
                    .           " JOIN golongan_m g ON g.golongan_id = b.golongan_id ";
            $criteria->compare('t.subsubkelompok_id',$this->subsubkelompok_id);
            $criteria->compare('t.subkelompok_id',$this->subkelompok_id);
            $criteria->compare('LOWER(t.subsubkelompok_kode)',  strtolower($this->subsubkelompok_kode),true);
            $criteria->compare('LOWER(t.subsubkelompok_nama)',  strtolower($this->subsubkelompok_nama),true);
            $criteria->compare('LOWER(t.subsubkelompok_namalainnya)',  strtolower($this->subsubkelompok_namalainnya),true);
            $criteria->compare('t.subsubkelompok_aktif',isset($this->subsubkelompok_aktif)?$this->subsubkelompok_aktif:true);
            if (!empty($this->golongan_id)){
                $criteria->addnCodition("g.golongan_id = '".$this->golongan_id."' ");
            }
            if (!empty($this->bidang_id)){
                $criteria->addCondition("b.bidang_id = '".$this->bidang_id."' ");
            }
            if (!empty($this->kelompok_id)){
                $criteria->addCondition("k.kelompok_id = '".$this->kelompok_id."' ");
            } 
            $criteria->limit = -1;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination' => false,
            ));
    }
}
?>

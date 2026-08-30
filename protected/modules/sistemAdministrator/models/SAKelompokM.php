<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SAKelompokM extends KelompokM
{
    public $bidang_nama, $golongan_id, $dropdown_bidang;
    public $temp_bid_id;
    public $temp_kode_kel;
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
        return $this->bidang->bidang_nama;
    }
    
    public function search()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->join = " JOIN bidang_m b ON b.bidang_id = t.bidang_id "
                            . " JOIN golongan_m g ON g.golongan_id = b.golongan_id ";
            $criteria->compare('t.kelompok_id',$this->kelompok_id);
            $criteria->compare('t.bidang_id',$this->bidang_id);
            $criteria->compare('LOWER(t.kelompok_kode)',strtolower($this->kelompok_kode),true);
            $criteria->compare('LOWER(t.kelompok_nama)',strtolower($this->kelompok_nama),true);
            $criteria->compare('LOWER(t.kelompok_namalainnya)',strtolower($this->kelompok_namalainnya),true);
            $criteria->compare('t.kelompok_aktif',isset($this->kelompok_aktif)?$this->kelompok_aktif:true);
            if (!empty($this->golongan_id)){
                $criteria->addCondition("g.golongan_id = '".$this->golongan_id."' ");
            }
//                $criteria->addCondition('kelompok_aktif is true');

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }


    public function searchPrint()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            $criteria->join = " JOIN bidang_m b ON b.bidang_id = t.bidang_id "
                            . " JOIN golongan_m g ON g.golongan_id = b.golongan_id ";
            $criteria->compare('t.kelompok_id',$this->kelompok_id);
            $criteria->compare('t.bidang_id',$this->bidang_id);
            $criteria->compare('LOWER(t.kelompok_kode)',strtolower($this->kelompok_kode),true);
            $criteria->compare('LOWER(t.kelompok_nama)',strtolower($this->kelompok_nama),true);
            $criteria->compare('LOWER(t.kelompok_namalainnya)',strtolower($this->kelompok_namalainnya),true);
            $criteria->compare('t.kelompok_aktif',isset($this->kelompok_aktif)?$this->kelompok_aktif:true);
            if (!empty($this->golongan_id)){
                $criteria->addCondition("g.golongan_id = '".$this->golongan_id."' ");
            }
            // Klo limit lebih kecil dari nol itu berarti ga ada limit 
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    
    public function getBidang()
    {
        
        if (!empty($this->golongan_id)){
            return SABidangM::model()->findAll(("golongan_id = '$this->golongan_id' AND bidang_aktif = TRUE ORDER BY bidang_kode ASC"));
        }else{
            return array();
        }
    }
}
?>

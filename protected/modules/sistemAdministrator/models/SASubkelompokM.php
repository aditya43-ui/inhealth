<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SASubkelompokM extends SubkelompokM
{
    public $kelompok_nama;
    public $kelompok_id;
    public $bidang_id;
    public $golongan_id;
    public $temp_kel_id;
    public $temp_kode_subkel;
    public $dropdown_bidang;
    public $dropdown_kelompok;    
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
    
    public function search()
	{		
            $criteria=new CDbCriteria;
            $criteria->join =   " JOIN kelompok_m k ON k.kelompok_id = t.kelompok_id "
                    .           " JOIN bidang_m b ON b.bidang_id = k.bidang_id "
                    .           " JOIN golongan_m g ON g.golongan_id = b.golongan_id ";
            $criteria->compare('t.subkelompok_id',$this->subkelompok_id);
            $criteria->compare('t.kelompok_id',$this->kelompok_id);
            $criteria->compare('LOWER(t.subkelompok_kode)',strtolower($this->subkelompok_kode),true);
            $criteria->compare('LOWER(t.subkelompok_nama)',strtolower($this->subkelompok_nama),true);
            $criteria->compare('LOWER(t.subkelompok_namalainnya)',strtolower($this->subkelompok_namalainnya),true);
            $criteria->compare('subkelompok_aktif',isset($this->subkelompok_aktif)?$this->subkelompok_aktif:true);
            if (!empty($this->bidang_id)){
                $criteria->addCondition(" b.bidang_id = '".$this->bidang_id."' ");
            }
            if (!empty($this->golongan_id)){
                $criteria->addCondition(" g.golongan_id = '".$this->golongan_id."' ");
            }
            

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
	}
                
        public function searchPrint()
        {                
                $criteria=new CDbCriteria;
                $criteria->join =   " JOIN kelompok_m k ON k.kelompok_id = t.kelompok_id "
                    .           " JOIN bidang_m b ON b.bidang_id = k.bidang_id "
                    .           " JOIN golongan_m g ON g.golongan_id = b.golongan_id ";
		$criteria->compare('subkelompok_id',$this->subkelompok_id);
		$criteria->compare('kelompok_id',$this->kelompok_id);
		$criteria->compare('LOWER(subkelompok_kode)',strtolower($this->subkelompok_kode),true);
		$criteria->compare('LOWER(subkelompok_nama)',strtolower($this->subkelompok_nama),true);
		$criteria->compare('LOWER(subkelompok_namalainnya)',strtolower($this->subkelompok_namalainnya),true);
		$criteria->compare('subkelompok_aktif',isset($this->subkelompok_aktif)?$this->subkelompok_aktif:true);
                if (!empty($this->bidang_id)){
                    $criteria->addCondition(" b.bidang_id = '".$this->bidang_id."' ");
                }
                if (!empty($this->golongan_id)){
                    $criteria->addCondition(" g.golongan_id = '".$this->golongan_id."' ");
                }
        
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
}
?>

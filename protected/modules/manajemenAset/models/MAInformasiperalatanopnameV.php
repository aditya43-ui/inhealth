<?php

class MAInformasiperalatanopnameV extends InformasiperalatanopnameV
{
     public $tgl_awal, $tgl_akhir;
     public $ada_pj_aset;
    /**
     * 
     * @param type $className
     * @return type
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchInformasi(){
        
        $cri = new CDbCriteria();
        $cri->addBetweenCondition("DATE(t.asetopname_tanggal)", $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->periodeasetopname_id)){
            $cri->addCondition("t.periodeasetopname_id = ".$this->periodeasetopname_id);
        }        
        if (!empty($this->barang_id)){
            $cri->addCondition("t.barang_id = ".$this->barang_id);
        }
        if (!empty($this->ruangan_id)){
            $cri->addCondition("t.ruangan_id = ".$this->ruangan_id);
        }
        if (!empty($this->lokasi_id)){
            if (!is_array($this->lokasi_id)){
                $cri->addCondition("t.lokasi_id = ".$this->lokasi_id);
            }else{
                $cri->addInCondition("t.lokasi_id",$this->lokasi_id);
            }
        }
        if (!empty($this->invperalatan_keadaan)){
            $cri->addCondition("t.invperalatan_keadaan = '".$this->invperalatan_keadaan."' ");
        }
        $cri->compare("LOWER(t.invperalatan_kode)", strtolower($this->invperalatan_kode), true);
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$cri,
        ));
    }
}
?>

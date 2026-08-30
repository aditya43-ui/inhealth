<?php

class RJDaftarpasienmeninggalV extends DaftarpasienmeninggalV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AnamnesaT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchInformasi(){
        
        $cri = new CDbCriteria;
        $cri->addBetweenCondition("DATE(tgl_pendaftaran)", $this->tgl_awal, $this->tgl_akhir);
        $cri->compare("LOWER(nama_pasien)", strtolower($this->nama_pasien), true);
        $cri->compare("LOWER(no_rekam_medik)", strtolower($this->no_rekam_medik), true);
            
        if (!empty($this->caramasuk_id)){
            $cri->addInCondition("caramasuk_id", $this->caramasuk_id);
        }
        
        if (!empty($this->kondisikeluar_id)){
            $cri->addInCondition("kondisikeluar_id", $this->kondisikeluar_id);
        }
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$cri,
        ));
    }
}
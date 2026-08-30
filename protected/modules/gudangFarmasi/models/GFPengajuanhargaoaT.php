<?php

class GFPengajuanhargaoaT extends PengajuanhargaoaT
{
    public $pegawai_nama, $pegawaimengetahui_nama, $pegawaimenyetujui_nama, $tgl_awal, $tgl_akhir;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchInformasi()
    {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('date(tglpengajuanhargaoa)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('lower(nopengajuanhargaoa)', strtolower($this->nopengajuanhargaoa),true);
        if(!empty($this->statuspengajuan)){
            if($this->statuspengajuan=='BELUM DISETUJUI'){
                $this->statuspengajuan = null;
            }
        }
        $criteria->compare('lower(statuspengajuan)', strtolower($this->statuspengajuan));
        
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));
    }
}
<?php

class GJLaporanrekappajakdokterV extends LaporanrekappajakdokterV
{
    public $jns_periode, $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_akhir, $thn_awal, $pegawaiNama;
	public static function model($className=__CLASS__)
	{
            return parent::model($className);
	}
	
    
    public function searchLaporan() {
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('date(tglbayarjasa)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchPrintLaporan() {
        $criteria = new CDbCriteria();
        $criteria->addBetweenCondition('date(tglbayarjasa)', $this->tgl_awal, $this->tgl_akhir);
        if(!empty($this->pegawai_id)){
            $criteria->addCondition('pegawai_id = '.$this->pegawai_id);
        }
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
    }
    
    public function getTarifPersen($value){
        $hasil = "";
        if($value > 250000000){
            $hasil = '30%';
        }else if($value > 200000000 && $value <= 250000000){
            $hasil = '25%';
        }else if($value > 50000000  && $value <= 200000000){
            $hasil = '15%';
        }else{
            $hasil = '5%';
        } 
        return $hasil;
    }
}
<?php

class MARekeningakuntansiV extends RekeningakuntansiV {
	public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	// fungsi untuk penjurnalan di transaksi penyusutan aset
    public function getNamaRekening()
    {
        if(isset($this->rekening5_id))
        {
            $kode_rekening = $this->nmrekening5;
        }else{
            if(isset($this->rekening4_id))
            {
                $kode_rekening = $this->nmrekening4;
            }else{
                $kode_rekening = $this->nmrekening3;
            }
        }
        
        return $kode_rekening;
    }
    
}


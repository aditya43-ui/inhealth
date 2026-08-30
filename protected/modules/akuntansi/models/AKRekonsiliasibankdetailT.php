<?php
class AKRekonsiliasibankdetailT extends RekonsiliasibankdetailT
{
	public $kode_rekening, $nama_rekening, $keterangan, $uraiantransaksi;
	public $kdrekening1,$kdrekneing2,$kdrekening3,$kdrekening4,$kdrekening5,$nmrekening5;
	public $rekening1_id,$rekening2_id,$rekening3_id,$rekening4_id,$rekening5_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getKodeRekening()
    {
        if(isset($this->rekening5_id))
        {
            $kode_rekening = $this->rekening5->kdrekening5;
        }else{
            if(isset($this->rekening4_id))
            {
                $kode_rekening = $this->rekening1->kdrekening1 . "-" . $this->rekening2->kdrekening2 . "-" . $this->rekening3->kdrekening3 . "-" . $this->rekening4->kdrekening4;
            }else{
                $kode_rekening = $this->rekening1->kdrekening1 . "-" . $this->rekening2->kdrekening2 . "-" . $this->rekening3->kdrekening3;
            }
        }
        
        return $kode_rekening;
    }
    
    public function getNamaRekening()
    {
        if(isset($this->rekening5_id))
        {
            $kode_rekening = $this->rekening5->nmrekening5;
        }else{
            if(isset($this->rekening4_id))
            {
                $kode_rekening = $this->rekening4->nmrekening4;
            }else{
                $kode_rekening = $this->rekening3->nmrekening3;
            }
        }
        
        return $kode_rekening;
    }
}
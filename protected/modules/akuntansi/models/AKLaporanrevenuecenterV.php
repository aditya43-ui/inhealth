<?php
class AKLaporanrevenuecenterV extends LaporanrevenuecenterV
{
    public $tgl_awal, $tgl_akhir;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function searchLaporan()
    {
        $criteria=new CDbCriteria;
        $criteria->select = "rekening5_id , kdrekening5, nmrekening5, sum(saldo_rj) as saldo_rj, sum(saldo_ri) as saldo_ri, sum(saldo_rd) as saldo_rd, sum(saldo_vk) as saldo_vk, sum(saldo_pi) as saldo_pi, sum(saldo_hd) as saldo_hd, sum(saldo_fisioterpi) as saldo_fisioterpi, sum(saldo_mcu) as saldo_mcu, sum(saldo_lab) as saldo_lab, sum(saldo_rad) as saldo_rad, sum(saldo_ibs) as saldo_ibs, sum(saldo_pemulasaran) as saldo_pemulasaran, sum(saldo_bankdrh) as saldo_bankdrh, sum(saldo_apotek) as saldo_apotek";
        $criteria->group = "rekening5_id , kdrekening5, nmrekening5";
        
//        $criteria->addBetweenCondition('date(tglbukubesar)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition('saldoakun <> 0');
        $criteria->order = "kdrekening5 ASC";
        
        return $criteria;
    }
}

?>
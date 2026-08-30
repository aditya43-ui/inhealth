<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GZStokbahanmakananT
 *
 * @author sujana
 */
class GZStokbahanmakananT extends StokbahanmakananT {
    
    public $tgl_awal;
    public $tgl_akhir;
    public $namabahanmakanan;
    public $jumlah;
    public $masuk;
    public $keluar;
    public $cekTgl;
    public $satuanbahan;
    public $jmlminimal;
    public $golbahanmakanan_id, $kelbahanmakanan, $jenisbahanmakanan;
    public $golbahanmakanan_nama;
    public $barang_satuan, $ceklisminimal;

        public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchInformasi() {
        
      
        $criteria = new CDbCriteria();
        $criteria->select = "bm.jmlminimal, bm.satuanbahan, bm.namabahanmakanan, bm.bahanmakanan_id,SUM(t.qty_masuk) as masuk, SUM(t.qty_keluar) as keluar, SUM(t.qty_current) as jumlah, bm.jmlpersediaan, g.golbahanmakanan_nama, bm.jenisbahanmakanan";
        $criteria->join =       " RIGHT JOIN bahanmakanan_m bm ON bm.bahanmakanan_id = t.bahanmakanan_id "
                            .   " left join golbahanmakanan_m g on g.golbahanmakanan_id = bm.golbahanmakanan_id "
                            .   " LEFT JOIN terimabahandetail_t tbd ON tbd.terimabahandetail_id = t.terimabahandetail_id ".
                                " LEFT JOIN terimabahanmakan_t tbm ON tbm.terimabahanmakan_id = tbd.terimabahanmakan_id";
        if ($this->cekTgl == 1){			
            $criteria->addBetweenCondition('DATE(t.tgltransaksi)', $this->tgl_awal, $this->tgl_akhir);
        }
        
         if ($this->ceklisminimal == 1){			
            $criteria->addCondition('COALESCE(t.qty_current, 0 ) <= COALESCE(bm.jmlminimal, 0 )');
        }
        
        $criteria->compare('LOWER(bm.namabahanmakanan)', strtolower($this->namabahanmakanan), TRUE);
        
        $criteria->compare('LOWER(bm.kelbahanmakanan)',strtolower($this->kelbahanmakanan),true);
        $criteria->compare('bm.golbahanmakanan_id',$this->golbahanmakanan_id);
        $criteria->compare('bm.jenisbahanmakanan',$this->jenisbahanmakanan);
        $criteria->compare('bm.satuanbahan',$this->satuanbahan);
        $criteria->compare('LOWER(bm.jenisbahanmakanan)',strtolower($this->jenisbahanmakanan),true);
        
        $criteria->group = "bm.jmlminimal, bm.bahanmakanan_id, bm.namabahanmakanan, jmlpersediaan, bm.satuanbahan, g.golbahanmakanan_nama, bm.jenisbahanmakanan";
        $criteria->order = "bm.namabahanmakanan ASC";
        
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
    
    public function searchInformasiUntukFormulirOpname() {
        $prov = $this->searchInformasi();
        $prov->pagination = false;
        $prov->criteria->compare("t.bahanmakanan_id", $this->bahanmakanan_id);
        
        return $prov;
    }
    
    public function searchDialogBahanMakanan() {
        
      
        $criteria = new CDbCriteria();
        $criteria->select = "bm.satuanbahan, bm.namabahanmakanan, bm.bahanmakanan_id,SUM(t.qty_masuk) as masuk, SUM(t.qty_keluar) as keluar, SUM(t.qty_current) as jumlah, bm.jmlpersediaan, g.golbahanmakanan_nama, bm.jenisbahanmakanan, bm.kelbahanmakanan";
        $criteria->join =       " JOIN bahanmakanan_m bm ON bm.bahanmakanan_id = t.bahanmakanan_id "
                            .   " JOIN golbahanmakanan_m g on g.golbahanmakanan_id = bm.golbahanmakanan_id "
                            .   " LEFT JOIN terimabahandetail_t tbd ON tbd.terimabahandetail_id = t.terimabahandetail_id ".
                                " LEFT JOIN terimabahanmakan_t tbm ON tbm.terimabahanmakan_id = tbd.terimabahanmakan_id";
//        if ($this->cekTgl == 1){			
//            $criteria->addBetweenCondition('DATE(tbm.tglterimabahan)', $this->tgl_awal, $this->tgl_akhir);
//        }
        $criteria->compare('LOWER(bm.namabahanmakanan)', strtolower($this->namabahanmakanan), TRUE);
        
        $criteria->compare('LOWER(bm.kelbahanmakanan)',strtolower($this->kelbahanmakanan),true);
        $criteria->compare('bm.golbahanmakanan_id',$this->golbahanmakanan_id);
        $criteria->compare('LOWER(bm.jenisbahanmakanan)',strtolower($this->jenisbahanmakanan),true);
        $criteria->compare('LOWER(bm.satuanbahan)',strtolower($this->satuanbahan));
        
        $criteria->group = "bm.bahanmakanan_id, bm.namabahanmakanan, jmlpersediaan, bm.satuanbahan, g.golbahanmakanan_nama, bm.jenisbahanmakanan, bm.kelbahanmakanan";
        $criteria->order = "bm.namabahanmakanan ASC";
       
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
}

?>

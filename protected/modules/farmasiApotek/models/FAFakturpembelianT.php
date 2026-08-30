<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FAFakturpembelianT extends FakturpembelianT {

    
    public $tick;
    public $data;
    public $jumlah;
    public $totaltagihan;
    public $jmldibayarkan;
    public $total_bruto,$total_discount,$total_ppn,$total_bayar,$total_tagihan,$total_sisa,$total_netto,$materai;
    public $supplier_id,$supplier_nama,$supplier_alamat;
    public $noterima,$tglterima,$nopermintaan;
    public $fakturpembelian_id;
    
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	
	public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
}

?>

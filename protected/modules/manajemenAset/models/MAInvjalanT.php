<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInvjalanT extends InvjalanT
{
    public $barang_nama;
	public $kode_wilayah;
    public $lokasi_nama;
        public $kondisifisikbangunan,$nomerkodetanah;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
	
	public function getfisikBangunan() {
		
		return array(
		'Baik'=>'Baik',
		'Kurang Baik'=>'Kurang Baik',
		'Rusak Berat'=>'Rusak Berat',		
		);
		
		
	}
}
?>

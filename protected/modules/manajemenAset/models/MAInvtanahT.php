<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class MAInvtanahT extends InvtanahT
{
	public $kode_wilayah, $nopenerimaan, $terimapersediaan_id, $lokasi_nama;
    
    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'nopenerimaan'=>'No. Penerimaan Barang',
            'terimapersediaan_id'=>'No. Penerimaan Barang',
            // 'terimapersdetail_id'=>'No. Penerimaan Barang',
        ));
    }
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KabupatenM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public function getTahunNama(){
        return $this->invtanah_thnpengadaan.PHP_EOL."".$this->invtanah_tglguna;
    }
    public function getSertifikat(){
        return $this->invtanah_nosertifikat.'--'.$this->invtanah_tglsertifikat;
    }
}
?>

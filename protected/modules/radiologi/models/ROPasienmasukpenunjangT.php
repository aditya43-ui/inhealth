<?php

class ROPasienmasukpenunjangT extends PasienmasukpenunjangT{
    
    public $is_adakarcis = 0;
	public $perawat_id = null; //untuk tindakanpelayanan_t (analis lab)
	public $ceklis;
	public $is_verifikasi, $catatan_verifikasi, $is_elektif, $tgl_tindakan;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienmasukpenunjangT the static model class
     */
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
	/**
	 * perawat_id tindakanpelayanan_t yg sudah ada
	 */
	public function getPerawatId(){
		$loadTindakan = TindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$this->pasienmasukpenunjang_id),"perawat_id IS NOT NULL");
		if(isset($loadTindakan->perawat_id)){
			if(!empty($loadTindakan->perawat_id)){
				return $loadTindakan->perawat_id;
			}else{
				return null;
			}
		}else{
			return null;
		}
	}
}
?>


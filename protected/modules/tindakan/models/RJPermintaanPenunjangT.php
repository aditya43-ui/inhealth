<?php

class RJPermintaanPenunjangT extends PermintaankepenunjangT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function loadPemeriksaanOperasi(){
            $cek = OperasiM::model()->findByAttributes(array('daftartindakan_id'=>$this->daftartindakan_id));
            
            return !empty($cek)?$cek->operasi_id:null;
        }
        
        public function loadPemeriksaanLab(){
            $cek = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id'=>$this->daftartindakan_id));
            
            return !empty($cek)?$cek->pemeriksaanlab_id:null;
        }
        
        public function loadPemeriksaanRad(){
            $cek = PemeriksaanradM::model()->findByAttributes(array('daftartindakan_id'=>$this->daftartindakan_id));
            
            return !empty($cek)?$cek->pemeriksaanrad_id:null;
        }

}
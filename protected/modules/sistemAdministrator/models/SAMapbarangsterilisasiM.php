<?php

class SAMapbarangsterilisasiM extends MapbarangsterilisasiM
{
      public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	public function getPeralatanSterilisasi($id) {
            $hasil = ''; 
            if(isset($id)) {
            $modPeralatan = PeralatansterilisasiM::model()->findByPk($id);  
            if(isset($modPeralatan)) {
                $hasil = $modPeralatan->peralatansterilisasi_nama;
            }
            }       
            return $hasil;
        } 
        
        public function getBarang($id) {
            $hasil = ''; 
            if(isset($id)) {
            $modPeralatan = BarangM::model()->findByPk($id);  
            if(isset($modPeralatan)) {
                $hasil = $modPeralatan->barang_nama;
            }
            }       
            return $hasil;
        }
}
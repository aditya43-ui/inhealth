<?php

class SAMapalkessterilisasiM extends MapalkessterilisasiM
{
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MapalkessterilisasiM the static model class
	 */
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
        
        public function getAlkes($id) {
            $hasil = ''; 
            if(isset($id)) {
            $modPeralatan = ObatalkesM::model()->findByPk($id);  
            if(isset($modPeralatan)) {
                $hasil = $modPeralatan->obatalkes_nama;
            }
            }       
            return $hasil;
        }

}
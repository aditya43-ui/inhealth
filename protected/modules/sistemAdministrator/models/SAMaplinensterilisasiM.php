<?php

class SAMaplinensterilisasiM extends MaplinensterilisasiM
{
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaplinensterilisasiM the static model class
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
        
        public function getLinen($id) {
            $hasil = ''; 
            if(isset($id)) {
            $modPeralatan = LinenM::model()->findByPk($id);  
            if(isset($modPeralatan)) {
                $hasil = $modPeralatan->namalinen;
            }
            }       
            return $hasil;
        }
}
<?php

class FAResepturT extends ResepturT
{
    public $noresep_depan;
    public $noresep_belakang;
    
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        //Menampilkan nama lengkap dokter + gelar
        public function getDokter(){
            if(!empty($this->pegawai_id)){
                $modDokter = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$this->pegawai_id));
                return $modDokter->gelardepan." ".$modDokter->nama_pegawai.(isset($modDokter->gelarbelakang->gelarbelakang_nama) ? ", ".$modDokter->gelarbelakang->gelarbelakang_nama : "");
            }else
                return null;
        }
		
	public function getNamaLengkapPegawai($pegawai_id)
    {
		$modPegawai = PegawaiM::model()->findByPk($pegawai_id);
        return (isset($modPegawai->gelardepan) ? $modPegawai->gelardepan : "").' '.$modPegawai->nama_pegawai.(isset($modPegawai->gelarbelakang_id) ? ', '.$modPegawai->gelarbelakang->gelarbelakang_nama : "");
    }
        

}
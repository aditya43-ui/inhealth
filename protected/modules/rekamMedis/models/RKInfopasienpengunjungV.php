<?php

class RKInfopasienpengunjungV extends InfopasienpengunjungV{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchDialogKunjungan() {
            $provider = $this->search();
            return $provider;
        }
        
        
    public function dokterlengkap($pegawai_id) {
        $hasil = '';  
        if(isset($pegawai_id)) {
            $modPegawai = PegawaiM::model()->findByAttributes(array('pegawai_id'=>$pegawai_id));
        
            if(isset($modPegawai)) {
                $modGelarDepan = GelarbelakangM::model()->findByAttributes(array('gelarbelakang_id'=>$modPegawai->gelarbelakang_id));
                if(isset($modGelarDepan)) {
                $hasil = $modPegawai->gelardepan.". ".$modPegawai->nama_pegawai.". ".$modGelarDepan->gelarbelakang_nama;
                }else{
                $hasil = $modPegawai->gelardepan.". ".$modPegawai->nama_pegawai;   
                }    
            }
        }
        
        return $hasil;
        
    }
}

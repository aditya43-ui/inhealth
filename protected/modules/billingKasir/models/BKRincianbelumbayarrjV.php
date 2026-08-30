<?php

class BKRincianbelumbayarrjV extends RincianbelumbayarrjV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RincianbelumbayarrjV the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
	
    public function getNamaPasienPendaftar()
    {
		return $this->namadepan.' '.$this->nama_pasien; 	     
    }

    public function getAlamatPasienPendaftar()
    {
		return $this->alamat_pasien.' Rt/Rw. '.$this->rt.' / '.$this->rw; 	     
    }

    public function getDokterPemeriksa()
    {
		return $this->gelardepan.' '.$this->nama_pegawai.' '.$this->gelarbelakang_nama; 	     
    }

    public function getCarabayarPenjamin()
    {
		return $this->carabayar_nama.' / '.$this->penjamin_nama; 	     
    }    

    public function getDokterTindakan()
    {
    	$modDokter = PegawaiM::model()->findByPk($this->doktertindakan_id);

    	$nama_lengkap_dokter = (isset($modDokter->gelardepan) ? $modDokter->gelardepan : "").' '.(isset($modDokter->nama_pegawai) ? $modDokter->nama_pegawai : "").' '.(isset($modDokter->gelarbelakang_nama) ? $modDokter->gelarbelakang_nama : ""); 	     

    	return $nama_lengkap_dokter;
    }
}
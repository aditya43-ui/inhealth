<?php

class BKLaporanbiayapelayanan extends LaporanbiayapelayananV {
   
    public $tgl_awal;
    public $tgl_akhir;
    public $bln_awal;
    public $bln_akhir;
    public $thn_awal;
    public $thn_akhir;
    public $jns_periode;
    public $tick;
    public $data;
    public $jumlah;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        

        $criteria = $this->functionCriteria();
		$criteria->select = 'instalasi_nama, ruangan_nama, namadepan, pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id, sum(tarif_tindakan) as total, sum(iurbiaya_tindakan) as iurbiaya';
        $criteria->group = 'instalasi_nama, ruangan_nama, namadepan, pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id';
		$criteria->order = " tgl_pendaftaran ASC";
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchGrafik() {
        
        $criteria = $this->functionCriteria();
        //$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->select = 'count(pendaftaran_id) as jumlah, instalasi_nama as data';        
        
       
        $criteria->group = 'instalasi_nama';
		$criteria->order = " jumlah DESC ";
        
        
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));

    }
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        
        $criteria = $this->functionCriteria();
		$criteria->select = 'instalasi_nama, ruangan_nama, namadepan, pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id, sum(tarif_tindakan) as total, sum(iurbiaya_tindakan) as iurbiaya';
        $criteria->group = 'instalasi_nama, ruangan_nama, namadepan, pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id';
		$criteria->order = " tgl_pendaftaran ASC";
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    //'pagination'=>false,
                ));
    }
    
    protected function functionCriteria(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        
        if (is_array($this->penjamin_id)){
            $criteria->addInCondition('penjamin_id', $this->penjamin_id);
        }else{
            //$criteria->addCondition('penjamin_id is null');
        }
		if (is_array($this->carabayar_id)){
            $criteria->addInCondition('carabayar_id', $this->carabayar_id);
        }else{
            //$criteria->addCondition('penjamin_id is null');
        }
		
        if (is_array($this->kelaspelayanan_id)){
            $criteria->addInCondition('kelaspelayanan_id', $this->kelaspelayanan_id);
        }else{
            //$criteria->addCondition('kelaspelayanan_id is null');
        }
		
		if (is_array($this->instalasi_id)){
            $criteria->addInCondition('instalasi_id', $this->instalasi_id);
        }else{
          $criteria->addInCondition('instalasi_id', Params::getArrayInstalasiBiayaPelayanan());
        }
		
		if (is_array($this->ruangan_id)){
            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
        }else{
           
        }
        
        return $criteria;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

}
<?php

class PSLaporanbiayapelayanan extends LaporanbiayapelayananV{
	
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir,$tglAwal,$tglAkhir;
	
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();
		$criteria->select = " count(pendaftaran_id) as jumlah, kelaspelayanan_nama as data ";
		$criteria->group = " kelaspelayanan_nama";

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));

    }
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false,
                ));
    }
    
    protected function functionCriteria(){
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        $criteria->select = 'namadepan, pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id, sum(tarif_tindakan) as total, sum(iurbiaya_tindakan) as iurbiaya';
        $criteria->group = 'namadepan, pendaftaran_id, ruangan_id, tgl_pendaftaran, no_rekam_medik, nama_pasien, nama_bin, jeniskelamin, umur, no_pendaftaran, jeniskasuspenyakit_nama, kelaspelayanan_nama, kelaspelayanan_id, carabayar_nama, penjamin_nama, penjamin_id, carabayar_id';

        if (is_array($this->penjamin_id)){
            $criteria->addInCondition('penjamin_id', $this->penjamin_id);
        }
		
		if (!empty($this->carabayar_id)){
			$criteria->addInCondition("carabayar_id", $this->carabayar_id);
		}
		
        if (is_array($this->kelaspelayanan_id)){
            $criteria->addInCondition('kelaspelayanan_id', $this->kelaspelayanan_id);
        }else{
            $criteria->addCondition('kelaspelayanan_id is null');
        }
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

        
        return $criteria;
    }
    
    public function getNamaModel(){
        return __CLASS__;
    }
}

?>

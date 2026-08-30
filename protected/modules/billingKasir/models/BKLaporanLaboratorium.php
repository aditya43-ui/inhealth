<?php
class BKLaporanLaboratorium extends LaporanbiayapelayananV {
    public $filter_tab;
    
    public function searchTable()
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
            )
        );
    }

    public function printRekapTable()
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
                'pagination' => false,
            )
        );
    }    
    
    public function searchDetailTable($id = null)
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        if(empty($id)){
			if(!empty($this->pendaftaran_id)){
				$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
			}
        }else{
            $criteria->addCondition('pendaftaran_id = '.$id);
        }
        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
                'pagination' => false,
            )
        );
    }
    
    public function printLapTransaksi()
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        $record = $this->model()->findAll($criteria);
        return $record;
    }
    
    public function searchTableGroup()
    {
        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        $criteria->select = 'no_rekam_medik, no_pendaftaran, nama_pasien, penjamin_nama, pendaftaran_id, sum(tarif_tindakan) AS tarif_tindakan, sum(subsidiasuransi_tindakan) AS subsidiasuransi_tindakan, sum(subsidipemerintah_tindakan) AS subsidipemerintah_tindakan, sum(subsisidirumahsakit_tindakan) AS subsisidirumahsakit_tindakan, sum(iurbiaya_tindakan) AS iurbiaya_tindakan';
        $criteria->group = 'no_pendaftaran, no_rekam_medik, nama_pasien, penjamin_nama, pendaftaran_id';
        $criteria->order = 'no_rekam_medik, nama_pasien, no_pendaftaran';
        return new CActiveDataProvider($this,
            array(
                'criteria' => $criteria,
            )
        );
    }    
    
    public function functionCriteria()
    {
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('DATE(tgl_tindakan)', $this->tgl_awal,$this->tgl_akhir);
            $criteria->compare('no_pendaftaran',  strtolower($this->no_pendaftaran), true);
            $criteria->compare('no_rekam_medik',$this->no_rekam_medik);
            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
			if(!empty($this->penjamin_id)){
				$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
			}
            $criteria->addCondition('ruangan_id = 18');
            return $criteria;
    }
    
    public function getNamaModel()
    {
        return __CLASS__;
    }
}
?>

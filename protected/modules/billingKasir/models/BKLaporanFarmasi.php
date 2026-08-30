<?php

class BKLaporanFarmasi extends LaporanpenjualanobatV {
    public $filter_tab;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /**
     * data provider untuk table
     */
    public function searchTable(){
        $criteria = $this->functionCriteria(true);
        $criteria->compare('no_pendaftaran',$this->no_pendaftaran);
        $criteria->compare('no_rekam_medik',$this->no_rekam_medik);
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
        $criteria->order = 'no_rekam_medik, no_pendaftaran, penjamin_id';
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    public function searchPrintTable(){
        $criteria = $this->functionCriteria(true);
        $criteria->compare('no_pendaftaran',$this->no_pendaftaran);
        $criteria->compare('no_rekam_medik',$this->no_rekam_medik);
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
        $criteria->order = 'no_rekam_medik, no_pendaftaran, penjamin_id';
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
    }
    
    public function searchTableDetail(){
        $criteria=new CDbCriteria;
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
                'pagination'=>false,
            )
        );
    }    
    
    public function searchGroupTable(){
        $criteria = $this->functionCriteria(true);
        $criteria->select = 'no_pendaftaran, no_rekam_medik, nama_pasien, instalasiasal_nama, ruanganasal_nama, penjamin_nama, tglpenjualan, penjamin_id, pendaftaran_id';
        $criteria->group = 'no_pendaftaran, no_rekam_medik, nama_pasien, instalasiasal_nama, ruanganasal_nama, penjamin_nama, tglpenjualan, penjamin_id, pendaftaran_id';
        $criteria->order = 'no_rekam_medik, no_pendaftaran, penjamin_id';
        $criteria->compare('no_pendaftaran',$this->no_pendaftaran);
        $criteria->compare('no_rekam_medik',$this->no_rekam_medik);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
        $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
    /**
     * method untuk criteria
     * @return CDbCriteria 
     */
    public function functionCriteria()
    {
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('tglpenjualan',$this->tgl_awal,$this->tgl_akhir);
            return $criteria;
    }
    
    /**
     * Method untuk mendapatkan nama Model
     * @return String 
     */
    public function getNamaModel(){
        return __CLASS__;
    }
    
}


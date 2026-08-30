<?php

class BKLaporanpembayaranpelayananV extends LaporanpembayaranpelayananV {
   
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination'=>false
                ));
    }

    public function searchGrafik() {
        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
        $criteria->select = 'count(pendaftaran_id) as jumlah, penjamin_nama as data';
        $criteria->group = 'penjamin_nama';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    protected function functionCriteria() {
        $criteria = new CDbCriteria();
        
        if (!is_array($this->ruangan_id)){
            $this->ruangan_id = 0;
        }
        
        if (!is_array($this->penjamin_id)){
            $this->penjamin_id = 0;
        }
        $criteria->addBetweenCondition('tglbuktibayar', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition('carabayar_id', $this->carabayar_id);
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addInCondition('penjamin_id ',$this->penjamin_id);
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->ruangan_id)){
			$criteria->addInCondition('ruangan_id ',$this->ruangan_id);
		}
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        return $criteria;
    }
    
    public function getNamaModel(){
        return __CLASS__;
    }
    
    public function primaryKey() {
        return 'pendaftaran_id';
    }
    
}
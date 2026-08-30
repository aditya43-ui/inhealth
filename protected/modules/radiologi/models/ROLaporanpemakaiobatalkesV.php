<?php

class ROLaporanpemakaiobatalkesV extends LaporanpemakaiobatalkesV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        
        return new CActiveDataProvider($this, array(
                    'pagination'=>false,
                    'criteria' => $criteria,
                ));
    }
    
    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        $criteria->select = 'count(obatalkes_id) as jumlah, obatalkes_nama as data, jenisobatalkes_nama as tick';
        $criteria->group = 'obatalkes_nama, jenisobatalkes_nama';
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $format = new MyFormatter();
        
        if (!is_array($this->jenisobatalkes_id)){
            $this->jenisobatalkes_id = 0;
		}
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('DATE(tglpelayanan)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition("obatalkes_id = ".$this->obatalkes_id);					
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addInCondition("jenisobatalkes_id",$this->jenisobatalkes_id);					
		}
        $criteria->compare('LOWER(jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
        $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
        $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition("satuankecil_id = ".$this->satuankecil_id);					
		}
        $criteria->compare('LOWER(satuankecil_nama)', strtolower($this->satuankecil_nama), true);
        $criteria->compare('LOWER(generik_nama)', strtolower($this->generik_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);					
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);					
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition("sumberdana_id = ".$this->sumberdana_id);					
		}
        $criteria->compare('LOWER(sumberdana_nama)', strtolower($this->sumberdana_nama), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('qty_oa', $this->qty_oa);
        $criteria->compare('hargasatuan_oa', $this->hargasatuan_oa);

        return $criteria;
    }

}

?>

<?php

class PJLaporanpemakaiobatalkesV extends LaporanpemakaiobatalkesV {

    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
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
        
        if (!is_array($this->jenisobatalkes_id)){
            $this->jenisobatalkes_id = 0;
        }
        $criteria->addBetweenCondition('DATE(tglpelayanan)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('obatalkes_id', $this->obatalkes_id);
        $criteria->compare('jenisobatalkes_id', $this->jenisobatalkes_id);
        $criteria->compare('LOWER(jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
        $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
        $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('satuankecil_id', $this->satuankecil_id);
        $criteria->compare('LOWER(satuankecil_nama)', strtolower($this->satuankecil_nama), true);
        $criteria->compare('LOWER(generik_nama)', strtolower($this->generik_nama), true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('sumberdana_id', $this->sumberdana_id);
        $criteria->compare('LOWER(sumberdana_nama)', strtolower($this->sumberdana_nama), true);
//        $criteria->compare('LOWER(tglpelayanan)', strtolower($this->tglpelayanan), true);
        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('qty_oa', $this->qty_oa);
        $criteria->compare('hargasatuan_oa', $this->hargasatuan_oa);

        return $criteria;
    }

}

?>

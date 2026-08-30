<?php

class BSObatalkesM extends ObatalkesM {

    public $satuankecil_nama, $jenisobatalkes_nama, $sumberdana_nama, $pendaftaran_id; //untuk pencarian

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ObatalkesM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * menampilkan data obat alkes untuk dialog
     * @return \CActiveDataProvider
     */
    public function searchDialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
                                JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
                                LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
                                ";
        if (!empty($this->obatalkes_id)) {
            $criteria->addCondition("obatalkes_id = " . $this->obatalkes_id);
        }
        if (!empty($this->sumberdana_id)) {
            $criteria->addCondition("t.sumberdana_id = " . $this->sumberdana_id);
        }
        if (!empty($this->satuankecil_id)) {
            $criteria->addCondition("t.satuankecil_id = " . $this->satuankecil_id);
        }
        if (!empty($this->jenisobatalkes_id)) {
            $criteria->addCondition("t.jenisobatalkes_id = " . $this->jenisobatalkes_id);
        }
        $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
        $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
        $criteria->compare('LOWER(tglkadaluarsa)', strtolower($this->tglkadaluarsa), true);
        $criteria->compare('LOWER(satuankecil_m.satuankecil_nama)', strtolower($this->satuankecil_nama), true);
        $criteria->compare('LOWER(sumberdana_m.sumberdana_nama)', strtolower($this->sumberdana_nama), true);
        $criteria->compare('LOWER(jenisobatalkes_m.jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
        $criteria->addCondition('obatalkes_aktif = TRUE');
        $criteria->order = 'obatalkes_nama ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * untuk dialog pilih obat alkes
     * @return type
     */
    public function getSatuanKecilNama() {
        return $this->satuankecil->satuankecil_nama;
    }

    public function searchObatPasienRuangan() {
        $criteria = new CDbCriteria;
        $criteria->join = "left JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
                                left JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
                                LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id 
                                ";
        $criteria->select = "t.*, jenisobatalkes_m.jenisobatalkes_nama";
        if (!empty($this->obatalkes_id)) {
            $criteria->addCondition("t.obatalkes_id = " . $this->obatalkes_id);
        }
        if (!empty($this->sumberdana_id)) {
            $criteria->addCondition("t.sumberdana_id = " . $this->sumberdana_id);
        }
        if (!empty($this->satuankecil_id)) {
            $criteria->addCondition("t.satuankecil_id = " . $this->satuankecil_id);
        }
        if (!empty($this->jenisobatalkes_id)) {
            $criteria->addCondition("t.jenisobatalkes_id = " . $this->jenisobatalkes_id);
        }
        $criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
        $criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
        $criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
        $criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
        $criteria->compare('LOWER(tglkadaluarsa)', strtolower($this->tglkadaluarsa), true);
        $criteria->compare('LOWER(satuankecil_m.satuankecil_nama)', strtolower($this->satuankecil_nama), true);
        $criteria->compare('LOWER(sumberdana_m.sumberdana_nama)', strtolower($this->sumberdana_nama), true);
        $criteria->compare('LOWER(jenisobatalkes_m.jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
        $criteria->addCondition('obatalkes_aktif = TRUE');
        $criteria->order = 'obatalkes_nama ASC';

        if (!empty($this->pendaftaran_id)) {
            $crOa = new CDbCriteria();
            $crOa->compare('pendaftaran_id', $this->pendaftaran_id);
            $crOa->compare('ruangan_id', $this->ruangan_id);
            $listOA = CHtml::listData(ObatalkespasienT::model()->findAll($crOa), 'obatalkes_id', 'obatalkes_id');
            $listOAres = array();

            foreach ($listOA as $item) {
                $listOAres[] = $item;
            }

            if (count((array)$listOAres) > 0) {
                $criteria->compare('t.obatalkes_id', 0);
            } else {
                $criteria->compare('t.obatalkes_id', $listOAres);
            }
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

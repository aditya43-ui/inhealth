<?php

class PSLaporansensuslabV extends LaporansensuslabV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();
        
//        $criteria->select = $

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

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'pagination' => false,
                    'criteria' => $criteria,
                ));
    }

    protected function functionCriteria() {
        $criteria = new CDbCriteria();
        
        $criteria->select = 'no_rekam_medik, no_masukpenunjang, tglmasukpenunjang, rt, rw, instalasiasal_nama, carabayar_nama, penjamin_nama, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, alamat_pasien, umur, ruanganasal_nama, pendaftaran_id';
        $criteria->group = 'no_rekam_medik, no_masukpenunjang, tglmasukpenunjang, rt, rw, instalasiasal_nama, carabayar_nama, penjamin_nama, no_pendaftaran, nama_pasien, nama_bin, jeniskelamin, alamat_pasien, umur, ruanganasal_nama, pendaftaran_id';
        
        if (!is_array($this->kunjungan)){
            $this->kunjungan = 0;
        }
        $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tglAwal, $this->tglAkhir);
        $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('kunjungan', $this->kunjungan);

        return $criteria;
    }

        public function getNamaModel(){
            return __CLASS__;
        }
}

?>

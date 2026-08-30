<?php

class RJLaporantindaklanjutrj extends LaporantindaklanjutrjV {

    public $jumlah;
    public $data;
    public $tick;
    public $tgl_awal;
    public $tgl_akhir;
    public $bln_awal;
    public $bln_akhir;
    public $thn_awal;
    public $thn_akhir;
    public $jns_periode;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTindakLanjut() {

        return array(
            'PULANG' => 'Pulang',
            'RAWAT INAP' => 'Rawat Inap',
            'RAWAT JALAN' => 'Rawat Jalan',
        );
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "pasienpulang_id, carakeluar, no_pendaftaran, no_rekam_medik, pendaftaran_id, namadepan, nama_pasien, umur, tgl_pendaftaran"; //, diagnosa_nama
        if (is_array($this->carakeluar)) {
            foreach ($this->carakeluar as $v) {
                if ($v == 'DIPULANGKAN') {
                    $criteria->addCondition('carakeluar is null', 'OR');
                } else {
                    $criteria->compare('LOWER(carakeluar)', strtolower($v), true, 'OR');
                }
            }
        } else {
            $criteria->addCondition('pasienpulang_id is not null');
            $criteria->addCondition('carakeluar is null');
        }
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->order = " tgl_pendaftaran ASC ";
        $criteria->group = "pasienpulang_id, carakeluar, no_pendaftaran, no_rekam_medik, pendaftaran_id, namadepan, nama_pasien, umur, tgl_pendaftaran"; //, diagnosa_nama
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (is_array($this->carakeluar)) {
            foreach ($this->carakeluar as $v) {
                if ($v == 'DIPULANGKAN') {
                    $criteria->addCondition('carakeluar is null', 'OR');
                } else {
                    $criteria->compare('LOWER(carakeluar)', strtolower($v), true, 'OR');
                }
            }
        } else {
            $criteria->addCondition('pasienpulang_id is not null');
            $criteria->addCondition('carakeluar is null');
        }

        $criteria->select = "count(pendaftaran_id) as jumlah, coalesce(carakeluar,'PULANG') as data";
        $criteria->group = 'carakeluar';

        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;        
        $criteria->select = "pasienpulang_id, carakeluar, no_pendaftaran, no_rekam_medik, pendaftaran_id, namadepan, nama_pasien, umur, tgl_pendaftaran"; //, diagnosa_nama
        if (is_array($this->carakeluar)) {
            foreach ($this->carakeluar as $v) {
                if ($v == 'DIPULANGKAN') {
                    $criteria->addCondition('carakeluar is null', 'OR');
                } else {
                    $criteria->compare('LOWER(carakeluar)', strtolower($v), true, 'OR');
                }
            }
        } else {
            $criteria->addCondition('pasienpulang_id is not null');
            $criteria->addCondition('carakeluar is null');
        }
        $criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->order = " tgl_pendaftaran ASC ";
        $criteria->group = "pasienpulang_id, carakeluar, no_pendaftaran, no_rekam_medik, pendaftaran_id, namadepan, nama_pasien, umur, tgl_pendaftaran"; //, diagnosa_nama
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    

}
<?php

class RILaporantindaklanjutri extends LaporantindaklanjutriV {

    public $jumlah;
    public $data;
    public $tick;
    public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;

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
        $criteria->select = "pasienpulang_id, carakeluar, no_pendaftaran, no_rekam_medik, pendaftaran_id, namadepan, nama_pasien, umur, tgl_pendaftaran, jeniskelamin, alamat_pasien, rt, rw, kelaspelayanan_nama, tglpasienpulang, kunjungan"; //, diagnosa_nama
        if (!empty($this->carakeluar)){
            if (is_array($this->carakeluar)) {
                foreach ($this->carakeluar as $v) {
                    if ($v == 'DIPULANGKAN') {
                        $criteria->compare('LOWER(carakeluar)', strtolower($v), true, 'OR');
                    } else {
                        $criteria->compare('LOWER(carakeluar)', strtolower($v), true, 'OR');
                    }
                }
            } else {
                $criteria->addCondition('pasienpulang_id is not null');
                $criteria->addCondition('carakeluar is null');
            }
        }
        $criteria->addBetweenCondition('tglpasienpulang', MyFormatter::formatDateTimeForDb(date("Y-m-d", strtotime($this->tgl_awal))).' 00:00:00', MyFormatter::formatDateTimeForDb(date("Y-m-d", strtotime($this->tgl_akhir))).' 23:59:59');
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->order = "tglpasienpulang ASC";
        $criteria->group = "pasienpulang_id, carakeluar, no_pendaftaran, no_rekam_medik, pendaftaran_id, namadepan, nama_pasien, umur, tgl_pendaftaran, jeniskelamin, alamat_pasien, rt, rw, kelaspelayanan_nama, tglpasienpulang, kunjungan"; //, diagnosa_nama
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        /*
        if (is_array($this->carakeluar)) {
            foreach ($this->carakeluar as $v) {
                if ($v == 'DIPULANGKAN') {
                    $criteria->compare('LOWER(carakeluar)', strtolower($v), true, 'OR');
                } else {
                    $criteria->compare('LOWER(carakeluar)', strtolower($v), true, 'OR');
                }
            }
        } else {
            $criteria->addCondition('pasienpulang_id is not null');
            $criteria->addCondition('carakeluar is null');
        }
         * 
         */

        $criteria->select = "count(pendaftaran_id) as jumlah, carakeluar as data";
        $criteria->group = 'carakeluar';

        $criteria->addBetweenCondition('tglpasienpulang', $this->tgl_awal, $this->tgl_akhir);
        
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

        // var_dump($criteria); die;
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = "pasienpulang_id, carakeluar, no_pendaftaran, no_rekam_medik, pendaftaran_id, namadepan, nama_pasien, umur, tgl_pendaftaran, jeniskelamin, alamat_pasien, rt, rw, kelaspelayanan_nama, tglpasienpulang, kunjungan"; //, diagnosa_nama
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
        $criteria->addBetweenCondition('tglpasienpulang', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        $criteria->order = "tglpasienpulang ASC";
        $criteria->group = "pasienpulang_id, carakeluar, no_pendaftaran, no_rekam_medik, pendaftaran_id, namadepan, nama_pasien, umur, tgl_pendaftaran, jeniskelamin, alamat_pasien, rt, rw, kelaspelayanan_nama, tglpasienpulang, kunjungan"; //, diagnosa_nama
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

}
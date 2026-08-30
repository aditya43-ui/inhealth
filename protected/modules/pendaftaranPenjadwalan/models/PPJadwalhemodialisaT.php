<?php

class PPJadwalhemodialisaT extends JadwalhemodialisaT {

    public $jadwalhemodialisa_tgl_ke_2;
    public $hari_nama, $nama_pasien;
    public $tgl_awal, $tgl_akhir, $no_rekam_medik;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchJadwalHD() {
        $criteria = new CDbCriteria;
//        $criteria->compare('DATE(jadwalhemodialisa_tgl_ke)', $this->jadwalhemodialisa_tgl_ke);
        $criteria->with = array('pasienrl');
        $criteria->addBetweenCondition('jadwalhemodialisa_tgl_ke', $this->tgl_awal, $this->tgl_akhir);

        if (!empty($this->shift_id)) {
            $criteria->addCondition('shift_id = ' . $this->shift_id);
        }
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        if (!empty($this->pasien_id)) {
            $criteria->addCondition('pasien_id = ' . $this->pasien_id);
        }
        $criteria->compare('LOWER(pasienrl.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(pasienrl.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->addCondition('bataljadwalhd_id is null');
        if (is_array($this->hari_nama)) {
            $criteria->addInCondition("jadwalhari_id", $this->hari_nama);
        } else {
            if (!empty($this->jadwalhari_id)) {
                $criteria->addCondition('jadwalhari_id = ' . $this->jadwalhari_id);
            }
        }
        $criteria->order = "jadwalhemodialisa_tgl_ke DESC, shift_id ASC";
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getJadwalHariItems() {
        return PPJadwalhariM::model()->findAll('jadwalhari_aktif=TRUE');
    }

    public function getShiftItems() {
        return ShiftM::model()->findAll('shift_aktif=TRUE ORDER BY shift_urutan');
    }

    public function getRuanganItems() {
        return PPRuanganhemodialisaV::model()->findAll();
    }

    public function getNamaRuangan() {
        return PPRuanganhemodialisaV::model()->findByAttributes(array('ruangan_id' => $this->ruangan_id))->ruangan_nama;
    }
    
    public function getDeskripsiUbah($gantijadwalhd_id) {
        $deskripsi = '';
        if(!empty($gantijadwalhd_id)){
            $modGantiJadwal = GantijadwalhdR::model()->findByPk($gantijadwalhd_id);
            $deskripsi = $modGantiJadwal->gantijadwalhd_desc;
        }
        return $deskripsi;
    }

}

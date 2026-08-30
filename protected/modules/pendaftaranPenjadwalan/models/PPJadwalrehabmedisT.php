<?php

class PPJadwalrehabmedisT extends JadwalrehabmedisT
{
    public $jadwalrehabmedis_tgl_ke_2;
    public $hari_nama, $nama_pasien;
    public $tgl_awal, $tgl_akhir, $no_rekam_medik;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsuransipasienM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function searchJadwalRH() {
        $criteria = new CDbCriteria;
//        $criteria->compare('DATE(jadwalhemodialisa_tgl_ke)', $this->jadwalhemodialisa_tgl_ke);
        $criteria->with = array('pasienrl');
        $criteria->addBetweenCondition('date(jadwalrehabmedis_tgl_ke)', $this->tgl_awal, $this->tgl_akhir);

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
        $criteria->addCondition('bataljadwalrh_id is null');
        if (is_array($this->hari_nama)) {
            $criteria->addInCondition("jadwalhari_id", $this->hari_nama);
        } else {
            if (!empty($this->jadwalhari_id)) {
                $criteria->addCondition('jadwalhari_id = ' . $this->jadwalhari_id);
            }
        }
        $criteria->order = "jadwalrehabmedis_tgl_ke DESC, shift_id ASC";
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
        return PPRuanganM::model()->findAllByAttributes(array(
            'instalasi_id'=>Params::INSTALASI_ID_REHAB,
            'ruangan_aktif'=>true
        ));
    }
    
    public function getNamaRuangan() {
        return PPRuanganM::model()->findByAttributes(array('ruangan_id' => $this->ruangan_id, 'ruangan_aktif'=>true))->ruangan_nama;
    }

}
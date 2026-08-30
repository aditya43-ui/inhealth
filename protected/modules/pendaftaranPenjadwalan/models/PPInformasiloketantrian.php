<?php

class PPInformasiloketantrian extends InformasiloketantrianV {

    public $tgl_awal,$tgl_akhir;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('DATE(tglantrian)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(loket_nama)', strtolower($this->loket_nama), true);
        $criteria->compare('LOWER(loket_fungsi)', strtolower($this->loket_fungsi), true);
		if(!empty($this->antrian_id)){
			$criteria->addCondition("antrian_id' = ".$this->antrian_id);			
		}
        $criteria->compare('LOWER(noantrian)', strtolower($this->noantrian), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('panggil_flaq', $this->panggil_flaq);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id' = ".$this->pendaftaran_id);			
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('LOWER(loket_nama)', strtolower($this->loket_nama), true);
        $criteria->compare('LOWER(loket_fungsi)', strtolower($this->loket_fungsi), true);
		if(!empty($this->antrian_id)){
			$criteria->addCondition("antrian_id' = ".$this->antrian_id);			
		}
        $criteria->compare('LOWER(tglantrian)', strtolower($this->tglantrian), true);
        $criteria->compare('LOWER(noantrian)', strtolower($this->noantrian), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('panggil_flaq', $this->panggil_flaq);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id' = ".$this->pendaftaran_id);			
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    public function getNamaModel() {
        return __CLASS__;
    }

}
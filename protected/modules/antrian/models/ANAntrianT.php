<?php

/**
 * This is the model class for table "antrian_t".
 *
 * The followings are the available columns in table 'antrian_t':
 * @property integer $antrian_id
 * @property integer $pendaftaran_id
 * @property integer $profilrs_id
 * @property integer $ruangan_id
 * @property string $tglantrian
 * @property string $noantrian
 * @property string $statuspasien
 * @property string $loket_antrian
 */
class ANAntrianT extends AntrianT
{
        public $jmlpasien; //untuk statistik antrian ke pendaftaran
        public $jmlmenunggu; //untuk statistik antrian ke pendaftaran
        public $jmlterdaftar; //untuk statistik antrian ke pendaftaran
        public $delaytombol;
        public $pegawai_id;
        public $lokasi_karcisantrian, $jml_panggil;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AntrianT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        public function criteriaSearch(){
            $criteria = new CDbCriteria();
            $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
            return $criteria;
        }
        /**
         * jumlah pasien
         * @return null
         */
        public function getJumlahPasien()
        {
            $criteria = $this->criteriaSearch();
            $criteria->compare("loket_id",$this->loket_id);
            $criteria->select = "count(noantrian) as jmlpasien";
            
            $record=self::model()->find($criteria);
            if(!empty($record))
                return $record->jmlpasien;
            return 0;
        }
        /**
         * jumlah menunggu
         * @return null
         */
        public function getJumlahMenunggu()
        {
            $criteria = $this->criteriaSearch();
            $criteria->addCondition("antrian_id > ".$this->antrian_id);
            $criteria->addCondition("pendaftaran_id IS NULL");
            $criteria->compare("loket_id",$this->loket_id);
            $criteria->select = "count(noantrian) as jmlpasien";

            $record=self::model()->find($criteria);
            if(!empty($record))
                return $record->jmlpasien;
            return 0;
        }
        /**
         * jumlah menunggu
         * @return null
         */
        public function getJumlahTerdaftar()
        {
            $criteria = $this->criteriaSearch();
            $criteria->addCondition("pendaftaran_id IS NOT NULL");
            $criteria->compare("loket_id",$this->loket_id);
            $criteria->select = "count(noantrian) as jmlpasien";
            
            $record=self::model()->find($criteria);
            if(!empty($record))
                return $record->jmlpasien;
            return 0;
        }

            /**
     * menampilkan lokasi_karcisantrian_m
     */
    public function getLokasiKarcisAntrian() {
        $data = array();
        $criteria = new CDbCriteria();
        $criteria->addCondition("lokasi_karcisantrian_aktif = TRUE");

        $criteria->order = "lokasi_karcisantrian_nama ASC";
        $modLokets = LokasiKarcisantrianM::model()->findAll($criteria);
        if (count($modLokets) > 0) {
            return $modLokets;
        } else {
            return array();
        }
    }

}
<?php
class MCAntrianT extends AntrianT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AntrianT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
	 * @return array validation rules for model attributes.
         * melepas elemen required
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruangan_id, carabayar_id, pendaftaran_id, profilrs_id, loket_id', 'numerical', 'integerOnly'=>true),
			array('noantrian', 'length', 'max'=>6),
			array('statuspasien, carabayar_loket', 'length', 'max'=>50),
			array('panggil_flaq', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('antrian_id, ruangan_id, carabayar_id, pendaftaran_id, profilrs_id, tglantrian, noantrian, statuspasien, carabayar_loket, panggil_flaq, loket_id', 'safe', 'on'=>'search'),
		);
	}
        
        public function criteriaSearch(){
            $criteria = new CDbCriteria();
            $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
            return $criteria;
        }
        /**
         * menentukan antrian berikutnya
         * @return null
         */
        public function getAntrianBerikut()
        {
            $criteria = $this->criteriaSearch();
            $criteria->addCondition("antrian_id > ".$this->antrian_id);
            $criteria->addCondition("pendaftaran_id IS NOT NULL");
			if(!empty($this->loket_id)){$criteria->addCondition("loket_id = ".$this->loket_id); }
            $criteria->order = "loket_id ASC, antrian_id ASC";
            $criteria->limit = 1;
            
            $record=self::model()->find($criteria);
            if($record!==null)
                return $record;
            return null;
        }
        /**
         * menentukan antrian sebelumnya
         * @return null
         */
        public function getAntrianSebelum()
        {
            $criteria = $this->criteriaSearch();
            $criteria->addCondition("antrian_id < ".$this->antrian_id);
            $criteria->addCondition("pendaftaran_id IS NOT NULL");
			$criteria->addCondition("loket_id = ".$this->loket_id);
            $criteria->order = "loket_id DESC, antrian_id DESC";
            $criteria->limit = 1;
            
            $record=self::model()->find($criteria);
            if($record!==null)
                return $record;
            return null;
        }
        
        /**
         * menampilkan loket antrian (loket_m)
         */
        public function getLokets($loket_id = null){
            $data = array();
            $criteria = new CDbCriteria();
            if (!empty($loket_id)){
                $criteria->addCondition("loket_id = ".$loket_id);
            }
            $criteria->addCondition("loket_aktif = TRUE");
            $criteria->order = "loket_nourut ASC";
            $modLokets = LoketM::model()->findAll($criteria);
            if(count((array)$modLokets) > 0){
                return $modLokets;
            }else{
                return array();
            }
        }

}
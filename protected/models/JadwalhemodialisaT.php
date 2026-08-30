<?php

/**
 * This is the model class for table "jadwalhemodialisa_t".
 *
 * The followings are the available columns in table 'jadwalhemodialisa_t':
 * @property integer $jadwalhemodialisa_id
 * @property integer $pasien_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property integer $jadwalhemodialisa_ke
 * @property string $jadwalhemodialisa_tgl_ke
 * @property string $jadwalhemodialisa_hari
 * @property string $jadwalhemodialisa_remark
 * @property integer $jadwalhemodialisa_lama_pel_jam
 * @property boolean $jadwalhemodialisa_status
 * @property string $jh_create_time
 * @property string $jh_update_time
 * @property integer $jh_create_loginid
 * @property integer $jh_update_loginid
 * @property integer $jh_create_ruanganid
 * @property string $jh_create_ruanganiphost
 */
class JadwalhemodialisaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JadwalhemodialisaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jadwalhemodialisa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, shift_id, ruangan_id, jadwalhemodialisa_ke, jadwalhemodialisa_tgl_ke, jadwalhemodialisa_hari', 'required'),
			array('shift_id, kamarruangan_id, ruangan_id, jadwalhari_id, pasien_id, pegawai_id, pendaftaran_id, jadwalhemodialisa_ke, jadwalhemodialisa_lama_pel_jam, jh_create_loginid, jh_update_loginid, jh_create_ruanganid', 'numerical', 'integerOnly'=>true),
			array('jadwalhemodialisa_hari', 'length', 'max'=>20),
			array('jadwalhemodialisa_remark, jh_create_ruanganiphost', 'length', 'max'=>100),
			array('jh_create_time, jh_update_time, kamarruangan_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jadwalhemodialisa_id, kamarruangan_id, shift_id, pasien_id, jadwalhari_id, ruangan_id, pegawai_id, pendaftaran_id, jadwalhemodialisa_ke, jadwalhemodialisa_tgl_ke, jadwalhemodialisa_hari, jadwalhemodialisa_remark, jadwalhemodialisa_lama_pel_jam, jadwalhemodialisa_status, jh_create_time, jh_update_time, jh_create_loginid, jh_update_loginid, jh_create_ruanganid, jh_create_ruanganiphost', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'shift'=>array(self::BELONGS_TO, 'ShiftM','shift_id'),
			'pasienrl'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
			'ruanganrl'=>array(self::BELONGS_TO, 'RuanganM','ruangan_id'),
			'kamarruangan'=>array(self::BELONGS_TO, 'KamarruanganM','kamarruangan_id'),
			'mengetahui'=>array(self::BELONGS_TO, 'LoginpemakaiK','mengetahui_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jadwalhemodialisa_id' => 'Jadwalhemodialisa',
			'gantijadwalhd_id'=>'gantijadwalhd id',
			'shift_id'=>'Shift',
			'pasien_id' => 'Pasien',
			'jadwalhari_id'=>'Hari',
			'bataljadwalhd_id'=>'bataljadwalhd id',
			'kamarruangan_id'=>'Kamar Ruangan',
			'pegawai_id' => 'Pegawai',
			'ruangan_id'=>'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'jadwalhemodialisa_ke' => 'Jadwalhemodialisa Ke',
			'jadwalhemodialisa_tgl_ke' => 'Tanggal',
			'jadwalhemodialisa_hari' => 'Jadwalhemodialisa Hari',
			'jadwalhemodialisa_remark' => 'Jadwalhemodialisa Remark',
			'jadwalhemodialisa_lama_pel_jam' => 'Jadwalhemodialisa Lama Pel Jam',
			'jadwalhemodialisa_status' => 'Jadwalhemodialisa Status',
			'membuat_id'=>'membuat id',
			'mengetahui_id'=>'mengetahui id',
			'jh_create_time' => 'Jh Create Time',
			'jh_update_time' => 'Jh Update Time',
			'jh_create_loginid' => 'Jh Create Loginid',
			'jh_update_loginid' => 'Jh Update Loginid',
			'jh_create_ruanganid' => 'Jh Create Ruanganid',
			'jh_create_ruanganiphost' => 'Jh Create Ruanganiphost',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->jadwalhemodialisa_id)){
			$criteria->addCondition('jadwalhemodialisa_id = '.$this->jadwalhemodialisa_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->jadwalhemodialisa_ke)){
			$criteria->addCondition('jadwalhemodialisa_ke = '.$this->jadwalhemodialisa_ke);
		}
		$criteria->compare('LOWER(jadwalhemodialisa_tgl_ke)',strtolower($this->jadwalhemodialisa_tgl_ke),true);
		$criteria->compare('LOWER(jadwalhemodialisa_hari)',strtolower($this->jadwalhemodialisa_hari),true);
		$criteria->compare('LOWER(jadwalhemodialisa_remark)',strtolower($this->jadwalhemodialisa_remark),true);
		if(!empty($this->jadwalhemodialisa_lama_pel_jam)){
			$criteria->addCondition('jadwalhemodialisa_lama_pel_jam = '.$this->jadwalhemodialisa_lama_pel_jam);
		}
		$criteria->compare('jadwalhemodialisa_status',$this->jadwalhemodialisa_status);
		$criteria->compare('LOWER(jh_create_time)',strtolower($this->jh_create_time),true);
		$criteria->compare('LOWER(jh_update_time)',strtolower($this->jh_update_time),true);
		if(!empty($this->jh_create_loginid)){
			$criteria->addCondition('jh_create_loginid = '.$this->jh_create_loginid);
		}
		if(!empty($this->jh_update_loginid)){
			$criteria->addCondition('jh_update_loginid = '.$this->jh_update_loginid);
		}
		if(!empty($this->jh_create_ruanganid)){
			$criteria->addCondition('jh_create_ruanganid = '.$this->jh_create_ruanganid);
		}
		$criteria->compare('LOWER(jh_create_ruanganiphost)',strtolower($this->jh_create_ruanganiphost),true);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
		
		public function searchPrintJadwalHD($data_limit)
        {
            $criteria=$this->criteriaSearch();
			$criteria->order = 'jadwalhemodialisa_id DESC';
			$criteria->limit=$data_limit;

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
				'pagination'=>false,
            ));
        }
}
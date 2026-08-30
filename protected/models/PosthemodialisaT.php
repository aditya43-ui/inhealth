<?php

/**
 * This is the model class for table "posthemodialisa_t".
 *
 * The followings are the available columns in table 'posthemodialisa_t':
 * @property integer $posthemodialisa_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $posthd_datasubyektif
 * @property string $posthd_dataobyektif
 * @property double $pemberiancairan_sisapriming
 * @property double $pemberiancairan_cairandrip
 * @property double $pemberiancairan_darah
 * @property double $pemberiancairan_washout
 * @property double $pemberiancairan_total
 * @property integer $posthd_tdsystolic
 * @property integer $posthd_tddiastolic
 * @property string $posthd_tekanandarah
 * @property integer $posthd_nadi
 * @property double $posthd_suhu
 * @property double $posthd_respirasi
 * @property double $posthd_bb_kg
 * @property double $pre_dialisis_bun
 * @property double $post_dialisis_bun
 * @property double $adekuasi_urr
 * @property double $adekuasi_kt_v
 * @property double $adekuasi_tbv
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PosthemodialisaperawatT[] $posthemodialisaperawatTs
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 */
class PosthemodialisaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PosthemodialisaT the static model class
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
		return 'posthemodialisa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id', 'required'),
			array('pasien_id, pendaftaran_id, pasienadmisi_id, posthd_tdsystolic, posthd_tddiastolic, posthd_nadi, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pemberiancairan_sisapriming, pemberiancairan_cairandrip, pemberiancairan_darah, pemberiancairan_washout, pemberiancairan_total, posthd_suhu, posthd_respirasi, posthd_bb_kg, pre_dialisis_bun, post_dialisis_bun, adekuasi_urr, adekuasi_kt_v, adekuasi_tbv', 'numerical'),
			array('posthd_tekanandarah', 'length', 'max'=>200),
			array('posthd_datasubyektif, posthd_dataobyektif, create_time, update_time', 'safe'),
            array('jenistransfusi_id, jmllabudarah, periksahd_penyulit, periksahd_penyulitlainnya, penyulit_teknis, penyulit_teknislainnya', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('posthemodialisa_id, pasien_id, pendaftaran_id, pasienadmisi_id, posthd_datasubyektif, posthd_dataobyektif, pemberiancairan_sisapriming, pemberiancairan_cairandrip, pemberiancairan_darah, pemberiancairan_washout, pemberiancairan_total, posthd_tdsystolic, posthd_tddiastolic, posthd_tekanandarah, posthd_nadi, posthd_suhu, posthd_respirasi, posthd_bb_kg, pre_dialisis_bun, post_dialisis_bun, adekuasi_urr, adekuasi_kt_v, adekuasi_tbv, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'posthemodialisaperawatTs' => array(self::HAS_MANY, 'PosthemodialisaperawatT', 'posthemodialisa_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'posthemodialisa_id' => 'Posthemodialisa',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'posthd_datasubyektif' => 'Data Subyektif',
			'posthd_dataobyektif' => 'Data Obyektif',
			'pemberiancairan_sisapriming' => 'Sisa Priming',
			'pemberiancairan_cairandrip' => 'Cairan Drip',
			'pemberiancairan_darah' => 'Darah',
			'pemberiancairan_washout' => 'Washout',
			'pemberiancairan_total' => 'Total',
			'posthd_tdsystolic' => 'Tensi',
			'posthd_tddiastolic' => 'Posthd Tddiastolic',
			'posthd_tekanandarah' => 'Posthd Tekanandarah',
			'posthd_nadi' => 'Nadi',
			'posthd_suhu' => 'Suhu',
			'posthd_respirasi' => 'Respirasi',
			'posthd_bb_kg' => 'BB',
			'pre_dialisis_bun' => 'Predialisis BUN',
			'post_dialisis_bun' => 'Postdialisis BUN',
			'adekuasi_urr' => 'Urea Reduction Ratio',
			'adekuasi_kt_v' => 'Kt/V',
			'adekuasi_tbv' => 'TBV',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
            'periksahd_penyulit' => 'Klinis',
            'penyulit_teknis' => 'Teknis',
            'jenistransfusi_id' => 'Jenis Transfusi Darah',
            'jmllabudarah' => 'Jumlah Labu',
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

		if(!empty($this->posthemodialisa_id)){
			$criteria->addCondition('posthemodialisa_id = '.$this->posthemodialisa_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition('pasienadmisi_id = '.$this->pasienadmisi_id);
		}
		$criteria->compare('LOWER(posthd_datasubyektif)',strtolower($this->posthd_datasubyektif),true);
		$criteria->compare('LOWER(posthd_dataobyektif)',strtolower($this->posthd_dataobyektif),true);
		$criteria->compare('pemberiancairan_sisapriming',$this->pemberiancairan_sisapriming);
		$criteria->compare('pemberiancairan_cairandrip',$this->pemberiancairan_cairandrip);
		$criteria->compare('pemberiancairan_darah',$this->pemberiancairan_darah);
		$criteria->compare('pemberiancairan_washout',$this->pemberiancairan_washout);
		$criteria->compare('pemberiancairan_total',$this->pemberiancairan_total);
		if(!empty($this->posthd_tdsystolic)){
			$criteria->addCondition('posthd_tdsystolic = '.$this->posthd_tdsystolic);
		}
		if(!empty($this->posthd_tddiastolic)){
			$criteria->addCondition('posthd_tddiastolic = '.$this->posthd_tddiastolic);
		}
		$criteria->compare('LOWER(posthd_tekanandarah)',strtolower($this->posthd_tekanandarah),true);
		if(!empty($this->posthd_nadi)){
			$criteria->addCondition('posthd_nadi = '.$this->posthd_nadi);
		}
		$criteria->compare('posthd_suhu',$this->posthd_suhu);
		$criteria->compare('posthd_respirasi',$this->posthd_respirasi);
		$criteria->compare('posthd_bb_kg',$this->posthd_bb_kg);
		$criteria->compare('pre_dialisis_bun',$this->pre_dialisis_bun);
		$criteria->compare('post_dialisis_bun',$this->post_dialisis_bun);
		$criteria->compare('adekuasi_urr',$this->adekuasi_urr);
		$criteria->compare('adekuasi_kt_v',$this->adekuasi_kt_v);
		$criteria->compare('adekuasi_tbv',$this->adekuasi_tbv);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

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
}
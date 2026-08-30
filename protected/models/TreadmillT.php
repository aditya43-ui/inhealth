<?php

/**
 * This is the model class for table "treadmill_t".
 *
 * The followings are the available columns in table 'treadmill_t':
 * @property integer $treadmill_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property string $tgltreadmill
 * @property string $resttime_menit
 * @property string $worktime_menit
 * @property string $recoverytime_menit
 * @property string $totaltime_menit
 * @property string $interpretation_tradmill
 * @property string $hasiltreadmill
 * @property string $namapemeriksa_treadmill
 * @property string $tingkatkebugaran
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class TreadmillT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TreadmillT the static model class
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
		return 'treadmill_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, ruangan_id, tgltreadmill, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, ruangan_id, pendaftaran_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('interpretation_tradmill', 'length', 'max'=>200),
			array('hasiltreadmill, tingkatkebugaran', 'length', 'max'=>20),
			array('namapemeriksa_treadmill', 'length', 'max'=>150),
			array('resttime_menit, worktime_menit, recoverytime_menit, totaltime_menit, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('treadmill_id, pasien_id, ruangan_id, pendaftaran_id, pegawai_id, tgltreadmill, resttime_menit, worktime_menit, recoverytime_menit, totaltime_menit, interpretation_tradmill, hasiltreadmill, namapemeriksa_treadmill, tingkatkebugaran, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
			'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
			'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'treadmill_id' => 'Treadmill',
			'pasien_id' => 'Pasien',
			'ruangan_id' => 'Ruangan',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Pegawai',
			'tgltreadmill' => 'Tgl. Treadmill',
			'resttime_menit' => 'Rest Time',
			'worktime_menit' => 'Work Time',
			'recoverytime_menit' => 'Recovery Time',
			'totaltime_menit' => 'Total TIme',
			'interpretation_tradmill' => 'Interpretation',
			'hasiltreadmill' => 'Hasil Treadmill',
			'namapemeriksa_treadmill' => 'Pemeriksa',
			'tingkatkebugaran' => 'Tingkat Kebugaran',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		if(!empty($this->treadmill_id)){
			$criteria->addCondition('treadmill_id = '.$this->treadmill_id);
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(tgltreadmill)',strtolower($this->tgltreadmill),true);
		$criteria->compare('LOWER(resttime_menit)',strtolower($this->resttime_menit),true);
		$criteria->compare('LOWER(worktime_menit)',strtolower($this->worktime_menit),true);
		$criteria->compare('LOWER(recoverytime_menit)',strtolower($this->recoverytime_menit),true);
		$criteria->compare('LOWER(totaltime_menit)',strtolower($this->totaltime_menit),true);
		$criteria->compare('LOWER(interpretation_tradmill)',strtolower($this->interpretation_tradmill),true);
		$criteria->compare('LOWER(hasiltreadmill)',strtolower($this->hasiltreadmill),true);
		$criteria->compare('LOWER(namapemeriksa_treadmill)',strtolower($this->namapemeriksa_treadmill),true);
		$criteria->compare('LOWER(tingkatkebugaran)',strtolower($this->tingkatkebugaran),true);
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
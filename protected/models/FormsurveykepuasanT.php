<?php

/**
 * This is the model class for table "formsurveykepuasan_t".
 * @author Rusdiyanto <Rusdiyanto@.com>
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @category RSST-8538 Improvment
 * @package application.models
 * The followings are the available columns in table 'formsurveykepuasan_t':
 * @property integer $formsurveykepuasan_id
 * @property string $tanggal_survey
 * @property integer $jenisformsurvey_id
 * @property integer $unitkerja_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property integer $totalbobot_quisioner
 * @property integer $totalbobot_responden
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class FormsurveykepuasanT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsurveykepuasanT the static model class
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
		return 'formsurveykepuasan_t';
	}
        
        public $usulanpelatihan, $usulanfasilitas, $usulanlainlain;
        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisformsurvey_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('jenisformsurvey_id, unitkerja_id, pegawai_id, ruangan_id, totalbobot_quisioner, totalbobot_responden, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tanggal_survey, update_time, usulanpelatihan, usulanfasilitas, usulanlainlain', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formsurveykepuasan_id, tanggal_survey, jenisformsurvey_id, unitkerja_id, pegawai_id, ruangan_id, totalbobot_quisioner, totalbobot_responden, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
                    'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_id')
                    
                );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'formsurveykepuasan_id' => 'Formsurveykepuasan',
			'tanggal_survey' => 'Tanggal Survey',
			'jenisformsurvey_id' => 'Jenisformsurvey',
			'unitkerja_id' => 'Unitkerja',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'totalbobot_quisioner' => 'Totalbobot Quisioner',
			'totalbobot_responden' => 'Totalbobot Responden',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		if(!empty($this->formsurveykepuasan_id)){
			$criteria->addCondition('formsurveykepuasan_id = '.$this->formsurveykepuasan_id);
		}
		$criteria->compare('LOWER(tanggal_survey)',strtolower($this->tanggal_survey),true);
		if(!empty($this->jenisformsurvey_id)){
			$criteria->addCondition('jenisformsurvey_id = '.$this->jenisformsurvey_id);
		}
		if(!empty($this->unitkerja_id)){
			$criteria->addCondition('unitkerja_id = '.$this->unitkerja_id);
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		if(!empty($this->totalbobot_quisioner)){
			$criteria->addCondition('totalbobot_quisioner = '.$this->totalbobot_quisioner);
		}
		if(!empty($this->totalbobot_responden)){
			$criteria->addCondition('totalbobot_responden = '.$this->totalbobot_responden);
		}
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

        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
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
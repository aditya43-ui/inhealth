<?php

/**
 * This is the model class for table "monitoringsterilisasi_t".
 *
 * The followings are the available columns in table 'monitoringsterilisasi_t':
 * @property integer $monitoringsterilisasi_id
 * @property integer $sterilisasi_id
 * @property string $tlgmonitoringsterilisasi
 * @property string $jenisindbiologi
 * @property string $tglujikontrol
 * @property string $hasilujikontrol
 * @property string $nolubanguji
 * @property string $lubangujikontrol
 * @property string $ind_biologiuji
 * @property string $ind_biologikontrol
 * @property integer $petugasmonitoring_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SterilisasiT $sterilisasi
 */
class MonitoringsterilisasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MonitoringsterilisasiT the static model class
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
		return 'monitoringsterilisasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sterilisasi_id, tlgmonitoringsterilisasi, jenisindbiologi, tglujikontrol, hasilujikontrol, petugasmonitoring_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('sterilisasi_id, petugasmonitoring_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jenisindbiologi, nolubanguji', 'length', 'max'=>50),
			array('hasilujikontrol, lubangujikontrol, ind_biologiuji, ind_biologikontrol', 'length', 'max'=>10),
			array('update_time,tgl_inkubasi,jenissterilisasi_id,mesin_id,siklus', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('monitoringsterilisasi_id, sterilisasi_id, tlgmonitoringsterilisasi, jenisindbiologi, tglujikontrol, hasilujikontrol, nolubanguji, lubangujikontrol, ind_biologiuji, ind_biologikontrol, petugasmonitoring_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'sterilisasi' => array(self::BELONGS_TO, 'SterilisasiT', 'sterilisasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'monitoringsterilisasi_id' => 'Monitoringsterilisasi',
			'sterilisasi_id' => 'Sterilisasi',
			'tlgmonitoringsterilisasi' => 'Tlgmonitoringsterilisasi',
			'jenisindbiologi' => 'Jenisindbiologi',
			'tglujikontrol' => 'Tglujikontrol',
			'hasilujikontrol' => 'Hasilujikontrol',
			'nolubanguji' => 'Nolubanguji',
			'lubangujikontrol' => 'Lubangujikontrol',
			'ind_biologiuji' => 'Ind Biologiuji',
			'ind_biologikontrol' => 'Ind Biologikontrol',
			'petugasmonitoring_id' => 'Petugasmonitoring',
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

		if(!empty($this->monitoringsterilisasi_id)){
			$criteria->addCondition('monitoringsterilisasi_id = '.$this->monitoringsterilisasi_id);
		}
		if(!empty($this->sterilisasi_id)){
			$criteria->addCondition('sterilisasi_id = '.$this->sterilisasi_id);
		}
		$criteria->compare('LOWER(tlgmonitoringsterilisasi)',strtolower($this->tlgmonitoringsterilisasi),true);
		$criteria->compare('LOWER(jenisindbiologi)',strtolower($this->jenisindbiologi),true);
		$criteria->compare('LOWER(tglujikontrol)',strtolower($this->tglujikontrol),true);
		$criteria->compare('LOWER(hasilujikontrol)',strtolower($this->hasilujikontrol),true);
		$criteria->compare('LOWER(nolubanguji)',strtolower($this->nolubanguji),true);
		$criteria->compare('LOWER(lubangujikontrol)',strtolower($this->lubangujikontrol),true);
		$criteria->compare('LOWER(ind_biologiuji)',strtolower($this->ind_biologiuji),true);
		$criteria->compare('LOWER(ind_biologikontrol)',strtolower($this->ind_biologikontrol),true);
		if(!empty($this->petugasmonitoring_id)){
			$criteria->addCondition('petugasmonitoring_id = '.$this->petugasmonitoring_id);
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
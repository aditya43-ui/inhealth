<?php

/**
 * This is the model class for table "hasilindikator_t".
 *
 * The followings are the available columns in table 'hasilindikator_t':
 * @property integer $hasilindikator_id
 * @property integer $sterilisasi_id
 * @property string $indikator_hslkimia_1
 * @property string $indikator_hslkimia_2
 * @property string $indikator_hslkimia_3
 * @property string $indikator_hslkimia_4
 * @property string $indikator_hslkimia_5
 * @property string $batch_monitoring
 * @property string $bowie_dick
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SterilisasiT $sterilisasi
 */
class HasilindikatorT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HasilindikatorT the static model class
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
		return 'hasilindikator_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sterilisasi_id, indikator_hslkimia_1, indikator_hslkimia_4, indikator_hslkimia_5, batch_monitoring, bowie_dick, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('sterilisasi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('indikator_hslkimia_1, indikator_hslkimia_2, indikator_hslkimia_3, indikator_hslkimia_4, indikator_hslkimia_5, batch_monitoring, bowie_dick', 'length', 'max'=>10),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hasilindikator_id, sterilisasi_id, indikator_hslkimia_1, indikator_hslkimia_2, indikator_hslkimia_3, indikator_hslkimia_4, indikator_hslkimia_5, batch_monitoring, bowie_dick, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'hasilindikator_id' => 'Hasilindikator',
			'sterilisasi_id' => 'Sterilisasi',
			'indikator_hslkimia_1' => 'Indikator Hslkimia 1',
			'indikator_hslkimia_2' => 'Indikator Hslkimia 2',
			'indikator_hslkimia_3' => 'Indikator Hslkimia 3',
			'indikator_hslkimia_4' => 'Indikator Hslkimia 4',
			'indikator_hslkimia_5' => 'Indikator Hslkimia 5',
			'batch_monitoring' => 'Batch Monitoring',
			'bowie_dick' => 'Bowie Dick',
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

		if(!empty($this->hasilindikator_id)){
			$criteria->addCondition('hasilindikator_id = '.$this->hasilindikator_id);
		}
		if(!empty($this->sterilisasi_id)){
			$criteria->addCondition('sterilisasi_id = '.$this->sterilisasi_id);
		}
		$criteria->compare('LOWER(indikator_hslkimia_1)',strtolower($this->indikator_hslkimia_1),true);
		$criteria->compare('LOWER(indikator_hslkimia_2)',strtolower($this->indikator_hslkimia_2),true);
		$criteria->compare('LOWER(indikator_hslkimia_3)',strtolower($this->indikator_hslkimia_3),true);
		$criteria->compare('LOWER(indikator_hslkimia_4)',strtolower($this->indikator_hslkimia_4),true);
		$criteria->compare('LOWER(indikator_hslkimia_5)',strtolower($this->indikator_hslkimia_5),true);
		$criteria->compare('LOWER(batch_monitoring)',strtolower($this->batch_monitoring),true);
		$criteria->compare('LOWER(bowie_dick)',strtolower($this->bowie_dick),true);
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
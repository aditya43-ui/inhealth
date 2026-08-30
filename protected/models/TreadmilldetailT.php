<?php

/**
 * This is the model class for table "treadmilldetail_t".
 *
 * The followings are the available columns in table 'treadmilldetail_t':
 * @property integer $treadmilldetail_id
 * @property integer $treadmill_id
 * @property string $age_elev
 * @property string $duration_treadmill
 * @property string $workload_kph
 * @property string $est02_rate_min
 * @property string $max02_intake
 * @property string $mets_treadmill
 * @property integer $td_systolic
 * @property integer $td_diastolic
 * @property string $heartrate_treadmill
 * @property string $fitnessclassification
 * @property string $functional_class_treadmill
 * @property string $walking_kmhr_treadmill
 * @property string $jogging_kmhr_treadmill
 * @property string $bicycling_kmhr_treadmill
 * @property string $sports_kmhr_treadmill
 */
class TreadmilldetailT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TreadmilldetailT the static model class
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
		return 'treadmilldetail_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('treadmill_id, age_elev, duration_treadmill, mets_treadmill, td_systolic, td_diastolic, heartrate_treadmill', 'required'),
			array('treadmill_id, td_systolic, td_diastolic', 'numerical', 'integerOnly'=>true),
			array('age_elev, walking_kmhr_treadmill, jogging_kmhr_treadmill, bicycling_kmhr_treadmill', 'length', 'max'=>50),
			array('fitnessclassification', 'length', 'max'=>10),
			array('functional_class_treadmill', 'length', 'max'=>5),
			array('workload_kph, est02_rate_min, max02_intake, sports_kmhr_treadmill', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('treadmilldetail_id, treadmill_id, age_elev, duration_treadmill, workload_kph, est02_rate_min, max02_intake, mets_treadmill, td_systolic, td_diastolic, heartrate_treadmill, fitnessclassification, functional_class_treadmill, walking_kmhr_treadmill, jogging_kmhr_treadmill, bicycling_kmhr_treadmill, sports_kmhr_treadmill', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'treadmilldetail_id' => 'Treadmilldetail',
			'treadmill_id' => 'Treadmill',
			'age_elev' => 'Age Elev',
			'duration_treadmill' => 'Duration Treadmill',
			'workload_kph' => 'Workload Kph',
			'est02_rate_min' => 'Est02 Rate Min',
			'max02_intake' => 'Max02 Intake',
			'mets_treadmill' => 'Mets Treadmill',
			'td_systolic' => 'Td Systolic',
			'td_diastolic' => 'Td Diastolic',
			'heartrate_treadmill' => 'Heartrate Treadmill',
			'fitnessclassification' => 'Fitnessclassification',
			'functional_class_treadmill' => 'Functional Class Treadmill',
			'walking_kmhr_treadmill' => 'Walking Kmhr Treadmill',
			'jogging_kmhr_treadmill' => 'Jogging Kmhr Treadmill',
			'bicycling_kmhr_treadmill' => 'Bicycling Kmhr Treadmill',
			'sports_kmhr_treadmill' => 'Sports Kmhr Treadmill',
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

		if(!empty($this->treadmilldetail_id)){
			$criteria->addCondition('treadmilldetail_id = '.$this->treadmilldetail_id);
		}
		if(!empty($this->treadmill_id)){
			$criteria->addCondition('treadmill_id = '.$this->treadmill_id);
		}
		$criteria->compare('LOWER(age_elev)',strtolower($this->age_elev),true);
		$criteria->compare('LOWER(duration_treadmill)',strtolower($this->duration_treadmill),true);
		$criteria->compare('LOWER(workload_kph)',strtolower($this->workload_kph),true);
		$criteria->compare('LOWER(est02_rate_min)',strtolower($this->est02_rate_min),true);
		$criteria->compare('LOWER(max02_intake)',strtolower($this->max02_intake),true);
		$criteria->compare('LOWER(mets_treadmill)',strtolower($this->mets_treadmill),true);
		if(!empty($this->td_systolic)){
			$criteria->addCondition('td_systolic = '.$this->td_systolic);
		}
		if(!empty($this->td_diastolic)){
			$criteria->addCondition('td_diastolic = '.$this->td_diastolic);
		}
		$criteria->compare('LOWER(heartrate_treadmill)',strtolower($this->heartrate_treadmill),true);
		$criteria->compare('LOWER(fitnessclassification)',strtolower($this->fitnessclassification),true);
		$criteria->compare('LOWER(functional_class_treadmill)',strtolower($this->functional_class_treadmill),true);
		$criteria->compare('LOWER(walking_kmhr_treadmill)',strtolower($this->walking_kmhr_treadmill),true);
		$criteria->compare('LOWER(jogging_kmhr_treadmill)',strtolower($this->jogging_kmhr_treadmill),true);
		$criteria->compare('LOWER(bicycling_kmhr_treadmill)',strtolower($this->bicycling_kmhr_treadmill),true);
		$criteria->compare('LOWER(sports_kmhr_treadmill)',strtolower($this->sports_kmhr_treadmill),true);

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
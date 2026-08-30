<?php

/**
 * This is the model class for table "klasifikasifitnes_m".
 *
 * The followings are the available columns in table 'klasifikasifitnes_m':
 * @property integer $klasifikasifitnes_id
 * @property string $age_elev
 * @property string $lama_menit
 * @property string $workload_kph
 * @property string $estimasirate
 * @property string $max_intake
 * @property integer $umur_min
 * @property integer $umur_maks
 * @property string $mets
 * @property string $klasifikasifitnes
 * @property string $functional_class
 * @property string $walking_kmhr
 * @property string $jogging_kmhr
 * @property string $bicycling_kmhr
 * @property string $other_sports
 * @property boolean $klasifikasifitnes_aktif
 */
class KlasifikasifitnesM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KlasifikasifitnesM the static model class
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
		return 'klasifikasifitnes_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('age_elev, lama_menit, umur_min, umur_maks, klasifikasifitnes, functional_class, jeniskelamin', 'required'),
			array('umur_min, umur_maks', 'numerical', 'integerOnly'=>true),
			array('age_elev, klasifikasifitnes, walking_kmhr, jogging_kmhr, bicycling_kmhr', 'length', 'max'=>50),
			array('functional_class', 'length', 'max'=>5),
			array('workload_kph, estimasirate, max_intake, mets, other_sports, klasifikasifitnes_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('klasifikasifitnes_id, age_elev, lama_menit, workload_kph, estimasirate, max_intake, umur_min, umur_maks, mets, klasifikasifitnes, functional_class, walking_kmhr, jogging_kmhr, bicycling_kmhr, other_sports, klasifikasifitnes_aktif, jeniskelamin', 'safe', 'on'=>'search'),
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
			'klasifikasifitnes_id' => 'ID',
			'age_elev' => 'Age Elev',
			'lama_menit' => 'Duration (min)',
			'workload_kph' => 'Work Load (Kph)',
			'estimasirate' => 'Estimate 02 1/min',
			'max_intake' => 'Max 02 Intake ml/kg/min',
			'umur_min' => 'Umur Minimal',
			'umur_maks' => 'Umur Maksimal',
			'mets' => 'Mets',
			'klasifikasifitnes' => 'Klasifikasi Fitnes',
			'functional_class' => 'Functional Class',
			'walking_kmhr' => 'Walking Km/Hr',
			'jogging_kmhr' => 'Jogging Km/Hr',
			'bicycling_kmhr' => 'Bicycling Km/Hr',
			'other_sports' => 'Other Sports',
			'klasifikasifitnes_aktif' => 'Status Aktif',
			'jeniskelamin' => 'Jenis Kelamin',
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

		if(!empty($this->klasifikasifitnes_id)){
			$criteria->addCondition('klasifikasifitnes_id = '.$this->klasifikasifitnes_id);
		}
		$criteria->compare('LOWER(age_elev)',strtolower($this->age_elev),true);
		//$criteria->compare('LOWER(lama_menit)',strtolower($this->lama_menit),true);
		if(!empty($this->lama_menit)){
			$criteria->addCondition('lama_menit = '.$this->lama_menit);
		}
		//$criteria->compare('LOWER(workload_kph)',strtolower($this->workload_kph),true);
		if(!empty($this->workload_kph)){
			$criteria->addCondition('workload_kph= '.$this->workload_kph);
		}
		//$criteria->compare('LOWER(estimasirate)',strtolower($this->estimasirate),true);
		if(!empty($this->estimasirate)){
			$criteria->addCondition('estimasirate= '.$this->estimasirate);
		}
		//$criteria->compare('LOWER(max_intake)',strtolower($this->max_intake),true);
		if(!empty($this->max_intake)){
			$criteria->addCondition('max_intake= '.$this->max_intake);
		}
		if(!empty($this->umur_min)){
			$criteria->addCondition('umur_min = '.$this->umur_min);
		}
		if(!empty($this->umur_maks)){
			$criteria->addCondition('umur_maks = '.$this->umur_maks);
		}
		//$criteria->compare('LOWER(mets)',strtolower($this->mets),true);
		if(!empty($this->mets)){
			$criteria->addCondition('mets = '.$this->mets);
		}
		$criteria->compare('LOWER(klasifikasifitnes)',strtolower($this->klasifikasifitnes),true);
		$criteria->compare('LOWER(functional_class)',strtolower($this->functional_class),true);
	    $criteria->compare('LOWER(walking_kmhr)',strtolower($this->walking_kmhr),true);
		$criteria->compare('LOWER(jogging_kmhr)',strtolower($this->jogging_kmhr),true);
		$criteria->compare('LOWER(bicycling_kmhr)',strtolower($this->bicycling_kmhr),true);
		$criteria->compare('LOWER(other_sports)',strtolower($this->other_sports),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		if(!empty($this->klasifikasifitnes_aktif)){
			$criteria->addCondition('klasifikasifitnes_aktif = '.$this->klasifikasifitnes_aktif);
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
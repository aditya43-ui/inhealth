<?php

/**
 * This is the model class for table "therapimapobat_m".
 *
 * The followings are the available columns in table 'therapimapobat_m':
 * @property integer $therapiobat_id
 * @property integer $obatalkes_id
 */
class TherapimapobatM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TherapimapobatM the static model class
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
		return 'therapimapobat_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('therapiobat_id, obatalkes_id', 'required'),
			array('therapiobat_id, obatalkes_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('therapiobat_id, obatalkes_id', 'safe', 'on'=>'search'),
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
			'therapiobat' => array(self::BELONGS_TO, 'TherapiobatM', 'therapiobat_id'),
			'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'therapiobat_id' => 'Therapiobat',
			'obatalkes_id' => 'Obatalkes',
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

		if(!empty($this->therapiobat_id)){
			$criteria->addCondition('therapiobat_id = '.$this->therapiobat_id);
		}
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
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

            //$criteria=$this->criteriaSearch();
            $criteria=new CDbCriteria;
            $criteria->with = array('obatalkes','therapiobat');
            if(!empty($this->therapiobat_id)){
                    $criteria->addCondition('therapiobat.therapiobat_id = '.$this->therapiobat_id);
            }
            if(!empty($this->obatalkes_id)){
                    $criteria->addCondition('obatalkes.obatalkes_id = '.$this->obatalkes_id);
            }
            $criteria->compare('LOWER(obatalkes.obatalkes_nama)',  strtolower($this->obatalkes_nama),true);
            $criteria->compare('LOWER(therapiobat.therapiobat_nama)',  strtolower($this->therapiobat_nama),true); 		
            $criteria->addCondition('therapiobat.therapiobat_aktif is TRUE');
            $criteria->addCondition('obatalkes.obatalkes_aktif is TRUE');
            $criteria->order="therapiobat.therapiobat_nama ASC";
				
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
}
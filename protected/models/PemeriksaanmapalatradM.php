<?php

/**
 * This is the model class for table "pemeriksaanmapalatrad_m".
 *
 * The followings are the available columns in table 'pemeriksaanmapalatrad_m':
 * @property integer $pemeriksaanalatrad_id
 * @property integer $pemeriksaanrad_id
 */
class PemeriksaanmapalatradM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanmapalatradM the static model class
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
		return 'pemeriksaanmapalatrad_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanalatrad_id, pemeriksaanrad_id', 'required'),
			array('pemeriksaanalatrad_id, pemeriksaanrad_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanalatrad_id, pemeriksaanrad_id', 'safe', 'on'=>'search'),
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
			'pemeriksaanrad' => array(self::BELONGS_TO, 'PemeriksaanradM', 'pemeriksaanrad_id'),
			'pemeriksaanalatrad' => array(self::BELONGS_TO, 'PemeriksaanalatradM', 'pemeriksaanalatrad_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanalatrad_id' => 'Pemeriksaanalatrad',
			'pemeriksaanrad_id' => 'Pemeriksaanrad',
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

		if(!empty($this->pemeriksaanalatrad_id)){
			$criteria->addCondition('pemeriksaanalatrad_id = '.$this->pemeriksaanalatrad_id);
		}
		if(!empty($this->pemeriksaanrad_id)){
			$criteria->addCondition('pemeriksaanrad_id = '.$this->pemeriksaanrad_id);
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
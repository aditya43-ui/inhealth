<?php

/**
 * This is the model class for table "pemeriksaanlabmapping_m".
 *
 * The followings are the available columns in table 'pemeriksaanlabmapping_m':
 * @property integer $pemeriksaanlabalat_id
 * @property integer $nilairujukan_id
 */
class PemeriksaanlabmappingM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanlabmappingM the static model class
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
		return 'pemeriksaanlabmapping_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pemeriksaanlabalat_id, nilairujukan_id', 'required'),
			array('pemeriksaanlabalat_id, nilairujukan_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanlabalat_id, nilairujukan_id', 'safe', 'on'=>'search'),
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
			'pemeriksaanlabalat' => array(self::BELONGS_TO, 'PemeriksaanlabalatM', 'pemeriksaanlabalat_id'),
			'nilairujukan' => array(self::BELONGS_TO, 'NilairujukanM', 'nilairujukan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanlabalat_id' => 'Pemeriksaanlabalat',
			'nilairujukan_id' => 'Nilairujukan',
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

		if(!empty($this->pemeriksaanlabalat_id)){
			$criteria->addCondition('pemeriksaanlabalat_id = '.$this->pemeriksaanlabalat_id);
		}
		if(!empty($this->nilairujukan_id)){
			$criteria->addCondition('nilairujukan_id = '.$this->nilairujukan_id);
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
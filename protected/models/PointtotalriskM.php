<?php

/**
 * This is the model class for table "pointtotalrisk_m".
 *
 * The followings are the available columns in table 'pointtotalrisk_m':
 * @property integer $pointtotalrisk_id
 * @property string $jeniskelamin
 * @property string $pointtotalrisk_matematika
 * @property integer $point_total
 * @property integer $yearrisk_persen
 */
class PointtotalriskM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PointtotalriskM the static model class
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
		return 'pointtotalrisk_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jeniskelamin, pointtotalrisk_matematika, point_total, yearrisk_persen', 'required'),
			array('point_total, yearrisk_persen', 'numerical', 'integerOnly'=>true),
			array('jeniskelamin', 'length', 'max'=>1),
			array('pointtotalrisk_matematika', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pointtotalrisk_id, jeniskelamin, pointtotalrisk_matematika, point_total, yearrisk_persen', 'safe', 'on'=>'search'),
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
			'pointtotalrisk_id' => 'Pointtotalrisk',
			'jeniskelamin' => 'Jenis Kelamin',
			'pointtotalrisk_matematika' => 'Pointtotalrisk Matematika',
			'point_total' => 'Point Total',
			'yearrisk_persen' => 'Yearrisk Persen',
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

		if(!empty($this->pointtotalrisk_id)){
			$criteria->addCondition('pointtotalrisk_id = '.$this->pointtotalrisk_id);
		}
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(pointtotalrisk_matematika)',strtolower($this->pointtotalrisk_matematika),true);
		if(!empty($this->point_total)){
			$criteria->addCondition('point_total = '.$this->point_total);
		}
		if(!empty($this->yearrisk_persen)){
			$criteria->addCondition('yearrisk_persen = '.$this->yearrisk_persen);
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
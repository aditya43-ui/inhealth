<?php

/**
 * This is the model class for table "hdlpoints_m".
 *
 * The followings are the available columns in table 'hdlpoints_m':
 * @property integer $hdlpoints_id
 * @property string $hdlpoints_nama
 * @property integer $hdlpoints_min
 * @property integer $hdlpoints_max
 * @property boolean $hdlpoints_aktif
 * @property integer $hdlpoints_point
 */
class HdlpointsM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HdlpointsM the static model class
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
		return 'hdlpoints_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('hdlpoints_nama, hdlpoints_min, hdlpoints_max, hdlpoints_point', 'required'),
			array('hdlpoints_min, hdlpoints_max, hdlpoints_point', 'numerical', 'integerOnly'=>true),
			array('hdlpoints_nama', 'length', 'max'=>20),
			array('hdlpoints_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('hdlpoints_id, hdlpoints_nama, hdlpoints_min, hdlpoints_max, hdlpoints_aktif, hdlpoints_point', 'safe', 'on'=>'search'),
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
			'hdlpoints_id' => 'Hdlpoints',
			'hdlpoints_nama' => 'Hdlpoints Nama',
			'hdlpoints_min' => 'Hdlpoints Min',
			'hdlpoints_max' => 'Hdlpoints Max',
			'hdlpoints_aktif' => 'Hdlpoints Aktif',
			'hdlpoints_point' => 'Hdlpoints Point',
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

		if(!empty($this->hdlpoints_id)){
			$criteria->addCondition('hdlpoints_id = '.$this->hdlpoints_id);
		}
		$criteria->compare('LOWER(hdlpoints_nama)',strtolower($this->hdlpoints_nama),true);
		if(!empty($this->hdlpoints_min)){
			$criteria->addCondition('hdlpoints_min = '.$this->hdlpoints_min);
		}
		if(!empty($this->hdlpoints_max)){
			$criteria->addCondition('hdlpoints_max = '.$this->hdlpoints_max);
		}
		$criteria->compare('hdlpoints_aktif',$this->hdlpoints_aktif);
		if(!empty($this->hdlpoints_point)){
			$criteria->addCondition('hdlpoints_point = '.$this->hdlpoints_point);
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
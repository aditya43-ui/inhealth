<?php

/**
 * This is the model class for table "cholesterolpoints_m".
 *
 * The followings are the available columns in table 'cholesterolpoints_m':
 * @property integer $cholesterolpoints_id
 * @property integer $kelompokumurjk_id
 * @property string $jeniskelamin
 * @property string $cholesterolpoints_nama
 * @property integer $cholesterolpoints_min
 * @property integer $cholesterolpoints_max
 * @property string $cholesterolpoints_keterangan
 * @property integer $cholesterolpoints_point
 */
class CholesterolpointsM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CholesterolpointsM the static model class
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
		return 'cholesterolpoints_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokumurjk_id, jeniskelamin, cholesterolpoints_nama, cholesterolpoints_min, cholesterolpoints_max, cholesterolpoints_keterangan', 'required'),
			array('kelompokumurjk_id, cholesterolpoints_min, cholesterolpoints_max, cholesterolpoints_point', 'numerical', 'integerOnly'=>true),
			array('jeniskelamin', 'length', 'max'=>1),
			array('cholesterolpoints_nama', 'length', 'max'=>20),
			array('cholesterolpoints_keterangan', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cholesterolpoints_id, kelompokumurjk_id, jeniskelamin, cholesterolpoints_nama, cholesterolpoints_min, cholesterolpoints_max, cholesterolpoints_keterangan, cholesterolpoints_point', 'safe', 'on'=>'search'),
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
			'cholesterolpoints_id' => 'Cholesterolpoints',
			'kelompokumurjk_id' => 'Kelompokumurjk',
			'jeniskelamin' => 'Jenis Kelamin',
			'cholesterolpoints_nama' => 'Cholesterolpoints Nama',
			'cholesterolpoints_min' => 'Cholesterolpoints Min',
			'cholesterolpoints_max' => 'Cholesterolpoints Max',
			'cholesterolpoints_keterangan' => 'Cholesterolpoints Keterangan',
			'cholesterolpoints_point' => 'Cholesterolpoints Point',
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

		if(!empty($this->cholesterolpoints_id)){
			$criteria->addCondition('cholesterolpoints_id = '.$this->cholesterolpoints_id);
		}
		if(!empty($this->kelompokumurjk_id)){
			$criteria->addCondition('kelompokumurjk_id = '.$this->kelompokumurjk_id);
		}
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(cholesterolpoints_nama)',strtolower($this->cholesterolpoints_nama),true);
		if(!empty($this->cholesterolpoints_min)){
			$criteria->addCondition('cholesterolpoints_min = '.$this->cholesterolpoints_min);
		}
		if(!empty($this->cholesterolpoints_max)){
			$criteria->addCondition('cholesterolpoints_max = '.$this->cholesterolpoints_max);
		}
		$criteria->compare('LOWER(cholesterolpoints_keterangan)',strtolower($this->cholesterolpoints_keterangan),true);
		if(!empty($this->cholesterolpoints_point)){
			$criteria->addCondition('cholesterolpoints_point = '.$this->cholesterolpoints_point);
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
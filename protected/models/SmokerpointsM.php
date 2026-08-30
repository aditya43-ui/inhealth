<?php

/**
 * This is the model class for table "smokerpoints_m".
 *
 * The followings are the available columns in table 'smokerpoints_m':
 * @property integer $smokerpoints_id
 * @property integer $kelompokumurjk_id
 * @property string $jeniskelamin
 * @property string $smokerpoints_nama
 * @property integer $smokerpoints_points
 */
class SmokerpointsM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SmokerpointsM the static model class
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
		return 'smokerpoints_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokumurjk_id, jeniskelamin, smokerpoints_nama, smokerpoints_points', 'required'),
			array('kelompokumurjk_id, smokerpoints_points', 'numerical', 'integerOnly'=>true),
			array('jeniskelamin', 'length', 'max'=>1),
			array('smokerpoints_nama', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('smokerpoints_id, kelompokumurjk_id, jeniskelamin, smokerpoints_nama, smokerpoints_points', 'safe', 'on'=>'search'),
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
			'smokerpoints_id' => 'Smokerpoints',
			'kelompokumurjk_id' => 'Kelompokumurjk',
			'jeniskelamin' => 'Jenis Kelamin',
			'smokerpoints_nama' => 'Smokerpoints Nama',
			'smokerpoints_points' => 'Smokerpoints Points',
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

		if(!empty($this->smokerpoints_id)){
			$criteria->addCondition('smokerpoints_id = '.$this->smokerpoints_id);
		}
		if(!empty($this->kelompokumurjk_id)){
			$criteria->addCondition('kelompokumurjk_id = '.$this->kelompokumurjk_id);
		}
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(smokerpoints_nama)',strtolower($this->smokerpoints_nama),true);
		if(!empty($this->smokerpoints_points)){
			$criteria->addCondition('smokerpoints_points = '.$this->smokerpoints_points);
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
<?php

/**
 * This is the model class for table "pointumurjk_m".
 *
 * The followings are the available columns in table 'pointumurjk_m':
 * @property integer $pointumurjk_id
 * @property integer $kelompokumurjk_id
 * @property string $jeniskelamin
 * @property integer $umur_points
 */
class PointumurjkM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PointumurjkM the static model class
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
		return 'pointumurjk_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelompokumurjk_id, jeniskelamin, umur_points', 'required'),
			array('kelompokumurjk_id, umur_points', 'numerical', 'integerOnly'=>true),
			array('jeniskelamin', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pointumurjk_id, kelompokumurjk_id, jeniskelamin, umur_points', 'safe', 'on'=>'search'),
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
			'pointumurjk_id' => 'Pointumurjk',
			'kelompokumurjk_id' => 'Kelompokumurjk',
			'jeniskelamin' => 'Jenis Kelamin',
			'umur_points' => 'Umur Points',
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

		if(!empty($this->pointumurjk_id)){
			$criteria->addCondition('pointumurjk_id = '.$this->pointumurjk_id);
		}
		if(!empty($this->kelompokumurjk_id)){
			$criteria->addCondition('kelompokumurjk_id = '.$this->kelompokumurjk_id);
		}
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		if(!empty($this->umur_points)){
			$criteria->addCondition('umur_points = '.$this->umur_points);
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
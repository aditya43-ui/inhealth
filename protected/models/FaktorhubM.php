<?php

/**
 * This is the model class for table "faktorhub_m".
 *
 * The followings are the available columns in table 'faktorhub_m':
 * @property integer $faktorhub_id
 * @property integer $diagnosakep_id
 * @property string $faktorhub_nama
 *
 * The followings are the available model relations:
 * @property FaktorhubdetM[] $faktorhubdetMs
 * @property DiagnosakepM $diagnosakep
 */
class FaktorhubM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FaktorhubM the static model class
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
		return 'faktorhub_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosakep_id', 'required'),
			array('diagnosakep_id', 'numerical', 'integerOnly'=>true),
			array('faktorhub_nama', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faktorhub_id, diagnosakep_id, faktorhub_nama', 'safe', 'on'=>'search'),
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
			'faktorhubdetMs' => array(self::HAS_MANY, 'FaktorhubdetM', 'faktorhub_id'),
			'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'faktorhub_id' => 'Faktorhub',
			'diagnosakep_id' => 'Diagnosakep',
			'faktorhub_nama' => 'Faktorhub Nama',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('faktorhub_id',$this->faktorhub_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('faktorhub_nama',$this->faktorhub_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
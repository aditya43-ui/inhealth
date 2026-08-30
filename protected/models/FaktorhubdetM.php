<?php

/**
 * This is the model class for table "faktorhubdet_m".
 *
 * The followings are the available columns in table 'faktorhubdet_m':
 * @property integer $faktorhubdet_id
 * @property integer $faktorhub_id
 * @property string $faktorhubdet_indikator
 * @property boolean $faktorhubdet_aktif
 *
 * The followings are the available model relations:
 * @property FaktorhubM $faktorhub
 */
class FaktorhubdetM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FaktorhubdetM the static model class
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
		return 'faktorhubdet_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('faktorhub_id, faktorhubdet_indikator, faktorhubdet_aktif', 'required'),
			array('faktorhub_id', 'numerical', 'integerOnly'=>true),
			array('faktorhubdet_indikator', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faktorhubdet_id, faktorhub_id, faktorhubdet_indikator, faktorhubdet_aktif', 'safe', 'on'=>'search'),
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
			'faktorhub' => array(self::BELONGS_TO, 'FaktorhubM', 'faktorhub_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'faktorhubdet_id' => 'Faktorhubdet',
			'faktorhub_id' => 'Faktorhub',
			'faktorhubdet_indikator' => 'Faktorhubdet Indikator',
			'faktorhubdet_aktif' => 'Faktorhubdet Aktif',
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

		$criteria->compare('faktorhubdet_id',$this->faktorhubdet_id);
		$criteria->compare('faktorhub_id',$this->faktorhub_id);
		$criteria->compare('faktorhubdet_indikator',$this->faktorhubdet_indikator,true);
		$criteria->compare('faktorhubdet_aktif',$this->faktorhubdet_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
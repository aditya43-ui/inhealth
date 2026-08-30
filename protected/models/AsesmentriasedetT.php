<?php

/**
 * This is the model class for table "asesmentriasedet_t".
 *
 * The followings are the available columns in table 'asesmentriasedet_t':
 * @property integer $asesmentridet_id
 * @property integer $asesmentriase_id
 * @property integer $triase_id
 *
 * The followings are the available model relations:
 * @property AsesmentriaseT $asesmentriase
 * @property TriaseM $triase
 */
class AsesmentriasedetT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmentriasedetT the static model class
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
		return 'asesmentriasedet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asesmentriase_id, triase_id', 'required'),
			array('asesmentriase_id, triase_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmentridet_id, asesmentriase_id, triase_id', 'safe', 'on'=>'search'),
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
			'asesmentriase' => array(self::BELONGS_TO, 'AsesmentriaseT', 'asesmentriase_id'),
			'triase' => array(self::BELONGS_TO, 'TriaseM', 'triase_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmentridet_id' => 'Asesmentridet',
			'asesmentriase_id' => 'Asesmentriase',
			'triase_id' => 'Triase',
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

		$criteria->compare('asesmentridet_id',$this->asesmentridet_id);
		$criteria->compare('asesmentriase_id',$this->asesmentriase_id);
		$criteria->compare('triase_id',$this->triase_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
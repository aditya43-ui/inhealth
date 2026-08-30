<?php

/**
 * This is the model class for table "implementasikep_m".
 * @author Aida Rahmawati <aidarahmawati@invoamedika.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'implementasikep_m':
 * @property integer $implementasikep_id
 * @property integer $diagnosakep_id
 *
 * The followings are the available model relations:
 * @property DiagnosakepM $diagnosakep
 * @property IndikatorimplkepdetM[] $indikatorimplkepdetMs
 */
class ImplementasikepM extends CActiveRecord
{
        public $jenisintervensi_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ImplementasikepM the static model class
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
		return 'implementasikep_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisintervensi_id', 'required'),
			array('diagnosakep_id', 'numerical', 'integerOnly'=>true),
			array('jenistindakan, jenisintervensi_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('implementasikep_id, diagnosakep_id', 'safe', 'on'=>'search'),
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
			'jenisintervensi' => array(self::BELONGS_TO, 'JenisintervensiM', 'jenisintervensi_id'),
			'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
			'indikatorimplkepdetMs' => array(self::HAS_MANY, 'IndikatorimplkepdetM', 'implementasikep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'implementasikep_id' => 'Implementasikep',
			'diagnosakep_id' => 'Diagnosakep',
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

		$criteria->compare('implementasikep_id',$this->implementasikep_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
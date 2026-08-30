<?php

/**
 * This is the model class for table "faktorrisiko_m".
 *
 * The followings are the available columns in table 'faktorrisiko_m':
 * @property integer $faktorrisiko_id
 * @property integer $diagnosakep_id
 * @property string $faktorrisiko_nama
 *
 * The followings are the available model relations:
 * @property FaktorrisikodetM[] $faktorrisikodetMs
 * @property DiagnosakepM $diagnosakep
 */
class FaktorrisikoM extends CActiveRecord
{
        public $faktorrisiko_daftar_nama, $jenisfaktorrisiko_nama, $jenisfaktorrisiko_id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FaktorrisikoM the static model class
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
		return 'faktorrisiko_m';
	}
        
        public $kelompokfaktorrisikodaftar_id;

        /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('diagnosakep_id', 'required'),
			array('diagnosakep_id, kelompokfaktorrisikodaftar_id', 'numerical', 'integerOnly'=>true),
			array('faktorrisiko_nama', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('faktorrisiko_id, diagnosakep_id, faktorrisiko_nama', 'safe', 'on'=>'search'),
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
			'faktorrisikodetMs' => array(self::HAS_MANY, 'FaktorrisikodetM', 'faktorrisiko_id'),
			'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'faktorrisiko_id' => 'Faktorrisiko',
			'diagnosakep_id' => 'Diagnosakep',
			'faktorrisiko_nama' => 'Faktorrisiko Nama',
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

		$criteria->compare('faktorrisiko_id',$this->faktorrisiko_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('faktorrisiko_nama',$this->faktorrisiko_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
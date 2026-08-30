<?php

/**
 * This is the model class for table "bataskarakteristik_m".
 *
 * The followings are the available columns in table 'bataskarakteristik_m':
 * @property integer $bataskarakteristik_id
 * @property integer $diagnosakep_id
 * @property string $bataskarakteristik_nama
 *
 * The followings are the available model relations:
 * @property BataskarakteristikdetM[] $bataskarakteristikdetMs
 * @property DiagnosakepM $diagnosakep
 */
class BataskarakteristikM extends CActiveRecord
{
public $varSort1;	
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BataskarakteristikM the static model class
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
		return 'bataskarakteristik_m';
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
			array('bataskarakteristik_nama', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('varSort1,bataskarakteristik_id, diagnosakep_id, bataskarakteristik_nama', 'safe', 'on'=>'search'),
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
			'bataskarakteristikdetMs' => array(self::HAS_MANY, 'BataskarakteristikdetM', 'bataskarakteristik_id'),
			'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bataskarakteristik_id' => 'Bataskarakteristik',
			'diagnosakep_id' => 'Diagnosakep',
			'bataskarakteristik_nama' => 'Bataskarakteristik Nama',
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

		$criteria->compare('bataskarakteristik_id',$this->bataskarakteristik_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('bataskarakteristik_nama',$this->bataskarakteristik_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
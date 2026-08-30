<?php

/**
 * This is the model class for table "intervensi_m".
 *
 * The followings are the available columns in table 'intervensi_m':
 * @property integer $intervensi_id
 * @property integer $diagnosakep_id
 * @property string $intervensi_nama
 *
 * The followings are the available model relations:
 * @property RencanaaskepdetT[] $rencanaaskepdetTs
 * @property IntervensidetM[] $intervensidetMs
 * @property DiagnosakepM $diagnosakep
 */
class IntervensiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IntervensiM the static model class
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
		return 'intervensi_m';
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
			array('intervensi_nama', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('intervensi_id, diagnosakep_id, intervensi_nama', 'safe', 'on'=>'search'),
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
			'rencanaaskepdetTs' => array(self::HAS_MANY, 'RencanaaskepdetT', 'intervensi_id'),
			'intervensidetMs' => array(self::HAS_MANY, 'IntervensidetM', 'intervensi_id'),
			'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'intervensi_id' => 'Intervensi',
			'diagnosakep_id' => 'Diagnosakep',
			'intervensi_nama' => 'Intervensi Nama',
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

		$criteria->compare('intervensi_id',$this->intervensi_id);
		$criteria->compare('diagnosakep_id',$this->diagnosakep_id);
		$criteria->compare('intervensi_nama',$this->intervensi_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
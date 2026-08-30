<?php

/**
 * This is the model class for table "operasitimeoutdet_t".
 *
 * The followings are the available columns in table 'operasitimeoutdet_t':
 * @property integer $operasitimeoutdet_id
 * @property integer $operasitimeout_id
 * @property integer $formtimeout_id
 * @property integer $checklisttimeout_id
 * @property string $timeoutdet_isian
 * @property boolean $timeoutdet_hasil
 */
class OperasitimeoutdetT extends CActiveRecord
{
	public $isdipilih;
	public $identifier;
	public $text;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OperasitimeoutdetT the static model class
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
		return 'operasitimeoutdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operasitimeout_id', 'required'),
			array('operasitimeout_id, formtimeout_id, checklisttimeout_id', 'numerical', 'integerOnly'=>true),
			array('timeoutdet_isian, timeoutdet_hasil', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('operasitimeoutdet_id, operasitimeout_id, formtimeout_id, checklisttimeout_id, timeoutdet_isian, timeoutdet_hasil', 'safe', 'on'=>'search'),
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
			'operasitimeoutdet_id' => 'Operasitimeoutdet',
			'operasitimeout_id' => 'Operasitimeout',
			'formtimeout_id' => 'Formtimeout',
			'checklisttimeout_id' => 'Checklisttimeout',
			'timeoutdet_isian' => 'Timeoutdet Isian',
			'timeoutdet_hasil' => 'Timeoutdet Hasil',
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

		$criteria->compare('operasitimeoutdet_id',$this->operasitimeoutdet_id);
		$criteria->compare('operasitimeout_id',$this->operasitimeout_id);
		$criteria->compare('formtimeout_id',$this->formtimeout_id);
		$criteria->compare('checklisttimeout_id',$this->checklisttimeout_id);
		$criteria->compare('timeoutdet_isian',$this->timeoutdet_isian,true);
		$criteria->compare('timeoutdet_hasil',$this->timeoutdet_hasil);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
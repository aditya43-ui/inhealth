<?php

/**
 * This is the model class for table "operasisignoutdet_t".
 *
 * The followings are the available columns in table 'operasisignoutdet_t':
 * @property integer $operasisignoutdet_id
 * @property integer $operasisignout_id
 * @property integer $formsignout_id
 * @property integer $checklistsignout_id
 * @property string $signoutdet_isian
 * @property boolean $signoutdet_hasil
 */
class OperasisignoutdetT extends CActiveRecord
{
	public $isdipilih;
	public $identifier;
	public $text;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OperasisignoutdetT the static model class
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
		return 'operasisignoutdet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operasisignout_id', 'required'),
			array('operasisignout_id, formsignout_id, checklistsignout_id', 'numerical', 'integerOnly'=>true),
			array('signoutdet_isian, signoutdet_hasil', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('operasisignoutdet_id, operasisignout_id, formsignout_id, checklistsignout_id, signoutdet_isian, signoutdet_hasil', 'safe', 'on'=>'search'),
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
			'operasisignoutdet_id' => 'Operasisignoutdet',
			'operasisignout_id' => 'Operasisignout',
			'formsignout_id' => 'Formsignout',
			'checklistsignout_id' => 'Checklistsignout',
			'signoutdet_isian' => 'Signoutdet Isian',
			'signoutdet_hasil' => 'Signoutdet Hasil',
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

		$criteria->compare('operasisignoutdet_id',$this->operasisignoutdet_id);
		$criteria->compare('operasisignout_id',$this->operasisignout_id);
		$criteria->compare('formsignout_id',$this->formsignout_id);
		$criteria->compare('checklistsignout_id',$this->checklistsignout_id);
		$criteria->compare('signoutdet_isian',$this->signoutdet_isian,true);
		$criteria->compare('signoutdet_hasil',$this->signoutdet_hasil);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
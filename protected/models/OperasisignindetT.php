<?php

/**
 * This is the model class for table "operasisignindet_t".
 *
 * The followings are the available columns in table 'operasisignindet_t':
 * @property integer $operasisignindet_id
 * @property integer $operasisignin_id
 * @property integer $formsignin_id
 * @property integer $checklistsignin_id
 * @property string $signindet_isian
 * @property boolean $signindet_hasil
 */
class OperasisignindetT extends CActiveRecord
{
	public $isdipilih;
	public $identifier;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OperasisignindetT the static model class
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
		return 'operasisignindet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operasisignin_id', 'required'),
			array('operasisignin_id, formsignin_id, checklistsignin_id', 'numerical', 'integerOnly'=>true),
			array('signindet_isian, signindet_hasil', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('operasisignindet_id, operasisignin_id, formsignin_id, checklistsignin_id, signindet_isian, signindet_hasil', 'safe', 'on'=>'search'),
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
			'operasisignindet_id' => 'Operasisignindet',
			'operasisignin_id' => 'Operasisignin',
			'formsignin_id' => 'Formsignin',
			'checklistsignin_id' => 'Checklistsignin',
			'signindet_isian' => 'Signindet Isian',
			'signindet_hasil' => 'Signindet Hasil',
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

		$criteria->compare('operasisignindet_id',$this->operasisignindet_id);
		$criteria->compare('operasisignin_id',$this->operasisignin_id);
		$criteria->compare('formsignin_id',$this->formsignin_id);
		$criteria->compare('checklistsignin_id',$this->checklistsignin_id);
		$criteria->compare('signindet_isian',$this->signindet_isian,true);
		$criteria->compare('signindet_hasil',$this->signindet_hasil);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
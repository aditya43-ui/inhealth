<?php

/**
 * This is the model class for table "sumlabarugi_v".
 *
 * The followings are the available columns in table 'sumlabarugi_v':
 * @property integer $rekperiod_id
 * @property string $jenissaldo
 * @property double $laba
 * @property double $rugi
 * @property double $pajak
 */
class SumlabarugiV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SumlabarugiV the static model class
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
		return 'sumlabarugi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekperiod_id', 'numerical', 'integerOnly'=>true),
			array('laba, rugi, pajak', 'numerical'),
			array('jenissaldo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekperiod_id, jenissaldo, laba, rugi, pajak', 'safe', 'on'=>'search'),
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
			'rekperiod_id' => 'Rekperiod',
			'jenissaldo' => 'Jenissaldo',
			'laba' => 'Laba',
			'rugi' => 'Rugi',
			'pajak' => 'Pajak',
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

		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('jenissaldo',$this->jenissaldo,true);
		$criteria->compare('laba',$this->laba);
		$criteria->compare('rugi',$this->rugi);
		$criteria->compare('pajak',$this->pajak);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "rekeninguangmuka_m".
 *
 * The followings are the available columns in table 'rekeninguangmuka_m':
 * @property integer $rekeninguangmuka_id
 * @property integer $rekening5_id
 * @property integer $instalasi_id
 *
 * The followings are the available model relations:
 * @property Rekening5M $rekening5
 * @property InstalasiM $instalasi
 */
class RekeninguangmukaM extends CActiveRecord
{
	public $instalasi_nama,$nmrekening5,$instalasi_id,$rekening5_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RekeninguangmukaM the static model class
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
		return 'rekeninguangmuka_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rekening5_id, instalasi_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rekeninguangmuka_id, rekening5_id, instalasi_id, debitkredit, ispembatalan', 'safe', 'on'=>'search'),
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
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rekeninguangmuka_id' => 'Rekeninguangmuka',
			'rekening5_id' => 'Rekening',
			'instalasi_id' => 'Instalasi',
			'debitkredit' => 'Saldo Normal',
			'ispembatalan' => 'Pembatalan',
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

		$criteria->compare('rekeninguangmuka_id',$this->rekeninguangmuka_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('instalasi_id',$this->instalasi_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
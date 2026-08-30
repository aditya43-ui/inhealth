<?php

/**
 * This is the model class for table "jnspembrek_m".
 *
 * The followings are the available columns in table 'jnspembrek_m':
 * @property integer $jnspembrek_id
 * @property integer $jnspembayar_id
 * @property integer $bank_id
 * @property integer $rekening5_id
 * @property string $debitkredit
 * @property string $saldonormal
 * @property integer $rekening1_id
 * @property integer $rekening2_id
 * @property integer $rekening3_id
 * @property integer $rekening4_id
 *
 * The followings are the available model relations:
 * @property JnspembayarM $jnspembayar
 * @property BankM $bank
 * @property Rekening1M $rekening1
 * @property Rekening2M $rekening2
 * @property Rekening3M $rekening3
 * @property Rekening4M $rekening4
 * @property Rekening5M $rekening5
 */
class JnspembrekM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JnspembrekM the static model class
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
		return 'jnspembrek_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jnspembayar_id, debitkredit, saldonormal', 'required'),
			array('jnspembayar_id, bank_id, rekening5_id, rekening1_id, rekening2_id, rekening3_id, rekening4_id', 'numerical', 'integerOnly'=>true),
			array('debitkredit', 'length', 'max'=>1),
			array('saldonormal', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jnspembrek_id, jnspembayar_id, bank_id, rekening5_id, debitkredit, saldonormal, rekening1_id, rekening2_id, rekening3_id, rekening4_id', 'safe', 'on'=>'search'),
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
			'jnspembayar' => array(self::BELONGS_TO, 'JnspembayarM', 'jnspembayar_id'),
			'bank' => array(self::BELONGS_TO, 'BankM', 'bank_id'),
			'rekening1' => array(self::BELONGS_TO, 'Rekening1M', 'rekening1_id'),
			'rekening2' => array(self::BELONGS_TO, 'Rekening2M', 'rekening2_id'),
			'rekening3' => array(self::BELONGS_TO, 'Rekening3M', 'rekening3_id'),
			'rekening4' => array(self::BELONGS_TO, 'Rekening4M', 'rekening4_id'),
			'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jnspembrek_id' => 'Jnspembrek',
			'jnspembayar_id' => 'Jnspembayar',
			'bank_id' => 'Bank',
			'rekening5_id' => 'Rekening5',
			'debitkredit' => 'Debitkredit',
			'saldonormal' => 'Saldo Normal',
			'rekening1_id' => 'Rekening1',
			'rekening2_id' => 'Rekening2',
			'rekening3_id' => 'Rekening3',
			'rekening4_id' => 'Rekening4',
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

		$criteria->compare('jnspembrek_id',$this->jnspembrek_id);
		$criteria->compare('jnspembayar_id',$this->jnspembayar_id);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('debitkredit',$this->debitkredit,true);
		$criteria->compare('saldonormal',$this->saldonormal,true);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('rekening4_id',$this->rekening4_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
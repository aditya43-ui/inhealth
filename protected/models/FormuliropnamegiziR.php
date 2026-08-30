<?php

/**
 * This is the model class for table "formuliropnamegizi_r".
 *
 * The followings are the available columns in table 'formuliropnamegizi_r':
 * @property integer $formuliropnamegizi_id
 * @property integer $stokopnamegizi_id
 * @property string $tglformulir
 * @property string $noformulir
 * @property double $totalvolume
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property StokopnamegiziT $stokopnamegizi
 * @property FormuliropnamegizidetR[] $formuliropnamegizidetRs
 */
class FormuliropnamegiziR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormuliropnamegiziR the static model class
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
		return 'formuliropnamegizi_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tglformulir, noformulir, totalvolume, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('stokopnamegizi_id', 'numerical', 'integerOnly'=>true),
			array('totalvolume', 'numerical'),
			array('noformulir', 'length', 'max'=>50),
			array('update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formuliropnamegizi_id, stokopnamegizi_id, tglformulir, noformulir, totalvolume, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'stokopnamegizi' => array(self::BELONGS_TO, 'StokopnamegiziT', 'stokopnamegizi_id'),
			'formuliropnamegizidetRs' => array(self::HAS_MANY, 'FormuliropnamegizidetR', 'formuliropnamegizi_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'formuliropnamegizi_id' => 'Formuliropnamegizi',
			'stokopnamegizi_id' => 'Stokopnamegizi',
			'tglformulir' => 'Tgl. Formulir',
			'noformulir' => 'No. Formulir',
			'totalvolume' => 'Total Volume',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('formuliropnamegizi_id',$this->formuliropnamegizi_id);
		$criteria->compare('stokopnamegizi_id',$this->stokopnamegizi_id);
		$criteria->compare('tglformulir',$this->tglformulir,true);
		$criteria->compare('noformulir',$this->noformulir,true);
		$criteria->compare('totalvolume',$this->totalvolume);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
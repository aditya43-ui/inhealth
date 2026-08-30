<?php

/**
 * This is the model class for table "laporanrasio_r".
 *
 * The followings are the available columns in table 'laporanrasio_r':
 * @property integer $laporanrasio_id
 * @property integer $periodeposting_id
 * @property string $nama_rasio
 * @property double $rasio
 */
class LaporanrasioR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporanrasioR the static model class
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
		return 'laporanrasio_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('periodeposting_id', 'numerical', 'integerOnly'=>true),
			array('rasio', 'numerical'),
			array('nama_rasio', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('laporanrasio_id, periodeposting_id, nama_rasio, rasio', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'periodeposting' => array(self::BELONGS_TO, 'PeriodepostingM', 'periodeposting_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'laporanrasio_id' => 'Laporanrasio',
			'periodeposting_id' => 'Periodeposting',
			'nama_rasio' => 'Nama Rasio',
			'rasio' => 'Rasio',
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

		$criteria->compare('laporanrasio_id',$this->laporanrasio_id);
		$criteria->compare('periodeposting_id',$this->periodeposting_id);
		$criteria->compare('nama_rasio',$this->nama_rasio,true);
		$criteria->compare('rasio',$this->rasio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
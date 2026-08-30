<?php

/**
 * This is the model class for table "komponengajipegawai_m".
 *
 * The followings are the available columns in table 'komponengajipegawai_m':
 * @property integer $komponengajipegawai_id
 * @property integer $pegawai_id
 * @property integer $komponengaji_id
 * @property double $nilaigaji
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property KomponengajiM $komponengaji
 */
class KomponengajipegawaiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KomponengajipegawaiM the static model class
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
		return 'komponengajipegawai_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, komponengaji_id', 'required'),
			array('pegawai_id, komponengaji_id', 'numerical', 'integerOnly'=>true),
			array('nilaigaji', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('komponengajipegawai_id, pegawai_id, komponengaji_id, nilaigaji', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'komponengaji' => array(self::BELONGS_TO, 'KomponengajiM', 'komponengaji_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'komponengajipegawai_id' => 'Komponengajipegawai',
			'pegawai_id' => 'Pegawai',
			'komponengaji_id' => 'Komponengaji',
			'nilaigaji' => 'Nilaigaji',
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

		$criteria->compare('komponengajipegawai_id',$this->komponengajipegawai_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('komponengaji_id',$this->komponengaji_id);
		$criteria->compare('nilaigaji',$this->nilaigaji);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
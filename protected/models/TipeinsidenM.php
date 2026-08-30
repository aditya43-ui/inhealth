<?php

/**
 * This is the model class for table "tipeinsiden_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'tipeinsiden_m':
 * @property integer $tipeinsiden_id
 * @property string $tipeinsiden_nama
 * @property string $tipeinsiden_namalainnya
 * @property boolean $tipeinsiden_aktif
 * @property integer $tipeinsiden_urutan
 *
 * The followings are the available model relations:
 * @property SubtipeinsidenM[] $subtipeinsidenMs
 * @property KelompoksubtipeinsidenM[] $kelompoksubtipeinsidenMs
 */
class TipeinsidenM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TipeinsidenM the static model class
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
		return 'tipeinsiden_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipeinsiden_urutan', 'numerical', 'integerOnly'=>true),
			array('tipeinsiden_nama, tipeinsiden_namalainnya', 'length', 'max'=>100),
			array('tipeinsiden_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tipeinsiden_id, tipeinsiden_nama, tipeinsiden_namalainnya, tipeinsiden_aktif, tipeinsiden_urutan', 'safe', 'on'=>'search'),
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
			'subtipeinsidenMs' => array(self::HAS_MANY, 'SubtipeinsidenM', 'tipeinsiden_id'),
			'kelompoksubtipeinsidenMs' => array(self::HAS_MANY, 'KelompoksubtipeinsidenM', 'tipeinsiden_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tipeinsiden_id' => 'ID Tipe Insiden',
			'tipeinsiden_nama' => 'Tipe Insiden',
			'tipeinsiden_namalainnya' => 'Nama Lain Tipe Insiden',
			'tipeinsiden_aktif' => 'Status',
			'tipeinsiden_urutan' => 'Urutan Tipe Insiden',
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

		$criteria->compare('tipeinsiden_id',$this->tipeinsiden_id);
		$criteria->compare('tipeinsiden_nama',$this->tipeinsiden_nama,true);
		$criteria->compare('tipeinsiden_namalainnya',$this->tipeinsiden_namalainnya,true);
		$criteria->compare('tipeinsiden_aktif',isset($this->tipeinsiden_aktif)?$this->tipeinsiden_aktif:true);
		$criteria->compare('tipeinsiden_urutan',$this->tipeinsiden_urutan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
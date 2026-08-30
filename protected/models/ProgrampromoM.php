<?php

/**
 * This is the model class for table "programpromo_m".
 *
 * The followings are the available columns in table 'programpromo_m':
 * @property integer $programpromo_id
 * @property string $namaprogrampromo
 * @property string $namalainnya
 * @property string $deskripsi
 * @property string $keterangan
 * @property boolean $programpromo_aktif
 */
class ProgrampromoM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProgrampromoM the static model class
	 */
	public $temp_gambar;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'programpromo_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('namalainnya', 'required'),
			array('namaprogrampromo, namalainnya', 'length', 'max'=>100),
			array('deskripsi, keterangan, programpromo_aktif,gambarpromo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('programpromo_id, namaprogrampromo, namalainnya, deskripsi, keterangan, programpromo_aktif', 'safe', 'on'=>'search'),
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
			'programpromo_id' => 'Program Promo ID',
			'namaprogrampromo' => 'Nama Program Promo',
			'namalainnya' => 'Nama Lainnya',
			'deskripsi' => 'Deskripsi',
			'keterangan' => 'Keterangan',
			'gambarpromo' => 'Gambar Promo',
			'programpromo_aktif' => 'Program Promo Aktif',
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

		$criteria->compare('programpromo_id',$this->programpromo_id);
		$criteria->compare('namaprogrampromo',$this->namaprogrampromo,true);
		$criteria->compare('namalainnya',$this->namalainnya,true);
		$criteria->compare('deskripsi',$this->deskripsi,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('programpromo_aktif',$this->programpromo_aktif);
		// $criteria->compare('programpromo_aktif',$this->programpromo_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
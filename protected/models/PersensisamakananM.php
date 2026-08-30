<?php

/**
 * This is the model class for table "persensisamakanan_m".
 *
 * The followings are the available columns in table 'persensisamakanan_m':
 * @property integer $persensisamakanan_id
 * @property string $persensisamakanan_nama
 * @property string $persensisamakanan_namalainnya
 * @property integer $urutan
 * @property boolean $persensisamakanan_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SisamakananpasiendetT[] $sisamakananpasiendetTs
 */
class PersensisamakananM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PersensisamakananM the static model class
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
		return 'persensisamakanan_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('persensisamakanan_nama, urutan, create_time, create_loginpemakai_id', 'required'),
			array('urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('persensisamakanan_nama, persensisamakanan_namalainnya', 'length', 'max'=>100),
			array('persensisamakanan_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('persensisamakanan_id, persensisamakanan_nama, persensisamakanan_namalainnya, urutan, persensisamakanan_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'sisamakananpasiendetTs' => array(self::HAS_MANY, 'SisamakananpasiendetT', 'persensisamakanan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'persensisamakanan_id' => 'Persensisamakanan',
			'persensisamakanan_nama' => 'Persensisamakanan Nama',
			'persensisamakanan_namalainnya' => 'Persensisamakanan Namalainnya',
			'urutan' => 'Urutan',
			'persensisamakanan_aktif' => 'Persensisamakanan Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('persensisamakanan_id',$this->persensisamakanan_id);
		$criteria->compare('persensisamakanan_nama',$this->persensisamakanan_nama,true);
		$criteria->compare('persensisamakanan_namalainnya',$this->persensisamakanan_namalainnya,true);
		$criteria->compare('urutan',$this->urutan);
		$criteria->compare('persensisamakanan_aktif',$this->persensisamakanan_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
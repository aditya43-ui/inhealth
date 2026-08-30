<?php

/**
 * This is the model class for table "spesialissubspesialis_m".
 *
 * The followings are the available columns in table 'spesialissubspesialis_m':
 * @property integer $spesialissubspesialis_id
 * @property string $jenis
 * @property string $spesialissubspesialis_nama
 * @property string $spesialissubspesialis_namalainnya
 * @property string $spesialissubspesialis_kode
 * @property string $spesialissubspesialis_kodebpjs
 * @property integer $spesialis_id
 * @property integer $spesialissubspesialis_urutan
 * @property boolean $spesialissubspesialis_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 */
class SpesialissubspesialisM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpesialissubspesialisM the static model class
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
		return 'spesialissubspesialis_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenis, spesialissubspesialis_nama, spesialissubspesialis_urutan, create_loginpemakai_id', 'required'),
			array('spesialis_id, spesialissubspesialis_urutan, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('jenis', 'length', 'max'=>50),
			array('spesialissubspesialis_nama', 'length', 'max'=>200),
			array('spesialissubspesialis_kode, spesialissubspesialis_kodebpjs', 'length', 'max'=>100),
			array('spesialissubspesialis_namalainnya, spesialissubspesialis_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('spesialissubspesialis_id, jenis, spesialissubspesialis_nama, spesialissubspesialis_namalainnya, spesialissubspesialis_kode, spesialissubspesialis_kodebpjs, spesialis_id, spesialissubspesialis_urutan, spesialissubspesialis_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'spesialis'=>array(self::BELONGS_TO, 'SpesialissubspesialisM', 'spesialis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'spesialissubspesialis_id' => 'ID',
			'jenis' => 'Jenis',
			'spesialissubspesialis_nama' => 'Nama Spesialis/Subspesialis',
			'spesialissubspesialis_namalainnya' => 'Nama Lain Spesialis/Subspesialis',
			'spesialissubspesialis_kode' => 'Kode Spesialis/Subspesialis',
			'spesialissubspesialis_kodebpjs' => 'Kode BPJS Spesialis/Subspesialis',
			'spesialis_id' => 'Spesialis',
			'spesialissubspesialis_urutan' => 'Urutan',
			'spesialissubspesialis_aktif' => 'Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('spesialissubspesialis_id',$this->spesialissubspesialis_id);
		$criteria->compare('jenis',$this->jenis,true);
		$criteria->compare('spesialissubspesialis_nama',$this->spesialissubspesialis_nama,true);
		$criteria->compare('spesialissubspesialis_namalainnya',$this->spesialissubspesialis_namalainnya,true);
		$criteria->compare('spesialissubspesialis_kode',$this->spesialissubspesialis_kode,true);
		$criteria->compare('spesialissubspesialis_kodebpjs',$this->spesialissubspesialis_kodebpjs,true);
		$criteria->compare('spesialis_id',$this->spesialis_id);
		$criteria->compare('spesialissubspesialis_urutan',$this->spesialissubspesialis_urutan);
		$criteria->compare('spesialissubspesialis_aktif',$this->spesialissubspesialis_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
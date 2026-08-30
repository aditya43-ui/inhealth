<?php

/**
 * This is the model class for table "petunjukpenggunaandetail_m".
 *
 * The followings are the available columns in table 'petunjukpenggunaandetail_m':
 * @property integer $petunjukpenggunaandetail_id
 * @property integer $petunjukpenggunaan_id
 * @property string $petunjukpenggunaandetail_image
 * @property boolean $petunjukpenggunaandetail_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PetunjukpenggunaandetailM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'petunjukpenggunaandetail_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('petunjukpenggunaan_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('petunjukpenggunaandetail_id, petunjukpenggunaan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('petunjukpenggunaandetail_image', 'length', 'max'=>500),
			array('petunjukpenggunaandetail_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('petunjukpenggunaandetail_id, petunjukpenggunaan_id, petunjukpenggunaandetail_image, petunjukpenggunaandetail_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'petunjuk' => array(self::BELONGS_TO, 'PetunjukpenggunaanM', 'petunjukpenggunaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'petunjukpenggunaandetail_id' => 'ID',
			'petunjukpenggunaan_id' => 'Petunjuk Penggunaan',
			'petunjukpenggunaandetail_image' => 'Gambar',
			'petunjukpenggunaandetail_aktif' => 'Petunjukpenggunaandetail Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('petunjukpenggunaandetail_id',$this->petunjukpenggunaandetail_id);
		$criteria->compare('petunjukpenggunaan_id',$this->petunjukpenggunaan_id);
		$criteria->compare('petunjukpenggunaandetail_image',$this->petunjukpenggunaandetail_image,true);
		$criteria->compare('petunjukpenggunaandetail_aktif',$this->petunjukpenggunaandetail_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('petunjukpenggunaandetail_id',$this->petunjukpenggunaandetail_id);
		$criteria->compare('petunjukpenggunaan_id',$this->petunjukpenggunaan_id);
		$criteria->compare('petunjukpenggunaandetail_image',$this->petunjukpenggunaandetail_image,true);
		$criteria->compare('petunjukpenggunaandetail_aktif',$this->petunjukpenggunaandetail_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PetunjukpenggunaandetailM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

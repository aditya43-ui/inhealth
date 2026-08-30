<?php

/**
 * This is the model class for table "subtipeinsiden_m".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'subtipeinsiden_m':
 * @property integer $subtipeinsiden_id
 * @property integer $tipeinsiden_id
 * @property integer $kelompoksubtipeinsiden_id
 * @property string $subtipeinsiden_nama
 * @property string $subtipeinsiden_namalainnya
 * @property boolean $subtipeinsiden_aktif
 * @property integer $subtipeinsiden_urutan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TipeinsidenM $tipeinsiden
 * @property KelompoksubtipeinsidenM $kelompoksubtipeinsiden
 */
class SubtipeinsidenM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubtipeinsidenM the static model class
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
		return 'subtipeinsiden_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipeinsiden_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('tipeinsiden_id, kelompoksubtipeinsiden_id, subtipeinsiden_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('subtipeinsiden_nama, subtipeinsiden_namalainnya', 'length', 'max'=>500),
			array('subtipeinsiden_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subtipeinsiden_id, tipeinsiden_id, kelompoksubtipeinsiden_id, subtipeinsiden_nama, subtipeinsiden_namalainnya, subtipeinsiden_aktif, subtipeinsiden_urutan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'tipeinsiden' => array(self::BELONGS_TO, 'TipeinsidenM', 'tipeinsiden_id'),
			'kelompoksubtipeinsiden' => array(self::BELONGS_TO, 'KelompoksubtipeinsidenM', 'kelompoksubtipeinsiden_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subtipeinsiden_id' => 'Subtipeinsiden',
			'tipeinsiden_id' => 'Tipeinsiden',
			'kelompoksubtipeinsiden_id' => 'Kelompoksubtipeinsiden',
			'subtipeinsiden_nama' => 'Subtipeinsiden Nama',
			'subtipeinsiden_namalainnya' => 'Subtipeinsiden Namalainnya',
			'subtipeinsiden_aktif' => 'Subtipeinsiden Aktif',
			'subtipeinsiden_urutan' => 'Subtipeinsiden Urutan',
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

		$criteria->compare('subtipeinsiden_id',$this->subtipeinsiden_id);
		$criteria->compare('tipeinsiden_id',$this->tipeinsiden_id);
		$criteria->compare('kelompoksubtipeinsiden_id',$this->kelompoksubtipeinsiden_id);
		$criteria->compare('subtipeinsiden_nama',$this->subtipeinsiden_nama,true);
		$criteria->compare('subtipeinsiden_namalainnya',$this->subtipeinsiden_namalainnya,true);
		$criteria->compare('subtipeinsiden_aktif',$this->subtipeinsiden_aktif);
		$criteria->compare('subtipeinsiden_urutan',$this->subtipeinsiden_urutan);
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
	 * Untuk mencetak data
         * @return \CActiveDataProvider
         */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('subtipeinsiden_id',$this->subtipeinsiden_id);
		$criteria->compare('tipeinsiden_id',$this->tipeinsiden_id);
		$criteria->compare('kelompoksubtipeinsiden_id',$this->kelompoksubtipeinsiden_id);
		$criteria->compare('subtipeinsiden_nama',$this->subtipeinsiden_nama,true);
		$criteria->compare('subtipeinsiden_namalainnya',$this->subtipeinsiden_namalainnya,true);
		$criteria->compare('subtipeinsiden_aktif',$this->subtipeinsiden_aktif);
		$criteria->compare('subtipeinsiden_urutan',$this->subtipeinsiden_urutan);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
                $criteria->limit = -1;
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
		));
	}
}
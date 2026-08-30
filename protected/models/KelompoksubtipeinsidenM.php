<?php

/**
 * This is the model class for table "kelompoksubtipeinsiden_m".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'kelompoksubtipeinsiden_m':
 * @property integer $kelompoksubtipeinsiden_id
 * @property integer $tipeinsiden_id
 * @property string $kelompoksubtipeinsiden_nama
 * @property string $kelompoksubtipeinsiden_namalainnya
 * @property boolean $kelompoksubtipeinsiden_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SubtipeinsidenM[] $subtipeinsidenMs
 * @property TipeinsidenM $tipeinsiden
 */
class KelompoksubtipeinsidenM extends CActiveRecord
{
        public $tipeinsiden_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KelompoksubtipeinsidenM the static model class
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
		return 'kelompoksubtipeinsiden_m';
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
			array('tipeinsiden_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kelompoksubtipeinsiden_nama, kelompoksubtipeinsiden_namalainnya', 'length', 'max'=>100),
			array('kelompoksubtipeinsiden_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('kelompoksubtipeinsiden_id, tipeinsiden_id, kelompoksubtipeinsiden_nama, kelompoksubtipeinsiden_namalainnya, kelompoksubtipeinsiden_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'subtipeinsidenMs' => array(self::HAS_MANY, 'SubtipeinsidenM', 'kelompoksubtipeinsiden_id'),
			'tipeinsiden' => array(self::BELONGS_TO, 'TipeinsidenM', 'tipeinsiden_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kelompoksubtipeinsiden_id' => 'Kelompoksubtipeinsiden',
			'tipeinsiden_id' => 'Tipeinsiden',
			'kelompoksubtipeinsiden_nama' => 'Kelompoksubtipeinsiden Nama',
			'kelompoksubtipeinsiden_namalainnya' => 'Kelompoksubtipeinsiden Namalainnya',
			'kelompoksubtipeinsiden_aktif' => 'Kelompoksubtipeinsiden Aktif',
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

		$criteria->compare('kelompoksubtipeinsiden_id',$this->kelompoksubtipeinsiden_id);
		$criteria->compare('tipeinsiden_id',$this->tipeinsiden_id);
		$criteria->compare('kelompoksubtipeinsiden_nama',$this->kelompoksubtipeinsiden_nama,true);
		$criteria->compare('kelompoksubtipeinsiden_namalainnya',$this->kelompoksubtipeinsiden_namalainnya,true);
		$criteria->compare('kelompoksubtipeinsiden_aktif',$this->kelompoksubtipeinsiden_aktif);
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
         * Mencetak data kelompok subtipe insiden
         * @return \CActiveDataProvider
         */
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('kelompoksubtipeinsiden_id',$this->kelompoksubtipeinsiden_id);
		$criteria->compare('tipeinsiden_id',$this->tipeinsiden_id);
		$criteria->compare('kelompoksubtipeinsiden_nama',$this->kelompoksubtipeinsiden_nama,true);
		$criteria->compare('kelompoksubtipeinsiden_namalainnya',$this->kelompoksubtipeinsiden_namalainnya,true);
		$criteria->compare('kelompoksubtipeinsiden_aktif',$this->kelompoksubtipeinsiden_aktif);
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
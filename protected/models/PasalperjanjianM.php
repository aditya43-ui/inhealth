<?php

/**
 * This is the model class for table "pasalperjanjian_m".
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'pasalperjanjian_m':
 * @property integer $pasalperjanjian_id
 * @property string $pasalperjanjian_nama
 * @property string $pasalperjanjian_uraian
 * @property string $pasalperjanjian_isi
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $pasalperjanjian_aktif
 */
class PasalperjanjianM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasalperjanjianM the static model class
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
		return 'pasalperjanjian_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasalperjanjian_nama, pasalperjanjian_uraian, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pasalperjanjian_nama', 'length', 'max'=>10),
			array('pasalperjanjian_uraian', 'length', 'max'=>100),
			array('urutan, pasalperjanjian_isi, update_time, pasalperjanjian_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasalperjanjian_id, pasalperjanjian_nama, pasalperjanjian_uraian, pasalperjanjian_isi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, pasalperjanjian_aktif', 'safe', 'on'=>'search'),
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
			'pasalperjanjian_id' => 'Pasalperjanjian',
			'pasalperjanjian_nama' => 'Nama Pasal Perjanjian',
			'pasalperjanjian_uraian' => 'Uraian Pasal Perjanjian',
			'pasalperjanjian_isi' => 'Isi Pasal Perjanjian',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'pasalperjanjian_aktif' => 'Pasalperjanjian Aktif',
			'urutan' => 'Urutan',
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

		$criteria->compare('pasalperjanjian_id',$this->pasalperjanjian_id);
		$criteria->compare('pasalperjanjian_nama',$this->pasalperjanjian_nama,true);
		$criteria->compare('pasalperjanjian_uraian',$this->pasalperjanjian_uraian,true);
		$criteria->compare('pasalperjanjian_isi',$this->pasalperjanjian_isi,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('pasalperjanjian_aktif',$this->pasalperjanjian_aktif);
                $criteria->order = "pasalperjanjian_nama asc";
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

		$criteria->compare('pasalperjanjian_id',$this->pasalperjanjian_id);
		$criteria->compare('pasalperjanjian_nama',$this->pasalperjanjian_nama,true);
		$criteria->compare('pasalperjanjian_uraian',$this->pasalperjanjian_uraian,true);
		$criteria->compare('pasalperjanjian_isi',$this->pasalperjanjian_isi,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('pasalperjanjian_aktif',$this->pasalperjanjian_aktif);
                $criteria->order = "pasalperjanjian_nama asc";
                $criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}
<?php

/**
 * This is the model class for table "subtiperesiko_m".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'subtiperesiko_m':
 * @property integer $subtiperesiko_id
 * @property integer $tiperesiko_id
 * @property string $subtiperesiko_nama
 * @property string $subtiperesiko_keterangan
 * @property integer $subtiperesiko_urutan
 * @property boolean $subtiperesiko_aktif
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property string $update_time
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TiperesikoM $tiperesiko
 */
class SubtiperesikoM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubtiperesikoM the static model class
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
		return 'subtiperesiko_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tiperesiko_id, subtiperesiko_nama, create_loginpemakai_id, create_ruangan', 'required'),
			array('tiperesiko_id, subtiperesiko_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('subtiperesiko_nama', 'length', 'max'=>500),
			array('subtiperesiko_keterangan, subtiperesiko_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('subtiperesiko_id, tiperesiko_id, subtiperesiko_nama, subtiperesiko_keterangan, subtiperesiko_urutan, subtiperesiko_aktif, create_time, create_loginpemakai_id, update_time, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'tiperesiko' => array(self::BELONGS_TO, 'TiperesikoM', 'tiperesiko_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'subtiperesiko_id' => 'Subtiperesiko',
			'tiperesiko_id' => 'Tipe Risiko',
			'subtiperesiko_nama' => 'Sub Tipe Risiko',
			'subtiperesiko_keterangan' => 'Keterangan',
			'subtiperesiko_urutan' => 'Urutan',
			'subtiperesiko_aktif' => 'Status',
			'create_time' => 'Create Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_time' => 'Update Time',
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

		$criteria->compare('subtiperesiko_id',$this->subtiperesiko_id);
		$criteria->compare('tiperesiko_id',$this->tiperesiko_id);
		$criteria->compare('subtiperesiko_nama',$this->subtiperesiko_nama,true);
                $criteria->compare("LOWER(subtiperesiko_nama)", strtolower($this->subtiperesiko_nama), true);
                $criteria->compare("LOWER(subtiperesiko_keterangan)", strtolower($this->subtiperesiko_keterangan), true);
		$criteria->compare('subtiperesiko_urutan',$this->subtiperesiko_urutan);
		$criteria->compare('subtiperesiko_aktif',$this->subtiperesiko_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
	 * Digunakan untuk mencetak dokumen master.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('subtiperesiko_id',$this->subtiperesiko_id);
		$criteria->compare('tiperesiko_id',$this->tiperesiko_id);
                $criteria->compare("LOWER(subtiperesiko_nama)", strtolower($this->subtiperesiko_nama), true);
                $criteria->compare("LOWER(subtiperesiko_keterangan)", strtolower($this->subtiperesiko_keterangan), true);
		$criteria->compare('subtiperesiko_urutan',$this->subtiperesiko_urutan);
		$criteria->compare('subtiperesiko_aktif',$this->subtiperesiko_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
                $criteria->limit=-1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}
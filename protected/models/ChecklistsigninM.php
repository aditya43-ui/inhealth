<?php

/**
 * This is the model class for table "checklistsignin_m".
 *
 * The followings are the available columns in table 'checklistsignin_m':
 * @property integer $checklistsignin_id
 * @property integer $formsignin_id
 * @property string $checklistsignin_nama
 * @property string $checklistsignin_namalain
 * @property boolean $checklistsignin_aktif
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class ChecklistsigninM extends CActiveRecord
{
	public $formsignin_nama;
	public $haschecklist;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChecklistsigninM the static model class
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
		return 'checklistsignin_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('checklistsignin_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('formsignin_id', 'numerical', 'integerOnly'=>true),
			array('checklistsignin_nama', 'length', 'max'=>250),
			array('checklistsignin_namalain', 'length', 'max'=>300),
			array('checklistsignin_aktif, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('checklistsignin_id, formsignin_id, checklistsignin_nama, checklistsignin_namalain, checklistsignin_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'checklistsignin_id' => 'Checklistsignin',
			'formsignin_id' => 'Formsignin',
			'checklistsignin_nama' => 'Checklistsignin Nama',
			'checklistsignin_namalain' => 'Checklistsignin Namalain',
			'checklistsignin_aktif' => 'Checklistsignin Aktif',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('checklistsignin_id',$this->checklistsignin_id);
		$criteria->compare('formsignin_id',$this->formsignin_id);
		$criteria->compare('checklistsignin_nama',$this->checklistsignin_nama,true);
		$criteria->compare('checklistsignin_namalain',$this->checklistsignin_namalain,true);
		$criteria->compare('checklistsignin_aktif',$this->checklistsignin_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
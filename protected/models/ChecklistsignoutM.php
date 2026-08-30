<?php

/**
 * This is the model class for table "checklistsignout_m".
 *
 * The followings are the available columns in table 'checklistsignout_m':
 * @property integer $checklistsignout_id
 * @property integer $formsignout_id
 * @property string $checklistsignout_nama
 * @property string $checklistsignout_namalain
 * @property boolean $checklistsignout_aktif
 * @property integer $checklistsignout_urutan
 * @property string $checklistsignout_inputtype
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class ChecklistsignoutM extends CActiveRecord
{
	public $checklist_nama;
	public $formsignout_nama;
	public $haschecklist;	
	public $formsignout_inputtype;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChecklistsignoutM the static model class
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
		return 'checklistsignout_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('checklistsignout_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('formsignout_id, checklistsignout_urutan', 'numerical', 'integerOnly'=>true),
			array('checklistsignout_nama', 'length', 'max'=>250),
			array('checklistsignout_namalain', 'length', 'max'=>300),
			array('checklistsignout_inputtype', 'length', 'max'=>20),
			array('checklistsignout_aktif, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('checklistsignout_id, formsignout_id, checklistsignout_nama, checklistsignout_namalain, checklistsignout_aktif, checklistsignout_urutan, checklistsignout_inputtype, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'checklistsignout_id' => 'Checklistsignout',
			'formsignout_id' => 'Formsignout',
			'checklistsignout_nama' => 'Checklistsignout Nama',
			'checklistsignout_namalain' => 'Checklistsignout Namalain',
			'checklistsignout_aktif' => 'Checklistsignout Aktif',
			'checklistsignout_urutan' => 'Checklistsignout Urutan',
			'checklistsignout_inputtype' => 'Checklistsignout Inputtype',
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

		$criteria->compare('checklistsignout_id',$this->checklistsignout_id);
		$criteria->compare('formsignout_id',$this->formsignout_id);
		$criteria->compare('checklistsignout_nama',$this->checklistsignout_nama,true);
		$criteria->compare('checklistsignout_namalain',$this->checklistsignout_namalain,true);
		$criteria->compare('checklistsignout_aktif',$this->checklistsignout_aktif);
		$criteria->compare('checklistsignout_urutan',$this->checklistsignout_urutan);
		$criteria->compare('checklistsignout_inputtype',$this->checklistsignout_inputtype,true);
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
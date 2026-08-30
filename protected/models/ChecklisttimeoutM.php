<?php

/**
 * This is the model class for table "checklisttimeout_m".
 *
 * The followings are the available columns in table 'checklisttimeout_m':
 * @property integer $checklisttimeout_id
 * @property integer $formtimeout_id
 * @property string $checklisttimeout_nama
 * @property string $checklisttimeout_namalain
 * @property boolean $checklisttimeout_aktif
 * @property integer $checklisttimeout_urutan
 * @property string $checklisttimeout_inputtype
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class ChecklisttimeoutM extends CActiveRecord
{
	public $checklist_nama;
	public $formtimeout_nama;
	public $haschecklist;	
	public 	$formtimeout_inputtype;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChecklisttimeoutM the static model class
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
		return 'checklisttimeout_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('checklisttimeout_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('formtimeout_id, checklisttimeout_urutan', 'numerical', 'integerOnly'=>true),
			array('checklisttimeout_nama', 'length', 'max'=>250),
			array('checklisttimeout_namalain', 'length', 'max'=>300),
			array('checklisttimeout_inputtype', 'length', 'max'=>20),
			array('checklisttimeout_aktif, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('checklisttimeout_id, formtimeout_id, checklisttimeout_nama, checklisttimeout_namalain, checklisttimeout_aktif, checklisttimeout_urutan, checklisttimeout_inputtype, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'checklisttimeout_id' => 'Checklisttimeout',
			'formtimeout_id' => 'Formtimeout',
			'checklisttimeout_nama' => 'Checklisttimeout Nama',
			'checklisttimeout_namalain' => 'Checklisttimeout Namalain',
			'checklisttimeout_aktif' => 'Checklisttimeout Aktif',
			'checklisttimeout_urutan' => 'Checklisttimeout Urutan',
			'checklisttimeout_inputtype' => 'Checklisttimeout Inputtype',
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

		$criteria->compare('checklisttimeout_id',$this->checklisttimeout_id);
		$criteria->compare('formtimeout_id',$this->formtimeout_id);
		$criteria->compare('checklisttimeout_nama',$this->checklisttimeout_nama,true);
		$criteria->compare('checklisttimeout_namalain',$this->checklisttimeout_namalain,true);
		$criteria->compare('checklisttimeout_aktif',$this->checklisttimeout_aktif);
		$criteria->compare('checklisttimeout_urutan',$this->checklisttimeout_urutan);
		$criteria->compare('checklisttimeout_inputtype',$this->checklisttimeout_inputtype,true);
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
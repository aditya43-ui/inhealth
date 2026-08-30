<?php

/**
 * This is the model class for table "formtimeout_m".
 *
 * The followings are the available columns in table 'formtimeout_m':
 * @property integer $formtimeout_id
 * @property string $formtimeout_nama
 * @property string $formtimeout_namalain
 * @property boolean $haschecklist
 * @property boolean $formtimeout_aktif
 * @property integer $formtimeout_urutan
 * @property string $formtimeout_inputtype
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class FormtimeoutM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormtimeoutM the static model class
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
		return 'formtimeout_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('formtimeout_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('formtimeout_urutan', 'numerical', 'integerOnly'=>true),
			array('formtimeout_nama', 'length', 'max'=>250),
			array('formtimeout_namalain', 'length', 'max'=>300),
			array('formtimeout_inputtype', 'length', 'max'=>20),
			array('haschecklist, formtimeout_aktif, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formtimeout_id, formtimeout_nama, formtimeout_namalain, haschecklist, formtimeout_aktif, formtimeout_urutan, formtimeout_inputtype, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'formtimeout_id' => 'Formtimeout',
			'formtimeout_nama' => 'Formtimeout Nama',
			'formtimeout_namalain' => 'Formtimeout Namalain',
			'haschecklist' => 'Haschecklist',
			'formtimeout_aktif' => 'Formtimeout Aktif',
			'formtimeout_urutan' => 'Formtimeout Urutan',
			'formtimeout_inputtype' => 'Formtimeout Inputtype',
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

		$criteria->compare('formtimeout_id',$this->formtimeout_id);
		$criteria->compare('formtimeout_nama',$this->formtimeout_nama,true);
		$criteria->compare('formtimeout_namalain',$this->formtimeout_namalain,true);
		$criteria->compare('haschecklist',$this->haschecklist);
		$criteria->compare('formtimeout_aktif',$this->formtimeout_aktif);
		$criteria->compare('formtimeout_urutan',$this->formtimeout_urutan);
		$criteria->compare('formtimeout_inputtype',$this->formtimeout_inputtype,true);
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
<?php

/**
 * This is the model class for table "ipmchecklist_m".
 *
 * The followings are the available columns in table 'ipmchecklist_m':
 * @property integer $ipmchecklist_id
 * @property string $ipm_jenis
 * @property integer $ipm_list_nourut
 * @property string $ipm_listnama
 * @property string $ipm_ket
 * @property boolean $ipm_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * 
 * @package  application.models
 */
class IpmchecklistM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IpmchecklistM the static model class
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
		return 'ipmchecklist_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ipm_jenis, ipm_list_nourut, ipm_listnama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('ipm_list_nourut, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('ipm_jenis', 'length', 'max'=>50),
			array('ipm_listnama', 'length', 'max'=>100),
			array('ipm_ket', 'length', 'max'=>255),
			array('ipm_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ipmchecklist_id, ipm_jenis, ipm_list_nourut, ipm_listnama, ipm_ket, ipm_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'ipmchecklist_id' => 'ID',
			'ipm_jenis' => 'Jenis IPM Checklist',
			'ipm_list_nourut' => 'No Urut',
			'ipm_listnama' => 'Nama',
			'ipm_ket' => 'Keterangan',
			'ipm_aktif' => 'Aktif',
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

		$criteria->compare('ipmchecklist_id',$this->ipmchecklist_id);
		$criteria->compare('ipm_jenis',$this->ipm_jenis,true);
		$criteria->compare('ipm_list_nourut',$this->ipm_list_nourut);
		$criteria->compare('ipm_listnama',$this->ipm_listnama,true);
		$criteria->compare('ipm_ket',$this->ipm_ket,true);
		$criteria->compare('ipm_aktif',$this->ipm_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
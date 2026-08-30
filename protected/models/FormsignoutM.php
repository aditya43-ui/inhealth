<?php

/**
 * This is the model class for table "formsignout_m".
 *
 * The followings are the available columns in table 'formsignout_m':
 * @property integer $formsignout_id
 * @property string $formsignout_nama
 * @property string $formsignout_namalain
 * @property boolean $haschecklist
 * @property boolean $formsignout_aktif
 * @property integer $formsignout_urutan
 * @property string $formsignout_inputtype
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class FormsignoutM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormsignoutM the static model class
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
		return 'formsignout_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('formsignout_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('formsignout_urutan', 'numerical', 'integerOnly'=>true),
			array('formsignout_nama', 'length', 'max'=>250),
			array('formsignout_namalain', 'length', 'max'=>300),
			array('formsignout_inputtype', 'length', 'max'=>20),
			array('haschecklist, formsignout_aktif, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formsignout_id, formsignout_nama, formsignout_namalain, haschecklist, formsignout_aktif, formsignout_urutan, formsignout_inputtype, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'formsignout_id' => 'Formsignout',
			'formsignout_nama' => 'Formsignout Nama',
			'formsignout_namalain' => 'Formsignout Namalain',
			'haschecklist' => 'Haschecklist',
			'formsignout_aktif' => 'Formsignout Aktif',
			'formsignout_urutan' => 'Formsignout Urutan',
			'formsignout_inputtype' => 'Formsignout Inputtype',
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

		$criteria->compare('formsignout_id',$this->formsignout_id);
		$criteria->compare('formsignout_nama',$this->formsignout_nama,true);
		$criteria->compare('formsignout_namalain',$this->formsignout_namalain,true);
		$criteria->compare('haschecklist',$this->haschecklist);
		$criteria->compare('formsignout_aktif',$this->formsignout_aktif);
		$criteria->compare('formsignout_urutan',$this->formsignout_urutan);
		$criteria->compare('formsignout_inputtype',$this->formsignout_inputtype,true);
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
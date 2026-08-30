<?php

/**
 * This is the model class for table "knowledgebase_m".
 *
 * The followings are the available columns in table 'knowledgebase_m':
 * @property integer $knowledgebase_id
 * @property string $knowledgebase_jenis
 * @property string $knowledgebase_nama
 * @property string $knowledgebase_deskripsi
 * @property boolean $knowledgebase_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class KnowledgebaseM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KnowledgebaseM the static model class
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
		return 'knowledgebase_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('knowledgebase_jenis', 'length', 'max'=>50),
			array('knowledgebase_nama', 'length', 'max'=>255),
			array('knowledgebase_deskripsi, knowledgebase_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('knowledgebase_id, knowledgebase_jenis, knowledgebase_nama, knowledgebase_deskripsi, knowledgebase_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'knowledgebase_id' => 'Knowledgebase',
			'knowledgebase_jenis' => 'Knowledgebase Jenis',
			'knowledgebase_nama' => 'Knowledgebase Nama',
			'knowledgebase_deskripsi' => 'Knowledgebase Deskripsi',
			'knowledgebase_aktif' => 'Knowledgebase Aktif',
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

		$criteria->compare('knowledgebase_id',$this->knowledgebase_id);
		$criteria->compare('knowledgebase_jenis',$this->knowledgebase_jenis,true);
		$criteria->compare('knowledgebase_nama',$this->knowledgebase_nama,true);
		$criteria->compare('knowledgebase_deskripsi',$this->knowledgebase_deskripsi,true);
		$criteria->compare('knowledgebase_aktif',$this->knowledgebase_aktif);
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
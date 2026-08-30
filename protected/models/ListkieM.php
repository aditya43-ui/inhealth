<?php

/**
 * This is the model class for table "listkie_m".
 *
 * The followings are the available columns in table 'listkie_m':
 * @property integer $listkie_id
 * @property string $jeniskie
 * @property string $listkie_nama
 * @property string $listkie_namalain
 * @property boolean $listkie_aktif
 * @property integer $listkie_urutan
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property string $create_time
 * @property string $update_time
 */
class ListkieM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ListkieM the static model class
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
		return 'listkie_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('listkie_urutan, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('jeniskie, listkie_nama, listkie_namalain', 'length', 'max'=>200),
			array('listkie_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('listkie_id, jeniskie, listkie_nama, listkie_namalain, listkie_aktif, listkie_urutan, create_loginpemakai_id, update_loginpemakai_id, create_time, update_time', 'safe', 'on'=>'search'),
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
			'listkie_id' => 'ID',
			'jeniskie' => 'Jenis KIE',
			'listkie_nama' => 'List KIE Nama',
			'listkie_namalain' => 'Nama lainnya',
			'listkie_aktif' => 'Aktif',
			'listkie_urutan' => 'Urutan',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		$criteria->compare('listkie_id',$this->listkie_id);
		$criteria->compare('jeniskie',$this->jeniskie,true);
		$criteria->compare('listkie_nama',$this->listkie_nama,true);
		$criteria->compare('listkie_namalain',$this->listkie_namalain,true);
		$criteria->compare('listkie_aktif',$this->listkie_aktif);
		$criteria->compare('listkie_urutan',$this->listkie_urutan);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

		public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('listkie_id',$this->listkie_id);
		$criteria->compare('jeniskie',$this->jeniskie,true);
		$criteria->compare('listkie_nama',$this->listkie_nama,true);
		$criteria->compare('listkie_namalain',$this->listkie_namalain,true);
		$criteria->compare('listkie_aktif',$this->listkie_aktif);
		$criteria->compare('listkie_urutan',$this->listkie_urutan);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => false
		));
	}
}
<?php

/**
 * This is the model class for table "catatanedikasipenj_t".
 *
 * The followings are the available columns in table 'catatanedikasipenj_t':
 * @property integer $catatanedikasipenj_id
 * @property integer $catatanedukasi_id
 * @property integer $edukasipenjelasan_id
 * @property string $nama_edukasi
 * @property boolean $isceklis
 * @property integer $urutan
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property CatatanedukasiT $catatanedukasi
 * @property EdukasipenjelasanM $edukasipenjelasan
 */
class CatatanedikasipenjT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatatanedikasipenjT the static model class
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
		return 'catatanedikasipenj_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, create_loginpemakai_id', 'required'),
			array('catatanedukasi_id, edukasipenjelasan_id, urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_edukasi, isceklis, update_time, lainnya', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('catatanedikasipenj_id, catatanedukasi_id, edukasipenjelasan_id, nama_edukasi, isceklis, urutan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'catatanedukasi' => array(self::BELONGS_TO, 'CatatanedukasiT', 'catatanedukasi_id'),
			'edukasipenjelasan' => array(self::BELONGS_TO, 'EdukasipenjelasanM', 'edukasipenjelasan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'catatanedikasipenj_id' => 'Catatanedikasipenj',
			'catatanedukasi_id' => 'Catatanedukasi',
			'edukasipenjelasan_id' => 'Edukasipenjelasan',
			'nama_edukasi' => 'Nama Edukasi',
			'isceklis' => 'Isceklis',
			'urutan' => 'Urutan',
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

		$criteria->compare('catatanedikasipenj_id',$this->catatanedikasipenj_id);
		$criteria->compare('catatanedukasi_id',$this->catatanedukasi_id);
		$criteria->compare('edukasipenjelasan_id',$this->edukasipenjelasan_id);
		$criteria->compare('nama_edukasi',$this->nama_edukasi,true);
		$criteria->compare('isceklis',$this->isceklis);
		$criteria->compare('urutan',$this->urutan);
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
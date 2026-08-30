<?php

/**
 * This is the model class for table "invperalatandok_t".
 *
 * The followings are the available columns in table 'invperalatandok_t':
 * @property integer $invperalatandok_id
 * @property integer $invperalatan_id
 * @property string $invperalatandok_no
 * @property string $invperalatandok_nama
 * @property string $invperalatandok_file
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property InvperalatanT $invperalatan
 */
class InvperalatandokT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InvperalatandokT the static model class
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
		return 'invperalatandok_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invperalatandok_no, invperalatandok_nama,', 'required'),
			array('invperalatan_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('invperalatandok_no', 'length', 'max'=>100),
			array('invperalatandok_nama, invperalatandok_file', 'length', 'max'=>255),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('invperalatandok_id, invperalatan_id, invperalatandok_no, invperalatandok_nama, invperalatandok_file, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'invperalatan' => array(self::BELONGS_TO, 'InvperalatanT', 'invperalatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'invperalatandok_id' => 'Invperalatandok',
			'invperalatan_id' => 'Invperalatan',
			'invperalatandok_no' => 'No. Dokumen',
			'invperalatandok_nama' => 'Nama Dokumen',
			'invperalatandok_file' => 'Dokumen',
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

		$criteria->compare('invperalatandok_id',$this->invperalatandok_id);
		$criteria->compare('invperalatan_id',$this->invperalatan_id);
		$criteria->compare('invperalatandok_no',$this->invperalatandok_no,true);
		$criteria->compare('invperalatandok_nama',$this->invperalatandok_nama,true);
		$criteria->compare('invperalatandok_file',$this->invperalatandok_file,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
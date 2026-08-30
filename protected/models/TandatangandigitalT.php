<?php

/**
 * This is the model class for table "tandatangandigital_t".
 *
 * The followings are the available columns in table 'tandatangandigital_t':
 * @property integer $tandatangandigital_id
 * @property string $no_seri
 * @property string $nama_file
 * @property string $path_file
 * @property integer $profilrs_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TandatangandigitaldetT[] $tandatangandigitaldetTs
 */
class TandatangandigitalT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tandatangandigital_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_seri, profilrs_id, create_time, create_loginpemakai, update_loginpemakai', 'required'),
			array('profilrs_id, create_petugaspengisi_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('nama_file, path_file, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tandatangandigital_id, no_seri, nama_file, path_file, profilrs_id, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'tandatangandigitaldetTs' => array(self::HAS_MANY, 'TandatangandigitaldetT', 'tandatangandigital_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tandatangandigital_id' => 'Tandatangandigital',
			'no_seri' => 'No Seri',
			'nama_file' => 'Nama File',
			'path_file' => 'Path File',
			'profilrs_id' => 'Profilrs',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('tandatangandigital_id',$this->tandatangandigital_id);
		$criteria->compare('no_seri',$this->no_seri,true);
		$criteria->compare('nama_file',$this->nama_file,true);
		$criteria->compare('path_file',$this->path_file,true);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TandatangandigitalT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

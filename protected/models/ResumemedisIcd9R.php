<?php

/**
 * This is the model class for table "resumemedis_icd9_r".
 *
 * The followings are the available columns in table 'resumemedis_icd9_r':
 * @property integer $resumemedis_icd9_id
 * @property integer $resumemedis_id
 * @property integer $diagnosaicdix_id
 * @property string $diagnosaicdix_kode
 * @property string $diagnosaicdix_nama
 * @property integer $kelompokdiagnosa_id
 * @property integer $pasienicd9cm_id
 * @property string $create_time
 */
class ResumemedisIcd9R extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'resumemedis_icd9_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resumemedis_id, diagnosaicdix_id, kelompokdiagnosa_id, pasienicd9cm_id', 'numerical', 'integerOnly'=>true),
			array('diagnosaicdix_kode, diagnosaicdix_nama', 'length', 'max'=>255),
			array('create_time, keterangan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('resumemedis_icd9_id, resumemedis_id, diagnosaicdix_id, diagnosaicdix_kode, diagnosaicdix_nama, kelompokdiagnosa_id, pasienicd9cm_id, create_time', 'safe', 'on'=>'search'),
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
			'diagnosatindakan'=>array(self::BELONGS_TO, 'DiagnosaicdixM', 'diagnosaicdix_id'),
			'kelompokdiagnosa'=>array(self::BELONGS_TO,  'KelompokdiagnosaM', 'kelompokdiagnosa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resumemedis_icd9_id' => 'Resumemedis Icd9',
			'resumemedis_id' => 'Resumemedis',
			'diagnosaicdix_id' => 'Diagnosaicdix',
			'diagnosaicdix_kode' => 'Diagnosaicdix Kode',
			'diagnosaicdix_nama' => 'Diagnosaicdix Nama',
			'kelompokdiagnosa_id' => 'Kelompokdiagnosa',
			'pasienicd9cm_id' => 'Pasienicd9cm',
			'create_time' => 'Create Time',
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

		$criteria->compare('resumemedis_icd9_id',$this->resumemedis_icd9_id);
		$criteria->compare('resumemedis_id',$this->resumemedis_id);
		$criteria->compare('diagnosaicdix_id',$this->diagnosaicdix_id);
		$criteria->compare('diagnosaicdix_kode',$this->diagnosaicdix_kode,true);
		$criteria->compare('diagnosaicdix_nama',$this->diagnosaicdix_nama,true);
		$criteria->compare('kelompokdiagnosa_id',$this->kelompokdiagnosa_id);
		$criteria->compare('pasienicd9cm_id',$this->pasienicd9cm_id);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ResumemedisIcd9R the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

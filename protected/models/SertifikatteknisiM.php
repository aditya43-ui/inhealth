<?php

/**
 * This is the model class for table "sertifikatteknisi_m".
 *
 * The followings are the available columns in table 'sertifikatteknisi_m':
 * @property integer $sertifikatteknisi_id
 * @property integer $teknisiperalatan_id
 * @property string $nama_sertifikat
 * @property string $no_sertifikat_teknisi
 * @property string $sertifikat_ket
 * @property string $berlaku_sd
 * @property string $file_sertifikat
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TeknisiperalatanM $teknisiperalatan
 */
class SertifikatteknisiM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SertifikatteknisiM the static model class
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
		return 'sertifikatteknisi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('teknisiperalatan_id, nama_sertifikat, no_sertifikat_teknisi, berlaku_sd, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('teknisiperalatan_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_sertifikat', 'length', 'max'=>50),
			array('no_sertifikat_teknisi', 'length', 'max'=>100),
			//array('file_sertifikat', 'length', 'max'=>500),
			array('sertifikat_ket, update_time', 'safe'),
            array('file_sertifikat','file','safe'=>true, 'allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('sertifikatteknisi_id, teknisiperalatan_id, nama_sertifikat, no_sertifikat_teknisi, sertifikat_ket, berlaku_sd, file_sertifikat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'teknisiperalatan' => array(self::BELONGS_TO, 'TeknisiperalatanM', 'teknisiperalatan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sertifikatteknisi_id' => 'Sertifikatteknisi',
			'teknisiperalatan_id' => 'Teknisiperalatan',
			'nama_sertifikat' => 'Nama Sertifikat',
			'no_sertifikat_teknisi' => 'No Sertifikat Teknisi',
			'sertifikat_ket' => 'Sertifikat Ket',
			'berlaku_sd' => 'Berlaku Sd',
			'file_sertifikat' => 'File Sertifikat',
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

		$criteria->compare('sertifikatteknisi_id',$this->sertifikatteknisi_id);
		$criteria->compare('teknisiperalatan_id',$this->teknisiperalatan_id);
		$criteria->compare('nama_sertifikat',$this->nama_sertifikat,true);
		$criteria->compare('no_sertifikat_teknisi',$this->no_sertifikat_teknisi,true);
		$criteria->compare('sertifikat_ket',$this->sertifikat_ket,true);
		$criteria->compare('berlaku_sd',$this->berlaku_sd,true);
		$criteria->compare('file_sertifikat',$this->file_sertifikat,true);
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
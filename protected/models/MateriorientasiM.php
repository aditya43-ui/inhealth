<?php

/**
 * This is the model class for table "materiorientasi_m".
 *
 * The followings are the available columns in table 'materiorientasi_m':
 * @property integer $materiorientasi_id
 * @property string $materiorientasi_nama
 * @property string $materiorientasi_namalainnya
 * @property string $jenisorientasi
 * @property boolean $materiorientasi_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_ruangan
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 */
class MateriorientasiM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'materiorientasi_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_ruangan, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly'=>true),
			array('materiorientasi_nama, materiorientasi_namalainnya', 'length', 'max'=>200),
			array('jenisorientasi', 'length', 'max'=>50),
			array('materiorientasi_aktif, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('materiorientasi_id, materiorientasi_nama, materiorientasi_namalainnya, jenisorientasi, materiorientasi_aktif, create_time, update_time, create_ruangan, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'materiorientasi_id' => 'ID',
			'materiorientasi_nama' => 'Materi Orientasi',
			'materiorientasi_namalainnya' => 'Nama Lainnya',
			'jenisorientasi' => 'Jenis Orientasi',
			'materiorientasi_aktif' => 'Materiorientasi Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_ruangan' => 'Create Ruangan',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('lower(materiorientasi_nama)',strtolower($this->materiorientasi_nama),true);
		$criteria->compare('lower(materiorientasi_namalainnya)',strtolower($this->materiorientasi_namalainnya),true);
		$criteria->compare('jenisorientasi',$this->jenisorientasi);
		$criteria->compare('materiorientasi_aktif',$this->materiorientasi_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lower(materiorientasi_nama)',strtolower($this->materiorientasi_nama),true);
		$criteria->compare('lower(materiorientasi_namalainnya)',strtolower($this->materiorientasi_namalainnya),true);
		$criteria->compare('jenisorientasi',$this->jenisorientasi);
		$criteria->compare('materiorientasi_aktif',$this->materiorientasi_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MateriorientasiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

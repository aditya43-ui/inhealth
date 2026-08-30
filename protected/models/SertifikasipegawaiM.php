<?php

/**
 * This is the model class for table "sertifikasipegawai_m".
 *
 * The followings are the available columns in table 'sertifikasipegawai_m':
 * @property integer $sertifikasipegawai_id
 * @property string $sertifikasipegawai_nama
 * @property string $sertifikasipegawai_namalainnya
 * @property boolean $sertifikasipegawai_aktif
 */
class SertifikasipegawaiM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sertifikasipegawai_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sertifikasipegawai_nama, sertifikasipegawai_namalainnya', 'length', 'max'=>200),
			array('sertifikasipegawai_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sertifikasipegawai_id, sertifikasipegawai_nama, sertifikasipegawai_namalainnya, sertifikasipegawai_aktif', 'safe', 'on'=>'search'),
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
			'sertifikasipegawai_id' => 'Sertifikasipegawai',
			'sertifikasipegawai_nama' => 'Nama Jenis Sertifikasi Karyawan',
			'sertifikasipegawai_namalainnya' => 'Nama Lainnya',
			'sertifikasipegawai_aktif' => 'Sertifikasipegawai Aktif',
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

		$criteria->compare('lower(sertifikasipegawai_nama)',strtolower($this->sertifikasipegawai_nama),true);
		$criteria->compare('lower(sertifikasipegawai_namalainnya)',strtolower($this->sertifikasipegawai_namalainnya),true);
		$criteria->compare('sertifikasipegawai_aktif',$this->sertifikasipegawai_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lower(sertifikasipegawai_nama)',strtolower($this->sertifikasipegawai_nama),true);
		$criteria->compare('lower(sertifikasipegawai_namalainnya)',strtolower($this->sertifikasipegawai_namalainnya),true);
		$criteria->compare('sertifikasipegawai_aktif',$this->sertifikasipegawai_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SertifikasipegawaiM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

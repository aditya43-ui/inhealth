<?php

/**
 * This is the model class for table "jenisvaksin_m".
 *
 * The followings are the available columns in table 'jenisvaksin_m':
 * @property integer $jenisvaksin_id
 * @property string $jenisvaksin_nama
 * @property string $jenisvaksin_namalainnya
 * @property boolean $isadakelompok_vaksin
 * @property integer $jenisvaksinkelompok_id
 * @property boolean $jenisvaksin_aktif
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property VaksinM[] $vaksinMs
 */
class JenisvaksinM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'jenisvaksin_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisvaksin_nama, create_time, create_loginpemakai', 'required'),
			array('jenisvaksinkelompok_id, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('jenisvaksin_namalainnya, isadakelompok_vaksin, jenisvaksin_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('jenisvaksin_id, jenisvaksin_nama, jenisvaksin_namalainnya, isadakelompok_vaksin, jenisvaksinkelompok_id, jenisvaksin_aktif, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'vaksinMs' => array(self::HAS_MANY, 'VaksinM', 'jenisvaksin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'jenisvaksin_id' => 'Jenisvaksin',
			'jenisvaksin_nama' => 'Nama Jenis Vaksin',
			'jenisvaksin_namalainnya' => 'Nama Lain Jenis Vaksin',
			'isadakelompok_vaksin' => 'Ada Kelompok Jenis Vaksin',
			'jenisvaksinkelompok_id' => 'Nama Kelompok Jenis Vaksin',
			'jenisvaksin_aktif' => 'Jenisvaksin Aktif',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('jenisvaksin_id',$this->jenisvaksin_id);
		$criteria->compare('jenisvaksin_nama',$this->jenisvaksin_nama,true);
		$criteria->compare('jenisvaksin_namalainnya',$this->jenisvaksin_namalainnya,true);
		$criteria->compare('isadakelompok_vaksin',$this->isadakelompok_vaksin);
		$criteria->compare('jenisvaksinkelompok_id',$this->jenisvaksinkelompok_id);
		$criteria->compare('jenisvaksin_aktif',$this->jenisvaksin_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JenisvaksinM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

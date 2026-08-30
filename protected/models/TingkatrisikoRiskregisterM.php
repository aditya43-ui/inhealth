<?php

/**
 * This is the model class for table "tingkatrisiko_riskregister_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'tingkatrisiko_riskregister_m':
 * @property integer $tingkatrisiko_riskregister_id
 * @property string $tingkatrisiko_nama
 * @property string $tingkatrisiko_batasbawah
 * @property string $tingkatrisiko_batasatas
 * @property string $tingkatrisiko_warna
 * @property string $tingkatrisiko_tindakan
 * @property integer $tingkatrisiko_urutan
 * @property boolean $tingkatrisiko_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class TingkatrisikoRiskregisterM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TingkatrisikoRiskregisterM the static model class
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
		return 'tingkatrisiko_riskregister_m';
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
			array('tingkatrisiko_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('tingkatrisiko_nama', 'length', 'max'=>150),
			array('tingkatrisiko_batasbawah, tingkatrisiko_batasatas, tingkatrisiko_warna', 'length', 'max'=>100),
			array('tingkatrisiko_tindakan, tingkatrisiko_aktif, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tingkatrisiko_riskregister_id, tingkatrisiko_nama, tingkatrisiko_batasbawah, tingkatrisiko_batasatas, tingkatrisiko_warna, tingkatrisiko_tindakan, tingkatrisiko_urutan, tingkatrisiko_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'tingkatrisiko_riskregister_id' => 'Tingkatrisiko Riskregister',
			'tingkatrisiko_nama' => 'Tingkat Risiko',
			'tingkatrisiko_batasbawah' => 'Tingkatrisiko Batasbawah',
			'tingkatrisiko_batasatas' => 'Tingkatrisiko Batasatas',
			'tingkatrisiko_warna' => 'Warna Risiko',
			'tingkatrisiko_tindakan' => 'Tingkatrisiko Tindakan',
			'tingkatrisiko_urutan' => 'Tingkatrisiko Urutan',
			'tingkatrisiko_aktif' => 'Tingkatrisiko Aktif',
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

		$criteria->compare('tingkatrisiko_riskregister_id',$this->tingkatrisiko_riskregister_id);
		$criteria->compare('tingkatrisiko_nama',$this->tingkatrisiko_nama,true);
		$criteria->compare('tingkatrisiko_batasbawah',$this->tingkatrisiko_batasbawah,true);
		$criteria->compare('tingkatrisiko_batasatas',$this->tingkatrisiko_batasatas,true);
		$criteria->compare('tingkatrisiko_warna',$this->tingkatrisiko_warna,true);
		$criteria->compare('tingkatrisiko_tindakan',$this->tingkatrisiko_tindakan,true);
		$criteria->compare('tingkatrisiko_urutan',$this->tingkatrisiko_urutan);
		$criteria->compare('tingkatrisiko_aktif',$this->tingkatrisiko_aktif);
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
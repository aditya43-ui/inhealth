<?php

/**
 * This is the model class for table "tingkatrisiko_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'tingkatrisiko_m':
 * @property integer $tingkatrisiko_id
 * @property string $tingkatrisiko_nama
 * @property string $tingkatrisiko_nilai
 * @property string $tingkatrisiko_warna
 * @property string $tingkatrisiko_tindakan
 * @property integer $tingkatrisiko_urutan
 * @property boolean $tingkatrisiko_aktif
 *
 * The followings are the available model relations:
 * @property GradingrisikoM[] $gradingrisikoMs
 */
class TingkatrisikoM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TingkatrisikoM the static model class
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
		return 'tingkatrisiko_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tingkatrisiko_urutan', 'numerical', 'integerOnly'=>true),
			array('tingkatrisiko_nama', 'length', 'max'=>150),
			array('tingkatrisiko_nilai, tingkatrisiko_warna', 'length', 'max'=>100),
			array('tingkatrisiko_tindakan, tingkatrisiko_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tingkatrisiko_id, tingkatrisiko_nama, tingkatrisiko_nilai, tingkatrisiko_warna, tingkatrisiko_tindakan, tingkatrisiko_urutan, tingkatrisiko_aktif', 'safe', 'on'=>'search'),
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
			'gradingrisikoMs' => array(self::HAS_MANY, 'GradingrisikoM', 'tingkatrisiko_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tingkatrisiko_id' => 'Tingkat Risiko',
			'tingkatrisiko_nama' => 'Tingkat Risiko',
			'tingkatrisiko_nilai' => 'Skor Risiko',
			'tingkatrisiko_warna' => 'Warna Risiko',
			'tingkatrisiko_tindakan' => 'Tindakan',
			'tingkatrisiko_urutan' => 'Urutan',
			'tingkatrisiko_aktif' => 'Status',
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

		$criteria->compare('tingkatrisiko_id',$this->tingkatrisiko_id);
		$criteria->compare('tingkatrisiko_nama',$this->tingkatrisiko_nama,true);
		$criteria->compare('tingkatrisiko_nilai',$this->tingkatrisiko_nilai,true);
		$criteria->compare('tingkatrisiko_warna',$this->tingkatrisiko_warna,true);
		$criteria->compare('tingkatrisiko_tindakan',$this->tingkatrisiko_tindakan,true);
		$criteria->compare('tingkatrisiko_urutan',$this->tingkatrisiko_urutan);
		$criteria->compare('tingkatrisiko_aktif',isset($this->tingkatrisiko_aktif)?$this->tingkatrisiko_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "perioderiskregister_m".
 * @author Yusuf Putra Anugrah<yusufputra@.com>
 * @package application.models
 * The followings are the available columns in table 'perioderiskregister_m':
 * @property integer $perioderiskregister_id
 * @property string $nama_perioderiskregister
 * @property string $periode_awal
 * @property string $periode_akhir
 * @property boolean $perioderiskregister_aktif
 */
class PerioderiskregisterM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerioderiskregisterM the static model class
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
		return 'perioderiskregister_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_perioderiskregister, periode_awal, periode_akhir', 'required'),
			array('nama_perioderiskregister', 'length', 'max'=>150),
			array('perioderiskregister_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perioderiskregister_id, nama_perioderiskregister, periode_awal, periode_akhir, perioderiskregister_aktif', 'safe', 'on'=>'search'),
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
			'perioderiskregister_id' => 'Perioderiskregister',
			'nama_perioderiskregister' => 'Nama Perioderiskregister',
			'periode_awal' => 'Periode Awal',
			'periode_akhir' => 'Periode Akhir',
			'perioderiskregister_aktif' => 'Aktif',
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

		$criteria->compare('perioderiskregister_id',$this->perioderiskregister_id);
		$criteria->compare('nama_perioderiskregister',$this->nama_perioderiskregister,true);
                if(!empty($this->periode_awal) && !empty($this->periode_akhir)){
                    $criteria->addBetweenCondition("periode_awal", $this->periode_awal, $this->periode_akhir);
                }
                $criteria->compare('perioderiskregister_aktif',$this->perioderiskregister_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
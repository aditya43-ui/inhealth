<?php

/**
 * This is the model class for table "aksesvaskular_m".
 *
 * The followings are the available columns in table 'aksesvaskular_m':
 * @property integer $aksesvaskular_id
 * @property string $aksesvaskular_nama
 * @property string $aksesvaskular_namalain
 * @property string $aksesvaskular_deskripsi
 * @property boolean $aksesvaskular_aktif
 */
class AksesvaskularM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AksesvaskularM the static model class
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
		return 'aksesvaskular_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('aksesvaskular_nama, aksesvaskular_namalain, aksesvaskular_aktif', 'required'),
			array('aksesvaskular_nama, aksesvaskular_namalain', 'length', 'max'=>50),
			array('aksesvaskular_deskripsi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('aksesvaskular_id, aksesvaskular_nama, aksesvaskular_namalain, aksesvaskular_deskripsi, aksesvaskular_aktif', 'safe', 'on'=>'search'),
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
			'aksesvaskular_id' => 'Akses Vaskular',
			'aksesvaskular_nama' => 'Nama Akses Vaskular ',
			'aksesvaskular_namalain' => 'Nama Lain Akses Vaskular ',
			'aksesvaskular_deskripsi' => 'Deskripsi Akses Vaskular ',
			'aksesvaskular_aktif' => 'Akses Vaskular Aktif',
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

		$criteria->compare('aksesvaskular_id',$this->aksesvaskular_id);
		$criteria->compare('aksesvaskular_nama',$this->aksesvaskular_nama,true);
		$criteria->compare('aksesvaskular_namalain',$this->aksesvaskular_namalain,true);
		$criteria->compare('aksesvaskular_deskripsi',$this->aksesvaskular_deskripsi,true);
		$criteria->compare('aksesvaskular_aktif',$this->aksesvaskular_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
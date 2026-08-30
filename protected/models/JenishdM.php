<?php

/**
 * This is the model class for table "jenishd_m".
 *
 * The followings are the available columns in table 'jenishd_m':
 * @property integer $jenishd_id
 * @property string $jenishd_nama
 * @property string $jenishd_namalain
 * @property string $jenishd_deskripsi
 * @property boolean $jenishd_aktif
 */
class JenishdM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenishdM the static model class
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
		return 'jenishd_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenishd_nama, jenishd_namalain, jenishd_aktif', 'required'),
			array('jenishd_nama, jenishd_namalain', 'length', 'max'=>50),
			array('jenishd_deskripsi', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenishd_id, jenishd_nama, jenishd_namalain, jenishd_deskripsi, jenishd_aktif', 'safe', 'on'=>'search'),
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
			'jenishd_id' => 'Jenis HD',
			'jenishd_nama' => 'Nama Jenis HD',
			'jenishd_namalain' => 'Nama Lain Jenis HD',
			'jenishd_deskripsi' => 'Deskripsi Jenis HD',
			'jenishd_aktif' => 'Jenis HD Aktif',
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

		$criteria->compare('jenishd_id',$this->jenishd_id);
		$criteria->compare('jenishd_nama',$this->jenishd_nama,true);
		$criteria->compare('jenishd_namalain',$this->jenishd_namalain,true);
		$criteria->compare('jenishd_deskripsi',$this->jenishd_deskripsi,true);
		$criteria->compare('jenishd_aktif',$this->jenishd_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
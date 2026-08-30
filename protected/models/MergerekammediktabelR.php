<?php

/**
 * This is the model class for table "mergerekammediktabel_r".
 *
 * The followings are the available columns in table 'mergerekammediktabel_r':
 * @property integer $mergerekammediktabel_id
 * @property integer $mergerekammedik_id
 * @property string $nama_tabel
 * @property double $jumlah_data
 */
class MergerekammediktabelR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MergerekammediktabelR the static model class
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
		return 'mergerekammediktabel_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mergerekammedik_id', 'required'),
			array('mergerekammedik_id', 'numerical', 'integerOnly'=>true),
			array('jumlah_data', 'numerical'),
			array('nama_tabel', 'length', 'max'=>250),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('mergerekammediktabel_id, mergerekammedik_id, nama_tabel, jumlah_data', 'safe', 'on'=>'search'),
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
			'mergerekammediktabel_id' => 'Mergerekammediktabel',
			'mergerekammedik_id' => 'Mergerekammedik',
			'nama_tabel' => 'Nama Tabel',
			'jumlah_data' => 'Jumlah Data',
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

		$criteria->compare('mergerekammediktabel_id',$this->mergerekammediktabel_id);
		$criteria->compare('mergerekammedik_id',$this->mergerekammedik_id);
		$criteria->compare('nama_tabel',$this->nama_tabel,true);
		$criteria->compare('jumlah_data',$this->jumlah_data);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
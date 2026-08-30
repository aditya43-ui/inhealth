<?php

/**
 * This is the model class for table "jenisskrining_m".
 *
 * The followings are the available columns in table 'jenisskrining_m':
 * @property integer $jenisskrining_id
 * @property string $jenisskrining_kode
 * @property string $nama_jenisskrining
 * @property string $nama_lainnya
 * @property boolean $status_jenisskringin
 * @property integer $urutan_skrining
 * @property string $create_time
 */
class JenisskriningM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisskriningM the static model class
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
		return 'jenisskrining_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisskrining_kode, nama_jenisskrining, nama_lainnya, urutan_skrining', 'required'),
			array('urutan_skrining', 'numerical', 'integerOnly'=>true),
			array('jenisskrining_kode', 'length', 'max'=>20),
			array('nama_jenisskrining, nama_lainnya', 'length', 'max'=>100),
			array('status_jenisskringin, create_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenisskrining_id, jenisskrining_kode, nama_jenisskrining, nama_lainnya, status_jenisskringin, urutan_skrining, create_time', 'safe', 'on'=>'search'),
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
			'jenisskrining_id' => 'Jenisskrining',
			'jenisskrining_kode' => 'Jenis Skrining Kode',
			'nama_jenisskrining' => 'Nama Jenis Skrining',
			'nama_lainnya' => 'Nama Lainnya',
			'status_jenisskringin' => 'Status Jenisskringin',
			'urutan_skrining' => 'Jenis Skrining Urutan',
			'create_time' => 'Create Time',
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

		$criteria->compare('lower(nama_jenisskrining)',strtolower($this->nama_jenisskrining),true);
		$criteria->compare('status_jenisskringin',isset($this->status_jenisskringin)?$this->status_jenisskringin:true);
		// $criteria->compare('jenisskrining_id',$this->jenisskrining_id);
		// $criteria->compare('jenisskrining_kode',$this->jenisskrining_kode,true);
		// $criteria->compare('nama_jenisskrining',$this->nama_jenisskrining,true);
		// $criteria->compare('nama_lainnya',$this->nama_lainnya,true);
		// $criteria->compare('status_jenisskringin',$this->status_jenisskringin);
		// $criteria->compare('urutan_skrining',$this->urutan_skrining);
		// $criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lower(nama_jenisskrining)',strtolower($this->nama_jenisskrining),true);
		$criteria->compare('status_jenisskringin',isset($this->status_jenisskringin)?$this->status_jenisskringin:true);
		// $criteria->compare('jenisskrining_id',$this->jenisskrining_id);
		// $criteria->compare('jenisskrining_kode',$this->jenisskrining_kode,true);
		// $criteria->compare('nama_jenisskrining',$this->nama_jenisskrining,true);
		// $criteria->compare('nama_lainnya',$this->nama_lainnya,true);
		// $criteria->compare('status_jenisskringin',$this->status_jenisskringin);
		// $criteria->compare('urutan_skrining',$this->urutan_skrining);
		// $criteria->compare('create_time',$this->create_time,true);
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
}

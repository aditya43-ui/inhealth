<?php

/**
 * This is the model class for table "dataskrining_m".
 *
 * The followings are the available columns in table 'dataskrining_m':
 * @property integer $dataskrining_id
 * @property integer $jenisskrining_id
 * @property string $nama_skrining
 * @property string $nama_lainnya
 * @property integer $urutan_skrining
 * @property boolean $status_dataskrining
 * @property string $create_time
 *
 * The followings are the available model relations:
 * @property JenisskriningM $jenisskrining
 * @property PerencanaanevaluasiT[] $perencanaanevaluasiTs
 */
class DataskriningM extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'dataskrining_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenisskrining_id, nama_skrining, nama_lainnya, urutan_skrining', 'required'),
			array('jenisskrining_id, urutan_skrining', 'numerical', 'integerOnly'=>true),
			array('nama_skrining, nama_lainnya', 'length', 'max'=>100),
			array('status_dataskrining, create_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dataskrining_id, jenisskrining_id, nama_skrining, nama_lainnya, urutan_skrining, status_dataskrining, create_time', 'safe', 'on'=>'search'),
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
			'jenisskrining' => array(self::BELONGS_TO, 'JenisskriningM', 'jenisskrining_id'),
			'perencanaanevaluasiTs' => array(self::HAS_MANY, 'PerencanaanevaluasiT', 'dataskrining_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dataskrining_id' => 'Dataskrining',
			'jenisskrining_id' => 'Jenisskrining',
			'nama_skrining' => 'Nama Skrining',
			'nama_lainnya' => 'Nama Lainnya',
			'urutan_skrining' => 'Urutan Skrining',
			'status_dataskrining' => 'Status Dataskrining',
			'create_time' => 'Create Time',
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

		$criteria->compare('dataskrining_id',$this->dataskrining_id);
		$criteria->compare('jenisskrining_id',$this->jenisskrining_id);
		$criteria->compare('nama_skrining',$this->nama_skrining,true);
		$criteria->compare('nama_lainnya',$this->nama_lainnya,true);
		$criteria->compare('urutan_skrining',$this->urutan_skrining);
		$criteria->compare('status_dataskrining',$this->status_dataskrining);
		$criteria->compare('create_time',$this->create_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DataskriningM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

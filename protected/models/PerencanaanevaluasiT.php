<?php

/**
 * This is the model class for table "perencanaanevaluasi_t".
 *
 * The followings are the available columns in table 'perencanaanevaluasi_t':
 * @property integer $perencanaanevaluasi_id
 * @property integer $skriningpasien_id
 * @property integer $jenisskrining_id
 * @property integer $dataskrining_id
 * @property string $nama_perencanaan
 * @property string $nama_lainnya
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property SkriningpasienT $skriningpasien
 * @property JenisskriningM $jenisskrining
 * @property DataskriningM $dataskrining
 */
class PerencanaanevaluasiT extends CActiveRecord
{
	public $ischeckboxSkrining;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerencanaanevaluasiT the static model class
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
		return 'perencanaanevaluasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('skriningpasien_id, jenisskrining_id, dataskrining_id, create_time', 'required'),
			array('skriningpasien_id, jenisskrining_id, dataskrining_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_perencanaan, create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('nama_lainnya, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('perencanaanevaluasi_id, skriningpasien_id, jenisskrining_id, dataskrining_id, nama_perencanaan, nama_lainnya, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'skriningpasien' => array(self::BELONGS_TO, 'SkriningpasienT', 'skriningpasien_id'),
			'jenisskrining' => array(self::BELONGS_TO, 'JenisskriningM', 'jenisskrining_id'),
			'dataskrining' => array(self::BELONGS_TO, 'DataskriningM', 'dataskrining_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'perencanaanevaluasi_id' => 'Perencanaanevaluasi',
			'skriningpasien_id' => 'Skriningpasien',
			'jenisskrining_id' => 'Jenisskrining',
			'dataskrining_id' => 'Dataskrining',
			'nama_perencanaan' => 'Nama Perencanaan',
			'nama_lainnya' => 'Nama Lainnya',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
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

		$criteria->compare('perencanaanevaluasi_id',$this->perencanaanevaluasi_id);
		$criteria->compare('skriningpasien_id',$this->skriningpasien_id);
		$criteria->compare('jenisskrining_id',$this->jenisskrining_id);
		$criteria->compare('dataskrining_id',$this->dataskrining_id);
		$criteria->compare('nama_perencanaan',$this->nama_perencanaan,true);
		$criteria->compare('nama_lainnya',$this->nama_lainnya,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

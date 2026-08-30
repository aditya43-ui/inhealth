<?php

/**
 * This is the model class for table "serahterima_t".
 *
 * The followings are the available columns in table 'serahterima_t':
 * @property integer $serahterima_id
 * @property integer $monitoringtranfusidarah_id
 * @property string $nama_serahterima
 * @property string $penjelasan
 * @property boolean $is_petugasbankdarah
 * @property string $petugas_bankdarah
 * @property boolean $is_perawat
 * @property string $nama_perawat
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property MonitoringtranfusidarahT $monitoringtranfusidarah
 */
class SerahterimaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SerahterimaT the static model class
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
		return 'serahterima_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('monitoringtranfusidarah_id, nama_serahterima, penjelasan, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('monitoringtranfusidarah_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_serahterima, petugas_bankdarah, nama_perawat', 'length', 'max'=>100),
			array('is_petugasbankdarah, is_perawat, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('serahterima_id, monitoringtranfusidarah_id, nama_serahterima, penjelasan, is_petugasbankdarah, petugas_bankdarah, is_perawat, nama_perawat, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'monitoringtranfusidarah' => array(self::BELONGS_TO, 'MonitoringtranfusidarahT', 'monitoringtranfusidarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'serahterima_id' => 'Serahterima',
			'monitoringtranfusidarah_id' => 'Monitoringtranfusidarah',
			'nama_serahterima' => 'Nama Serahterima',
			'penjelasan' => 'Penjelasan',
			'is_petugasbankdarah' => 'Is Petugasbankdarah',
			'petugas_bankdarah' => 'Petugas Bankdarah',
			'is_perawat' => 'Is Perawat',
			'nama_perawat' => 'Nama Perawat',
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

		$criteria->compare('serahterima_id',$this->serahterima_id);
		$criteria->compare('monitoringtranfusidarah_id',$this->monitoringtranfusidarah_id);
		$criteria->compare('nama_serahterima',$this->nama_serahterima,true);
		$criteria->compare('penjelasan',$this->penjelasan,true);
		$criteria->compare('is_petugasbankdarah',$this->is_petugasbankdarah);
		$criteria->compare('petugas_bankdarah',$this->petugas_bankdarah,true);
		$criteria->compare('is_perawat',$this->is_perawat);
		$criteria->compare('nama_perawat',$this->nama_perawat,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
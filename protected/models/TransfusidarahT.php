<?php

/**
 * This is the model class for table "transfusidarah_t".
 *
 * The followings are the available columns in table 'transfusidarah_t':
 * @property integer $transfusidarah_id
 * @property integer $monitoringtranfusidarah_id
 * @property string $waktu_transfusi
 * @property string $kondisi_transfusidarah
 * @property string $deskripsi
 * @property boolean $is_tandareaksi
 * @property string $waktu_tranfusi
 * @property string $jam_transfusi
 * @property string $petugas
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property MonitoringtranfusidarahT $monitoringtranfusidarah
 * @property TransfusidarahdetT[] $transfusidarahdetTs
 */
class TransfusidarahT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TransfusidarahT the static model class
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
		return 'transfusidarah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('monitoringtranfusidarah_id, kondisi_transfusidarah, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('monitoringtranfusidarah_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('kondisi_transfusidarah, deskripsi, waktu_tranfusi, petugas', 'length', 'max'=>100),
			array('is_tandareaksi, jam_transfusi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('transfusidarah_id, monitoringtranfusidarah_id, waktu_transfusi, kondisi_transfusidarah, deskripsi, is_tandareaksi, waktu_tranfusi, jam_transfusi, petugas, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'transfusidarahdetTs' => array(self::HAS_MANY, 'TransfusidarahdetT', 'transfusidarah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'transfusidarah_id' => 'Transfusidarah',
			'monitoringtranfusidarah_id' => 'Monitoringtranfusidarah',
			'waktu_transfusi' => 'Waktu Transfusi',
			'kondisi_transfusidarah' => 'Kondisi Transfusidarah',
			'deskripsi' => 'Deskripsi',
			'is_tandareaksi' => 'Is Tandareaksi',
			'waktu_tranfusi' => 'Waktu Tranfusi',
			'jam_transfusi' => 'Jam Transfusi',
			'petugas' => 'Petugas',
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

		$criteria->compare('transfusidarah_id',$this->transfusidarah_id);
		$criteria->compare('monitoringtranfusidarah_id',$this->monitoringtranfusidarah_id);
		$criteria->compare('waktu_transfusi',$this->waktu_transfusi,true);
		$criteria->compare('kondisi_transfusidarah',$this->kondisi_transfusidarah,true);
		$criteria->compare('deskripsi',$this->deskripsi,true);
		$criteria->compare('is_tandareaksi',$this->is_tandareaksi);
		$criteria->compare('waktu_tranfusi',$this->waktu_tranfusi,true);
		$criteria->compare('jam_transfusi',$this->jam_transfusi,true);
		$criteria->compare('petugas',$this->petugas,true);
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
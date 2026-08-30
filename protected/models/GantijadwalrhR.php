<?php

/**
 * This is the model class for table "gantijadwalrh_r".
 *
 * The followings are the available columns in table 'gantijadwalrh_r':
 * @property integer $gantijadwalrh_id
 * @property integer $pasien_id
 * @property string $gantijadwalrh_tgl
 * @property string $gantijadwalrh_alasan
 * @property string $gantijadwalrh_desc
 * @property string $gantijadwalrh_tglsblmnya
 * @property string $gjrh_create_time
 * @property string $gjrh_update_time
 * @property integer $gjrh_create_loginid
 * @property integer $gjrh_update_loginid
 * @property integer $gjrh_create_ruangan_id
 * @property string $gjrh_create_iphost
 */
class GantijadwalrhR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GantijadwalrhR the static model class
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
		return 'gantijadwalrh_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gantijadwalrh_tgl, gantijadwalrh_alasan, gantijadwalrh_tglsblmnya, gjrh_create_time, gjrh_create_loginid, gjrh_create_ruangan_id, gjrh_create_iphost', 'required'),
			array('pasien_id, gjrh_create_loginid, gjrh_update_loginid, gjrh_create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('gantijadwalrh_alasan', 'length', 'max'=>100),
			array('gjrh_create_iphost', 'length', 'max'=>50),
			array('gantijadwalrh_desc, gjrh_update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gantijadwalrh_id, pasien_id, gantijadwalrh_tgl, gantijadwalrh_alasan, gantijadwalrh_desc, gantijadwalrh_tglsblmnya, gjrh_create_time, gjrh_update_time, gjrh_create_loginid, gjrh_update_loginid, gjrh_create_ruangan_id, gjrh_create_iphost', 'safe', 'on'=>'search'),
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
			'gantijadwalrh_id' => 'Gantijadwalrh',
			'pasien_id' => 'Pasien',
			'gantijadwalrh_tgl' => 'Tanggal Ubah',
			'gantijadwalrh_alasan' => 'Alasan Ubah',
			'gantijadwalrh_desc' => 'Deskripsi',
			'gantijadwalrh_tglsblmnya' => 'Tgl. Sebelumnya',
			'gjrh_create_time' => 'Gjrh Create Time',
			'gjrh_update_time' => 'Gjrh Update Time',
			'gjrh_create_loginid' => 'Gjrh Create Loginid',
			'gjrh_update_loginid' => 'Gjrh Update Loginid',
			'gjrh_create_ruangan_id' => 'Gjrh Create Ruangan',
			'gjrh_create_iphost' => 'Gjrh Create Iphost',
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

		$criteria->compare('gantijadwalrh_id',$this->gantijadwalrh_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('gantijadwalrh_tgl',$this->gantijadwalrh_tgl,true);
		$criteria->compare('gantijadwalrh_alasan',$this->gantijadwalrh_alasan,true);
		$criteria->compare('gantijadwalrh_desc',$this->gantijadwalrh_desc,true);
		$criteria->compare('gantijadwalrh_tglsblmnya',$this->gantijadwalrh_tglsblmnya,true);
		$criteria->compare('gjrh_create_time',$this->gjrh_create_time,true);
		$criteria->compare('gjrh_update_time',$this->gjrh_update_time,true);
		$criteria->compare('gjrh_create_loginid',$this->gjrh_create_loginid);
		$criteria->compare('gjrh_update_loginid',$this->gjrh_update_loginid);
		$criteria->compare('gjrh_create_ruangan_id',$this->gjrh_create_ruangan_id);
		$criteria->compare('gjrh_create_iphost',$this->gjrh_create_iphost,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
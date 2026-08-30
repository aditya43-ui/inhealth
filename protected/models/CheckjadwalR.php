<?php

/**
 * This is the model class for table "checkjadwal_r".
 *
 * The followings are the available columns in table 'checkjadwal_r':
 * @property integer $checkjadwal_id
 * @property integer $pegawai_id
 * @property integer $pendaftaran_id
 * @property string $check_ipsegment
 * @property string $check_port
 * @property string $check_poliklinik
 * @property boolean $check_status
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 */
class CheckjadwalR extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'checkjadwal_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, create_time, create_loginpemakai_id', 'required'),
			array('pegawai_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('check_ipsegment', 'length', 'max'=>50),
			array('check_port, check_poliklinik', 'length', 'max'=>20),
			array('check_status, update_time, update_loginpemakai_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('checkjadwal_id, pegawai_id, pendaftaran_id, check_ipsegment, check_port, check_poliklinik, check_status, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'checkjadwal_id' => 'Checkjadwal',
			'pegawai_id' => 'Dokter Pemeriksa',
			'pendaftaran_id' => 'Pendaftaran',
			'check_ipsegment' => 'Ip Segment',
			'check_port' => 'Port',
			'check_poliklinik' => 'Poliklinik',
			'check_status' => 'Check Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
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

		$criteria->compare('checkjadwal_id',$this->checkjadwal_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('check_ipsegment',$this->check_ipsegment,true);
		$criteria->compare('check_port',$this->check_port,true);
		$criteria->compare('check_poliklinik',$this->check_poliklinik,true);
		$criteria->compare('check_status',$this->check_status,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CheckjadwalR the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getRuanganItems($instalasi=null)
        {
            if($instalasi != null)
            {
                return RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi,'ruangan_aktif'=>true),array('order'=>'ruangan_nama'));
            }
            else{
                return RuanganM::model()->findAll(array('order'=>'ruangan_nama', 'condition'=>'ruangan_aktif = true'));
            }
        }  
}

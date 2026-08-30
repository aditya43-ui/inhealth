<?php

/**
 * This is the model class for table "loginaktivasi_k".
 *
 * The followings are the available columns in table 'loginaktivasi_k':
 * @property integer $loginaktivasi_id
 * @property string $loginaktivasi_nomobile
 * @property string $loginaktivasi_email
 * @property string $loginaktivasi_token
 * @property string $loginaktivasi_expired
 * @property boolean $loginaktivasi_active
 * @property integer $loginpemakai_id
 * @property integer $pasien_id
 * @property integer $pegawai_id
 * @property string $jenis_verif
 * @property string $create_time
 * @property integer $create_loginpemakai_id
 * @property string $update_time
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $create_iphost
 *
 * The followings are the available model relations:
 * @property LoginpemakaiK $loginpemakai
 */
class LoginaktivasiK extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LoginaktivasiK the static model class
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
		return 'loginaktivasi_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('loginaktivasi_token, loginaktivasi_expired, create_time, create_loginpemakai_id, create_ruangan, create_iphost', 'required'),
			array('loginpemakai_id, pasien_id, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('loginaktivasi_nomobile, jenis_verif', 'length', 'max'=>20),
			array('loginaktivasi_email', 'length', 'max'=>50),
			array('loginaktivasi_token', 'length', 'max'=>150),
			array('create_iphost', 'length', 'max'=>100),
			array('loginaktivasi_active, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('loginaktivasi_id, loginaktivasi_nomobile, loginaktivasi_email, loginaktivasi_token, loginaktivasi_expired, loginaktivasi_active, loginpemakai_id, pasien_id, pegawai_id, jenis_verif, create_time, create_loginpemakai_id, update_time, update_loginpemakai_id, create_ruangan, create_iphost', 'safe', 'on'=>'search'),
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
			'loginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'loginpemakai_id'),
                        'pasien'=>array(self::BELONGS_TO,'PasienM','pasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'loginaktivasi_id' => 'Loginaktivasi',
			'loginaktivasi_nomobile' => 'Loginaktivasi Nomobile',
			'loginaktivasi_email' => 'Loginaktivasi Email',
			'loginaktivasi_token' => 'Loginaktivasi Token',
			'loginaktivasi_expired' => 'Loginaktivasi Expired',
			'loginaktivasi_active' => 'Loginaktivasi Active',
			'loginpemakai_id' => 'Loginpemakai',
			'pasien_id' => 'Pasien',
			'pegawai_id' => 'Pegawai',
			'jenis_verif' => 'Jenis Verif',
			'create_time' => 'Waktu Create',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_time' => 'Waktu Update',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'create_iphost' => 'Create Iphost',
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

		$criteria->compare('loginaktivasi_id',$this->loginaktivasi_id);
		$criteria->compare('loginaktivasi_nomobile',$this->loginaktivasi_nomobile,true);
		$criteria->compare('loginaktivasi_email',$this->loginaktivasi_email,true);
		$criteria->compare('loginaktivasi_token',$this->loginaktivasi_token,true);
		$criteria->compare('loginaktivasi_expired',$this->loginaktivasi_expired,true);
		$criteria->compare('loginaktivasi_active',$this->loginaktivasi_active);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('jenis_verif',$this->jenis_verif,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('create_iphost',$this->create_iphost,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
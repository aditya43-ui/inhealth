<?php

/**
 * This is the model class for table "tandatangandigitaldet_t".
 *
 * The followings are the available columns in table 'tandatangandigitaldet_t':
 * @property integer $tandatangandigitaldet_id
 * @property integer $tandatangandigital_id
 * @property string $user_agent
 * @property string $nama_pegawai
 * @property string $nip_pegawai
 * @property string $nomor_sk
 * @property string $kode_otp
 * @property string $nomobile_verifikasi
 * @property string $verifikasi_sebagai
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property TandatangandigitalT $tandatangandigital
 */
class TandatangandigitaldetT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tandatangandigitaldet_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tandatangandigital_id, user_agent, nama_pegawai, create_time, create_loginpemakai, update_loginpemakai', 'required'),
			array('tandatangandigital_id, create_petugaspengisi_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nip_pegawai, nomor_sk, verifikasi_sebagai', 'length', 'max'=>200),
			array('kode_otp, nomobile_verifikasi', 'length', 'max'=>30),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tandatangandigitaldet_id, tandatangandigital_id, user_agent, nama_pegawai, nip_pegawai, nomor_sk, kode_otp, nomobile_verifikasi, verifikasi_sebagai, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'tandatangandigital' => array(self::BELONGS_TO, 'TandatangandigitalT', 'tandatangandigital_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tandatangandigitaldet_id' => 'Tandatangandigitaldet',
			'tandatangandigital_id' => 'Tandatangandigital',
			'user_agent' => 'User Agent',
			'nama_pegawai' => 'Nama Pegawai',
			'nip_pegawai' => 'Nip Pegawai',
			'nomor_sk' => 'Nomor Sk',
			'kode_otp' => 'Kode Otp',
			'nomobile_verifikasi' => 'Nomobile Verifikasi',
			'verifikasi_sebagai' => 'Verifikasi Sebagai',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('tandatangandigitaldet_id',$this->tandatangandigitaldet_id);
		$criteria->compare('tandatangandigital_id',$this->tandatangandigital_id);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('nip_pegawai',$this->nip_pegawai,true);
		$criteria->compare('nomor_sk',$this->nomor_sk,true);
		$criteria->compare('kode_otp',$this->kode_otp,true);
		$criteria->compare('nomobile_verifikasi',$this->nomobile_verifikasi,true);
		$criteria->compare('verifikasi_sebagai',$this->verifikasi_sebagai,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TandatangandigitaldetT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

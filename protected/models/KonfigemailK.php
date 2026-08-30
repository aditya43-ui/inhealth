<?php

/**
 * This is the model class for table "konfigemail_k".
 *
 * The followings are the available columns in table 'konfigemail_k':
 * @property integer $konfigemail_id
 * @property string $konfigemail_host
 * @property integer $konfigemail_port
 * @property boolean $konfigemail_smtp_auth
 * @property string $konfigemail_username
 * @property string $konfigemail_password
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $profilrs_id
 * @property string $konfigemail_smtp_secure
 * @property boolean $konfigemail_ishtml
 *
 * The followings are the available model relations:
 * @property ProfilrumahsakitM $profilrs
 */
class KonfigemailK extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KonfigemailK the static model class
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
		return 'konfigemail_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('konfigemail_send_type, konfigemail_email_type, konfigemail_smtp_secure, konfigemail_host, konfigemail_port, create_time, create_loginpemakai_id, create_ruangan, profilrs_id, konfigemail_ishtml', 'required'),
			array('konfigemail_port, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, profilrs_id', 'numerical', 'integerOnly'=>true),
			array('konfigemail_host, konfigemail_username, konfigemail_password', 'length', 'max'=>100),
			array('konfigemail_smtp_secure', 'length', 'max'=>20),
			array('konfigemail_email_type, konfigemail_send_type', 'length', 'max'=>30),
			array('konfigemail_oauth_pass, konfigemail_oauth_id, konfigemail_oauth_type, konfigemail_oauth_email, konfigemail_email_type, konfigemail_send_type, konfigemail_smtp_auth, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('konfigemail_id, konfigemail_host, konfigemail_port, konfigemail_smtp_auth, konfigemail_username, konfigemail_password, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, profilrs_id, konfigemail_smtp_secure, konfigemail_ishtml', 'safe', 'on'=>'search'),
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
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'konfigemail_id' => 'ID',
			'konfigemail_host' => 'Host',
			'konfigemail_port' => 'Port',
			'konfigemail_smtp_auth' => 'SMTP Auth',
			'konfigemail_username' => 'Username',
			'konfigemail_password' => 'Password',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'profilrs_id' => 'Profil',
			'konfigemail_smtp_secure' => 'SMTP Secure',
			'konfigemail_ishtml' => 'HTML',
			'konfigemail_send_type' => 'Tipe Kirim',
			'konfigemail_email_type' => 'Tipe Email',
			'konfigemail_oauth_email' => 'Oauth Email',
			'konfigemail_oauth_id' => 'Client ID',
			'konfigemail_oauth_pass' => 'Client Pass',
			'konfigemail_oauth_type' => 'Oauth Type',
		);
	}
	
	 /**
      -	 * @return array customized attribute labels (name=>label)
      - */
    public function attributeTooltips() {
        return array(
            'konfigemail_id' => 'ID',
			'konfigemail_host' => 'Host, digunakan sebagai server atau back up server SMTP. Jika ada lebih dari 2 server makan penulisannya dapat dilakukan seperti ini : <b>Contoh : piindonesia.co.id; email.piindonesia.co.id</b>',
			'konfigemail_port' => 'Port, digunakan untuk koneksi ke port pada server SMTP',
			'konfigemail_smtp_auth' => 'SMTP Auth, digunakan untuk mengaktifkan SMTP authentication <b>(RECOMMENDED)</b>',
			'konfigemail_username' => 'Username, umumnya yang diisi adalah nama email yang digunakan sebagai email pengirim ke client',
			'konfigemail_password' => 'Password, kata kunci yang digunakan untuk login ke email yang digunakan sebagai email pengirim ke client',			
			'profilrs_id' => 'Profil, untuk membagi konfig email per profil rumah sakir',
			'konfigemail_smtp_secure' => 'SMTP Secure, digunakan untuk mengaktifkan enkripsi antara <b>tls</b> atau <b>ssl</b>',
			'konfigemail_ishtml' => 'HTML, digunakan untuk menentukan apakah email yang dikirim dalam bentuk HTML atau text biasa  <b>(RECOMMENDED)</b>',
			'konfigemail_send_type' => 'HTML, digunakan untuk menentukan apakah email yang dikirim dalam bentuk HTML atau text biasa  <b>(RECOMMENDED)</b>',
			'konfigemail_email_type' => 'HTML, digunakan untuk menentukan apakah email yang dikirim dalam bentuk HTML atau text biasa  <b>(RECOMMENDED)</b>',
			'konfigemail_oauth_email' => 'HTML, digunakan untuk menentukan apakah email yang dikirim dalam bentuk HTML atau text biasa  <b>(RECOMMENDED)</b>',
			'konfigemail_oauth_type' => 'HTML, digunakan untuk menentukan apakah email yang dikirim dalam bentuk HTML atau text biasa  <b>(RECOMMENDED)</b>',
			'konfigemail_oauth_id' => 'HTML, digunakan untuk menentukan apakah email yang dikirim dalam bentuk HTML atau text biasa  <b>(RECOMMENDED)</b>',
			'konfigemail_oauth_pass' => 'HTML, digunakan untuk menentukan apakah email yang dikirim dalam bentuk HTML atau text biasa  <b>(RECOMMENDED)</b>',
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

		$criteria->compare('konfigemail_id',$this->konfigemail_id);
		$criteria->compare('konfigemail_host',$this->konfigemail_host,true);
		$criteria->compare('konfigemail_port',$this->konfigemail_port);
		$criteria->compare('konfigemail_smtp_auth',$this->konfigemail_smtp_auth);
		$criteria->compare('konfigemail_username',$this->konfigemail_username,true);
		$criteria->compare('konfigemail_password',$this->konfigemail_password,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('konfigemail_smtp_secure',$this->konfigemail_smtp_secure,true);
		$criteria->compare('konfigemail_ishtml',$this->konfigemail_ishtml);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
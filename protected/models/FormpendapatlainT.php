<?php

/**
 * This is the model class for table "formpendapatlain_t".
 *
 * The followings are the available columns in table 'formpendapatlain_t':
 * @property integer $formpendapatlain_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $nama_lengkap
 * @property string $tanggal_lahir
 * @property string $alamat
 * @property string $hubunganpasien
 * @property string $dokter_opinion
 * @property string $petugas_tanggungjawab
 * @property integer $petugas_id
 * @property string $penerima_informasi
 * @property string $nama_penerima
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 */
class FormpendapatlainT extends CActiveRecord
{
	public $petugas_nama, $is_luar, $inputdokter;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FormpendapatlainT the static model class
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
		return 'formpendapatlain_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, nama_lengkap, petugas_tanggungjawab, petugas_id, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, petugas_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_lengkap, alamat, hubunganpasien, dokter_opinion, petugas_tanggungjawab, nama_penerima', 'length', 'max'=>200),
			array('penerima_informasi', 'length', 'max'=>100),
			array('tanggal_lahir, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('formpendapatlain_id, pendaftaran_id, pasienadmisi_id, nama_lengkap, tanggal_lahir, alamat, hubunganpasien, dokter_opinion, petugas_tanggungjawab, petugas_id, penerima_informasi, nama_penerima, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan, is_luar', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'petugas' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'formpendapatlain_id' => 'Formpendapatlain',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'nama_lengkap' => 'Nama Lengkap',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat' => 'Alamat',
			'hubunganpasien' => 'Hubungan dengan pasien',
			'dokter_opinion' => 'Dokter Sebagai Second Opinion',
			'petugas_tanggungjawab' => 'Petugas Penanggung Jawab',
			'petugas_id' => 'Nama Petugas',
			'penerima_informasi' => 'Penerima Informasi',
			'nama_penerima' => 'Nama Penerima',
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

		$criteria->compare('formpendapatlain_id',$this->formpendapatlain_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('nama_lengkap',$this->nama_lengkap,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('hubunganpasien',$this->hubunganpasien,true);
		$criteria->compare('dokter_opinion',$this->dokter_opinion,true);
		$criteria->compare('petugas_tanggungjawab',$this->petugas_tanggungjawab,true);
		$criteria->compare('petugas_id',$this->petugas_id);
		$criteria->compare('penerima_informasi',$this->penerima_informasi,true);
		$criteria->compare('nama_penerima',$this->nama_penerima,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPasien()
	{

		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
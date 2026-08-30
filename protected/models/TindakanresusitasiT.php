<?php

/**
 * This is the model class for table "tindakanresusitasi_t".
 *
 * The followings are the available columns in table 'tindakanresusitasi_t':
 * @property integer $tindakanresusitasi_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property boolean $pasienbutuh_resusitasi
 * @property string $resusitasi_tidak
 * @property string $resusitasi_lainnya
 * @property boolean $isdiskusidengan_pasien
 * @property string $diskusipasien_tidak
 * @property boolean $isdiskusidengan_keluarga
 * @property string $diskusikeluarga_tidak
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
class TindakanresusitasiT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TindakanresusitasiT the static model class
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
		return 'tindakanresusitasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('resusitasi_tidak, diskusipasien_tidak, diskusikeluarga_tidak, nama_penerima', 'length', 'max'=>200),
			array('penerima_informasi', 'length', 'max'=>100),
			array('pasienbutuh_resusitasi, resusitasi_lainnya, isdiskusidengan_pasien, isdiskusidengan_keluarga, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tindakanresusitasi_id, pendaftaran_id, pasienadmisi_id, pasienbutuh_resusitasi, resusitasi_tidak, resusitasi_lainnya, isdiskusidengan_pasien, diskusipasien_tidak, isdiskusidengan_keluarga, diskusikeluarga_tidak, penerima_informasi, nama_penerima, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan, resusitasistatus, diagnosaresusitasi', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tindakanresusitasi_id' => 'Tindakanresusitasi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienbutuh_resusitasi' => 'Pasienbutuh Resusitasi',
			'resusitasi_tidak' => 'Resusitasi Tidak',
			'resusitasi_lainnya' => 'Resusitasi Lainnya',
			'isdiskusidengan_pasien' => 'Isdiskusidengan Pasien',
			'diskusipasien_tidak' => 'Diskusipasien Tidak',
			'isdiskusidengan_keluarga' => 'Isdiskusidengan Keluarga',
			'diskusikeluarga_tidak' => 'Diskusikeluarga Tidak',
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

		$criteria->compare('tindakanresusitasi_id',$this->tindakanresusitasi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienbutuh_resusitasi',$this->pasienbutuh_resusitasi);
		$criteria->compare('resusitasi_tidak',$this->resusitasi_tidak,true);
		$criteria->compare('resusitasi_lainnya',$this->resusitasi_lainnya,true);
		$criteria->compare('isdiskusidengan_pasien',$this->isdiskusidengan_pasien);
		$criteria->compare('diskusipasien_tidak',$this->diskusipasien_tidak,true);
		$criteria->compare('isdiskusidengan_keluarga',$this->isdiskusidengan_keluarga);
		$criteria->compare('diskusikeluarga_tidak',$this->diskusikeluarga_tidak,true);
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
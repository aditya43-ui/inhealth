<?php

/**
 * This is the model class for table "tidakdilakukanresusitasi_t".
 *
 * The followings are the available columns in table 'tidakdilakukanresusitasi_t':
 * @property integer $tidakdilakukanresusitasi_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $nama_lengkap
 * @property string $tanggal_lahir
 * @property string $alamat
 * @property string $hubunganpasien
 * @property string $isikeputusan
 * @property string $pasienmenyatakan
 * @property string $nama_menyatakan
 * @property string $saksi1
 * @property string $saksi2
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
class TidakdilakukanresusitasiT extends CActiveRecord
{
	public $nama_saksi2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TidakdilakukanresusitasiT the static model class
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
		return 'tidakdilakukanresusitasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, nama_lengkap, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('nama_lengkap, alamat, hubunganpasien, pasienmenyatakan, nama_menyatakan, saksi1, saksi2', 'length', 'max'=>200),
			array('tanggal_lahir, isikeputusan, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tidakdilakukanresusitasi_id, pendaftaran_id, pasienadmisi_id, nama_lengkap, tanggal_lahir, alamat, hubunganpasien, isikeputusan, pasienmenyatakan, nama_menyatakan, saksi1, saksi2, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan', 'safe', 'on'=>'search'),
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
			'saksi' => array(self::BELONGS_TO, 'PegawaiM', 'saksi2'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tidakdilakukanresusitasi_id' => 'Tidakdilakukanresusitasi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'nama_lengkap' => 'Nama Lengkap',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat' => 'Alamat',
			'hubunganpasien' => 'Hubungan degan pasien',
			'isikeputusan' => 'Isikeputusan',
			'pasienmenyatakan' => 'Yang Menyatakan',
			'nama_menyatakan' => 'Nama',
			'saksi1' => 'Nama Keluarga',
			'saksi2' => 'Nama Petugas',
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

		$criteria->compare('tidakdilakukanresusitasi_id',$this->tidakdilakukanresusitasi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('nama_lengkap',$this->nama_lengkap,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('hubunganpasien',$this->hubunganpasien,true);
		$criteria->compare('isikeputusan',$this->isikeputusan,true);
		$criteria->compare('pasienmenyatakan',$this->pasienmenyatakan,true);
		$criteria->compare('nama_menyatakan',$this->nama_menyatakan,true);
		$criteria->compare('saksi1',$this->saksi1,true);
		$criteria->compare('saksi2',$this->saksi2,true);
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
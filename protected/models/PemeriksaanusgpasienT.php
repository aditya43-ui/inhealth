<?php

/**
 * This is the model class for table "pemeriksaanusgpasien_t".
 *
 * The followings are the available columns in table 'pemeriksaanusgpasien_t':
 * @property integer $pemeriksaanusgpasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $tgl_pemeriksaan
 * @property integer $dokterpemeriksa_id
 * @property integer $trimesterkehamilan
 * @property string $jumlahjanin_ket
 * @property integer $jumlahjanin
 * @property integer $ruanganperiksausg_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienadmisiT $pasienadmisi
 * @property PasienM $pasien
 * @property PegawaiM $dokterpemeriksa
 * @property RuanganM $ruanganperiksausg
 * @property PemeriksaanusgpasiendetT[] $pemeriksaanusgpasiendetTs
 */
class PemeriksaanusgpasienT extends CActiveRecord
{
    public $is_trimester, $jumlahjaninlain;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanusgpasienT the static model class
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
		return 'pemeriksaanusgpasien_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, pasien_id, tgl_pemeriksaan, dokterpemeriksa_id, ruanganperiksausg_id, create_time, create_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'required'),
			array('pendaftaran_id, pasienadmisi_id, pasien_id, dokterpemeriksa_id, trimesterkehamilan, jumlahjanin, ruanganperiksausg_id, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jumlahjanin_ket', 'length', 'max'=>50),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pemeriksaanusgpasien_id, pendaftaran_id, pasienadmisi_id, pasien_id, tgl_pemeriksaan, dokterpemeriksa_id, trimesterkehamilan, jumlahjanin_ket, jumlahjanin, ruanganperiksausg_id, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'dokterpemeriksa' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa_id'),
			'ruanganperiksausg' => array(self::BELONGS_TO, 'RuanganM', 'ruanganperiksausg_id'),
			'pemeriksaanusgpasiendetTs' => array(self::HAS_MANY, 'PemeriksaanusgpasiendetT', 'pemeriksaanusgpasien_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanusgpasien_id' => 'Pemeriksaanusgpasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Pasien',
			'tgl_pemeriksaan' => 'Tanggal & Jam Pemeriksaan',
			'dokterpemeriksa_id' => 'Dokter Pemeriksa',
			'trimesterkehamilan' => 'Trimesterkehamilan',
			'jumlahjanin_ket' => 'Jumlahjanin Ket',
			'jumlahjanin' => 'Jumlah Janin',
			'ruanganperiksausg_id' => 'Ruanganperiksausg',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('pemeriksaanusgpasien_id',$this->pemeriksaanusgpasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('tgl_pemeriksaan',$this->tgl_pemeriksaan,true);
		$criteria->compare('dokterpemeriksa_id',$this->dokterpemeriksa_id);
		$criteria->compare('trimesterkehamilan',$this->trimesterkehamilan);
		$criteria->compare('jumlahjanin_ket',$this->jumlahjanin_ket,true);
		$criteria->compare('jumlahjanin',$this->jumlahjanin);
		$criteria->compare('ruanganperiksausg_id',$this->ruanganperiksausg_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
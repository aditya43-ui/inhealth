<?php

/**
 * This is the model class for table "observasi_transfusi_darah_t".
 *
 * The followings are the available columns in table 'observasi_transfusi_darah_t':
 * @property integer $observasi_transfusi_darah_id
 * @property integer $petugas_observasi_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $kantong_transfusi_darah_det_id
 * @property string $tanggal_observasi
 * @property string $jam_observasi
 * @property string $keluhan
 * @property string $kesadaran
 * @property integer $tensi_sistolik
 * @property integer $tensi_diatolik
 * @property integer $nadi
 * @property double $suhu
 * @property integer $pernapasan
 * @property string $lainnya
 * @property string $create_time
 * @property string $update_time
 * @property integer $creale_login
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 *
 * The followings are the available model relations:
 * @property KantongTransfusiDarahDetT $kantongTransfusiDarahDet
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $petugasObservasi
 * @property ReaksiTransfusiT[] $reaksiTransfusiTs
 */
class ObservasiTransfusiDarahT extends CActiveRecord
{
    public $petugas_observasi_nama, $kantong_transfusi_darah_det_no, $reaksi_transfusi, $no_kantongdarah, $sukses;
    public $petugas_transfusi_nama, $petugas_verifikasi_nama, $jeniskomponendarah_nama;
    public $reaksi_transfusi_id, $nama_reaksi_transfusi, $volume_darah;    
    public $tgl_pendaftaran, $no_pendaftaran;
    public $kantong_transfusi_darah_id;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObservasiTransfusiDarahT the static model class
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
		return 'observasi_transfusi_darah_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_time, creale_login, ruangan_id', 'required'),
			array('petugas_observasi_id, pendaftaran_id, pasien_id, kantong_transfusi_darah_det_id, tensi_sistolik, tensi_diatolik, nadi, pernapasan, creale_login, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('suhu', 'numerical'),
			array('keluhan, kesadaran, lainnya', 'length', 'max'=>250),
			array('tanggal_observasi, jam_observasi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('observasi_transfusi_darah_id, petugas_observasi_id, pendaftaran_id, pasien_id, kantong_transfusi_darah_det_id, tanggal_observasi, jam_observasi, keluhan, kesadaran, tensi_sistolik, tensi_diatolik, nadi, suhu, pernapasan, lainnya, create_time, update_time, creale_login, update_loginpemakai_id, ruangan_id', 'safe', 'on'=>'search'),
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
			'kantongTransfusiDarahDet' => array(self::BELONGS_TO, 'KantongTransfusiDarahDetT', 'kantong_transfusi_darah_det_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'petugasObservasi' => array(self::BELONGS_TO, 'PegawaiM', 'petugas_observasi_id'),
			'reaksiTransfusiTs' => array(self::HAS_MANY, 'ReaksiTransfusiT', 'observasi_transfusi_darah_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'observasi_transfusi_darah_id' => 'Observasi Transfusi Darah',
			'petugas_observasi_id' => 'Petugas Observasi',
			'pendaftaran_id' => 'Pendaftaran',
			'pasien_id' => 'Pasien',
			'kantong_transfusi_darah_det_id' => 'Kantong Transfusi Darah Det',
			'tanggal_observasi' => 'Tanggal Observasi',
			'jam_observasi' => 'Jam Observasi',
			'keluhan' => 'Keluhan',
			'kesadaran' => 'Kesadaran',
			'tensi_sistolik' => 'Tensi Sistolik',
			'tensi_diatolik' => 'Tensi Diatolik',
			'nadi' => 'Nadi',
			'suhu' => 'Suhu',
			'pernapasan' => 'Pernapasan',
			'lainnya' => 'Lainnya',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'creale_login' => 'Creale Login',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'ruangan_id' => 'Ruangan',
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

		$criteria->compare('observasi_transfusi_darah_id',$this->observasi_transfusi_darah_id);
		$criteria->compare('petugas_observasi_id',$this->petugas_observasi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('kantong_transfusi_darah_det_id',$this->kantong_transfusi_darah_det_id);
		$criteria->compare('tanggal_observasi',$this->tanggal_observasi,true);
		$criteria->compare('jam_observasi',$this->jam_observasi,true);
		$criteria->compare('keluhan',$this->keluhan,true);
		$criteria->compare('kesadaran',$this->kesadaran,true);
		$criteria->compare('tensi_sistolik',$this->tensi_sistolik);
		$criteria->compare('tensi_diatolik',$this->tensi_diatolik);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('suhu',$this->suhu);
		$criteria->compare('pernapasan',$this->pernapasan);
		$criteria->compare('lainnya',$this->lainnya,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('creale_login',$this->creale_login);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
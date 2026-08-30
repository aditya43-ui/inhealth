<?php

/**
 * This is the model class for table "resumeaskep_r".
 *
 * The followings are the available columns in table 'resumeaskep_r':
 * @property integer $resumeaskep_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $ruangan_id
 * @property string $noresume
 * @property string $tglresume
 * @property string $keluhanutamamasuk
 * @property string $keadaanumummasuk
 * @property integer $gcs_eye
 * @property integer $gcs_motorik
 * @property integer $gcs_verbal
 * @property string $gcs_hasil
 * @property string $tekanandarahmasuk
 * @property integer $detaknadimasuk
 * @property string $suhutubuhmasuk
 * @property string $pernapasanmasuk
 * @property string $diagnosakeperawatan
 * @property string $tindakankeperawatan
 * @property string $keluhanakhir
 * @property string $keadaanumumakhir
 * @property string $tekanandarahakhir
 * @property integer $detaknadiakhir
 * @property string $suhutubuhakhir
 * @property string $pernapasanakhir
 * @property string $namaperawat
 * @property string $tglmasukrs
 * @property string $tglkeluarrs
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $pegawai
 * @property RuanganM $ruangan
 */
class ResumeaskepR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ResumeaskepR the static model class
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
		return 'resumeaskep_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, pegawai_id, noresume, tglresume, tglmasukrs, tglkeluarrs, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pendaftaran_id, pegawai_id, ruangan_id, gcs_eye, gcs_motorik, gcs_verbal, detaknadimasuk, detaknadiakhir', 'numerical', 'integerOnly'=>true),
			array('noresume, tekanandarahmasuk, tekanandarahakhir', 'length', 'max'=>20),
			array('keadaanumummasuk, keadaanumumakhir', 'length', 'max'=>500),
			array('gcs_hasil, namaperawat', 'length', 'max'=>50),
			array('suhutubuhmasuk, suhutubuhakhir', 'length', 'max'=>10),
			array('keluhanutamamasuk, pernapasanmasuk, diagnosakeperawatan, tindakankeperawatan, keluhanakhir, pernapasanakhir, update_time, update_loginpemakai_id', 'safe'),
//			// The following rule is used by search().
//			// Please remove those attributes that should not be searched.
			array('resumeaskep_id, pasien_id, pendaftaran_id, pegawai_id, ruangan_id, noresume, tglresume, keluhanutamamasuk, keadaanumummasuk, gcs_eye, gcs_motorik, gcs_verbal, gcs_hasil, tekanandarahmasuk, detaknadimasuk, suhutubuhmasuk, pernapasanmasuk, diagnosakeperawatan, tindakankeperawatan, keluhanakhir, keadaanumumakhir, tekanandarahakhir, detaknadiakhir, suhutubuhakhir, pernapasanakhir, namaperawat, tglmasukrs, tglkeluarrs, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resumeaskep_id' => 'Resumeaskep',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'pegawai_id' => 'Pegawai',
			'ruangan_id' => 'Ruangan',
			'noresume' => 'Noresume',
			'tglresume' => 'Tglresume',
			'keluhanutamamasuk' => 'Keluhanutamamasuk',
			'keadaanumummasuk' => 'Keadaanumummasuk',
			'gcs_eye' => 'Gcs Eye',
			'gcs_motorik' => 'Gcs Motorik',
			'gcs_verbal' => 'Gcs Verbal',
			'gcs_hasil' => 'Gcs Hasil',
			'tekanandarahmasuk' => 'Tekanandarahmasuk',
			'detaknadimasuk' => 'Detaknadimasuk',
			'suhutubuhmasuk' => 'Suhutubuhmasuk',
			'pernapasanmasuk' => 'Pernapasanmasuk',
			'diagnosakeperawatan' => 'Diagnosakeperawatan',
			'tindakankeperawatan' => 'Tindakankeperawatan',
			'keluhanakhir' => 'Keluhanakhir',
			'keadaanumumakhir' => 'Keadaanumumakhir',
			'tekanandarahakhir' => 'Tekanandarahakhir',
			'detaknadiakhir' => 'Detaknadiakhir',
			'suhutubuhakhir' => 'Suhutubuhakhir',
			'pernapasanakhir' => 'Pernapasanakhir',
			'namaperawat' => 'Namaperawat',
			'tglmasukrs' => 'Tglmasukrs',
			'tglkeluarrs' => 'Tglkeluarrs',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
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

		$criteria->compare('resumeaskep_id',$this->resumeaskep_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('noresume',$this->noresume,true);
		$criteria->compare('tglresume',$this->tglresume,true);
		$criteria->compare('keluhanutamamasuk',$this->keluhanutamamasuk,true);
		$criteria->compare('keadaanumummasuk',$this->keadaanumummasuk,true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('gcs_hasil',$this->gcs_hasil,true);
		$criteria->compare('tekanandarahmasuk',$this->tekanandarahmasuk,true);
		$criteria->compare('detaknadimasuk',$this->detaknadimasuk);
		$criteria->compare('suhutubuhmasuk',$this->suhutubuhmasuk,true);
		$criteria->compare('pernapasanmasuk',$this->pernapasanmasuk,true);
		$criteria->compare('diagnosakeperawatan',$this->diagnosakeperawatan,true);
		$criteria->compare('tindakankeperawatan',$this->tindakankeperawatan,true);
		$criteria->compare('keluhanakhir',$this->keluhanakhir,true);
		$criteria->compare('keadaanumumakhir',$this->keadaanumumakhir,true);
		$criteria->compare('tekanandarahakhir',$this->tekanandarahakhir,true);
		$criteria->compare('detaknadiakhir',$this->detaknadiakhir);
		$criteria->compare('suhutubuhakhir',$this->suhutubuhakhir,true);
		$criteria->compare('pernapasanakhir',$this->pernapasanakhir,true);
		$criteria->compare('namaperawat',$this->namaperawat,true);
		$criteria->compare('tglmasukrs',$this->tglmasukrs,true);
		$criteria->compare('tglkeluarrs',$this->tglkeluarrs,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
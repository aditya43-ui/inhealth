<?php

/**
 * This is the model class for table "rencana_perawatan_dialisis_t".
 *
 * The followings are the available columns in table 'rencana_perawatan_dialisis_t':
 * @property integer $rencana_perawatan_dialisis_id
 * @property integer $pegawai_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $waktu_dialisis_pertama
 * @property string $profesi
 * @property string $masalah_yang_ditemukan
 * @property string $perencanaan
 * @property string $instruksi
 * @property string $create_time
 * @property string $update_time
 * @property integer $creale_login
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 * @property PegawaiM $pegawai
 */
class RencanaPerawatanDialisisT extends CActiveRecord
{
    public $nama_pegawai;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RencanaPerawatanDialisisT the static model class
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
		return 'rencana_perawatan_dialisis_t';
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
			array('pegawai_id, pasien_id, pendaftaran_id, creale_login, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly'=>true),
			array('profesi', 'length', 'max'=>50),
			array('waktu_dialisis_pertama, masalah_yang_ditemukan, perencanaan, instruksi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rencana_perawatan_dialisis_id, pegawai_id, pasien_id, pendaftaran_id, waktu_dialisis_pertama, profesi, masalah_yang_ditemukan, perencanaan, instruksi, create_time, update_time, creale_login, update_loginpemakai_id, ruangan_id', 'safe', 'on'=>'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rencana_perawatan_dialisis_id' => 'Rencana Perawatan Dialisis',
			'pegawai_id' => 'Pegawai',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'waktu_dialisis_pertama' => 'Waktu Dialisis Pertama',
			'profesi' => 'Profesi',
			'masalah_yang_ditemukan' => 'Masalah Yang Ditemukan',
			'perencanaan' => 'Perencanaan',
			'instruksi' => 'Instruksi',
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

		$criteria->compare('rencana_perawatan_dialisis_id',$this->rencana_perawatan_dialisis_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('waktu_dialisis_pertama',$this->waktu_dialisis_pertama,true);
		$criteria->compare('profesi',$this->profesi,true);
		$criteria->compare('masalah_yang_ditemukan',$this->masalah_yang_ditemukan,true);
		$criteria->compare('perencanaan',$this->perencanaan,true);
		$criteria->compare('instruksi',$this->instruksi,true);
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
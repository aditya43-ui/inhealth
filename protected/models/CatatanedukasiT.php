<?php

/**
 * This is the model class for table "catatanedukasi_t".
 *
 * The followings are the available columns in table 'catatanedukasi_t':
 * @property integer $catatanedukasi_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property string $nomorcatatanedukasi
 * @property string $tgl_edukasi
 * @property string $kodeprofesi
 * @property string $penjelasan_kie
 * @property string $keterangan_dan_evaluasi
 * @property string $metodeedukasi
 * @property integer $durasi
 * @property integer $edukator_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property CatatanedukasiketEvaluasiT[] $catatanedukasiketEvaluasiTs
 * @property CatatanedikasipenjT[] $catatanedikasipenjTs
 */
class CatatanedukasiT extends CActiveRecord
{
    public $edukator_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatatanedukasiT the static model class
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
		return 'catatanedukasi_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, nomorcatatanedukasi, tgl_edukasi, kodeprofesi, metodeedukasi, durasi, edukator_id, create_time, create_loginpemakai_id', 'required'),
			array('pasien_id, pasienadmisi_id, pendaftaran_id, durasi, edukator_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('hubungankeluarga, penerimaedukasi, penjelasan_kie, keterangan_dan_evaluasi, update_time, isi_penjelasan, isi_keterangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('catatanedukasi_id, pasien_id, pasienadmisi_id, pendaftaran_id, nomorcatatanedukasi, tgl_edukasi, kodeprofesi, penjelasan_kie, keterangan_dan_evaluasi, metodeedukasi, durasi, edukator_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, isi_penjelasan, isi_keterangan', 'safe', 'on'=>'search'),
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
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'catatanedukasiketEvaluasiTs' => array(self::HAS_MANY, 'CatatanedukasiketEvaluasiT', 'catatanedukasi_id'),
			'catatanedikasipenjTs' => array(self::HAS_MANY, 'CatatanedikasipenjT', 'catatanedukasi_id'),
			'edukator' => array(self::BELONGS_TO, 'PegawaiM', 'edukator_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'catatanedukasi_id' => 'Catatanedukasi',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'nomorcatatanedukasi' => 'Nomor Catatan Edukasi',
			'tgl_edukasi' => 'Tanggal Edukasi',
			'kodeprofesi' => 'Kode Profesi Edukator',
			'penjelasan_kie' => 'Penjelasan/KIE',
			'keterangan_dan_evaluasi' => 'Keterangan Dan Evaluasi',
			'metodeedukasi' => 'Metode',
			'durasi' => 'Durasi',
			'edukator_id' => 'Edukator',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
            'hubungankeluarga' => 'Hubungan Keluarga',
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

		$criteria->compare('catatanedukasi_id',$this->catatanedukasi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('nomorcatatanedukasi',$this->nomorcatatanedukasi,true);
		$criteria->compare('tgl_edukasi',$this->tgl_edukasi,true);
		$criteria->compare('kodeprofesi',$this->kodeprofesi,true);
		$criteria->compare('penjelasan_kie',$this->penjelasan_kie,true);
		$criteria->compare('keterangan_dan_evaluasi',$this->keterangan_dan_evaluasi,true);
		$criteria->compare('metodeedukasi',$this->metodeedukasi,true);
		$criteria->compare('durasi',$this->durasi);
		$criteria->compare('edukator_id',$this->edukator_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

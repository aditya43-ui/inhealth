<?php

/**
 * This is the model class for table "informasiresumeaskep_v".
 *
 * The followings are the available columns in table 'informasiresumeaskep_v':
 * @property integer $resumeaskep_id
 * @property string $noresume
 * @property string $tglresume
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pegawai_id
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property string $nama_pegawai
 */
class InformasiresumeaskepV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiresumeaskepV the static model class
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
		return 'informasiresumeaskep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resumeaskep_id, pendaftaran_id, pasien_id, kelaspelayanan_id, ruangan_id, pegawai_id, kamarruangan_id', 'numerical', 'integerOnly'=>true),
			array('noresume, no_pendaftaran', 'length', 'max'=>20),
			array('no_rekam_medik, kamarruangan_nobed', 'length', 'max'=>10),
			array('kelaspelayanan_nama, ruangan_nama', 'length', 'max'=>50),
			array('kamarruangan_nokamar', 'length', 'max'=>100),
			array('tglresume, tgl_pendaftaran, nama_pasien, nama_pegawai', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('resumeaskep_id, noresume, tglresume, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, pasien_id, nama_pasien, no_rekam_medik, kelaspelayanan_id, kelaspelayanan_nama, ruangan_id, ruangan_nama, pegawai_id, kamarruangan_id, kamarruangan_nokamar, kamarruangan_nobed, nama_pegawai', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resumeaskep_id' => 'Resumeaskep',
			'noresume' => 'No. Resume',
			'tglresume' => 'Tglresume',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'pasien_id' => 'Pasien',
			'nama_pasien' => 'Nama Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'pegawai_id' => 'Pegawai',
			'kamarruangan_id' => 'Kamarruangan',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'nama_pegawai' => 'Nama Pegawai',
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
		$criteria->compare('noresume',$this->noresume,true);
		$criteria->compare('tglresume',$this->tglresume,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
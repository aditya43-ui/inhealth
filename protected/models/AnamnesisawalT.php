<?php

/**
 * This is the model class for table "anamnesisawal_t".
 *
 * The followings are the available columns in table 'anamnesisawal_t':
 * @property integer $anamnesisawal_id
 * @property integer $pendaftaran_id
 * @property integer $dokterpemeriksa_id
 * @property integer $tenagamedis_id
 * @property string $jenisasesmen
 * @property string $tgl_anamnesis
 * @property string $keluhanutama
 * @property string $keluhantambahan
 * @property string $riwayatpenyakit_sekarang
 * @property string $riwayatpenyakit_terdahulu
 * @property string $isada_riwayatalergi
 * @property string $riwayatalergi_obat
 * @property string $riwayatalergi_makanan
 * @property string $riwayatalergi_lainnya
 * @property string $namapihak_menyetujui
 * @property string $riwayatpenyakit
 * @property string $riwayatpenyakit_lainnya
 * @property string $riwayatoperasi_status
 * @property string $riwayatoperasi_keterangan
 * @property string $riwayattransfusi_status
 * @property string $riwayattransfusi_isreaksi
 * @property string $riwayattransfusi_reaksiygtimbul
 * @property string $riwayatpenyakit_dlmkeluarga
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $dokterpemeriksa
 * @property PegawaiM $tenagamedis
 */
class AnamnesisawalT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesisawalT the static model class
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
		return 'anamnesisawal_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, dokterpemeriksa_id, jenisasesmen, tgl_anamnesis, create_time, create_loginpemakai_id', 'required'),
			array('pendaftaran_id, dokterpemeriksa_id, tenagamedis_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('jenisasesmen, namapihak_menyetujui, riwayatpenyakit_lainnya', 'length', 'max'=>200),
			array('isada_riwayatalergi, riwayatoperasi_status, riwayattransfusi_status, riwayattransfusi_isreaksi', 'length', 'max'=>20),
			array('riwayatalergi_obat, riwayatalergi_makanan, riwayatalergi_lainnya', 'length', 'max'=>255),
            array('namapihakyg_diwawancara, autoanamnesa, heteroanamnesa, faktorpencetus, faktorkeluarga, fungsikerja, riwayatnapza, riwayatnapza_lamapemakaian, riwayatnapza_jeniszat, riwayatnapza_carapemakaian, riwayatnapza_latabelakangpemakaian, faktorpremorbid, faktororganik', 'safe'),
			array('keluhanutama, keluhantambahan, riwayatpenyakit_sekarang, riwayatpenyakit_terdahulu, riwayatpenyakit, riwayatoperasi_keterangan, riwayattransfusi_reaksiygtimbul, riwayatpenyakit_dlmkeluarga, update_time', 'safe'),
			array('riwayatresusitasi_status, riwayatresusitasi_tindakan, riwayatresusitasi_medikasi, riwayatresusitasi_lainnya', 'safe'),
            // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('anamnesisawal_id, pendaftaran_id, dokterpemeriksa_id, tenagamedis_id, jenisasesmen, tgl_anamnesis, keluhanutama, keluhantambahan, riwayatpenyakit_sekarang, riwayatpenyakit_terdahulu, isada_riwayatalergi, riwayatalergi_obat, riwayatalergi_makanan, riwayatalergi_lainnya, namapihak_menyetujui, riwayatpenyakit, riwayatpenyakit_lainnya, riwayatoperasi_status, riwayatoperasi_keterangan, riwayattransfusi_status, riwayattransfusi_isreaksi, riwayattransfusi_reaksiygtimbul, riwayatpenyakit_dlmkeluarga, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'dokterpemeriksa' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa_id'),
			'tenagamedis' => array(self::BELONGS_TO, 'PegawaiM', 'tenagamedis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'anamnesisawal_id' => 'Anamnesisawal',
			'pendaftaran_id' => 'Pendaftaran',
			'dokterpemeriksa_id' => 'Dokter Pemeriksa',
			'tenagamedis_id' => 'Tenaga Medis',
			'jenisasesmen' => 'Jenis Asesmen',
			'tgl_anamnesis' => 'Tgl Anamnesis',
			'keluhanutama' => 'Keluhan Utama',
			'keluhantambahan' => 'Keluhan Tambahan',
			'riwayatpenyakit_sekarang' => 'Riwayat Penyakit Sekarang',
			'riwayatpenyakit_terdahulu' => 'Riwayat Penyakit Terdahulu',
			'isada_riwayatalergi' => 'Riwayat Alergi',
			'riwayatalergi_obat' => 'Riwayat Alergi Obat',
			'riwayatalergi_makanan' => 'Riwayat Alergi Makanan',
			'riwayatalergi_lainnya' => 'Riwayat Alergi Lainnya',
			'namapihak_menyetujui' => 'Nama Pasien/Keluarga Menyetujui',
			'riwayatpenyakit' => 'Riwayat Penyakit',
			'riwayatpenyakit_lainnya' => 'Riwayat Penyakit Lainnya',
			'riwayatoperasi_status' => 'Riwayat Operasi',
			'riwayatoperasi_keterangan' => 'Jenis dan Kapan',
			'riwayattransfusi_status' => 'Riwayat Transfusi',
			'riwayattransfusi_isreaksi' => 'Reaksi Transfusi',
			'riwayattransfusi_reaksiygtimbul' => 'Reaksi yang timbul',
			'riwayatpenyakit_dlmkeluarga' => 'Riwayat Penyakit Dalam Keluarga',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan_id' => 'Create Ruangan',
            'autoanamnesa' => 'Auto Anamnesa',
            'heteroanamnesa' => 'Hetero Anamnesa',
            'faktorpencetus' => 'Faktor Pencetus/Penyebab',
            'faktorkeluarga' => 'Faktor Keluarga',
            'fungsikerja' => 'Fungsi Kerja/Sosial',
            'riwayatnapza' => 'Riwayat Napza',
            'riwayatnapza_lamapemakaian' => 'Lama Pemakaian',
            'riwayatnapza_jeniszat' => 'Jenis Zat',
            'riwayatnapza_carapemakaian' => 'Cara Pemakaian',
            'riwayatnapza_latabelakangpemakaian' => 'Latar Belakang Pemakaian',
            'faktorpremorbid' => 'Faktor Premorbid',
            'faktororganik' => 'Faktor Organik',
            'namapihakyg_diwawancara' => 'Nama Pihak yang Diwawancara',
            'riwayatresusitasi_status' => 'Riwayat Resusitasi',
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

		$criteria->compare('anamnesisawal_id',$this->anamnesisawal_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('dokterpemeriksa_id',$this->dokterpemeriksa_id);
		$criteria->compare('tenagamedis_id',$this->tenagamedis_id);
		$criteria->compare('jenisasesmen',$this->jenisasesmen,true);
		$criteria->compare('tgl_anamnesis',$this->tgl_anamnesis,true);
		$criteria->compare('keluhanutama',$this->keluhanutama,true);
		$criteria->compare('keluhantambahan',$this->keluhantambahan,true);
		$criteria->compare('riwayatpenyakit_sekarang',$this->riwayatpenyakit_sekarang,true);
		$criteria->compare('riwayatpenyakit_terdahulu',$this->riwayatpenyakit_terdahulu,true);
		$criteria->compare('isada_riwayatalergi',$this->isada_riwayatalergi,true);
		$criteria->compare('riwayatalergi_obat',$this->riwayatalergi_obat,true);
		$criteria->compare('riwayatalergi_makanan',$this->riwayatalergi_makanan,true);
		$criteria->compare('riwayatalergi_lainnya',$this->riwayatalergi_lainnya,true);
		$criteria->compare('namapihak_menyetujui',$this->namapihak_menyetujui,true);
		$criteria->compare('riwayatpenyakit',$this->riwayatpenyakit,true);
		$criteria->compare('riwayatpenyakit_lainnya',$this->riwayatpenyakit_lainnya,true);
		$criteria->compare('riwayatoperasi_status',$this->riwayatoperasi_status,true);
		$criteria->compare('riwayatoperasi_keterangan',$this->riwayatoperasi_keterangan,true);
		$criteria->compare('riwayattransfusi_status',$this->riwayattransfusi_status,true);
		$criteria->compare('riwayattransfusi_isreaksi',$this->riwayattransfusi_isreaksi,true);
		$criteria->compare('riwayattransfusi_reaksiygtimbul',$this->riwayattransfusi_reaksiygtimbul,true);
		$criteria->compare('riwayatpenyakit_dlmkeluarga',$this->riwayatpenyakit_dlmkeluarga,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
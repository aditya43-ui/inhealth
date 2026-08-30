<?php

/**
 * This is the model class for table "infoverifikasiaskep_v".
 *
 * The followings are the available columns in table 'infoverifikasiaskep_v':
 * @property integer $verifikasiaskep_id
 * @property string $verifikasiaskep_tgl
 * @property string $verifikasiaskep_no
 * @property string $verifikasiaskep_ket
 * @property string $petugasverifikasi_nama
 * @property string $mengetahui_nama
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $verifikasiaskep_status
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 */
class InfoverifikasiaskepV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfoverifikasiaskepV the static model class
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
		return 'infoverifikasiaskep_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('verifikasiaskep_id, pendaftaran_id, pasien_id, ruangan_id, kelaspelayanan_id, kamarruangan_id, pegawai_id', 'numerical', 'integerOnly'=>true),
			array('verifikasiaskep_no, verifikasiaskep_status, no_pendaftaran', 'length', 'max'=>20),
			array('petugasverifikasi_nama, mengetahui_nama, nama_pasien, ruangan_nama, kelaspelayanan_nama, nama_pegawai', 'length', 'max'=>50),
			array('no_rekam_medik, kamarruangan_nobed', 'length', 'max'=>10),
			array('kamarruangan_nokamar', 'length', 'max'=>25),
			array('verifikasiaskep_tgl, verifikasiaskep_ket, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_pendaftaran', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('verifikasiaskep_id, verifikasiaskep_tgl, verifikasiaskep_no, verifikasiaskep_ket, petugasverifikasi_nama, mengetahui_nama, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, verifikasiaskep_status, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, pasien_id, no_rekam_medik, nama_pasien, ruangan_id, ruangan_nama, kelaspelayanan_id, kelaspelayanan_nama, kamarruangan_id, kamarruangan_nokamar, kamarruangan_nobed, pegawai_id, nama_pegawai', 'safe', 'on'=>'search'),
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
			'verifikasiaskep_id' => 'Verifikasiaskep',
			'verifikasiaskep_tgl' => 'Verifikasiaskep Tgl',
			'verifikasiaskep_no' => 'Verifikasiaskep No',
			'verifikasiaskep_ket' => 'Verifikasiaskep Ket',
			'petugasverifikasi_nama' => 'Petugasverifikasi Nama',
			'mengetahui_nama' => 'Mengetahui Nama',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'verifikasiaskep_status' => 'Verifikasiaskep Status',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'kamarruangan_id' => 'Kamarruangan',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'pegawai_id' => 'Pegawai',
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

		$criteria->compare('verifikasiaskep_id',$this->verifikasiaskep_id);
		$criteria->compare('verifikasiaskep_tgl',$this->verifikasiaskep_tgl,true);
		$criteria->compare('verifikasiaskep_no',$this->verifikasiaskep_no,true);
		$criteria->compare('verifikasiaskep_ket',$this->verifikasiaskep_ket,true);
		$criteria->compare('petugasverifikasi_nama',$this->petugasverifikasi_nama,true);
		$criteria->compare('mengetahui_nama',$this->mengetahui_nama,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('verifikasiaskep_status',$this->verifikasiaskep_status,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
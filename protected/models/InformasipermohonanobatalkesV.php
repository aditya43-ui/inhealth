<?php

/**
 * This is the model class for table "informasipermohonanobatalkes_v".
 *
 * The followings are the available columns in table 'informasipermohonanobatalkes_v':
 * @property integer $permohonanoa_id
 * @property string $permohonanoa_tgl
 * @property string $permohonanoa_nomor
 * @property string $pemohon_jenisidentitas
 * @property string $pemohon_noidentitas
 * @property string $pemohon_nama
 * @property string $pemohon_jeniskelamin
 * @property string $pemohon_alamat
 * @property integer $rt
 * @property integer $rw
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property string $pemohon_notelp
 * @property string $pemohon_nomobile
 * @property string $pemohon_alamatemail
 * @property string $permohonan_alasan
 * @property string $permohonan_keterangan
 * @property string $permohonanoa_tglapproved
 * @property boolean $permohonanoa_isapproved
 * @property integer $profilrs_id
 * @property string $nokode_rumahsakit
 * @property string $nama_rumahsakit
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property integer $pegawaimenyetujui_id
 * @property string $pegawaimenyetujui_gelardepan
 * @property string $pegawaimenyetujui_nama
 * @property string $pegawaimenyetujui_gelarbelakang
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InformasipermohonanobatalkesV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipermohonanobatalkesV the static model class
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
		return 'informasipermohonanobatalkes_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permohonanoa_id, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, profilrs_id, pegawaimengetahui_id, pegawaimenyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('permohonanoa_nomor, pemohon_nama, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, pegawaimengetahui_nama, pegawaimenyetujui_nama', 'length', 'max'=>50),
			array('pemohon_jenisidentitas, pemohon_jeniskelamin, pemohon_notelp', 'length', 'max'=>20),
			array('pemohon_noidentitas, pemohon_nomobile', 'length', 'max'=>30),
			array('pemohon_alamatemail, nama_rumahsakit', 'length', 'max'=>100),
			array('nokode_rumahsakit, pegawaimengetahui_gelardepan, pegawaimenyetujui_gelardepan', 'length', 'max'=>10),
			array('pegawaimengetahui_gelarbelakang, pegawaimenyetujui_gelarbelakang', 'length', 'max'=>15),
			array('permohonanoa_tgl, pemohon_alamat, permohonan_alasan, permohonan_keterangan, permohonanoa_tglapproved, permohonanoa_isapproved, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permohonanoa_id, permohonanoa_tgl, permohonanoa_nomor, pemohon_jenisidentitas, pemohon_noidentitas, pemohon_nama, pemohon_jeniskelamin, pemohon_alamat, rt, rw, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, pemohon_notelp, pemohon_nomobile, pemohon_alamatemail, permohonan_alasan, permohonan_keterangan, permohonanoa_tglapproved, permohonanoa_isapproved, profilrs_id, nokode_rumahsakit, nama_rumahsakit, pegawaimengetahui_id, pegawaimengetahui_gelardepan, pegawaimengetahui_nama, pegawaimengetahui_gelarbelakang, pegawaimenyetujui_id, pegawaimenyetujui_gelardepan, pegawaimenyetujui_nama, pegawaimenyetujui_gelarbelakang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'permohonanoa_id' => 'Permohonanoa',
			'permohonanoa_tgl' => 'Tanggal Permohonan',
			'permohonanoa_nomor' => 'No. Permohonan',
			'pemohon_jenisidentitas' => 'Jenis Identitas',
			'pemohon_noidentitas' => 'No. Identitas',
			'pemohon_nama' => 'Nama Pemohon',
			'pemohon_jeniskelamin' => 'Jenis Kelamin',
			'pemohon_alamat' => 'Alamat',
			'rt' => 'RT',
			'rw' => 'RW',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Provinsi',
			'pemohon_notelp' => 'No. Telepon',
			'pemohon_nomobile' => 'No. Ponsel',
			'pemohon_alamatemail' => 'E-mail',
			'permohonan_alasan' => 'Alasan',
			'permohonan_keterangan' => 'Keterangan',
			'permohonanoa_tglapproved' => 'Tanggal Approved',
			'permohonanoa_isapproved' => 'Is Approved',
			'profilrs_id' => 'Profil RS.',
			'nokode_rumahsakit' => 'No. Kode RS.',
			'nama_rumahsakit' => 'Nama Rumah Sakit',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimengetahui_gelardepan' => 'Gelar Depan',
			'pegawaimengetahui_nama' => 'Pegawai Mengetahui',
			'pegawaimengetahui_gelarbelakang' => 'Gelar Belakang',
			'pegawaimenyetujui_id' => 'Pegawai Menyetujui',
			'pegawaimenyetujui_gelardepan' => 'Gelar Depan',
			'pegawaimenyetujui_nama' => 'Pegawai Menyetujui',
			'pegawaimenyetujui_gelarbelakang' => 'Gelar Belakang',
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

		$criteria->compare('permohonanoa_id',$this->permohonanoa_id);
		$criteria->compare('permohonanoa_tgl',$this->permohonanoa_tgl,true);
		$criteria->compare('permohonanoa_nomor',$this->permohonanoa_nomor,true);
		$criteria->compare('pemohon_jenisidentitas',$this->pemohon_jenisidentitas,true);
		$criteria->compare('pemohon_noidentitas',$this->pemohon_noidentitas,true);
		$criteria->compare('pemohon_nama',$this->pemohon_nama,true);
		$criteria->compare('pemohon_jeniskelamin',$this->pemohon_jeniskelamin,true);
		$criteria->compare('pemohon_alamat',$this->pemohon_alamat,true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kecamatan_nama',$this->kecamatan_nama,true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('propinsi_nama',$this->propinsi_nama,true);
		$criteria->compare('pemohon_notelp',$this->pemohon_notelp,true);
		$criteria->compare('pemohon_nomobile',$this->pemohon_nomobile,true);
		$criteria->compare('pemohon_alamatemail',$this->pemohon_alamatemail,true);
		$criteria->compare('permohonan_alasan',$this->permohonan_alasan,true);
		$criteria->compare('permohonan_keterangan',$this->permohonan_keterangan,true);
		$criteria->compare('permohonanoa_tglapproved',$this->permohonanoa_tglapproved,true);
		$criteria->compare('permohonanoa_isapproved',$this->permohonanoa_isapproved);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('nokode_rumahsakit',$this->nokode_rumahsakit,true);
		$criteria->compare('nama_rumahsakit',$this->nama_rumahsakit,true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimengetahui_gelardepan',$this->pegawaimengetahui_gelardepan,true);
		$criteria->compare('pegawaimengetahui_nama',$this->pegawaimengetahui_nama,true);
		$criteria->compare('pegawaimengetahui_gelarbelakang',$this->pegawaimengetahui_gelarbelakang,true);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('pegawaimenyetujui_gelardepan',$this->pegawaimenyetujui_gelardepan,true);
		$criteria->compare('pegawaimenyetujui_nama',$this->pegawaimenyetujui_nama,true);
		$criteria->compare('pegawaimenyetujui_gelarbelakang',$this->pegawaimenyetujui_gelarbelakang,true);
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
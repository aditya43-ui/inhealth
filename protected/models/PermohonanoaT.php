<?php

/**
 * This is the model class for table "permohonanoa_t".
 *
 * The followings are the available columns in table 'permohonanoa_t':
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
 * @property integer $kecamatan_id
 * @property integer $kabupaten_id
 * @property integer $propinsi_id
 * @property integer $profilrs_id
 * @property string $pemohon_notelp
 * @property string $pemohon_nomobile
 * @property string $pemohon_alamatemail
 * @property string $permohonan_alasan
 * @property string $permohonan_keterangan
 * @property integer $pegawaimengetahui_id
 * @property integer $pegawaimenyetujui_id
 * @property string $permohonanoa_tglapproved
 * @property boolean $permohonanoa_isapproved
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property string $permohonanoa_nosurat
 * @property string $permohonanoa_instansi
 *
 * The followings are the available model relations:
 * @property PermohonanoadetailT[] $permohonanoadetailTs
 * @property PenjualanresepT[] $penjualanresepTs
 * @property KabupatenM $kabupaten
 * @property KelurahanM $kelurahan
 * @property KecamatanM $kecamatan
 * @property PropinsiM $propinsi
 * @property ProfilrumahsakitM $profilrs
 * @property PegawaiM $pegawaimengetahui
 * @property PegawaiM $pegawaimenyetujui
 * @property LoginpemakaiK $createLoginpemakai
 * @property LoginpemakaiK $updateLoginpemakai
 * @property RuanganM $createRuangan
 */
class PermohonanoaT extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PermohonanoaT the static model class
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
		return 'permohonanoa_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('permohonanoa_tgl, permohonanoa_nomor, pemohon_nama, pemohon_jeniskelamin, pemohon_alamat, kecamatan_id, kabupaten_id, propinsi_id, profilrs_id, pemohon_notelp, create_time, create_loginpemakai_id, create_ruangan, permohonanoa_nosurat, permohonanoa_instansi', 'required'),
			array('rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, profilrs_id, pegawaimengetahui_id, pegawaimenyetujui_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('permohonanoa_nomor, pemohon_nama, permohonanoa_nosurat', 'length', 'max'=>50),
			array('pemohon_jenisidentitas, pemohon_jeniskelamin, pemohon_notelp', 'length', 'max'=>20),
			array('pemohon_noidentitas, pemohon_nomobile', 'length', 'max'=>30),
			array('pemohon_alamatemail', 'length', 'max'=>100),
			array('permohonanoa_instansi', 'length', 'max'=>200),
			array('permohonan_alasan, permohonan_keterangan, permohonanoa_tglapproved, permohonanoa_isapproved, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('permohonanoa_id, permohonanoa_tgl, permohonanoa_nomor, pemohon_jenisidentitas, pemohon_noidentitas, pemohon_nama, pemohon_jeniskelamin, pemohon_alamat, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, profilrs_id, pemohon_notelp, pemohon_nomobile, pemohon_alamatemail, permohonan_alasan, permohonan_keterangan, pegawaimengetahui_id, pegawaimenyetujui_id, permohonanoa_tglapproved, permohonanoa_isapproved, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, permohonanoa_nosurat, permohonanoa_instansi', 'safe', 'on'=>'search'),
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
			'permohonanoadetailTs' => array(self::HAS_MANY, 'PermohonanoadetailT', 'permohonanoa_id'),
			'penjualanresepTs' => array(self::HAS_MANY, 'PenjualanresepT', 'permohonanoa_id'),
			'kabupaten' => array(self::BELONGS_TO, 'KabupatenM', 'kabupaten_id'),
			'kelurahan' => array(self::BELONGS_TO, 'KelurahanM', 'kelurahan_id'),
			'kecamatan' => array(self::BELONGS_TO, 'KecamatanM', 'kecamatan_id'),
			'propinsi' => array(self::BELONGS_TO, 'PropinsiM', 'propinsi_id'),
			'profilrs' => array(self::BELONGS_TO, 'ProfilrumahsakitM', 'profilrs_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimengetahui_id'),
			'pegawaimenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawaimenyetujui_id'),
			'createLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'create_loginpemakai_id'),
			'updateLoginpemakai' => array(self::BELONGS_TO, 'LoginpemakaiK', 'update_loginpemakai_id'),
			'createRuangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan'),
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
			'pemohon_alamat' => 'Alamat Pemohon',
			'rt' => 'RT',
			'rw' => 'RW',
			'kelurahan_id' => 'Kelurahan',
			'kecamatan_id' => 'Kecamatan',
			'kabupaten_id' => 'Kabupaten',
			'propinsi_id' => 'Provinsi',
			'profilrs_id' => 'Profilrs',
			'pemohon_notelp' => 'No. Telepon Pemohon',
			'pemohon_nomobile' => 'No. Ponsel Pemohon',
			'pemohon_alamatemail' => 'E-mail',
			'permohonan_alasan' => 'Alasan',
			'permohonan_keterangan' => 'Keterangan',
			'pegawaimengetahui_id' => 'Pegawai Mengetahui',
			'pegawaimenyetujui_id' => 'Pegawai Menyetujui',
			'permohonanoa_tglapproved' => 'Tanggal Approved',
			'permohonanoa_isapproved' => 'Is Approved',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'permohonanoa_nosurat' => 'No. Surat',
			'permohonanoa_instansi' => 'Nama Instansi',
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
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('pemohon_notelp',$this->pemohon_notelp,true);
		$criteria->compare('pemohon_nomobile',$this->pemohon_nomobile,true);
		$criteria->compare('pemohon_alamatemail',$this->pemohon_alamatemail,true);
		$criteria->compare('permohonan_alasan',$this->permohonan_alasan,true);
		$criteria->compare('permohonan_keterangan',$this->permohonan_keterangan,true);
		$criteria->compare('pegawaimengetahui_id',$this->pegawaimengetahui_id);
		$criteria->compare('pegawaimenyetujui_id',$this->pegawaimenyetujui_id);
		$criteria->compare('permohonanoa_tglapproved',$this->permohonanoa_tglapproved,true);
		$criteria->compare('permohonanoa_isapproved',$this->permohonanoa_isapproved);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('permohonanoa_nosurat',$this->permohonanoa_nosurat,true);
		$criteria->compare('permohonanoa_instansi',$this->permohonanoa_instansi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
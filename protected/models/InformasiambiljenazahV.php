<?php

/**
 * This is the model class for table "informasiambiljenazah_v".
 *
 * The followings are the available columns in table 'informasiambiljenazah_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasimeninggal_id
 * @property string $instalasimeninggal_nama
 * @property integer $ruanganmeninggal_id
 * @property string $ruanganmeninggal_nama
 * @property integer $ambiljenazah_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $jenisidentitas
 * @property string $no_identitas_pasien
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
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
 * @property string $statusperkawinan
 * @property string $agama
 * @property string $golongandarah
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $alamatemail
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $tglpengambilan
 * @property string $tglmeninggal
 * @property string $nama_pengambiljenazah
 * @property string $hubungan_pengjenazah
 * @property string $noidentitas_pengjenazah
 * @property string $alamat_pengjenazah
 * @property string $notelepon_pengjenazah
 * @property string $keterangan_pengambilan
 */
class InformasiambiljenazahV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasiambiljenazahV the static model class
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
		return 'informasiambiljenazah_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, ruangan_id, instalasimeninggal_id, ruanganmeninggal_id, ambiljenazah_id, pasien_id, rt, rw, kelurahan_id, kecamatan_id, kabupaten_id, propinsi_id, pendaftaran_id', 'numerical', 'integerOnly'=>true),
			array('instalasi_nama, ruangan_nama, instalasimeninggal_nama, ruanganmeninggal_nama, nama_pasien, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, hubungan_pengjenazah, notelepon_pengjenazah', 'length', 'max'=>50),
			array('no_rekam_medik', 'length', 'max'=>10),
			array('jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, no_mobile_pasien, no_pendaftaran', 'length', 'max'=>20),
			array('no_identitas_pasien, nama_bin', 'length', 'max'=>30),
			array('tempat_lahir, warga_negara', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('no_telepon_pasien', 'length', 'max'=>15),
			array('alamatemail, nama_pengambiljenazah, noidentitas_pengjenazah', 'length', 'max'=>100),
			array('tanggal_lahir, alamat_pasien, tgl_pendaftaran, tglpengambilan, tglmeninggal, alamat_pengjenazah, keterangan_pengambilan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, instalasimeninggal_id, instalasimeninggal_nama, ruanganmeninggal_id, ruanganmeninggal_nama, ambiljenazah_id, pasien_id, no_rekam_medik, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, kabupaten_id, kabupaten_nama, propinsi_id, propinsi_nama, statusperkawinan, agama, golongandarah, no_telepon_pasien, no_mobile_pasien, warga_negara, alamatemail, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, tglpengambilan, tglmeninggal, nama_pengambiljenazah, hubungan_pengjenazah, noidentitas_pengjenazah, alamat_pengjenazah, notelepon_pengjenazah, keterangan_pengambilan', 'safe', 'on'=>'search'),
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasimeninggal_id' => 'Instalasimeninggal',
			'instalasimeninggal_nama' => 'Instalasimeninggal Nama',
			'ruanganmeninggal_id' => 'Ruanganmeninggal',
			'ruanganmeninggal_nama' => 'Ruanganmeninggal Nama',
			'ambiljenazah_id' => 'Ambiljenazah',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'warga_negara' => 'Warga Negara',
			'alamatemail' => 'Alamatemail',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'tglpengambilan' => 'Tglpengambilan',
			'tglmeninggal' => 'Tglmeninggal',
			'nama_pengambiljenazah' => 'Nama Pengambiljenazah',
			'hubungan_pengjenazah' => 'Hubungan Pengambil Jenazah',
			'noidentitas_pengjenazah' => 'Noidentitas Pengjenazah',
			'alamat_pengjenazah' => 'Alamat Pengjenazah',
			'notelepon_pengjenazah' => 'Notelepon Pengjenazah',
			'keterangan_pengambilan' => 'Keterangan Pengambilan',
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

		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasimeninggal_id',$this->instalasimeninggal_id);
		$criteria->compare('instalasimeninggal_nama',$this->instalasimeninggal_nama,true);
		$criteria->compare('ruanganmeninggal_id',$this->ruanganmeninggal_id);
		$criteria->compare('ruanganmeninggal_nama',$this->ruanganmeninggal_nama,true);
		$criteria->compare('ambiljenazah_id',$this->ambiljenazah_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
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
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('no_telepon_pasien',$this->no_telepon_pasien,true);
		$criteria->compare('no_mobile_pasien',$this->no_mobile_pasien,true);
		$criteria->compare('warga_negara',$this->warga_negara,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('tglpengambilan',$this->tglpengambilan,true);
		$criteria->compare('tglmeninggal',$this->tglmeninggal,true);
		$criteria->compare('nama_pengambiljenazah',$this->nama_pengambiljenazah,true);
		$criteria->compare('hubungan_pengjenazah',$this->hubungan_pengjenazah,true);
		$criteria->compare('noidentitas_pengjenazah',$this->noidentitas_pengjenazah,true);
		$criteria->compare('alamat_pengjenazah',$this->alamat_pengjenazah,true);
		$criteria->compare('notelepon_pengjenazah',$this->notelepon_pengjenazah,true);
		$criteria->compare('keterangan_pengambilan',$this->keterangan_pengambilan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "informasipasienpegawai_v".
 *
 * The followings are the available columns in table 'informasipasienpegawai_v':
 * @property integer $pasien_id
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
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $transportasi
 * @property string $keadaanmasuk
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
 * @property string $statusmasuk
 * @property string $umur
 * @property string $nokartuasuransi
 * @property integer $asuransipasien_id
 * @property string $namapemilikasuransi
 * @property string $nomorpokokperusahaan
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $no_rujukan
 * @property string $nama_perujuk
 * @property string $tanggal_rujukan
 * @property string $diagnosa_rujukan
 * @property integer $asalrujukan_id
 * @property string $asalrujukan_nama
 * @property integer $penanggungjawab_id
 * @property string $pengantar
 * @property string $hubungankeluarga
 * @property string $nama_pj
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property integer $pegawai_id
 * @property integer $kelompokpegawai_id
 * @property string $kelompokpegawai_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property string $nomorindukpegawai
 * @property string $kelompokjabatan
 * @property string $kategoripegawai
 */
class InformasipasienpegawaiV extends CActiveRecord
{
    
        public $tgl_rm_awal;
        public $tgl_rm_akhir;
        public $ceklis;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipasienpegawaiV the static model class
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
		return 'informasipasienpegawai_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, pendaftaran_id, asuransipasien_id, carabayar_id, penjamin_id, asalrujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, kelaspelayanan_id, pegawai_id, kelompokpegawai_id, jabatan_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, statusperkawinan, no_pendaftaran, no_rujukan, agama', 'length', 'max'=>20),
			array('no_identitas_pasien, umur, kelompokpegawai_nama, nomorindukpegawai, kelompokjabatan', 'length', 'max'=>30),
			array('nama_pasien, nama_bin, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, nokartuasuransi, namapemilikasuransi, nomorpokokperusahaan, carabayar_nama, penjamin_nama, nama_perujuk, asalrujukan_nama, pengantar, hubungankeluarga, nama_pj, ruangan_nama, instalasi_nama, kelaspelayanan_nama', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('no_rekam_medik, statusrekammedis', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail, jabatan_nama', 'length', 'max'=>100),
			array('kategoripegawai', 'length', 'max'=>128),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, create_time, create_loginpemakai_id, create_ruangan, tanggal_rujukan, diagnosa_rujukan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, statusperkawinan, no_rekam_medik, tgl_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, nokartuasuransi, asuransipasien_id, namapemilikasuransi, nomorpokokperusahaan, create_time, create_loginpemakai_id, create_ruangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, kelaspelayanan_id, kelaspelayanan_nama, agama, golongandarah, photopasien, alamatemail, statusrekammedis, pegawai_id, kelompokpegawai_id, kelompokpegawai_nama, jabatan_id, jabatan_nama, nomorindukpegawai, kelompokjabatan, kategoripegawai', 'safe', 'on'=>'search'),
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
			'pasien_id' => 'Pasien',
			'jenisidentitas' => 'Jenisidentitas',
			'no_identitas_pasien' => 'No Identitas Pasien',
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Bin',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'statusperkawinan' => 'Status Perkawainan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_urutantri' => 'No Urutantri',
			'transportasi' => 'Transportasi',
			'keadaanmasuk' => 'Keadaan Pasuk',
			'statusperiksa' => 'Status Periksa',
			'statuspasien' => 'Status Pasien',
			'kunjungan' => 'Kunjungan',
			'alihstatus' => 'Alih Status',
			'byphone' => 'By Phone',
			'kunjunganrumah' => 'Kunjungan Rumah',
			'statusmasuk' => 'Status Masuk',
			'umur' => 'Umur',
			'nokartuasuransi' => 'No Kartu Asuransi',
			'asuransipasien_id' => 'Asuransi Pasien',
			'namapemilikasuransi' => 'Nama Pemilik Asuransi',
			'nomorpokokperusahaan' => 'Nomor Pokok Perusahaan',
			'create_time' => 'Waktu Create',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'no_rujukan' => 'No Rujukan',
			'nama_perujuk' => 'Nama Perujuk',
			'tanggal_rujukan' => 'Tanggal Rujukan',
			'diagnosa_rujukan' => 'Diagnosa Rujukan',
			'asalrujukan_id' => 'Asal Rujukan',
			'asalrujukan_nama' => 'Asal Rujukan',
			'penanggungjawab_id' => 'Penanggung Jawab',
			'pengantar' => 'Pengantar',
			'hubungankeluarga' => 'Hubungan Keluarga',
			'nama_pj' => 'Nama Pj',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'statusrekammedis' => 'Status Rekam Medis',
			'pegawai_id' => 'Pegawai',
			'kelompokpegawai_id' => 'Kelompok Pegawai',
			'kelompokpegawai_nama' => 'Kelompok Pegawai Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'nomorindukpegawai' => 'Nomor Induk Pegawai',
			'kelompokjabatan' => 'Kelompok Jabatan',
			'kategoripegawai' => 'Kategori Pegawai',
                        'tgl_rm_awal' => 'Tgl. Rekam Medis',
                        'tgl_rm_akhir' => 'Sampai Dengan',
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

                if (!empty($this->tgl_rm_awal) && !empty($this->tgl_rm_akhir))
                    $criteria->addBetweenCondition ('tgl_pendaftaran::date', $this->tgl_rm_awal, $this->tgl_rm_akhir);
                
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('jenisidentitas',$this->jenisidentitas,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('namadepan',$this->namadepan,true);
		$criteria->compare('lower(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('nama_bin',$this->nama_bin,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('tempat_lahir',$this->tempat_lahir,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('lower(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('tgl_rekam_medik',$this->tgl_rekam_medik,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_urutantri',$this->no_urutantri,true);
		$criteria->compare('transportasi',$this->transportasi,true);
		$criteria->compare('keadaanmasuk',$this->keadaanmasuk,true);
		$criteria->compare('statusperiksa',$this->statusperiksa,true);
		$criteria->compare('statuspasien',$this->statuspasien,true);
		$criteria->compare('kunjungan',$this->kunjungan,true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('statusmasuk',$this->statusmasuk,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('nokartuasuransi',$this->nokartuasuransi,true);
		$criteria->compare('asuransipasien_id',$this->asuransipasien_id);
		$criteria->compare('namapemilikasuransi',$this->namapemilikasuransi,true);
		$criteria->compare('nomorpokokperusahaan',$this->nomorpokokperusahaan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('no_rujukan',$this->no_rujukan,true);
		$criteria->compare('nama_perujuk',$this->nama_perujuk,true);
		$criteria->compare('tanggal_rujukan',$this->tanggal_rujukan,true);
		$criteria->compare('diagnosa_rujukan',$this->diagnosa_rujukan,true);
		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('asalrujukan_nama',$this->asalrujukan_nama,true);
		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('pengantar',$this->pengantar,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('photopasien',$this->photopasien,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('statusrekammedis',$this->statusrekammedis,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('kelompokpegawai_nama',$this->kelompokpegawai_nama,true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('jabatan_nama',$this->jabatan_nama,true);
		$criteria->compare('nomorindukpegawai',$this->nomorindukpegawai,true);
		$criteria->compare('kelompokjabatan',$this->kelompokjabatan,true);
		$criteria->compare('kategoripegawai',$this->kategoripegawai,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
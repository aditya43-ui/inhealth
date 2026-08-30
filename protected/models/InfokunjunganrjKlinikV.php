<?php

/**
 * This is the model class for table "infokunjunganrj_klinik_v".
 *
 * The followings are the available columns in table 'infokunjunganrj_klinik_v':
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
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
 * @property integer $propinsi_id
 * @property string $propinsi_nama
 * @property integer $kabupaten_id
 * @property string $kabupaten_nama
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property integer $kecamatan_id
 * @property string $kecamatan_nama
 * @property integer $pendaftaran_id
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
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
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $caramasuk_id
 * @property string $caramasuk_nama
 * @property integer $shift_id
 * @property integer $golonganumur_id
 * @property string $golonganumur_nama
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
 * @property string $ruangan_singkatan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property string $status_konfirmasi
 * @property string $tgl_konfirmasi
 * @property integer $pegawai_id
 * @property string $tglrenkontrol
 * @property integer $pembayaranpelayanan_id
 * @property boolean $panggilantrian
 * @property string $tglakandilayani
 * @property integer $antrian_id
 * @property string $tglantrian
 * @property string $noantrian
 * @property boolean $panggil_flaq
 * @property integer $loket_id
 * @property string $loket_nama
 * @property string $loket_fungsi
 * @property string $loket_singkatan
 * @property integer $loket_nourut
 * @property string $loket_formatnomor
 * @property integer $loket_maksantrian
 * @property string $nopeserta
 * @property string $tglcetakkartuasuransi
 * @property string $kodefeskestk1
 * @property string $nama_feskestk1
 * @property string $masaberlakukartu
 * @property string $nokartukeluarga
 * @property string $nopassport
 * @property boolean $asuransipasien_aktif
 * @property string $keterangan_pendaftaran
 * @property integer $pengirimanrm_id
 * @property string $statusdokrm
 * @property integer $kelompokpegawai_id
 * @property integer $pasienpulang_id
 * @property integer $carakeluar_id
 * @property integer $sep_id
 * @property integer $konsulpoli_id
 */
class InfokunjunganrjKlinikV extends CActiveRecord
{
	public $tgl_awal;
    public $tgl_akhir;
    public $pilihanx;
    public $statusBayar;
    public $pendidikan_id, $suku_id;
    public $tahun, $bulan;      
    public $rujukandari_id, $pasienadmisi_id;  
    public $prefix_pendaftaran;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'infokunjunganrj_klinik_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pendaftaran_id, pekerjaan_id, carabayar_id, penjamin_id, caramasuk_id, shift_id, golonganumur_id, asalrujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, pegawai_id, pembayaranpelayanan_id, antrian_id, loket_id, loket_nourut, loket_maksantrian, pengirimanrm_id, kelompokpegawai_id, pasienpulang_id, carakeluar_id, sep_id, konsulpoli_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran, no_rujukan', 'length', 'max'=>20),
			array('no_identitas_pasien, umur', 'length', 'max'=>30),
			array('nama_pasien, nama_bin, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_nama, caramasuk_nama, nama_perujuk, asalrujukan_nama, pengantar, hubungankeluarga, nama_pj, ruangan_nama, instalasi_nama, kelaspelayanan_nama, gelarbelakang_nama, status_konfirmasi, loket_nama, nopeserta, kodefeskestk1, statusdokrm', 'length', 'max'=>50),
			array('tempat_lahir, golonganumur_nama', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien, nama_feskestk1, nopassport, keterangan_pendaftaran', 'length', 'max'=>200),
			array('alamatemail, penjamin_nama, jeniskasuspenyakit_nama, nama_pegawai, nokartukeluarga', 'length', 'max'=>100),
			array('statusrekammedis, no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>8),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('noantrian', 'length', 'max'=>6),
			array('loket_singkatan', 'length', 'max'=>1),
			array('loket_formatnomor', 'length', 'max'=>5),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, create_time, create_loginpemakai_id, create_ruangan, tanggal_rujukan, diagnosa_rujukan, tgl_konfirmasi, tglrenkontrol, panggilantrian, tglakandilayani, tglantrian, panggil_flaq, loket_fungsi, tglcetakkartuasuransi, masaberlakukartu, asuransipasien_aktif', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, create_time, create_loginpemakai_id, create_ruangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, caramasuk_id, caramasuk_nama, shift_id, golonganumur_id, golonganumur_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, ruangan_id, ruangan_nama, ruangan_singkatan, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, gelardepan, nama_pegawai, gelarbelakang_nama, status_konfirmasi, tgl_konfirmasi, pegawai_id, tglrenkontrol, pembayaranpelayanan_id, panggilantrian, tglakandilayani, antrian_id, tglantrian, noantrian, panggil_flaq, loket_id, loket_nama, loket_fungsi, loket_singkatan, loket_nourut, loket_formatnomor, loket_maksantrian, nopeserta, tglcetakkartuasuransi, kodefeskestk1, nama_feskestk1, masaberlakukartu, nokartukeluarga, nopassport, asuransipasien_aktif, keterangan_pendaftaran, pengirimanrm_id, statusdokrm, kelompokpegawai_id, pasienpulang_id, carakeluar_id, sep_id, konsulpoli_id', 'safe', 'on'=>'search'),
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
			'jeniskelamin' => 'Jeniskelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'Rt',
			'rw' => 'Rw',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'statusrekammedis' => 'Statusrekammedis',
			'statusperkawinan' => 'Statusperkawinan',
			'no_rekam_medik' => 'No Rekam Medik',
			'tgl_rekam_medik' => 'Tgl Rekam Medik',
			'propinsi_id' => 'Propinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'pendaftaran_id' => 'Pendaftaran',
			'pekerjaan_id' => 'Pekerjaan',
			'pekerjaan_nama' => 'Pekerjaan Nama',
			'no_pendaftaran' => 'No Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'no_urutantri' => 'No Urutantri',
			'transportasi' => 'Transportasi',
			'keadaanmasuk' => 'Keadaanmasuk',
			'statusperiksa' => 'Statusperiksa',
			'statuspasien' => 'Statuspasien',
			'kunjungan' => 'Kunjungan',
			'alihstatus' => 'Alihstatus',
			'byphone' => 'Byphone',
			'kunjunganrumah' => 'Kunjunganrumah',
			'statusmasuk' => 'Statusmasuk',
			'umur' => 'Umur',
			'no_asuransi' => 'No Asuransi',
			'namapemilik_asuransi' => 'Namapemilik Asuransi',
			'nopokokperusahaan' => 'Nopokokperusahaan',
			'create_time' => 'Create Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'carabayar_id' => 'Carabayar',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'caramasuk_id' => 'Caramasuk',
			'caramasuk_nama' => 'Caramasuk Nama',
			'shift_id' => 'Shift',
			'golonganumur_id' => 'Golonganumur',
			'golonganumur_nama' => 'Golonganumur Nama',
			'no_rujukan' => 'No Rujukan',
			'nama_perujuk' => 'Nama Perujuk',
			'tanggal_rujukan' => 'Tanggal Rujukan',
			'diagnosa_rujukan' => 'Diagnosa Rujukan',
			'asalrujukan_id' => 'Asalrujukan',
			'asalrujukan_nama' => 'Asalrujukan Nama',
			'penanggungjawab_id' => 'Penanggungjawab',
			'pengantar' => 'Pengantar',
			'hubungankeluarga' => 'Hubungankeluarga',
			'nama_pj' => 'Nama Pj',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'status_konfirmasi' => 'Status Konfirmasi',
			'tgl_konfirmasi' => 'Tgl Konfirmasi',
			'pegawai_id' => 'Pegawai',
			'tglrenkontrol' => 'Tglrenkontrol',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'panggilantrian' => 'Panggilantrian',
			'tglakandilayani' => 'Tglakandilayani',
			'antrian_id' => 'Antrian',
			'tglantrian' => 'Tglantrian',
			'noantrian' => 'Noantrian',
			'panggil_flaq' => 'Panggil Flaq',
			'loket_id' => 'Loket',
			'loket_nama' => 'Loket Nama',
			'loket_fungsi' => 'Loket Fungsi',
			'loket_singkatan' => 'Loket Singkatan',
			'loket_nourut' => 'Loket Nourut',
			'loket_formatnomor' => 'Loket Formatnomor',
			'loket_maksantrian' => 'Loket Maksantrian',
			'nopeserta' => 'Nopeserta',
			'tglcetakkartuasuransi' => 'Tglcetakkartuasuransi',
			'kodefeskestk1' => 'Kodefeskestk1',
			'nama_feskestk1' => 'Nama Feskestk1',
			'masaberlakukartu' => 'Masaberlakukartu',
			'nokartukeluarga' => 'Nokartukeluarga',
			'nopassport' => 'Nopassport',
			'asuransipasien_aktif' => 'Asuransipasien Aktif',
			'keterangan_pendaftaran' => 'Keterangan Pendaftaran',
			'pengirimanrm_id' => 'Pengirimanrm',
			'statusdokrm' => 'Statusdokrm',
			'kelompokpegawai_id' => 'Kelompokpegawai',
			'pasienpulang_id' => 'Pasienpulang',
			'carakeluar_id' => 'Carakeluar',
			'sep_id' => 'Sep',
			'konsulpoli_id' => 'Konsulpoli',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pasien_id',$this->pasien_id);
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
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('photopasien',$this->photopasien,true);
		$criteria->compare('alamatemail',$this->alamatemail,true);
		$criteria->compare('statusrekammedis',$this->statusrekammedis,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('tgl_rekam_medik',$this->tgl_rekam_medik,true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('propinsi_nama',$this->propinsi_nama,true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('kecamatan_nama',$this->kecamatan_nama,true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
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
		$criteria->compare('no_asuransi',$this->no_asuransi,true);
		$criteria->compare('namapemilik_asuransi',$this->namapemilik_asuransi,true);
		$criteria->compare('nopokokperusahaan',$this->nopokokperusahaan,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('caramasuk_nama',$this->caramasuk_nama,true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('golonganumur_nama',$this->golonganumur_nama,true);
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
		$criteria->compare('ruangan_singkatan',$this->ruangan_singkatan,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('status_konfirmasi',$this->status_konfirmasi,true);
		$criteria->compare('tgl_konfirmasi',$this->tgl_konfirmasi,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglrenkontrol',$this->tglrenkontrol,true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('panggilantrian',$this->panggilantrian);
		$criteria->compare('tglakandilayani',$this->tglakandilayani,true);
		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('tglantrian',$this->tglantrian,true);
		$criteria->compare('noantrian',$this->noantrian,true);
		$criteria->compare('panggil_flaq',$this->panggil_flaq);
		$criteria->compare('loket_id',$this->loket_id);
		$criteria->compare('loket_nama',$this->loket_nama,true);
		$criteria->compare('loket_fungsi',$this->loket_fungsi,true);
		$criteria->compare('loket_singkatan',$this->loket_singkatan,true);
		$criteria->compare('loket_nourut',$this->loket_nourut);
		$criteria->compare('loket_formatnomor',$this->loket_formatnomor,true);
		$criteria->compare('loket_maksantrian',$this->loket_maksantrian);
		$criteria->compare('nopeserta',$this->nopeserta,true);
		$criteria->compare('tglcetakkartuasuransi',$this->tglcetakkartuasuransi,true);
		$criteria->compare('kodefeskestk1',$this->kodefeskestk1,true);
		$criteria->compare('nama_feskestk1',$this->nama_feskestk1,true);
		$criteria->compare('masaberlakukartu',$this->masaberlakukartu,true);
		$criteria->compare('nokartukeluarga',$this->nokartukeluarga,true);
		$criteria->compare('nopassport',$this->nopassport,true);
		$criteria->compare('asuransipasien_aktif',$this->asuransipasien_aktif);
		$criteria->compare('keterangan_pendaftaran',$this->keterangan_pendaftaran,true);
		$criteria->compare('pengirimanrm_id',$this->pengirimanrm_id);
		$criteria->compare('statusdokrm',$this->statusdokrm,true);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('pasienpulang_id',$this->pasienpulang_id);
		$criteria->compare('carakeluar_id',$this->carakeluar_id);
		$criteria->compare('sep_id',$this->sep_id);
		$criteria->compare('konsulpoli_id',$this->konsulpoli_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InfokunjunganrjKlinikV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE ORDER BY carabayar_nama ASC') ;
        }
        
        public function getPenjaminItems()
        {
            return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE ORDER BY penjamin_nama ASC');
        }
        
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
        }
        
        public function getNamaNamaBIN()
        {
            if (!empty($this->nama_bin)) {
        		//return $this->namadepan." ".$this->nama_pasien.' alias '.$this->nama_bin;
				return $this->nama_pasien;
        	} else {
       			//return $this->namadepan." ".$this->nama_pasien;
				return $this->nama_pasien;
        	}  
            
        }
        
        public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.' / '.$this->penjamin_nama;
        }
        
        public function getRTRW()
        {
            return $this->rt.' / '.$this->rw;
        }
        
        public function getStatus($status,$id){
            $statusantara = Yii::app()->db->createCommand()->select('(barangjadi_stok) as barangjadi_stok, (barangjadi_id) as barangjadi_id')->from('barangjadi_m')->where("barangjadi_id = $id AND barangjadi_stok between barangjadi_stok and barangjadi_minimal")->queryAll();
            if($status  == strtolower('ANTRIAN')){
                $status = '<span style="color:black;" id="yellow">'.$status.'</span>';
                
            }else if($status == strtolower('SEDANG PERIKSA')){
                $status = '<span style="color:black;" id="green">'.$status.'</span>';
            }else if($status == strtolower('SUDAH PERIKSA')){
                $status = '<span style="color:black; id="blue">'.$status.'</span>';
            }else{
                $status = '<span style="color:black;>'.$status.'</span>';
            }
            return $status;
        }
        
         public function getPekerjaanItems()
        {
            return PekerjaanM::model()->findAll('pekerjaan_aktif=TRUE ORDER BY pekerjaan_nama');
        }
        
         public function getPendidikanItems()
        {
            return PendidikanM::model()->findAll('pendidikan_aktif=TRUE ORDER BY pendidikan_nama');
        }
        
         public function getSukuItems()
        {
            return SukuM::model()->findAll('suku_aktif=TRUE ORDER BY suku_nama');
        }
}
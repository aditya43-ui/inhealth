<?php

/**
 * This is the model class for table "informasikasirrehabmedis_v".
 *
 * The followings are the available columns in table 'informasikasirrehabmedis_v':
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
 * @property string $tgl_pendaftaran
 * @property string $keadaanmasuk
 * @property string $statuspasien
 * @property boolean $alihstatus
 * @property string $statusmasuk
 * @property string $umur
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
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
 * @property integer $ruanganasal_id
 * @property string $ruanganasal_nama
 * @property integer $instalasiasal_id
 * @property string $instalasiasal_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $gelardokterasal
 * @property string $nama_dokterasal
 * @property string $gelarbelakang_nama
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property string $no_urutperiksa
 * @property string $kunjungan
 * @property string $statusperiksa
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pasienadmisi_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $create_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $pegawai_id
 * @property string $no_rekam_medik
 * @property string $no_pendaftaran
 * @property string $namaperujuk
 * @property string $alamatlengkapperujuk
 * @property string $notelpperujuk
 * @property integer $rujukandari_id
 * @property string $tglbatal
 * @property string $keterangan_batal
 * @property integer $pasienbatalperiksa_id
 * @property integer $pembayaranpelayanan_id
 * @property boolean $ispasienluar
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property string $warga_negara
 * @property string $rhesus
 * @property boolean $panggilantrian
 * @property string $ruangan_singkatan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property string $tglcetakkartuasuransi
 * @property string $kodefeskestk1
 * @property string $nama_feskestk1
 * @property string $masaberlakukartu
 * @property string $nokartukeluarga
 * @property string $nopassport
 * @property string $status_konfirmasi
 * @property string $tgl_konfirmasi
 * @property boolean $asuransipasien_aktif
 * @property string $keterangan_pendaftaran
 * @property integer $jml_panggil
 * @property string $waktumulaiperiksa
 * @property integer $pasienkirimkeunitlain_id
 * @property string $tgladmisi
 * @property integer $dokterasal_id
 * @property string $catatandokterpengirim
 */
class InformasikasirrehabmedisV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informasikasirrehabmedis_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pendaftaran_id, pekerjaan_id, carabayar_id, penjamin_id, caramasuk_id, shift_id, golonganumur_id, asalrujukan_id, penanggungjawab_id, ruanganasal_id, instalasiasal_id, jeniskasuspenyakit_id, kelaspelayanan_id, ruangan_id, pasienadmisi_id, pasienmasukpenunjang_id, pegawai_id, rujukandari_id, pasienbatalperiksa_id, pembayaranpelayanan_id, instalasi_id, jml_panggil, pasienkirimkeunitlain_id, dokterasal_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_rujukan, no_masukpenunjang, no_pendaftaran, rhesus', 'length', 'max'=>20),
			array('no_identitas_pasien, umur', 'length', 'max'=>30),
			array('nama_pasien, nama_bin, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, keadaanmasuk, statuspasien, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_nama, penjamin_nama, caramasuk_nama, nama_perujuk, asalrujukan_nama, pengantar, hubungankeluarga, nama_pj, ruanganasal_nama, instalasiasal_nama, kelaspelayanan_nama, nama_dokterasal, kunjungan, statusperiksa, ruangan_nama, nama_pegawai, nama_ibu, nama_ayah, instalasi_nama, kodefeskestk1, status_konfirmasi', 'length', 'max'=>50),
			array('tempat_lahir, golonganumur_nama, warga_negara', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien, nama_feskestk1, nopassport, keterangan_pendaftaran', 'length', 'max'=>200),
			array('alamatemail, jeniskasuspenyakit_nama, namaperujuk, notelpperujuk, nokartukeluarga', 'length', 'max'=>100),
			array('statusrekammedis, gelardokterasal, gelardepan, no_rekam_medik', 'length', 'max'=>10),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('no_urutperiksa, ruangan_singkatan', 'length', 'max'=>3),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, tanggal_rujukan, diagnosa_rujukan, tglmasukpenunjang, create_time, create_loginpemakai_id, create_ruangan, alamatlengkapperujuk, tglbatal, keterangan_batal, ispasienluar, panggilantrian, tglcetakkartuasuransi, masaberlakukartu, tgl_konfirmasi, asuransipasien_aktif, waktumulaiperiksa, tgladmisi, catatandokterpengirim', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, tgl_pendaftaran, keadaanmasuk, statuspasien, alihstatus, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, caramasuk_id, caramasuk_nama, shift_id, golonganumur_id, golonganumur_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, ruanganasal_id, ruanganasal_nama, instalasiasal_id, instalasiasal_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, gelardokterasal, nama_dokterasal, gelarbelakang_nama, no_masukpenunjang, tglmasukpenunjang, no_urutperiksa, kunjungan, statusperiksa, ruangan_id, ruangan_nama, pasienadmisi_id, pasienmasukpenunjang_id, create_time, create_loginpemakai_id, create_ruangan, gelardepan, nama_pegawai, pegawai_id, no_rekam_medik, no_pendaftaran, namaperujuk, alamatlengkapperujuk, notelpperujuk, rujukandari_id, tglbatal, keterangan_batal, pasienbatalperiksa_id, pembayaranpelayanan_id, ispasienluar, nama_ibu, nama_ayah, warga_negara, rhesus, panggilantrian, ruangan_singkatan, instalasi_id, instalasi_nama, tglcetakkartuasuransi, kodefeskestk1, nama_feskestk1, masaberlakukartu, nokartukeluarga, nopassport, status_konfirmasi, tgl_konfirmasi, asuransipasien_aktif, keterangan_pendaftaran, jml_panggil, waktumulaiperiksa, pasienkirimkeunitlain_id, tgladmisi, dokterasal_id, catatandokterpengirim', 'safe', 'on'=>'search'),
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
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'keadaanmasuk' => 'Keadaanmasuk',
			'statuspasien' => 'Statuspasien',
			'alihstatus' => 'Alihstatus',
			'statusmasuk' => 'Statusmasuk',
			'umur' => 'Umur',
			'no_asuransi' => 'No Asuransi',
			'namapemilik_asuransi' => 'Namapemilik Asuransi',
			'nopokokperusahaan' => 'Nopokokperusahaan',
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
			'ruanganasal_id' => 'Ruanganasal',
			'ruanganasal_nama' => 'Ruanganasal Nama',
			'instalasiasal_id' => 'Instalasiasal',
			'instalasiasal_nama' => 'Instalasiasal Nama',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'gelardokterasal' => 'Gelardokterasal',
			'nama_dokterasal' => 'Nama Dokterasal',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'no_masukpenunjang' => 'No Masukpenunjang',
			'tglmasukpenunjang' => 'Tglmasukpenunjang',
			'no_urutperiksa' => 'No Urutperiksa',
			'kunjungan' => 'Kunjungan',
			'statusperiksa' => 'Statusperiksa',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'create_time' => 'Create Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'pegawai_id' => 'Pegawai',
			'no_rekam_medik' => 'No Rekam Medik',
			'no_pendaftaran' => 'No Pendaftaran',
			'namaperujuk' => 'Namaperujuk',
			'alamatlengkapperujuk' => 'Alamatlengkapperujuk',
			'notelpperujuk' => 'Notelpperujuk',
			'rujukandari_id' => 'Rujukandari',
			'tglbatal' => 'Tglbatal',
			'keterangan_batal' => 'Keterangan Batal',
			'pasienbatalperiksa_id' => 'Pasienbatalperiksa',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'ispasienluar' => 'Ispasienluar',
			'nama_ibu' => 'Nama Ibu',
			'nama_ayah' => 'Nama Ayah',
			'warga_negara' => 'Warga Negara',
			'rhesus' => 'Rhesus',
			'panggilantrian' => 'Panggilantrian',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'tglcetakkartuasuransi' => 'Tglcetakkartuasuransi',
			'kodefeskestk1' => 'Kodefeskestk1',
			'nama_feskestk1' => 'Nama Feskestk1',
			'masaberlakukartu' => 'Masaberlakukartu',
			'nokartukeluarga' => 'Nokartukeluarga',
			'nopassport' => 'Nopassport',
			'status_konfirmasi' => 'Status Konfirmasi',
			'tgl_konfirmasi' => 'Tgl Konfirmasi',
			'asuransipasien_aktif' => 'Asuransipasien Aktif',
			'keterangan_pendaftaran' => 'Keterangan Pendaftaran',
			'jml_panggil' => 'Jml Panggil',
			'waktumulaiperiksa' => 'Waktumulaiperiksa',
			'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
			'tgladmisi' => 'Tgladmisi',
			'dokterasal_id' => 'Dokterasal',
			'catatandokterpengirim' => 'Catatandokterpengirim',
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
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('keadaanmasuk',$this->keadaanmasuk,true);
		$criteria->compare('statuspasien',$this->statuspasien,true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('statusmasuk',$this->statusmasuk,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('no_asuransi',$this->no_asuransi,true);
		$criteria->compare('namapemilik_asuransi',$this->namapemilik_asuransi,true);
		$criteria->compare('nopokokperusahaan',$this->nopokokperusahaan,true);
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
		$criteria->compare('ruanganasal_id',$this->ruanganasal_id);
		$criteria->compare('ruanganasal_nama',$this->ruanganasal_nama,true);
		$criteria->compare('instalasiasal_id',$this->instalasiasal_id);
		$criteria->compare('instalasiasal_nama',$this->instalasiasal_nama,true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('gelardokterasal',$this->gelardokterasal,true);
		$criteria->compare('nama_dokterasal',$this->nama_dokterasal,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('no_masukpenunjang',$this->no_masukpenunjang,true);
		$criteria->compare('tglmasukpenunjang',$this->tglmasukpenunjang,true);
		$criteria->compare('no_urutperiksa',$this->no_urutperiksa,true);
		$criteria->compare('kunjungan',$this->kunjungan,true);
		$criteria->compare('statusperiksa',$this->statusperiksa,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasienmasukpenunjang_id',$this->pasienmasukpenunjang_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('namaperujuk',$this->namaperujuk,true);
		$criteria->compare('alamatlengkapperujuk',$this->alamatlengkapperujuk,true);
		$criteria->compare('notelpperujuk',$this->notelpperujuk,true);
		$criteria->compare('rujukandari_id',$this->rujukandari_id);
		$criteria->compare('tglbatal',$this->tglbatal,true);
		$criteria->compare('keterangan_batal',$this->keterangan_batal,true);
		$criteria->compare('pasienbatalperiksa_id',$this->pasienbatalperiksa_id);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('ispasienluar',$this->ispasienluar);
		$criteria->compare('nama_ibu',$this->nama_ibu,true);
		$criteria->compare('nama_ayah',$this->nama_ayah,true);
		$criteria->compare('warga_negara',$this->warga_negara,true);
		$criteria->compare('rhesus',$this->rhesus,true);
		$criteria->compare('panggilantrian',$this->panggilantrian);
		$criteria->compare('ruangan_singkatan',$this->ruangan_singkatan,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('tglcetakkartuasuransi',$this->tglcetakkartuasuransi,true);
		$criteria->compare('kodefeskestk1',$this->kodefeskestk1,true);
		$criteria->compare('nama_feskestk1',$this->nama_feskestk1,true);
		$criteria->compare('masaberlakukartu',$this->masaberlakukartu,true);
		$criteria->compare('nokartukeluarga',$this->nokartukeluarga,true);
		$criteria->compare('nopassport',$this->nopassport,true);
		$criteria->compare('status_konfirmasi',$this->status_konfirmasi,true);
		$criteria->compare('tgl_konfirmasi',$this->tgl_konfirmasi,true);
		$criteria->compare('asuransipasien_aktif',$this->asuransipasien_aktif);
		$criteria->compare('keterangan_pendaftaran',$this->keterangan_pendaftaran,true);
		$criteria->compare('jml_panggil',$this->jml_panggil);
		$criteria->compare('waktumulaiperiksa',$this->waktumulaiperiksa,true);
		$criteria->compare('pasienkirimkeunitlain_id',$this->pasienkirimkeunitlain_id);
		$criteria->compare('tgladmisi',$this->tgladmisi,true);
		$criteria->compare('dokterasal_id',$this->dokterasal_id);
		$criteria->compare('catatandokterpengirim',$this->catatandokterpengirim,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasikasirrehabmedisV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

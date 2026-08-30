<?php

/**
 * This is the model class for table "infokunjunganpersalinan_v".
 *
 * The followings are the available columns in table 'infokunjunganpersalinan_v':
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
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $statusperkawinan
 * @property string $nama_ibu
 * @property string $nama_ayah
 * @property boolean $ispasienluar
 * @property string $tgl_meninggal
 * @property string $statusrekammedis
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
 * @property integer $carakeluar_id
 * @property string $carakeluar_nama
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
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $ruangan_singkatan
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
 */
class InfokunjunganpersalinanV extends CActiveRecord
{
        public $kamarruangan_id;
        public $tgladmisi, $rhesus;
        public $tgl_awal, $tgl_akhir;
        public $rujukandari_id;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganpersalinanV the static model class
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
		return 'infokunjunganpersalinan_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, anakke, jumlah_bersaudara, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pendaftaran_id, pekerjaan_id, carabayar_id, penjamin_id, caramasuk_id, carakeluar_id, shift_id, golonganumur_id, asalrujukan_id, penanggungjawab_id, instalasi_id, ruangan_id, jeniskasuspenyakit_id, kelaspelayanan_id, pegawai_id, pembayaranpelayanan_id, antrian_id, loket_id, loket_nourut, loket_maksantrian', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, agama, no_mobile_pasien, statusperkawinan, no_pendaftaran', 'length', 'max'=>20),
			array('no_identitas_pasien, nama_bin, umur', 'length', 'max'=>30),
			array('nama_pasien, nama_ibu, nama_ayah, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_nama, penjamin_nama, caramasuk_nama, carakeluar_nama, nama_perujuk, asalrujukan_nama, pengantar, hubungankeluarga, nama_pj, instalasi_nama, ruangan_nama, kelaspelayanan_nama, nama_pegawai, status_konfirmasi, loket_nama', 'length', 'max'=>50),
			array('tempat_lahir, warga_negara, golonganumur_nama', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail, jeniskasuspenyakit_nama', 'length', 'max'=>100),
			array('no_telepon_pasien, gelarbelakang_nama', 'length', 'max'=>15),
			array('statusrekammedis, no_rekam_medik, no_rujukan, gelardepan', 'length', 'max'=>10),
			array('no_urutantri, noantrian', 'length', 'max'=>6),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('loket_singkatan', 'length', 'max'=>1),
			array('loket_formatnomor', 'length', 'max'=>5),
			array('tanggal_lahir, alamat_pasien, ispasienluar, tgl_meninggal, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, create_time, create_loginpemakai_id, create_ruangan, tanggal_rujukan, diagnosa_rujukan, tgl_konfirmasi, tglrenkontrol, panggilantrian, tglantrian, panggil_flaq, loket_fungsi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, anakke, jumlah_bersaudara, no_telepon_pasien, no_mobile_pasien, warga_negara, statusperkawinan, nama_ibu, nama_ayah, ispasienluar, tgl_meninggal, statusrekammedis, no_rekam_medik, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, create_time, create_loginpemakai_id, create_ruangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, caramasuk_id, caramasuk_nama, carakeluar_id, carakeluar_nama, shift_id, golonganumur_id, golonganumur_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, ruangan_singkatan, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, gelardepan, nama_pegawai, gelarbelakang_nama, status_konfirmasi, tgl_konfirmasi, pegawai_id, tglrenkontrol, pembayaranpelayanan_id, panggilantrian, antrian_id, tglantrian, noantrian, panggil_flaq, loket_id, loket_nama, loket_fungsi, loket_singkatan, loket_nourut, loket_formatnomor, loket_maksantrian', 'safe', 'on'=>'search'),
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
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'anakke' => 'Anakke',
			'jumlah_bersaudara' => 'Jumlah Bersaudara',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'warga_negara' => 'Warga Negara',
			'statusperkawinan' => 'Statusperkawinan',
			'nama_ibu' => 'Nama Ibu',
			'nama_ayah' => 'Nama Ayah',
			'ispasienluar' => 'Ispasienluar',
			'tgl_meninggal' => 'Tgl. Meninggal',
			'statusrekammedis' => 'Statusrekammedis',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
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
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tgl. Pendaftaran',
			'no_urutantri' => 'No. Urutantri',
			'transportasi' => 'Transportasi',
			'keadaanmasuk' => 'Keadaanmasuk',
			'statusperiksa' => 'Status Periksa',
			'statuspasien' => 'Statuspasien',
			'kunjungan' => 'Kunjungan',
			'alihstatus' => 'Alihstatus',
			'byphone' => 'Byphone',
			'kunjunganrumah' => 'Kunjunganrumah',
			'statusmasuk' => 'Statusmasuk',
			'umur' => 'Umur',
			'no_asuransi' => 'No. Asuransi',
			'namapemilik_asuransi' => 'Namapemilik Asuransi',
			'nopokokperusahaan' => 'Nopokokperusahaan',
			'create_time' => 'Waktu Create',
			'create_loginpemakai_id' => 'Petugas Loket',
			'create_ruangan' => 'Create Ruangan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'caramasuk_id' => 'Caramasuk',
			'caramasuk_nama' => 'Caramasuk Nama',
			'carakeluar_id' => 'Cara Keluar ID',
			'carakeluar_nama' => 'Cara Keluar',
			'shift_id' => 'Shift',
			'golonganumur_id' => 'Golonganumur',
			'golonganumur_nama' => 'Golonganumur Nama',
			'no_rujukan' => 'No. Rujukan',
			'nama_perujuk' => 'Nama Perujuk',
			'tanggal_rujukan' => 'Tanggal Rujukan',
			'diagnosa_rujukan' => 'Diagnosa Rujukan',
			'asalrujukan_id' => 'Asal Rujukan',
			'asalrujukan_nama' => 'Asal Rujukan',
			'penanggungjawab_id' => 'Penanggungjawab',
			'pengantar' => 'Pengantar',
			'hubungankeluarga' => 'Hubungankeluarga',
			'nama_pj' => 'Nama Pj',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'ruangan_singkatan' => 'Ruangan Singkatan',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan Nama',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Dokter',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'status_konfirmasi' => 'Status Konfirmasi',
			'tgl_konfirmasi' => 'Tgl. Konfirmasi',
			'pegawai_id' => 'Dokter',
			'tglrenkontrol' => 'Tglrenkontrol',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'panggilantrian' => 'Panggilantrian',
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
                        'kamarruangan_id' => 'Kamar Ruangan',
                        'rujukandari_id'=>'Rujukan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
		$criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('rt',$this->rt);
		$criteria->compare('rw',$this->rw);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('anakke',$this->anakke);
		$criteria->compare('jumlah_bersaudara',$this->jumlah_bersaudara);
		$criteria->compare('LOWER(no_telepon_pasien)',strtolower($this->no_telepon_pasien),true);
		$criteria->compare('LOWER(no_mobile_pasien)',strtolower($this->no_mobile_pasien),true);
		$criteria->compare('LOWER(warga_negara)',strtolower($this->warga_negara),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(nama_ibu)',strtolower($this->nama_ibu),true);
		$criteria->compare('LOWER(nama_ayah)',strtolower($this->nama_ayah),true);
		$criteria->compare('ispasienluar',$this->ispasienluar);
		$criteria->compare('LOWER(tgl_meninggal)',strtolower($this->tgl_meninggal),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pekerjaan_id',$this->pekerjaan_id);
		$criteria->compare('LOWER(pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
		$criteria->compare('LOWER(transportasi)',strtolower($this->transportasi),true);
		$criteria->compare('LOWER(keadaanmasuk)',strtolower($this->keadaanmasuk),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
		$criteria->compare('carakeluar_id',$this->carakeluar_id);
		$criteria->compare('LOWER(carakeluar_nama)',strtolower($this->carakeluar_nama),true);
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('golonganumur_id',$this->golonganumur_id);
		$criteria->compare('LOWER(golonganumur_nama)',strtolower($this->golonganumur_nama),true);
		$criteria->compare('LOWER(no_rujukan)',strtolower($this->no_rujukan),true);
		$criteria->compare('LOWER(nama_perujuk)',strtolower($this->nama_perujuk),true);
		$criteria->compare('LOWER(tanggal_rujukan)',strtolower($this->tanggal_rujukan),true);
		$criteria->compare('LOWER(diagnosa_rujukan)',strtolower($this->diagnosa_rujukan),true);
		$criteria->compare('asalrujukan_id',$this->asalrujukan_id);
		$criteria->compare('LOWER(asalrujukan_nama)',strtolower($this->asalrujukan_nama),true);
		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('LOWER(pengantar)',strtolower($this->pengantar),true);
		$criteria->compare('LOWER(hubungankeluarga)',strtolower($this->hubungankeluarga),true);
		$criteria->compare('LOWER(nama_pj)',strtolower($this->nama_pj),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('LOWER(ruangan_singkatan)',strtolower($this->ruangan_singkatan),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		$criteria->compare('LOWER(tgl_konfirmasi)',strtolower($this->tgl_konfirmasi),true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglrenkontrol)',strtolower($this->tglrenkontrol),true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('panggilantrian',$this->panggilantrian);
		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('LOWER(tglantrian)',strtolower($this->tglantrian),true);
		$criteria->compare('LOWER(noantrian)',strtolower($this->noantrian),true);
		$criteria->compare('panggil_flaq',$this->panggil_flaq);
		$criteria->compare('loket_id',$this->loket_id);
		$criteria->compare('LOWER(loket_nama)',strtolower($this->loket_nama),true);
		$criteria->compare('LOWER(loket_fungsi)',strtolower($this->loket_fungsi),true);
		$criteria->compare('LOWER(loket_singkatan)',strtolower($this->loket_singkatan),true);
		$criteria->compare('loket_nourut',$this->loket_nourut);
		$criteria->compare('LOWER(loket_formatnomor)',strtolower($this->loket_formatnomor),true);
		$criteria->compare('loket_maksantrian',$this->loket_maksantrian);

		return $criteria;
	}
        
        
        /**
         * Retrieves a list of models based on the current search/filter conditions.
         * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function search()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }


        public function searchPrint()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            $criteria->limit=-1; 

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>false,
            ));
        }
               
        
         public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE') ;
        }
        
        public function getPenjaminItems()
        {
            return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE');
        }
        
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAll('propinsi_aktif=TRUE ORDER BY propinsi_nama');
        }
        
        public function getNamaNamaBIN()
        { 
            if (!empty($this->nama_bin)) {
                return $this->nama_pasien.' alias '.$this->nama_bin;
            } else {
                return $this->nama_pasien;
            }
            
        }
        
        public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.' / '.$this->penjamin_nama;
        }
        
        public function getAlamatRTRW()
        {
            return $this->alamat_pasien.'<br>'.$this->rt.' / '.$this->rw;
        }
        
        public function getNoRMNoPend(){
            return $this->no_rekam_medik.'<br/>'.$this->no_pendaftaran;
        }
        
        public function getTglMasukNoPenunjang(){
            return $this->tglmasukpenunjang.'<br/>'.PHP_EOL.$this->no_masukpenunjang;
        }
        
        public function getJenisKelaminUmur(){
            return $this->jeniskelamin.'<br/>'.$this->umur;
        }
        public function getInstalasiRuangan(){
            return $this->instalasiasal_nama.'<br/>'.$this->ruanganasal_nama;
        }
        
        public function searchDialogKunjungan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
//                if(!empty($this->tgl_pendaftaran)){
//                    $tgl_pendaftaran = $this->getKonverviDateRange($this->tgl_pendaftaran);
//                    $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0]." 00:00:00", $tgl_pendaftaran[1]." 23:59:59");
////                    $criteria->addBetweenCondition("DATE(tgl_pendaftaran)", MyFormatter::formatDateTimeForDb($this->tgl_pendaftaran), MyFormatter::formatDateTimeForDb($this->tgl_pendaftaran));
//                }
                if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
            $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        }
                
                $criteria->addCondition("ruangan_id = '".$this->ruangan_id."' ");
                $criteria->compare("LOWER(no_pendaftaran)", strtolower($this->no_pendaftaran), TRUE);
                $criteria->compare("LOWER(nama_pasien)", strtolower($this->nama_pasien), TRUE);
                $criteria->compare("LOWER(no_rekam_medik)", strtolower($this->no_rekam_medik), TRUE);
                $criteria->compare("LOWER(statusperiksa)", strtolower($this->statusperiksa), TRUE);
               // $criteria->addBetweenCondition("tgl_pendaftaran::date", MyFormatter::formatDateTimeForDb($this->tgl_pendaftaran).' 00:00:00', MyFormatter::formatDateTimeForDb($this->tgl_pendaftaran).' 23:59:59');
                if (!empty($this->jeniskelamin)){
                    $criteria->addCondition("jeniskelamin = '".$this->jeniskelamin."' ");
                }               
                 if (!empty($this->carabayar_id)){
                    $criteria->addCondition("carabayar_id = '".$this->carabayar_id."' ");
                }    
		 if (!empty($this->penjamin_id)){
                    $criteria->addCondition("penjamin_id = '".$this->penjamin_id."' ");
                }  
		
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    //'pagination'=>false,
            ));
        }
        
        public function getKonverviDateRange($tgl){
            $Tgl = (explode(" - ",$tgl));

            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');
            return array($Tgl[0],$Tgl[1]);
        }
}
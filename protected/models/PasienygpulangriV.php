<?php

/**
 * This is the model class for table "pasienygpulangri_v".
 *
 * The followings are the available columns in table 'pasienygpulangri_v':
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
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
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
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $pasienadmisi_id
 * @property string $tgladmisi
 * @property string $tglpulang
 * @property string $kunjungan
 * @property boolean $statuskeluar
 * @property boolean $rawatgabung
 * @property integer $kamarruangan_id
 * @property string $kamarruangan_nokamar
 * @property string $kamarruangan_nobed
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $masukkamar_id
 * @property string $nomasukkamar
 * @property string $tglmasukkamar
 * @property string $jammasukkamar
 * @property string $tglkeluarkamar
 * @property string $jamkeluarkamar
 * @property integer $lamadirawat_kamar
 * @property integer $pindahkamar_id
 * @property string $tglpasienpulang
 * @property string $carakeluar
 * @property string $kondisipulang
 * @property string $penerimapasien
 * @property integer $lamarawat
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property string $ruanganakhir_id
 * @property strin $keterangan_kamar
 */
class PasienygpulangriV extends CActiveRecord
{
        public $caradanKondisiPulang;
        public $tgl_awal;
        public $tgl_akhir;
        public $prefix_pendaftaran;
//        public $keterangan_kamar;
        public $ceklis=false;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienygpulangriV the static model class
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
		return 'pasienygpulangri_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pendaftaran_id, pekerjaan_id, carabayar_id, penjamin_id, caramasuk_id, shift_id, golonganumur_id, asalrujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, pasienadmisi_id, kamarruangan_id, masukkamar_id, lamadirawat_kamar, pindahkamar_id, lamarawat', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran', 'length', 'max'=>20),
			array('no_identitas_pasien, nama_bin, umur', 'length', 'max'=>30),
			array('nama_pasien, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, transportasi, keadaanmasuk, statusperiksa, statuspasien, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_nama, penjamin_nama, caramasuk_nama, nama_perujuk, asalrujukan_nama, pengantar, hubungankeluarga, nama_pj, ruangan_nama, instalasi_nama, kelaspelayanan_nama, kunjungan, nama_pegawai, nomasukkamar, carakeluar, keterangan_kamar,  kondisipulang', 'length', 'max'=>50),
			array('tempat_lahir, golonganumur_nama', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail, jeniskasuspenyakit_nama, penerimapasien', 'length', 'max'=>100),
			array('statusrekammedis, no_rekam_medik, no_rujukan, kamarruangan_nokamar, kamarruangan_nobed, gelardepan', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('pegawai_id, dokterpenerima_id, tanggal_lahir, alamat_pasien, tgl_rekam_medik, keterangan_kamar, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, tanggal_rujukan, diagnosa_rujukan, tgladmisi, tglpulang, statuskeluar, rawatgabung, tglmasukkamar, jammasukkamar, tglkeluarkamar, jamkeluarkamar, tglpasienpulang, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, ruanganakhir_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, dokterpenerima_id, pasien_id,ceklis,tgl_awal,tgl_akhir, jenisidentitas, keterangan_kamar, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, caramasuk_id, caramasuk_nama, shift_id, golonganumur_id, golonganumur_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, pasienadmisi_id, tgladmisi, tglpulang, kunjungan, statuskeluar, rawatgabung, kamarruangan_id, kamarruangan_nokamar, kamarruangan_nobed, gelardepan, nama_pegawai, gelarbelakang_nama, masukkamar_id, nomasukkamar, tglmasukkamar, jammasukkamar, tglkeluarkamar, jamkeluarkamar, lamadirawat_kamar, pindahkamar_id, tglpasienpulang, carakeluar, kondisipulang, penerimapasien, lamarawat, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, ruanganakhir_id', 'safe', 'on'=>'search'),
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
			'statusrekammedis' => 'Statusrekammedis',
			'statusperkawinan' => 'Statusperkawinan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
			'propinsi_id' => 'Provinsi',
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
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'no_urutantri' => 'No. Urutantri',
			'transportasi' => 'Transportasi',
			'keadaanmasuk' => 'Keadaanmasuk',
			'statusperiksa' => 'Statusperiksa',
			'statuspasien' => 'Statuspasien',
			'alihstatus' => 'Alihstatus',
			'byphone' => 'Byphone',
			'kunjunganrumah' => 'Kunjunganrumah',
			'statusmasuk' => 'Statusmasuk',
			'umur' => 'Umur',
			'no_asuransi' => 'No. Asuransi',
			'namapemilik_asuransi' => 'Namapemilik Asuransi',
			'nopokokperusahaan' => 'Nopokokperusahaan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Cara bayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'caramasuk_id' => 'Caramasuk',
			'caramasuk_nama' => 'Caramasuk Nama',
			'shift_id' => 'Shift',
			'golonganumur_id' => 'Golonganumur',
			'golonganumur_nama' => 'Golonganumur Nama',
			'no_rujukan' => 'No. Rujukan',
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
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tgladmisi' => 'Tgladmisi',
			'tglpulang' => 'Tglpulang',
			'kunjungan' => 'Kunjungan',
			'statuskeluar' => 'Statuskeluar',
			'rawatgabung' => 'Rawatgabung',
			'kamarruangan_id' => 'Kamarruangan',
			'kamarruangan_nokamar' => 'Kamarruangan Nokamar',
			'kamarruangan_nobed' => 'Kamarruangan Nobed',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'masukkamar_id' => 'Masukkamar',
			'nomasukkamar' => 'Nomasukkamar',
			'tglmasukkamar' => 'Tglmasukkamar',
			'jammasukkamar' => 'Jammasukkamar',
			'tglkeluarkamar' => 'Tglkeluarkamar',
			'jamkeluarkamar' => 'Jamkeluarkamar',
			'lamadirawat_kamar' => 'Lamadirawat Kamar',
			'pindahkamar_id' => 'Pindahkamar',
			'tglpasienpulang' => 'Tglpasienpulang',
			'carakeluar' => 'Carakeluar',
			'kondisipulang' => 'Kondisipulang',
			'penerimapasien' => 'Penerimapasien',
			'lamarawat' => 'Lamarawat',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'ruanganakhir_id' => 'Ruanganakhir',
            'keterangan_kamar'=>'Status Kamar',
            'pegawai_id'=>'Dokter PJP',
            'dokterpenerima_id'=>'Dokter Penerima',
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
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
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
		$criteria->compare('LOWER(keterangan_kamar)',strtolower($this->keterangan_kamar),true);
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
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
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('statuskeluar',$this->statuskeluar);
		$criteria->compare('rawatgabung',$this->rawatgabung);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('masukkamar_id',$this->masukkamar_id);
		$criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
		$criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
		$criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
		$criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
		$criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);
		$criteria->compare('lamadirawat_kamar',$this->lamadirawat_kamar);
		$criteria->compare('pindahkamar_id',$this->pindahkamar_id);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(ruanganakhir_id)',strtolower($this->ruanganakhir_id),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
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
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
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
		$criteria->compare('LOWER(keterangan_kamar)',strtolower($this->keterangan_kamar),true);
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
		$criteria->compare('alihstatus',$this->alihstatus);
		$criteria->compare('byphone',$this->byphone);
		$criteria->compare('kunjunganrumah',$this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(umur)',strtolower($this->umur),true);
		$criteria->compare('LOWER(no_asuransi)',strtolower($this->no_asuransi),true);
		$criteria->compare('LOWER(namapemilik_asuransi)',strtolower($this->namapemilik_asuransi),true);
		$criteria->compare('LOWER(nopokokperusahaan)',strtolower($this->nopokokperusahaan),true);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('caramasuk_id',$this->caramasuk_id);
		$criteria->compare('LOWER(caramasuk_nama)',strtolower($this->caramasuk_nama),true);
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
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(tgladmisi)',strtolower($this->tgladmisi),true);
		$criteria->compare('LOWER(tglpulang)',strtolower($this->tglpulang),true);
		$criteria->compare('LOWER(kunjungan)',strtolower($this->kunjungan),true);
		$criteria->compare('statuskeluar',$this->statuskeluar);
		$criteria->compare('rawatgabung',$this->rawatgabung);
		$criteria->compare('kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('LOWER(kamarruangan_nokamar)',strtolower($this->kamarruangan_nokamar),true);
		$criteria->compare('LOWER(kamarruangan_nobed)',strtolower($this->kamarruangan_nobed),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('masukkamar_id',$this->masukkamar_id);
		$criteria->compare('LOWER(nomasukkamar)',strtolower($this->nomasukkamar),true);
		$criteria->compare('LOWER(tglmasukkamar)',strtolower($this->tglmasukkamar),true);
		$criteria->compare('LOWER(jammasukkamar)',strtolower($this->jammasukkamar),true);
		$criteria->compare('LOWER(tglkeluarkamar)',strtolower($this->tglkeluarkamar),true);
		$criteria->compare('LOWER(jamkeluarkamar)',strtolower($this->jamkeluarkamar),true);
		$criteria->compare('lamadirawat_kamar',$this->lamadirawat_kamar);
		$criteria->compare('pindahkamar_id',$this->pindahkamar_id);
		$criteria->compare('LOWER(tglpasienpulang)',strtolower($this->tglpasienpulang),true);
		$criteria->compare('LOWER(carakeluar)',strtolower($this->carakeluar),true);
		$criteria->compare('LOWER(kondisipulang)',strtolower($this->kondisipulang),true);
		$criteria->compare('LOWER(penerimapasien)',strtolower($this->penerimapasien),true);
		$criteria->compare('lamarawat',$this->lamarawat);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(ruanganakhir_id)',strtolower($this->ruanganakhir_id),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
        
         public function getCaradanKondisiPulang()
        {
                return $this->carakeluar.' / '.$this->kondisipulang;
        }
        
         public function getNoRMdanNoPendaftaran()
        {
                return $this->no_rekam_medik.' / '.$this->no_pendaftaran;
        }
        
        public function getCaraBayardanPenjamin()
        {
                return $this->carabayar_nama.' / '.$this->penjamin_nama;
        }
        
        public function getKelasPelayanandanNoMasukKamar()
        {
                return $this->kelaspelayanan_nama.' / '.$this->nomasukkamar;
        }
        
        public function getNamadanNamaBIN()
        {
                return $this->nama_pasien.' / '.$this->nama_bin;
        }
        
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE') ;
        }
        
        public function getPenjaminItems()
        {
            return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE');
        }
        
        public function getCaraKeluarItems()
        {
            return CarakeluarM::model()->findAll("carakeluar_aktif = TRUE ORDER BY carakeluar_nama ASC");
        }
        
       
}
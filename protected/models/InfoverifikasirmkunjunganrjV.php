<?php

/**
 * This is the model class for table "infoverifikasirmkunjunganrj_v".
 *
 * The followings are the available columns in table 'infoverifikasirmkunjunganrj_v':
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
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $nama_ibu
 * @property string $nama_ayah
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
 * @property string $kodedokter_bpjs
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
 * @property string $jenis_kunjungan
 * @property string $waktupanggilpasien
 * @property integer $jml_panggil
 * @property string $waktuverifikasipasien
 * @property string $nosep
 * @property integer $suku_id
 * @property string $suku_nama
 * @property integer $pendidikan_id
 * @property string $pendidikan_nama
 * @property string $diagnosamasuk
 * @property string $keluhan
 * @property string $tekanandarah
 * @property double $tinggibadan_cm
 * @property double $beratbadan_kg
 * @property string $tglselesaiperiksa
 * @property string $asalrujukan
 * @property string $alamatrujukan
 * @property string $diagnosa
 * @property boolean $is_anamnesa
 * @property boolean $is_periksafisik
 * @property boolean $is_diagnosa
 * @property boolean $is_tindakan
 * @property string $carakeluar_nama
 * @property boolean $is_verifikasidiagnosa
 */
class InfoverifikasirmkunjunganrjV extends CActiveRecord
{
	public $tgl_awal, 
			$tgl_akhir,
			$tgl_awall, 
			$tgl_akhirl, 
			$ceklis, 
			$adaKarcis,
			$status_resume;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'infoverifikasirmkunjunganrj_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pendaftaran_id, pekerjaan_id, carabayar_id, penjamin_id, caramasuk_id, shift_id, golonganumur_id, asalrujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, pegawai_id, pembayaranpelayanan_id, antrian_id, loket_id, loket_nourut, loket_maksantrian, pengirimanrm_id, kelompokpegawai_id, pasienpulang_id, carakeluar_id, sep_id, jml_panggil, suku_id, pendidikan_id', 'numerical', 'integerOnly'=>true),
			array('tinggibadan_cm, beratbadan_kg', 'numerical'),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_mobile_pasien, no_pendaftaran, no_rujukan, tekanandarah', 'length', 'max'=>20),
			array('no_identitas_pasien, umur', 'length', 'max'=>30),
			array('nama_pasien, alamatemail, penjamin_nama, ruangan_nama, instalasi_nama, jeniskasuspenyakit_nama, nokartukeluarga, nosep, carakeluar_nama', 'length', 'max'=>100),
			array('nama_bin, nama_ibu, nama_ayah, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_nama, caramasuk_nama, nama_perujuk, asalrujukan_nama, pengantar, hubungankeluarga, nama_pj, kelaspelayanan_nama, nama_pegawai, kodedokter_bpjs, status_konfirmasi, loket_nama, nopeserta, kodefeskestk1, statusdokrm, jenis_kunjungan, suku_nama, pendidikan_nama', 'length', 'max'=>50),
			array('tempat_lahir, warga_negara, golonganumur_nama', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien, nama_feskestk1, nopassport, keterangan_pendaftaran', 'length', 'max'=>200),
			array('statusrekammedis, no_rekam_medik, gelardepan, loket_singkatan', 'length', 'max'=>10),
			array('no_urutantri, noantrian', 'length', 'max'=>6),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('loket_formatnomor', 'length', 'max'=>5),
			array('diagnosamasuk, keluhan', 'length', 'max'=>255),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, create_time, create_loginpemakai_id, create_ruangan, tanggal_rujukan, diagnosa_rujukan, tgl_konfirmasi, tglrenkontrol, panggilantrian, tglakandilayani, tglantrian, panggil_flaq, loket_fungsi, tglcetakkartuasuransi, masaberlakukartu, asuransipasien_aktif, waktupanggilpasien, waktuverifikasipasien, tglselesaiperiksa, asalrujukan, alamatrujukan, diagnosa, is_anamnesa, is_periksafisik, is_diagnosa, is_tindakan, is_verifikasidiagnosa', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, no_mobile_pasien, warga_negara, nama_ibu, nama_ayah, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, create_time, create_loginpemakai_id, create_ruangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, caramasuk_id, caramasuk_nama, shift_id, golonganumur_id, golonganumur_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, ruangan_id, ruangan_nama, ruangan_singkatan, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, gelardepan, nama_pegawai, gelarbelakang_nama, kodedokter_bpjs, status_konfirmasi, tgl_konfirmasi, pegawai_id, tglrenkontrol, pembayaranpelayanan_id, panggilantrian, tglakandilayani, antrian_id, tglantrian, noantrian, panggil_flaq, loket_id, loket_nama, loket_fungsi, loket_singkatan, loket_nourut, loket_formatnomor, loket_maksantrian, nopeserta, tglcetakkartuasuransi, kodefeskestk1, nama_feskestk1, masaberlakukartu, nokartukeluarga, nopassport, asuransipasien_aktif, keterangan_pendaftaran, pengirimanrm_id, statusdokrm, kelompokpegawai_id, pasienpulang_id, carakeluar_id, sep_id, jenis_kunjungan, waktupanggilpasien, jml_panggil, waktuverifikasipasien, nosep, suku_id, suku_nama, pendidikan_id, pendidikan_nama, diagnosamasuk, keluhan, tekanandarah, tinggibadan_cm, beratbadan_kg, tglselesaiperiksa, asalrujukan, alamatrujukan, diagnosa, is_anamnesa, is_periksafisik, is_diagnosa, is_tindakan, carakeluar_nama, is_verifikasidiagnosa', 'safe', 'on'=>'search'),
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
			'no_mobile_pasien' => 'No Mobile Pasien',
			'warga_negara' => 'Warga Negara',
			'nama_ibu' => 'Nama Ibu',
			'nama_ayah' => 'Nama Ayah',
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
			'kodedokter_bpjs' => 'Kodedokter Bpjs',
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
			'carakeluar_id' => 'Cara Keluar',
			'kondisikeluar_id' => 'Kondisi Keluar',
			'sep_id' => 'Sep',
			'jenis_kunjungan' => 'Jenis Kunjungan',
			'waktupanggilpasien' => 'Waktupanggilpasien',
			'jml_panggil' => 'Jml Panggil',
			'waktuverifikasipasien' => 'Waktuverifikasipasien',
			'nosep' => 'Nosep',
			'suku_id' => 'Suku',
			'suku_nama' => 'Suku Nama',
			'pendidikan_id' => 'Pendidikan',
			'pendidikan_nama' => 'Pendidikan Nama',
			'diagnosamasuk' => 'Diagnosamasuk',
			'keluhan' => 'Keluhan',
			'tekanandarah' => 'Tekanandarah',
			'tinggibadan_cm' => 'Tinggibadan Cm',
			'beratbadan_kg' => 'Beratbadan Kg',
			'tglselesaiperiksa' => 'Tglselesaiperiksa',
			'asalrujukan' => 'Asalrujukan',
			'alamatrujukan' => 'Alamatrujukan',
			'diagnosa' => 'Diagnosa',
			'is_anamnesa' => 'Is Anamnesa',
			'is_periksafisik' => 'Is Periksafisik',
			'is_diagnosa' => 'Is Diagnosa',
			'is_tindakan' => 'Is Tindakan',
			'carakeluar_nama' => 'Carakeluar Nama',
			'is_verifikasidiagnosa' => 'Is Verifikasidiagnosa',
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
	public function searchRJ()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		
		
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id);			
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("t.kelurahan_id = ".$this->kelurahan_id);			
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		
	
		
		$criteria->compare('LOWER(t.status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		
		
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);			
		}
		$criteria->compare('LOWER(t.nama_pegawai)',($this->nama_pegawai));
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);

		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
		
		if(!empty($this->propinsi_id)){
			if (is_array($this->propinsi_id)){
				$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
			}else{
				$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
			}
		}	

		if(!empty($this->kabupaten_id)){
			if (is_array($this->kabupaten_id)){
				$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
			}else{
				$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
			}
		}

		if (!empty($this->ruangan_id)){
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
			}else{
				$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
			}
		}

		if (!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
			}else{
				$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
			}
		}

		if (!empty($this->carabayar_id)){
			if (is_array($this->carabayar_id)){
				$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
			}else{
				$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
			}
		}

		if (!empty($this->penjamin_id)){
			if (is_array($this->penjamin_id)){
				$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
			}else{
				$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
			}
		}
		
		$criteria->order = 't.tgl_pendaftaran DESC';

		if(!empty($this->carakeluar_id)) {
			$criteria->addCondition('carakeluar_id='.$this->carakeluar_id);
		}
		if(!empty($this->kondisikeluar_id)) {
			$criteria->addCondition('kondisikeluar_id='.$this->kondisikeluar_id);
		}
		if(!empty($this->pegawai_id)) {
			$criteria->addCondition('pegawai_id='.$this->pegawai_id);
		}
		if($this->is_verifikasidiagnosa != '') {
			if($this->is_verifikasidiagnosa == true) {
				$criteria->addCondition("is_verifikasidiagnosa is true");
			} else if($this->is_verifikasidiagnosa == false){
				$criteria->addCondition("is_verifikasidiagnosa is false");
			}
		}

		
		$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		if ($this->ceklis) {
			$criteria->addBetweenCondition('DATE(tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InfoverifikasirmkunjunganrjV the static model class
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

	public function searchInformasiRJ()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(t.statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(t.statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('LOWER(t.no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		
		
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("t.kecamatan_id = ".$this->kecamatan_id);			
		}
		$criteria->compare('LOWER(t.kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("t.kelurahan_id = ".$this->kelurahan_id);			
		}
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		
	
		
		$criteria->compare('LOWER(t.status_konfirmasi)',strtolower($this->status_konfirmasi),true);
		
		
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);			
		}
		$criteria->compare('LOWER(t.nama_pegawai)',($this->nama_pegawai));
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.pekerjaan_nama)',strtolower($this->pekerjaan_nama),true);

		$criteria->compare('LOWER(t.jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		$criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
		
		if(!empty($this->propinsi_id)){
			if (is_array($this->propinsi_id)){
				$criteria->addInCondition("t.propinsi_id",$this->propinsi_id); 			
			}else{
				$criteria->addCondition("t.propinsi_id = ".$this->propinsi_id); 			
			}
		}	

		if(!empty($this->kabupaten_id)){
			if (is_array($this->kabupaten_id)){
				$criteria->addInCondition("t.kabupaten_id",$this->kabupaten_id); 			
			}else{
				$criteria->addCondition("t.kabupaten_id = ".$this->kabupaten_id); 			
			}
		}

		if (!empty($this->ruangan_id)){
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition("t.ruangan_id", $this->ruangan_id);
			}else{
				$criteria->addCondition("t.ruangan_id =".$this->ruangan_id);
			}
		}

		if (!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition("t.instalasi_id", $this->instalasi_id);
			}else{
				$criteria->addCondition("t.instalasi_id =".$this->instalasi_id);
			}
		}

		if (!empty($this->carabayar_id)){
			if (is_array($this->carabayar_id)){
				$criteria->addInCondition("t.carabayar_id", $this->carabayar_id);
			}else{
				$criteria->addCondition("t.carabayar_id =".$this->carabayar_id);
			}
		}

		if (!empty($this->penjamin_id)){
			if (is_array($this->penjamin_id)){
				$criteria->addInCondition("t.penjamin_id", $this->penjamin_id);
			}else{
				$criteria->addCondition("t.penjamin_id =".$this->penjamin_id);
			}
		}
		
		$criteria->order = 't.tgl_pendaftaran DESC';

		if(!empty($this->carakeluar_id)) {
			$criteria->addCondition('carakeluar_id='.$this->carakeluar_id);
		}
		if(!empty($this->kondisikeluar_id)) {
			$criteria->addCondition('kondisikeluar_id='.$this->kondisikeluar_id);
		}
		if(!empty($this->pegawai_id)) {
			$criteria->addCondition('pegawai_id='.$this->pegawai_id);
		}
		if($this->is_verifikasidiagnosa != '') {
			if($this->is_verifikasidiagnosa == true) {
				$criteria->addCondition("is_verifikasidiagnosa is true");
			} else if($this->is_verifikasidiagnosa == false){
				$criteria->addCondition("is_verifikasidiagnosa is false");
			}
		}

		
		$criteria->addBetweenCondition('date(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		if ($this->ceklis) {
			$criteria->addBetweenCondition('DATE(tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

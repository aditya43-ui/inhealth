<?php

/**
 * This is the model class for table "infokunjunganriglobal_v".
 *
 * The followings are the available columns in table 'infokunjunganriglobal_v':
 * @property string $tgladmisi
 * @property string $no_rekam_medik
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $alamat_pasien
 * @property string $kelurahan_nama
 * @property string $kecamatan_nama
 * @property string $kabupaten_nama
 * @property string $propinsi_nama
 * @property string $no_mobile_pasien
 * @property string $suku_nama
 * @property string $statusperkawinan
 * @property string $warga_negara
 * @property string $agama
 * @property string $pendidikan_nama
 * @property string $pekerjaan_nama
 * @property string $no_identitas_pasien
 * @property string $tanggal_lahir
 * @property string $umur_tahun
 * @property string $umur_bulan
 * @property string $umur_hari
 * @property string $golonganumur_nama
 * @property string $kelompokumur_nama
 * @property string $nama_ayah
 * @property string $nama_ibu
 * @property string $sistem
 * @property string $kunjungan
 * @property string $no_pendaftaran
 * @property string $nama_pegawailoket
 * @property string $carabayar_nama
 * @property string $penjamin_nama
 * @property string $ruangan_nama
 * @property string $kelaspelayanan_nama
 * @property string $kelastanggungan_nama
 * @property string $caramasuk_nama
 * @property string $diagnosamasuk
 * @property string $keluhan
 * @property string $icd_masuk
 * @property string $diagnosa_masuk
 * @property string $riwayatimunisasi
 * @property string $tekanandarah
 * @property string $golongandarah
 * @property double $tinggibadan_cm
 * @property double $beratbadan_kg
 * @property string $nama_pegawaiverif
 * @property string $icd_utama
 * @property string $diagnosa_utama
 * @property string $dtd_nama
 * @property string $icd_komplikasi
 * @property string $icd_tindakanutama
 * @property string $tindakanutama
 * @property string $icd_tindakanlain
 * @property string $tindakanlain
 * @property string $kodedokter
 * @property string $nama_pegawai
 * @property string $spesialissubspesialis_nama
 * @property string $kasus
 * @property string $icd_utama_dpjp
 * @property string $diagnosa_utama_dpjp
 * @property string $dtd_dpjp_nama
 * @property string $icd_komplikasi_dpjp
 * @property string $petugasrawatinap
 * @property string $kodespesialis
 * @property string $lamarawat
 * @property string $carakeluar_nama
 * @property string $tglpulang
 * @property string $asalrujukan_nama
 * @property string $tanggal_rujukan
 * @property string $no_rujukan
 * @property string $alamatrujukan
 * @property string $tgldiet
 * @property string $tgloperasi
 * @property string $jenisoperasi
 * @property boolean $tirahbaring
 * @property boolean $pulangmati
 * @property string $tglmati
 * @property string $icdmati
 * @property string $sebabmati
 * @property string $create_time
 * @property string $ktp
 * @property string $kodeicd
 * @property string $kepalalist
 * @property string $formcairan
 * @property string $diagnosatindakan
 * @property string $namadokteroperasi
 * @property string $tandatangandokter
 * @property string $namapasien
 * @property string $tandatanganpasien
 * @property string $namasaksi1
 * @property string $tandatangansaksi1
 * @property string $namasaksi2
 * @property string $tandatangansaksi2
 * @property string $dischargesum
 * @property string $formoperasi
 * @property string $formanastesi
 * @property string $formtransfusi
 * @property string $formkematian
 * @property string $formaskep
 * @property string $generalconsent
 * @property string $formic
 * @property string $f1_a
 * @property string $f2_a
 * @property string $f2_b
 * @property string $f3_a
 * @property string $f3_b
 * @property string $f5_a_operasi
 * @property string $f5_b_operasi
 * @property string $f5_c_operasi
 * @property string $f5_d_operasi
 * @property string $f5_e_operasi
 * @property string $f5_f_operasi
 * @property string $f5_g_operasi
 * @property string $f5_h_operasi
 * @property string $f5_a_anastesi
 * @property string $f5_b_anastesi
 * @property string $f5_c_anastesi
 * @property string $f5_a_kemoterapi
 * @property string $f5_b_kemoterapi
 * @property string $f5_a_transfusi
 * @property string $f5_b_transfusi
 * @property string $f5_c_transfusi
 * @property string $f6_a_cppt
 * @property string $f6_b_cppt
 * @property string $f6_c_cppt
 * @property string $f6_d_cppt
 * @property string $f8_a_ringkasan
 * @property string $f8_b_ringkasan
 * @property string $f8_c_ringkasan
 * @property string $f8_a_kematian
 * @property string $f8_b_kematian
 * @property string $casemix_a
 * @property string $casemix_b
 * @property string $f5_i_operasi
 * @property string $f5_c_kemoterapi
 * @property string $f8_d_ringkasan
 * @property string $f8_e_ringkasan
 * @property string $kelengkapanautopsi
 * @property string $tgllengkap
 * @property string $ketsebabkematian
 * @property string $tglverifikasikelengkapan
 */
class InfokunjunganriglobalV extends CActiveRecord
{
	public $instalasi_id, $carabayar_id, $penjamin_id, $nama_perujuk;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'infokunjunganriglobal_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tinggibadan_cm, beratbadan_kg', 'numerical'),
			array('no_rekam_medik, icd_masuk, icd_utama, dtd_nama, icd_utama_dpjp, dtd_dpjp_nama', 'length', 'max'=>10),
			array('nama_pasien, penjamin_nama, ruangan_nama, kasus, carakeluar_nama', 'length', 'max'=>100),
			array('jeniskelamin, no_mobile_pasien, statusperkawinan, agama, no_pendaftaran, tekanandarah, no_rujukan', 'length', 'max'=>20),
			array('kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, suku_nama, pendidikan_nama, pekerjaan_nama, nama_ayah, nama_ibu, kunjungan, nama_pegawailoket, carabayar_nama, kelaspelayanan_nama, kelastanggungan_nama, caramasuk_nama, nama_pegawaiverif, kodedokter, nama_pegawai, petugasrawatinap, asalrujukan_nama', 'length', 'max'=>50),
			array('warga_negara, golonganumur_nama, kelompokumur_nama', 'length', 'max'=>25),
			array('no_identitas_pasien', 'length', 'max'=>30),
			array('diagnosamasuk, keluhan, ktp, kodeicd, kepalalist, formcairan, diagnosatindakan, namadokteroperasi, tandatangandokter, namapasien, tandatanganpasien, namasaksi1, tandatangansaksi1, namasaksi2, tandatangansaksi2, dischargesum, formoperasi, formanastesi, formtransfusi, formkematian, formaskep, generalconsent, formic, f1_a, f2_a, f2_b, f3_a, f3_b, f5_a_operasi, f5_b_operasi, f5_c_operasi, f5_d_operasi, f5_e_operasi, f5_f_operasi, f5_g_operasi, f5_h_operasi, f5_a_anastesi, f5_b_anastesi, f5_c_anastesi, f5_a_kemoterapi, f5_b_kemoterapi, f5_a_transfusi, f5_b_transfusi, f5_c_transfusi, f6_a_cppt, f6_b_cppt, f6_c_cppt, f6_d_cppt, f8_a_ringkasan, f8_b_ringkasan, f8_c_ringkasan, f8_a_kematian, f8_b_kematian, casemix_a, casemix_b, f5_i_operasi, f5_c_kemoterapi, f8_d_ringkasan, f8_e_ringkasan', 'length', 'max'=>255),
			array('diagnosa_masuk, diagnosa_utama, spesialissubspesialis_nama, diagnosa_utama_dpjp', 'length', 'max'=>200),
			array('golongandarah', 'length', 'max'=>2),
			array('tgladmisi, alamat_pasien, tanggal_lahir, umur_tahun, umur_bulan, umur_hari, sistem, riwayatimunisasi, icd_komplikasi, icd_tindakanutama, tindakanutama, icd_tindakanlain, tindakanlain, icd_komplikasi_dpjp, kodespesialis, lamarawat, tglpulang, tanggal_rujukan, alamatrujukan, tgldiet, tgloperasi, jenisoperasi, tirahbaring, pulangmati, tglmati, icdmati, sebabmati, create_time, kelengkapanautopsi, tgllengkap, ketsebabkematian, tglverifikasikelengkapan', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tgladmisi, no_rekam_medik, nama_pasien, jeniskelamin, alamat_pasien, kelurahan_nama, kecamatan_nama, kabupaten_nama, propinsi_nama, no_mobile_pasien, suku_nama, statusperkawinan, warga_negara, agama, pendidikan_nama, pekerjaan_nama, no_identitas_pasien, tanggal_lahir, umur_tahun, umur_bulan, umur_hari, golonganumur_nama, kelompokumur_nama, nama_ayah, nama_ibu, sistem, kunjungan, no_pendaftaran, nama_pegawailoket, carabayar_nama, penjamin_nama, ruangan_nama, kelaspelayanan_nama, kelastanggungan_nama, caramasuk_nama, diagnosamasuk, keluhan, icd_masuk, diagnosa_masuk, riwayatimunisasi, tekanandarah, golongandarah, tinggibadan_cm, beratbadan_kg, nama_pegawaiverif, icd_utama, diagnosa_utama, dtd_nama, icd_komplikasi, icd_tindakanutama, tindakanutama, icd_tindakanlain, tindakanlain, kodedokter, nama_pegawai, spesialissubspesialis_nama, kasus, icd_utama_dpjp, diagnosa_utama_dpjp, dtd_dpjp_nama, icd_komplikasi_dpjp, petugasrawatinap, kodespesialis, lamarawat, carakeluar_nama, tglpulang, asalrujukan_nama, tanggal_rujukan, no_rujukan, alamatrujukan, tgldiet, tgloperasi, jenisoperasi, tirahbaring, pulangmati, tglmati, icdmati, sebabmati, create_time, ktp, kodeicd, kepalalist, formcairan, diagnosatindakan, namadokteroperasi, tandatangandokter, namapasien, tandatanganpasien, namasaksi1, tandatangansaksi1, namasaksi2, tandatangansaksi2, dischargesum, formoperasi, formanastesi, formtransfusi, formkematian, formaskep, generalconsent, formic, f1_a, f2_a, f2_b, f3_a, f3_b, f5_a_operasi, f5_b_operasi, f5_c_operasi, f5_d_operasi, f5_e_operasi, f5_f_operasi, f5_g_operasi, f5_h_operasi, f5_a_anastesi, f5_b_anastesi, f5_c_anastesi, f5_a_kemoterapi, f5_b_kemoterapi, f5_a_transfusi, f5_b_transfusi, f5_c_transfusi, f6_a_cppt, f6_b_cppt, f6_c_cppt, f6_d_cppt, f8_a_ringkasan, f8_b_ringkasan, f8_c_ringkasan, f8_a_kematian, f8_b_kematian, casemix_a, casemix_b, f5_i_operasi, f5_c_kemoterapi, f8_d_ringkasan, f8_e_ringkasan, kelengkapanautopsi, tgllengkap, ketsebabkematian, tglverifikasikelengkapan', 'safe', 'on'=>'search'),
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
			'tgladmisi' => 'Tgladmisi',
			'no_rekam_medik' => 'No Rekam Medik',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jeniskelamin',
			'alamat_pasien' => 'Alamat Pasien',
			'kelurahan_nama' => 'Kelurahan',
			'kecamatan_nama' => 'Kecamatan',
			'kabupaten_nama' => 'Kota/Kabupaten',
			'propinsi_nama' => 'Povinsi',
			'no_mobile_pasien' => 'No. Handphone',
			'suku_nama' => 'Suku',
			'statusperkawinan' => 'Status Perkawinan',

			'warga_negara' => 'Warga Negara',
			'agama' => 'Agama',
			'pendidikan_nama' => 'Pendidikan',
			'pekerjaan_nama' => 'Pekerjaan',
			'no_identitas_pasien' => 'NIK',
			'tanggal_lahir' => 'Tgl. Lahir',
			'umur_tahun' => 'Umur Tahun',
			'umur_bulan' => 'Umur Bulan',
			'umur_hari' => 'Umur Hari',
			'golonganumur_nama' => 'Golongan Umur RL',
			'kelompokumur_nama' => 'Golongan Umur Surv',
			'nama_ayah' => 'Nama Ayah',
			'nama_ibu' => 'Nama Ibu',
			'sistem' => 'Sistem',
			'kunjungan' => 'Kunjungan',
			'no_pendaftaran' => 'No. Pendaftaran',
			'nama_pegawailoket' => 'Petugas Loket',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_nama' => 'Penjamin',
			'ruangan_nama' => 'Ruangan Inap',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'kelastanggungan_nama' => 'Kelas Tanggungan Asuransi',
			'caramasuk_nama' => 'Cara Masuk',
			'diagnosamasuk' => 'Diagnosa 10 Masuk',
			'keluhan' => 'Keluhan',
			'icd_masuk' => 'ICD 10 Masuk',
			'diagnosa_masuk' => 'Diagnosa 10 Masuk',
			'riwayatimunisasi' => 'Riwayat Imunisasi',
			'tekanandarah' => 'Tekanan Darah',
			'golongandarah' => 'Golongan Darah',
			'tinggibadan_cm' => 'Tinggi Badan',
			'beratbadan_kg' => 'Berat Badan',
			'nama_pegawaiverif' => 'Petugas Verifikasi',
			'icd_utama' => 'ICD 10 Utama',
			'diagnosa_utama' => 'Diagnosa 10 Utama',
			'dtd_nama' => 'DTD ICD 10 Utama',
			'icd_komplikasi' => 'ICD Komplikasi',
			'icd_tindakanutama' => 'ICD Tindakan Utama',
			'tindakanutama' => 'Tindakan Utama',
			'icd_tindakanlain' => 'ICD Tindakan Lain',
			'tindakanlain' => 'Tindakan Lain',
			'kodedokter' => 'Kode DPJP',
			'nama_pegawai' => 'Nama DPJP',
			'spesialissubspesialis_nama' => 'Sub Spesialis',
			'kasus' => 'Kasus',
			'icd_utama_dpjp' => 'ICD 10 Utama - DPJP',
			'diagnosa_utama_dpjp' => 'Diagnosa 10 Utama - DPJP ',
			'dtd_dpjp_nama' => 'DTD ICD 10 Utama - DPJP',
			'icd_komplikasi_dpjp' => 'ICD Komplikasi - DPJP',
			'petugasrawatinap' => 'Petugas Rawat Inap',
			'kodespesialis' => 'Kode Spesialis',
			'lamarawat' => 'Lama Rawat',
			'carakeluar_nama' => 'Cara Keluar',
			'tglpulang' => 'Tgl. Pulang',
			'asalrujukan_nama' => 'Asal Rujukan',
			'tanggal_rujukan' => 'Tgl. Rujukan',
			'no_rujukan' => 'No. Rujukan',
			'alamatrujukan' => 'Alamat Rujukan',
			'tgldiet' => 'Tgl. Diet',
			'tgloperasi1' => 'Tgl. Operasi 1',
			'tgloperasi2' => 'Tgl. Operasi 2',
			'tgloperasi3' => 'Tgl. Operasi 3',
			'tgloperasi4' => 'Tgl. Operasi 4',
			'tgloperasi5' => 'Tgl. Operasi 5',
			'jenisoperasi1' => 'Jenis Operasi 1',
			'jenisoperasi2' => 'Jenis Operasi 2',
			'jenisoperasi3' => 'Jenis Operasi 3',
			'jenisoperasi4' => 'Jenis Operasi 4',
			'jenisoperasi5' => 'Jenis Operasi 5',
			'tirahbaring' => 'Tirah Baring',
			'pulangmati' => 'Pulang Kematian',
			'tglmati' => 'Tgl. Kematian',
			'icdmati' => 'ICD 10 Kematian',
			'sebabmati' => 'Sebab Kematian',
			'aa' => 'Aa',
			'pendaftaran_id' => 'Pendaftaran',
			'tgl_pendaftaran' => 'Tgl Pendaftaran',
			'namadepan' => 'Namadepan',
			'nama_bin' => 'Nama Bin',
			'nama_pj' => 'Nama Pj',
			'nama_perujuk' => 'Nama Perujuk',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'instalasi_nama' => 'Instalasi Nama',
			'gelardepan' => 'Gelardepan',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'keterangankeluar' => 'Keterangankeluar',
			'statusperiksa' => 'Statusperiksa',
			'pasien_id' => 'Pasien',
			'jenisidentitas' => 'Jenisidentitas',
			'tempat_lahir' => 'Tempat Lahir',
			'rt' => 'Rt',
			'rw' => 'Rw',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'statusrekammedis' => 'Statusrekammedis',
			'tgl_rekam_medik' => 'Tgl Rekam Medik',
			'propinsi_id' => 'Provinsi',
			'kabupaten_id' => 'Kabupaten',
			'kelurahan_id' => 'Kelurahan',
			'kecamatan_id' => 'Kecamatan',
			'pekerjaan_id' => 'Pekerjaan',
			'no_urutantri' => 'No Urutantri',
			'transportasi' => 'Transportasi',
			'keadaanmasuk' => 'Keadaanmasuk',
			'statuspasien' => 'Statuspasien',
			'alihstatus' => 'Alihstatus',
			'byphone' => 'Byphone',
			'kunjunganrumah' => 'Kunjunganrumah',
			'statusmasuk' => 'Statusmasuk',
			'umur' => 'Umur',
			'no_asuransi' => 'No Asuransi',
			'namapemilik_asuransi' => 'Namapemilik Asuransi',
			'nopokokperusahaan' => 'Nopokokperusahaan',
			'carabayar_id' => 'Carabayar',
			'penjamin_id' => 'Penjamin',
			'caramasuk_id' => 'Caramasuk',
			'shift_id' => 'Shift',
			'golonganumur_id' => 'Golonganumur',
			'diagnosa_rujukan' => 'Diagnosa Rujukan',
			'asalrujukan_id' => 'Asalrujukan',
			'penanggungjawab_id' => 'Penanggungjawab',
			'pengantar' => 'Pengantar',
			'hubungankeluarga' => 'Hubungankeluarga',
			'ruangan_id' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'pasienadmisi_id' => 'Pasienadmisi',
			'statuskeluar' => 'Statuskeluar',
			'rawatgabung' => 'Rawatgabung',
			'create_time' => 'Create Time',
			'ktp' => 'Kelengkapan KTP',
			'kodeicd' => 'Kelengkapan Kode ICD',
			'kepalalist' => 'Kelengkapan Kepala List',
			'formcairan' => 'Kelengkapan Form Cairan',
			'diagnosatindakan' => 'Kelengkapan Diagnosa Tindakan',
			'namadokteroperasi' => 'Kelengkapan Dokter Operasi',
			'tandatangandokter' => 'Kelengkapan TTD Dokter',
			'namapasien' => 'Kelengkapan Pasien',
			'tandatanganpasien' => 'Kelengkapan TTD Pasien',
			'namasaksi1' => 'Kelengkapan Saksi 1',
			'tandatangansaksi1' => 'Kelengkapan TTD Saksi 1',
			'namasaksi2' => 'Kelengkapan Saksi 2',
			'tandatangansaksi2' => 'Kelengkapan TTD Saksi 2',
			'dischargesum' => 'Kelengkapan Discharge Sum',
			'formoperasi' => 'Kelengkapan Form Operasi',
			'formanastesi' => 'Kelengkapan Form Anestesi',
			'formtransfusi' => 'Kelengkapan Form Transfusi',
			'formkematian' => 'Kelengkapan Form Kematian',
			'formaskep' => 'Kelengkapan Form ASKEP',
			'generalconsent' => 'Kelengkapan General Consent',
			'formic' => 'Kelengkapan Form IC',
			'f1_a' => 'F1 A Diagnosa masuk, alasan / indikasi rawat',
			'f2_a' => 'F2 A Tanggal dan Jam',
			'f2_b' => 'F2 B Tanda tangan DPJP',
			'f3_a' => 'F3 A Tanggal dan Tanda Tangan',
			'f3_b' => 'F3 B Target Waktu',
			'f5_a_operasi' => 'F5 A Nama DPJP Bedah, Operator, Asisten Operator, Instrumen',
			'f5_b_operasi' => 'F5 B Nama DPJP Anestesi, Perawat anestesi, Tgl. Pembedahan',
			'f5_c_operasi' => 'F5 C Jenis Operasi, Sifat Operasi, Jenis Anestesi',
			'f5_d_operasi' => 'F5 D Mulai / selesai operasi, mulai / selesai pembiusan',
			'f5_e_operasi' => 'F5 E Jenis pembedahan, operasi ke …',
			'f5_f_operasi' => 'F5 F  Tanda tangan DPJP, Operator',
			'f5_g_operasi' => 'F5 G Diagnosa pra & pasca bedah',
			'f5_h_operasi' => 'F5 H Nama tindakan operasi',
			'f5_a_anastesi' => 'F5 A TTD Ahli anestesi',
			'f5_b_anastesi' => 'F5 B Petugas anestesi',
			'f5_c_anastesi' => 'F5 C Petugas RR',
			'f5_a_kemoterapi' => 'F5 A Seri kemo',
			'f5_b_kemoterapi' => 'F5 B Tanda tangan & Nama terang Dokter',
			'f5_a_transfusi' => 'F5 A No. Seri darah',
			'f5_b_transfusi' => 'F5 B Jam mulai / selesai transfusi',
			'f5_c_transfusi' => 'F5 C Tanda tangan & Nama terang Dokter',
			'f6_a_cppt' => 'F6 A Tanggal dan jam Pengkajian',
			'f6_b_cppt' => 'F6 B Nama dokter / perawat yang melakukan pengkajian',
			'f6_c_cppt' => 'F6 C Verifikasi DPJP',
			'f6_d_cppt' => 'F6 D  Kronologi Kematian',
			'f8_a_ringkasan' => 'F8 A Indikasi Dirawat',
			'f8_b_ringkasan' => 'F8 B Dasar diagnosa / kriteria diagnosa',
			'f8_c_ringkasan' => 'F8 C Tanda tanga DPJP dan pasien / Kel.Pasien',
			'f8_a_kematian' => 'F8 A Diagnosa sebab kematian',
			'f8_b_kematian' => 'F8 B Tanda Tangan Dokter',
			'casemix_a' => 'Cover A Tanda Tangan DPJP',
			'casemix_b' => 'Cover B Tanda Tangan Dokter',
			'f5_i_operasi' => 'F5 I  Laporan Prosedur Lain',
			'f5_c_kemoterapi' => 'F5 C Tanggal kemoterapi sesuai pelayanan',
			'f8_d_ringkasan' => 'F8 D Prosedur Operatif/Non Operatif',
			'f8_e_ringkasan' => 'F8 E Pemberian obat-obatan',
			'kelengkapanautopsi' => 'Kelengkapan Autopsi',
			'tgllengkap' => 'Tgl. Lengkap',
			'ketsebabkematian' => 'Keterangan Sebab Kematian',
			'tglverifikasikelengkapan' => 'Tgl. Verifikasi Lengkap',

			'icd_komplikasi1' => 'ICD Komplikasi 1',
			'icd_komplikasi2' => 'ICD Komplikasi 2',
			'icd_komplikasi3' => 'ICD Komplikasi 3',
			'icd_komplikasi4' => 'ICD Komplikasi 4',
			'icd_komplikasi5' => 'ICD Komplikasi 5',

			'icd_tindakan1' => 'ICD Tindakan 1',
			'icd_tindakan2' => 'ICD Tindakan 2',
			'icd_tindakan3' => 'ICD Tindakan 3',
			'icd_tindakan4' => 'ICD Tindakan 4',
			'icd_tindakan5' => 'ICD Tindakan 5',

			'icd_dpjp_komplikasi1' => 'ICD Komplikasi 1 - DPJP',
			'icd_dpjp_komplikasi2' => 'ICD Komplikasi 2 - DPJP',
			'icd_dpjp_komplikasi3' => 'ICD Komplikasi 3 - DPJP',
			'icd_dpjp_komplikasi4' => 'ICD Komplikasi 4 - DPJP',
			'icd_dpjp_komplikasi5' => 'ICD Komplikasi 5 - DPJP',

			'icd_dpjp_tindakan1' => 'ICD Tindakan 1 - DPJP',
			'icd_dpjp_tindakan2' => 'ICD Tindakan 2 - DPJP',
			'icd_dpjp_tindakan3' => 'ICD Tindakan 3 - DPJP',
			'icd_dpjp_tindakan4' => 'ICD Tindakan 4 - DPJP',
			'icd_dpjp_tindakan5' => 'ICD Tindakan 5 - DPJP',
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

		$criteria->compare('tgladmisi',$this->tgladmisi,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('nama_pasien',$this->nama_pasien,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kelurahan_nama',$this->kelurahan_nama,true);
		$criteria->compare('kecamatan_nama',$this->kecamatan_nama,true);
		$criteria->compare('kabupaten_nama',$this->kabupaten_nama,true);
		$criteria->compare('propinsi_nama',$this->propinsi_nama,true);
		$criteria->compare('no_mobile_pasien',$this->no_mobile_pasien,true);
		$criteria->compare('suku_nama',$this->suku_nama,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('warga_negara',$this->warga_negara,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('no_identitas_pasien',$this->no_identitas_pasien,true);
		$criteria->compare('tanggal_lahir',$this->tanggal_lahir,true);
		$criteria->compare('umur_tahun',$this->umur_tahun,true);
		$criteria->compare('umur_bulan',$this->umur_bulan,true);
		$criteria->compare('umur_hari',$this->umur_hari,true);
		$criteria->compare('golonganumur_nama',$this->golonganumur_nama,true);
		$criteria->compare('kelompokumur_nama',$this->kelompokumur_nama,true);
		$criteria->compare('nama_ayah',$this->nama_ayah,true);
		$criteria->compare('nama_ibu',$this->nama_ibu,true);
		$criteria->compare('sistem',$this->sistem,true);
		$criteria->compare('kunjungan',$this->kunjungan,true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('nama_pegawailoket',$this->nama_pegawailoket,true);
		$criteria->compare('carabayar_nama',$this->carabayar_nama,true);
		$criteria->compare('penjamin_nama',$this->penjamin_nama,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('kelastanggungan_nama',$this->kelastanggungan_nama,true);
		$criteria->compare('caramasuk_nama',$this->caramasuk_nama,true);
		$criteria->compare('diagnosamasuk',$this->diagnosamasuk,true);
		$criteria->compare('keluhan',$this->keluhan,true);
		$criteria->compare('icd_masuk',$this->icd_masuk,true);
		$criteria->compare('diagnosa_masuk',$this->diagnosa_masuk,true);
		$criteria->compare('riwayatimunisasi',$this->riwayatimunisasi,true);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('golongandarah',$this->golongandarah,true);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('nama_pegawaiverif',$this->nama_pegawaiverif,true);
		$criteria->compare('icd_utama',$this->icd_utama,true);
		$criteria->compare('diagnosa_utama',$this->diagnosa_utama,true);
		$criteria->compare('dtd_nama',$this->dtd_nama,true);
		$criteria->compare('icd_komplikasi',$this->icd_komplikasi,true);
		$criteria->compare('icd_tindakanutama',$this->icd_tindakanutama,true);
		$criteria->compare('tindakanutama',$this->tindakanutama,true);
		$criteria->compare('icd_tindakanlain',$this->icd_tindakanlain,true);
		$criteria->compare('tindakanlain',$this->tindakanlain,true);
		$criteria->compare('kodedokter',$this->kodedokter,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('spesialissubspesialis_nama',$this->spesialissubspesialis_nama,true);
		$criteria->compare('kasus',$this->kasus,true);
		$criteria->compare('icd_utama_dpjp',$this->icd_utama_dpjp,true);
		$criteria->compare('diagnosa_utama_dpjp',$this->diagnosa_utama_dpjp,true);
		$criteria->compare('dtd_dpjp_nama',$this->dtd_dpjp_nama,true);
		$criteria->compare('icd_komplikasi_dpjp',$this->icd_komplikasi_dpjp,true);
		$criteria->compare('petugasrawatinap',$this->petugasrawatinap,true);
		$criteria->compare('kodespesialis',$this->kodespesialis,true);
		$criteria->compare('lamarawat',$this->lamarawat,true);
		$criteria->compare('carakeluar_nama',$this->carakeluar_nama,true);
		$criteria->compare('tglpulang',$this->tglpulang,true);
		$criteria->compare('asalrujukan_nama',$this->asalrujukan_nama,true);
		$criteria->compare('tanggal_rujukan',$this->tanggal_rujukan,true);
		$criteria->compare('no_rujukan',$this->no_rujukan,true);
		$criteria->compare('alamatrujukan',$this->alamatrujukan,true);
		$criteria->compare('tgldiet',$this->tgldiet,true);
		$criteria->compare('tgloperasi',$this->tgloperasi,true);
		$criteria->compare('jenisoperasi',$this->jenisoperasi,true);
		$criteria->compare('tirahbaring',$this->tirahbaring);
		$criteria->compare('pulangmati',$this->pulangmati);
		$criteria->compare('tglmati',$this->tglmati,true);
		$criteria->compare('icdmati',$this->icdmati,true);
		$criteria->compare('sebabmati',$this->sebabmati,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('ktp',$this->ktp,true);
		$criteria->compare('kodeicd',$this->kodeicd,true);
		$criteria->compare('kepalalist',$this->kepalalist,true);
		$criteria->compare('formcairan',$this->formcairan,true);
		$criteria->compare('diagnosatindakan',$this->diagnosatindakan,true);
		$criteria->compare('namadokteroperasi',$this->namadokteroperasi,true);
		$criteria->compare('tandatangandokter',$this->tandatangandokter,true);
		$criteria->compare('namapasien',$this->namapasien,true);
		$criteria->compare('tandatanganpasien',$this->tandatanganpasien,true);
		$criteria->compare('namasaksi1',$this->namasaksi1,true);
		$criteria->compare('tandatangansaksi1',$this->tandatangansaksi1,true);
		$criteria->compare('namasaksi2',$this->namasaksi2,true);
		$criteria->compare('tandatangansaksi2',$this->tandatangansaksi2,true);
		$criteria->compare('dischargesum',$this->dischargesum,true);
		$criteria->compare('formoperasi',$this->formoperasi,true);
		$criteria->compare('formanastesi',$this->formanastesi,true);
		$criteria->compare('formtransfusi',$this->formtransfusi,true);
		$criteria->compare('formkematian',$this->formkematian,true);
		$criteria->compare('formaskep',$this->formaskep,true);
		$criteria->compare('generalconsent',$this->generalconsent,true);
		$criteria->compare('formic',$this->formic,true);
		$criteria->compare('f1_a',$this->f1_a,true);
		$criteria->compare('f2_a',$this->f2_a,true);
		$criteria->compare('f2_b',$this->f2_b,true);
		$criteria->compare('f3_a',$this->f3_a,true);
		$criteria->compare('f3_b',$this->f3_b,true);
		$criteria->compare('f5_a_operasi',$this->f5_a_operasi,true);
		$criteria->compare('f5_b_operasi',$this->f5_b_operasi,true);
		$criteria->compare('f5_c_operasi',$this->f5_c_operasi,true);
		$criteria->compare('f5_d_operasi',$this->f5_d_operasi,true);
		$criteria->compare('f5_e_operasi',$this->f5_e_operasi,true);
		$criteria->compare('f5_f_operasi',$this->f5_f_operasi,true);
		$criteria->compare('f5_g_operasi',$this->f5_g_operasi,true);
		$criteria->compare('f5_h_operasi',$this->f5_h_operasi,true);
		$criteria->compare('f5_a_anastesi',$this->f5_a_anastesi,true);
		$criteria->compare('f5_b_anastesi',$this->f5_b_anastesi,true);
		$criteria->compare('f5_c_anastesi',$this->f5_c_anastesi,true);
		$criteria->compare('f5_a_kemoterapi',$this->f5_a_kemoterapi,true);
		$criteria->compare('f5_b_kemoterapi',$this->f5_b_kemoterapi,true);
		$criteria->compare('f5_a_transfusi',$this->f5_a_transfusi,true);
		$criteria->compare('f5_b_transfusi',$this->f5_b_transfusi,true);
		$criteria->compare('f5_c_transfusi',$this->f5_c_transfusi,true);
		$criteria->compare('f6_a_cppt',$this->f6_a_cppt,true);
		$criteria->compare('f6_b_cppt',$this->f6_b_cppt,true);
		$criteria->compare('f6_c_cppt',$this->f6_c_cppt,true);
		$criteria->compare('f6_d_cppt',$this->f6_d_cppt,true);
		$criteria->compare('f8_a_ringkasan',$this->f8_a_ringkasan,true);
		$criteria->compare('f8_b_ringkasan',$this->f8_b_ringkasan,true);
		$criteria->compare('f8_c_ringkasan',$this->f8_c_ringkasan,true);
		$criteria->compare('f8_a_kematian',$this->f8_a_kematian,true);
		$criteria->compare('f8_b_kematian',$this->f8_b_kematian,true);
		$criteria->compare('casemix_a',$this->casemix_a,true);
		$criteria->compare('casemix_b',$this->casemix_b,true);
		$criteria->compare('f5_i_operasi',$this->f5_i_operasi,true);
		$criteria->compare('f5_c_kemoterapi',$this->f5_c_kemoterapi,true);
		$criteria->compare('f8_d_ringkasan',$this->f8_d_ringkasan,true);
		$criteria->compare('f8_e_ringkasan',$this->f8_e_ringkasan,true);
		$criteria->compare('kelengkapanautopsi',$this->kelengkapanautopsi,true);
		$criteria->compare('tgllengkap',$this->tgllengkap,true);
		$criteria->compare('ketsebabkematian',$this->ketsebabkematian,true);
		$criteria->compare('tglverifikasikelengkapan',$this->tglverifikasikelengkapan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InfokunjunganriglobalV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

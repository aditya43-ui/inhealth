<?php

/**
 * This is the model class for table "rinciantagihapasienpenunjang_v".
 *
 * The followings are the available columns in table 'rinciantagihapasienpenunjang_v':
 * @property integer $profilrs_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
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
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $anakke
 * @property integer $jumlah_bersaudara
 * @property string $no_telepon_pasien
 * @property string $no_mobile_pasien
 * @property string $warga_negara
 * @property string $photopasien
 * @property string $alamatemail
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property string $no_asuransi
 * @property string $namapemilik_asuransi
 * @property string $nopokokperusahaan
 * @property string $namaperusahaan
 * @property string $tglselesaiperiksa
 * @property integer $tindakanpelayanan_id
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $tgl_tindakan
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property integer $tipepaket_id
 * @property string $tipepaket_nama
 * @property boolean $daftartindakan_karcis
 * @property boolean $daftartindakan_visite
 * @property boolean $daftartindakan_konsul
 * @property double $tarif_rsakomodasi
 * @property double $tarif_medis
 * @property double $tarif_paramedis
 * @property double $tarif_bhp
 * @property double $tarif_satuan
 * @property double $tarif_tindakan
 * @property string $satuantindakan
 * @property integer $qty_tindakan
 * @property boolean $cyto_tindakan
 * @property double $tarifcyto_tindakan
 * @property double $discount_tindakan
 * @property double $pembebasan_tindakan
 * @property double $subsidiasuransi_tindakan
 * @property double $subsidipemerintah_tindakan
 * @property double $subsisidirumahsakit_tindakan
 * @property double $iurbiaya_tindakan
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $pembayaranpelayanan_id
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property integer $ruanganpendaftaran_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property integer $ruanganpenunjang_id
 * @property integer $tindakansudahbayar_id
 */
class RinciantagihanpasienpenunjangV extends CActiveRecord
{
	public $tgl_awal, $tgl_akhir, $totaltagihan, $statusBayar, $pasienadmisi_id;
	public $statusperiksa;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RinciantagihanpasienpenunjangV the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rinciantagihapasienpenunjang_v';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, pasien_id, rt, rw, anakke, jumlah_bersaudara, pendaftaran_id, tindakanpelayanan_id, penjamin_id, carabayar_id, kelaspelayanan_id, instalasi_id, ruangan_id, daftartindakan_id, tipepaket_id, qty_tindakan, jeniskasuspenyakit_id, pembayaranpelayanan_id, kategoritindakan_id, pegawai_id, gelarbelakang_id, ruanganpendaftaran_id, pasienmasukpenunjang_id, ruanganpenunjang_id, tindakansudahbayar_id', 'numerical', 'integerOnly' => true),
			array('tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, tarif_satuan, tarif_tindakan, tarifcyto_tindakan, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan', 'numerical'),
			array('no_rekam_medik, satuantindakan, gelardepan', 'length', 'max' => 10),
			array('jenisidentitas, namadepan, jeniskelamin, statusperkawinan, agama, rhesus, no_mobile_pasien, no_pendaftaran, daftartindakan_kode, no_masukpenunjang', 'length', 'max' => 20),
			array('no_identitas_pasien, nama_bin, umur, kategoritindakan_nama', 'length', 'max' => 30),
			array('nama_pasien, no_asuransi, namapemilik_asuransi, nopokokperusahaan, namaperusahaan, penjamin_nama, carabayar_nama, kelaspelayanan_nama, instalasi_nama, ruangan_nama, tipepaket_nama, nama_pegawai', 'length', 'max' => 50),
			array('tempat_lahir, warga_negara', 'length', 'max' => 25),
			array('golongandarah', 'length', 'max' => 2),
			array('no_telepon_pasien, gelarbelakang_nama', 'length', 'max' => 15),
			array('photopasien, daftartindakan_nama', 'length', 'max' => 200),
			array('alamatemail, jeniskasuspenyakit_nama', 'length', 'max' => 100),
			array('tgl_rekam_medik, tanggal_lahir, alamat_pasien, tgl_pendaftaran, tglselesaiperiksa, tgl_tindakan, daftartindakan_karcis, daftartindakan_visite, daftartindakan_konsul, cyto_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tglmasukpenunjang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('statusBayar, tgl_awal, tgl_akhir, profilrs_id, pasien_id, o_rekam_medik, tgl_rekam_medik, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, statusperkawinan, agama, golongandarah, rhesus, anakke, jumlah_bersaudara, no_telepon_pasien, no_mobile_pasien, warga_negara, photopasien, alamatemail, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, namaperusahaan, tglselesaiperiksa, tindakanpelayanan_id, penjamin_id, penjamin_nama, carabayar_id, carabayar_nama, kelaspelayanan_id, kelaspelayanan_nama, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, tgl_tindakan, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, tipepaket_id, tipepaket_nama, daftartindakan_karcis, daftartindakan_visite, daftartindakan_konsul, tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, tarif_satuan, tarif_tindakan, satuantindakan, qty_tindakan, cyto_tindakan, tarifcyto_tindakan, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, pembayaranpelayanan_id, kategoritindakan_id, kategoritindakan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, ruanganpendaftaran_id, pasienmasukpenunjang_id, no_masukpenunjang, tglmasukpenunjang, ruanganpenunjang_id, tindakansudahbayar_id', 'safe', 'on' => 'search'),
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
			'pendaftaran' => array(self::HAS_MANY, 'PendaftaranT', 'pendaftaran_id'),
			'pasien' => array(self::HAS_MANY, 'PasienM', 'pasien_id'),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'profilrs_id' => 'Profilrs',
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
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
			'statusperkawinan' => 'Statusperkawinan',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'rhesus' => 'Rhesus',
			'anakke' => 'Anakke',
			'jumlah_bersaudara' => 'Jumlah Bersaudara',
			'no_telepon_pasien' => 'No. Telepon Pasien',
			'no_mobile_pasien' => 'No. Handphone Pasien',
			'warga_negara' => 'Warga Negara',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'umur' => 'Umur',
			'no_asuransi' => 'No. Asuransi',
			'namapemilik_asuransi' => 'Namapemilik Asuransi',
			'nopokokperusahaan' => 'Nopokokperusahaan',
			'namaperusahaan' => 'Namaperusahaan',
			'tglselesaiperiksa' => 'Tglselesaiperiksa',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Cara Bayar Nama',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Nama Kelas Pelayanan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Nama Ruangan',
			'tgl_tindakan' => 'Tanggal Tindakan',
			'daftartindakan_id' => 'Daftar TIndakan',
			'daftartindakan_kode' => 'Kode Daftar Tindakan',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'tipepaket_id' => 'Tipe Paket',
			'tipepaket_nama' => 'Tipe Paket Nama',
			'daftartindakan_karcis' => 'Karcis Daftar Tindakan',
			'daftartindakan_visite' => 'Visite Daftar Tindakan',
			'daftartindakan_konsul' => 'Konsul Daftar Tindakan',
			'tarif_rsakomodasi' => 'Tarif Rsakomodasi',
			'tarif_medis' => 'Tarif Medis',
			'tarif_paramedis' => 'Tarif Paramedis',
			'tarif_bhp' => 'Tarif Bhp',
			'tarif_satuan' => 'Tarif Satuan',
			'tarif_tindakan' => 'Nominal Tarif',
			'satuantindakan' => 'Satuan TIndakan',
			'qty_tindakan' => 'Tindakan Jumlah',
			'cyto_tindakan' => 'Tindakan Cyto',
			'tarifcyto_tindakan' => 'Tindakan Tarif Cyto',
			'discount_tindakan' => 'Tindakan Keringanan',
			'pembebasan_tindakan' => 'Tindakan Pembebasan',
			'subsidiasuransi_tindakan' => 'Tindakan Tanggungan Asuransi',
			'subsidipemerintah_tindakan' => 'Tindakan Tanggungan Pemerintah',
			'subsisidirumahsakit_tindakan' => 'Tindakan Tanggungan Rumah Sakit',
			'iurbiaya_tindakan' => 'Iur Biaya Tindakan',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
			'jeniskasuspenyakit_nama' => 'Nama Jenis Kasus Penyakit',
			'pembayaranpelayanan_id' => 'Pembayaran Pelayanan',
			'kategoritindakan_id' => 'Kategori Tindakan',
			'kategoritindakan_nama' => 'Nama Kategori Tindakan',
			'pegawai_id' => 'Dokter',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Dokter',
			'gelarbelakang_id' => 'Gelar Belakang',
			'gelarbelakang_nama' => 'Nama Gelar Belakang',
			'ruanganpendaftaran_id' => 'Ruangan Pendaftaran',
			'pasienmasukpenunjang_id' => 'Pasien Masuk Penunjang',
			'no_masukpenunjang' => 'No. Masuk Penunjang',
			'tglmasukpenunjang' => 'Tanggal Masuk Penunjang',
			'ruanganpenunjang_id' => 'Ruangan Penunjang',
			'tindakansudahbayar_id' => 'Tindakan Sudah Bayar',
			'totaltagihan' => 'Total Tagihan',
			'statusperiksa' => 'Status Periksa',
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
		$criteria = new CDbCriteria;
		$criteria->compare('profilrs_id', $this->profilrs_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
		$criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
		$criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
		$criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
		$criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
		$criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
		$criteria->compare('rt', $this->rt);
		$criteria->compare('rw', $this->rw);
		$criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
		$criteria->compare('LOWER(agama)', strtolower($this->agama), true);
		$criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
		$criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
		$criteria->compare('anakke', $this->anakke);
		$criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
		$criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
		$criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
		$criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
		$criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
		$criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
		$criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		$criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
		$criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
		$criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
		$criteria->compare('LOWER(namaperusahaan)', strtolower($this->namaperusahaan), true);
		$criteria->compare('LOWER(tglselesaiperiksa)', strtolower($this->tglselesaiperiksa), true);
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
		$criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
		$criteria->compare('daftartindakan_karcis', $this->daftartindakan_karcis);
		$criteria->compare('daftartindakan_visite', $this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul', $this->daftartindakan_konsul);
		$criteria->compare('tarif_rsakomodasi', $this->tarif_rsakomodasi);
		$criteria->compare('tarif_medis', $this->tarif_medis);
		$criteria->compare('tarif_paramedis', $this->tarif_paramedis);
		$criteria->compare('tarif_bhp', $this->tarif_bhp);
		$criteria->compare('tarif_satuan', $this->tarif_satuan);
		$criteria->compare('tarif_tindakan', $this->tarif_tindakan);
		$criteria->compare('LOWER(satuantindakan)', strtolower($this->satuantindakan), true);
		$criteria->compare('qty_tindakan', $this->qty_tindakan);
		$criteria->compare('cyto_tindakan', $this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
		$criteria->compare('discount_tindakan', $this->discount_tindakan);
		$criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
		$criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
		$criteria->compare('subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		$criteria->compare('pembayaranpelayanan_id', $this->pembayaranpelayanan_id);
		$criteria->compare('kategoritindakan_id', $this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
		$criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
		$criteria->compare('ruanganpendaftaran_id', $this->ruanganpendaftaran_id);
		$criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(no_masukpenunjang)', strtolower($this->no_masukpenunjang), true);
		$criteria->compare('LOWER(tglmasukpenunjang)', strtolower($this->tglmasukpenunjang), true);
		$criteria->compare('ruanganpenunjang_id', $this->ruanganpenunjang_id);
		$criteria->compare('tindakansudahbayar_id', $this->tindakansudahbayar_id);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('profilrs_id', $this->profilrs_id);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
		$criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
		$criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
		$criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
		$criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
		$criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
		$criteria->compare('rt', $this->rt);
		$criteria->compare('rw', $this->rw);
		$criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
		$criteria->compare('LOWER(agama)', strtolower($this->agama), true);
		$criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
		$criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
		$criteria->compare('anakke', $this->anakke);
		$criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
		$criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
		$criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
		$criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
		$criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
		$criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
		$criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		$criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
		$criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
		$criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
		$criteria->compare('LOWER(namaperusahaan)', strtolower($this->namaperusahaan), true);
		$criteria->compare('LOWER(tglselesaiperiksa)', strtolower($this->tglselesaiperiksa), true);
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
		$criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
		$criteria->compare('daftartindakan_karcis', $this->daftartindakan_karcis);
		$criteria->compare('daftartindakan_visite', $this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul', $this->daftartindakan_konsul);
		$criteria->compare('tarif_rsakomodasi', $this->tarif_rsakomodasi);
		$criteria->compare('tarif_medis', $this->tarif_medis);
		$criteria->compare('tarif_paramedis', $this->tarif_paramedis);
		$criteria->compare('tarif_bhp', $this->tarif_bhp);
		$criteria->compare('tarif_satuan', $this->tarif_satuan);
		$criteria->compare('tarif_tindakan', $this->tarif_tindakan);
		$criteria->compare('LOWER(satuantindakan)', strtolower($this->satuantindakan), true);
		$criteria->compare('qty_tindakan', $this->qty_tindakan);
		$criteria->compare('cyto_tindakan', $this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
		$criteria->compare('discount_tindakan', $this->discount_tindakan);
		$criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
		$criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
		$criteria->compare('subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		$criteria->compare('pembayaranpelayanan_id', $this->pembayaranpelayanan_id);
		$criteria->compare('kategoritindakan_id', $this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('gelarbelakang_id', $this->gelarbelakang_id);
		$criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
		$criteria->compare('ruanganpendaftaran_id', $this->ruanganpendaftaran_id);
		$criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
		$criteria->compare('LOWER(no_masukpenunjang)', strtolower($this->no_masukpenunjang), true);
		$criteria->compare('LOWER(tglmasukpenunjang)', strtolower($this->tglmasukpenunjang), true);
		$criteria->compare('ruanganpenunjang_id', $this->ruanganpenunjang_id);
		$criteria->compare('tindakansudahbayar_id', $this->tindakansudahbayar_id);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
	public function getNamaNamaBIN()
	{
		if (!empty($this->nama_bin)) {
			return $this->nama_pasien . ' alias ' . $this->nama_bin;
		} else {
			return $this->nama_pasien;
		}
	}
	public function getCaraBayarPenjamin()
	{
		return $this->carabayar_nama . ' / ' . $this->penjamin_nama;
	}
	public function getAlamatRTRW()
	{
		return $this->alamat_pasien . '<br>' . $this->rt . ' / ' . $this->rw;
	}
	public function getNoRMNoPend()
	{
		return $this->no_rekam_medik . '<br/>' . $this->no_pendaftaran;
	}
	public function getTglMasukNoPenunjang()
	{
		return $this->tglmasukpenunjang . '<br/>' . PHP_EOL . $this->no_masukpenunjang;
	}
	public function getJenisKelaminUmur()
	{
		return $this->jeniskelamin . '<br/>' . $this->umur;
	}
	public function getInstalasiRuangan()
	{
		return $this->instalasiasal_nama . '<br/>' . $this->ruanganasal_nama;
	}
	protected function afterFind()
	{
		foreach ($this->metadata->tableSchema->columns as $columnName => $column) {
			if (!strlen($this->$columnName)) continue;
			if ($column->dbType == 'date') {
				$this->$columnName = Yii::app()->dateFormatter->formatDateTime(
					CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),
					'medium',
					null
				);
			} elseif ($column->dbType == 'timestamp without time zone') {
				$this->$columnName = Yii::app()->dateFormatter->formatDateTime(
					CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss', 'medium', null)
				);
			}
		}
		return true;
	}
}

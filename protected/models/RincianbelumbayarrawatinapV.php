<?php

/**
 * This is the model class for table "rincianbelumbayarrawatinap_v".
 *
 * The followings are the available columns in table 'rincianbelumbayarrawatinap_v':
 * @property integer $profilrs_id
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $umur
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $instalasi_nama
 * @property integer $instalasi_id
 * @property integer $unitlayanan_id
 * @property string $unitlayanan_nama
 * @property integer $pegawai_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $tglrenkontrol
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property string $nama_pj
 * @property string $alamat_pj
 * @property integer $tindakanpelayanan_id
 * @property string $tgl_tindakan
 * @property double $tarif_satuan
 * @property double $qty_tindakan
 * @property string $satuantindakan
 * @property integer $kategoritindakan_id
 * @property string $kategoritindakan_nama
 * @property integer $tipepaket_id
 * @property string $tipepaket_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property double $discount_tindakan
 * @property double $pembebasan_tindakan
 * @property double $subsidiasuransi_tindakan
 * @property double $subsisidirumahsakit_tindakan
 * @property double $iurbiaya_tindakan
 * @property string $tm
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $kelastindakan_id
 * @property string $kelastindakan_nama
 * @property integer $ruangantindakan_id
 * @property string $ruangantindakan_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $tgl_pendaftaran
 * @property double $tarifcyto_tindakan
 * @property string $caramasuk_nama
 * @property integer $caramasuk_id
 * @property string $tgladmisi
 * @property boolean $daftartindakan_visite
 * @property boolean $daftartindakan_konsul
 * @property boolean $daftartindakan_tindakan
 * @property boolean $daftartindakan_akomodasi
 * @property boolean $daftartindakan_observasi
 * @property string $tglpasienpulang
 * @property string $carakeluar
 * @property string $kondisipulang
 * @property string $ruanganakhir_nama
 * @property integer $ruanganakhir_id
 * @property string $penerimapasien
 * @property integer $lamarawat
 * @property double $jumlahuangmuka
 */
class RincianbelumbayarrawatinapV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RincianbelumbayarrawatinapV the static model class
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
		return 'rincianbelumbayarrawatinap_v';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, pasien_id, rt, rw, pendaftaran_id, instalasi_id, unitlayanan_id, pegawai_id, carabayar_id, penjamin_id, jeniskasuspenyakit_id, tindakanpelayanan_id, kategoritindakan_id, tipepaket_id, daftartindakan_id, kelastindakan_id, ruangantindakan_id, kelaspelayanan_id, caramasuk_id, ruanganakhir_id, lamarawat', 'numerical', 'integerOnly' => true),
			array('tarif_satuan, qty_tindakan, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, tarifcyto_tindakan, jumlahuangmuka', 'numerical'),
			array('no_rekam_medik, gelardepan', 'length', 'max' => 10),
			array('namadepan, jeniskelamin, no_pendaftaran', 'length', 'max' => 20),
			array('nama_pasien, instalasi_nama, unitlayanan_nama, nama_pegawai, carabayar_nama, penjamin_nama, nama_pj, tipepaket_nama, kelastindakan_nama, ruangantindakan_nama, kelaspelayanan_nama, caramasuk_nama, carakeluar, kondisipulang, ruanganakhir_nama', 'length', 'max' => 50),
			array('umur', 'length', 'max' => 30),
			array('gelarbelakang_nama', 'length', 'max' => 15),
			array('jeniskasuspenyakit_nama, penerimapasien', 'length', 'max' => 100),
			array('daftartindakan_nama', 'length', 'max' => 200),
			array('tm', 'length', 'max' => 2),
			array('alamat_pasien, tglrenkontrol, alamat_pj, tgl_tindakan, satuantindakan, kategoritindakan_nama, daftartindakan_kode, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tgl_pendaftaran, tgladmisi, daftartindakan_visite, daftartindakan_konsul, daftartindakan_tindakan, daftartindakan_akomodasi, daftartindakan_observasi, tglpasienpulang', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('profilrs_id, pasien_id, no_rekam_medik, namadepan, nama_pasien, jeniskelamin, umur, alamat_pasien, rt, rw, pendaftaran_id, no_pendaftaran, instalasi_nama, instalasi_id, unitlayanan_id, unitlayanan_nama, pegawai_id, gelardepan, nama_pegawai, gelarbelakang_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, tglrenkontrol, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, nama_pj, alamat_pj, tindakanpelayanan_id, tgl_tindakan, tarif_satuan, qty_tindakan, satuantindakan, kategoritindakan_id, kategoritindakan_nama, tipepaket_id, tipepaket_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, discount_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, tm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, kelastindakan_id, kelastindakan_nama, ruangantindakan_id, ruangantindakan_nama, kelaspelayanan_id, kelaspelayanan_nama, tgl_pendaftaran, tarifcyto_tindakan, caramasuk_nama, caramasuk_id, tgladmisi, daftartindakan_visite, daftartindakan_konsul, daftartindakan_tindakan, daftartindakan_akomodasi, daftartindakan_observasi, tglpasienpulang, carakeluar, kondisipulang, ruanganakhir_nama, ruanganakhir_id, penerimapasien, lamarawat, jumlahuangmuka', 'safe', 'on' => 'search'),
		);
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
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
			'namadepan' => 'Namadepan',
			'nama_pasien' => 'Nama Pasien',
			'jeniskelamin' => 'Jenis Kelamin',
			'umur' => 'Umur',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'instalasi_nama' => 'Instalasi Nama',
			'instalasi_id' => 'Instalasi',
			'unitlayanan_id' => 'Unitlayanan',
			'unitlayanan_nama' => 'Unitlayanan Nama',
			'pegawai_id' => 'Pegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'tglrenkontrol' => 'Tglrenkontrol',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'nama_pj' => 'Nama Pj',
			'alamat_pj' => 'Alamat Pj',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'tgl_tindakan' => 'Tanggal Tindakan',
			'tarif_satuan' => 'Tarif Satuan',
			'qty_tindakan' => 'Jumlah Tindakan',
			'satuantindakan' => 'Satuantindakan',
			'kategoritindakan_id' => 'Kategoritindakan',
			'kategoritindakan_nama' => 'Kategoritindakan Nama',
			'tipepaket_id' => 'Tipepaket',
			'tipepaket_nama' => 'Tipepaket Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'discount_tindakan' => 'Keringanan Tindakan',
			'pembebasan_tindakan' => 'Pembebasan Tindakan',
			'subsidiasuransi_tindakan' => 'Tanggungan Asuransi Tindakan',
			'subsisidirumahsakit_tindakan' => 'Tanggungan Rumah Sakit Tindakan',
			'iurbiaya_tindakan' => 'Iurbiaya Tindakan',
			'tm' => 'Tm',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'kelastindakan_id' => 'Kelastindakan',
			'kelastindakan_nama' => 'Kelastindakan Nama',
			'ruangantindakan_id' => 'Ruangantindakan',
			'ruangantindakan_nama' => 'Ruangantindakan Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'tarifcyto_tindakan' => 'Tarifcyto Tindakan',
			'caramasuk_nama' => 'Caramasuk Nama',
			'caramasuk_id' => 'Caramasuk',
			'tgladmisi' => 'Tgladmisi',
			'daftartindakan_visite' => 'Daftartindakan Visite',
			'daftartindakan_konsul' => 'Daftartindakan Konsul',
			'daftartindakan_tindakan' => 'Daftartindakan Tindakan',
			'daftartindakan_akomodasi' => 'Daftartindakan Akomodasi',
			'daftartindakan_observasi' => 'Daftartindakan Observasi',
			'tglpasienpulang' => 'Tglpasienpulang',
			'carakeluar' => 'Carakeluar',
			'kondisipulang' => 'Kondisipulang',
			'ruanganakhir_nama' => 'Ruanganakhir Nama',
			'ruanganakhir_id' => 'Ruanganakhir',
			'penerimapasien' => 'Penerimapasien',
			'lamarawat' => 'Lamarawat',
			'jumlahuangmuka' => 'Jumlahuangmuka',
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
		$criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		$criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
		$criteria->compare('rt', $this->rt);
		$criteria->compare('rw', $this->rw);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('unitlayanan_id', $this->unitlayanan_id);
		$criteria->compare('LOWER(unitlayanan_nama)', strtolower($this->unitlayanan_nama), true);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->compare('LOWER(tglrenkontrol)', strtolower($this->tglrenkontrol), true);
		$criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		$criteria->compare('LOWER(nama_pj)', strtolower($this->nama_pj), true);
		$criteria->compare('LOWER(alamat_pj)', strtolower($this->alamat_pj), true);
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		$criteria->compare('tarif_satuan', $this->tarif_satuan);
		$criteria->compare('qty_tindakan', $this->qty_tindakan);
		$criteria->compare('LOWER(satuantindakan)', strtolower($this->satuantindakan), true);
		$criteria->compare('kategoritindakan_id', $this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
		$criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
		$criteria->compare('discount_tindakan', $this->discount_tindakan);
		$criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
		$criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
		$criteria->compare('LOWER(tm)', strtolower($this->tm), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->compare('kelastindakan_id', $this->kelastindakan_id);
		$criteria->compare('LOWER(kelastindakan_nama)', strtolower($this->kelastindakan_nama), true);
		$criteria->compare('ruangantindakan_id', $this->ruangantindakan_id);
		$criteria->compare('LOWER(ruangantindakan_nama)', strtolower($this->ruangantindakan_nama), true);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		$criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
		$criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
		$criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
		$criteria->compare('caramasuk_id', $this->caramasuk_id);
		$criteria->compare('LOWER(tgladmisi)', strtolower($this->tgladmisi), true);
		$criteria->compare('daftartindakan_visite', $this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul', $this->daftartindakan_konsul);
		$criteria->compare('daftartindakan_tindakan', $this->daftartindakan_tindakan);
		$criteria->compare('daftartindakan_akomodasi', $this->daftartindakan_akomodasi);
		$criteria->compare('daftartindakan_observasi', $this->daftartindakan_observasi);
		$criteria->compare('LOWER(tglpasienpulang)', strtolower($this->tglpasienpulang), true);
		$criteria->compare('LOWER(carakeluar)', strtolower($this->carakeluar), true);
		$criteria->compare('LOWER(kondisipulang)', strtolower($this->kondisipulang), true);
		$criteria->compare('LOWER(ruanganakhir_nama)', strtolower($this->ruanganakhir_nama), true);
		$criteria->compare('ruanganakhir_id', $this->ruanganakhir_id);
		$criteria->compare('LOWER(penerimapasien)', strtolower($this->penerimapasien), true);
		$criteria->compare('lamarawat', $this->lamarawat);
		$criteria->compare('jumlahuangmuka', $this->jumlahuangmuka);
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
		$criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		$criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
		$criteria->compare('rt', $this->rt);
		$criteria->compare('rw', $this->rw);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('unitlayanan_id', $this->unitlayanan_id);
		$criteria->compare('LOWER(unitlayanan_nama)', strtolower($this->unitlayanan_nama), true);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->compare('LOWER(tglrenkontrol)', strtolower($this->tglrenkontrol), true);
		$criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		$criteria->compare('LOWER(nama_pj)', strtolower($this->nama_pj), true);
		$criteria->compare('LOWER(alamat_pj)', strtolower($this->alamat_pj), true);
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
		$criteria->compare('tarif_satuan', $this->tarif_satuan);
		$criteria->compare('qty_tindakan', $this->qty_tindakan);
		$criteria->compare('LOWER(satuantindakan)', strtolower($this->satuantindakan), true);
		$criteria->compare('kategoritindakan_id', $this->kategoritindakan_id);
		$criteria->compare('LOWER(kategoritindakan_nama)', strtolower($this->kategoritindakan_nama), true);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('LOWER(tipepaket_nama)', strtolower($this->tipepaket_nama), true);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('LOWER(daftartindakan_kode)', strtolower($this->daftartindakan_kode), true);
		$criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
		$criteria->compare('discount_tindakan', $this->discount_tindakan);
		$criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
		$criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
		$criteria->compare('LOWER(tm)', strtolower($this->tm), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->compare('kelastindakan_id', $this->kelastindakan_id);
		$criteria->compare('LOWER(kelastindakan_nama)', strtolower($this->kelastindakan_nama), true);
		$criteria->compare('ruangantindakan_id', $this->ruangantindakan_id);
		$criteria->compare('LOWER(ruangantindakan_nama)', strtolower($this->ruangantindakan_nama), true);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		$criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
		$criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
		$criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
		$criteria->compare('caramasuk_id', $this->caramasuk_id);
		$criteria->compare('LOWER(tgladmisi)', strtolower($this->tgladmisi), true);
		$criteria->compare('daftartindakan_visite', $this->daftartindakan_visite);
		$criteria->compare('daftartindakan_konsul', $this->daftartindakan_konsul);
		$criteria->compare('daftartindakan_tindakan', $this->daftartindakan_tindakan);
		$criteria->compare('daftartindakan_akomodasi', $this->daftartindakan_akomodasi);
		$criteria->compare('daftartindakan_observasi', $this->daftartindakan_observasi);
		$criteria->compare('LOWER(tglpasienpulang)', strtolower($this->tglpasienpulang), true);
		$criteria->compare('LOWER(carakeluar)', strtolower($this->carakeluar), true);
		$criteria->compare('LOWER(kondisipulang)', strtolower($this->kondisipulang), true);
		$criteria->compare('LOWER(ruanganakhir_nama)', strtolower($this->ruanganakhir_nama), true);
		$criteria->compare('ruanganakhir_id', $this->ruanganakhir_id);
		$criteria->compare('LOWER(penerimapasien)', strtolower($this->penerimapasien), true);
		$criteria->compare('lamarawat', $this->lamarawat);
		$criteria->compare('jumlahuangmuka', $this->jumlahuangmuka);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
	public function getNamaPasienPendaftar()
	{
		return $this->namadepan . ' ' . $this->nama_pasien;
	}
	public function getAlamatPasienPendaftar()
	{
		return $this->alamat_pasien . ' Rt/Rw. ' . $this->rt . ' / ' . $this->rw;
	}
	public function getDokterPemeriksa()
	{
		return $this->gelardepan . ' ' . $this->nama_pegawai . ' ' . $this->gelarbelakang_nama;
	}
	public function getCarabayarPenjamin()
	{
		return $this->carabayar_nama . ' / ' . $this->penjamin_nama;
	}
}

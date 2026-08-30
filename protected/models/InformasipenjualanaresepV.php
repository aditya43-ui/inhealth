<?php

/**
 * This is the model class for table "informasipenjualanaresep_v".
 *
 * The followings are the available columns in table 'informasipenjualanaresep_v':
 * @property integer $pasien_id
 * @property string $no_rekam_medik
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $nama_bin
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property integer $rt
 * @property integer $rw
 * @property integer $penjualanresep_id
 * @property string $jenispenjualan
 * @property string $tglresep
 * @property string $noresep
 * @property double $totharganetto
 * @property double $totalhargajual
 * @property double $totaltarifservice
 * @property double $biayaadministrasi
 * @property double $biayakonseling
 * @property double $pembulatanharga
 * @property double $jasadokterresep
 * @property string $instalasiasal_nama
 * @property string $ruanganasal_nama
 * @property integer $ruangan_id
 * @property integer $pegawai_id
 * @property string $nama_pegawai
 * @property string $gelardepan
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property string $tglpenjualan
 * @property double $discount
 * @property double $subsidiasuransi
 * @property double $subsidipemerintah
 * @property double $subsidirs
 * @property double $iurbiaya
 * @property integer $lamapelayanan
 * @property integer $pasienadmisi_id
 * @property integer $reseptur_id
 * @property integer $pendaftaran_id
 * @property integer $obatalkes_id
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_nama
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $kekuatan
 * @property integer $racikan_id
 * @property integer $shift_id
 * @property string $tglpelayanan
 * @property string $r
 * @property integer $rke
 * @property double $qty_oa
 * @property double $hargasatuan_oa
 * @property string $signa_oa
 * @property double $harganetto_oa
 * @property double $hargajual_oa
 * @property string $etiket
 * @property double $biayaservice
 * @property double $biayakemasan
 * @property string $oa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $create_ruangan
 * @property string $update_loginpemakai_id
 * @property integer $sumberdana_id
 * @property string $sumberdana_nama
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property integer $tipepaket_id
 * @property integer $oasudahbayar_id
 */
class InformasipenjualanaresepV extends CActiveRecord
{
	public $statusperiksa;
	public $data, $tick, $jumlah;
	public $ruanganpendaftaran_id;
	public $instalasipendaftaran_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipenjualanaresepV the static model class
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
		return 'informasipenjualanresep_v';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasienpegawai_id, pasien_id, rt, rw, penjualanresep_id, ruangan_id, pegawai_id, carabayar_id, penjamin_id, lamapelayanan, pasienadmisi_id, reseptur_id, pendaftaran_id, obatalkes_id, jenisobatalkes_id, kekuatan, racikan_id, shift_id, rke, sumberdana_id, satuankecil_id, tipepaket_id, oasudahbayar_id, antrianfarmasi_id', 'numerical', 'integerOnly' => true),
			array('totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, qty_oa, hargasatuan_oa, harganetto_oa, hargajual_oa, biayaservice, biayakemasan', 'numerical'),
			array('no_rekam_medik, gelardepan', 'length', 'max' => 10),
			array('namadepan, jeniskelamin, obatalkes_kadarobat', 'length', 'max' => 20),
			array('nama_pasien, noresep, nama_pegawai, carabayar_nama, penjamin_nama, jenisobatalkes_nama, obatalkes_kode, obatalkes_golongan, obatalkes_kategori, sumberdana_nama, satuankecil_nama', 'length', 'max' => 50),
			array('nama_bin, signa_oa', 'length', 'max' => 30),
			array('tempat_lahir', 'length', 'max' => 25),
			array('jenispenjualan, instalasiasal_nama, ruanganasal_nama, etiket', 'length', 'max' => 100),
			array('obatalkes_nama', 'length', 'max' => 200),
			array('r, oa', 'length', 'max' => 2),
			array('ruanganterakhir_id, tanggal_lahir, alamat_pasien, tglresep, tglpenjualan, tglpelayanan, create_time, update_time, create_loginpemakai_id, create_ruangan, update_loginpemakai_id, antrianfarmasi_id, statusobat, tglsedangdisiapkan, tglselesaidisiapkan, tglpenyerahan, namapenerimaobat, notelppenerimaobat, namaygmenyerahkan, ketpenyerahan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ruanganterakhir_id, pasien_id, no_rekam_medik, namadepan, jenisPenjualan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, penjualanresep_id, jenispenjualan, tglresep, noresep, totharganetto, totalhargajual, totaltarifservice, biayaadministrasi, biayakonseling, pembulatanharga, jasadokterresep, instalasiasal_nama, ruanganasal_nama, ruangan_id, pegawai_id, nama_pegawai, gelardepan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, tglpenjualan, discount, subsidiasuransi, subsidipemerintah, subsidirs, iurbiaya, lamapelayanan, pasienadmisi_id, reseptur_id, pendaftaran_id, obatalkes_id, jenisobatalkes_id, jenisobatalkes_nama, obatalkes_kode, obatalkes_nama, obatalkes_golongan, obatalkes_kategori, obatalkes_kadarobat, kekuatan, racikan_id, shift_id, tglpelayanan, r, rke, qty_oa, hargasatuan_oa, signa_oa, harganetto_oa, hargajual_oa, etiket, biayaservice, biayakemasan, oa, create_time, update_time, create_loginpemakai_id, create_ruangan, update_loginpemakai_id, sumberdana_id, sumberdana_nama, satuankecil_id, satuankecil_nama, tipepaket_id, oasudahbayar_id, antrianfarmasi_id, statusobat, tglsedangdisiapkan, tglselesaidisiapkan, tglpenyerahan, namapenerimaobat, notelppenerimaobat, namaygmenyerahkan, ketpenyerahan, kamarruangan_nokamar, kamarruangan_nobed, instalasiterakhir_id, kelaspelayanan_id', 'safe', 'on' => 'search'),
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
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
			'penjualanresep' => array(self::BELONGS_TO, 'PenjualanresepT', 'penjualanresep_id'),
		);
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasien_id' => 'Pasien',
			'no_rekam_medik' => 'No. Rekam Medik',
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Panggilan',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'penjualanresep_id' => 'Penjualan Resep',
			'jenispenjualan' => 'Jenis Penjualan',
			'tglresep' => 'Tanggal Resep',
			'noresep' => 'No. Penjualan',
			'totharganetto' => 'Total Harga Netto',
			'totalhargajual' => 'Total Harga Jual',
			'totaltarifservice' => 'Total Tarif Service',
			'biayaadministrasi' => 'Biaya Administrasi',
			'biayakonseling' => 'Biaya Konseling',
			'pembulatanharga' => 'Pembulatan Harga',
			'jasadokterresep' => 'Jasa Dokter Resep',
			'instalasiasal_nama' => 'Asal Instalasi',
			'ruanganasal_nama' => 'Asal Ruangan',
			'ruangan_id' => 'Ruangan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelardepan' => 'Gelar Depan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'tglpenjualan' => 'Tanggal Penjualan',
			'discount' => 'Keringanan',
			'subsidiasuransi' => 'Tanggungan Asuransi',
			'subsidipemerintah' => 'Tanggungan Pemerintah',
			'subsidirs' => 'Tanggungan Rumah Sakit',
			'iurbiaya' => 'Iur Biaya',
			'lamapelayanan' => 'Lama Pelayanan',
			'pasienadmisi_id' => 'Pasien Admisi',
			'reseptur_id' => 'Reseptur',
			'pendaftaran_id' => 'Pendaftaran',
			'obatalkes_id' => 'Obat Alkes',
			'jenisobatalkes_id' => 'Jenis Obat Alkes',
			'jenisobatalkes_nama' => 'Nama Jenis Obat Alkes',
			'obatalkes_kode' => 'Kode Obat Alkes',
			'obatalkes_nama' => 'Nama Obat Alkes',
			'obatalkes_golongan' => 'Golongan Obat Alkes',
			'obatalkes_kategori' => 'Kategori Obat Alkes',
			'obatalkes_kadarobat' => 'Kadar Obat',
			'kekuatan' => 'Kekuatan',
			'racikan_id' => 'Racikan',
			'shift_id' => 'Shift',
			'tglpelayanan' => 'Tanggal Pelayanan',
			'r' => 'R',
			'rke' => 'Rke',
			'qty_oa' => 'Jumlah Obat',
			'hargasatuan_oa' => 'Harga Satuan',
			'signa_oa' => 'Signa',
			'harganetto_oa' => 'Harga Netto',
			'hargajual_oa' => 'Harga Jual',
			'etiket' => 'Etiket',
			'biayaservice' => 'Biaya Service',
			'biayakemasan' => 'Biaya Kemasan',
			'oa' => 'Oa',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'sumberdana_id' => 'Sumberdana',
			'sumberdana_nama' => 'Nama Sumberdana',
			'satuankecil_id' => 'Satuan Kecil',
			'satuankecil_nama' => 'Nama Satuan Kecil',
			'tipepaket_id' => 'Tipe Paket',
			'oasudahbayar_id' => 'Oa Sudah Bayar',
			'noantrian' => 'No. Antrian',
			'statusperiksa' => 'Status Periksa',
			'pegawai_id' => 'Dokter',
			'instalasipendaftaran_id' => 'Instalasi',
			'ruanganpendaftaran_id' => 'Ruangan',
			'instalasiterakhir_id' => 'Instalasi Asal'
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
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
		$criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
		$criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
		$criteria->compare('rt', $this->rt);
		$criteria->compare('rw', $this->rw);
		$criteria->compare('penjualanresep_id', $this->penjualanresep_id);
		$criteria->compare('LOWER(jenispenjualan)', strtolower($this->jenispenjualan), true);
		$criteria->compare('LOWER(tglresep)', strtolower($this->tglresep), true);
		$criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
		$criteria->compare('totharganetto', $this->totharganetto);
		$criteria->compare('totalhargajual', $this->totalhargajual);
		$criteria->compare('totaltarifservice', $this->totaltarifservice);
		$criteria->compare('biayaadministrasi', $this->biayaadministrasi);
		$criteria->compare('biayakonseling', $this->biayakonseling);
		$criteria->compare('pembulatanharga', $this->pembulatanharga);
		$criteria->compare('jasadokterresep', $this->jasadokterresep);
		$criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
		$criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->compare('LOWER(tglpenjualan)', strtolower($this->tglpenjualan), true);
		$criteria->compare('LOWER(tglpenyerahan)', strtolower($this->tglpenyerahan), true);
		$criteria->compare('discount', $this->discount);
		$criteria->compare('subsidiasuransi', $this->subsidiasuransi);
		$criteria->compare('subsidipemerintah', $this->subsidipemerintah);
		$criteria->compare('subsidirs', $this->subsidirs);
		$criteria->compare('iurbiaya', $this->iurbiaya);
		$criteria->compare('lamapelayanan', $this->lamapelayanan);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('reseptur_id', $this->reseptur_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('obatalkes_id', $this->obatalkes_id);
		$criteria->compare('jenisobatalkes_id', $this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
		$criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
		$criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
		$criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
		$criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
		$criteria->compare('LOWER(obatalkes_kadarobat)', strtolower($this->obatalkes_kadarobat), true);
		$criteria->compare('kekuatan', $this->kekuatan);
		$criteria->compare('racikan_id', $this->racikan_id);
		$criteria->compare('shift_id', $this->shift_id);
		$criteria->compare('LOWER(tglpelayanan)', strtolower($this->tglpelayanan), true);
		$criteria->compare('LOWER(r)', strtolower($this->r), true);
		$criteria->compare('rke', $this->rke);
		$criteria->compare('qty_oa', $this->qty_oa);
		$criteria->compare('hargasatuan_oa', $this->hargasatuan_oa);
		$criteria->compare('LOWER(signa_oa)', strtolower($this->signa_oa), true);
		$criteria->compare('harganetto_oa', $this->harganetto_oa);
		$criteria->compare('hargajual_oa', $this->hargajual_oa);
		$criteria->compare('LOWER(etiket)', strtolower($this->etiket), true);
		$criteria->compare('biayaservice', $this->biayaservice);
		$criteria->compare('biayakemasan', $this->biayakemasan);
		$criteria->compare('LOWER(oa)', strtolower($this->oa), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('sumberdana_id', $this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)', strtolower($this->sumberdana_nama), true);
		$criteria->compare('satuankecil_id', $this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)', strtolower($this->satuankecil_nama), true);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('oasudahbayar_id', $this->oasudahbayar_id);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria = new CDbCriteria;
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
		$criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
		$criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
		$criteria->compare('rt', $this->rt);
		$criteria->compare('rw', $this->rw);
		$criteria->compare('penjualanresep_id', $this->penjualanresep_id);
		$criteria->compare('LOWER(jenispenjualan)', strtolower($this->jenispenjualan), true);
		$criteria->compare('LOWER(tglresep)', strtolower($this->tglresep), true);
		$criteria->compare('LOWER(noresep)', strtolower($this->noresep), true);
		$criteria->compare('totharganetto', $this->totharganetto);
		$criteria->compare('totalhargajual', $this->totalhargajual);
		$criteria->compare('totaltarifservice', $this->totaltarifservice);
		$criteria->compare('biayaadministrasi', $this->biayaadministrasi);
		$criteria->compare('biayakonseling', $this->biayakonseling);
		$criteria->compare('pembulatanharga', $this->pembulatanharga);
		$criteria->compare('jasadokterresep', $this->jasadokterresep);
		$criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
		$criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->compare('LOWER(tglpenjualan)', strtolower($this->tglpenjualan), true);
		$criteria->compare('LOWER(tglpenyerahan)', strtolower($this->tglpenyerahan), true);
		$criteria->compare('discount', $this->discount);
		$criteria->compare('subsidiasuransi', $this->subsidiasuransi);
		$criteria->compare('subsidipemerintah', $this->subsidipemerintah);
		$criteria->compare('subsidirs', $this->subsidirs);
		$criteria->compare('iurbiaya', $this->iurbiaya);
		$criteria->compare('lamapelayanan', $this->lamapelayanan);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('reseptur_id', $this->reseptur_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('obatalkes_id', $this->obatalkes_id);
		$criteria->compare('jenisobatalkes_id', $this->jenisobatalkes_id);
		$criteria->compare('LOWER(jenisobatalkes_nama)', strtolower($this->jenisobatalkes_nama), true);
		$criteria->compare('LOWER(obatalkes_kode)', strtolower($this->obatalkes_kode), true);
		$criteria->compare('LOWER(obatalkes_nama)', strtolower($this->obatalkes_nama), true);
		$criteria->compare('LOWER(obatalkes_golongan)', strtolower($this->obatalkes_golongan), true);
		$criteria->compare('LOWER(obatalkes_kategori)', strtolower($this->obatalkes_kategori), true);
		$criteria->compare('LOWER(obatalkes_kadarobat)', strtolower($this->obatalkes_kadarobat), true);
		$criteria->compare('kekuatan', $this->kekuatan);
		$criteria->compare('racikan_id', $this->racikan_id);
		$criteria->compare('shift_id', $this->shift_id);
		$criteria->compare('LOWER(tglpelayanan)', strtolower($this->tglpelayanan), true);
		$criteria->compare('LOWER(r)', strtolower($this->r), true);
		$criteria->compare('rke', $this->rke);
		$criteria->compare('qty_oa', $this->qty_oa);
		$criteria->compare('hargasatuan_oa', $this->hargasatuan_oa);
		$criteria->compare('LOWER(signa_oa)', strtolower($this->signa_oa), true);
		$criteria->compare('harganetto_oa', $this->harganetto_oa);
		$criteria->compare('hargajual_oa', $this->hargajual_oa);
		$criteria->compare('LOWER(etiket)', strtolower($this->etiket), true);
		$criteria->compare('biayaservice', $this->biayaservice);
		$criteria->compare('biayakemasan', $this->biayakemasan);
		$criteria->compare('LOWER(oa)', strtolower($this->oa), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('sumberdana_id', $this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)', strtolower($this->sumberdana_nama), true);
		$criteria->compare('satuankecil_id', $this->satuankecil_id);
		$criteria->compare('LOWER(satuankecil_nama)', strtolower($this->satuankecil_nama), true);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('oasudahbayar_id', $this->oasudahbayar_id);
		// Klo limit lebih kecil dari nol itu berarti ga ada limit 
		$criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}
	public function getStatus($status)
	{
		$status = trim($status);
		if ($status == "ANTRIAN") {
			$status = '<a  class="btn btn-primary nohover" name="yt1">' . $status . '</a>';
		} else if ($status == "SEDANG PERIKSA") {
			$status = '<a  class="btn btn-danger nohover" name="yt1">' . $status . '</a>';
		} else if ($status == "SUDAH PULANG") {
			$status = '<a  class="btn btn-danger-yellow nohover" name="yt1">' . $status . '</a>';
		} else if ($status == "SUDAH DI PERIKSA") {
			$status = '<a class="btn btn-danger-red nohover" name="yt1" >' . $status . '</a>';
		} else {
			$status = '<a  class="btn btn-danger-blue nohover"  name="yt1">' . $status . '</a>';
		}
		return $status;
	}
}

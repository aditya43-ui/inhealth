<?php

/**
 * This is the model class for table "infopasienkarcis_v".
 *
 * The followings are the available columns in table 'infopasienkarcis_v':
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
 * @property integer $pekerjaan_id
 * @property string $pekerjaan_nama
 * @property integer $suku_id
 * @property string $suku_nama
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
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $carabayar_id
 * @property string $carabayar_nama
 * @property integer $penjamin_id
 * @property string $penjamin_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $tindakanpelayanan_id
 * @property integer $shift_id
 * @property string $shift_nama
 * @property integer $tipepaket_id
 * @property string $tipepaket_nama
 * @property integer $daftartindakan_id
 * @property string $daftartindakan_kode
 * @property string $daftartindakan_nama
 * @property integer $karcis_id
 * @property string $karcis_nama
 * @property integer $pasienmasukpenunjang_id
 * @property string $no_masukpenunjang
 * @property string $tglmasukpenunjang
 * @property integer $pasienadmisi_id
 * @property string $tgladmisi
 * @property integer $caramasuk_id
 * @property string $caramasuk_nama
 * @property string $tgl_tindakan
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
 * @property integer $kelastanggungan_id
 * @property string $kelastanggungan_nama
 * @property double $pembebasan_tindakan
 * @property double $subsidiasuransi_tindakan
 * @property double $subsidipemerintah_tindakan
 * @property double $subsisidirumahsakit_tindakan
 * @property double $iurbiaya_tindakan
 * @property string $tm
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $verifikasitagihan_id
 * @property integer $jurnalrekening_id
 * @property string $keterangantindakan
 * @property integer $tindakansudahbayar_id
 */
class InfopasienkarcisV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopasienkarcisV the static model class
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
		return 'infopasienkarcis_v';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pekerjaan_id, suku_id, pendaftaran_id, jeniskasuspenyakit_id, instalasi_id, ruangan_id, carabayar_id, penjamin_id, kelaspelayanan_id, tindakanpelayanan_id, shift_id, tipepaket_id, daftartindakan_id, karcis_id, pasienmasukpenunjang_id, pasienadmisi_id, caramasuk_id, qty_tindakan, kelastanggungan_id, verifikasitagihan_id, jurnalrekening_id, tindakansudahbayar_id', 'numerical', 'integerOnly' => true),
			array('tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, tarif_satuan, tarif_tindakan, tarifcyto_tindakan, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan', 'numerical'),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran, daftartindakan_kode, no_masukpenunjang', 'length', 'max' => 20),
			array('no_identitas_pasien, nama_bin, umur', 'length', 'max' => 30),
			array('nama_pasien, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, suku_nama, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, instalasi_nama, ruangan_nama, carabayar_nama, penjamin_nama, kelaspelayanan_nama, shift_nama, tipepaket_nama, caramasuk_nama, kelastanggungan_nama', 'length', 'max' => 50),
			array('tempat_lahir', 'length', 'max' => 25),
			array('golongandarah, tm', 'length', 'max' => 2),
			array('photopasien, daftartindakan_nama, keterangantindakan', 'length', 'max' => 200),
			array('alamatemail, jeniskasuspenyakit_nama, karcis_nama', 'length', 'max' => 100),
			array('statusrekammedis, no_rekam_medik, satuantindakan', 'length', 'max' => 10),
			array('no_urutantri', 'length', 'max' => 6),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, tglmasukpenunjang, tgladmisi, tgl_tindakan, cyto_tindakan, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pekerjaan_id, pekerjaan_nama, suku_id, suku_nama, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, instalasi_id, instalasi_nama, ruangan_id, ruangan_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, kelaspelayanan_id, kelaspelayanan_nama, tindakanpelayanan_id, shift_id, shift_nama, tipepaket_id, tipepaket_nama, daftartindakan_id, daftartindakan_kode, daftartindakan_nama, karcis_id, karcis_nama, pasienmasukpenunjang_id, no_masukpenunjang, tglmasukpenunjang, pasienadmisi_id, tgladmisi, caramasuk_id, caramasuk_nama, tgl_tindakan, tarif_rsakomodasi, tarif_medis, tarif_paramedis, tarif_bhp, tarif_satuan, tarif_tindakan, satuantindakan, qty_tindakan, cyto_tindakan, tarifcyto_tindakan, kelastanggungan_id, kelastanggungan_nama, pembebasan_tindakan, subsidiasuransi_tindakan, subsidipemerintah_tindakan, subsisidirumahsakit_tindakan, iurbiaya_tindakan, tm, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, verifikasitagihan_id, jurnalrekening_id, keterangantindakan, tindakansudahbayar_id', 'safe', 'on' => 'search'),
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
			'tgl_rekam_medik' => 'Tgl. Rekam Medik',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Propinsi Nama',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten Nama',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan Nama',
			'pekerjaan_id' => 'Pekerjaan',
			'pekerjaan_nama' => 'Pekerjaan Nama',
			'suku_id' => 'Suku',
			'suku_nama' => 'Suku Nama',
			'pendaftaran_id' => 'Pendaftaran',
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
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'tindakanpelayanan_id' => 'Tindakanpelayanan',
			'shift_id' => 'Shift',
			'shift_nama' => 'Shift Nama',
			'tipepaket_id' => 'Tipepaket',
			'tipepaket_nama' => 'Tipepaket Nama',
			'daftartindakan_id' => 'Daftartindakan',
			'daftartindakan_kode' => 'Daftartindakan Kode',
			'daftartindakan_nama' => 'Nama Daftar Tindakan',
			'karcis_id' => 'Karcis',
			'karcis_nama' => 'Karcis Nama',
			'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
			'no_masukpenunjang' => 'No. Masukpenunjang',
			'tglmasukpenunjang' => 'Tglmasukpenunjang',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tgladmisi' => 'Tgladmisi',
			'caramasuk_id' => 'Caramasuk',
			'caramasuk_nama' => 'Caramasuk Nama',
			'tgl_tindakan' => 'Tgl. Tindakan',
			'tarif_rsakomodasi' => 'Tarif Rsakomodasi',
			'tarif_medis' => 'Tarif Medis',
			'tarif_paramedis' => 'Tarif Paramedis',
			'tarif_bhp' => 'Tarif Bhp',
			'tarif_satuan' => 'Tarif Satuan',
			'tarif_tindakan' => 'Nominal Tarif',
			'satuantindakan' => 'Satuantindakan',
			'qty_tindakan' => 'Jumlah Tindakan',
			'cyto_tindakan' => 'Cyto Tindakan',
			'tarifcyto_tindakan' => 'Tarifcyto Tindakan',
			'kelastanggungan_id' => 'Kelastanggungan',
			'kelastanggungan_nama' => 'Kelastanggungan Nama',
			'pembebasan_tindakan' => 'Pembebasan Tindakan',
			'subsidiasuransi_tindakan' => 'Tanggungan Asuransi Tindakan',
			'subsidipemerintah_tindakan' => 'Tanggungan Pemerintah Tindakan',
			'subsisidirumahsakit_tindakan' => 'Tanggungan Rumah Sakit Tindakan',
			'iurbiaya_tindakan' => 'Iurbiaya Tindakan',
			'tm' => 'Tm',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'verifikasitagihan_id' => 'Verifikasitagihan',
			'jurnalrekening_id' => 'Jurnalrekening',
			'keterangantindakan' => 'Keterangantindakan',
			'tindakansudahbayar_id' => 'Tindakansudahbayar',
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
		$criteria->compare('jenisidentitas', $this->jenisidentitas, true);
		$criteria->compare('no_identitas_pasien', $this->no_identitas_pasien, true);
		$criteria->compare('namadepan', $this->namadepan, true);
		$criteria->compare('nama_pasien', $this->nama_pasien, true);
		$criteria->compare('nama_bin', $this->nama_bin, true);
		$criteria->compare('jeniskelamin', $this->jeniskelamin, true);
		$criteria->compare('tempat_lahir', $this->tempat_lahir, true);
		$criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
		$criteria->compare('alamat_pasien', $this->alamat_pasien, true);
		$criteria->compare('rt', $this->rt);
		$criteria->compare('rw', $this->rw);
		$criteria->compare('agama', $this->agama, true);
		$criteria->compare('golongandarah', $this->golongandarah, true);
		$criteria->compare('photopasien', $this->photopasien, true);
		$criteria->compare('alamatemail', $this->alamatemail, true);
		$criteria->compare('statusrekammedis', $this->statusrekammedis, true);
		$criteria->compare('statusperkawinan', $this->statusperkawinan, true);
		$criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
		$criteria->compare('tgl_rekam_medik', $this->tgl_rekam_medik, true);
		$criteria->compare('propinsi_id', $this->propinsi_id);
		$criteria->compare('propinsi_nama', $this->propinsi_nama, true);
		$criteria->compare('kabupaten_id', $this->kabupaten_id);
		$criteria->compare('kabupaten_nama', $this->kabupaten_nama, true);
		$criteria->compare('kelurahan_id', $this->kelurahan_id);
		$criteria->compare('kelurahan_nama', $this->kelurahan_nama, true);
		$criteria->compare('kecamatan_id', $this->kecamatan_id);
		$criteria->compare('kecamatan_nama', $this->kecamatan_nama, true);
		$criteria->compare('pekerjaan_id', $this->pekerjaan_id);
		$criteria->compare('pekerjaan_nama', $this->pekerjaan_nama, true);
		$criteria->compare('suku_id', $this->suku_id);
		$criteria->compare('suku_nama', $this->suku_nama, true);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('no_pendaftaran', $this->no_pendaftaran, true);
		$criteria->compare('tgl_pendaftaran', $this->tgl_pendaftaran, true);
		$criteria->compare('no_urutantri', $this->no_urutantri, true);
		$criteria->compare('transportasi', $this->transportasi, true);
		$criteria->compare('keadaanmasuk', $this->keadaanmasuk, true);
		$criteria->compare('statusperiksa', $this->statusperiksa, true);
		$criteria->compare('statuspasien', $this->statuspasien, true);
		$criteria->compare('kunjungan', $this->kunjungan, true);
		$criteria->compare('alihstatus', $this->alihstatus);
		$criteria->compare('byphone', $this->byphone);
		$criteria->compare('kunjunganrumah', $this->kunjunganrumah);
		$criteria->compare('statusmasuk', $this->statusmasuk, true);
		$criteria->compare('umur', $this->umur, true);
		$criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama', $this->jeniskasuspenyakit_nama, true);
		$criteria->compare('instalasi_id', $this->instalasi_id);
		$criteria->compare('instalasi_nama', $this->instalasi_nama, true);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('ruangan_nama', $this->ruangan_nama, true);
		$criteria->compare('carabayar_id', $this->carabayar_id);
		$criteria->compare('carabayar_nama', $this->carabayar_nama, true);
		$criteria->compare('penjamin_id', $this->penjamin_id);
		$criteria->compare('penjamin_nama', $this->penjamin_nama, true);
		$criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama', $this->kelaspelayanan_nama, true);
		$criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
		$criteria->compare('shift_id', $this->shift_id);
		$criteria->compare('shift_nama', $this->shift_nama, true);
		$criteria->compare('tipepaket_id', $this->tipepaket_id);
		$criteria->compare('tipepaket_nama', $this->tipepaket_nama, true);
		$criteria->compare('daftartindakan_id', $this->daftartindakan_id);
		$criteria->compare('daftartindakan_kode', $this->daftartindakan_kode, true);
		$criteria->compare('daftartindakan_nama', $this->daftartindakan_nama, true);
		$criteria->compare('karcis_id', $this->karcis_id);
		$criteria->compare('karcis_nama', $this->karcis_nama, true);
		$criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
		$criteria->compare('no_masukpenunjang', $this->no_masukpenunjang, true);
		$criteria->compare('tglmasukpenunjang', $this->tglmasukpenunjang, true);
		$criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
		$criteria->compare('tgladmisi', $this->tgladmisi, true);
		$criteria->compare('caramasuk_id', $this->caramasuk_id);
		$criteria->compare('caramasuk_nama', $this->caramasuk_nama, true);
		$criteria->compare('tgl_tindakan', $this->tgl_tindakan, true);
		$criteria->compare('tarif_rsakomodasi', $this->tarif_rsakomodasi);
		$criteria->compare('tarif_medis', $this->tarif_medis);
		$criteria->compare('tarif_paramedis', $this->tarif_paramedis);
		$criteria->compare('tarif_bhp', $this->tarif_bhp);
		$criteria->compare('tarif_satuan', $this->tarif_satuan);
		$criteria->compare('tarif_tindakan', $this->tarif_tindakan);
		$criteria->compare('satuantindakan', $this->satuantindakan, true);
		$criteria->compare('qty_tindakan', $this->qty_tindakan);
		$criteria->compare('cyto_tindakan', $this->cyto_tindakan);
		$criteria->compare('tarifcyto_tindakan', $this->tarifcyto_tindakan);
		$criteria->compare('kelastanggungan_id', $this->kelastanggungan_id);
		$criteria->compare('kelastanggungan_nama', $this->kelastanggungan_nama, true);
		$criteria->compare('pembebasan_tindakan', $this->pembebasan_tindakan);
		$criteria->compare('subsidiasuransi_tindakan', $this->subsidiasuransi_tindakan);
		$criteria->compare('subsidipemerintah_tindakan', $this->subsidipemerintah_tindakan);
		$criteria->compare('subsisidirumahsakit_tindakan', $this->subsisidirumahsakit_tindakan);
		$criteria->compare('iurbiaya_tindakan', $this->iurbiaya_tindakan);
		$criteria->compare('tm', $this->tm, true);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);
		$criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
		$criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);
		$criteria->compare('create_ruangan', $this->create_ruangan, true);
		$criteria->compare('verifikasitagihan_id', $this->verifikasitagihan_id);
		$criteria->compare('jurnalrekening_id', $this->jurnalrekening_id);
		$criteria->compare('keterangantindakan', $this->keterangantindakan, true);
		$criteria->compare('tindakansudahbayar_id', $this->tindakansudahbayar_id);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}

<?php

/**
 * This is the model class for table "orderbataltindakanrad_v".
 *
 * The followings are the available columns in table 'orderbataltindakanrad_v':
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
 * @property integer $shift_id
 * @property integer $penanggungjawab_id
 * @property string $pengantar
 * @property string $hubungankeluarga
 * @property string $nama_pj
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property boolean $is_tindakan
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $jeniskasuspenyakit_id
 * @property string $jeniskasuspenyakit_nama
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property integer $pembayaranpelayanan_id
 * @property string $namaperusahaan
 * @property string $tglselesaiperiksa
 * @property string $alamat_pj
 * @property string $nopeserta
 * @property string $tglcetakkartuasuransi
 * @property string $kodefeskestk1
 * @property string $nama_feskestk1
 * @property string $masaberlakukartu
 * @property string $nokartukeluarga
 * @property string $nopassport
 * @property string $status_konfirmasi
 * @property string $tgl_konfirmasi
 * @property boolean $asuransipasien_aktif
 * @property string $tglalokasi
 * @property string $alokasidana_id
 */
class OrderbataltindakanradV extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orderbataltindakanrad_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pendaftaran_id, pekerjaan_id, carabayar_id, penjamin_id, shift_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, pembayaranpelayanan_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran', 'length', 'max'=>20),
			array('no_identitas_pasien, umur', 'length', 'max'=>30),
			array('nama_pasien, alamatemail, penjamin_nama, ruangan_nama, instalasi_nama, jeniskasuspenyakit_nama, nokartukeluarga', 'length', 'max'=>100),
			array('nama_bin, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_nama, pengantar, hubungankeluarga, nama_pj, kelaspelayanan_nama, nama_pegawai, namaperusahaan, nopeserta, kodefeskestk1, status_konfirmasi', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien, nama_feskestk1, nopassport', 'length', 'max'=>200),
			array('statusrekammedis, no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, create_time, create_loginpemakai_id, create_ruangan, is_tindakan, tglselesaiperiksa, alamat_pj, tglcetakkartuasuransi, masaberlakukartu, tgl_konfirmasi, asuransipasien_aktif, tglalokasi, alokasidana_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, create_time, create_loginpemakai_id, create_ruangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, shift_id, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, ruangan_id, ruangan_nama, is_tindakan, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, gelardepan, nama_pegawai, gelarbelakang_nama, pembayaranpelayanan_id, namaperusahaan, tglselesaiperiksa, alamat_pj, nopeserta, tglcetakkartuasuransi, kodefeskestk1, nama_feskestk1, masaberlakukartu, nokartukeluarga, nopassport, status_konfirmasi, tgl_konfirmasi, asuransipasien_aktif, tglalokasi, alokasidana_id', 'safe', 'on'=>'search'),
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
			'shift_id' => 'Shift',
			'penanggungjawab_id' => 'Penanggungjawab',
			'pengantar' => 'Pengantar',
			'hubungankeluarga' => 'Hubungankeluarga',
			'nama_pj' => 'Nama Pj',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'is_tindakan' => 'Is Tindakan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi Nama',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jeniskasuspenyakit Nama',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'pembayaranpelayanan_id' => 'Pembayaranpelayanan',
			'namaperusahaan' => 'Namaperusahaan',
			'tglselesaiperiksa' => 'Tglselesaiperiksa',
			'alamat_pj' => 'Alamat Pj',
			'nopeserta' => 'Nopeserta',
			'tglcetakkartuasuransi' => 'Tglcetakkartuasuransi',
			'kodefeskestk1' => 'Kodefeskestk1',
			'nama_feskestk1' => 'Nama Feskestk1',
			'masaberlakukartu' => 'Masaberlakukartu',
			'nokartukeluarga' => 'Nokartukeluarga',
			'nopassport' => 'Nopassport',
			'status_konfirmasi' => 'Status Konfirmasi',
			'tgl_konfirmasi' => 'Tgl Konfirmasi',
			'asuransipasien_aktif' => 'Asuransipasien Aktif',
			'tglalokasi' => 'Tglalokasi',
			'alokasidana_id' => 'Alokasidana',
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
		$criteria->compare('shift_id',$this->shift_id);
		$criteria->compare('penanggungjawab_id',$this->penanggungjawab_id);
		$criteria->compare('pengantar',$this->pengantar,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('is_tindakan',$this->is_tindakan);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('namaperusahaan',$this->namaperusahaan,true);
		$criteria->compare('tglselesaiperiksa',$this->tglselesaiperiksa,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('nopeserta',$this->nopeserta,true);
		$criteria->compare('tglcetakkartuasuransi',$this->tglcetakkartuasuransi,true);
		$criteria->compare('kodefeskestk1',$this->kodefeskestk1,true);
		$criteria->compare('nama_feskestk1',$this->nama_feskestk1,true);
		$criteria->compare('masaberlakukartu',$this->masaberlakukartu,true);
		$criteria->compare('nokartukeluarga',$this->nokartukeluarga,true);
		$criteria->compare('nopassport',$this->nopassport,true);
		$criteria->compare('status_konfirmasi',$this->status_konfirmasi,true);
		$criteria->compare('tgl_konfirmasi',$this->tgl_konfirmasi,true);
		$criteria->compare('asuransipasien_aktif',$this->asuransipasien_aktif);
		$criteria->compare('tglalokasi',$this->tglalokasi,true);
		$criteria->compare('alokasidana_id',$this->alokasidana_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderbataltindakanradV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

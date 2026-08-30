<?php

/**
 * This is the model class for table "infokunjunganmcu_v".
 *
 * The followings are the available columns in table 'infokunjunganmcu_v':
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
 */
class InfokunjunganmcuV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganmcuV the static model class
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
		return 'infokunjunganmcu_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pendaftaran_id, pekerjaan_id, carabayar_id, penjamin_id, caramasuk_id, shift_id, golonganumur_id, asalrujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, pegawai_id, pembayaranpelayanan_id, antrian_id, loket_id, loket_nourut, loket_maksantrian, pengirimanrm_id, kelompokpegawai_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran, no_rujukan', 'length', 'max'=>20),
			array('no_identitas_pasien, umur', 'length', 'max'=>30),
			array('nama_pasien, nama_bin, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_nama, penjamin_nama, caramasuk_nama, nama_perujuk, asalrujukan_nama, pengantar, hubungankeluarga, nama_pj, ruangan_nama, instalasi_nama, kelaspelayanan_nama, nama_pegawai, status_konfirmasi, loket_nama, nopeserta, kodefeskestk1, statusdokrm', 'length', 'max'=>50),
			array('tempat_lahir, golonganumur_nama', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien, nama_feskestk1, nopassport, keterangan_pendaftaran', 'length', 'max'=>200),
			array('alamatemail, jeniskasuspenyakit_nama, nokartukeluarga', 'length', 'max'=>100),
			array('statusrekammedis, no_rekam_medik, gelardepan', 'length', 'max'=>10),
			array('no_urutantri, noantrian', 'length', 'max'=>6),
			array('ruangan_singkatan', 'length', 'max'=>3),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('loket_singkatan', 'length', 'max'=>1),
			array('loket_formatnomor', 'length', 'max'=>5),
			array('tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, create_time, create_loginpemakai_id, create_ruangan, tanggal_rujukan, diagnosa_rujukan, tgl_konfirmasi, tglrenkontrol, panggilantrian, tglantrian, panggil_flaq, loket_fungsi, tglcetakkartuasuransi, masaberlakukartu, asuransipasien_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, create_time, create_loginpemakai_id, create_ruangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, caramasuk_id, caramasuk_nama, shift_id, golonganumur_id, golonganumur_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, ruangan_id, ruangan_nama, ruangan_singkatan, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, gelardepan, nama_pegawai, gelarbelakang_nama, status_konfirmasi, tgl_konfirmasi, pegawai_id, tglrenkontrol, pembayaranpelayanan_id, panggilantrian, antrian_id, tglantrian, noantrian, panggil_flaq, loket_id, loket_nama, loket_fungsi, loket_singkatan, loket_nourut, loket_formatnomor, loket_maksantrian, nopeserta, tglcetakkartuasuransi, kodefeskestk1, nama_feskestk1, masaberlakukartu, nokartukeluarga, nopassport, asuransipasien_aktif, keterangan_pendaftaran, pengirimanrm_id, statusdokrm, kelompokpegawai_id', 'safe', 'on'=>'search'),
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
            'pendaftaran'=>array(self::HAS_MANY, 'PendaftaranT','pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pasien_id' => 'Pasien',
			'jenisidentitas' => 'Jenis Identitas',
			'no_identitas_pasien' => 'No. Identitas Pasien',
			'namadepan' => 'Nama Depan',
			'nama_pasien' => 'Nama Pasien',
			'nama_bin' => 'Nama Panggilan',
			'jeniskelamin' => 'Jenis Kelamin',
			'tempat_lahir' => 'Tempat Lahir',
			'tanggal_lahir' => 'Tanggal Lahir',
			'alamat_pasien' => 'Alamat Pasien',
			'rt' => 'RT',
			'rw' => 'RW',
			'agama' => 'Agama',
			'golongandarah' => 'Golongan Darah',
			'photopasien' => 'Foto Pasien',
			'alamatemail' => 'Alamat Email',
			'statusrekammedis' => 'Status Rekam Medis',
			'statusperkawinan' => 'Status Perkawinan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
			'propinsi_id' => 'Provinsi',
			'propinsi_nama' => 'Provinsi',
			'kabupaten_id' => 'Kabupaten',
			'kabupaten_nama' => 'Kabupaten',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan',
			'kecamatan_id' => 'Kecamatan',
			'kecamatan_nama' => 'Kecamatan',
			'pendaftaran_id' => 'Pendaftaran',
			'pekerjaan_id' => 'Pekerjaan',
			'pekerjaan_nama' => 'Pekerjaan',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
			'no_urutantri' => 'No. Urut',
			'transportasi' => 'Transportasi',
			'keadaanmasuk' => 'Keadaan Masuk',
			'statusperiksa' => 'Status Periksa',
			'statuspasien' => 'Status Pasien',
			'kunjungan' => 'Kunjungan',
			'alihstatus' => 'Alihstatus',
			'byphone' => 'Byphone',
			'kunjunganrumah' => 'Kunjungan Rumah',
			'statusmasuk' => 'Status Masuk',
			'umur' => 'Umur',
			'no_asuransi' => 'No. Asuransi',
			'namapemilik_asuransi' => 'Nama Pemilik Asuransi',
			'nopokokperusahaan' => 'No. Pokok Perusahaan',
			'create_time' => 'Waktu Create',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Dokter',
			'gelarbelakang_nama' => 'Gelar Belakang',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Jenis Penjamin',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin',
			'caramasuk_id' => 'Caramasuk',
			'caramasuk_nama' => 'Cara Masuk',
			'shift_id' => 'Shift',
			'golonganumur_id' => 'Golonganumur',
			'golonganumur_nama' => 'Golongan Umur',
			'no_rujukan' => 'No. Rujukan',
			'nama_perujuk' => 'Perujuk',
			'tanggal_rujukan' => 'Tanggal Rujukan',
			'diagnosa_rujukan' => 'Diagnosa Rujukan',
			'asalrujukan_id' => 'Asal Rujukan',
			'asalrujukan_nama' => 'Asal Rujukan',
			'penanggungjawab_id' => 'Penanggungjawab',
			'pengantar' => 'Pengantar',
			'hubungankeluarga' => 'Hubungan Keluarga',
			'nama_pj' => 'Nama Pj',
			'ruangan_id' => 'Poliklinik',
			'ruangan_nama' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'jeniskasuspenyakit_id' => 'Jenis Kasus Penyakit',
			'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit',
			'kelaspelayanan_id' => 'Kelas Pelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
                        'RTRW' => 'RT/RW',
                        'tgl_awal'=>'Tanggal Pendaftaran Dari',
                        'tgl_akhir'=>'Sampai Dengan',
                        'NamaNamaBIN'=>'Nama Pasien',
                        'noantrian'=>'No. Antrian',
                        'pegawai_id'=>'Dokter Pemeriksa',
                        'rujukandari_id'=>'Rujukan',
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
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('ruangan_singkatan',$this->ruangan_singkatan,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('instalasi_nama',$this->instalasi_nama,true);
		$criteria->compare('jeniskasuspenyakit_id',$this->jeniskasuspenyakit_id);
		$criteria->compare('jeniskasuspenyakit_nama',$this->jeniskasuspenyakit_nama,true);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('gelardepan',$this->gelardepan,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('gelarbelakang_nama',$this->gelarbelakang_nama,true);
		$criteria->compare('status_konfirmasi',$this->status_konfirmasi,true);
		$criteria->compare('tgl_konfirmasi',$this->tgl_konfirmasi,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('tglrenkontrol',$this->tglrenkontrol,true);
		$criteria->compare('pembayaranpelayanan_id',$this->pembayaranpelayanan_id);
		$criteria->compare('panggilantrian',$this->panggilantrian);
		$criteria->compare('antrian_id',$this->antrian_id);
		$criteria->compare('tglantrian',$this->tglantrian,true);
		$criteria->compare('noantrian',$this->noantrian,true);
		$criteria->compare('panggil_flaq',$this->panggil_flaq);
		$criteria->compare('loket_id',$this->loket_id);
		$criteria->compare('loket_nama',$this->loket_nama,true);
		$criteria->compare('loket_fungsi',$this->loket_fungsi,true);
		$criteria->compare('loket_singkatan',$this->loket_singkatan,true);
		$criteria->compare('loket_nourut',$this->loket_nourut);
		$criteria->compare('loket_formatnomor',$this->loket_formatnomor,true);
		$criteria->compare('loket_maksantrian',$this->loket_maksantrian);
		$criteria->compare('nopeserta',$this->nopeserta,true);
		$criteria->compare('tglcetakkartuasuransi',$this->tglcetakkartuasuransi,true);
		$criteria->compare('kodefeskestk1',$this->kodefeskestk1,true);
		$criteria->compare('nama_feskestk1',$this->nama_feskestk1,true);
		$criteria->compare('masaberlakukartu',$this->masaberlakukartu,true);
		$criteria->compare('nokartukeluarga',$this->nokartukeluarga,true);
		$criteria->compare('nopassport',$this->nopassport,true);
		$criteria->compare('asuransipasien_aktif',$this->asuransipasien_aktif);
		$criteria->compare('keterangan_pendaftaran',$this->keterangan_pendaftaran,true);
		$criteria->compare('pengirimanrm_id',$this->pengirimanrm_id);
		$criteria->compare('statusdokrm',$this->statusdokrm,true);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
}
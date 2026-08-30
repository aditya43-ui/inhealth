<?php

/**
 * This is the model class for table "infokunjunganrj_v".
 *
 * The followings are the available columns in table 'infokunjunganrj_v':
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
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
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
 */
class InfokunjunganrdV extends CActiveRecord
{
        public $tgl_awal;
        public $tgl_akhir;
        public $pilihanx;
        public $statusBayar;
        public $pendidikan_id, $suku_id;
        public $bulan, $tahun;
        public $rujukandari_id, $pasienadmisi_id;
        public $prefix_pendaftaran;
		public $tgl_pencarian, $default;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganrdV the static model class
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
		return 'infokunjunganrd_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, propinsi_id, kabupaten_id, kelurahan_id, kecamatan_id, pendaftaran_id, pekerjaan_id, carabayar_id, penjamin_id, caramasuk_id, shift_id, golonganumur_id, asalrujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, jeniskasuspenyakit_id, kelaspelayanan_id, notriage_pasien_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, agama, statusperkawinan, no_pendaftaran', 'length', 'max'=>20),
			array('no_identitas_pasien, nama_bin, umur', 'length', 'max'=>30),
			array('nama_pasien, propinsi_nama, kabupaten_nama, kelurahan_nama, kecamatan_nama, pekerjaan_nama, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, nama_pegawai, carabayar_nama, penjamin_nama, caramasuk_nama, nama_perujuk, asalrujukan_nama, pengantar, hubungankeluarga, nama_pj, ruangan_nama, instalasi_nama, kelaspelayanan_nama', 'length', 'max'=>50),
			array('tempat_lahir, golonganumur_nama', 'length', 'max'=>25),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail, jeniskasuspenyakit_nama, no_bed_triage, no_triage_pasien', 'length', 'max'=>100),
			array('statusrekammedis, gelardepan, no_rujukan', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('gelarbelakang_nama', 'length', 'max'=>15),
			array('carakeluar, tanggal_lahir, alamat_pasien, tgl_rekam_medik, status_konfirmasi, tgl_konfirmasi, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, create_time, create_loginpemakai_id, create_ruangan, tanggal_rujukan, diagnosa_rujukan, pegawai_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('carakeluar, statusBayar, pilihanx, tgl_awal, pendidikan_id, suku_id,  tgl_akhir, pasien_id, status_konfirmasi, tgl_konfirmasi, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, agama, golongandarah, photopasien, alamatemail, statusrekammedis, statusperkawinan, no_rekam_medik, tgl_rekam_medik, propinsi_id, propinsi_nama, kabupaten_id, kabupaten_nama, kelurahan_id, kelurahan_nama, kecamatan_id, kecamatan_nama, pendaftaran_id, pekerjaan_id, pekerjaan_nama, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, create_time, create_loginpemakai_id, create_ruangan, gelardepan, nama_pegawai, gelarbelakang_nama, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, caramasuk_id, caramasuk_nama, shift_id, golonganumur_id, golonganumur_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, jeniskasuspenyakit_id, jeniskasuspenyakit_nama, kelaspelayanan_id, kelaspelayanan_nama, pegawai_id, no_rekam_medik', 'safe', 'on'=>'search'),
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
                    'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
		);
	}
    public function primaryKey() {
        return 'pendaftaran_id';
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
			'statusrekammedis' => 'Statusrekammedis',
			'statusperkawinan' => 'Statusperkawinan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
			'propinsi_id' => 'Propinsi',
			'propinsi_nama' => 'Propinsi',
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
			'create_loginpemakai_id' => 'Petugas Loket',
			'create_ruangan' => 'Create Ruangan',
			'gelardepan' => 'Gelardepan',
                        'pegawai_id' => 'Dokter Pemeriksa',
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
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan',
			'instalasi_id' => 'Instalasi',
			'instalasi_nama' => 'Instalasi',
			'jeniskasuspenyakit_id' => 'Jeniskasuspenyakit',
			'jeniskasuspenyakit_nama' => 'Jenis Kasus Penyakit',
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelas Pelayanan',
			'RTRW' => 'RT/RW',
			'tgl_awal'=>'Tanggal Pendaftaran Dari',
			'tgl_akhir'=>'Sampai Dengan',
			'NamaNamaBIN'=>'Nama Pasien',
			'statusperiksa'=>'Status Periksa',
			'rujukandari_id'=>'Rujukan',
			'carakeluar_id' => 'Cara Keluar',
			'kondisikeluar_id' => 'Kondisi Keluar' 
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
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
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
//		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
                $criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
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
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
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
                
//		$criteria->compare('LOWER(status_konfirmasi)',strtolower($this->status_konfirmasi),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
//		RND-6941 Format Tanggal di rubah di grid viewnya.
//        protected function afterFind(){
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//
//                if (!strlen($this->$columnName)) continue;
//
//                if ($column->dbType == 'date'){                         
//                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
//                        }elseif ($column->dbType == 'timestamp without time zone'){
//                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
//                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
//                        }
//            }
//            return true;
//        }
        
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


	/**
     * searchDialogKunjunganForSPRI menampilkan pasien rumah sakit dari view database
     * @return \CActiveDataProvider
     */
    public function searchDialogKunjunganForSPRI() {
        $format = new MyFormatter;
        $model = null;
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);

        $tgl_pendaftaran = array(date('Y-m-d'), date('Y-m-d'));
        if (!empty($this->tgl_pencarian)) {
            $tgl_pendaftaran = $this->getKonverviDateRange($this->tgl_pencarian);
        }


        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $this->instalasi_id);
        }
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->addCondition('carabayar_id = ' . Params::CARABAYAR_ID_BPJS);
        $criteria->limit = 5;
        
        if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);
            $criteria->addCondition(" carakeluar_id = ".Params::CARAKELUAR_ID_RAWATINAP);
            $model = new InfokunjunganrdV;
        }else if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);
            $criteria->addCondition(" carakeluar_id = ".Params::CARAKELUAR_ID_RAWATINAP);
            $model = new InfokunjunganrjV;
        }else {
            $criteria->addBetweenCondition('DATE(tgladmisi)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);
            $model = new InfokunjunganriV;
        }
        
        if (!empty($this->default)){
            $criteria->addCondition(" pendaftaran_id IS NULL ");
        }
       
        return new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSIze' => 5
            ),
            'sort'=>[
                'defaultOrder'=>'DATE(tgl_pendaftaran) DESC'
            ]
        ));
    }
    
    /**
     * searchDialogKunjunganForSPRI menampilkan pasien rumah sakit dari view database
     * @return \CActiveDataProvider
     */
    public function searchDialogKunjunganForSRK() {
        $format = new MyFormatter;
        $model = null;
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);

        $tgl_pendaftaran = array(date('Y-m-d'), date('Y-m-d'));
        if (!empty($this->tgl_pencarian)) {
            $tgl_pendaftaran = $this->getKonverviDateRange($this->tgl_pencarian);
        }


        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $this->instalasi_id);
        }
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->addCondition('carabayar_id = ' . Params::CARABAYAR_ID_BPJS);
        $criteria->limit = 10;
        
        if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);            
            $model = new InfokunjunganrdV;
        }else if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);            
            $model = new InfokunjunganrjV;
        }else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);            
            $model = new InfokunjunganhdV;
        }else if ($this->instalasi_id == Params::INSTALASI_ID_FISIOTERAPI) {
            $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);            
            $model = new PasienmasukpenunjangV;
        }else{
            $criteria->addBetweenCondition('DATE(tgladmisi)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);
            $model = new InfokunjunganriV;
        }
        
        if (!empty($this->default)){
            $criteria->addCondition(" pendaftaran_id IS NULL ");
        }
       
        return new CActiveDataProvider($model, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSIze' => 10
            ),
            'sort'=>[
                'defaultOrder'=>'DATE(tgl_pendaftaran) DESC'
            ]
        ));
    }

    public function searchDialogKunjunganForSinkronSEP() {
		$format = new MyFormatter;
		$model = null;
		$criteria = new CDbCriteria();
		$criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);

		$tgl_pendaftaran = array(date('Y-m-d'), date('Y-m-d'));
		if (!empty($this->tgl_pencarian)) {
			$tgl_pendaftaran = $this->getKonverviDateRange($this->tgl_pencarian);
		}


		$criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
		if (!empty($this->instalasi_id)) {
			$criteria->addCondition("t.instalasi_id = " . $this->instalasi_id);
		}
		$criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(t.instalasi_nama)', strtolower($this->instalasi_nama), true);
		$criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('LOWER(t.alamat_pasien)', strtolower($this->alamat_pasien), true);
		$criteria->addCondition('t.carabayar_id = ' . Params::CARABAYAR_ID_BPJS);
		$criteria->limit = 5;
		

		$criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";

		if ($this->instalasi_id == Params::INSTALASI_ID_RD) {
			$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);            
			$model = new InfokunjunganrdV;
		}else if ($this->instalasi_id == Params::INSTALASI_ID_RJ) {
			$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);            
			$model = new InfokunjunganrjV;
		}else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
			$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);            
			$model = new InfokunjunganhdV;
		}else if ($this->instalasi_id == Params::INSTALASI_ID_FISIOTERAPI) {
			$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);            
			$model = new PasienmasukpenunjangV;
		}else{
			$criteria->addBetweenCondition('DATE(t.tgladmisi)', $tgl_pendaftaran[0], $tgl_pendaftaran[1]);
			$model = new InfokunjunganriV;
		}
		
		if (!empty($this->default)){
			$criteria->addCondition(" t.pendaftaran_id IS NULL ");
		}
	   
		return new CActiveDataProvider($model, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSIze' => 5
			),
			'sort'=>[
				'defaultOrder'=>'DATE(t.tgl_pendaftaran) DESC'
			]
		));
	}

    public function getKonverviDateRange($tgl) {

        $Tgl = (explode(" - ", $tgl));

        $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
        $Tgl[0] = $Tgl[0]->format('Y-m-d');
        $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
        $Tgl[1] = $Tgl[1]->format('Y-m-d');


        return array($Tgl[0], $Tgl[1]);
    }

    public function searchDialogKunjungan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->order = 'tgl_pendaftaran ASC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
}
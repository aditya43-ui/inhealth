<?php

/**
 * This is the model class for table "infopasienpengunjung_v".
 *
 * The followings are the available columns in table 'infopasienpengunjung_v':
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
 * @property string $statusperkawinan
 * @property string $no_rekam_medik
 * @property string $tgl_rekam_medik
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
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property string $agama
 * @property string $golongandarah
 * @property string $photopasien
 * @property string $alamatemail
 * @property string $statusrekammedis
 * 
 * @package application.models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 * 
 */
class InfopasienpengunjungV extends CActiveRecord
{
    public $tgl_awal;
        public $tgl_akhir;
        public $penanggungJawab;
        public $nama_pegawai, $gelardepan, $gelarbelakang_nama, $pasienmasukpenunjang_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopasienpengunjungV the static model class
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
		return 'infopasienpengunjung_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, rt, rw, pendaftaran_id, carabayar_id, penjamin_id, asalrujukan_id, penanggungjawab_id, ruangan_id, instalasi_id, kelaspelayanan_id', 'numerical', 'integerOnly'=>true),
			array('jenisidentitas, namadepan, jeniskelamin, statusperkawinan, no_pendaftaran, agama', 'length', 'max'=>20),
			array('no_identitas_pasien, nama_bin, umur', 'length', 'max'=>30),
			array('nama_pasien, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, statusmasuk, no_asuransi, namapemilik_asuransi, nopokokperusahaan, carabayar_nama, penjamin_nama, nama_perujuk, asalrujukan_nama, pengantar, hubungankeluarga, nama_pj, ruangan_nama, instalasi_nama, kelaspelayanan_nama', 'length', 'max'=>50),
			array('tempat_lahir', 'length', 'max'=>25),
			array('no_rekam_medik, no_rujukan, statusrekammedis', 'length', 'max'=>10),
			array('no_urutantri', 'length', 'max'=>6),
			array('golongandarah', 'length', 'max'=>2),
			array('photopasien', 'length', 'max'=>200),
			array('alamatemail', 'length', 'max'=>100),
			array('nama_pegawai, penanggungJawab, tanggal_lahir, alamat_pasien, tgl_rekam_medik, tgl_pendaftaran, alihstatus, byphone, kunjunganrumah, create_time, create_loginpemakai_id, create_ruangan, tanggal_rujukan, diagnosa_rujukan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nama_pegawai, penanggungJawab, pasien_id, jenisidentitas, no_identitas_pasien, namadepan, nama_pasien, nama_bin, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, rt, rw, statusperkawinan, no_rekam_medik, tgl_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, no_urutantri, transportasi, keadaanmasuk, statusperiksa, statuspasien, kunjungan, alihstatus, byphone, kunjunganrumah, statusmasuk, umur, no_asuransi, namapemilik_asuransi, nopokokperusahaan, create_time, create_loginpemakai_id, create_ruangan, carabayar_id, carabayar_nama, penjamin_id, penjamin_nama, no_rujukan, nama_perujuk, tanggal_rujukan, diagnosa_rujukan, asalrujukan_id, asalrujukan_nama, penanggungjawab_id, pengantar, hubungankeluarga, nama_pj, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, kelaspelayanan_id, kelaspelayanan_nama, agama, golongandarah, photopasien, alamatemail, statusrekammedis', 'safe', 'on'=>'search'),
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
                    'pj'=>array(self::BELONGS_TO, 'PenanggungjawabM', 'penanggungjawab_id'),
                    'propinsi'=>array(self::BELONGS_TO, 'PropinsiM', 'propinsi_id'),
                            'kabupaten' => array(self::BELONGS_TO, 'KabupatenM', 'kabupaten_id'),
                            'kelurahan' => array(self::BELONGS_TO, 'KelurahanM', 'kelurahan_id'),
                            'kecamatan' => array(self::BELONGS_TO, 'KecamatanM', 'kecamatan_id'),
                            'pendaftaran' => array(self::HAS_MANY, 'PendaftaranT', 'pasien_id'),
                            'kelompokumur' => array(self::BELONGS_TO, 'KelompokumurM', 'kelompokumur_id'),
                            'pekerjaan' => array(self::BELONGS_TO, 'PekerjaanM', 'pekerjaan_id'),
                            'asalrujukan'=>array(self::BELONGS_TO, 'AsalrujukanM','asalrujukan_id'),
                    'penanggungjawab'=>array(self::BELONGS_TO, 'PenanggungjawabM', 'penanggungjawab_id'),
                    'pegawai'=>array(self::BELONGS_TO, 'PegawaiM', 'dokterpenanggungjawab_id'),
                    
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
			'statusperkawinan' => 'Statusperkawinan',
			'no_rekam_medik' => 'No. Rekam Medik',
			'tgl_rekam_medik' => 'Tanggal Rekam Medik',
			'pendaftaran_id' => 'Pendaftaran',
			'no_pendaftaran' => 'No. Pendaftaran',
			'tgl_pendaftaran' => 'Tanggal Pendaftaran',
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
			'no_asuransi' => 'No. Asuransi',
			'namapemilik_asuransi' => 'Namapemilik Asuransi',
			'nopokokperusahaan' => 'Nopokokperusahaan',
			'create_time' => 'Waktu Create',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'carabayar_id' => 'Jenis Penjamin',
			'carabayar_nama' => 'Carabayar Nama',
			'penjamin_id' => 'Penjamin',
			'penjamin_nama' => 'Penjamin Nama',
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
			'kelaspelayanan_id' => 'Kelaspelayanan',
			'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
			'agama' => 'Agama',
			'golongandarah' => 'Golongandarah',
			'photopasien' => 'Photopasien',
			'alamatemail' => 'Alamatemail',
			'statusrekammedis' => 'Statusrekammedis',
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

                if (!empty($this->tgl_awal) && trim($this->tgl_awal) != "" && !empty($this->tgl_akhir) && trim($this->tgl_akhir) != "") $criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');
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
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
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
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
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
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
		$criteria->order = " tgl_pendaftaran DESC ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * untuk memfilter data, sesuai dengan prinout yang akan ditampilkan
         * @return \CActiveDataProvider
         */
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
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
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
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
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
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(photopasien)',strtolower($this->photopasien),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(statusrekammedis)',strtolower($this->statusrekammedis),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        /**
         * primary key
         * @return string
         */
        public function primaryKey() {
           return 'pendaftaran_id';
        }
        
        /**
         * menyatukan data cara bayar dan penjamin, saat akan ditampilkan
         * @return type
         */
        public function getCaraBayarPenjamin()
        {
                return $this->carabayar_nama.' / '.$this->penjamin_nama;
        }
        
        /**
         * load data cara bayar
         * @return type
         */
        public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=TRUE') ;
        }
        
        /**
         * load data penjamin
         * @return type
         */
        public function getPenjaminItems()
        {
            return PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE');
        }
        
        /**
         * load data pendidikan
         * @return type
         */
        public function getPendidikanItems()
        {
            return PendidikanM::model()->findAllByAttributes(array('pendidikan_aktif'=>true),array('order'=>'pendidikan_nama'));
        }
        
        /**
         * Mengambil daftar semua pekerjaan
         * @return CActiveDataProvider 
         */
        public function getPekerjaanItems()
        {
            return PekerjaanM::model()->findAllByAttributes(array('pekerjaan_aktif'=>true),array('order'=>'pekerjaan_nama'));
        }
        
        /**
         * Mengambil daftar semua propinsi
         * @return CActiveDataProvider 
         */
        public function getPropinsiItems()
        {
            return PropinsiM::model()->findAllByAttributes(array('propinsi_aktif'=>true),array('order'=>'propinsi_nama'));
        }
        
        /**
         * Mengambil daftar semua kabupaten berdasarkan propinsi
         * @return CActiveDataProvider 
         */
        public function getKabupatenItems($propinsi_id=null)
        {
            if(!empty($propinsi_id))
                return KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true),array('order'=>'kabupaten_nama'));
            else {
                return array();
            }
        }
        
        /**
         * Mengambil daftar semua kecamatan berdasarkan kabupaten
         * @return CActiveDataProvider 
         */
        public function getKecamatanItems($kabupaten_id=null)
        {
            if(!empty($kabupaten_id))
                return KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true),array('order'=>'kecamatan_nama'));
            else {
                return array();
            }
        }
        
        /**
         * Mengambil daftar semua kelurahan berdasarkan kecamatan
         * @return CActiveDataProvider 
         */
        public function getKelurahanItems($kecamatan_id=null)
        {
            if(!empty($kecamatan_id))
                return KelurahanM::model()->findAllByAttributes(array('kecamatan_id'=>$kecamatan_id,'kelurahan_aktif'=>true),array('order'=>'kelurahan_nama'));
            else {
                return array();
            }
        }
        
        /**
         * load data kunjungan
         * @return \CActiveDataProvider
         */
	public function searchKunjunganRuanganDialog()
	{		
		$criteria=new CDbCriteria;
		if (!empty($this->tgl_pendaftaran)) {
			$tgl_pendaftaran = $this->getKonverviDateRange($this->tgl_pendaftaran);
			$this->tgl_awal = $tgl_pendaftaran[0];
			$this->tgl_akhir = $tgl_pendaftaran[1];
		}

                if (!empty($this->tgl_awal) && trim($this->tgl_awal) != "" && !empty($this->tgl_akhir) && trim($this->tgl_akhir) != "") $criteria->addCondition('tgl_pendaftaran BETWEEN \''.$this->tgl_awal.'\' and \''.$this->tgl_akhir.'\'');		
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);		
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);	
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);				
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);	
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);	
		$criteria->addCondition(" ruangan_id = '".Yii::app()->user->getState('ruangan_id')."' ");
		$criteria->order = " tgl_pendaftaran DESC ";

		if(in_array(Yii::app()->user->getState('instalasi_id'), array(Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_IBS))){
			$model = new PasienmasukpenunjangV;
		}else{
			$model = $this;
		}
		
		return new CActiveDataProvider($model, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchDialogEresep() {            

        $criteria = new CDbCriteria;
        $criteria->select = "t.*, p.gelardepan, p.nama_pegawai, gb.gelarbelakang_nama";
        $criteria->join = " LEFT JOIN pasienadmisi_t pa ON pa.pendaftaran_id =  t.pendaftaran_id "
                . "left join pegawai_m p on p.pegawai_id = t.dokterpenanggungjawab_id "
                . "left join gelarbelakang_m gb on gb.gelarbelakang_id = p.gelarbelakang_id";
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(t.instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(t.dokterpenanggungjawab_nama)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->addCondition("t.statusperiksa NOT IN ('".Params::STATUSPERIKSA_SUDAH_PULANG."', '".Params::STATUSPERIKSA_BATAL_PERIKSA."', '".Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO."') ");
        $criteria->order = 't.tgl_pendaftaran ASC';     
        
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,            
                ));
    }

	public function getKonverviDateRange($tgl) {
		$Tgl = (explode(" - ", $tgl));

		//harus di format date dulu karena hasil dri widget tidak sama seperti format DB
		$Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
		$Tgl[0] = $Tgl[0]->format('Y-m-d');
		$Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
		$Tgl[1] = $Tgl[1]->format('Y-m-d');
		return array($Tgl[0], $Tgl[1]);
	}

	public function dokterlengkap($pegawai_id)
	{
		$hasil = '';
		if (isset($pegawai_id)) {
			$modPegawai = PegawaiM::model()->findByAttributes(array('pegawai_id' => $pegawai_id));

			if (isset($modPegawai)) {
				$modGelarDepan = GelarbelakangM::model()->findByAttributes(array('gelarbelakang_id' => $modPegawai->gelarbelakang_id));
				if (isset($modGelarDepan)) {
					$hasil = $modPegawai->gelardepan . ". " . $modPegawai->nama_pegawai . ". " . $modGelarDepan->gelarbelakang_nama;
				} else {
					$hasil = $modPegawai->gelardepan . ". " . $modPegawai->nama_pegawai;
				}
			}
		}

		return $hasil;
	}
}
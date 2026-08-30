<?php

/**
 * This is the model class for table "pegawai_m".
 *
 * The followings are the available columns in table 'pegawai_m':
 * @property integer $pegawai_id
 * @property integer $kelurahan_id
 * @property integer $kecamatan_id
 * @property integer $profilrs_id
 * @property integer $gelarbelakang_id
 *  * @property integer $gelarbelakang_nama
 * @property integer $suku_id
 * @property integer $kelompokpegawai_id
 * @property integer $pendkualifikasi_id
 * @property integer $jabatan_id
 * @property integer $pendidikan_id
 * @property integer $propinsi_id
 * @property integer $pangkat_id
 * @property integer $kabupaten_id
 * @property string $nomorindukpegawai
 * @property string $no_kartupegawainegerisipil
 * @property string $no_karis_karsu
 * @property string $no_taspen
 * @property string $no_askes
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $nama_keluarga
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property string $agama
 * @property string $golongandarah
 * @property string $rhesus
 * @property string $alamatemail
 * @property string $notelp_pegawai
 * @property string $nomobile_pegawai
 * @property string $warganegara_pegawai
 * @property string $jeniswaktukerja
 * @property string $kelompokjabatan
 * @property string $kategoripegawai
 * @property string $kategoripegawaiasal
 * @property string $photopegawai
 * @property boolean $pegawai_aktif
 * @property integer $esselon_id
 * @property integer $statuskepemilikanrumah_id
 * @property string $jenisidentitas
 * @property string $noidentitas
 * @property string $nofingerprint
 * @property double $tinggibadan
 * @property double $beratbadan
 * @property string $kemampuanbahasa
 * @property string $warnakulit
 * @property string $nip_lama
 * @property string $no_rekening
 * @property string $bank_no_rekening
 * @property string $npwp
 * @property string $tglditerima
 * @property string $tglberhenti
 * @property string $kodedokter_bpjs
 */
class PegawaiM extends CActiveRecord
{
        public $tglpenilaian;
        public $pegawai_nama;
        public $gelarbelakang_nama;
        public $dokter_pemeriksa;
        public $ruangan_id;
        public $tglpresensi;
        public $tglpresensi_akhir;
        public $hadir;
        public $izin;
        public $sakit;
        public $dinas;
        public $alpha;
        public $cuti;
        public $totalpeg;
        public $rerata_jam_keluar;
        public $rerata_jam_masuk;
        public $namapegawai;
        public $shift_id;
        public $profilperusahaan_id;
        public $statuspegawai;      
        public $umur;
        public $insentifpegawai;
		public $kelompokpegawai_nama;
		public $jabatan_nama;
		public $no_fingerprint;
		public $nama_lengkap;
		public $instalasi_id;	
        public $belakang;
        public $pasien_id;
		public $ptkp_nama;
		public $untikerja_id;
        public $norekening, $banknorekening;
        public $nilaigajipokok, $nilaithr, $nilaitetap;
        public $tglberhenti_awal, $tglberhenti_akhir;
        public $namaunitkerja;
        public $pendidikan_nama, $unitkerja_nama, $masakerja;
		public $cek_array_or_not, $array_1, $array_2;

        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiM the static model class
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
		return 'pegawai_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profilrs_id, kelompokpegawai_id, nama_pegawai, jeniskelamin, statusperkawinan, agama, tgl_lahirpegawai', 'required'),
			array('kelurahan_id, kecamatan_id, profilrs_id, gelarbelakang_id, suku_id, kelompokpegawai_id, pendkualifikasi_id, jabatan_id, pendidikan_id, propinsi_id, pangkat_id, kabupaten_id, esselon_id, statuskepemilikanrumah_id, pegawaipenghapusankemenkes, pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes', 'numerical', 'integerOnly'=>true),
			array('tinggibadan, beratbadan, gajipokok', 'numerical'),
			array('nomorindukpegawai, no_kartupegawainegerisipil, no_karis_karsu, no_taspen, no_askes, tempatlahir_pegawai, kelompokjabatan, cabang_pegawai, golongan, grade, nopeserta_asuransi', 'length', 'max'=>30),
			array('gelardepan, kategoripegawai', 'length', 'max'=>100),
			array('npwp, no_bpjs_kesehatan, no_bpjs_ketenagakerjaan, levelakses, statuspengiriman', 'length', 'max'=>20),
			array('nama_pegawai, nama_keluarga, notelp_pegawai, nomobile_pegawai, kategoripegawaiasal, jenisidentitas, deskripsi, cabang_bank, atasnama, nokontrak', 'length', 'max'=>50),
			array('jeniskelamin, statusperkawinan, agama, rhesus, jeniswaktukerja', 'length', 'max'=>100),
			array('golongandarah', 'length', 'max'=>2),
			array('create_time, update_time','default','value'=>date('Y-m-d'),'setOnEmpty'=>false,'on'=>'insert'),
			array('update_time','default','value'=>date('Y-m-d'),'setOnEmpty'=>false,'on'=>'update'),
			array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
			array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
			array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			array('alamatemail, kemampuanbahasa', 'length', 'max'=>100),
			array('warganegara_pegawai', 'length', 'max'=>25),
			array('photopegawai, alamatnpwp', 'length', 'max'=>200),
                        array('inisial, kodegroup_komponen', 'length', 'max'=>15),
                        array('keterangankontrak', 'length', 'max'=>255),
					
			array('metode_pph_21, cabang_bank', 'safe'),
			array('spesialissubspesialis_id, kodedokter_bpjs', 'safe'),
						
			array('jenispegawai, kode_negara, alamat_pegawai_ktp, unitkerja_id, nominal_sip, masa_str, masa_sip, masa_tenagasehat, masa_medis, ruangan_id, shift_id, npwp, gajipokok, tgl_lahirpegawai, no_rekening, bank_no_rekening, unit_perusahaan, suratizinpraktek, tglpenilaian, alamat_pegawai, pegawai_aktif, noidentitas, nofingerprint,warnakulit, nip_lama, tglditerima, tglberhenti,deskripsi, golonganpegawai_id, surattandaregistrasi, tglterdaftarnpwp, tglcatatkepnpwp, alamatnpwp, no_bpjs_kesehatan, no_bpjs_ketenagakerjaan, ptkp_id, kode_objekpajak, keterampilan, keahlian, minat, bakat, tglmasuk_bpjs_ketenagakerjaan, tglkeluar_bpjs_ketenagakerjaan, tglpenghapusankemenkes, tglpengiriminkemenkes, tglubahpengirimankemenkes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('jenispegawai, alamat_pegawai_ktp, nominal_sip, deskripsi, pegawai_id, unit_perusahaan, suratizinpraktek, kelurahan_id, tglpenilaian, kecamatan_id, profilrs_id, gelarbelakang_id,gelarbelakang_nama, suku_id, kelompokpegawai_id,kelompokpegawai_nama, pendkualifikasi_id, jabatan_id, pendidikan_id, propinsi_id, pangkat_id, kabupaten_id, nomorindukpegawai, no_kartupegawainegerisipil, no_karis_karsu, no_taspen, no_askes, gelardepan, nama_pegawai, nama_keluarga, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, statusperkawinan, alamat_pegawai, agama, golongandarah, rhesus, alamatemail, notelp_pegawai, nomobile_pegawai, warganegara_pegawai, jeniswaktukerja, kelompokjabatan, kategoripegawai, kategoripegawaiasal, photopegawai, pegawai_aktif, esselon_id, statuskepemilikanrumah_id, jenisidentitas, noidentitas, nofingerprint, tinggibadan, beratbadan, kemampuanbahasa, warnakulit, nip_lama, norekening, banknorekening, npwp, tglditerima, tglberhenti,gelarbelakang_nama, golonganpegawai_id, ptkp_id, kode_objekpajak, keterampilan, keahlian, minat, bakat, inisial, kodegroup_komponen, cabang_pegawai, golongan, grade, nopeserta_asuransi, cabang_bank, atasnama, nokontrak, tglmasuk_bpjs_ketenagakerjaan, tglkeluar_bpjs_ketenagakerjaan, levelakses, keterangankontrak, metode_pph_21, tglpenghapusankemenkes, tglpengiriminkemenkes, tglubahpengirimankemenkes, pegawaipenghapusankemenkes, pegawaipengirimkemenkes, pegawaiubahpengirimankemenkes, logpenghapusandatakemenkes, statuspengiriman', 'safe', 'on'=>'search'),
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

                    'jabatan' => array(self::BELONGS_TO, 'JabatanM', 'jabatan_id'),
                    'kelompokpegawai' => array(self::BELONGS_TO, 'KelompokpegawaiM', 'kelompokpegawai_id'),
                    'pangkat' => array(self::BELONGS_TO, 'PangkatM', 'pangkat_id'),
                    'pendidikan' => array(self::BELONGS_TO, 'PendidikanM', 'pendidikan_id'),
                    'gelarbelakang'=>array(self::BELONGS_TO,'GelarbelakangM','gelarbelakang_id'),
                    'suku'=>array(self::BELONGS_TO,'SukuM','suku_id'),
                    'pendkualifikasi'=>array(self::BELONGS_TO,'PendidikankualifikasiM','pendkualifikasi_id'),
                    'propinsi'=>array(self::BELONGS_TO,'PropinsiM','propinsi_id'),
                    'kabupaten'=>array(self::BELONGS_TO,'KabupatenM','kabupaten_id'),
                    'kecamatan'=>array(self::BELONGS_TO,'KecamatanM','kecamatan_id'),
                    'kelurahan'=>array(self::BELONGS_TO,'KelurahanM','kelurahan_id'),
                    'penilaiankaryawan'=>array(self::BELONGS_TO,'PenilaianpegawaiT','pegawai_id'),
                    'statuskepemilikanrumah'=>array(self::BELONGS_TO,'StatuskepemilikanrumahM','statuskepemilikanrumah_id'),
                    'golonganpegawai'=>array(self::BELONGS_TO,'GolonganpegawaiM','golonganpegawai_id'),
                    'loginpemakai'=>array(self::BELONGS_TO,'LoginpemakaiK','loginpemakai_id'),
                    'shift'=>array(self::BELONGS_TO,'ShiftM','shift_id'),
                    'ruanganpegawai'=>array(self::HAS_ONE,'RuanganpegawaiM','pegawai_id'),
                    'profilrs'=>array(self::BELONGS_TO,'ProfilrumahsakitM','profilrs_id'),
					'unitkerja'=>array(self::BELONGS_TO,'UnitkerjaM','unitkerja_id'),
					'spesialissubspesialis'=>array(self::BELONGS_TO,'SpesialissubspesialisM','spesialissubspesialis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegawai_id' => 'Pegawai',
			'kelurahan_id' => 'Kelurahan',
			'kecamatan_id' => 'Kecamatan',
			'profilrs_id' => 'Profile RS.',
			'gelarbelakang_id' => 'Gelar Belakang',
			'suku_id' => 'Suku',
			'kelompokpegawai_id' => 'Kelompok Pegawai',
			'pendkualifikasi_id' => 'Pendidikan Kualifikasi',
			'jabatan_id' => 'Jabatan',
			'pendidikan_id' => 'Pendidikan',
			'propinsi_id' => 'Provinsi',
			'pangkat_id' => 'Pangkat',
			'kabupaten_id' => 'Kabupaten',
			'nomorindukpegawai' => 'NIP',
			'no_kartupegawainegerisipil' => 'No. PNS',
			'no_karis_karsu' => 'No. Karis Karsu',
			'no_taspen' => 'No. Taspen',
			'no_askes' => 'No. Askes',
			'gelardepan' => 'Gelar Depan',
			'nama_pegawai' => 'Nama Pegawai',
			'nama_keluarga' => 'Nama Keluarga',
			'tempatlahir_pegawai' => 'Tempat Lahir',
			'tgl_lahirpegawai' => 'Tanggal Lahir',
			'jeniskelamin' => 'Jenis Kelamin',
			'statusperkawinan' => 'Status Perkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'agama' => 'Agama',
			'golongandarah' => 'Golongan Darah',
			'rhesus' => 'Rhesus',
			'alamatemail' => 'Email',
			'notelp_pegawai' => 'No. Telepon',
			'nomobile_pegawai' => 'No. HP',
			'warganegara_pegawai' => 'Warga Negara',
			'jeniswaktukerja' => 'Jenis Waktu Kerja',
			'kelompokjabatan' => 'Kelompok Jabatan',
			'kategoripegawai' => 'Kategori Pegawai',
			'kategoripegawaiasal' => 'Kategori Pegawai Asal',
			'photopegawai' => 'Photo Pegawai',
			'pegawai_aktif' => 'Aktif',
			'esselon_id' => 'Esselon',
			'statuskepemilikanrumah_id' => 'Status Kepemilikan Rumah',
			'jenisidentitas' => 'Jenis Identitas',
			'noidentitas' => 'No. Identitas',
			'nofingerprint' => 'No. Fingerprint',
			'tinggibadan' => 'Tinggi Badan',
			'beratbadan' => 'Berat Badan',
			'kemampuanbahasa' => 'Kemampuan Bahasa',
			'warnakulit' => 'Warna Kulit',
			'nip_lama' => 'Nip Lama',
			'norekening' => 'No. Rekening',
			'banknorekening' => 'Bank No. Rekening',
			'npwp' => 'NPWP',
			'tglditerima' => 'Tanggal Diterima',
			'tglberhenti' => 'Tanggal Berhenti',
			'nipsampai'=>'NIP Sampai',
			'namasampai'=>'Nama Sampai',
			'jabatansampai'=>'Jabatan Sampai',
			'kelompoksampai'=>'Kelompok Sampai',
			'unit_perusahaan'=>'Unit / Perusahaan',
			'suratizinpraktek'=>'Surat Izin Praktik',
			'deskripsi'=>'Deskripsi',
			'jenistenagamedis_id'=>'Jenis Tenaga Medis',
			'tglmasaaktifpeg'=>'Masa Aktif',
			'tglmasaaktifpeg_sd'=>'Sampai Dengan',
                        'golonganpegawai_id'=>'Golongan',
                        'ruangan_id'=>'Ruangan',
                        'tglpresensi' => 'Tanggal Awal',
                        'tglpresensi_akhir' => 'Sampai Dengan',
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'dinas' => 'Dinas',
                        'alpha' => 'Alpha',
                        'rerata_jam_masuk' => 'Rerata Jam Masuk',
                        'rerata_jam_keluar' => 'Rerata Jam Pulang',
                        'surattandaregistrasi'=>'Surat Tanda Registrasi', 
                        'shift_id' => 'Shift',
                        'gajipokok' => 'Gaji Pokok',
                        'bank_no_rekening' => 'Bank',
                        'profilperusahaan_id' => 'Profil Perusahaan',
                        'statuspegawai' => 'Status Pegawai',
                        'masa_str' => 'Masa Berlaku Surat Tanda Registrasi', 
                        'masa_sip' => 'Masa Berlaku Surat Izin Praktek', 
                        'masa_tenagasehat' => 'Masa Berlaku Tenaga Kesehatan', 
                        'masa_medis' => 'Masa Berlaku Medis', 
						'unitkerja_id' => 'Unit Kerja',
						'nominal_sip' => 'Nominal Jasa Surat Izin Praktek',
                    'alamat_pegawai_ktp'=>'Alamat KTP',
					'instalasi_id'=>'Instalasi',
                    'alamatnpwp'=>'Alamat NPWP',
                    'ptkp_id'=>'Kode PTKP',
                    'kode_objekpajak'=>'Kode Pajak',
            'jenispegawai' => 'Jenis Pegawai',
                    'inisial'=>'Inisial',
                    'levelakses'=>'Level Akses',
                    'kodegroup_komponen'=>'Kode Group Komponen',
                    'cabang_pegawai'=>'Cabang Pegawai',
                    'golongan'=>'Golongan Pegawai',
                    'grade'=>'Grade',
                    'tglmasuk_bpjs_ketenagakerjaan'=>'Tgl. Masuk BPJS',
                    'tglkeluar_bpjs_ketenagakerjaan'=>'Tgl. Keluar BPJS Tenaga Kerja',
                    'atasnama'=>'Atas Nama',
                    'cabang_bank'=>'Cabang Bank',
                    'nopeserta_asuransi'=>'No Peserta Asuransi',
					'nokontrak'=>'No. Kontrak',
					'metode_pph_21' => 'Metode PPh 21',
                    'kodedokter_bpjs'=>'Kode Dokter BPJS',
					'spesialissubspesialis_id'=>'Spesialis/Subspesialis',
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
		$criteria->join = " LEFT JOIN golonganpegawai_m gp ON gp.golonganpegawai_id = t.golonganpegawai_id "
                        . "LEFT JOIN Jabatan_m jb ON jb.jabatan_id = t.jabatan_id";
               //  var_dump($this->tgl_lahirpegawai);
		//$criteria->compare('tgl_lahirpegawai)',$this->tgl_lahirpegawai);
                if (!empty($this->tgl_lahirpegawai)){
                    $criteria->addCondition("t.tgl_lahirpegawai = '".  MyFormatter::formatDateTimeForDb($this->tgl_lahirpegawai)."' ");
                }
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.kelurahan_id',$this->kelurahan_id);
		$criteria->compare('t.kecamatan_id',$this->kecamatan_id);
		$criteria->compare('t.profilrs_id',$this->profilrs_id);
               
		$criteria->compare('t.gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('t.gelarbelakang_nama',$this->gelarbelakang_nama);
		$criteria->compare('t.suku_id',$this->suku_id);
		
		
		$criteria->compare('t.pendkualifikasi_id',$this->pendkualifikasi_id);
		
		if (!empty($this->jabatan_id)) {
			if (is_array($this->jabatan_id)){
				$criteria->addInCondition(" t.jabatan_id ", $this->jabatan_id);
			}else{
				$criteria->addCondition(" t.jabatan_id = '".$this->jabatan_id."' ");
			}
		}
                if (!empty($this->jabatan_nama)) {
                    $criteria->compare('LOWER(jb.jabatan_nama)',strtolower($this->jabatan_nama),true);
		}
                
		
		if (!empty($this->unitkerja_id)){
			if (is_array($this->unitkerja_id)){
				$criteria->addInCondition(" t.unitkerja_id ", $this->unitkerja_id);
			}else{
				$criteria->addCondition(" t.unitkerja_id = '".$this->unitkerja_id."' ");
			}
		}
		
		if (!empty($this->kelompokpegawai_id)){
			if (is_array($this->kelompokpegawai_id)){
				$criteria->addInCondition(" t.kelompokpegawai_id ", $this->kelompokpegawai_id);
			}else{
				$criteria->addCondition(" t.kelompokpegawai_id = '".$this->kelompokpegawai_id."' ");
			}
		}
		
		if (!empty($this->kategoripegawai)){
			if (is_array($this->kategoripegawai)){
				$criteria->addInCondition(" t.kategoripegawai ", $this->kategoripegawai);
			}else{
				$criteria->addCondition(" t.kategoripegawai = '".$this->kategoripegawai."' ");
			}
		}
		$criteria->compare(" t.pegawai_aktif ",$this->pegawai_aktif);
		
                if($this->pegawai_aktif != '' && $this->pegawai_aktif ==0){
                 $criteria->addBetweenCondition('date(t.tglberhenti)', $this->tglberhenti_awal, $this->tglberhenti_akhir);
                }
                
		if (!empty($this->ruangan_id)){
			$r = PegawairuanganV::model()->findAll("t.ruangan_id = '".$this->ruangan_id."' ");
			
			$id = array();
			foreach ($r as $v){
				$id[] = $v->pegawai_id;
			}
			
			$criteria->addInCondition("t.pegawai_id", $id);
		}else{
			if (!empty($this->instalasi_id)){
				
				
				$r = PegawairuanganV::model()->findAll("instalasi_id = '".$this->instalasi_id."' ");
			
				$id = array();
				foreach ($r as $v){
					$id[] = $v->pegawai_id;
				}
					$criteria->addInCondition("t.pegawai_id", $id);
				}
		}
		
		//$criteria->compare('jabatan_id',$this->jabatan_id);
		
		
		$criteria->compare('t.pendidikan_id',$this->pendidikan_id);
		$criteria->compare('t.propinsi_id',$this->propinsi_id);
		$criteria->compare('t.pangkat_id',$this->pangkat_id);
		$criteria->compare('t.kabupaten_id',$this->kabupaten_id);
		
		$criteria->compare('LOWER(t.cabang_bank)',strtolower($this->cabang_bank),true);
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(t.no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(t.no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(t.no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(t.tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
               
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(t.golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(t.rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(t.alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(t.notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(t.nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(t.warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(t.jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(t.kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		
		$criteria->compare('LOWER(t.kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(t.photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('LOWER(t.metode_pph_21)', strtolower($this->metode_pph_21),true);
		$criteria->compare('t.esselon_id',$this->esselon_id);
		$criteria->compare('t.statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(t.jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(t.noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(t.nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('t.tinggibadan',$this->tinggibadan);
		$criteria->compare('t.beratbadan',$this->beratbadan);
		$criteria->compare('t.unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('t.suratizinpraktek',$this->suratizinpraktek);
		$criteria->compare('LOWER(t.kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(t.warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(t.deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('t.golonganpegawai_id', $this->golonganpegawai_id);
		$criteria->order = 't.nama_pegawai ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                  		));
	}
        
        public function searchPegawai()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('LOWER(t.cabang_bank)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), TRUE);
		$criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), TRUE);
		if ($this->jabatan_id){
			$criteria->addCondition(" t.jabatan_id = '".$this->jabatan_id."' ");
		}
		$criteria->addCondition(" t.pegawai_aktif = TRUE ");
		$criteria->order = 't.nama_pegawai ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                  		));
	}
        
	public function searchByDokter()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('unitkerja_id', Params::UNITKERJA_ID_DOKTER);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		//$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('suratizinpraktek',$this->suratizinpraktek);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('LOWER(t.metode_pph_21)', strtolower($this->metode_pph_21),true);
		$criteria->compare('LOWER(t.cabang_bank)',strtolower($this->nama_pegawai),true);
		$criteria->order = 'pegawai_id ASC';
		//$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			//'pagination'=>false,
		));
	}        
        
	public function searchByNofinger()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if (!empty($this->pegawai_id)){
			$criteria->addInCondition("t.pegawai_id", $this->pegawai_id);
		}
		
		
		//$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('suku_id',$this->suku_id);
                if (!empty($this->kelompokpegawai_id)){
                    $criteria->addCondition('kelompokpegawai_id ='.$this->kelompokpegawai_id);
                }
		
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('suratizinpraktek',$this->suratizinpraktek);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('LOWER(t.metode_pph_21)', strtolower($this->metode_pph_21),true);
		$criteria->compare('LOWER(t.cabang_bank)',strtolower($this->cabang_bank),true);
//		$criteria->addCondition("nofingerprint IS NOT NULL");
		if (!empty($this->ruangan_id)){
			$criteria->with = array('ruanganpegawai');
			$criteria->addCondition("ruanganpegawai.ruangan_id =".$this->ruangan_id);
		}
		$criteria->order = 'nama_pegawai ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}        
        
        public function searchNoMobile()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $criteria->addCondition('TRIM(nomobile_pegawai) != \'\'');
                $criteria->addCondition('char_length(TRIM(nomobile_pegawai)) > 8');
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
                
		if (!empty($this->ruangan_id)) {
			$criteria->join = 'join ruanganpegawai_m p on p.pegawai_id = t.pegawai_id';
			$criteria->compare('p.ruangan_id', $this->ruangan_id);
		}
                

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.                
                $criteria=new CDbCriteria;
                
		if (!empty($this->pegawai_id)){
			$criteria->addInCondition("t.pegawai_id", $this->pegawai_id);
		}
		$criteria->compare('kelurahan_id',$this->kelurahan_id);
		$criteria->compare('kecamatan_id',$this->kecamatan_id);
		$criteria->compare('profilrs_id',$this->profilrs_id);
		$criteria->compare('gelarbelakang_id',$this->gelarbelakang_id);
		$criteria->compare('suku_id',$this->suku_id);
		$criteria->compare('kelompokpegawai_id',$this->kelompokpegawai_id);
		$criteria->compare('pendkualifikasi_id',$this->pendkualifikasi_id);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->compare('pendidikan_id',$this->pendidikan_id);
		$criteria->compare('propinsi_id',$this->propinsi_id);
		$criteria->compare('pangkat_id',$this->pangkat_id);
		$criteria->compare('kabupaten_id',$this->kabupaten_id);
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
		$criteria->compare('LOWER(photopegawai)',strtolower($this->photopegawai),true);
		$criteria->compare('pegawai_aktif',isset($this->pegawai_aktif)?$this->pegawai_aktif:true);
		$criteria->compare('esselon_id',$this->esselon_id);
		$criteria->compare('statuskepemilikanrumah_id',$this->statuskepemilikanrumah_id);
		$criteria->compare('LOWER(jenisidentitas)',strtolower($this->jenisidentitas),true);
		$criteria->compare('LOWER(noidentitas)',strtolower($this->noidentitas),true);
		$criteria->compare('LOWER(nofingerprint)',strtolower($this->nofingerprint),true);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('unit_perusahaan',$this->unit_perusahaan);
		$criteria->compare('suratizinpraktek',$this->suratizinpraktek);
		$criteria->compare('LOWER(kemampuanbahasa)',strtolower($this->kemampuanbahasa),true);
		$criteria->compare('LOWER(warnakulit)',strtolower($this->warnakulit),true);
		$criteria->compare('LOWER(deskripsi)',strtolower($this->deskripsi),true);
		$criteria->compare('LOWER(t.metode_pph_21)', strtolower($this->metode_pph_21),true);
		$criteria->compare('LOWER(t.cabang_bank)',strtolower($this->nama_pegawai),true);
		
		$criteria->addCondition("nofingerprint IS NOT NULL");
		if (!empty($this->ruangan_id)){
			$criteria->with = array('ruanganpegawai');
			$criteria->addCondition("ruanganpegawai.ruangan_id =".$this->ruangan_id);
		}
		$criteria->order = 'nama_pegawai ASC';

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
        }
        
   

    public function getProfilRSItems()
    {
        return ProfilrumahsakitM::model()->findAll(array('order'=>'nama_rumahsakit'));
    }     

    public function getGelarBelakangItems()
    {
        return GelarbelakangM::model()->findAll('gelarbelakang_aktif=TRUE order by gelarbelakang_nama');
    } 

    public function getSukuItems()
    {
        return SukuM::model()->findAll('suku_aktif=TRUE order by suku_nama');
    }  

    public function getkelompokPegawaiItems()
    {
        return KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif=TRUE order by kelompokpegawai_nama');
    }  

    public function getPendidikanKualifikasiItems()
    {
        return PendidikankualifikasiM::model()->findAll('pendkualifikasi_aktif=TRUE order by pendkualifikasi_nama');
    }    
    
    public function getJabatanItems()
    {
        return JabatanM::model()->findAll('jabatan_aktif=TRUE order by jabatan_nama');
    } 
	
	/**
	 * - digunakan untuk mengenerate data dropdown yang diambil dari unitkerja_m
	 * @return type
	 */
	public function getDropUnitKerjaItems()
    {
        return CHtml::listData(UnitkerjaM::model()->findAll('unitkerja_aktif=TRUE order by namaunitkerja'),'unitkerja_id','namaunitkerja');
    } 
	
	/**
	 * - digunakan untuk mengenerate data dropdown yang diambil dari kelompokpegawai_m
	 * @return type
	 */
	public function getDropKelompokPegItems()
    {
        return CHtml::listData(KelompokpegawaiM::model()->findAll('kelompokpegawai_aktif=TRUE order by kelompokpegawai_nama'),'kelompokpegawai_id','kelompokpegawai_nama');
    } 

    public function getPendidikanItems()
    {
        return PendidikanM::model()->findAll('pendidikan_aktif=TRUE order by pendidikan_nama');
    }
    
     public function getPangkatItems()
    {
        return PangkatM::model()->findAll('pangkat_aktif=TRUE order by pangkat_nama');
    } 

    public function getPropinsiItems()
    {
        return PropinsiM::model()->findAll('propinsi_aktif=TRUE order by propinsi_nama');
    }

    public function getKabupatenItems()
    {
        if(!empty($this->propinsi_id))
          {     
            return KabupatenM::model()->findAll('propinsi_id='.$this->propinsi_id.' order BY kabupaten_nama');
          }
        else  
          {
            return array();
          }  
    } 
    
    public function getItemsByInstalasi()
    {
        if(!empty($this->propinsi_id))
          {     
            return KabupatenM::model()->findAll('propinsi_id='.$this->propinsi_id.' order BY kabupaten_nama');
          }
        else  
          {
            return array();
          }  
    } 
    
     public function getKecamatanItems()
    {
       return KecamatanM::model()->findAll();
            
        
    }
    
     public function getKelurahanItems()
    {
       return KelurahanM::model()->findAll();
    }
    
    public function getLoginpemakaiItems()
    {
        return PegawaiM::model()->findAll();
    }
    
    public function getNamaLengkap()
    {
        return (isset($this->gelardepan) ? $this->gelardepan : "").' '.$this->nama_pegawai.(isset($this->gelarbelakang_id) ? ', '.$this->gelarbelakang->gelarbelakang_nama : "");
    }
    
    public function getNamaGelar()
    {
        return (isset($this->gelarbelakang->gelarbelakang_nama)? $this->gelarbelakang->gelarbelakang_nama : "");
    }
    
    public function getNamaDepanGelar()
    {
       // return $this->gelarbelakang->gelarbelakang_nama;
        return $this->gelardepan;
    }
    
    public function getNamaKelompok()
    {
        return $this->kelompokpegawai->kelompokpegawai_nama;
        
    }
    
    public function getEsselonItems()
    {
        return EsselonM::model()->findAll('esselon_aktif=TRUE ORDER BY esselon_nama');
    }
           
    public function getStatuskepemilikanrumahItems()
    {
        return StatuskepemilikanrumahM::model()->findAll('statuskepemilikanrumah_aktif=TRUE ORDER BY statuskepemilikanrumah_nama');
    }
    
    public function getGolonganPegawaiItems()
    {
        return GolonganpegawaiM::model()->findAll('golonganpegawai_aktif=TRUE ORDER BY golonganpegawai_nama');
    }
    
    public function getTotalStatusKehadiran($status_id, $pegawai_id, $tglpresensi, $tglpresensi_akhir, $kelompokjabatan=null)
    {		
        $format = new MyFormatter();
        $criteria = new CDbCriteria();		
        $criteria->select = "tglpresensi, jamkerjamasuk, statuskehadiran_id, jamkerjapulang, p.kelompokjabatan ";		
        $criteria->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id ";
        $criteria->addBetweenCondition('date(tglpresensi)', $format->formatDateTimeForDb($tglpresensi), $format->formatDateTimeForDb($tglpresensi_akhir));    
        $criteria->addCondition("p.pegawai_id = '$pegawai_id' ");		
        $criteria->addCondition("jamkerjapulang is null ");                
        $criteria->group = "tglpresensi, jamkerjamasuk, jamkerjapulang, statuskehadiran_id, p.kelompokjabatan";
        $total = PresensiT::model()->findAll($criteria);
        
        $criteria1 = new CDbCriteria();		
        $criteria1->select = "tglpresensi, jamkerjamasuk, statuskehadiran_id, jamkerjapulang, p.kelompokjabatan ";
		$criteria1->join = " JOIN pegawai_m p ON p.pegawai_id = t.pegawai_id ";
        $criteria1->addBetweenCondition('tglpresensi', $format->formatDateTimeForDb($tglpresensi), $format->formatDateTimeForDb($tglpresensi_akhir));    
        $criteria1->addCondition("p.pegawai_id = '$pegawai_id' ");
        $criteria1->addCondition("jamkerjamasuk is null ");                
        $criteria1->group = "tglpresensi, jamkerjamasuk, statuskehadiran_id, jamkerjapulang, p.kelompokjabatan";
        $total1 = PresensiT::model()->findAll($criteria1);
               
        $list1 = array();        
        foreach($total as $data){
			$jamkerjamasuk = date('H:i:s', strtotime($data->tglpresensi));
			$tgl = date('Y-m-d', strtotime($data->tglpresensi));
			
            $list1[$tgl] = array(
                'tglpresensi' => $tgl,
                'jamkerjamasuk' => $jamkerjamasuk,
                'jamkerjapulang' => $data->jamkerjapulang,
                'statuskehadiran_id' => $data->statuskehadiran_id,
				'kelompokjabatan' => $data->kelompokjabatan
            );
        }
        
        $list2 = array();        
        foreach($total1 as $data1){
			$jamkerjapulang = date('H:i:s', strtotime($data1->tglpresensi));
			$tgl = date('Y-m-d', strtotime($data1->tglpresensi));
			
				$list2[$tgl] = array(
					'tglpresensi' => $tgl,
					'jamkerjamasuk' => $data1->jamkerjamasuk,
					'jamkerjapulang' => $jamkerjapulang,
					'statuskehadiran_id' => $data1->statuskehadiran_id,				
					'kelompokjabatan' => $data1->kelompokjabatan
				);
        }
        
        $hasil = array_merge($list2, $list1);//CustomFunction::joinTwo2DArraysPresensi($list1, $list2, 'tglpresensi');
        
		
		//var_dump($hasil);
        $tot = 0;
		$totH = 0;
		$totI = 0;
		$totD = 0;		
		$totS = 0;
		
		$ms = 0;
		$pl = 0;		
		$count = count((array)$hasil);
		
		$dtH = 0;
		$dtI = 0;
		$dtD = 0;		
		$dtS = 0;
		
                /*
		//var_dump($count);
			foreach ($hasil as $hitung){
	//            if ($hitung['statuskehadiran_id'] == $status_id){
	  //              $tot = $tot + 1;
		//        }else{
		  //          $tot = $tot + 0;
			//    }
				//var_dump( $hitung['tglpresensi']);
				if ($hitung['statuskehadiran_id'] == $status_id && $hitung['statuskehadiran_id'] != Params::STATUSKEHADIRAN_ALPHA){				
					if (!empty($hitung['jamkerjamasuk'])){ 
						$dt = ShiftberlakuM::model()->cekHadir($hitung['tglpresensi'].' '.$hitung['jamkerjamasuk'], $hitung['kelompokjabatan'], 'masuk', true,$status_id);				
					}elseif (!empty($hitung['jamkerjapulang'])){		
						if ($hitung['statuskehadiran_id'] != Params::STATUSKEHADIRAN_ALPHA ){							
							$dt = ShiftberlakuM::model()->cekHadir($hitung['tglpresensi'].' '.$hitung['jamkerjapulang'], $hitung['kelompokjabatan'], 'pulang', true, $status_id);				
						}else{
							
							$dt = 0;
						}
					}else{	
						
						$dt = 0;
					}
					$tot = $tot + $dt;
					//var_dump($dt);					
				}else{
						if ($status_id == Params::STATUSKEHADIRAN_ALPHA){
							if (!empty($hitung['jamkerjamasuk'])){ 
								$dtH = ShiftberlakuM::model()->cekHadir($hitung['tglpresensi'].' '.$hitung['jamkerjamasuk'], $hitung['kelompokjabatan'], 'masuk', true,  Params::STATUSKEHADIRAN_HADIR);				
							}elseif (!empty($hitung['jamkerjapulang'])){										
								$dtH = 0;							
							}else{	

								$dtH = 0;
							}
							$totH = $totH + $dtH;
							
							if (!empty($hitung['jamkerjamasuk'])){ 
								$dtI = ShiftberlakuM::model()->cekHadir($hitung['tglpresensi'].' '.$hitung['jamkerjamasuk'], $hitung['kelompokjabatan'], 'masuk', true,  Params::STATUSKEHADIRAN_IZIN);				
							}elseif (!empty($hitung['jamkerjapulang'])){										
								$dtI = 0;							
							}else{	

								$dtI = 0;
							}
							$totI = $totI + $dtI;
							
							if (!empty($hitung['jamkerjamasuk'])){ 
								$dtD = ShiftberlakuM::model()->cekHadir($hitung['tglpresensi'].' '.$hitung['jamkerjamasuk'], $hitung['kelompokjabatan'], 'masuk', true,  Params::STATUSKEHADIRAN_DINAS);				
							}elseif (!empty($hitung['jamkerjapulang'])){										
								$dtD = 0;							
							}else{	

								$dtD = 0;
							}
							$totD = $totD + $dtD;
							
							if (!empty($hitung['jamkerjamasuk'])){ 
								$dtS = ShiftberlakuM::model()->cekHadir($hitung['tglpresensi'].' '.$hitung['jamkerjamasuk'], $hitung['kelompokjabatan'], 'masuk', true,  Params::STATUSKEHADIRAN_SAKIT);				
							}elseif (!empty($hitung['jamkerjapulang'])){										
								$dtS = 0;							
							}else{	

								$dtS = 0;
							}
							$totS = $totS + $dtS;
						/*	if (!empty($hitung['jamkerjamasuk'])){ 
								$dt1 = ShiftberlakuM::model()->cekHadir($hitung['tglpresensi'].' '.$hitung['jamkerjamasuk'], $hitung['kelompokjabatan'], 'masuk', true,$status_id);				
							}elseif (!empty($hitung['jamkerjapulang'])){		
								if ($hitung['statuskehadiran_id'] != Params::STATUSKEHADIRAN_ALPHA ){							
									$dt1 = ShiftberlakuM::model()->cekHadir($hitung['tglpresensi'].' '.$hitung['jamkerjapulang'], $hitung['kelompokjabatan'], 'pulang', true, $status_id);				
								}else{

									$dt1 = 0;
								}
							}else{	

								$dt1 = 0;
							}
							$tot1 = $tot1 + $dt1;*/
						
						
			/*			if (!empty($hitung['jamkerjamasuk'])){ 
							$pl = $pl+1;
							$dt = ShiftberlakuM::model()->cekHadirAlpha($hitung['tglpresensi'].' '.$hitung['jamkerjapulang'], $hitung['kelompokjabatan'], 'masuk', true, Params::STATUSKEHADIRAN_ALPHA, $status_id);				
						}elseif (!empty($hitung['jamkerjapulang'])){							
							$ms = $ms+1;
							$dt = ShiftberlakuM::model()->cekHadirAlpha($hitung['tglpresensi'].' '.$hitung['jamkerjapulang'], $hitung['kelompokjabatan'], 'pulang', true, Params::STATUSKEHADIRAN_ALPHA, $status_id);				
						}else{		
							
							$dt = 0;
						}
						$tot = $tot + $dt;
					}
				}																
			}
			
		if ($status_id == Params::STATUSKEHADIRAN_ALPHA){
			/*$kurang = $ms-$pl;
			//var_dump($ms.'  '.$pl);
			if ($ms >= $pl){
				if ($ms == 0){
					$tot = $pl;
				}else{
					if ($kurang == 1){
						$tot = $ms+$pl;
					}else{
						$tot = $ms;
					}
					
					
				}
				
			}elseif($ms <= $pl){
				$tot = $ms;
			}*/			
			//$tot = $count - ($totH);
		//}
			
        
        //$data
      //  foreach($total as $total){
          //  if ($total->jam)
       // }
       // $criteria1 = new CDbCriteria();
       // $criteria1->select = "tglpresensi::date,statuskehadiran_id ";
       // $criteria1->addBetweenCondition('tglpresensi', $format->formatDateTimeForDb($tglpresensi), $format->formatDateTimeForDb($tglpresensi_akhir));    
      //  $criteria1->addCondition("pegawai_id = '$pegawai_id' ");
       // $criteria1->addCondition("statuskehadiran_id = '$status_id' ");                
       // $criteria1->group = "tglpresensi::date, statuskehadiran_id";
       // $total1 = PresensiT::model()->findAll($criteria);
        
       // $selisih = count((array)$total1) - count((array)$total);
        
      //  $hasil = count((array)$total) - $selisih;
        //return  $hasil.'-'.count((array)$total1).'-'.count((array)$total);
        //return $tot;
    }
    
    public function getPendKualifikasiItems($pendidikan_id=null){
            if (!empty($pendidikan_id)){
                    return PendidikankualifikasiM::model()->findAllByAttributes (array('pendkualifikasi_aktif'=>TRUE, 'pendidikan_id'=>$pendidikan_id),array('order'=>'pendkualifikasi_nama asc'));
            } else if(!empty($this->pendidikan_id)) {
                    return PendidikankualifikasiM::model()->findAllByAttributes (array('pendkualifikasi_aktif'=>TRUE, 'pendidikan_id'=>$this->pendidikan_id),array('order'=>'pendkualifikasi_nama asc'));
            }else{
                    return array();
            }
    }
    
   public function getKelPegawaiItems($pendkualifikasi_id=null){
            if (!empty($pendkualifikasi_id)){
                    $modPendKualifikasi = PendidikankualifikasiM::model()->findByPK($pendkualifikasi_id);
                    return KelompokpegawaiM::model()->findAll("kelompokpegawai_id = ".$modPendKualifikasi->kelompokpegawai_id);
            } else if(!empty($this->pendkualifikasi_id)) {
                    $modPendKualifikasi = PendidikankualifikasiM::model()->findByPK($this->pendkualifikasi_id);
                    return KelompokpegawaiM::model()->findAll("kelompokpegawai_id = ".$modPendKualifikasi->kelompokpegawai_id);
            }else{
//				return array();
                    return KelompokpegawaiM::model()->findAll("kelompokpegawai_aktif IS TRUE ");
            }
    }
    
    public function searchPengurus() 
    {
            $criteria = new CDbCriteria;
            //$criteria->with = array('kelurahan');
            if(!empty($this->jabatan_id))$criteria->addCondition('t.jabatan_id = '.$this->jabatan_id);
            //$criteria->compare('t.jabatan_id',$this->jabatan_id);
            $criteria->compare('LOWER(nomorindukpegawai)', strtolower($this->nomorindukpegawai),true);
            $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }
   
/*
    protected function beforeValidate ()
    {
    $format = new MyFormatter();
    foreach($this->metadata->tableSchema->columns as $columnName => $column){
        if ($column->dbType == 'date'){
                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
        }elseif ($column->dbType == 'datetime'){
                $this->$columnName = date('Y-m-d H:i:s', CDateTimeParser::parse($this->$columnName, Yii::app()->locale->dateFormat));
        }

    }

    return parent::beforeValidate ();
    }

    public function beforeSave() 
    {
        if($this->tgl_lahirpegawai===null || trim($this->tgl_lahirpegawai)=='')
            {
                $this->setAttribute('tgl_lahirpegawai', null);
            } 
        if($this->tglditerima===null || trim($this->tglditerima)=='')
            {
                $this->setAttribute('tglditerima', null);
            } 
        if($this->tglberhenti===null || trim($this->tglberhenti)=='')
            {
                $this->setAttribute('tglberhenti', null);
            }
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        foreach($this->metadata->tableSchema->columns as $columnName => $column)
            {

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date')
                    {                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                    }
                elseif ($column->dbType == 'datetime')
                    {
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                    }
             }
        return true;
    }
 * 
 */
    
    public function getDropPegTriase(){
        $cri = new CDbCriteria();
    }
    
    /**
     * - digunakan untuk menampilkan total status kehadiran
     * @param type $statuskehadiran_id
     * @param type $pegawai_id
     * @param type $tgl_awal
     * @param type $tgl_akhir
     * @return type
     */
    public function getTotalStatusKehadiranV2($statuskehadiran_id, $pegawai_id, $tgl_awal, $tgl_akhir){
        $format = new MyFormatter();
        $criteria = new CDbCriteria();		
        //$criteria->select = "tglpresensi, statusscan_id, statuskehadiran_id";		        
        $criteria->addBetweenCondition('date(tglpresensi)', $format->formatDateTimeForDb($tgl_awal), $format->formatDateTimeForDb($tgl_akhir));    
        $criteria->addCondition("pegawai_id = '$pegawai_id' ");	
        $criteria->order = "tglpresensi ASC";
        //$criteria->group = "tglpresensi, statusscan_id, statuskehadiran_id";
        $getPresensi = PresensiT::model()->findAll($criteria);
        
        $data = array();
        
        $total = 0;
        $jam_masuk = null;
        $jam_pulang = null;
                
        if (count((array)$getPresensi) > 0){
            foreach ($getPresensi as $pre){
                $tgl = date('Y-m-d', strtotime($pre->tglpresensi));

                if (isset($data["$tgl"])){                        
                    if ($pre->statusscan_id == Params::STATUSSCAN_MASUK){
                        if (empty($data["$tgl"]['jam_masuk'])){                        
                            $jam_masuk = date('H:i:s', strtotime($pre->tglpresensi));                        
                        }else{                        
                            if (!empty(Params::getStatusHadir($pre->statuskehadiran_id))){
                                //$jam_masuk = date('H:i:s', strtotime($pre->tglpresensi));
                                $jam_masuk = $data["$tgl"]['jam_masuk'];
                            }else{
                                $jam_masuk = $data["$tgl"]['jam_masuk'];
                            }                                                                
                        }
                    }

                    if ($pre->statusscan_id == Params::STATUSSCAN_PULANG){
                        
                        if (empty($data["$tgl"]['jam_pulang'])){                                      
                            //var_dump(date('H:i:s', strtotime($pre->tglpresensi)));
                            $jam_pulang = date('H:i:s', strtotime($pre->tglpresensi));                                                        
                        }else{                                                                                    
                            if (!empty(Params::getStatusHadir($pre->statuskehadiran_id))){
                                //$jam_pulang = date('H:i:s', strtotime($pre->tglpresensi));
                                $jam_pulang = $data["$tgl"]['jam_pulang'];
                            }else{                                                                                        
                                $jam_pulang = $data["$tgl"]['jam_pulang'];
                            }                                                         
                        }                                                
                    }
                    
                    if (!empty(Params::getStatusHadir($pre->statuskehadiran_id))){
                        $status_kehadiran = $pre->statuskehadiran_id; 
                    }else{
                        $status_kehadiran = $data["$tgl"]['status_kehadiran'];
                    }
                                       
                }else{                    
                    if ($pre->statusscan_id == Params::STATUSSCAN_MASUK){
                        $jam_masuk = date('H:i:s', strtotime($pre->tglpresensi));
                    }else{
                        $jam_masuk = null;
                    }
                    
                    if ($pre->statusscan_id == Params::STATUSSCAN_PULANG){                        
                        $jam_pulang = date('H:i:s', strtotime($pre->tglpresensi));
                    }else{                        
                        $jam_pulang = null;                        
                    }
                                  
                    $status_kehadiran = $pre->statuskehadiran_id;                
                }
                                                                        
                $data["$tgl"] = array(
                    'jam_masuk' => $jam_masuk,
                    'jam_pulang' => $jam_pulang,
                    'status_kehadiran' => $status_kehadiran,
                    'tanggal' => $tgl
                );                                                        
            }                                    
                                            
            
            foreach ($data as $i => $val){                                
                if (!empty(Params::getStatusHadir($val['status_kehadiran']))){
                     if ($val['status_kehadiran'] == $statuskehadiran_id){                             
                        $total = $total + 1;
                     }
                }else{
                    if ($val['status_kehadiran'] == $statuskehadiran_id){                        
                        if ( (!empty($val['jam_masuk'])) && (!empty($val['jam_pulang']))){
                            $masuk = strtotime($val['tanggal'].' '.$val['jam_masuk']);
                            $pulang = strtotime($val['tanggal'].' '.$val['jam_pulang']);
                            
                            $jam = floor(round(abs($masuk - $pulang) / 60,2)/60);

                            if ($jam >= Params::KUOTA_JAM_KERJA){
                                $total = $total + 1;
                            }else{                                                               
                                $total = $total + 0;                                
                            }                    
                        }
                    }else{
                        if ($statuskehadiran_id == Params::STATUSKEHADIRAN_ALPHA){
                            if ( (!empty($val['jam_masuk'])) && (!empty($val['jam_pulang']))){
                                $masuk = strtotime($val['tanggal'].' '.$val['jam_masuk']);
                                $pulang = strtotime($val['tanggal'].' '.$val['jam_pulang']);

                                $jam = floor(round(abs($masuk - $pulang) / 60,2)/60);

                                if ($jam >= Params::KUOTA_JAM_KERJA){
                                    $total = $total + 0;
                                }else{                                                               
                                    $total = $total + 1;                                
                                }                    
                            }
                        }else{
                            $total = $total + 0;
                        }
                                                    
                    }
                }
            }                     
        }else{
            $total = 0;
        }        
        return $total;
    }
    
    
    public function dropDokterParamedisItems($ruangan_id='')
    {
       // if(!empty($ruangan_id)):
            $dokter = new CDbCriteria;
            //$dokter->join =
            //$dokter->addCondition("t.ruangan_id = '$ruangan_id' ");
            //$dokter->addCondition("kelompokpegawai_id IN (".Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.", ".Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN.")");            
			if (!empty($ruangan_id)){
				$dokter->join = " JOIN ruanganpegawai_m rp ON rp.pegawai_id = t.pegawai_id ";
				$dokter->addCondition("rp.ruangan_id = ".$ruangan_id." ");
			}
			
            $dokter->addCondition("pegawai_aktif = TRUE");
            $dokter->order = "kelompokpegawai_id ASC, nama_pegawai ASC";
             
            return CHtml::listData(PegawaiM::model()->findAll($dokter),'pegawai_id','namaLengkap');
            //return DokterV::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id), array(
              //  'order'=>'nama_pegawai',
            //));
       // else:
       //     return array();
      //  endif;
    }
	
	/**
	 * Mengambil data jasa medis yang belum dibayar yang kemudian dijumlahkan tarif
	 * komponenya.
	 * 
	 * @param string $date tanggal yang dipakai untuk filter bulanan. Jika $date-nya
	 * adalah 2017-12-04, maka filter yang dibuat adalah antara 2017-12-01 dan
	 * 2017-12-31.
	 * @return integer Jumlah jasa yang belum dibayar
	 */
	public function getUangJasaMedisBelumBayar($date) {
		$time = strtotime($date);
		$cr = new CDbCriteria();
		$cr->addBetweenCondition('tgl_tindakan::date', date('Y-m-01', $time), date('Y-m-t', $time));
		$cr->compare('pegawai_id', $this->pegawai_id);
		$cr->addCondition('tarif_tindakankomp > 0');
		$cr->addInCondition('komponentarif_id', array(Params::KOMPONENTARIF_ID_JASA_MEDIS));
					
		
		$mod = GJPasienpelayanandokterrsV::model()->findAll($cr);
		$total = 0;
		
		foreach ($mod as $item) {
			$total += $item->tarif_tindakankomp;
		}
		
		return $total;
	}
    
    
    
    
    
    /**
	 * Mengambil data jasa medis yang sudah dibayar yang kemudian dijumlahkan tarif
	 * komponenya.
	 * 
	 * @param string $date tanggal yang dipakai untuk filter bulanan. Jika $date-nya
	 * adalah 2017-12-04, maka filter yang dibuat adalah antara 2017-12-01 dan
	 * 2017-12-31.
	 * @return integer Jumlah jasa yang belum dibayar
	 */
    public function getUangJasaMedisSudahBayar($date, &$mod, &$mod2) {
		$time = strtotime($date);
		$cr = new CDbCriteria();
        
        $total = 0;
        
        if (!in_array($this->kelompokpegawai_id, array(
            Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, 
            Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, 
            Params::KELOMPOKPEGAWAI_ID_BIDAN
        ))) return $total;
        
        $cr->join = 'join pembayaranjasa_t b on b.pembayaranjasa_id = t.pembayaranjasa_id '
            //. 'join tindakankomponen_t k on k.tindakankomponen_id = t.tindakankomponen_id '
                . 'join tindakansudahbayar_t tsb on tsb.tindakanpelayanan_id = t.tindakanpelayanan_id '
                . 'join pembayaranpelayanan_t pp on pp.pembayaranpelayanan_id = tsb.pembayaranpelayanan_id';
        $cr->compare('b.pegawai_id', $this->pegawai_id);
        $cr->addBetweenCondition('pp.tglpembayaran::date', date('Y-m-01', $time), date('Y-m-t', $time));
        $cr->addCondition('t.penggajiankomp_id is null');
        $cr->addInCondition('t.komponentarif_id', array(
            13,50,23,60,58,64,56,54,61,2,46,5,10,53,11,12
        ));
        // $cr->addCondition('tp.tarif_tindakankomp > 0');
		// var_dump($cr); die;

        $mod = PembjasadetailT::model()->findAll($cr);

        // var_dump(count((array)$mod), $date, $cr); die;

        foreach ($mod as $item) {
            $total += $item->jumlahbayar;
        }
        
        
        if (in_array($this->kelompokpegawai_id, array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN))) {
            
            $cr = new CDbCriteria;
            $cr->join = 'join pembayaranjasa_t p on p.pembayaranjasa_id = t.pembayaranjasa_id';
            $cr->compare('t.pegawai_id', $this->pegawai_id);
            $cr->compare('t.pilihjasa', 'askep');
            $cr->addBetweenCondition('p.periodejasa::date', date('Y-m-01', $time), date('Y-m-t', $time));
            
            $mod2 = PembjasaperawatT::model()->findAll($cr);

            // var_dump(count((array)$mod), $date, $cr); die;

            foreach ($mod2 as $item) {
                $total += $item->total_terima;
            }
        }
            
		return $total;
	}
    
    
    
    
    /**
	 * Mengambil data jasa paramedis medis yang sudah dibayar yang kemudian dijumlahkan tarif
	 * komponenya.
	 * 
	 * @param string $date tanggal yang dipakai untuk filter bulanan. Jika $date-nya
	 * adalah 2017-12-04, maka filter yang dibuat adalah antara 2017-12-01 dan
	 * 2017-12-31.
	 * @return integer Jumlah jasa yang belum dibayar
	 */
    public function getUangJasaParamedisSudahBayar($date, &$mod, &$mod2) {
		$time = strtotime($date);
		$cr = new CDbCriteria();
        
        $total = 0;
        
        if (!in_array($this->kelompokpegawai_id, array(
            Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, 
            Params::KELOMPOKPEGAWAI_ID_BIDAN
        ))) return $total;
        
        $cr->join = 'join pembayaranjasa_t b on b.pembayaranjasa_id = t.pembayaranjasa_id '
            //. 'join tindakankomponen_t k on k.tindakankomponen_id = t.tindakankomponen_id '
                . 'join tindakansudahbayar_t tsb on tsb.tindakanpelayanan_id = t.tindakanpelayanan_id '
                . 'join pembayaranpelayanan_t pp on pp.pembayaranpelayanan_id = tsb.pembayaranpelayanan_id';
        $cr->compare('b.pegawai_id', $this->pegawai_id);
        $cr->addBetweenCondition('pp.tglpembayaran::date', date('Y-m-01', $time), date('Y-m-t', $time));
        $cr->addCondition('t.penggajiankomp_id is null');
        $cr->addInCondition('t.komponentarif_id', array(
            65,53,10,59,4,5,21,52,51
        ));
        // $cr->addCondition('tp.tarif_tindakankomp > 0');


        $mod = PembjasadetailT::model()->findAll($cr);

        // var_dump(count((array)$mod), $date, $cr); die;

        foreach ($mod as $item) {
            $total += $item->jumlahbayar;
        }
        
        
        $cr = new CDbCriteria;
        $cr->join = 'join pembayaranjasa_t p on p.pembayaranjasa_id = t.pembayaranjasa_id';
        $cr->compare('t.pegawai_id', $this->pegawai_id);
        $cr->compare('t.pilihjasa', array('paramedis'));
        $cr->addBetweenCondition('p.periodejasa::date', date('Y-m-01', $time), date('Y-m-t', $time));

        $mod2 = PembjasaperawatT::model()->findAll($cr);

        // var_dump(count((array)$mod), $date, $cr); die;

        foreach ($mod2 as $item) {
            $total += $item->total_terima;
        }
        
            
		return $total;
	}
	
    public function getUangJasaRadiograferSudahBayar($date, &$mod, &$mod2) {
		$time = strtotime($date);
		$total = 0;
        
        
        $cr = new CDbCriteria;
        $cr->join = 'join pembayaranjasa_t p on p.pembayaranjasa_id = t.pembayaranjasa_id';
        $cr->compare('t.pegawai_id', $this->pegawai_id);
        $cr->compare('t.pilihjasa', array('radio'));
        $cr->addBetweenCondition('p.periodejasa::date', date('Y-m-01', $time), date('Y-m-t', $time));

        $mod2 = PembjasaperawatT::model()->findAll($cr);

        // var_dump(count((array)$mod), $date, $cr); die;

        foreach ($mod2 as $item) {
            $total += $item->total_terima;
        }
        
            
		return $total;
	}
    
    
    
    public function getUangJasaGiziSudahBayar($date, &$mod, &$mod2) {
		$time = strtotime($date);
		$cr = new CDbCriteria();
        
        $total = 0;
        
        $cr->join = 'join pembayaranjasa_t b on b.pembayaranjasa_id = t.pembayaranjasa_id '
            //. 'join tindakankomponen_t k on k.tindakankomponen_id = t.tindakankomponen_id '
                . 'join tindakansudahbayar_t tsb on tsb.tindakanpelayanan_id = t.tindakanpelayanan_id '
                . 'join pembayaranpelayanan_t pp on pp.pembayaranpelayanan_id = tsb.pembayaranpelayanan_id';
        $cr->compare('b.pegawai_id', $this->pegawai_id);
        $cr->addBetweenCondition('pp.tglpembayaran::date', date('Y-m-01', $time), date('Y-m-t', $time));
        $cr->addCondition('t.penggajiankomp_id is null');
        $cr->addInCondition('t.komponentarif_id', array(
            7
        ));
        // $cr->addCondition('tp.tarif_tindakankomp > 0');


        $mod = PembjasadetailT::model()->findAll($cr);

        // var_dump(count((array)$mod), $date, $cr); die;

        foreach ($mod as $item) {
            $total += $item->jumlahbayar;
        }
        
		return $total;
	}
    
    
    
    
    
    
    public function getUangJasaSopirSudahBayar($date, &$mod, &$mod2) {
		$time = strtotime($date);
		$cr = new CDbCriteria();
        
        $total = 0;
        
        if (in_array($this->jabatan_id, array(Params::JABATAN_ID_DRIVER, Params::JABATAN_ID_SECURITY)) || in_array($this->pegawai_id, array(33, 69))) {
            
            $cr->join = 'join pembayaranjasa_t b on b.pembayaranjasa_id = t.pembayaranjasa_id '
            //. 'join tindakankomponen_t k on k.tindakankomponen_id = t.tindakankomponen_id '
                    . 'join tindakansudahbayar_t tsb on tsb.tindakanpelayanan_id = t.tindakanpelayanan_id '
                    . 'join pembayaranpelayanan_t pp on pp.pembayaranpelayanan_id = tsb.pembayaranpelayanan_id';
            $cr->compare('b.pegawai_id', $this->pegawai_id);
            $cr->addBetweenCondition('pp.tglpembayaran::date', date('Y-m-01', $time), date('Y-m-t', $time));
            $cr->addCondition('t.penggajiankomp_id is null');
            $cr->addInCondition('t.komponentarif_id', array(
                Params::KOMPONENTARIF_ID_JASA_SOPIR
            ));
            // $cr->addCondition('tp.tarif_tindakankomp > 0');


            $mod = PembjasadetailT::model()->findAll($cr);

            // var_dump(count((array)$mod), $date, $cr); die;

            foreach ($mod as $item) {
                $total += $item->jumlahbayar;
            }
            
            
            
            $cr = new CDbCriteria;
            $cr->join = 'join pembayaranjasa_t p on p.pembayaranjasa_id = t.pembayaranjasa_id';
            $cr->compare('t.pegawai_id', $this->pegawai_id);
            $cr->addBetweenCondition('p.periodejasa::date', date('Y-m-01', $time), date('Y-m-t', $time));
            $cr->compare('t.pilihjasa', 'sopir');
            
            $mod2 = PembjasaperawatT::model()->findAll($cr);

            // var_dump(count((array)$mod), $date, $cr); die;

            foreach ($mod2 as $item) {
                $total += $item->total_terima;
            }
        }
		
		return $total;
	}
    
    public function getUangJasaLaundrySudahBayar($date, &$mod, &$mod2) {
		$time = strtotime($date);
		$cr = new CDbCriteria();
        
        $total = 0;
        
        if ($this->unitkerja_id == Params::UNITKERJA_ID_LAUNDRY) {
            
            
            $cr->join = 'join pembayaranjasa_t b on b.pembayaranjasa_id = t.pembayaranjasa_id '
            //. 'join tindakankomponen_t k on k.tindakankomponen_id = t.tindakankomponen_id '
                    . 'join tindakansudahbayar_t tsb on tsb.tindakanpelayanan_id = t.tindakanpelayanan_id '
                    . 'join pembayaranpelayanan_t pp on pp.pembayaranpelayanan_id = tsb.pembayaranpelayanan_id';
            $cr->compare('b.pegawai_id', $this->pegawai_id);
            $cr->addBetweenCondition('pp.tglpembayaran::date', date('Y-m-01', $time), date('Y-m-t', $time));
            $cr->addCondition('t.penggajiankomp_id is null');
            $cr->addInCondition('t.komponentarif_id', array(
                Params::KOMPONENTARIF_ID_JASA_LAUNDRY
            ));
            // $cr->addCondition('tp.tarif_tindakankomp > 0');


            $mod = PembjasadetailT::model()->findAll($cr);

            // var_dump(count((array)$mod), $date, $cr); die;

            foreach ($mod as $item) {
                $total += $item->jumlahbayar;
            }
            
            
            
            $cr = new CDbCriteria;
            $cr->join = 'join pembayaranjasa_t p on p.pembayaranjasa_id = t.pembayaranjasa_id';
            $cr->compare('t.pegawai_id', $this->pegawai_id);
            $cr->addBetweenCondition('p.periodejasa::date', date('Y-m-01', $time), date('Y-m-t', $time));
            $cr->compare('t.pilihjasa', 'laundry');
            
            $mod2 = PembjasaperawatT::model()->findAll($cr);

            // var_dump(count((array)$mod), $date, $cr); die;

            foreach ($mod2 as $item) {
                $total += $item->total_terima;
            }
        }
		
		return $total;
	}
    
    public function getUangJasaApotekSudahBayar($date, &$mod, &$mod2) {
		$time = strtotime($date);
		$cr = new CDbCriteria();
        
        $total = 0;
        
        if ($this->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_NONKEPERAWATAN) {
            
            $cr = new CDbCriteria;
            $cr->join = 'join pembayaranjasa_t p on p.pembayaranjasa_id = t.pembayaranjasa_id';
            $cr->compare('t.pegawai_id', $this->pegawai_id);
            $cr->addBetweenCondition('p.periodejasa::date', date('Y-m-01', $time), date('Y-m-t', $time));
            $cr->compare('t.pilihjasa', 'farmasi');
            
            $mod2 = PembjasaperawatT::model()->findAll($cr);

            // var_dump(count((array)$mod), $date, $cr); die;

            foreach ($mod2 as $item) {
                $total += $item->total_terima;
            }
        }
		
		return $total;
	}
    
    
	
	/**
	 * Total jada rujukan internal disertiap bulan yang dipilih.
	 * @param string $date tanggal yang dipakai untuk filter bulanan. Jika $date-nya
	 * adalah 2017-12-04, maka filter yang dibuat adalah antara 2017-12-01 dan
	 * 2017-12-31.
	 * @param integer $ruangan_id ruangan yang dipilih.
	 * @return integer Nominal jasa Rujuk.
	 */
	public function getUangRujukInternalBulan($date, $ruangan_id) {
		$time = strtotime($date);
		$cr = new CDbCriteria();
		$cr->addBetweenCondition('tgl_tindakan::date', date('Y-m-01', $time), date('Y-m-t', $time));
		$cr->compare('pegawai_id', $this->pegawai_id);
		$cr->compare('ruangan_id', $ruangan_id);
		
		//print_r($cr); die;
		
		$dat = LaporanpemeriksaanrujukanrsV::model()->findAll($cr);
		$tot = 0;
		
		foreach ($dat as $item) {
			$tot += $item->tarif_tindakankomp;
		}
		
		return $tot;
		
	}
    
    public function jasaPenunjangBulan($date, $ruangan_id) {
        $time = strtotime($date);
		$cr = new CDbCriteria();
        $cr->join = 'join pembayaranjasa_t b on b.pembayaranjasa_id = t.pembayaranjasa_id '
            //. 'join tindakankomponen_t k on k.tindakankomponen_id = t.tindakankomponen_id '
            . 'join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id';
        $cr->compare('b.pegawai_id', $this->pegawai_id);
        $cr->compare('tp.ruangan_id', $ruangan_id);
		$cr->addBetweenCondition('tp.tgl_tindakan::date', date('Y-m-01', $time), date('Y-m-t', $time));
		// $cr->addCondition('tp.tarif_tindakankomp > 0');
		$cr->addInCondition('t.komponentarif_id', array(Params::KOMPONENTARIF_ID_JASA_PEMBACA));
					
		
        // print_r($cr); die;
        
		$mod = PembjasadetailT::model()->findAll($cr);
		$total = 0;
		
		foreach ($mod as $item) {
			$total += $item->jumlahbayar;
		}
		
		return $total;
    }
	
	/**
	 * Menghitung Jumlah Uang Jaga pegawai berdasarkan Jadwal Dokter pegawai untuk
	 * Rawat Darurat dan Rawat Inap.
	 * Nominal ditentukan berdasarkan Letak shift pada Waktu mulai jadwal.
	 * 
	 * @param string $date 
	 * @return total nominal uang jaga pada bulan yang diinput.
	 */
	public function getUangJagaBulan($date) {
		$time = strtotime($date);
		$cr = new CDbCriteria();
		$cr->join = 'left join ruangan_m r on r.ruangan_id = t.ruangan_id';
		$cr->addBetweenCondition('t.jadwaldokter_tgl::date', date('Y-m-01', $time), date('Y-m-t', $time));
		$cr->compare('t.pegawai_id', $this->pegawai_id);
		$cr->addInCOndition('r.instalasi_id', array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI));
		
		$modJadwal = JadwaldokterM::model()->findAll($cr);
		$modShift = ShiftM::model()->findAllByAttributes(array(
			'shift_id'=>array(8, 3)
		));
		
		$total = 0;
		
		$arrShift = array(
			3 => array('start'=>0, 'end'=>0, 'qty'=>array(), 'code'=>'OSP'),
			'3_1' => array('start'=>0, 'end'=>0, 'qty'=>array(), 'code'=>'OSP'),
			8 => array('start'=>0, 'end'=>0, 'qty'=>array(), 'code'=>'OSM'),
		);
		
		foreach ($modShift as $item) {
			$start = CustomFunction::time2int($item->shift_jamawal);
			$end = CustomFunction::time2int($item->shift_jamakhir);
			
			$arrShift[$item->shift_id]['start'] = $start;
			
			if ($start > $end) {
				$arrShift[$item->shift_id]['end'] = (3600 * 24) - 1;
				$arrShift[$item->shift_id."_1"]['start'] = 0;
				$arrShift[$item->shift_id."_1"]['end'] = $end;
				
				
			} else {
				$arrShift[$item->shift_id]['end'] = $end;
			}
			
			
			
		}
		
		
		foreach ($modJadwal as $jadwal) {
			$start_time = CustomFunction::time2int($jadwal->jadwaldokter_mulai);
			
			
			
			foreach ($arrShift as $id=>$shift) {
				// print_r(array($start_time, $shift));
				if ($start_time >= $shift['start'] && $start_time < $shift['end'])
					$arrShift[$id]['qty'][$jadwal->jadwaldokter_tgl] = 1;
			}
		}
		
		// die;
        
        // print_r($arrShift); die;
		
		$res = array('OSP'=>0, 'OSM'=>1);
		foreach ($arrShift as $item) {
			foreach ($item['qty'] as $val) {
				$res[$item['code']] += $val;
			}
		}
		// print_r($res); die;
		
		return $res;
	}
	
	/**
	 * Mengambil nominal SIP untuk pegawai yang memiliki Surat Izin Praktek dan 
	 * belum melewati masa Izin-nya..
	 * Jika SIP pada data pegawai adalah 0, maka akan mengambil nominal  
	 * dari Jabatan dari pegawai tersebut.
	 * @return int Nomial SIP Pegawai.
	 */
	public function getNilaiSIP() {
		if (empty($this->suratizinpraktek)) return 0;
		if (time() > strtotime($this->masa_sip)) return 0;
		if (empty($this->jabatan_id)) return 0;
		
		$jabatan = JabatanM::model()->findByPk($this->jabatan_id);
		
		if (!empty($this->nominal_sip) && $this->nominal_sip != 0)
			return $this->nominal_sip;
		
		if ($jabatan->nominal_sip != 0)
			return $jabatan->nominal_sip;
		
		return 0;
	}
    
    
    public function getLembur($date, $biayalembur_id = 1) {
        $time = strtotime($date);
        
        $cr = new CDbCriteria;
        $cr->compare('t.pegawai_id', $this->pegawai_id);
        $cr->addBetweenCondition('t.tglmulai::date', date('Y-m-01', $time), date('Y-m-t', $time));
		$cr->compare('biayalembur_id', $biayalembur_id);
        
        $mod = RealisasilemburdetT::model()->findAll($cr);
        
        $qty = 0;
        $val = 0;
        $cnt = 0;
		
		
        foreach ($mod as $item) {
            $qty += $item->total_jam;
            $val = $item->nilai_lembur;
        }
		
		//$val = $qty == 0 ? 0 : ($val / $qty);
        
        return array('qty'=>$qty, 'val'=>$val);
    }
    
    public function getUangParamedis($date) {
        $time = strtotime($date);
		$cr = new CDbCriteria();
        $cr->join = 'join pembayaranjasa_t b on b.pembayaranjasa_id = t.pembayaranjasa_id '
            //. 'join tindakankomponen_t k on k.tindakankomponen_id = t.tindakankomponen_id '
            . 'join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id';
        $cr->compare('b.pegawai_id', $this->pegawai_id);
        // $cr->compare('tp.ruangan_id', $ruangan_id);
		$cr->addBetweenCondition('tp.tgl_tindakan::date', date('Y-m-01', $time), date('Y-m-t', $time));
		// $cr->addCondition('tp.tarif_tindakankomp > 0');
		$cr->addInCondition('t.komponentarif_id', array(
            Params::KOMPONENTARIF_ID_JASA_PARAMEDIS,
            Params::KOMPONENTARIF_ID_JASA_ASISTEN_ANASTESI,
        ));
					
		
        // print_r($cr); die;
        
		$mod = PembjasadetailT::model()->findAll($cr);
		$total = 0;
		
		foreach ($mod as $item) {
			$total += $item->jumlahbayar;
		}
		
		return $total;
    }
    
    public function getJabatanNama() {
        $namajabatan = '';
        if(!empty($this->jabatan_id)){
            $namajabatan = $this->jabatan->jabatan_nama;
        }
        return $namajabatan;
    }
    
    public function getJmlTanggungan() {
            $tanggungan = '0';
            if(!empty($this->ptkp_id)){
                $ptkp = PtkpM::model()->findByPk($this->ptkp_id);
                if(!empty($ptkp->ptkp_id)){
                    $tanggungan = $ptkp->jmltanggunan;
                }
            }
            return $tanggungan;
        }
    
    public function getStatusKodePtkp() {
            $tanggungan = '';
            if(!empty($this->ptkp_id)){
                $ptkp = PtkpM::model()->findByPk($this->ptkp_id);
                if(!empty($ptkp->ptkp_id)){
                    if($ptkp->kodeptkp == 'K'){
                        echo 'K / '.$ptkp->jmltanggunan.' &nbsp; &nbsp; &nbsp; TK / &nbsp; &nbsp; &nbsp; HB /';
                    }
                    else if($ptkp->kodeptkp == 'KI'){
                        echo 'KI / '.$ptkp->jmltanggunan.' &nbsp; &nbsp; &nbsp; TK / &nbsp; &nbsp; &nbsp; HB /';
                    }
                    else if($ptkp->kodeptkp == 'TK'){
                        echo 'K / &nbsp; &nbsp; &nbsp; TK / '.$ptkp->jmltanggunan.' &nbsp; &nbsp; &nbsp; HB /';
                    }
                    else if($ptkp->kodeptkp == 'HB'){
                        echo 'K / &nbsp; &nbsp; &nbsp; TK /  &nbsp; &nbsp; &nbsp; HB / '.$ptkp->jmltanggunan;
                    }
                    else{
                        echo 'K / &nbsp; &nbsp; &nbsp; TK /  &nbsp; &nbsp; &nbsp; HB / ';
                    }
                }
            }
            return $tanggungan;
        }    
        
        
    public function getJenisBuktiPotong() {
        if ($this->kode_objekpajak == "21-100-07") {
            return "21 Final";
        }
        
        return "21";
    }
    
    public function getAlamatJson() {
        return str_replace("\n", " ", str_replace("\r", " ", $this->alamat_pegawai));
    }
    
    public function getUmurTahun() {
        $lahir = new DateTime($this->tgl_lahirpegawai);
        $now = new DateTime(date('Y-m-d'));

       return $umur = $now->diff($lahir)->y;
    }
    
    public function searchKepalaunit() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $cekKepalaBagian = UnitkerjaM::model()->findAll('kepalaunitpeg_id IS NOT NULL');
        $kepalaunitpeg_id = array();

        foreach ($cekKepalaBagian as $val):
            $kepalaunitpeg_id[] = $val->kepalaunitpeg_id;
        endforeach;

        $criteria = new CDbCriteria;
        $criteria->join = "left join unitkerja_m u on u.unitkerja_id = t.unitkerja_id "
                . "left join jabatan_m j on j.jabatan_id = t.jabatan_id";
        $criteria->select = "t.*, u.namaunitkerja, j.jabatan_nama";
        $criteria->addInCondition('pegawai_id', $kepalaunitpeg_id);

        $criteria->compare('LOWER(nomorindukpegawai)', strtolower($this->nomorindukpegawai), TRUE);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), TRUE);
        $criteria->compare('LOWER(u.namaunitkerja)', strtolower($this->namaunitkerja), TRUE);
        if ($this->jabatan_id) {
            $criteria->addCondition(" jabatan_id = '" . $this->jabatan_id . "' ");
        }
        if ($this->unitkerja_id) {
            $criteria->addCondition(" unitkerja_id = '" . $this->unitkerja_id . "' ");
        }
        $criteria->addCondition(" pegawai_aktif = TRUE ");
        $criteria->order = 'nama_pegawai ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
	public function searchPegawaiDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if (!empty($this->unitkerja_id)){
			$criteria->addCondition(" t.unitkerja_id = ".$this->unitkerja_id);
		}
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->order = 't.nama_pegawai ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
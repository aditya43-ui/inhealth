<?php

/**
 * This is the model class for table "pemeriksaanfisik_t".
 *
 * The followings are the available columns in table 'pemeriksaanfisik_t':
 * @property integer $pemeriksaanfisik_id
 * @property integer $gcs_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $tglperiksafisik
 * @property string $keadaanumum
 * @property string $inspeksi
 * @property string $palpasi
 * @property string $perkusi
 * @property string $auskultasi
 * @property string $tekanandarah
 * @property string $detaknadi
 * @property string $suhutubuh
 * @property string $beratbadan_kg
 * @property string $tinggibadan_cm
 * @property string $pernapasan
 * @property string $paramedis_nama
 * @property string $kelainanpadabagtubuh
 * @property string $kulit
 * @property string $kepala
 * @property string $mata
 * @property string $telinga
 * @property string $hidung
 * @property string $leher
 * @property string $tenggorokan
 * @property string $jantung
 * @property string $payudara
 * @property string $abdomen
 * @property integer $gcs_eye
 * @property integer $gcs_verbal
 * @property integer $gcs_motorik
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PemeriksaanfisikT extends CActiveRecord
{
        public $tekanandarah_text;
        public $posisijanin;
        public $is_pilih,$conjuctiva;
		public $jnstransaksi;
		public $gcs_kesadaran;
	public $pemeriksaanfisiksebelum_id;
	public $nomor_triage, $pemeriksaanfisikasal_id;
        public $periksa_penunjang_detail;
        public $kriteria_td,$namaGCS;
		public $pemeriksaan, $pernafasan, $pernafasandada, $pemeriksaanmata,$obs_ppds,$obs_ppds_nama, $thorax, $cardio, $pulmo, $genitalia, $obstetri, $obs_ppds_id, $kala4_ppds_id, $kala4_ppds_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanfisikT the static model class
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
		return 'pemeriksaanfisik_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('tglperiksafisik,keadaanumum, create_loginpemakai_id, create_time, create_ruangan', 'required'),
			array('gcs_id, pendaftaran_id, pegawai_id, pasienadmisi_id,ppds_id, pasien_id, gcs_eye, gcs_verbal, gcs_motorik, kala4_systolic, obs_ppds_id, kala4_diastolic, kala4_detaknadi', 'numerical', 'integerOnly'=>true),
			// array('pendaftaran_id, pasien_id,ppds_id, tglperiksafisik, create_loginpemakai_id, create_time, create_ruangan', 'required'),
			// array('gcs_id, pendaftaran_id, pegawai_id, pasienadmisi_id,ppds_id, pasien_id, gcs_eye, gcs_verbal, gcs_motorik, kala4_systolic, kala4_diastolic, kala4_detaknadi', 'numerical', 'integerOnly'=>true),

			array('keadaanumum', 'length', 'max'=>3000),
			array('ket_masalahperkawinanlain, ket_traumakehidupan, bisingjantung, panel_obgyn', 'length', 'max'=>150),
			array('nifas_inveksi, nifas_laktasi, nifas_febris, nifas_lainlain, kala4_anemia, kala4_ppds_id,kala4_ppds_nama, obs_pemeriksaan, inspeksi, palpasi, perkusi, auskultasi, paramedis_nama, obs_fundusufen, ketuban_genitalia, obs_warnaketuban, obs_pemeriksa, obs_ppds , obs_ppds_nama, portio_genitalia, obs_konsistensigenitalia, obs_arah, penurunan_genitalia, obs_hodge, presentasi_genitalia, plasentaspontanitas, plasentakelengkapan, pusar_insersi, pusar_kelengkapan, pusar_robekan, pusar_lainlain, luka_perineum, luka_vagina, luka_serviks, episiotomi, rupturaperinei', 'length', 'max'=>100),
			array('tekanandarah', 'length', 'max'=>20),
			array('panggul_ukuran, panggul_posisipengukuran', 'length', 'max'=>20),
			
			array('detaknadi, kelainanpadabagtubuh', 'length', 'max'=>30),
			array('suhutubuh, beratbadan_kg, tinggibadan_cm, pernapasan', 'length', 'max'=>10),

			array('pegawai_id, genitalia_garingdubur, frek_auskultasi, portio_genitalia, tekanandarah_text, meanarteripressure, td_systolic, td_diastolic, bb_ideal, kulit, mata, telinga, hidung, leher, tenggorokan, jantung, payudara, abdomen, update_time, update_loginpemakai_id,Lila, LingkarPinggang, LingkarPinggul, TebalLemak, TinggiLutut, denyutjantung_janin, tinggifundus_uteri', 'safe'),
			array('leher_kelgetahbening_teraba, leher_kelenjartiroid_teraba, riwayatjatuh_penilaian, riwayatjatuh_skor, diagnosismedis_penilaian, diagnosismedis_skor, alatbantujalan_penilaian, alatbantujalan_skor, memakaiterapiheparin_penilaian, memakaiterapiheparin_skor, caraberjalan_penilaian, caraberjalan_skor, statusmental_penilaian, statusmental_skor, resikojatuh_skor, resikojatuh_keterangan, keluhan_nyeri, skala_wongbaker_nrs','safe'),
			array('lama_nyeri,leher_mata,leher_telinga, seringmengalami_nyeri, penyebabberkurang_nyeri, rasanyeri_tajam, rasanyeri_tumpul, rasanyeri_ditarik, rasanyeri_ditusuk, rasanyeri_dibakar, rasanyeri_dipukul, rasanyeri_berdenyut, rasanyeri_ditikam, rasanyeri_kram, rasanyeri_berpindah','safe'),
			array('leher_posisijanin,is_pilih, leher_anemia, leher_leterus, leher_cyanosis, leher_dyspneu, leher_reflekpupil, leher_pupil, leher_nasal, leher_orofans, leher_jvp, leher_lainlain, tandavital_reflekcahaya, tandavital_spo2, cardio_inspeksi, cardio_perkusi, cardio_palpasi, cardio_auskultasi, pulmo_inspeksi, pulmo_palpasi, pulmo_perkusi, pulmo_auskultasi, abd_inspeksi, abd_palpasi, abd_perkusi, abd_auskultasi, obs_his, obs_vaginatoucher, genitalia_inspeksi, genitalia_palpasi, dubur_inspeksi, dubur_palpasi, status_neorologis, genitalia_rectaltouche','safe'),
			array('denyutjantung, kekuatanotot_cybex, kekuatanotot_entree, kekuatanotot_nktable, kekuatanotot_handhelddinamo, kekuatanotot_pinchmeter, lingkupgeraksendi_ikinometer, lingkupgeraksendi_goniometer, fleksibilitas_schober, fleksibilitas_sitandreach, fleksibilitas_shoulderfleksibility, fleksibilitas_sentuhjarikaki, fleksibilitas_kesimpulan, fleksibilitas_saran, skalanyeri_statusumur', 'safe'),
            
            array('leopold_1, leopold_2, leopold_3, leopold_4, periksa_penunjang, terapi_igd, terapi_rawatinap, monitoring, tl_rawatinap_ruang, tl_rawatinap_dpjp, tl_indikasi, tl_pengantar_pasien, tl_rujuk_ke, tl_rujuk_nama, edukasi_dituju_ke, edukasi_nama_keluarga, edukasi_alasan_tidakbisa', 'safe'),
            array('tl_asalrujukan_id, tl_rujukandari_id, tl_homecare_tgl, obs_ppds_id, kala4_ppds_id, kala4_ppds_nama, au_parurhkiri_1, au_parurhkiri_2, au_parurhkiri_3, au_parurhkanan_1, au_parurhkanan_2, au_parurhkanan_3, au_paruwhkiri_1, au_paruwhkiri_2, au_paruwhkiri_3, au_paruwhkanan_1, au_paruwhkanan_2, au_paruwhkanan_3, au_cardios1, au_cardios2, au_cardios3, au_cardios4', 'safe'),
			array('ada_sensibilitas, sensibilitas_panasdingin, sensibilitas_tajamtumpul, sensibilitas_kasarhalus, sensibilitas_titik', 'safe'),
            
            array('is_ews, ppds_id, is_pews, is_mews', 'safe'),
            array('is_masalahperkawinan, is_masalahperkawinan_istribaru, is_masalahperkawinan_simpanan, is_masalahperkawinan_cerai, is_masalahperkawinan_lainlain, is_kekerasanfisik, is_traumakehidupan, is_gangguanatidur, is_konsulpsikolog, is_mencederaiorang', 'safe'),
            array('ews_pernafasan, ews_pernafasanskor, ews_so2skala1, ews_so2skala1skor, ews_so2skala2, ews_so2skala2skor, '
                . 'ews_pemberiano2, ews_pemberiano2skor, ews_tdsistolik, ews_tdsistolikskor, ews_nadi, ews_nadiskor, ews_kesadaran, ews_kesadaranskor, '
                . 'ews_suhu, ews_suhuskor, ews_totalskor, ews_frekmonitor, ews_eskalasi', 'safe'),
            array('pews_keadaanumum, pews_skorkesadaranumum, pews_kardiovaskuler, pews_skorkardiovaskuler, pews_respirasi, pews_skorrespirasi, '
                . 'pews_totalskor, pews_frekmonitor, pews_eskalasi', 'safe'),
            array('mews_pernafasan, mews_pernafasannilai, mews_pernafasanskor, mews_so2, mews_so2nilai, mews_so2skor, '
                . 'mews_tdsistolik, mews_tdsistoliknilai, mews_tdsistolikskor, mews_tddiastolik, mews_tddiastoliknilai, mews_tddiastolikskor, '
                . 'mews_nadi, mews_nadinilai, mews_nadiskor, mews_kesadaran, mews_kesadarannilai, mews_kesadaranskor, '
                . 'mews_suhu, mews_suhunilai, mews_suhuskor, mews_totalkriteria, mews_frekmonitor, ppds_id, mews_totalskor, mews_eskalasi', 'safe'),
            
            array('reflekbayi, plasenta_lahir', 'safe'),
            array('hr,hrv, plasenta_berat, plasenta_diameter, pusar_panjang, kala4_meanarteripressure', 'numerical'),
            
            
            array('fungsional_tidur,fungsional_jalansendiri,fungsional_alatbantu,fungsional_alatbantu_keterangan,fungsional_kursiroda,fungsional_prothese,fungsional_prothese_keterangan,fungsional_deformitas,fungsional_deformitas_keterangan,fungsional_resikojatuh,fungsional_resikojatuh_keterangan,fungsional_lainlain,fungsional_lainlain_keterangan,
                sistematikkhusus_muskuloskeletal,sistematikkhusus_neuromuscular,sistematikkhusus_cardiopulmunal,sistematikkhusus_integumen,
                pengukurankhusus_muskuloskeletal,pengukurankhusus_neuromuscular,pengukurankhusus_cardiopulmunal,pengukurankhusus_integumen', 'safe'),
            
            array('gcs_jenis, obs_periksadalam', 'safe'),
            //pemeriksaan fisik mata
            ['mata_kanan, mata_kiri, segmen_anterior, segmen_posterior, warna, resume','safe'],
//                        DI NON-AKTIFKAN AGAR BRIDGING UNTUK MOBILE DOKTER BISA BERJALAN
//                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
//                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
//                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
//                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
//                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// Please remove those attributes that should not be searched.
			array('pemeriksaanfisik_id, gcs_id, leher_mata, leher_telinga, pendaftaran_id, Lila, obs_ppds,obs_ppds_nama, LingkarPinggang, LingkarPinggul, TebalLemak, TinggiLutut, pegawai_id, pasienadmisi_id, pasien_id, tglperiksafisik, keadaanumum, inspeksi, palpasi,ppds_id, perkusi, auskultasi, tekanandarah, detaknadi, suhutubuh, beratbadan_kg, tinggibadan_cm, pernapasan, paramedis_nama, kelainanpadabagtubuh, kulit, mata, telinga, hidung, leher, tenggorokan, jantung, payudara, abdomen, gcs_eye, gcs_verbal, gcs_motorik, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, gcs_jenis, panggul_ukuran, panggul_posisipengukuran, denyutjantung_janin, obs_fundusufen, ketuban_genitalia, obs_warnaketuban, obs_pemeriksa, portio_genitalia, obs_konsistensigenitalia, obs_arah, penurunan_genitalia, obs_hodge, presentasi_genitalia, obs_periksadalam, obs_pemeriksaan, plasenta_lahir, plasentaspontanitas, plasentakelengkapan, pusar_insersi, pusar_kelengkapan, pusar_robekan, pusar_lainlain, plasenta_berat, plasenta_diameter, pusar_panjang, kala4_anemia, kala4_systolic, kala4_diastolic, kala4_detaknadi, kala4_meanarteripressure, luka_perineum, luka_vagina, luka_serviks, episiotomi, rupturaperinei, nifas_inveksi, nifas_laktasi, nifas_febris, nifas_lainlain,au_cardios1, au_cardios2, au_cardios3, au_cardios4', 'safe', 'on'=>'search'),
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
				'gcs'=>array(self::BELONGS_TO, 'GcsM','gcs_id'),
				'pegawai'=>array(self::BELONGS_TO, 'PegawaiM','pegawai_id'),
				'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
				'klasifikasitekanandarah'=>array(self::BELONGS_TO, 'KlasifikasitekanadarahM','klasifikasitekanandarah_id'),
				'metodegcseye'=>array(self::BELONGS_TO, 'MetodegcsM','gcs_eye'),
				'metodegcsverbal'=>array(self::BELONGS_TO, 'MetodegcsM','gcs_verbal'),
				'metodegcsmotorik'=>array(self::BELONGS_TO, 'MetodegcsM','gcs_motorik'),
				'asalrujukan'=>array(self::BELONGS_TO, 'AsalrujukanM','tl_asalrujukan_id'),
				'rujukandari'=>array(self::BELONGS_TO, 'RujukandariM','tl_rujukandari_id'),
				'ppds'=>array(self::BELONGS_TO, 'PpdsM','ppds_id'),
				'pendaftaran'=>array(self::BELONGS_TO, 'PendaftaranT','pendaftaran_id'),
				
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pemeriksaanfisik_id' => 'ID',
			'gcs_id' => 'GCS',
			'ppds_id'=> '&nbsp;&nbsp;&nbsp;PPDS',
			'pendaftaran_id' => 'No. Pendaftaran',
			'pegawai_id' => '&nbsp;&nbsp;&nbsp;Dokter',
			'ppds_id'=> '&nbsp;&nbsp;&nbsp;PPDS',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pasien_id' => 'Nama Pasien',
			'tglperiksafisik' => 'Tanggal Periksa',
			'keadaanumum' => 'Keadaan Umum',
			'inspeksi' => 'Inspeksi',
			'palpasi' => 'Palpasi',
			'perkusi' => 'Perkusi',
			'auskultasi' => 'Auskultasi',
			'tekanandarah' => 'Tekanan Darah',
			'detaknadi' => 'Detak Nadi',
			'denyutjantung' => 'Denyut Jantung',
			'suhutubuh' => 'Suhu Tubuh',
			'beratbadan_kg' => 'Berat Badan',
			'tinggibadan_cm' => 'Tinggi Badan/',
			'pernapasan' => 'Pernapasan',
			'paramedis_nama' => 'Paramedis',
			'kelainanpadabagtubuh' => 'Kelainan Pada Bag. Tubuh',
			'kulit' => 'Kulit',
			'mata' => 'Mata',
			'telinga' => 'Telinga',
			'hidung' => 'Hidung',
			'leher' => 'Leher',
			'leher_mata' => 'Mata',
			'leher_telinga' => 'Telinga',
			'tenggorokan' => 'Tenggorokan',
			'jantung' => 'Jantung',
			'payudara' => 'Payudara',
			'abdomen' => 'Abdomen',
			'gcs_eye' => 'GCS Eye',
			'gcs_verbal' => 'GCS Verbal',
			'gcs_motorik' => 'GCS Motorik',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'Lila'=>'Lila',
			'LingkarPinggang'=>'Lingkar Pinggang',
			'LingkarPinggul'=>'Lingkar Pinggul',
			'TebalLemak'=>'Tebal Lemak',
			'TinggiLutut'=>'Tinggi Lutut',
			'bb_ideal'=>'Berat Badan Ideal',
			'jn_paten'=>'Paten',
			'jn_obstruktifpartial'=>'Obstruktif Partial',
			'jn_obstruktifnormal'=>'Obstruktif Total',
			'jn_stridor'=>'Stridor',
			'jn_gargling'=>'Gargling',
			'pgp_normal'=>'Normal',
			'pgp_kussmaul'=>'Kussmaul',
			'pgp_takipnea'=>'Takipnea',
			'pgp_retraktif'=>'Retraktif',
			'pgp_dangkal'=>'Dangkal',
			'pgd_simetri'=>'Simetri',
			'pgd_asimetri'=>'Asimetri',
			'sirkulasi_nadicarotis'=>'Nadi Carotis',
			'sirkulasi_nadiradialis'=>'Nadi Radialis',
			'cfr_kecil_2'=>'CFR',
			'cfr_besar_2'=>'CFR',
			'kulit_normal'=>'Normal',
			'kulit_jaundice'=>'Jaundice',
			'kulit_cyanosis'=>'Cyanosis',
			'kulit_pucat'=>'Pucat',
			'kulit_berkeringat'=>'Berkeringat',
			'akral'=>'Akral',
			'namaGCS'=>'Nilai GCS',
			'denyutjantung_janin'=>'Denyut Jantung Janin',
			'tinggifundus_uteri'=>'Tinggi Fundus Uteri',
			'portio_genitalia' => 'Portio',    
			'leher_anemia' => 'Anemia',
			'leher_leterus' => 'Leterus',
			'leher_cyanosis' => 'Cyanosis',
			'leher_dyspneu' => 'Dyspneu',
			'leher_reflekpupil' => 'Reflek Pupil',
			'leher_pupil' => 'Pupil',
			'leher_nasal' => 'Hidung/Nassal',
			'leher_orofans' => 'Mulut',
			'leher_jvp' => 'JVP',
			'leher_lainlain' => 'Lain - Lain',
			'tandavital_reflekcahaya' => 'Reflek Cahaya',
			'tandavital_spo2' => 'SPO2',
			'cardio_inspeksi' => 'Inspeksi',
			'cardio_perkusi' => 'Perkusi',
			'cardio_palpasi' => 'Palpasi',
			'cardio_auskultasi' => 'Auskultasi',
			'pulmo_inspeksi' => 'Inspeksi',
			'pulmo_palpasi' => 'Palpasi',
			'pulmo_perkusi' => 'Perkusi',
			'pulmo_auskultasi' => 'Auskultasi',
			'abd_inspeksi' => 'Inspeksi',
			'abd_palpasi' => 'Palpasi',
			'abd_perkusi' => 'Perkusi',
			'abd_auskultasi' => 'Auskultasi',
			'obs_his' => 'HIS',
			'obs_vaginatoucher' => 'Vagina Toucher',
			'genitalia_inspeksi' => 'Inspeksi', 
			'genitalia_palpasi' => 'Palpasi',
			'genitalia_rectaltouche' => 'Rectal Touche',
			'dubur_inspeksi' => 'Inspeksi',
			'dubur_palpasi' => 'Palpasi',
			'status_neorologis' => 'Status Neorologis',
            'genitalia_garingdubur'=>'Garing Dubur',
            'leopold_1'=>'Leopold I',
            'leopold_2'=>'Leopold II',
            'leopold_3'=>'Leopold III',
            'leopold_4'=>'Leopold IV',
            
            
            'fungsional_tidur' => 'Tidur / Bedrest / Gendong',
            'fungsional_jalansendiri' => 'Jalan Sendiri',
            'fungsional_alatbantu' => 'Alat Bantu',

            'fungsional_kursiroda' => 'Kursi Roda',

            'fungsional_prothese_keterangan' => 'Prothese',

            'fungsional_deformitas_keterangan' => 'Deformitas',

            'fungsional_resikojatuh_keterangan' => 'Resiko Jatuh',

            'fungsional_lainlain_keterangan' => 'Lain-Lain',

            'sistematikkhusus_muskuloskeletal' => 'Muskuloskeletal',
            'sistematikkhusus_neuromuscular' => 'Neuromuscular',
            'sistematikkhusus_cardiopulmunal' => 'Cardiopulmunal',
            'sistematikkhusus_integumen' => 'Integument',

            'pengukurankhusus_muskuloskeletal' => 'Muskuloskeletal',
            'pengukurankhusus_neuromuscular' => 'Neuromuscular',
            'pengukurankhusus_cardiopulmunal' => 'Cardiopulmunal',
            'pengukurankhusus_integumen' => 'Integument',

            'gcs_jenis' => 'Jenis Gcs',
			'is_masalahperkawinan' => 'Masalah Perkawinan',
			'is_kekerasanfisik' => 'Mengalamai Kekerasan Fisik',
			'is_traumakehidupan' => 'Trauma Dalam Kehidupan',
			'is_gangguanatidur' => 'Gangguan Tidur',
			'is_konsulpsikolog' => 'Konsultasi dengan Psikologi',
			'is_mencederaiorang' => 'Menciderai diri/orang lain',
			'is_masalahperkawinan_cerai' => 'Cerai',
			'is_masalahperkawinan_istribaru' => 'Istri Baru',
			'is_masalahperkawinan_simpanan' => 'Simpanan',
			'is_masalahperkawinan_lainlain' => 'Lain-lain',
            'mata_kanan' => 'Mata Kanan', 
            'mata_kiri' => 'Mata Kiri', 
            'segmen_anterior' => 'Segmen Anterior', 
            'segmen_posterior' => 'Segmen Posterior', 
            'warna' => 'Warna/Ishihara Test', 
            'resume' => 'Resume',
			'panel_obgyn' => 'Panel obgyn',
			'bisingjantung' =>	'Bisingjantung',
			'gcs_kesadaran' => 'Kesadaran'
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

		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('gcs_id',$this->gcs_id);
		$criteria->compare('ppds_id',$this->ppds_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('ppds_id',$this->ppds_id);
		$criteria->compare('LOWER(tglperiksafisik)',strtolower($this->tglperiksafisik),true);
		$criteria->compare('LOWER(keadaanumum)',strtolower($this->keadaanumum),true);
		$criteria->compare('LOWER(inspeksi)',strtolower($this->inspeksi),true);
		$criteria->compare('LOWER(palpasi)',strtolower($this->palpasi),true);
		$criteria->compare('LOWER(perkusi)',strtolower($this->perkusi),true);
		$criteria->compare('LOWER(auskultasi)',strtolower($this->auskultasi),true);
		$criteria->compare('LOWER(tekanandarah)',strtolower($this->tekanandarah),true);
		$criteria->compare('LOWER(detaknadi)',strtolower($this->detaknadi),true);
                $criteria->compare('LOWER(denyutjantung)',strtolower($this->denyutjantung),true);
		$criteria->compare('LOWER(suhutubuh)',strtolower($this->suhutubuh),true);
		$criteria->compare('LOWER(beratbadan_kg)',strtolower($this->beratbadan_kg),true);
		$criteria->compare('LOWER(tinggibadan_cm)',strtolower($this->tinggibadan_cm),true);
		$criteria->compare('LOWER(pernapasan)',strtolower($this->pernapasan),true);
		$criteria->compare('LOWER(paramedis_nama)',strtolower($this->paramedis_nama),true);
		$criteria->compare('LOWER(kelainanpadabagtubuh)',strtolower($this->kelainanpadabagtubuh),true);
		$criteria->compare('LOWER(kulit)',strtolower($this->kulit),true);
		$criteria->compare('LOWER(mata)',strtolower($this->mata),true);
		$criteria->compare('LOWER(telinga)',strtolower($this->telinga),true);
		$criteria->compare('LOWER(hidung)',strtolower($this->hidung),true);
		$criteria->compare('LOWER(leher)',strtolower($this->leher),true);
		$criteria->compare('LOWER(tenggorokan)',strtolower($this->tenggorokan),true);
		$criteria->compare('LOWER(jantung)',strtolower($this->jantung),true);
		$criteria->compare('LOWER(payudara)',strtolower($this->payudara),true);
		$criteria->compare('LOWER(abdomen)',strtolower($this->abdomen),true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('Lila',$this->Lila);
                $criteria->compare('LingkarPinggang',$this->LingkarPinggang);
                $criteria->compare('LingkarPinggul',$this->LingkarPinggul);
                $criteria->compare('TebalLemak',$this->TebalLemak);
				$criteria->compare('TinggiLutut',$this->TinggiLutut);
				$criteria->compare('gcs_jenis',$this->gcs_jenis);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('gcs_id',$this->gcs_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(tglperiksafisik)',strtolower($this->tglperiksafisik),true);
		$criteria->compare('LOWER(keadaanumum)',strtolower($this->keadaanumum),true);
		$criteria->compare('LOWER(inspeksi)',strtolower($this->inspeksi),true);
		$criteria->compare('LOWER(palpasi)',strtolower($this->palpasi),true);
		$criteria->compare('LOWER(perkusi)',strtolower($this->perkusi),true);
		$criteria->compare('LOWER(auskultasi)',strtolower($this->auskultasi),true);
		$criteria->compare('LOWER(tekanandarah)',strtolower($this->tekanandarah),true);
		$criteria->compare('LOWER(detaknadi)',strtolower($this->detaknadi),true);
                $criteria->compare('LOWER(denyutjantung)',strtolower($this->denyutjantung),true);
		$criteria->compare('LOWER(suhutubuh)',strtolower($this->suhutubuh),true);
		$criteria->compare('LOWER(beratbadan_kg)',strtolower($this->beratbadan_kg),true);
		$criteria->compare('LOWER(tinggibadan_cm)',strtolower($this->tinggibadan_cm),true);
		$criteria->compare('LOWER(pernapasan)',strtolower($this->pernapasan),true);
		$criteria->compare('LOWER(paramedis_nama)',strtolower($this->paramedis_nama),true);
		$criteria->compare('LOWER(kelainanpadabagtubuh)',strtolower($this->kelainanpadabagtubuh),true);
		$criteria->compare('LOWER(kulit)',strtolower($this->kulit),true);
		$criteria->compare('LOWER(mata)',strtolower($this->mata),true);
		$criteria->compare('LOWER(telinga)',strtolower($this->telinga),true);
		$criteria->compare('LOWER(hidung)',strtolower($this->hidung),true);
		$criteria->compare('LOWER(leher)',strtolower($this->leher),true);
		$criteria->compare('LOWER(tenggorokan)',strtolower($this->tenggorokan),true);
		$criteria->compare('LOWER(jantung)',strtolower($this->jantung),true);
		$criteria->compare('LOWER(payudara)',strtolower($this->payudara),true);
		$criteria->compare('LOWER(abdomen)',strtolower($this->abdomen),true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('Lila',$this->Lila);
                $criteria->compare('LingkarPinggang',$this->LingkarPinggang);
                $criteria->compare('LingkarPinggul',$this->LingkarPinggul);
                $criteria->compare('TebalLemak',$this->TebalLemak);
                $criteria->compare('TinggiLutut',$this->TinggiLutut);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
//       FUNGSI beforeValidate() dan beforeSave() TIDAK DIGUNAKAN, NILAI DITENTUKAN DICONTROLLER
//             protected function beforeValidate ()
//        {
//            // convert to storage format
//            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
//            $format = new MyFormatter();
//            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
//            foreach($this->metadata->tableSchema->columns as $columnName => $column){
//                    if ($column->dbType == 'date')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }
//                    else if ( $column->dbType == 'timestamp without time zone')
//                        {
//                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
//                        }
//            }
//
//            return parent::beforeValidate ();
//        }
//
//        public function beforeSave() {         
//            if($this->tglperiksafisik===null || trim($this->tglperiksafisik)==''){
//	        $this->setAttribute('tglperiksafisik', null);
//            }
//            return parent::beforeSave();
//        }

        // protected function afterFind(){
        //     foreach($this->metadata->tableSchema->columns as $columnName => $column){

        //         if (!strlen($this->$columnName)) continue;

        //         if ($column->dbType == 'date'){                         
        //                 $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
        //                                 CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
        //                 }elseif ($column->dbType == 'timestamp without time zone'){
        //                         $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
        //                                 CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
        //                 }
        //     }
        //     return true;
        // }
               
        public function getDokterItems($ruangan_id=null){
            if (Yii::app()->user->getState('dokterruangan')==true){
				if(empty($ruangan_id))
					$ruangan_id = Yii::app()->user->getState('ruangan_id');
                if(!empty($ruangan_id))
                    return DokterV::model()->findAllByAttributes(array('pegawai_aktif'=>true,'ruangan_id'=>$ruangan_id),array('order'=>'nama_pegawai'));
                else
                    return array();
            }else{
                //criteria disamakan dengan dokter_v
				$criteria = new CDbCriteria();
				$criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));
				$criteria->addCondition("pegawai_aktif = TRUE");
				$criteria->order = 'nama_pegawai';
                return PegawaiM::model()->findAll($criteria);
            }
        }
        
        public function getAhliGiziItems()
        {
			return PegawaiM::model()->findAllByAttributes(array('kelompokpegawai_id'=>16));
            //return DokterV::model()->findAll();
        }
        
        /**
	* menampilkan paramedis
	* @param type $ruangan_id
	* @return type
	*/
	public function getParamedisItems()
	{
	    $criteria = new CDbCriteria;
	    $criteria->join = 'LEFT JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id LEFT JOIN kelompokpegawai_m ON kelompokpegawai_m.kelompokpegawai_id = pegawai_m.kelompokpegawai_id';
	    $ruangan_id = Yii::app()->user->getState('ruangan_id');
	    $criteria->addCondition('t.ruangan_id='.$ruangan_id);
	    $paramedis = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
	    //$criteria->addCondition('kelompokpegawai_m.kelompokpegawai_id='.$paramedis);
            $criteria->addCondition('kelompokpegawai_m.kelompokpegawai_id <> 1 ');
	    $criteria->order = "pegawai_m.nama_pegawai ASC";
	    return RuanganpegawaiM::model()->findAll($criteria);
	}
}
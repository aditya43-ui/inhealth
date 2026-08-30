<?php

/**
 * Model untuk tabel "evaluasianestesi_pra_t".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'evaluasianestesi_pra_t':
 * @property integer $praevaluasianestesi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $evaluasianestesi_id
 * @property boolean $anamnesadari_pasien
 * @property boolean $anamnesadari_keluarga
 * @property boolean $anamnesadari_lainnya
 * @property string $anamnesadari_lainnya_keterangan
 * @property boolean $riwayatanestesi_ada
 * @property boolean $riwayatanestesi_tidakada
 * @property string $riwayatanestesi_keterangan
 * @property boolean $komplikasi_ada
 * @property boolean $komplikasi_tidakada
 * @property string $komplikasi_keterangan
 * @property string $obatyangdikonsumsi
 * @property boolean $riwayatalergi_ada
 * @property boolean $riwayatalergi_tidakada
 * @property string $riwayatalergi_keterangan
 * @property integer $beratbadan
 * @property integer $tinggibadan
 * @property double $bodymassindex
 * @property integer $tekanandarah_sistolik
 * @property integer $tekanandarah_diastolik
 * @property integer $respiration_rate
 * @property integer $nadi
 * @property integer $skor_nyeri
 * @property double $suhu
 * @property boolean $pernafasan_dbn
 * @property boolean $pernafasan_asma
 * @property boolean $pernafasan_bronkitis
 * @property boolean $pernafasan_ppok
 * @property boolean $pernafasan_dyspnea
 * @property boolean $pernafasan_orthopnea
 * @property boolean $pernafasan_pneumonia
 * @property boolean $pernafasan_batukproduktif
 * @property boolean $pernafasan_ispa
 * @property boolean $pernafasan_sop
 * @property boolean $pernafasan_tuberkulosis
 * @property boolean $pernafasan_efusipleura
 * @property boolean $kardiovaskular_dbn
 * @property boolean $kardiovaskular_ekgabnormal
 * @property boolean $kardiovaskular_angina
 * @property boolean $kardiovaskular_artero_shd
 * @property boolean $kardiovaskular_gagaljantungkongesif
 * @property boolean $kardiovaskular_disritmia
 * @property boolean $kardiovaskular_limitasiaktifitas
 * @property boolean $kardiovaskular_hipertensi
 * @property boolean $kardiovaskular_infarkmyokard
 * @property boolean $kardiovaskular_murmur
 * @property boolean $kardiovaskular_pacemaker
 * @property boolean $kardiovaskular_dememrheuma
 * @property boolean $kardiovaskular_penyakitkatub
 * @property boolean $neura_dbn
 * @property boolean $neura_arthritis
 * @property boolean $neura_backproblem
 * @property boolean $neura_stoke
 * @property boolean $neura_nyerikepala
 * @property boolean $neura_penurunankesadaran
 * @property boolean $neura_kejang
 * @property boolean $neura_kelemahanotot
 * @property boolean $neura_neuromuscular
 * @property boolean $neura_paralis
 * @property boolean $neura_parestesia
 * @property boolean $neura_pingsan
 * @property boolean $renal_diebetmelitus
 * @property boolean $renal_gagalginjal
 * @property boolean $renal_penyakitthyroid
 * @property boolean $renal_retensiurine
 * @property boolean $renal_isk
 * @property boolean $renal_bb_turun
 * @property boolean $hepato_obstruksiusus
 * @property boolean $hepato_sirosis
 * @property boolean $hepato_hepatitis
 * @property boolean $hepato_haitalhernia
 * @property boolean $hepato_mualmuntah
 * @property boolean $hepato_tukakpeptik
 * @property boolean $lainlain_dbn
 * @property boolean $lainlain_anemia
 * @property boolean $lainlain_bleeding
 * @property boolean $lainlain_kanker
 * @property boolean $lainlain_dehidrasi
 * @property boolean $lainlain_hemofilia
 * @property boolean $lainlain_immunosupresan
 * @property boolean $lainlain_kehamilan
 * @property boolean $lainlain_sicklescelldis
 * @property boolean $lainlain_riwayattransfusi
 * @property boolean $lainlain_antikogulan
 * @property boolean $merokok_ya
 * @property boolean $merokok_tidak
 * @property integer $jumlahrokok
 * @property integer $lamamerokok
 * @property boolean $alkohol_ya
 * @property boolean $alkohol_tidak
 * @property integer $lamaminumalkohol
 * @property boolean $evaluasijalannafas_bebas_ya
 * @property boolean $evaluasijalannafas_bebas_tidak
 * @property boolean $evaluasijalannafas_potrusimandibula_ya
 * @property boolean $evaluasijalannafas_potrusimandibula_tidak
 * @property boolean $evaluasijalannafas_bukamulut3jari_ya
 * @property boolean $evaluasijalannafas_bukamulut3jari_tidak
 * @property boolean $evaluasijalannafas_bukamulut2jari_ya
 * @property boolean $evaluasijalannafas_bukamulut2jari_tidak
 * @property boolean $evaluasijalannafas_malaphaty_satu
 * @property boolean $evaluasijalannafas_malaphaty_dua
 * @property boolean $evaluasijalannafas_malaphaty_tiga
 * @property boolean $evaluasijalannafas_malaphaty_empat
 * @property boolean $evaluasijalannafas_gerakleher_bebas
 * @property boolean $evaluasijalannafas_gerakleher_terbata
 * @property boolean $evaluasijalannafas_obesitas_ya
 * @property boolean $evaluasijalannafas_obesitas_tidak
 * @property boolean $evaluasijalannafas_massa_ya
 * @property boolean $evaluasijalannafas_massa_tidak
 * @property boolean $evaluasijalannafas_gigigeligi_keterangan
 * @property boolean $evaluasijalannafas_jalannafassulit_ya
 * @property boolean $evaluasijalannafas_jalannafassulit_tidak
 * @property boolean $evaluasijalannafas_ventilasisulit_ya
 * @property boolean $evaluasijalannafas_ventilasiaulit_tidak
 * @property string $pemeriksaanlab_hb
 * @property string $pemeriksaanlab_fungsiginjal
 * @property string $pemeriksaanlab_fungsihati
 * @property string $pemeriksaanlab_serumelektrolit
 * @property string $pemeriksaanlab_faalhemostatis
 * @property string $pemeriksaanlab_lainlain
 * @property string $pemeriksaanpenunjang_echocardiografi
 * @property string $pemeriksaanpenunjang_ekg
 * @property string $pemeriksaanpenunjang_pencitraan
 * @property string $pemeriksaanpenunjang_evaluasifaalparu
 * @property string $pemeriksaanpenunjang_lainlain
 * @property string $kesimpulanevaluasi_psasa
 * @property string $kesimpulanevaluasi_penyulit
 * @property string $kesimpulanevaluasi_cardiacriskindex
 * @property string $kesimpulanevaluasi_komplikasi
 * @property string $tanggalpemeriksaan
 * @property integer $pegawai_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property EvaluasianestesiT $evaluasianestesi
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 */
class EvaluasianestesiPraT extends CActiveRecord
{
        public $pasienkirimkeunitlain_id, $pegawai_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EvaluasianestesiPraT the static model class
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
		return 'evaluasianestesi_pra_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pasien_id, pendaftaran_id, tanggalpemeriksaan, pegawai_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pasien_id, pendaftaran_id, evaluasianestesi_id, beratbadan, tinggibadan, tekanandarah_sistolik, tekanandarah_diastolik, respiration_rate, nadi, skor_nyeri, jumlahrokok, pegawai_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('bodymassindex, suhu', 'numerical'),
			array('anamnesadari_lainnya_keterangan, lamamerokok, lamaminumalkohol', 'length', 'max'=>250),
			array('riwayatanestesi_keterangan, komplikasi_keterangan, riwayatalergi_keterangan', 'length', 'max'=>100),
			array('obatyangdikonsumsi, pernafasan_keterangan, kardiovaskular_keterangan, neura_keterangan, renal_keterangan, hepato_keterangan, lainlain_keterangan', 'length', 'max'=>500),
			array('pemeriksaanlab_hb, pemeriksaanlab_fungsiginjal, pemeriksaanlab_fungsihati, pemeriksaanlab_serumelektrolit, pemeriksaanlab_faalhemostatis, pemeriksaanlab_lainlain, pemeriksaanpenunjang_echocardiografi, pemeriksaanpenunjang_ekg, pemeriksaanpenunjang_pencitraan, pemeriksaanpenunjang_evaluasifaalparu, pemeriksaanpenunjang_lainlain', 'length', 'max'=>50),
			array('hepato_dbn, renal_dbn, evaluasijalannafas_alat_jalan_nafas, anamnesadari_pasien, anamnesadari_keluarga, anamnesadari_lainnya, riwayatanestesi_ada, riwayatanestesi_tidakada, komplikasi_ada, komplikasi_tidakada, riwayatalergi_ada, riwayatalergi_tidakada, pernafasan_dbn, pernafasan_asma, pernafasan_bronkitis, pernafasan_ppok, pernafasan_dyspnea, pernafasan_orthopnea, pernafasan_pneumonia, pernafasan_batukproduktif, pernafasan_ispa, pernafasan_sop, pernafasan_tuberkulosis, pernafasan_efusipleura, kardiovaskular_dbn, kardiovaskular_ekgabnormal, kardiovaskular_angina, kardiovaskular_artero_shd, kardiovaskular_gagaljantungkongesif, kardiovaskular_disritmia, kardiovaskular_limitasiaktifitas, kardiovaskular_hipertensi, kardiovaskular_infarkmyokard, kardiovaskular_murmur, kardiovaskular_pacemaker, kardiovaskular_dememrheuma, kardiovaskular_penyakitkatub, neura_dbn, neura_arthritis, neura_backproblem, neura_stoke, neura_nyerikepala, neura_penurunankesadaran, neura_kejang, neura_kelemahanotot, neura_neuromuscular, neura_paralis, neura_parestesia, neura_pingsan, renal_diebetmelitus, renal_gagalginjal, renal_penyakitthyroid, renal_retensiurine, renal_isk, renal_bb_turun, hepato_obstruksiusus, hepato_sirosis, hepato_hepatitis, hepato_haitalhernia, hepato_mualmuntah, hepato_tukakpeptik, lainlain_dbn, lainlain_anemia, lainlain_bleeding, lainlain_kanker, lainlain_dehidrasi, lainlain_hemofilia, lainlain_immunosupresan, lainlain_kehamilan, lainlain_sicklescelldis, lainlain_riwayattransfusi, lainlain_antikogulan, merokok_ya, merokok_tidak, alkohol_ya, alkohol_tidak, evaluasijalannafas_bebas_ya, evaluasijalannafas_bebas_tidak, evaluasijalannafas_potrusimandibula_ya, evaluasijalannafas_potrusimandibula_tidak, evaluasijalannafas_bukamulut3jari_ya, evaluasijalannafas_bukamulut3jari_tidak, evaluasijalannafas_bukamulut2jari_ya, evaluasijalannafas_bukamulut2jari_tidak, evaluasijalannafas_malaphaty_satu, evaluasijalannafas_malaphaty_dua, evaluasijalannafas_malaphaty_tiga, evaluasijalannafas_malaphaty_empat, evaluasijalannafas_gerakleher_bebas, evaluasijalannafas_gerakleher_terbata, evaluasijalannafas_obesitas_ya, evaluasijalannafas_obesitas_tidak, evaluasijalannafas_massa_ya, evaluasijalannafas_massa_tidak, evaluasijalannafas_gigigeligi_keterangan, evaluasijalannafas_jalannafassulit_ya, evaluasijalannafas_jalannafassulit_tidak, evaluasijalannafas_ventilasisulit_ya, evaluasijalannafas_ventilasiaulit_tidak, kesimpulanevaluasi_psasa, kesimpulanevaluasi_penyulit, kesimpulanevaluasi_cardiacriskindex, kesimpulanevaluasi_komplikasi, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('praevaluasianestesi_id, pasien_id, pendaftaran_id, evaluasianestesi_id, anamnesadari_pasien, anamnesadari_keluarga, anamnesadari_lainnya, anamnesadari_lainnya_keterangan, riwayatanestesi_ada, riwayatanestesi_tidakada, riwayatanestesi_keterangan, komplikasi_ada, komplikasi_tidakada, komplikasi_keterangan, obatyangdikonsumsi, riwayatalergi_ada, riwayatalergi_tidakada, riwayatalergi_keterangan, beratbadan, tinggibadan, bodymassindex, tekanandarah_sistolik, tekanandarah_diastolik, respiration_rate, nadi, skor_nyeri, suhu, pernafasan_dbn, pernafasan_asma, pernafasan_bronkitis, pernafasan_ppok, pernafasan_dyspnea, pernafasan_orthopnea, pernafasan_pneumonia, pernafasan_batukproduktif, pernafasan_ispa, pernafasan_sop, pernafasan_tuberkulosis, pernafasan_efusipleura, kardiovaskular_dbn, kardiovaskular_ekgabnormal, kardiovaskular_angina, kardiovaskular_artero_shd, kardiovaskular_gagaljantungkongesif, kardiovaskular_disritmia, kardiovaskular_limitasiaktifitas, kardiovaskular_hipertensi, kardiovaskular_infarkmyokard, kardiovaskular_murmur, kardiovaskular_pacemaker, kardiovaskular_dememrheuma, kardiovaskular_penyakitkatub, neura_dbn, neura_arthritis, neura_backproblem, neura_stoke, neura_nyerikepala, neura_penurunankesadaran, neura_kejang, neura_kelemahanotot, neura_neuromuscular, neura_paralis, neura_parestesia, neura_pingsan, renal_diebetmelitus, renal_gagalginjal, renal_penyakitthyroid, renal_retensiurine, renal_isk, renal_bb_turun, hepato_obstruksiusus, hepato_sirosis, hepato_hepatitis, hepato_haitalhernia, hepato_mualmuntah, hepato_tukakpeptik, lainlain_dbn, lainlain_anemia, lainlain_bleeding, lainlain_kanker, lainlain_dehidrasi, lainlain_hemofilia, lainlain_immunosupresan, lainlain_kehamilan, lainlain_sicklescelldis, lainlain_riwayattransfusi, lainlain_antikogulan, merokok_ya, merokok_tidak, jumlahrokok, lamamerokok, alkohol_ya, alkohol_tidak, lamaminumalkohol, evaluasijalannafas_bebas_ya, evaluasijalannafas_bebas_tidak, evaluasijalannafas_potrusimandibula_ya, evaluasijalannafas_potrusimandibula_tidak, evaluasijalannafas_bukamulut3jari_ya, evaluasijalannafas_bukamulut3jari_tidak, evaluasijalannafas_bukamulut2jari_ya, evaluasijalannafas_bukamulut2jari_tidak, evaluasijalannafas_malaphaty_satu, evaluasijalannafas_malaphaty_dua, evaluasijalannafas_malaphaty_tiga, evaluasijalannafas_malaphaty_empat, evaluasijalannafas_gerakleher_bebas, evaluasijalannafas_gerakleher_terbata, evaluasijalannafas_obesitas_ya, evaluasijalannafas_obesitas_tidak, evaluasijalannafas_massa_ya, evaluasijalannafas_massa_tidak, evaluasijalannafas_gigigeligi_keterangan, evaluasijalannafas_jalannafassulit_ya, evaluasijalannafas_jalannafassulit_tidak, evaluasijalannafas_ventilasisulit_ya, evaluasijalannafas_ventilasiaulit_tidak, pemeriksaanlab_hb, pemeriksaanlab_fungsiginjal, pemeriksaanlab_fungsihati, pemeriksaanlab_serumelektrolit, pemeriksaanlab_faalhemostatis, pemeriksaanlab_lainlain, pemeriksaanpenunjang_echocardiografi, pemeriksaanpenunjang_ekg, pemeriksaanpenunjang_pencitraan, pemeriksaanpenunjang_evaluasifaalparu, pemeriksaanpenunjang_lainlain, kesimpulanevaluasi_psasa, kesimpulanevaluasi_penyulit, kesimpulanevaluasi_cardiacriskindex, kesimpulanevaluasi_komplikasi, tanggalpemeriksaan, pegawai_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'evaluasianestesi' => array(self::BELONGS_TO, 'EvaluasianestesiT', 'evaluasianestesi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'praevaluasianestesi_id' => 'Praevaluasianestesi',
			'pasien_id' => 'Pasien',
			'pendaftaran_id' => 'Pendaftaran',
			'evaluasianestesi_id' => 'Evaluasianestesi',
			'anamnesadari_pasien' => 'Anamnesadari Pasien',
			'anamnesadari_keluarga' => 'Anamnesadari Keluarga',
			'anamnesadari_lainnya' => 'Anamnesadari Lainnya',
			'anamnesadari_lainnya_keterangan' => 'Anamnesadari Lainnya Keterangan',
			'riwayatanestesi_ada' => 'Riwayatanestesi Ada',
			'riwayatanestesi_tidakada' => 'Riwayatanestesi Tidakada',
			'riwayatanestesi_keterangan' => 'Riwayatanestesi Keterangan',
			'komplikasi_ada' => 'Komplikasi Ada',
			'komplikasi_tidakada' => 'Komplikasi Tidakada',
			'komplikasi_keterangan' => 'Komplikasi Keterangan',
			'obatyangdikonsumsi' => 'Obatyangdikonsumsi',
			'riwayatalergi_ada' => 'Riwayatalergi Ada',
			'riwayatalergi_tidakada' => 'Riwayatalergi Tidakada',
			'riwayatalergi_keterangan' => 'Riwayatalergi Keterangan',
			'beratbadan' => 'Beratbadan',
			'tinggibadan' => 'Tinggibadan',
			'bodymassindex' => 'Bodymassindex',
			'tekanandarah_sistolik' => 'Tekanandarah Sistolik',
			'tekanandarah_diastolik' => 'Tekanandarah Diastolik',
			'respiration_rate' => 'Respiration Rate',
			'nadi' => 'Nadi',
			'skor_nyeri' => 'Skor Nyeri',
			'suhu' => 'Suhu',
			'pernafasan_dbn' => 'Pernafasan Dbn',
			'pernafasan_asma' => 'Pernafasan Asma',
			'pernafasan_bronkitis' => 'Pernafasan Bronkitis',
			'pernafasan_ppok' => 'Pernafasan Ppok',
			'pernafasan_dyspnea' => 'Pernafasan Dyspnea',
			'pernafasan_orthopnea' => 'Pernafasan Orthopnea',
			'pernafasan_pneumonia' => 'Pernafasan Pneumonia',
			'pernafasan_batukproduktif' => 'Pernafasan Batukproduktif',
			'pernafasan_ispa' => 'Pernafasan Ispa',
			'pernafasan_sop' => 'Pernafasan Sop',
			'pernafasan_tuberkulosis' => 'Pernafasan Tuberkulosis',
			'pernafasan_efusipleura' => 'Pernafasan Efusipleura',
			'kardiovaskular_dbn' => 'Kardiovaskular Dbn',
			'kardiovaskular_ekgabnormal' => 'Kardiovaskular Ekgabnormal',
			'kardiovaskular_angina' => 'Kardiovaskular Angina',
			'kardiovaskular_artero_shd' => 'Kardiovaskular Artero Shd',
			'kardiovaskular_gagaljantungkongesif' => 'Kardiovaskular Gagaljantungkongesif',
			'kardiovaskular_disritmia' => 'Kardiovaskular Disritmia',
			'kardiovaskular_limitasiaktifitas' => 'Kardiovaskular Limitasiaktifitas',
			'kardiovaskular_hipertensi' => 'Kardiovaskular Hipertensi',
			'kardiovaskular_infarkmyokard' => 'Kardiovaskular Infarkmyokard',
			'kardiovaskular_murmur' => 'Kardiovaskular Murmur',
			'kardiovaskular_pacemaker' => 'Kardiovaskular Pacemaker',
			'kardiovaskular_dememrheuma' => 'Kardiovaskular Dememrheuma',
			'kardiovaskular_penyakitkatub' => 'Kardiovaskular Penyakitkatub',
			'neura_dbn' => 'Neura Dbn',
			'neura_arthritis' => 'Neura Arthritis',
			'neura_backproblem' => 'Neura Backproblem',
			'neura_stoke' => 'Neura Stoke',
			'neura_nyerikepala' => 'Neura Nyerikepala',
			'neura_penurunankesadaran' => 'Neura Penurunankesadaran',
			'neura_kejang' => 'Neura Kejang',
			'neura_kelemahanotot' => 'Neura Kelemahanotot',
			'neura_neuromuscular' => 'Neura Neuromuscular',
			'neura_paralis' => 'Neura Paralis',
			'neura_parestesia' => 'Neura Parestesia',
			'neura_pingsan' => 'Neura Pingsan',
			'renal_diebetmelitus' => 'Renal Diebetmelitus',
			'renal_gagalginjal' => 'Renal Gagalginjal',
			'renal_penyakitthyroid' => 'Renal Penyakitthyroid',
			'renal_retensiurine' => 'Renal Retensiurine',
			'renal_isk' => 'Renal Isk',
			'renal_bb_turun' => 'Renal Bb Turun',
			'hepato_obstruksiusus' => 'Hepato Obstruksiusus',
			'hepato_sirosis' => 'Hepato Sirosis',
			'hepato_hepatitis' => 'Hepato Hepatitis',
			'hepato_haitalhernia' => 'Hepato Haitalhernia',
			'hepato_mualmuntah' => 'Hepato Mualmuntah',
			'hepato_tukakpeptik' => 'Hepato Tukakpeptik',
			'lainlain_dbn' => 'Lainlain Dbn',
			'lainlain_anemia' => 'Lainlain Anemia',
			'lainlain_bleeding' => 'Lainlain Bleeding',
			'lainlain_kanker' => 'Lainlain Kanker',
			'lainlain_dehidrasi' => 'Lainlain Dehidrasi',
			'lainlain_hemofilia' => 'Lainlain Hemofilia',
			'lainlain_immunosupresan' => 'Lainlain Immunosupresan',
			'lainlain_kehamilan' => 'Lainlain Kehamilan',
			'lainlain_sicklescelldis' => 'Lainlain Sicklescelldis',
			'lainlain_riwayattransfusi' => 'Lainlain Riwayattransfusi',
			'lainlain_antikogulan' => 'Lainlain Antikogulan',
			'merokok_ya' => 'Merokok Ya',
			'merokok_tidak' => 'Merokok Tidak',
			'jumlahrokok' => 'Jumlahrokok',
			'lamamerokok' => 'Lamamerokok',
			'alkohol_ya' => 'Alkohol Ya',
			'alkohol_tidak' => 'Alkohol Tidak',
			'lamaminumalkohol' => 'Lamaminumalkohol',
			'evaluasijalannafas_bebas_ya' => 'Evaluasijalannafas Bebas Ya',
			'evaluasijalannafas_bebas_tidak' => 'Evaluasijalannafas Bebas Tidak',
			'evaluasijalannafas_potrusimandibula_ya' => 'Evaluasijalannafas Potrusimandibula Ya',
			'evaluasijalannafas_potrusimandibula_tidak' => 'Evaluasijalannafas Potrusimandibula Tidak',
			'evaluasijalannafas_bukamulut3jari_ya' => 'Evaluasijalannafas Bukamulut3jari Ya',
			'evaluasijalannafas_bukamulut3jari_tidak' => 'Evaluasijalannafas Bukamulut3jari Tidak',
			'evaluasijalannafas_bukamulut2jari_ya' => 'Evaluasijalannafas Bukamulut2jari Ya',
			'evaluasijalannafas_bukamulut2jari_tidak' => 'Evaluasijalannafas Bukamulut2jari Tidak',
			'evaluasijalannafas_malaphaty_satu' => 'Evaluasijalannafas Malaphaty Satu',
			'evaluasijalannafas_malaphaty_dua' => 'Evaluasijalannafas Malaphaty Dua',
			'evaluasijalannafas_malaphaty_tiga' => 'Evaluasijalannafas Malaphaty Tiga',
			'evaluasijalannafas_malaphaty_empat' => 'Evaluasijalannafas Malaphaty Empat',
			'evaluasijalannafas_gerakleher_bebas' => 'Evaluasijalannafas Gerakleher Bebas',
			'evaluasijalannafas_gerakleher_terbata' => 'Evaluasijalannafas Gerakleher Terbata',
			'evaluasijalannafas_obesitas_ya' => 'Evaluasijalannafas Obesitas Ya',
			'evaluasijalannafas_obesitas_tidak' => 'Evaluasijalannafas Obesitas Tidak',
			'evaluasijalannafas_massa_ya' => 'Evaluasijalannafas Massa Ya',
			'evaluasijalannafas_massa_tidak' => 'Evaluasijalannafas Massa Tidak',
			'evaluasijalannafas_gigigeligi_keterangan' => 'Evaluasijalannafas Gigigeligi Keterangan',
			'evaluasijalannafas_jalannafassulit_ya' => 'Evaluasijalannafas Jalannafassulit Ya',
			'evaluasijalannafas_jalannafassulit_tidak' => 'Evaluasijalannafas Jalannafassulit Tidak',
			'evaluasijalannafas_ventilasisulit_ya' => 'Evaluasijalannafas Ventilasisulit Ya',
			'evaluasijalannafas_ventilasiaulit_tidak' => 'Evaluasijalannafas Ventilasiaulit Tidak',
			'pemeriksaanlab_hb' => 'Pemeriksaanlab Hb',
			'pemeriksaanlab_fungsiginjal' => 'Pemeriksaanlab Fungsiginjal',
			'pemeriksaanlab_fungsihati' => 'Pemeriksaanlab Fungsihati',
			'pemeriksaanlab_serumelektrolit' => 'Pemeriksaanlab Serumelektrolit',
			'pemeriksaanlab_faalhemostatis' => 'Pemeriksaanlab Faalhemostatis',
			'pemeriksaanlab_lainlain' => 'Pemeriksaanlab Lainlain',
			'pemeriksaanpenunjang_echocardiografi' => 'Pemeriksaanpenunjang Echocardiografi',
			'pemeriksaanpenunjang_ekg' => 'Pemeriksaanpenunjang Ekg',
			'pemeriksaanpenunjang_pencitraan' => 'Pemeriksaanpenunjang Pencitraan',
			'pemeriksaanpenunjang_evaluasifaalparu' => 'Pemeriksaanpenunjang Evaluasifaalparu',
			'pemeriksaanpenunjang_lainlain' => 'Pemeriksaanpenunjang Lainlain',
			'kesimpulanevaluasi_psasa' => 'Kesimpulanevaluasi Psasa',
			'kesimpulanevaluasi_penyulit' => 'Kesimpulanevaluasi Penyulit',
			'kesimpulanevaluasi_cardiacriskindex' => 'Kesimpulanevaluasi Cardiacriskindex',
			'kesimpulanevaluasi_komplikasi' => 'Kesimpulanevaluasi Komplikasi',
			'tanggalpemeriksaan' => 'Tanggalpemeriksaan',
			'pegawai_id' => 'Pegawai',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
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

		$criteria->compare('praevaluasianestesi_id',$this->praevaluasianestesi_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('evaluasianestesi_id',$this->evaluasianestesi_id);
		$criteria->compare('anamnesadari_pasien',$this->anamnesadari_pasien);
		$criteria->compare('anamnesadari_keluarga',$this->anamnesadari_keluarga);
		$criteria->compare('anamnesadari_lainnya',$this->anamnesadari_lainnya);
		$criteria->compare('anamnesadari_lainnya_keterangan',$this->anamnesadari_lainnya_keterangan,true);
		$criteria->compare('riwayatanestesi_ada',$this->riwayatanestesi_ada);
		$criteria->compare('riwayatanestesi_tidakada',$this->riwayatanestesi_tidakada);
		$criteria->compare('riwayatanestesi_keterangan',$this->riwayatanestesi_keterangan,true);
		$criteria->compare('komplikasi_ada',$this->komplikasi_ada);
		$criteria->compare('komplikasi_tidakada',$this->komplikasi_tidakada);
		$criteria->compare('komplikasi_keterangan',$this->komplikasi_keterangan,true);
		$criteria->compare('obatyangdikonsumsi',$this->obatyangdikonsumsi,true);
		$criteria->compare('riwayatalergi_ada',$this->riwayatalergi_ada);
		$criteria->compare('riwayatalergi_tidakada',$this->riwayatalergi_tidakada);
		$criteria->compare('riwayatalergi_keterangan',$this->riwayatalergi_keterangan,true);
		$criteria->compare('beratbadan',$this->beratbadan);
		$criteria->compare('tinggibadan',$this->tinggibadan);
		$criteria->compare('bodymassindex',$this->bodymassindex);
		$criteria->compare('tekanandarah_sistolik',$this->tekanandarah_sistolik);
		$criteria->compare('tekanandarah_diastolik',$this->tekanandarah_diastolik);
		$criteria->compare('respiration_rate',$this->respiration_rate);
		$criteria->compare('nadi',$this->nadi);
		$criteria->compare('skor_nyeri',$this->skor_nyeri);
		$criteria->compare('suhu',$this->suhu);
		$criteria->compare('pernafasan_dbn',$this->pernafasan_dbn);
		$criteria->compare('pernafasan_asma',$this->pernafasan_asma);
		$criteria->compare('pernafasan_bronkitis',$this->pernafasan_bronkitis);
		$criteria->compare('pernafasan_ppok',$this->pernafasan_ppok);
		$criteria->compare('pernafasan_dyspnea',$this->pernafasan_dyspnea);
		$criteria->compare('pernafasan_orthopnea',$this->pernafasan_orthopnea);
		$criteria->compare('pernafasan_pneumonia',$this->pernafasan_pneumonia);
		$criteria->compare('pernafasan_batukproduktif',$this->pernafasan_batukproduktif);
		$criteria->compare('pernafasan_ispa',$this->pernafasan_ispa);
		$criteria->compare('pernafasan_sop',$this->pernafasan_sop);
		$criteria->compare('pernafasan_tuberkulosis',$this->pernafasan_tuberkulosis);
		$criteria->compare('pernafasan_efusipleura',$this->pernafasan_efusipleura);
		$criteria->compare('kardiovaskular_dbn',$this->kardiovaskular_dbn);
		$criteria->compare('kardiovaskular_ekgabnormal',$this->kardiovaskular_ekgabnormal);
		$criteria->compare('kardiovaskular_angina',$this->kardiovaskular_angina);
		$criteria->compare('kardiovaskular_artero_shd',$this->kardiovaskular_artero_shd);
		$criteria->compare('kardiovaskular_gagaljantungkongesif',$this->kardiovaskular_gagaljantungkongesif);
		$criteria->compare('kardiovaskular_disritmia',$this->kardiovaskular_disritmia);
		$criteria->compare('kardiovaskular_limitasiaktifitas',$this->kardiovaskular_limitasiaktifitas);
		$criteria->compare('kardiovaskular_hipertensi',$this->kardiovaskular_hipertensi);
		$criteria->compare('kardiovaskular_infarkmyokard',$this->kardiovaskular_infarkmyokard);
		$criteria->compare('kardiovaskular_murmur',$this->kardiovaskular_murmur);
		$criteria->compare('kardiovaskular_pacemaker',$this->kardiovaskular_pacemaker);
		$criteria->compare('kardiovaskular_dememrheuma',$this->kardiovaskular_dememrheuma);
		$criteria->compare('kardiovaskular_penyakitkatub',$this->kardiovaskular_penyakitkatub);
		$criteria->compare('neura_dbn',$this->neura_dbn);
		$criteria->compare('neura_arthritis',$this->neura_arthritis);
		$criteria->compare('neura_backproblem',$this->neura_backproblem);
		$criteria->compare('neura_stoke',$this->neura_stoke);
		$criteria->compare('neura_nyerikepala',$this->neura_nyerikepala);
		$criteria->compare('neura_penurunankesadaran',$this->neura_penurunankesadaran);
		$criteria->compare('neura_kejang',$this->neura_kejang);
		$criteria->compare('neura_kelemahanotot',$this->neura_kelemahanotot);
		$criteria->compare('neura_neuromuscular',$this->neura_neuromuscular);
		$criteria->compare('neura_paralis',$this->neura_paralis);
		$criteria->compare('neura_parestesia',$this->neura_parestesia);
		$criteria->compare('neura_pingsan',$this->neura_pingsan);
		$criteria->compare('renal_diebetmelitus',$this->renal_diebetmelitus);
		$criteria->compare('renal_gagalginjal',$this->renal_gagalginjal);
		$criteria->compare('renal_penyakitthyroid',$this->renal_penyakitthyroid);
		$criteria->compare('renal_retensiurine',$this->renal_retensiurine);
		$criteria->compare('renal_isk',$this->renal_isk);
		$criteria->compare('renal_bb_turun',$this->renal_bb_turun);
		$criteria->compare('hepato_obstruksiusus',$this->hepato_obstruksiusus);
		$criteria->compare('hepato_sirosis',$this->hepato_sirosis);
		$criteria->compare('hepato_hepatitis',$this->hepato_hepatitis);
		$criteria->compare('hepato_haitalhernia',$this->hepato_haitalhernia);
		$criteria->compare('hepato_mualmuntah',$this->hepato_mualmuntah);
		$criteria->compare('hepato_tukakpeptik',$this->hepato_tukakpeptik);
		$criteria->compare('lainlain_dbn',$this->lainlain_dbn);
		$criteria->compare('lainlain_anemia',$this->lainlain_anemia);
		$criteria->compare('lainlain_bleeding',$this->lainlain_bleeding);
		$criteria->compare('lainlain_kanker',$this->lainlain_kanker);
		$criteria->compare('lainlain_dehidrasi',$this->lainlain_dehidrasi);
		$criteria->compare('lainlain_hemofilia',$this->lainlain_hemofilia);
		$criteria->compare('lainlain_immunosupresan',$this->lainlain_immunosupresan);
		$criteria->compare('lainlain_kehamilan',$this->lainlain_kehamilan);
		$criteria->compare('lainlain_sicklescelldis',$this->lainlain_sicklescelldis);
		$criteria->compare('lainlain_riwayattransfusi',$this->lainlain_riwayattransfusi);
		$criteria->compare('lainlain_antikogulan',$this->lainlain_antikogulan);
		$criteria->compare('merokok_ya',$this->merokok_ya);
		$criteria->compare('merokok_tidak',$this->merokok_tidak);
		$criteria->compare('jumlahrokok',$this->jumlahrokok);
		$criteria->compare('lamamerokok',$this->lamamerokok);
		$criteria->compare('alkohol_ya',$this->alkohol_ya);
		$criteria->compare('alkohol_tidak',$this->alkohol_tidak);
		$criteria->compare('lamaminumalkohol',$this->lamaminumalkohol);
		$criteria->compare('evaluasijalannafas_bebas_ya',$this->evaluasijalannafas_bebas_ya);
		$criteria->compare('evaluasijalannafas_bebas_tidak',$this->evaluasijalannafas_bebas_tidak);
		$criteria->compare('evaluasijalannafas_potrusimandibula_ya',$this->evaluasijalannafas_potrusimandibula_ya);
		$criteria->compare('evaluasijalannafas_potrusimandibula_tidak',$this->evaluasijalannafas_potrusimandibula_tidak);
		$criteria->compare('evaluasijalannafas_bukamulut3jari_ya',$this->evaluasijalannafas_bukamulut3jari_ya);
		$criteria->compare('evaluasijalannafas_bukamulut3jari_tidak',$this->evaluasijalannafas_bukamulut3jari_tidak);
		$criteria->compare('evaluasijalannafas_bukamulut2jari_ya',$this->evaluasijalannafas_bukamulut2jari_ya);
		$criteria->compare('evaluasijalannafas_bukamulut2jari_tidak',$this->evaluasijalannafas_bukamulut2jari_tidak);
		$criteria->compare('evaluasijalannafas_malaphaty_satu',$this->evaluasijalannafas_malaphaty_satu);
		$criteria->compare('evaluasijalannafas_malaphaty_dua',$this->evaluasijalannafas_malaphaty_dua);
		$criteria->compare('evaluasijalannafas_malaphaty_tiga',$this->evaluasijalannafas_malaphaty_tiga);
		$criteria->compare('evaluasijalannafas_malaphaty_empat',$this->evaluasijalannafas_malaphaty_empat);
		$criteria->compare('evaluasijalannafas_gerakleher_bebas',$this->evaluasijalannafas_gerakleher_bebas);
		$criteria->compare('evaluasijalannafas_gerakleher_terbata',$this->evaluasijalannafas_gerakleher_terbata);
		$criteria->compare('evaluasijalannafas_obesitas_ya',$this->evaluasijalannafas_obesitas_ya);
		$criteria->compare('evaluasijalannafas_obesitas_tidak',$this->evaluasijalannafas_obesitas_tidak);
		$criteria->compare('evaluasijalannafas_massa_ya',$this->evaluasijalannafas_massa_ya);
		$criteria->compare('evaluasijalannafas_massa_tidak',$this->evaluasijalannafas_massa_tidak);
		$criteria->compare('evaluasijalannafas_gigigeligi_keterangan',$this->evaluasijalannafas_gigigeligi_keterangan);
		$criteria->compare('evaluasijalannafas_jalannafassulit_ya',$this->evaluasijalannafas_jalannafassulit_ya);
		$criteria->compare('evaluasijalannafas_jalannafassulit_tidak',$this->evaluasijalannafas_jalannafassulit_tidak);
		$criteria->compare('evaluasijalannafas_ventilasisulit_ya',$this->evaluasijalannafas_ventilasisulit_ya);
		$criteria->compare('evaluasijalannafas_ventilasiaulit_tidak',$this->evaluasijalannafas_ventilasiaulit_tidak);
		$criteria->compare('pemeriksaanlab_hb',$this->pemeriksaanlab_hb,true);
		$criteria->compare('pemeriksaanlab_fungsiginjal',$this->pemeriksaanlab_fungsiginjal,true);
		$criteria->compare('pemeriksaanlab_fungsihati',$this->pemeriksaanlab_fungsihati,true);
		$criteria->compare('pemeriksaanlab_serumelektrolit',$this->pemeriksaanlab_serumelektrolit,true);
		$criteria->compare('pemeriksaanlab_faalhemostatis',$this->pemeriksaanlab_faalhemostatis,true);
		$criteria->compare('pemeriksaanlab_lainlain',$this->pemeriksaanlab_lainlain,true);
		$criteria->compare('pemeriksaanpenunjang_echocardiografi',$this->pemeriksaanpenunjang_echocardiografi,true);
		$criteria->compare('pemeriksaanpenunjang_ekg',$this->pemeriksaanpenunjang_ekg,true);
		$criteria->compare('pemeriksaanpenunjang_pencitraan',$this->pemeriksaanpenunjang_pencitraan,true);
		$criteria->compare('pemeriksaanpenunjang_evaluasifaalparu',$this->pemeriksaanpenunjang_evaluasifaalparu,true);
		$criteria->compare('pemeriksaanpenunjang_lainlain',$this->pemeriksaanpenunjang_lainlain,true);
		$criteria->compare('kesimpulanevaluasi_psasa',$this->kesimpulanevaluasi_psasa,true);
		$criteria->compare('kesimpulanevaluasi_penyulit',$this->kesimpulanevaluasi_penyulit,true);
		$criteria->compare('kesimpulanevaluasi_cardiacriskindex',$this->kesimpulanevaluasi_cardiacriskindex,true);
		$criteria->compare('kesimpulanevaluasi_komplikasi',$this->kesimpulanevaluasi_komplikasi,true);
		$criteria->compare('tanggalpemeriksaan',$this->tanggalpemeriksaan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
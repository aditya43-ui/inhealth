<?php

/**
 * This is the model class for table "asesmen_awal_medis_t".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'asesmen_awal_medis_t':
 * @property integer $asesmen_awal_medis_id
 * @property string $tglmasuk_rs
 * @property string $tgl_pemeriksaan
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property boolean $pasiendari_irj
 * @property boolean $pasiendari_igd
 * @property boolean $pasiendari_rujukan
 * @property boolean $pasiendari_lainnya
 * @property string $pasiendari_lainnya_keterangan
 * @property integer $diagnosa_id
 * @property boolean $alasandirawat_observasi
 * @property boolean $alasandirawat_prosesdiagnostik
 * @property boolean $alasandirawat_terapi
 * @property boolean $alasandirawat_rehabilitasi
 * @property string $keluhan_utama
 * @property string $riwayat_penyakit_sekarang
 * @property boolean $riwayat_sakit_dulu_diabetes
 * @property boolean $riwayat_sakit_dulu_hipertensi
 * @property boolean $riwayat_sakit_dulu_jantung
 * @property boolean $riwayat_sakit_dulu_tidakada
 * @property boolean $riwayat_sakit_dulu_lainnya
 * @property string $riwayat_sakit_dulu_lainnya_ket
 * @property boolean $riwayas_sakit_keluarga_diabetes
 * @property boolean $riwayas_sakit_keluarga_hipertensi
 * @property boolean $riwayas_sakit_keluarga_jantung
 * @property boolean $riwayas_sakit_keluarga_tidakada
 * @property boolean $riwayas_sakit_keluarga_lainnya
 * @property string $riwayat_sakit_keluarga_lainnya_ket
 * @property boolean $status_psikososial_pakai_napza
 * @property boolean $status_psikososial_cobabunuhdiri
 * @property boolean $status_psikososial_kdrt
 * @property boolean $status_psikososial_agresif
 * @property boolean $status_psikososial_tidakkooperatif
 * @property boolean $statusfungsional_mandiri
 * @property boolean $statusfungsional_tirahbaringparsial
 * @property boolean $statusfungsional_tirahbaringtotal
 * @property boolean $kesadarankualitatif_composmentis
 * @property boolean $kesadarankualitatif_apatis
 * @property boolean $kesadarankualitatif_delirum
 * @property boolean $kesadarankualitatif_koma
 * @property integer $kesadarankuantitatif_gcs_eye
 * @property integer $kesadarankuantitatif_gcs_verbal
 * @property integer $kesadarankuantitatif_gcs_motorik
 * @property integer $beratbadan
 * @property integer $tinggibadan
 * @property integer $luasbadan
 * @property boolean $kondisikhusus_normal
 * @property boolean $kondisikhusus_anemis
 * @property boolean $kondisikhusus_icterus
 * @property boolean $kondisikhusus_sianosis
 * @property boolean $kondisikhusus_lainnya
 * @property string $kondisikhusus_lainnya_ket
 * @property integer $tekanandarah_sistolok
 * @property integer $tekanandarah_diastolik
 * @property integer $nadi
 * @property integer $pernafasan
 * @property integer $suhu
 * @property boolean $nyeri_ada
 * @property boolean $nyeri_tidakada
 * @property boolean $kepala_normal
 * @property boolean $kepala_tidaknormal
 * @property string $kepala_tidaknormal_ket
 * @property boolean $mata_normal
 * @property boolean $mata_tidaknormal
 * @property string $mata_tidaknormal_ket
 * @property boolean $tht_normal
 * @property boolean $tht_tidaknormal
 * @property string $tht_tidaknormal_ket
 * @property boolean $leher_normal
 * @property boolean $leher_tidaknormal
 * @property string $leher_tidaknormal_ket
 * @property boolean $mulut_normal
 * @property boolean $mulut_tidaknormal
 * @property string $mulut_tidaknormal_ket
 * @property boolean $jantung_pb_normal
 * @property boolean $jantung_pb_tidaknormal
 * @property string $jantung_pb_tidaknormal_ket
 * @property boolean $thorax_paru_payudara_normal
 * @property boolean $thorax_paru_payudara_tidaknormal
 * @property string $thorax_paru_payudara_tidaknormal_ket
 * @property boolean $abdomen_normal
 * @property boolean $abdomen_tidaknormal
 * @property string $abdomen_tidaknormal_ket
 * @property boolean $kulit_normal
 * @property boolean $kulit_tidaknormal
 * @property string $kulit_tidaknormal_ket
 * @property boolean $tulang_anggotatubuh_normal
 * @property boolean $tulang_anggotatubuh_tidaknormal
 * @property string $tulang_anggotatubuh_tidaknormal_ket
 * @property boolean $sistemsaraf_normal
 * @property boolean $sistemsaraf_tidaknormal
 * @property string $sistemsaraf_tidaknormal_ket
 * @property boolean $genitalia_normal
 * @property boolean $genitalia_tidaknormal
 * @property string $genitalia_tidaknormal_ket
 * @property integer $pemeriksaangambar_id
 * @property boolean $laboratorium_normal
 * @property boolean $laboratorium_tidaknormal
 * @property string $laboratorium_tidaknormal_ket
 * @property boolean $radiologi_thorax_normal
 * @property boolean $radiologi_thorax_tidaknormal
 * @property string $radiologi_thorax_tidaknormal_ket
 * @property boolean $radiologi_ctscan_normal
 * @property boolean $radiologi_ctscan_tidaknormal
 * @property string $radiologi_ctscan_tidaknormal_ket
 * @property boolean $radiologi_mri_normal
 * @property boolean $radiologi_mri_tidaknormal
 * @property string $radiologi_mri_tidaknormal_ket
 * @property boolean $radiologi_usg_normal
 * @property boolean $radiologi_usg_tidaknormal
 * @property string $radiologi_usg_tidaknormal_ket
 * @property string $radiologi
 * @property string $diagnosisawal
 * @property string $diagnosisbanding
 * @property integer $dokterpemeriksa_id
 * @property integer $dokterdpjp_id
 */
class AsesmenAwalMedisT extends CActiveRecord
{
    public $bodymassindex_nama,$diagnosa_nama, $ppds_nama , $dokterdpjp_nama, $atropometri_beratbadan2, $atropometri_tinggibadan2, $dokterpemeriksa_nama, $ruangan_asal_nama, $konsultan_nefrologi_nama, $tinggi_badan;
    public $masalah_perkawinan_keterangan_1;
    public $set_obat_alkes_pasien, $set_riwayat_obat_sebelum;
    public $set_periksa_lab_dari_luar;
    public $set_akses_vaskular;
    public $set_periksa_internal_lab, $set_periksa_internal_rad;
    public $set_diagnosa_morbiditas;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsesmenAwalMedisT the static model class
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
        return 'asesmen_awal_medis_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendaftaran_id, pasien_id ,keluhan_utama,dokterpemeriksa_id,dokterdpjp_id', 'required'),
            array('pendaftaran_id, pasien_id, diagnosa_id, kesadarankuantitatif_gcs_eye, kesadarankuantitatif_gcs_verbal, kesadarankuantitatif_gcs_motorik, tinggibadan, tekanandarah_sistolok, tekanandarah_diastolik, nadi, pernafasan, suhu, pemeriksaangambar_id, dokterpemeriksa_id, dokterdpjp_id', 'numerical', 'integerOnly' => true),
            array('pasiendari_lainnya_keterangan, riwayat_sakit_dulu_lainnya_ket, riwayat_sakit_keluarga_lainnya_ket, kondisikhusus_lainnya_ket, kepala_tidaknormal_ket, mata_tidaknormal_ket, tht_tidaknormal_ket, leher_tidaknormal_ket, mulut_tidaknormal_ket, jantung_pb_tidaknormal_ket, thorax_paru_payudara_tidaknormal_ket, abdomen_tidaknormal_ket, kulit_tidaknormal_ket, tulang_anggotatubuh_tidaknormal_ket, sistemsaraf_tidaknormal_ket, genitalia_tidaknormal_ket, laboratorium_tidaknormal_ket, radiologi_thorax_tidaknormal_ket, radiologi_ctscan_tidaknormal_ket, radiologi_mri_tidaknormal_ket, radiologi_usg_tidaknormal_ket', 'length', 'max' => 100),
            array('radiologi', 'length', 'max' => 200),
            array('diagnosisawal, diagnosisbanding', 'length', 'max' => 250),
            array('ppds_id, pemeriksaanpenunjang_ket, status_psikososial_lainnya_ket, status_psikososial_lainnya, status_psikososial_tidakbermasalah, riwayat_sakit_keluarga_diabetes, riwayat_sakit_keluarga_hipertensi, riwayat_sakit_keluarga_jantung, riwayat_sakit_keluarga_tidakada,  riwayat_sakit_keluarga_lainnya, riwayat_sakit_keluarga_lainnya_ket, riwayatalergi_obat, riwayatalergi_obatket, riwayatalergi_makanan, riwayatalergi_makananket, tglmasuk_rs, tgl_pemeriksaan, pasiendari_irj, pasiendari_igd, pasiendari_rujukan, pasiendari_lainnya, alasandirawat_observasi, alasandirawat_prosesdiagnostik, alasandirawat_terapi, alasandirawat_rehabilitasi, keluhan_utama, riwayat_penyakit_sekarang, riwayat_sakit_dulu_diabetes, riwayat_sakit_dulu_hipertensi, riwayat_sakit_dulu_jantung, riwayat_sakit_dulu_tidakada, riwayat_sakit_dulu_lainnya, riwayas_sakit_keluarga_diabetes, riwayas_sakit_keluarga_hipertensi, riwayas_sakit_keluarga_jantung, riwayas_sakit_keluarga_tidakada, riwayas_sakit_keluarga_lainnya, status_psikososial_pakai_napza, status_psikososial_cobabunuhdiri, status_psikososial_kdrt, status_psikososial_agresif, status_psikososial_tidakkooperatif, statusfungsional_mandiri, statusfungsional_tirahbaringparsial, statusfungsional_tirahbaringtotal, kesadarankualitatif_composmentis, kesadarankualitatif_apatis, kesadarankualitatif_delirum, kesadarankualitatif_koma, kondisikhusus_normal, kondisikhusus_anemis, kondisikhusus_icterus, kondisikhusus_sianosis, kondisikhusus_lainnya, nyeri_ada, nyeri_tidakada, kepala_normal, kepala_tidaknormal, mata_normal, mata_tidaknormal, tht_normal, tht_tidaknormal, leher_normal, leher_tidaknormal, mulut_normal, mulut_tidaknormal, jantung_pb_normal, jantung_pb_tidaknormal, thorax_paru_payudara_normal, thorax_paru_payudara_tidaknormal, abdomen_normal, abdomen_tidaknormal, kulit_normal, kulit_tidaknormal, tulang_anggotatubuh_normal, tulang_anggotatubuh_tidaknormal, sistemsaraf_normal, sistemsaraf_tidaknormal, genitalia_normal, genitalia_tidaknormal, laboratorium_normal, laboratorium_tidaknormal, radiologi_thorax_normal, radiologi_thorax_tidaknormal, radiologi_ctscan_normal, radiologi_ctscan_tidaknormal, radiologi_mri_normal, radiologi_mri_tidaknormal, radiologi_usg_normal, radiologi_usg_tidaknormal,nilai_bmi,bodymassindex_id', 'safe'),
            ['dialisis_pertama_pada, is_keluhan_nyeridada, is_keluhan_sesak, is_keluhan_sakitperut, is_keluhan_demam, is_keluhan_bengkak, is_keluhan_lainnya, keterangan_keluhan_lainnya, keluhan_nyeridada_sejak, keluhan_sesak_sejak, keluhan_sakitperut_sejak, keluhan_demam_sejak, keluhan_bengkak_sejak, keluhan_lainnya_sejak, riwayat_sakit_skr_diabetes, riwayat_sakit_skr_hipertensi, riwayat_sakit_skr_jantung, riwayat_sakit_skr_tidakada ,riwayat_sakit_skr_lainnya, riwayat_sakit_skr_lainnya_ket','safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('asesmen_awal_medis_id, tglmasuk_rs, tgl_pemeriksaan, pendaftaran_id, pasien_id, pasiendari_irj, pasiendari_igd, pasiendari_rujukan, pasiendari_lainnya, pasiendari_lainnya_keterangan, diagnosa_id, alasandirawat_observasi, alasandirawat_prosesdiagnostik, alasandirawat_terapi, alasandirawat_rehabilitasi, keluhan_utama, riwayat_penyakit_sekarang, riwayat_sakit_dulu_diabetes, riwayat_sakit_dulu_hipertensi, riwayat_sakit_dulu_jantung, riwayat_sakit_dulu_tidakada, riwayat_sakit_dulu_lainnya, riwayat_sakit_dulu_lainnya_ket, riwayas_sakit_keluarga_diabetes, riwayas_sakit_keluarga_hipertensi, riwayas_sakit_keluarga_jantung, riwayas_sakit_keluarga_tidakada, riwayas_sakit_keluarga_lainnya, riwayat_sakit_keluarga_lainnya_ket, status_psikososial_pakai_napza, status_psikososial_cobabunuhdiri, status_psikososial_kdrt, status_psikososial_agresif, status_psikososial_tidakkooperatif, statusfungsional_mandiri, statusfungsional_tirahbaringparsial, statusfungsional_tirahbaringtotal, kesadarankualitatif_composmentis, kesadarankualitatif_apatis, kesadarankualitatif_delirum, kesadarankualitatif_koma, kesadarankuantitatif_gcs_eye, kesadarankuantitatif_gcs_verbal, kesadarankuantitatif_gcs_motorik, beratbadan, tinggibadan, luasbadan, kondisikhusus_normal, kondisikhusus_anemis, kondisikhusus_icterus, kondisikhusus_sianosis, kondisikhusus_lainnya, kondisikhusus_lainnya_ket, tekanandarah_sistolok, tekanandarah_diastolik, nadi, pernafasan, suhu, nyeri_ada, nyeri_tidakada, kepala_normal, kepala_tidaknormal, kepala_tidaknormal_ket, mata_normal, mata_tidaknormal, mata_tidaknormal_ket, tht_normal, tht_tidaknormal, tht_tidaknormal_ket, leher_normal, leher_tidaknormal, leher_tidaknormal_ket, mulut_normal, mulut_tidaknormal, mulut_tidaknormal_ket, jantung_pb_normal, jantung_pb_tidaknormal, jantung_pb_tidaknormal_ket, thorax_paru_payudara_normal, thorax_paru_payudara_tidaknormal, thorax_paru_payudara_tidaknormal_ket, abdomen_normal, abdomen_tidaknormal, abdomen_tidaknormal_ket, kulit_normal, kulit_tidaknormal, kulit_tidaknormal_ket, tulang_anggotatubuh_normal, tulang_anggotatubuh_tidaknormal, tulang_anggotatubuh_tidaknormal_ket, sistemsaraf_normal, sistemsaraf_tidaknormal, sistemsaraf_tidaknormal_ket, genitalia_normal, genitalia_tidaknormal, genitalia_tidaknormal_ket, pemeriksaangambar_id, laboratorium_normal, laboratorium_tidaknormal, laboratorium_tidaknormal_ket, radiologi_thorax_normal, radiologi_thorax_tidaknormal, radiologi_thorax_tidaknormal_ket, radiologi_ctscan_normal, radiologi_ctscan_tidaknormal, radiologi_ctscan_tidaknormal_ket, radiologi_mri_normal, radiologi_mri_tidaknormal, radiologi_mri_tidaknormal_ket, radiologi_usg_normal, radiologi_usg_tidaknormal, radiologi_usg_tidaknormal_ket, radiologi, diagnosisawal, diagnosisbanding, dokterpemeriksa_id, dokterdpjp_id', 'safe', 'on' => 'search'),
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
            'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
            'bodymassaindex' => array(self::BELONGS_TO, 'BodymassindexM', 'bodymassindex_id'),
            'dokterpemeriksa' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa_id'),
            'dokterdpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dokterdpjp_id'),
            'konsultannefrologi' => array(self::BELONGS_TO, 'PegawaiM', 'konsultan_nefrologi_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'asesmen_awal_medis_id' => 'Asesmen Awal Medis',
            'tglmasuk_rs' => 'Tgl. Masuk RS',
            'tgl_pemeriksaan' => 'Tgl. Pemeriksaan',
            'pendaftaran_id' => 'Pendaftaran',
            'pasien_id' => 'Pasien',
            'pasiendari_irj' => 'Pasien dari IRJ',
            'pasiendari_igd' => 'Pasien dari IGD',
            'pasiendari_rujukan' => 'Pasien dari Rujukan',
            'pasiendari_lainnya' => 'Pasien dari Lainnya',
            'pasiendari_lainnya_keterangan' => 'Keterangan Pasien dari Lainnya',
            'diagnosa_id' => 'Diagnosa Masuk Rs',
            'alasandirawat_observasi' => 'Alasandirawat Observasi',
            'alasandirawat_prosesdiagnostik' => 'Alasandirawat Prosesdiagnostik',
            'alasandirawat_terapi' => 'Alasandirawat Terapi',
            'alasandirawat_rehabilitasi' => 'Alasandirawat Rehabilitasi',
            'keluhan_utama' => 'Keluhan Utama',
            'riwayat_penyakit_sekarang' => 'Riwayat Penyakit Sekarang',
            'riwayat_sakit_dulu_diabetes' => 'Riwayat Sakit Dulu Diabetes',
            'riwayat_sakit_dulu_hipertensi' => 'Riwayat Sakit Dulu Hipertensi',
            'riwayat_sakit_dulu_jantung' => 'Riwayat Sakit Dulu Jantung',
            'riwayat_sakit_dulu_tidakada' => 'Riwayat Sakit Dulu Tidakada',
            'riwayat_sakit_dulu_lainnya' => 'Riwayat Sakit Dulu Lainnya',
            'riwayat_sakit_dulu_lainnya_ket' => 'Riwayat Sakit Dulu Lainnya Ket',
            'riwayas_sakit_keluarga_diabetes' => 'Riwayas Sakit Keluarga Diabetes',
            'riwayas_sakit_keluarga_hipertensi' => 'Riwayas Sakit Keluarga Hipertensi',
            'riwayas_sakit_keluarga_jantung' => 'Riwayas Sakit Keluarga Jantung',
            'riwayas_sakit_keluarga_tidakada' => 'Riwayas Sakit Keluarga Tidakada',
            'riwayas_sakit_keluarga_lainnya' => 'Riwayas Sakit Keluarga Lainnya',
            'riwayat_sakit_keluarga_lainnya_ket' => 'Riwayat Sakit Keluarga Lainnya Ket',
            'status_psikososial_pakai_napza' => 'Status Psikososial Pakai Napza',
            'status_psikososial_cobabunuhdiri' => 'Status Psikososial Cobabunuhdiri',
            'status_psikososial_kdrt' => 'Status Psikososial Kdrt',
            'status_psikososial_agresif' => 'Status Psikososial Agresif',
            'status_psikososial_tidakkooperatif' => 'Status Psikososial Tidakkooperatif',
            'statusfungsional_mandiri' => 'Statusfungsional Mandiri',
            'statusfungsional_tirahbaringparsial' => 'Statusfungsional Tirahbaringparsial',
            'statusfungsional_tirahbaringtotal' => 'Statusfungsional Tirahbaringtotal',
            'kesadarankualitatif_composmentis' => 'Kesadarankualitatif Composmentis',
            'kesadarankualitatif_apatis' => 'Kesadarankualitatif Apatis',
            'kesadarankualitatif_delirum' => 'Kesadarankualitatif Delirum',
            'kesadarankualitatif_koma' => 'Kesadarankualitatif Koma',
            'kesadarankuantitatif_gcs_eye' => 'Kesadarankuantitatif Gcs Eye',
            'kesadarankuantitatif_gcs_verbal' => 'Kesadarankuantitatif Gcs Verbal',
            'kesadarankuantitatif_gcs_motorik' => 'Kesadarankuantitatif Gcs Motorik',
            'beratbadan' => 'Berat Badan',
            'tinggibadan' => 'Tinggi Badan',
            'luasbadan' => 'Luas Badan',
            'kondisikhusus_normal' => 'Kondisi Khusus Normal',
            'kondisikhusus_anemis' => 'Kondisi Khusus Anemis',
            'kondisikhusus_icterus' => 'Kondisi Khusus Icterus',
            'kondisikhusus_sianosis' => 'Kondisi Khusus Sianosis',
            'kondisikhusus_lainnya' => 'Kondisi Khusus Lainnya',
            'kondisikhusus_lainnya_ket' => 'Kondisi Khusus Lainnya Ket',
            'tekanandarah_sistolok' => 'Tekanandarah Sistolok',
            'tekanandarah_diastolik' => 'Tekanandarah Diastolik',
            'nadi' => 'Nadi',
            'pernafasan' => 'Pernafasan',
            'suhu' => 'Suhu',
            'nyeri_ada' => 'Nyeri Ada',
            'nyeri_tidakada' => 'Nyeri Tidakada',
            'kepala_normal' => 'Kepala Normal',
            'kepala_tidaknormal' => 'Kepala Tidaknormal',
            'kepala_tidaknormal_ket' => 'Kepala Tidaknormal Ket',
            'mata_normal' => 'Mata Normal',
            'mata_tidaknormal' => 'Mata Tidaknormal',
            'mata_tidaknormal_ket' => 'Mata Tidaknormal Ket',
            'tht_normal' => 'Tht Normal',
            'tht_tidaknormal' => 'Tht Tidaknormal',
            'tht_tidaknormal_ket' => 'Tht Tidaknormal Ket',
            'leher_normal' => 'Leher Normal',
            'leher_tidaknormal' => 'Leher Tidaknormal',
            'leher_tidaknormal_ket' => 'Leher Tidaknormal Ket',
            'mulut_normal' => 'Mulut Normal',
            'mulut_tidaknormal' => 'Mulut Tidaknormal',
            'mulut_tidaknormal_ket' => 'Mulut Tidaknormal Ket',
            'jantung_pb_normal' => 'Jantung Pb Normal',
            'jantung_pb_tidaknormal' => 'Jantung Pb Tidaknormal',
            'jantung_pb_tidaknormal_ket' => 'Jantung Pb Tidaknormal Ket',
            'thorax_paru_payudara_normal' => 'Thorax Paru Payudara Normal',
            'thorax_paru_payudara_tidaknormal' => 'Thorax Paru Payudara Tidaknormal',
            'thorax_paru_payudara_tidaknormal_ket' => 'Thorax Paru Payudara Tidaknormal Ket',
            'abdomen_normal' => 'Abdomen Normal',
            'abdomen_tidaknormal' => 'Abdomen Tidaknormal',
            'abdomen_tidaknormal_ket' => 'Abdomen Tidaknormal Ket',
            'kulit_normal' => 'Kulit Normal',
            'kulit_tidaknormal' => 'Kulit Tidaknormal',
            'kulit_tidaknormal_ket' => 'Kulit Tidaknormal Ket',
            'tulang_anggotatubuh_normal' => 'Tulang Anggotatubuh Normal',
            'tulang_anggotatubuh_tidaknormal' => 'Tulang Anggotatubuh Tidaknormal',
            'tulang_anggotatubuh_tidaknormal_ket' => 'Tulang Anggotatubuh Tidaknormal Ket',
            'sistemsaraf_normal' => 'Sistemsaraf Normal',
            'sistemsaraf_tidaknormal' => 'Sistemsaraf Tidaknormal',
            'sistemsaraf_tidaknormal_ket' => 'Sistemsaraf Tidaknormal Ket',
            'genitalia_normal' => 'Genitalia Normal',
            'genitalia_tidaknormal' => 'Genitalia Tidaknormal',
            'genitalia_tidaknormal_ket' => 'Genitalia Tidaknormal Ket',
            'pemeriksaangambar_id' => 'Pemeriksaangambar',
            'laboratorium_normal' => 'Laboratorium Normal',
            'laboratorium_tidaknormal' => 'Laboratorium Tidaknormal',
            'laboratorium_tidaknormal_ket' => 'Laboratorium Tidaknormal Ket',
            'radiologi_thorax_normal' => 'Radiologi Thorax Normal',
            'radiologi_thorax_tidaknormal' => 'Radiologi Thorax Tidaknormal',
            'radiologi_thorax_tidaknormal_ket' => 'Radiologi Thorax Tidaknormal Ket',
            'radiologi_ctscan_normal' => 'Radiologi Ctscan Normal',
            'radiologi_ctscan_tidaknormal' => 'Radiologi Ctscan Tidaknormal',
            'radiologi_ctscan_tidaknormal_ket' => 'Radiologi Ctscan Tidaknormal Ket',
            'radiologi_mri_normal' => 'Radiologi Mri Normal',
            'radiologi_mri_tidaknormal' => 'Radiologi Mri Tidaknormal',
            'radiologi_mri_tidaknormal_ket' => 'Radiologi Mri Tidaknormal Ket',
            'radiologi_usg_normal' => 'Radiologi Usg Normal',
            'radiologi_usg_tidaknormal' => 'Radiologi Usg Tidaknormal',
            'radiologi_usg_tidaknormal_ket' => 'Radiologi Usg Tidaknormal Ket',
            'radiologi' => 'Radiologi',
            'diagnosisawal' => 'Diagnosa Awal',
            'diagnosisbanding' => 'Diagnosisbanding',
            'dokterpemeriksa_id' => 'Dokter Pemeriksa',
            'dokterdpjp_id' => 'DPJP',
            'ppds_id' => 'Dokter Pemeriksa',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->asesmen_awal_medis_id)) {
            $criteria->addCondition('asesmen_awal_medis_id = ' . $this->asesmen_awal_medis_id);
        }
        $criteria->compare('LOWER(tglmasuk_rs)', strtolower($this->tglmasuk_rs), true);
        $criteria->compare('LOWER(tgl_pemeriksaan)', strtolower($this->tgl_pemeriksaan), true);
        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
        }
        if (!empty($this->pasien_id)) {
            $criteria->addCondition('pasien_id = ' . $this->pasien_id);
        }
        $criteria->compare('pasiendari_irj', $this->pasiendari_irj);
        $criteria->compare('pasiendari_igd', $this->pasiendari_igd);
        $criteria->compare('pasiendari_rujukan', $this->pasiendari_rujukan);
        $criteria->compare('pasiendari_lainnya', $this->pasiendari_lainnya);
        $criteria->compare('LOWER(pasiendari_lainnya_keterangan)', strtolower($this->pasiendari_lainnya_keterangan), true);
        if (!empty($this->diagnosa_id)) {
            $criteria->addCondition('diagnosa_id = ' . $this->diagnosa_id);
        }
        $criteria->compare('alasandirawat_observasi', $this->alasandirawat_observasi);
        $criteria->compare('alasandirawat_prosesdiagnostik', $this->alasandirawat_prosesdiagnostik);
        $criteria->compare('alasandirawat_terapi', $this->alasandirawat_terapi);
        $criteria->compare('alasandirawat_rehabilitasi', $this->alasandirawat_rehabilitasi);
        $criteria->compare('LOWER(keluhan_utama)', strtolower($this->keluhan_utama), true);
        $criteria->compare('LOWER(riwayat_penyakit_sekarang)', strtolower($this->riwayat_penyakit_sekarang), true);
        $criteria->compare('riwayat_sakit_dulu_diabetes', $this->riwayat_sakit_dulu_diabetes);
        $criteria->compare('riwayat_sakit_dulu_hipertensi', $this->riwayat_sakit_dulu_hipertensi);
        $criteria->compare('riwayat_sakit_dulu_jantung', $this->riwayat_sakit_dulu_jantung);
        $criteria->compare('riwayat_sakit_dulu_tidakada', $this->riwayat_sakit_dulu_tidakada);
        $criteria->compare('riwayat_sakit_dulu_lainnya', $this->riwayat_sakit_dulu_lainnya);
        $criteria->compare('LOWER(riwayat_sakit_dulu_lainnya_ket)', strtolower($this->riwayat_sakit_dulu_lainnya_ket), true);
        /*$criteria->compare('riwayas_sakit_keluarga_diabetes',$this->riwayas_sakit_keluarga_diabetes);
		$criteria->compare('riwayas_sakit_keluarga_hipertensi',$this->riwayas_sakit_keluarga_hipertensi);
		$criteria->compare('riwayas_sakit_keluarga_jantung',$this->riwayas_sakit_keluarga_jantung);
		$criteria->compare('riwayas_sakit_keluarga_tidakada',$this->riwayas_sakit_keluarga_tidakada);
		$criteria->compare('riwayas_sakit_keluarga_lainnya',$this->riwayas_sakit_keluarga_lainnya);
		$criteria->compare('LOWER(riwayat_sakit_keluarga_lainnya_ket)',strtolower($this->riwayat_sakit_keluarga_lainnya_ket),true);*/
        $criteria->compare('status_psikososial_pakai_napza', $this->status_psikososial_pakai_napza);
        $criteria->compare('status_psikososial_cobabunuhdiri', $this->status_psikososial_cobabunuhdiri);
        $criteria->compare('status_psikososial_kdrt', $this->status_psikososial_kdrt);
        $criteria->compare('status_psikososial_agresif', $this->status_psikososial_agresif);
        $criteria->compare('status_psikososial_tidakkooperatif', $this->status_psikososial_tidakkooperatif);
        $criteria->compare('statusfungsional_mandiri', $this->statusfungsional_mandiri);
        $criteria->compare('statusfungsional_tirahbaringparsial', $this->statusfungsional_tirahbaringparsial);
        $criteria->compare('statusfungsional_tirahbaringtotal', $this->statusfungsional_tirahbaringtotal);
        $criteria->compare('kesadarankualitatif_composmentis', $this->kesadarankualitatif_composmentis);
        $criteria->compare('kesadarankualitatif_apatis', $this->kesadarankualitatif_apatis);
        $criteria->compare('kesadarankualitatif_delirum', $this->kesadarankualitatif_delirum);
        $criteria->compare('kesadarankualitatif_koma', $this->kesadarankualitatif_koma);
        if (!empty($this->kesadarankuantitatif_gcs_eye)) {
            $criteria->addCondition('kesadarankuantitatif_gcs_eye = ' . $this->kesadarankuantitatif_gcs_eye);
        }
        if (!empty($this->kesadarankuantitatif_gcs_verbal)) {
            $criteria->addCondition('kesadarankuantitatif_gcs_verbal = ' . $this->kesadarankuantitatif_gcs_verbal);
        }
        if (!empty($this->kesadarankuantitatif_gcs_motorik)) {
            $criteria->addCondition('kesadarankuantitatif_gcs_motorik = ' . $this->kesadarankuantitatif_gcs_motorik);
        }
        if (!empty($this->beratbadan)) {
            $criteria->addCondition('beratbadan = ' . $this->beratbadan);
        }
        if (!empty($this->tinggibadan)) {
            $criteria->addCondition('tinggibadan = ' . $this->tinggibadan);
        }
        if (!empty($this->luasbadan)) {
            $criteria->addCondition('luasbadan = ' . $this->luasbadan);
        }
        $criteria->compare('kondisikhusus_normal', $this->kondisikhusus_normal);
        $criteria->compare('kondisikhusus_anemis', $this->kondisikhusus_anemis);
        $criteria->compare('kondisikhusus_icterus', $this->kondisikhusus_icterus);
        $criteria->compare('kondisikhusus_sianosis', $this->kondisikhusus_sianosis);
        $criteria->compare('kondisikhusus_lainnya', $this->kondisikhusus_lainnya);
        $criteria->compare('LOWER(kondisikhusus_lainnya_ket)', strtolower($this->kondisikhusus_lainnya_ket), true);
        if (!empty($this->tekanandarah_sistolok)) {
            $criteria->addCondition('tekanandarah_sistolok = ' . $this->tekanandarah_sistolok);
        }
        if (!empty($this->tekanandarah_diastolik)) {
            $criteria->addCondition('tekanandarah_diastolik = ' . $this->tekanandarah_diastolik);
        }
        if (!empty($this->nadi)) {
            $criteria->addCondition('nadi = ' . $this->nadi);
        }
        if (!empty($this->pernafasan)) {
            $criteria->addCondition('pernafasan = ' . $this->pernafasan);
        }
        if (!empty($this->suhu)) {
            $criteria->addCondition('suhu = ' . $this->suhu);
        }
        $criteria->compare('nyeri_ada', $this->nyeri_ada);
        $criteria->compare('nyeri_tidakada', $this->nyeri_tidakada);
        $criteria->compare('kepala_normal', $this->kepala_normal);
        $criteria->compare('kepala_tidaknormal', $this->kepala_tidaknormal);
        $criteria->compare('LOWER(kepala_tidaknormal_ket)', strtolower($this->kepala_tidaknormal_ket), true);
        $criteria->compare('mata_normal', $this->mata_normal);
        $criteria->compare('mata_tidaknormal', $this->mata_tidaknormal);
        $criteria->compare('LOWER(mata_tidaknormal_ket)', strtolower($this->mata_tidaknormal_ket), true);
        $criteria->compare('tht_normal', $this->tht_normal);
        $criteria->compare('tht_tidaknormal', $this->tht_tidaknormal);
        $criteria->compare('LOWER(tht_tidaknormal_ket)', strtolower($this->tht_tidaknormal_ket), true);
        $criteria->compare('leher_normal', $this->leher_normal);
        $criteria->compare('leher_tidaknormal', $this->leher_tidaknormal);
        $criteria->compare('LOWER(leher_tidaknormal_ket)', strtolower($this->leher_tidaknormal_ket), true);
        $criteria->compare('mulut_normal', $this->mulut_normal);
        $criteria->compare('mulut_tidaknormal', $this->mulut_tidaknormal);
        $criteria->compare('LOWER(mulut_tidaknormal_ket)', strtolower($this->mulut_tidaknormal_ket), true);
        $criteria->compare('jantung_pb_normal', $this->jantung_pb_normal);
        $criteria->compare('jantung_pb_tidaknormal', $this->jantung_pb_tidaknormal);
        $criteria->compare('LOWER(jantung_pb_tidaknormal_ket)', strtolower($this->jantung_pb_tidaknormal_ket), true);
        $criteria->compare('thorax_paru_payudara_normal', $this->thorax_paru_payudara_normal);
        $criteria->compare('thorax_paru_payudara_tidaknormal', $this->thorax_paru_payudara_tidaknormal);
        $criteria->compare('LOWER(thorax_paru_payudara_tidaknormal_ket)', strtolower($this->thorax_paru_payudara_tidaknormal_ket), true);
        $criteria->compare('abdomen_normal', $this->abdomen_normal);
        $criteria->compare('abdomen_tidaknormal', $this->abdomen_tidaknormal);
        $criteria->compare('LOWER(abdomen_tidaknormal_ket)', strtolower($this->abdomen_tidaknormal_ket), true);
        $criteria->compare('kulit_normal', $this->kulit_normal);
        $criteria->compare('kulit_tidaknormal', $this->kulit_tidaknormal);
        $criteria->compare('LOWER(kulit_tidaknormal_ket)', strtolower($this->kulit_tidaknormal_ket), true);
        $criteria->compare('tulang_anggotatubuh_normal', $this->tulang_anggotatubuh_normal);
        $criteria->compare('tulang_anggotatubuh_tidaknormal', $this->tulang_anggotatubuh_tidaknormal);
        $criteria->compare('LOWER(tulang_anggotatubuh_tidaknormal_ket)', strtolower($this->tulang_anggotatubuh_tidaknormal_ket), true);
        $criteria->compare('sistemsaraf_normal', $this->sistemsaraf_normal);
        $criteria->compare('sistemsaraf_tidaknormal', $this->sistemsaraf_tidaknormal);
        $criteria->compare('LOWER(sistemsaraf_tidaknormal_ket)', strtolower($this->sistemsaraf_tidaknormal_ket), true);
        $criteria->compare('genitalia_normal', $this->genitalia_normal);
        $criteria->compare('genitalia_tidaknormal', $this->genitalia_tidaknormal);
        $criteria->compare('LOWER(genitalia_tidaknormal_ket)', strtolower($this->genitalia_tidaknormal_ket), true);
        if (!empty($this->pemeriksaangambar_id)) {
            $criteria->addCondition('pemeriksaangambar_id = ' . $this->pemeriksaangambar_id);
        }
        $criteria->compare('laboratorium_normal', $this->laboratorium_normal);
        $criteria->compare('laboratorium_tidaknormal', $this->laboratorium_tidaknormal);
        $criteria->compare('LOWER(laboratorium_tidaknormal_ket)', strtolower($this->laboratorium_tidaknormal_ket), true);
        $criteria->compare('radiologi_thorax_normal', $this->radiologi_thorax_normal);
        $criteria->compare('radiologi_thorax_tidaknormal', $this->radiologi_thorax_tidaknormal);
        $criteria->compare('LOWER(radiologi_thorax_tidaknormal_ket)', strtolower($this->radiologi_thorax_tidaknormal_ket), true);
        $criteria->compare('radiologi_ctscan_normal', $this->radiologi_ctscan_normal);
        $criteria->compare('radiologi_ctscan_tidaknormal', $this->radiologi_ctscan_tidaknormal);
        $criteria->compare('LOWER(radiologi_ctscan_tidaknormal_ket)', strtolower($this->radiologi_ctscan_tidaknormal_ket), true);
        $criteria->compare('radiologi_mri_normal', $this->radiologi_mri_normal);
        $criteria->compare('radiologi_mri_tidaknormal', $this->radiologi_mri_tidaknormal);
        $criteria->compare('LOWER(radiologi_mri_tidaknormal_ket)', strtolower($this->radiologi_mri_tidaknormal_ket), true);
        $criteria->compare('radiologi_usg_normal', $this->radiologi_usg_normal);
        $criteria->compare('radiologi_usg_tidaknormal', $this->radiologi_usg_tidaknormal);
        $criteria->compare('LOWER(radiologi_usg_tidaknormal_ket)', strtolower($this->radiologi_usg_tidaknormal_ket), true);
        $criteria->compare('LOWER(radiologi)', strtolower($this->radiologi), true);
        $criteria->compare('LOWER(diagnosisawal)', strtolower($this->diagnosisawal), true);
        $criteria->compare('LOWER(diagnosisbanding)', strtolower($this->diagnosisbanding), true);
        if (!empty($this->dokterpemeriksa_id)) {
            $criteria->addCondition('dokterpemeriksa_id = ' . $this->dokterpemeriksa_id);
        }
        if (!empty($this->dokterdpjp_id)) {
            $criteria->addCondition('dokterdpjp_id = ' . $this->dokterdpjp_id);
        }

        return $criteria;
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function searchPrint()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    public function searchRiwayatByPendaftaran()
    {

        $criteria = new CDbCriteria();
        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition(" t.pendaftaran_id = '" . $this->pendaftaran_id . "' ");
        } else {
            $criteria->addCondition(" t.pendaftaran_id is null ");
        }

        if (!empty($this->pasien_id)) {
            $criteria->addCondition(" t.pasien_id = '" . $this->pasien_id . "' ");
        }
        $criteria->order = " tgl_pemeriksaan ASC ";
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
         * load obatalkes pasien berdasrkan pasien_id
         * @return type
         */
        public function loadObatAlkesPasien($jenis=''){
            $load = null;                        
            if (!empty($this->pasien_id)){                
                $cri = new CDbCriteria ();
                $cri->select = " oa.obatalkes_nama, t.satuankekuatan_oa, t.carapakai, t.tglpelayanan  ";
                $cri->join = " JOIN obatalkes_m oa ON oa.obatalkes_id = t.obatalkes_id ";                
                $cri->addCondition(" pasien_id = ".$this->pasien_id." ");                
                if ($jenis == 'daftar_terakhir'){                    
                    $new_pendaftaran = PendaftaranT::model()->find(" pasien_id = ".$this->pasien_id." ORDER BY pendaftaran_id ASC "); // menangkap pendaftaran_id paling terakhir berdasarkan pasien_id
                    if (!empty($new_pendaftaran)){
                        $cri->addCondition(" pendaftaran_id = ".$new_pendaftaran->pendaftaran_id." ");                                        
                    }
                }
                $load = ObatalkespasienT::model()->findAll($cri);                
            }
            
            return $load;
        }
        
        
        /**
         * load riayat  berdasrbat sebelumkan pasien_id
         * @return type
         */
        public function loadRiwayatObatSebelum(){
            $load = null;            
            if (!empty($this->asesmen_awal_medis_id)){
                $cri = new CDbCriteria ();                
                $cri->addCondition(" asesmen_awal_medis_id = ".$this->asesmen_awal_medis_id." ");                
                $load = RiwayatobatsebelumnyaT::model()->findAll($cri);                
            }
            
            return $load;
        }
        
        /**
         * load riayat  berdasrbat sebelumkan pasien_id
         * @return type
         */
        public function loadLabPeriksaDariLuar(){
            $load = null;            
            if (!empty($this->asesmen_awal_medis_id)){
                $cri = new CDbCriteria ();                
                $cri->addCondition(" asesmen_awal_medis_id = ".$this->asesmen_awal_medis_id." ");                
                $load = HasilpemeriksaanlabeksternalT::model()->findAll($cri);                
            }
            
            return $load;
        }
        
        /**
         * 
         * @return array
         */
        public function loadAksesVaskular(){
            $dt = [];
            if (!empty($this->asesmen_awal_medis_id)){
                $cri = new CDbCriteria ();                
                $cri->addCondition(" asesmen_awal_medis_id = ".$this->asesmen_awal_medis_id." ");                
                $load = AksesVaskularT::model()->findAll($cri);                
                
                foreach($load as $det){
                    $dt[$det->nama_akses_vaskular]['attr'] = $det;
                    if (!empty($det->hd_kateter)){
                        $dt[$det->nama_akses_vaskular]['kateter'][$det->hd_kateter] = $det;
                    }
                }
            }
            return $dt;
        }
        
        /**
        * 
        * @return type
        */
        public function loadPemeriksaanLab(){
            $load =  null;
            if (!empty($this->pendaftaran_id)){
                $cri = new CDbCriteria();
                $cri->addCondition(" pp.pasien_id = ".$this->pasien_id." AND pb.pasienbatalperiksa_id IS NULL ");
                $cri->select = " hp.tglhasilpemeriksaanlab, hp.pasienmasukpenunjang_id ,array_to_string(array_agg(distinct p.pemeriksaanlab_nama),', ') as pemeriksaanlab_nama ";
                $cri->join = "  JOIN hasilpemeriksaanlab_t hp ON hp.hasilpemeriksaanlab_id = t.hasilpemeriksaanlab_id 
                                JOIN pemeriksaanlab_m p ON p.pemeriksaanlab_id = t.pemeriksaanlab_id 
                                JOIN pasienmasukpenunjang_t pp ON pp.pasienmasukpenunjang_id = hp.pasienmasukpenunjang_id 
                                LEFT JOIN pasienbatalperiksa_r pb ON pb.pasienmasukpenunjang_id = pp.pasienmasukpenunjang_id
                             ";
                $cri->group = " hp.tglhasilpemeriksaanlab, hp.pasienmasukpenunjang_id ";
                $load = DetailhasilpemeriksaanlabT::model()->findAll($cri);
            }

            return $load;
        }
       
        /**
        * 
        * @return type
        */
        public function loadPemeriksaanRad(){
            $load =  null;
            if (!empty($this->pendaftaran_id)){
                $cri = new CDbCriteria();
                $cri->addCondition(" pp.pasien_id = ".$this->pasien_id." AND pb.pasienbatalperiksa_id IS NULL ");
                $cri->select = " t.tglpemeriksaanrad, t.pasienmasukpenunjang_id ,array_to_string(array_agg(distinct rad.pemeriksaanrad_nama),', ') as pemeriksaanrad_nama ";
                $cri->join = "  
                                JOIN pemeriksaanrad_m rad ON rad.pemeriksaanrad_id = t.pemeriksaanrad_id 
                                JOIN pasienmasukpenunjang_t pp ON pp.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id 
                                LEFT JOIN pasienbatalperiksa_r pb ON pb.pasienmasukpenunjang_id = pp.pasienmasukpenunjang_id
                             ";
                $cri->group = " t.tglpemeriksaanrad, t.pasienmasukpenunjang_id ";
                $load = HasilpemeriksaanradT::model()->findAll($cri);
            }

            return $load;
        }
        
        /**
        * 
        * @return type
        */
        public function loadDiagnosaMorbiditas(){
            $load =  null;
            if (!empty($this->asesmen_awal_medis_id)){
                $cri = new CDbCriteria();
                $cri->select = " d.diagnosa_nama, t.tglmorbiditas, t.kasusdiagnosa, d.diagnosa_kode, kel.kelompokdiagnosa_nama ";
                $cri->join =  " JOIN diagnosa_m d ON d.diagnosa_id = t.diagnosa_id "
                            . " JOIN kelompokdiagnosa_m kel ON kel.kelompokdiagnosa_id = t.kelompokdiagnosa_id ";
                $cri->addCondition(" t.asesmen_awal_medis_id = ".$this->asesmen_awal_medis_id);
                //$cri->addCondition('t.diagnosa_id <> 0');
                $load = PasienmorbiditasT::model()->findAll($cri);
            }

            return $load;
        }
}

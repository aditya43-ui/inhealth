<?php

/**
 * This is the model class for table "monitoring_pre_hd_t".
 *
 * The followings are the available columns in table 'monitoring_pre_hd_t':
 * @property integer $monitoring_pre_hd_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $dpjp_id
 * @property integer $perawat1_id
 * @property integer $perawat2_id
 * @property integer $pasienmorbiditas_id
 * @property integer $asesmentnyeri_id
 * @property string $waktu
 * @property string $nomor_mesin
 * @property string $gol_darah
 * @property boolean $kendala_komunikasi_ada
 * @property boolean $kendala_komunikasi_tidakada
 * @property string $kendala_komunikasi_keterangan
 * @property boolean $kondisi_saat_ini_tenang
 * @property boolean $kondisi_saat_ini_gelisah
 * @property boolean $kondisi_saat_ini_takut_tindakan
 * @property boolean $kondisi_saat_ini_marah
 * @property boolean $kondisi_saat_ini_tersinggung
 * @property integer $hemodialisis_ke
 * @property string $dialiser
 * @property boolean $alergi_obat_ya
 * @property boolean $alergi_obat_tidak
 * @property string $alergi_obat_keterangan
 * @property boolean $hbsag_ya
 * @property boolean $hbsag_tidak
 * @property boolean $hcv_ya
 * @property boolean $hcv_tidak
 * @property string $hcv_keterangan
 * @property boolean $hiv_ya
 * @property boolean $hiv_tidak
 * @property boolean $hiv_keterangan
 * @property boolean $keluhan_utama_sesak_nafas
 * @property boolean $keluhan_utama_mual_muntah
 * @property boolean $keluhan_utama_lainnya
 * @property string $keluhan_utama_lainnya_keterangan
 * @property integer $gcs_eye
 * @property integer $gcs_verbal
 * @property string $gcs_motorik
 * @property boolean $keadaan_umum_baik
 * @property boolean $keadaan_umum_sedang
 * @property boolean $keadaan_umum_lainnya
 * @property string $keadaan_umum_lainnya_keterangan
 * @property double $berat_badan_pre_hd
 * @property double $berat_badan_post_hd
 * @property double $selisih
 * @property double $tinggi_badan
 * @property double $imt
 * @property integer $tensi_sistolik
 * @property integer $tensi_diastolik
 * @property integer $nadi
 * @property boolean $nadi_reguler
 * @property boolean $nadi_irreguler
 * @property integer $respirasi
 * @property double $suhu
 * @property boolean $kepala_normal
 * @property boolean $kepala_tidak_normal
 * @property string $kepala_keterangan
 * @property boolean $leher_normal
 * @property boolean $leher_tidak_normal
 * @property string $leher_keterangan
 * @property boolean $jantung_normal
 * @property boolean $jantung_tidak_normal
 * @property string $jantung_keterangan
 * @property boolean $paru_normal
 * @property boolean $paru_tidak_normal
 * @property string $paru_keterangan
 * @property boolean $abdomen_normal
 * @property boolean $abdomen_tidak_normal
 * @property string $abdomen_keterangan
 * @property boolean $kulit_normal
 * @property boolean $kulit_tidak_normal
 * @property string $kulit_keterangan
 * @property boolean $anggota_tubuh_normal
 * @property boolean $anggota_tubuh_tidak_normal
 * @property string $anggota_tubuh_keterangan
 * @property boolean $gizi_baik
 * @property boolean $gizi_sedang
 * @property boolean $gizi_buruk
 * @property boolean $risiko_jatuh_dewasa_rendah
 * @property boolean $risiko_jatuh_dewasa_tinggi
 * @property boolean $risiko_jatuh_anak_rendah
 * @property boolean $risiko_jatuh_anak_tinggi
 * @property boolean $lab_internal
 * @property boolean $lab_eksternal
 * @property double $lab_eksternal_hb
 * @property double $lab_eksternal_k
 * @property double $lab_eksternal_bun
 * @property double $lab_eksternal_na
 * @property double $lab_eksternal_sk
 * @property double $lab_eksternal_p
 * @property double $lab_eksternal_ca
 * @property double $lab_eksternal_cl
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 * @property integer $diagnosa_id
 * @property string $hbsag_keterangan
 *
 * The followings are the available model relations:
 * @property DiagnosaM $diagnosa
 * @property PegawaiM $perawat2
 * @property PegawaiM $perawat1
 * @property PegawaiM $dpjp
 * @property AsesmentnyeriT $asesmentnyeri
 * @property PasienmorbiditasT $pasienmorbiditas
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property AksesVaskularT[] $aksesVaskularTs
 * @property IntervensiKeperawatanPreHdT[] $intervensiKeperawatanPreHdTs
 * @property MasalahKeperawatanPreHdT[] $masalahKeperawatanPreHdTs
 */
class MonitoringPreHdT extends CActiveRecord {

    public $dpjp_nama, $perawat1_nama, $perawat2_nama, $diagnosa_nama, $keluhan_utama_nyeri, $skornyeri, $keterangan_skriningnyeri;
    public $set_akses_vaskular;
    public $set_periksa_internal_lab, $set_periksa_lab_dari_luar;
    public $konjungtiva_ceklainlain;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MonitoringPreHdT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'monitoring_pre_hd_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendaftaran_id, pasien_id, create_time, create_loginpemakai_id, ruangan_id', 'required'),
            array('pendaftaran_id, pasien_id, dpjp_id, perawat1_id, perawat2_id, pasienmorbiditas_id, asesmentnyeri_id, hemodialisis_ke, gcs_eye, gcs_verbal, tensi_sistolik, tensi_diastolik, nadi, respirasi, create_loginpemakai_id, update_loginpemakai_id, ruangan_id, diagnosa_id', 'numerical', 'integerOnly' => true),
            array('berat_badan_pre_hd, berat_badan_post_hd, selisih, tinggi_badan, imt, suhu, lab_eksternal_hb, lab_eksternal_k, lab_eksternal_bun, lab_eksternal_na, lab_eksternal_sk, lab_eksternal_p, lab_eksternal_ca, lab_eksternal_cl', 'numerical'),
            array('nomor_mesin', 'length', 'max' => 20),
            array('gol_darah', 'length', 'max' => 5),
            array('kendala_komunikasi_keterangan, alergi_obat_keterangan, hcv_keterangan, keluhan_utama_lainnya_keterangan, keadaan_umum_lainnya_keterangan, kepala_keterangan, leher_keterangan, jantung_keterangan, paru_keterangan, abdomen_keterangan, kulit_keterangan, anggota_tubuh_keterangan, hbsag_keterangan', 'length', 'max' => 100),
            array('dialiser', 'length', 'max' => 50),
            array('lokasi_nyeri, waktu, kendala_komunikasi_ada, kendala_komunikasi_tidakada, kondisi_saat_ini_tenang, kondisi_saat_ini_gelisah, kondisi_saat_ini_takut_tindakan, kondisi_saat_ini_marah, kondisi_saat_ini_tersinggung, alergi_obat_ya, alergi_obat_tidak, hbsag_ya, hbsag_tidak, hcv_ya, hcv_tidak, hiv_ya, hiv_tidak, hiv_keterangan, keluhan_utama_sesak_nafas, keluhan_utama_mual_muntah, keluhan_utama_lainnya, gcs_motorik, keadaan_umum_baik, keadaan_umum_sedang, keadaan_umum_lainnya, nadi_reguler, nadi_irreguler, kepala_normal, kepala_tidak_normal, leher_normal, leher_tidak_normal, jantung_normal, jantung_tidak_normal, paru_normal, paru_tidak_normal, abdomen_normal, abdomen_tidak_normal, kulit_normal, kulit_tidak_normal, anggota_tubuh_normal, anggota_tubuh_tidak_normal, gizi_baik, gizi_sedang, gizi_buruk, risiko_jatuh_dewasa_rendah, risiko_jatuh_dewasa_tinggi, risiko_jatuh_anak_rendah, risiko_jatuh_anak_tinggi, lab_internal, lab_eksternal, update_time, tidaktimbang', 'safe'),
            ['berat_badan_kering, konjuctiva_tidakanemis, konjungtiva_anemis, konjungtiva_lainlain, konjungtiva_keterangan, ekstrimitas_tidakedema, ekstrimitas_anemis, ekstrimitas_oedema, ekstrimitas_anasarka, ekstrimitas_pucatdingin','safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('monitoring_pre_hd_id, pendaftaran_id, pasien_id, dpjp_id, perawat1_id, perawat2_id, pasienmorbiditas_id, asesmentnyeri_id, waktu, nomor_mesin, gol_darah, kendala_komunikasi_ada, kendala_komunikasi_tidakada, kendala_komunikasi_keterangan, kondisi_saat_ini_tenang, kondisi_saat_ini_gelisah, kondisi_saat_ini_takut_tindakan, kondisi_saat_ini_marah, kondisi_saat_ini_tersinggung, hemodialisis_ke, dialiser, alergi_obat_ya, alergi_obat_tidak, alergi_obat_keterangan, hbsag_ya, hbsag_tidak, hcv_ya, hcv_tidak, hcv_keterangan, hiv_ya, hiv_tidak, hiv_keterangan, keluhan_utama_sesak_nafas, keluhan_utama_mual_muntah, keluhan_utama_lainnya, keluhan_utama_lainnya_keterangan, gcs_eye, gcs_verbal, gcs_motorik, keadaan_umum_baik, keadaan_umum_sedang, keadaan_umum_lainnya, keadaan_umum_lainnya_keterangan, berat_badan_pre_hd, berat_badan_post_hd, selisih, tinggi_badan, imt, tensi_sistolik, tensi_diastolik, nadi, nadi_reguler, nadi_irreguler, respirasi, suhu, kepala_normal, kepala_tidak_normal, kepala_keterangan, leher_normal, leher_tidak_normal, leher_keterangan, jantung_normal, jantung_tidak_normal, jantung_keterangan, paru_normal, paru_tidak_normal, paru_keterangan, abdomen_normal, abdomen_tidak_normal, abdomen_keterangan, kulit_normal, kulit_tidak_normal, kulit_keterangan, anggota_tubuh_normal, anggota_tubuh_tidak_normal, anggota_tubuh_keterangan, gizi_baik, gizi_sedang, gizi_buruk, risiko_jatuh_dewasa_rendah, risiko_jatuh_dewasa_tinggi, risiko_jatuh_anak_rendah, risiko_jatuh_anak_tinggi, lab_internal, lab_eksternal, lab_eksternal_hb, lab_eksternal_k, lab_eksternal_bun, lab_eksternal_na, lab_eksternal_sk, lab_eksternal_p, lab_eksternal_ca, lab_eksternal_cl, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, ruangan_id, diagnosa_id, hbsag_keterangan, tidaktimbang', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'diagnosa' => array(self::BELONGS_TO, 'DiagnosaM', 'diagnosa_id'),
            'perawat2' => array(self::BELONGS_TO, 'PegawaiM', 'perawat2_id'),
            'perawat1' => array(self::BELONGS_TO, 'PegawaiM', 'perawat1_id'),
            'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
            'asesmentnyeri' => array(self::BELONGS_TO, 'AsesmentnyeriT', 'asesmentnyeri_id'),
            'pasienmorbiditas' => array(self::BELONGS_TO, 'PasienmorbiditasT', 'pasienmorbiditas_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'aksesVaskularTs' => array(self::HAS_MANY, 'AksesVaskularT', 'monitoring_pre_hd_id'),
            'intervensiKeperawatanPreHdTs' => array(self::HAS_MANY, 'IntervensiKeperawatanPreHdT', 'monitoring_pre_hd_id'),
            'masalahKeperawatanPreHdTs' => array(self::HAS_MANY, 'MasalahKeperawatanPreHdT', 'monitoring_pre_hd_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'monitoring_pre_hd_id' => 'Monitoring Pre Hd',
            'pendaftaran_id' => 'Pendaftaran',
            'pasien_id' => 'Pasien',
            'dpjp_id' => 'Dpjp',
            'perawat1_id' => 'Perawat1',
            'perawat2_id' => 'Perawat2',
            'pasienmorbiditas_id' => 'Pasienmorbiditas',
            'asesmentnyeri_id' => 'Asesmentnyeri',
            'waktu' => 'Waktu',
            'nomor_mesin' => 'Nomor Mesin',
            'gol_darah' => 'Golongan Darah',
            'kendala_komunikasi_ada' => 'Kendala Komunikasi Ada',
            'kendala_komunikasi_tidakada' => 'Kendala Komunikasi Tidakada',
            'kendala_komunikasi_keterangan' => 'Kendala Komunikasi Keterangan',
            'kondisi_saat_ini_tenang' => 'Kondisi Saat Ini Tenang',
            'kondisi_saat_ini_gelisah' => 'Kondisi Saat Ini Gelisah',
            'kondisi_saat_ini_takut_tindakan' => 'Kondisi Saat Ini Takut Tindakan',
            'kondisi_saat_ini_marah' => 'Kondisi Saat Ini Marah',
            'kondisi_saat_ini_tersinggung' => 'Kondisi Saat Ini Tersinggung',
            'hemodialisis_ke' => 'Hemodialisis Ke',
            'dialiser' => 'Dialiser',
            'alergi_obat_ya' => 'Alergi Obat Ya',
            'alergi_obat_tidak' => 'Alergi Obat Tidak',
            'alergi_obat_keterangan' => 'Alergi Obat Keterangan',
            'hbsag_ya' => 'Hbsag Ya',
            'hbsag_tidak' => 'Hbsag Tidak',
            'hcv_ya' => 'Hcv Ya',
            'hcv_tidak' => 'Hcv Tidak',
            'hcv_keterangan' => 'Hcv Keterangan',
            'hiv_ya' => 'Hiv Ya',
            'hiv_tidak' => 'Hiv Tidak',
            'hiv_keterangan' => 'Hiv Keterangan',
            'keluhan_utama_sesak_nafas' => 'Keluhan Utama Sesak Nafas',
            'keluhan_utama_mual_muntah' => 'Keluhan Utama Mual Muntah',
            'keluhan_utama_lainnya' => 'Keluhan Utama Lainnya',
            'keluhan_utama_lainnya_keterangan' => 'Keluhan Utama Lainnya Keteranga',
            'gcs_eye' => 'Gcs Eye',
            'gcs_verbal' => 'Gcs Verbal',
            'gcs_motorik' => 'Gcs Motorik',
            'keadaan_umum_baik' => 'Keadaan Umum Baik',
            'keadaan_umum_sedang' => 'Keadaan Umum Sedang',
            'keadaan_umum_lainnya' => 'Keadaan Umum Lainnya',
            'keadaan_umum_lainnya_keterangan' => 'Keadaan Umum Lainnya Keterangan',
            'berat_badan_pre_hd' => 'Berat Badan Pre Hd',
            'berat_badan_post_hd' => 'Berat Badan Post Hd',
            'selisih' => 'Selisih',
            'tinggi_badan' => 'Tinggi Badan',
            'imt' => 'Imt',
            'tensi_sistolik' => 'Tensi Sistolik',
            'tensi_diastolik' => 'Tensi Diastolik',
            'nadi' => 'Nadi',
            'nadi_reguler' => 'Nadi Reguler',
            'nadi_irreguler' => 'Nadi Irreguler',
            'respirasi' => 'Respirasi',
            'suhu' => 'Suhu',
            'kepala_normal' => 'Kepala Normal',
            'kepala_tidak_normal' => 'Kepala Tidak Normal',
            'kepala_keterangan' => 'Kepala Keterangan',
            'leher_normal' => 'Leher Normal',
            'leher_tidak_normal' => 'Leher Tidak Normal',
            'leher_keterangan' => 'Leher Keterangan',
            'jantung_normal' => 'Jantung Normal',
            'jantung_tidak_normal' => 'Jantung Tidak Normal',
            'jantung_keterangan' => 'Jantung Keterangan',
            'paru_normal' => 'Paru Normal',
            'paru_tidak_normal' => 'Paru Tidak Normal',
            'paru_keterangan' => 'Paru Keterangan',
            'abdomen_normal' => 'Abdomen Normal',
            'abdomen_tidak_normal' => 'Abdomen Tidak Normal',
            'abdomen_keterangan' => 'Abdomen Keterangan',
            'kulit_normal' => 'Kulit Normal',
            'kulit_tidak_normal' => 'Kulit Tidak Normal',
            'kulit_keterangan' => 'Kulit Keterangan',
            'anggota_tubuh_normal' => 'Anggota Tubuh Normal',
            'anggota_tubuh_tidak_normal' => 'Anggota Tubuh Tidak Normal',
            'anggota_tubuh_keterangan' => 'Anggota Tubuh Keterangan',
            'gizi_baik' => 'Gizi Baik',
            'gizi_sedang' => 'Gizi Sedang',
            'gizi_buruk' => 'Gizi Buruk',
            'risiko_jatuh_dewasa_rendah' => 'Risiko Jatuh Dewasa Rendah',
            'risiko_jatuh_dewasa_tinggi' => 'Risiko Jatuh Dewasa Tinggi',
            'risiko_jatuh_anak_rendah' => 'Risiko Jatuh Anak Rendah',
            'risiko_jatuh_anak_tinggi' => 'Risiko Jatuh Anak Tinggi',
            'lab_internal' => 'Lab Internal',
            'lab_eksternal' => 'Lab Eksternal',
            'lab_eksternal_hb' => 'Lab Eksternal Hb',
            'lab_eksternal_k' => 'Lab Eksternal K',
            'lab_eksternal_bun' => 'Lab Eksternal Bun',
            'lab_eksternal_na' => 'Lab Eksternal Na',
            'lab_eksternal_sk' => 'Lab Eksternal Sk',
            'lab_eksternal_p' => 'Lab Eksternal P',
            'lab_eksternal_ca' => 'Lab Eksternal Ca',
            'lab_eksternal_cl' => 'Lab Eksternal Cl',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Creale Login',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'ruangan_id' => 'Ruangan',
            'diagnosa_id' => 'Diagnosa',
            'hbsag_keterangan' => 'Hbsag Keterangan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('monitoring_pre_hd_id', $this->monitoring_pre_hd_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('dpjp_id', $this->dpjp_id);
        $criteria->compare('perawat1_id', $this->perawat1_id);
        $criteria->compare('perawat2_id', $this->perawat2_id);
        $criteria->compare('pasienmorbiditas_id', $this->pasienmorbiditas_id);
        $criteria->compare('asesmentnyeri_id', $this->asesmentnyeri_id);
        $criteria->compare('waktu', $this->waktu, true);
        $criteria->compare('nomor_mesin', $this->nomor_mesin, true);
        $criteria->compare('gol_darah', $this->gol_darah, true);
        $criteria->compare('kendala_komunikasi_ada', $this->kendala_komunikasi_ada);
        $criteria->compare('kendala_komunikasi_tidakada', $this->kendala_komunikasi_tidakada);
        $criteria->compare('kendala_komunikasi_keterangan', $this->kendala_komunikasi_keterangan, true);
        $criteria->compare('kondisi_saat_ini_tenang', $this->kondisi_saat_ini_tenang);
        $criteria->compare('kondisi_saat_ini_gelisah', $this->kondisi_saat_ini_gelisah);
        $criteria->compare('kondisi_saat_ini_takut_tindakan', $this->kondisi_saat_ini_takut_tindakan);
        $criteria->compare('kondisi_saat_ini_marah', $this->kondisi_saat_ini_marah);
        $criteria->compare('kondisi_saat_ini_tersinggung', $this->kondisi_saat_ini_tersinggung);
        $criteria->compare('hemodialisis_ke', $this->hemodialisis_ke);
        $criteria->compare('dialiser', $this->dialiser, true);
        $criteria->compare('alergi_obat_ya', $this->alergi_obat_ya);
        $criteria->compare('alergi_obat_tidak', $this->alergi_obat_tidak);
        $criteria->compare('alergi_obat_keterangan', $this->alergi_obat_keterangan, true);
        $criteria->compare('hbsag_ya', $this->hbsag_ya);
        $criteria->compare('hbsag_tidak', $this->hbsag_tidak);
        $criteria->compare('hcv_ya', $this->hcv_ya);
        $criteria->compare('hcv_tidak', $this->hcv_tidak);
        $criteria->compare('hcv_keterangan', $this->hcv_keterangan, true);
        $criteria->compare('hiv_ya', $this->hiv_ya);
        $criteria->compare('hiv_tidak', $this->hiv_tidak);
        $criteria->compare('hiv_keterangan', $this->hiv_keterangan);
        $criteria->compare('keluhan_utama_sesak_nafas', $this->keluhan_utama_sesak_nafas);
        $criteria->compare('keluhan_utama_mual_muntah', $this->keluhan_utama_mual_muntah);
        $criteria->compare('keluhan_utama_lainnya', $this->keluhan_utama_lainnya);
        $criteria->compare('keluhan_utama_lainnya_keterangan', $this->keluhan_utama_lainnya_keterangan, true);
        $criteria->compare('gcs_eye', $this->gcs_eye);
        $criteria->compare('gcs_verbal', $this->gcs_verbal);
        $criteria->compare('gcs_motorik', $this->gcs_motorik, true);
        $criteria->compare('keadaan_umum_baik', $this->keadaan_umum_baik);
        $criteria->compare('keadaan_umum_sedang', $this->keadaan_umum_sedang);
        $criteria->compare('keadaan_umum_lainnya', $this->keadaan_umum_lainnya);
        $criteria->compare('keadaan_umum_lainnya_keterangan', $this->keadaan_umum_lainnya_keterangan, true);
        $criteria->compare('berat_badan_pre_hd', $this->berat_badan_pre_hd);
        $criteria->compare('berat_badan_post_hd', $this->berat_badan_post_hd);
        $criteria->compare('selisih', $this->selisih);
        $criteria->compare('tinggi_badan', $this->tinggi_badan);
        $criteria->compare('imt', $this->imt);
        $criteria->compare('tensi_sistolik', $this->tensi_sistolik);
        $criteria->compare('tensi_diastolik', $this->tensi_diastolik);
        $criteria->compare('nadi', $this->nadi);
        $criteria->compare('nadi_reguler', $this->nadi_reguler);
        $criteria->compare('nadi_irreguler', $this->nadi_irreguler);
        $criteria->compare('respirasi', $this->respirasi);
        $criteria->compare('suhu', $this->suhu);
        $criteria->compare('kepala_normal', $this->kepala_normal);
        $criteria->compare('kepala_tidak_normal', $this->kepala_tidak_normal);
        $criteria->compare('kepala_keterangan', $this->kepala_keterangan, true);
        $criteria->compare('leher_normal', $this->leher_normal);
        $criteria->compare('leher_tidak_normal', $this->leher_tidak_normal);
        $criteria->compare('leher_keterangan', $this->leher_keterangan, true);
        $criteria->compare('jantung_normal', $this->jantung_normal);
        $criteria->compare('jantung_tidak_normal', $this->jantung_tidak_normal);
        $criteria->compare('jantung_keterangan', $this->jantung_keterangan, true);
        $criteria->compare('paru_normal', $this->paru_normal);
        $criteria->compare('paru_tidak_normal', $this->paru_tidak_normal);
        $criteria->compare('paru_keterangan', $this->paru_keterangan, true);
        $criteria->compare('abdomen_normal', $this->abdomen_normal);
        $criteria->compare('abdomen_tidak_normal', $this->abdomen_tidak_normal);
        $criteria->compare('abdomen_keterangan', $this->abdomen_keterangan, true);
        $criteria->compare('kulit_normal', $this->kulit_normal);
        $criteria->compare('kulit_tidak_normal', $this->kulit_tidak_normal);
        $criteria->compare('kulit_keterangan', $this->kulit_keterangan, true);
        $criteria->compare('anggota_tubuh_normal', $this->anggota_tubuh_normal);
        $criteria->compare('anggota_tubuh_tidak_normal', $this->anggota_tubuh_tidak_normal);
        $criteria->compare('anggota_tubuh_keterangan', $this->anggota_tubuh_keterangan, true);
        $criteria->compare('gizi_baik', $this->gizi_baik);
        $criteria->compare('gizi_sedang', $this->gizi_sedang);
        $criteria->compare('gizi_buruk', $this->gizi_buruk);
        $criteria->compare('risiko_jatuh_dewasa_rendah', $this->risiko_jatuh_dewasa_rendah);
        $criteria->compare('risiko_jatuh_dewasa_tinggi', $this->risiko_jatuh_dewasa_tinggi);
        $criteria->compare('risiko_jatuh_anak_rendah', $this->risiko_jatuh_anak_rendah);
        $criteria->compare('risiko_jatuh_anak_tinggi', $this->risiko_jatuh_anak_tinggi);
        $criteria->compare('lab_internal', $this->lab_internal);
        $criteria->compare('lab_eksternal', $this->lab_eksternal);
        $criteria->compare('lab_eksternal_hb', $this->lab_eksternal_hb);
        $criteria->compare('lab_eksternal_k', $this->lab_eksternal_k);
        $criteria->compare('lab_eksternal_bun', $this->lab_eksternal_bun);
        $criteria->compare('lab_eksternal_na', $this->lab_eksternal_na);
        $criteria->compare('lab_eksternal_sk', $this->lab_eksternal_sk);
        $criteria->compare('lab_eksternal_p', $this->lab_eksternal_p);
        $criteria->compare('lab_eksternal_ca', $this->lab_eksternal_ca);
        $criteria->compare('lab_eksternal_cl', $this->lab_eksternal_cl);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('diagnosa_id', $this->diagnosa_id);
        $criteria->compare('hbsag_keterangan', $this->hbsag_keterangan, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian riwayat monitoring
     * @return \CActiveDataProvider
     */
    public function searchRiwayat($pasien_id = null) {

        $criteria = new CDbCriteria;
        if (!empty($pasien_id)) {
            $criteria->addCondition('pasien_id = '.$pasien_id);
        }
//        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->order = ('create_time DESC');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    
    /**
    * 
    * @return array
    */
   public function loadAksesVaskular(){
       $dt = [];
       $cri = new CDbCriteria ();
       if (!empty($this->monitoring_pre_hd_id)){                                
           $cri->addCondition(" monitoring_pre_hd_id = ".$this->monitoring_pre_hd_id." ");                                
       }else if($this->pendaftaran_id){
           $cri->addCondition(" pendaftaran_id = ".$this->pendaftaran_id." ");                                
       }else{
           $cri->addCondition(" akses_vaskular_id IS NULL ");
       }           
       $load = AksesVaskularT::model()->findAll($cri);                

       if (!empty($load)){
           foreach($load as $det){
               if (empty($this->monitoring_pre_hd_id)){
                   $det->akses_vaskular_id = null;
               }
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
        if (!empty($this->pasien_id)){
            $cri = new CDbCriteria();
            $cri->addCondition(" hp.pasien_id = ".$this->pasien_id." AND pb.pasienbatalperiksa_id IS NULL ");
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
    * load riayat  berdasrbat sebelumkan pasien_id
    * @return type
    */
   public function loadLabPeriksaDariLuar(){
       $load = null;            
       if (!empty($this->pasien_id)){
           $cri = new CDbCriteria ();                
           $cri->addCondition(" pasien_id = ".$this->pasien_id." ");                
           $load = HasilpemeriksaanlabeksternalT::model()->findAll($cri);                
       }

       return $load;
    }

}

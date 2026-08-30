<?php

/**
 * This is the model class for table "asesmenawalgizi_t".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 *
 * The followings are the available columns in table 'asesmenawalgizi_t':
 * @property integer $asesmenawalgiziranap_id
 * @property string $tgl_pemeriksaan
 * @property integer $perawat_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $diagnosa_medis
 * @property double $beratbadan
 * @property double $tinggibadan
 * @property double $nilai_imt
 * @property integer $lila
 * @property integer $presentase_lila
 * @property integer $tinggilutut
 * @property double $tinggibadan_estimasi
 * @property double $beratbadan_estimasi
 * @property string $keterangan_antropometri
 * @property boolean $hb
 * @property string $hb_keterangan
 * @property boolean $alb
 * @property string $alb_keterangan
 * @property boolean $gula_darah
 * @property string $gula_darah_keterangan
 * @property boolean $lainlain
 * @property string $lainlain_keterangan
 * @property string $keterangan_laboratorium
 * @property boolean $keadaan_lemah
 * @property boolean $keadaan_koma
 * @property boolean $keadaan_sadar
 * @property integer $tekanandarah_sistolik
 * @property integer $tekanandarah_diastolik
 * @property boolean $alatpenunjang_ventilator
 * @property boolean $alatpenunjang_ngt
 * @property boolean $alatpenunjang_oksigen
 * @property string $keterangan_fisik
 * @property string $makananpokok
 * @property string $laukhewani
 * @property string $lauknabati
 * @property string $sayuran
 * @property string $buah
 * @property integer $frekuensi_makan
 * @property string $frekuensi_makan_keterangan
 * @property string $alergi
 * @property string $kebiasaanmakan
 * @property string $keterangan_riwayatgizi
 * @property string $riwayat_penyakit_pasien
 * @property string $keterangan_riwayat_penyakit
 * @property string $diagnosa_gizi
 * @property string $keterangan_diagnosagizi
 * @property string $preskripsi_diet
 * @property string $keterangan_preskripsi_diet
 * @property string $tujuan_diet
 * @property string $keterangan_tujuan_diet
 * @property integer $kebutuhangizi_energi
 * @property integer $kebutuhangizi_lemak
 * @property integer $kebutuhangizi_protein
 * @property integer $kebutuhangizi_vitamin
 * @property string $kebutuhangizi_lainlain
 * @property string $keterangan_kebutuhangizi
 *
 * The followings are the available model relations:
 * @property PendaftaranT $pendaftaran
 * @property PasienM $pasien
 */
class AsesmenawalgiziranapT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsesmenawalgiziT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asesmenawalgiziranap_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tgl_pemeriksaan, perawat_id, pendaftaran_id, pasien_id', 'required'),
            array('perawat_id, pendaftaran_id, pasien_id, lila, presentase_lila, tinggilutut, tekanandarah_sistolik, tekanandarah_diastolik, frekuensi_makan, kebutuhangizi_energi, kebutuhangizi_lemak, kebutuhangizi_protein, kebutuhangizi_vitamin', 'numerical', 'integerOnly' => true),
            array('beratbadan, tinggibadan, nilai_imt, tinggibadan_estimasi, beratbadan_estimasi', 'numerical'),
            array('hb_keterangan, alb_keterangan, gula_darah_keterangan, lainlain_keterangan, makananpokok, laukhewani, lauknabati, sayuran, buah, frekuensi_makan_keterangan', 'length', 'max' => 100),
            array('alergi, kebiasaanmakan, kebutuhangizi_lainlain', 'length', 'max' => 150),
            array('diagnosa_medis, keterangan_antropometri, hb, alb, gula_darah, lainlain, keterangan_laboratorium, keadaan_lemah, keadaan_koma, keadaan_sadar, alatpenunjang_ventilator, alatpenunjang_ngt, alatpenunjang_oksigen, keterangan_fisik, keterangan_riwayatgizi, riwayat_penyakit_pasien, keterangan_riwayat_penyakit, diagnosa_gizi, keterangan_diagnosagizi, preskripsi_diet, keterangan_preskripsi_diet, tujuan_diet, keterangan_tujuan_diet, keterangan_kebutuhangizi', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('asesmenawalgiziranap_id, tgl_pemeriksaan, perawat_id, pendaftaran_id, pasien_id, diagnosa_medis, beratbadan, tinggibadan, nilai_imt, lila, presentase_lila, tinggilutut, tinggibadan_estimasi, beratbadan_estimasi, keterangan_antropometri, hb, hb_keterangan, alb, alb_keterangan, gula_darah, gula_darah_keterangan, lainlain, lainlain_keterangan, keterangan_laboratorium, keadaan_lemah, keadaan_koma, keadaan_sadar, tekanandarah_sistolik, tekanandarah_diastolik, alatpenunjang_ventilator, alatpenunjang_ngt, alatpenunjang_oksigen, keterangan_fisik, makananpokok, laukhewani, lauknabati, sayuran, buah, frekuensi_makan, frekuensi_makan_keterangan, alergi, kebiasaanmakan, keterangan_riwayatgizi, riwayat_penyakit_pasien, keterangan_riwayat_penyakit, diagnosa_gizi, keterangan_diagnosagizi, preskripsi_diet, keterangan_preskripsi_diet, tujuan_diet, keterangan_tujuan_diet, kebutuhangizi_energi, kebutuhangizi_lemak, kebutuhangizi_protein, kebutuhangizi_vitamin, kebutuhangizi_lainlain, keterangan_kebutuhangizi', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'asesmenawalgiziranap_id' => 'Asesmenawalgizi',
            'tgl_pemeriksaan' => 'Tgl Pemeriksaan',
            'perawat_id' => 'Perawat',
            'pendaftaran_id' => 'Pendaftaran',
            'pasien_id' => 'Pasien',
            'diagnosa_medis' => 'Diagnosa Medis',
            'beratbadan' => 'Beratbadan',
            'tinggibadan' => 'Tinggibadan',
            'nilai_imt' => 'Nilai Imt',
            'lila' => 'Lila',
            'presentase_lila' => 'Presentase Lila',
            'tinggilutut' => 'Tinggilutut',
            'tinggibadan_estimasi' => 'Tinggibadan Estimasi',
            'beratbadan_estimasi' => 'Beratbadan Estimasi',
            'keterangan_antropometri' => 'Keterangan Antropometri',
            'hb' => 'Hb',
            'hb_keterangan' => 'Hb Keterangan',
            'alb' => 'Alb',
            'alb_keterangan' => 'Alb Keterangan',
            'gula_darah' => 'Gula Darah',
            'gula_darah_keterangan' => 'Gula Darah Keterangan',
            'lainlain' => 'Lainlain',
            'lainlain_keterangan' => 'Lainlain Keterangan',
            'keterangan_laboratorium' => 'Keterangan Laboratorium',
            'keadaan_lemah' => 'Keadaan Lemah',
            'keadaan_koma' => 'Keadaan Koma',
            'keadaan_sadar' => 'Keadaan Sadar',
            'tekanandarah_sistolik' => 'Tekanandarah Sistolik',
            'tekanandarah_diastolik' => 'Tekanandarah Diastolik',
            'alatpenunjang_ventilator' => 'Alatpenunjang Ventilator',
            'alatpenunjang_ngt' => 'Alatpenunjang Ngt',
            'alatpenunjang_oksigen' => 'Alatpenunjang Oksigen',
            'keterangan_fisik' => 'Keterangan Fisik',
            'makananpokok' => 'Makananpokok',
            'laukhewani' => 'Laukhewani',
            'lauknabati' => 'Lauknabati',
            'sayuran' => 'Sayuran',
            'buah' => 'Buah',
            'frekuensi_makan' => 'Frekuensi Makan',
            'frekuensi_makan_keterangan' => 'Frekuensi Makan Keterangan',
            'alergi' => 'Alergi',
            'kebiasaanmakan' => 'Kebiasaanmakan',
            'keterangan_riwayatgizi' => 'Keterangan Riwayatgizi',
            'riwayat_penyakit_pasien' => 'Riwayat Penyakit Pasien',
            'keterangan_riwayat_penyakit' => 'Keterangan Riwayat Penyakit',
            'diagnosa_gizi' => 'Diagnosa Gizi',
            'keterangan_diagnosagizi' => 'Keterangan Diagnosagizi',
            'preskripsi_diet' => 'Preskripsi Diet',
            'keterangan_preskripsi_diet' => 'Keterangan Preskripsi Diet',
            'tujuan_diet' => 'Tujuan Diet',
            'keterangan_tujuan_diet' => 'Keterangan Tujuan Diet',
            'kebutuhangizi_energi' => 'Kebutuhangizi Energi',
            'kebutuhangizi_lemak' => 'Kebutuhangizi Lemak',
            'kebutuhangizi_protein' => 'Kebutuhangizi Protein',
            'kebutuhangizi_vitamin' => 'Kebutuhangizi Vitamin',
            'kebutuhangizi_lainlain' => 'Kebutuhangizi Lainlain',
            'keterangan_kebutuhangizi' => 'Keterangan Kebutuhangizi',
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

        $criteria->compare('asesmenawalgiziranap_id', $this->asesmenawalgiziranap_id);
        $criteria->compare('tgl_pemeriksaan', $this->tgl_pemeriksaan, true);
        $criteria->compare('perawat_id', $this->perawat_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('diagnosa_medis', $this->diagnosa_medis, true);
        $criteria->compare('beratbadan', $this->beratbadan);
        $criteria->compare('tinggibadan', $this->tinggibadan);
        $criteria->compare('nilai_imt', $this->nilai_imt);
        $criteria->compare('lila', $this->lila);
        $criteria->compare('presentase_lila', $this->presentase_lila);
        $criteria->compare('tinggilutut', $this->tinggilutut);
        $criteria->compare('tinggibadan_estimasi', $this->tinggibadan_estimasi);
        $criteria->compare('beratbadan_estimasi', $this->beratbadan_estimasi);
        $criteria->compare('keterangan_antropometri', $this->keterangan_antropometri, true);
        $criteria->compare('hb', $this->hb);
        $criteria->compare('hb_keterangan', $this->hb_keterangan, true);
        $criteria->compare('alb', $this->alb);
        $criteria->compare('alb_keterangan', $this->alb_keterangan, true);
        $criteria->compare('gula_darah', $this->gula_darah);
        $criteria->compare('gula_darah_keterangan', $this->gula_darah_keterangan, true);
        $criteria->compare('lainlain', $this->lainlain);
        $criteria->compare('lainlain_keterangan', $this->lainlain_keterangan, true);
        $criteria->compare('keterangan_laboratorium', $this->keterangan_laboratorium, true);
        $criteria->compare('keadaan_lemah', $this->keadaan_lemah);
        $criteria->compare('keadaan_koma', $this->keadaan_koma);
        $criteria->compare('keadaan_sadar', $this->keadaan_sadar);
        $criteria->compare('tekanandarah_sistolik', $this->tekanandarah_sistolik);
        $criteria->compare('tekanandarah_diastolik', $this->tekanandarah_diastolik);
        $criteria->compare('alatpenunjang_ventilator', $this->alatpenunjang_ventilator);
        $criteria->compare('alatpenunjang_ngt', $this->alatpenunjang_ngt);
        $criteria->compare('alatpenunjang_oksigen', $this->alatpenunjang_oksigen);
        $criteria->compare('keterangan_fisik', $this->keterangan_fisik, true);
        $criteria->compare('makananpokok', $this->makananpokok, true);
        $criteria->compare('laukhewani', $this->laukhewani, true);
        $criteria->compare('lauknabati', $this->lauknabati, true);
        $criteria->compare('sayuran', $this->sayuran, true);
        $criteria->compare('buah', $this->buah, true);
        $criteria->compare('frekuensi_makan', $this->frekuensi_makan);
        $criteria->compare('frekuensi_makan_keterangan', $this->frekuensi_makan_keterangan, true);
        $criteria->compare('alergi', $this->alergi, true);
        $criteria->compare('kebiasaanmakan', $this->kebiasaanmakan, true);
        $criteria->compare('keterangan_riwayatgizi', $this->keterangan_riwayatgizi, true);
        $criteria->compare('riwayat_penyakit_pasien', $this->riwayat_penyakit_pasien, true);
        $criteria->compare('keterangan_riwayat_penyakit', $this->keterangan_riwayat_penyakit, true);
        $criteria->compare('diagnosa_gizi', $this->diagnosa_gizi, true);
        $criteria->compare('keterangan_diagnosagizi', $this->keterangan_diagnosagizi, true);
        $criteria->compare('preskripsi_diet', $this->preskripsi_diet, true);
        $criteria->compare('keterangan_preskripsi_diet', $this->keterangan_preskripsi_diet, true);
        $criteria->compare('tujuan_diet', $this->tujuan_diet, true);
        $criteria->compare('keterangan_tujuan_diet', $this->keterangan_tujuan_diet, true);
        $criteria->compare('kebutuhangizi_energi', $this->kebutuhangizi_energi);
        $criteria->compare('kebutuhangizi_lemak', $this->kebutuhangizi_lemak);
        $criteria->compare('kebutuhangizi_protein', $this->kebutuhangizi_protein);
        $criteria->compare('kebutuhangizi_vitamin', $this->kebutuhangizi_vitamin);
        $criteria->compare('kebutuhangizi_lainlain', $this->kebutuhangizi_lainlain, true);
        $criteria->compare('keterangan_kebutuhangizi', $this->keterangan_kebutuhangizi, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
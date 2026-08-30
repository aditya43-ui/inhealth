<?php

/**
 * This is the model class for table "prescription_hd_t".
 *
 * The followings are the available columns in table 'prescription_hd_t':
 * @property integer $prescription_hd_id
 * @property integer $pegawai_id
 * @property integer $dpjp_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $monitoring_post_hd_id
 * @property string $waktu_prescription
 * @property integer $durasi_time
 * @property string $time_satuan
 * @property double $blood_flow
 * @property double $dialysate_flow
 * @property boolean $dialysate_bicarbonat
 * @property boolean $dialysate_lainnya
 * @property string $dialysate_lainnya_keterangan
 * @property boolean $prescription_dokter_akut
 * @property boolean $prescription_dokter_kronis
 * @property boolean $prescription_dokter_pirrt
 * @property string $diayser
 * @property double $dialyser_temperature
 * @property double $uf_goal
 * @property string $akses_vaskular
 * @property boolean $heparinisasi_standar
 * @property boolean $heparinisasi_minimal
 * @property boolean $heparinisasi_tanpaheparin
 * @property string $heparinisasi_tanpaheparin_penyebab
 * @property boolean $heparinisasi_lmwh
 * @property boolean $heparinisasi_lainnya
 * @property string $heparinisasi_lainnya_penyebab
 * @property double $selisih_berat_badan
 * @property double $infus
 * @property boolean $transfusi_darah
 * @property boolean $penggunaan_elektropetin
 * @property boolean $penggunaan_zatbesi
 * @property string $create_time
 * @property string $update_time
 * @property integer $creale_login
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 * @property string $catatan_lain
 *
 * The followings are the available model relations:
 * @property MonitoringPostHdT $monitoringPostHd
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $dpjp
 */
class PrescriptionHdT extends CActiveRecord {

    public $dpjp_nama, $prescription_dokter;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PrescriptionHdT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'prescription_hd_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('waktu_prescription, create_time, create_loginpmakai_id, ruangan_id', 'required'),
            array('prescription_hd_id, pegawai_id, dpjp_id, pendaftaran_id, pasien_id, monitoring_post_hd_id, durasi_time, create_loginpmakai_id, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly' => true),
            array('blood_flow, dialysate_flow, dialyser_temperature, uf_goal, selisih_berat_badan, infus', 'numerical'),
            array('time_satuan, dialysate_lainnya_keterangan, diayser, heparinisasi_tanpaheparin_penyebab, heparinisasi_lainnya_penyebab, catatan_lain', 'length', 'max' => 50),
            array('dialysate_bicarbonat, dialysate_lainnya, prescription_dokter_akut, prescription_dokter_kronis, prescription_dokter_pirrt, heparinisasi_standar, heparinisasi_minimal, heparinisasi_tanpaheparin, heparinisasi_lmwh, heparinisasi_lainnya, transfusi_darah, penggunaan_elektropetin, penggunaan_zatbesi, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('prescription_hd_id, pegawai_id, dpjp_id, pendaftaran_id, pasien_id, monitoring_post_hd_id, waktu_prescription, durasi_time, time_satuan, blood_flow, dialysate_flow, dialysate_bicarbonat, dialysate_lainnya, dialysate_lainnya_keterangan, prescription_dokter_akut, prescription_dokter_kronis, prescription_dokter_pirrt, diayser, dialyser_temperature, uf_goal, akses_vaskular, heparinisasi_standar, heparinisasi_minimal, heparinisasi_tanpaheparin, heparinisasi_tanpaheparin_penyebab, heparinisasi_lmwh, heparinisasi_lainnya, heparinisasi_lainnya_penyebab, selisih_berat_badan, infus, transfusi_darah, penggunaan_elektropetin, penggunaan_zatbesi, create_time, update_time, create_loginpmakai_id, update_loginpemakai_id, ruangan_id, catatan_lain', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'monitoringPostHd' => array(self::BELONGS_TO, 'MonitoringPostHdT', 'monitoring_post_hd_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'prescription_hd_id' => 'Prescription Hd',
            'pegawai_id' => 'Pegawai',
            'dpjp_id' => 'DPJP',
            'pendaftaran_id' => 'Pendaftaran',
            'pasien_id' => 'Pasien',
            'monitoring_post_hd_id' => 'Monitoring Post Hd',
            'waktu_prescription' => 'Waktu Prescription',
            'durasi_time' => 'Durasi Time',
            'time_satuan' => 'Time Satuan',
            'blood_flow' => 'Blood Flow',
            'dialysate_flow' => 'Dialysate Flow',
            'dialysate_bicarbonat' => 'Dialysate Bicarbonat',
            'dialysate_lainnya' => 'Dialysate Lainnya',
            'dialysate_lainnya_keterangan' => 'Dialysate Lainnya Keterangan',
            'prescription_dokter_akut' => 'Prescription Dokter Akut',
            'prescription_dokter_kronis' => 'Prescription Dokter Kronis',
            'prescription_dokter_pirrt' => 'Prescription Dokter Pirrt',
            'diayser' => 'Diayser',
            'dialyser_temperature' => 'Dialyser Temperature',
            'uf_goal' => 'Uf Goal',
            'akses_vaskular' => 'Akses Vaskular',
            'heparinisasi_standar' => 'Heparinisasi Standar',
            'heparinisasi_minimal' => 'Heparinisasi Minimal',
            'heparinisasi_tanpaheparin' => 'Heparinisasi Tanpaheparin',
            'heparinisasi_tanpaheparin_penyebab' => 'Heparinisasi Tanpaheparin Penyebab',
            'heparinisasi_lmwh' => 'Heparinisasi Lmwh',
            'heparinisasi_lainnya' => 'Heparinisasi Lainnya',
            'heparinisasi_lainnya_penyebab' => 'Heparinisasi Lainnya Penyebab',
            'selisih_berat_badan' => 'Selisih Berat Badan',
            'infus' => 'Infus',
            'transfusi_darah' => 'Transfusi Darah',
            'penggunaan_elektropetin' => 'Penggunaan Elektropetin',
            'penggunaan_zatbesi' => 'Penggunaan Zatbesi',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'creale_login' => 'Creale Login',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'ruangan_id' => 'Ruangan',
            'catatan_lain' => 'Catatan Lain',
            'prescription_dokter' => 'Prescription Dokter',
            'heparinisasi' => 'Heparinisasi',
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

        $criteria->compare('prescription_hd_id', $this->prescription_hd_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('dpjp_id', $this->dpjp_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('monitoring_post_hd_id', $this->monitoring_post_hd_id);
        $criteria->compare('waktu_prescription', $this->waktu_prescription, true);
        $criteria->compare('durasi_time', $this->durasi_time);
        $criteria->compare('time_satuan', $this->time_satuan, true);
        $criteria->compare('blood_flow', $this->blood_flow);
        $criteria->compare('dialysate_flow', $this->dialysate_flow);
        $criteria->compare('dialysate_bicarbonat', $this->dialysate_bicarbonat);
        $criteria->compare('dialysate_lainnya', $this->dialysate_lainnya);
        $criteria->compare('dialysate_lainnya_keterangan', $this->dialysate_lainnya_keterangan, true);
        $criteria->compare('prescription_dokter_akut', $this->prescription_dokter_akut);
        $criteria->compare('prescription_dokter_kronis', $this->prescription_dokter_kronis);
        $criteria->compare('prescription_dokter_pirrt', $this->prescription_dokter_pirrt);
        $criteria->compare('diayser', $this->diayser, true);
        $criteria->compare('dialyser_temperature', $this->dialyser_temperature);
        $criteria->compare('uf_goal', $this->uf_goal);
        $criteria->compare('akses_vaskular', $this->akses_vaskular, true);
        $criteria->compare('heparinisasi_standar', $this->heparinisasi_standar);
        $criteria->compare('heparinisasi_minimal', $this->heparinisasi_minimal);
        $criteria->compare('heparinisasi_tanpaheparin', $this->heparinisasi_tanpaheparin);
        $criteria->compare('heparinisasi_tanpaheparin_penyebab', $this->heparinisasi_tanpaheparin_penyebab, true);
        $criteria->compare('heparinisasi_lmwh', $this->heparinisasi_lmwh);
        $criteria->compare('heparinisasi_lainnya', $this->heparinisasi_lainnya);
        $criteria->compare('heparinisasi_lainnya_penyebab', $this->heparinisasi_lainnya_penyebab, true);
        $criteria->compare('selisih_berat_badan', $this->selisih_berat_badan);
        $criteria->compare('infus', $this->infus);
        $criteria->compare('transfusi_darah', $this->transfusi_darah);
        $criteria->compare('penggunaan_elektropetin', $this->penggunaan_elektropetin);
        $criteria->compare('penggunaan_zatbesi', $this->penggunaan_zatbesi);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('creale_login', $this->creale_login);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('catatan_lain', $this->catatan_lain, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian riwayat monitoring
     * @return \CActiveDataProvider
     */
    public function searchRiwayat() {

        $criteria = new CDbCriteria;
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->order = ('create_time DESC');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}

<?php

/**
 * This is the model class for table "monitoring_post_hd_t".
 *
 * The followings are the available columns in table 'monitoring_post_hd_t':
 * @property integer $monitoring_post_hd_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property integer $dpjp_id
 * @property integer $perawat1_id
 * @property integer $perawat2_id2
 * @property integer $jadwalhemodialisa_id
 * @property string $waktu
 * @property string $keluhan
 * @property double $berat_badan
 * @property double $tinggi_badan
 * @property integer $nadi
 * @property integer $respirasi
 * @property double $suhu
 * @property string $lainnya
 * @property boolean $nadi_reguler
 * @property boolean $nadi_irreguler
 * @property boolean $catatan_dipulangkan
 * @property boolean $catatan_igd
 * @property boolean $catatan_lainnya
 * @property boolean $perubahan_perawatan
 * @property string $create_time
 * @property string $update_time
 * @property integer $creale_login
 * @property integer $update_loginpemakai_id
 * @property integer $ruangan_id
 *
 * The followings are the available model relations:
 * @property PrescriptionHdT[] $prescriptionHdTs
 * @property JadwalhemodialisaT $jadwalhemodialisa
 * @property PasienM $pasien
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $perawat2Id2
 * @property PegawaiM $perawat1
 * @property PegawaiM $dpjp
 * @property KelengkapanAlatHdT[] $kelengkapanAlatHdTs
 */
class MonitoringPostHdT extends CActiveRecord {

    public $dpjp_nama, $perawat1_nama, $perawat2_nama, $perubahan;
    public $presdokter, $durasi_time, $time_satuan, $blood_flow, $dialysate_flow, $dialysate, $dialyser, $akses_vaskular, $catatan_lain, $dialyser_temperatur, $uf_goal, $selisih_bb, $infus, $transfusi_darah, $heparinisasi;
    public $tensi_sistolik, $tensi_diastolik, $catatan_lainnya_keterangan;
    public $skornyeri, $keterangan_skriningnyeri, $keluhan_utama_nyeri;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MonitoringPostHdT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'monitoring_post_hd_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('create_time, creale_login, ruangan_id', 'required'),
            array('monitoring_post_hd_id, pasien_id, pendaftaran_id, dpjp_id, perawat1_id, perawat2_id2, jadwalhemodialisa_id, nadi, respirasi, creale_login, update_loginpemakai_id, ruangan_id', 'numerical', 'integerOnly' => true),
            array('berat_badan, tinggi_badan, suhu', 'numerical'),
            array('keluhan, lainnya', 'length', 'max' => 100),
            array('jadwalhemodialisa_tgl_ke, tensi_diastolik, tensi_sistolik, ket_catatan_lainnya, waktu_meninggal, catatan_meninggal, lokasi_nyeri, asesmentnyeri_id, keterangan_keluhanlainnya, is_keluhan_keluhanlainnya, is_keluhan_mualmuntah, is_keluhan_sesaknafas, waktu, nadi_reguler, nadi_irreguler, catatan_dipulangkan, catatan_igd, catatan_lainnya, perubahan_perawatan, update_time, tidaktimbang', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('monitoring_post_hd_id, pasien_id, pendaftaran_id, dpjp_id, perawat1_id, perawat2_id2, jadwalhemodialisa_id, waktu, keluhan, berat_badan, tinggi_badan, nadi, respirasi, suhu, lainnya, nadi_reguler, nadi_irreguler, catatan_dipulangkan, catatan_igd, catatan_lainnya, perubahan_perawatan, create_time, update_time, creale_login, update_loginpemakai_id, ruangan_id, tidaktimbang', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'prescriptionHdTs' => array(self::HAS_MANY, 'PrescriptionHdT', 'monitoring_post_hd_id'),
            'jadwalhemodialisa' => array(self::BELONGS_TO, 'JadwalhemodialisaT', 'jadwalhemodialisa_id'),
            'pasien' => array(self::BELONGS_TO, 'PasienM', 'pasien_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'perawat2Id2' => array(self::BELONGS_TO, 'PegawaiM', 'perawat2_id2'),
            'perawat1' => array(self::BELONGS_TO, 'PegawaiM', 'perawat1_id'),
            'dpjp' => array(self::BELONGS_TO, 'PegawaiM', 'dpjp_id'),
            'kelengkapanAlatHdTs' => array(self::HAS_MANY, 'KelengkapanAlatHdT', 'monitoring_post_hd_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'monitoring_post_hd_id' => 'Monitoring Post Hd',
            'pasien_id' => 'Pasien',
            'pendaftaran_id' => 'Pendaftaran',
            'dpjp_id' => 'Dpjp',
            'perawat1_id' => 'Perawat1',
            'perawat2_id2' => 'Perawat2 Id2',
            'jadwalhemodialisa_id' => 'Jadwalhemodialisa',
            'waktu' => 'Waktu',
            'keluhan' => 'Keluhan',
            'berat_badan' => 'Berat Badan',
            'tinggi_badan' => 'Tinggi Badan',
            'nadi' => 'Nadi',
            'respirasi' => 'Respirasi',
            'suhu' => 'Suhu',
            'lainnya' => 'Lainnya',
            'nadi_reguler' => 'Nadi Reguler',
            'nadi_irreguler' => 'Nadi Irreguler',
            'catatan_dipulangkan' => 'Catatan Dipulangkan',
            'catatan_igd' => 'Catatan Igd',
            'catatan_lainnya' => 'Catatan Lainnya',
            'perubahan_perawatan' => 'Perubahan Perawatan',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'creale_login' => 'Creale Login',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'ruangan_id' => 'Ruangan',
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

        $criteria->compare('monitoring_post_hd_id', $this->monitoring_post_hd_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('dpjp_id', $this->dpjp_id);
        $criteria->compare('perawat1_id', $this->perawat1_id);
        $criteria->compare('perawat2_id2', $this->perawat2_id2);
        $criteria->compare('jadwalhemodialisa_id', $this->jadwalhemodialisa_id);
        $criteria->compare('waktu', $this->waktu, true);
        $criteria->compare('keluhan', $this->keluhan, true);
        $criteria->compare('berat_badan', $this->berat_badan);
        $criteria->compare('tinggi_badan', $this->tinggi_badan);
        $criteria->compare('nadi', $this->nadi);
        $criteria->compare('respirasi', $this->respirasi);
        $criteria->compare('suhu', $this->suhu);
        $criteria->compare('lainnya', $this->lainnya, true);
        $criteria->compare('nadi_reguler', $this->nadi_reguler);
        $criteria->compare('nadi_irreguler', $this->nadi_irreguler);
        $criteria->compare('catatan_dipulangkan', $this->catatan_dipulangkan);
        $criteria->compare('catatan_igd', $this->catatan_igd);
        $criteria->compare('catatan_lainnya', $this->catatan_lainnya);
        $criteria->compare('perubahan_perawatan', $this->perubahan_perawatan);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('creale_login', $this->creale_login);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);

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

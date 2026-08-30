<?php

/**
 * This is the model class for table "asesmenkebutuhan_edukasi_t".
 *
 * The followings are the available columns in table 'asesmenkebutuhan_edukasi_t':
 * @property integer $asesmenkebutuhan_edukasi_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property integer $pendidikan_id
 * @property boolean $kesediaanmenerimaedukasi_status
 * @property string $kesediaanmenerimaedukasi_alasantidak
 * @property boolean $ispenerimaedukasi_pasien
 * @property string $penerimaedukasi_pasien
 * @property boolean $ispenerimaedukasi_keluargapasien
 * @property string $penerimaedukasi_keluargapasien
 * @property boolean $ispenerimaedukasi_lainnya
 * @property string $penerimaedukasi_lainnya
 * @property string $bicara_status
 * @property string $mulaiseranganawal
 * @property string $bahasaseharihari_jenis
 * @property string $bahasadaerah_nama
 * @property string $bahasaasing_nama
 * @property string $bahasaasing_kemampuan
 * @property string $kebutuhanpenerjemah_status
 * @property string $kebutuhanpenerjemah_jenisbahasa
 * @property string $bahasaisyarat_status
 * @property boolean $ishambatanbelajar_bahasa
 * @property string $hambatanbelajar_bahasa
 * @property boolean $ishambatanbelajar_pendengaran
 * @property string $hambatanbelajar_pendengaran
 * @property boolean $ishambatanbelajar_penglihatan
 * @property string $hambatanbelajar_penglihatan
 * @property boolean $ishambatanbelajar_motivasi
 * @property string $hambatanbelajar_motivasi
 * @property boolean $ishambatanbelajar_fisik
 * @property string $hambatanbelajar_fisik
 * @property boolean $ishambatanbelajar_emosi
 * @property string $hambatanbelajar_emosi
 * @property boolean $ishambatanbelajar_butahuruf
 * @property string $hambatanbelajar_butahuruf
 * @property boolean $ishambatanbelajar_usia
 * @property string $hambatanbelajar_usia
 * @property boolean $ishambatanbelajar_kognitif
 * @property string $hambatanbelajar_kognitif
 * @property boolean $ishambatanbelajar_tidakada
 * @property string $hambatanbelajar_tidakada
 * @property boolean $iscarabelajardisukai_menulis
 * @property string $carabelajardisukai_menulis
 * @property boolean $iscarabelajardisukai_audiovisual
 * @property string $carabelajardisukai_audiovisual
 * @property boolean $iscarabelajardisukai_diskusi
 * @property string $carabelajardisukai_diskusi
 * @property boolean $iscarabelajardisukai_demonstrasi
 * @property string $carabelajardisukai_demonstrasi
 * @property boolean $iscarabelajardisukai_membaca
 * @property string $carabelajardisukai_membaca
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 * @property boolean $iscarabelajardisukai_mendengarkan
 * @property string $carabelajardisukai_mendengarkan
 * @property string $penerimaedukasi_namakeluargapasien
 * @property string $penerimaedukasi_lainnyanama
 * @property string $neonatus_edukasidiberikankpd
 * @property string $neonatus_hubkeluargapenerimaedukasi
 * @property string $neonatus_bahasaseharihari
 * @property boolean $neonatus_bahasaseharihari_indo
 * @property string $neonatus_bahasaseharihari_indostatus
 * @property boolean $neonatus_bahasaseharihari_inggris
 * @property string $neonatus_bahasaseharihari_inggrisstatus
 * @property boolean $neonatus_bahasaseharihari_daerah
 * @property string $neonatus_bahasaseharihari_daerahket
 * @property boolean $neonatus_bahasaseharihari_lainnya
 * @property string $neonatus_bahasaseharihari_lainnyaket
 * @property integer $asesmenawalkeperawatan_id
 * @property integer $pemeriksaanfisikneonatus_id
 * @property integer $pemeriksaanfisik_id
 *
 * The followings are the available model relations:
 * @property AsesmenawalkeperawatanT $asesmenawalkeperawatan
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property AsesmenkebutuhanEdukasidetT[] $asesmenkebutuhanEdukasidetTs
 */
class AsesmenkebutuhanEdukasiT extends CActiveRecord {

    public $bicara_status_neonatus, $mulaiseranganawal_neonatus, $kebutuhanpenerjemah_status_neonatus, $kebutuhanpenerjemah_jenisbahasa_neonatus, $bahasaisyarat_status_neonatus, $ishambatanbelajar_bahasa_neonatus, $ishambatanbelajar_emosi_neonatus, $ishambatanbelajar_pendengaran_neonatus, $ishambatanbelajar_butahuruf_neonatus, $ishambatanbelajar_penglihatan_neonatus, $ishambatanbelajar_usia_neonatus, $ishambatanbelajar_motivasi_neonatus, $ishambatanbelajar_kognitif_neonatus, $ishambatanbelajar_fisik_neonatus, $ishambatanbelajar_tidakada_neonatus, $iscarabelajardisukai_menulis_neonatus, $iscarabelajardisukai_demonstrasi_neonatus, $iscarabelajardisukai_audiovisual_neonatus, $iscarabelajardisukai_membaca_neonatus, $iscarabelajardisukai_diskusi_neonatus, $iscarabelajardisukai_mendengarkan_neonatus;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsesmenkebutuhanEdukasiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asesmenkebutuhan_edukasi_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendaftaran_id, create_time, create_loginpemakai', 'required'),
            array('pendaftaran_id, pasienadmisi_id, pendidikan_id, create_petugaspengisi_id, create_ruangan_id, asesmenawalkeperawatan_id, pemeriksaanfisikneonatus_id, pemeriksaanfisik_id', 'numerical', 'integerOnly' => true),
            array('kesediaanmenerimaedukasi_alasantidak, bahasadaerah_nama, bahasaasing_nama, kebutuhanpenerjemah_jenisbahasa, create_loginpemakai, update_loginpemakai, neonatus_bahasaseharihari_daerahket, neonatus_bahasaseharihari_lainnyaket', 'length', 'max' => 100),
            array('penerimaedukasi_pasien, penerimaedukasi_keluargapasien, penerimaedukasi_lainnya, bahasaasing_kemampuan, kebutuhanpenerjemah_status, bahasaisyarat_status, neonatus_edukasidiberikankpd, neonatus_hubkeluargapenerimaedukasi, neonatus_bahasaseharihari, neonatus_bahasaseharihari_indostatus, neonatus_bahasaseharihari_inggrisstatus, nilaikepercayaankhusus', 'length', 'max' => 20),
            array('bicara_status, mulaiseranganawal, bahasaseharihari_jenis, hambatanbelajar_bahasa, hambatanbelajar_pendengaran, hambatanbelajar_penglihatan, hambatanbelajar_motivasi, hambatanbelajar_fisik, hambatanbelajar_emosi, hambatanbelajar_butahuruf, hambatanbelajar_usia, hambatanbelajar_kognitif, hambatanbelajar_tidakada, carabelajardisukai_menulis, carabelajardisukai_audiovisual, carabelajardisukai_diskusi, carabelajardisukai_demonstrasi, carabelajardisukai_membaca, carabelajardisukai_mendengarkan', 'length', 'max' => 50),
            array('penerimaedukasi_namakeluargapasien, penerimaedukasi_lainnyanama', 'length', 'max' => 200),
            array('kesediaanmenerimaedukasi_status, ispenerimaedukasi_pasien, ispenerimaedukasi_keluargapasien, ispenerimaedukasi_lainnya, ishambatanbelajar_bahasa, ishambatanbelajar_pendengaran, ishambatanbelajar_penglihatan, ishambatanbelajar_motivasi, ishambatanbelajar_fisik, ishambatanbelajar_emosi, ishambatanbelajar_butahuruf, ishambatanbelajar_usia, ishambatanbelajar_kognitif, ishambatanbelajar_tidakada, iscarabelajardisukai_menulis, iscarabelajardisukai_audiovisual, iscarabelajardisukai_diskusi, iscarabelajardisukai_demonstrasi, iscarabelajardisukai_membaca, update_time, iscarabelajardisukai_mendengarkan, neonatus_bahasaseharihari_indo, neonatus_bahasaseharihari_inggris, neonatus_bahasaseharihari_daerah, neonatus_bahasaseharihari_lainnya, nilaikepercayaankhususket, , ishambatanbelajar_lainnya, hambatanbelajar_lainnya', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('asesmenkebutuhan_edukasi_id, pendaftaran_id, pasienadmisi_id, pendidikan_id, kesediaanmenerimaedukasi_status, kesediaanmenerimaedukasi_alasantidak, ispenerimaedukasi_pasien, penerimaedukasi_pasien, ispenerimaedukasi_keluargapasien, penerimaedukasi_keluargapasien, ispenerimaedukasi_lainnya, penerimaedukasi_lainnya, bicara_status, mulaiseranganawal, bahasaseharihari_jenis, bahasadaerah_nama, bahasaasing_nama, bahasaasing_kemampuan, kebutuhanpenerjemah_status, kebutuhanpenerjemah_jenisbahasa, bahasaisyarat_status, ishambatanbelajar_bahasa, hambatanbelajar_bahasa, ishambatanbelajar_pendengaran, hambatanbelajar_pendengaran, ishambatanbelajar_penglihatan, hambatanbelajar_penglihatan, ishambatanbelajar_motivasi, hambatanbelajar_motivasi, ishambatanbelajar_fisik, hambatanbelajar_fisik, ishambatanbelajar_emosi, hambatanbelajar_emosi, ishambatanbelajar_butahuruf, hambatanbelajar_butahuruf, ishambatanbelajar_usia, hambatanbelajar_usia, ishambatanbelajar_kognitif, hambatanbelajar_kognitif, ishambatanbelajar_tidakada, hambatanbelajar_tidakada, iscarabelajardisukai_menulis, carabelajardisukai_menulis, iscarabelajardisukai_audiovisual, carabelajardisukai_audiovisual, iscarabelajardisukai_diskusi, carabelajardisukai_diskusi, iscarabelajardisukai_demonstrasi, carabelajardisukai_demonstrasi, iscarabelajardisukai_membaca, carabelajardisukai_membaca, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id, iscarabelajardisukai_mendengarkan, carabelajardisukai_mendengarkan, penerimaedukasi_namakeluargapasien, penerimaedukasi_lainnyanama, neonatus_edukasidiberikankpd, neonatus_hubkeluargapenerimaedukasi, neonatus_bahasaseharihari, neonatus_bahasaseharihari_indo, neonatus_bahasaseharihari_indostatus, neonatus_bahasaseharihari_inggris, neonatus_bahasaseharihari_inggrisstatus, neonatus_bahasaseharihari_daerah, neonatus_bahasaseharihari_daerahket, neonatus_bahasaseharihari_lainnya, neonatus_bahasaseharihari_lainnyaket, asesmenawalkeperawatan_id, pemeriksaanfisikneonatus_id, pemeriksaanfisik_id, nilaikepercayaankhusus, nilaikepercayaankhususket, ishambatanbelajar_lainnya, hambatanbelajar_lainnya', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'asesmenawalkeperawatan' => array(self::BELONGS_TO, 'AsesmenawalkeperawatanT', 'asesmenawalkeperawatan_id'),
            'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
            'asesmenkebutuhanEdukasidetTs' => array(self::HAS_MANY, 'AsesmenkebutuhanEdukasidetT', 'asesmenkebutuhan_edukasi_id'),
            'pendidikan' => array(self::BELONGS_TO, 'PendidikanM', 'pendidikan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'asesmenkebutuhan_edukasi_id' => 'Asesmenkebutuhan Edukasi',
            'pendaftaran_id' => 'Pendaftaran',
            'pasienadmisi_id' => 'Pasienadmisi',
            'pendidikan_id' => 'Tingkat Pendidikan',
            'kesediaanmenerimaedukasi_status' => 'Ketersediaan untuk menerima edukasi',
            'kesediaanmenerimaedukasi_alasantidak' => 'Kesediaanmenerimaedukasi Alasantidak',
            'ispenerimaedukasi_pasien' => 'Ispenerimaedukasi Pasien',
            'penerimaedukasi_pasien' => 'Penerimaedukasi Pasien',
            'ispenerimaedukasi_keluargapasien' => 'Ispenerimaedukasi Keluargapasien',
            'penerimaedukasi_keluargapasien' => 'Penerimaedukasi Keluargapasien',
            'ispenerimaedukasi_lainnya' => 'Ispenerimaedukasi Lainnya',
            'penerimaedukasi_lainnya' => 'Penerimaedukasi Lainnya',
            'bicara_status' => 'Bicara',
            'mulaiseranganawal' => 'Mulaiseranganawal',
            'bahasaseharihari_jenis' => 'Bahasa sehari-hari',
            'bahasadaerah_nama' => 'Bahasadaerah Nama',
            'bahasaasing_nama' => 'Bahasa Asing',
            'bahasaasing_kemampuan' => 'Bahasaasing Kemampuan',
            'kebutuhanpenerjemah_status' => 'Perlu Penerjemah',
            'kebutuhanpenerjemah_jenisbahasa' => 'Kebutuhanpenerjemah Jenisbahasa',
            'bahasaisyarat_status' => 'Bahasa Isyarat',
            'ishambatanbelajar_bahasa' => 'Hambatan Belajar',
            'hambatanbelajar_bahasa' => 'Hambatanbelajar Bahasa',
            'ishambatanbelajar_pendengaran' => 'Ishambatanbelajar Pendengaran',
            'hambatanbelajar_pendengaran' => 'Hambatanbelajar Pendengaran',
            'ishambatanbelajar_penglihatan' => 'Ishambatanbelajar Penglihatan',
            'hambatanbelajar_penglihatan' => 'Hambatanbelajar Penglihatan',
            'ishambatanbelajar_motivasi' => 'Ishambatanbelajar Motivasi',
            'hambatanbelajar_motivasi' => 'Hambatanbelajar Motivasi',
            'ishambatanbelajar_fisik' => 'Ishambatanbelajar Fisik',
            'hambatanbelajar_fisik' => 'Hambatanbelajar Fisik',
            'ishambatanbelajar_emosi' => 'Ishambatanbelajar Emosi',
            'hambatanbelajar_emosi' => 'Hambatanbelajar Emosi',
            'ishambatanbelajar_butahuruf' => 'Ishambatanbelajar Butahuruf',
            'hambatanbelajar_butahuruf' => 'Hambatanbelajar Butahuruf',
            'ishambatanbelajar_usia' => 'Ishambatanbelajar Usia',
            'hambatanbelajar_usia' => 'Hambatanbelajar Usia',
            'ishambatanbelajar_kognitif' => 'Ishambatanbelajar Kognitif',
            'hambatanbelajar_kognitif' => 'Hambatanbelajar Kognitif',
            'ishambatanbelajar_tidakada' => 'Ishambatanbelajar Tidakada',
            'hambatanbelajar_tidakada' => 'Hambatanbelajar Tidakada',
            'iscarabelajardisukai_menulis' => 'Cara Belajar yang disukai',
            'carabelajardisukai_menulis' => 'Carabelajardisukai Menulis',
            'iscarabelajardisukai_audiovisual' => 'Iscarabelajardisukai Audiovisual',
            'carabelajardisukai_audiovisual' => 'Carabelajardisukai Audiovisual',
            'iscarabelajardisukai_diskusi' => 'Iscarabelajardisukai Diskusi',
            'carabelajardisukai_diskusi' => 'Carabelajardisukai Diskusi',
            'iscarabelajardisukai_demonstrasi' => 'Iscarabelajardisukai Demonstrasi',
            'carabelajardisukai_demonstrasi' => 'Carabelajardisukai Demonstrasi',
            'iscarabelajardisukai_membaca' => 'Iscarabelajardisukai Membaca',
            'carabelajardisukai_membaca' => 'Carabelajardisukai Membaca',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai' => 'Create Loginpemakai',
            'update_loginpemakai' => 'Update Loginpemakai',
            'create_petugaspengisi_id' => 'Create Petugaspengisi',
            'create_ruangan_id' => 'Create Ruangan',
            'neonatus_edukasidiberikankpd' => 'Edukasi Diberikan Kepada'
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

        $criteria->compare('asesmenkebutuhan_edukasi_id', $this->asesmenkebutuhan_edukasi_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pasienadmisi_id', $this->pasienadmisi_id);
        $criteria->compare('pendidikan_id', $this->pendidikan_id);
        $criteria->compare('kesediaanmenerimaedukasi_status', $this->kesediaanmenerimaedukasi_status);
        $criteria->compare('kesediaanmenerimaedukasi_alasantidak', $this->kesediaanmenerimaedukasi_alasantidak, true);
        $criteria->compare('ispenerimaedukasi_pasien', $this->ispenerimaedukasi_pasien);
        $criteria->compare('penerimaedukasi_pasien', $this->penerimaedukasi_pasien, true);
        $criteria->compare('ispenerimaedukasi_keluargapasien', $this->ispenerimaedukasi_keluargapasien);
        $criteria->compare('penerimaedukasi_keluargapasien', $this->penerimaedukasi_keluargapasien, true);
        $criteria->compare('ispenerimaedukasi_lainnya', $this->ispenerimaedukasi_lainnya);
        $criteria->compare('penerimaedukasi_lainnya', $this->penerimaedukasi_lainnya, true);
        $criteria->compare('bicara_status', $this->bicara_status, true);
        $criteria->compare('mulaiseranganawal', $this->mulaiseranganawal, true);
        $criteria->compare('bahasaseharihari_jenis', $this->bahasaseharihari_jenis, true);
        $criteria->compare('bahasadaerah_nama', $this->bahasadaerah_nama, true);
        $criteria->compare('bahasaasing_nama', $this->bahasaasing_nama, true);
        $criteria->compare('bahasaasing_kemampuan', $this->bahasaasing_kemampuan, true);
        $criteria->compare('kebutuhanpenerjemah_status', $this->kebutuhanpenerjemah_status, true);
        $criteria->compare('kebutuhanpenerjemah_jenisbahasa', $this->kebutuhanpenerjemah_jenisbahasa, true);
        $criteria->compare('bahasaisyarat_status', $this->bahasaisyarat_status, true);
        $criteria->compare('ishambatanbelajar_bahasa', $this->ishambatanbelajar_bahasa);
        $criteria->compare('hambatanbelajar_bahasa', $this->hambatanbelajar_bahasa, true);
        $criteria->compare('ishambatanbelajar_pendengaran', $this->ishambatanbelajar_pendengaran);
        $criteria->compare('hambatanbelajar_pendengaran', $this->hambatanbelajar_pendengaran, true);
        $criteria->compare('ishambatanbelajar_penglihatan', $this->ishambatanbelajar_penglihatan);
        $criteria->compare('hambatanbelajar_penglihatan', $this->hambatanbelajar_penglihatan, true);
        $criteria->compare('ishambatanbelajar_motivasi', $this->ishambatanbelajar_motivasi);
        $criteria->compare('hambatanbelajar_motivasi', $this->hambatanbelajar_motivasi, true);
        $criteria->compare('ishambatanbelajar_fisik', $this->ishambatanbelajar_fisik);
        $criteria->compare('hambatanbelajar_fisik', $this->hambatanbelajar_fisik, true);
        $criteria->compare('ishambatanbelajar_emosi', $this->ishambatanbelajar_emosi);
        $criteria->compare('hambatanbelajar_emosi', $this->hambatanbelajar_emosi, true);
        $criteria->compare('ishambatanbelajar_butahuruf', $this->ishambatanbelajar_butahuruf);
        $criteria->compare('hambatanbelajar_butahuruf', $this->hambatanbelajar_butahuruf, true);
        $criteria->compare('ishambatanbelajar_usia', $this->ishambatanbelajar_usia);
        $criteria->compare('hambatanbelajar_usia', $this->hambatanbelajar_usia, true);
        $criteria->compare('ishambatanbelajar_kognitif', $this->ishambatanbelajar_kognitif);
        $criteria->compare('hambatanbelajar_kognitif', $this->hambatanbelajar_kognitif, true);
        $criteria->compare('ishambatanbelajar_tidakada', $this->ishambatanbelajar_tidakada);
        $criteria->compare('hambatanbelajar_tidakada', $this->hambatanbelajar_tidakada, true);
        $criteria->compare('iscarabelajardisukai_menulis', $this->iscarabelajardisukai_menulis);
        $criteria->compare('carabelajardisukai_menulis', $this->carabelajardisukai_menulis, true);
        $criteria->compare('iscarabelajardisukai_audiovisual', $this->iscarabelajardisukai_audiovisual);
        $criteria->compare('carabelajardisukai_audiovisual', $this->carabelajardisukai_audiovisual, true);
        $criteria->compare('iscarabelajardisukai_diskusi', $this->iscarabelajardisukai_diskusi);
        $criteria->compare('carabelajardisukai_diskusi', $this->carabelajardisukai_diskusi, true);
        $criteria->compare('iscarabelajardisukai_demonstrasi', $this->iscarabelajardisukai_demonstrasi);
        $criteria->compare('carabelajardisukai_demonstrasi', $this->carabelajardisukai_demonstrasi, true);
        $criteria->compare('iscarabelajardisukai_membaca', $this->iscarabelajardisukai_membaca);
        $criteria->compare('carabelajardisukai_membaca', $this->carabelajardisukai_membaca, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai', $this->create_loginpemakai, true);
        $criteria->compare('update_loginpemakai', $this->update_loginpemakai, true);
        $criteria->compare('create_petugaspengisi_id', $this->create_petugaspengisi_id);
        $criteria->compare('create_ruangan_id', $this->create_ruangan_id);
        $criteria->compare('iscarabelajardisukai_mendengarkan', $this->iscarabelajardisukai_mendengarkan);
        $criteria->compare('carabelajardisukai_mendengarkan', $this->carabelajardisukai_mendengarkan, true);
        $criteria->compare('penerimaedukasi_namakeluargapasien', $this->penerimaedukasi_namakeluargapasien, true);
        $criteria->compare('penerimaedukasi_lainnyanama', $this->penerimaedukasi_lainnyanama, true);
        $criteria->compare('neonatus_edukasidiberikankpd', $this->neonatus_edukasidiberikankpd, true);
        $criteria->compare('neonatus_hubkeluargapenerimaedukasi', $this->neonatus_hubkeluargapenerimaedukasi, true);
        $criteria->compare('neonatus_bahasaseharihari', $this->neonatus_bahasaseharihari, true);
        $criteria->compare('neonatus_bahasaseharihari_indo', $this->neonatus_bahasaseharihari_indo);
        $criteria->compare('neonatus_bahasaseharihari_indostatus', $this->neonatus_bahasaseharihari_indostatus, true);
        $criteria->compare('neonatus_bahasaseharihari_inggris', $this->neonatus_bahasaseharihari_inggris);
        $criteria->compare('neonatus_bahasaseharihari_inggrisstatus', $this->neonatus_bahasaseharihari_inggrisstatus, true);
        $criteria->compare('neonatus_bahasaseharihari_daerah', $this->neonatus_bahasaseharihari_daerah);
        $criteria->compare('neonatus_bahasaseharihari_daerahket', $this->neonatus_bahasaseharihari_daerahket, true);
        $criteria->compare('neonatus_bahasaseharihari_lainnya', $this->neonatus_bahasaseharihari_lainnya);
        $criteria->compare('neonatus_bahasaseharihari_lainnyaket', $this->neonatus_bahasaseharihari_lainnyaket, true);
        $criteria->compare('asesmenawalkeperawatan_id', $this->asesmenawalkeperawatan_id);
        $criteria->compare('pemeriksaanfisikneonatus_id', $this->pemeriksaanfisikneonatus_id);
        $criteria->compare('pemeriksaanfisik_id', $this->pemeriksaanfisik_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

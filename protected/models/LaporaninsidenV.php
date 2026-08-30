<?php

/**
 * This is the model class for table "laporaninsiden_v".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'laporaninsiden_v':
 * @property string $nama_pasien
 * @property string $jeniskelamin
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $alamat_pasien
 * @property string $no_rekam_medik
 * @property integer $pendaftaran_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $umur
 * @property string $tanggal_insiden
 * @property string $waktu_insiden
 * @property string $insidenrs_kronologis
 * @property string $insidenrs_pelapor
 * @property integer $lokasikejadian_id
 * @property string $insidenrs_jenis
 * @property integer $unitkerjatempat_id
 * @property string $tindakan_setelah
 * @property integer $mengetahui_id
 * @property integer $insidenrsdet_id
 * @property integer $diagnosa_id
 * @property string $diagnosa_nama
 * @property integer $tipeinsiden_id
 * @property string $tipeinsiden_nama
 * @property integer $subtipeinsiden_id
 * @property string $subtipeinsiden_nama
 * @property integer $konsekuensi_id
 * @property string $konsekuensi_deskripsi
 * @property string $gradingrisiko
 * @property string $regradingrisiko
 * @property string $tindakan
 */
class LaporaninsidenV extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return laporaninsidenV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'laporaninsiden_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pendaftaran_id, lokasikejadian_id, unitkerjatempat_id, mengetahui_id, insidenrsdet_id, diagnosa_id, tipeinsiden_id, subtipeinsiden_id, konsekuensi_id', 'numerical', 'integerOnly' => true),
            array('nama_pasien', 'length', 'max' => 50),
            array('jeniskelamin, no_pendaftaran', 'length', 'max' => 20),
            array('tempat_lahir', 'length', 'max' => 25),
            array('no_rekam_medik', 'length', 'max' => 10),
            array('umur', 'length', 'max' => 30),
            array('insidenrs_pelapor, insidenrs_jenis, tipeinsiden_nama', 'length', 'max' => 100),
            array('diagnosa_nama', 'length', 'max' => 200),
            array('subtipeinsiden_nama', 'length', 'max' => 500),
            array('gradingrisiko, regradingrisiko', 'length', 'max' => 150),
            array('tanggal_lahir, alamat_pasien, tgl_pendaftaran, tanggal_insiden, waktu_insiden, insidenrs_kronologis, tindakan_setelah, konsekuensi_deskripsi, tindakan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nama_pasien, jeniskelamin, tempat_lahir, tanggal_lahir, alamat_pasien, no_rekam_medik, pendaftaran_id, no_pendaftaran, tgl_pendaftaran, umur, tanggal_insiden, waktu_insiden, insidenrs_kronologis, insidenrs_pelapor, lokasikejadian_id, insidenrs_jenis, unitkerjatempat_id, tindakan_setelah, mengetahui_id, insidenrsdet_id, diagnosa_id, diagnosa_nama, tipeinsiden_id, tipeinsiden_nama, subtipeinsiden_id, subtipeinsiden_nama, konsekuensi_id, konsekuensi_deskripsi, gradingrisiko, regradingrisiko, tindakan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'nama_pasien' => 'Nama Pasien',
            'jeniskelamin' => 'Jeniskelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat_pasien' => 'Alamat Pasien',
            'no_rekam_medik' => 'No Rekam Medik',
            'pendaftaran_id' => 'Pendaftaran',
            'no_pendaftaran' => 'No Pendaftaran',
            'tgl_pendaftaran' => 'Tgl Pendaftaran',
            'umur' => 'Umur',
            'tanggal_insiden' => 'Tanggal Insiden',
            'waktu_insiden' => 'Waktu Insiden',
            'insidenrs_kronologis' => 'Insidenrs Kronologis',
            'insidenrs_pelapor' => 'Insidenrs Pelapor',
            'lokasikejadian_id' => 'Lokasikejadian',
            'insidenrs_jenis' => 'Insidenrs Jenis',
            'unitkerjatempat_id' => 'Unitkerjatempat',
            'tindakan_setelah' => 'Tindakan Setelah',
            'mengetahui_id' => 'Mengetahui',
            'insidenrsdet_id' => 'Insidenrsdet',
            'diagnosa_id' => 'Diagnosa',
            'diagnosa_nama' => 'Diagnosa Nama',
            'tipeinsiden_id' => 'Tipeinsiden',
            'tipeinsiden_nama' => 'Tipeinsiden Nama',
            'subtipeinsiden_id' => 'Subtipeinsiden',
            'subtipeinsiden_nama' => 'Subtipeinsiden Nama',
            'konsekuensi_id' => 'Konsekuensi',
            'konsekuensi_deskripsi' => 'Konsekuensi Deskripsi',
            'gradingrisiko' => 'Gradingrisiko',
            'regradingrisiko' => 'Regradingrisiko',
            'tindakan' => 'Tindakan',
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

        $criteria->compare('nama_pasien', $this->nama_pasien, true);
        $criteria->compare('jeniskelamin', $this->jeniskelamin, true);
        $criteria->compare('tempat_lahir', $this->tempat_lahir, true);
        $criteria->compare('tanggal_lahir', $this->tanggal_lahir, true);
        $criteria->compare('alamat_pasien', $this->alamat_pasien, true);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('no_pendaftaran', $this->no_pendaftaran, true);
        $criteria->compare('tgl_pendaftaran', $this->tgl_pendaftaran, true);
        $criteria->compare('umur', $this->umur, true);
        $criteria->compare('tanggal_insiden', $this->tanggal_insiden, true);
        $criteria->compare('waktu_insiden', $this->waktu_insiden, true);
        $criteria->compare('insidenrs_kronologis', $this->insidenrs_kronologis, true);
        $criteria->compare('insidenrs_pelapor', $this->insidenrs_pelapor, true);
        $criteria->compare('lokasikejadian_id', $this->lokasikejadian_id);
        $criteria->compare('insidenrs_jenis', $this->insidenrs_jenis, true);
        $criteria->compare('unitkerjatempat_id', $this->unitkerjatempat_id);
        $criteria->compare('tindakan_setelah', $this->tindakan_setelah, true);
        $criteria->compare('mengetahui_id', $this->mengetahui_id);
        $criteria->compare('insidenrsdet_id', $this->insidenrsdet_id);
        $criteria->compare('diagnosa_id', $this->diagnosa_id);
        $criteria->compare('diagnosa_nama', $this->diagnosa_nama, true);
        $criteria->compare('tipeinsiden_id', $this->tipeinsiden_id);
        $criteria->compare('tipeinsiden_nama', $this->tipeinsiden_nama, true);
        $criteria->compare('subtipeinsiden_id', $this->subtipeinsiden_id);
        $criteria->compare('subtipeinsiden_nama', $this->subtipeinsiden_nama, true);
        $criteria->compare('konsekuensi_id', $this->konsekuensi_id);
        $criteria->compare('konsekuensi_deskripsi', $this->konsekuensi_deskripsi, true);
        $criteria->compare('gradingrisiko', $this->gradingrisiko, true);
        $criteria->compare('regradingrisiko', $this->regradingrisiko, true);
        $criteria->compare('tindakan', $this->tindakan, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Criteria pencarian pada grafik
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;

        $criteria->compare('nama_pasien', $this->nama_pasien, true);
        $criteria->compare('jeniskelamin', $this->jeniskelamin, true);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('umur', $this->umur, true);
        $criteria->compare('tanggal_insiden', $this->tanggal_insiden, true);
        $criteria->compare('waktu_insiden', $this->waktu_insiden, true);
        $criteria->compare('insidenrs_kronologis', $this->insidenrs_kronologis, true);
        $criteria->compare('insidenrs_pelapor', $this->insidenrs_pelapor, true);
        $criteria->compare('lokasikejadian_id', $this->lokasikejadian_id);
        $criteria->compare('insidenrs_jenis', $this->insidenrs_jenis, true);
        $criteria->compare('unitkerjatempat_id', $this->unitkerjatempat_id);
        $criteria->compare('tindakan_setelah', $this->tindakan_setelah, true);
        $criteria->compare('mengetahui_id', $this->mengetahui_id);
//        $criteria->compare('insidenrsdet_id', $this->insidenrsdet_id);
        $criteria->compare('diagnosa_id', $this->diagnosa_id);
        $criteria->compare('diagnosa_nama', $this->diagnosa_nama, true);
//        $criteria->compare('tipeinsiden_id', $this->tipeinsiden_id);
//        $criteria->compare('tipeinsiden_nama', $this->tipeinsiden_nama, true);
//        $criteria->compare('subtipeinsiden_id', $this->subtipeinsiden_id);
//        $criteria->compare('subtipeinsiden_nama', $this->subtipeinsiden_nama, true);
        $criteria->compare('konsekuensi_id', $this->konsekuensi_id);
        $criteria->compare('konsekuensi_deskripsi', $this->konsekuensi_deskripsi, true);
        $criteria->compare('gradingrisiko', $this->gradingrisiko, true);
        $criteria->compare('regradingrisiko', $this->regradingrisiko, true);
        $criteria->compare('tindakan', $this->tindakan, true);
        return $criteria;
    }

}

<?php

/**
 * This is the model class for table "oppeperilaku_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'oppeperilaku_t':
 * @property integer $oppeperilaku_id
 * @property integer $indikatoroppekeperawatan_id
 * @property integer $pegawai_id
 * @property integer $ka_unitkerja_id
 * @property integer $unitkerja_id
 * @property string $bulan_pencatatan
 * @property integer $perawat_id
 * @property string $nama_perawat
 * @property string $nip_perawat
 * @property integer $perawat_unitkerja_id
 * @property double $nilai_sejawat
 * @property double $nilai_pasien
 * @property double $nilai_dokter
 * @property double $nilai_rata
 * @property integer $create_loginpemakai_id
 * @property string $create_time
 * @property integer $update_loginpemakai_id
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 * @property IndikatoroppekeperawatanM $indikatoroppekeperawatan
 */
class OppeperilakuT extends CActiveRecord {

    public $namaunitkerja;
    public $smf_nama;
    public $capaian;
    public $jumlah;
    public $nama_indikator;
    public $standar_nilai;
    public $golongan_indikator;
    public $rekomendasi, $bulan_pilih_awal, $bulan_pilih_akhir;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return OppeperilakuT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'oppeperilaku_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ka_unitkerja_id, unitkerja_id, bulan_pencatatan, nama_perawat, pegawai_id, nip_perawat, perawat_unitkerja_id, create_loginpemakai_id, create_time', 'required'),
            array('indikatoroppekeperawatan_id, pegawai_id, ka_unitkerja_id, unitkerja_id, perawat_unitkerja_id, create_loginpemakai_id, update_loginpemakai_id', 'numerical', 'integerOnly' => true),
            array('nilai_keluarga, nilai_sejawat, nilai_pasien, nilai_dokter, nilai_rata', 'numerical'),
            array('nama_perawat, nip_perawat', 'length', 'max' => 255),
            array('update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('oppeperilaku_id, indikatoroppekeperawatan_id, pegawai_id, ka_unitkerja_id, unitkerja_id, bulan_pencatatan, nama_perawat, nip_perawat, perawat_unitkerja_id, nilai_sejawat, nilai_pasien, nilai_dokter, nilai_rata, create_loginpemakai_id, create_time, update_loginpemakai_id, update_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
            'indikatoroppekeperawatan' => array(self::BELONGS_TO, 'IndikatoroppekeperawatanM', 'indikatoroppekeperawatan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'oppeperilaku_id' => 'Oppeperilaku',
            'indikatoroppekeperawatan_id' => 'Nama Indikator',
            'pegawai_id' => 'Nama Perawat',
            'ka_unitkerja_id' => 'Ka Unitkerja',
            'unitkerja_id' => 'Unit Kerja',
            'bulan_pencatatan' => 'Bulan Kuisioner',
            'nama_perawat' => 'Nama Perawat',
            'nip_perawat' => 'NIP Perawat',
            'perawat_unitkerja_id' => 'Unit Kerja',
            'nilai_sejawat' => 'Sejawat',
            'nilai_pasien' => 'Pasien',
            'nilai_keluarga' => 'Keluarga Pasien',
            'nilai_dokter' => 'Dokter',
            'nilai_rata' => 'Nilai Rata',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'create_time' => 'Waktu Create',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'update_time' => 'Waktu Update',
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

        $criteria->compare('oppeperilaku_id', $this->oppeperilaku_id);
        $criteria->compare('indikatoroppekeperawatan_id', $this->indikatoroppekeperawatan_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('ka_unitkerja_id', $this->ka_unitkerja_id);
        $criteria->compare('unitkerja_id', $this->unitkerja_id);
//        if(!empty($this->bulan_pencatatan)){
            $criteria->addBetweenCondition('DATE(bulan_pencatatan)', $this->bulan_pilih_awal, $this->bulan_pilih_akhir);
//        }
        $criteria->compare('nama_perawat', $this->nama_perawat, true);
        $criteria->compare('nip_perawat', $this->nip_perawat, true);
        $criteria->compare('perawat_unitkerja_id', $this->perawat_unitkerja_id);
        $criteria->compare('nilai_sejawat', $this->nilai_sejawat);
        $criteria->compare('nilai_pasien', $this->nilai_pasien);
        $criteria->compare('nilai_dokter', $this->nilai_dokter);
        $criteria->compare('nilai_rata', $this->nilai_rata);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('update_time', $this->update_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

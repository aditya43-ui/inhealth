<?php

/**
 * This is the model class for table "rinciantagihanpasienbankdarah_v".
 * @author  Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'rinciantagihanpasienbankdarah_v':
 * @property integer $permintaandarah_id
 * @property string $tglpermintaan
 * @property string $no_permintaandarah
 * @property string $jenispermintaan
 * @property integer $pasien_id
 * @property string $namadepan
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property string $alamat_pasien
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $pendaftaran_id
 * @property string $tgl_pendaftaran
 * @property string $no_pendaftaran
 * @property integer $ruanganpemesan_id
 * @property string $ruangan_nama
 * @property integer $pegpemesan_id
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property string $gelarbelakang_nama
 * @property double $total_tarif
 * @property double $total_bayar
 */
class RinciantagihanpasienbankdarahV extends CActiveRecord {

    public $tgl_awal, $tgl_akhir, $status_bayar;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RinciantagihanpasienbankdarahV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rinciantagihanpasienbankdarah_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('permintaandarah_id, pasien_id, pendaftaran_id, ruanganpemesan_id, pegpemesan_id', 'numerical', 'integerOnly' => true),
            array('total_tarif, total_bayar', 'numerical'),
            array('no_permintaandarah, nama_pasien, ruangan_nama, nama_pegawai', 'length', 'max' => 50),
            array('jenispermintaan, no_rekam_medik, gelardepan', 'length', 'max' => 10),
            array('namadepan, rhesus, no_pendaftaran', 'length', 'max' => 20),
            array('golongandarah', 'length', 'max' => 2),
            array('gelarbelakang_nama', 'length', 'max' => 25),
            array('tglpermintaan, alamat_pasien, tgl_pendaftaran', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('permintaandarah_id, tglpermintaan, no_permintaandarah, jenispermintaan, pasien_id, namadepan, nama_pasien, no_rekam_medik, alamat_pasien, golongandarah, rhesus, pendaftaran_id, tgl_pendaftaran, no_pendaftaran, ruanganpemesan_id, ruangan_nama, pegpemesan_id, gelardepan, nama_pegawai, gelarbelakang_nama, total_tarif, total_bayar', 'safe', 'on' => 'search'),
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
            'permintaandarah_id' => 'Permintaandarah',
            'tglpermintaan' => 'Tglpermintaan',
            'no_permintaandarah' => 'No Permintaandarah',
            'jenispermintaan' => 'Jenispermintaan',
            'pasien_id' => 'Pasien',
            'namadepan' => 'Namadepan',
            'nama_pasien' => 'Nama Pasien',
            'no_rekam_medik' => 'No. Rekam Medik',
            'alamat_pasien' => 'Alamat Pasien',
            'golongandarah' => 'Golongandarah',
            'rhesus' => 'Rhesus',
            'pendaftaran_id' => 'Pendaftaran',
            'tgl_pendaftaran' => 'Tgl. Pendaftaran',
            'no_pendaftaran' => 'No. Pendaftaran',
            'ruanganpemesan_id' => 'Ruanganpemesan',
            'ruangan_nama' => 'Ruangan Nama',
            'pegpemesan_id' => 'Pegpemesan',
            'gelardepan' => 'Gelardepan',
            'nama_pegawai' => 'Nama Pegawai',
            'gelarbelakang_nama' => 'Gelarbelakang Nama',
            'total_tarif' => 'Total Tarif',
            'total_bayar' => 'Total Bayar',
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

        $criteria->compare('permintaandarah_id', $this->permintaandarah_id);
        //$criteria->compare('tglpermintaan',$this->tglpermintaan,true);
        $criteria->addBetweenCondition('DATE(tglpermintaan)', $this->tgl_awal, $this->tgl_akhir);
        //$criteria->compare('no_permintaandarah',$this->no_permintaandarah,true);
        $criteria->compare('LOWER(no_permintaandarah)', strtolower($this->no_permintaandarah), true);
        $criteria->compare('jenispermintaan', $this->jenispermintaan, true);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('namadepan', $this->namadepan, true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('alamat_pasien', $this->alamat_pasien, true);
        $criteria->compare('golongandarah', $this->golongandarah, true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        //$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
        //$criteria->addBetweenCondition('DATE(tgl_pendaftaran)',$this->tgl_awal,$this->tgl_akhir);
        //$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
        $criteria->compare('ruanganpemesan_id', $this->ruanganpemesan_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('pegpemesan_id', $this->pegpemesan_id);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('total_tarif', $this->total_tarif);
        $criteria->compare('total_bayar', $this->total_bayar);
        if(!empty($this->status_bayar)){
            if($this->status_bayar == 1){
                $criteria->addCondition ('total_tarif = total_bayar');
            }else{
                $criteria->addCondition ('total_tarif != total_bayar');
            }
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

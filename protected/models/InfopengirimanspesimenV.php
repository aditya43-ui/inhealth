<?php

/**
 * This is the model class for table "infopengirimanspesimen_v".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'infopengirimanspesimen_v':
 * @property integer $pengirimanspesimendet_id
 * @property integer $pengirimanspesimen_id
 * @property string $tglkirimspesimen
 * @property string $no_kirimspesimen
 * @property integer $petugaskirim_id
 * @property string $nama_pegawai
 * @property integer $tindakanpelayanan_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $ruanganasal_id
 * @property string $ruangan_nama
 * @property string $daftartindakan_nama
 * @property integer $spesimen_id
 * @property integer $pasien_id
 * @property string $nama_pasien
 * @property string $no_rekam_medik
 * @property string $no_spesimen
 * @property string $samplelab_nama
 * @property boolean $is_batalpengiriman
 * @property string $status
 */
class InfopengirimanspesimenV extends CActiveRecord {
    
    public $detail;
    public $tgl_akhir, $tgl_awal, $petugaskirim_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InfopengirimanspesimenV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'infopengirimanspesimen_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pengirimanspesimendet_id, pengirimanspesimen_id, petugaskirim_id, tindakanpelayanan_id, pasienmasukpenunjang_id, ruanganasal_id, spesimen_id, pasien_id', 'numerical', 'integerOnly' => true),
            array('no_kirimspesimen, nama_pegawai, ruangan_nama, nama_pasien, samplelab_nama', 'length', 'max' => 50),
            array('daftartindakan_nama', 'length', 'max' => 200),
            array('no_rekam_medik', 'length', 'max' => 10),
            array('no_spesimen', 'length', 'max' => 100),
            array('tglkirimspesimen, is_batalpengiriman, status', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pengirimanspesimendet_id, pengirimanspesimen_id, tglkirimspesimen, no_kirimspesimen, petugaskirim_id, nama_pegawai, tindakanpelayanan_id, pasienmasukpenunjang_id, ruanganasal_id, ruangan_nama, daftartindakan_nama, spesimen_id, pasien_id, nama_pasien, no_rekam_medik, no_spesimen, samplelab_nama, is_batalpengiriman, status', 'safe', 'on' => 'search'),
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
            'pengirimanspesimendet_id' => 'Pengirimanspesimendet',
            'pengirimanspesimen_id' => 'Pengirimanspesimen',
            'tglkirimspesimen' => 'Tglkirimspesimen',
            'no_kirimspesimen' => 'No Kirimspesimen',
            'petugaskirim_id' => 'Petugaskirim',
            'nama_pegawai' => 'Nama Pegawai',
            'tindakanpelayanan_id' => 'Tindakanpelayanan',
            'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
            'ruanganasal_id' => 'Ruanganasal',
            'ruangan_nama' => 'Ruangan Nama',
            'daftartindakan_nama' => 'Daftartindakan Nama',
            'spesimen_id' => 'Spesimen',
            'pasien_id' => 'Pasien',
            'nama_pasien' => 'Nama Pasien',
            'no_rekam_medik' => 'No Rekam Medik',
            'no_spesimen' => 'No Spesimen',
            'samplelab_nama' => 'Samplelab Nama',
            'is_batalpengiriman' => 'Is Batalpengiriman',
            'status' => 'Status',
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

        $criteria->compare('pengirimanspesimendet_id', $this->pengirimanspesimendet_id);
        $criteria->compare('pengirimanspesimen_id', $this->pengirimanspesimen_id);
        $criteria->compare('tglkirimspesimen', $this->tglkirimspesimen, true);
        $criteria->compare('no_kirimspesimen', $this->no_kirimspesimen, true);
        $criteria->compare('petugaskirim_id', $this->petugaskirim_id);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
        $criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
        $criteria->compare('ruanganasal_id', $this->ruanganasal_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('daftartindakan_nama', $this->daftartindakan_nama, true);
        $criteria->compare('spesimen_id', $this->spesimen_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('nama_pasien', $this->nama_pasien, true);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('no_spesimen', $this->no_spesimen, true);
        $criteria->compare('samplelab_nama', $this->samplelab_nama, true);
        $criteria->compare('is_batalpengiriman', $this->is_batalpengiriman);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('pengirimanspesimendet_id', $this->pengirimanspesimendet_id);
        $criteria->compare('pengirimanspesimen_id', $this->pengirimanspesimen_id);
        $criteria->compare('tglkirimspesimen', $this->tglkirimspesimen, true);
        $criteria->compare('no_kirimspesimen', $this->no_kirimspesimen, true);
        $criteria->compare('petugaskirim_id', $this->petugaskirim_id);
        $criteria->compare('nama_pegawai', $this->nama_pegawai, true);
        $criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
        $criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
        $criteria->compare('ruanganasal_id', $this->ruanganasal_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('daftartindakan_nama', $this->daftartindakan_nama, true);
        $criteria->compare('spesimen_id', $this->spesimen_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('nama_pasien', $this->nama_pasien, true);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('no_spesimen', $this->no_spesimen, true);
        $criteria->compare('samplelab_nama', $this->samplelab_nama, true);
        $criteria->compare('is_batalpengiriman', $this->is_batalpengiriman);
        $criteria->compare('status', $this->status, true);
        $criteria->addCondition('penerimaanspesimendet_id is null');
        $criteria->addCondition('is_batalpengiriman is null');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data informasi pengiriman spesimen
     * @return \CActiveDataProvider
     */
    public function searchInformasi() {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('DATE(t.tglkirimspesimen)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('pengirimanspesimendet_id', $this->pengirimanspesimendet_id);
        $criteria->compare('pengirimanspesimen_id', $this->pengirimanspesimen_id);
        $criteria->compare('LOWER(no_kirimspesimen)', strtolower($this->no_kirimspesimen), true);
        $criteria->compare('petugaskirim_id', $this->petugaskirim_id);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('tindakanpelayanan_id', $this->tindakanpelayanan_id);
        $criteria->compare('pasienmasukpenunjang_id', $this->pasienmasukpenunjang_id);
        $criteria->compare('ruanganasal_id', $this->ruanganasal_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('daftartindakan_nama', $this->daftartindakan_nama, true);
        $criteria->compare('spesimen_id', $this->spesimen_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('nama_pasien', $this->nama_pasien, true);
        $criteria->compare('no_rekam_medik', $this->no_rekam_medik, true);
        $criteria->compare('no_spesimen', $this->no_spesimen, true);
        $criteria->compare('samplelab_nama', $this->samplelab_nama, true);
        $criteria->addCondition('is_batalpengiriman is null');
        $criteria->compare('LOWER(status)', strtolower($this->status), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

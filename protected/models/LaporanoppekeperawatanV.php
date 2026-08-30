<?php

/**
 * This is the model class for table "laporanoppekeperawatan_v".
 * @author Aida Rahmawati <aidarahmawati@example.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'laporanoppekeperawatan_v':
 * @property integer $oppekeperawatan_id
 * @property integer $indikatoroppekeperawatan_id
 * @property string $kode_indikator
 * @property string $golongan_indikator
 * @property string $periodebulan
 * @property integer $unitkerja_id
 * @property string $namaunitkerja
 * @property integer $ka_unitkerja_id
 * @property string $namakepalaunit
 * @property integer $pegawai_id
 * @property string $nama_perawat
 * @property string $nip_perawat
 * @property integer $perawat_unitkerja_id
 * @property double $standar_nilai
 * @property double $capaian
 * @property double $skor
 * @property string $keterangan
 * @property string $rekomendasi
 */
class LaporanoppekeperawatanV extends CActiveRecord {

    public $bulan_pilih, $bulan_pilih_awal, $bulan_pilih_akhir; 
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaporanoppekeperawatanV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'laporanoppekeperawatan_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('oppekeperawatan_id, indikatoroppekeperawatan_id, unitkerja_id, ka_unitkerja_id, pegawai_id, perawat_unitkerja_id', 'numerical', 'integerOnly' => true),
            array('standar_nilai, capaian, skor', 'numerical'),
            array('kode_indikator', 'length', 'max' => 25),
            array('golongan_indikator', 'length', 'max' => 100),
            array('namaunitkerja', 'length', 'max' => 200),
            array('namakepalaunit', 'length', 'max' => 50),
            array('nama_perawat, nip_perawat', 'length', 'max' => 255),
            array('periodebulan, keterangan, rekomendasi', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('oppekeperawatan_id, indikatoroppekeperawatan_id, kode_indikator, golongan_indikator, periodebulan, unitkerja_id, namaunitkerja, ka_unitkerja_id, namakepalaunit, pegawai_id, nama_perawat, nip_perawat, perawat_unitkerja_id, standar_nilai, capaian, skor, keterangan, rekomendasi', 'safe', 'on' => 'search'),
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
            'oppekeperawatan_id' => 'Oppekeperawatan',
            'indikatoroppekeperawatan_id' => 'Indikatoroppekeperawatan',
            'kode_indikator' => 'Kode Indikator',
            'golongan_indikator' => 'Golongan Indikator',
            'periodebulan' => 'Periodebulan',
            'unitkerja_id' => 'Unitkerja',
            'namaunitkerja' => 'Namaunitkerja',
            'ka_unitkerja_id' => 'Ka Unitkerja',
            'namakepalaunit' => 'Namakepalaunit',
            'pegawai_id' => 'Pegawai',
            'nama_perawat' => 'Nama Perawat',
            'nip_perawat' => 'Nip Perawat',
            'perawat_unitkerja_id' => 'Perawat Unitkerja',
            'standar_nilai' => 'Standar Nilai',
            'capaian' => 'Capaian',
            'skor' => 'Skor',
            'keterangan' => 'Keterangan',
            'rekomendasi' => 'Rekomendasi',
        );
    }

    /**
     * Load data search 
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;
        
        $criteria->compare('oppekeperawatan_id', $this->oppekeperawatan_id);
        $criteria->compare('indikatoroppekeperawatan_id', $this->indikatoroppekeperawatan_id);
        $criteria->compare('kode_indikator', $this->kode_indikator, true);
        $criteria->compare('golongan_indikator', $this->golongan_indikator, true);
        $criteria->compare('unitkerja_id', $this->unitkerja_id);
        $criteria->compare('namaunitkerja', $this->namaunitkerja, true);
        $criteria->compare('ka_unitkerja_id', $this->ka_unitkerja_id);
        $criteria->compare('namakepalaunit', $this->namakepalaunit, true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('nama_perawat', $this->nama_perawat, true);
        $criteria->compare('nip_perawat', $this->nip_perawat, true);
        $criteria->compare('perawat_unitkerja_id', $this->perawat_unitkerja_id);
        $criteria->compare('standar_nilai', $this->standar_nilai);
        $criteria->compare('capaian', $this->capaian);
        $criteria->compare('skor', $this->skor);
        $criteria->compare('keterangan', $this->keterangan, true);
        $criteria->compare('rekomendasi', $this->rekomendasi, true);
        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = $this->criteriaSearch();
        $blnawal = date('Y-m-d', strtotime($this->bulan_pilih_awal . '-01'));
        $blnakhir = date("Y-m-t", strtotime($this->bulan_pilih_akhir . '-1'));
        if(!empty($blnawal) && !empty($blnakhir)){
            $criteria->addBetweenCondition('periodebulan', $blnawal, $blnakhir);
        }else{
            $criteria->compare('periodebulan', $this->periodebulan, true);
        }
        $criteria->addCondition('ka_unitkerja_id = '. Yii::app()->user->getState('pegawai_id'));
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

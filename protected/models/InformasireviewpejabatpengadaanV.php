<?php

/**
 * This is the model class for table "informasireviewpejabatpengadaan_v".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * 
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'informasireviewpejabatpengadaan_v':
 * @property integer $infoumumpengadaan_id
 * @property string $create_time
 * @property integer $persiapanpengadaan_id
 * @property string $persiapanpengadaan_nomor
 * @property integer $rencanaumumpengadaan_id
 * @property string $rencanaumumpengadaan_nomor
 * @property string $nama_pekerjaan
 * @property double $total_hps
 * @property string $rencanaumumpengadaan_tahun
 * @property string $metodepengadaan_nama
 * @property integer $pegpa_id
 * @property integer $pegkpa_id
 * @property integer $pegppk_id
 * @property integer $pegpengadaan_id
 * @property string $infoumumpengadaan_status
 */
class InformasireviewpejabatpengadaanV extends CActiveRecord {

    public $pegawaipengadaan_nama, $pegppk_nama, $create_loginpemakai_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InformasireviewpejabatpengadaanV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'informasireviewpejabatpengadaan_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('infoumumpengadaan_id, persiapanpengadaan_id, rencanaumumpengadaan_id, pegpa_id, pegkpa_id, pegppk_id, pegpengadaan_id', 'numerical', 'integerOnly' => true),
            array('total_hps', 'numerical'),
            array('persiapanpengadaan_nomor, rencanaumumpengadaan_nomor', 'length', 'max' => 20),
            array('nama_pekerjaan', 'length', 'max' => 300),
            array('rencanaumumpengadaan_tahun', 'length', 'max' => 4),
            array('metodepengadaan_nama, infoumumpengadaan_status', 'length', 'max' => 100),
            array('create_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('infoumumpengadaan_id, create_time, persiapanpengadaan_id, persiapanpengadaan_nomor, rencanaumumpengadaan_id, rencanaumumpengadaan_nomor, nama_pekerjaan, total_hps, rencanaumumpengadaan_tahun, metodepengadaan_nama, pegpa_id, pegkpa_id, pegppk_id, pegpengadaan_id, infoumumpengadaan_status', 'safe', 'on' => 'search'),
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
            'infoumumpengadaan_id' => 'Infoumumpengadaan',
            'create_time' => 'Create Time',
            'persiapanpengadaan_id' => 'Persiapanpengadaan',
            'persiapanpengadaan_nomor' => 'Persiapanpengadaan Nomor',
            'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
            'rencanaumumpengadaan_nomor' => 'Rencanaumumpengadaan Nomor',
            'nama_pekerjaan' => 'Nama Pekerjaan',
            'total_hps' => 'Total Hps',
            'rencanaumumpengadaan_tahun' => 'Rencanaumumpengadaan Tahun',
            'metodepengadaan_nama' => 'Metodepengadaan Nama',
            'pegpa_id' => 'Pegpa',
            'pegkpa_id' => 'Pegkpa',
            'pegppk_id' => 'Pegppk',
            'pegpengadaan_id' => 'Pegpengadaan',
            'infoumumpengadaan_status' => 'Infoumumpengadaan Status',
        );
    }

    /**
     * Load data pencarian 
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;
        $criteria->select = "*, pegppk.nama_pegawai as pegppk_nama, pegpengadaan.nama_pegawai as pegawaipengadaan_nama, info.create_loginpemakai_id, info.infoumumpengadaan_status";
        $criteria->join = "left join pegawai_m pegppk on t.pegppk_id = pegppk.pegawai_id "
                . "left join pegawai_m pegpengadaan on t.pegpengadaan_id = pegpengadaan.pegawai_id "
                . "left join infoumumpengadaan_t info on t.persiapanpengadaan_id = info.persiapanpengadaan_id ";
        $criteria->compare('infoumumpengadaan_id', $this->infoumumpengadaan_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('persiapanpengadaan_id', $this->persiapanpengadaan_id);
        $criteria->compare('lower(persiapanpengadaan_nomor)', strtolower($this->persiapanpengadaan_nomor), true);
        $criteria->compare('lower(pegppk.nama_pegawai)', strtolower($this->pegppk_nama), true);
        $criteria->compare('lower(pegpengadaan.nama_pegawai)', strtolower($this->pegawaipengadaan_nama), true);
        $criteria->compare('rencanaumumpengadaan_id', $this->rencanaumumpengadaan_id);
        $criteria->compare('lower(rencanaumumpengadaan_nomor)', strtolower($this->rencanaumumpengadaan_nomor), true);
        $criteria->compare('lower(nama_pekerjaan)', strtolower($this->nama_pekerjaan), true);
        $criteria->compare('lower(metodepengadaan_nama)', strtolower($this->metodepengadaan_nama), true);
        $criteria->compare('total_hps', $this->total_hps);
        $criteria->compare('rencanaumumpengadaan_tahun', $this->rencanaumumpengadaan_tahun, true);
        $criteria->compare('pegpa_id', $this->pegpa_id);
        $criteria->compare('pegkpa_id', $this->pegkpa_id);
        $criteria->compare('pegppk_id', $this->pegppk_id);
        $criteria->compare('pegpengadaan_id', $this->pegpengadaan_id);
        $criteria->compare('info.infoumumpengadaan_status', $this->infoumumpengadaan_status, true);

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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

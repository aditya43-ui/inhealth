<?php

/**
 * This is the model class for table "rl1_2_indikatorpelayananrumahsakit".
 *
 * The followings are the available columns in table 'rl1_2_indikatorpelayananrumahsakit':
 * @property integer $rl1_2_indikatorpelayananrumahsakit_id
 * @property string $tgl_laporan
 * @property string $propinsi
 * @property string $kabupaten
 * @property integer $profilrs_id
 * @property string $koders
 * @property string $namars
 * @property double $bor
 * @property double $los
 * @property double $bto
 * @property double $toi
 * @property double $ndr
 * @property double $gdr
 * @property integer $pendaftaran_id
 * @property integer $pasienpulang_id
 * @property integer $hariperawatan
 * @property integer $lamarawat
 * @property string $tgl_pendaftaran
 */
class SERl12Indikatorpelayananrumahsakit extends Rl12Indikatorpelayananrumahsakit {

    public $jns_periode;
    public $periode, $jumlah_hari, $jumlah_lama, $jumlah_ndr, $jumlah_gdr, $jumlah_bor, $jumlah_alos, $jumlah_bto, $jumlah_toi;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Rl12Indikatorpelayananrumahsakit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rl1_2_indikatorpelayananrumahsakit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tgl_laporan, propinsi, kabupaten, koders, namars', 'required'),
            array('profilrs_id, pendaftaran_id, pasienpulang_id, hariperawatan, lamarawat', 'numerical', 'integerOnly' => true),
            array('bor, los, bto, toi, ndr, gdr', 'numerical'),
            array('propinsi, kabupaten, koders, namars', 'length', 'max' => 50),
            array('tgl_pendaftaran', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('rl1_2_indikatorpelayananrumahsakit_id, tgl_laporan, propinsi, kabupaten, profilrs_id, koders, namars, bor, los, bto, toi, ndr, gdr, pendaftaran_id, pasienpulang_id, hariperawatan, lamarawat, tgl_pendaftaran', 'safe', 'on' => 'search'),
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
            'rl1_2_indikatorpelayananrumahsakit_id' => 'Rl1 2 Indikatorpelayananrumahsakit',
            'tgl_laporan' => 'Tgl Laporan',
            'propinsi' => 'Propinsi',
            'kabupaten' => 'Kabupaten',
            'profilrs_id' => 'Profilrs',
            'koders' => 'Koders',
            'namars' => 'Namars',
            'bor' => 'Bor',
            'los' => 'Los',
            'bto' => 'Bto',
            'toi' => 'Toi',
            'ndr' => 'Ndr',
            'gdr' => 'Gdr',
            'pendaftaran_id' => 'Pendaftaran',
            'pasienpulang_id' => 'Pasienpulang',
            'hariperawatan' => 'Hariperawatan',
            'lamarawat' => 'Lamarawat',
            'tgl_pendaftaran' => 'Tgl Pendaftaran',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->rl1_2_indikatorpelayananrumahsakit_id)) {
            $criteria->addCondition('rl1_2_indikatorpelayananrumahsakit_id = ' . $this->rl1_2_indikatorpelayananrumahsakit_id);
        }
        $criteria->compare('LOWER(tgl_laporan)', strtolower($this->tgl_laporan), true);
        $criteria->compare('LOWER(propinsi)', strtolower($this->propinsi), true);
        $criteria->compare('LOWER(kabupaten)', strtolower($this->kabupaten), true);
        if (!empty($this->profilrs_id)) {
            $criteria->addCondition('profilrs_id = ' . $this->profilrs_id);
        }
        $criteria->compare('LOWER(koders)', strtolower($this->koders), true);
        $criteria->compare('LOWER(namars)', strtolower($this->namars), true);
        $criteria->compare('bor', $this->bor);
        $criteria->compare('los', $this->los);
        $criteria->compare('bto', $this->bto);
        $criteria->compare('toi', $this->toi);
        $criteria->compare('ndr', $this->ndr);
        $criteria->compare('gdr', $this->gdr);
        if (!empty($this->pendaftaran_id)) {
            $criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
        }
        if (!empty($this->pasienpulang_id)) {
            $criteria->addCondition('pasienpulang_id = ' . $this->pasienpulang_id);
        }
        if (!empty($this->hariperawatan)) {
            $criteria->addCondition('hariperawatan = ' . $this->hariperawatan);
        }
        if (!empty($this->lamarawat)) {
            $criteria->addCondition('lamarawat = ' . $this->lamarawat);
        }
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);

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
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}

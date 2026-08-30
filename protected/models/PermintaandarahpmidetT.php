<?php

/**
 * This is the model class for table "permintaandarahpmidet_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * The followings are the available columns in table 'permintaandarahpmidet_t':
 * @property integer $permintaandarahpmidet_id
 * @property integer $jeniskomponendarah_id
 * @property integer $permintaandarahpmi_id
 * @property string $golongandarah
 * @property string $rhesus
 * @property integer $jumlah
 * @property string $tgl_perlu
 * @property string $no_ppup
 * @property string $keterangan_det
 *
 * The followings are the available model relations:
 * @property JeniskomponendarahM $jeniskomponendarah
 * @property PermintaandarahpmiT $permintaandarahpmi
 * 
 * @package application.models
 */
class PermintaandarahpmidetT extends CActiveRecord {
    
    public $penerimaandarahpmidet_id;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PermintaandarahpmidetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'permintaandarahpmidet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jeniskomponendarah_id, permintaandarahpmi_id, jumlah', 'numerical', 'integerOnly' => true),
            array('golongandarah, rhesus, no_ppup', 'length', 'max' => 100),
            array('tgl_perlu, keterangan_det', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('permintaandarahpmidet_t, jeniskomponendarah_id, permintaandarahpmi_id, golongandarah, rhesus, jumlah, tgl_perlu, no_ppup, keterangan_det', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'jeniskomponendarah' => array(self::BELONGS_TO, 'JeniskomponendarahM', 'jeniskomponendarah_id'),
            'permintaandarahpmi' => array(self::BELONGS_TO, 'PermintaandarahpmiT', 'permintaandarahpmi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'permintaandarahpmidet_id' => 'Permintaandarahpmidet T',
            'jeniskomponendarah_id' => 'Jeniskomponendarah',
            'permintaandarahpmi_id' => 'Permintaandarahpmi',
            'golongandarah' => 'Golongandarah',
            'rhesus' => 'Rhesus',
            'jumlah' => 'Jumlah',
            'tgl_perlu' => 'Tgl. Perlu',
            'no_ppup' => 'No Ppup',
            'keterangan_det' => 'Keterangan Det',
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

        if (!empty($this->permintaandarahpmidet_t)) {
            $criteria->addCondition('permintaandarahpmidet_id = ' . $this->permintaandarahpmidet_id);
        }
        if (!empty($this->jeniskomponendarah_id)) {
            $criteria->addCondition('jeniskomponendarah_id = ' . $this->jeniskomponendarah_id);
        }
        if (!empty($this->permintaandarahpmi_id)) {
            $criteria->addCondition('permintaandarahpmi_id = ' . $this->permintaandarahpmi_id);
        }
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        if (!empty($this->jumlah)) {
            $criteria->addCondition('jumlah = ' . $this->jumlah);
        }
        $criteria->compare('LOWER(tgl_perlu)', strtolower($this->tgl_perlu), true);
        $criteria->compare('LOWER(no_ppup)', strtolower($this->no_ppup), true);
        $criteria->compare('LOWER(keterangan_det)', strtolower($this->keterangan_det), true);

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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
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

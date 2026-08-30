<?php

/**
 * This is the model class for table "pengadaansumberdana_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'pengadaansumberdana_t':
 * @property integer $pengadaansumberdana_id
 * @property integer $rencanaumumpengadaan_id
 * @property integer $sumberanggaran_id
 * @property integer $rekening5_id
 * @property string $asal_dana
 * @property string $komponen_kegiatan
 * @property double $pagu
 *
 * The followings are the available model relations:
 * @property RencanaumumpengadaanT $rencanaumumpengadaan
 * @property SumberanggaranM $sumberanggaran
 * @property Rekening5M $rekening5
 */
class PengadaansumberdanaT extends CActiveRecord {

    public $pagus,$nmrekening5;
    public $kegiatanprogram_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PengadaansumberdanaT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pengadaansumberdana_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rencanaumumpengadaan_id, sumberanggaran_id, rekening5_id', 'numerical', 'integerOnly' => true),
            array('pagu', 'numerical'),
            array('asal_dana, komponen_kegiatan', 'length', 'max' => 250),
            array('rekeninganggaran5_id, mappingrekeninganggaran_id, kode_rekening, kegiatanprogram_id','safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pengadaansumberdana_id, rencanaumumpengadaan_id, sumberanggaran_id, rekening5_id, asal_dana, komponen_kegiatan, pagu', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rencanaumumpengadaan' => array(self::BELONGS_TO, 'RencanaumumpengadaanT', 'rencanaumumpengadaan_id'),
            'sumberanggaran' => array(self::BELONGS_TO, 'SumberanggaranM', 'sumberanggaran_id'),
            'kegiatanprogram' => array(self::BELONGS_TO, 'KegiatanprogramM', 'kegiatanprogram_id'),
            'rekening5' => array(self::BELONGS_TO, 'Rekening5M', 'rekening5_id'),
            'kegiatanprogram' => array(self::BELONGS_TO, 'KegiatanprogramM', 'kegiatanprogram_id'),
            'mappingrekeninganggaran' => array(self::BELONGS_TO, 'MappingrekeninganggaranM', 'mappingrekeninganggaran_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pengadaansumberdana_id' => 'Pengadaansumberdana',
            'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
            'sumberanggaran_id' => 'Sumberanggaran',
            'rekening5_id' => 'Rekening5',
            'asal_dana' => 'Asal Dana',
            'komponen_kegiatan' => 'Komponen Kegiatan',
            'pagu' => 'Pagu',
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

        if (!empty($this->pengadaansumberdana_id)) {
            $criteria->addCondition('pengadaansumberdana_id = ' . $this->pengadaansumberdana_id);
        }
        if (!empty($this->rencanaumumpengadaan_id)) {
            $criteria->addCondition('rencanaumumpengadaan_id = ' . $this->rencanaumumpengadaan_id);
        }
        if (!empty($this->sumberanggaran_id)) {
            $criteria->addCondition('sumberanggaran_id = ' . $this->sumberanggaran_id);
        }
        if (!empty($this->rekening5_id)) {
            $criteria->addCondition('rekening5_id = ' . $this->rekening5_id);
        }
        $criteria->compare('LOWER(asal_dana)', strtolower($this->asal_dana), true);
        $criteria->compare('LOWER(komponen_kegiatan)', strtolower($this->komponen_kegiatan), true);
        $criteria->compare('pagu', $this->pagu);

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

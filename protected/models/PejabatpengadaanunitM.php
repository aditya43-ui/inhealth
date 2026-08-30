<?php

/**
 * This is the model class for table "pejabatpengadaanunit_m".
 *
 * The followings are the available columns in table 'pejabatpengadaanunit_m':
 * @property integer $pejabatpengadaanunit_id
 * @property integer $pejabatpengadaan_id
 * @property integer $unitkerja_id
 *
 * The followings are the available model relations:
 * @property PejabatpengadaanM $pejabatpengadaan
 * @property UnitkerjaM $unitkerja
 */
class PejabatpengadaanunitM extends CActiveRecord {

    public $namaunitkerja, $kepalaunitpeg_nama, $periodeanggaran_id, $kepalaunitpeg_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PejabatpengadaanunitM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pejabatpengadaanunit_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pejabatpengadaan_id, unitkerja_id', 'required'),
            array('pejabatpengadaan_id, unitkerja_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pejabatpengadaanunit_id, pejabatpengadaan_id, unitkerja_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pejabatpengadaan' => array(self::BELONGS_TO, 'PejabatpengadaanM', 'pejabatpengadaan_id'),
            'unitkerja' => array(self::BELONGS_TO, 'UnitkerjaM', 'unitkerja_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pejabatpengadaanunit_id' => 'Pejabatpengadaanunit',
            'pejabatpengadaan_id' => 'Pejabatpengadaan',
            'unitkerja_id' => 'Unitkerja',
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

        $criteria->compare('pejabatpengadaanunit_id', $this->pejabatpengadaanunit_id);
        $criteria->compare('pejabatpengadaan_id', $this->pejabatpengadaan_id);
        $criteria->compare('unitkerja_id', $this->unitkerja_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data Pegawai Drafter 
     */
    public function searchDialogPergeseran() {
        $criteria = new CDbCriteria;

        $criteria->select = "unit.namaunitkerja, t.unitkerja_id, peg.pegawai_id, unit.kepalaunitpeg_id, kepala.nama_pegawai as kepalaunitpeg_nama ";
        $criteria->join = "join pejabatpengadaan_m pejabat on t.pejabatpengadaan_id = pejabat.pejabatpengadaan_id
                            join pegawai_m peg on pejabat.pegawai_id = peg.pegawai_id
                            join unitkerja_m unit on t.unitkerja_id = unit.unitkerja_id 
                            join pegawai_m kepala on kepala.pegawai_id = unit.kepalaunitpeg_id ";
        $criteria->addCondition("jabatan_pengadaan = '" . Params::JABATAN_PENGADAAN_DRAFTER . "'");
        $criteria->addCondition("peg.pegawai_id = " . Yii::app()->user->getState('pegawai_id'));
        if (!empty($this->periodeanggaran_id)) {
            $criteria->addCondition('pejabat.periodeanggaran_id = ' . $this->periodeanggaran_id);
        } else {
            $criteria->addCondition('t.unitkerja_id is null');
        }

        $criteria->compare('LOWER(namaunitkerja)', strtolower($this->namaunitkerja), true);
        $criteria->compare('LOWER(kepala.nama_pegawai)', strtolower($this->kepalaunitpeg_nama), true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

<?php

/**
 * This is the model class for table "mortalitas_r".
 *
 * The followings are the available columns in table 'mortalitas_r':
 * @property integer $mortalitas_id
 * @property string $tanggal
 * @property integer $diagnosa_id
 * @property string $diagnosa_nama
 * @property integer $jumlah
 */
class SEMortalitasR extends MortalitasR {

    public $jns_periode;
    public $periode, $jumlah, $jenis;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MortalitasR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'mortalitas_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('diagnosa_id, jumlah', 'numerical', 'integerOnly' => true),
            array('diagnosa_nama', 'length', 'max' => 100),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('mortalitas_id, tanggal, diagnosa_id, diagnosa_nama, jumlah', 'safe', 'on' => 'search'),
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
            'mortalitas_id' => 'Mortalitas',
            'tanggal' => 'Tanggal',
            'diagnosa_id' => 'Diagnosa',
            'diagnosa_nama' => 'Diagnosa Nama',
            'jumlah' => 'Jumlah',
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

        if (!empty($this->mortalitas_id)) {
            $criteria->addCondition('mortalitas_id = ' . $this->mortalitas_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        if (!empty($this->diagnosa_id)) {
            $criteria->addCondition('diagnosa_id = ' . $this->diagnosa_id);
        }
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($this->diagnosa_nama), true);
        if (!empty($this->jumlah)) {
            $criteria->addCondition('jumlah = ' . $this->jumlah);
        }

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

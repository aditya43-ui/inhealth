<?php

/**
 * This is the model class for table "riberdasarkankelas_r".
 *
 * The followings are the available columns in table 'riberdasarkankelas_r':
 * @property integer $riberdasarkankelas_id
 * @property string $tanggal
 * @property integer $kelaspelayanan_id
 * @property string $kelaspelayanan_nama
 * @property integer $jumlah
 */
class SERiberdasarkankelasR extends RiberdasarkankelasR {

    public $jns_periode;
    public $periode, $jumlah, $jenis;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RiberdasarkankelasR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'riberdasarkankelas_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kelaspelayanan_id, jumlah', 'numerical', 'integerOnly' => true),
            array('kelaspelayanan_nama', 'length', 'max' => 50),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('riberdasarkankelas_id, tanggal, kelaspelayanan_id, kelaspelayanan_nama, jumlah', 'safe', 'on' => 'search'),
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
            'riberdasarkankelas_id' => 'Riberdasarkankelas',
            'tanggal' => 'Tanggal',
            'kelaspelayanan_id' => 'Kelaspelayanan',
            'kelaspelayanan_nama' => 'Kelaspelayanan Nama',
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

        if (!empty($this->riberdasarkankelas_id)) {
            $criteria->addCondition('riberdasarkankelas_id = ' . $this->riberdasarkankelas_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        if (!empty($this->kelaspelayanan_id)) {
            $criteria->addCondition('kelaspelayanan_id = ' . $this->kelaspelayanan_id);
        }
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
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

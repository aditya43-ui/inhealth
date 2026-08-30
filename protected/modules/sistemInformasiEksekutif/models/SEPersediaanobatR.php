<?php

/**
 * This is the model class for table "persediaanobat_r".
 *
 * The followings are the available columns in table 'persediaanobat_r':
 * @property integer $persediaanobat_id
 * @property string $tanggal
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $obat
 * @property integer $alkes
 */
class SEPersediaanobatR extends PersediaanobatR {

    public $jns_periode;
    public $periode, $instalasi_id, $ruangan_id, $jumlah_obat, $jumlah_alkes;
    public $tgl_awal, $tgl_akhir, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $data, $data_2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PersediaanobatR the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'persediaanobat_r';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ruangan_id, instalasi_id, obat, alkes', 'numerical', 'integerOnly' => true),
            array('ruangan_nama, instalasi_nama', 'length', 'max' => 50),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('persediaanobat_id, tanggal, ruangan_id, ruangan_nama, instalasi_id, instalasi_nama, obat, alkes', 'safe', 'on' => 'search'),
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
            'persediaanobat_id' => 'Persediaanobat',
            'tanggal' => 'Tanggal',
            'ruangan_id' => 'Ruangan',
            'ruangan_nama' => 'Ruangan Nama',
            'instalasi_id' => 'Instalasi',
            'instalasi_nama' => 'Instalasi Nama',
            'obat' => 'Obat',
            'alkes' => 'Alkes',
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

        if (!empty($this->persediaanobat_id)) {
            $criteria->addCondition('persediaanobat_id = ' . $this->persediaanobat_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        if (!empty($this->ruangan_id)) {
            $criteria->addCondition('ruangan_id = ' . $this->ruangan_id);
        }
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        if (!empty($this->instalasi_id)) {
            $criteria->addCondition('instalasi_id = ' . $this->instalasi_id);
        }
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        if (!empty($this->obat)) {
            $criteria->addCondition('obat = ' . $this->obat);
        }
        if (!empty($this->alkes)) {
            $criteria->addCondition('alkes = ' . $this->alkes);
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

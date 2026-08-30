<?php

/**
 * This is the model class for table "storeeddetail_t".
 *
 * The followings are the available columns in table 'storeeddetail_t':
 * @property integer $storeeddetail_id
 * @property integer $satuankecil_id
 * @property integer $obatalkes_id
 * @property integer $storeed_id
 * @property string $tglkadaluarsa
 * @property integer $qtystoked
 * @property string $keterangan_obated
 * @property boolean $isdikembalikan
 */
class StoreeddetailT extends CActiveRecord {

    public $obatalkes_nama, $supplier_nama, $satuankecil_nama, $supplier_id;
    public $stokobatalkes_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return StoreeddetailT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'storeeddetail_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('satuankecil_id, obatalkes_id, storeed_id, tglkadaluarsa, qtystoked', 'required'),
            array('satuankecil_id, obatalkes_id, storeed_id, qtystoked', 'numerical', 'integerOnly' => true),
            array('keterangan_obated', 'length', 'max' => 200),
            array('sumberdana_id, isdikembalikan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('storeeddetail_id, satuankecil_id, obatalkes_id, storeed_id, tglkadaluarsa, qtystoked, keterangan_obated, isdikembalikan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'obatalkes' => array(self::BELONGS_TO, 'ObatalkesM', 'obatalkes_id'),
            'storeed' => array(self::BELONGS_TO, 'StoreedT', 'storeed_id'),
            'satuankecil' => array(self::BELONGS_TO, 'SatuankecilM', 'satuankecil_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'storeeddetail_id' => 'Storeeddetail',
            'satuankecil_id' => 'Satuan Kecil',
            'obatalkes_id' => 'Nama Obat',
            'storeed_id' => 'Storeed',
            'tglkadaluarsa' => 'Tanggal Kadaluarsa',
            'qtystoked' => 'Jumlah',
            'keterangan_obated' => 'Keterangan Obat',
            'isdikembalikan' => 'Isdikembalikan',
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

        if (!empty($this->storeeddetail_id)) {
            $criteria->addCondition('storeeddetail_id = ' . $this->storeeddetail_id);
        }
        if (!empty($this->satuankecil_id)) {
            $criteria->addCondition('satuankecil_id = ' . $this->satuankecil_id);
        }
        if (!empty($this->obatalkes_id)) {
            $criteria->addCondition('obatalkes_id = ' . $this->obatalkes_id);
        }
        if (!empty($this->storeed_id)) {
            $criteria->addCondition('storeed_id = ' . $this->storeed_id);
        }
        $criteria->compare('LOWER(tglkadaluarsa)', strtolower($this->tglkadaluarsa), true);
        if (!empty($this->qtystoked)) {
            $criteria->addCondition('qtystoked = ' . $this->qtystoked);
        }
        $criteria->compare('LOWER(keterangan_obated)', strtolower($this->keterangan_obated), true);
        $criteria->compare('isdikembalikan', $this->isdikembalikan);

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

    public function getHargaSatuan() {
        $modStok = StokobatalkesT::model()->findByAttributes(array('storeeddetail_id' => $this->storeeddetail_id));
        if ($modStok->harganetto % 2 == 0) {
            return MyFormatter::formatNumberForUser($modStok->harganetto);
        } else {
            return MyFormatter::formatNumberForUser($modStok->harganetto, 2);
        }
    }

    public function getTotalHarga() {
        $modStok = StokobatalkesT::model()->findByAttributes(array('storeeddetail_id' => $this->storeeddetail_id));

        if ($modStok->harganetto % 2 == 0) {
            $total = ($modStok->harganetto * $this->qtystoked);
            return MyFormatter::formatNumberForUser($total);
        } else {
            $total = (number_format($modStok->harganetto, 2, '.', '') * $this->qtystoked);
            return MyFormatter::formatNumberForUser($total, 2);
        }
    }

}

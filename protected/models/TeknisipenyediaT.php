<?php

/**
 * This is the model class for table "teknisipenyedia_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'teknisipenyedia_t':
 * @property integer $teknisipenyedia_id
 * @property integer $baujifungsi_id
 * @property string $teknisipenyedia_nama
 * @property integer $supplier_id
 *
 * The followings are the available model relations:
 * @property BaujifungsiT $baujifungsi
 * @property SupplierM $supplier
 */
class TeknisipenyediaT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TeknisipenyediaT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'teknisipenyedia_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('baujifungsi_id, teknisipenyedia_nama', 'required'),
            array('baujifungsi_id, supplier_id', 'numerical', 'integerOnly' => true),
            array('teknisipenyedia_nama', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('teknisipenyedia_id, baujifungsi_id, teknisipenyedia_nama, supplier_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'baujifungsi' => array(self::BELONGS_TO, 'BaujifungsiT', 'baujifungsi_id'),
            'supplier' => array(self::BELONGS_TO, 'SupplierM', 'supplier_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'teknisipenyedia_id' => 'Teknisipenyedia',
            'baujifungsi_id' => 'Baujifungsi',
            'teknisipenyedia_nama' => 'Teknisipenyedia Nama',
            'supplier_id' => 'Supplier',
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

        if (!empty($this->teknisipenyedia_id)) {
            $criteria->addCondition('teknisipenyedia_id = ' . $this->teknisipenyedia_id);
        }
        if (!empty($this->baujifungsi_id)) {
            $criteria->addCondition('baujifungsi_id = ' . $this->baujifungsi_id);
        }
        $criteria->compare('LOWER(teknisipenyedia_nama)', strtolower($this->teknisipenyedia_nama), true);
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('supplier_id = ' . $this->supplier_id);
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

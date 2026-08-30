<?php

/**
 * This is the model class for table "tautansdki_slki_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'tautansdki_slki_m':
 * @property integer $tautansdki_slki_id
 * @property string $tingkatluarankeperawatan
 * @property integer $diagnosakep_id
 *
 * The followings are the available model relations:
 * @property DiagnosakepM $diagnosakep
 * @property TautansdkiSlkiDetM[] $tautansdkiSlkiDetMs
 */
class TautansdkiSlkiM extends CActiveRecord {

    public $diagnosakep_nama, $tautansdki_slki_aktif, $luarankeperawatan_nama, $tautansdki_slki_det_id, $luarankeperawatan_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TautansdkiSlkiM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tautansdki_slki_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('diagnosakep_id', 'required'),
            array('diagnosakep_id', 'numerical', 'integerOnly' => true),
            array('tingkatluarankeperawatan', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('tautansdki_slki_id, tingkatluarankeperawatan, diagnosakep_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'diagnosakep' => array(self::BELONGS_TO, 'DiagnosakepM', 'diagnosakep_id'),
            'tautansdkiSlkiDetMs' => array(self::HAS_MANY, 'TautansdkiSlkiDetM', 'tautansdki_slki_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'tautansdki_slki_id' => 'Tautansdki Slki',
            'tingkatluarankeperawatan' => 'Tingkatluarankeperawatan',
            'diagnosakep_id' => 'Diagnosakep',
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

        $criteria->compare('tautansdki_slki_id', $this->tautansdki_slki_id);
        $criteria->compare('tingkatluarankeperawatan', $this->tingkatluarankeperawatan, true);
        $criteria->compare('diagnosakep_id', $this->diagnosakep_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchMaster() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 't.*, diagnosakep_m.diagnosakep_nama, tautansdki_slki_det_m.luarankeperawatan_nama, tautansdki_slki_det_m.tautansdki_slki_aktif, tautansdki_slki_det_m.tautansdki_slki_det_id';
        $criteria->join = ' JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = t.diagnosakep_id'
                        . ' JOIN tautansdki_slki_det_m ON tautansdki_slki_det_m.tautansdki_slki_id = t.tautansdki_slki_id ';
        $criteria->compare('tautansdki_slki_id', $this->tautansdki_slki_id);
        $criteria->compare('LOWER(diagnosakep_m.diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
        $criteria->compare('LOWER(tingkatluarankeperawatan)', strtolower($this->tingkatluarankeperawatan), true);
        $criteria->compare('LOWER(tautansdki_slki_det_m.luarankeperawatan_nama)', strtolower($this->luarankeperawatan_nama), true);
        $criteria->compare('tautansdki_slki_det_m.tautansdki_slki_aktif',isset($this->tautansdki_slki_aktif)?$this->tautansdki_slki_aktif:true);
        if(!empty($this->diagnosakep_id)){
            $criteria->compare('t.diagnosakep_id', $this->diagnosakep_id);
        }
        
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

        $criteria = new CDbCriteria;
        $criteria->select = 't.*, diagnosakep_m.diagnosakep_nama, tautansdki_slki_det_m.luarankeperawatan_nama, tautansdki_slki_det_m.tautansdki_slki_aktif, tautansdki_slki_det_m.tautansdki_slki_det_id';
        $criteria->join = ' JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = t.diagnosakep_id'
                        . ' JOIN tautansdki_slki_det_m ON tautansdki_slki_det_m.tautansdki_slki_id = t.tautansdki_slki_id ';
        $criteria->compare('tautansdki_slki_id', $this->tautansdki_slki_id);
        $criteria->compare('LOWER(diagnosakep_m.diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
        $criteria->compare('LOWER(tingkatluarankeperawatan)', strtolower($this->tingkatluarankeperawatan), true);
        $criteria->compare('LOWER(tautansdki_slki_det_m.luarankeperawatan_nama)', strtolower($this->luarankeperawatan_nama), true);
        $criteria->compare('tautansdki_slki_det_m.tautansdki_slki_aktif',isset($this->tautansdki_slki_aktif)?$this->tautansdki_slki_aktif:true);
        if(!empty($this->diagnosakep_id)){
            $criteria->compare('t.diagnosakep_id', $this->diagnosakep_id);
        }
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}

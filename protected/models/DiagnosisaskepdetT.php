<?php

/**
 * This is the model class for table "diagnosisaskepdet_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'diagnosisaskepdet_t':
 * @property integer $diagnosisaskepdet_id
 * @property integer $diagnosisaskep_id
 * @property integer $hasildiagnosa_id
 * @property boolean $iskolaborasi
 *
 * The followings are the available model relations:
 * @property RencanaaskepdetT[] $rencanaaskepdetTs
 * @property DiagnosisaskepT $diagnosisaskep
 * @property DiagnosakepM $hasildiagnosa
 */
class DiagnosisaskepdetT extends CActiveRecord {

    public $tandagejala_indikator, $faktorrisikodet_indikator, $diagnosakep_nama, $diagnosakep_id, $rencanaaskepdet_ketkolaborasi;
    public $rencanaaskepdet_hari, $rencanaaskepdet_estimasiwaktu, $tujuan_nama, $tujuan_id, $kriteriahasil_id, $kriteriahasil_nama;
    public $intervensi_id, $intervensi_nama, $intervensidet_id, $kriteriahasildet_id, $rencanaaskep_ir, $detail;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DiagnosisaskepdetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'diagnosisaskepdet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('diagnosisaskepdet_id, diagnosisaskep_id, hasildiagnosa_id', 'numerical', 'integerOnly' => true),
            array('iskolaborasi', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('diagnosisaskepdet_id, diagnosisaskep_id, hasildiagnosa_id, iskolaborasi', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rencanaaskepdetTs' => array(self::HAS_MANY, 'RencanaaskepdetT', 'diagnosisaskepdet_id'),
            'diagnosisaskep' => array(self::BELONGS_TO, 'DiagnosisaskepT', 'diagnosisaskep_id'),
            'hasildiagnosa' => array(self::BELONGS_TO, 'DiagnosakepM', 'hasildiagnosa_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'diagnosisaskepdet_id' => 'Diagnosisaskepdet',
            'diagnosisaskep_id' => 'Diagnosisaskep',
            'hasildiagnosa_id' => 'Hasildiagnosa',
            'iskolaborasi' => 'Iskolaborasi',
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

        $criteria->compare('diagnosisaskepdet_id', $this->diagnosisaskepdet_id);
        $criteria->compare('diagnosisaskep_id', $this->diagnosisaskep_id);
        $criteria->compare('hasildiagnosa_id', $this->hasildiagnosa_id);
        $criteria->compare('iskolaborasi', $this->iskolaborasi);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

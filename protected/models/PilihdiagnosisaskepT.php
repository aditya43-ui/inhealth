<?php

/**
 * This is the model class for table "pilihdiagnosisaskep_t".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'pilihdiagnosisaskep_t':
 * @property integer $pilihdiagnosisaskep_id
 * @property integer $diagnosisaskepdet_id
 * @property integer $tandagejaladet_id
 * @property integer $faktorrisikodet_id
 *
 * The followings are the available model relations:
 * @property FaktorrisikoM $faktorrisiko
 * @property TandagejalaM $tandagejala
 */
class PilihdiagnosisaskepT extends CActiveRecord {

    public $jenisfaktorrisiko_id;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PilihdiagnosisaskepT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pilihdiagnosisaskep_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('diagnosisaskepdet_id, tandagejaladet_id, faktorrisikodet_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pilihdiagnosisaskep_id, diagnosisaskepdet_id, tandagejaladet_id, faktorrisikodet_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'faktorrisiko' => array(self::BELONGS_TO, 'FaktorrisikoM', 'faktorrisikodet_id'),
            'tandagejala' => array(self::BELONGS_TO, 'TandagejalaM', 'tandagejaladet_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pilihdiagnosisaskep_id' => 'Pilihdiagnosisaskep',
            'diagnosisaskepdet_id' => 'Diagnosisaskepdet',
            'tandagejaladet_id' => 'Tandagejala',
            'faktorrisikodet_id' => 'Faktorrisiko',
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

        $criteria->compare('pilihdiagnosisaskep_id', $this->pilihdiagnosisaskep_id);
        $criteria->compare('diagnosisaskepdet_id', $this->diagnosisaskepdet_id);
        $criteria->compare('tandagejaladet_id', $this->tandagejaladet_id);
        $criteria->compare('faktorrisikodet_id', $this->faktorrisikodet_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

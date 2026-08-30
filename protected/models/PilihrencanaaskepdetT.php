<?php

/**
 * This is the model class for table "pilihrencanaaskepdet_t".
 *
 * The followings are the available columns in table 'pilihrencanaaskepdet_t':
 * @property integer $pilihrencanaaskepdet_t
 * @property integer $pilihrencanaaskep_id
 * @property integer $intervensidet_id
 * @property string $kelompoktindakan
 * @property integer $indikatorimplkepdet_id
 *
 * The followings are the available model relations:
 * @property IndikatorimplkepdetM $indikatorimplkepdet
 * @property PilihrencanaaskepT $pilihrencanaaskep
 */
class PilihrencanaaskepdetT extends CActiveRecord {

    public $detail, $diagnosa;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PilihrencanaaskepdetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pilihrencanaaskepdet_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pilihrencanaaskep_id, intervensidet_id, indikatorimplkepdet_id', 'required'),
            array('pilihrencanaaskep_id, intervensidet_id, indikatorimplkepdet_id', 'numerical', 'integerOnly' => true),
            array('kelompoktindakan', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pilihrencanaaskepdet_t, pilihrencanaaskep_id, intervensidet_id, kelompoktindakan, indikatorimplkepdet_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'indikatorimplkepdet' => array(self::BELONGS_TO, 'IndikatorimplkepdetM', 'indikatorimplkepdet_id'),
            'pilihrencanaaskep' => array(self::BELONGS_TO, 'PilihrencanaaskepT', 'pilihrencanaaskep_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pilihrencanaaskepdet_t' => 'Pilihrencanaaskepdet T',
            'pilihrencanaaskep_id' => 'Pilihrencanaaskep',
            'intervensidet_id' => 'Intervensidet',
            'kelompoktindakan' => 'Kelompoktindakan',
            'indikatorimplkepdet_id' => 'Indikatorimplkepdet',
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

        $criteria->compare('pilihrencanaaskepdet_t', $this->pilihrencanaaskepdet_t);
        $criteria->compare('pilihrencanaaskep_id', $this->pilihrencanaaskep_id);
        $criteria->compare('intervensidet_id', $this->intervensidet_id);
        $criteria->compare('kelompoktindakan', $this->kelompoktindakan, true);
        $criteria->compare('indikatorimplkepdet_id', $this->indikatorimplkepdet_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

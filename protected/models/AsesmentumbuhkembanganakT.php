<?php

/**
 * This is the model class for table "asesmentumbuhkembanganak_t".
 *
 * The followings are the available columns in table 'asesmentumbuhkembanganak_t':
 * @property integer $asesmentumbuhkembanganak_id
 * @property integer $asesmenawalkeperawatan_id
 * @property string $tumbuhkembanganak_jenis
 * @property integer $tumbuhkembanganak_usia
 *
 * The followings are the available model relations:
 * @property AsesmenawalkeperawatanT $asesmenawalkeperawatan
 */
class AsesmentumbuhkembanganakT extends CActiveRecord {

    public $ischeckbox;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsesmentumbuhkembanganakT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asesmentumbuhkembanganak_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('asesmenawalkeperawatan_id', 'required'),
            array('asesmenawalkeperawatan_id, tumbuhkembanganak_usia', 'numerical', 'integerOnly' => true),
            array('tumbuhkembanganak_jenis', 'length', 'max' => 50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('asesmentumbuhkembanganak_id, asesmenawalkeperawatan_id, tumbuhkembanganak_jenis, tumbuhkembanganak_usia', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'asesmenawalkeperawatan' => array(self::BELONGS_TO, 'AsesmenawalkeperawatanT', 'asesmenawalkeperawatan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'asesmentumbuhkembanganak_id' => 'Asesmentumbuhkembanganak',
            'asesmenawalkeperawatan_id' => 'Asesmenawalkeperawatan',
            'tumbuhkembanganak_jenis' => 'Tumbuhkembanganak Jenis',
            'tumbuhkembanganak_usia' => 'Tumbuhkembanganak Usia',
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

        $criteria->compare('asesmentumbuhkembanganak_id', $this->asesmentumbuhkembanganak_id);
        $criteria->compare('asesmenawalkeperawatan_id', $this->asesmenawalkeperawatan_id);
        $criteria->compare('tumbuhkembanganak_jenis', $this->tumbuhkembanganak_jenis, true);
        $criteria->compare('tumbuhkembanganak_usia', $this->tumbuhkembanganak_usia);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

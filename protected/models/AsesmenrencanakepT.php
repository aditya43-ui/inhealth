<?php

/**
 * This is the model class for table "asesmenrencanakep_t".
 *
 * The followings are the available columns in table 'asesmenrencanakep_t':
 * @property integer $asesmenrencanakep_id
 * @property integer $asesmenpasienigd_id
 * @property integer $rencanakeperawatanigd_id
 * @property string $rencanakeperawatan_ket
 *
 * The followings are the available model relations:
 * @property AsesmenpasienigdT $asesmenpasienigd
 */
class AsesmenrencanakepT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsesmenrencanakepT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'asesmenrencanakep_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('asesmenpasienigd_id', 'required'),
            array('asesmenpasienigd_id, rencanakeperawatanigd_id', 'numerical', 'integerOnly' => true),
            array('rencanakeperawatan_ket', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('asesmenrencanakep_id, asesmenpasienigd_id, rencanakeperawatanigd_id, rencanakeperawatan_ket', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'asesmenpasienigd' => array(self::BELONGS_TO, 'AsesmenpasienigdT', 'asesmenpasienigd_id'),
            'rencanakeperawatanigd' => array(self::BELONGS_TO, 'RencanakeperawatanigdM', 'rencanakeperawatanigd_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'asesmenrencanakep_id' => 'Asesmenrencanakep',
            'asesmenpasienigd_id' => 'Asesmenpasienigd',
            'rencanakeperawatanigd_id' => 'Rencanakeperawatanigd',
            'rencanakeperawatan_ket' => 'Rencanakeperawatan Ket',
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

        $criteria->compare('asesmenrencanakep_id', $this->asesmenrencanakep_id);
        $criteria->compare('asesmenpasienigd_id', $this->asesmenpasienigd_id);
        $criteria->compare('rencanakeperawatanigd_id', $this->rencanakeperawatanigd_id);
        $criteria->compare('rencanakeperawatan_ket', $this->rencanakeperawatan_ket, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

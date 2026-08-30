<?php

/**
 * This is the model class for table "skorbromage_t".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'skorbromage_t':
 * @property integer $skorbromage_id
 * @property integer $skorpascaanastesi_id
 * @property string $jam
 * @property integer $bromage_0
 * @property integer $bromage_5
 * @property integer $bromage_15
 * @property integer $bromage_30
 * @property integer $bromage_45
 * @property integer $bromage_1
 * @property integer $bromage_2
 * @property integer $bromage_3
 * @property integer $bromage_4
 * @property integer $bromage_keluar
 */
class SkorbromageT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SkorbromageT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'skorbromage_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('skorpascaanastesi_id, bromage_0, bromage_5, bromage_15, bromage_30, bromage_45, bromage_1, bromage_2, bromage_3, bromage_4, bromage_keluar', 'numerical', 'integerOnly' => true),
            array('jam', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('skorbromage_id, skorpascaanastesi_id, jam, bromage_0, bromage_5, bromage_15, bromage_30, bromage_45, bromage_1, bromage_2, bromage_3, bromage_4, bromage_keluar', 'safe', 'on' => 'search'),
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
            'skorbromage_id' => 'Skorbromage',
            'skorpascaanastesi_id' => 'Skorpascaanastesi',
            'jam' => 'Jam',
            'bromage_0' => 'Bromage 0',
            'bromage_5' => 'Bromage 5',
            'bromage_15' => 'Bromage 15',
            'bromage_30' => 'Bromage 30',
            'bromage_45' => 'Bromage 45',
            'bromage_1' => 'Bromage 1',
            'bromage_2' => 'Bromage 2',
            'bromage_3' => 'Bromage 3',
            'bromage_4' => 'Bromage 4',
            'bromage_keluar' => 'Bromage Keluar',
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

        $criteria->compare('skorbromage_id', $this->skorbromage_id);
        $criteria->compare('skorpascaanastesi_id', $this->skorpascaanastesi_id);
        $criteria->compare('jam', $this->jam, true);
        $criteria->compare('bromage_0', $this->bromage_0);
        $criteria->compare('bromage_5', $this->bromage_5);
        $criteria->compare('bromage_15', $this->bromage_15);
        $criteria->compare('bromage_30', $this->bromage_30);
        $criteria->compare('bromage_45', $this->bromage_45);
        $criteria->compare('bromage_1', $this->bromage_1);
        $criteria->compare('bromage_2', $this->bromage_2);
        $criteria->compare('bromage_3', $this->bromage_3);
        $criteria->compare('bromage_4', $this->bromage_4);
        $criteria->compare('bromage_keluar', $this->bromage_keluar);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

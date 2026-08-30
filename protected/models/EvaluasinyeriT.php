<?php

/**
 * This is the model class for table "evaluasinyeri_t".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'evaluasinyeri_t':
 * @property integer $evaluasinyeri_id
 * @property integer $skorpascaanastesi_id
 * @property integer $skornyeri_praanestesi
 * @property boolean $keluhan_nyeri_ada
 * @property boolean $keluhan_nyeri_tidak_ada
 * @property boolean $metode_vas
 * @property boolean $metode_comfortscales
 * @property integer $nyeri_0
 * @property integer $nyeri_5
 * @property integer $nyeri_15
 * @property integer $nyeri_30
 * @property integer $nyeri_45
 * @property integer $nyeri_1
 * @property integer $nyeri_2
 * @property integer $nyeri_3
 * @property integer $nyeri_4
 * @property integer $nyeri_keluar
 * @property string $nyeri_jam
 */
class EvaluasinyeriT extends CActiveRecord {

    public $keluhan_nyeri;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EvaluasinyeriT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'evaluasinyeri_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('skorpascaanastesi_id, skornyeri_praanestesi, nyeri_0, nyeri_5, nyeri_15, nyeri_30, nyeri_45, nyeri_1, nyeri_2, nyeri_3, nyeri_4, nyeri_keluar', 'numerical', 'integerOnly' => true),
            array('keluhan_nyeri_ada, keluhan_nyeri_tidak_ada, metode_vas, metode_comfortscales, nyeri_jam', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('evaluasinyeri_id, skorpascaanastesi_id, skornyeri_praanestesi, keluhan_nyeri_ada, keluhan_nyeri_tidak_ada, metode_vas, metode_comfortscales, nyeri_0, nyeri_5, nyeri_15, nyeri_30, nyeri_45, nyeri_1, nyeri_2, nyeri_3, nyeri_4, nyeri_keluar, nyeri_jam', 'safe', 'on' => 'search'),
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
            'evaluasinyeri_id' => 'Evaluasinyeri',
            'skorpascaanastesi_id' => 'Skorpascaanastesi',
            'skornyeri_praanestesi' => 'Skornyeri Praanestesi',
            'keluhan_nyeri_ada' => 'Keluhan Nyeri Ada',
            'keluhan_nyeri_tidak_ada' => 'Keluhan Nyeri Tidak Ada',
            'metode_vas' => 'Metode Vas',
            'metode_comfortscales' => 'Metode Comfortscales',
            'nyeri_0' => 'Nyeri 0',
            'nyeri_5' => 'Nyeri 5',
            'nyeri_15' => 'Nyeri 15',
            'nyeri_30' => 'Nyeri 30',
            'nyeri_45' => 'Nyeri 45',
            'nyeri_1' => 'Nyeri 1',
            'nyeri_2' => 'Nyeri 2',
            'nyeri_3' => 'Nyeri 3',
            'nyeri_4' => 'Nyeri 4',
            'nyeri_keluar' => 'Nyeri Keluar',
            'nyeri_jam' => 'Nyeri Jam',
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

        $criteria->compare('evaluasinyeri_id', $this->evaluasinyeri_id);
        $criteria->compare('skorpascaanastesi_id', $this->skorpascaanastesi_id);
        $criteria->compare('skornyeri_praanestesi', $this->skornyeri_praanestesi);
        $criteria->compare('keluhan_nyeri_ada', $this->keluhan_nyeri_ada);
        $criteria->compare('keluhan_nyeri_tidak_ada', $this->keluhan_nyeri_tidak_ada);
        $criteria->compare('metode_vas', $this->metode_vas);
        $criteria->compare('metode_comfortscales', $this->metode_comfortscales);
        $criteria->compare('nyeri_0', $this->nyeri_0);
        $criteria->compare('nyeri_5', $this->nyeri_5);
        $criteria->compare('nyeri_15', $this->nyeri_15);
        $criteria->compare('nyeri_30', $this->nyeri_30);
        $criteria->compare('nyeri_45', $this->nyeri_45);
        $criteria->compare('nyeri_1', $this->nyeri_1);
        $criteria->compare('nyeri_2', $this->nyeri_2);
        $criteria->compare('nyeri_3', $this->nyeri_3);
        $criteria->compare('nyeri_4', $this->nyeri_4);
        $criteria->compare('nyeri_keluar', $this->nyeri_keluar);
        $criteria->compare('nyeri_jam', $this->nyeri_jam, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

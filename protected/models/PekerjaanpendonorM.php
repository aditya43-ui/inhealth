<?php

/**
 * This is the model class for table "pekerjaanpendonor_m".
 * 
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 *
 * The followings are the available columns in table 'pekerjaanpendonor_m':
 * @property integer $pekerjaanpendonor_id
 * @property string $pekerjaanpendonor_nama
 * @property string $pekerjaanpendonor_namalainnya
 * @property boolean $pekerjaanpendonor_aktif
 */
class PekerjaanpendonorM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PekerjaanpendonorM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pekerjaanpendonor_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pekerjaanpendonor_id', 'required'),
            array('pekerjaanpendonor_id', 'numerical', 'integerOnly' => true),
            array('pekerjaanpendonor_nama, pekerjaanpendonor_namalainnya', 'length', 'max' => 250),
            array('pekerjaanpendonor_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pekerjaanpendonor_id, pekerjaanpendonor_nama, pekerjaanpendonor_namalainnya, pekerjaanpendonor_aktif', 'safe', 'on' => 'search'),
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
            'pekerjaanpendonor_id' => 'Pekerjaanpendonor',
            'pekerjaanpendonor_nama' => 'Pekerjaan Pendonor',
            'pekerjaanpendonor_namalainnya' => 'Nama Lainnya',
            'pekerjaanpendonor_aktif' => 'Pekerjaanpendonor Aktif',
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

        $criteria->compare('pekerjaanpendonor_id', $this->pekerjaanpendonor_id);
        $criteria->compare('pekerjaanpendonor_nama', $this->pekerjaanpendonor_nama, true);
        $criteria->compare('pekerjaanpendonor_namalainnya', $this->pekerjaanpendonor_namalainnya, true);
        $criteria->compare('pekerjaanpendonor_aktif', $this->pekerjaanpendonor_aktif);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

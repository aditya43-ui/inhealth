<?php

/**
 * This is the model class for table "faktorrisiko_daftar_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'faktorrisiko_daftar_m':
 * @property integer $faktorrisiko_daftar_id
 * @property string $faktorrisiko_daftar_nama
 * @property string $faktorrisiko_daftar_namalain
 * @property boolean $faktorrisiko_daftar_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class FaktorrisikoDaftarM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return FaktorrisikoDaftarM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'faktorrisiko_daftar_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('faktorrisiko_daftar_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('faktorrisiko_daftar_nama, faktorrisiko_daftar_namalain, faktorrisiko_daftar_aktif, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('faktorrisiko_daftar_id, faktorrisiko_daftar_nama, faktorrisiko_daftar_namalain, faktorrisiko_daftar_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'faktorrisiko_daftar_id' => 'ID',
            'faktorrisiko_daftar_nama' => 'Nama Faktor Risiko',
            'faktorrisiko_daftar_namalain' => 'Nama Lain Faktor Risiko',
            'faktorrisiko_daftar_aktif' => 'Status',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
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

        $criteria->compare('faktorrisiko_daftar_id', $this->faktorrisiko_daftar_id);
        $criteria->compare('LOWER(faktorrisiko_daftar_nama)', strtolower($this->faktorrisiko_daftar_nama), true);
        $criteria->compare('LOWER(faktorrisiko_daftar_namalain)', strtolower($this->faktorrisiko_daftar_namalain), true);
        $criteria->compare('faktorrisiko_daftar_aktif', isset($this->faktorrisiko_daftar_aktif) ? $this->faktorrisiko_daftar_aktif : true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

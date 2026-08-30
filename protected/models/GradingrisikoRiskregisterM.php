<?php

/**
 * This is the model class for table "gradingrisiko_riskregister_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'gradingrisiko_riskregister_m':
 * @property integer $gradingrisiko_riskregister_id
 * @property integer $konsekuensi_id
 * @property integer $peluang_id
 * @property integer $detectability_id
 * @property integer $tingkatrisiko_riskregister_id
 * @property boolean $gradingrisiko_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class GradingrisikoRiskregisterM extends CActiveRecord {

    public $warnarisiko, $peluang_descriptor, $konsekuensi_namabobot, $tingkatrisiko_nama, $detectability_deskripsi;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return GradingrisikoRiskregisterM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gradingrisiko_riskregister_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('konsekuensi_id, peluang_id, detectability_id, tingkatrisiko_riskregister_id, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('konsekuensi_id, peluang_id, detectability_id, tingkatrisiko_riskregister_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('gradingrisiko_aktif, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('gradingrisiko_riskregister_id, konsekuensi_id, peluang_id, detectability_id, tingkatrisiko_riskregister_id, gradingrisiko_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'gradingrisiko_riskregister_id' => 'Gradingrisiko Riskregister',
            'konsekuensi_id' => 'Konsekuensi Riskregister',
            'peluang_id' => 'Peluang',
            'detectability_id' => 'Detectability',
            'tingkatrisiko_riskregister_id' => 'Tingkatrisiko',
            'gradingrisiko_aktif' => 'Gradingrisiko Aktif',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
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

        $criteria->compare('gradingrisiko_riskregister_id', $this->gradingrisiko_riskregister_id);
        $criteria->compare('konsekuensi_id', $this->konsekuensi_id);
        $criteria->compare('peluang_id', $this->peluang_id);
        $criteria->compare('detectability_id', $this->detectability_id);
        $criteria->compare('tingkatrisiko_riskregister_id', $this->tingkatrisiko_riskregister_id);
        $criteria->compare('gradingrisiko_aktif', $this->gradingrisiko_aktif);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Mencetak data grading risiko
     * @return \CActiveDataProvider
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('gradingrisiko_riskregister_id', $this->gradingrisiko_riskregister_id);
        $criteria->compare('konsekuensi_id', $this->konsekuensi_id);
        $criteria->compare('peluang_id', $this->peluang_id);
        $criteria->compare('detectability_id', $this->detectability_id);
        $criteria->compare('tingkatrisiko_riskregister_id', $this->tingkatrisiko_riskregister_id);
        $criteria->compare('gradingrisiko_aktif', $this->gradingrisiko_aktif);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }
    
}

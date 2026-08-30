<?php

/**
 * This is the model class for table "skorpascaanastesi_t".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'skorpascaanastesi_t':
 * @property integer $skorpascaanastesi_id
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property integer $pendaftaran_id
 * @property string $ruangan_id
 * @property integer $pegawai_id
 * @property string $waktu
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_pengguna_id
 * @property integer $update_pengguna_id
 * @property integer $create_ruangan
 */
class SkorpascaanastesiT extends CActiveRecord {

    public $pegawai_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SkorpascaanastesiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'skorpascaanastesi_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('create_time, create_pengguna_id, create_ruangan', 'required'),
            array('pasienanastesi_id, pasien_id, pendaftaran_id, pegawai_id, create_pengguna_id, update_pengguna_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('ruangan_id', 'length', 'max' => 10),
            array('waktu, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('skorpascaanastesi_id, pasienanastesi_id, pasien_id, pendaftaran_id, ruangan_id, pegawai_id, waktu, create_time, update_time, create_pengguna_id, update_pengguna_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'skorpascaanastesi_id' => 'Skorpascaanastesi',
            'pasienanastesi_id' => 'Pasienanastesi',
            'pasien_id' => 'Pasien',
            'pendaftaran_id' => 'Pendaftaran',
            'ruangan_id' => 'Ruangan',
            'pegawai_id' => 'Pegawai',
            'waktu' => 'Waktu',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_pengguna_id' => 'Create Pengguna',
            'update_pengguna_id' => 'Update Pengguna',
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

        $criteria->compare('skorpascaanastesi_id', $this->skorpascaanastesi_id);
        $criteria->compare('pasienanastesi_id', $this->pasienanastesi_id);
        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('ruangan_id', $this->ruangan_id, true);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('waktu', $this->waktu, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_pengguna_id', $this->create_pengguna_id);
        $criteria->compare('update_pengguna_id', $this->update_pengguna_id);
        $criteria->compare('create_ruangan', $this->create_ruangan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

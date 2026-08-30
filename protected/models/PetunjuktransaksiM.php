<?php

/**
 * This is the model class for table "petunjuktransaksi_m".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'petunjuktransaksi_m':
 * @property integer $petunjuktransaksi_id
 * @property string $petunjuktransaksi_type
 * @property string $petunjuktransaksi_nama
 * @property string $petunjuktransaksi_deskripsi
 * @property string $petunjuktransaksi_image
 * @property integer $petunjuktransaksi_urutan
 * @property boolean $petunjuktransaksi_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class PetunjuktransaksiM extends CActiveRecord {

    public $temp_file; 
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PetunjuktransaksiM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'petunjuktransaksi_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('petunjuktransaksi_type, petunjuktransaksi_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('petunjuktransaksi_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('petunjuktransaksi_type, petunjuktransaksi_nama', 'length', 'max' => 100),
            array('petunjuktransaksi_deskripsi, petunjuktransaksi_image', 'length', 'max' => 500),
            array('petunjuktransaksi_aktif, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('petunjuktransaksi_id, petunjuktransaksi_type, petunjuktransaksi_nama, petunjuktransaksi_deskripsi, petunjuktransaksi_image, petunjuktransaksi_urutan, petunjuktransaksi_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
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
            'petunjuktransaksi_id' => 'Petunjuktransaksi',
            'petunjuktransaksi_type' => 'Tipe',
            'petunjuktransaksi_nama' => 'Nama',
            'petunjuktransaksi_deskripsi' => 'Deskripsi',
            'petunjuktransaksi_image' => 'Gambar',
            'petunjuktransaksi_urutan' => 'Urutan',
            'petunjuktransaksi_aktif' => 'Aktif',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
        );
    }

    /**
     * Load data untuk dicari 
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;
        $criteria->compare('petunjuktransaksi_type', $this->petunjuktransaksi_type);
        $criteria->compare('lower(petunjuktransaksi_nama)', strtolower($this->petunjuktransaksi_nama), true);
        $criteria->compare('lower(petunjuktransaksi_deskripsi)', strtolower($this->petunjuktransaksi_deskripsi), true);
        $criteria->compare('petunjuktransaksi_urutan', $this->petunjuktransaksi_urutan);
        $criteria->compare('petunjuktransaksi_aktif', $this->petunjuktransaksi_aktif);
        return $criteria;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = $this->criteriaSearch();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * Load data cetak 
     * @return \CActiveDataProvider
     */
    public function searchPrint(){
        $criteria = $this->criteriaSearch();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

}

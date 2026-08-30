<?php

/**
 * This is the model class for table "metodepengadaan_m".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'metodepengadaan_m':
 * @property integer $metodepengadaan_id
 * @property string $metodepengadaan_nama
 * @property string $metodepengadaan_namalain
 * @property string $metodepengadaan_ket
 * @property integer $metodepengadaan_urutan
 * @property boolean $metodepengadaan_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property RencanaumumpengadaanT[] $rencanaumumpengadaanTs
 * @property PersiapanpengadaanT[] $persiapanpengadaanTs
 */
class MetodepengadaanM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MetodepengadaanM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'metodepengadaan_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('metodepengadaan_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('metodepengadaan_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('metodepengadaan_nama, metodepengadaan_namalain', 'length', 'max' => 100),
            array('metodepengadaan_ket, metodepengadaan_aktif, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('metodepengadaan_id, metodepengadaan_nama, metodepengadaan_namalain, metodepengadaan_ket, metodepengadaan_urutan, metodepengadaan_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rencanaumumpengadaanTs' => array(self::HAS_MANY, 'RencanaumumpengadaanT', 'metodepengadaan_id'),
            'persiapanpengadaanTs' => array(self::HAS_MANY, 'PersiapanpengadaanT', 'metodepengadaan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'metodepengadaan_id' => 'Metodepengadaan',
            'metodepengadaan_nama' => 'Nama Metode Pengadaan',
            'metodepengadaan_namalain' => 'Nama Lain',
            'metodepengadaan_ket' => 'Keterangan',
            'metodepengadaan_urutan' => 'Urutan',
            'metodepengadaan_aktif' => 'Aktif',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'create_loginpemakai_id' => 'Create Loginpemakai',
            'update_loginpemakai_id' => 'Update Loginpemakai',
            'create_ruangan' => 'Create Ruangan',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CdbCriteria that can return criterias.
     */
    public function criteriaSearch() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        if (!empty($this->metodepengadaan_id)) {
            $criteria->addCondition('metodepengadaan_id = ' . $this->metodepengadaan_id);
        }
        $criteria->compare('LOWER(metodepengadaan_nama)', strtolower($this->metodepengadaan_nama), true);
        $criteria->compare('LOWER(metodepengadaan_namalain)', strtolower($this->metodepengadaan_namalain), true);
        $criteria->compare('LOWER(metodepengadaan_ket)', strtolower($this->metodepengadaan_ket), true);
        if (!empty($this->metodepengadaan_urutan)) {
            $criteria->addCondition('metodepengadaan_urutan = ' . $this->metodepengadaan_urutan);
        }
        $criteria->compare('metodepengadaan_aktif', $this->metodepengadaan_aktif);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        if (!empty($this->create_loginpemakai_id)) {
            $criteria->addCondition('create_loginpemakai_id = ' . $this->create_loginpemakai_id);
        }
        if (!empty($this->update_loginpemakai_id)) {
            $criteria->addCondition('update_loginpemakai_id = ' . $this->update_loginpemakai_id);
        }
        if (!empty($this->create_ruangan)) {
            $criteria->addCondition('create_ruangan = ' . $this->create_ruangan);
        }

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
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = $this->criteriaSearch();
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

}

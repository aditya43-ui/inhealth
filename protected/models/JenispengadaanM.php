<?php

/**
 * This is the model class for table "jenispengadaan_m".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'jenispengadaan_m':
 * @property integer $jenispengadaan_id
 * @property string $jenispengadaan_nama
 * @property string $jenispengadaan_namalain
 * @property string $jenispengadaan_ket
 * @property integer $jenispengadaan_urutan
 * @property boolean $jenispengadaan_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengadaanjenisT[] $pengadaanjenisTs
 * @property DokumenpengadaanM[] $dokumenpengadaanMs
 */
class JenispengadaanM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JenispengadaanM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jenispengadaan_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jenispengadaan_nama, create_time, create_loginpemakai_id, create_ruangan', 'required'),
            array('jenispengadaan_urutan, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly' => true),
            array('jenispengadaan_nama, jenispengadaan_namalain', 'length', 'max' => 100),
            array('jenispengadaan_ket, jenispengadaan_aktif, update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('jenispengadaan_id, jenispengadaan_nama, jenispengadaan_namalain, jenispengadaan_ket, jenispengadaan_urutan, jenispengadaan_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pengadaanjenisTs' => array(self::HAS_MANY, 'PengadaanjenisT', 'jenispengadaan_id'),
            'dokumenpengadaanMs' => array(self::HAS_MANY, 'DokumenpengadaanM', 'jenispengadaan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'jenispengadaan_id' => 'Jenispengadaan',
            'jenispengadaan_nama' => 'Nama Jenis Pengadaan',
            'jenispengadaan_namalain' => 'Nama Lain',
            'jenispengadaan_ket' => 'Keterangan',
            'jenispengadaan_urutan' => 'Urutan',
            'jenispengadaan_aktif' => 'Aktif',
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

        if (!empty($this->jenispengadaan_id)) {
            $criteria->addCondition('jenispengadaan_id = ' . $this->jenispengadaan_id);
        }
        $criteria->compare('LOWER(jenispengadaan_nama)', strtolower($this->jenispengadaan_nama), true);
        $criteria->compare('LOWER(jenispengadaan_namalain)', strtolower($this->jenispengadaan_namalain), true);
        $criteria->compare('LOWER(jenispengadaan_ket)', strtolower($this->jenispengadaan_ket), true);
        if (!empty($this->jenispengadaan_urutan)) {
            $criteria->addCondition('jenispengadaan_urutan = ' . $this->jenispengadaan_urutan);
        }
        $criteria->compare('jenispengadaan_aktif', $this->jenispengadaan_aktif);
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

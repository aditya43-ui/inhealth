<?php

/**
 * This is the model class for table "jenisintervensi_m".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'jenisintervensi_m':
 * @property integer $jenisintervensi_id
 * @property string $jenisintervensi_nama
 * @property string $jenisintervensi_namalain
 * @property string $jenisintervensi_kode
 * @property string $jenisintervensi_deskripsi
 */
class JenisintervensiM extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JenisintervensiM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jenisintervensi_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jenisintervensi_nama,jenisintervensi_kode', 'required'),
            array('jenisintervensi_nama, jenisintervensi_namalain', 'length', 'max' => 100),
            array('jenisintervensi_kode', 'length', 'max' => 10),
            array('jenisintervensi_aktif, jenisintervensi_deskripsi', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('jenisintervensi_id, jenisintervensi_nama, jenisintervensi_namalain, jenisintervensi_kode, jenisintervensi_deskripsi', 'safe', 'on' => 'search'),
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
            'jenisintervensi_id' => 'Jenisintervensi',
            'jenisintervensi_nama' => 'Nama Intervensi Keperawatan',
            'jenisintervensi_namalain' => 'Nama Lain',
            'jenisintervensi_kode' => 'Kode Intervensi Keperawatan',
            'jenisintervensi_deskripsi' => 'Deskripsi',
        );
    }

    /**
     * Pencarian 
     * @return \CDbCriteria
     */
    public function criteriaSearch() {
        $criteria = new CDbCriteria;

        $criteria->compare('jenisintervensi_id', $this->jenisintervensi_id);
        $criteria->compare('lower(jenisintervensi_nama)', strtolower($this->jenisintervensi_nama), true);
        $criteria->compare('lower(jenisintervensi_namalain)', strtolower($this->jenisintervensi_namalain), true);
        $criteria->compare('lower(jenisintervensi_kode)', strtolower($this->jenisintervensi_kode), true);
        $criteria->compare('lower(jenisintervensi_deskripsi)', strtolower($this->jenisintervensi_deskripsi), true);
        $criteria->compare('jenisintervensi_aktif', $this->jenisintervensi_aktif);
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
    public function searchPrint() {
        $criteria = $this->criteriaSearch();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

}

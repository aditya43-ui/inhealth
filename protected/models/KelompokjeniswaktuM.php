<?php

/**
 * This is the model class for table "kelompokjeniswaktu_m".
 *
 * @author  Andyka Putra <andykaputra@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'kelompokjeniswaktu_m':
 * @property integer $kelompokjeniswaktu_id
 * @property integer $jenismakanan_id
 * @property integer $jeniswaktu_id
 * @property boolean $kelompokjeniswaktu_aktif
 * @property integer $kelompokjeniswaktu_urutan
 *
 * The followings are the available model relations:
 * @property JeniswaktuM $jeniswaktu
 * @property JenismakananM $jenismakanan
 */
class KelompokjeniswaktuM extends CActiveRecord {

    public $jenismakanan_nama, $jeniswaktu_nama, $status;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokjeniswaktuM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'kelompokjeniswaktu_m';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jenismakanan_id, jeniswaktu_id, kelompokjeniswaktu_urutan', 'numerical', 'integerOnly' => true),
            array('kelompokjeniswaktu_aktif', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kelompokjeniswaktu_id, jenismakanan_id, jeniswaktu_id, kelompokjeniswaktu_aktif, kelompokjeniswaktu_urutan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'jeniswaktu' => array(self::BELONGS_TO, 'JeniswaktuM', 'jeniswaktu_id'),
            'jenismakanan' => array(self::BELONGS_TO, 'JenismakananM', 'jenismakanan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'kelompokjeniswaktu_id' => 'Kelompok Jenis Waktu',
            'jenismakanan_id' => 'Jenis Makanan',
            'jeniswaktu_id' => 'Jenis Waktu',
            'kelompokjeniswaktu_aktif' => 'Status',
            'kelompokjeniswaktu_urutan' => 'Urutan',
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

        $criteria->compare('kelompokjeniswaktu_id', $this->kelompokjeniswaktu_id);
        $criteria->compare('jenismakanan_id', $this->jenismakanan_id);
        $criteria->compare('jeniswaktu_id', $this->jeniswaktu_id);
        $criteria->compare('kelompokjeniswaktu_aktif', $this->kelompokjeniswaktu_aktif);
        $criteria->compare('kelompokjeniswaktu_urutan', $this->kelompokjeniswaktu_urutan);

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

        $criteria = new CDbCriteria;

        $criteria->compare('kelompokjeniswaktu_id', $this->kelompokjeniswaktu_id);
        $criteria->compare('jenismakanan_id', $this->jenismakanan_id);
        $criteria->compare('jeniswaktu_id', $this->jeniswaktu_id);
        $criteria->compare('kelompokjeniswaktu_aktif', $this->kelompokjeniswaktu_aktif);
        $criteria->compare('kelompokjeniswaktu_urutan', $this->kelompokjeniswaktu_urutan);
        $criteria->limit=-1;
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * get model jenis waktu
     * @return object mengambil data
     */
    public function getJeniswaktuItems() {
        return JeniswaktuM::Model()->findAll('jeniswaktu_aktif=TRUE ORDER BY jeniswaktu_nama');
    }

    /**
     * get model jenis makanan
     * @return object mengambil data
     */
    public function getJenisMakananItems() {
        return JenismakananM::Model()->findAll('jenismakanan_aktif=TRUE ORDER BY jenismakanan_nama');
    }

}

<?php

/**
 * This is the model class for table "jumlahpemeriksaandoktermcu_v".
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.models
 * The followings are the available columns in table 'jumlahpemeriksaandoktermcu_v':
 * @property string $date
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property string $gelardepan
 * @property string $dokter_nama
 * @property string $gelarbelakang_nama
 * @property string $jumlah
 */
class JumlahpemeriksaandoktermcuV extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return JumlahpemeriksaandoktermcuV the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jumlahpemeriksaandoktermcu_v';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ruangan_id', 'numerical', 'integerOnly' => true),
            array('ruangan_nama, dokter_nama', 'length', 'max' => 50),
            array('gelardepan', 'length', 'max' => 10),
            array('gelarbelakang_nama', 'length', 'max' => 25),
            array('date, jumlah', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('date, ruangan_id, ruangan_nama, gelardepan, dokter_nama, gelarbelakang_nama, jumlah', 'safe', 'on' => 'search'),
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
            'date' => 'Date',
            'ruangan_id' => 'Ruangan',
            'ruangan_nama' => 'Ruangan Nama',
            'gelardepan' => 'Gelardepan',
            'dokter_nama' => 'Dokter Nama',
            'gelarbelakang_nama' => 'Gelarbelakang Nama',
            'jumlah' => 'Jumlah',
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

        $criteria->compare('date', $this->date, true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('dokter_nama', $this->dokter_nama, true);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('jumlah', $this->jumlah, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian untuk data Dashboard MCU
     * Filter data berdasarkan tanggal hari ini 
     * @return \CActiveDataProvider
     */
    public function searchDashboardMCU() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
//        $criteria->addCondition('DATE(date) = date(now())');
        $criteria->addBetweenCondition('DATE(date)', date('Y-m').'-01', date('Y-m-d'));
//        $criteria->compare('date', $this->date, true);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('ruangan_nama', $this->ruangan_nama, true);
        $criteria->compare('gelardepan', $this->gelardepan, true);
        $criteria->compare('dokter_nama', $this->dokter_nama, true);
        $criteria->compare('gelarbelakang_nama', $this->gelarbelakang_nama, true);
        $criteria->compare('jumlah', $this->jumlah, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}

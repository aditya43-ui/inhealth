<?php

/**
 * This is the model class for table "pengadaanlokasi_t".
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'pengadaanlokasi_t':
 * @property integer $pengadaanlokasi_id
 * @property integer $rencanaumumpengadaan_id
 * @property integer $provinsi_id
 * @property integer $kabupaten_id
 * @property string $detil_lokasi
 *
 * The followings are the available model relations:
 * @property RencanaumumpengadaanT $rencanaumumpengadaan
 * @property KabupatenM $kabupaten
 * @property PropinsiM $provinsi
 */
class PengadaanlokasiT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PengadaanlokasiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pengadaanlokasi_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rencanaumumpengadaan_id, provinsi_id, kabupaten_id', 'numerical', 'integerOnly' => true),
            array('detil_lokasi', 'length', 'max' => 250),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pengadaanlokasi_id, rencanaumumpengadaan_id, provinsi_id, kabupaten_id, detil_lokasi', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rencanaumumpengadaan' => array(self::BELONGS_TO, 'RencanaumumpengadaanT', 'rencanaumumpengadaan_id'),
            'kabupaten' => array(self::BELONGS_TO, 'KabupatenM', 'kabupaten_id'),
            'provinsi' => array(self::BELONGS_TO, 'PropinsiM', 'provinsi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pengadaanlokasi_id' => 'Pengadaanlokasi',
            'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
            'provinsi_id' => 'Provinsi',
            'kabupaten_id' => 'Kabupaten',
            'detil_lokasi' => 'Detil Lokasi',
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

        if (!empty($this->pengadaanlokasi_id)) {
            $criteria->addCondition('pengadaanlokasi_id = ' . $this->pengadaanlokasi_id);
        }
        if (!empty($this->rencanaumumpengadaan_id)) {
            $criteria->addCondition('rencanaumumpengadaan_id = ' . $this->rencanaumumpengadaan_id);
        }
        if (!empty($this->provinsi_id)) {
            $criteria->addCondition('provinsi_id = ' . $this->provinsi_id);
        }
        if (!empty($this->kabupaten_id)) {
            $criteria->addCondition('kabupaten_id = ' . $this->kabupaten_id);
        }
        $criteria->compare('LOWER(detil_lokasi)', strtolower($this->detil_lokasi), true);

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

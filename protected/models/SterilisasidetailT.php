<?php

/**
 * This is the model class for table "sterilisasidetail_t".
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.models
 * 
 * The followings are the available columns in table 'sterilisasidetail_t':
 * @property integer $sterilisasidetail_id
 * @property integer $penerimaansterilisasi_id
 * @property integer $peralatansterilisasi_id
 * @property integer $sterilisasi_id
 * @property integer $dekontaminasi_id
 * @property integer $jenissterilisasi_id
 * @property integer $sterilisasidetail_jml
 * @property string $sterilisasidetail_ket
 * @property string $kemasanygdigunakan
 * @property string $waktukadaluarsa
 * @property integer $alatmedis_id
 *
 * The followings are the available model relations:
 * @property AlatmedisM $alatmedis
 */
class SterilisasidetailT extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SterilisasidetailT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sterilisasidetail_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('peralatansterilisasi_id, sterilisasi_id, jenissterilisasi_id, sterilisasidetail_jml', 'required'),
            array('penerimaansterilisasi_id, sterilisasi_id, dekontaminasi_id, jenissterilisasi_id, sterilisasidetail_jml, barang_id', 'numerical', 'integerOnly' => true),
            array('sterilisasidetail_ket', 'length', 'max' => 200),
            array('kemasanygdigunakan', 'length', 'max' => 100),
            array('waktukadaluarsa', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('sterilisasidetail_id, penerimaansterilisasi_id, peralatansterilisasi_id, sterilisasi_id, dekontaminasi_id, jenissterilisasi_id, sterilisasidetail_jml, sterilisasidetail_ket, kemasanygdigunakan, waktukadaluarsa, barang_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'alatmedis' => array(self::BELONGS_TO, 'AlatmedisM', 'alatmedis_id'),
            'sterilisasi' => array(self::BELONGS_TO, 'SterilisasiT', 'sterilisasi_id'),
            'jenissterilisasi' => array(self::BELONGS_TO, 'JenissterilisasiM', 'jenissterilisasi_id'),
            'penerimaansterilisasi' => array(self::BELONGS_TO, 'PenerimaansterilisasiT', 'penerimaansterilisasi_id'),
            'peralatansterilisasi' => array(self::BELONGS_TO, 'PeralatansterilisasiM', 'peralatansterilisasi_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'sterilisasidetail_id' => 'ID Sterilisasi Detail',
            'penerimaansterilisasi_id' => 'ID Penerimaan Sterilisasi',
            'peralatansterilisasi_id' => 'Peralatan Sterilisasi',
            'sterilisasi_id' => 'Sterilisasi',
            'dekontaminasi_id' => 'Dekontaminasi',
            'jenissterilisasi_id' => 'Jenis Sterilisasi',
            'sterilisasidetail_jml' => 'Jumlah',
            'sterilisasidetail_ket' => 'Keterangan',
            'kemasanygdigunakan' => 'Kemasan yang Digunakan',
            'waktukadaluarsa' => 'Waktu Kedaluwarsa',
            'alatmedis_id' => 'Alat Medis',
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

        if (!empty($this->sterilisasidetail_id)) {
            $criteria->addCondition('sterilisasidetail_id = ' . $this->sterilisasidetail_id);
        }
        if (!empty($this->penerimaansterilisasi_id)) {
            $criteria->addCondition('penerimaansterilisasi_id = ' . $this->penerimaansterilisasi_id);
        }

        if (!empty($this->sterilisasi_id)) {
            $criteria->addCondition('sterilisasi_id = ' . $this->sterilisasi_id);
        }
        if (!empty($this->dekontaminasi_id)) {
            $criteria->addCondition('dekontaminasi_id = ' . $this->dekontaminasi_id);
        }
        if (!empty($this->jenissterilisasi_id)) {
            $criteria->addCondition('jenissterilisasi_id = ' . $this->jenissterilisasi_id);
        }
        if (!empty($this->sterilisasidetail_jml)) {
            $criteria->addCondition('sterilisasidetail_jml = ' . $this->sterilisasidetail_jml);
        }
        $criteria->compare('LOWER(sterilisasidetail_ket)', strtolower($this->sterilisasidetail_ket), true);
        $criteria->compare('LOWER(kemasanygdigunakan)', strtolower($this->kemasanygdigunakan), true);
        $criteria->compare('LOWER(waktukadaluarsa)', strtolower($this->waktukadaluarsa), true);
        if (!empty($this->alatmedis_id)) {
            $criteria->addCondition('alatmedis_id = ' . $this->alatmedis_id);
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
     * Untuk mencetak data
     * @return \CActiveDataProvider
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

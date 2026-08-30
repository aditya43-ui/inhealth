<?php

/**
 * This is the model class for table "pengadaanjenis_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @package application.models
 * @category model
 * The followings are the available columns in table 'pengadaanjenis_t':
 * @property integer $pengadaanjenis_id
 * @property integer $rencanaumumpengadaan_id
 * @property integer $jenispengadaan_id
 * @property string $jenispengadaan_nama
 * @property double $jumlahpagu
 *
 * The followings are the available model relations:
 * @property RencanaumumpengadaanT $rencanaumumpengadaan
 * @property JenispengadaanM $jenispengadaan
 */
class PengadaanjenisT extends CActiveRecord {

    public $jumlahpagus, $labels, $data, $pengadaanjenis_id_awal;
    public $kegiatanprogram_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PengadaanjenisT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pengadaanjenis_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rencanaumumpengadaan_id, jenispengadaan_id', 'numerical', 'integerOnly' => true),
            array('jumlahpagu', 'numerical'),
            array('jenispengadaan_nama', 'length', 'max' => 100),            
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pengadaanjenis_id, rencanaumumpengadaan_id, jenispengadaan_id, jenispengadaan_nama, jumlahpagu', 'safe', 'on' => 'search'),
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
            'jenispengadaan' => array(self::BELONGS_TO, 'JenispengadaanM', 'jenispengadaan_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pengadaanjenis_id' => 'Pengadaanjenis',
            'rencanaumumpengadaan_id' => 'Rencanaumumpengadaan',
            'jenispengadaan_id' => 'Jenispengadaan',
            'jenispengadaan_nama' => 'Jenispengadaan Nama',
            'jumlahpagu' => 'Jumlahpagu',
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

        if (!empty($this->pengadaanjenis_id)) {
            $criteria->addCondition('pengadaanjenis_id = ' . $this->pengadaanjenis_id);
        }
        if (!empty($this->rencanaumumpengadaan_id)) {
            $criteria->addCondition('rencanaumumpengadaan_id = ' . $this->rencanaumumpengadaan_id);
        }
        if (!empty($this->jenispengadaan_id)) {
            $criteria->addCondition('jenispengadaan_id = ' . $this->jenispengadaan_id);
        }
        $criteria->compare('LOWER(jenispengadaan_nama)', strtolower($this->jenispengadaan_nama), true);
        $criteria->compare('jumlahpagu', $this->jumlahpagu);

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

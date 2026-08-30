<?php

/**
 * This is the model class for table "penialian_kelayakan_spesimen_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * 
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'penialian_kelayakan_spesimen_t':
 * @property integer $penilaian_kelayakan_spesimen_id
 * @property integer $pasienkirimkeunitlain_id
 * @property integer $pasienmasukpenunjang_id
 * @property string $tanggal
 * @property integer $manajerpelayanan_id
 * @property integer $dpjtm_id
 * @property integer $ppds_id
 *
 * The followings are the available model relations:
 * @property PasienkirimkeunitlainT $pasienkirimkeunitlain
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property SpesimenT[] $spesimenTs
 */
class PenialianKelayakanSpesimenT extends CActiveRecord {

    public $manajerpelayanan_nama, $dpjtm_nama, $ppds_nama;
            
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PenialianKelayakanSpesimenT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'penialian_kelayakan_spesimen_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('penilaian_kelayakan_spesimen_id', 'required'),
            array('penilaian_kelayakan_spesimen_id, pasienkirimkeunitlain_id, pasienmasukpenunjang_id, manajerpelayanan_id, dpjtm_id, ppds_id', 'numerical', 'integerOnly' => true),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('penilaian_kelayakan_spesimen_id, pasienkirimkeunitlain_id, pasienmasukpenunjang_id, tanggal, manajerpelayanan_id, dpjtm_id, ppds_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pasienkirimkeunitlain' => array(self::BELONGS_TO, 'PasienkirimkeunitlainT', 'pasienkirimkeunitlain_id'),
            'pasienmasukpenunjang' => array(self::BELONGS_TO, 'PasienmasukpenunjangT', 'pasienmasukpenunjang_id'),
            'spesimenTs' => array(self::HAS_MANY, 'SpesimenT', 'penilaian_kelayakan_spesimen_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'penilaian_kelayakan_spesimen_id' => 'Penilaian Kelayakan Spesimen',
            'pasienkirimkeunitlain_id' => 'Pasienkirimkeunitlain',
            'pasienmasukpenunjang_id' => 'Pasienmasukpenunjang',
            'tanggal' => 'Tanggal',
            'manajerpelayanan_id' => 'Manajerpelayanan',
            'dpjtm_id' => 'Dpjtm',
            'ppds_id' => 'Ppds',
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

        if (!empty($this->penilaian_kelayakan_spesimen_id)) {
            $criteria->addCondition('penilaian_kelayakan_spesimen_id = ' . $this->penilaian_kelayakan_spesimen_id);
        }
        if (!empty($this->pasienkirimkeunitlain_id)) {
            $criteria->addCondition('pasienkirimkeunitlain_id = ' . $this->pasienkirimkeunitlain_id);
        }
        if (!empty($this->pasienmasukpenunjang_id)) {
            $criteria->addCondition('pasienmasukpenunjang_id = ' . $this->pasienmasukpenunjang_id);
        }
        $criteria->compare('LOWER(tanggal)', strtolower($this->tanggal), true);
        if (!empty($this->manajerpelayanan_id)) {
            $criteria->addCondition('manajerpelayanan_id = ' . $this->manajerpelayanan_id);
        }
        if (!empty($this->dpjtm_id)) {
            $criteria->addCondition('dpjtm_id = ' . $this->dpjtm_id);
        }
        if (!empty($this->ppds_id)) {
            $criteria->addCondition('ppds_id = ' . $this->ppds_id);
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

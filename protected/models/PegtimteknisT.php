<?php

/**
 * This is the model class for table "pegtimteknis_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * 
 * @package application.models
 * @category model
 * 
 * The followings are the available columns in table 'pegtimteknis_t':
 * @property integer $pegtimteknis_id
 * @property integer $pegawai_id
 * @property integer $suratperjanjiankerja_id
 * @property string $jabatan_timteknis
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 */
class PegtimteknisT extends CActiveRecord {

    public $nama_pegawai, $nomorindukpegawai, $status;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PegtimteknisT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pegtimteknis_t';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pegawai_id, suratperjanjiankerja_id', 'required'),
            array('pegawai_id, suratperjanjiankerja_id', 'numerical', 'integerOnly' => true),
            array('jabatan_timteknis', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('pegtimteknis_id, pegawai_id, suratperjanjiankerja_id, jabatan_timteknis', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'pegtimteknis_id' => 'Pegtimteknis',
            'pegawai_id' => 'Pegawai',
            'suratperjanjiankerja_id' => 'Suratperjanjiankerja',
            'jabatan_timteknis' => 'Jabatan Timteknis',
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

        if (!empty($this->pegtimteknis_id)) {
            $criteria->addCondition('pegtimteknis_id = ' . $this->pegtimteknis_id);
        }
        if (!empty($this->pegawai_id)) {
            $criteria->addCondition('pegawai_id = ' . $this->pegawai_id);
        }
        if (!empty($this->suratperjanjiankerja_id)) {
            $criteria->addCondition('suratperjanjiankerja_id = ' . $this->suratperjanjiankerja_id);
        }
        $criteria->compare('LOWER(jabatan_timteknis)', strtolower($this->jabatan_timteknis), true);

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
